@section('css')
    <link href="{{ asset('backend/css/company/pharmacy') }}" rel="stylesheet">
@endsection

<x-dash.master>


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
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200"
                                id="pharmacyRow{{ $pharmacy->id }}">
                                <td class="py-4 px-6 text-gray-700">{{ $loop->iteration }}</td>
                                <td class="py-4 px-6">
                                    @if ($pharmacy->image)
                                        <img src="{{ asset('storage/pharmacy/' . $pharmacy->image->path) }}"
                                            alt="صورة الصيدلية"
                                            class="w-24 h-16 rounded-lg object-cover border border-gray-200 shadow-sm">
                                    @else
                                        <span class="text-gray-500">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-gray-900 font-medium">{{ $pharmacy->name }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->email }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->address }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $pharmacy->sent_orders_count }}</td>
                                <td class="py-4 px-6">
                                    <button
                                        onclick="deletePharmacy({{ $pharmacy->id }}, '{{ route('company.pharmacies.destroy', $pharmacy->id) }}')"
                                        class="px-4 py-2 text-base font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">لا توجد صيدليات طلبت من الشركة
                                    حاليًا</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/js/company/pharmacy.js') }}"></script>


</x-dash.master>
