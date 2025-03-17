{{-- <x-front.main>
    <!-- إضافة Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer>
    </script>

    <style>
        /* أسلوب عام للصفحة */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
            color: #333;
            direction: rtl;
        }

        .search-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        /* شريط التنقل والبحث */
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #007bff;
            background: #fff;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-bar a {
            color: #100f0f;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .nav-bar a:hover {
            color: #181919;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border: none;
            padding: 12px 20px;
            width: 300px;
            font-size: 16px;
            outline: none;
        }

        .search-button {
            background: #007bff;
            border: none;
            padding: 12px 25px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-button:hover {
            background: #007bff;
        }

        /* قسم التصفية والترتيب */
        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* تخصيص أزرار Bootstrap */
        .filter-btn,
        .sort-btn {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            margin-left: 10px;
        }

        .dropdown-menu {
            min-width: 150px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px;
            color: #333;
        }

        .dropdown-item:hover {
            background: #f0f0f0;
        }

        /* بطاقات المنتجات */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 10px;
        }

        .product-card h3 {
            font-size: 18px;
            color: #007bff;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .add-to-cart {
            background: #007bff;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-to-cart:hover {
            background: #007bff;
        }

        .pharmacy-name {
            font-size: 14px;
            color: #888;
            margin-top: 10px;
        }

        /* رسالة عدم وجود نتائج */
        .no-results {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #666;
            font-size: 20px;
        }

        .no-results a {
            color: #007bff;
            text-decoration: none;
        }

        .no-results a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="search-container">
        <div class="nav-bar">
            <div>
                <a href="{{ route('home') }}" class="home">الرئيسية</a>
                <span class="search"> > </span>
                <span class="search-result">{{ $query }}</span>
            </div>
            <div>
                <span class="producto">تم إيجاد {{ $inventories->count() }} منتج</span>
            </div>
        </div>

        <div class="filters">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="ابحث عن منتجك .." value="{{ $query }}"
                    id="searchInput">
                <button class="search-button">ابحث</button>
            </div>
            <div class="d-flex align-items-center">
                <!-- قائمة منسدلة للتصفية باستخدام Bootstrap -->
                <div class="dropdown me-2">
                    <button class="filter-btn dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($category && $categories->find($category))
                            {{ $categories->find($category)->name }}
                        @else
                            اختر فئة
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'sort' => $sort]) }}">الكل</a></li>
                        @foreach ($categories as $cat)
                            <li><a class="dropdown-item"
                                    href="{{ route('search', ['query' => $query, 'category' => $cat->id, 'sort' => $sort]) }}">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- قائمة منسدلة للترتيب باستخدام Bootstrap -->
                <div class="dropdown">
                    <button class="sort-btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        ترتيب: {{ $sort == 'asc' ? 'الأقل سعرًا' : 'الأعلى سعرًا' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'category' => $category, 'sort' => 'asc']) }}">الأقل
                                إلى الأعلى</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'category' => $category, 'sort' => 'desc']) }}">الأعلى
                                إلى الأقل</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product-grid" id="productGrid">
            @forelse ($inventories as $inventory)
                <div class="product-card">
                    <img src="{{ $inventory->medicine->image ? asset('storage/' . $inventory->medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                        alt="{{ $inventory->medicine->name }}">
                    <h3>{{ $inventory->medicine->name }}</h3>
                    <p>{{ number_format($inventory->selling_price, 2) }} ₪</p>
                    <div class="pharmacy-name">{{ $inventory->pharmacy->name }}</div>
                    <button class="add-to-cart cart-button" data-id="{{ $inventory->id }}"
                        data-href="{{ route('cart.show', $inventory->id) }}">
                        <span>أضف للسلة</span>
                        <i class="fa-solid fa-plus"></i>
                </div>
            @empty
                <div class="no-results">
                    لم يتم العثور على نتائج لبحثك.
                </div>
            @endforelse
        </div>

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



        // تحديث نص الزر بعد الاختيار (اختياري مع Bootstrap)
        document.querySelectorAll('#filterDropdown + .dropdown-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                const categoryName = this.textContent === 'الكل' ? 'اختر فئة' : this.textContent;
                document.getElementById('filterDropdown').textContent = categoryName;
            });
        });

        document.querySelectorAll('#sortDropdown + .dropdown-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                const sortText = this.textContent;
                document.getElementById('sortDropdown').textContent = `ترتيب: ${sortText}`;
            });
        });

        // البحث الديناميكي باستخدام AJAX
        const searchInput = document.querySelector('.search-input');
        const productGrid = document.getElementById('productGrid');
        const productCount = document.querySelector('.producto');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            const category = new URLSearchParams(window.location.search).get('category') || '';
            const sort = new URLSearchParams(window.location.search).get('sort') || 'asc';

            fetch(`/search?query=${encodeURIComponent(query)}&category=${category}&sort=${sort}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    productGrid.innerHTML = '';
                    if (data.inventories.length > 0) {
                        data.inventories.forEach(inventory => {
                            const card = `
                            <div class="product-card">
                                <img src="${inventory.medicine.image ? '/storage/' + inventory.medicine.image.path : '/storage/medicines/default-medicine.jpg'}" alt="${inventory.medicine.name}">
                                <h3>${inventory.medicine.name}</h3>
                                <p>${parseFloat(inventory.selling_price).toFixed(2)} ₪</p>
                                <div class="pharmacy-name">${inventory.pharmacy.name}</div>
                                <button class="add-to-cart">+ أضف للسلة</button>
                            </div>`;
                            productGrid.insertAdjacentHTML('beforeend', card);
                        });
                    } else {
                        productGrid.innerHTML = `
                        <div class="no-results">
                            لم يتم العثور على نتائج لبحثك.
                        </div>`;
                    }
                    productCount.textContent = `تم إيجاد ${data.inventories.length} منتج`;
                    document.querySelector('.search-result').textContent = query;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</x-front.main> --}}


<x-front.main>
    <!-- إضافة Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer>
    </script>

    <style>
        /* أسلوب عام للصفحة */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
            color: #333;
            direction: rtl;
        }

        .search-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        /* شريط التنقل والبحث */
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #007bff;
            background: #fff;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .nav-bar a {
            color: #100f0f;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }

        .nav-bar a:hover {
            color: #181919;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border: none;
            padding: 12px 20px;
            width: 300px;
            font-size: 16px;
            outline: none;
        }

        .search-button {
            background: #007bff;
            border: none;
            padding: 12px 25px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-button:hover {
            background: #007bff;
        }

        /* قسم التصفية والترتيب */
        .filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* تخصيص أزرار Bootstrap */
        .filter-btn,
        .sort-btn {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            margin-left: 10px;
        }

        .dropdown-menu {
            min-width: 150px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 10px;
            color: #333;
        }

        .dropdown-item:hover {
            background: #f0f0f0;
        }

        /* بطاقات المنتجات */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .product-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 10px;
        }

        .product-card h3 {
            font-size: 18px;
            color: #007bff;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .add-to-cart {
            background: #007bff;
            border: none;
            padding: 10px 20px;
            color: #fff;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-to-cart:hover {
            background: #007bff;
        }

        .pharmacy-name {
            font-size: 14px;
            color: #888;
            margin-top: 10px;
        }

        /* رسالة عدم وجود نتائج */
        .no-results {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #666;
            font-size: 20px;
        }

        .no-results a {
            color: #007bff;
            text-decoration: none;
        }

        .no-results a:hover {
            text-decoration: underline;
        }

        /* أسلوب الـ Modal */
        #authModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #authModal.active {
            display: flex;
        }

        .container-sal {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
            width: 400px;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .image-container img {
            width: 100%;
            max-width: 200px;
            margin-bottom: 20px;
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-sal {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
        }

        .login-btn {
            background-color: #007bff;
        }

        .register-btn {
            background-color: #28a745;
        }
    </style>

    <div class="search-container">
        <div class="nav-bar">
            <div>
                <a href="{{ route('home') }}" class="home">الرئيسية</a>
                <span class="search"> > </span>
                <span class="search-result">{{ $query }}</span>
            </div>
            <div>
                <span class="producto">تم إيجاد {{ $inventories->count() }} منتج</span>
            </div>
        </div>

        <div class="filters">
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="ابحث عن منتجك .." value="{{ $query }}"
                    id="searchInput">
                <button class="search-button">ابحث</button>
            </div>
            <div class="d-flex align-items-center">
                <!-- قائمة منسدلة للتصفية باستخدام Bootstrap -->
                <div class="dropdown me-2">
                    <button class="filter-btn dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($category && $categories->find($category))
                            {{ $categories->find($category)->name }}
                        @else
                            اختر فئة
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'sort' => $sort]) }}">الكل</a></li>
                        @foreach ($categories as $cat)
                            <li><a class="dropdown-item"
                                    href="{{ route('search', ['query' => $query, 'category' => $cat->id, 'sort' => $sort]) }}">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- قائمة منسدلة للترتيب باستخدام Bootstrap -->
                <div class="dropdown">
                    <button class="sort-btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        ترتيب: {{ $sort == 'asc' ? 'الأقل سعرًا' : 'الأعلى سعرًا' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'category' => $category, 'sort' => 'asc']) }}">الأقل
                                إلى الأعلى</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('search', ['query' => $query, 'category' => $category, 'sort' => 'desc']) }}">الأعلى
                                إلى الأقل</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product-grid" id="productGrid">
            @forelse ($inventories as $inventory)
                <div class="product-card">
                    <img src="{{ $inventory->medicine->image ? asset('storage/' . $inventory->medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                        alt="{{ $inventory->medicine->name }}">
                    <h3>{{ $inventory->medicine->name }}</h3>
                    <p>{{ number_format($inventory->selling_price, 2) }} ₪</p>
                    <div class="pharmacy-name">{{ $inventory->pharmacy->name }}</div>
                    <button class="add-to-cart cart-button" data-id="{{ $inventory->id }}"
                        data-href="{{ route('cart.show', $inventory->id) }}">
                        <span>أضف للسلة</span>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            @empty
                <div class="no-results">
                    لم يتم العثور على نتائج لبحثك.
                </div>
            @endforelse
        </div>

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

    <script>
        // تفويض حدث النقر على أزرار "أضف للسلة"
        document.querySelector('.product-grid').addEventListener('click', function(e) {
            const button = e.target.closest('.cart-button');
            if (button) {
                e.preventDefault();
                console.log('Button clicked!');
                const inventoryId = button.getAttribute('data-id');

                fetch('/check-auth', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
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
                            window.location.replace('/cart/show/' + inventoryId);
                        } else {
                            console.log('User is not authenticated, showing modal...');
                            showModal();
                        }
                    })
                    .catch(error => console.error('Fetch error:', error));
            }
        });

        // دالة إظهار النافذة المنبثقة
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

        // إغلاق النافذة المنبثقة عند النقر على زر الإغلاق
        document.querySelector('.modal-close')?.addEventListener('click', function() {
            const modal = document.getElementById('authModal');
            if (modal) modal.classList.remove('active');
        });

        // إغلاق النافذة المنبثقة عند النقر خارجها
        document.getElementById('authModal')?.addEventListener('click', function(e) {
            const modal = document.getElementById('authModal');
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // تحديث نص الزر بعد الاختيار (اختياري مع Bootstrap)
        document.querySelectorAll('#filterDropdown + .dropdown-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                const categoryName = this.textContent === 'الكل' ? 'اختر فئة' : this.textContent;
                document.getElementById('filterDropdown').textContent = categoryName;
            });
        });

        document.querySelectorAll('#sortDropdown + .dropdown-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                const sortText = this.textContent;
                document.getElementById('sortDropdown').textContent = `ترتيب: ${sortText}`;
            });
        });

        // البحث الديناميكي باستخدام AJAX
        const searchInput = document.querySelector('.search-input');
        const productGrid = document.getElementById('productGrid');
        const productCount = document.querySelector('.producto');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            const category = new URLSearchParams(window.location.search).get('category') || '';
            const sort = new URLSearchParams(window.location.search).get('sort') || 'asc';

            fetch(`/search?query=${encodeURIComponent(query)}&category=${category}&sort=${sort}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    productGrid.innerHTML = '';
                    if (data.inventories.length > 0) {
                        data.inventories.forEach(inventory => {
                            const card = `
                <div class="product-card">
                    <img src="${inventory.medicine.image ? '/storage/' + inventory.medicine.image.path : '/storage/medicines/default-medicine.jpg'}" alt="${inventory.medicine.name}">
                    <h3>${inventory.medicine.name}</h3>
                    <p>${parseFloat(inventory.selling_price).toFixed(2)} ₪</p>
                    <div class="pharmacy-name">${inventory.pharmacy.name}</div>
                    <button class="add-to-cart cart-button" data-id="${inventory.id}" data-href="${'/cart/show/' + inventory.id}">
                        <span>أضف للسلة</span>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>`;
                            productGrid.insertAdjacentHTML('beforeend', card);
                        });
                    } else {
                        productGrid.innerHTML = `
            <div class="no-results">
                لم يتم العثور على نتائج لبحثك.
            </div>`;
                    }
                    productCount.textContent = `تم إيجاد ${data.inventories.length} منتج`;
                    document.querySelector('.search-result').textContent = query;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</x-front.main>
