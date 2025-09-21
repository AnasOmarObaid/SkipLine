<x-dashboard.layouts>

@section('css')
<link rel="stylesheet" href="{{ asset('dashboards/css/product.create.css') }}">
<link rel="stylesheet" href="{{ asset('dashboards/css/product.edit.css') }}">
@endsection

<main class="app-content">
    <!-- Header Section -->
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> {{ __('app.product_edit') }}</h1>
            <p>{{ __('app.product_catalog_overview') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.welcome') }}">{{ __('app.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.product.index') }}">{{ __('app.products') }}</a></li>
            <li class="breadcrumb-item active">{{ __('app.product_edit') }}</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="product-creation-wrapper">
        <div class="container-fluid">
            <!-- Creation Header -->
            <div class="creation-header fade-in">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2"><i class="bi bi-box-seam me-2"></i>{{ __('app.product_edit') }}</h2>
                        <p class="mb-0 opacity-75">{{ __('app.fill_product_details') }}</p>
                    </div>
                    <div class="col-md-4 text-md-{{ app()->getLocale() == 'ar' ? 'start' : 'end' }}">
                        <button type="button" class="btn btn-preview" onclick="generatePreview()">
                            <i class="bi bi-eye me-2"></i>{{ __('app.view_details') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-7">
                    <div class="form-section fade-in">
                        <form id="productForm" method="POST" action="{{ localized_route('dashboard.product.update', [$product]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information -->
                            <div class="section-title">
                                <i class="bi bi-info-circle"></i>
                                <span>{{ __('app.information') }}</span>
                            </div>

                            {{-- name field --}}
                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name.en') is-invalid @enderror"
                                           id="name_en" name="name[en]"
                                           value="{{ old('name.en', $product->getTranslation('name', 'en')) }}"
                                           placeholder="{{ __('app.product_name_english') }}"
                                           required
                                           data-preview="name">
                                    <label for="name_en">{{ __('app.name_en') }} *</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.product_name_info') ?: 'Enter a descriptive product name' }}
                                    </div>
                                    @error('name.en')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name.ar') is-invalid @enderror"
                                           id="name_ar" name="name[ar]"
                                           value="{{ old('name.ar', $product->getTranslation('name', 'ar')) }}"
                                           placeholder="{{ __('app.product_name_arabic') }}"
                                           required>
                                    <label for="name_ar">{{ __('app.name_ar') }} *</label>
                                    @error('name.ar')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            {{-- sku field --}}
                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                           id="sku" name="sku"
                                           value="{{ old('sku', $product->sku) }}"
                                           placeholder="{{ __('app.product_sku') }}"
                                           pattern="[A-Za-z0-9-_]+"
                                           title="{{ __('app.sku_pattern') ?: 'SKU can only contain letters, numbers, hyphens, and underscores' }}"
                                           data-preview="sku"
                                           required>
                                    <label for="sku">{{ __('app.sku') }} *</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.sku_info') ?: 'Unique product identifier (letters, numbers, hyphens, underscores)' }}
                                    </div>
                                    @error('sku')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                {{-- barcode field --}}
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                           id="barcode" name="barcode"
                                           value="{{ old('barcode', $product->barcode) }}"
                                           placeholder="{{ __('app.barcode') }}"
                                           data-preview="barcode">
                                    <label for="barcode">{{ __('app.barcode') }}</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.barcode_info') ?: 'Optional barcode for inventory management' }}
                                    </div>
                                    @error('barcode')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Pricing-->
                            <div class="section-title mt-4">
                                <i class="bi bi-currency-dollar"></i>
                                <span>{{ __('app.pricing_and_stock') }}</span>
                            </div>

                            {{-- price field --}}
                            <div class="form-row">

                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                           id="price" name="price"
                                           value="{{ old('price', $product->price) }}"
                                           placeholder="{{ __('app.price') }}"
                                           min="0"
                                           data-preview="price"
                                           required>
                                    <label for="price">{{ __('app.price') }} *</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.price_info') ?: 'Regular price of the product' }}
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    {{-- sale price field --}}
                                    <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror"
                                           id="sale_price" name="sale_price"
                                           value="{{ old('sale_price', $product->sale_price) }}"
                                           placeholder="{{ __('app.sale_price') }}"
                                           min="0"
                                           data-preview="salePrice">
                                    <label for="sale_price">{{ __('app.sale_price') }}</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.sale_price_info') ?: 'Discounted price (leave empty if no discount)' }}
                                    </div>
                                    @error('sale_price')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            {{-- stock field --}}
                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                           id="stock" name="stock"
                                           value="{{ old('stock', $product->stock) }}"
                                           placeholder="{{ __('app.stock_quantity') }}"
                                           min="0"
                                           data-preview="stock"
                                           required>
                                    <label for="stock">{{ __('app.stock') }} *</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.stock_info') ?: 'Current inventory quantity' }}
                                    </div>
                                    @error('stock')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    {{-- unit field en--}}
                                    <input type="text" class="form-control @error('unit.en') is-invalid @enderror"
                                           id="unit_en" name="unit[en]"
                                           value="{{ old('unit.en', $product->getTranslation('unit', 'en')) }}"
                                           placeholder="{{ __('app.unit_english') }}"
                                           data-preview="unit">
                                    <label for="unit_en">{{ __('app.unit_en') }}</label>
                                    <div class="field-info">
                                        <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.unit_info') ?: 'Unit of measurement (e.g., kg, pcs, oz)' }}
                                    </div>
                                    @error('unit.en')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            {{-- unit field ar --}}
                            <div class="form-floating">
                                <input type="text" class="form-control @error('unit.ar') is-invalid @enderror"
                                       id="unit_ar" name="unit[ar]"
                                       value="{{ old('unit.ar', $product->getTranslation('unit', 'ar')) }}"
                                       placeholder="{{ __('app.unit_arabic') }}">
                                <label for="unit_ar">{{ __('app.unit_ar') }}</label>
                                @error('unit.ar')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- Description-->
                            <div class="section-title mt-4">
                                <i class="bi bi-card-text"></i>
                                <span>{{ __('app.description') }}</span>
                            </div>

                            {{-- description field en --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description.en') is-invalid @enderror"
                                          id="description_en" name="description[en]"
                                          style="height: 100px"
                                          placeholder="{{ __('app.description_english') }}"
                                          data-preview="description">{{ old('description.en', $product->getTranslation('description', 'en')) }}</textarea>
                                <label for="description_en">{{ __('app.description_en') }}</label>
                                <div class="field-info">
                                    <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.description_info') ?: 'Detailed product description with key features' }}
                                </div>
                                @error('description.en')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- description field ar --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description.ar') is-invalid @enderror"
                                          id="description_ar" name="description[ar]"
                                          style="height: 100px"
                                          placeholder="{{ __('app.description_arabic') }}">{{ old('description.ar', $product->getTranslation('description', 'ar')) }}</textarea>
                                <label for="description_ar">{{ __('app.description_ar') }}</label>
                                @error('description.ar')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- nutrition en -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('nutrition.en') is-invalid @enderror"
                                          id="nutrition_en" name="nutrition[en]"
                                          style="height: 80px"
                                          placeholder="{{ __('app.nutritional_info_english') }}"
                                          data-preview="nutrition">{{ old('nutrition.en', $product->getTranslation('nutrition', 'en')) }}</textarea>
                                <label for="nutrition_en">{{ __('app.nutrition_en') }}</label>
                                <div class="field-info">
                                    <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.nutrition_info') ?: 'Nutritional information (optional)' }}
                                </div>
                                @error('nutrition.en')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- nutrition ar --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('nutrition.ar') is-invalid @enderror" id="nutrition_ar" name="nutrition[ar]" style="height: 80px" placeholder="{{ __('app.nutritional_info_arabic') }}">{{ old('nutrition.ar', $product->getTranslation('nutrition', 'ar')) }}</textarea>
                                <label for="nutrition_ar">{{ __('app.nutrition_ar') }}</label>
                                @error('nutrition.ar')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="form-floating mb-3">
                                <select class="form-select @error('rate') is-invalid @enderror"
                                        id="rate" name="rate"
                                        data-preview="rating">
                                    <option value="1" {{ old('rate', $product->rate) == '1' ? 'selected' : '' }}>⭐ 1 {{ __('app.stars') }}</option>
                                    <option value="2" {{ old('rate', $product->rate) == '2' ? 'selected' : '' }}>⭐⭐ 2 {{ __('app.stars') }}</option>
                                    <option value="3" {{ old('rate', $product->rate) == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 {{ __('app.stars') }}</option>
                                    <option value="4" {{ old('rate', $product->rate) == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 {{ __('app.stars') }}</option>
                                    <option value="5" {{ old('rate', $product->rate) == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 {{ __('app.stars') }}</option>
                                </select>
                                <label for="rate">{{ __('app.product_rating') }}</label>
                                <div class="field-info">
                                    <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.rating_info') ?: 'Product quality rating (1-5 stars)' }}
                                </div>
                                @error('rate')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- Product Image -->
                            <div class="section-title mt-4">
                                <i class="bi bi-image"></i>
                                <span>{{ __('app.product_image') }}</span>
                            </div>

                            {{-- image preview --}}
                            <div class="image-upload-zone @error('image') border-danger @enderror" onclick="document.getElementById('image').click()">
                                <input type="file" id="image" name="image" accept="image/*" style="display: none;" data-preview="image">

                                @if($product->image)
                                <!-- Current product image -->
                                <div class="current-image-container">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->getTranslation('name', 'en') }}" class="current-product-image">
                                    <span class="current-image-label">{{ __('app.current_image') ?: 'Current Image' }}</span>
                                </div>
                                @endif

                                <div id="image-placeholder" {!! $product->image ? 'style="display: none;"' : '' !!}>
                                    <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                                    <h5>{{ __('app.upload_new_image') ?: 'Upload New Image' }}</h5>
                                    <p class="text-muted">{{ __('app.drag_drop_image') }}</p>
                                    <small class="text-muted">{{ __('app.image_formats_supported') }}</small>
                                </div>
                                <div id="image-preview-container" style="display: none;">
                                    <img id="image-preview" class="image-preview" src="" alt="Preview">
                                    <button type="button" class="remove-image" onclick="removeImage(event)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="field-info">
                                <i class="bi bi-info-circle-fill me-1"></i> {{ __('app.image_info') ?: 'Recommended size: 800x800px, max 5MB' }}
                            </div>
                            @error('image')
                                <div class="text-danger mt-2"><strong>{{ $message }}</strong></div>
                            @enderror

                            <!-- Status -->
                            <div class="form-check-modern @error('is_active') border-danger @enderror">
                                <input class="form-check-input" type="checkbox"
                                       id="is_active" name="is_active"
                                       value="1"
                                       {{ old('is_active', $product->is_active) == '1' ? 'checked' : '' }}
                                       data-preview="status">
                                <label class="form-check-label" for="is_active">
                                    <strong>{{ __('app.active_product') }}</strong>
                                    <br><small class="text-muted">{{ __('app.product_visible_store') }}</small>
                                </label>
                            </div>
                            @error('is_active')
                                <div class="text-danger mt-2"><strong>{{ $message }}</strong></div>
                            @enderror

                            <!-- Submit Buttons -->
                            <div class="text-center mt-4">
                                <button type="submit" class="w-100 mb-3 btn-lg btn btn-outline-primary cu-rounded">
                                    <i class="bi bi-check-circle me-2"></i>{{ __('app.update_product') }}
                                </button>
                                <a href="{{ localized_route('dashboard.product.index') }}" class="w-100 d-block btn-lg btn btn-outline-warning cu-rounded">
                                    <i class="bi bi-arrow-left me-2"></i>{{ __('app.back_to_products') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="col-lg-5">
                    <div class="preview-section fade-in">
                        <h4 class="mb-3"><i class="bi bi-eye me-2"></i>{{ __('app.live_preview') }}</h4>

                        <div class="product-preview-card pulse" id="product-preview">
                            <div class="product-preview-image" id="preview-image">
                                @if($product->image)
                                <img src="{{ asset($product->image_url) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 1rem;" alt="Product">
                                @else
                                <i class="bi bi-box-seam"></i>
                                @endif
                            </div>

                            <div class="product-preview-content">
                                <div class="preview-price" id="preview-price">
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        ${{ $product->sale_price }} <small style="text-decoration: line-through; opacity: 0.7;">${{ $product->price }}</small>
                                    @else
                                        ${{ $product->price }}
                                    @endif
                                </div>

                                <h5 class="mb-2" id="preview-name">{{ $product->getTranslation('name', 'en') }}</h5>
                                <p class="mb-2 opacity-75" id="preview-description">{{ $product->getTranslation('description', 'en') ?: __('app.product_description_placeholder') }}</p>

                                <div class="preview-badges">
                                    <span class="preview-badge" id="preview-sku">{{ __('app.sku_label') }}: {{ $product->sku }}</span>
                                    <span class="preview-badge" id="preview-stock">{{ __('app.stock_label') }}: {{ $product->stock }}</span>
                                    <span class="preview-badge" id="preview-unit">{{ __('app.unit_label') }}: {{ $product->getTranslation('unit', 'en') }}</span>
                                    @if($product->barcode)
                                    <span class="preview-badge" id="preview-barcode">{{ __('app.barcode_label') ?: 'Barcode' }}: {{ $product->barcode }}</span>
                                    @endif
                                </div>

                                @if($product->getTranslation('nutrition', 'en'))
                                <div class="mt-2">
                                    <small class="d-block text-muted" id="preview-nutrition"><strong>{{ __('app.nutrition_label') ?: 'Nutrition' }}:</strong> {{ $product->getTranslation('nutrition', 'en') }}</small>
                                </div>
                                @endif

                                <div class="mt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div id="preview-rating">{{ str_repeat('⭐', $product->rate) }}</div>
                                        <small class="opacity-75">{{ __('app.product_rating_text') }}</small>
                                    </div>
                                </div>

                                <div class="mt-3" id="preview-status">
                                    @if($product->is_active)
                                    <span class="badge bg-success">{{ __('app.active') }}</span>
                                    @else
                                    <span class="badge bg-danger">{{ __('app.inactive') ?: 'Inactive' }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <small class="text-muted">{{ __('app.preview_updates_automatically') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@section('scripts')
    @include('dashboard.product.__edit')
@endsection

</x-dashboard.layouts>
