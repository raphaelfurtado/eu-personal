<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Credenciais não conferem.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['required', 'email', 'max:160', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->trainer()->create([
            'slug'         => $this->uniqueSlug($data['name']),
            'name'         => $data['name'],
            'brand_name'   => $data['name'],
            'role'         => 'Personal Trainer',
            'tagline'      => 'Treino personalizado e acompanhamento de verdade para você alcançar seus objetivos.',
            'about_title'  => 'Sobre mim',
            'accent_color' => '#1f4733',
            'show_stats'   => true,
            'about_features' => [
                ['icon' => 'pulse', 'title' => 'Avaliação individual',  'body' => 'Avaliação completa antes de montar o seu treino.'],
                ['icon' => 'chart', 'title' => 'Método com progressão', 'body' => 'Treinos que evoluem junto com você, semana a semana.'],
                ['icon' => 'chat',  'title' => 'Acompanhamento próximo', 'body' => 'Suporte e ajustes sempre que precisar.'],
            ],
            'stats' => [
                ['num' => '0', 'label' => 'Anos de experiência'],
                ['num' => '0', 'label' => 'Alunos atendidos'],
            ],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.profile.edit')
            ->with('flash', 'Conta criada! Complete seu perfil abaixo.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'personal';
        $slug = $base;
        $i = 2;

        while (Trainer::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
