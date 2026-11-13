<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $guarded = [];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }
}
