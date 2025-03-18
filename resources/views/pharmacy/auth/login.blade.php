<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('pharmacy.login') }}" class="text-right">
        @csrf

        <div class="mb-4">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" class="block" />
            <x-text-input id="email" class="block w-full mt-1 text-left" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('كلمة المرور')" class="block" />
            <x-text-input id="password" class="block w-full mt-1 text-left" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mb-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('تذكرني') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

