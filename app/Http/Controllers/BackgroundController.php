<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BackgroundController extends Controller
{
    /**
     * Safely extract a scalar value whether the DB stores
     * a plain string OR a legacy JSON array ["value"].
     */
    private function val(mixed $raw): mixed
    {
        return is_array($raw) ? ($raw[0] ?? null) : $raw;
    }

    public function index()
    {
        $backgrounds = Background::paginate(15);
        return view('backgrounds.index', compact('backgrounds'));
    }

    public function create()
    {
        return view('backgrounds.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'slides'               => ['required', 'array'],
            'slides.*.title'       => ['required', 'string', 'max:255'],
            'slides.*.description' => ['nullable', 'string'],
            'slides.*.thumbnail'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'slides.*.go_to'       => ['nullable', 'string', 'max:500'],
            'slides.*.button_text' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($request->slides as $index => $slide) {

            $thumbnailPath = null;
            if ($request->hasFile("slides.$index.thumbnail")) {
                $file         = $request->file("slides.$index.thumbnail");
                $filename     = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/backgrounds'), $filename);
                $thumbnailPath = 'assets/backgrounds/' . $filename;
            }

            $slug = !empty($slide['slug'])
                ? Str::slug($slide['slug'])
                : Str::slug($slide['title']);

            Background::create([
                'title'       => $slide['title'],
                'slug'        => $slug,
                'description' => $slide['description'] ?? null,
                'thumbnail'   => $thumbnailPath,
                'go_to'       => $slide['go_to'] ?? null,
                'button_text' => $slide['button_text'] ?? null,
            ]);
        }

        return redirect()
            ->route('backgrounds.index')
            ->with('success', 'Backgrounds saved successfully!');
    }

    public function show(Background $background)
    {
        return view('backgrounds.show', compact('background'));
    }

    public function edit(Background $background)
    {
        return view('backgrounds.edit', compact('background'));
    }

    public function update(Request $request, Background $background)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:backgrounds,slug,' . $background->id],
            'description' => ['nullable', 'string'],
            'thumbnail'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'go_to'       => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:255'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail — handle both legacy array and plain string
            $oldThumbnail = $this->val($background->thumbnail);
            if ($oldThumbnail && file_exists(public_path($oldThumbnail))) {
                unlink(public_path($oldThumbnail));
            }

            $file     = $request->file('thumbnail');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/backgrounds'), $filename);
            $validated['thumbnail'] = 'assets/backgrounds/' . $filename;
        }

        $background->update($validated);

        return redirect()
            ->route('backgrounds.index')
            ->with('success', 'Background updated successfully!');
    }

    public function destroy(Background $background)
    {
        // Handle both legacy array ["path"] and plain string "path"
        $thumbnail = $this->val($background->thumbnail);
        if ($thumbnail && file_exists(public_path($thumbnail))) {
            unlink(public_path($thumbnail));
        }

        $background->delete();

        return redirect()
            ->route('backgrounds.index')
            ->with('success', 'Background deleted successfully!');
    }
}