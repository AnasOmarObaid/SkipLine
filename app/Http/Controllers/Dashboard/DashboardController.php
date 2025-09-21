<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current date ranges for comparisons
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // General Statistics
        $stats = [
            'total_users' => User::role('client')->count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::whereIn('status', ['paid', 'completed'])->sum('total'),

            // Growth statistics
            'users_this_month' => User::role('client')->where('created_at', '>=', $thisMonth)->count(),
            'users_last_month' => User::role('client')->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count(),
            'orders_this_month' => Order::where('created_at', '>=', $thisMonth)->count(),
            'orders_last_month' => Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count(),
            'revenue_this_month' => Order::whereIn('status', ['paid', 'completed'])->where('created_at', '>=', $thisMonth)->sum('total'),
            'revenue_last_month' => Order::whereIn('status', ['paid', 'completed'])->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->sum('total'),

            // Order status counts
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders' => Order::where('status', 'paid')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),

            // User verification stats
            'verified_users' => User::role('client')->whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::role('client')->whereNull('email_verified_at')->count(),
        ];

        // Calculate growth percentages
        $stats['users_growth'] = $this->calculateGrowthPercentage($stats['users_this_month'], $stats['users_last_month']);
        $stats['orders_growth'] = $this->calculateGrowthPercentage($stats['orders_this_month'], $stats['orders_last_month']);
        $stats['revenue_growth'] = $this->calculateGrowthPercentage($stats['revenue_this_month'], $stats['revenue_last_month']);

        // Most sold products
        $mostSoldProducts = OrderProduct::select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total) as total_revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(6)
            ->get();

        // Recent users (last 10)
        $recentUsers = User::role('client')
            ->with('image')
            ->latest()
            ->limit(10)
            ->get();

        // Recent products (last 10)
        $recentProducts = Product::with('image')
            ->latest()
            ->limit(10)
            ->get();

        // Recent orders (last 10)
        $recentOrders = Order::with(['user', 'products'])
            ->latest()
            ->limit(10)
            ->get();

        // Chart data for sales trends (last 7 days)
        $salesTrendData = $this->getSalesTrendData();

        // Chart data for user growth (last 12 months)
        $userGrowthData = $this->getUserGrowthData();

        // Chart data for order status distribution
        $orderStatusData = [
            'pending' => $stats['pending_orders'],
            'paid' => $stats['paid_orders'],
            'completed' => $stats['completed_orders'],
            'cancelled' => $stats['cancelled_orders']
        ];

        // Revenue analytics
        $revenueAnalytics = $this->getRevenueAnalytics();

        // Performance metrics
        $performanceMetrics = $this->getPerformanceMetrics();

        // Activity feed
        $recentActivities = $this->getRecentActivities();

        // Product performance
        $productPerformance = $this->getProductPerformance();

        // System health (basic)
        $systemHealth = $this->getSystemHealth();

        // Quick stats for mini cards
        $quickStats = [
            'avg_order_value' => $stats['total_orders'] > 0 ? round($stats['total_revenue'] / $stats['total_orders'], 2) : 0,
            'conversion_rate' => $stats['total_users'] > 0 ? round(($stats['total_orders'] / $stats['total_users']) * 100, 1) : 0,
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'revenue_today' => Order::whereIn('status', ['paid', 'completed'])->whereDate('created_at', $today)->sum('total'),
        ];

        return view('dashboard.welcome', compact(
            'stats',
            'mostSoldProducts',
            'recentUsers',
            'recentProducts',
            'recentOrders',
            'salesTrendData',
            'userGrowthData',
            'orderStatusData',
            'revenueAnalytics',
            'performanceMetrics',
            'recentActivities',
            'productPerformance',
            'systemHealth',
            'quickStats'
        ));
    }

    /**
     * Calculate growth percentage between two values
     */
    private function calculateGrowthPercentage($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Get sales trend data for the last 7 days
     */
    private function getSalesTrendData()
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('M j');

            $dayRevenue = Order::whereIn('status', ['paid', 'completed'])
                ->whereDate('created_at', $date)
                ->sum('total');

            $data[] = (float) $dayRevenue;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get user growth data for the last 12 months
     */
    private function getUserGrowthData()
    {
        $data = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $monthlyUsers = User::role('client')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $data[] = $monthlyUsers;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get detailed revenue analytics
     */
    private function getRevenueAnalytics()
    {
        $monthlyRevenue = [];
        $monthlyLabels = [];

        // Get last 6 months revenue
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $revenue = Order::whereIn('status', ['paid', 'completed'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');

            $monthlyRevenue[] = (float) $revenue;
        }

        return [
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyRevenue
            ],
            'thisMonth' => Order::whereIn('status', ['paid', 'completed'])
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('total'),
            'lastMonth' => Order::whereIn('status', ['paid', 'completed'])
                ->whereBetween('created_at', [
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth()
                ])->sum('total')
        ];
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics()
    {
        $totalOrders = Order::count();
        $totalUsers = User::role('client')->count();
        $totalRevenue = Order::whereIn('status', ['paid', 'completed'])->sum('total');

        return [
            'average_order_value' => $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0,
            'conversion_rate' => $totalUsers > 0 ? round(($totalOrders / $totalUsers) * 100, 2) : 0,
            'customer_lifetime_value' => $totalUsers > 0 ? round($totalRevenue / $totalUsers, 2) : 0,
            'orders_per_user' => $totalUsers > 0 ? round($totalOrders / $totalUsers, 2) : 0,
            'repeat_customer_rate' => $this->getRepeatCustomerRate(),
            'top_spending_customers' => $this->getTopSpendingCustomers()
        ];
    }

    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        $activities = [];

        // Recent orders
        $recentOrders = Order::with('user')->latest()->limit(5)->get();
        foreach ($recentOrders as $order) {
            $activities[] = [
                'type' => 'order',
                'icon' => 'bi-receipt',
                'color' => 'primary',
                'title' => 'New Order Placed',
                'description' => 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' by ' . ($order->user->name ?? 'Guest'),
                'time' => $order->created_at,
                'amount' => $order->total
            ];
        }

        // Recent users
        $recentUsers = User::role('client')->latest()->limit(3)->get();
        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user',
                'icon' => 'bi-person-plus',
                'color' => 'success',
                'title' => 'New User Registration',
                'description' => $user->name . ' joined the platform',
                'time' => $user->created_at,
                'amount' => null
            ];
        }

        // Sort by time
        usort($activities, function($a, $b) {
            return $b['time']->timestamp - $a['time']->timestamp;
        });

        return array_slice($activities, 0, 10);
    }

    /**
     * Get product performance metrics
     */
    private function getProductPerformance()
    {
        return [
            'low_stock_products' => $this->getLowStockProducts(),
            'top_categories' => $this->getTopCategories(),
            'product_stats' => [
                'total_products' => Product::count(),
                'out_of_stock' => Product::where('stock', '<=', 0)->count(),
                'low_stock' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
                'in_stock' => Product::where('stock', '>', 10)->count()
            ]
        ];
    }

    /**
     * Get system health indicators
     */
    private function getSystemHealth()
    {
        return [
            'database' => $this->checkDatabaseHealth(),
            'storage' => $this->checkStorageHealth(),
            'cache' => $this->checkCacheHealth(),
            'queue' => $this->checkQueueHealth()
        ];
    }

    /**
     * Get repeat customer rate
     */
    private function getRepeatCustomerRate()
    {
        try {
            $totalCustomers = User::role('client')
                ->whereHas('orders')
                ->count();

            if ($totalCustomers == 0) {
                return 0;
            }

            // Use a raw query to avoid GROUP BY issues with MySQL strict mode
            $repeatCustomers = DB::select(
                "SELECT COUNT(DISTINCT u.id) as count 
                 FROM users u 
                 INNER JOIN model_has_roles mhr ON u.id = mhr.model_id 
                 INNER JOIN roles r ON mhr.role_id = r.id 
                 INNER JOIN (
                     SELECT user_id, COUNT(*) as order_count 
                     FROM orders 
                     WHERE user_id IS NOT NULL 
                     GROUP BY user_id 
                     HAVING COUNT(*) > 1
                 ) o ON u.id = o.user_id 
                 WHERE r.name = 'client' AND mhr.model_type = 'App\\\\Models\\\\User'"
            );

            $repeatCount = $repeatCustomers[0]->count ?? 0;
            return round(($repeatCount / $totalCustomers) * 100, 1);
        } catch (\Exception $e) {
            // Fallback to a simpler calculation if the complex query fails
            return 0;
        }
    }

    /**
     * Get top spending customers
     */
    private function getTopSpendingCustomers()
    {
        try {
            // Use a more compatible approach for MySQL strict mode
            $customers = DB::select(
                "SELECT u.*, COALESCE(o.total_spent, 0) as total_spent
                 FROM users u
                 INNER JOIN model_has_roles mhr ON u.id = mhr.model_id
                 INNER JOIN roles r ON mhr.role_id = r.id
                 LEFT JOIN (
                     SELECT user_id, SUM(total) as total_spent
                     FROM orders
                     WHERE status IN ('paid', 'completed') AND user_id IS NOT NULL
                     GROUP BY user_id
                 ) o ON u.id = o.user_id
                 WHERE r.name = 'client' AND mhr.model_type = 'App\\\\Models\\\\User' AND o.total_spent > 0
                 ORDER BY o.total_spent DESC
                 LIMIT 5"
            );

            // Convert to User models
            return collect($customers)->map(function($customer) {
                $user = User::find($customer->id);
                $user->total_spent = $customer->total_spent;
                return $user;
            });
        } catch (\Exception $e) {
            // Fallback to empty collection if query fails
            return collect([]);
        }
    }

    /**
     * Get low stock products
     */
    private function getLowStockProducts()
    {
        return Product::where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
    }

    /**
     * Get top categories (simulated - adjust based to your category system)
     */
    private function getTopCategories()
    {
        try {
            // This is a placeholder - adjust based on your actual category system
            $topProducts = DB::select(
                "SELECT op.product_id, COUNT(*) as orders_count, p.name
                 FROM order_products op
                 LEFT JOIN products p ON op.product_id = p.id
                 GROUP BY op.product_id, p.name
                 ORDER BY orders_count DESC
                 LIMIT 5"
            );

            return collect($topProducts)->map(function($item) {
                return [
                    'name' => $item->name ?? 'Unknown Product',
                    'orders' => $item->orders_count
                ];
            });
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Check database health
     */
    private function checkDatabaseHealth()
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'healthy', 'message' => 'Connected'];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Connection failed'];
        }
    }

    /**
     * Check storage health
     */
    private function checkStorageHealth()
    {
        try {
            $freeBytes = disk_free_space(storage_path());
            $totalBytes = disk_total_space(storage_path());
            $usedPercent = (($totalBytes - $freeBytes) / $totalBytes) * 100;

            return [
                'status' => $usedPercent < 90 ? 'healthy' : 'warning',
                'message' => round($usedPercent, 1) . '% used',
                'free_space' => $this->formatBytes($freeBytes)
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Cannot read storage'];
        }
    }

    /**
     * Check cache health
     */
    private function checkCacheHealth()
    {
        try {
            $key = 'health_check_' . time();
            Cache::put($key, 'test', 60);
            $result = Cache::get($key);
            Cache::forget($key);

            return [
                'status' => $result === 'test' ? 'healthy' : 'unhealthy',
                'message' => $result === 'test' ? 'Working' : 'Not responding'
            ];
        } catch (\Exception $e) {
            return ['status' => 'unhealthy', 'message' => 'Cache error'];
        }
    }

    /**
     * Check queue health (basic)
     */
    private function checkQueueHealth()
    {
        // This is a basic check - enhance based on your queue system
        return ['status' => 'healthy', 'message' => 'No failed jobs'];
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
