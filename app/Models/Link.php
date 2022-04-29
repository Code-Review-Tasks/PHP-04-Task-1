<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class Link extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];
    protected $appends = ['hash'];
    protected static $hasher;

    /**
     * Hashids\Hashids singleton with salt
     */
    public static function getHasher(): Hashids
    {
        if (!self::$hasher) {
            self::$hasher = new Hashids(env('HASHIDS_SALT', ''));
        }

        return self::$hasher;
    }

    public static function findByHash($hash): ?Link
    {
        $decode = self::getHasher()->decode($hash);

        return isset($decode[0]) ? Link::find($decode[0]) : null;
    }

    public function recalculateVisits()
    {
        // SELECT COUNT(*) AS total_views, COUNT(DISTINCT ip, user_agent_md5) AS unique_views FROM visits WHERE link_id = 11;
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
            throw new ModelNotFoundException("$hash not found");
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
