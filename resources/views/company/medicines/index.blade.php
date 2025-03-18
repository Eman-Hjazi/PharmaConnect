@section('css')
    <link href="{{ asset('backend/css/pharmacy/medicine') }}" rel="stylesheet">
@endsection
<x-dash.master>
    <div class="container-fluid px-4 py-5">
        <!-- عنوان الصفحة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">قائمة الأدوية</h1>
            <a href="#" class="btn btn-primary rounded-pill px-5 py-2 shadow" data-bs-toggle="modal"
                data-bs-target="#createMedicineModal">
                <i class="fas fa-plus me-2"></i>إضافة دواء جديد
            </a>
        </div>

        <!-- فلترة الأدوية -->
        <div class="row mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control rounded-pill" placeholder="ابحث عن دواء..." id="searchInput"
                    onkeyup="searchMedicines()">
            </div>
        </div>

        <!-- بطاقات الأدوية -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4" id="medicineCards">
            @foreach ($medicines as $medicine)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 animate__animated animate__fadeIn">
                        <div class="card-img-top position-relative">
                            <img src="{{ $medicine->image ? asset('storage/' . $medicine->image->path) : asset('storage/medicines/default-medicine.jpg') }}"
                                class="card-img-top rounded-top-4 img-fluid" style="height: 200px; object-fit: cover;"
                                alt="{{ $medicine->name }}">
                            <span
                                class="badge {{ $medicine->is_available ? 'bg-success' : 'bg-danger' }} text-white position-absolute top-0 start-0 m-2 p-2 rounded">
                                {{ $medicine->is_available ? 'متوفر' : 'غير متوفر' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-gray-800">{{ $medicine->name }}</h5>
                            <p class="card-text text-muted small">{{ $medicine->description }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-primary fw-bold">{{ number_format($medicine->base_price, 2) }}
                                    شيكل</span>
                                <span class="text-muted small">الفئة:
                                    {{ $medicine->category->name ?? 'غير مصنف' }}</span>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">تاريخ الانتهاء:
                                    {{ $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d') : 'غير محدد' }}</span>
                                <span
                                    class="text-muted small">{{ $medicine->is_controlled ? 'دواء مراقب' : 'غير مراقب' }}</span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                            <a href="#" class="btn btn-outline-primary btn-sm rounded-pill edit-medicine"
                                data-id="{{ $medicine->id }}">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <form action="{{ route('company.medicines.destroy', $medicine->id) }}" method="POST"
                                onsubmit="confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $medicines->links() }}
        </div>
    </div>

    <!-- Modal للتعديل -->
    <div class="modal fade" id="editMedicineModal" tabindex="-1" aria-labelledby="editMedicineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-4" style="position: relative;">
                <!-- زر الإغلاق البسيط -->
                <button type="button" id="closeModalBtn" class="simple-close-btn" data-bs-dismiss="modal"
                    aria-label="Close" style="position: absolute; top: 10px; left: 15px; z-index: 10;">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="editMedicineModalLabel">
                        <i class="fas fa-edit text-primary me-2"></i> تعديل الدواء
                    </h5>
                </div>
                <div class="modal-body p-3">
                    <form id="editMedicineForm" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="medicine_id" id="medicine_id">

                        <!-- الحقول -->
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted">اسم الدواء <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" required>
                            <div class="invalid-feedback">يرجى إدخال اسم الدواء.</div>
                        </div>
                        <div class="mb-3">
                            <label for="base_price" class="form-label text-muted">السعر الأساسي (شيكل) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control rounded-3" id="base_price"
                                name="base_price" required>
                            <div class="invalid-feedback">يرجى إدخال السعر الأساسي.</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-muted">الوصف</label>
                            <textarea class="form-control rounded-3" id="description" name="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="medicine_category_id" class="form-label text-muted">الفئة <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="medicine_category_id"
                                name="medicine_category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">يرجى اختيار الفئة.</div>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label text-muted">تاريخ الانتهاء</label>
                            <input type="date" class="form-control rounded-3" id="expiry_date"
                                name="expiry_date">
                        </div>
                        <div class="mb-3">
                            <label for="is_available" class="form-label text-muted">التوفر <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="is_available" name="is_available" required>
                                <option value="1">متوفر</option>
                                <option value="0">غير متوفر</option>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار حالة التوفر.</div>
                        </div>
                        <div class="mb-4">
                            <label for="is_controlled" class="form-label text-muted">هل هو دواء مراقب؟ <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="is_controlled" name="is_controlled" required>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار الحالة.</div>

                            <!-- حقل التحميل للصورة -->
                            <div class="mb-3">
                                <label for="create_image" class="form-label text-muted">صورة الدواء</label>
                                <input type="file" class="form-control rounded-3" id="create_image"
                                    name="image">
                                <div class="invalid-feedback">يرجى اختيار صورة إن أمكن.</div>
                            </div>
                        </div>

                        <!-- الأزرار -->
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

    <!-- Modal لإضافة دواء جديد -->
    <div class="modal fade" id="createMedicineModal" tabindex="-1" aria-labelledby="createMedicineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-4" style="position: relative;">
                <!-- زر الإغلاق البسيط -->
                <button type="button" id="closeCreateModalBtn" class="simple-close-btn" data-bs-dismiss="modal"
                    aria-label="Close" style="position: absolute; top: 10px; left: 15px; z-index: 10;">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal-header p-2 bg-light border-bottom-0">
                    <h5 class="modal-title m-0" id="createMedicineModalLabel">
                        <i class="fas fa-plus text-primary me-2"></i> إضافة دواء جديد
                    </h5>
                </div>
                <div class="modal-body p-3">
                    <form id="createMedicineForm" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="_method" value="POST">

                        <!-- الحقول -->
                        <div class="mb-3">
                            <label for="create_name" class="form-label text-muted">اسم الدواء <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="create_name" name="name"
                                required>
                            <div class="invalid-feedback">يرجى إدخال اسم الدواء.</div>
                        </div>
                        <div class="mb-3">
                            <label for="create_base_price" class="form-label text-muted">السعر الأساسي (شيكل) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control rounded-3"
                                id="create_base_price" name="base_price" required>
                            <div class="invalid-feedback">يرجى إدخال السعر الأساسي.</div>
                        </div>
                        <div class="mb-3">
                            <label for="create_description" class="form-label text-muted">الوصف</label>
                            <textarea class="form-control rounded-3" id="create_description" name="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_medicine_category_id" class="form-label text-muted">الفئة <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="create_medicine_category_id"
                                name="medicine_category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">يرجى اختيار الفئة.</div>
                        </div>
                        <div class="mb-3">
                            <label for="create_expiry_date" class="form-label text-muted">تاريخ الانتهاء</label>
                            <input type="date" class="form-control rounded-3" id="create_expiry_date"
                                name="expiry_date">
                        </div>
                        <div class="mb-3">
                            <label for="create_is_available" class="form-label text-muted">التوفر <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="create_is_available" name="is_available"
                                required>
                                <option value="1">متوفر</option>
                                <option value="0">غير متوفر</option>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار حالة التوفر.</div>
                        </div>
                        <div class="mb-4">
                            <label for="create_is_controlled" class="form-label text-muted">هل هو دواء مراقب؟ <span
                                    class="text-danger">*</span></label>
                            <select class="form-select rounded-3" id="create_is_controlled" name="is_controlled"
                                required>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                            <div class="invalid-feedback">يرجى اختيار الحالة.</div>


                            <!-- حقل التحميل للصورة -->
                            <div class="mb-3">
                                <label for="create_image" class="form-label text-muted">صورة الدواء</label>
                                <input type="file" class="form-control rounded-3" id="create_image"
                                    name="image">
                                <div class="invalid-feedback">يرجى اختيار صورة إن أمكن.</div>
                            </div>
                        </div>

                        <!-- الأزرار -->
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




    <!-- إضافة Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    @push('scripts')
        <script src="{{ asset('backend/js/company/medicine.js') }}"></script>
    @endpush
</x-dash.master>
