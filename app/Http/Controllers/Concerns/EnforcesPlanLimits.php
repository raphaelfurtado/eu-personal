<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;

trait EnforcesPlanLimits
{
    /**
     * Se o personal já atingiu o limite do plano para esse recurso, devolve um
     * redirect com aviso de upgrade. Senão, devolve null. O nome do recurso ($key)
     * coincide com o da relação (results/links/packages/testimonials).
     */
    protected function overPlanLimit(Trainer $trainer, string $key, string $noun): ?RedirectResponse
    {
        if (! $trainer->reachedLimit($key, $trainer->{$key}()->count())) {
            return null;
        }

        return back()->with('flash', "Limite de {$noun} do plano {$trainer->plan_label} atingido ({$trainer->planLimit($key)}). Faça upgrade no painel para liberar mais.");
    }
}
