<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

class Link extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];
    protected $appends = ['hash'];    

    public static function getHasher()
    {
        return App::make('Hashids\Hashids');
    }

    public static function findByHash($hash): ?Link
    {
        $decode = self::getHasher()->decode($hash);

        return isset($decode[0]) ? Link::find($decode[0]) : null;
    }

    public static function findByHashOrFail($hash): Link
    {
        $decode = self::getHasher()->decode($hash);

        if (!isset($decode[0])) {
            throw new UnexpectedValueException("Invalid hash: $hash", 404);
        }

        return Link::findOrFail($decode[0]);
    }

    /**
     * Recalculating total_views and unique_views based on visits table
     *
     * @return Link
     */
    public function recalculateVisits(): Link
    {        
        $result = DB::table('visits')->selectRaw('COUNT(*) AS total_views, COUNT(DISTINCT ip, user_agent_md5) AS unique_views')->where('link_id', $this->id)->first();

        $this->total_views = $result->total_views;
        $this->unique_views = $result->unique_views;

        $this->save();

        return $this;
    }

    public function scopeByHash($query, $hash)
    {
        $decode = self::getHasher()->decode($hash);

        if (!isset($decode[0])) {
            throw new UnexpectedValueException("Invalid hash: $hash");
        }

        return $query->where('id', $decode[0]);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * Get URI hash from id
     */
    public function getHashAttribute(): string
    {
        return self::getHasher()->encode($this->id);
    }    
}
