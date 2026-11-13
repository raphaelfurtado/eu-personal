@php
    $navLinks = array_values(array_filter([
        ['href' => '#resultados',    'label' => 'Resultados'],
        ['href' => '#qualificacoes', 'label' => 'Qualificações'],
        $trainer->packages->isNotEmpty() ? ['href' => '#planos', 'label' => 'Planos'] : null,
        ['href' => '#sobre',         'label' => 'Sobre'],
    ]));
    $objetivos = [
        'emagrecimento'  => 'Emagrecimento',
        'hipertrofia'    => 'Hipertrofia / ganho de massa',
        'condicionamento'=> 'Condicionamento físico',
        'reabilitacao'   => 'Reabilitação / postura',
        'outro'          => 'Outro',
    ];
    $niveis = ['Iniciante', 'Intermediário', 'Avançado'];
    $frequencias = ['2x por semana', '3x por semana', '4x ou mais'];
    $locais = ['Academia', 'Em casa', 'Ao ar livre', 'Online'];

    // Plano: marca PersonalBio e logo próprio dependem do plano
    $showBranding = ! $trainer->planAllows('remove_branding');
    $logoSrc = $trainer->planAllows('custom_logo') ? $trainer->logo_url : null;
@endphp

<x-layout :title="$trainer->name.' · '.$trainer->role" :theme-style="$trainer->theme_style">
<div style="background:var(--page,#f5f4ef);overflow:hidden;">

    @if ($showBranding)
        {{-- faixa da plataforma (segue a cor da marca; ocultada no Pro) --}}
        <div style="background:var(--brand,#1f4733);color:var(--on-brand-muted,#cfe0d5);text-align:center;padding:7px 16px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;">
            Perfil verificado em PersonalBio &nbsp;·&nbsp; <a href="{{ route('home') }}" style="color:var(--accent,#d8a32e);text-decoration:none;">Explorar outros personais →</a>
        </div>
    @endif

    <x-site-header :links="$navLinks" cta-href="#contato" cta-label="Agendar avaliação" :home="route('home')" :logo-src="$logoSrc" :brand="$trainer->brand_name_label" />

    {{-- HERO --}}
    <section style="max-width:1180px;margin:0 auto;padding:clamp(48px,7vw,84px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(330px,1fr));gap:clamp(36px,5vw,64px);align-items:center;">
        <div>
            @if ($trainer->verified)
                <div style="display:inline-flex;align-items:center;gap:8px;padding:7px 14px;background:var(--brand-tint,#e8f0ea);border-radius:999px;margin-bottom:22px;color:var(--brand-2,#2f7d54);">
                    <x-icon name="check-fill" size="14" />
                    <span style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:var(--brand-2,#2f7d54);">{{ $trainer->cref }} · Profissional verificada</span>
                </div>
            @endif
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#8a9690;margin-bottom:10px;">{{ $trainer->role }}@if($trainer->city) · {{ $trainer->city }}@endif</div>
            <h1 style="font:700 clamp(46px,8vw,86px)/.92 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 18px;">{{ $trainer->name }}</h1>
            <p style="font:400 clamp(17px,2.2vw,20px)/1.55 'Inter',sans-serif;color:#4a564f;max-width:30ch;margin:0 0 30px;">{{ $trainer->tagline }}</p>
            <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:34px;">
                <a href="#contato" style="padding:16px 28px;background:var(--brand,#1f4733);color:var(--on-brand,#fff);border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-decoration:none;display:inline-flex;align-items:center;gap:9px;">Agendar avaliação gratuita <x-icon name="arrow-right" size="16" sw="2.4" /></a>
                <a href="#resultados" style="padding:16px 28px;background:transparent;color:var(--brand,#1f4733);border:1.6px solid #cdd6cf;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-decoration:none;">Ver transformações</a>
            </div>
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:22px;">
                @if ($trainer->rating)
                    <div style="display:flex;align-items:center;gap:7px;color:var(--accent,#d8a32e);">
                        <x-icon name="star" size="18" />
                        <span style="font:700 15px/1 'Inter',sans-serif;color:#1b2520;">{{ $trainer->rating_br }}</span>
                        <span style="font:400 13px/1 'Inter',sans-serif;color:#6b7670;">· {{ $trainer->rating_count }} avaliações</span>
                    </div>
                    <div style="width:1px;height:22px;background:#dcdad2;"></div>
                @endif
                <div style="font:400 14px/1.3 'Inter',sans-serif;color:#4a564f;"><strong style="color:#1b2520;">{{ $trainer->years }} anos</strong> de prática</div>
                <div style="width:1px;height:22px;background:#dcdad2;"></div>
                <div style="font:400 14px/1.3 'Inter',sans-serif;color:#4a564f;"><strong style="color:#1b2520;">{{ $trainer->students }}</strong> alunos</div>
            </div>
        </div>

        <div style="position:relative;">
            <div style="position:absolute;inset:auto -18px -22px auto;width:62%;height:78%;background:var(--brand-tint,#e8f0ea);border-radius:24px;z-index:0;"></div>
            <x-photo :src="$trainer->hero_photo_url" label="Foto principal" :radius="22" style="position:relative;z-index:1;width:100%;aspect-ratio:4/5;display:block;box-shadow:0 24px 60px rgba(31,71,51,.18);" />
            <div style="position:absolute;z-index:2;left:-14px;top:26px;background:#fff;border-radius:16px;padding:13px 17px;box-shadow:0 12px 30px rgba(0,0,0,.12);display:flex;align-items:center;gap:11px;">
                <span style="width:40px;height:40px;border-radius:11px;background:var(--brand-tint,#e8f0ea);display:flex;align-items:center;justify-content:center;color:var(--brand-2,#2f7d54);"><x-icon name="heart" size="20" sw="2.2" /></span>
                <div><div style="font:700 18px/1 'Oswald',sans-serif;color:#1b2520;">{{ $trainer->goal_rate }}</div><div style="font:400 11px/1.2 'Inter',sans-serif;color:#6b7670;">atingem a meta</div></div>
            </div>
            <div style="position:absolute;z-index:2;right:-12px;bottom:34px;background:var(--brand,#1f4733);border-radius:16px;padding:14px 18px;box-shadow:0 12px 30px rgba(31,71,51,.3);">
                <div style="font:700 22px/1 'Oswald',sans-serif;color:var(--accent,#d8a32e);">{{ $trainer->students }}</div>
                <div style="font:400 11px/1.2 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);margin-top:3px;">alunos<br>transformados</div>
            </div>
        </div>
    </section>

    {{-- ESPECIALIDADES + FORMATO --}}
    @if (! empty($trainer->specialties) || ! empty($trainer->formats))
        <section style="max-width:1180px;margin:0 auto;padding:0 clamp(20px,5vw,24px) clamp(22px,4vw,40px);">
            <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
                @foreach (($trainer->specialties ?? []) as $sp)
                    <span style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:var(--brand,#1f4733);background:var(--brand-tint,#e8f0ea);padding:9px 14px;border-radius:999px;">{{ $sp }}</span>
                @endforeach
                @foreach (($trainer->formats ?? []) as $fm)
                    <span style="display:inline-flex;align-items:center;gap:6px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;border:1.5px solid #d8d4c8;padding:8px 13px;border-radius:999px;"><span style="width:6px;height:6px;border-radius:50%;background:var(--brand-2,#2f7d54);"></span>{{ $fm }}</span>
                @endforeach
            </div>
        </section>
    @endif

    {{-- MEUS LINKS (estilo linktree) --}}
    @if ($trainer->links->isNotEmpty())
        <section style="max-width:1180px;margin:0 auto;padding:0 clamp(20px,5vw,24px) clamp(28px,5vw,48px);">
            <div style="max-width:560px;margin:0 auto;">
                <div style="text-align:center;font:600 13px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:#8a9690;margin-bottom:18px;">Meus links</div>
                <div style="display:flex;flex-direction:column;gap:13px;">
                    @foreach ($trainer->links as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener" class="lk-btn">
                            <span style="flex:0 0 auto;width:42px;height:42px;border-radius:11px;background:var(--brand-tint,#e8f0ea);display:flex;align-items:center;justify-content:center;color:var(--brand,#1f4733);"><x-icon :name="$link->icon ?: 'link'" size="20" /></span>
                            <span style="flex:1;font:600 16px/1.25 'Oswald',sans-serif;letter-spacing:.3px;color:#1b2520;">{{ $link->label }}</span>
                            <span style="flex:0 0 auto;color:var(--accent,#d8a32e);"><x-icon name="arrow-ur" size="18" sw="2.2" /></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- STATS --}}
    @if ($trainer->show_stats && $trainer->stats)
        <section style="background:var(--brand,#1f4733);">
            <div style="max-width:1180px;margin:0 auto;padding:clamp(40px,5vw,56px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:clamp(28px,4vw,40px);">
                @foreach ($trainer->stats as $s)
                    <div style="text-align:center;">
                        <div style="font:700 clamp(40px,5vw,58px)/1 'Oswald',sans-serif;color:var(--on-brand,#fff);letter-spacing:.5px;">{{ $s['num'] }}</div>
                        <div style="width:30px;height:3px;background:var(--accent,#d8a32e);border-radius:3px;margin:14px auto;"></div>
                        <div style="font:500 14px/1.4 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- QUALIFICAÇÕES --}}
    <section id="qualificacoes" style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
        <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Formação &amp; credenciais</div>
        <h2 style="font:700 clamp(32px,4.6vw,50px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 14px;max-width:18ch;">Qualificações que sustentam cada treino</h2>
        <p style="font:400 17px/1.6 'Inter',sans-serif;color:#4a564f;max-width:54ch;margin:0 0 46px;">Registro ativo no conselho, formação acadêmica e certificações reconhecidas — sua segurança vem antes de qualquer resultado.</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:18px;">
            @foreach ($trainer->certifications as $c)
                <div style="background:#fff;border:1px solid #ece9e0;border-radius:18px;padding:26px;display:flex;flex-direction:column;gap:14px;">
                    <span style="width:46px;height:46px;border-radius:13px;background:var(--brand-tint,#e8f0ea);display:flex;align-items:center;justify-content:center;color:var(--brand,#1f4733);"><x-icon name="shield-check" size="22" /></span>
                    <div>
                        <div style="font:600 19px/1.25 'Oswald',sans-serif;letter-spacing:.3px;color:#1b2520;">{{ $c->title }}</div>
                        <div style="font:400 14px/1.4 'Inter',sans-serif;color:#6b7670;margin-top:5px;">{{ $c->issuer }}</div>
                    </div>
                    @if ($c->year)
                        <span style="margin-top:auto;align-self:flex-start;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:#8a6512;background:#f6ecd2;padding:6px 11px;border-radius:999px;">{{ $c->year }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- RESULTADOS --}}
    <section id="resultados" style="background:var(--brand-tint-2,#eef0e9);">
        <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Resultados reais</div>
            <h2 style="font:700 clamp(32px,4.6vw,50px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 14px;max-width:16ch;">Transformações que falam por si</h2>
            <p style="font:400 17px/1.6 'Inter',sans-serif;color:#4a564f;max-width:54ch;margin:0 0 46px;">Cada jornada é única. Estes são alguns alunos que confiaram no processo.</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:22px;">
                @foreach ($trainer->results as $r)
                    <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 8px 28px rgba(31,71,51,.08);">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;background:#e7e5dd;">
                            <div style="position:relative;"><x-photo :src="$r->before_photo_url" label="Antes" style="width:100%;aspect-ratio:3/4;display:block;" /><span style="position:absolute;top:10px;left:10px;font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(27,37,32,.78);color:#fff;padding:5px 9px;border-radius:6px;">Antes</span></div>
                            <div style="position:relative;"><x-photo :src="$r->after_photo_url" label="Depois" style="width:100%;aspect-ratio:3/4;display:block;" /><span style="position:absolute;top:10px;left:10px;font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;background:var(--brand,#1f4733);color:var(--on-brand,#fff);padding:5px 9px;border-radius:6px;">Depois</span></div>
                        </div>
                        <div style="padding:22px;">
                            <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:13px;"><span style="font:600 19px/1 'Oswald',sans-serif;color:#1b2520;">{{ $r->student_name }}</span><span style="font:400 13px/1 'Inter',sans-serif;color:#6b7670;">{{ $r->duration }}</span></div>
                            <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;">
                                @foreach (($r->tags ?? []) as $tag)
                                    <span style="font:600 13px/1 'Inter',sans-serif;color:var(--brand-2,#2f7d54);background:var(--brand-tint,#e8f0ea);padding:6px 11px;border-radius:8px;">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <p style="font:400 15px/1.5 'Inter',sans-serif;color:#4a564f;margin:0;font-style:italic;">"{{ $r->quote }}"</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- NA VOZ DOS ALUNOS (prints de conversas) --}}
    @if ($trainer->testimonials->isNotEmpty())
        <section style="background:var(--brand-tint-2,#eef0e9);">
            <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
                <div style="text-align:center;margin-bottom:40px;">
                    <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Na voz dos alunos</div>
                    <h2 style="font:700 clamp(30px,4.4vw,46px)/1.05 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 12px;">O que eles falam por mensagem</h2>
                    <p style="font:400 16px/1.55 'Inter',sans-serif;color:#6b7670;margin:0 auto;max-width:48ch;">Conversas reais, enviadas pelos próprios alunos.</p>
                </div>
                <div style="display:flex;gap:18px;overflow-x:auto;padding:4px 4px 14px;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;">
                    @foreach ($trainer->testimonials as $t)
                        <img src="{{ $t->image_url }}" alt="Depoimento de aluno" loading="lazy" style="height:440px;width:auto;border-radius:18px;border:1px solid #e3e0d7;box-shadow:0 12px 30px rgba(31,71,51,.10);flex:0 0 auto;background:#fff;scroll-snap-align:center;">
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- SOBRE --}}
    <section id="sobre" style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:clamp(36px,5vw,64px);align-items:center;">
        <div style="position:relative;">
            <x-photo :src="$trainer->about_photo_url" label="Foto de bastidores" :radius="22" style="width:100%;aspect-ratio:1/1;display:block;box-shadow:0 20px 50px rgba(31,71,51,.15);" />
            @if ($trainer->sessions)
                <div style="position:absolute;right:-10px;bottom:-18px;background:var(--accent,#d8a32e);color:#1b2520;border-radius:16px;padding:16px 20px;box-shadow:0 12px 30px rgba(0,0,0,.15);">
                    <div style="font:700 26px/1 'Oswald',sans-serif;">{{ $trainer->sessions }}</div>
                    <div style="font:500 12px/1.2 'Inter',sans-serif;">sessões conduzidas</div>
                </div>
            @endif
        </div>
        <div>
            <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Minha história</div>
            <h2 style="font:700 clamp(32px,4.6vw,50px)/1.02 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 20px;">{{ $trainer->about_title }}</h2>
            @if ($trainer->about_p1)<p style="font:400 17px/1.65 'Inter',sans-serif;color:#4a564f;margin:0 0 16px;">{{ $trainer->about_p1 }}</p>@endif
            @if ($trainer->about_p2)<p style="font:400 17px/1.65 'Inter',sans-serif;color:#4a564f;margin:0 0 30px;">{{ $trainer->about_p2 }}</p>@endif
            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach (($trainer->about_features ?? []) as $af)
                    <div style="display:flex;gap:15px;align-items:flex-start;">
                        <span style="flex:0 0 auto;width:40px;height:40px;border-radius:11px;background:var(--brand-tint,#e8f0ea);display:flex;align-items:center;justify-content:center;color:var(--brand,#1f4733);"><x-icon :name="$af['icon']" size="20" /></span>
                        <div><div style="font:600 17px/1.2 'Oswald',sans-serif;color:#1b2520;">{{ $af['title'] }}</div><div style="font:400 15px/1.5 'Inter',sans-serif;color:#6b7670;margin-top:3px;">{{ $af['body'] }}</div></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PLANOS / PACOTES --}}
    @if ($trainer->packages->isNotEmpty())
        <section id="planos" style="background:var(--brand-tint-2,#eef0e9);">
            <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
                <div style="text-align:center;margin-bottom:46px;">
                    <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Planos &amp; pacotes</div>
                    <h2 style="font:700 clamp(32px,4.6vw,50px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0;">Escolha como quer treinar</h2>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:22px;align-items:stretch;">
                    @foreach ($trainer->packages as $pkg)
                        @php
                            $hot = $pkg->featured;
                            $pkgCta = $trainer->whatsapp
                                ? $trainer->whatsapp_url.'?text='.urlencode('Olá! Tenho interesse no plano '.$pkg->name.'.')
                                : '#contato';
                        @endphp
                        <div style="background:{{ $hot ? 'var(--brand,#1f4733)' : '#fff' }};border:{{ $hot ? 'none' : '1px solid #ece9e0' }};border-radius:22px;padding:32px;display:flex;flex-direction:column;position:relative;{{ $hot ? 'box-shadow:0 24px 50px rgba(31,71,51,.22);' : '' }}">
                            @if ($hot)
                                <span style="position:absolute;top:-13px;left:32px;background:var(--accent,#d8a32e);color:#1b2520;font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;padding:7px 14px;border-radius:999px;">Mais procurado</span>
                            @endif
                            <div style="font:600 16px/1.2 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;color:{{ $hot ? 'var(--on-brand,#fff)' : '#1b2520' }};margin-bottom:10px;">{{ $pkg->name }}</div>
                            @if ($pkg->price)
                                <div style="display:flex;align-items:baseline;gap:5px;margin-bottom:18px;"><span style="font:700 40px/1 'Oswald',sans-serif;color:{{ $hot ? 'var(--on-brand,#fff)' : '#1b2520' }};">{{ $pkg->price }}</span><span style="font:400 14px 'Inter',sans-serif;color:{{ $hot ? 'var(--on-brand-muted,#a9c4b3)' : '#6b7670' }};">{{ $pkg->period }}</span></div>
                            @endif
                            <div style="display:flex;flex-direction:column;gap:11px;margin-bottom:26px;">
                                @foreach (($pkg->items ?? []) as $it)
                                    <div style="display:flex;gap:10px;font:400 14px/1.4 'Inter',sans-serif;color:{{ $hot ? 'var(--on-brand,#eaf2ec)' : '#3a463f' }};"><span style="flex:0 0 auto;margin-top:1px;color:{{ $hot ? 'var(--accent,#d8a32e)' : 'var(--brand-2,#2f7d54)' }};"><x-icon name="check" size="18" sw="2.4" /></span>{{ $it }}</div>
                                @endforeach
                            </div>
                            <a href="{{ $pkgCta }}" @if($trainer->whatsapp) target="_blank" rel="noopener" @endif style="margin-top:auto;text-align:center;padding:14px;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;{{ $hot ? 'background:var(--accent,#d8a32e);color:#1b2520;' : 'background:var(--brand,#1f4733);color:var(--on-brand,#fff);' }}">Quero este plano</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CALCULADORA FITNESS --}}
    @if ($trainer->show_calculator)
        @php $ci = "width:100%;padding:12px 14px;border:1.5px solid #e0ddd3;border-radius:10px;font:400 15px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;outline:none;"; @endphp
        <section style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
            <div style="text-align:center;margin-bottom:40px;">
                <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Ferramenta grátis</div>
                <h2 style="font:700 clamp(30px,4.4vw,46px)/1.05 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0 0 12px;">Calcule seu ponto de partida</h2>
                <p style="font:400 16px/1.55 'Inter',sans-serif;color:#6b7670;margin:0 auto;max-width:50ch;">Descubra seu IMC e quanto seu corpo gasta por dia. Depois, é só agendar pra montar o plano certo pra sua meta.</p>
            </div>
            <div x-data="{ sexo:'f', idade:null, peso:null, altura:null, ativ:1.55,
                    get imc(){ const a=this.altura/100; return (this.peso>0&&a>0)?(this.peso/(a*a)):0; },
                    get tmb(){ if(!(this.peso>0&&this.altura>0&&this.idade>0))return 0; const b=10*this.peso+6.25*this.altura-5*this.idade; return Math.round(b+(this.sexo==='m'?5:-161)); },
                    get gasto(){ return this.tmb?Math.round(this.tmb*this.ativ):0; },
                    get imcTxt(){ const v=this.imc; if(!v)return '—'; if(v<18.5)return 'abaixo do peso'; if(v<25)return 'peso normal'; if(v<30)return 'sobrepeso'; return 'obesidade'; },
                    fmt(n){ return n?Math.round(n).toLocaleString('pt-BR'):'—'; } }"
                 style="max-width:820px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:clamp(20px,4vw,30px);background:#fff;border:1px solid #ece9e0;border-radius:22px;padding:clamp(24px,4vw,34px);">
                <div>
                    <div style="display:flex;gap:8px;margin-bottom:14px;">
                        <button type="button" @click="sexo='f'" :style="sexo==='f' ? 'background:var(--brand,#1f4733);color:var(--on-brand,#fff);border-color:var(--brand,#1f4733)' : ''" style="flex:1;padding:11px;border:1.5px solid #e0ddd3;border-radius:10px;background:#faf9f5;color:#1b2520;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;cursor:pointer;">Mulher</button>
                        <button type="button" @click="sexo='m'" :style="sexo==='m' ? 'background:var(--brand,#1f4733);color:var(--on-brand,#fff);border-color:var(--brand,#1f4733)' : ''" style="flex:1;padding:11px;border:1.5px solid #e0ddd3;border-radius:10px;background:#faf9f5;color:#1b2520;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;cursor:pointer;">Homem</button>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                        <input type="number" min="10" max="100" x-model.number="idade" placeholder="Idade" style="{{ $ci }}">
                        <input type="number" min="30" max="300" x-model.number="peso" placeholder="Peso (kg)" style="{{ $ci }}">
                    </div>
                    <input type="number" min="120" max="230" x-model.number="altura" placeholder="Altura (cm)" style="{{ $ci }}margin-bottom:10px;">
                    <select x-model.number="ativ" style="{{ $ci }}">
                        <option value="1.2">Sedentário (pouco/nenhum exercício)</option>
                        <option value="1.375">Leve (1–3x por semana)</option>
                        <option value="1.55">Moderado (3–5x por semana)</option>
                        <option value="1.725">Intenso (6–7x por semana)</option>
                        <option value="1.9">Muito intenso (atleta)</option>
                    </select>
                </div>
                <div style="background:var(--brand,#1f4733);border-radius:16px;padding:24px;color:var(--on-brand,#fff);display:flex;flex-direction:column;">
                    <div style="display:flex;justify-content:space-between;align-items:baseline;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,.14);">
                        <span style="font:400 14px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">IMC</span>
                        <span style="font:700 22px/1 'Oswald',sans-serif;"><span x-text="imc?imc.toFixed(1).replace('.',','):'—'"></span> <span style="font:400 12px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);" x-text="imcTxt"></span></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:baseline;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.14);">
                        <span style="font:400 14px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">Metabolismo basal</span>
                        <span style="font:700 22px/1 'Oswald',sans-serif;"><span x-text="fmt(tmb)"></span> <span style="font:400 12px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">kcal</span></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:baseline;padding:14px 0 20px;">
                        <span style="font:400 14px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">Gasto diário</span>
                        <span style="font:700 22px/1 'Oswald',sans-serif;color:var(--accent,#d8a32e);"><span x-text="fmt(gasto)"></span> <span style="font:400 12px 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">kcal</span></span>
                    </div>
                    <a href="#contato" style="margin-top:auto;text-align:center;padding:14px;background:var(--accent,#d8a32e);color:#1b2520;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Quero um plano pra minha meta</a>
                    <p style="font:400 11px/1.4 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);margin:12px 0 0;text-align:center;">Estimativa educativa (Mifflin-St Jeor). Não substitui avaliação profissional.</p>
                </div>
            </div>
        </section>
    @endif

    {{-- FAQ --}}
    @if (! empty($trainer->faqs))
        <section style="background:var(--brand-tint-2,#eef0e9);">
            <div style="max-width:780px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);">
                <div style="text-align:center;margin-bottom:40px;">
                    <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--brand-2,#2f7d54);margin-bottom:12px;">Dúvidas frequentes</div>
                    <h2 style="font:700 clamp(30px,4.4vw,46px)/1.05 'Oswald',sans-serif;letter-spacing:.5px;color:#1b2520;margin:0;">Perguntas que sempre recebo</h2>
                </div>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach ($trainer->faqs as $faq)
                        <div x-data="{ o:false }" style="background:#fff;border:1px solid #ece9e0;border-radius:14px;overflow:hidden;">
                            <button type="button" @click="o=!o" style="width:100%;display:flex;justify-content:space-between;align-items:center;gap:14px;padding:18px 22px;background:none;border:none;cursor:pointer;text-align:left;font:600 17px/1.3 'Oswald',sans-serif;color:#1b2520;">
                                {{ $faq['q'] }}
                                <span x-text="o ? '−' : '+'" style="font:700 22px/1 'Oswald',sans-serif;color:var(--brand-2,#2f7d54);flex:0 0 auto;"></span>
                            </button>
                            <div x-show="o" x-cloak style="padding:0 22px 20px;font:400 15px/1.6 'Inter',sans-serif;color:#6b7670;">{{ $faq['a'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CONTATO --}}
    <section id="contato" style="background:var(--brand,#1f4733);">
        <div style="max-width:1180px;margin:0 auto;padding:clamp(60px,8vw,100px) clamp(20px,5vw,24px);display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:clamp(36px,5vw,56px);">
            <div>
                <div style="font:600 14px/1 'Oswald',sans-serif;letter-spacing:2.5px;text-transform:uppercase;color:var(--accent,#d8a32e);margin-bottom:14px;">Vamos começar</div>
                <h2 style="font:700 clamp(32px,4.6vw,52px)/1 'Oswald',sans-serif;letter-spacing:.5px;color:var(--on-brand,#fff);margin:0 0 18px;max-width:14ch;">Agende sua avaliação gratuita</h2>
                <p style="font:400 17px/1.6 'Inter',sans-serif;color:var(--on-brand-muted,#bcd4c5);max-width:42ch;margin:0 0 34px;">Conversa de 30 minutos, sem compromisso. Entendo seus objetivos, faço uma avaliação inicial e monto um plano de ação para você.</p>
                <div style="display:flex;flex-direction:column;gap:18px;">
                    @if ($trainer->studio_name)
                        <div style="display:flex;align-items:center;gap:14px;"><span style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;color:var(--on-brand,#fff);"><x-icon name="pin" size="20" /></span><div><div style="font:600 16px/1.2 'Oswald',sans-serif;color:var(--on-brand,#fff);">{{ $trainer->studio_name }}</div><div style="font:400 14px/1.3 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">{{ $trainer->studio_location }}</div></div></div>
                    @endif
                    @if ($trainer->hours)
                        <div style="display:flex;align-items:center;gap:14px;"><span style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;color:var(--on-brand,#fff);"><x-icon name="clock" size="20" /></span><div><div style="font:600 16px/1.2 'Oswald',sans-serif;color:var(--on-brand,#fff);">{{ $trainer->hours }}</div><div style="font:400 14px/1.3 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">{{ $trainer->response_time }}</div></div></div>
                    @endif
                    @if ($trainer->whatsapp)
                        <a href="{{ $trainer->whatsapp_url }}" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:14px;text-decoration:none;"><span style="width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;color:var(--on-brand,#fff);"><x-icon name="whatsapp" size="20" /></span><div><div style="font:600 16px/1.2 'Oswald',sans-serif;color:var(--on-brand,#fff);">WhatsApp: {{ $trainer->whatsapp_label }}</div><div style="font:400 14px/1.3 'Inter',sans-serif;color:var(--on-brand-muted,#a9c4b3);">{{ $trainer->instagram }}</div></div></a>
                    @endif
                </div>
            </div>

            <div style="background:#fff;border-radius:22px;padding:clamp(24px,4vw,36px);">
                @if (session('lead_sent'))
                    <div style="text-align:center;padding:30px 10px;">
                        <span style="width:64px;height:64px;border-radius:50%;background:var(--brand-tint,#e8f0ea);display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;color:var(--brand-2,#2f7d54);"><x-icon name="check" size="32" sw="2.4" /></span>
                        <h3 style="font:700 26px/1.1 'Oswald',sans-serif;color:#1b2520;margin:0 0 10px;">Recebido! 🎉</h3>
                        <p style="font:400 16px/1.5 'Inter',sans-serif;color:#6b7670;margin:0 auto;max-width:32ch;">Vou te chamar no WhatsApp em até 2 horas para combinar sua avaliação gratuita.</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('lead.store', $trainer) }}">
                        @csrf
                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Nome completo</label>
                        <input name="nome" value="{{ old('nome') }}" placeholder="Seu nome" required style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:4px;outline:none;">
                        @error('nome')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-bottom:10px;">{{ $message }}</div>@enderror
                        <div style="height:14px;"></div>

                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">WhatsApp</label>
                        <input name="whatsapp" value="{{ old('whatsapp') }}" placeholder="(11) 9 0000-0000" required style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:4px;outline:none;">
                        @error('whatsapp')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-bottom:10px;">{{ $message }}</div>@enderror
                        <div style="height:14px;"></div>

                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Seu objetivo</label>
                        <select name="objetivo" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">
                            <option value="">Selecione…</option>
                            @foreach ($objetivos as $val => $lbl)
                                <option value="{{ $val }}" @selected(old('objetivo') === $val)>{{ $lbl }}</option>
                            @endforeach
                        </select>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                            <div>
                                <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Seu nível</label>
                                <select name="nivel" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">
                                    <option value="">Selecione…</option>
                                    @foreach ($niveis as $n)<option value="{{ $n }}" @selected(old('nivel') === $n)>{{ $n }}</option>@endforeach
                                </select>
                            </div>
                            <div>
                                <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Frequência</label>
                                <select name="frequencia" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">
                                    <option value="">Selecione…</option>
                                    @foreach ($frequencias as $fr)<option value="{{ $fr }}" @selected(old('frequencia') === $fr)>{{ $fr }}</option>@endforeach
                                </select>
                            </div>
                        </div>

                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Onde pretende treinar</label>
                        <select name="local" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">
                            <option value="">Selecione…</option>
                            @foreach ($locais as $lo)<option value="{{ $lo }}" @selected(old('local') === $lo)>{{ $lo }}</option>@endforeach
                        </select>

                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Lesões ou restrições (opcional)</label>
                        <input name="restricoes" value="{{ old('restricoes') }}" placeholder="Ex.: dor no joelho, hérnia de disco…" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:18px;outline:none;">

                        <label style="display:block;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#6b7670;margin-bottom:8px;">Mensagem (opcional)</label>
                        <textarea name="msg" rows="3" placeholder="Conte um pouco sobre sua rotina" style="width:100%;padding:14px 16px;border:1.5px solid #e0ddd3;border-radius:12px;font:400 16px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;margin-bottom:22px;outline:none;resize:vertical;">{{ old('msg') }}</textarea>

                        <button type="submit" style="width:100%;padding:17px;background:var(--brand,#1f4733);color:var(--on-brand,#fff);border:none;border-radius:999px;font:600 15px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:9px;">
                            @if ($trainer->whatsapp)<x-icon name="whatsapp" size="18" /> Agendar pelo WhatsApp @else Quero minha avaliação gratuita @endif
                        </button>
                        @if ($trainer->whatsapp)
                            <p style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin:12px 0 0;text-align:center;">Abrimos o WhatsApp com seus dados já preenchidos — é só tocar em enviar.</p>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    </section>

    {{-- FOOTER (segue a cor da marca; marca PersonalBio só no plano Grátis) --}}
    <footer style="background:var(--brand-dark,#16341f);color:var(--on-brand-muted,#a9c4b3);">
        <div style="max-width:1180px;margin:0 auto;padding:38px clamp(20px,5vw,24px);display:flex;flex-wrap:wrap;align-items:center;gap:18px;justify-content:space-between;">
            @if ($showBranding)
                <x-logo variant="footer" :href="route('home')" />
                <div style="font:400 13px/1.5 'Inter',sans-serif;color:var(--on-brand-muted,#88a594);max-width:40ch;">Este é um perfil profissional hospedado em PersonalBio — a plataforma que conecta você ao personal certo.</div>
            @else
                <span style="font:700 20px/1 'Oswald',sans-serif;color:var(--on-brand,#fff);letter-spacing:.3px;">{{ $trainer->brand_name_label }}</span>
            @endif
            <div style="display:flex;gap:18px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;">
                <a href="{{ route('profile.bio', $trainer) }}" style="color:var(--on-brand-muted,#a9c4b3);text-decoration:none;">Versão link na bio</a>
                @if ($showBranding)
                    <a href="{{ route('home') }}#planos" style="color:var(--on-brand-muted,#a9c4b3);text-decoration:none;">Para profissionais</a>
                @endif
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,.12);padding:16px;text-align:center;font:400 12px/1 'Inter',sans-serif;color:var(--on-brand-muted,#6f8a7b);">© {{ date('Y') }} @if($showBranding)PersonalBio · @endif{{ $trainer->name }}@if($trainer->cref) · {{ $trainer->cref }}@endif</div>
    </footer>

</div>
</x-layout>
