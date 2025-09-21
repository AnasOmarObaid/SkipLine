<x-dashboard.layouts>
      @section('css')
            <link href="https://cdn.datatables.net/v/bs5/dt-2.3.3/datatables.min.css" rel="stylesheet"
                  integrity="sha384-CoUEazvx+MklR7+tLlL048g8FXNPCgFr7HP39p0DQojPC16bnlchqDSzQK3Td1BU" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap5.min.css">
            <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.3/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/datatables.min.css"
                  rel="stylesheet" integrity="sha384-LNyH/Z9Q461Cc4QrpeqQ9cAMcUPB0uiozvh36L5BLFXDF2I7A5ut9odNxBAhHbdf"
                  crossorigin="anonymous">
            <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

            <style>
                :root {
                    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
                    --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
                    --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
                    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                    --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
                    --hover-shadow: 0 15px 35px rgba(0,0,0,0.15);
                    --border-radius: 20px;
                }

                body {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                }

                .app-content {
                    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                    min-height: 100vh;
                }

                .users-container {
                    padding: 2rem 0;
                }

                .page-header {
                    background: white;
                    border-radius: var(--border-radius);
                    padding: 2rem;
                    margin-bottom: 2rem;
                    box-shadow: var(--card-shadow);
                    position: relative;
                    overflow: hidden;
                }

                .page-header::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    height: 5px;
                    background: var(--primary-gradient);
                }

                .page-title {
                    font-size: 2.5rem;
                    font-weight: 800;
                    color: #2d3748;
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .page-title i {
                    background: var(--primary-gradient);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }

                .page-subtitle {
                    color: #718096;
                    font-size: 1.1rem;
                    margin: 0.5rem 0 0;
                    font-weight: 500;
                }

                .breadcrumb-nav {
                    background: #f8fafc;
                    border-radius: 15px;
                    padding: 1rem 1.5rem;
                    margin-top: 1.5rem;
                }

                .breadcrumb {
                    margin: 0;
                    background: none;
                }

                .breadcrumb-item {
                    color: #718096;
                    font-weight: 500;
                }

                .breadcrumb-item.active {
                    color: #667eea;
                    font-weight: 600;
                }

                .breadcrumb-item a {
                    color: #4a5568;
                    text-decoration: none;
                    transition: color 0.3s ease;
                }

                .breadcrumb-item a:hover {
                    color: #667eea;
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

                .stat-card.success::before { background: var(--success-gradient); }
                .stat-card.warning::before { background: var(--warning-gradient); }
                .stat-card.danger::before { background: var(--danger-gradient); }
                .stat-card.info::before { background: var(--info-gradient); }

                .stat-card:hover {
                    transform: translateY(-5px);
                    box-shadow: var(--hover-shadow);
                }

                .stat-icon {
                    width: 70px;
                    height: 70px;
                    border-radius: 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 2rem;
                    margin-bottom: 1.5rem;
                    background: var(--primary-gradient);
                    color: white;
                    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
                }

                .stat-card.success .stat-icon {
                    background: var(--success-gradient);
                    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
                }

                .stat-card.warning .stat-icon {
                    background: var(--warning-gradient);
                    box-shadow: 0 8px 25px rgba(250, 112, 154, 0.3);
                }

                .stat-card.danger .stat-icon {
                    background: var(--danger-gradient);
                    box-shadow: 0 8px 25px rgba(252, 70, 107, 0.3);
                }

                .stat-card.info .stat-icon {
                    background: var(--info-gradient);
                    box-shadow: 0 8px 25px rgba(168, 237, 234, 0.3);
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
                    margin: 0.5rem 0 0;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .stat-trend {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    margin-top: 1rem;
                    font-size: 0.875rem;
                    font-weight: 600;
                }

                .trend-up {
                    color: #38a169;
                }

                .trend-down {
                    color: #e53e3e;
                }

                .table-container {
                    background: white;
                    border-radius: var(--border-radius);
                    box-shadow: var(--card-shadow);
                    overflow: hidden;
                    margin-bottom: 2rem;
                }

                .table-header {
                    background: var(--primary-gradient);
                    color: white;
                    padding: 2rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 1rem;
                }

                .table-title {
                    font-size: 1.5rem;
                    font-weight: 700;
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                }

                .table-actions {
                    display: flex;
                    gap: 1rem;
                    align-items: center;
                    flex-wrap: wrap;
                }

                .btn-modern {
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    border: none;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    text-decoration: none;
                    font-size: 0.875rem;
                }

                .btn-primary-modern {
                    background: var(--primary-gradient);
                    color: white;
                    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                }

                .btn-primary-modern:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
                    color: white;
                }

                .btn-outline-modern {
                    background: rgba(255, 255, 255, 0.2);
                    color: white;
                    border: 2px solid rgba(255, 255, 255, 0.3);
                    backdrop-filter: blur(10px);
                }

                .btn-outline-modern:hover {
                    background: rgba(255, 255, 255, 0.3);
                    border-color: rgba(255, 255, 255, 0.5);
                    transform: translateY(-2px);
                    color: white;
                }

                .filters-section {
                    background: #f8fafc;
                    padding: 1.5rem 2rem;
                    border-bottom: 1px solid #e2e8f0;
                }

                .filters-row {
                    display: grid;
                    grid-template-columns: 1fr auto;
                    gap: 2rem;
                    align-items: center;
                }

                .search-container {
                    position: relative;
                    max-width: 400px;
                }

                .search-input {
                    width: 100%;
                    padding: 1rem 1rem 1rem 3rem;
                    border: 2px solid #e2e8f0;
                    border-radius: 15px;
                    font-size: 1rem;
                    transition: all 0.3s ease;
                    background: white;
                }

                .search-input:focus {
                    outline: none;
                    border-color: #667eea;
                    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                }

                .search-icon {
                    position: absolute;
                    left: 1rem;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #718096;
                    font-size: 1.25rem;
                }

                .table-body {
                    padding: 0;
                }

                #userTable {
                    margin: 0;
                    border: none;
                }

                #userTable thead th {
                    background: #f8fafc;
                    border: none;
                    padding: 1.5rem;
                    font-weight: 700;
                    color: #2d3748;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.875rem;
                    border-bottom: 2px solid #e2e8f0;
                }

                #userTable tbody td {
                    padding: 1.5rem;
                    border: none;
                    border-bottom: 1px solid #f1f5f9;
                    vertical-align: middle;
                }

                #userTable tbody tr {
                    transition: all 0.3s ease;
                }

                #userTable tbody tr:hover {
                    background-color: #f8fafc;
                    transform: scale(1.01);
                    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                }

                .user-avatar {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 3px solid #e2e8f0;
                    transition: all 0.3s ease;
                }

                .user-avatar:hover {
                    transform: scale(1.1);
                    border-color: #667eea;
                }

                .user-name {
                    font-weight: 700;
                    color: #2d3748;
                    font-size: 1.1rem;
                    margin: 0;
                }

                .user-email {
                    color: #718096;
                    font-size: 0.9rem;
                    margin: 0.25rem 0 0;
                }

                .user-info {
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                }

                .status-badge {
                    padding: 0.5rem 1rem;
                    border-radius: 25px;
                    font-size: 0.75rem;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .status-verified {
                    background: linear-gradient(135deg, #c6f6d5 0%, #68d391 100%);
                    color: #22543d;
                }

                .status-unverified {
                    background: linear-gradient(135deg, #fed7d7 0%, #fc8181 100%);
                    color: #742a2a;
                }

                .action-buttons {
                    display: flex;
                    gap: 0.5rem;
                    align-items: center;
                }

                .btn-action {
                    width: 40px;
                    height: 40px;
                    border-radius: 10px;
                    border: none;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: all 0.3s ease;
                    font-size: 1rem;
                    position: relative;
                }

                .btn-action:hover {
                    transform: translateY(-2px);
                }

                .btn-view {
                    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                    color: white;
                    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
                }

                .btn-edit {
                    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
                    color: white;
                    box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);
                }

                .btn-delete {
                    background: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
                    color: white;
                    box-shadow: 0 4px 15px rgba(252, 70, 107, 0.3);
                }

                .modal-xl .modal-content {
                    border-radius: var(--border-radius);
                    border: none;
                    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
                }

                .modal-header {
                    background: var(--primary-gradient);
                    color: white;
                    border-radius: var(--border-radius) var(--border-radius) 0 0;
                    padding: 2rem;
                }

                .modal-title {
                    font-weight: 700;
                    font-size: 1.5rem;
                }

                .dataTables_wrapper .dataTables_length select,
                .dataTables_wrapper .dataTables_filter input {
                    border: 2px solid #e2e8f0;
                    border-radius: 10px;
                    padding: 0.5rem;
                }

                .dataTables_wrapper .dataTables_paginate .paginate_button {
                    padding: 0.5rem 1rem;
                    margin: 0 0.25rem;
                    border-radius: 8px;
                    border: none;
                    background: #f8fafc;
                    color: #4a5568;
                }

                .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                    background: var(--primary-gradient) !important;
                    color: white !important;
                }

                .dt-buttons .btn {
                    margin: 0 0.25rem;
                    padding: 0.5rem 1rem;
                    border-radius: 8px;
                    border: none;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    font-size: 0.75rem;
                }

                .buttons-excel {
                    background: #28a745;
                    color: white;
                }

                .buttons-pdf {
                    background: #dc3545;
                    color: white;
                }

                .buttons-print {
                    background: #17a2b8;
                    color: white;
                }

                .buttons-csv {
                    background: #6c757d;
                    color: white;
                }

                .buttons-copy {
                    background: #ffc107;
                    color: #212529;
                }

                .buttons-colvis {
                    background: #6f42c1;
                    color: white;
                }

                @media (max-width: 768px) {
                    .users-container {
                        padding: 1rem 0;
                    }

                    .page-header {
                        padding: 1.5rem;
                        margin-bottom: 1.5rem;
                    }

                    .page-title {
                        font-size: 1.75rem;
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 0.5rem;
                    }

                    .stats-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }

                    .stat-card {
                        padding: 1.5rem;
                    }

                    .stat-number {
                        font-size: 2rem;
                    }

                    .table-header {
                        flex-direction: column;
                        align-items: flex-start;
                        padding: 1.5rem;
                    }

                    .table-actions {
                        width: 100%;
                        justify-content: space-between;
                        margin-top: 1rem;
                    }

                    .filters-row {
                        grid-template-columns: 1fr;
                        gap: 1rem;
                    }

                    .search-container {
                        max-width: 100%;
                    }

                    .action-buttons {
                        justify-content: center;
                    }

                    .user-info {
                        flex-direction: column;
                        text-align: center;
                        gap: 0.5rem;
                    }
                }

                @media (max-width: 480px) {
                    .stats-grid {
                        grid-template-columns: 1fr;
                    }

                    .page-title {
                        font-size: 1.5rem;
                    }

                    .table-header,
                    .page-header,
                    .stat-card {
                        padding: 1rem;
                    }

                    .filters-section {
                        padding: 1rem;
                    }
                }

                .animate__animated {
                    animation-duration: 0.8s;
                }
            </style>
      @endsection
      <main class="app-content">
            <div class="container-fluid">
                  <div class="users-container animate__animated animate__fadeIn">
                  <!-- Page Header -->
                  <div class="page-header animate__animated animate__slideInDown">
                        <h1 class="page-title">
                              <i class="bi bi-people-fill"></i>
                              {{ __('app.users_management') }}
                        </h1>
                        <p class="page-subtitle">{{ __('app.manage_and_monitor_users') }}</p>

                        <nav class="breadcrumb-nav">
                              <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                          <a href="{{ localized_route('dashboard.welcome') }}">
                                                <i class="bi bi-house-door me-1"></i>{{ __('app.dashboard') }}
                                          </a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ __('app.users') }}</li>
                              </ol>
                        </nav>
                  </div>

                  <!-- Statistics Cards -->
                  <div class="stats-grid animate__animated animate__fadeInUp">
                        <div class="stat-card">
                              <div class="stat-icon">
                                    <i class="bi bi-people"></i>
                              </div>
                              <h3 class="stat-number">{{ $users->count() }}</h3>
                              <p class="stat-label">{{ __('app.total_users') }}</p>
                              <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up"></i>
                                    <span>+12% {{ __('app.this_month') }}</span>
                              </div>
                        </div>

                        <div class="stat-card success">
                              <div class="stat-icon">
                                    <i class="bi bi-person-check"></i>
                              </div>
                              <h3 class="stat-number">{{ $users->whereNotNull('email_verified_at')->count() }}</h3>
                              <p class="stat-label">{{ __('app.verified_users') }}</p>
                              <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up"></i>
                                    <span>+8% {{ __('app.this_week') }}</span>
                              </div>
                        </div>

                        <div class="stat-card warning">
                              <div class="stat-icon">
                                    <i class="bi bi-person-x"></i>
                              </div>
                              <h3 class="stat-number">{{ $users->whereNull('email_verified_at')->count() }}</h3>
                              <p class="stat-label">{{ __('app.unverified_users') }}</p>
                              <div class="stat-trend trend-down">
                                    <i class="bi bi-arrow-down"></i>
                                    <span>-3% {{ __('app.this_week') }}</span>
                              </div>
                        </div>

                        <div class="stat-card info">
                              <div class="stat-icon">
                                    <i class="bi bi-person-plus"></i>
                              </div>
                              <h3 class="stat-number">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                              <p class="stat-label">{{ __('app.new_this_month') }}</p>
                              <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up"></i>
                                    <span>+15% {{ __('app.vs_last_month') }}</span>
                              </div>
                        </div>
                  </div>

                  <!-- Users Table -->
                  <div class="table-container animate__animated animate__fadeInUp">
                        <div class="table-header">
                              <h2 class="table-title">
                                    <i class="bi bi-table"></i>
                                    {{ __('app.users_list') }}
                              </h2>
                              <div class="table-actions">
                                    <div id="userTable_wrapperButton"></div>
                                    <a href="{{ localized_route('dashboard.user.create') }}" class="btn-modern btn-primary-modern">
                                          <i class="bi bi-plus-lg"></i>
                                          {{ __('app.add_new_user') }}
                                    </a>
                              </div>
                        </div>

                        <div class="filters-section">
                              <div class="filters-row">
                                    <div class="search-container">
                                          <i class="search-icon bi bi-search"></i>
                                          <input type="text" class="search-input" id="globalSearch"
                                                placeholder="{{ __('app.search_users') }}...">
                                    </div>
                                    <div class="filter-controls">
                                          <select class="form-select" id="statusFilter" style="min-width: 150px;">
                                                <option value="">{{ __('app.all_statuses') }}</option>
                                                <option value="verified">{{ __('app.verified') }}</option>
                                                <option value="unverified">{{ __('app.unverified') }}</option>
                                          </select>
                                    </div>
                              </div>
                        </div>

                        <div class="table-body">
                              <table id="userTable" class="table">
                                    <thead>
                                          <tr>
                                                <th>#</th>
                                                <th class="no-sort">{{ __('app.user') }}</th>
                                                <th>{{ __('app.contact_info') }}</th>
                                                <th>{{ __('app.status') }}</th>
                                                <th>{{ __('app.orders') }}</th>
                                                <th>{{ __('app.joined') }}</th>
                                                <th class="no-sort">{{ __('app.actions') }}</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach ($users as $index => $user)
                                          <tr>
                                                <td>
                                                      <span class="fw-bold text-muted">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </td>
                                                <td>
                                                      <div class="user-info">
                                                            <img class="user-avatar" src="{{ asset($user->getImagePath()) }}" alt="{{ $user->name }}">
                                                            <div>
                                                                  <h6 class="user-name">{{ $user->name }}</h6>
                                                                  <p class="user-email">{{ $user->email }}</p>
                                                            </div>
                                                      </div>
                                                </td>
                                                <td>
                                                      <div>
                                                            <div class="mb-1">
                                                                  <i class="bi bi-telephone me-2 text-muted"></i>
                                                                  <span>{{ $user->phone ?: __('app.not_provided') }}</span>
                                                            </div>
                                                            <div>
                                                                  <i class="bi bi-geo-alt me-2 text-muted"></i>
                                                                  <span>{{ Str::limit($user->address ?: __('app.not_provided'), 30) }}</span>
                                                            </div>
                                                      </div>
                                                </td>
                                                <td>
                                                      @if($user->email_verified_at)
                                                            <span class="status-badge status-verified">
                                                                  <i class="bi bi-check-circle me-1"></i>
                                                                  {{ __('app.verified') }}
                                                            </span>
                                                      @else
                                                            <span class="status-badge status-unverified">
                                                                  <i class="bi bi-x-circle me-1"></i>
                                                                  {{ __('app.unverified') }}
                                                            </span>
                                                      @endif
                                                </td>
                                                <td>
                                                      <span class="fw-bold text-primary">{{ $user->orders->count() }}</span>
                                                      <small class="text-muted d-block">{{ __('app.total_orders') }}</small>
                                                </td>
                                                <td>
                                                      <div>
                                                            <span class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                                                            <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                                      </div>
                                                </td>
                                                <td>
                                                      <div class="action-buttons">
                                                            <button class="btn-action btn-view view-user-btn"
                                                                  data-user-id="{{ $user->id }}"
                                                                  data-url="{{ localized_route('dashboard.user.show', [$user->id]) }}"
                                                                  title="{{ __('app.view_orders') }}">
                                                                  <i class="bi bi-eye"></i>
                                                            </button>

                                                            <a href="{{ localized_route('dashboard.user.edit', [$user]) }}"
                                                               class="btn-action btn-edit"
                                                               title="{{ __('app.edit_user') }}">
                                                                  <i class="bi bi-pencil-square"></i>
                                                            </a>

                                                            <form action="{{ localized_route('dashboard.user.destroy', [$user]) }}"
                                                                  method="post" class="d-inline">
                                                                  @csrf
                                                                  @method('DELETE')
                                                                  <button type="submit" class="btn-action btn-delete btn-delete-confirm"
                                                                        title="{{ __('app.delete_user') }}">
                                                                        <i class="bi bi-trash"></i>
                                                                  </button>
                                                            </form>
                                                      </div>
                                                </td>
                                          </tr>
                                          @endforeach
                                    </tbody>
                              </table>
                        </div>
                  </div>
                  </div>
            </div>

      <!-- Modal for User Preview -->
      <div class="modal modal-xl fade" id="userPreviewModal" tabindex="-1" aria-labelledby="userPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userPreviewModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="userPreviewContent">
                        <!-- Tickets and bookings will be loaded here -->
                    </div>
                </div>
            </div>
      </div>

      </main>

      @section('scripts')
            <script src="https://cdn.datatables.net/v/bs5/dt-2.3.3/datatables.min.js"
                  integrity="sha384-ojz3MK3bx1Hb+Bu7oACSEUC9lgGaVZwak7rlgV4yKmSv2BAcRldS4GUz7NqRuAnn" crossorigin="anonymous">
            </script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.6/js/dataTables.responsive.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.6/js/responsive.bootstrap5.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"
                  integrity="sha384-P2rohseTZr3+/y/u+6xaOAE3CIkcmmC0e7ZjhdkTilUMHfNHCerfVR9KICPeFMOP" crossorigin="anonymous">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"
                  integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous">
            </script>
            <script
                  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.3/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/datatables.js"
                  integrity="sha384-hD4H5eNTpwxgHNVQJOxRxoE8PyGs1b5T2mVaub4P9ult0pmm+MB6gip45K27gRQp" crossorigin="anonymous">
            </script>
            <script src="{{ asset('dashboards/js/user.js') }}"></script>
      @endsection

</x-dashboard.layouts>
