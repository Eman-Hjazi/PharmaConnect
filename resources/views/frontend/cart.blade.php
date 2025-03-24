{{-- <x-front.main>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            direction: rtl;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            display: flex;
            justify-content: space-between;
            max-width: 900px;
            margin: 50px auto;
            gap: 20px;
            margin-top: 100px;
        }

        .cart-items {
            background: white;
            flex: 2;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 200px;
            height: auto;
            border-radius: 5px;
            object-fit: cover;


        }

        .item-details p {
            font-weight: bold;
        }

        .item-details {
            flex: 1;
            padding: 0 10px;
        }

        .quantity {
            display: flex;
            align-items: center;
        }

        .quantity button {
            width: 25px;
            height: 25px;
            background-color: white;
            color: black;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }

        .price {
            font-weight: bold;
            margin-left: 100px;
        }

        .remove {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: rgba(97, 97, 97, 0.8);
        }

        .coupon {
            background: #e6f2ff;
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .coupon p {
            color: rgba(97, 97, 97, 0.8);
        }

        .coupon h3 {
            margin-bottom: 10px;
        }

        .coupon-section {
            display: flex;
            gap: 5px;
            margin-bottom: 15px;
        }

        .coupon-section input {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .coupon-section button {
            background: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .coupon p {
            display: flex;
            justify-content: space-between;
        }

        .coupon-value {
            text-align: left;
            flex: 1;
            color: rgba(97, 97, 97, 0.8);
        }

        .pay-button {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .number {
            color: black;
        }

        /* أنماط للسلة الفارغة */
        .salaemp {
            display: none;
            /* مخفي افتراضيًا */
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .salaemp .cart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 600px;
        }

        .salaemp .cart-icon img {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .salaemp .cart-message {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .salaemp .cart-description {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
        }
    </style>

    <div class="cart-container">
        <div class="cart-items">
            @forelse ($carts as $cart)
                <div class="cart-item" data-id="{{ $cart->id }}"
                    data-base-price="{{ $cart->pharmacyInventory->selling_price }}">
                    <img src="{{ $cart->pharmacyInventory->medicine->image ? asset('storage/' . $cart->pharmacyInventory->medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                        alt="{{ $cart->pharmacyInventory->medicine->name }}">
                    <div class="item-details">
                        <p>{{ $cart->pharmacyInventory->medicine->name }}</p>
                        <div class="quantity">
                            <button class="increase">+</button>
                            <span class="quantity-value">{{ $cart->quantity }}</span>
                            <button class="decrease">-</button>
                        </div>
                    </div>
                    <span
                        class="price">{{ number_format($cart->quantity * $cart->pharmacyInventory->selling_price, 2) }}
                        ₪</span>
                    <button class="remove">×</button>
                </div>
            @empty
                <!-- لا شيء هنا لأن العناصر ستبقى داخل .cart-items -->
            @endforelse
        </div>

        <section class="section-left">
            <div class="coupon">
                <h3>قائمة الكوبون</h3>
                <div class="coupon-section">
                    <input type="text" placeholder="كوبون خصم">
                    <button>حفظ</button>
                </div>

                <h3>الفاتورة</h3>
                <p>مجموع المنتجات: <span class="coupon-value"><span
                            class="number subtotal">{{ number_format($subtotal, 2) }}</span> ₪</span></p>
                <p>الشحن: <span class="coupon-value"><span
                            class="number shipping">{{ number_format($shipping, 2) }}</span> ₪</span></p>
                <p class="total">الإجمالي: <span class="coupon-value"><span
                            class="number total">{{ number_format($total, 2) }}</span> ₪</span></p>
                <button class="pay-button">ادفع</button>
            </div>
        </section>
    </div>

    <!-- دائمًا أضف السلة الفارغة في الصفحة للتحكم الديناميكي -->
    <div class="salaemp">
        <div class="cart-container">
            <div class="cart-icon">
                <img src="{{ asset('front/images/emptysala.png') }}" alt="سله فارغة">
            </div>
            <div class="cart-message">سلة مشترياتك فارغة حالياً!</div>
            <div class="cart-description">
                قبل الشروع في الدفع، يجب عليك إضافة بعض المنتجات إلى عربة التسوق الخاصة بك.<br>
                سوف تجد الكثير من المنتجات الشيقة على <a href="{{route('home')}}">صفحة التسوق</a> الخاصة
                بنا.
            </div>
        </div>
    </div>


    <script>
        // تحديث الكمية وحذف العناصر
        document.querySelectorAll('.cart-item').forEach(item => {
            const cartId = item.getAttribute('data-id');
            const quantityElement = item.querySelector('.quantity-value');
            const priceElement = item.querySelector('.price');
            const basePrice = parseFloat(item.getAttribute('data-base-price'));

            // زر الزيادة
            item.querySelector('.increase').addEventListener('click', () => {
                let quantity = parseInt(quantityElement.textContent);
                quantity++;
                updateQuantity(cartId, quantity);
            });

            // زر النقصان
            item.querySelector('.decrease').addEventListener('click', () => {
                let quantity = parseInt(quantityElement.textContent);
                if (quantity > 1) {
                    quantity--;
                    updateQuantity(cartId, quantity);
                } else {
                    removeItem(cartId);
                }
            });

            // زر الحذف
            item.querySelector('.remove').addEventListener('click', () => {
                removeItem(cartId);
            });
        });

        function updateQuantity(cartId, quantity) {
            fetch(`/cart/update/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
                        if (quantity < 1) {
                            item.remove();
                        } else {
                            item.querySelector('.quantity-value').textContent = quantity;
                            item.querySelector('.price').textContent = (quantity * parseFloat(item.getAttribute(
                                'data-base-price'))).toFixed(2) + ' ₪';
                        }

                        updateTotal();
                        checkEmptyCart();
                        document.dispatchEvent(new Event('cartUpdated'));
                    }
                })
                .catch(error => console.error('Error updating quantity:', error));
        }

        function removeItem(cartId) {
            fetch(`/cart/remove/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const item = document.querySelector(`.cart-item[data-id="${cartId}"]`);
                        if (item) {
                            item.remove();
                            updateTotal();
                            checkEmptyCart();
                            document.dispatchEvent(new Event('cartUpdated'));
                        }
                    }
                })
                .catch(error => console.error('Error removing item:', error));
        }

        function updateTotal() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const quantity = parseInt(item.querySelector('.quantity-value').textContent);
                const price = parseFloat(item.getAttribute('data-base-price'));
                subtotal += quantity * price;
            });

            const shipping = {{ $shipping }};
            const total = subtotal + shipping;

            document.querySelector('.subtotal').textContent = subtotal.toFixed(2);
            document.querySelector('.total').textContent = total.toFixed(2);
        }

        function checkEmptyCart() {
            const cartItems = document.querySelectorAll('.cart-item');
            const salaemp = document.querySelector('.salaemp');
            const cartContainer = document.querySelector('.cart-container');
            console.log('cartItems length:', cartItems.length);
            console.log('salaemp:', salaemp);
            console.log('cartContainer:', cartContainer);
            if (cartItems.length === 0 && cartContainer && salaemp) {
                cartContainer.style.display = 'none';
                salaemp.style.display = 'flex';
            }
        }
        // التحقق عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            checkEmptyCart();
        });
    </script>

