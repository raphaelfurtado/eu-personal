<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    protected $guarded = [];

    protected $casts = [
        'items'    => 'array',
        'featured' => 'boolean',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }
}
