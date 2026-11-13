<?php

namespace App\Http\Controllers;

use App\Models\Trainer;

class ProfileController extends Controller
{
    public function show(Trainer $trainer)
    {
        $trainer->load(['certifications', 'results', 'links', 'packages', 'testimonials']);

        return view('profile', [
            'trainer' => $trainer,
        ]);
    }

    /** Versão "link na bio": minimalista e leve (estilo Linktree). */
    public function bio(Trainer $trainer)
    {
        $trainer->load('links');

        return view('bio', [
            'trainer' => $trainer,
        ]);
    }
}