</x-front.main> --}}


@section('css')
    <link rel="stylesheet" href="{{ asset('front/css/cart.css') }}">
@endsection
<x-front.main>

    <div class="cart-container">
        <div class="cart-items">
            @forelse ($carts as $cart)
                <div class="cart-item" data-id="{{ $cart->id }}"
                    data-base-price="{{ $cart->pharmacyInventory->selling_price }}">
                    <img src="{{ $cart->pharmacyInventory->medicine->image ? asset('storage/' . $cart->pharmacyInventory->medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                        alt="{{ $cart->pharmacyInventory->medicine->name }}">
                    <div class="item-details">
                        <p>{{ $cart->pharmacyInventory->medicine->name }}</p>
                        <div class="quantity">
                            <button class="increase">+</button>
                            <span class="quantity-value">{{ $cart->quantity }}</span>
                            <button class="decrease">-</button>
                        </div>
                    </div>
                    <span
                        class="price">{{ number_format($cart->quantity * $cart->pharmacyInventory->selling_price, 2) }}
                        ₪</span>
                    <button class="remove">×</button>
                </div>
            @empty
            @endforelse
        </div>

        <section class="section-left">
            <div class="coupon">
                <h3>قائمة الكوبون</h3>
                <div class="coupon-section">
                    <input type="text" placeholder="كوبون خصم">
                    <button>حفظ</button>
                </div>

                <h3>الفاتورة</h3>
                <p>مجموع المنتجات: <span class="coupon-value"><span
                            class="number subtotal">{{ number_format($subtotal, 2) }}</span> ₪</span></p>
                <p>الشحن: <span class="coupon-value"><span
                            class="number shipping">{{ number_format($shipping, 2) }}</span> ₪</span></p>
                <p class="total">الإجمالي: <span class="coupon-value"><span
                            class="number total">{{ number_format($total, 2) }}</span> ₪</span></p>
                <button class="pay-button" id="order-now">طلب الآن</button>
            </div>
        </section>
    </div>

    <!-- السلة الفارغة -->
    <div class="salaemp">
        <div class="cart-container">
            <div class="cart-icon">
                <img src="{{ asset('front/images/emptysala.png') }}" alt="سله فارغة">
            </div>
            <div class="cart-message">سلة مشترياتك فارغة حالياً!</div>
            <div class="cart-description">
                قبل الشروع في الدفع، يجب عليك إضافة بعض المنتجات إلى عربة التسوق الخاصة بك.<br>
                سوف تجد الكثير من المنتجات الشيقة على <a href="{{ route('home') }}">صفحة التسوق</a> الخاصة
                بنا.
            </div>
        </div>
    </div>

    <!-- Modal لرفع الروشتة -->
    <div class="modal" id="prescription-modal">
        <div class="modal-content">
            <h3>يرجى إدخال صورة الروشتة</h3>
            <form id="prescription-form" action="{{ route('order.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="file" name="prescription" accept="image/*" required>
                <button type="submit">إرسال</button>
            </form>
        </div>
    </div>

    <!-- Modal لتأكيد الطلب -->
    <div class="modal" id="confirmation-modal">
        <div class="modal-content">
            <h3>تم تقديم طلبك بنجاح!</h3>
            <p>شكرًا لك، سيتم مراجعة الروشتة وتأكيد الطلب قريبًا.</p>
            <a href="{{ route('home') }}">العودة للصفحة الرئيسية</a>
        </div>
    </div>

    @section('js')
        <script src="{{ asset('front/js/cart.js') }}"></script>
    @endsection
</x-front.main>
