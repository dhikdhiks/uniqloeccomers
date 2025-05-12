<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();
        Cart::instance('cart')->restore($identifier);

        $invalidItemsRemoved = false;
        foreach (Cart::instance('cart')->content() as $item) {
            if (!$item->model) {
                Cart::instance('cart')->remove($item->rowId);
                $invalidItemsRemoved = true;
            }
        }
        Cart::instance('cart')->store($identifier);

        if ($invalidItemsRemoved) {
            Session::flash('invalid_items_removed', 'Beberapa item dihapus dari keranjang karena sudah tidak tersedia.');
        }

        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan!');
        }

        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();

        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate('App\Models\Product');

        Cart::instance('cart')->store($identifier);

        if (Auth::check()) {
            DB::table('shoppingcart')
                ->where('identifier', $identifier)
                ->where('instance', 'cart')
                ->update(['user_id' => Auth::id()]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update_cart_quantity(Request $request, $rowId)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease,set',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();
        $product = Cart::instance('cart')->get($rowId);

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan di keranjang!'], 404);
        }

        $qty = $product->qty;
        if ($request->action == 'increase') {
            $qty++;
        } elseif ($request->action == 'decrease') {
            $qty--;
            if ($qty <= 0) {
                Cart::instance('cart')->remove($rowId);
                Cart::instance('cart')->store($identifier);
                return response()->json(['success' => 'Produk dihapus dari keranjang!']);
            }
        } elseif ($request->action == 'set' && $request->quantity) {
            $qty = $request->quantity;
        }

        Cart::instance('cart')->update($rowId, $qty);
        Cart::instance('cart')->store($identifier);

        if (Auth::check()) {
            DB::table('shoppingcart')
                ->where('identifier', $identifier)
                ->where('instance', 'cart')
                ->update(['user_id' => Auth::id()]);
        }

        if (Session::has('coupon')) {
            $this->calculateDiscount();
        }

        return response()->json([
            'success' => 'Jumlah diperbarui!',
            'subtotal' => number_format(Cart::instance('cart')->subtotal(), 2),
            'total' => number_format(Cart::instance('cart')->total(), 2),
            'item_subtotal' => number_format($product->subtotal(), 2),
        ]);
    }

    public function remove_item($rowId)
    {
        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();
        Cart::instance('cart')->remove($rowId);
        Cart::instance('cart')->store($identifier);

        if (Auth::check()) {
            DB::table('shoppingcart')
                ->where('identifier', $identifier)
                ->where('instance', 'cart')
                ->update(['user_id' => Auth::id()]);
        }

        return response()->json(['success' => 'Item dihapus dari keranjang!']);
    }

    public function empty_cart()
    {
        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();
        Cart::instance('cart')->destroy();
        DB::table('shoppingcart')
            ->where('identifier', $identifier)
            ->where('instance', 'cart')
            ->delete();

        return response()->json(['success' => 'Keranjang dikosongkan!']);
    }

    public function apply_coupon_code(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon_code = $request->coupon_code;
        $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

        $coupon = Coupon::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $subtotal)
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Kode kupon tidak valid!');
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => floatval($coupon->value),
            'cart_value' => floatval($coupon->cart_value)
        ]);

        $this->calculateDiscount();
        return redirect()->back()->with('success', 'Kupon berhasil diterapkan!');
    }

    public function calculateDiscount()
    {
        $discount = 0;
        $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $couponValue = floatval($coupon['value']);

            if ($coupon['type'] == 'fixed') {
                $discount = min($couponValue, $subtotal);
            } else {
                $discount = min(($subtotal * $couponValue) / 100, $subtotal);
            }
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', '')
        ]);

        Log::info('Perhitungan Diskon', [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'subtotalAfterDiscount' => $subtotalAfterDiscount,
            'taxAfterDiscount' => $taxAfterDiscount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);
    }

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return back()->with('success', 'Kupon berhasil dihapus!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Cart::instance('cart')->content()->count() <= 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan item untuk melanjutkan ke checkout.');
        }

        $address = Address::where('user_id', Auth::user()->id)
            ->where('isdefault', 1)
            ->first();

        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric',
                'zip' => 'required|numeric|digits:5',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Indonesia';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountForCheckout();

        if (!Session::has('checkout')) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong atau data checkout hilang. Silakan tambahkan item ke keranjang.');
        }

        $checkout = Session::get('checkout');
        $subtotal = floatval(str_replace(',', '', $checkout['subtotal']));
        $discount = floatval(str_replace(',', '', $checkout['discount']));
        $tax = floatval(str_replace(',', '', $checkout['tax']));
        $total = floatval(str_replace(',', '', $checkout['total']));

        if ($discount > $subtotal) {
            Session::forget('coupon');
            Session::forget('discounts');
            Session::forget('checkout');
            return redirect()->route('cart.index')->with('error', 'Jumlah diskon tidak valid. Silakan periksa keranjang Anda.');
        }

        $maxValue = 99999999.99;
        if ($subtotal > $maxValue || $discount > $maxValue || $tax > $maxValue || $total > $maxValue) {
            return redirect()->back()->with('error', 'Jumlah pesanan melebihi nilai maksimum yang diizinkan.');
        }

        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->tax = $tax;
        $order->total = $total;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->status = 'ordered';
        $order->is_shipping_different = false;
        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }

        $request->validate([
            'mode' => 'required|in:card,paypal,cod',
        ]);

        if ($request->mode == "card") {
            // Logika untuk pembayaran kartu
        } elseif ($request->mode == "paypal") {
            // Logika untuk pembayaran PayPal
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();
        }

        $identifier = Auth::check() ? 'user_' . Auth::id() : 'guest_' . session()->getId();
        Cart::instance('cart')->destroy();
        DB::table('shoppingcart')
            ->where('identifier', $identifier)
            ->where('instance', 'cart')
            ->delete();

        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        return redirect()->route('cart.order.confirmation');
    }

    public function setAmountForCheckout()
    {
        if (Cart::instance('cart')->content()->count() <= 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            $discounts = Session::get('discounts');
            if (!$discounts || !isset($discounts['subtotal']) || !isset($discounts['discount']) || $discounts['discount'] > $discounts['subtotal']) {
                Session::forget('coupon');
                Session::forget('discounts');
                Session::put('checkout', [
                    'discount' => 0,
                    'subtotal' => Cart::instance('cart')->subtotal(),
                    'tax' => Cart::instance('cart')->tax(),
                    'total' => Cart::instance('cart')->total(),
                ]);
            } else {
                Session::put('checkout', [
                    'discount' => $discounts['discount'],
                    'subtotal' => $discounts['subtotal'],
                    'tax' => $discounts['tax'],
                    'total' => $discounts['total'],
                ]);
            }
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }

        Log::info('Checkout Data', [
            'checkout' => Session::get('checkout'),
        ]);
    }

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
