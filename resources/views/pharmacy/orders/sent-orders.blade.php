<x-dash.master>
    <div class="container py-6">
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">الطلبات المرسلة</h2>

            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">رقم الطلب</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">اسم الشركة</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">التاريخ</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">حالة الطلب</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">الأدوية</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">إجمالي السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $order->destination->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                @if ($order->order_status == 'completed')
                                    <span class="text-green-600">مكتمل</span>
                                @elseif ($order->order_status == 'processing')
                                    <span class="text-yellow-600">قيد التنفيذ</span>
                                @elseif ($order->order_status == 'canceled')
                                    <span class="text-red-600">ملغى</span>
                                @else
                                    <span class="text-blue-600">قيد الانتظار</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">
                                <ul>
                                    @foreach ($order->orderDetails as $detail)
                                        <li>{{ $detail->medicine->name }} - الكمية: {{ $detail->quantity }} - السعر: {{ number_format($detail->subtotal, 2) }} ج.م</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ number_format($order->total, 2) }} شيكل</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-sm text-gray-500 text-center">لا توجد طلبات مرسلة حاليًا.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-dash.master>
