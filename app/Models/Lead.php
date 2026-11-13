<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $guarded = [];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    /** Link wa.me para o personal responder o lead (assume Brasil se faltar DDI). */
    public function getWhatsappUrlAttribute(): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $this->whatsapp);

        if (! $digits) {
            return null;
        }

        if (strlen($digits) <= 11) {
            $digits = '55'.$digits;
        }

        return 'https://wa.me/'.$digits;
    }
}
