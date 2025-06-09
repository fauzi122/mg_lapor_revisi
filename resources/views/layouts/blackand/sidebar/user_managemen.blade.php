<div data-kt-menu-trigger="click" class="menu-item menu-accordion mt-2">
    <!--begin:Menu link-->
    <span class="menu-link active">
        <span class="menu-icon">
            <i class="bi bi-person-fill"></i>
        </span>
        <span class="menu-title">User Managemen</span>
        <span class="menu-arrow"></span>
    </span>
    <!--end:Menu link-->
    <!--begin:Menu sub-->
    <div class="menu-sub menu-sub-accordion">
        <!--begin:Menu item-->
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/user-badan-usaha') }}" class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">User Badan Usaha</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/user') }}" class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">User Evaluator</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/role') }}" class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Role</span>
            </a>
            <!--end:Menu link-->
        </div>
        <div class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <a href="{{ url('/permission') }}" class="menu-link">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Permission</span>
            </a>
            <!--end:Menu link-->
        </div>
    </div>
</div>