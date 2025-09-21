<x-dashboard.layouts>

    @section('css')
        <link rel="stylesheet" href="{{ asset('dashboards/css/product.css') }}">
    @endsection

    @php
        $totalProducts = $products->count();
        $activeProducts = $products->where('is_active', true)->count();
        $onSaleProducts = $products->filter(function($p){ return !is_null($p->sale_price); })->count();
        $lowStockProducts = $products->filter(function($p){ return (int) $p->stock > 0 && (int) $p->stock < 10; })->count();
        $outOfStockProducts = $products->filter(function($p){ return (int) $p->stock === 0; })->count();
    @endphp


      <main class="app-content">

            {{-- title --}}
            <div class="app-title">
                  <div>
                        <h1 class="mb-1"><i class="bi bi-box-seam"></i> {{ __('app.products') }}</h1>
                        <p class="text-muted mb-0">{{ __('app.product_catalog_overview') }}</p>
                  </div>
                  <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                        <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.welcome') }}">{{ __('app.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('app.products') }}</li>
                  </ul>
            </div>

              {{-- filter --}}
            <div class="row g-3">
                <div class="col-12">
                    <div class="tile cu-rounded">
                        <div class="tile-body">
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center">
                                <div class="d-flex flex-column flex-lg-row align-items-stretch align-items-lg-center gap-3 w-100 w-md-50">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                        <input id="productSearch" type="search" class="form-control" placeholder="{{ __('app.search_by_name_or_sku') }}">
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-light btn-sm cu-rounded filter-pill active" data-filter="all">{{ __('app.all') }}</button>
                                        <button class="btn btn-light btn-sm cu-rounded filter-pill" data-filter="active">{{ __('app.active') }}</button>
                                        <button class="btn btn-light btn-sm cu-rounded filter-pill" data-filter="sale">{{ __('app.on_sale') }}</button>
                                        <button class="btn btn-light btn-sm cu-rounded filter-pill" data-filter="low">{{ __('app.low_stock') }}</button>
                                        <button class="btn btn-light btn-sm cu-rounded filter-pill" data-filter="out">{{ __('app.out') }}</button>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 ms-md-auto align-items-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm cu-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-arrow-down-up"></i> {{ __('app.sort') }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="created" data-dir="desc">{{ __('app.newest_first') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="created" data-dir="asc">{{ __('app.oldest_first') }}</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="name" data-dir="asc">{{ __('app.name_a_to_z') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="name" data-dir="desc">{{ __('app.name_z_to_a') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="price" data-dir="asc">{{ __('app.price_low_to_high') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="price" data-dir="desc">{{ __('app.price_high_to_low') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="stock" data-dir="desc">{{ __('app.stock_high_to_low') }}</a></li>
                                            <li><a class="dropdown-item sort-option" href="#" data-sort="fav" data-dir="desc">{{ __('app.favorites') }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="View toggle">
                                        <button class="btn btn-outline-secondary cu-rounded view-toggle active" data-view="grid" title="{{ __('app.grid') }}">
                                            <i class="bi bi-grid"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary cu-rounded view-toggle" data-view="list" title="{{ __('app.list') }}">
                                            <i class="bi bi-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- status --}}
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="card cu-rounded shadow-sm border-0 h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('app.total') }}</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="h5 mb-0">{{ $totalProducts }}</span>
                                <i class="bi bi-box-seam text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card cu-rounded shadow-sm border-0 h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('app.active') }}</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="h5 mb-0">{{ $activeProducts }}</span>
                                <span class="badge bg-success-subtle text-success border">ON</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card cu-rounded shadow-sm border-0 h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('app.on_sale') }}</div>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="h5 mb-0">{{ $onSaleProducts }}</span>
                                <i class="bi bi-tags-fill text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card cu-rounded shadow-sm border-0 h-100">
                        <div class="card-body py-3">
                            <div class="text-muted small">{{ __('app.stock_alerts') }}</div>
                            <div class="d-flex align-items-baseline gap-3">
                                <span class="badge bg-warning-subtle text-warning border">{{ __('app.low') }}: {{ $lowStockProducts }}</span>
                                <span class="badge bg-danger-subtle text-danger border">{{ __('app.out') }}: {{ $outOfStockProducts }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- products --}}
            <div class="row g-3 mt-2">
                <div class="col-12">
                    <div class="">
                        <div class="tile-body">
                            @if($products->isEmpty())
                                <div class="text-center py-5">
                                    <i class="bi bi-box-seam fs-1 text-muted"></i>
                                    <h5 class="mt-3">{{ __('app.no_products_yet') }}</h5>
                                    <p class="text-muted mb-3">{{ __('app.create_first_product') }}</p>
                                    <a href="{{ localized_route('dashboard.product.create') }}" class="btn btn-outline-primary cu-rounded">
                                        <i class="bi bi-plus"></i> {{ __('app.product_create') }}
                                    </a>
                                </div>
                            @else
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3" id="productGrid">
                                    @foreach($products as $product)
                                        @php
                                            $name = $product->name;
                                            $sku = $product->sku;
                                            $unit = $product->unit;
                                            $rawPrice = (float) $product->price;
                                            $price = number_format($rawPrice, 2);
                                            $sale = $product->sale_price !== null ? number_format((float) $product->sale_price, 2) : null;
                                            $stock = (int) $product->stock;
                                            $isActive = (bool) $product->is_active;
                                            $favCount = $product->favored_by_count ?? 0;
                                            $description = $product->description;
                                            $nutrition = $product->nutrition;
                                            $barcode = $product->barcode;
                                            $createdAt = $product->formatted_created_at;
                                        @endphp
                                        <div class="col product-card tr" data-name="{{ strtolower($name) }}" data-sku="{{ strtolower($sku) }}" data-price="{{ $rawPrice }}" data-stock="{{ $stock }}" data-fav="{{ $favCount }}" data-active="{{ $isActive ? 1 : 0 }}" data-sale="{{ $sale ? 1 : 0 }}" data-low="{{ $stock > 0 && $stock < 10 ? 1 : 0 }}" data-out="{{ $stock == 0 ? 1 : 0 }}" data-created="{{ $product->created_at->timestamp }}">
                                            <div class="card cu-rounded card-neo h-100 border-0 hover-lift overflow-hidden">
                                                <div class="product-image-wrap cu-rounded">
                                                    <div class="ratio ratio-16x9 bg-light position-relative cu-rounded">
                                                        <img src="{{ $product->image_url }}" alt="{{ $name }}" class="card-img-top" style="object-fit: cover;">
                                                        <div class="img-gradient position-absolute top-0 start-0 w-100 h-100"></div>

                                                        <!-- Quick Preview Button -->
                                                        <button class="quick-preview-btn" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
                                                            <i class="bi bi-eye-fill fs-5"></i>
                                                        </button>
                                                    </div>

                                                    @php
                                                        $discount = null;
                                                        if ($sale && ((float) $product->sale_price) < ((float) $product->price)) {
                                                            $discount = (int) round((1 - ((float) $product->sale_price / (float) $product->price)) * 100);
                                                        }
                                                    @endphp
                                                    @if($discount)
                                                        <div class="ribbon"><span>-{{ $discount }}%</span></div>
                                                    @endif

                                                    <!-- Top overlays -->
                                                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-2 flex-wrap">
                                                        <span class="badge glass-badge text-dark fw-semibold cu-rounded">
                                                            {{ $isActive ? __('app.active') : __('app.inactive') }}
                                                        </span>
                                                    </div>

                                                    <!-- Heart bubble -->
                                                    <div class="position-absolute top-0 end-0 m-2">
                                                        <span class="heart-bubble d-inline-flex align-items-center justify-content-center rounded-circle p-2">
                                                            <i class="bi bi-heart-fill text-danger me-1"></i>
                                                            <span class="small fw-semibold">{{ $favCount }}</span>
                                                        </span>
                                                    </div>

                                                    <!-- SKU chip -->
                                                    <span class="sku-chip position-absolute bottom-0 start-0 m-2">
                                                        <i class="bi bi-upc"></i> {{ $sku }}
                                                    </span>

                                                    <!-- Price chip -->
                                                    <div class="price-chip">
                                                        @if($sale)
                                                            <span class="me-1">{{ setting('currency') }}{{ $sale }}</span>
                                                            <span class="sale-strike text-decoration-line-through">{{ setting('currency') }}{{ $price }}</span>
                                                        @else
                                                            <span>{{ setting('currency') }}{{ $price }}</span>
                                                        @endif
                                                    </div>

                                                    <!-- Actionbar -->
                                                    <div class="actionbar">
                                                        <a href="{{ localized_route('dashboard.product.edit', [$product]) }}" class="btn btn-sm btn-primary text-white cu-rounded" title="{{ __('app.edit_product') }}">
                                                            <i class="bi bi-pencil m-0"></i>
                                                        </a>
                                                        <form action="{{ localized_route('dashboard.product.destroy', [$product]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger btn-delete cu-rounded" title="{{ __('app.delete_product') }}">
                                                                <i class="bi bi-trash m-0"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <div class="card-body d-flex flex-column">
                                                    <!-- Product title and unit -->
                                                    <div class="d-flex align-items-start gap-2 mb-2">
                                                        <h6 class="card-title mb-0 line-clamp-2 flex-grow-1" title="{{ $name }}">
                                                            {{ $name }}
                                                        </h6>
                                                        @if($unit)
                                                            <span class="product-tag">
                                                                <i class="bi bi-box2"></i> {{ $unit }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Product rating -->
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= (int) $product->rate)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="small text-muted">({{ (int) $product->rate }}.0)</span>
                                                        <span class="ms-auto small text-muted">{{ $favCount }} ♥</span>
                                                    </div>

                                                    <!-- Product description (visible in grid, expandable in list) -->
                                                    @if($description)
                                                        <p class="small text-muted line-clamp-2 product-description d-none d-lg-block mb-2">
                                                            {{ $description }}
                                                        </p>
                                                    @endif

                                                    <!-- Product specifications table (hidden in grid, visible in list) -->
                                                    <div class="specs-wrapper d-none mb-3">
                                                        <table class="specs-table w-100">
                                                            @if($barcode)
                                                                <tr>
                                                                    <td><i class="bi bi-upc-scan me-1"></i> {{ __('app.barcode') }}</td>
                                                                    <td><code class="small">{{ $barcode }}</code></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td><i class="bi bi-calendar3 me-1"></i> {{ __('app.created') }}</td>
                                                                <td>{{ $createdAt }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="bi bi-boxes me-1"></i> {{ __('app.stock') }}</td>
                                                                <td>
                                                                    <span class="badge {{ $stock == 0 ? 'bg-danger' : ($stock < 10 ? 'bg-warning' : 'bg-primary') }}-subtle border">
                                                                        {{ $stock }} {{ __('app.units') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @if($nutrition)
                                                                <tr>
                                                                    <td><i class="bi bi-heart-pulse me-1"></i> {{ __('app.nutrition') }}</td>
                                                                    <td>
                                                                        <span class="badge bg-primary-subtle text-primary border">
                                                                            <i class="bi bi-check-circle"></i> {{ __('app.available') }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>

                                                    <!-- Stock progress and status -->
                                                    <div class="mb-2">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="small text-muted">{{ __('app.stock') }}</span>
                                                            <span class="small fw-medium {{ $stock == 0 ? 'text-danger' : ($stock < 10 ? 'text-warning' : 'text-primary') }}">
                                                                {{ $stock }} {{ __('app.units') }}
                                                            </span>
                                                        </div>
                                                        <div class="progress stock-progress cu-rounded">
                                                            @php
                                                                $stockPercent = $stock == 0 ? 5 : ($stock < 10 ? 25 : min(100, ($stock / 100) * 100));
                                                            @endphp
                                                            <div class="progress-bar {{ $stock == 0 ? 'bg-danger' : ($stock < 10 ? 'bg-warning' : 'bg-primary') }}"
                                                                 role="progressbar"
                                                                 style="width: {{ $stockPercent }}%"
                                                                 aria-valuenow="{{ $stockPercent }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Quick info badges -->
                                                    <div class="mt-auto">
                                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                                            @if($barcode)
                                                                <span class="barcode-chip">
                                                                    <i class="bi bi-upc-scan"></i> {{ $barcode }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <!-- Product timestamp -->
                                                        <div class="product-timestamp">
                                                            <i class="bi bi-clock"></i>
                                                            <span>{{ __('app.added') }} {{ $createdAt }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Modern Pagination Controls -->
                                <div class="pagination-wrapper" id="paginationWrapper" style="display: none;">
                                    <div class="pagination-info">
                                        <span id="paginationInfo">{{ __('app.showing') }} 1-12 {{ __('app.of') }} 24 {{ __('app.products') }}</span>
                                    </div>

                                    <div class="pagination-nav" id="paginationNav">
                                        <button class="page-btn nav-btn" id="firstPageBtn" title="{{ __('app.first_page') }}">
                                            <i class="bi bi-chevron-double-left"></i>
                                        </button>
                                        <button class="page-btn nav-btn" id="prevPageBtn" title="{{ __('app.previous_page') }}">
                                            <i class="bi bi-chevron-left"></i> {{ __('app.prev') }}
                                        </button>

                                        <div id="pageNumbers">
                                            <!-- Page numbers will be dynamically generated -->
                                        </div>

                                        <button class="page-btn nav-btn" id="nextPageBtn" title="{{ __('app.next_page') }}">
                                            {{ __('app.next') }} <i class="bi bi-chevron-right"></i>
                                        </button>
                                        <button class="page-btn nav-btn" id="lastPageBtn" title="{{ __('app.last_page') }}">
                                            <i class="bi bi-chevron-double-right"></i>
                                        </button>
                                    </div>

                                    <div class="page-size-selector">
                                        <label for="pageSize">{{ __('app.show') }}:</label>
                                        <select id="pageSize">
                                            <option value="6">6</option>
                                            <option value="12" selected>12</option>
                                            <option value="24">24</option>
                                            <option value="48">48</option>
                                            <option value="all">{{ __('app.all') }}</option>
                                        </select>
                                        <span>{{ __('app.per_page') }}</span>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Preview Modals -->
            @if(!$products->isEmpty())
                @foreach($products as $product)
                    @php
                        $name = $product->name;
                        $sku = $product->sku;
                        $unit = $product->unit;
                        $rawPrice = (float) $product->price;
                        $price = number_format($rawPrice, 2);
                        $sale = $product->sale_price !== null ? number_format((float) $product->sale_price, 2) : null;
                        $stock = (int) $product->stock;
                        $isActive = (bool) $product->is_active;
                        $favCount = $product->favored_by_count ?? 0;
                        $description = $product->description;
                        $nutrition = $product->nutrition;
                        $barcode = $product->barcode;
                        $createdAt = $product->formatted_created_at;
                    @endphp
                    <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 cu-rounded">
                                <div class="modal-header border-0 pb-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="product-image-preview" style="width: 60px; height: 60px; border-radius: .5rem; overflow: hidden; background: var(--bs-light);">
                                            <img src="{{ $product->image_url }}" alt="{{ $name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h5 class="modal-title mb-0" id="productModalLabel-{{ $product->id }}">{{ $name }}</h5>
                                            <span class="text-muted small">
                                                <i class="bi bi-upc me-1"></i>{{ $sku }}
                                                @if($unit) • {{ $unit }}@endif
                                            </span>
                                        </div>
                                        <div class="ms-auto d-flex gap-2">
                                            @if($sale)
                                                <span class="badge bg-danger-subtle text-danger border fs-6">
                                                    @php
                                                        $discount = (int) round((1 - ((float) $product->sale_price / (float) $product->price)) * 100);
                                                    @endphp
                                                    -{{ $discount }}% OFF
                                                </span>
                                            @endif
                                            <span class="badge {{ $isActive ? 'bg-success' : 'bg-danger' }}-subtle {{ $isActive ? 'text-success' : 'text-danger' }} border">
                                                {{ $isActive ? __('app.active') : __('app.inactive') }}
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('app.close') }}"></button>
                                </div>
                                <div class="modal-body pt-2">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="product-preview-image">
                                                <div class="ratio ratio-1x1 bg-light cu-rounded overflow-hidden position-relative">
                                                    <img src="{{ $product->image_url }}" alt="{{ $name }}" style="object-fit: cover; width: 100%; height: 100%;">
                                                    @if($sale)
                                                        <div class="position-absolute top-0 start-0 m-2">
                                                            <span class="badge bg-danger text-white">
                                                                -{{ $discount }}% OFF
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="product-details">
                                                <!-- Price Section -->
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-baseline gap-2 mb-2">
                                                        @if($sale)
                                                            <span class="h4 text-primary mb-0">{{ setting('currency') }}{{ $sale }}</span>
                                                            <span class="text-muted text-decoration-line-through">{{ setting('currency') }}{{ $price }}</span>
                                                        @else
                                                            <span class="h4 text-primary mb-0">{{ setting('currency') }}{{ $price }}</span>
                                                        @endif
                                                        @if($unit)
                                                            <span class="text-muted">/ {{ $unit }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Rating Section -->
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= (int) $product->rate)
                                                                <i class="bi bi-star-fill text-warning"></i>
                                                            @else
                                                                <i class="bi bi-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="text-muted">({{ (int) $product->rate }}.0)</span>
                                                        <span class="ms-auto text-muted">{{ $favCount }} ♥ {{ __('app.favorites') }}</span>
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                @if($description)
                                                    <div class="mb-3">
                                                        <h6 class="text-muted mb-2">{{ __('app.description') }}</h6>
                                                        <p class="mb-0">{{ $description }}</p>
                                                    </div>
                                                @endif

                                                <!-- Product Details Table -->
                                                <div class="mb-3">
                                                    <h6 class="text-muted mb-2">{{ __('app.product_details') }}</h6>
                                                    <table class="table table-sm table-borderless mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-muted"><i class="bi bi-boxes me-1"></i> {{ __('app.stock') }}:</td>
                                                                <td>
                                                                    <span class="badge {{ $stock == 0 ? 'bg-danger' : ($stock < 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                                                                        {{ $stock }} {{ __('app.units') }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted"><i class="bi bi-upc-scan me-1"></i> {{ __('app.sku') }}:</td>
                                                                <td><code>{{ $sku }}</code></td>
                                                            </tr>
                                                            @if($barcode)
                                                                <tr>
                                                                    <td class="text-muted"><i class="bi bi-upc me-1"></i> {{ __('app.barcode') }}:</td>
                                                                    <td><code>{{ $barcode }}</code></td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ __('app.created') }}:</td>
                                                                <td>{{ $createdAt }}</td>
                                                            </tr>
                                                            @if($nutrition)
                                                                <tr>
                                                                    <td class="text-muted"><i class="bi bi-heart-pulse me-1"></i> {{ __('app.nutrition') }}:</td>
                                                                    <td>
                                                                        <span class="badge bg-success-subtle text-success">
                                                                            <i class="bi bi-check-circle me-1"></i>{{ __('app.available') }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>

                                                @if($nutrition)
                                                    <div class="mb-3">
                                                        <h6 class="text-muted mb-2">{{ __('app.nutritional_information') }}</h6>
                                                        <div class="bg-light p-3 cu-rounded">
                                                            <pre class="mb-0 small text-wrap">{{ $nutrition }}</pre>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-2">
                                    <div class="d-flex gap-2 w-100">
                                        <a href="{{ localized_route('dashboard.product.edit', [$product]) }}" class="btn btn-primary">
                                            <i class="bi bi-pencil me-1"></i> {{ __('app.edit_product') }}
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary ms-auto" data-bs-dismiss="modal">{{ __('app.close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

      </main>

      @section('scripts')
       <script src="{{ asset('dashboards/js/product.js') }}"></script>
      @endsection

</x-dashboard.layouts>
