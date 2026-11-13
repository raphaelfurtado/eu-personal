<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\HandlesPhotoUploads;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    use HandlesPhotoUploads;

    /** Slugs que colidiriam com rotas do sistema. */
    private const RESERVED_SLUGS = [
        'painel', 'entrar', 'cadastrar', 'sair', 'dashboard', 'login', 'register',
        'up', 'storage', 'admin', 'api', 'bio', 'lead', 'home',
    ];

    public function edit(Request $request)
    {
        return view('dashboard.profile', [
            'trainer' => $request->user()->trainer,
        ]);
    }

    public function update(Request $request)
    {
        $trainer = $request->user()->trainer;

        // Normaliza o link antes de validar (minúsculo, sem espaço/acento)
        $request->merge(['slug' => Str::slug((string) $request->input('slug'))]);

        $data = $request->validate([
            'slug'            => ['required', 'string', 'min:3', 'max:60', 'regex:/^[a-z0-9-]+$/', Rule::notIn(self::RESERVED_SLUGS), Rule::unique('trainers', 'slug')->ignore($trainer->id)],
            'name'            => ['required', 'string', 'max:120'],
            'role'            => ['nullable', 'string', 'max:60'],
            'city'            => ['nullable', 'string', 'max:80'],
            'state'           => ['nullable', 'string', 'max:2'],
            'cref'            => ['nullable', 'string', 'max:60'],
            'verified'        => ['nullable', 'boolean'],
            'tagline'         => ['nullable', 'string', 'max:600'],

            'rating'          => ['nullable', 'numeric', 'between:0,5'],
            'rating_count'    => ['nullable', 'integer', 'min:0'],
            'years'           => ['nullable', 'integer', 'min:0', 'max:80'],
            'students'        => ['nullable', 'string', 'max:20'],
            'goal_rate'       => ['nullable', 'string', 'max:20'],
            'sessions'        => ['nullable', 'string', 'max:20'],

            'about_title'     => ['nullable', 'string', 'max:160'],
            'about_p1'        => ['nullable', 'string', 'max:1200'],
            'about_p2'        => ['nullable', 'string', 'max:1200'],
            'about_features'  => ['nullable', 'array'],
            'about_features.*.icon'  => ['nullable', 'string', 'max:30'],
            'about_features.*.title' => ['nullable', 'string', 'max:80'],
            'about_features.*.body'  => ['nullable', 'string', 'max:240'],

            'stats'           => ['nullable', 'array'],
            'stats.*.num'     => ['nullable', 'string', 'max:20'],
            'stats.*.label'   => ['nullable', 'string', 'max:60'],
            'show_stats'      => ['nullable', 'boolean'],

            'specialties'     => ['nullable', 'array'],
            'specialties.*'   => ['string', 'max:40'],
            'formats'         => ['nullable', 'array'],
            'formats.*'       => ['string', 'max:30'],
            'faqs'            => ['nullable', 'array'],
            'faqs.*.q'        => ['nullable', 'string', 'max:160'],
            'faqs.*.a'        => ['nullable', 'string', 'max:600'],
            'show_calculator' => ['nullable', 'boolean'],

            'whatsapp'        => ['nullable', 'string', 'max:40'],
            'whatsapp_label'  => ['nullable', 'string', 'max:40'],
            'instagram'       => ['nullable', 'string', 'max:60'],
            'tiktok'          => ['nullable', 'string', 'max:255'],
            'youtube'         => ['nullable', 'string', 'max:255'],
            'twitter'         => ['nullable', 'string', 'max:255'],
            'studio_name'     => ['nullable', 'string', 'max:120'],
            'studio_location' => ['nullable', 'string', 'max:120'],
            'hours'           => ['nullable', 'string', 'max:80'],
            'response_time'   => ['nullable', 'string', 'max:80'],

            'accent_color'    => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'brand_name'      => ['nullable', 'string', 'max:60'],

            'logo'            => ['nullable', 'image', 'max:4096'],
            'hero_photo'      => ['nullable', 'image', 'max:6144'],
            'about_photo'     => ['nullable', 'image', 'max:6144'],
            'bio_bg_image'    => ['nullable', 'image', 'max:6144'],
        ]);

        // Campos simples
        foreach ([
            'slug', 'name', 'role', 'city', 'state', 'cref', 'tagline',
            'rating', 'rating_count', 'years', 'students', 'goal_rate', 'sessions',
            'about_title', 'about_p1', 'about_p2',
            'whatsapp', 'whatsapp_label', 'instagram', 'tiktok', 'youtube', 'twitter',
            'studio_name', 'studio_location',
            'hours', 'response_time', 'accent_color', 'brand_name',
        ] as $f) {
            $trainer->$f = $data[$f] ?? null;
        }

        // Colunas NOT NULL: garante valor mesmo se o campo vier vazio
        $trainer->role         = $trainer->role ?: 'Personal Trainer';
        $trainer->rating_count = $trainer->rating_count ?? 0;
        $trainer->years        = $trainer->years ?? 0;
        $trainer->verified     = $request->boolean('verified');
        $trainer->show_stats   = $request->boolean('show_stats');

        // Diferenciais (mantém só linhas com título)
        $trainer->about_features = collect($data['about_features'] ?? [])
            ->filter(fn ($f) => filled($f['title'] ?? null))
            ->map(fn ($f) => [
                'icon'  => $f['icon'] ?: 'pulse',
                'title' => $f['title'],
                'body'  => $f['body'] ?? '',
            ])->values()->all();

        // Números (mantém só linhas preenchidas)
        $trainer->stats = collect($data['stats'] ?? [])
            ->filter(fn ($s) => filled($s['num'] ?? null) || filled($s['label'] ?? null))
            ->map(fn ($s) => ['num' => $s['num'] ?? '', 'label' => $s['label'] ?? ''])
            ->values()->all();

        // Especialidades / formato de atendimento (checkboxes)
        $trainer->specialties = array_values($data['specialties'] ?? []);
        $trainer->formats = array_values($data['formats'] ?? []);
        $trainer->show_calculator = $request->boolean('show_calculator');

        // FAQ (mantém só perguntas preenchidas)
        $trainer->faqs = collect($data['faqs'] ?? [])
            ->filter(fn ($f) => filled($f['q'] ?? null))
            ->map(fn ($f) => ['q' => $f['q'], 'a' => $f['a'] ?? ''])
            ->values()->all();

        // Uploads
        if ($request->hasFile('logo')) {
            $trainer->logo_path = $this->storePhoto($request->file('logo'), $trainer, 'logo', $trainer->logo_path);
        } elseif ($request->boolean('remove_logo')) {
            $this->deletePhoto($trainer->logo_path);
            $trainer->logo_path = null;
        }

        if ($request->hasFile('hero_photo')) {
            $trainer->hero_photo = $this->storePhoto($request->file('hero_photo'), $trainer, 'hero', $trainer->hero_photo);
        } elseif ($request->boolean('remove_hero')) {
            $this->deletePhoto($trainer->hero_photo);
            $trainer->hero_photo = null;
        }

        if ($request->hasFile('about_photo')) {
            $trainer->about_photo = $this->storePhoto($request->file('about_photo'), $trainer, 'about', $trainer->about_photo);
        } elseif ($request->boolean('remove_about')) {
            $this->deletePhoto($trainer->about_photo);
            $trainer->about_photo = null;
        }

        if ($request->hasFile('bio_bg_image')) {
            $trainer->bio_bg_image = $this->storePhoto($request->file('bio_bg_image'), $trainer, 'bio-bg', $trainer->bio_bg_image);
        } elseif ($request->boolean('remove_bio_bg')) {
            $this->deletePhoto($trainer->bio_bg_image);
            $trainer->bio_bg_image = null;
        }

        $trainer->save();

        return back()->with('flash', 'Perfil atualizado com sucesso.');
    }
}
