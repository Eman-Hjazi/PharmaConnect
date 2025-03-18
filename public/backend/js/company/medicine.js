
// وظيفة البحث عن الأدوية
function searchMedicines() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let cards = document.getElementById("medicineCards").getElementsByClassName("col");

    for (let i = 0; i < cards.length; i++) {
        let title = cards[i].getElementsByClassName("card-title")[0].innerText.toLowerCase();
        cards[i].style.display = title.includes(input) ? "" : "none";
    }
}

// تحميل بيانات الدواء عند الضغط على زر التعديل
document.querySelectorAll('.edit-medicine').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const medicineId = this.getAttribute('data-id');

        fetch(`/company/medicines/${medicineId}/edit`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const medicine = data.medicine;
                    document.getElementById('medicine_id').value = medicine.id;
                    document.getElementById('name').value = medicine.name;
                    document.getElementById('base_price').value = medicine.base_price;
                    document.getElementById('description').value = medicine.description;
                    document.getElementById('medicine_category_id').value = medicine
                        .medicine_category_id;
                    document.getElementById('expiry_date').value = medicine.expiry_date || '';
                    document.getElementById('is_available').value = medicine.is_available ? 1 :
                        0;
                    document.getElementById('is_controlled').value = medicine.is_controlled ?
                        1 : 0;

                    new bootstrap.Modal(document.getElementById('editMedicineModal')).show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'تعذر تحميل بيانات الدواء، الرجاء المحاولة مجددًا!',
                    });
                }
            })
            .catch(error => {
                console.error('حدث خطأ:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ غير متوقع أثناء جلب البيانات!',
                });
            });
    });
});

// إرسال نموذج التعديل عبر AJAX
document.getElementById('editMedicineForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let medicineId = document.getElementById('medicine_id').value;
    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/company/medicines/${medicineId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: 'تم تحديث الدواء بنجاح!',
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'تعذر تحديث الدواء، الرجاء التأكد من البيانات والمحاولة مجددًا!',
                });
            }
        })
        .catch(error => {
            console.error('حدث خطأ:', error);
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ غير متوقع أثناء التحديث!',
            });
        });
});

// إرسال نموذج إضافة الدواء عبر AJAX
document.getElementById('createMedicineForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('/company/medicines/store', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: 'تم إضافة الدواء بنجاح!',
                }).then(() => {
                    location.reload();
                });
            } else {
                // التحقق من وجود أخطاء تحقق
                if (data.errors) {
                    let errorMessage = 'يرجى تصحيح الأخطاء التالية:\n';
                    for (let field in data.errors) {
                        errorMessage += `- ${data.errors[field].join(', ')}\n`;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ في البيانات',
                        text: errorMessage,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: data.message ||
                            'تعذر إضافة الدواء، الرجاء التأكد من البيانات والمحاولة مجددًا!',
                    });
                }
            }
        })
        .catch(error => {
            console.error('حدث خطأ:', error);
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ غير متوقع أثناء الإضافة!',
            });
        });
});

// تأكيد الحذف باستخدام SweetAlert2
function confirmDelete(event) {
    event.preventDefault();
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن تتمكن من التراجع عن هذا الإجراء!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، احذفه!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'نجاح',
                            text: 'تم حذف الدواء بنجاح!',
                        }).then(() => {
                            location.reload(); // إعادة تحميل الصفحة
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'تعذر حذف الدواء: ' + (data.message || 'خطأ غير معروف'),
                        });
                    }
                })
                .catch(error => {
                    console.error('حدث خطأ:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: 'حدث خطأ غير متوقع أثناء الحذف!',
                    });
                });
        }
    });
}

// إغلاق الـ Modal للتعديل يدويًا
document.getElementById('closeModalBtn').addEventListener('click', function() {
    const modal = document.getElementById('editMedicineModal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    if (modalInstance) {
        modalInstance.hide();
    }
});

// إغلاق الـ Modal للإضافة يدويًا
document.getElementById('closeCreateModalBtn').addEventListener('click', function() {
    const modal = document.getElementById('createMedicineModal');
    const modalInstance = bootstrap.Modal.getInstance(modal);
    if (modalInstance) {
        modalInstance.hide();
    }
});
