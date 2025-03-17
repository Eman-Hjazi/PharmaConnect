<x-front.main  :pharmacies="$pharmacies">
    <div class="section-one">
        <div class="container">
            <form action="{{route('search')}}" method="GET" class="search-form">
                <input type="text" class="form-input" placeholder="البحث" name="query">
                <button type="submit" class="form-button">
                    <i class="fas fa-search"></i> ابحث
                </button>
            </form>

            <div class="main-content">
                <div class="content-text">
                    <h1>وصفتك لحلول صحية ميسورة التكلفة!</h1>
                    <p>اهتم بصحتك مع منصة متكاملة لتلبية احتياجاتك الطبية بسهولة!</p>
                    <button class="shop-button">
                        <i class="fas fa-shopping-cart"></i>
                        تسوق الآن
                    </button>
                    <div class="payment-methods">
                        <p>أسهل طرق الدفع</p>
                        <div class="payment-icons">
                            <img src="{{ asset('front/images/visa.png') }}" alt="Visa" />
                            <img src="{{ asset('front/images/pal.png') }}" alt="Pal" />
                            <img src="{{ asset('front/images/pal-pay.png') }}" alt="pal-pay" />
                            <img src="{{ asset('front/images/visa.png') }}" alt="Visa" />
                        </div>
                    </div>
                </div>
                <div class="doctor-image">
                    <img src="{{ asset('front/images/doctor.png') }}" alt="Doctor showing medicine" />
                </div>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-box"></i>
                    <h3>الشحن مجاناً</h3>
                    <p>لجميع الطلبات التي تتجاوز مبلغاً معيناً</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-credit-card"></i>
                    <h3>طرق الدفع</h3>
                    <p>يتيح خيارات دفع إلكترونية مرنة لتسهيل عملية الشراء.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-robot"></i>
                    <h3>الدعم بالذكاء الاصطناعي</h3>
                    <p>الرد على استفسارات العملاء على مدار الأيام</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-prescription"></i>
                    <h3>رفع الروشتات الطبية</h3>
                    <p>إمكانية تحميل الوصفات لتسهيل طلب الأدوية.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: الصيدليات القريبة -->
    <div class="pharmacy-container" id="pharmacy">
        <div class="pharmacy-header">
            <h1>الصيدليات القريبة</h1>
        </div>
        <div class="pharmacy-navigator">
            <button class="nav-button prev" aria-label="Previous page">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="pharmacy-cards" id="pharmacyCards">
                @foreach($pharmacies as $pharmacy)
                    <div class="pharmacy-card">
                        <div class="pharmacy-logo">
                            <img src="{{ $pharmacy->image ? asset('storage/' . $pharmacy->image->path) : asset('storage/pharmacy/pharma.png') }}" alt="{{ $pharmacy->name }} logo" />
                        </div>
                        <h3 class="pharmacy-name">{{ $pharmacy->name }}</h3>
                        <div class="pharmacy-info">
                            <div class="info-line">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $pharmacy->address }}</span>
                            </div>
                        </div>
                        <div class="pharmacy-actions">
                            <a href="{{ route('pharmacy.show', $pharmacy->id) }}" class="action-button details">المزيد</a>
                            <div class="social-icons">
                                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="nav-button next" aria-label="Next page">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        <div class="pagination-indicator">
            <span id="paginationText">1 / {{ ceil($pharmacies->count() / 5) }}</span>
        </div>
    </div>

    <!-- Section 3: الإعلان -->
    <section class="advertisement-section">
        <div class="advertisement-container">
            <div class="ad-image">
                <img src="{{ asset('front/images/med.png') }}" alt="Advertisement Image">
            </div>
            <div class="ad-text">
                <h3>أدوية GLP-1</h3>
                <p>
                    وفّر مع Pharma Connect عندما لا يغطي التأمين GLP-1.<br>
                    احصل على خصومات لدعم فقدان الوزن وعلاج مرض السكري والمزيد.
                </p>
                <button class="ad-button">اشترك الآن</button>
            </div>
        </div>
    </section>

    <!-- اهتم بصحتك -->
    <section class="health-section">
        <h2>اهتم بصحتك</h2>
        <div class="articles-container">
            <div class="left-article">
                <div class="article">
                    <img src="{{ asset('front/images/disbeyazlaticiset-2.png') }}" alt="Article Image">
                    <div class="article-content">
                        <span>📅 2025، 1 فبراير | <b>كبير</b></span>
                        <h3>اكتشف كنزًا من النصائح المعالجة لجسمك</h3>
                        <p>استكشف مجموعة النصائح الطبية التي قد تساعدك على تحسين نمط حياتك اليومي. نحن هنا لدعمك بمعلومات أكثر صحة.</p>
                        <button class="btn-health">المزيد</button>
                    </div>
                </div>
            </div>
            <div class="right-articles">
                <div class="article">
                    <img src="{{ asset('front/images/kara-sarimsak-yagi 1.png') }}" alt="Article Image">
                    <div class="article-content">
                        <span>📅 2025، 1 فبراير | <b>كبير</b></span>
                        <h3>اكتشف كنزًا من النصائح المعالجة لجسمك</h3>
                        <p>استكشف مجموعة النصائح الطبية التي قد تساعدك على تحسين نمط حياتك اليومي. نحن هنا لدعمك بمعلومات أكثر صحة.</p>
                        <button class="btn-health">المزيد</button>
                    </div>
                </div>
                <div class="article">
                    <img src="{{ asset('front/images/muz.aromali.dis_.png') }}" alt="Article Image">
                    <div class="article-content">
                        <span>📅 2025، 1 فبراير | <b>كبير</b></span>
                        <h3>اكتشف كنزًا من النصائح المعالجة لجسمك</h3>
                        <p>استكشف مجموعة النصائح الطبية التي قد تساعدك على تحسين نمط حياتك اليومي. نحن هنا لدعمك بمعلومات أكثر صحة.</p>
                        <button class="btn-health">المزيد</button>
                    </div>
                </div>
                <div class="featured-article">
                    <img src="{{ asset('front/images/Group 346.png') }}" alt="Featured Article">
                    <div class="article-content">
                        <span>📅 2025، 1 فبراير</span>
                        <h3>في هذا القسم، نكشف عن جوانب مختلفة من الصحة</h3>
                        <p>اكتشف أحدث الأبحاث الصحية من مصدر موثوق، واستمتع بمقالات متنوعة كتبها أطباء الخبراء.</p>
                        <button class="btn-health">المزيد</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Last 2 Sections -->
    <div class="container-last-section">
        <!-- Offers and Promotions Section -->
        <section class="promotions-section">
            <h2 class="section-title-last">عروضات وخصومات</h2>
            <div class="promotions-grid">
                <div class="promotion-large">
                    <div class="promotional-product">
                        <div class="product-image-container">
                            <img src="{{ asset('front/images/kara-sarimsak-yagi 1.png') }}" alt="زيت الثوم الأسود" class="product-image">
                        </div>
                        <div class="product-details-last">
                            <div class="discount-tag">خصم 15%</div>
                            <h3 class="product-name">زيت الثوم الأسود</h3>
                            <p class="product-description">سيرم زيوت طبيعية ذاتية نمو الشعر الثوم الأسود</p>
                            <div class="product-price">
                                <div class="original-price">
                                    <span class="line-through">90.00 ر.س</span>
                                </div>
                                <div class="sale-price">
                                    37.00 <span class="currency">ر.س</span>
                                </div>
                                <div class="tax-note">
                                    بعد خصم قيمة الضريبة
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="promotion-small-container">
                    <div class="promotional-product">
                        <div class="product-image-container">
                            <img src="{{ asset('front/images/kara-sarimsak-yagi 1.png') }}" alt="مجموعة العناية بالأسنان" class="product-image">
                        </div>
                        <div class="product-details-last">
                            <div class="discount-tag">خصم 15%</div>
                            <h3 class="product-name">مجموعة العناية بالأسنان</h3>
                            <p class="product-description">فرشاة أسنان متطورة وحديثة</p>
                            <div class="product-price">
                                <div class="original-price">
                                    <span class="line-through">80.00 ر.س</span>
                                </div>
                                <div class="sale-price">
                                    37.00 <span class="currency">ر.س</span>
                                </div>
                                <div class="tax-note">
                                    بعد خصم قيمة الضريبة
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="promotional-product">
                        <div class="product-image-container">
                            <img src="{{ asset('front/images/kara-sarimsak-yagi 1.png') }}" alt="معجون أسنان بنكهة الموز" class="product-image">
                        </div>
                        <div class="product-details-last">
                            <div class="discount-tag">خصم 15%</div>
                            <h3 class="product-name">معجون أسنان بنكهة الموز</h3>
                            <div class="product-price">
                                <div class="original-price">
                                    <span class="line-through">39.00 ر.س</span>
                                </div>
                                <div class="sale-price">
                                    37.00 <span class="currency">ر.س</span>
                                </div>
                                <div class="tax-note">
                                    بعد خصم قيمة الضريبة
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Medical Products Section -->
        <section class="medical-products-section">
            <h2 class="section-title-last">منتجات طبية</h2>
            <div class="carousel-container">
                <div class="carousel-track" id="productCarousel">
                    <!-- Product Card 1 -->
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="مقياس الأكسجين" class="product-image">
                        </div>
                        <h3 class="product-name">مقياس الأكسجين</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="product-price">150 ر.س</span>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">عادية</span>
                            </div>
                            <span class="pharmacy-type regular">عادية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                    <!-- Product Card 2 -->
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="قسطرة وريدية" class="product-image">
                        </div>
                        <h3 class="product-name">قسطرة وريدية</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="product-price">150 ر.س</span>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">عادية</span>
                            </div>
                            <span class="pharmacy-type regular">عادية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                    <!-- Product Card 3 -->
                    <div class="product-card">
                        <div class="discount-badge">خصم 10%</div>
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="جهاز ضغط" class="product-image">
                        </div>
                        <h3 class="product-name">جهاز ضغط</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="product-price">150 ر.س</span>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">عادل</span>
                            </div>
                            <span class="pharmacy-type medical">طبية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                    <!-- Product Card 4 -->
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="سماعة طبية" class="product-image">
                        </div>
                        <h3 class="product-name">سماعة طبية</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="product-price">150 ر.س</span>
                            </div>
                            <div class="product-rating">
                                <span>4.5</span>
                                <svg class="star-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">طبية</span>
                            </div>
                            <span class="pharmacy-type medical">طبية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                    <!-- Product Card 5 -->
                    <div class="product-card">
                        <div class="discount-badge">خصم 10%</div>
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="جهاز قياس السكر" class="product-image">
                        </div>
                        <h3 class="product-name">جهاز قياس السكر</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="line-through">200 ر.س</span>
                                <span class="product-price">180 ر.س</span>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">الدواء</span>
                            </div>
                            <span class="pharmacy-type medical">طبية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                    <!-- Product Card 6 -->
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('front/images/Group 33560 (2).png') }}" alt="رباط طبي للركبة" class="product-image">
                        </div>
                        <h3 class="product-name">رباط طبي للركبة</h3>
                        <div class="product-price-row">
                            <div>
                                <span class="product-price">120 ر.س</span>
                            </div>
                        </div>
                        <div class="product-pharmacy">
                            <div class="pharmacy-name">
                                <span>صيدلية</span>
                                <span class="pharmacy-title">النهدي</span>
                            </div>
                            <span class="pharmacy-type regular">عادية</span>
                        </div>
                        <button class="add-to-cart-btn">أضف للسلة</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- الشركات الداعمة -->
    <section id="sponsors" class="sponsors-section">
        <h2 class="section-title">الشركات الداعمة</h2>
        <div class="sponsors-container">
            <div class="sponsor-logo">
                <a href=""><img src="{{ asset('front/images/download (6).png') }}" style="height: 140px; width: 140px;" alt="بيرزيت للأدوية"></a>
                <a href=""><img src="{{ asset('front/images/download (6).png') }}" style="height: 140px; width: 140px;" alt="بيرزيت للأدوية"></a>
                <a href=""><img src="{{ asset('front/images/download (6).png') }}" style="height: 140px; width: 140px;" alt="بيرزيت للأدوية"></a>
                <a href=""><img src="{{ asset('front/images/download (6).png') }}" style="height: 140px; width: 140px;" alt="بيرزيت للأدوية"></a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="testimonials-container">
            <div class="testimonial-cards-wrapper">
                <!-- Testimonial Card -->
                <div class="testimonial-card active" id="testimonial-1">
                    <div class="testimonial-rating">
                        <div class="stars-container">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="rating-value">4.5</span>
                        </div>
                    </div>
                    <p class="testimonial-content">هذا النص مثال يمكن أن يستبدل بنفس المساحة المخصصة له هذا النص هذا النص مثال يمكن أن يستبدل بنفس المساحة المخصصة له هذا النص مثال يمكن أن يستبدل بنفس المساحة المخصصة له هذا</p>
                    <div class="testimonial-author">
                        <div class="quote-icon">❝</div>
                        <div class="author-info">
                            <p class="author-name">أحمد عبد الخالدي</p>
                            <p class="author-position">مدير عام - 20 يناير 2023</p>
                        </div>
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="أحمد عبد الخالدي" class="author-avatar">
                    </div>
                </div>
                <!-- Testimonial Card (Hidden initially) -->
                <div class="testimonial-card" id="testimonial-2">
                    <div class="testimonial-rating">
                        <div class="stars-container">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="rating-value">4.8</span>
                        </div>
                    </div>
                    <p class="testimonial-content">خدمة ممتازة وفريق عمل متميز، استفدت كثيرًا من التجربة. أنصح الجميع بالتعامل معهم لتحقيق أفضل النتائج في وقت قياسي.</p>
                    <div class="testimonial-author">
                        <div class="quote-icon">❝</div>
                        <div class="author-info">
                            <p class="author-name">عمر سمير</p>
                            <p class="author-position">مستشار تقني - 15 فبراير 2023</p>
                        </div>
                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="عمر سمير" class="author-avatar">
                    </div>
                </div>
                <!-- Testimonial Card (Hidden initially) -->
                <div class="testimonial-card" id="testimonial-3">
                    <div class="testimonial-rating">
                        <div class="stars-container">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="rating-value">4.7</span>
                        </div>
                    </div>
                    <p class="testimonial-content">سرعة في التنفيذ ودقة في العمل. تجربة مميزة من البداية للنهاية، وإن شاء الله سنتعاون مرة أخرى قريبًا.</p>
                    <div class="testimonial-author">
                        <div class="quote-icon">❝</div>
                        <div class="author-info">
                            <p class="author-name">سارة العبيدي</p>
                            <p class="author-position">مديرة تسويق - 5 مارس 2023</p>
                        </div>
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="سارة العبيدي" class="author-avatar">
                    </div>
                </div>
            </div>
            <div class="testimonial-navigation">
                <button id="prev-btn" class="nav-arrow-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button id="next-btn" class="nav-arrow-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
            <div class="testimonial-summary">
                <h3 class="summary-title">تقييمات</h3>
                <p class="summary-description">أكثر من 50000 عميل مع تقييمات 5 نجوم</p>
                <p class="summary-text">هذا النص مثال ليمكن أن يستبدل بنفس المساحة المخصصة له هذا</p>
                <div class="rating-avatars">
                    <div class="rating-display">
                        <div class="stars-row">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                        </div>
                        <span class="rating-text">4.5 (5464+ تقييم)</span>
                    </div>
                    <div class="avatars-group">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="عميل" class="avatar">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="عميل" class="avatar">
                        <img src="https://randomuser.me/api/portraits/men/43.jpg" alt="عميل" class="avatar">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="عميل" class="avatar">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- إضافة jQuery وملف JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('front/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#locationSelector').on('change', function() {
                var location = $(this).val();
                $.ajax({
                    url: '{{ route("pharmacies.by.location", "") }}/' + location,
                    method: 'GET',
                    success: function(response) {
                        $('#pharmacyCards').html(response.html);
                        // تحديث الـ pagination بناءً على عدد الصيدليات المسترجعة
                        var totalCards = $(response.html).filter('.pharmacy-card').length;
                        var pages = Math.ceil(totalCards / 5);
                        $('#paginationText').text('1 / ' + (pages > 0 ? pages : 1));
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });
        });
    </script>
</x-front.main>
