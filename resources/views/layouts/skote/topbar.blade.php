@php
    $info = app('user.helper')->getAuthInfo();
@endphp

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background: #eaedff">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ app('file.helper')->getFileUrl('alodokter_logo.svg', 'main_image') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ app('file.helper')->getFileUrl('alodokter_letter.png', 'main_image') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ app('file.helper')->getFileUrl('alodokter_logo.svg', 'main_image') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ app('file.helper')->getFileUrl('alodokter_letter.png', 'main_image') }}" alt="" height="19">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            {{-- <div class="px-3 header-item mt-4">
                <select
                    name="group_site_id"
                    id="selectGroupSiteId"
                    class="select2 form-control"
                    >
                    <option value="">Choose Group Site</option>
                </select>
            </div> --}}
    </div>

    <div class="d-flex">
        <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                <i class="bx bx-fullscreen"></i>
            </button>
        </div>

        <div class="dropdown d-inline-block">
            <input type="hidden" id="routeListNotificationUser" value="{{ route('api.v1.user.notifications.summary') }}">
            <input type="hidden" id="roleCheck" value="{{ $info['role'] }}">
            <input type="hidden" id="employeeId" value="{{ $info['employee_id'] }}">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-bell bx-tada"></i>
                <span class="badge bg-danger rounded-pill"><div id="count-notification">0</div></span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-notifications-dropdown">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-0" key="t-notifications"> Notifications </h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="small" key="t-view-all"> </a>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 230px;">
                    <div id="info-notif"></div>
                </div>
                <div class="p-2 border-top d-grid">
                    <a class="btn btn-sm btn-link font-size-14 text-center" href="{{ route('user.user.notification.index') }}">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More</span> 
                    </a>
                </div>
            </div>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ $info['photo'] }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ $info['name'] }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                @if (Auth::user()->getRoleNames()->first() == "user")
                    <a class="dropdown-item" href="{{ route('hrd.hrd.employee.show.by.user', ['employee' => \Crypt::encrypt(Auth::user()->employee_id)]) }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                @elseif (in_array(Auth::user()->getRoleNames()->first(), app('user.helper')->getRoleWithoutSuperadminAndUser()))
                    <a class="dropdown-item" href="{{ route('user.user.user.edit.by.role', ['user' => \Crypt::encrypt(Auth::user()->id)]) }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
</header>