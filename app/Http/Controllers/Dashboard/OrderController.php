<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'products.product']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Get pagination limit
        $perPage = $request->get('per_page', 15);

        // Paginate results
        $orders = $query->paginate($perPage)->appends($request->query());

        // Get statistics for status cards
        $stats = $this->getOrderStatistics();

        return view('dashboard.order.index', compact('orders', 'stats'));
    }

    /**
     * Get order statistics for dashboard cards
     */
    private function getOrderStatistics()
    {
        return Order::select('status', DB::raw('count(*) as total'))
                   ->groupBy('status')
                   ->pluck('total', 'status')
                   ->toArray() + [
                       'pending' => 0,
                       'paid' => 0,
                       'completed' => 0,
                       'cancelled' => 0
                   ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $locale, Order $order)
    {
        $order->load(['user', 'products.product']);

        return view('dashboard.order.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(string $locale, Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => __('app.order_status_updated_successfully'),
            'status' => $order->status
        ]);
    }
}
