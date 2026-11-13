<?php

/*
 | Planos da PersonalBio. limites: null = ilimitado.
 | features: o que cada plano libera. Fonte única de verdade do que é grátis x pago.
 | (Cobrança ainda não implementada — o plano é definido manualmente por enquanto.)
 */

return [

    'labels' => [
        'free'   => 'Grátis',
        'pro'    => 'Pro',
        'studio' => 'Studio',
    ],

    'free' => [
        'price' => 'R$0',
        'limits' => [
            'results'      => 2,
            'links'        => 2,
            'packages'     => 1,
            'testimonials' => 2,
        ],
        'features' => [
            'remove_branding' => false,  // mostra "Feito com PersonalBio"
            'custom_logo'     => false,  // usa o nome da marca, sem logo próprio
        ],
    ],

    'pro' => [
        'price' => 'R$39',
        'limits' => [
            'results'      => null,
            'links'        => null,
            'packages'     => null,
            'testimonials' => 5,
        ],
        'features' => [
            'remove_branding' => true,
            'custom_logo'     => true,
        ],
    ],

    'studio' => [
        'price' => 'R$129',
        'limits' => [
            'results'      => null,
            'links'        => null,
            'packages'     => null,
            'testimonials' => null,
        ],
        'features' => [
            'remove_branding' => true,
            'custom_logo'     => true,
            'team'            => true,
        ],
    ],
];
