<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;

/**
 * Perfis de exemplo exibidos na home ("Veja na prática"): Marina Lacerda e Bruno Tavares.
 *
 * Não cria nenhuma conta de usuário, então é seguro para produção. Roda em todo deploy
 * (deploy/_deploy.php) e é idempotente: atualiza pelo slug e recria os itens de cada perfil.
 */
class ExampleProfilesSeeder extends Seeder
{
    public function run(): void
    {
        $marina = Trainer::updateOrCreate(['slug' => 'marina-lacerda'], [
            'name'           => 'Marina Lacerda',
            'brand_name'     => 'Marina Lacerda',
            'role'           => 'Personal Trainer',
            'city'           => 'São Paulo',
            'state'          => 'SP',
            'cref'           => 'CREF 012345-G/SP',
            'verified'       => true,
            'tagline'        => 'Emagrecimento, hipertrofia e recondicionamento físico com método baseado em evidência — treino feito sob medida para o seu corpo e a sua rotina.',
            'rating'         => 4.9,
            'rating_count'   => 127,
            'years'          => 8,
            'students'       => '300+',
            'goal_rate'      => '94%',
            'sessions'       => '12k+',
            'about_title'    => 'Treino que respeita o seu corpo e a sua vida',
            'about_p1'       => 'Sou Marina, formada em Educação Física pela USP e apaixonada por mostrar que condicionamento não é sofrimento — é consistência. Comecei treinando amigos no parque e hoje conduzo um método que já transformou mais de 300 pessoas.',
            'about_p2'       => 'Acredito em avaliar antes de prescrever, progredir com segurança e ajustar a rota sempre que a vida pede. Sem fórmulas mágicas: ciência, escuta e acompanhamento de verdade.',
            'about_features' => [
                ['icon' => 'pulse', 'title' => 'Avaliação individual',        'body' => 'Anamnese, bioimpedância e testes funcionais antes do primeiro treino.'],
                ['icon' => 'chart', 'title' => 'Método baseado em evidência',  'body' => 'Periodização e progressão de carga acompanhadas semana a semana.'],
                ['icon' => 'chat',  'title' => 'Acompanhamento contínuo',      'body' => 'Ajustes de treino e nutrição pelo app, com check-ins quinzenais.'],
            ],
            'stats' => [
                ['num' => '8',    'label' => 'Anos de experiência'],
                ['num' => '300+', 'label' => 'Alunos transformados'],
                ['num' => '94%',  'label' => 'Atingem a meta traçada'],
                ['num' => '4,9',  'label' => 'Avaliação média dos alunos'],
            ],
            'whatsapp'         => '5511999990000',
            'whatsapp_label'   => '(11) 9 9999-0000',
            'instagram'        => '@marina.lacerda.treina',
            'tiktok'           => 'https://tiktok.com/@marina.lacerda',
            'youtube'          => 'https://youtube.com/@marina.lacerda',
            'studio_name'      => 'Studio Vila Madalena · São Paulo',
            'studio_location'  => 'Presencial e online (todo o Brasil)',
            'hours'            => 'Seg a Sáb · 6h às 21h',
            'response_time'    => 'Resposta em até 2 horas',
            'accent_color'     => '#1f4733',
            'show_stats'       => true,
            'show_calculator'  => true,
            'plan'             => 'pro',
            'specialties'      => ['Emagrecimento', 'Hipertrofia', 'Funcional', 'Pós-reabilitação'],
            'formats'          => ['Presencial', 'Online'],
            'faqs'             => [
                ['q' => 'Você atende online?', 'a' => 'Sim. Monto o treino no app, com vídeos e check-ins quinzenais por chamada — funciona pra todo o Brasil.'],
                ['q' => 'Preciso ter experiência com treino?', 'a' => 'Não. A maioria dos meus alunos começou do zero. A gente ajusta tudo ao seu nível na avaliação.'],
                ['q' => 'O plano inclui dieta?', 'a' => 'Faço orientação nutricional básica. Para plano alimentar detalhado, trabalho junto com nutricionistas parceiras.'],
                ['q' => 'Como funciona a avaliação gratuita?', 'a' => 'É uma conversa de 30 minutos pra entender seus objetivos e sua rotina, com uma avaliação inicial — sem compromisso.'],
            ],
            'hero_photo'       => 'images/demo/marina-hero.jpg',
            'about_photo'      => 'images/demo/marina-about.jpg',
        ]);

        $marina->certifications()->delete();
        $marina->certifications()->createMany([
            ['title' => 'Bacharelado em Educação Física',   'issuer' => 'Universidade de São Paulo (USP)',     'year' => '2016',  'sort' => 1],
            ['title' => 'Pós em Fisiologia do Exercício',    'issuer' => 'UNIFESP',                              'year' => '2019',  'sort' => 2],
            ['title' => 'Registro CREF 012345-G/SP',         'issuer' => 'Conselho Regional de Ed. Física',      'year' => 'Ativo', 'sort' => 3],
            ['title' => 'Strength & Conditioning (CSCS)',    'issuer' => 'NSCA',                                 'year' => '2021',  'sort' => 4],
            ['title' => 'Treinamento Funcional',             'issuer' => 'Functional Training Institute',        'year' => '2020',  'sort' => 5],
            ['title' => 'Nutrição Esportiva Aplicada',       'issuer' => 'Especialização',                       'year' => '2022',  'sort' => 6],
        ]);

        $marina->results()->delete();
        $marina->results()->createMany([
            ['student_name' => 'Ana P., 34',     'duration' => '6 meses', 'tags' => ['−14 kg', '−9% gordura'],           'quote' => 'Voltei a confiar no espelho — e a subir escada sem perder o fôlego.',     'before_photo' => 'images/demo/r1-antes.jpg', 'after_photo' => 'images/demo/r1-depois.jpg', 'sort' => 1],
            ['student_name' => 'Rodrigo M., 42', 'duration' => '8 meses', 'tags' => ['+7 kg massa magra', '−5% gordura'], 'quote' => 'Estou mais forte aos 42 do que estava aos 30. Sem dor no joelho.',        'before_photo' => 'images/demo/r2-antes.jpg', 'after_photo' => 'images/demo/r2-depois.jpg', 'sort' => 2],
            ['student_name' => 'Júlia S., 28',   'duration' => '4 meses', 'tags' => ['−8 kg', 'postura corrigida'],       'quote' => 'As dores nas costas sumiram. Hoje treinar é a melhor parte do meu dia.',  'before_photo' => 'images/demo/r3-antes.jpg', 'after_photo' => 'images/demo/r3-depois.jpg', 'sort' => 3],
        ]);

        $marina->links()->delete();
        $marina->links()->createMany([
            ['icon' => 'whatsapp',  'label' => 'Fale comigo no WhatsApp',     'url' => 'https://wa.me/5511999990000',                'sort' => 1],
            ['icon' => 'instagram', 'label' => 'Me siga no Instagram',        'url' => 'https://instagram.com/marina.lacerda.treina','sort' => 2],
            ['icon' => 'play',      'label' => 'Treino online (assinatura)',  'url' => rtrim(config('app.url'), '/').'/marina-lacerda', 'sort' => 3],
            ['icon' => 'bag',       'label' => 'Minhas planilhas de treino',  'url' => rtrim(config('app.url'), '/').'/marina-lacerda', 'sort' => 4],
        ]);

        $marina->packages()->delete();
        $marina->packages()->createMany([
            [
                'name' => 'Online', 'price' => 'R$ 197', 'period' => '/mês', 'featured' => false, 'sort' => 1,
                'items' => ['Treino personalizado no app', 'Ajustes quinzenais', 'Suporte por WhatsApp', 'Vídeos dos exercícios'],
            ],
            [
                'name' => 'Presencial', 'price' => 'R$ 390', 'period' => '/mês', 'featured' => true, 'sort' => 2,
                'items' => ['2 sessões por semana no studio', 'Avaliação física completa', 'Treino + acompanhamento online', 'Plano de progressão individual'],
            ],
            [
                'name' => 'Avaliação avulsa', 'price' => 'R$ 120', 'period' => 'única', 'featured' => false, 'sort' => 3,
                'items' => ['Anamnese e bioimpedância', 'Testes funcionais', 'Relatório com plano de ação'],
            ],
        ]);

        $marina->testimonials()->delete();
        $marina->testimonials()->createMany([
            ['image' => 'images/demo/depo-1.svg', 'sort' => 1],
            ['image' => 'images/demo/depo-2.svg', 'sort' => 2],
        ]);

        // ===== 2º exemplo: Bruno Tavares (homem, cor azul) =====
        $bruno = Trainer::updateOrCreate(['slug' => 'bruno-tavares'], [
            'name'           => 'Bruno Tavares',
            'role'           => 'Personal Trainer',
            'city'           => 'Rio de Janeiro',
            'state'          => 'RJ',
            'cref'           => 'CREF 045678-G/RJ',
            'verified'       => true,
            'tagline'        => 'Hipertrofia, força e performance com treino direto ao ponto — resultado pra quem leva a sério, sem enrolação.',
            'rating'         => 4.8,
            'rating_count'   => 93,
            'years'          => 6,
            'students'       => '180+',
            'goal_rate'      => '91%',
            'sessions'       => '9k+',
            'about_title'    => 'Treino sem enrolação, focado em resultado',
            'about_p1'       => 'Sou Bruno, formado em Educação Física pela UFRJ. Trabalho com quem quer ganhar massa, força e performance de verdade — com método, progressão de carga e cobrança na medida certa.',
            'about_p2'       => 'Cada treino tem objetivo claro e é ajustado pelo seu retorno. Nada de treino aleatório: a gente mede, progride e corrige a rota toda semana.',
            'about_features' => [
                ['icon' => 'pulse', 'title' => 'Avaliação e metas',          'body' => 'Definimos número e prazo logo na primeira conversa.'],
                ['icon' => 'chart', 'title' => 'Progressão de carga',         'body' => 'Planilha que evolui semana a semana, sem estagnar.'],
                ['icon' => 'chat',  'title' => 'Cobrança no ponto certo',     'body' => 'Acompanhamento e ajustes pelo WhatsApp e pelo app.'],
            ],
            'stats' => [
                ['num' => '6',    'label' => 'Anos de experiência'],
                ['num' => '180+', 'label' => 'Alunos atendidos'],
                ['num' => '91%',  'label' => 'Batem a meta'],
                ['num' => '4,8',  'label' => 'Avaliação média'],
            ],
            'whatsapp'         => '5521988887777',
            'whatsapp_label'   => '(21) 9 8888-7777',
            'instagram'        => '@bruno.tavares.treina',
            'tiktok'           => 'https://tiktok.com/@bruno.tavares',
            'youtube'          => 'https://youtube.com/@bruno.tavares',
            'studio_name'      => 'CrossBox Botafogo · Rio de Janeiro',
            'studio_location'  => 'Presencial e online (todo o Brasil)',
            'hours'            => 'Seg a Sex · 6h às 22h',
            'response_time'    => 'Resposta em até 1 hora',
            'accent_color'     => '#1e40af',
            'show_stats'       => true,
            'show_calculator'  => true,
            'plan'             => 'free',
            'specialties'      => ['Hipertrofia', 'Força', 'Performance', 'Corrida'],
            'formats'          => ['Presencial', 'Online'],
            'faqs'             => [
                ['q' => 'Treino serve pra iniciante?', 'a' => 'Serve. Ajusto a carga e a complexidade ao seu nível — você evolui no seu ritmo, com segurança.'],
                ['q' => 'Você monta treino pra academia e pra casa?', 'a' => 'Sim. Adapto o treino ao equipamento que você tem disponível, em casa ou na academia.'],
                ['q' => 'Quanto tempo pra ver resultado?', 'a' => 'Com constância, as primeiras mudanças aparecem em 4–6 semanas. O plano é montado pra isso.'],
            ],
            'hero_photo'       => 'images/demo/bruno-hero.jpg',
            'about_photo'      => 'images/demo/bruno-about.jpg',
        ]);

        $bruno->certifications()->delete();
        $bruno->certifications()->createMany([
            ['title' => 'Bacharelado em Educação Física', 'issuer' => 'UFRJ',                          'year' => '2018',  'sort' => 1],
            ['title' => 'Strength & Conditioning (CSCS)',  'issuer' => 'NSCA',                          'year' => '2020',  'sort' => 2],
            ['title' => 'Registro CREF 045678-G/RJ',       'issuer' => 'Conselho Regional de Ed. Física', 'year' => 'Ativo', 'sort' => 3],
            ['title' => 'Especialização em Treino de Força', 'issuer' => 'Strength Academy',             'year' => '2021',  'sort' => 4],
        ]);

        $bruno->results()->delete();
        $bruno->results()->createMany([
            ['student_name' => 'Carlos M., 38', 'duration' => '8 meses', 'tags' => ['+9 kg massa magra', '−6% gordura'], 'quote' => 'Saí do sedentarismo e hoje treino pesado sem dor. Mudou meu dia a dia.', 'before_photo' => 'images/demo/b1-antes.jpg', 'after_photo' => 'images/demo/b1-depois.jpg', 'sort' => 1],
            ['student_name' => 'Felipe R., 25', 'duration' => '5 meses', 'tags' => ['+15 kg no supino', 'mais explosão'], 'quote' => 'Bati metas que achei que demorariam anos. Treino objetivo de verdade.', 'before_photo' => 'images/demo/b2-antes.jpg', 'after_photo' => 'images/demo/b2-depois.jpg', 'sort' => 2],
            ['student_name' => 'Diego A., 31', 'duration' => '6 meses', 'tags' => ['−10 kg', 'condicionamento'], 'quote' => 'Perdi peso e ganhei fôlego pra correr. O acompanhamento faz toda diferença.', 'before_photo' => 'images/demo/b3-antes.jpg', 'after_photo' => 'images/demo/b3-depois.jpg', 'sort' => 3],
        ]);

        $bruno->links()->delete();
        $bruno->links()->createMany([
            ['icon' => 'whatsapp',  'label' => 'Fala comigo no WhatsApp',   'url' => 'https://wa.me/5521988887777',                  'sort' => 1],
            ['icon' => 'instagram', 'label' => 'Instagram (bastidores)',    'url' => 'https://instagram.com/bruno.tavares.treina',   'sort' => 2],
            ['icon' => 'youtube',   'label' => 'Canal no YouTube',          'url' => 'https://youtube.com/@bruno.tavares',           'sort' => 3],
        ]);

        $bruno->packages()->delete();
        $bruno->packages()->createMany([
            ['name' => 'Consultoria online', 'price' => 'R$ 167', 'period' => '/mês', 'featured' => false, 'sort' => 1, 'items' => ['Treino no app', 'Ajustes semanais', 'Suporte por WhatsApp']],
            ['name' => 'Presencial', 'price' => 'R$ 420', 'period' => '/mês', 'featured' => true, 'sort' => 2, 'items' => ['3 sessões por semana', 'Avaliação física completa', 'Periodização de força', 'Acompanhamento online incluso']],
            ['name' => 'Plano performance', 'price' => 'R$ 690', 'period' => '/mês', 'featured' => false, 'sort' => 3, 'items' => ['Tudo do Presencial', 'Treino de corrida/condicionamento', 'Estratégia de competição']],
        ]);
    }
}
