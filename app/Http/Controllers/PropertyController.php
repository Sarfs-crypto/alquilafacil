<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('user_id', Auth::id())->get();
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'price_per_night' => 'required|numeric|min:1',
            'image' => 'nullable|image',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['available'] = true;

        Property::create($validated);

        return redirect()->route('properties.index')->with('success', 'Propiedad creada');
    }

    // TODO: edit, update, destroy, show
}