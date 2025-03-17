<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\PharmacyInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    public function show($id)
    {
        $inventory = PharmacyInventory::with('medicine')->findOrFail($id);
        $medicine = $inventory->medicine;

        return view('frontend.product', compact('inventory', 'medicine'));
    }



    public function add(Request $request, $id)
    {
        // الحصول على الكمية من الطلب (افتراضي 1 إذا لم يُرسل)
        $quantity = $request->input('quantity', 1);

        // التأكد من أن الكمية رقم صحيح وأكبر من 0
        if (!is_int($quantity) || $quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية يجب أن تكون رقمًا صحيحًا أكبر من 0'
            ], 422);
        }

        // إضافة المنتج إلى السلة أو تحديثه إذا كان موجودًا
        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'inventory_id' => $id,
            ],
            [
                'quantity' => $quantity,
            ]
        );

        return response()->json(['success' => true]);
    }


    public function getCartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $cartCount]);
    }




    public function sala()
    {
        $carts = Cart::where('user_id', Auth::id())->with('pharmacyInventory.medicine')->get();
        if ($carts->isEmpty()) {
            $carts = collect(); // تأكيد أنها مجموعة فارغة
        }
        $subtotal = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->pharmacyInventory->selling_price;
        });
        $shipping = 20.00;
        $total = $subtotal + $shipping;

        return view('frontend.cart', compact('carts', 'subtotal', 'shipping', 'total'));
    }

    // دالة لتحديث الكمية
    public function updateQuantity(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $quantity = $request->input('quantity');

        if ($quantity < 1) {
            $cart->delete();
        } else {
            $cart->update(['quantity' => $quantity]);
        }

        return response()->json(['success' => true]);
    }

    // دالة للحذف
    public function remove($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return response()->json(['success' => true]);
    }
}
