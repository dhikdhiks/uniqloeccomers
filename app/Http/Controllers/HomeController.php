<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status',1)->take(3)->get();
        $categories = Category::orderBy('name')->take(4)->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->take(8)->get();
        $fproducts = Product::where('featured', 1)->get()->take(8);

        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts'));
    }
     public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'comment' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function address()
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();
        return view('address', compact('order'));
    }
        public function addressUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'locality' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip' => 'required|string',
            'type' => 'required|string',
        ]);

        $order = Order::where('user_id', Auth::id())->latest()->first();

        if ($order) {
            $order->update($request->only([
                'name', 'phone', 'locality', 'address', 'city', 'state', 'country', 'zip', 'type'
            ]));
        }

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
    }
    public function accountDetails()
    {
        $user = Auth::user();
        return view('user.account-details', compact('user'));
    }
     public function updateAccountDetails(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('account.details')->with('success', 'Informasi akun berhasil diperbarui.');
    }
}
