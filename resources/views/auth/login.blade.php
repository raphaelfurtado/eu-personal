<x-layout title="Entrar · PersonalBio">
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 20px;">
    <div style="width:100%;max-width:420px;">
        <div style="display:flex;justify-content:center;margin-bottom:26px;"><x-logo /></div>

        <div style="background:#fff;border:1px solid #ece9e0;border-radius:22px;padding:clamp(26px,5vw,38px);box-shadow:0 18px 50px rgba(31,71,51,.08);">
            <h1 style="font:700 30px/1 'Oswald',sans-serif;color:#1b2520;margin:0 0 6px;">Entrar</h1>
            <p style="font:400 15px/1.5 'Inter',sans-serif;color:#6b7670;margin:0 0 26px;">Acesse o painel do seu perfil.</p>

            @if ($errors->any())
                <div style="background:#fbecec;border:1px solid #f0caca;color:#a23a3a;border-radius:12px;padding:12px 14px;font:400 13px/1.4 'Inter',sans-serif;margin-bottom:18px;">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">E-mail</label>
                <input name="email" type="email" value="{{ old('email') }}" required autofocus style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">

                <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Senha</label>
                <input name="password" type="password" required style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:16px;outline:none;">

                <label style="display:flex;align-items:center;gap:9px;font:400 14px 'Inter',sans-serif;color:#4a564f;margin-bottom:22px;cursor:pointer;">
                    <input type="checkbox" name="remember" value="1" style="width:16px;height:16px;accent-color:#1f4733;"> Manter conectado
                </label>

                <button type="submit" style="width:100%;padding:16px;background:#1f4733;color:#fff;border:none;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;cursor:pointer;">Entrar</button>
            </form>
        </div>

        <p style="text-align:center;font:400 14px/1.5 'Inter',sans-serif;color:#6b7670;margin-top:20px;">Ainda não tem conta? <a href="{{ route('register') }}" style="color:#1f4733;font-weight:600;text-decoration:none;">Criar grátis</a></p>
    </div>
</div>
</x-layout>
