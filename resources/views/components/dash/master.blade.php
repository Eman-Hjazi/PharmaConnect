<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم</title>

    <!-- تحميل المكتبات -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

       <!-- إضافة Animate.css -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="{{ asset('backend/css/master.css') }}" rel="stylesheet">

    <!-- إضافة خطوط حديثة (اختياري) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @yield('css')


</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @if (auth('pharmacy')->check())
            <x-dash.sidebar-pharmacy />
        @elseif(auth('company')->check())
            <x-dash.sidebar-company />
        @else
            <x-dash.sidebar-user />
        @endif

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <!-- Alerts Dropdown -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <!-- محتوى التنبيهات -->
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- User Information Dropdown -->
                        @php
                            if (auth('pharmacy')->check()) {
                                $user = auth('pharmacy')->user();
                                $profileRoute = 'pharmacy.profile';
                                $logoutRoute = 'pharmacy.logout';
                                $imageSrc = $user->image
                                    ? asset('storage/pharmacy/' . $user->image->path)
                                    : 'https://via.placeholder.com/150';
                            } elseif (auth('company')->check()) {
                                $user = auth('company')->user();
                                $profileRoute = 'company.profile';
                                $logoutRoute = 'company.logout';
                                $imageSrc = $user->image
                                    ? asset('storage/company/' . $user->image->path)
                                    : 'https://via.placeholder.com/150';
                            } else {
                                $user = null;
                                $profileRoute = '#';
                                $logoutRoute = '#';
                                $imageSrc = 'https://via.placeholder.com/150';
                            }
                        @endphp

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small ml-2">{{ $user->name ?? 'غير معروف' }}</span>
                                <img class="img-profile rounded-circle" src="{{ $imageSrc }}" alt="صورة المستخدم"
                                    style="width: 30px; height: 30px;">
                            </a>
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route($profileRoute) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    حسابي
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-target="#logoutModal"
                                    data-logout-route="{{ route($logoutRoute) }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    تسجيل الخروج
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <!-- Inside <body> before @stack('scripts') -->
    <script>
        window.App = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>

    <!-- Existing Scripts -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('backend/js/master.js') }}"></script>

    @stack('scripts')
</body>

</html>
