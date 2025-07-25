@php
    $userActive = Request::is('user-badan-usaha', 'user', 'role', 'permission');
@endphp

<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2 {{ $userActive ? 'show' : '' }}">
    <!--begin:Menu link-->
    <span class="menu-link active shadow">
        <span class="menu-icon">
            <i class="bi bi-person-fill"></i>
        </span>
        <span class="menu-title">User Managemen</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion mt-2 {{ $userActive ? 'show' : '' }}">
        <!--begin:Menu item-->
        <div class="menu-item menu-accordion">
            <a href="{{ url('/user-badan-usaha') }}" class="menu-link {{ Request::is('user-badan-usaha') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">User Badan Usaha</span>
            </a>
        </div>

        @can('user')
        <div class="menu-item menu-accordion">
            <a href="{{ url('/user') }}" class="menu-link {{ Request::is('user') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">User Evaluator</span>
            </a>
        </div>
        @endcan

        <div class="menu-item menu-accordion">
            <a href="{{ url('/role') }}" class="menu-link {{ Request::is('role') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Role</span>
            </a>
        </div>

        @can('permission')
        <div class="menu-item menu-accordion">
            <a href="{{ url('/permission') }}" class="menu-link {{ Request::is('permission') ? 'active shadow' : '' }}">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Permission</span>
            </a>
        </div>
        @endcan
    </div>
</div>
