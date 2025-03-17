{{-- <x-front.main>
    <div class="container-product">
        <!-- Product Section -->
        <div class="product-section">
            <div class="product-one-image">
                <img src="{{ $medicine->image ? asset('storage/' . $medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                    class="card-img-top rounded-top-4 img-fluid" style="height: 200px; object-fit: cover;"
                    alt="{{ $medicine->name }}">
            </div>
            <div class="product-details">
                <div class="status">{{ $inventory->status }}</div>
                <h1>{{ $medicine->name }}</h1>
                <p>{{ $medicine->description }}</p>
                <p class="price">{{ $inventory->selling_price }}</p>

                <!-- Quantity Section -->
                <div class="quantity-section">
                    <button id="decrease">-</button>
                    <span id="quantity">1</span>
                    <button id="increase">+</button>
                </div>

                <!-- Actions -->
                <div class="actions">
                    <button class="buy-now">شراء الآن</button>
                    <button class="add-to-cart"
                       >أضف للسلة</button>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <button class="tab-button active" data-tab="description">الوصف</button>
            <button class="tab-button" data-tab="details">تفاصيل المنتج</button>
            <button class="tab-button" data-tab="reviews">التقييمات</button>
        </div>

        <!-- Tab Content -->
        <div id="description" class="tab-content">
            <h3>{{ $medicine->description }}</h3>
        </div>
        <div id="details" class="tab-content hidden">
            <h3>تفاصيل المنتج</h3>
            <p>معلومات إضافية عن المنتج (يمكن إضافتها لاحقًا).</p>
        </div>
        <div id="reviews" class="tab-content hidden">
            <h3>التقييمات</h3>
            <p>لا توجد تقييمات بعد لهذا المنتج.</p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('front/js/product.js') }}"></script>
    <script>
        // التحكم في الكمية
        const quantitySpan = document.getElementById('quantity');
        document.getElementById('increase').addEventListener('click', () => {
            quantitySpan.textContent = parseInt(quantitySpan.textContent) + 1;
        });
        document.getElementById('decrease').addEventListener('click', () => {
            const quantity = parseInt(quantitySpan.textContent);
            if (quantity > 1) quantitySpan.textContent = quantity - 1;
        });

        // التحكم في التبويبات
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));

                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.remove('hidden');
            });
        });

        // إضافة إلى السلة في صفحة المنتج



    </script>
</x-front.main> --}}

<x-front.main>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-product">
        <!-- Product Section -->
        <div class="product-section">
            <div class="product-one-image">
                <img src="{{ $medicine->image ? asset('storage/' . $medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                    class="card-img-top rounded-top-4 img-fluid" style="height: 200px; object-fit: cover;"
                    alt="{{ $medicine->name }}">
            </div>
            <div class="product-details">
                <div class="status">{{ $inventory->status }}</div>
                <h1>{{ $medicine->name }}</h1>
                <p>{{ $medicine->description }}</p>
                <p class="price" data-base-price="{{ $inventory->selling_price }}">
                    السعر: <span id="total-price">{{ $inventory->selling_price }}</span>
                </p>

                <!-- Quantity Section -->
                <div class="quantity-section">
                    <button id="decrease">-</button>
                    <span id="quantity">1</span>
                    <button id="increase">+</button>
                </div>

                <!-- Actions -->
                <div class="actions">
                    <button class="buy-now">شراء الآن</button>
                    <button class="add-to-cart" data-inventory-id="{{ $inventory->id }}">أضف للسلة</button>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <button class="tab-button active" data-tab="description">الوصف</button>
            <button class="tab-button" data-tab="details">تفاصيل المنتج</button>
            <button class="tab-button" data-tab="reviews">التقييمات</button>
        </div>

        <!-- Tab Content -->
        <div id="description" class="tab-content">
            <h3>{{ $medicine->description }}</h3>
        </div>
        <div id="details" class="tab-content hidden">
            <h3>تفاصيل المنتج</h3>
            <p>معلومات إضافية عن المنتج (يمكن إضافتها لاحقًا).</p>
        </div>
        <div id="reviews" class="tab-content hidden">
            <h3>التقييمات</h3>
            <p>لا توجد تقييمات بعد لهذا المنتج.</p>
        </div>
    </div>

  <!-- إضافة المكتبات والسكربت الخاص بـ product -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('front/js/product.js') }}" defer></script>

</x-front.main>
