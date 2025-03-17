<x-dash.master>
    <div class="container py-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-semibold mb-4 text-right">الطلبات الواردة</h2>

            <table class="min-w-full table-auto border-collapse divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="px-4 py-2 text-right">#</th>
                        <th class="px-4 py-2 text-right">اسم المستخدم</th>
                        <th class="px-4 py-2 text-right">التاريخ</th>
                        <th class="px-4 py-2 text-right">حالة الطلب</th>
                        <th class="px-4 py-2 text-right">الأدوية</th>
                        <th class="px-4 py-2 text-right">الإجمالي</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">{{ $loop->iteration + $orders->firstItem() - 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">{{ $order->orderable->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 text-sm text-right">
                                <select
                                    class="px-2 py-1 border rounded text-right w-full status-select"
                                    data-order-id="{{ $order->id }}"
                                    {{ in_array($order->order_status, ['completed', 'canceled']) ? 'disabled' : '' }}
                                    onchange="updateOrderStatus(this, {{ $order->id }})">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>قيد التنفيذ</option>
                                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>ملغى</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                <ul class="list-disc list-inside">
                                    @foreach ($order->orderDetails as $detail)
                                        <li>
                                            {{ $detail->medicine->name }} - الكمية: {{ $detail->quantity }} - السعر: {{ number_format($detail->unit_price, 2) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                {{ number_format($order->total, 2) }} شيكل
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">لا توجد طلبات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 text-right">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function updateOrderStatus(selectElement, orderId) {
        const newStatus = selectElement.value;
        const originalStatus = selectElement.getAttribute('data-original-status') || selectElement.options[selectElement.selectedIndex].value;

        fetch(`/pharmacy/orders/${orderId}/update-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Dynamic CSRF token
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Update UI
                selectElement.classList.add('bg-green-100');
                setTimeout(() => selectElement.classList.remove('bg-green-100'), 2000);

                // Disable dropdown if completed or canceled
                if (newStatus === 'completed' || newStatus === 'canceled') {
                    selectElement.disabled = true;
                }
            } else {
                // Revert to original status on error
                selectElement.value = originalStatus;

                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: data.message || 'حدث خطأ أثناء تحديث الحالة',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            selectElement.value = originalStatus;
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'خطأ في الاتصال بالسيرفر',
            });
        });

        // Store original status
        selectElement.setAttribute('data-original-status', newStatus);
    }

    // Add responsiveness for mobile
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.querySelector('table');
        if (window.innerWidth < 768) {
            table.classList.add('table-responsive');
        }
    });
    </script>

    <style>
    @media (max-width: 768px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        th, td {
            min-width: 120px;
        }
    }
    .status-select {
        min-width: 120px;
    }
    </style>
</x-dash.master>
