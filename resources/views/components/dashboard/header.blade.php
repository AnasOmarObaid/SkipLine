<header class="app-header"><a class="app-header__logo" href="index.html">SlipLine</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
            aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
            <li class="app-search">
                  <input class="app-search__input" type="search" placeholder="Search">
                  <button class="app-search__button"><i class="bi bi-search"></i></button>
            </li>
            <!--Notification Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                        aria-label="Show notifications"><i class="bi bi-bell fs-5"></i></a>
                  <ul class="app-notification dropdown-menu dropdown-menu-right">
                        <li class="app-notification__title">You have 4 new notifications.</li>
                        <div class="app-notification__content">
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-envelope fs-4 text-primary"></i></span>
                                          <div>
                                                <p class="app-notification__message">Lisa sent you a mail</p>
                                                <p class="app-notification__meta">2 min ago</p>
                                          </div>
                                    </a></li>
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                                          <div>
                                                <p class="app-notification__message">Mail server not working</p>
                                                <p class="app-notification__meta">5 min ago</p>
                                          </div>
                                    </a></li>
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-cash fs-4 text-success"></i></span>
                                          <div>
                                                <p class="app-notification__message">Transaction complete</p>
                                                <p class="app-notification__meta">2 days ago</p>
                                          </div>
                                    </a></li>
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-envelope fs-4 text-primary"></i></span>
                                          <div>
                                                <p class="app-notification__message">Lisa sent you a mail</p>
                                                <p class="app-notification__meta">2 min ago</p>
                                          </div>
                                    </a></li>
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-exclamation-triangle fs-4 text-warning"></i></span>
                                          <div>
                                                <p class="app-notification__message">Mail server not working</p>
                                                <p class="app-notification__meta">5 min ago</p>
                                          </div>
                                    </a></li>
                              <li><a class="app-notification__item" href="javascript:;"><span
                                                class="app-notification__icon"><i
                                                      class="bi bi-cash fs-4 text-success"></i></span>
                                          <div>
                                                <p class="app-notification__message">Transaction complete</p>
                                                <p class="app-notification__meta">2 days ago</p>
                                          </div>
                                    </a></li>
                        </div>
                        <li class="app-notification__footer"><a href="#">See all notifications.</a></li>
                  </ul>
            </li>

            {{-- Language Switcher --}}
            <li class="dropdown direction-left">
                <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Change Language">
                    <i class="bi bi-globe fs-4"></i>
                </a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    @foreach(config('locales.supported') as $localeCode => $properties)
                        @php
                            // Get current URL and replace language prefix
                            $currentUrl = url()->current();
                            $currentLocale = app()->getLocale();

                            // Replace current language prefix with selected language
                            if (str_contains($currentUrl, '/' . $currentLocale . '/')) {
                                $newUrl = str_replace('/' . $currentLocale . '/', '/' . $localeCode . '/', $currentUrl);
                            } else {
                                // If no language prefix found, add it
                                $newUrl = url('/') . '/' . $localeCode . str_replace(url('/'), '', $currentUrl);
                            }
                        @endphp
                        <li>
                            <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == $localeCode ? 'active' : '' }}"
                               href="{{ $newUrl }}">
                                @if(isset($properties['image']))
                                    <img src="{{ asset($properties['image']) }}" alt="{{ $properties['name'] }}"
                                         class="me-2" style="width: 20px; height: 15px; object-fit: cover;">
                                @endif
                                <span>{{ $properties['name'] }}</span>
                                <span class="ms-2 text-muted small">{{ $properties['flag'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

            <!-- User Menu-->
            <li class="dropdown direction-left"><a class="app-nav__item" href="#" data-bs-toggle="dropdown"
                        aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
                  <ul class="dropdown-menu settings-menu dropdown-menu-right">
                        <li><a class="dropdown-item" href="{{ localized_route('dashboard.setting.index') }}"><i class="bi bi-gear me-2 fs-5"></i>
                                    {{ __('app.settings') }}</a></li>
                        <li><a class="dropdown-item" href="{{ localized_route('dashboard.profile.edit') }}"><i class="bi bi-person me-2 fs-5"></i>
                                   {{ __('app.profile') }}</a></li>
                        <li>
                              <form class='form' method="POST" action="">
                                    @csrf
                                    <button class="btn p-0 m-0 w-100" style="text-align: left;" type='submit'>
                                          <a class="dropdown-item btn-block w-100"><i
                                                      class="bi bi-box-arrow-right me-2 fs-5"></i>
                                                {{ __('app.logout') }}</a>
                                    </button>
                              </form>
                        </li>
                  </ul>
            </li>

      </ul>
</header>
