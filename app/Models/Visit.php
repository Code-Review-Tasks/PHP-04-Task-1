<?php

namespace App\Models;

use App\Jobs\RecalculateVisits;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::created(function (self $visit) {
            RecalculateVisits::dispatch($visit->link);
        });
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
