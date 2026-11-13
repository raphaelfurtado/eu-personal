<?php

namespace App\Http\Controllers;

use App\Models\Trainer;

class PageController extends Controller
{
    public function home()
    {
        // Perfis usados como exemplo na seção "Veja na prática".
        $examples = Trainer::query()
            ->whereIn('slug', ['marina-lacerda', 'bruno-tavares'])
            ->orderByRaw("FIELD(slug, 'marina-lacerda', 'bruno-tavares')")
            ->get();

        if ($examples->isEmpty()) {
            $examples = Trainer::query()->latest('id')->take(2)->get();
        }

        return view('landing', [
            'examples'    => $examples,
            'exampleSlug' => $examples->first()?->slug ?? 'marina-lacerda',
        ]);
    }
}
