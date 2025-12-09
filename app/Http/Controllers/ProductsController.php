<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderDetails;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product                 = new Product();
        $product->name           = $request->input('name');
        $product->description    = $request->input('description');
        $product->price          = $request->input('price');
        $product->stock_quantity = $request->input('stock_quantity');
        $product->category_id    = $request->input('id_categoria');
        $product->supplier_id    = $request->input('id_supplier');
        $product->save();
        return response()->json([
            'message' => 'Producto creado correctamente',
            'product' => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function productByCategory($id)
    {
        $products = Product::where('category_id', $id)->get();
        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Buscar producto
        $product = Product::findOrFail($id);

        // Actualizar solo el precio
        $product->name           = $request->input('name');
        $product->description    = $request->input('description');
        $product->price          = $request->input('price');
        $product->stock_quantity = $request->input('stock_quantity');
        $product->save();

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->orderDetails()->delete(); // asumiendo que tienes la relación definida en Product
        Product::destroy($id);              // elimina el producto

        return response()->json([
            'message' => 'Producto eliminado',
            'product' => $product,
        ]);
    }

    public function bestSeller()
    {
        $bestSellers = Product::withCount('orderDetails')
            ->orderBy('order_details_count', 'desc')
            ->take(5)
            ->get();
        //si es igual a 0 no mostrar
        $bestSellers = $bestSellers->filter(function ($product) {
            return $product->order_details_count > 0;
        });
        return response()->json($bestSellers);
    }

    public function purchaseProduct($id)
    {
        $user = auth('api')->user();

        // Verificar usuario autenticado
        if (! $user) {
            return response()->json([
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $product = Product::find($id);

        // Validar que el producto existe
        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado',
            ], 404);
        }

        // Resto del código igual...
        $order               = new Order();
        $order->user_id      = $user->id;
        $order->total_amount = $product->price;
        $order->status       = 'pending';
        $order->order_date   = now();
        $order->save();

        $orderDetail             = new OrderDetails();
        $orderDetail->order_id   = $order->id;
        $orderDetail->product_id = $product->id;
        $orderDetail->cantity   = 1;
        $orderDetail->price      = $product->price;
        $orderDetail->save();

        return response()->json([
            'success' => true,
            'message' => 'Producto comprado con éxito',
        ]);
    }

}
