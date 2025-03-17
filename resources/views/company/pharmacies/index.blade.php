<x-dash.master>
    <!-- إضافة خطوط حديثة (اختياري) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="mt-10 mx-4 md:mx-10">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- العنوان -->
            <div class="p-4 bg-gradient-to-r from-blue-900 to-blue-800 text-white">
                <h2 class="text-3xl font-bold tracking-tight">إدارة الصيدليات</h2>
                <p class="text-sm text-blue-200 mt-1">قائمة الصيدليات التي طلبت أدوية من الشركة</p>
            </div>

            <!-- الجدول -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-gray-700 font-medium">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">#</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">الصورة</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">الاسم</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">البريد الإلكتروني</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">العنوان</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">عدد الطلبات</th>
                            <th class="py-4 px-6 text-right font-semibold text-gray-600">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="pharmaciesTable">
                        @forelse ($pharmacies as $pharmacy)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200" id="pharmacyRow{{ $pharmacy->id }}">
                                <td class="py-4 px-6 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6">
                                    @if ($pharmacy->image)
                                        <img src="{{ asset('storage/' . $pharmacy->image->path) }}" alt="صورة الصيدلية" class="w-24 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                    @else
                                        <span class="text-gray-500">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-900 font-medium">{{ $pharmacy->name }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->email }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->address }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->sent_orders_count }}</td>
                                <td class="py-4 px-6">
                                    <button onclick="deletePharmacy({{ $pharmacy->id }}, '{{ route('company.pharmacies.destroy', $pharmacy->id) }}')" class="px-4 py-2 text-base font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">لا توجد صيدليات طلبت من الشركة حاليًا</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- مكتبة SweetAlert2 للتنبيهات -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
    </script>

    <!-- إضافة أنماط مخصصة -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* تحسين مظهر الجدول */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th, td {
            transition: all 0.2s ease;
        }

        /* زر الحذف */
        button.bg-red-500 {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* تحسين الصورة */
        img.rounded-lg {
            transition: transform 0.2s ease;
        }

        img.rounded-lg:hover {
            transform: scale(1.05);
        }

        /* تحسين التصميم المتجاوب */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                font-size: 0.875rem;
                padding: 0.75rem 1rem;
            }

            img {
                width: 5rem;
                height: 3.5rem;
            }

            button.bg-red-500 {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>
</x-dash.master>
