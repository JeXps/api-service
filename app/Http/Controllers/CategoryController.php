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
        $category = Category::create($request->validate([
            'name' => 'required|string|max:255'
        ]));

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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $category->update([
            'name' => $request->name,
        ]);

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

