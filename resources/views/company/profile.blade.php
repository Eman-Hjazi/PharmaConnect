<x-dash.master>
    @section('css')
        <style>
            .prev-img {
                width: 200px;
                height: 200px;
                object-fit: cover;
                border-radius: 50%;
                padding: 5px;
                border: 1px dashed #b8b8b8;
                cursor: pointer;
                transition: all .3s ease;
            }

            .prev-img:hover {
                opacity: .8;
            }

            .prev-img-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(6, 6, 6, 0.53);
                z-index: 99999;
                display: flex;
                justify-content: center;
                align-items: center;
                backdrop-filter: blur(8px);
                display: none;
            }

            .prev-img-modal img {
                width: 300px;
                height: 300px;
                border-radius: 50%;
                object-fit: cover;
            }

            .pass-wrapper {
                position: relative;
            }

            .pass-wrapper i {
                position: absolute;
                right: 10px;
                top: 12px;
                cursor: pointer;
            }
        </style>
    @endsection

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
                        ? asset('company/' . $company->image->path)
                        : 'https://ui-avatars.com/api/?background=random&name=' . $company->name;
                @endphp

                <div class="text-center">
                    <img title="تعديل الصورة" class="prev-img mr-3" id="prevImg" src="{{ $src }}"
                        alt="">
                    <br>
                    <label for="image"
                        class="mt-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer ml-5">تعديل
                        الصورة</label>
                    <input type="file" name="image" onchange="showImg(event)" id="image" class="hidden">
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
</x-dash.master>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevImg = document.getElementById('prevImg');
        const imageInput = document.getElementById('image');
        const prevImgModal = document.querySelector('.prev-img-modal');
        const currentPassword = document.getElementById('current');
        const newPassword = document.getElementById('password');
        const confirmPassword = document.querySelector('input[name="password_confirmation"]');
        const strengthBar = document.getElementById('meter');
        const display = document.querySelector('.textbox');
        const togglePassword = document.querySelector('.pass-wrapper i');

        // تحديث الصورة مباشرة بعد اختيارها
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    prevImg.src = e.target.result;
                    prevImgModal.querySelector('img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // عرض الصورة في المودال عند النقر عليها
        prevImg.addEventListener('click', function() {
            prevImgModal.querySelector('img').src = this.src;
            prevImgModal.style.display = 'flex';
        });

        // إخفاء المودال عند النقر خارج الصورة
        prevImgModal.addEventListener('click', function() {
            this.style.display = 'none';
        });

        // تفعيل حقول كلمة المرور الجديدة عند إدخال كلمة المرور الحالية
        currentPassword.addEventListener('input', function() {
            const isDisabled = this.value.length === 0;
            newPassword.disabled = isDisabled;
            confirmPassword.disabled = isDisabled;
            if (isDisabled) {
                newPassword.value = '';
                confirmPassword.value = '';
            }
        });

        // التحقق من قوة كلمة المرور
        newPassword.addEventListener('input', function() {
            if (this.value.length > 0) {
                strengthBar.style.display = 'block';
            } else {
                strengthBar.style.display = 'none';
            }
            checkPassword(this.value);
        });

        // وظيفة التحقق من قوة كلمة المرور
        function checkPassword(password) {
            let strength = 0;

            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[$@#&!]+/)) strength += 1;

            if (password.length < 6) {
                display.textContent = "كلمة المرور ضعيفة (يجب أن تكون 6 أحرف على الأقل)";
            } else if (password.length < 12) {
                display.textContent = "كلمة المرور متوسطة (يجب أن تكون 12 حرفًا على الأقل)";
            } else {
                display.textContent = "كلمة المرور قوية";
            }

            strengthBar.value = strength * 25;
        }

        // إظهار/إخفاء كلمة المرور
        togglePassword.addEventListener('click', function() {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // التعامل مع إرسال النموذج باستخدام SweetAlert
        document.getElementById('profileForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('{{ route('company.profile') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }

                const data = await response.json();
                console.log('Response data:', data); // لتتبع الرد

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'نجاح!',
                        text: data.message,
                        confirmButtonText: 'تم'
                    }).then(() => {
                        setTimeout(() => window.location.reload(), 1000); // تأخير 1 ثانية لظهور الرسالة
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: data.message,
                        confirmButtonText: 'حسنًا'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ غير متوقع!',
                    text: 'حدث خطأ أثناء المعالجة: ' + error.message,
                    confirmButtonText: 'حسنًا'
                });
            }
        });
    });
</script>
