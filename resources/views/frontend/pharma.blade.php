





<x-front.main :pharmacy="$pharmacy" :categories="$categories">
    <link rel="stylesheet" href="{{ asset('front/css/pharma.css') }}">



    <div class="container">
        <!-- Pharmacy Hero Section -->
        <section class="pharmacy-hero">
            <div class="pharmacy-banner">
                <img src="{{ asset('storage/pharmacy/' . 'back.png') }}" alt="صيدلية {{ $pharmacy->name }}"
                    class="banner-image">
            </div>
            <div class="pharmacy-info">
                <div class="pharmacy-details">
                    <div class="pharmacy-summary">
                        <h1 class="pharmacy-name">{{ $pharmacy->name }}</h1>
                        <div class="pharmacy-metadata">
                            <div class="metadata-item">
                                <span class="metadata-label">الموقع</span>
                                <p>{{ $pharmacy->address }}</p>
                            </div>
                        </div>
                        <div class="pharmacy-description">
                            <div class="description-item">
                                <span class="icon delivery">📦</span>
                                <span>يتم توصيل الطلبات خلال 30 ساعة عمل</span>
                            </div>
                            <div class="description-item">
                                <span class="icon payment">💳</span>
                                <span>يتم الدفع عند الاستلام أو الدفع اون لاين</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pharmacy-logo">
                    <img src="{{ $pharmacy->image ? asset('storage/' . $pharmacy->image->path) : asset('storage/pharmacy/pharma.png') }}"
                        alt="شعار {{ $pharmacy->name }}" class="logo-image">
                </div>
            </div>
        </section>

        <!-- Search Section -->
        <div class="search-section">
            <input type="text" placeholder="ابحث عن منتج..." id="searchInput" onkeyup="searchMedicines()">
            <button>البحث</button>
        </div>

        <!-- Categories Tabs -->
        <div id="categoryTabs" class="sticky-header">
            <button class="category-tab active" data-category="all">جميع المنتجات</button>
            @foreach ($categories as $category)
                <button class="category-tab"
                    data-category="{{ strtolower($category->name) }}">{{ $category->name }}</button>
            @endforeach
        </div>

        <!-- Product Grid -->
        <div id="productGrid" class="product-grid">
            @foreach ($pharmacy->inventories as $inventory)
                <div class="product-card active current-page"
                    data-category="{{ strtolower($inventory->medicine->category->name ?? 'all') }}"
                    data-id="{{ $inventory->id }}">
                    <div class="product-image-container">
                        <img src="{{ $inventory->medicine->image ? asset('storage/' . $inventory->medicine->image->path) : asset('storage/medicines' . '/default-medicine.jpg') }}"
                            alt="{{ $inventory->medicine->name }}" class="product-image">
                        <div class="product-badge badge-{{ $inventory->status === 'نفذ' ? 'sold-out' : 'available' }}">
                            {{ $inventory->status }}
                        </div>
                        <button class="favorite-button" data-id="{{ $inventory->id }}">
                            <i class="favorite-icon fa-heart fa-regular"></i>
                        </button>
                        <div class="rating">
                            <span>4.5</span>
                            <i class="fa-solid fa-star star-icon"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-meta">
                            <span>{{ $inventory->medicine->description ?? 'لا يوجد وصف' }}</span>
                            <span class="dot"></span>
                            <span>{{ $inventory->selling_price }}</span>
                        </div>
                        <h3 class="product-name">{{ $inventory->medicine->name }}</h3><button class="cart-button"
                            data-id="{{ $inventory->id }}" data-href="{{ route('cart.show', $inventory->id) }}">
                            <span>أضف للسلة</span>
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination" id="pagination">
            <button id="prev-page" class="page-button" disabled>
                <i class="fa-solid fa-chevron-right chevron-icon"></i>
            </button>
            <button class="page-button active" data-page="1">1</button>
            <button class="page-button" data-page="2">2</button>
            <button id="next-page" class="page-button">
                <i class="fa-solid fa-chevron-left chevron-icon"></i>
            </button>
        </div>






        <!-- داخل <div class="container"> بعد قسم الـ Pagination -->
        <section id="authModal" class="hero-sal">
            <main class="container-sal">
                <span class="modal-close">×</span>
                <div class="image-container">
                    <img src="{{ asset('front/images/Frame.png') }}" alt="دعوة للتسجيل">
                </div>
                <h2>يرجى تسجيل الدخول!</h2>
                <p>تحتاج إلى حساب لإضافة المنتجات إلى السلة ومتابعة طلبك.</p>
                <div class="buttons-container">
                    <a href="{{ route('login') }}" class="btn-sal login-btn">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="btn-sal register-btn">إنشاء حساب</a>
                </div>
            </main>
        </section>
    </div>




    <script src="{{ asset('front/js/pharma.js') }}"></script>

    <script>
        document.querySelectorAll('.cart-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Button clicked!');
                const inventoryId = this.getAttribute('data-id'); // الحصول على inventoryId من data-id

                fetch('/check-auth', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response:', data);
                        if (data.authenticated) {
                            console.log('User is authenticated, redirecting to cart.show...');
                            // التوجيه إلى مسار cart.show مع تمرير inventoryId
                            window.location.href = '/cart/show/' + inventoryId;
                        } else {
                            console.log('User is not authenticated, showing modal...');
                            showModal();
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            });
        });

        function showModal() {
            console.log('Showing modal');
            const modal = document.getElementById('authModal');
            if (modal) {
                console.log('Modal found, adding active class');
                modal.classList.add('active');
            } else {
                console.error('Modal element #authModal not found!');
            }
        }

        document.querySelector('.modal-close')?.addEventListener('click', function() {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.remove('active');
        });

        document.getElementById('authModal')?.addEventListener('click', function(e) {
            const modal = document.getElementById('authModal');
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // دالة البحث (لا تتغير)
        function searchMedicines() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let cards = document.getElementById("productGrid").getElementsByClassName("product-card");

            for (let i = 0; i < cards.length; i++) {
                let nameElement = cards[i].getElementsByClassName("product-name")[0];
                let descriptionElement = cards[i].getElementsByClassName("product-meta")[0].getElementsByTagName("span")[0];
                let name = nameElement ? nameElement.innerText.toLowerCase() : '';
                let description = descriptionElement ? descriptionElement.innerText.toLowerCase() : '';

                if (name.includes(input) || description.includes(input)) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }
    </script>
</x-front.main>


