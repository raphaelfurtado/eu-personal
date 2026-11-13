<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Chamado pelo GitHub Actions depois do deploy por FTP (que não executa comandos
 * no servidor). Protegido por DEPLOY_TOKEN; sem token configurado, a rota não existe.
 */
class DeployController extends Controller
{
    public function migrate(Request $request)
    {
        $token = (string) config('app.deploy_token');

        if ($token === '' || ! hash_equals($token, (string) $request->header('X-Deploy-Token'))) {
            abort(404);
        }

        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();

        // Limpa caches de config/rotas/views da versão anterior
        Artisan::call('optimize:clear');

        return response($output, 200)->header('Content-Type', 'text/plain');
    }
}
