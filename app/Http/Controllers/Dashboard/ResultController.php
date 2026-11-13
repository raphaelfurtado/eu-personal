<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\EnforcesPlanLimits;
use App\Http\Controllers\Concerns\HandlesPhotoUploads;
use App\Http\Controllers\Controller;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    use EnforcesPlanLimits, HandlesPhotoUploads;

    public function store(Request $request)
    {
        $trainer = $request->user()->trainer;

        if ($over = $this->overPlanLimit($trainer, 'results', 'resultados')) {
            return $over;
        }

        $data = $this->validateData($request);

        $result = $trainer->results()->create([
            'student_name' => $data['student_name'],
            'duration'     => $data['duration'] ?? null,
            'quote'        => $data['quote'] ?? null,
            'tags'         => $this->parseTags($data['tags'] ?? null),
            'sort'         => (int) $trainer->results()->max('sort') + 1,
        ]);

        if ($request->hasFile('before_photo')) {
            $result->before_photo = $this->storePhoto($request->file('before_photo'), $trainer, 'antes');
        }
        if ($request->hasFile('after_photo')) {
            $result->after_photo = $this->storePhoto($request->file('after_photo'), $trainer, 'depois');
        }
        $result->save();

        return back()->with('flash', 'Resultado adicionado.');
    }

    public function update(Request $request, Result $result)
    {
        $this->authorizeOwner($request, $result);
        $data = $this->validateData($request);
        $trainer = $request->user()->trainer;

        $result->fill([
            'student_name' => $data['student_name'],
            'duration'     => $data['duration'] ?? null,
            'quote'        => $data['quote'] ?? null,
            'tags'         => $this->parseTags($data['tags'] ?? null),
        ]);

        if ($request->hasFile('before_photo')) {
            $result->before_photo = $this->storePhoto($request->file('before_photo'), $trainer, 'antes', $result->before_photo);
        }
        if ($request->hasFile('after_photo')) {
            $result->after_photo = $this->storePhoto($request->file('after_photo'), $trainer, 'depois', $result->after_photo);
        }
        $result->save();

        return back()->with('flash', 'Resultado atualizado.');
    }

    public function destroy(Request $request, Result $result)
    {
        $this->authorizeOwner($request, $result);
        $this->deletePhoto($result->before_photo);
        $this->deletePhoto($result->after_photo);
        $result->delete();

        return back()->with('flash', 'Resultado removido.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'student_name' => ['required', 'string', 'max:80'],
            'duration'     => ['nullable', 'string', 'max:40'],
            'tags'         => ['nullable', 'string', 'max:160'],
            'quote'        => ['nullable', 'string', 'max:400'],
            'before_photo' => ['nullable', 'image', 'max:6144'],
            'after_photo'  => ['nullable', 'image', 'max:6144'],
        ]);
    }

    private function parseTags(?string $tags): array
    {
        return collect(explode(',', (string) $tags))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }

    private function authorizeOwner(Request $request, Result $result): void
    {
        abort_unless($result->trainer_id === $request->user()->trainer->id, 403);
    }
}
