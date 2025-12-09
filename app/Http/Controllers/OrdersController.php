<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userId = auth('api')->id(); //id del usuario autenticado
        /** guardar en la variable $orders la relación con detalles del pedido */
        $orders = Order::with(['details.product'])
            ->where('user_id', $userId)
            ->get();

        /** devolver en formato json los pedidos */
        return response()->json($orders);
    }

    public function orderDetails($id)
    {
        $order = Order::with('details.product')->find($id);

        if (! $order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }

        return response()->json([
            'order_id' => $order->id,
            'price'    => $order->total_amount,
            'status'   => $order->status,
            'products' => $order->details, // aquí están los productos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Aqui se ve si es administrador
        $user = auth('api')->user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $order = Order::find($id);
        if (! $order) {
            return response()->json(['message' => 'Pedido no encontrado'], 404);
        }
        $order->status = $request->input('status', $order->status);
        $order->save();
    }

    public function getOrderByUserId($userId)
    {
        $orders = Order::with('details.product')
            ->where('user_id', $userId)
            ->get();

        return response()->json($orders);
    }


        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            //
        }
    }
