<x-dashboard.layouts>

@section('css')
<style>
    .orders-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 60px);
        padding: 2rem 0;
    }

    .orders-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .orders-header {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .orders-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.pending {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        color: #8b4513;
    }

    .stat-card.paid {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #2d5016;
    }

    .stat-card.completed {
        background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
        color: #1a5490;
    }

    .stat-card.cancelled {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        color: #8b1538;
    }

    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }

    .stat-card p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
    }

    .orders-controls {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .search-filters {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .orders-table-container {
        background: white;
        border-radius: 15px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        margin: 0;
    }

    .table-responsive {
        margin: 0;
    }

    .orders-table {
        margin: 0;
        border: none;
    }

    .orders-table thead th {
        background: #f8fafc;
        border: none;
        padding: 1.25rem;
        font-weight: 600;
        color: #4a5568;
        border-bottom: 2px solid #e2e8f0;
    }

    .orders-table tbody td {
        padding: 1.25rem;
        border: none;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .orders-table tbody tr:hover {
        background-color: #f7fafc;
    }

    .order-id {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        color: #8b4513;
    }

    .status-paid {
        background: linear-gradient(135deg, #c3f0ca 0%, #a8e6cf 100%);
        color: #2d5016;
    }

    .status-completed {
        background: linear-gradient(135deg, #bde3ff 0%, #a2d2ff 100%);
        color: #1a5490;
    }

    .status-cancelled {
        background: linear-gradient(135deg, #ffb3ba 0%, #ff9aa2 100%);
        color: #8b1538;
    }

    .order-total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2d3748;
    }

    .order-date {
        color: #718096;
        font-size: 0.9rem;
    }

    .order-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 8px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-outline-info {
        border: 2px solid #3182ce;
        color: #3182ce;
    }

    .btn-outline-info:hover {
        background: #3182ce;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-success {
        border: 2px solid #38a169;
        color: #38a169;
    }

    .btn-outline-success:hover {
        background: #38a169;
        color: white;
        transform: translateY(-2px);
    }

    .btn-outline-danger {
        border: 2px solid #e53e3e;
        color: #e53e3e;
    }

    .btn-outline-danger:hover {
        background: #e53e3e;
        color: white;
        transform: translateY(-2px);
    }

    .products-count {
        background: #edf2f7;
        color: #4a5568;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .pagination-wrapper {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }

    .no-orders {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .no-orders i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }

    .no-orders h3 {
        color: #4a5568;
        margin-bottom: 1rem;
    }

    .no-orders p {
        color: #718096;
        margin-bottom: 0;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        z-index: 10;
    }

    .export-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-export {
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        color: #4a5568;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-export:hover {
        background: #667eea;
        border-color: #667eea;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .search-filters {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .orders-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .stat-card h3 {
            font-size: 2rem;
        }

        .export-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

<main class="app-content">
    <div class="orders-wrapper">
        <div class="orders-container">
            <!-- Header -->
            <div class="orders-header cu-rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-2"><i class="bi bi-receipt me-2"></i>{{ __('app.orders_management') ?: 'Orders Management' }}</h1>
                        <p class="mb-0 text-muted">{{ __('app.manage_track_orders') ?: 'Manage and track all customer orders' }}</p>
                    </div>
                    <div class="export-buttons">
                        <a href="#" class="btn-export cu-rounded">
                            <i class="bi bi-download"></i> {{ __('app.export_excel') ?: 'Export Excel' }}
                        </a>
                        <a href="#" class="btn-export cu-rounded">
                            <i class="bi bi-file-pdf"></i> {{ __('app.export_pdf') ?: 'Export PDF' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="orders-stats">
                <div class="stat-card cu-rounded">
                    <h3 id="total-orders">{{ method_exists($orders, 'total') ? $orders->total() : $orders->count() }}</h3>
                    <p><i class="bi bi-receipt me-2"></i>{{ __('app.total_orders') ?: 'Total Orders' }}</p>
                </div>
                <div class="stat-card pending cu-rounded">
                    <h3 id="pending-orders">{{ $stats['pending'] ?? 0 }}</h3>
                    <p><i class="bi bi-clock me-2"></i>{{ __('app.pending_orders') ?: 'Pending Orders' }}</p>
                </div>
                <div class="stat-card paid cu-rounded">
                    <h3 id="paid-orders">{{ $stats['paid'] ?? 0 }}</h3>
                    <p><i class="bi bi-check-circle me-2"></i>{{ __('app.paid_orders') ?: 'Paid Orders' }}</p>
                </div>
                <div class="stat-card completed cu-rounded">
                    <h3 id="completed-orders">{{ $stats['completed'] ?? 0 }}</h3>
                    <p><i class="bi bi-check-all me-2"></i>{{ __('app.completed_orders') ?: 'Completed Orders' }}</p>
                </div>
                <div class="stat-card cancelled cu-rounded">
                    <h3 id="cancelled-orders">{{ $stats['cancelled'] ?? 0 }}</h3>
                    <p><i class="bi bi-x-circle me-2"></i>{{ __('app.cancelled_orders') ?: 'Cancelled Orders' }}</p>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="orders-controls cu-rounded">
                <form method="GET" action="{{ localized_route('dashboard.order.index') }}" id="ordersFilterForm">
                    <div class="search-filters">
                        <div class="form-group">
                            <label for="search" class="form-label">{{ __('app.search_orders') ?: 'Search Orders' }}</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="{{ __('app.search_by_order_id_customer') ?: 'Search by order ID, customer name...' }}">
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('app.order_status') ?: 'Status' }}</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">{{ __('app.all_statuses') ?: 'All Statuses' }}</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('app.pending') ?: 'Pending' }}</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>{{ __('app.paid') ?: 'Paid' }}</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('app.completed') ?: 'Completed' }}</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('app.cancelled') ?: 'Cancelled' }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="per_page" class="form-label">{{ __('app.per_page') ?: 'Per Page' }}</label>
                            <select class="form-select" id="per_page" name="per_page">
                                <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary cu-rounded">
                                <i class="bi bi-search me-2"></i>{{ __('app.filter') ?: 'Filter' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Orders Table -->
            @if($orders && $orders->isNotEmpty())
            <div class="orders-table-container cu-rounded" id="ordersTableContainer">
                <div class="table-header">
                    <h4 class="mb-0"><i class="bi bi-table me-2"></i>{{ __('app.orders_list') ?: 'Orders List' }}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table orders-table">
                        <thead>
                            <tr>
                                <th>{{ __('app.order_id') ?: 'Order ID' }}</th>
                                <th>{{ __('app.customer') ?: 'Customer' }}</th>
                                <th>{{ __('app.products') ?: 'Products' }}</th>
                                <th>{{ __('app.total_amount') ?: 'Total Amount' }}</th>
                                <th>{{ __('app.status') ?: 'Status' }}</th>
                                <th>{{ __('app.order_date') ?: 'Order Date' }}</th>
                                <th>{{ __('app.actions') ?: 'Actions' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">
                                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $order->user->name ?? __('app.guest_user') }}</div>
                                            <div class="text-muted small">{{ $order->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="products-count cu-rounded">
                                        {{ $order->products->count() }} {{ __('app.items') ?: 'items' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="order-total">${{ number_format($order?->total, 2) }}</span>
                                </td>
                                <td>
                                    <span class="status-badge cu-rounded status-{{ $order->status }}">
                                        @switch($order->status)
                                            @case('pending')
                                                <i class="bi bi-clock me-1"></i>{{ __('app.pending') ?: 'Pending' }}
                                                @break
                                            @case('paid')
                                                <i class="bi bi-check-circle me-1"></i>{{ __('app.paid') ?: 'Paid' }}
                                                @break
                                            @case('completed')
                                                <i class="bi bi-check-all me-1"></i>{{ __('app.completed') ?: 'Completed' }}
                                                @break
                                            @case('cancelled')
                                                <i class="bi bi-x-circle me-1"></i>{{ __('app.cancelled') ?: 'Cancelled' }}
                                                @break
                                            @default
                                                {{ ucfirst($order->status) }}
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                                    <div class="text-muted small">{{ $order->created_at->format('g:i A') }}</div>
                                </td>
                                <td>
                                    <div class="order-actions">
                                        <button class="btn btn-outline-info cu-rounded btn-sm" onclick="viewOrder({{ $order->id }})"
                                                title="{{ __('app.view_order') ?: 'View Order' }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                        <button class="btn btn-outline-success cu-rounded btn-sm" onclick="updateOrderStatus({{ $order->id }}, 'completed')"
                                                title="{{ __('app.mark_completed') ?: 'Mark as Completed' }}">
                                            <i class="bi bi-check"></i>
                                        </button>
                                        @endif
                                        @if($order->status !== 'cancelled')
                                        <button class="btn btn-outline-danger cu-rounded btn-sm" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')"
                                                title="{{ __('app.cancel_order') ?: 'Cancel Order' }}">
                                            <i class="bi bi-x"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if(method_exists($orders, 'hasPages') && $orders->hasPages())
            <div class="pagination-wrapper">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        {{ __('app.showing') ?: 'Showing' }} {{ $orders->firstItem() }} {{ __('app.to') ?: 'to' }} {{ $orders->lastItem() }}
                        {{ __('app.of') ?: 'of' }} {{ $orders->total() }} {{ __('app.results') ?: 'results' }}
                    </div>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
            @endif

            @else
            <!-- No Orders State -->
            <div class="no-orders">
                <i class="bi bi-receipt"></i>
                <h3>{{ __('app.no_orders_found') ?: 'No Orders Found' }}</h3>
                <p>{{ __('app.no_orders_message') ?: 'There are no orders to display. Orders will appear here once customers start placing them.' }}</p>
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">{{ __('app.order_details') ?: 'Order Details' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>
</div>

@section('scripts')
  @include('dashboard.order.__order')
@endsection

</x-dashboard.layouts>
