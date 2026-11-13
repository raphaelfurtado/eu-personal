<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\EnforcesPlanLimits;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    use EnforcesPlanLimits;

    public function store(Request $request)
    {
        $trainer = $request->user()->trainer;

        if ($over = $this->overPlanLimit($trainer, 'packages', 'pacotes')) {
            return $over;
        }

        $data = $this->validateData($request);

        $trainer->packages()->create($data + [
            'sort' => (int) $trainer->packages()->max('sort') + 1,
        ]);

        return back()->with('flash', 'Pacote adicionado.');
    }

    public function update(Request $request, Package $package)
    {
        $this->authorizeOwner($request, $package);
        $package->update($this->validateData($request));

        return back()->with('flash', 'Pacote atualizado.');
    }

    public function destroy(Request $request, Package $package)
    {
        $this->authorizeOwner($request, $package);
        $package->delete();

        return back()->with('flash', 'Pacote removido.');
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:80'],
            'price'    => ['nullable', 'string', 'max:40'],
            'period'   => ['nullable', 'string', 'max:30'],
            'items'    => ['nullable', 'string', 'max:1000'],  // uma linha por item
            'featured' => ['nullable', 'boolean'],
        ]);

        // Quebra o textarea em itens (uma linha cada)
        $data['items'] = collect(preg_split('/\r\n|\r|\n/', (string) ($data['items'] ?? '')))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();

        $data['featured'] = $request->boolean('featured');

        return $data;
    }

    private function authorizeOwner(Request $request, Package $package): void
    {
        abort_unless($package->trainer_id === $request->user()->trainer->id, 403);
    }
}
