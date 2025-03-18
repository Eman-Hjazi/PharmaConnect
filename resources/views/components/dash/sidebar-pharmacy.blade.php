<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-capsules"></i>
        </div>
        <div class="sidebar-brand-text mx-3">PharmaConnect</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('pharmacy.dashboard')}}">
            <i class="fa-solid fa-house"></i>
            <span>لوحة التحكم</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <li class="nav-item {{ request()->routeIs('pharmacy.medicine.index')||request()->routeIs('pharmacy.order.index') ||request()->routeIs('pharmacy.stock.index')  ? 'active' : ''}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMedicine"
            aria-expanded="true" aria-controls="collapseMedicine">
            <i class="fa-solid fa-pills"></i>
            <span>إدارة الأدوية</span>
        </a>
        <div id="collapseMedicine" class="collapse  {{ request()->routeIs('pharmacy.medicine.index')||request()->routeIs('pharmacy.order.index') ||request()->routeIs('pharmacy.stock.index')  ? 'show' : ''}}" aria-labelledby="headingMedicine" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->routeIs('pharmacy.medicine.index') ? 'active' : ''}} " href="{{route('pharmacy.medicine.index')}}">
                    <i class="fa-solid fa-box-open"></i>  الأدوية المتاحة للطلب
                </a>

                <a class="collapse-item " href="{{route('pharmacy.inventory.show',['pharmacyId' => auth('pharmacy')->user()->id])}}">
                    <i class="fa-solid fa-warehouse"></i> عرض المخزون
                </a>
            </div>

        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - إدارة الطلبات -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fa-solid fa-cart-plus"></i>
            <span>الطلبات</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('pharmacy.orders.sent') }}">
                    <i class="fa-solid fa-paper-plane"></i> الطلبات المرسلة
                </a>
                <a class="collapse-item" href="{{route('pharmacy.orders.customer')}}">
                    <i class="fa-solid fa-truck"></i> الطلبات الواردة
                </a>

            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - إدارة العملاء -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fa-solid fa-users"></i>
            <span>إدارة العملاء</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('pharmacy.customers.add') }}">
                    <i class="fa-solid fa-user-plus"></i> إضافة عميل
                </a>
                <a class="collapse-item" href="{{ route('pharmacy.customers.index') }}">
                    <i class="fa-solid fa-users"></i> قائمة العملاء
                </a>
            </div>


        </div>



    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
