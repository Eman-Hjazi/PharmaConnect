
        function deletePharmacy(id, url) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف الصيدلية مع جميع طلباتها وتفاصيل الطلبات!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفها!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(error => { throw new Error(error.message || 'خطأ غير معروف'); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'نجاح',
                            text: data.success,
                        });
                        document.getElementById(`pharmacyRow${id}`).remove();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: error.message || 'حدث خطأ أثناء الحذف',
                        });
                    });
                }
            });
        }
