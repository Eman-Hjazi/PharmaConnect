<x-dash.master>
    <div class="container  px-4 py-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">عرض المخزون</h2>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full table-auto" dir="rtl">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 uppercase">اسم الدواء</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 uppercase">الكمية المتاحة</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 uppercase">سعر البيع</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 uppercase">تاريخ الانتهاء</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-600 uppercase">حالة المخزون</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($inventory as $item)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-4 py-3 text-sm text-gray-700 border-transparent">{{ $item->medicine->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 border-transparent">{{ number_format($item->quantity_in_stock) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 border-transparent">{{ number_format($item->selling_price, 2) }} شيكل</td>
                            <td class="px-4 py-3 text-sm text-gray-700 border-transparent">
                                @if($item->expiry_date)
                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}
                                @else
                                    غير محدد
                                @endif
                            </td>
                            <td class="px-4 py-3 border-transparent">
                                <span class="px-2 py-1 rounded text-sm font-medium
                                    @if($item->status == 'متوفر') bg-green-100 text-green-700
                                    @elseif($item->status == 'قليل') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="mt-6">
                {{ $inventory->links() }}
            </div> --}}
        </div>
    </div>
</x-dash.master>
