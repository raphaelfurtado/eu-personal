<?php

return [

    // WhatsApp de vendas (botão "Falar com vendas" do plano Studio). Só dígitos com DDI.
    'sales_whatsapp' => env('SALES_WHATSAPP', ''),

    // Faixa de números (trust strip)
    'trust' => [
        ['value' => '2.000+', 'label' => 'personais ativos'],
        ['value' => '10 min', 'label' => 'para publicar'],
        ['value' => '+38%',   'label' => 'mais leads em média'],
        ['value' => '0',      'label' => 'linha de código'],
    ],

    // Recursos
    'features' => [
        ['icon' => 'shield-check', 'title' => 'Perfil que transmite autoridade', 'body' => 'Credenciais, CREF e bio organizados num layout que gera confiança no primeiro olhar.'],
        ['icon' => 'chart',        'title' => 'Vitrine de resultados',           'body' => 'Mostre antes/depois e números reais das suas transformações — a melhor prova social que existe.'],
        ['icon' => 'chat',         'title' => 'Captação e agendamento',          'body' => 'Formulário e WhatsApp integrados levam cada lead direto pra você, sem fricção.'],
        ['icon' => 'code',         'title' => 'Zero código',                     'body' => 'Edite tudo arrastando textos e fotos. Publique em um clique, atualize quando quiser.'],
    ],

    // Como funciona
    'steps' => [
        ['n' => '01', 'title' => 'Crie sua conta',          'body' => 'Em 2 minutos, sem cartão de crédito. É grátis para começar.'],
        ['n' => '02', 'title' => 'Personalize seu perfil',  'body' => 'Adicione fotos, credenciais e resultados arrastando — sem complicação.'],
        ['n' => '03', 'title' => 'Publique e capte alunos',  'body' => 'Compartilhe seu link — site completo ou a versão enxuta pra bio — e receba contatos no painel.'],
    ],

    // Depoimentos
    'quotes' => [
        ['text' => 'Fechei 6 novos alunos no primeiro mês só com a página. O investimento se pagou na primeira semana.', 'name' => 'Camila Reis',    'role' => 'Personal Trainer · RJ'],
        ['text' => 'Finalmente um site que parece profissional sem eu precisar mexer em código nenhum.',                 'name' => 'Diego Antunes',  'role' => 'Personal Trainer · POA'],
        ['text' => 'A vitrine de antes e depois vende sozinha. Os alunos chegam já querendo fechar.',                    'name' => 'Marina Lacerda', 'role' => 'Personal Trainer · SP'],
    ],

    // Planos
    'plans' => [
        [
            'name' => 'Grátis', 'price' => 'R$0', 'period' => '/mês',
            'desc' => 'Para começar a captar hoje.',
            'features' => ['Perfil completo + link na bio', 'Captação ilimitada por WhatsApp'],
            'plan' => 'free',
            'cta' => 'Criar grátis', 'href' => '#', 'featured' => false, 'badge' => null,
        ],
        [
            'name' => 'Pro', 'price' => 'R$39', 'period' => '/mês',
            'desc' => 'Para o personal que quer escalar.',
            'features' => ['Tudo do Grátis, e mais:', 'Sem a marca PersonalBio', 'Logo próprio', 'Vitrine ilimitada (resultados, links, pacotes)'],
            'cta' => 'Assinar Pro', 'href' => '#', 'featured' => true, 'badge' => 'Mais popular',
        ],
        [
            'name' => 'Studio', 'price' => 'Sob consulta', 'period' => '',
            'desc' => 'Para estúdios e equipes — montamos sob medida.',
            'features' => ['Tudo do Pro, e mais:', 'Vários personais no mesmo estúdio', 'Gestão centralizada e relatórios', 'Atendimento dedicado'],
            'cta' => 'Falar com vendas', 'href' => '#', 'featured' => false, 'badge' => null, 'plan' => 'studio',
        ],
    ],
];
