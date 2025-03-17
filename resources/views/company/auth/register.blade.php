<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-100 to-purple-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-2xl text-right">
            <!-- العنوان -->
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    إنشاء حساب جديد
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    هل لديك حساب بالفعل؟
                    <a href="{{ route('company.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        سجل الدخول هنا
                    </a>
                </p>
            </div>

            <!-- النموذج -->
            <form method="POST" action="{{ route('company.register') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf

                <!-- الاسم -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
                    <input id="name" name="name" type="text" required  dir="rtl"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           value="{{ old('name') }}">
                    @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" required  dir="rtl"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           value="{{ old('email') }}">
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                    <input id="password" name="password" type="password" required  dir="rtl"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required  dir="rtl"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- تحميل الصورة -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">شعار الشركة </label>
                    <input id="image" name="image" type="file"  dir="rtl"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- زر التسجيل -->
                <div>
                    <x-primary-button class="ms-3 w-full flex justify-center py-2 px-4 rounded-md shadow-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-transform hover:scale-105">
                       تسجيل الدخول
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
