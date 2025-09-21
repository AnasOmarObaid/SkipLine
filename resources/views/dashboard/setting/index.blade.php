<x-dashboard.layouts>

@section('css')
<link rel="stylesheet" href="{{ asset('dashboards/css/setting.css') }}">
@endsection

<main class="app-content">
    <div class="settings-wrapper">
        <div class="settings-container">
            <!-- Header -->
            <div class="settings-header">
                <h1><i class="bi bi-gear-fill"></i> {{ __('app.application_settings') ?: 'Application Settings' }}</h1>
                <p>{{ __('app.configure_application_settings') ?: 'Configure your application settings and preferences' }}</p>
            </div>

            <!-- Navigation Tabs -->
            <div class="settings-nav">
                <ul class="nav nav-pills nav-fill" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                            <i class="bi bi-gear me-2"></i>{{ __('app.general') ?: 'General' }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="appearance-tab" data-bs-toggle="pill" data-bs-target="#appearance" type="button" role="tab">
                            <i class="bi bi-palette me-2"></i>{{ __('app.appearance') ?: 'Appearance' }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications" type="button" role="tab">
                            <i class="bi bi-bell me-2"></i>{{ __('app.notifications') ?: 'Notifications' }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="pill" data-bs-target="#social" type="button" role="tab">
                            <i class="bi bi-share me-2"></i>{{ __('app.social_media') ?: 'Social Media' }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="advanced-tab" data-bs-toggle="pill" data-bs-target="#advanced" type="button" role="tab">
                            <i class="bi bi-sliders me-2"></i>{{ __('app.advanced') ?: 'Advanced' }}
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Settings Content -->
            <div class="settings-content">
                <form action="{{ localized_route('dashboard.setting.store') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                    @csrf

                    <div class="tab-content" id="settingsTabsContent">

                        <!-- General Settings -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="setting-section">
                                <div class="section-title">
                                    <i class="bi bi-info-circle-fill"></i>
                                    <h3>{{ __('app.basic_information') ?: 'Basic Information' }}</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('app_name') is-invalid @enderror"
                                                   id="app_name" name="app_name"
                                                   value="{{ old('app_name', setting('app_name')) }}"
                                                   placeholder="{{ __('app.application_name') ?: 'Application Name' }}" required>
                                            <label for="app_name">{{ __('app.application_name') ?: 'Application Name' }} *</label>
                                            @error('app_name')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('app_version') is-invalid @enderror"
                                                   id="app_version" name="app_version"
                                                   value="{{ old('app_version', setting('app_version')) }}"
                                                   placeholder="{{ __('app.version') ?: 'Version' }}" required>
                                            <label for="app_version">{{ __('app.application_version') ?: 'Application Version' }} *</label>
                                            @error('app_version')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="url" class="form-control"
                                                   value="{{ request()->getSchemeAndHttpHost() }}" readonly>
                                            <label>{{ __('app.website_url') ?: 'Website URL' }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control"
                                                   value="{{ auth()->user()->email }}" readonly>
                                            <label>{{ __('app.admin_email') ?: 'Admin Email' }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('app_content') is-invalid @enderror"
                                              id="app_content" name="app_content"
                                              style="height: 100px"
                                              placeholder="{{ __('app.website_description') ?: 'Website Description' }}">{{ old('app_content', setting('app_content')) }}</textarea>
                                    <label for="app_content">{{ __('app.website_description') ?: 'Website Description' }}</label>
                                    @error('app_content')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control @error('app_phone_number') is-invalid @enderror"
                                                   id="app_phone_number" name="app_phone_number"
                                                   value="{{ old('app_phone_number', setting('app_phone_number')) }}"
                                                   placeholder="{{ __('app.phone_number') ?: 'Phone Number' }}">
                                            <label for="app_phone_number">{{ __('app.contact_phone') ?: 'Contact Phone' }}</label>
                                            @error('app_phone_number')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                                   id="contact_email" name="contact_email"
                                                   value="{{ old('contact_email', setting('contact_email')) }}"
                                                   placeholder="{{ __('app.contact_email') ?: 'Contact Email' }}">
                                            <label for="contact_email">{{ __('app.contact_email') ?: 'Contact Email' }}</label>
                                            @error('contact_email')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('app_address') is-invalid @enderror"
                                              id="app_address" name="app_address"
                                              style="height: 80px"
                                              placeholder="{{ __('app.business_address') ?: 'Business Address' }}">{{ old('app_address', setting('app_address')) }}</textarea>
                                    <label for="app_address">{{ __('app.business_address') ?: 'Business Address' }}</label>
                                    @error('app_address')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Appearance Settings -->
                        <div class="tab-pane fade" id="appearance" role="tabpanel">
                            <div class="setting-section">
                                <div class="section-title">
                                    <i class="bi bi-palette-fill"></i>
                                    <h3>{{ __('app.appearance_customization') ?: 'Appearance Customization' }}</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('app.primary_color') ?: 'Primary Color' }}</label>
                                        <div class="color-picker-wrapper">
                                            <input type="color" class="form-control @error('primary_color') is-invalid @enderror"
                                                   id="primary_color" name="primary_color"
                                                   value="{{ old('primary_color', setting('primary_color', '#667eea')) }}">
                                            <div class="color-preview" id="primary_preview"></div>
                                        </div>
                                        @error('primary_color')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('app.secondary_color') ?: 'Secondary Color' }}</label>
                                        <div class="color-picker-wrapper">
                                            <input type="color" class="form-control @error('secondary_color') is-invalid @enderror"
                                                   id="secondary_color" name="secondary_color"
                                                   value="{{ old('secondary_color', setting('secondary_color', '#764ba2')) }}">
                                            <div class="color-preview" id="secondary_preview"></div>
                                        </div>
                                        @error('secondary_color')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('theme_mode') is-invalid @enderror"
                                                    id="theme_mode" name="theme_mode">
                                                <option value="light" {{ old('theme_mode', setting('theme_mode')) == 'light' ? 'selected' : '' }}>{{ __('app.light_mode') ?: 'Light Mode' }}</option>
                                                <option value="dark" {{ old('theme_mode', setting('theme_mode')) == 'dark' ? 'selected' : '' }}>{{ __('app.dark_mode') ?: 'Dark Mode' }}</option>
                                                <option value="auto" {{ old('theme_mode', setting('theme_mode')) == 'auto' ? 'selected' : '' }}>{{ __('app.auto_mode') ?: 'Auto Mode' }}</option>
                                            </select>
                                            <label for="theme_mode">{{ __('app.theme_mode') ?: 'Theme Mode' }}</label>
                                            @error('theme_mode')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('default_language') is-invalid @enderror"
                                                    id="default_language" name="default_language">
                                                <option value="en" {{ old('default_language', setting('default_language')) == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="ar" {{ old('default_language', setting('default_language')) == 'ar' ? 'selected' : '' }}>العربية</option>
                                            </select>
                                            <label for="default_language">{{ __('app.default_language') ?: 'Default Language' }}</label>
                                            @error('default_language')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">{{ __('app.logo_upload') ?: 'Logo Upload' }}</label>
                                        <div class="file-upload-zone" onclick="document.getElementById('logo_upload').click()">
                                            <input type="file" id="logo_upload" name="app_logo" accept="image/*" style="display: none;">
                                            <i class="bi bi-cloud-upload fs-1 text-primary mb-3"></i>
                                            <h5>{{ __('app.upload_logo') ?: 'Upload Logo' }}</h5>
                                            <p class="text-muted">{{ __('app.drag_drop_logo') ?: 'Click here or drag & drop your logo' }}</p>
                                            <small class="text-muted">{{ __('app.logo_formats') ?: 'Supports: PNG, SVG (Max: 2MB, Recommended: 200x80px)' }}</small>
                                        </div>
                                        @if(setting('app_logo'))
                                            <div class="mt-3">
                                                <img src="{{ asset('storage/' . setting('app_logo')) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 80px;">
                                                <small class="d-block text-muted">{{ __('app.current_logo') ?: 'Current Logo' }}</small>
                                            </div>
                                        @endif
                                        @error('app_logo')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Settings -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel">
                            <div class="setting-section">
                                <div class="section-title">
                                    <i class="bi bi-bell-fill"></i>
                                    <h3>{{ __('app.notification_preferences') ?: 'Notification Preferences' }}</h3>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <h6>{{ __('app.email_notifications') ?: 'Email Notifications' }}</h6>
                                        <small class="text-muted">{{ __('app.receive_email_notifications') ?: 'Receive email notifications for important updates' }}</small>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="email_notifications"
                                               {{ old('email_notifications', setting('email_notifications', true)) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <h6>{{ __('app.order_notifications') ?: 'Order Notifications' }}</h6>
                                        <small class="text-muted">{{ __('app.notify_new_orders') ?: 'Get notified when new orders are placed' }}</small>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="order_notifications"
                                               {{ old('order_notifications', setting('order_notifications', true)) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <h6>{{ __('app.low_stock_alerts') ?: 'Low Stock Alerts' }}</h6>
                                        <small class="text-muted">{{ __('app.alert_when_products_low_stock') ?: 'Alert when products are running low on stock' }}</small>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="low_stock_notifications"
                                               {{ old('low_stock_notifications', setting('low_stock_notifications', true)) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="notification-item">
                                    <div>
                                        <h6>{{ __('app.user_registration_alerts') ?: 'User Registration Alerts' }}</h6>
                                        <small class="text-muted">{{ __('app.notify_new_user_registrations') ?: 'Notify when new users register' }}</small>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="user_registration_notifications"
                                               {{ old('user_registration_notifications', setting('user_registration_notifications', false)) ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                </div>

                                <div class="form-floating mt-3">
                                    <input type="number" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                                           id="low_stock_threshold" name="low_stock_threshold"
                                           value="{{ old('low_stock_threshold', setting('low_stock_threshold', 10)) }}"
                                           min="1" max="1000">
                                    <label for="low_stock_threshold">{{ __('app.low_stock_threshold') ?: 'Low Stock Threshold' }}</label>
                                    @error('low_stock_threshold')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Settings -->
                        <div class="tab-pane fade" id="social" role="tabpanel">
                            <div class="setting-section">
                                <div class="section-title">
                                    <i class="bi bi-share-fill"></i>
                                    <h3>{{ __('app.social_media_links') ?: 'Social Media Links' }}</h3>
                                </div>

                                <div class="social-input-group">
                                    <div class="social-icon facebook">
                                        <i class="bi bi-facebook"></i>
                                    </div>
                                    <div class="form-floating flex-grow-1">
                                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                                               id="facebook_url" name="facebook_url"
                                               value="{{ old('facebook_url', setting('facebook_url')) }}"
                                               placeholder="https://facebook.com/yourpage">
                                        <label for="facebook_url">{{ __('app.facebook_page') ?: 'Facebook Page' }}</label>
                                        @error('facebook_url')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="social-input-group">
                                    <div class="social-icon twitter">
                                        <i class="bi bi-twitter"></i>
                                    </div>
                                    <div class="form-floating flex-grow-1">
                                        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror"
                                               id="twitter_url" name="twitter_url"
                                               value="{{ old('twitter_url', setting('twitter_url')) }}"
                                               placeholder="https://twitter.com/youraccount">
                                        <label for="twitter_url">{{ __('app.twitter_account') ?: 'Twitter Account' }}</label>
                                        @error('twitter_url')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="social-input-group">
                                    <div class="social-icon instagram">
                                        <i class="bi bi-instagram"></i>
                                    </div>
                                    <div class="form-floating flex-grow-1">
                                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror"
                                               id="instagram_url" name="instagram_url"
                                               value="{{ old('instagram_url', setting('instagram_url')) }}"
                                               placeholder="https://instagram.com/youraccount">
                                        <label for="instagram_url">{{ __('app.instagram_account') ?: 'Instagram Account' }}</label>
                                        @error('instagram_url')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="social-input-group">
                                    <div class="social-icon linkedin">
                                        <i class="bi bi-linkedin"></i>
                                    </div>
                                    <div class="form-floating flex-grow-1">
                                        <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror"
                                               id="linkedin_url" name="linkedin_url"
                                               value="{{ old('linkedin_url', setting('linkedin_url')) }}"
                                               placeholder="https://linkedin.com/company/yourcompany">
                                        <label for="linkedin_url">{{ __('app.linkedin_page') ?: 'LinkedIn Page' }}</label>
                                        @error('linkedin_url')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="social-input-group">
                                    <div class="social-icon youtube">
                                        <i class="bi bi-youtube"></i>
                                    </div>
                                    <div class="form-floating flex-grow-1">
                                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                                               id="youtube_url" name="youtube_url"
                                               value="{{ old('youtube_url', setting('youtube_url')) }}"
                                               placeholder="https://youtube.com/c/yourchannel">
                                        <label for="youtube_url">{{ __('app.youtube_channel') ?: 'YouTube Channel' }}</label>
                                        @error('youtube_url')
                                            <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="tab-pane fade" id="advanced" role="tabpanel">
                            <div class="setting-section">
                                <div class="section-title">
                                    <i class="bi bi-sliders"></i>
                                    <h3>{{ __('app.advanced_settings') ?: 'Advanced Settings' }}</h3>
                                </div>

                                <div class="maintenance-banner">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6>{{ __('app.maintenance_mode') ?: 'Maintenance Mode' }}</h6>
                                            <small>{{ __('app.maintenance_mode_desc') ?: 'Put your site in maintenance mode for updates' }}</small>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" name="maintenance_mode"
                                                   {{ old('maintenance_mode', setting('maintenance_mode', false)) ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('items_per_page') is-invalid @enderror"
                                                    id="items_per_page" name="items_per_page">
                                                <option value="10" {{ old('items_per_page', setting('items_per_page', 15)) == '10' ? 'selected' : '' }}>10 {{ __('app.items') ?: 'items' }}</option>
                                                <option value="15" {{ old('items_per_page', setting('items_per_page', 15)) == '15' ? 'selected' : '' }}>15 {{ __('app.items') ?: 'items' }}</option>
                                                <option value="25" {{ old('items_per_page', setting('items_per_page', 15)) == '25' ? 'selected' : '' }}>25 {{ __('app.items') ?: 'items' }}</option>
                                                <option value="50" {{ old('items_per_page', setting('items_per_page', 15)) == '50' ? 'selected' : '' }}>50 {{ __('app.items') ?: 'items' }}</option>
                                            </select>
                                            <label for="items_per_page">{{ __('app.items_per_page') ?: 'Items Per Page' }}</label>
                                            @error('items_per_page')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('date_format') is-invalid @enderror"
                                                    id="date_format" name="date_format">
                                                <option value="Y-m-d" {{ old('date_format', setting('date_format', 'Y-m-d')) == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                                <option value="d-m-Y" {{ old('date_format', setting('date_format', 'Y-m-d')) == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                                <option value="m/d/Y" {{ old('date_format', setting('date_format', 'Y-m-d')) == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                                <option value="F j, Y" {{ old('date_format', setting('date_format', 'Y-m-d')) == 'F j, Y' ? 'selected' : '' }}>Month Day, Year</option>
                                            </select>
                                            <label for="date_format">{{ __('app.date_format') ?: 'Date Format' }}</label>
                                            @error('date_format')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('currency') is-invalid @enderror"
                                                    id="currency" name="currency">
                                                <option value="USD" {{ old('currency', setting('currency', 'USD')) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                                <option value="EUR" {{ old('currency', setting('currency', 'USD')) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                                <option value="SAR" {{ old('currency', setting('currency', 'USD')) == 'SAR' ? 'selected' : '' }}>SAR (﷼)</option>
                                                <option value="AED" {{ old('currency', setting('currency', 'USD')) == 'AED' ? 'selected' : '' }}>AED (د.إ)</option>
                                                <option value="EGP" {{ old('currency', setting('currency', 'USD')) == 'EGP' ? 'selected' : '' }}>EGP (£)</option>
                                            </select>
                                            <label for="currency">{{ __('app.currency') ?: 'Currency' }}</label>
                                            @error('currency')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select @error('timezone') is-invalid @enderror"
                                                    id="timezone" name="timezone">
                                                <option value="UTC" {{ old('timezone', setting('timezone', 'UTC')) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                <option value="Asia/Riyadh" {{ old('timezone', setting('timezone', 'UTC')) == 'Asia/Riyadh' ? 'selected' : '' }}>Asia/Riyadh</option>
                                                <option value="Asia/Dubai" {{ old('timezone', setting('timezone', 'UTC')) == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                                <option value="Africa/Cairo" {{ old('timezone', setting('timezone', 'UTC')) == 'Africa/Cairo' ? 'selected' : '' }}>Africa/Cairo</option>
                                                <option value="Europe/London" {{ old('timezone', setting('timezone', 'UTC')) == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                            </select>
                                            <label for="timezone">{{ __('app.timezone') ?: 'Timezone' }}</label>
                                            @error('timezone')
                                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="section-title mt-4">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                    <h3>{{ __('app.legal_pages') ?: 'Legal Pages' }}</h3>
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('usage_treaty') is-invalid @enderror"
                                              id="usage_treaty" name="usage_treaty"
                                              style="height: 120px"
                                              placeholder="{{ __('app.terms_of_service') ?: 'Terms of Service' }}">{{ old('usage_treaty', setting('usage_treaty')) }}</textarea>
                                    <label for="usage_treaty">{{ __('app.terms_of_service') ?: 'Terms of Service' }}</label>
                                    @error('usage_treaty')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('usage_policy') is-invalid @enderror"
                                              id="usage_policy" name="usage_policy"
                                              style="height: 120px"
                                              placeholder="{{ __('app.privacy_policy') ?: 'Privacy Policy' }}">{{ old('usage_policy', setting('usage_policy')) }}</textarea>
                                    <label for="usage_policy">{{ __('app.privacy_policy') ?: 'Privacy Policy' }}</label>
                                    @error('usage_policy')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('laws_review') is-invalid @enderror"
                                              id="laws_review" name="laws_review"
                                              style="height: 120px"
                                              placeholder="{{ __('app.cookie_policy') ?: 'Cookie Policy' }}">{{ old('laws_review', setting('laws_review')) }}</textarea>
                                    <label for="laws_review">{{ __('app.cookie_policy') ?: 'Cookie Policy' }}</label>
                                    @error('laws_review')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="text-center py-4">
                        <button type="submit" class="save-button">
                            <i class="bi bi-check-circle me-2"></i>{{ __('app.save_settings') ?: 'Save All Settings' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@section('scripts')
  @includeIf('dashboard.setting.__script')
@endsection

</x-dashboard.layouts>
