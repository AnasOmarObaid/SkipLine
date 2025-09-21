<x-dashboard.layouts>
    @section('css')
        <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
        <style>
            :root {
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
                --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
                --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
                --card-shadow: 0 15px 35px rgba(0,0,0,0.1);
                --hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
                --border-radius: 20px;
            }

            .app-content {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }

            .dashboard-container {
                padding: 2rem 0;
            }

            .dashboard-header {
                background: white;
                border-radius: var(--border-radius);
                padding: 2rem;
                margin-bottom: 2rem;
                box-shadow: var(--card-shadow);
                position: relative;
                overflow: hidden;
            }

            .dashboard-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 5px;
                background: var(--primary-gradient);
            }

            .dashboard-title {
                font-size: 2.5rem;
                font-weight: 800;
                color: #2d3748;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .dashboard-title i {
                background: var(--primary-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .dashboard-subtitle {
                color: #718096;
                font-size: 1.1rem;
                margin: 0.5rem 0 0;
                font-weight: 500;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: var(--border-radius);
                padding: 2rem;
                box-shadow: var(--card-shadow);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: var(--primary-gradient);
            }

            .stat-card.users::before { background: var(--success-gradient); }
            .stat-card.products::before { background: var(--warning-gradient); }
            .stat-card.orders::before { background: var(--info-gradient); }
            .stat-card.revenue::before { background: var(--danger-gradient); }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--hover-shadow);
            }

            .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
            }

            .stat-icon {
                width: 70px;
                height: 70px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                background: var(--primary-gradient);
                color: white;
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            }

            .stat-card.users .stat-icon {
                background: var(--success-gradient);
                box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
            }

            .stat-card.products .stat-icon {
                background: var(--warning-gradient);
                box-shadow: 0 8px 25px rgba(250, 112, 154, 0.3);
            }

            .stat-card.orders .stat-icon {
                background: var(--info-gradient);
                box-shadow: 0 8px 25px rgba(168, 237, 234, 0.3);
            }

            .stat-card.revenue .stat-icon {
                background: var(--danger-gradient);
                box-shadow: 0 8px 25px rgba(252, 70, 107, 0.3);
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 800;
                color: #2d3748;
                margin: 0;
                line-height: 1;
            }

            .stat-label {
                color: #718096;
                font-size: 1rem;
                font-weight: 600;
                margin: 0.5rem 0;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .stat-growth {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
                font-weight: 600;
                margin-top: 0.5rem;
            }

            .growth-positive {
                color: #38a169;
            }

            .growth-negative {
                color: #e53e3e;
            }

            .charts-section {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .chart-container {
                background: white;
                border-radius: var(--border-radius);
                padding: 2rem;
                box-shadow: var(--card-shadow);
                transition: all 0.3s ease;
            }

            .chart-container:hover {
                transform: translateY(-2px);
                box-shadow: var(--hover-shadow);
            }

            .chart-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: #2d3748;
                margin: 0 0 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .chart-title i {
                color: #667eea;
            }

            .chart-canvas {
                position: relative;
                height: 300px;
                width: 100%;
            }

            .products-section {
                margin-bottom: 2rem;
            }

            .section-header {
                background: white;
                border-radius: var(--border-radius) var(--border-radius) 0 0;
                padding: 1.5rem 2rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .section-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #2d3748;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .section-title i {
                color: #667eea;
            }

            .products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                background: white;
                padding: 2rem;
                border-radius: 0 0 var(--border-radius) var(--border-radius);
                box-shadow: var(--card-shadow);
            }

            .product-card {
                background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
                border: 2px solid #e2e8f0;
                border-radius: 15px;
                padding: 1.5rem;
                text-align: center;
                transition: all 0.3s ease;
            }

            .product-card:hover {
                transform: translateY(-3px);
                border-color: #667eea;
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.15);
            }

            .product-image {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                object-fit: cover;
                margin: 0 auto 1rem;
                border: 3px solid #e2e8f0;
            }

            .product-name {
                font-weight: 700;
                color: #2d3748;
                font-size: 0.9rem;
                margin: 0 0 0.5rem;
            }

            .product-sales {
                color: #38a169;
                font-weight: 600;
                font-size: 0.875rem;
            }

            .product-revenue {
                color: #718096;
                font-size: 0.8rem;
                margin-top: 0.25rem;
            }

            .tables-section {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
                gap: 2rem;
            }

            .table-container {
                background: white;
                border-radius: var(--border-radius);
                box-shadow: var(--card-shadow);
                overflow: hidden;
            }

            .table-header {
                background: var(--primary-gradient);
                color: white;
                padding: 1.5rem 2rem;
            }

            .table-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .modern-table {
                margin: 0;
                border: none;
            }

            .modern-table thead th {
                background: #f8fafc;
                border: none;
                padding: 1rem 1.5rem;
                font-weight: 600;
                color: #4a5568;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-size: 0.8rem;
            }

            .modern-table tbody td {
                padding: 1rem 1.5rem;
                border: none;
                border-bottom: 1px solid #f1f5f9;
                vertical-align: middle;
            }

            .modern-table tbody tr:hover {
                background-color: #f8fafc;
            }

            .user-avatar-small {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
            }

            .product-image-small {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                object-fit: cover;
                border: 2px solid #e2e8f0;
            }

            .status-badge {
                padding: 0.375rem 0.75rem;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
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

            @media (max-width: 768px) {
                .dashboard-container {
                    padding: 1rem 0;
                }

                .dashboard-header {
                    padding: 1.5rem;
                }

                .dashboard-title {
                    font-size: 2rem;
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0.5rem;
                }

                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }

                .charts-section {
                    grid-template-columns: 1fr;
                }

                .tables-section {
                    grid-template-columns: 1fr;
                }

                .products-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 480px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }

                .products-grid {
                    grid-template-columns: 1fr;
                }
            }

            /* Mini Stat Cards */
            .mini-stat-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                box-shadow: var(--card-shadow);
                transition: all 0.3s ease;
                border-left: 4px solid transparent;
            }

            .mini-stat-card:hover {
                transform: translateY(-3px);
                box-shadow: var(--hover-shadow);
            }

            .mini-stat-icon {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                color: white;
            }

            .mini-stat-content h4 {
                font-size: 1.75rem;
                font-weight: 800;
                color: #2d3748;
                margin: 0;
            }

            .mini-stat-content p {
                color: #718096;
                font-size: 0.9rem;
                font-weight: 600;
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            /* Performance Metrics */
            .performance-metrics,
            .activity-feed,
            .system-health,
            .quick-actions,
            .product-performance,
            .low-stock-alerts {
                background: white;
                border-radius: var(--border-radius);
                box-shadow: var(--card-shadow);
                overflow: hidden;
                height: fit-content;
            }

            .metrics-header,
            .feed-header,
            .health-header,
            .actions-header,
            .performance-header,
            .alerts-header {
                background: var(--primary-gradient);
                color: white;
                padding: 1.5rem;
            }

            .metrics-content,
            .feed-content,
            .health-content,
            .performance-stats,
            .alerts-list {
                padding: 1.5rem;
            }

            .metric-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .metric-item:last-child {
                border-bottom: none;
            }

            .metric-label {
                color: #718096;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .metric-value {
                color: #2d3748;
                font-weight: 800;
                font-size: 1.25rem;
            }

            /* Activity Feed */
            .activity-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .activity-icon {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.25rem;
                flex-shrink: 0;
            }

            .activity-content {
                flex: 1;
            }

            .activity-content h4 {
                font-size: 0.95rem;
                font-weight: 700;
                color: #2d3748;
                margin: 0 0 0.25rem;
            }

            .activity-content p {
                color: #718096;
                font-size: 0.875rem;
                margin: 0;
                line-height: 1.4;
            }

            .activity-time {
                color: #a0aec0;
                font-size: 0.75rem;
                font-weight: 500;
            }

            .activity-amount {
                color: #38a169;
                font-weight: 700;
                font-size: 1rem;
                flex-shrink: 0;
            }

            /* System Health */
            .health-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .health-item:last-child {
                border-bottom: none;
            }

            .health-label {
                color: #4a5568;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .health-status {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
                font-weight: 600;
            }

            .health-status.status-healthy {
                color: #38a169;
            }

            .health-status.status-warning {
                color: #d69e2e;
            }

            .health-status.status-unhealthy {
                color: #e53e3e;
            }

            /* Quick Actions */
            .actions-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                padding: 10px;
            }

            .action-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.75rem;
                padding: 1.5rem;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border-radius: 15px;
                text-decoration: none;
                color: #4a5568;
                font-weight: 600;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .action-card:hover {
                color: #667eea;
                border-color: #667eea;
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
                text-decoration: none;
            }

            .action-card i {
                font-size: 1.5rem;
            }

            /* Product Performance */
            .performance-stat {
                text-align: center;
                padding: 1rem;
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border-radius: 15px;
                transition: all 0.3s ease;
            }

            .performance-stat:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }

            .performance-stat h4 {
                font-size: 2rem;
                font-weight: 800;
                margin: 0 0 0.5rem;
                color: #2d3748;
            }

            .performance-stat p {
                color: #718096;
                font-size: 0.875rem;
                font-weight: 600;
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            /* Low Stock Alerts */
            .alert-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                background: #fffbf0;
                border: 1px solid #fed7aa;
                border-radius: 10px;
                margin-bottom: 0.75rem;
                transition: all 0.3s ease;
            }

            .alert-item:hover {
                transform: translateX(3px);
                box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
            }

            .alert-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #fef3c7;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                flex-shrink: 0;
            }

            .alert-content {
                flex: 1;
            }

            .alert-content h4 {
                font-size: 0.95rem;
                font-weight: 700;
                color: #92400e;
                margin: 0 0 0.25rem;
            }

            .alert-content p {
                color: #a16207;
                font-size: 0.825rem;
                margin: 0;
            }

            .alert-stock {
                font-size: 1.25rem;
                flex-shrink: 0;
            }
        </style>
    @endsection

    <main class="app-content">
        <div class="container-fluid">
            <div class="dashboard-container animate__animated animate__fadeIn">
                <!-- Dashboard Header -->
                <div class="dashboard-header animate__animated animate__slideInDown">
                    <h1 class="dashboard-title">
                        <i class="bi bi-speedometer"></i>
                        {{ __('app.dashboard') }}
                    </h1>
                    <p class="dashboard-subtitle">{{ __('app.welcome_dashboard_message') }}</p>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid animate__animated animate__fadeInUp">
                    <div class="stat-card users">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <h3 class="stat-number">{{ number_format($stats['total_users']) }}</h3>
                        <p class="stat-label">{{ __('app.total_users') }}</p>
                        <div class="stat-growth {{ $stats['users_growth'] >= 0 ? 'growth-positive' : 'growth-negative' }}">
                            <i class="bi bi-arrow-{{ $stats['users_growth'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($stats['users_growth']) }}% {{ __('app.this_month') }}</span>
                        </div>
                    </div>

                    <div class="stat-card products">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="bi bi-box"></i>
                            </div>
                        </div>
                        <h3 class="stat-number">{{ number_format($stats['total_products']) }}</h3>
                        <p class="stat-label">{{ __('app.total_products') }}</p>
                        <div class="stat-growth growth-positive">
                            <i class="bi bi-arrow-up"></i>
                            <span>{{ __('app.active_products') }}</span>
                        </div>
                    </div>

                    <div class="stat-card orders">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                        <h3 class="stat-number">{{ number_format($stats['total_orders']) }}</h3>
                        <p class="stat-label">{{ __('app.total_orders') }}</p>
                        <div class="stat-growth {{ $stats['orders_growth'] >= 0 ? 'growth-positive' : 'growth-negative' }}">
                            <i class="bi bi-arrow-{{ $stats['orders_growth'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($stats['orders_growth']) }}% {{ __('app.this_month') }}</span>
                        </div>
                    </div>

                    <div class="stat-card revenue">
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                        <h3 class="stat-number">${{ number_format($stats['total_revenue'], 0) }}</h3>
                        <p class="stat-label">{{ __('app.total_revenue') }}</p>
                        <div class="stat-growth {{ $stats['revenue_growth'] >= 0 ? 'growth-positive' : 'growth-negative' }}">
                            <i class="bi bi-arrow-{{ $stats['revenue_growth'] >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ abs($stats['revenue_growth']) }}% {{ __('app.this_month') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="charts-section animate__animated animate__fadeInUp">
                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="bi bi-graph-up"></i>
                            {{ __('app.sales_trend') }} ({{ __('app.last_7_days') }})
                        </h3>
                        <div class="chart-canvas">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="bi bi-pie-chart"></i>
                            {{ __('app.order_status_distribution') }}
                        </h3>
                        <div class="chart-canvas">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>

                    <div class="chart-container">
                        <h3 class="chart-title">
                            <i class="bi bi-person-plus"></i>
                            {{ __('app.user_growth') }} ({{ __('app.last_12_months') }})
                        </h3>
                        <div class="chart-canvas">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Most Sold Products -->
                <div class="products-section animate__animated animate__fadeInUp">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="bi bi-trophy"></i>
                            {{ __('app.most_sold_products') }}
                        </h2>
                    </div>
                    <div class="products-grid">
                        @forelse($mostSoldProducts as $item)
                        <div class="product-card">
                            @if($item->product && $item->product->image)
                                <img src="{{ $item->product->image_url }}"
                                     alt="{{ $item->product->name }}"
                                     class="product-image">
                            @else
                                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-box text-muted"></i>
                                </div>
                            @endif
                            <h4 class="product-name">{{ $item->product->name ?? __('app.unknown_product') }}</h4>
                            <div class="product-sales">{{ $item->total_sold }} {{ __('app.sold') }}</div>
                            <div class="product-revenue">${{ number_format($item->total_revenue, 0) }} {{ __('app.revenue') }}</div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-box fs-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">{{ __('app.no_products_sold_yet') }}</h5>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Stats Mini Cards -->
                <div class="row g-3 mb-4 animate__animated animate__fadeInUp">
                    <div class="col-md-3">
                        <div class="mini-stat-card">
                            <div class="mini-stat-icon bg-success">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="mini-stat-content">
                                <h4>${{ number_format($quickStats['avg_order_value'], 2) }}</h4>
                                <p>{{ __('app.avg_order_value') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat-card">
                            <div class="mini-stat-icon bg-info">
                                <i class="bi bi-percent"></i>
                            </div>
                            <div class="mini-stat-content">
                                <h4>{{ $quickStats['conversion_rate'] }}%</h4>
                                <p>{{ __('app.conversion_rate') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat-card">
                            <div class="mini-stat-icon bg-warning">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="mini-stat-content">
                                <h4>{{ number_format($quickStats['orders_today']) }}</h4>
                                <p>{{ __('app.orders_today') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat-card">
                            <div class="mini-stat-icon bg-danger">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div class="mini-stat-content">
                                <h4>${{ number_format($quickStats['revenue_today'], 0) }}</h4>
                                <p>{{ __('app.revenue_today') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Analytics Section -->
                <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
                    <!-- Revenue Analytics Chart -->
                    <div class="col-xl-8">
                        <div class="chart-container">
                            <h3 class="chart-title">
                                <i class="bi bi-bar-chart"></i>
                                {{ __('app.revenue_analytics') }} ({{ __('app.last_6_months') }})
                            </h3>
                            <div class="chart-canvas">
                                <canvas id="revenueAnalyticsChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Metrics -->
                    <div class="col-xl-4">
                        <div class="performance-metrics">
                            <div class="metrics-header">
                                <h3 class="section-title">
                                    <i class="bi bi-speedometer2"></i>
                                    {{ __('app.performance_metrics') }}
                                </h3>
                            </div>
                            <div class="metrics-content">
                                <div class="metric-item">
                                    <div class="metric-label">{{ __('app.customer_lifetime_value') }}</div>
                                    <div class="metric-value">${{ number_format($performanceMetrics['customer_lifetime_value'], 2) }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">{{ __('app.orders_per_user') }}</div>
                                    <div class="metric-value">{{ number_format($performanceMetrics['orders_per_user'], 1) }}</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-label">{{ __('app.repeat_customer_rate') }}</div>
                                    <div class="metric-value">{{ $performanceMetrics['repeat_customer_rate'] }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed and System Health -->
                <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
                    <!-- Activity Feed -->
                    <div class="col-xl-8">
                        <div class="activity-feed">
                            <div class="feed-header">
                                <h3 class="section-title">
                                    <i class="bi bi-activity"></i>
                                    {{ __('app.recent_activities') }}
                                </h3>
                            </div>
                            <div class="feed-content">
                                @forelse($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon bg-{{ $activity['color'] }}">
                                        <i class="bi {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>{{ $activity['title'] }}</h4>
                                        <p>{{ $activity['description'] }}</p>
                                        <small class="activity-time">{{ $activity['time']->diffForHumans() }}</small>
                                    </div>
                                    @if($activity['amount'])
                                    <div class="activity-amount">
                                        ${{ number_format($activity['amount'], 2) }}
                                    </div>
                                    @endif
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-clock fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">{{ __('app.no_recent_activities') }}</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- System Health and Quick Actions -->
                    <div class="col-xl-4">
                        <div class="system-health mb-4">
                            <div class="health-header">
                                <h3 class="section-title">
                                    <i class="bi bi-shield-check"></i>
                                    {{ __('app.system_health') }}
                                </h3>
                            </div>
                            <div class="health-content">
                                <div class="health-item">
                                    <div class="health-label">{{ __('app.database') }}</div>
                                    <div class="health-status status-{{ $systemHealth['database']['status'] }}">
                                        <i class="bi bi-circle-fill"></i> {{ $systemHealth['database']['message'] }}
                                    </div>
                                </div>
                                <div class="health-item">
                                    <div class="health-label">{{ __('app.storage') }}</div>
                                    <div class="health-status status-{{ $systemHealth['storage']['status'] }}">
                                        <i class="bi bi-circle-fill"></i> {{ $systemHealth['storage']['message'] }}
                                    </div>
                                </div>
                                <div class="health-item">
                                    <div class="health-label">{{ __('app.cache') }}</div>
                                    <div class="health-status status-{{ $systemHealth['cache']['status'] }}">
                                        <i class="bi bi-circle-fill"></i> {{ $systemHealth['cache']['message'] }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <div class="actions-header">
                                <h3 class="section-title">
                                    <i class="bi bi-lightning"></i>
                                    {{ __('app.quick_actions') }}
                                </h3>
                            </div>
                            <div class="actions-grid">
                                <a href="{{ localized_route('dashboard.user.create') }}" class="action-card">
                                    <i class="bi bi-person-plus"></i>
                                    <span>{{ __('app.add_user') }}</span>
                                </a>
                                <a href="{{ localized_route('dashboard.product.create') }}" class="action-card">
                                    <i class="bi bi-box"></i>
                                    <span>{{ __('app.add_product') }}</span>
                                </a>
                                <a href="{{ localized_route('dashboard.order.index') }}" class="action-card">
                                    <i class="bi bi-receipt"></i>
                                    <span>{{ __('app.view_orders') }}</span>
                                </a>
                                <a href="{{ localized_route('dashboard.setting.index') }}" class="action-card">
                                    <i class="bi bi-gear"></i>
                                    <span>{{ __('app.settings') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Performance and Low Stock Alerts -->
                <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
                    <!-- Product Performance -->
                    <div class="col-xl-6">
                        <div class="product-performance">
                            <div class="performance-header">
                                <h3 class="section-title">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    {{ __('app.product_performance') }}
                                </h3>
                            </div>
                            <div class="performance-stats">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="performance-stat">
                                            <h4>{{ number_format($productPerformance['product_stats']['in_stock']) }}</h4>
                                            <p>{{ __('app.in_stock') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="performance-stat">
                                            <h4 class="text-warning">{{ number_format($productPerformance['product_stats']['low_stock']) }}</h4>
                                            <p>{{ __('app.low_stock') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="performance-stat">
                                            <h4 class="text-danger">{{ number_format($productPerformance['product_stats']['out_of_stock']) }}</h4>
                                            <p>{{ __('app.out_of_stock') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="performance-stat">
                                            <h4>{{ number_format($productPerformance['product_stats']['total_products']) }}</h4>
                                            <p>{{ __('app.total_products') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Alerts -->
                    <div class="col-xl-6">
                        <div class="low-stock-alerts">
                            <div class="alerts-header">
                                <h3 class="section-title">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    {{ __('app.low_stock_alerts') }}
                                </h3>
                            </div>
                            <div class="alerts-list">
                                @forelse($productPerformance['low_stock_products'] as $product)
                                <div class="alert-item">
                                    <div class="alert-icon">
                                        <i class="bi bi-box text-warning"></i>
                                    </div>
                                    <div class="alert-content">
                                        <h4>{{ $product->name }}</h4>
                                        <p>{{ __('app.stock_remaining') }}: {{ $product->stock }}</p>
                                    </div>
                                    <div class="alert-stock text-warning fw-bold">
                                        {{ $product->stock }}
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle fs-1 text-success"></i>
                                    <p class="text-muted mt-2">{{ __('app.no_low_stock_items') }}</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Data Tables -->
                <div class="tables-section animate__animated animate__fadeInUp">
                    <!-- Recent Users -->
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">
                                <i class="bi bi-people"></i>
                                {{ __('app.recent_users') }}
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.user') }}</th>
                                        <th>{{ __('app.email') }}</th>
                                        <th>{{ __('app.joined') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($user->getImagePath()) }}"
                                                     alt="{{ $user->name }}"
                                                     class="user-avatar-small">
                                                <span class="fw-semibold">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            {{ __('app.no_users_found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Top Spending Customers -->
                    <div class="table-container">
                        <div class="table-header">
                            <h3 class="table-title">
                                <i class="bi bi-star"></i>
                                {{ __('app.top_spending_customers') }}
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.customer') }}</th>
                                        <th>{{ __('app.total_spent') }}</th>
                                        <th>{{ __('app.orders_count') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($performanceMetrics['top_spending_customers'] as $customer)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($customer->getImagePath()) }}"
                                                     alt="{{ $customer->name }}"
                                                     class="user-avatar-small">
                                                <span class="fw-semibold">{{ $customer->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">${{ number_format($customer->total_spent ?? 0, 2) }}</span>
                                        </td>
                                        <td>{{ $customer->orders->count() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            {{ __('app.no_customers_yet') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @section('scripts')
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Chart.js Global Configuration
                Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
                Chart.defaults.color = '#718096';
                Chart.defaults.borderColor = '#e2e8f0';
                Chart.defaults.backgroundColor = 'rgba(102, 126, 234, 0.1)';

                // Check if elements exist before creating charts
                const salesElement = document.getElementById('salesTrendChart');
                if (salesElement) {
                    // Sales Trend Chart
                    const salesTrendData = {
                        labels: @json($salesTrendData['labels'] ?? []),
                        datasets: [{
                            label: '{{ __('app.daily_revenue') }}',
                            data: @json($salesTrendData['data'] ?? []),
                            borderColor: 'rgb(102, 126, 234)',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(102, 126, 234)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    };

                    new Chart(salesElement, {
                        type: 'line',
                        data: salesTrendData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: 'rgb(102, 126, 234)',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return '{{ __('app.revenue') }}: $' + context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.5)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Order Status Distribution Chart
                const orderStatusElement = document.getElementById('orderStatusChart');
                if (orderStatusElement) {
                    const orderStatusData = {
                        labels: [
                            '{{ __('app.pending') }}',
                            '{{ __('app.paid') }}',
                            '{{ __('app.completed') }}',
                            '{{ __('app.cancelled') }}'
                        ],
                        datasets: [{
                            data: [
                                {{ $orderStatusData['pending'] ?? 0 }},
                                {{ $orderStatusData['paid'] ?? 0 }},
                                {{ $orderStatusData['completed'] ?? 0 }},
                                {{ $orderStatusData['cancelled'] ?? 0 }}
                            ],
                            backgroundColor: [
                                'rgba(244, 183, 64, 0.8)',
                                'rgba(79, 172, 254, 0.8)',
                                'rgba(56, 161, 105, 0.8)',
                                'rgba(252, 70, 107, 0.8)'
                            ],
                            borderColor: [
                                'rgb(244, 183, 64)',
                                'rgb(79, 172, 254)',
                                'rgb(56, 161, 105)',
                                'rgb(252, 70, 107)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    };

                    new Chart(orderStatusElement, {
                        type: 'doughnut',
                        data: orderStatusData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.parsed || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                                            return label + ': ' + value + ' (' + percentage + '%)';
                                        }
                                    }
                                }
                            },
                            cutout: '60%'
                        }
                    });
                }

                // User Growth Chart
                const userGrowthElement = document.getElementById('userGrowthChart');
                if (userGrowthElement) {
                    const userGrowthData = {
                        labels: @json($userGrowthData['labels'] ?? []),
                        datasets: [{
                            label: '{{ __('app.new_users') }}',
                            data: @json($userGrowthData['data'] ?? []),
                            backgroundColor: 'rgba(79, 172, 254, 0.1)',
                            borderColor: 'rgb(79, 172, 254)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(79, 172, 254)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    };

                    new Chart(userGrowthElement, {
                        type: 'line',
                        data: userGrowthData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: 'rgb(79, 172, 254)',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return '{{ __('app.new_users') }}: ' + context.parsed.y;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.5)'
                                    },
                                    ticks: {
                                        stepSize: 1
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Revenue Analytics Chart
                const revenueElement = document.getElementById('revenueAnalyticsChart');
                if (revenueElement) {
                    const revenueAnalyticsData = {
                        labels: @json($revenueAnalytics['monthly']['labels'] ?? []),
                        datasets: [{
                            label: '{{ __('app.monthly_revenue') }}',
                            data: @json($revenueAnalytics['monthly']['data'] ?? []),
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderColor: 'rgb(102, 126, 234)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(102, 126, 234)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    };

                    new Chart(revenueElement, {
                        type: 'bar',
                        data: revenueAnalyticsData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: 'rgb(102, 126, 234)',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return '{{ __('app.revenue') }}: $' + context.parsed.y.toLocaleString();
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.5)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            });

            // Add hover effects to stat cards
            document.querySelectorAll('.stat-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add hover effects to chart containers
            document.querySelectorAll('.chart-container').forEach(container => {
                container.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                container.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add animations to elements when they come into view
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            }, observerOptions);

            // Observe elements for animation
            document.querySelectorAll('.stat-card, .chart-container, .product-card, .table-container').forEach(el => {
                observer.observe(el);
            });

            // Real-time clock
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString();
                const dateString = now.toLocaleDateString();
                document.title = `{{ __('app.dashboard') }} - ${timeString}`;
            }

            // Revenue Analytics Chart
            const revenueAnalyticsData = {
                labels: @json($revenueAnalytics['monthly']['labels']),
                datasets: [{
                    label: '{{ __('app.monthly_revenue') }}',
                    data: @json($revenueAnalytics['monthly']['data']),
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderColor: 'rgb(102, 126, 234)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(102, 126, 234)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            };

            const revenueAnalyticsChart = new Chart(document.getElementById('revenueAnalyticsChart'), {
                type: 'bar',
                data: revenueAnalyticsData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgb(102, 126, 234)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '{{ __('app.revenue') }}: $' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Update clock every second
            setInterval(updateClock, 1000);
            updateClock(); // Initialize immediately

            // Add real-time updates (optional)
            setInterval(function() {
                // You can add AJAX calls here to update dashboard data in real-time
                // This is just a placeholder for future implementation
            }, 300000); // Update every 5 minutes
        </script>

        <!-- Debug Script -->
        <script>
            console.log('Chart data debugging:');
            console.log('Sales Trend Data:', @json($salesTrendData));
            console.log('User Growth Data:', @json($userGrowthData));
            console.log('Order Status Data:', @json($orderStatusData));
            console.log('Revenue Analytics:', @json($revenueAnalytics));
            
            // Wait for DOM to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, checking chart elements:');
                console.log('Sales Chart Element:', document.getElementById('salesTrendChart'));
                console.log('Order Status Chart Element:', document.getElementById('orderStatusChart'));
                console.log('User Growth Chart Element:', document.getElementById('userGrowthChart'));
                console.log('Revenue Analytics Chart Element:', document.getElementById('revenueAnalyticsChart'));
            });
        </script>
    @endsection
</x-dashboard.layouts>
