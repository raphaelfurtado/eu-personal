<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $trainer = $request->user()->trainer;

        $trainer->certifications()->create($data + [
            'sort' => (int) $trainer->certifications()->max('sort') + 1,
        ]);

        return back()->with('flash', 'Qualificação adicionada.');
    }

    public function update(Request $request, Certification $certification)
    {
        $this->authorizeOwner($request, $certification);
        $certification->update($this->validateData($request));

        return back()->with('flash', 'Qualificação atualizada.');
    }

    public function destroy(Request $request, Certification $certification)
    {
        $this->authorizeOwner($request, $certification);
        $certification->delete();

        return back()->with('flash', 'Qualificação removida.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title'  => ['required', 'string', 'max:120'],
            'issuer' => ['nullable', 'string', 'max:120'],
            'year'   => ['nullable', 'string', 'max:20'],
        ]);
    }

    private function authorizeOwner(Request $request, Certification $certification): void
    {
        abort_unless($certification->trainer_id === $request->user()->trainer->id, 403);
    }
}
