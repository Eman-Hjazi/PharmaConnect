<x-dash.master>
    <div class="min-h-screen bg-gray-50 p-6">
        <!-- عنوان الصفحة -->
        <h1 class="text-4xl font-extrabold text-blue-700 mb-8 text-center">الأدوية المتاحة للطلب</h1>

        <!-- فلتر البحث والتصفية -->
        <div class="flex justify-center items-center mb-6 gap-4">
            <input type="text" class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="ابحث عن دواء..." id="searchInput">
            <select id="companyFilter" class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-600 text-white shadow-sm">
                <option value="">جميع الشركات</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- شبكة البطاقات -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="medicinesGrid">
            @forelse($medicines as $medicine)
                <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 flex flex-col h-full transition-transform transform hover:scale-105 w-72 h-64" data-company-id="{{ $medicine->company->id ?? '' }}">
                    <img src="{{ asset('storage/' . ($medicine->image ? $medicine->image->path : 'medicines/default-medicine.jpg')) }}"
                         alt="{{ $medicine->name }}"
                         class="w-32 h-32 mx-auto mb-3 rounded">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $medicine->name }}</h2>
                    <p class="text-gray-600">الشركة: {{ $medicine->company->name ?? 'غير معروف' }}</p>
                    <p class="text-green-600 font-semibold mb-4">${{ number_format($medicine->base_price, 2) }}</p>
                    <button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-800 open-order-modal mt-auto"
                            data-medicine-id="{{ $medicine->id }}"
                            data-medicine-price="{{ $medicine->base_price }}"
                            data-medicine-name="{{ $medicine->name }}"
                            data-medicine-company="{{ $medicine->company->name ?? 'غير معروف' }}">
                        طلب الآن
                    </button>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-full">لا توجد أدوية متاحة حاليًا</p>
            @endforelse
        </div>

        <!-- نموذج الطلب (Modal) -->
        <div id="add-new-order" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-xl w-11/12 md:w-1/2 text-right relative">
                <button id="close-modal" class="absolute top-4 left-4 text-gray-600 hover:text-red-500 text-2xl">×</button>
                <h1 class="text-3xl font-bold text-blue-800 mb-6">طلب دواء جديد</h1>
                <form action="{{ route('pharmacy.medicine.order') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="medicine_id" id="medicine_id">
                    <div class="mb-6 space-y-4">
                        <div>
                            <label class="text-gray-700 font-medium">اسم الدواء:</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100" id="medicine_name" disabled>
                        </div>
                        <div>
                            <label class="text-gray-700 font-medium">الشركة:</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100" id="medicine_company" disabled>
                        </div>
                        <div>
                            <label class="text-gray-700 font-medium">السعر للوحدة:</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100" id="medicine_price" disabled>
                        </div>
                        <div>
                            <label class="text-gray-700 font-medium">الكمية:</label>
                            <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right" name="quantity" id="quantity" min="1" placeholder="أدخل الكمية" required>
                        </div>
                        <div>
                            <label class="text-gray-700 font-medium">السعر الإجمالي:</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100" id="totalPrice" disabled>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-800">تأكيد الطلب</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // البحث والتصفية
        const searchInput = document.getElementById('searchInput');
        const companyFilter = document.getElementById('companyFilter');
        const grid = document.getElementById('medicinesGrid');
        const cards = grid.getElementsByTagName('div');

        function filterGrid() {
            const searchTerm = searchInput.value.toLowerCase();
            const companyId = companyFilter.value;

            for (let card of cards) {
                const medicineName = card.querySelector('h2').textContent.toLowerCase();
                const rowCompanyId = card.getAttribute('data-company-id');
                const matchesSearch = medicineName.includes(searchTerm);
                const matchesCompany = !companyId || rowCompanyId === companyId;
                card.style.display = matchesSearch && matchesCompany ? '' : 'none';
            }
        }
        searchInput.addEventListener('input', filterGrid);
        companyFilter.addEventListener('change', filterGrid);

        // إدارة نموذج الطلب
        const addNewOrderButtons = document.querySelectorAll('.open-order-modal');
        const addNewOrderModel = document.getElementById('add-new-order');
        const closeModalButton = document.getElementById('close-modal');
        const quantityInput = document.getElementById('quantity');
        const totalPriceInput = document.getElementById('totalPrice');
        let pricePerUnit = 0; // متغير لحفظ السعر للوحدة

        function calculateTotalPrice() {
            const quantity = parseInt(quantityInput.value) || 0;
            const totalPrice = pricePerUnit * quantity;
            totalPriceInput.value = totalPrice.toFixed(2);
        }

        addNewOrderButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('medicine_id').value = button.getAttribute('data-medicine-id');
                document.getElementById('medicine_name').value = button.getAttribute('data-medicine-name');
                document.getElementById('medicine_company').value = button.getAttribute('data-medicine-company');
                pricePerUnit = parseFloat(button.getAttribute('data-medicine-price'));
                document.getElementById('medicine_price').value = pricePerUnit.toFixed(2);
                quantityInput.value = 1;
                calculateTotalPrice();
                addNewOrderModel.classList.remove('hidden');
            });
        });

        // تحديث السعر الإجمالي عند تغيير الكمية
        quantityInput.addEventListener('input', calculateTotalPrice);

        // إغلاق النموذج عند النقر على زر الإغلاق
        closeModalButton.addEventListener('click', () => {
            addNewOrderModel.classList.add('hidden');
        });

        // إغلاق النموذج عند النقر خارج النافذة
        addNewOrderModel.addEventListener('click', (e) => {
            if (e.target === addNewOrderModel) {
                addNewOrderModel.classList.add('hidden');
            }
        });
    </script>
</x-dash.master>
