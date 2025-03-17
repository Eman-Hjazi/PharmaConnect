<x-dash.master>
    <div class="container py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-center">إضافة عميل جديد</h2>

            <!-- النموذج -->
            <form action="{{ route('pharmacy.customers.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 text-right">اسم العميل</label>
                    <input type="text" name="name" id="name" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 text-right">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 text-right">كلمة المرور</label>
                    <input type="password" name="password" id="password" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 text-right">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-800 transition-colors">
                        إضافة العميل
                    </button>
                </div>
            </form>

            <!-- الرسائل الفلاش -->
            @if (session('success'))
                <div class="fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center w-1/3 max-w-xs transition-opacity duration-300" id="flashMessage">
                    <span>{{ session('success') }}</span>
                    <button id="closeFlash" class="ml-4 text-white hover:text-gray-200">×</button>
                </div>
            @endif
            @if ($errors->any())
                <div class="fixed top-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg flex justify-between items-center w-1/3 max-w-xs transition-opacity duration-300" id="flashMessage">
                    <span>{{ $errors->first() }}</span>
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
