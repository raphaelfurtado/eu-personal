# PersonalBio

Site profissional para personal trainers, pronto em minutos.

Muito personal bom perde aluno porque a única vitrine que tem é o Instagram: as fotos de antes e depois se perdem no feed, as certificações ficam num destaque esquecido e quem quer contratar precisa mandar DM e esperar. A PersonalBio dá a cada personal uma página própria que mostra o trabalho de um jeito sério e transforma visita em contato no WhatsApp.

Ao vivo em [personalbio.websiteponto.com.br](https://personalbio.websiteponto.com.br).

## Como funciona

O personal cria a conta, preenche o perfil pelo painel e ganha dois endereços:

- **`/seu-nome`**: o site completo, com apresentação, formação e certificações, resultados de alunos (antes e depois), pacotes e preços, depoimentos e formulário de contato.
- **`/seu-nome/bio`**: uma versão enxuta para colocar no link da bio do Instagram, com os links que ele quiser.

Quando um aluno em potencial preenche o formulário, ele responde uma pequena anamnese (objetivo, nível, frequência, onde treina e restrições). O contato fica salvo no painel, o personal recebe um e-mail e o aluno é levado direto para o WhatsApp do personal, já com a mensagem pronta.

No painel, o personal escolhe as cores e o fundo da página, sobe as fotos, organiza os pacotes e acompanha os contatos que chegaram.

## Planos

| | Grátis | Pro | Studio |
| --- | --- | --- | --- |
| Preço | R$ 0 | R$ 39/mês | R$ 129/mês |
| Resultados, links e pacotes | até 2, 2 e 1 | ilimitados | ilimitados |
| Depoimentos | 2 | 5 | ilimitados |
| Logo próprio e sem "Feito com PersonalBio" | não | sim | sim |

A assinatura do Pro é feita pelo Mercado Pago (assinatura recorrente). O webhook do Mercado Pago ativa ou rebaixa o plano automaticamente quando o pagamento é aprovado, pausado ou cancelado. Os limites e o que cada plano libera ficam em [config/plans.php](config/plans.php).

## Rodando na sua máquina

Precisa de PHP 8.3+, Composer, Node 22 e MySQL (ou SQLite, para testar rápido).

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

O seed cria dois perfis de exemplo, `/marina-lacerda` e `/bruno-tavares`, que aparecem na home na seção "Veja na prática", e uma conta para entrar no painel: `demo@corpora.test` com a senha `password`. Não rode o seed em produção sem trocar essa senha.

Para a assinatura funcionar, configure no `.env`:

```env
MP_ACCESS_TOKEN=
MP_PUBLIC_KEY=
MP_PRO_PRICE=39
```

## Testes

```bash
php artisan test
```

## Deploy

O deploy é feito pelo GitHub Actions a cada push na `main` ([.github/workflows/deploy.yml](.github/workflows/deploy.yml)):

1. Roda os testes. Se algum falhar, nada vai para o servidor.
2. Instala as dependências de produção, builda os assets e empacota tudo em dois arquivos: `backend.zip` (o Laravel) e `webroot.zip` (a pasta pública).
3. Envia esses dois arquivos e o instalador [deploy/_deploy.php](deploy/_deploy.php) por FTP para a pasta do domínio. São só três arquivos: mandar o `vendor` arquivo por arquivo levava mais de 40 minutos e a hospedagem acabava bloqueando a conexão.
4. Chama o instalador, que só responde a quem envia o `DEPLOY_TOKEN` certo. Ele descompacta o backend numa pasta nova, leva o `.env` e o `storage/` da versão atual, troca as pastas, atualiza a pasta do domínio e roda as migrations. A saída das migrations aparece no log do Actions.

O backend fica em `/eu-persona` e a pasta pública em `/personalbio.websiteponto.com.br`. O `index.php` da pasta do domínio é gerado no deploy e carrega o Laravel de `/eu-persona`. As fotos que os personais enviam ficam em `uploads/`, dentro da pasta do domínio, e o deploy nunca mexe nelas.

O servidor precisa da extensão `zip` do PHP habilitada.

Secrets necessários no repositório: `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD` e `DEPLOY_TOKEN`. O mesmo `DEPLOY_TOKEN` precisa estar no `.env` do servidor.

## Stack

Laravel 13, Blade, Tailwind CSS 4 e Vite. Pagamentos pelo Mercado Pago.

A pasta `design-source/` guarda os protótipos em HTML que serviram de base para o visual (o projeto se chamava Corpora no começo).
