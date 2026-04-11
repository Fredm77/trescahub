<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // ── Public ─────────────────────────────────────────────────────────────

    public function publicIndex()
    {
        $partners = Partner::latest()->get();
        return view('front.pages.for-partners', compact('partners'));
    }

    // ── Admin ──────────────────────────────────────────────────────────────

    /**
     * Display a listing of partners.
     */
    public function index()
    {
        $partners = Partner::latest()->paginate(15);
        return view('partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        Partner::create($validated);

        return redirect()->route('partners.index')
            ->with('success', 'Partner created successfully!');
    }

    /**
     * Display the specified partner.
     */
    public function show(Partner $partner)
    {
        return view('partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner)
    {
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $partner->update($validated);

        return redirect()->route('partners.index')
            ->with('success', 'Partner updated successfully!');
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy(Partner $partner)
    {
        $title = $partner->title;
        $partner->delete();

        return redirect()->route('partners.index')
            ->with('success', "Partner '{$title}' deleted successfully!");
    }
}