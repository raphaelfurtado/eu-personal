<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Trainer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HandlesPhotoUploads
{
    /**
     * Salva a imagem em public/uploads/trainers/{id}/ e devolve o caminho
     * relativo (web), pronto para asset(). Apaga o arquivo antigo, se houver.
     */
    protected function storePhoto(UploadedFile $file, Trainer $trainer, string $prefix, ?string $old = null): string
    {
        $dir = "uploads/trainers/{$trainer->id}";
        $abs = public_path($dir);

        if (! is_dir($abs)) {
            mkdir($abs, 0755, true);
        }

        $name = $prefix.'-'.Str::random(8).'.'.strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $file->move($abs, $name);

        $this->deletePhoto($old);

        return $dir.'/'.$name;
    }

    protected function deletePhoto(?string $path): void
    {
        if ($path && is_file(public_path($path))) {
            @unlink(public_path($path));
        }
    }
}
