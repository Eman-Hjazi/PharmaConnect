// تحميل التصنيفات عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded, starting to load categories...');
    loadCategories();
});

// دالة لتحميل التصنيفات عبر AJAX
function loadCategories() {
    const url = window.appConfig.categoriesIndexUrl + '?ajax=true';
    console.log('Fetching categories from URL:', url);

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Received data:', data);
        let tableBody = '';
        if (data && data.categories && Array.isArray(data.categories)) {
            data.categories.forEach(category => {
                console.log('Processing category:', category);
                tableBody += `
                    <tr>
                        <td>${category.name}</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm rounded-pill edit-category" data-id="${category.id}" data-name="${category.name}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill delete-category" data-id="${category.id}">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr>
                `;
            });
            document.querySelector('#categoriesTable tbody').innerHTML = tableBody;
            console.log('Table updated successfully');
        } else {
            console.error('No valid categories found in response:', data);
        }
    })
    .catch(error => {
        console.error('Error loading categories:', error);
    });
}

// إرسال نموذج الإضافة عبر AJAX
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Add category form submitted');
    let formData = new FormData(this);
    const url = window.appConfig.categoriesBaseUrl + '/store';
    console.log('Sending POST request to:', url);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('Add response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Add response data:', data);
        if (data.success) {
            Swal.fire('نجاح', 'تم إضافة التصنيف بنجاح!', 'success').then(() => {
                document.getElementById('addCategoryModal').querySelector('.btn-close').click();
                loadCategories();
            });
        } else {
            Swal.fire('خطأ', 'تعذر إضافة التصنيف!', 'error');
        }
    })
    .catch(error => {
        console.error('Error adding category:', error);
    });
});

// فتح نموذج التعديل وتعبئة البيانات
document.addEventListener('click', function(e) {
    if (e.target.closest('.edit-category')) {
        const button = e.target.closest('.edit-category');
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        console.log('Opening edit modal for category ID:', id, 'with name:', name);
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
    }
});

// إرسال نموذج التعديل عبر AJAX
document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Edit category form submitted');
    let id = document.getElementById('edit_id').value;
    let formData = new FormData(this);
    formData.append('_method', 'PUT');
    const url = `${window.appConfig.categoriesBaseUrl}/${id}`;
    console.log('Sending PUT request to:', url);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('Edit response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Edit response data:', data);
        if (data.success) {
            Swal.fire('نجاح', 'تم تحديث التصنيف بنجاح!', 'success').then(() => {
                document.getElementById('editCategoryModal').querySelector('.btn-close').click();
                loadCategories();
            });
        } else {
            Swal.fire('خطأ', 'تعذر تحديث التصنيف!', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating category:', error);
    });
});

// حذف تصنيف عبر AJAX
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-category')) {
        const button = e.target.closest('.delete-category');
        const id = button.getAttribute('data-id');
        console.log('Delete button clicked for category ID:', id);
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'لن تتمكن من التراجع عن هذا الإجراء!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `${window.appConfig.categoriesBaseUrl}/${id}`;
                console.log('Sending DELETE request to:', url);
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Delete response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response data:', data);
                    if (data.success) {
                        Swal.fire('نجاح', 'تم حذف التصنيف بنجاح!', 'success').then(() => loadCategories());
                    } else {
                        Swal.fire('خطأ', 'تعذر حذف التصنيف!', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting category:', error);
                });
            }
        });
    }
});