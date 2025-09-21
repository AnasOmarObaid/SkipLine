<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="table-user-image app-sidebar__user-avatar"
                  src="{{ asset(Auth::user()->getImagePath()) }}" width="60" height="60" alt="User Image">
            <div>
                  <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
                  <p class="app-sidebar__user-designation">{{ Auth::user()->role }}</p>
            </div>
      </div>
      <ul class="app-menu">
            {{-- Dashboard Link --}}
            <li><a class="app-menu__item {{ request()->routeIs('dashboard.welcome') ? 'active' : '' }}"
                        href="{{ localized_route('dashboard.welcome') }}"><i class="app-menu__icon bi bi-speedometer"></i><span
                              class="app-menu__label">{{ __('app.dashboard') }}</span></a></li>

            {{-- users routes  --}}
            <li class="treeview {{ request()->routeIs('dashboard.user.*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-people-fill"></i><span class="app-menu__label">{{ __('app.users') }}</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.user.index') ? 'active' : '' }}"
                                    href="{{ localized_route('dashboard.user.index') }}"><i class="icon bi bi-database"></i> {{ __('app.user_view') }}</a></li>
                        <li> <a class="treeview-item {{ request()->routeIs('dashboard.user.create') ? 'active' : '' }}"
                                    href="{{ localized_route('dashboard.user.create') }}"><i class="icon bi bi-plus fs-5"></i>
                                    {{ __('app.user_create') }}</a></li>
                  </ul>
            </li>

             {{-- products routes  --}}
            <li class="treeview {{ request()->routeIs('dashboard.product.*') ? 'is-expanded' : '' }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon bi bi-box-seam"></i><span class="app-menu__label">{{ __('app.products') }}</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.product.index') ? 'active' : '' }}"
                                    href="{{ localized_route('dashboard.product.index') }}"><i class="icon bi bi-database"></i> {{ __('app.product_view') }}</a></li>
                        <li> <a class="treeview-item {{ request()->routeIs('dashboard.product.create') ? 'active' : '' }}"
                                    href="{{ localized_route('dashboard.product.create') }}"><i class="icon bi bi-plus fs-5"></i>
                                    {{ __('app.product_create') }}</a></li>
                  </ul>
            </li>

            {{-- orders --}}
             <li><a class="app-menu__item mt-1 {{ request()->routeIs('dashboard.order.*') ? 'active' : '' }}" href="{{ localized_route('dashboard.order.index') }}"><i class="app-menu__icon bi bi-receipt"></i><span
                              class="app-menu__label">{{ __('app.orders') }}</span></a></li>

            {{-- profile --}}
            <li><a class="app-menu__item mt-1 {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}" href="{{ localized_route('dashboard.profile.edit') }}"><i class="app-menu__icon bi bi-person-circle"></i><span
                              class="app-menu__label">{{ __('app.profile') }}</span></a></li>

             {{-- settings --}}
             <li><a class="app-menu__item mt-1 {{ request()->routeIs('dashboard.setting.*') ? 'active' : '' }}" href="{{ localized_route('dashboard.setting.index') }}"><i class="app-menu__icon bi bi-gear-fill"></i><span
                              class="app-menu__label">{{ __('app.settings') }}</span></a></li>


            {{-- logout --}}
            <li>
                <form class='form' method="POST" action="{{ localized_route('dashboard.auth.logout') }}">
                    @csrf
                    <button class="btn p-0 w-100" type='submit'>
                        <a class="app-menu__item ">
                            <i class="bi bi-box-arrow-right me-2 fs-5"></i>
                            {{ __('app.logout') }}
                        </a>
                    </button>
                </form>
            </li>
      </ul>
</aside>



