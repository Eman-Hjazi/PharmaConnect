
// document.getElementById('orderStatus').addEventListener('change', function() {
//     const orderId = this.getAttribute('data-order-id');
//     const newStatus = this.value;
//     const selectElement = this;

//     fetch(`/company/orders/${orderId}/update-status`, {
//             method: 'PATCH',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
//                     'content'),
//                 'Accept': 'application/json'
//             },
//             body: JSON.stringify({
//                 status: newStatus
//             })
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 // تحديث الـ <select> ليعكس التغيير مباشرة دون إعادة تحميل الصفحة
//                 selectElement.value = newStatus;

//                 // تعطيل القائمة إذا كانت الحالة "مكتمل" أو "ملغي"
//                 if (newStatus === 'completed' || newStatus === 'canceled') {
//                     selectElement.setAttribute('disabled', true);
//                 }

//                 Swal.fire({
//                     icon: 'success',
//                     title: 'تم التحديث!',
//                     text: 'تم تغيير حالة الطلب بنجاح.',
//                     confirmButtonText: 'موافق'
//                 });
//             } else {
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'خطأ!',
//                     text: data.message,
//                     confirmButtonText: 'حسناً'
//                 });
//             }
//         })
//         .catch(error => {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'خطأ!',
//                 text: 'لا يمكن الاتصال بالخادم.',
//                 confirmButtonText: 'حسناً'
//             });
//         });
// });


document.getElementById('orderStatus').addEventListener('change', function () {
    const orderId = this.getAttribute('data-order-id');
    const newStatus = this.value;
    const selectElement = this;

    const url = `/company/orders/${orderId}/update-status`;
    console.log('Sending PATCH request to:', url);
    console.log('New status:', newStatus);

    fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json', // إضافة Content-Type
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' // للإشارة إلى أن الطلب AJAX
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(`HTTP error! Status: ${response.status}, Message: ${err.message || 'Unknown error'}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // تحديث الـ <select> ليعكس التغيير مباشرة دون إعادة تحميل الصفحة
                selectElement.value = newStatus;

                // تعطيل القائمة إذا كانت الحالة "مكتمل" أو "ملغي"
                if (newStatus === 'completed' || newStatus === 'canceled') {
                    selectElement.setAttribute('disabled', true);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'تم التحديث!',
                    text: 'تم تغيير حالة الطلب بنجاح.',
                    confirmButtonText: 'موافق'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: data.message || 'فشل تحديث الحالة.',
                    confirmButtonText: 'حسناً'
                });
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: 'لا يمكن الاتصال بالخادم.',
                confirmButtonText: 'حسناً'
            });
        });

    })