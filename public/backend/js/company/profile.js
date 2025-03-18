document.addEventListener('DOMContentLoaded', function () {
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
    if (imageInput) {
        imageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file && prevImg) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    prevImg.src = e.target.result;
                    prevImgModal.querySelector('img').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // عرض الصورة في المودال عند النقر عليها
    if (prevImg) {
        prevImg.addEventListener('click', function () {
            prevImgModal.querySelector('img').src = this.src;
            prevImgModal.style.display = 'flex';
        });
    }

    // إخفاء المودال عند النقر خارج الصورة
    if (prevImgModal) {
        prevImgModal.addEventListener('click', function () {
            this.style.display = 'none';
        });
    }

    // تفعيل حقول كلمة المرور الجديدة عند إدخال كلمة المرور الحالية
    if (currentPassword) {
        currentPassword.addEventListener('input', function () {
            const isDisabled = this.value.length === 0;
            newPassword.disabled = isDisabled;
            confirmPassword.disabled = isDisabled;
            if (isDisabled) {
                newPassword.value = '';
                confirmPassword.value = '';
            }
        });
    }

    // التحقق من قوة كلمة المرور
    if (newPassword) {
        newPassword.addEventListener('input', function () {
            if (this.value.length > 0) {
                strengthBar.style.display = 'block';
            } else {
                strengthBar.style.display = 'none';
            }
            checkPassword(this.value);
        });
    }

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
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const type = newPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            newPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    // التعامل مع إرسال النموذج باستخدام SweetAlert
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch(window.App.profileRoute, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': window.App.csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }

                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'نجاح!',
                        text: data.message,
                        confirmButtonText: 'تم'
                    }).then(() => {
                        setTimeout(() => window.location.reload(), 1000);
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
    }
});