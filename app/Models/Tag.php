<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function shortLinks()
    {
        return $this->belongsToMany(ShortLink::class, 'tag_short_link');
    }
}
