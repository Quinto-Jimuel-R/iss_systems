@php
  $isApprover = in_array($_SESSION['rapidx_employee_number'] ?? '', ['V084', 'K010', '1810', '4771']);
  $isHardware = in_array($_SESSION['rapidx_employee_number'] ?? '', config('forms.hardware_employee_numbers'));
@endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="#" class="brand-link d-flex justify-content-center align-items-center">
            <img src="{{ asset('public/images/pricon_logo.png') }}" alt="AdminLTE" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text fw-light">ISS Systems</span>
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->

        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper" data-overlayscrollbars="host"><div class="os-size-observer"><div class="os-size-observer-listener"></div></div><div class="" data-overlayscrollbars-viewport="scrollbarHidden overflowXHidden overflowYScroll" tabindex="-1" style="margin-right: -16px; margin-bottom: -16px; margin-left: 0px; top: -8px; right: auto; left: -8px; width: calc(100% + 16px); padding: 8px;">
          <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" data-accordion="false" id="navigation" tabindex="-1">

                <li class="nav-item menu-open">
                  <a href="{{ route('forms') }}" class="nav-link {{ request()->is('/') || request()->routeIs('forms') ? 'bg-secondary' : 'bg-body-secondary' }}">
                      <i class="nav-icon fa-solid fa-file-pen"></i>
                      <p>
                          Forms
                      </p>
                  </a>
                </li>

                @if($isApprover)
                  <li class="nav-item menu-open">
                    <a href="{{ route('approval') }}" class="nav-link {{ request()->routeIs('approval') ? 'bg-secondary' : 'bg-body-secondary' }}">
                        <i class="nav-icon fa-solid fa-circle-check"></i>
                        <p>
                            For Approval
                        </p>
                    </a>
                  </li>
                @endif

                @if($isHardware)
                  <li class="nav-item menu-open">
                    <a href="{{ route('hardware') }}" class="nav-link {{ request()->routeIs('hardware') ? 'bg-secondary' : 'bg-body-secondary' }}">
                        <i class="nav-icon fa-solid fa-circle-check"></i>
                        <p>
                            Hardware
                        </p>
                    </a>
                  </li>
                @endif

            </ul>
          </nav>
        </div><div class="os-scrollbar os-scrollbar-horizontal os-theme-light os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-track-interactive os-scrollbar-cornerless os-scrollbar-unusable os-scrollbar-auto-hide-hidden" style="--os-viewport-percent: 1; --os-scroll-direction: 0;"><div class="os-scrollbar-track"><div class="os-scrollbar-handle"></div></div></div><div class="os-scrollbar os-scrollbar-vertical os-theme-light os-scrollbar-auto-hide os-scrollbar-handle-interactive os-scrollbar-track-interactive os-scrollbar-visible os-scrollbar-cornerless os-scrollbar-auto-hide-hidden" style="--os-viewport-percent: 0.5968; --os-scroll-direction: 0;"><div class="os-scrollbar-track"><div class="os-scrollbar-handle"></div></div></div></div>
        <!--end::Sidebar Wrapper-->
      </aside>

      <div class="sidebar-overlay"></div>