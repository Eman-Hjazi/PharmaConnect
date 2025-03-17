<x-dash.master>
    <div class="container px-6 py-8">
        <!-- عنوان الصفحة -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="lucide lucide-receipt text-blue-600"></i> تفاصيل الطلب
            </h1>
            <a href="{{ route('company.orders.index') }}"
                class="px-4 py-2 text-sm font-semibold text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                <i class="lucide lucide-arrow-left"></i> العودة إلى الطلبات
            </a>
        </div>

        <!-- معلومات الطلب -->
        <div class="bg-white shadow-lg rounded-2xl p-6 mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                <i class="lucide lucide-info"></i> معلومات الطلب
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div>
                    <p class="text-gray-700"><strong>رقم الطلب:</strong> {{ $order->id }}</p>
                    <p class="text-gray-700 flex items-center">
                        <strong class="mr-2">حالة الطلب:</strong>
                        <select id="orderStatus"
                            class="px-3 py-1 border rounded-lg text-gray-700 focus:ring focus:ring-blue-300 transition"
                            data-order-id="{{ $order->id }}"
                            {{ in_array($order->order_status, ['completed', 'canceled']) ? 'disabled' : '' }}>
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>قيد
                                الانتظار</option>
                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>قيد
                                التنفيذ</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>مكتمل
                            </option>
                            <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>ملغي
                            </option>
                        </select>
                    </p>
                    <p class="text-gray-700"><strong>إجمالي المبلغ:</strong> {{ number_format($order->total, 2) }} شيكل
                    </p>
                </div>
                <div>
                    <p class="text-gray-700"><strong>تاريخ الإنشاء:</strong>
                        {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p class="text-gray-700"><strong>الجهة الطالبة:</strong> {{ $order->orderable->name }}</p>
                    <p class="text-gray-700"><strong>الجهة المستقبلة:</strong> {{ $order->destination->name }}</p>
                </div>
            </div>
        </div>

        <!-- تفاصيل الأدوية -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
            <h2 class="text-lg font-semibold text-blue-700 flex items-center gap-2">
                <i class="lucide lucide-pill"></i> تفاصيل الأدوية
            </h2>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">اسم الدواء</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">الكمية</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">سعر الوحدة</th>
                            <th class="py-3 px-4 text-gray-700 font-semibold text-right">المجموع الفرعي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $detail)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-gray-900">{{ $detail->medicine->name }}</td>
                                <td class="py-3 px-4 text-gray-900">{{ $detail->quantity }}</td>
                                <td class="py-3 px-4 text-gray-900">{{ number_format($detail->unit_price, 2) }} شيكل
                                </td>
                                <td class="py-3 px-4 text-gray-900">{{ number_format($detail->subtotal, 2) }} شيكل</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- سكريبت AJAX & SweetAlert -->
    <script>
        document.getElementById('orderStatus').addEventListener('change', function() {
            const orderId = this.getAttribute('data-order-id');
            const newStatus = this.value;
            const selectElement = this;

            fetch(`/company/orders/${orderId}/update-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // تحديث الـ <select> ليعكس التغيير مباشرة دون إعادة تحميل الصفحة
                        selectElement.value = newStatus;

                        // تعطيل القائمة إذا كانت الحالة "مكتمل" أو "ملغي"
                        if (newStatus === 'completed' || newStatus === 'canceled') {
                            selectElement.setAttribute('disabled', true);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحديث!',
                            text: 'تم تغيير حالة الطلب بنجاح.',
                            confirmButtonText: 'موافق'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: 'لا يمكن الاتصال بالخادم.',
                        confirmButtonText: 'حسناً'
                    });
                });
        });
    </script>
</x-dash.master>
