<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categoria = Category::create([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Categoría agregada', 'data' => $categoria]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Ver productos de esa categoria
        $category = Category::find($id);
        $products = $category->products; // Asumiendo que la relación está definida en el modelo Category
        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
