<?php

namespace App\Http\Controllers;

use App\Models\Trainer;

class PageController extends Controller
{
    public function home()
    {
        // Perfis usados como exemplo na seção "Veja na prática".
        $order = ['marina-lacerda', 'bruno-tavares'];

        // Ordena em PHP (FIELD() só existe no MySQL e quebrava os testes em SQLite)
        $examples = Trainer::query()
            ->whereIn('slug', $order)
            ->get()
            ->sortBy(fn ($t) => array_search($t->slug, $order))
            ->values();

        if ($examples->isEmpty()) {
            $examples = Trainer::query()->latest('id')->take(2)->get();
        }

        return view('landing', [
            'examples'    => $examples,
            'exampleSlug' => $examples->first()?->slug ?? 'marina-lacerda',
        ]);
    }
}
