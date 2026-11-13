@props([
    'title' => 'PersonalBio',
    'themeStyle' => '',   // variáveis CSS da cor de marca (--brand, --on-brand, ...)
    'alpine' => true,     // carrega o Alpine (menu/forms); a página /bio dispensa
])
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{margin:0;background:var(--page,#f5f4ef);font-family:'Inter',system-ui,sans-serif;color:#1b2520;-webkit-font-smoothing:antialiased;}
        a{color:inherit;}
        [x-cloak]{display:none!important;}
        .lk-btn{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #ece9e0;border-radius:15px;padding:15px 18px;text-decoration:none;box-shadow:0 4px 14px rgba(31,71,51,.05);transition:transform .15s ease,box-shadow .15s ease,border-color .15s ease;}
        .lk-btn:hover{transform:translateY(-2px);box-shadow:0 10px 26px rgba(31,71,51,.12);border-color:var(--accent,#d8a32e);}
        .bio-btn{display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:17px 20px;border-radius:14px;background:var(--brand,#1f4733);color:var(--on-brand,#fff);font:600 15px/1.2 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;text-decoration:none;box-shadow:0 6px 18px rgba(0,0,0,.08);transition:transform .15s ease,box-shadow .15s ease;}
        .bio-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.16);}
        .bio-btn--ghost{background:#fff;color:var(--brand,#1f4733);border:1.5px solid #e3e0d7;box-shadow:none;}
        @media(max-width:880px){
            [data-desktop-nav]{display:none!important;}
            [data-burger]{display:inline-flex!important;}
        }
    </style>

    @if ($alpine)
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endif
</head>
<body style="overflow-x:hidden;{{ $themeStyle }}">
    {{ $slot }}
</body>
</html>
