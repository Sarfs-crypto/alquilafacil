<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // Mostrar listado de equipos (para el admin)
    public function index()
    {
        $equipment = Equipment::with('category')->get();
        return view('admin.equipos.index', compact('equipment'));
    }

    // Mostrar detalle de un equipo (para el cliente)
    public function show($id)
    {
        $equipment = Equipment::with('category')->findOrFail($id);
        return view('equipo-detail', compact('equipment'));
    }

    // Mostrar formulario para crear equipo
    public function create()
    {
        $categories = Category::all();
        return view('admin.equipos.create', compact('categories'));
    }

    // Guardar nuevo equipo
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|unique:equipment',
            'daily_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }
        Equipment::create($data);
        return redirect()->route('equipos.index')->with('success', 'Equipo creado exitosamente.');
    }

    // Mostrar formulario para editar equipo
    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        $categories = Category::all();
        return view('admin.equipos.edit', compact('equipment', 'categories'));
    }

    // Actualizar equipo
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|unique:equipment,code,' . $id,
            'daily_price' => 'required|numeric|min:0',
        ]);

        $equipment->update($request->all());
        return redirect()->route('equipos.index')->with('success', 'Equipo actualizado.');
    }

    // Eliminar equipo
    public function destroy($id)
    {
        Equipment::destroy($id);
        return redirect()->route('equipos.index')->with('success', 'Equipo eliminado.');
    }

    // Cambiar equipo a mantenimiento
    public function setMaintenance($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'maintenance']);
        return back()->with('success', 'Equipo en mantenimiento.');
    }
}