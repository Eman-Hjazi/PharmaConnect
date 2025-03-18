
document.addEventListener('DOMContentLoaded', function () {
    const logoutLink = document.querySelector('[data-target="#logoutModal"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function (e) {
            e.preventDefault();
            const logoutRoute = this.getAttribute('data-logout-route');

            Swal.fire({
                title: 'تأكيد تسجيل الخروج',
                text: "هل أنتَ متأكد أنك تريد تسجيل الخروج؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، تسجيل الخروج',
                cancelButtonText: 'إلغاء'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch(logoutRoute, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.ok) {
                            window.location.href = '/'; // Redirect to home or login page after logout
                        } else if (response.status === 419) {
                            Swal.fire({
                                icon: 'error',
                                title: 'انتهت الجلسة',
                                text: 'الرجاء تسجيل الدخول مرة أخرى',
                                confirmButtonText: 'حسنًا'
                            }).then(() => {
                                window.location.href = '/login'; // Redirect to login page
                            });
                        } else {
                            throw new Error('فشل تسجيل الخروج');
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'حدث خطأ أثناء تسجيل الخروج: ' + error.message,
                            confirmButtonText: 'حسنًا'
                        });
                    }
                }
            });
        });
    }
});