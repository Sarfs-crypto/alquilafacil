<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('category')->paginate(12);
        $categories = Category::all();
        return view('equipment.index', compact('equipment', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:equipment',
            'daily_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        Equipment::create($data);
        return redirect()->route('equipment.index')->with('success', 'Equipo creado');
    }

    public function show(Equipment $equipment)
    {
        return view('equipment.show', compact('equipment'));
    }
}