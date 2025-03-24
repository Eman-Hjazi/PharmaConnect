{{-- <x-dash.master>

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

</x-dash.master> --}}


{{-- <x-dash.master>
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
                        <th class="px-4 py-2 text-right">صورة الروشتة</th>
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
                            <!-- حقل صورة الروشتة -->
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                @if($order->image)
                                    <img src="{{ asset('storage/' . $order->image->path) }}" alt="روشتة" class="w-20 h-20 object-cover rounded cursor-pointer prescription-image" data-src="{{ asset('storage/' . $order->image->path) }}">
                                @else
                                    <span class="text-gray-500">لا توجد روشتة</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                {{ number_format($order->total, 2) }} شيكل
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-500">لا توجد طلبات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 text-right">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Modal لعرض الصورة -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
        <div class="relative bg-white p-6 rounded-lg max-w-[90vw] max-h-[90vh] w-auto h-auto flex items-center justify-center">
            <!-- زر الإغلاق -->
            <button onclick="closeModal()" class="absolute top-[-40px] right-0 text-white bg-red-600 rounded-full w-10 h-10 flex items-center justify-center hover:bg-red-700 z-[10001]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- الصورة -->
            <img id="modalImage" src="" alt="روشتة" class="max-w-full max-h-[80vh] object-contain rounded">
        </div>
    </div>

    @push('styles')
        <style>
            /* تحسين الـ Modal */
            #imageModal {
                z-index: 9999; /* التأكد إن الـ modal فوق كل العناصر */
            }
            /* تحسين حاوية الصورة */
            #imageModal .relative {
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden; /* التأكد إن الصورة ما تطلعش برا الحاوية */
            }
            /* تحسين زر الإغلاق */
            #imageModal button {
                z-index: 10001; /* التأكد إن الزر فوق الصورة */
            }
            /* تحسين الصورة داخل الـ Modal */
            #modalImage {
                max-height: 80vh; /* التأكد إن الصورة مش هتتعدى 80% من ارتفاع الشاشة */
                max-width: 90vw; /* التأكد إن الصورة مش هتتعدى 90% من عرض الشاشة */
                object-fit: contain; /* الحفاظ على نسبة العرض إلى الارتفاع */
                object-position: center; /* التأكد إن الصورة متمركزة */
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // جلب كل الصور اللي عندها class بتاع prescription-image
                const images = document.querySelectorAll('.prescription-image');
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');

                // التأكد إن العناصر موجودة
                if (!modal || !modalImage) {
                    console.error('Modal or modal image element not found');
                    return;
                }

                console.log('Found', images.length, 'images with class prescription-image'); // Debugging

                // إضافة event listener لكل صورة
                images.forEach(image => {
                    image.addEventListener('click', function () {
                        const imageSrc = this.getAttribute('data-src');
                        console.log('Opening modal with image:', imageSrc); // Debugging
                        modalImage.src = imageSrc;
                        console.log('Modal display before:', modal.style.display); // Debugging
                        modal.style.display = 'flex'; // تغيير الـ display مباشرة
                        console.log('Modal display after:', modal.style.display); // Debugging
                    });
                });

                // إغلاق الـ Modal لما المستخدم يضغط خارج الصورة
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        console.log('Closing modal'); // Debugging
                        modal.style.display = 'none'; // إخفاء الـ Modal
                    }
                });
            });

            function closeModal() {
                console.log('Closing modal'); // Debugging
                const modal = document.getElementById('imageModal');
                if (modal) {
                    modal.style.display = 'none'; // إخفاء الـ Modal
                    console.log('Modal display after closing:', modal.style.display); // Debugging
                } else {
                    console.error('Modal element not found');
                }
            }
        </script>
        <script src="{{ asset('backend/js/pharmacy/order.js') }}"></script>
    @endpush
</x-dash.master> --}}


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
                        <th class="px-4 py-2 text-right">صورة الروشتة</th>
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
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                        قيد التنفيذ</option>
                                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>
                                        مكتمل</option>
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
                            <!-- حقل صورة الروشتة -->
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                @if($order->image)
                                    <img src="{{ asset('storage/' . $order->image->path) }}" alt="روشتة" class="w-20 h-20 object-cover rounded cursor-pointer prescription-image" data-src="{{ asset('storage/' . $order->image->path) }}">
                                @else
                                    <span class="text-gray-500">لا توجد روشتة</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 text-right">
                                {{ number_format($order->total, 2) }} شيكل
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-gray-500">لا توجد طلبات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4 text-right">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Modal لعرض الصورة -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
        <div class="relative bg-white p-6 rounded-lg max-w-[90vw] max-h-[90vh] w-auto h-auto flex items-center justify-center">
            <!-- زر الإغلاق -->
            <button onclick="closeModal()" class="absolute top-2 right-2 text-white bg-red-600 rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-700 z-[10001]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- الصورة -->
            <img id="modalImage" src="" alt="روشتة" class="max-w-full max-h-[80vh] object-contain rounded">
        </div>
    </div>

    @push('styles')
        <style>
            /* تحسين الـ Modal */
            #imageModal {
                z-index: 9999; /* التأكد إن الـ modal فوق كل العناصر */
            }
            /* تحسين حاوية الصورة */
            #imageModal .relative {
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden; /* التأكد إن الصورة ما تطلعش برا الحاوية */
            }
            /* تحسين زر الإغلاق */
            #imageModal button {
                z-index: 10001; /* التأكد إن الزر فوق الصورة */
            }
            /* تحسين الصورة داخل الـ Modal */
            #modalImage {
                max-height: 80vh; /* التأكد إن الصورة مش هتتعدى 80% من ارتفاع الشاشة */
                max-width: 90vw; /* التأكد إن الصورة مش هتتعدى 90% من عرض الشاشة */
                object-fit: contain; /* الحفاظ على نسبة العرض إلى الارتفاع */
                object-position: center; /* التأكد إن الصورة متمركزة */
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // جلب كل الصور اللي عندها class بتاع prescription-image
                const images = document.querySelectorAll('.prescription-image');
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');

                // التأكد إن العناصر موجودة
                if (!modal || !modalImage) {
                    console.error('Modal or modal image element not found');
                    return;
                }

                console.log('Found', images.length, 'images with class prescription-image'); // Debugging

                // إضافة event listener لكل صورة
                images.forEach(image => {
                    image.addEventListener('click', function () {
                        const imageSrc = this.getAttribute('data-src');
                        console.log('Opening modal with image:', imageSrc); // Debugging
                        modalImage.src = imageSrc;
                        console.log('Modal display before:', modal.style.display); // Debugging
                        modal.style.display = 'flex'; // تغيير الـ display مباشرة
                        console.log('Modal display after:', modal.style.display); // Debugging
                    });
                });

                // إغلاق الـ Modal لما المستخدم يضغط خارج الصورة
                modal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        console.log('Closing modal'); // Debugging
                        modal.style.display = 'none'; // إخفاء الـ Modal
                    }
                });
            });

            function closeModal() {
                console.log('Closing modal'); // Debugging
                const modal = document.getElementById('imageModal');
                if (modal) {
                    modal.style.display = 'none'; // إخفاء الـ Modal
                    console.log('Modal display after closing:', modal.style.display); // Debugging
                } else {
                    console.error('Modal element not found');
                }
            }
        </script>
        <script src="{{ asset('backend/js/pharmacy/order.js') }}"></script>
    @endpush
</x-dash.master>
