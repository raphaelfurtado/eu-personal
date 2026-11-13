@php
    $icons = [
        'pulse' => 'Atividade', 'chart' => 'Gráfico', 'chat' => 'Balão',
        'shield-check' => 'Escudo', 'heart' => 'Coração', 'clock' => 'Relógio',
        'code' => 'Código', 'bars' => 'Barras',
    ];
    $linkIcons = [
        'link' => 'Site / link', 'instagram' => 'Instagram', 'whatsapp' => 'WhatsApp',
        'youtube' => 'YouTube', 'bag' => 'Loja', 'play' => 'Vídeo', 'chat' => 'Mensagem', 'heart' => 'Outro',
    ];
    $features = old('about_features', $trainer->about_features ?? []);
    $stats = old('stats', $trainer->stats ?? []);
    $statRows = max(4, count($stats));
    $faqs = old('faqs', $trainer->faqs ?? []);
    $faqRows = max(4, count($faqs));
    $specialtyOptions = ['Emagrecimento', 'Hipertrofia', 'Condicionamento', 'Funcional', 'Treino para idosos', 'Gestantes', 'Pós-reabilitação', 'Corrida', 'Força', 'Mobilidade'];
    $formatOptions = ['Presencial', 'Online', 'Domicílio'];
    $mySpecialties = old('specialties', $trainer->specialties ?? []);
    $myFormats = old('formats', $trainer->formats ?? []);
    $inputSt = "width:100%;padding:13px 15px;border:1.5px solid #e0ddd3;border-radius:11px;font:400 15px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;outline:none;";
    $labelSt = "display:block;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:#6b7670;margin-bottom:7px;";
