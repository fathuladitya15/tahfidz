          <!-- Menu -->

          <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
              <a href="index.html" class="app-brand-link">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo/logopesantren.jpg') }}" alt="" style="width: 100px;">
                </span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item {{ menuActive(['home','profile']) }}">
                    <a href="{{ route('home') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Pages</span>
                </li>
                @if(in_array(Auth::user()->getRoleNames()->join(', '),['admin','teacher'] ))
                    <li class="menu-item {{ menuActive(['user-index','user-create','user-edit']) }}">
                        <a href="{{ route('user-index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user-circle"></i>
                        <div data-i18n="Analytics">Data Pengguna</div>
                        </a>
                    </li>
                @endrole
                <li class="menu-item {{ menuActive(['hafalan-index','hafalan-show']) }}">
                    <a href="{{ route('hafalan-index') }}" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-paperclip"></i>
                      <div data-i18n="Analytics">Data Hafalan</div>
                    </a>
                </li>
            </ul>
          </aside>
          <!-- / Menu -->
