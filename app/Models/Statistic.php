<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    use HasFactory;

    public function short_links(): BelongsTo
    {
        return $this->belongsTo(ShortLinks::class, 'short_links_id');
    }
}
