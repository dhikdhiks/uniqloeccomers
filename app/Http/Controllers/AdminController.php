<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use function PHPUnit\Framework\returnCallback;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    //brand
    public function brands(){
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }
    //add-brand
    public function add_brand(){
        return view('admin.brand-add');
    }
    //brand-store
    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'mimes:jpeg,jpg,png,webp|max:10240',
        ]);
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateBrandThumbnailImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been added succesfully');
    }
    //edit-brand
    public function brand_edit($id) {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    //forcedelete-brand
    public function brand_delete($id){
        $brand = Brand::find($id);
        if (File::exists(public_path('uploads/brands').'/'.$brand->image)) {
            File::delete(public_path('uploads/brands').'/'.$brand->image);
        }
       $brand->delete();
       return redirect()->route('admin.brands')->with('status', 'brand has been deleted succesfully');
    }

    //update-brand
    public function brand_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'image' => 'mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $brand = Brand::find($request->id); // Bukan fing, bukan new Brand
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found');
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if ($request->hasFile('image')) {
            // Hapus file lama
            if (File::exists(public_path('uploads/brands/'.$brand->image))) {
                File::delete(public_path('uploads/brands/'.$brand->image));
            }

            // Upload baru
            $image = $request->file('image');
            $file_extension = $image->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extension;
            $this->GenerateBrandThumbnailImage($image, $file_name);
            $brand->image = $file_name;
        }

        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated successfully');
        }
        //thumbnail-brand
        public function GenerateBrandThumbnailImage($image, $imageName){
            $destinationPath = public_path('uploads/brands');
            $img = Image::read($image->path());
            $img->cover(124,124,"top");
            $img->resize(124,124,function($constraint){
                $constraint->aspectRatio();            })->save($destinationPath.'/'.$imageName);
        }
        //categories
        public function categories(){
            $categories = Category::orderBy('id', 'DESC')->paginate(10);
            return view('admin.categories', compact('categories'));
        }
        //add category
        public function category_add(){
            return view('admin.category-add');
        }
        //store_category
        public function category_store(Request $request){
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug',
                'image' => 'mimes:jpeg,jpg,png,webp|max:10240',
            ]);
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateCategoryThumbnailImage($image,$file_name);
            $category->image = $file_name;
            $category->save();
            return redirect()->route('admin.categories')->with('status', 'Category has been added succesfully');
        }
        //edit-category
        public function category_edit($id) {
            $category = category::find($id);
            return view('admin.category-edit', compact('category'));
        }

        //forcedelete
        public function category_delete($id){
            $category = Category::find($id);
            if (File::exists(public_path('uploads/categories').'/'.$category->image)) {
                File::delete(public_path('uploads/categories').'/'.$category->image);
            }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'category has been deleted succesfully');
        }

        //edit
        public function category_update(Request $request){
            $request->validate([
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,'.$request->id,
                'image' => 'mimes:jpeg,jpg,png,webp|max:10240',
            ]);

            $category = category::find($request->id); // Bukan fing, bukan new category
            if (!$category) {
                return redirect()->back()->with('error', 'category not found');
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);

            if ($request->hasFile('image')) {
                // Hapus file lama
                if (File::exists(public_path('uploads/categories/'.$category->image))) {
                    File::delete(public_path('uploads/categories/'.$category->image));
                }

                // Upload baru
                $image = $request->file('image');
                $file_extension = $image->extension();
                $file_name = Carbon::now()->timestamp.'.'.$file_extension;
                $this->GeneratecategoryThumbnailImage($image, $file_name);
                $category->image = $file_name;
            }

            $category->save();
            return redirect()->route('admin.categories')->with('status', 'category has been updated successfully');
        }
    //thumbnail-category
    public function GenerateCategoryThumbnailImage($image, $imageName){
        $destinationPath = public_path('uploads/categories');
        $img = Image::read($image->path());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }
    //product
    public function products(){
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }
    public function product_add(){
        $categories = Category::select('id', 'name',)->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }
    public function product_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|mimes:jpeg,jpg,png,webp|max:10240',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
           $product = new Product();
           $product->name = $request->name;
           $product->slug = Str::slug($request->name);
           $product->short_description = $request->short_description;
           $product->description = $request->description;
           $product->regular_price = $request->regular_price;
           $product->sale_price = $request->sale_price;
           $product->SKU = $request->SKU;
           $product->stock_status = $request->stock_status;
           $product->featured = $request->featured;
           $product->quantity = $request->quantity;
           $product->category_id = $request->category_id;
           $product->brand_id = $request->brand_id;

           $current_timestamp = Carbon::now()->timestamp;

           if ($request->hasFile('image'))
           {
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' .$image->extension();
                $this->GenerateProductThumbnailImage($image,$imageName);
                $product->image = $imageName;
           }

           $gallery_arr = array();
           $gallery_images = "";
           $counter = 1;

           if ($request->hasFile('images')) {
                $allowedfileExtion = ['jpg', 'png', 'jpeg', 'webp'];
                $files = $request->file('images');
                foreach ($files as $file ) {
                    $gextension = $file->getClientOriginalExtension();
                    $gcheck = in_array($gextension, $allowedfileExtion);
                    if($gcheck){
                        $gfileName = $current_timestamp . '-' .$counter . '.' .$gextension;
                        $this->GenerateProductThumbnailImage($file, $gfileName);
                        array_push($gallery_arr, $gfileName);
                        $counter = $counter + 1;
                    }
                }
                $gallery_images = implode(',',$gallery_arr);
           }
           $product->images = $gallery_images;
           $product->save();
           return redirect()->route('admin.products')->with('status', 'Product has been added succesfully');
    }
    public function GenerateProductThumbnailImage($image, $imageName){
            $destinationPathThumbnail = public_path('uploads/products/thumbnails');
            $destinationPath = public_path('uploads/products');
            $img = Image::read($image->path());

            $img->cover(540,689,"top");
            $img->resize(540,689,function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);

            $img->resize(540,689,function($constraint){
                $constraint->aspectRatio();
            })->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function product_edit($id){
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get(); // FIXED
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }


    //update
    public function product_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|integer',
            'image' => 'mimes:jpeg,jpg,png,webp|max:10240',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);
        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if ($request->hasFile('image'))
           {
            if (File::exists(public_path('uploads/products').'/'.$product->image)) {
                File::delete(public_path('uploads/products').'/'.$product->image);
            }
            if (File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)) {
                File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
            }
                $image = $request->file('image');
                $imageName = $current_timestamp . '.' .$image->extension();
                $this->GenerateProductThumbnailImage($image,$imageName);
                $product->image = $imageName;
           }

           $gallery_arr = array();
           $gallery_images = "";
           $counter = 1;

           if ($request->hasFile('images')) {
                foreach (explode(',', $product->images) as $ofile){
                    if (File::exists(public_path('uploads/products').'/'.$ofile)) {
                        File::delete(public_path('uploads/products').'/'.$ofile);
                    }
                    if (File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)) {
                        File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                    }
                }

                $allowedfileExtion = ['jpg', 'png', 'jpeg', 'webp'];
                $files = $request->file('images');
                foreach ($files as $file ) {
                    $gextension = $file->getClientOriginalExtension();
                    $gcheck = in_array($gextension, $allowedfileExtion);
                    if($gcheck){
                        $gfileName = $current_timestamp . '-' .$counter . '.' .$gextension;
                        $this->GenerateProductThumbnailImage($file,$gfileName);
                        array_push($gallery_arr,$gfileName);
                        $counter = $counter + 1;
                    }
                }
                $gallery_images = implode(',',$gallery_arr);
                $product->images = $gallery_images;
           }

           $product->save();
           return redirect()->route('admin.products')->with('status', 'Product has been updated succesfully !');
    }
    public function product_delete($id){
        $product = Product::find($id);
        if (File::exists(public_path('uploads/products').'/'.$product->image))
        {
            File::delete(public_path('uploads/products').'/'.$product->image);
        }
        if (File::exists(public_path('uploads/products/thumbnails').'/'.$product->image))
        {
            File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
        }
        foreach (explode(',', $product->images) as $ofile){
            if (File::exists(public_path('uploads/products').'/'.$ofile)) {
                File::delete(public_path('uploads/products').'/'.$ofile);
            }
            if (File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)) {
                File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully !');
    }

    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function coupon_update(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
    }

    public function coupon_delete($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();

        return view('admin.order-details', compact('order','orderItems','transaction'));
    }
    public function update_order_status(Request $request)
    {
        $order= Order::find($request->order_id);
        $order->status = $request->order_status;
        if($request->order_status == 'delivered')
        {
            $order->delivered_date = Carbon::now();
        }
        else if($request->order_status == 'canceled')
        {
            $order->canceled_date = Carbon::now();
        }
        $order->save();

        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with("status", "status changed succesfully");
    }

    public function slides() {
    $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

}
