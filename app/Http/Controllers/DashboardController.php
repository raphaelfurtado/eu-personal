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
     * Quando a cobrança entrar, isto vira o retorno do webhook do provedor.
     */
    public function setPlan(Request $request)
    {
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
