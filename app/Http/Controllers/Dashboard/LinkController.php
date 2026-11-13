<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\EnforcesPlanLimits;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    use EnforcesPlanLimits;

    public function store(Request $request)
    {
        $trainer = $request->user()->trainer;

        if ($over = $this->overPlanLimit($trainer, 'links', 'links')) {
            return $over;
        }

        $data = $this->validateData($request);

        $trainer->links()->create($data + [
            'sort' => (int) $trainer->links()->max('sort') + 1,
        ]);

        return back()->with('flash', 'Link adicionado.');
    }

    public function update(Request $request, Link $link)
    {
        $this->authorizeOwner($request, $link);
        $link->update($this->validateData($request));

        return back()->with('flash', 'Link atualizado.');
    }

    public function destroy(Request $request, Link $link)
    {
        $this->authorizeOwner($request, $link);
        $link->delete();

        return back()->with('flash', 'Link removido.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:80'],
            'url'   => ['required', 'string', 'max:255'],
            'icon'  => ['nullable', 'string', 'max:30'],
        ]);

        $data['url'] = $this->normalizeUrl($data['url']);

        return $data;
    }

    /** Aceita o que o usuário digitar; prefixa https:// quando não houver esquema. */
    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        if (preg_match('#^(https?://|mailto:|tel:)#i', $url)) {
            return $url;
        }

        return 'https://'.ltrim($url, '/');
    }

    private function authorizeOwner(Request $request, Link $link): void
    {
        abort_unless($link->trainer_id === $request->user()->trainer->id, 403);
    }
}
