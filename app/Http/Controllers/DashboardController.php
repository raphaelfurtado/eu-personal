<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $trainer = $request->user()->trainer()->withCount(['leads', 'certifications', 'results'])->first();

        return view('dashboard.index', [
            'trainer'     => $trainer,
            'recentLeads' => $trainer->leads()->latest()->take(5)->get(),
        ]);
    }

    public function leads(Request $request)
    {
        $trainer = $request->user()->trainer;

        return view('dashboard.leads', [
            'trainer' => $trainer,
            'leads'   => $trainer->leads()->latest()->get(),
        ]);
    }

    /**
     * Troca de plano em modo demonstração (sem cobrança).
     * Só existe em ambiente local: em produção o plano muda apenas pelo Mercado Pago.
     */
    public function setPlan(Request $request)
    {
        abort_unless(app()->isLocal(), 404);

        $data = $request->validate([
            // Studio é sob consulta (Falar com vendas), não entra no self-service
            'plan' => ['required', 'in:free,pro'],
        ]);

        $trainer = $request->user()->trainer;
        $trainer->plan = $data['plan'];
        $trainer->save();

        return back()->with('flash', 'Plano alterado para '.$trainer->plan_label.' (modo demonstração).');
    }
}
