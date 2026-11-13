<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\Dashboard\CertificationController;
use App\Http\Controllers\Dashboard\LinkController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Dashboard\ResultController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing institucional da PersonalBio
Route::get('/', [PageController::class, 'home'])->name('home');

// Autenticação (visitantes)
Route::middleware('guest')->group(function () {
    Route::get('/entrar', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/entrar', [AuthController::class, 'login']);
    Route::get('/cadastrar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/cadastrar', [AuthController::class, 'register']);
});

Route::post('/sair', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Painel do personal (autenticado)
Route::middleware('auth')->prefix('painel')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/leads', [DashboardController::class, 'leads'])->name('leads');
    Route::post('/plano', [DashboardController::class, 'setPlan'])->name('plan.set');

    Route::get('/perfil', [DashboardProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/perfil', [DashboardProfileController::class, 'update'])->name('profile.update');

    Route::post('/qualificacoes', [CertificationController::class, 'store'])->name('certs.store');
    Route::post('/qualificacoes/{certification}', [CertificationController::class, 'update'])->name('certs.update');
    Route::delete('/qualificacoes/{certification}', [CertificationController::class, 'destroy'])->name('certs.destroy');

    Route::post('/resultados', [ResultController::class, 'store'])->name('results.store');
    Route::post('/resultados/{result}', [ResultController::class, 'update'])->name('results.update');
    Route::delete('/resultados/{result}', [ResultController::class, 'destroy'])->name('results.destroy');

    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::post('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::post('/pacotes', [PackageController::class, 'store'])->name('packages.store');
    Route::post('/pacotes/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/pacotes/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

    Route::post('/depoimentos', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::delete('/depoimentos/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});

// Dá um nome amigável a "dashboard" (usado nos redirects de login)
Route::middleware('auth')->get('/dashboard', fn () => redirect()->route('dashboard.index'))->name('dashboard');

// Assinatura Pro (Mercado Pago) — autenticado, sob /painel para não colidir com /{trainer}
Route::middleware('auth')->prefix('painel')->name('billing.')->group(function () {
    Route::get('/assinar', [BillingController::class, 'subscribe'])->name('subscribe');
    Route::get('/assinar/retorno', [BillingController::class, 'callback'])->name('return');
});

// Webhook do Mercado Pago (chamada externa, sem CSRF/sessão)
Route::match(['get', 'post'], '/webhooks/mercadopago', [BillingController::class, 'webhook'])->name('billing.webhook');

// Formulário de contato do perfil (captação de leads)
Route::post('/{trainer}/lead', [LeadController::class, 'store'])->name('lead.store');

// Versão "link na bio" — minimalista, mobile-first (estilo Linktree)
Route::get('/{trainer}/bio', [ProfileController::class, 'bio'])->name('profile.bio');

// Perfil público completo — precisa ser a ÚLTIMA rota,
// pois /{trainer} captura qualquer slug na raiz.
Route::get('/{trainer}', [ProfileController::class, 'show'])->name('profile');
