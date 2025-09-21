<x-dashboard.layouts>

@section('css')
    <link rel="stylesheet" href="{{ asset('dashboards/css/user.edit.css') }}">
@endsection

<main class="app-content">

    <!-- Header Section -->
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-gear"></i> {{ __('app.user_edit') }}</h1>
            <p>{{ __('app.welcome_dashboard_message') }}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.welcome') }}">{{ __('app.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ localized_route('dashboard.user.index') }}">{{ __('app.users') }}</a></li>
            <li class="breadcrumb-item active">{{ __('app.user_edit') }}</li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="user-creation-wrapper">
        <div class="container-fluid">
            <!-- Creation Header -->
            <div class="creation-header fade-in">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2"><i class="bi bi-person-gear me-2"></i>{{ __('app.user_edit') }}</h2>
                        <p class="mb-0 opacity-75">{{ __('app.edit_user_description') }}</p>
                    </div>
                    <div style="z-index: 1000" class="col-md-4 text-md-{{ app()->getLocale() == 'ar' ? 'start' : 'end' }}">
                        <a href="{{ localized_route('dashboard.user.index') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>{{ __('app.users') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-7">
                    <div class="form-section fade-in">
                        <form id="userForm" method="POST" action="{{ localized_route('dashboard.user.update', [$user]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- User Image -->
                            <div class="section-title">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ __('app.user_image') }}</span>
                            </div>

                            <div class="image-upload-zone" id="imageUploadZone" onclick="document.getElementById('user_image').click()">
                                <input type="file" name="image" id="user_image" accept="image/*" style="display: none;">
                                <div id="image-placeholder" @if($user->image) style="display: none;" @endif>
                                    <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                                    <h5>{{ __('app.upload_image') }}</h5>
                                    <p class="text-muted">{{ __('app.click_to_upload_user_photo') }}</p>
                                    <small class="text-muted">{{ __('app.supported_formats') }}</small>
                                </div>
                                <div id="image-preview-container" @if(!$user->image) style="display: none;" @endif>
                                    <img id="image-preview" class="image-preview" src="{{ $user->image ? asset($user->getImagePath()) : '' }}" alt="Preview">
                                    <button type="button" class="remove-image" onclick="removeImage(event)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="section-title">
                                <i class="bi bi-info-circle"></i>
                                <span>{{ __('app.information') }}</span>
                            </div>

                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ __('app.name') }}">
                                    <label for="name">{{ __('app.name') }}</label>
                                    @error('name')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ __('app.email') }}">
                                    <label for="email">{{ __('app.email') }}</label>
                                    @error('email')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="{{ __('app.phone') }}">
                                    <label for="phone">{{ __('app.phone') }}</label>
                                    @error('phone')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="{{ __('app.address') }}">
                                    <label for="address">{{ __('app.address') }}</label>
                                    @error('address')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Verification -->
                            <div class="form-check-modern">
                                <input class="form-check-input" type="checkbox" id="validEmail" name="email_verified_at" value="1" {{ old('email_verified_at', $user->email_verified_at) ? 'checked' : '' }}>
                                <label class="form-check-label" for="validEmail">
                                    <strong>{{ __('app.mark_a_valid_email') }}</strong>
                                    <br><small class="text-muted">{{ __('app.user_verified_email_status') }}</small>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-update">
                                    <i class="bi bi-arrow-clockwise me-2"></i>{{ __('app.update') }} {{ __('app.user') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="col-lg-5">
                    <div class="preview-section fade-in">
                        <h4 class="mb-3"><i class="bi bi-eye me-2"></i>{{ __('app.user_preview') }}</h4>

                        <div class="user-preview-card pulse" id="user-preview">
                            <div class="user-avatar-section">
                                <img id="previewImage" class="user-avatar" src="{{ $user->image ? asset($user->getImagePath()) : 'https://placehold.co/120x120/0d6efd/ffffff?text=User' }}" alt="User Avatar">
                                <h5 class="mb-1" id="name_preview">{{ old('name', $user->name) }}</h5>
                                <p class="mb-0 opacity-75">{{ __('app.regular_user') }}</p>
                            </div>

                            <div class="user-details-section">
                                <div class="detail-item">
                                    <span class="detail-label"><i class="bi bi-envelope me-2"></i>{{ __('app.email') }}</span>
                                    <span class="detail-value" id="email_preview">{{ old('email', $user->email) }}</span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label"><i class="bi bi-shield-lock me-2"></i>{{ __('app.password') }}</span>
                                    <span class="detail-value" id="password_preview">{{ __('app.not_allowed_to_preview') }}</span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label"><i class="bi bi-telephone me-2"></i>{{ __('app.phone') }}</span>
                                    <span class="detail-value" id="phone_preview">{{ old('phone', $user->phone) ?: '-' }}</span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label"><i class="bi bi-geo-alt me-2"></i>{{ __('app.address') }}</span>
                                    <span class="detail-value" id="address_preview">{{ old('address', $user->address) ?: '-' }}</span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label"><i class="bi bi-patch-check me-2"></i>{{ __('app.valid_email') }}</span>
                                    <span class="status-badge" id="previewStatus">{{ old('email_verified_at', $user->email_verified_at) ? __('app.verify_email') : __('app.unverified') }}</span>
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
    @includeIf('dashboard.user.__edit')
@endsection

</x-dashboard.layouts>
