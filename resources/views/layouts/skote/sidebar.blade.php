@php
    $info = app('user.helper')->getAuthInfo();
@endphp

<!-- ========== Left Sidebar Start ========== --> 
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">
                    
                    <div class="row mt-4 mb-4">
                        <div class="col-lg-12">
                            <div class="text-lg-center mt-4 mt-lg-0 mb-3">
                                <img src="{{ $info['photo'] }}" alt="" class="avatar-lg rounded-circle img-thumbnail">
                            </div>
                            <div class="text-lg-center mt-4 mt-lg-0 font-size-15">
                                {{ $info['name'] }}
                            </div>
                            <div class="text-lg-center mt-4 mt-lg-0 font-size-15">
                                <span class="badge bg-info">{{ $info['role'] }}</span>
                            </div>
                        </div>
                    </div>

                </li>
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span class="badge rounded-pill bg-info float-end"></span>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @foreach(session('sess_menu') as $menu)
                    @foreach(session('sess_usermenu') as $userMenu)
                        @if($userMenu->menu_name == str_replace(' ', '', strtolower($menu->name)))
                            <li>
                                @php
                                    $hasrows = ($menu->is_parent == 1) ? 'has-arrow ' : '';   
                                @endphp
                                <a href="{{ $menu->url }}" class="{{ $hasrows }}waves-effect">
                                    <i class="bx {{ $menu->icon }}"></i>
                                    <span key="t-{{ $menu->id }}">{{ $menu->name }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @foreach(session('sess_submenu') as $submenu)
                                        @if($submenu->menu_id == $menu->id)
                                            @if(auth()->user()->can(str_replace(' ', '', strtolower($submenu->menu->name)).'-'.str_replace(' ', '', strtolower($submenu->name))))                                                
                                                <li>
                                                    <a href="{{ $submenu->url }}" key="t-{{ $submenu->id }}">
                                                        {{ $submenu->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endforeach

                @if( auth()->user()->hasRole('superadmin'))
                    <li class="menu-title" key="t-menu">Utilitas</li>
                    
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-wrench"></i>
                            <span key="t-multi-level">Setting</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="{{ route('user.user.index') }}" key="t-level-2-1">
                                    <i class="bx bx-user"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">User</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.group-site.index') }}" key="t-level-2-1">
                                    <i class="bx bx-group"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Group Site</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('role.index') }}" key="t-level-2-1">
                                    <i class="bx bx-briefcase-alt-2"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Role</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.roles_permission') }}" key="t-level-2-1">
                                    <i class="bx bx-check-shield"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Permission</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('menu.index') }}" key="t-level-2-1">
                                    <i class="bx bxs-book-content"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Menu</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('submenu.index') }}" key="t-level-2-1">
                                    <i class="bx bxs-book-content"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Sub Menu</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('configuration.index') }}" key="t-level-2-1">
                                    <i class="bx bx bx-extension"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">App Info</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-customize"></i>
                            <span key="t-multi-level">I.O.T</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="{{ route('iot.device.index') }}" key="t-level-2-1">
                                    <i class="bx bx-devices"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Device</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('iot.chart.index') }}" key="t-level-2-1">
                                    <i class="bx bx-line-chart"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">Chart</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-history"></i>
                            <span key="t-multi-level">Logs</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <a href="{{ route('user.userlogin.index') }}" key="t-level-2-1">
                                    <i class="bx bx-user"></i><span class="badge rounded-pill bg-info float-end"></span>
                                    <span key="t-user">User Login</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

