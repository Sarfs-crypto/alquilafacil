<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Mostrar listado de categorías
    public function index()
    {
        $categories = Category::all();
        return view('admin.categorias.index', compact('categories'));
    }

    // Mostrar formulario para crear categoría
    public function create()
    {
        return view('admin.categorias.create');
    }

    // Guardar nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);

        Category::create($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Mostrar formulario para editar categoría
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categorias.edit', compact('category'));
    }

    // Actualizar categoría
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id . '|max:255'
        ]);

        $category->update($request->all());
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    // Eliminar categoría
    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}