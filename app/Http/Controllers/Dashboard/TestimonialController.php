<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Concerns\EnforcesPlanLimits;
use App\Http\Controllers\Concerns\HandlesPhotoUploads;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use EnforcesPlanLimits, HandlesPhotoUploads;

    public function store(Request $request)
    {
        $trainer = $request->user()->trainer;

        if ($over = $this->overPlanLimit($trainer, 'testimonials', 'prints')) {
            return $over;
        }

        $request->validate([
            'image' => ['required', 'image', 'max:6144'],
        ]);

        $path = $this->storePhoto($request->file('image'), $trainer, 'depoimento');

        $trainer->testimonials()->create([
            'image' => $path,
            'sort'  => (int) $trainer->testimonials()->max('sort') + 1,
        ]);

        return back()->with('flash', 'Print adicionado.');
    }

    public function destroy(Request $request, Testimonial $testimonial)
    {
        abort_unless($testimonial->trainer_id === $request->user()->trainer->id, 403);

        $this->deletePhoto($testimonial->image);
        $testimonial->delete();

        return back()->with('flash', 'Print removido.');
    }
}
