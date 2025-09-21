<x-dashboard.layouts>

@section('css')
<link rel="stylesheet" href="{{ asset('dashboards/css/product.create.css') }}">
@endsection

<main class="app-content">
    <!-- Header Section -->
    <div class="app-title">
        <div>
            <h1><i class="bi bi-plus-circle"></i> {{ __('app.product_create') }}</h1>
            <p>{{ __('app.product_catalog_overview') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.welcome') }}">{{ __('app.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.product.index') }}">{{ __('app.products') }}</a></li>
            <li class="breadcrumb-item active">{{ __('app.product_create') }}</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="product-creation-wrapper">
        <div class="container-fluid">
            <!-- Creation Header -->
            <div class="creation-header fade-in">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2"><i class="bi bi-box-seam me-2"></i>{{ __('app.product_create') }}</h2>
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
                        <form id="productForm" method="POST" action="{{ localized_route('dashboard.product.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <!-- Basic Information -->
                            <div class="section-title">
                                <i class="bi bi-info-circle"></i>
                                <span>{{ __('app.information') }}</span>
                            </div>

                            {{-- name filed --}}
                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name.en') is-invalid @enderror" id="name_en" name="name[en]" value="{{ old('name.en') }}" placeholder="{{ __('app.product_name_english') }}" required>
                                    <label for="name_en">{{ __('app.name_en') }} *</label>
                                    @error('name.en')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name.ar') is-invalid @enderror" id="name_ar" name="name[ar]" value="{{ old('name.ar') }}" placeholder="{{ __('app.product_name_arabic') }}" required>
                                    <label for="name_ar">{{ __('app.name_ar') }} *</label>
                                    @error('name.ar')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- sku field --}}
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}" placeholder="{{ __('app.product_sku') }}" required>
                                    <label for="sku">{{ __('app.sku') }} *</label>
                                    @error('sku')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                {{-- barcode filed --}}
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode') }}" placeholder="{{ __('app.barcode') }}">
                                    <label for="barcode">{{ __('app.barcode') }}</label>
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

                            <div class="form-row">
                                {{-- price filed --}}
                                <div class="form-floating">
                                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="{{ __('app.price') }}" required>
                                    <label for="price">{{ __('app.price') }} *</label>
                                    @error('price')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    {{-- sale price filed --}}
                                    <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" placeholder="{{ __('app.sale_price') }}">
                                    <label for="sale_price">{{ __('app.sale_price') }}</label>
                                    @error('sale_price')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                {{-- stock filed --}}
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" placeholder="{{ __('app.stock_quantity') }}" required>
                                    <label for="stock">{{ __('app.stock') }} *</label>
                                    @error('stock')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    {{-- unit filed en--}}
                                    <input type="text" class="form-control @error('unit.en') is-invalid @enderror" id="unit_en" name="unit[en]" value="{{ old('unit.en') }}" placeholder="{{ __('app.unit_english') }}">
                                    <label for="unit_en">{{ __('app.unit_en') }}</label>
                                    @error('unit.en')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                            {{-- unit filed ar --}}
                            <div class="form-floating">
                                <input type="text" class="form-control @error('unit.ar') is-invalid @enderror" id="unit_ar" name="unit[ar]" value="{{ old('unit.ar') }}" placeholder="{{ __('app.unit_arabic') }}">
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

                            {{-- description filed en --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description.en') is-invalid @enderror" id="description_en" name="description[en]" style="height: 100px" placeholder="{{ __('app.description_english') }}">{{ old('description.en') }}</textarea>
                                <label for="description_en">{{ __('app.description_en') }}</label>
                                @error('description.en')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- description filed ar --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description.ar') is-invalid @enderror" id="description_ar" name="description[ar]" style="height: 100px" placeholder="{{ __('app.description_arabic') }}">{{ old('description.ar') }}</textarea>
                                <label for="description_ar">{{ __('app.description_ar') }}</label>
                                @error('description.ar')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- nutrition en -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('nutrition.en') is-invalid @enderror" id="nutrition_en" name="nutrition[en]" style="height: 80px" placeholder="{{ __('app.nutritional_info_english') }}">{{ old('nutrition.en') }}</textarea>
                                <label for="nutrition_en">{{ __('app.nutrition_en') }}</label>
                                @error('nutrition.en')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- nutrition ar --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('nutrition.ar') is-invalid @enderror" id="nutrition_ar" name="nutrition[ar]" style="height: 80px" placeholder="{{ __('app.nutritional_info_arabic') }}">{{ old('nutrition.ar') }}</textarea>
                                <label for="nutrition_ar">{{ __('app.nutrition_ar') }}</label>
                                @error('nutrition.ar')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="form-floating mb-3">
                                <select class="form-select @error('rate') is-invalid @enderror" id="rate" name="rate">
                                    <option value="1" {{ old('rate') == '1' ? 'selected' : '' }}>⭐ 1 {{ __('app.stars') }}</option>
                                    <option value="2" {{ old('rate') == '2' ? 'selected' : '' }}>⭐⭐ 2 {{ __('app.stars') }}</option>
                                    <option value="3" {{ old('rate', '3') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 {{ __('app.stars') }}</option>
                                    <option value="4" {{ old('rate') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 {{ __('app.stars') }}</option>
                                    <option value="5" {{ old('rate') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 {{ __('app.stars') }}</option>
                                </select>
                                <label for="rate">{{ __('app.product_rating') }}</label>
                                @error('rate')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <!-- Product Image -->
                            <div class="section-title mt-4">
                                <i class="bi bi-image"></i>
                                <span>{{ __('app.product_image') }}</span>
                            </div>

                            <div class="image-upload-zone @error('image') border-danger @enderror" onclick="document.getElementById('image').click()">
                                <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                                <div id="image-placeholder">
                                    <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                                    <h5>{{ __('app.upload_image') }}</h5>
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
                            @error('image')
                                <div class="text-danger mt-2"><strong>{{ $message }}</strong></div>
                            @enderror

                            <!-- Status -->
                            <div class="form-check-modern @error('is_active') border-danger @enderror">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
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
                                <button type="submit" class="w-100  mb-3 btn-lg btn btn-outline-primary cu-rounded">
                                    <i class="bi bi-plus-circle me-2"></i>{{ __('app.create_product') }}
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
                                <i class="bi bi-box-seam"></i>
                            </div>

                            <div class="product-preview-content">
                                <div class="preview-price" id="preview-price">$0.00</div>

                                <h5 class="mb-2" id="preview-name">{{ __('app.product_name_placeholder') }}</h5>
                                <p class="mb-2 opacity-75" id="preview-description">{{ __('app.product_description_placeholder') }}</p>

                                <div class="preview-badges">
                                    <span class="preview-badge" id="preview-sku">{{ __('app.sku_label') }}: -</span>
                                    <span class="preview-badge" id="preview-stock">{{ __('app.stock_label') }}: 0</span>
                                    <span class="preview-badge" id="preview-unit">{{ __('app.unit_label') }}: -</span>
                                </div>

                                <div class="mt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div id="preview-rating">⭐⭐⭐</div>
                                        <small class="opacity-75">{{ __('app.product_rating_text') }}</small>
                                    </div>
                                </div>

                                <div class="mt-3" id="preview-status">
                                    <span class="badge bg-success">{{ __('app.active') }}</span>
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
    @includeIf('dashboard.product.__create')
@endsection

</x-dashboard.layouts>
