


@section('css')
    <link href="{{ asset('backend/css/profile.css') }}" rel="stylesheet">
@endsection

<x-dash.master>


    <h1 class="text-3xl font-bold mb-6 mr-5">صفحة الملف الشخصي</h1>

    <form action="{{ route('company.profile') }}" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="profileForm">
        @csrf
        @method('put')

        <div class="prev-img-modal">
            <img src="https://via.placeholder.com/300x300" alt="">
        </div>

        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/4 px-3 mb-6">
                @php
                    $src = $company->image
                        ? asset('storage/company/' . $company->image->path)
                        : 'https://ui-avatars.com/api/?background=random&name=' . $company->name;
                @endphp

                <div class="text-center">
                    <img title="تعديل الصورة" class="prev-img mr-3" id="prevImg" src="{{ $src }}"
                        alt="">
                    <br>
                    <label for="image"
                        class="mt-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer ml-5">تعديل
                        الصورة</label>
                    <input type="file" name="image" id="image" class="hidden">
                </div>
            </div>

            <div class="w-full md:w-2/4 px-3">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('msg'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        {{ session('msg') }}
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">الاسم</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="name" value="{{ old('name', $company->name) }}">
                </div>


                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">البريد الإلكتروني</label>
                    <input type="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        disabled value="{{ $company->email }}">
                </div>

                <h4 class="text-xl font-bold mb-4">تحديث كلمة المرور</h4>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">كلمة المرور الحالية</label>
                    <input type="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="current" name="current-password">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">كلمة المرور الجديدة</label>
                    <div class="pass-wrapper">
                        <input type="password" id="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline new"
                            name="password" disabled>
                        <i class="fas fa-eye"></i>
                    </div>
                    <progress style="display: none" max="100" value="0" id="meter"></progress>
                    <span class="textbox text-sm text-gray-600"></span>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">تأكيد كلمة المرور</label>
                    <input type="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline new"
                        name="password_confirmation" disabled>
                </div>

                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-save"></i> تحديث
                </button>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            // Define global variables for use in external JS
            window.App = {
                csrfToken: '{{ csrf_token() }}',
                profileRoute: '{{ route('company.profile') }}'
            };
        </script>
        <script src="{{ asset('backend/js/company/profile.js') }}"></script>
    @endpush
</x-dash.master>
