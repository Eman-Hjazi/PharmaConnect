<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="right: 0; left: auto;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('company.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-capsules"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PharmaConnect</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('company.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>لوحة التحكم</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Medicines Management -->
    <li class="nav-item {{ request()->routeIs('company.medicines.index')?'active':''}}">
        <a class="nav-link collapsed" href="{{ route('company.medicines.index') }}" data-toggle="collapse" data-target="#collapseMedicines"
            aria-expanded="true" aria-controls="collapseMedicines">
            <i class="fas fa-pills"></i>
            <span>إدارة الأدوية</span>
        </a>
        <div id="collapseMedicines" class="collapse {{ request()->routeIs('company.medicines.index')?'show':''}}" aria-labelledby="headingMedicines" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('company.medicines.index') }}"><i class="fas fa-list"></i> عرض الأدوية</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Categories Management (NEW) -->
    <li class="nav-item {{ request()->routeIs('company.categories.index')?'active':''}}">
        <a class="nav-link collapsed" href="{{ route('company.categories.index') }}" data-toggle="collapse" data-target="#collapseCategories"
            aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-tags"></i>
            <span>إدارة التصنيفات</span>
        </a>
        <div id="collapseCategories" class="collapse  {{ request()->routeIs('company.categories.index')?'show':''}}" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('company.categories.index') }}"><i class="fas fa-list-ul"></i> عرض التصنيفات</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Orders Management -->
    <li class="nav-item  {{ request()->routeIs('company.orders.index')?'active':''}}">
        <a class="nav-link collapsed" href="{{ route('company.orders.index') }}" data-toggle="collapse" data-target="#collapseOrders"
            aria-expanded="true" aria-controls="collapseOrders">
            <i class="fas fa-shopping-cart"></i>
            <span>إدارة الطلبات</span>
        </a>
        <div id="collapseOrders" class="collapse  {{ request()->routeIs('company.orders.index')?'show':''}}" aria-labelledby="headingOrders" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('company.orders.index') }}"><i class="fas fa-eye"></i> عرض الطلبات</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pharmacies Management -->
    <li class="nav-item  {{ request()->routeIs('company.pharmacies.index')?'active':''}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePharmacies"
            aria-expanded="true" aria-controls="collapsePharmacies">
            <i class="fas fa-clinic-medical"></i>
            <span>إدارة الصيدليات</span>
        </a>
        <div id="collapsePharmacies" class="collapse  {{ request()->routeIs('company.pharmacies.index')?'show':''}}" aria-labelledby="headingPharmacies" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('company.pharmacies.index') }}"><i class="fas fa-store"></i> عرض الصيدليات</a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

