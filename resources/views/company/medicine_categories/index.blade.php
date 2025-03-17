{{-- <x-dash.master>
    <div class="container-fluid px-4 py-5">
        <!-- عنوان الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">قائمة التصنيفات</h1>
            <button class="btn btn-primary rounded-pill px-5 py-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus me-2"></i>إضافة تصنيف جديد
            </button>
        </div>

        <!-- جدول التصنيفات -->
        <div class="row">
            <div class="col">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="categoriesTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- سيتم ملء الجدول عبر AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لإضافة تصنيف -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm rounded-4">
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="addCategoryModalLabel">
                        <i class="fas fa-plus text-primary me-2"></i> إضافة تصنيف جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="addCategoryForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" required>
                            <div class="invalid-feedback">يرجى إدخال اسم التصنيف.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="fas fa-save me-1"></i> إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لتعديل تصنيف -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm rounded-4">
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="editCategoryModalLabel">
                        <i class="fas fa-edit text-primary me-2"></i> تعديل التصنيف
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label text-muted">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                            <div class="invalid-feedback">يرجى إدخال اسم التصنيف.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="fas fa-save me-1"></i> حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة المكتبات الخارجية -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- السكربت للتعامل مع AJAX -->
    <script>
        // تحميل التصنيفات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            loadCategories();
        });

        // دالة لتحميل التصنيفات عبر AJAX
        function loadCategories() {
            fetch('{{ route("company.categories.index") }}?ajax=true', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = '';
                data.categories.forEach(category => {
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
            })
            .catch(error => console.error('Error loading categories:', error));
        }

        // إرسال نموذج الإضافة عبر AJAX
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch('{{ route("company.categories.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('نجاح', 'تم إضافة التصنيف بنجاح!', 'success').then(() => {
                        document.getElementById('addCategoryModal').querySelector('.btn-close').click();
                        loadCategories();
                    });
                } else {
                    Swal.fire('خطأ', 'تعذر إضافة التصنيف!', 'error');
                }
            })
            .catch(error => console.error('Error adding category:', error));
        });

        // فتح نموذج التعديل وتعبئة البيانات
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-category')) {
                const button = e.target.closest('.edit-category');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
            }
        });

        // إرسال نموذج التعديل عبر AJAX
        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('edit_id').value;
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            fetch(`{{ url('company/categories') }}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('نجاح', 'تم تحديث التصنيف بنجاح!', 'success').then(() => {
                        document.getElementById('editCategoryModal').querySelector('.btn-close').click();
                        loadCategories();
                    });
                } else {
                    Swal.fire('خطأ', 'تعذر تحديث التصنيف!', 'error');
                }
            })
            .catch(error => console.error('Error updating category:', error));
        });

        // حذف تصنيف عبر AJAX
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-category')) {
                const button = e.target.closest('.delete-category');
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: 'لن تتمكن من التراجع عن هذا الإجراء!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، احذفه!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('company/categories') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('نجاح', 'تم حذف التصنيف بنجاح!', 'success').then(() => loadCategories());
                            } else {
                                Swal.fire('خطأ', 'تعذر حذف التصنيف!', 'error');
                            }
                        })
                        .catch(error => console.error('Error deleting category:', error));
                    }
                });
            }
        });
    </script>
</x-dash.master> --}}
<x-dash.master>


    <div class="container-fluid px-4 py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">قائمة التصنيفات</h1>
            <button class="btn btn-primary rounded-pill px-5 py-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus me-2"></i>إضافة تصنيف جديد
            </button>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow-lg border-0 rounded-4 bg-light">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center" id="categoriesTable">
                                <thead class="table-light border-bottom border-secondary">
                                    <tr class="fw-bold text-muted">
                                        <th>الاسم</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- سيتم ملء الجدول عبر AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








    <!-- Modal لإضافة تصنيف -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm rounded-4">
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="addCategoryModalLabel">
                        <i class="fas fa-plus text-primary me-2"></i> إضافة تصنيف جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="addCategoryForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" required>
                            <div class="invalid-feedback">يرجى إدخال اسم التصنيف.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="fas fa-save me-1"></i> إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal لتعديل تصنيف -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm rounded-4">
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="editCategoryModalLabel">
                        <i class="fas fa-edit text-primary me-2"></i> تعديل التصنيف
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label text-muted">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                            <div class="invalid-feedback">يرجى إدخال اسم التصنيف.</div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-3">
                                <i class="fas fa-save me-1"></i> حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة المكتبات الخارجية -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- السكربت للتعامل مع AJAX -->
    <script>
        // تحميل التصنيفات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            loadCategories();
        });

        // دالة لتحميل التصنيفات عبر AJAX
        function loadCategories() {
            fetch('{{ route("company.categories.index") }}?ajax=true', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                let tableBody = '';
                data.categories.forEach(category => {
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
            })
            .catch(error => console.error('Error loading categories:', error));
        }

        // إرسال نموذج الإضافة عبر AJAX
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch('{{ route("company.categories.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('نجاح', 'تم إضافة التصنيف بنجاح!', 'success').then(() => {
                        document.getElementById('addCategoryModal').querySelector('.btn-close').click();
                        loadCategories();
                    });
                } else {
                    Swal.fire('خطأ', 'تعذر إضافة التصنيف!', 'error');
                }
            })
            .catch(error => console.error('Error adding category:', error));
        });

        // فتح نموذج التعديل وتعبئة البيانات
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-category')) {
                const button = e.target.closest('.edit-category');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
            }
        });

        // إرسال نموذج التعديل عبر AJAX
        document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let id = document.getElementById('edit_id').value;
            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            fetch(`{{ url('company/categories') }}/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('نجاح', 'تم تحديث التصنيف بنجاح!', 'success').then(() => {
                        document.getElementById('editCategoryModal').querySelector('.btn-close').click();
                        loadCategories();
                    });
                } else {
                    Swal.fire('خطأ', 'تعذر تحديث التصنيف!', 'error');
                }
            })
            .catch(error => console.error('Error updating category:', error));
        });

        // حذف تصنيف عبر AJAX
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-category')) {
                const button = e.target.closest('.delete-category');
                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: 'لن تتمكن من التراجع عن هذا الإجراء!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، احذفه!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ url('company/categories') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('نجاح', 'تم حذف التصنيف بنجاح!', 'success').then(() => loadCategories());
                            } else {
                                Swal.fire('خطأ', 'تعذر حذف التصنيف!', 'error');
                            }
                        })
                        .catch(error => console.error('Error deleting category:', error));
                    }
                });
            }
        });
    </script>
</x-dash.master>



