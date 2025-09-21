<style>
    .user-orders-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .user-header {
        background: white;
        padding: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #667eea;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .user-info h4 {
        margin: 0;
        color: #2d3748;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .user-info p {
        margin: 0.25rem 0 0;
        color: #718096;
        font-size: 0.95rem;
    }

    .user-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        background: white;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: linear-gradient(135deg, #123459 0%, #1d5ea5 100%);
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #718096;
        margin: 0.25rem 0 0;
        font-weight: 600;
    }

    .orders-section {
        background: white;
        padding: 2rem;
        max-height: 500px;
        overflow-y: auto;
    }

    .section-title {
        color: #2d3748;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: #667eea;
        font-size: 1.5rem;
    }

    .order-card {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateX(5px);
        border-color: #667eea;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
    }

    .order-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: between;
        align-items: center;
        background: white;
    }

    .order-id {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
        margin: 0;
    }

    .order-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .order-date {
        color: #718096;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .order-total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #38a169;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .order-status {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef5e7 0%, #f6e05e 100%);
        color: #744210;
    }

    .status-paid {
        background: linear-gradient(135deg, #f0fff4 0%, #68d391 100%);
        color: #22543d;
    }

    .status-completed {
        background: linear-gradient(135deg, #ebf8ff 0%, #63b3ed 100%);
        color: #2a4365;
    }

    .status-cancelled {
        background: linear-gradient(135deg, #fed7d7 0%, #fc8181 100%);
        color: #742a2a;
    }

    .order-products {
        padding: 1.25rem 1.5rem;
    }

    .products-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: white;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .product-item:hover {
        border-color: #cbd5e0;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .product-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    .product-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.25rem;
        font-size: 0.95rem;
    }

    .product-details {
        color: #718096;
        font-size: 0.85rem;
        margin: 0;
    }

    .product-total {
        font-weight: 700;
        color: #38a169;
        font-size: 1rem;
    }

    .no-orders {
        text-align: center;
        padding: 3rem 2rem;
        color: #718096;
    }

    .no-orders i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }

    .no-orders h5 {
        color: #4a5568;
        margin: 1rem 0 0.5rem;
    }

    .no-orders p {
        margin: 0;
        font-size: 0.95rem;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    @media (max-width: 768px) {
        .user-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .user-stats {
            grid-template-columns: 1fr;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .order-meta {
            width: 100%;
            justify-content: space-between;
        }

        .product-item {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="user-orders-container">
    <!-- User Header -->
    <div class="user-header">
        <img src="{{ $user->getImagePath() }}" alt="{{ $user->name }}" class="user-avatar">
        <div class="user-info">
            <h4>{{ $user->name }}</h4>
            <p><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
            <p><i class="bi bi-telephone me-1"></i>{{ $user->phone ?? __('app.not_available') }}</p>
            <p><i class="bi bi-geo-alt me-1"></i>{{ $user->address ?? __('app.not_available') }}</p>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="user-stats">
        <div class="stat-item">
            <h3 class="stat-number">{{ $user->orders->count() }}</h3>
            <p class="stat-label">{{ __('app.total_orders') }}</p>
        </div>
        <div class="stat-item">
            <h3 class="stat-number">${{ number_format($user->orders->sum('total'), 2) }}</h3>
            <p class="stat-label">{{ __('app.total_spent') }}</p>
        </div>
        <div class="stat-item">
            <h3 class="stat-number">{{ $user->orders->where('status', 'completed')->count() }}</h3>
            <p class="stat-label">{{ __('app.completed_orders') }}</p>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-section custom-scrollbar">
        <h5 class="section-title">
            <i class="bi bi-receipt"></i>
            {{ __('app.recent_orders') }} ({{ __('app.last_10') }})
        </h5>

        @if($user->orders->isNotEmpty())
            @foreach($user->orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h6 class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h6>
                        <div class="order-meta">
                            <span class="order-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $order->created_at->format('M d, Y') }}
                            </span>
                            <span class="order-total">
                                <i class="bi bi-currency-dollar"></i>
                                {{ number_format($order->total, 2) }}
                            </span>
                        </div>
                    </div>
                    <span class="order-status status-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                <i class="bi bi-clock"></i> {{ __('app.pending') }}
                                @break
                            @case('paid')
                                <i class="bi bi-check-circle"></i> {{ __('app.paid') }}
                                @break
                            @case('completed')
                                <i class="bi bi-check-all"></i> {{ __('app.completed') }}
                                @break
                            @case('cancelled')
                                <i class="bi bi-x-circle"></i> {{ __('app.cancelled') }}
                                @break
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </span>
                </div>

                @if($order->products->isNotEmpty())
                <div class="order-products">
                    <div class="products-list">
                        @foreach($order->products->take(3) as $orderProduct)
                        <div class="product-item">
                            @if($orderProduct->product && $orderProduct->product->image)
                                <img src="{{ $orderProduct->product->image_url }}"
                                     alt="{{ $orderProduct->product->name }}"
                                     class="product-image">
                            @else
                                <div class="product-placeholder">
                                    <i class="bi bi-box"></i>
                                </div>
                            @endif

                            <div class="product-info">
                                <h6 class="product-name">
                                    {{ $orderProduct->product->name ?? __('app.unknown_product') }}
                                </h6>
                                <p class="product-details">
                                    {{ __('app.quantity') }}: {{ $orderProduct->quantity }} ×
                                    ${{ number_format($orderProduct->price, 2) }}
                                </p>
                            </div>

                            <div class="product-total">
                                ${{ number_format($orderProduct->total, 2) }}
                            </div>
                        </div>
                        @endforeach

                        @if($order->products->count() > 3)
                        <div class="text-center mt-2">
                            <small class="text-muted">
                                <i class="bi bi-three-dots"></i>
                                {{ __('app.and_more_items', ['count' => $order->products->count() - 3]) }}
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        @else
            <div class="no-orders">
                <i class="bi bi-receipt"></i>
                <h5>{{ __('app.no_orders_yet') }}</h5>
                <p>{{ __('app.user_hasnt_placed_orders_yet') }}</p>
            </div>
        @endif
    </div>
</div>