@endphp
<x-dashboard-layout title="Editar perfil" active="profile">
    <h1 style="font:700 clamp(28px,4vw,38px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 24px;">Editar perfil</h1>

    {{-- ===== FORM PRINCIPAL ===== --}}
    <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- APARÊNCIA: cor + logo --}}
        <x-card title="Aparência" desc="Escolha a cor principal da sua marca e o logo. A cor vale no site inteiro; o texto ajusta o contraste automaticamente.">
            <div x-data="{ c: '{{ old('accent_color', $trainer->accent_color) }}', onBrand() { const h = this.c.replace('#',''); if (h.length < 6) return '#fff'; const r=parseInt(h.slice(0,2),16), g=parseInt(h.slice(2,4),16), b=parseInt(h.slice(4,6),16); return (0.2126*r+0.7152*g+0.0722*b)/255 > 0.6 ? '#15211b' : '#fff'; } }" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px;">
                <div>
                    <label style="{{ $labelSt }}">Cor principal (sua marca)</label>
                    <div style="display:flex;align-items:center;gap:14px;">
                        <input type="color" name="accent_color" x-model="c" style="width:56px;height:48px;border:1.5px solid #e0ddd3;border-radius:12px;background:#fff;cursor:pointer;padding:3px;">
                        <span x-text="c" style="font:600 16px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#1b2520;"></span>
                    </div>
                    <div style="margin-top:14px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                        <span style="display:inline-flex;padding:11px 20px;border-radius:999px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;" :style="`background:${c};color:${onBrand()}`">Botão</span>
                        <span style="display:inline-flex;align-items:center;padding:11px 16px;border-radius:10px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;" :style="`background:${c};color:${onBrand()}`">Seção do site</span>
                    </div>
                    @error('accent_color')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:8px;">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label style="{{ $labelSt }}">Logo (opcional)</label>
                    @if ($trainer->logo_url)
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:10px;">
                            <img src="{{ $trainer->logo_url }}" alt="logo" style="height:44px;width:auto;max-width:150px;object-fit:contain;background:#f5f4ef;border:1px solid #ece9e0;border-radius:8px;padding:4px 8px;">
                            <label style="font:400 13px 'Inter',sans-serif;color:#6b7670;cursor:pointer;"><input type="checkbox" name="remove_logo" value="1" style="accent-color:#1f4733;"> remover</label>
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" style="font:400 13px 'Inter',sans-serif;color:#4a564f;">
                    <div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin-top:6px;">Sem logo, mostramos o nome da marca. PNG/SVG com fundo transparente fica melhor.</div>
                    @unless ($trainer->planAllows('custom_logo'))
                        <div style="font:600 12px/1.4 'Inter',sans-serif;color:#8a6512;background:#f6ecd2;border-radius:8px;padding:8px 11px;margin-top:8px;">🔒 Logo próprio é um recurso do plano <strong>Pro</strong> — no Grátis, exibimos o nome da marca. <a href="{{ route('dashboard.index') }}" style="color:#8a6512;">Fazer upgrade</a></div>
                    @endunless
                    @error('logo')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:5px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="margin-top:8px;">
                <x-field label="Nome da marca (cabeçalho do site)" name="brand_name" :value="$trainer->brand_name" placeholder="Ex.: Marina Lacerda" hint="Texto exibido se você não enviar um logo." />
            </div>

            <div style="margin-top:18px;border-top:1px dashed #e0ddd3;padding-top:18px;">
                <label style="{{ $labelSt }}">Fundo da página "link na bio" (opcional)</label>
                @if ($trainer->bio_bg_image_url)
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:10px;">
                        <img src="{{ $trainer->bio_bg_image_url }}" alt="fundo da bio" style="height:64px;width:auto;max-width:120px;object-fit:cover;border:1px solid #ece9e0;border-radius:10px;">
                        <label style="font:400 13px 'Inter',sans-serif;color:#6b7670;cursor:pointer;"><input type="checkbox" name="remove_bio_bg" value="1" style="accent-color:#1f4733;"> remover</label>
                    </div>
                @endif
                <input type="file" name="bio_bg_image" accept="image/*" style="font:400 13px 'Inter',sans-serif;color:#4a564f;">
                <div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin-top:6px;">Sem foto, a /bio usa a cor da marca cheia. Com foto, escurecemos automaticamente pra manter o texto legível.</div>
                @error('bio_bg_image')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:5px;">{{ $message }}</div>@enderror
            </div>
        </x-card>

        {{-- IDENTIDADE --}}
        <x-card title="Identidade">
            <div style="margin-bottom:16px;">
                <label style="{{ $labelSt }}">Seu link (endereço do seu site)</label>
                <div style="display:flex;align-items:stretch;border:1.5px solid #e0ddd3;border-radius:11px;overflow:hidden;background:#faf9f5;">
                    <span style="display:flex;align-items:center;padding:0 12px;background:#efece3;color:#8a9690;font:600 14px/1 'Inter',sans-serif;white-space:nowrap;">personalbio.com.br/</span>
                    <input name="slug" value="{{ old('slug', $trainer->slug) }}" required style="flex:1;border:none;background:#faf9f5;padding:13px 14px;font:400 15px 'Inter',sans-serif;color:#1b2520;outline:none;">
                </div>
                <div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin-top:6px;">Use letras minúsculas, números e hífen. Precisa ser único — se já existir, escolha outro (ex.: <em>raphael-furtado-rj</em>).</div>
                @error('slug')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:6px;">{{ $message }}</div>@enderror
            </div>
            <x-field label="Nome" name="name" :value="$trainer->name" :required="true" />
            <div style="display:grid;grid-template-columns:2fr 2fr 1fr;gap:14px;">
                <x-field label="Função" name="role" :value="$trainer->role" placeholder="Personal Trainer" />
                <x-field label="Cidade" name="city" :value="$trainer->city" />
                <x-field label="UF" name="state" :value="$trainer->state" placeholder="SP" />
            </div>
            <x-field label="CREF / credencial" name="cref" :value="$trainer->cref" placeholder="CREF 000000-G/SP" />
            <label style="display:flex;align-items:center;gap:9px;font:400 14px 'Inter',sans-serif;color:#4a564f;margin:4px 0 16px;cursor:pointer;">
                <input type="checkbox" name="verified" value="1" @checked(old('verified', $trainer->verified)) style="width:16px;height:16px;accent-color:#1f4733;"> Exibir selo de profissional verificada
            </label>
            <x-field label="Frase de apresentação (hero)" name="tagline" type="textarea" :value="$trainer->tagline" />
        </x-card>

        {{-- FOTO PRINCIPAL --}}
        <x-card title="Foto principal">
            <div style="display:flex;align-items:flex-start;gap:18px;flex-wrap:wrap;">
                @if ($trainer->hero_photo_url)
                    <div>
                        <img src="{{ $trainer->hero_photo_url }}" alt="hero" style="width:90px;height:112px;object-fit:cover;border-radius:12px;border:1px solid #ece9e0;">
                        <label style="display:block;font:400 13px 'Inter',sans-serif;color:#6b7670;cursor:pointer;margin-top:6px;"><input type="checkbox" name="remove_hero" value="1" style="accent-color:#1f4733;"> remover</label>
                    </div>
                @endif
                <div style="flex:1;min-width:200px;">
                    <input type="file" name="hero_photo" accept="image/*" style="font:400 13px 'Inter',sans-serif;color:#4a564f;">
                    <div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin-top:6px;">Foto vertical (proporção ~4:5) funciona melhor.</div>
                    @error('hero_photo')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:5px;">{{ $message }}</div>@enderror
                </div>
            </div>
        </x-card>

        {{-- NÚMEROS DO TOPO --}}
        <x-card title="Números do topo" desc="Aparecem ao lado do seu nome e nos cards flutuantes.">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:14px;">
                <x-field label="Nota (0–5)" name="rating" :value="$trainer->rating" placeholder="4.9" />
                <x-field label="Nº de avaliações" name="rating_count" :value="$trainer->rating_count" />
                <x-field label="Anos de prática" name="years" :value="$trainer->years" />
                <x-field label="Alunos" name="students" :value="$trainer->students" placeholder="300+" />
                <x-field label="% que atinge a meta" name="goal_rate" :value="$trainer->goal_rate" placeholder="94%" />
                <x-field label="Sessões conduzidas" name="sessions" :value="$trainer->sessions" placeholder="12k+" />
            </div>
        </x-card>

        {{-- SOBRE --}}
        <x-card title="Sobre você">
            <x-field label="Título da seção" name="about_title" :value="$trainer->about_title" />
            <x-field label="Parágrafo 1" name="about_p1" type="textarea" :value="$trainer->about_p1" />
            <x-field label="Parágrafo 2" name="about_p2" type="textarea" :value="$trainer->about_p2" />

            <label style="{{ $labelSt }}">Foto de bastidores</label>
            <div style="display:flex;align-items:flex-start;gap:18px;flex-wrap:wrap;margin-bottom:22px;">
                @if ($trainer->about_photo_url)
                    <div>
                        <img src="{{ $trainer->about_photo_url }}" alt="sobre" style="width:96px;height:96px;object-fit:cover;border-radius:12px;border:1px solid #ece9e0;">
                        <label style="display:block;font:400 13px 'Inter',sans-serif;color:#6b7670;cursor:pointer;margin-top:6px;"><input type="checkbox" name="remove_about" value="1" style="accent-color:#1f4733;"> remover</label>
                    </div>
                @endif
                <div style="flex:1;min-width:200px;"><input type="file" name="about_photo" accept="image/*" style="font:400 13px 'Inter',sans-serif;color:#4a564f;">@error('about_photo')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:5px;">{{ $message }}</div>@enderror</div>
            </div>

            <label style="{{ $labelSt }}">Diferenciais (3)</label>
            @for ($i = 0; $i < 3; $i++)
                <div style="display:grid;grid-template-columns:130px 1fr;gap:10px;margin-bottom:10px;">
                    <select name="about_features[{{ $i }}][icon]" style="{{ $inputSt }}">
                        @foreach ($icons as $key => $lbl)
                            <option value="{{ $key }}" @selected(($features[$i]['icon'] ?? 'pulse') === $key)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                    <div>
                        <input name="about_features[{{ $i }}][title]" value="{{ $features[$i]['title'] ?? '' }}" placeholder="Título do diferencial" style="{{ $inputSt }}margin-bottom:8px;">
                        <input name="about_features[{{ $i }}][body]" value="{{ $features[$i]['body'] ?? '' }}" placeholder="Descrição curta" style="{{ $inputSt }}">
                    </div>
                </div>
            @endfor
        </x-card>

        {{-- STATS --}}
        <x-card title="Faixa de números" desc="A faixa verde com seus destaques. Deixe em branco para ocultar uma linha.">
            <label style="display:flex;align-items:center;gap:9px;font:400 14px 'Inter',sans-serif;color:#4a564f;margin-bottom:18px;cursor:pointer;">
                <input type="checkbox" name="show_stats" value="1" @checked(old('show_stats', $trainer->show_stats)) style="width:16px;height:16px;accent-color:#1f4733;"> Mostrar a faixa de números no site
            </label>
            @for ($i = 0; $i < $statRows; $i++)
                <div style="display:grid;grid-template-columns:140px 1fr;gap:10px;margin-bottom:10px;">
                    <input name="stats[{{ $i }}][num]" value="{{ $stats[$i]['num'] ?? '' }}" placeholder="Ex.: 300+" style="{{ $inputSt }}">
                    <input name="stats[{{ $i }}][label]" value="{{ $stats[$i]['label'] ?? '' }}" placeholder="Ex.: Alunos transformados" style="{{ $inputSt }}">
                </div>
            @endfor
        </x-card>

        {{-- CONTATO --}}
        <x-card title="Contato">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <x-field label="WhatsApp (com DDI/DDD, só dígitos)" name="whatsapp" :value="$trainer->whatsapp" placeholder="5511999990000" hint="Usado no botão e no link wa.me." />
                <x-field label="WhatsApp (texto exibido)" name="whatsapp_label" :value="$trainer->whatsapp_label" placeholder="(11) 9 9999-0000" />
            </div>
            <x-field label="Instagram" name="instagram" :value="$trainer->instagram" placeholder="@seu.perfil" />
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                <x-field label="TikTok (link)" name="tiktok" :value="$trainer->tiktok" placeholder="tiktok.com/@voce" />
                <x-field label="YouTube (link)" name="youtube" :value="$trainer->youtube" placeholder="youtube.com/@voce" />
                <x-field label="X / Twitter (link)" name="twitter" :value="$trainer->twitter" placeholder="x.com/voce" />
            </div>
            <div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin:-4px 0 6px;">Instagram, WhatsApp e estes aparecem como ícones na sua página <strong>/bio</strong>.</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <x-field label="Estúdio / local" name="studio_name" :value="$trainer->studio_name" />
                <x-field label="Abrangência" name="studio_location" :value="$trainer->studio_location" placeholder="Presencial e online" />
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <x-field label="Horário" name="hours" :value="$trainer->hours" placeholder="Seg a Sáb · 6h às 21h" />
                <x-field label="Tempo de resposta" name="response_time" :value="$trainer->response_time" placeholder="Resposta em até 2 horas" />
            </div>
        </x-card>

        {{-- ESPECIALIDADES + FERRAMENTAS --}}
        <x-card title="Especialidades & atendimento" desc="Aparecem como etiquetas no topo do seu perfil.">
            <label style="{{ $labelSt }}">Especialidades</label>
            <div style="display:flex;flex-wrap:wrap;gap:9px;margin-bottom:20px;">
                @foreach ($specialtyOptions as $opt)
                    <label style="display:inline-flex;align-items:center;gap:7px;font:400 14px 'Inter',sans-serif;color:#3a463f;background:#faf9f5;border:1.5px solid #e0ddd3;border-radius:10px;padding:9px 12px;cursor:pointer;">
                        <input type="checkbox" name="specialties[]" value="{{ $opt }}" @checked(in_array($opt, $mySpecialties)) style="accent-color:#1f4733;"> {{ $opt }}
                    </label>
                @endforeach
            </div>
            <label style="{{ $labelSt }}">Formato de atendimento</label>
            <div style="display:flex;flex-wrap:wrap;gap:9px;">
                @foreach ($formatOptions as $opt)
                    <label style="display:inline-flex;align-items:center;gap:7px;font:400 14px 'Inter',sans-serif;color:#3a463f;background:#faf9f5;border:1.5px solid #e0ddd3;border-radius:10px;padding:9px 12px;cursor:pointer;">
                        <input type="checkbox" name="formats[]" value="{{ $opt }}" @checked(in_array($opt, $myFormats)) style="accent-color:#1f4733;"> {{ $opt }}
                    </label>
                @endforeach
            </div>
            <label style="display:flex;align-items:center;gap:9px;font:400 14px 'Inter',sans-serif;color:#4a564f;margin-top:20px;cursor:pointer;">
                <input type="checkbox" name="show_calculator" value="1" @checked(old('show_calculator', $trainer->show_calculator)) style="width:16px;height:16px;accent-color:#1f4733;"> Mostrar a calculadora de IMC / gasto calórico no site
            </label>
        </x-card>

        {{-- FAQ --}}
        <x-card title="Perguntas frequentes (FAQ)" desc="Quebram objeções antes do contato. Linhas em branco são ocultadas.">
            @for ($i = 0; $i < $faqRows; $i++)
                <div style="margin-bottom:14px;">
                    <input name="faqs[{{ $i }}][q]" value="{{ $faqs[$i]['q'] ?? '' }}" placeholder="Pergunta (ex.: Você atende online?)" style="{{ $inputSt }}margin-bottom:8px;">
                    <textarea name="faqs[{{ $i }}][a]" rows="2" placeholder="Resposta" style="{{ $inputSt }}resize:vertical;">{{ $faqs[$i]['a'] ?? '' }}</textarea>
                </div>
            @endfor
        </x-card>

        <div style="position:sticky;bottom:0;background:linear-gradient(180deg,rgba(245,244,239,0),#f5f4ef 40%);padding:16px 0;margin-top:-6px;">
            <button type="submit" style="padding:16px 34px;background:#1f4733;color:#fff;border:none;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;cursor:pointer;">Salvar alterações</button>
        </div>
    </form>

    {{-- ===== QUALIFICAÇÕES ===== --}}
    <x-card title="Qualificações" desc="Formação e certificações exibidas no seu perfil." id="qualificacoes">
        @foreach ($trainer->certifications as $c)
            <form method="POST" action="{{ route('dashboard.certs.update', $c) }}" style="display:grid;grid-template-columns:2fr 2fr 1fr auto auto;gap:10px;align-items:center;margin-bottom:10px;">
                @csrf
                <input name="title" value="{{ $c->title }}" placeholder="Título" required style="{{ $inputSt }}">
                <input name="issuer" value="{{ $c->issuer }}" placeholder="Instituição" style="{{ $inputSt }}">
                <input name="year" value="{{ $c->year }}" placeholder="Ano" style="{{ $inputSt }}">
                <button type="submit" style="padding:12px 16px;background:#e8f0ea;color:#1f4733;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Salvar</button>
        </form>
            <form method="POST" action="{{ route('dashboard.certs.destroy', $c) }}" onsubmit="return confirm('Remover esta qualificação?')" style="margin:-10px 0 14px;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;">Remover</button>
            </form>
        @endforeach

        <div style="border-top:1px dashed #e0ddd3;margin-top:8px;padding-top:18px;">
            <label style="{{ $labelSt }}">Adicionar qualificação</label>
            <form method="POST" action="{{ route('dashboard.certs.store') }}" style="display:grid;grid-template-columns:2fr 2fr 1fr auto;gap:10px;align-items:center;">
                @csrf
                <input name="title" placeholder="Título" required style="{{ $inputSt }}">
                <input name="issuer" placeholder="Instituição" style="{{ $inputSt }}">
                <input name="year" placeholder="Ano" style="{{ $inputSt }}">
                <button type="submit" style="padding:12px 18px;background:#1f4733;color:#fff;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Adicionar</button>
            </form>
        </div>
    </x-card>

    {{-- ===== RESULTADOS ===== --}}
    <x-card title="Resultados (antes/depois)" desc="Transformações exibidas no seu perfil." id="resultados">
        @foreach ($trainer->results as $r)
            <form method="POST" action="{{ route('dashboard.results.update', $r) }}" enctype="multipart/form-data" style="border:1px solid #ece9e0;border-radius:14px;padding:16px;margin-bottom:14px;">
                @csrf
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:10px;margin-bottom:10px;">
                    <input name="student_name" value="{{ $r->student_name }}" placeholder="Aluno, idade" required style="{{ $inputSt }}">
                    <input name="duration" value="{{ $r->duration }}" placeholder="Duração (ex.: 6 meses)" style="{{ $inputSt }}">
                </div>
                <input name="tags" value="{{ implode(', ', $r->tags ?? []) }}" placeholder="Tags separadas por vírgula: −14 kg, −9% gordura" style="{{ $inputSt }}margin-bottom:10px;">
                <textarea name="quote" rows="2" placeholder="Depoimento" style="{{ $inputSt }}resize:vertical;margin-bottom:10px;">{{ $r->quote }}</textarea>
                <div style="display:flex;gap:18px;flex-wrap:wrap;align-items:center;margin-bottom:12px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if ($r->before_photo_url)<img src="{{ $r->before_photo_url }}" style="width:48px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #ece9e0;">@endif
                        <div><div style="font:600 10px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;margin-bottom:4px;">Antes</div><input type="file" name="before_photo" accept="image/*" style="font:400 12px 'Inter',sans-serif;color:#4a564f;max-width:170px;"></div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if ($r->after_photo_url)<img src="{{ $r->after_photo_url }}" style="width:48px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #ece9e0;">@endif
                        <div><div style="font:600 10px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;margin-bottom:4px;">Depois</div><input type="file" name="after_photo" accept="image/*" style="font:400 12px 'Inter',sans-serif;color:#4a564f;max-width:170px;"></div>
                    </div>
                </div>
                <button type="submit" style="padding:11px 18px;background:#e8f0ea;color:#1f4733;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Salvar</button>
            </form>
            <form method="POST" action="{{ route('dashboard.results.destroy', $r) }}" onsubmit="return confirm('Remover este resultado?')" style="margin:-8px 0 18px;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;">Remover</button>
            </form>
        @endforeach

        <div style="border-top:1px dashed #e0ddd3;margin-top:8px;padding-top:18px;">
            <label style="{{ $labelSt }}">Adicionar resultado</label>
            <form method="POST" action="{{ route('dashboard.results.store') }}" enctype="multipart/form-data">
                @csrf
                <div style="display:grid;grid-template-columns:2fr 1fr;gap:10px;margin-bottom:10px;">
                    <input name="student_name" placeholder="Aluno, idade" required style="{{ $inputSt }}">
                    <input name="duration" placeholder="Duração" style="{{ $inputSt }}">
                </div>
                <input name="tags" placeholder="Tags separadas por vírgula" style="{{ $inputSt }}margin-bottom:10px;">
                <textarea name="quote" rows="2" placeholder="Depoimento" style="{{ $inputSt }}resize:vertical;margin-bottom:10px;"></textarea>
                <div style="display:flex;gap:18px;flex-wrap:wrap;margin-bottom:12px;">
                    <div><div style="font:600 10px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;margin-bottom:4px;">Antes</div><input type="file" name="before_photo" accept="image/*" style="font:400 12px 'Inter',sans-serif;color:#4a564f;max-width:170px;"></div>
                    <div><div style="font:600 10px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;margin-bottom:4px;">Depois</div><input type="file" name="after_photo" accept="image/*" style="font:400 12px 'Inter',sans-serif;color:#4a564f;max-width:170px;"></div>
                </div>
                <button type="submit" style="padding:12px 20px;background:#1f4733;color:#fff;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Adicionar resultado</button>
            </form>
        </div>
    </x-card>

    {{-- ===== MEUS LINKS ===== --}}
    <x-card title="Meus links" desc="Botões estilo Linktree exibidos no topo do seu perfil." id="links">
        @foreach ($trainer->links as $link)
            <form method="POST" action="{{ route('dashboard.links.update', $link) }}" style="display:grid;grid-template-columns:150px 1.4fr 2fr auto;gap:10px;align-items:center;margin-bottom:10px;">
                @csrf
                <select name="icon" style="{{ $inputSt }}">
                    @foreach ($linkIcons as $key => $lbl)<option value="{{ $key }}" @selected(($link->icon ?: 'link') === $key)>{{ $lbl }}</option>@endforeach
                </select>
                <input name="label" value="{{ $link->label }}" placeholder="Texto do botão" required style="{{ $inputSt }}">
                <input name="url" value="{{ $link->url }}" placeholder="https://…" required style="{{ $inputSt }}">
                <button type="submit" style="padding:12px 16px;background:#e8f0ea;color:#1f4733;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Salvar</button>
            </form>
            <form method="POST" action="{{ route('dashboard.links.destroy', $link) }}" onsubmit="return confirm('Remover este link?')" style="margin:-10px 0 14px;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;">Remover</button>
            </form>
        @endforeach

        <div style="border-top:1px dashed #e0ddd3;margin-top:8px;padding-top:18px;">
            <label style="{{ $labelSt }}">Adicionar link</label>
            <form method="POST" action="{{ route('dashboard.links.store') }}" style="display:grid;grid-template-columns:150px 1.4fr 2fr auto;gap:10px;align-items:center;">
                @csrf
                <select name="icon" style="{{ $inputSt }}">
                    @foreach ($linkIcons as $key => $lbl)<option value="{{ $key }}">{{ $lbl }}</option>@endforeach
                </select>
                <input name="label" placeholder="Texto do botão (ex.: Treino online)" required style="{{ $inputSt }}">
                <input name="url" placeholder="https://… ou @seu_usuario" required style="{{ $inputSt }}">
                <button type="submit" style="padding:12px 18px;background:#1f4733;color:#fff;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Adicionar</button>
            </form>
        </div>
    </x-card>

    {{-- ===== PLANOS / PACOTES ===== --}}
    <x-card title="Planos & pacotes" desc="O que você vende e por quanto. Aparece na seção 'Planos' do seu perfil; o botão abre o WhatsApp com a mensagem pronta." id="pacotes">
        @foreach ($trainer->packages as $pkg)
            <form method="POST" action="{{ route('dashboard.packages.update', $pkg) }}" style="border:1px solid #ece9e0;border-radius:14px;padding:16px;margin-bottom:14px;">
                @csrf
                <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:10px;margin-bottom:10px;">
                    <input name="name" value="{{ $pkg->name }}" placeholder="Nome do plano" required style="{{ $inputSt }}">
                    <input name="price" value="{{ $pkg->price }}" placeholder="R$ 39" style="{{ $inputSt }}">
                    <input name="period" value="{{ $pkg->period }}" placeholder="/mês" style="{{ $inputSt }}">
                </div>
                <textarea name="items" rows="3" placeholder="O que inclui — um item por linha" style="{{ $inputSt }}resize:vertical;margin-bottom:10px;">{{ implode("\n", $pkg->items ?? []) }}</textarea>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                    <label style="display:inline-flex;align-items:center;gap:8px;font:400 14px 'Inter',sans-serif;color:#4a564f;cursor:pointer;"><input type="checkbox" name="featured" value="1" @checked($pkg->featured) style="accent-color:#1f4733;"> Destacar como "mais procurado"</label>
                    <div style="display:flex;gap:14px;align-items:center;">
                        <button type="submit" style="padding:12px 16px;background:#e8f0ea;color:#1f4733;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Salvar</button>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{ route('dashboard.packages.destroy', $pkg) }}" onsubmit="return confirm('Remover este plano?')" style="margin:-10px 0 16px;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;">Remover</button>
            </form>
        @endforeach

        <div style="border-top:1px dashed #e0ddd3;margin-top:8px;padding-top:18px;">
            <label style="{{ $labelSt }}">Adicionar plano</label>
            <form method="POST" action="{{ route('dashboard.packages.store') }}">
                @csrf
                <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:10px;margin-bottom:10px;">
                    <input name="name" placeholder="Nome do plano (ex.: Online)" required style="{{ $inputSt }}">
                    <input name="price" placeholder="R$ 39" style="{{ $inputSt }}">
                    <input name="period" placeholder="/mês" style="{{ $inputSt }}">
                </div>
                <textarea name="items" rows="3" placeholder="O que inclui — um item por linha" style="{{ $inputSt }}resize:vertical;margin-bottom:10px;"></textarea>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                    <label style="display:inline-flex;align-items:center;gap:8px;font:400 14px 'Inter',sans-serif;color:#4a564f;cursor:pointer;"><input type="checkbox" name="featured" value="1" style="accent-color:#1f4733;"> Destacar como "mais procurado"</label>
                    <button type="submit" style="padding:12px 18px;background:#1f4733;color:#fff;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Adicionar</button>
                </div>
            </form>
        </div>
    </x-card>

    {{-- ===== NA VOZ DOS ALUNOS (prints) ===== --}}
    @php $tMax = $trainer->planLimit('testimonials'); $tCount = $trainer->testimonials->count(); @endphp
    <x-card title="Na voz dos alunos (prints)" desc="Prints de conversas/depoimentos de alunos (ex.: WhatsApp). Aparecem num carrossel no seu perfil." id="depoimentos">
        @if ($trainer->testimonials->isNotEmpty())
            <div style="display:flex;flex-wrap:wrap;gap:14px;margin-bottom:18px;">
                @foreach ($trainer->testimonials as $t)
                    <div style="position:relative;">
                        <img src="{{ $t->image_url }}" alt="print" style="height:150px;width:auto;border-radius:10px;border:1px solid #ece9e0;display:block;background:#fff;">
                        <form method="POST" action="{{ route('dashboard.testimonials.destroy', $t) }}" onsubmit="return confirm('Remover este print?')" style="position:absolute;top:6px;right:6px;margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" title="Remover" style="width:28px;height:28px;border-radius:50%;background:rgba(27,37,32,.8);color:#fff;border:none;cursor:pointer;font:700 15px/1 'Inter',sans-serif;">×</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($tMax === null || $tCount < $tMax)
            <div style="border-top:1px dashed #e0ddd3;padding-top:18px;">
                <label style="{{ $labelSt }}">Adicionar print ({{ $tCount }}/{{ $tMax ?? '∞' }})</label>
                <form method="POST" action="{{ route('dashboard.testimonials.store') }}" enctype="multipart/form-data" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                    @csrf
                    <input type="file" name="image" accept="image/*" required style="font:400 13px 'Inter',sans-serif;color:#4a564f;">
                    <button type="submit" style="padding:12px 18px;background:#1f4733;color:#fff;border:none;border-radius:11px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;cursor:pointer;">Enviar print</button>
                </form>
                @error('image')<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:8px;">{{ $message }}</div>@enderror
            </div>
        @else
            <div style="font:400 13px/1.5 'Inter',sans-serif;color:#8a9690;">Limite de {{ $tMax }} prints do plano {{ $trainer->plan_label }} atingido. Remova um, ou faça upgrade na <a href="{{ route('dashboard.index') }}" style="color:#1f4733;font-weight:600;">Visão geral</a>.</div>
        @endif
    </x-card>
</x-dashboard-layout>
