<x-front.main>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-product">
        <!-- Product Section -->
        <div class="product-section">

            <div class="product-one-image">
                <img src="{{ $medicine->image ? asset('storage/' . $medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                    class="card-img-top img-fluid rounded-top-4" alt="{{ $medicine->name }}" loading="lazy">
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

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('front/js/product.js') }}" defer></script>
    @endsection

</x-front.main>
