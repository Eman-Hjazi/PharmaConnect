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
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                {{ $loop->iteration + $orders->firstItem() - 1 }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">{{ $order->orderable->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                {{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 text-sm text-right">
                                <select class="px-2 py-1 border rounded text-right w-full status-select"
                                    data-order-id="{{ $order->id }}"
                                    {{ in_array($order->order_status, ['completed', 'canceled']) ? 'disabled' : '' }}
                                    onchange="updateOrderStatus(this, {{ $order->id }})">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>
                                        قيد الانتظار</option>
                                    <option value="processing"
                                        {{ $order->order_status == 'processing' ? 'selected' : '' }}>قيد التنفيذ
                                    </option>
                                    <option value="completed"
                                        {{ $order->order_status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>
                                        ملغى</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                <ul class="list-disc list-inside">
                                    @foreach ($order->orderDetails as $detail)
                                        <li>
                                            {{ $detail->medicine->name }} - الكمية: {{ $detail->quantity }} - السعر:
                                            {{ number_format($detail->unit_price, 2) }}
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



    @push('scripts')
        <script src="{{ asset('backend/js/pharmacy/order.js') }}"></script>
    @endpush

</x-dash.master>
