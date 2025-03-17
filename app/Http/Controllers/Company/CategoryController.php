<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

use App\Models\MedicineCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // عرض قائمة التصنيفات
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = MedicineCategory::all();
            return response()->json(['categories' => $categories]);
        }
        return view('company.medicine_categories.index');
    }

    // إضافة تصنيف جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:medicine_categories',
        ]);

        $category = MedicineCategory::create($validated);
        return response()->json(['success' => true, 'category' => $category]);
    }

    // تحديث تصنيف
    public function update(Request $request, $id)
    {
        $category = MedicineCategory::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:medicine_categories,name,' . $id,
        ]);

        $category->update($validated);
        return response()->json(['success' => true, 'category' => $category]);
    }

    // حذف تصنيف
    public function destroy($id)
    {
        $category = MedicineCategory::findOrFail($id);
        $category->delete();
        return response()->json(['success' => true]);
    }
}
