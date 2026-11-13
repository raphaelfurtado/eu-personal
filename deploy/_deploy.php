<?php

/*
 * Instalador chamado pelo GitHub Actions (.github/workflows/deploy.yml).
 *
 * O Actions envia por FTP só três arquivos para o webroot: backend.zip, webroot.zip
 * e este script. Depois faz um POST aqui com o DEPLOY_TOKEN, e este script:
 *   1. descompacta o backend numa pasta nova (../__BACKEND_DIR__.new);
 *   2. leva o .env e o storage/ (logs, sessões) da versão atual para a nova;
 *   3. troca a pasta antiga pela nova (rename, quase instantâneo);
 *   4. descompacta o webroot aqui (sem tocar em uploads/);
 *   5. roda as migrations e limpa os caches.
 *
 * O token é lido do .env do backend. Sem token válido, responde 404.
 */

// Bufferiza a saída para ainda poder responder 500 se algo falhar no fim
ob_start();
set_time_limit(600);
ignore_user_abort(true);
header('Content-Type: text/plain; charset=UTF-8');

const BACKEND_DIR = '__BACKEND_DIR__';

$base = dirname(__DIR__).'/'.BACKEND_DIR;
$new = $base.'.new';
$old = $base.'.old';
$log = [];

function fail(int $code, string $message): never
{
    http_response_code($code);
    exit($message."\n");
}

function step(array &$log, string $message): void
{
    $log[] = date('H:i:s').' '.$message;
}

function rrmdir(string $dir): void
{
    if (! is_dir($dir) || is_link($dir)) {
        @unlink($dir);

        return;
    }

    foreach (new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    ) as $item) {
        $item->isDir() && ! $item->isLink() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }

    rmdir($dir);
}

function envValue(string $file, string $key): ?string
{
    if (! is_file($file)) {
        return null;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES) as $line) {
        // trim() padrão também remove o \r de arquivos salvos com quebra de linha do Windows
        if (preg_match('/^\s*'.preg_quote($key, '/').'\s*=(.*)$/', $line, $m)) {
            return trim(trim($m[1]), "\"'");
        }
    }

    return null;
}

function extract_zip(string $zip, string $to): void
{
    $archive = new ZipArchive;

    if ($archive->open($zip) !== true) {
        fail(500, "Não consegui abrir {$zip}.");
    }

    if (! $archive->extractTo($to)) {
        fail(500, "Falha ao descompactar {$zip} em {$to}.");
    }

    $archive->close();
}

// ---------------------------------------------------------------- autenticação

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    fail(404, 'Not Found');
}

$token = envValue($base.'/.env', 'DEPLOY_TOKEN') ?? envValue($new.'/.env', 'DEPLOY_TOKEN') ?? '';
$sent = trim($_SERVER['HTTP_X_DEPLOY_TOKEN'] ?? '');

// Só chega aqui com o header presente; aí vale explicar o que falta na configuração
if ($sent !== '' && $token === '') {
    fail(500, 'DEPLOY_TOKEN não encontrado em ../'.BACKEND_DIR.'/.env no servidor.');
}

if ($token === '' || ! hash_equals($token, $sent)) {
    fail(404, 'Not Found');
}

if (! class_exists(ZipArchive::class)) {
    fail(500, 'A extensão zip do PHP não está habilitada no servidor.');
}

$backendZip = __DIR__.'/backend.zip';
$webrootZip = __DIR__.'/webroot.zip';

if (! is_file($backendZip) || ! is_file($webrootZip)) {
    fail(500, 'backend.zip ou webroot.zip não encontrado no webroot.');
}

// ---------------------------------------------------------------- backend

rrmdir($new);
mkdir($new, 0755, true);
extract_zip($backendZip, $new);
step($log, 'Backend descompactado em '.basename($new));

if (is_file($base.'/.env')) {
    rename($base.'/.env', $new.'/.env');
}

if (! is_file($new.'/.env')) {
    fail(500, "Falta o arquivo .env em {$base}.");
}

if (is_dir($base.'/storage')) {
    rrmdir($new.'/storage');
    rename($base.'/storage', $new.'/storage');
    step($log, 'storage/ preservado');
}

foreach (['storage/app/public', 'storage/framework/cache/data', 'storage/framework/sessions',
    'storage/framework/views', 'storage/logs', 'bootstrap/cache'] as $dir) {
    is_dir($new.'/'.$dir) || mkdir($new.'/'.$dir, 0755, true);
}

rrmdir($old);
if (is_dir($base)) {
    rename($base, $old);
}
rename($new, $base);
rrmdir($old);
step($log, 'Nova versão ativada em '.BACKEND_DIR);

// ---------------------------------------------------------------- webroot

rrmdir(__DIR__.'/build');
extract_zip($webrootZip, __DIR__);
step($log, 'Webroot atualizado');

unlink($backendZip);
unlink($webrootZip);

if (function_exists('opcache_reset')) {
    opcache_reset();
}

// ---------------------------------------------------------------- migrations

require $base.'/vendor/autoload.php';

$app = require $base.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$status = $kernel->call('migrate', ['--force' => true]);
$migrateOutput = trim($kernel->output());
$kernel->call('optimize:clear');

step($log, 'Migrations:');

echo implode("\n", $log)."\n".$migrateOutput."\n";

if ($status !== 0) {
    fail(500, 'As migrations falharam.');
}

echo "Deploy concluído.\n";
