<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
