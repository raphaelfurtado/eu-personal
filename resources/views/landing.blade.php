@php
    $profileUrl = route('profile', $exampleSlug);
    $navLinks = [
        ['href' => '#recursos', 'label' => 'Recursos'],
        ['href' => '#como',     'label' => 'Como funciona'],
        ['href' => '#planos',   'label' => 'Planos'],
        ['href' => '#exemplos', 'label' => 'Exemplos'],
        ['href' => route('login'), 'label' => 'Entrar'],
    ];
@endphp

<x-layout title="PersonalBio · Site profissional para personal trainers">
<div style="background:#f5f4ef;overflow:hidden;">

    <x-site-header :links="$navLinks" :cta-href="route('register')" cta-label="Criar meu perfil" />

    {{-- HERO --}}
    <section style="max-width:1180px;margin:0 auto;padding:clamp(48px,7vw,84px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:clamp(40px,5vw,64px);align-items:center;">
        <div>
            <div style="display:inline-flex;align-items:center;gap:8px;padding:7px 14px;background:#e8f0ea;border-radius:999px;margin-bottom:24px;">
                <span style="width:7px;height:7px;border-radius:50%;background:#2f7d54;"></span>
                <span style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#2f7d54;">A plataforma para personal trainers</span>
            </div>
            <h1 style="font:700 clamp(42px,6.5vw,72px)/.98 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 20px;">Seu site profissional pronto em minutos</h1>
            <p style="font:400 clamp(17px,2.2vw,20px)/1.55 'Inter',sans-serif;color:#4a564f;max-width:46ch;margin:0 0 32px;">A PersonalBio transforma suas credenciais e resultados em uma página que capta alunos — sem precisar saber nada de programação.</p>
            <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:26px;">
                <a href="{{ route('register') }}" style="padding:16px 30px;background:#1f4733;color:#fff;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:9px;">Começar grátis <x-icon name="arrow-right" size="16" sw="2.4" /></a>
                <a href="{{ $profileUrl }}" style="padding:16px 30px;background:transparent;color:#1f4733;border:1.6px solid #cdd6cf;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:9px;"><x-icon name="play" size="16" sw="2.2" />Ver exemplo ao vivo</a>
            </div>
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="display:flex;">
                    <span style="width:34px;height:34px;border-radius:50%;background:#cdd6cf;border:2px solid #f5f4ef;"></span>
                    <span style="width:34px;height:34px;border-radius:50%;background:#b6c7bb;border:2px solid #f5f4ef;margin-left:-10px;"></span>
                    <span style="width:34px;height:34px;border-radius:50%;background:#2f7d54;border:2px solid #f5f4ef;margin-left:-10px;"></span>
                    <span style="width:34px;height:34px;border-radius:50%;background:#1f4733;border:2px solid #f5f4ef;margin-left:-10px;display:flex;align-items:center;justify-content:center;font:600 11px 'Oswald',sans-serif;color:var(--accent,#d8a32e);">2k+</span>
                </div>
                <span style="font:400 14px/1.4 'Inter',sans-serif;color:#4a564f;"><strong style="color:#1b2520;">+2.000 personais</strong> já têm seu site na PersonalBio</span>
            </div>
        </div>

        {{-- mockup de navegador --}}
        <div style="position:relative;">
            <div style="position:absolute;inset:14px -16px -20px 18px;background:#e8f0ea;border-radius:24px;z-index:0;"></div>
            <div style="position:relative;z-index:1;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 28px 70px rgba(31,71,51,.22);border:1px solid #e7e5dd;">
                <div style="display:flex;align-items:center;gap:7px;padding:12px 16px;background:#f0efe9;border-bottom:1px solid #e7e5dd;">
                    <span style="width:11px;height:11px;border-radius:50%;background:#e06c5e;"></span>
                    <span style="width:11px;height:11px;border-radius:50%;background:#e6b54a;"></span>
                    <span style="width:11px;height:11px;border-radius:50%;background:#5bb87a;"></span>
                    <span style="margin-left:12px;flex:1;background:#fff;border:1px solid #e7e5dd;border-radius:7px;padding:5px 12px;font:400 12px 'Inter',sans-serif;color:#8a9690;">personalbio.com.br/camila-reis</span>
                </div>
                <div>
                    <div style="background:#1f4733;color:#cfe0d5;text-align:center;padding:6px;font:600 10px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;">Perfil verificado em PersonalBio</div>
                    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:14px;padding:22px;align-items:center;">
                        <div>
                            <div style="font:600 10px/1 'Oswald',sans-serif;letter-spacing:1.5px;text-transform:uppercase;color:#8a9690;margin-bottom:6px;">Personal Trainer · RJ</div>
                            <div style="font:700 30px/.95 'Oswald',sans-serif;color:#1b2520;margin-bottom:10px;">Camila Reis</div>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px;">
                                <span style="font:600 10px/1 'Inter',sans-serif;color:#2f7d54;background:#e8f0ea;padding:5px 9px;border-radius:7px;">CREF ativo</span>
                                <span style="font:600 10px/1 'Inter',sans-serif;color:#2f7d54;background:#e8f0ea;padding:5px 9px;border-radius:7px;">⭐ 4,9</span>
                            </div>
                            <span style="display:inline-block;padding:9px 16px;background:#1f4733;color:#fff;border-radius:999px;font:600 10px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;">Agendar avaliação</span>
                        </div>
                        <x-photo :src="asset('images/demo/mockup.jpg')" label="Foto" :radius="14" style="width:100%;aspect-ratio:3/4;display:block;" />
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);background:#1f4733;">
                        <div style="text-align:center;padding:14px 6px;"><div style="font:700 22px/1 'Oswald',sans-serif;color:#fff;">8</div><div style="font:400 9px/1.2 'Inter',sans-serif;color:#a9c4b3;margin-top:3px;">anos</div></div>
                        <div style="text-align:center;padding:14px 6px;border-left:1px solid rgba(255,255,255,.1);border-right:1px solid rgba(255,255,255,.1);"><div style="font:700 22px/1 'Oswald',sans-serif;color:#fff;">300+</div><div style="font:400 9px/1.2 'Inter',sans-serif;color:#a9c4b3;margin-top:3px;">alunos</div></div>
                        <div style="text-align:center;padding:14px 6px;"><div style="font:700 22px/1 'Oswald',sans-serif;color:var(--accent,#d8a32e);">94%</div><div style="font:400 9px/1.2 'Inter',sans-serif;color:#a9c4b3;margin-top:3px;">meta</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUST STRIP --}}
    <section style="border-top:1px solid #e7e5dd;border-bottom:1px solid #e7e5dd;background:#eff1ea;">
        <div style="max-width:1180px;margin:0 auto;padding:30px clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:24px;">
            @foreach (config('corpora.trust') as $t)
                <div style="text-align:center;"><div style="font:700 clamp(30px,4vw,40px)/1 'Oswald',sans-serif;color:#1f4733;">{{ $t['value'] }}</div><div style="font:500 13px/1.3 'Inter',sans-serif;color:#6b7670;margin-top:4px;">{{ $t['label'] }}</div></div>
            @endforeach
        </div>
    </section>

    {{-- RECURSOS --}}
    <section id="recursos" style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
        <div style="text-align:center;margin-bottom:52px;">
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#2f7d54;margin-bottom:12px;">Por que PersonalBio</div>
            <h2 style="font:700 clamp(32px,4.6vw,50px)/1.02 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 auto;max-width:18ch;">Tudo que você precisa para virar referência</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;">
            @foreach (config('corpora.features') as $f)
                <div style="background:#fff;border:1px solid #ece9e0;border-radius:20px;padding:30px;">
                    <span style="width:52px;height:52px;border-radius:14px;background:#e8f0ea;display:flex;align-items:center;justify-content:center;margin-bottom:18px;color:#1f4733;"><x-icon :name="$f['icon']" size="24" /></span>
                    <h3 style="font:600 21px/1.2 'Oswald',sans-serif;letter-spacing:.3px;color:#1b2520;margin:0 0 10px;">{{ $f['title'] }}</h3>
                    <p style="font:400 15px/1.55 'Inter',sans-serif;color:#6b7670;margin:0;">{{ $f['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- COMO FUNCIONA --}}
    <section id="como" style="background:#eef0e9;">
        <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
            <div style="text-align:center;margin-bottom:52px;">
                <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#2f7d54;margin-bottom:12px;">Simples assim</div>
                <h2 style="font:700 clamp(32px,4.6vw,50px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0;">Do zero ao no ar em 3 passos</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:22px;">
                @foreach (config('corpora.steps') as $s)
                    <div style="background:#fff;border-radius:20px;padding:32px;position:relative;">
                        <div style="font:700 46px/1 'Oswald',sans-serif;color:#e8f0ea;margin-bottom:6px;">{{ $s['n'] }}</div>
                        <h3 style="font:600 22px/1.2 'Oswald',sans-serif;letter-spacing:.3px;color:#1b2520;margin:0 0 10px;">{{ $s['title'] }}</h3>
                        <p style="font:400 15px/1.55 'Inter',sans-serif;color:#6b7670;margin:0;">{{ $s['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SHOWCASE / EXEMPLOS --}}
    <section id="exemplos" style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:clamp(36px,5vw,56px);align-items:center;scroll-margin-top:90px;">
        <div>
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#2f7d54;margin-bottom:12px;">Veja na prática</div>
            <h2 style="font:700 clamp(30px,4.4vw,46px)/1.05 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 18px;max-width:16ch;">Perfis reais, criados na PersonalBio</h2>
            <p style="font:400 17px/1.6 'Inter',sans-serif;color:#4a564f;max-width:44ch;margin:0 0 24px;">Cada personal tem o seu — com credenciais, transformações, planos e agendamento, e a <strong style="color:#1b2520;">cor da própria marca</strong>. Veja dois exemplos:</p>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach ($examples as $ex)
                    <a href="{{ route('profile', $ex) }}" style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #ece9e0;border-radius:16px;padding:13px 16px;text-decoration:none;box-shadow:0 4px 14px rgba(31,71,51,.05);">
                        @if ($ex->hero_photo_url)
                            <img src="{{ $ex->hero_photo_url }}" alt="{{ $ex->name }}" style="width:50px;height:50px;border-radius:50%;object-fit:cover;flex:0 0 auto;">
                        @endif
                        <div style="flex:1;">
                            <div style="font:600 17px/1.2 'Oswald',sans-serif;color:#1b2520;">{{ $ex->name }}</div>
                            <div style="font:400 13px/1.3 'Inter',sans-serif;color:#6b7670;">{{ $ex->role }}@if($ex->city) · {{ $ex->city }}@endif</div>
                        </div>
                        <span title="cor do perfil" style="flex:0 0 auto;width:14px;height:14px;border-radius:50%;background:{{ $ex->accent_color }};box-shadow:0 0 0 2px #fff,0 0 0 3px #e7e5dd;"></span>
                        <span style="flex:0 0 auto;color:#1f4733;"><x-icon name="arrow-ur" size="16" sw="2.4" /></span>
                    </a>
                @endforeach
            </div>
            <a href="{{ route('profile.bio', $exampleSlug) }}" style="display:inline-flex;align-items:center;gap:7px;margin-top:16px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#1f4733;text-decoration:none;">Ver versão link na bio <x-icon name="arrow-right" size="15" sw="2.4" /></a>
        </div>
        <div style="display:flex;flex-direction:column;gap:14px;">
            @foreach ([
                ['icon' => 'shield', 'title' => 'Credenciais em destaque', 'body' => 'CREF, formação e certificações que geram confiança.'],
                ['icon' => 'bars',   'title' => 'Vitrine de resultados',   'body' => 'Antes/depois e números das suas transformações.'],
                ['icon' => 'chat',   'title' => 'Captação integrada',      'body' => 'Formulário e WhatsApp levam o lead direto pra você.'],
                ['icon' => 'link',   'title' => 'Link na bio incluso',     'body' => 'Uma página minimalista, no estilo do Linktree, pra bio do Instagram.'],
            ] as $m)
                <div style="display:flex;gap:14px;align-items:flex-start;background:#fff;border:1px solid #ece9e0;border-radius:16px;padding:20px;">
                    <span style="flex:0 0 auto;width:42px;height:42px;border-radius:11px;background:#e8f0ea;display:flex;align-items:center;justify-content:center;color:#1f4733;"><x-icon :name="$m['icon']" size="20" /></span>
                    <div><div style="font:600 17px/1.2 'Oswald',sans-serif;color:#1b2520;">{{ $m['title'] }}</div><div style="font:400 14px/1.5 'Inter',sans-serif;color:#6b7670;margin-top:3px;">{{ $m['body'] }}</div></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- DEPOIMENTOS --}}
    <section style="background:#1f4733;">
        <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,90px) clamp(20px,5vw,24px);">
            <div style="text-align:center;margin-bottom:46px;">
                <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--accent,#d8a32e);margin-bottom:12px;">Quem usa, indica</div>
                <h2 style="font:700 clamp(30px,4.4vw,46px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#fff;margin:0;">Personais que já decolaram</h2>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;">
                @foreach (config('corpora.quotes') as $q)
                    <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:28px;">
                        <div style="color:var(--accent,#d8a32e);font:700 40px/1 'Oswald',sans-serif;margin-bottom:6px;">&ldquo;</div>
                        <p style="font:400 17px/1.55 'Inter',sans-serif;color:#eaf2ec;margin:0 0 20px;">{{ $q['text'] }}</p>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="width:40px;height:40px;border-radius:50%;background:rgba(255,255,255,.12);"></span>
                            <div><div style="font:600 15px/1.2 'Oswald',sans-serif;color:#fff;">{{ $q['name'] }}</div><div style="font:400 13px/1.2 'Inter',sans-serif;color:#a9c4b3;">{{ $q['role'] }}</div></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PLANOS --}}
    <section id="planos" style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
        <div style="text-align:center;margin-bottom:52px;">
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#2f7d54;margin-bottom:12px;">Planos</div>
            <h2 style="font:700 clamp(32px,4.6vw,50px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 12px;">Comece grátis, cresça quando quiser</h2>
            <p style="font:400 16px/1.5 'Inter',sans-serif;color:#6b7670;margin:0 auto;max-width:46ch;">Sem fidelidade. Cancele quando quiser.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:22px;align-items:stretch;">
            @foreach (config('corpora.plans') as $p)
                @php
                    $hot = $p['featured'];
                    // No Grátis, mostra os limites reais (vindos de config/plans.php)
                    $feats = $p['features'];
                    if (($p['plan'] ?? null) === 'free') {
                        $l = config('plans.free.limits');
                        $feats = array_merge($feats, [
                            "Até {$l['results']} transformações (antes/depois)",
                            "Até {$l['links']} links e {$l['packages']} pacote",
                            "Até {$l['testimonials']} prints de alunos",
                        ]);
                    }
                    // CTA: Studio fala com vendas (WhatsApp); os demais vão pro cadastro
                    if (($p['plan'] ?? null) === 'studio') {
                        $sales = config('corpora.sales_whatsapp');
                        $ctaHref = $sales ? 'https://wa.me/'.$sales.'?text='.rawurlencode('Olá! Tenho um estúdio/equipe e quero saber do plano Studio da PersonalBio.') : route('register');
                    } else {
                        $ctaHref = $p['href'] === '#' ? route('register') : $p['href'];
                    }
                @endphp
                <div style="background:{{ $hot ? '#1f4733' : '#fff' }};border:{{ $hot ? 'none' : '1px solid #ece9e0' }};border-radius:22px;padding:32px;display:flex;flex-direction:column;position:relative;{{ $hot ? 'box-shadow:0 24px 50px rgba(31,71,51,.25);' : '' }}">
                    @if ($p['badge'])
                        <span style="position:absolute;top:-13px;left:32px;background:var(--accent,#d8a32e);color:#1b2520;font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;padding:7px 14px;border-radius:999px;">{{ $p['badge'] }}</span>
                    @endif
                    <div style="font:600 16px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:{{ $hot ? '#fff' : '#1b2520' }};margin-bottom:10px;">{{ $p['name'] }}</div>
                    <div style="display:flex;align-items:baseline;gap:5px;margin-bottom:6px;"><span style="font:700 46px/1 'Oswald',sans-serif;color:{{ $hot ? '#fff' : '#1b2520' }};">{{ $p['price'] }}</span><span style="font:400 14px 'Inter',sans-serif;color:{{ $hot ? '#a9c4b3' : '#6b7670' }};">{{ $p['period'] }}</span></div>
                    <p style="font:400 14px/1.4 'Inter',sans-serif;color:{{ $hot ? '#a9c4b3' : '#6b7670' }};margin:0 0 22px;">{{ $p['desc'] }}</p>
                    <div style="display:flex;flex-direction:column;gap:11px;margin-bottom:28px;">
                        @foreach ($feats as $feat)
                            <div style="display:flex;gap:10px;font:400 14px/1.4 'Inter',sans-serif;color:{{ $hot ? '#eaf2ec' : '#3a463f' }};"><span style="flex:0 0 auto;margin-top:1px;color:{{ $hot ? 'var(--accent,#d8a32e)' : '#2f7d54' }};"><x-icon name="check" size="18" sw="2.4" /></span>{{ $feat }}</div>
                        @endforeach
                    </div>
                    <a href="{{ $ctaHref }}" @if(($p['plan'] ?? null) === 'studio') target="_blank" rel="noopener" @endif style="margin-top:auto;text-align:center;padding:14px;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;{{ $hot ? 'background:var(--accent,#d8a32e);color:#1b2520;border:none;' : 'background:transparent;color:#1f4733;border:1.6px solid #cdd6cf;' }}">{{ $p['cta'] }}</a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA BAND --}}
    <section style="max-width:1180px;margin:0 auto clamp(60px,8vw,90px);padding:0 clamp(20px,5vw,24px);">
        <div style="background:linear-gradient(135deg,#234d36,#16341f);border-radius:28px;padding:clamp(40px,6vw,72px);text-align:center;">
            <h2 style="font:700 clamp(30px,4.6vw,52px)/1.02 'Oswald',sans-serif;letter-spacing:.5px;color:#fff;margin:0 auto 16px;max-width:18ch;">Pronto para ter o site que seu trabalho merece?</h2>
            <p style="font:400 18px/1.55 'Inter',sans-serif;color:#bcd4c5;margin:0 auto 32px;max-width:44ch;">Crie seu perfil em minutos e comece a captar alunos hoje. Grátis para sempre no plano inicial.</p>
            <a href="{{ route('register') }}" style="display:inline-flex;align-items:center;gap:9px;padding:17px 34px;background:var(--accent,#d8a32e);color:#1b2520;border-radius:999px;font:600 15px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-decoration:none;">Criar meu perfil grátis <x-icon name="arrow-right" size="17" sw="2.4" /></a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer style="background:#16341f;color:#a9c4b3;">
        <div style="max-width:1180px;margin:0 auto;padding:48px clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:32px;">
            <div>
                <div style="margin-bottom:14px;"><x-logo variant="footer" /></div>
                <p style="font:400 14px/1.6 'Inter',sans-serif;color:#88a594;margin:0;max-width:30ch;">A plataforma que conecta personal trainers aos alunos certos.</p>
            </div>
            <div>
                <div style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#fff;margin-bottom:14px;">Produto</div>
                <div style="display:flex;flex-direction:column;gap:10px;font:400 14px 'Inter',sans-serif;"><a href="#recursos" style="color:#a9c4b3;text-decoration:none;">Recursos</a><a href="#planos" style="color:#a9c4b3;text-decoration:none;">Planos</a><a href="#exemplos" style="color:#a9c4b3;text-decoration:none;">Exemplos</a></div>
            </div>
            <div>
                <div style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#fff;margin-bottom:14px;">Empresa</div>
                <div style="display:flex;flex-direction:column;gap:10px;font:400 14px 'Inter',sans-serif;"><a href="#" style="color:#a9c4b3;text-decoration:none;">Sobre</a><a href="#" style="color:#a9c4b3;text-decoration:none;">Contato</a><a href="#" style="color:#a9c4b3;text-decoration:none;">Blog</a></div>
            </div>
            <div>
                <div style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#fff;margin-bottom:14px;">Comece agora</div>
                <a href="#planos" style="display:inline-block;padding:12px 22px;background:var(--accent,#d8a32e);color:#1b2520;border-radius:999px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Criar perfil grátis</a>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,.08);padding:16px;text-align:center;font:400 12px/1 'Inter',sans-serif;color:#6f8a7b;">© {{ date('Y') }} PersonalBio · Feito para quem move pessoas</div>
    </footer>

</div>
</x-layout>
