<script>
    // Real-time search
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('ordersFilterForm').submit();
        }, 700);
    });

    // Auto-submit on filter change
    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('ordersFilterForm').submit();
    });

    document.getElementById('per_page').addEventListener('change', function() {
        document.getElementById('ordersFilterForm').submit();
    });

    // View order details
    async function viewOrder(orderId) {
        try {
            // Show loading state
            document.getElementById('orderDetailsContent').innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading...</p></div>';
            new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();

            // Using Laravel route helper for proper URL generation
            const response = await fetch(`{{ localized_route('dashboard.order.show', ['order' => '__ORDER_ID__']) }}`.replace('__ORDER_ID__', orderId));

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const html = await response.text();
            document.getElementById('orderDetailsContent').innerHTML = html;
        } catch (error) {
            console.error('Error loading order details:', error);
            document.getElementById('orderDetailsContent').innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ __('app.error_loading_order') ?: 'Error loading order details' }}
                </div>`;
        }
    }

    // Update order status with SweetAlert
    async function updateOrderStatus(orderId, status) {
        // Status translations
        const statusTranslations = {
            'completed': '{{ __('app.completed') ?: 'Completed' }}',
            'cancelled': '{{ __('app.cancelled') ?: 'Cancelled' }}',
            'pending': '{{ __('app.pending') ?: 'Pending' }}',
            'paid': '{{ __('app.paid') ?: 'Paid' }}'
        };

        const result = await Swal.fire({
            title: '{{ __('app.confirm_status_change') ?: 'Are you sure?' }}',
            text: `Change order status to ${statusTranslations[status] || status}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'completed' ? '#28a745' : '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '{{ __('app.yes') ?: 'Yes' }}',
            cancelButtonText: '{{ __('app.no') ?: 'No' }}'
        });

        if (!result.isConfirmed) {
            return;
        }

        try {
            // Show loading
            Swal.fire({
                title: 'Please wait...',
                html: 'Updating order status...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const response = await fetch(`{{ localized_route('dashboard.order.updateStatus', ['order' => '__ORDER_ID__']) }}`.replace('__ORDER_ID__', orderId), {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ __('app.order_status_updated_successfully') ?: 'Order status updated successfully' }}',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload();
                });
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        } catch (error) {
            console.error('Error updating order status:', error);
            Swal.fire({
                title: 'Error!',
                text: '{{ __('app.error_updating_status') ?: 'Error updating order status' }}',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        }
    }

</script>
