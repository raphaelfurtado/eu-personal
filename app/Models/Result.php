<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tags' => 'array',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function getBeforePhotoUrlAttribute(): ?string
    {
        return $this->before_photo ? asset($this->before_photo) : null;
    }

    public function getAfterPhotoUrlAttribute(): ?string
    {
        return $this->after_photo ? asset($this->after_photo) : null;
    }
}
