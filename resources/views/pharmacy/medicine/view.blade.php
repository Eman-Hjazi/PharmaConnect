<x-dash.master>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="container bg-white p-6 rounded-lg shadow-lg w-11/12 lg:w-3/4 text-right" >

            <!-- عنوان المخزون الحالي -->
            <h1 class="text-3xl font-bold text-blue-800 mb-4 text-center">المخزون الحالي</h1>

            <!-- زر إضافة دواء جديد -->
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('pharmacy.order.create') }}"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-blue-800 transition duration-300 flex items-center">
                    <ion-icon name="add-circle-outline" class="text-white text-xl mr-2"></ion-icon>
                    إضافة دواء جديد
                </a>
            </div>

            <!-- مربع البحث والتصفية -->
            <div class="mb-4 bg-white p-3 rounded-lg shadow-md flex justify-between items-center">
                <input type="text"
                    class="px-3 py-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-right"
                    placeholder="ابحث عن دواء..." id="search">
                <button class="bg-green-600 text-white py-2 px-4 ml-2 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
                    تصفية
                </button>
            </div>

            <!-- جدول الأدوية -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-blue-100 text-gray-700 uppercase text-sm">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">الاسم التجاري</th>
                            <th class="px-4 py-2">الفئة</th>
                            <th class="px-4 py-2">الشركة</th>
                            <th class="px-4 py-2">السعر</th>
                            <th class="px-4 py-2">تاريخ الانتهاء</th>
                            <th class="px-4 py-2">التحكم</th>
                            <th class="px-4 py-2">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicines as $medicine)
                            <tr class="border-b hover:bg-gray-50 transition duration-300">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-semibold text-gray-800">{{ $medicine->trade_name }}</td>
                                <td class="px-4 py-2">{{ $medicine->medicineCategory->name ?? 'غير محدد' }}</td>
                                <td class="px-4 py-2">{{ $medicine->company->name ?? 'غير محدد' }}</td>
                                <td class="px-4 py-2 text-green-600 font-semibold">${{ number_format($medicine->price, 2) }}</td>
                                <td class="px-4 py-2">
                                    {{ $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y') : 'غير محدد' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="text-sm font-medium px-2 py-1 rounded-full {{ $medicine->is_controlled ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                        {{ $medicine->is_controlled ? 'مقيد' : 'غير مقيد' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex space-x-2 justify-end">
                                    <a href="{{ route('medicines.show', $medicine->id) }}"
                                        class="text-blue-500 hover:text-blue-700 transition duration-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('medicines.edit', $medicine->id) }}"
                                        class="text-yellow-500 hover:text-yellow-700 transition duration-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition duration-300 delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-2 text-center text-gray-500">لم يتم العثور على أدوية</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- الترقيم -->
            <div class="mt-4 flex justify-center">
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
</x-dash.master>
