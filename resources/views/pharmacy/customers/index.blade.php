<x-dash.master>
    <div class="container py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-center">قائمة العملاء</h2>

            <!-- جدول العملاء -->
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">الرقم</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">الاسم</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">البريد الإلكتروني</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 text-right">تاريخ التسجيل</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr class="border-b">
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $customer->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $customer->email }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $customer->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-sm text-gray-500 text-center">لا يوجد عملاء قاموا بإرسال طلبات إلى الصيدلية حاليًا.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- روابط التصفح -->
            <div class="mt-4">
                {{ $customers->links() }}
            </div>

            <!-- الرسائل الفلاش -->
            @if (session('success'))
                <div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center w-1/3 max-w-xs transition-opacity duration-300" id="flashMessage">
                    <span>{{ session('success') }}</span>
                    <button id="closeFlash" class="ml-4 text-white hover:text-gray-200">×</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        const flashMessage = document.getElementById('flashMessage');
        const closeFlash = document.getElementById('closeFlash');
        if (closeFlash) {
            closeFlash.addEventListener('click', () => {
                flashMessage.style.opacity = '0';
                setTimeout(() => flashMessage.remove(), 300);
            });
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                setTimeout(() => flashMessage.remove(), 3000);
            }, 3000);
        }
    </script>
</x-dash.master>
