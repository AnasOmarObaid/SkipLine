<div class="order-details">
    <!-- Order Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-1">{{ __('app.order') }} #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
            <p class="text-muted mb-0">{{ __('app.placed_on') ?: 'Placed on' }}: {{ $order->created_at->format('F d, Y g:i A') }}</p>
        </div>
        <div>
            <span class="status-badge status-{{ $order->status }}">
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
        </div>
    </div>

    <!-- Customer Information -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="bi bi-person me-2"></i>{{ __('app.customer_information') ?: 'Customer Information' }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>{{ __('app.name') ?: 'Name' }}:</strong> {{ $order->user->name ?? __('app.guest_user') }}</p>
                    <p class="mb-1"><strong>{{ __('app.email') ?: 'Email' }}:</strong> {{ $order->user->email ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>{{ __('app.user_id') ?: 'User ID' }}:</strong> {{ $order->user_id ?? '-' }}</p>
                    <p class="mb-1"><strong>{{ __('app.phone') ?: 'Phone' }}:</strong> {{ $order->user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="bi bi-cart me-2"></i>{{ __('app.order_items') ?: 'Order Items' }}</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('app.product') ?: 'Product' }}</th>
                            <th>{{ __('app.price') ?: 'Price' }}</th>
                            <th>{{ __('app.quantity') ?: 'Quantity' }}</th>
                            <th class="text-end">{{ __('app.total') ?: 'Total' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="width: 40px; height: 40px; background: #f5f7fa; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset( $item->product->image_url) }}" alt="{{ $item->product->name ?? '' }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <i class="bi bi-box"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $item->product->name ?? __('app.unknown_product') }}</p>
                                        <small class="text-muted">{{ __('app.sku') }}: {{ $item->product->sku ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('app.total') ?: 'Total' }}:</strong></td>
                            <td class="text-end"><strong>${{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Timeline -->
    <div class="card">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>{{ __('app.order_timeline') ?: 'Order Timeline' }}</h6>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0 d-flex justify-content-between">
                    <div>
                        <h6 class="mb-0">{{ __('app.order_placed') ?: 'Order Placed' }}</h6>
                        <small class="text-muted">{{ __('app.initial_status') ?: 'Initial status: ' }} {{ __('app.pending') }}</small>
                    </div>
                    <small>{{ $order->created_at->format('M d, Y g:i A') }}</small>
                </li>

                @if($order->updated_at->gt($order->created_at))
                <li class="list-group-item px-0 d-flex justify-content-between">
                    <div>
                        <h6 class="mb-0">{{ __('app.status_updated') ?: 'Status Updated' }}</h6>
                        <small class="text-muted">{{ __('app.current_status') ?: 'Current status: ' }} {{ __('app.' . $order->status) ?: ucfirst($order->status) }}</small>
                    </div>
                    <small>{{ $order->updated_at->format('M d, Y g:i A') }}</small>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Order Actions Footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        {{ __('app.close') ?: 'Close' }}
    </button>

    @if($order->status !== 'completed' && $order->status !== 'cancelled')
    <button type="button" class="btn btn-outline-success" onclick="updateOrderStatus({{ $order->id }}, 'completed')" data-bs-dismiss="modal">
        <i class="bi bi-check-circle me-1"></i>{{ __('app.mark_completed') ?: 'Mark as Completed' }}
    </button>
    @endif

    @if($order->status !== 'cancelled')
    <button type="button" class="btn btn-outline-danger" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')" data-bs-dismiss="modal">
        <i class="bi bi-x-circle me-1"></i>{{ __('app.cancel_order') ?: 'Cancel Order' }}
    </button>
    @endif
</div>
