<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Tampilkan semua pesanan
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    // Tampilkan pesanan berdasarkan ID
    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order, 200);
    }

    // Update pesanan
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $request->validate([
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1',
            'total_price' => 'numeric|min:0',
        ]);

        $order->update($request->all());

        return response()->json($order, 200);
    }

    // Hapus pesanan
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();
        return response()->json(['message' => 'Order deleted'], 200);
    }
}
