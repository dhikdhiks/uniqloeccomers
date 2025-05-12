<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $sessionId = 'guest_' . session()->getId();
        $userId = 'user_' . $user->id;

        // Pulihkan cart tamu (jika ada)
        Cart::instance('cart')->restore($sessionId);
        Log::info("Guest cart restored for sessionId: $sessionId, count: " . Cart::instance('cart')->count());

        // Pulihkan cart pengguna (jika ada)
        Cart::instance('cart')->restore($userId);
        Log::info("User cart restored for userId: $userId, count: " . Cart::instance('cart')->count());

        // Jika cart memiliki isi, simpan dengan user_id
        if (Cart::instance('cart')->count() > 0) {
            Cart::instance('cart')->store($userId);
            DB::table('shoppingcart')
                ->where('identifier', $userId)
                ->where('instance', 'cart')
                ->update(['user_id' => $user->id, 'updated_at' => now()]);
            Log::info("Cart stored for userId: $userId with user_id: " . $user->id);
        }

        // Hapus cart tamu dari database
        DB::table('shoppingcart')
            ->where('identifier', $sessionId)
            ->where('instance', 'cart')
            ->delete();
        Log::info("Guest cart deleted for sessionId: $sessionId");

        return redirect()->intended($this->redirectTo);
    }
}
