<x-dash.master>
    <div class="bg-white rounded-lg overflow-hidden mt-10 mx-10 shadow-sm hover:shadow-md transition-shadow duration-300">
        <h2 class="text-lg font-bold text-gray-700 p-2">طلبات الصيدليات

        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-right font-semibold text-gray-600">رقم الطلب</th>
                        <th class="py-3 px-6 text-right font-semibold text-gray-600">اسم الصيدلية</th>
                        <th class="py-3 px-6 text-right font-semibold text-gray-600">تاريخ الطلب</th>
                        <th class="py-3 px-6 text-right font-semibold text-gray-600">الحالة</th>
                        <th class="py-3 px-6 text-right font-semibold text-gray-600">عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-6 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6 text-gray-900 font-medium">{{ $order->orderable->name }}</td>
                            <td class="py-3 px-6 text-gray-600">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-6">
                                @switch($order->order_status)
                                    @case('pending')
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-700">
                                            قيد الانتظار
                                        </span>
                                    @break

                                    @case('completed')
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700">
                                            مكتمل
                                        </span>
                                    @break

                                    @case('processing')
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-700">
                                            قيد المعالجة
                                        </span>
                                    @break

                                    @case('canceled')
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-50 text-red-700">
                                            ملغي
                                        </span>
                                    @break

                                    @default
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gray-50 text-gray-700">
                                            {{ $order->order_status }}
                                        </span>
                                @endswitch
                            </td>
                            <td class="py-3 px-6">
                                <a href="{{ route('company.orders.show', $order->id) }}"
                                    class="inline-block px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors">
                                    عرض
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-dash.master>
