<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $guarded = [];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset($this->image) : null;
    }
}
