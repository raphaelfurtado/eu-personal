<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'verified'        => 'boolean',
        'show_stats'      => 'boolean',
        'show_calculator' => 'boolean',
        'rating'          => 'decimal:1',
        'about_features'  => 'array',
        'stats'           => 'array',
        'specialties'     => 'array',
        'formats'         => 'array',
        'faqs'            => 'array',
        'plan_until'      => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class)->orderBy('sort');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class)->orderBy('sort');
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class)->orderBy('sort');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class)->orderBy('sort');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class)->orderBy('sort');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Marca exibida no cabeçalho do perfil (cai para o nome). */
    public function getBrandNameLabelAttribute(): string
    {
        return $this->brand_name ?: $this->name;
    }

    /** URL pública do logo enviado (ou null). */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset($this->logo_path) : null;
    }

    public function getHeroPhotoUrlAttribute(): ?string
    {
        return $this->hero_photo ? asset($this->hero_photo) : null;
    }

    public function getAboutPhotoUrlAttribute(): ?string
    {
        return $this->about_photo ? asset($this->about_photo) : null;
    }

    public function getBioBgImageUrlAttribute(): ?string
    {
        return $this->bio_bg_image ? asset($this->bio_bg_image) : null;
    }

    /** Redes sociais presentes, como ícones (ordem fixa) para a fileira da /bio. */
    public function getSocialLinksAttribute(): array
    {
        $out = [];
        if ($this->instagram) {
            $out[] = ['icon' => 'instagram', 'url' => 'https://instagram.com/'.ltrim($this->instagram, '@')];
        }
        if ($this->tiktok) {
            $out[] = ['icon' => 'tiktok', 'url' => self::ensureScheme($this->tiktok)];
        }
        if ($this->youtube) {
            $out[] = ['icon' => 'youtube', 'url' => self::ensureScheme($this->youtube)];
        }
        if ($this->twitter) {
            $out[] = ['icon' => 'x', 'url' => self::ensureScheme($this->twitter)];
        }
        if ($this->whatsapp) {
            $out[] = ['icon' => 'whatsapp', 'url' => $this->whatsapp_url];
        }

        return $out;
    }

    private static function ensureScheme(string $url): string
    {
        $url = trim($url);

        return preg_match('#^https?://#i', $url) ? $url : 'https://'.ltrim($url, '/');
    }

    /** Nota formatada no padrão brasileiro: 4.9 -> "4,9" */
    public function getRatingBrAttribute(): string
    {
        return number_format((float) $this->rating, 1, ',', '.');
    }

    /** Link wa.me a partir do número só com dígitos */
    public function getWhatsappUrlAttribute(): ?string
    {
        return $this->whatsapp ? 'https://wa.me/'.preg_replace('/\D/', '', $this->whatsapp) : null;
    }

    // =================== PLANO ===================

    public function planKey(): string
    {
        return in_array($this->plan, ['free', 'pro', 'studio'], true) ? $this->plan : 'free';
    }

    public function getPlanLabelAttribute(): string
    {
        return config('plans.labels.'.$this->planKey(), 'Grátis');
    }

    public function isPro(): bool
    {
        return in_array($this->planKey(), ['pro', 'studio'], true);
    }

    /** Recurso liberado no plano? (ex.: 'remove_branding', 'custom_logo') */
    public function planAllows(string $feature): bool
    {
        return (bool) config("plans.{$this->planKey()}.features.{$feature}", false);
    }

    /** Limite do plano para um recurso; null = ilimitado. */
    public function planLimit(string $key): ?int
    {
        return config("plans.{$this->planKey()}.limits.{$key}");
    }

    /** Já atingiu o limite do plano para esse recurso? */
    public function reachedLimit(string $key, int $current): bool
    {
        $limit = $this->planLimit($key);

        return $limit !== null && $current >= $limit;
    }

    // =================== TEMA / COR DA MARCA ===================

    /** Variáveis CSS (custom properties) derivadas da cor principal, prontas pro style do <body>. */
    public function getThemeStyleAttribute(): string
    {
        return self::paletteCss($this->accent_color ?: '#1f4733');
    }

    /** Gera as variáveis de tema a partir de uma cor hex, com contraste automático. */
    public static function paletteCss(string $hex): string
    {
        [$r, $g, $b] = self::hexToRgb($hex);
        $lum = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;
        $onBrand = $lum > 0.6 ? '#15211b' : '#ffffff';
        $muted = $lum > 0.6 ? self::mix($hex, '#000000', 0.45) : self::mix($hex, '#ffffff', 0.62);

        $vars = [
            '--brand'          => $hex,
            '--brand-2'        => self::mix($hex, '#ffffff', 0.22),
            '--brand-dark'     => self::mix($hex, '#000000', 0.30),
            '--brand-tint'     => self::mix($hex, '#ffffff', 0.90),
            '--brand-tint-2'   => self::mix($hex, '#ffffff', 0.93),
            '--page'           => self::mix($hex, '#ffffff', 0.94),  // fundo da página, leve tom da marca
            '--on-brand'       => $onBrand,
            '--on-brand-muted' => $muted,
        ];

        $css = '';
        foreach ($vars as $k => $v) {
            $css .= $k.':'.$v.';';
        }

        return $css;
    }

    private static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            $hex = '1f4733';
        }

        return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    }

    /** Mistura $a com $b; $w é o peso de $b (0..1). */
    private static function mix(string $a, string $b, float $w): string
    {
        [$ar, $ag, $ab] = self::hexToRgb($a);
        [$br, $bg, $bb] = self::hexToRgb($b);

        return sprintf(
            '#%02x%02x%02x',
            (int) round($ar * (1 - $w) + $br * $w),
            (int) round($ag * (1 - $w) + $bg * $w),
            (int) round($ab * (1 - $w) + $bb * $w),
        );
    }
}
