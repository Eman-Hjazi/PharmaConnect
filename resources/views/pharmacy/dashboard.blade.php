 <x-dash.master>
     <div class="container p-4">
         <!-- الإحصائيات السريعة -->
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
             <div
                 class="bg-gradient-to-r from-blue-300 to-blue-400 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-sm text-white">إجمالي الطلبات</p>
                         <p class="text-2xl font-bold text-white">{{ $totalOrders }}</p>
                     </div>
                     <div class="bg-white bg-opacity-20 p-3 rounded-full">
                         <i class="fas fa-shopping-cart text-xl"></i>
                     </div>
                 </div>
                 <div class="mt-4">
                     <p class="text-xs text-white opacity-80">زيادة بنسبة
                         {{ number_format($ordersPercentageIncrease, 2) }}% عن الشهر الماضي</p>
                 </div>
             </div>

             <div
                 class="bg-gradient-to-r from-yellow-300 to-yellow-400 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-sm text-white">الطلبات قيد الانتظار</p>
                         <p class="text-2xl font-bold text-white">{{ $pendingOrders }}</p>
                     </div>
                     <div class="bg-white bg-opacity-20 p-3 rounded-full">
                         <i class="fas fa-clock text-xl"></i>
                     </div>
                 </div>
                 <div class="mt-4">
                     <p class="text-xs text-white opacity-80">طلبات جديدة اليوم: {{ $todayOrders }}</p>
                 </div>
             </div>

             <div
                 class="bg-gradient-to-r from-red-300 to-red-400 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-sm text-white">الأدوية منخفضة المخزون</p>
                         <p class="text-2xl font-bold text-white">{{ $lowStockCount }}</p>
                     </div>
                     <div class="bg-white bg-opacity-20 p-3 rounded-full">
                         <i class="fas fa-exclamation-triangle text-xl"></i>
                     </div>
                 </div>
                 <div class="mt-4">
                     <p class="text-xs text-white opacity-80">تحتاج إلى إعادة طلب</p>
                 </div>
             </div>

             <div
                 class="bg-gradient-to-r from-green-300 to-green-400 p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                 <div class="flex items-center justify-between">
                     <div>
                         <p class="text-sm text-white">إجمالي الإيرادات</p>
                         <p class="text-2xl font-bold text-white">${{ number_format($totalRevenue, 2) }}</p>
                     </div>
                     <div class="bg-white bg-opacity-20 p-3 rounded-full">
                         <i class="fas fa-dollar-sign text-xl"></i>
                     </div>
                 </div>
                 <div class="mt-4">
                     <p class="text-xs text-white opacity-80">زيادة بنسبة
                         {{ number_format($revenuePercentageIncrease, 2) }}% عن الشهر الماضي</p>
                 </div>
             </div>
         </div>

         <!-- الطلبات الأخيرة -->
         <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
             <div class="flex justify-between items-center mb-4">
                 <h2 class="text-xl font-bold text-gray-800">الطلبات الأخيرة</h2>
                 <a href="{{ route('pharmacy.orders.customer') }}" class="text-blue-500 hover:text-blue-700">عرض الكل</a>
             </div>
             <div class="overflow-x-auto">
                 <table class="min-h-[400px] w-full bg-white">
                     <thead class="bg-gray-50">
                         <tr>
                             <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">رقم الطلب
                             </th>
                             <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">اسم العميل
                             </th>
                             <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">التاريخ</th>
                             <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">الحالة</th>
                             <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">الإجراءات
                             </th>
                         </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-200">
                         @forelse ($recentOrders as $order)
                             <tr class="hover:bg-gray-50 transition duration-200">
                                 <td class="px-6 py-4 text-center text-sm text-gray-800">#{{ $order->id }}</td>
                                 <td class="px-6 py-4 text-center text-sm text-gray-800">
                                     {{ $order->orderable ? ($order->orderable_type === 'App\Models\User' ? $order->orderable->name : 'غير معروف') : 'غير معروف' }}
                                 </td>
                                 <td class="px-6 py-4 text-center text-sm text-gray-800">
                                     {{ $order->created_at->format('Y-m-d') }}</td>
                                 <td class="px-6 py-4 text-center">
                                     @if ($order->order_status == 'pending')
                                         <span class="px-2 py-1 text-sm bg-yellow-100 text-yellow-800 rounded-full">قيد
                                             الانتظار</span>
                                     @elseif ($order->order_status == 'completed')
                                         <span
                                             class="px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">مكتمل</span>
                                     @elseif ($order->order_status == 'processing')
                                         <span class="px-2 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">قيد
                                             المعالجة</span>
                                     @elseif ($order->order_status == 'canceled')
                                         <span
                                             class="px-2 py-1 text-sm bg-red-100 text-red-800 rounded-full">ملغي</span>
                                     @else
                                         <span
                                             class="px-2 py-1 text-sm bg-gray-100 text-gray-800 rounded-full">{{ $order->order_status }}</span>
                                     @endif
                                 </td>

                                 <td class="px-6 py-4 text-center space-x-2">
                                     <button class="open-order-details-modal text-blue-500 hover:text-blue-700"
                                         data-order-id="{{ $order->id }}" data-order-number="#{{ $order->id }}"
                                         data-customer-name="{{ $order->orderable ? ($order->orderable_type === 'App\Models\User' ? $order->orderable->name : 'غير معروف') : 'غير معروف' }}"
                                         data-order-date="{{ $order->created_at->format('Y-m-d') }}"
                                         data-order-status="{{ $order->order_status }}">
                                         عرض
                                     </button>

                                 </td>
                             </tr>
                         @empty
                             <tr>
                                 <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-800">لا توجد طلبات
                                     أخيرة.</td>
                             </tr>
                         @endforelse
                     </tbody>
                 </table>
             </div>
         </div>

         <!-- تنبيهات المخزون -->
         <div class="bg-white rounded-lg shadow-lg p-6">
             <div class="flex justify-between items-center mb-4">
                 <h2 class="text-xl font-bold text-gray-800">تنبيهات المخزون</h2>
                 <a href="{{route('pharmacy.inventory.show',['pharmacyId' => auth('pharmacy')->user()->id])}}" class="text-blue-500 hover:text-blue-700">عرض
                     الكل</a>
             </div>
             <div class="space-y-4">
                 @forelse ($lowStockMedicines as $medicine)
                     <div class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition duration-200">
                         <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                         <p class="text-sm text-gray-800">دواء "{{ $medicine->medicine->name }}" منخفض المخزون
                             ({{ $medicine->quantity_in_stock }} وحدات متبقية)
                             .</p>

                         <button class="open-order-modal text-blue-500 hover:text-blue-700 ml-auto"
                             data-medicine-id="{{ $medicine->medicine_id }}"
                             data-medicine-name="{{ $medicine->medicine->name }}"
                             data-medicine-price="{{ $medicine->selling_price }}"
                             data-medicine-company="{{ $medicine->medicine->company->name ?? 'غير معروف' }}">
                             إعادة الطلب
                         </button>

                     </div>
                 @empty
                     <p class="text-sm text-gray-800">لا يوجد أدوية منخفضة المخزون.</p>
                 @endforelse
             </div>
         </div>



     </div>

     {{-- اعادة الطلب  --}}
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
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="medicine_name" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">الشركة:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="medicine_company" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">السعر للوحدة:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="medicine_price" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">الكمية:</label>
                         <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right"
                             name="quantity" id="quantity" min="1" placeholder="أدخل الكمية" required>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">السعر الإجمالي:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="totalPrice" disabled>
                     </div>
                 </div>
                 <button type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-800">تأكيد
                     الطلب</button>
             </form>
         </div>
     </div>

     {{-- تفاصيل الطلب --}}
     <div id="order-details-modal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
         <div class="bg-white p-8 rounded-lg shadow-xl w-11/12 md:w-1/2 text-right relative">
             <button id="close-order-details-modal"
                 class="absolute top-4 left-4 text-gray-600 hover:text-red-500 text-2xl">×</button>
             <h1 class="text-3xl font-bold text-blue-800 mb-6">تفاصيل الطلب</h1>
             <form id="update-order-status-form">
                 @csrf
                 <input type="hidden" id="order-id" name="order_id">
                 <div class="mb-6 space-y-4">
                     <div>
                         <label class="text-gray-700 font-medium">رقم الطلب:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="order-number" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">اسم العميل:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="customer-name" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">تاريخ الطلب:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="order-date" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">الحالة الحالية:</label>
                         <input type="text"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right bg-gray-100"
                             id="order-status" disabled>
                     </div>
                     <div>
                         <label class="text-gray-700 font-medium">تحديث الحالة:</label>
                         <select name="status" id="new-status"
                             class="w-full px-4 py-2 border border-gray-300 rounded-lg text-right">
                             <option value="pending">قيد الانتظار</option>
                             <option value="processing">قيد المعالجة</option>
                             <option value="completed">مكتمل</option>
                             <option value="canceled">ملغي</option>
                         </select>
                     </div>
                 </div>
                 <button type="submit" class="bg-blue-600 text-white py-3 px-8 rounded-lg hover:bg-blue-800">تحديث
                     الحالة</button>
             </form>
         </div>
     </div>

   @push('scripts')
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <script src="{{ asset('backend/js/pharmacy/dash.js') }}"></script>

   @endpush


 </x-dash.master>


