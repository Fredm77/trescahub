<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // ─── Public: Submit testimonial (POST from popup form) ────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'position'     => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $validated['status'] = 'pending';

        Testimonial::create($validated);

        return back()->with('testimonial_success', 'Thank you! Your testimonial has been submitted and is awaiting approval.');
    }

    // ─── Admin: List all testimonials ─────────────────────────────────────────

    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        $pendingCount = Testimonial::pending()->count();

        return view('testimonials.index', compact('testimonials', 'pendingCount'));
    }

    // ─── Admin: Approve a testimonial ─────────────────────────────────────────

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'approved']);

        return back()->with('success', "\"{$testimonial->name}\" testimonial approved successfully.");
    }

    // ─── Admin: Delete a testimonial ──────────────────────────────────────────

    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimonial from \"{$name}\" deleted successfully.");
    }
}