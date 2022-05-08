<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function links()
    {
        return $this->belongsToMany(Link::class);
    }
}
