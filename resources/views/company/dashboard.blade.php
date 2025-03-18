<x-dash.master>
    <div class="container  px-6 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">لوحة التحكم</h1>
            <span class="text-black-500 text-sm">آخر تحديث: {{ now()->format('Y-m-d') }}</span>
        </div>




        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 ml-auto">
            <div
                class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border-2 border-blue-500/50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase text-blue-600 tracking-wide">الطلبات الجديدة</h2>
                    <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ $newOrders }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-shopping-cart text-3xl text-blue-600"></i>
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border-2 border-green-500/50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase text-green-600 tracking-wide">الصيدليات المسجلة</h2>
                    <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ $pharmacies }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-clinic-medical text-3xl text-green-600"></i>
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border-2 border-cyan-500/50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase text-cyan-600 tracking-wide">الأدوية المتوفرة</h2>
                    <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ $availableMedicines }}</p>
                </div>
                <div class="bg-cyan-100 p-4 rounded-full">
                    <i class="fas fa-pills text-3xl text-cyan-600"></i>
                </div>
            </div>

            <div
                class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border-2 border-yellow-500/50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-semibold uppercase text-yellow-600 tracking-wide">إجمالي المبيعات</h2>
                    <p class="text-4xl font-extrabold text-gray-900 mt-2">{{ number_format($totalSales, 2) }}
                        شيكل</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-wallet text-3xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- جدول الطلبات الأخيرة باللغة العربية -->
        <div class="bg-white shadow-md rounded-2xl mt-10 overflow-hidden ml-10">
            <div class="px-6 py-4 border-b bg-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-700">الطلبات الأخيرة</h2>
                <a href="{{ route('company.orders.index') }}"
                    class="text-blue-600 text-sm font-semibold hover:text-blue-800 transition-colors">عرض
                    الكل</a>
            </div>
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
                        @foreach ($recentOrders as $order)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                <td class="py-3 px-6">{{ $order->orderable->name }}</td>
                                <td class="py-3 px-6">{{ $order->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-6">
                                    @switch($order->order_status)
                                        @case('pending')
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                قيد الانتظار
                                            </span>
                                        @break

                                        @case('completed')
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                مكتمل
                                            </span>
                                        @break

                                        @case('processing')
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                قيد المعالجة
                                            </span>
                                        @break

                                        @case('canceled')
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                ملغي
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ $order->order_status }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="py-3 px-6">
                                    <a href="{{ route('company.orders.show', $order->id) }}"
                                        class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                                        عرض
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-dash.master>
