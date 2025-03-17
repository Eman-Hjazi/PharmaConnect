<x-dash.master>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="container bg-white p-6 rounded-lg shadow-lg w-11/12 lg:w-3/4 text-right">

            <!-- عنوان تتبع الطلبات -->
            <h1 class="text-3xl font-bold text-blue-800 mb-4 text-center">تتبع الطلبات</h1>

            <!-- مربع البحث والتصفية -->
            <div class="mb-4 bg-white p-3 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 md:space-x-4">
                <input type="text" class="px-3 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-right" placeholder="ابحث عن طلب..." id="search">
                <select class="ml-4 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400 text-right bg-green-600 text-white">
                    <option value="">تصفية حسب الحالة</option>
                    <option value="pending">قيد التنفيذ</option>
                    <option value="processing">قيد الشحن</option>
                    <option value="completed">مكتمل</option>
                    <option value="canceled">ملغي</option>
                </select>
            </div>

            <!-- جدول الطلبات -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-gray-700 uppercase text-sm">
                            <th class="px-4 py-2">الدواء</th>
                            <th class="px-4 py-2">الكمية</th>
                            <th class="px-4 py-2">الشركة</th>
                            <th class="px-4 py-2">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-4 py-2 font-semibold text-gray-800">{{ $order->medicine->name }}</td>
                            <td class="px-4 py-2">{{ $order->quantity }}</td>
                            <td class="px-4 py-2">{{ $order->company->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-2">
                                @if($order->order_status == 'pending')
                                    <span class="text-yellow-500">قيد التنفيذ</span>
                                @elseif($order->order_status == 'processing')
                                    <span class="text-blue-500">قيد الشحن</span>
                                @elseif($order->order_status == 'completed')
                                    <span class="text-green-500">مكتمل</span>
                                @elseif($order->order_status == 'canceled')
                                    <span class="text-red-500">ملغي</span>
                                @else
                                    <span class="text-gray-500">غير معروف</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">لم يتم العثور على طلبات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dash.master>
