<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Muestra todas las categorías.
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Crea una nueva categoría.
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Crear la categoría con los datos validados
        $category = Category::create($validatedData);

        // Retornar la categoría recién creada
        return response()->json($category, 201);
    }

    /**
     * Muestra una categoría específica.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        return response()->json($category);
    }

    /**
     * Actualiza una categoría existente.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        // Actualizar la categoría con los datos validados
        $category->update($validatedData);

        return response()->json($category);
    }

    /**
     * Elimina una categoría.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente']);
    }
}


