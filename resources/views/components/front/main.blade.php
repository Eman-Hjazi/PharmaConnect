@props(['pharmacies'])

<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pharma Connect</title>
    <link rel="stylesheet" href="{{ asset('front/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="container-header">
            <div class="right-section">
                <div class="logo">
                    <h1>Pharma Connect</h1>
                </div>
                <div class="language-selector">
                    <div class="location-selector">
                        <select id="locationSelector">
                            <option value="all">اختر موقعك</option>
                            <option value="غزة">غزة</option>
                            <option value="رفح">رفح</option>
                            <option value="دير البلح">دير البلح</option>
                            <option value="خانيونس">خانيونس</option>

                        </select>
                    </div>
                </div>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}" class="active">الرئيسية</a></li>
                    <li><a href="#pharmacy" class="">صيدليات</a></li>
                    <li><a href="#about" class="">من نحن</a></li>
                    <li><a href="{{route('contact')}}" class="">اتصل بنا</a></li>
                </ul>
            </nav>

            <div class="left-section">
                <div class="ask-link">
                    <a href="{{route('ask')}}">اسأل <i class="fa-solid fa-headphones"></i></a>
                </div>
                <div class="cart-button">
                    <a href="{{route('cart.sala')}}" class="cart-link">
                        <div class="cart-badge" id="cart-badge">{{ $cartCount ?? 0 }}</div>
                        <i class="fas fa-shopping-cart"></i>
                    </a>

                </div>
            </div>
        </div>
    </header>

    {{ $slot }}

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- First Column -->
                <div class="footer-column">
                    <div class="footer-section">
                        <h2 class="footer-title">Pharma Connect</h2>
                        <p class="footer-text">
                            هذا النص مثال للنص يمكن أن
                            <br>
                            يستبدل بنفس المساحة المخصصة له
                        </p>
                    </div>
                    <div class="payment-methods">
                        <h3 class="payment-title">أسهل طرق الدفع</h3>
                        <div class="payment-icons">
                            <img src="{{ asset('front/images/pal-pay.png') }}" alt="Visa" class="payment-icon">
                            <img src="{{ asset('front/images/pal.png') }}" alt="Mastercard" class="payment-icon">
                            <img src="{{ asset('front/images/visa.png') }}" alt="PayPal" class="payment-icon">
                        </div>
                    </div>
                </div>
                <!-- Quick Links - First Column -->
                <div class="footer-column">
                    <h3 class="quick-links-title">روابط سريعة</h3>
                    <div class="quick-links">
                        <a href="{{ route('home') }}" class="quick-link">الرئيسية</a>
                        <a href="#pharmacy" class="quick-link">صيدليات</a>
                        <a href="/about" class="quick-link">من نحن</a>
                        <a href="/contact" class="quick-link">اتصل بنا</a>
                    </div>
                </div>
                <!-- Quick Links - Second Column -->
                <div class="footer-column">
                    <h3 class="quick-links-title">روابط سريعة</h3>
                    <div class="quick-links">
                        <a href="/blog" class="quick-link">مدونة</a>
                        <a href="/support" class="quick-link">دعم فني</a>
                        <a href="/center" class="quick-link">المركز</a>
                    </div>
                </div>
                <!-- Newsletter Signup -->
                <div class="footer-column">
                    <h3 class="quick-links-title">روابط سريعة</h3>
                    <div class="quick-links">
                        <a href="/sitemap" class="quick-link">خريطة الموقع</a>
                        <a href="/accessibility" class="quick-link">إمكانية الوصول</a>
                    </div>
                    <div class="newsletter">
                        <p class="newsletter-text">
                            انضم إلى قائمة البريد الإلكتروني الخاصة بنا
                            <br>
                            للحصول على التحديثات، احصل على الأخبار
                            <br>
                            والعروض والأحداث
                        </p>
                        <div class="newsletter-form">
                            <input type="email" placeholder="أدخل بريدك الإلكتروني" class="newsletter-input">
                            <button class="newsletter-button">اشتراك</button>
                        </div>
                        <div class="social-media">
                            <p class="social-text">السوشيال ميديا</p>
                            <div class="social-icons">
                                <a href="#" class="social-icon facebook">f</a>
                                <a href="#" class="social-icon linkedin">In</a>
                                <a href="#" class="social-icon twitter">X</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bottom footer -->
            <div class="footer-bottom">
                <div class="footer-links">
                    <a href="{{route('pharma-policies')}}" class="footer-link">سياسة الخصوصية</a>
                    <a href="/terms" class="footer-link">الشروط والأحكام</a>
                </div>
                <div class="copyright">
                    حقوق الطبع والنشر © لعام 2024 محفوظة
                </div>
            </div>
        </div>
    </footer>

    <!-- إضافة script.js -->

    <script>
        function updateCartBadge() {
            fetch('{{ route('cart.count') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('cart-badge').textContent = data.count;
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                });
        }

        // تحديث العدد عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();

            // الاستماع إلى حدث إضافة المنتج
            document.addEventListener('cartUpdated', () => {
                updateCartBadge();
            });
        });

    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('js')
</body>

</html>
