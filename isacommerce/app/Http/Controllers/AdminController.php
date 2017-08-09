<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Admin;
use App\Role;
use App\Permission;
use App\Category;
use App\Product;
use App\ProductToCategory;
use App\User;
use App\Country;
use App\Province;
use App\Address;
use App\Order;
use App\OrderProduct;
use App\Discount;
use App\Brand;
use App\Attribute;
use App\AttributeValue;
use App\ProductToAttribute;

use Validator;
use Image;
use File;
use Carbon\Carbon;
use DB;

class AdminController extends Controller{
    public function __construct(){
    	$this->middleware('admin');
        date_default_timezone_set('asia/jakarta');
    }

    public function dashboard(){
        $data['count_users']    = User::all()->count();
        $data['count_orders']   = Order::all()->count();
        $data['count_products'] = Product::all()->count();

        $data['orders'] = DB::table('order')
        ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
        ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'order.id')
        ->take(10)
        ->get(); 

        return view('backend.dashboard.dashboard')->with('data', $data);
    }
    public function category(){
        $category = Category::all();
        return view('backend.categories.categories')->with('category', $category);
    }

    public function categoryCreate(){
        $category = Category::all('id', 'parent_id', 'category_name');
        return view('backend.categories.categories_create')->with('category', $category);
    }

    public function categoryStore(Request $request){
        $validator = Validator::make($request->all(), [
            'parent_id'                  => 'required',
            'category_name'              => 'required|min:3|max:100|unique:category,category_name',
            'category_meta_title'        => 'required|min:3|max:50',
            'category_meta_description'  => 'required|min:3|max:100',
            'category_meta_keyword'      => 'required|min:3|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $category = new Category;
            $slug = str_slug($request->category_name,"-");

            $category->category_name             = $request->category_name;
            $category->category_seo              = $slug;
            $category->category_meta_title       = $request->category_meta_title;
            $category->category_meta_description = $request->category_meta_description;
            $category->category_meta_keyword     = $request->category_meta_keyword;
            $category->status                    = $request->status;
            $category->parent_id                 = $request->parent_id;
            $category->created_at                = $time_now;

            $category->save();
            return back()->with('status', 'Category was successfully added!');
        }
    }

    public function categoryEdit($id){
        $category = Category::find($id);
        $categories = Category::all('id', 'parent_id', 'category_name');
        return view('backend.categories.categories_edit')->with('category', $category)->with('categories', $categories);
    }
    public function categoryUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name'              => 'required|min:3|max:100',
            'category_meta_title'        => 'required|min:3|max:50',
            'category_meta_description'  => 'required|min:3|max:100',
            'category_meta_keyword'      => 'required|min:3|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $category = Category::find($request->id);
            $slug = str_slug($request->category_name,"-");

            $category->category_name             = $request->category_name;
            $category->category_seo              = $slug;
            $category->category_meta_title       = $request->category_meta_title;
            $category->category_meta_description = $request->category_meta_description;
            $category->category_meta_keyword     = $request->category_meta_keyword;
            $category->status                    = $request->status;
            $category->parent_id                 = $request->parent_id;
            $category->updated_at                = $time_now;

            $category->save();
            return back()->with('status', 'category was successfully updated!');
        }
    }

    public function categoryDelete($id){
        $category = Category::find($id);
        $category->delete();
        return redirect('isa-cms/categories')->with('status', 'Category was successfully deleted!');
    }

    public function products(){
        $product = Product::where('product.parent_id', '0')->get();
        return view('backend.products.products')->with('product', $product);
    }

    public function productCreate(){
        $category = Category::all('id', 'parent_id', 'category_name');
        $brand    = Brand::all('id', 'name', 'is_active');
        return view('backend.products.products_create')->with('category', $category)->with('brand', $brand);
    }

    public function productStore(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name'              => 'required|min:3|max:100',
            'product_name'              => 'required|min:3|max:100',
            'product_meta_title'        => 'required|min:3|max:50',
            'product_meta_description'  => 'required|min:3|max:100',
            'product_description'       => 'required|min:3|max:750',
            'product_detail'            => 'required|min:3|max:750',
            'meta_keyword'              => 'required|min:3|max:50',
            'sku'                       => 'required|unique:product,sku',
            'product'                   => 'array|min:1',
            'upc'                       => 'required',
            'price'                     => 'required|min:1|numeric',
            'weight'                    => 'required',
            'quantity'                  => 'required',
            'min_quantity'              => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $prod = $request->product;
            $keylength = $request->lenght;

            $slug = str_slug($request->product_name,"-");

            $product = new Product;

            $product->brand_id                 = $request->brand_id;
            $product->product_name             = $request->product_name;
            $product->product_seo              = $slug;
            $product->product_meta_title       = $request->product_meta_title;
            $product->product_meta_description = $request->product_meta_description;
            $product->product_meta_keyword     = $request->meta_keyword;
            $product->sku                      = $request->sku;
            $product->upc                      = $request->upc;
            $product->price                    = $request->price;
            $product->weight                   = $request->weight;
            $product->quantity                 = $request->quantity;
            $product->min_quantity             = $request->min_quantity;
            $product->subtract_quantity        = $request->subtract_quantity;
            $product->product_description      = $request->product_description;
            $product->product_detail           = $request->product_detail;
            $product->product_spesification    = $request->product_spesification;
            $product->status                   = $request->status;
            $product->created_at               = $time_now;

            $product->save();

            for($i=1; $i<$keylength; $i++){
                if(!empty($prod[$i]['categories'])){
                    $product_to_category = new ProductToCategory;
                    $product_to_category->product_id   = $product->id;
                    $product_to_category->category_id  = $prod[$i]['categories'];
                    $product_to_category->created_at   = $time_now;
                    $product_to_category->save();
                }
            }
            if($request->has('discount')){
                $this->createDiscount($product->id, $request->discount);
            }
            return back()->with('status', 'Product was successfully added!');
        }
    }

    public function createDiscount($product_id, $data){
        $time_now = Carbon::now();
        $newDate = date("Y-m-d", strtotime($data['expiry']));
        $discount = new Discount;

        $discount->product_id          = $product_id;
        $discount->is_active           = $data['active'];
        $discount->discount_operation  = $data['type'];
        $discount->discount_amount     = $data['amount'];
        $discount->expiry              = $newDate;
        $discount->created_at          = $time_now;

        $discount->save();
    }

    public function updateDiscount($data){
        $time_now = Carbon::now();
        $newDate = date("Y-m-d", strtotime($data['expiry']));

        $discount = Discount::find($data['discount_id']);
        $discount->is_active           = $data['active'];
        $discount->discount_operation  = $data['type'];
        $discount->discount_amount     = $data['amount'];
        $discount->expiry              = $newDate;
        $discount->updated_at          = $time_now;

        $discount->save();
    }

    public function productEdit($id){
        $product      = Product::find($id);
        $category     = Category::all('id', 'parent_id', 'category_name');
        $brand        = Brand::all('id', 'name', 'is_active');
        $product_cat  = ProductToCategory::where('product_id', $id)->get();

        return view('backend.products.products_edit')->with('product', $product)->with('category', $category)
        ->with('product_cat', $product_cat)->with('brand', $brand);
    }

    public function productUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'product_name'              => 'required|min:3|max:100',
            'product_meta_title'        => 'required|min:3|max:50',
            'product_meta_description'  => 'required|min:3|max:100',
            'product_meta_keyword'      => 'required|min:3|max:50',
            'product_description'       => 'required|min:3|max:750',
            'product_detail'            => 'required|min:3|max:1750',
            'sku'                       => 'required',
            'upc'                       => 'required',
            'price'                     => 'required|min:1|numeric',
            'weight'                    => 'required',
            'quantity'                  => 'required',
            'min_quantity'              => 'required',
            'subtract_quantity'         => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $prod = $request->product;
            $keylength = $request->lenght;
            $slug = str_slug($request->product_name,"-");
            $product = Product::find($request->id);

            $product->brand_id                 = $request->brand_id;
            $product->product_name             = $request->product_name;
            $product->product_seo              = $slug;
            $product->product_meta_title       = $request->product_meta_title;
            $product->product_meta_description = $request->product_meta_description;
            $product->product_meta_keyword     = $request->product_meta_keyword;
            $product->sku                      = $request->sku;
            $product->upc                      = $request->upc;
            $product->price                    = $request->price;
            $product->weight                   = $request->weight;
            $product->quantity                 = $request->quantity;
            $product->min_quantity             = $request->min_quantity;
            $product->subtract_quantity        = $request->subtract_quantity;
            $product->product_description      = $request->product_description;
            $product->product_detail           = $request->product_detail;
            $product->product_spesification    = $request->product_spesification;
            $product->status                   = $request->status;
            $product->updated_at               = $time_now;

            $product->save();

            $product_cat    = ProductToCategory::where('product_id', $request->id)->delete();

            for($i=1; $i<$keylength; $i++){
                if(!empty($prod[$i]['categories'])){
                    $product_to_category = new ProductToCategory;
                    $product_to_category->product_id   = $product->id;
                    $product_to_category->category_id  = $prod[$i]['categories'];
                    $product_to_category->created_at   = $time_now;
                    $product_to_category->save();
                }
            }

            if($request->has('discount')){
                $discount = $request->discount;
                if($discount['discount_id'] == '-'){
                    $this->createDiscount($product->id, $request->discount);
                }else{
                    $this->updateDiscount($request->discount);
                }
            }
            return back()->with('status', 'Product was successfully updated!');
            echo $request->brand_id;
        }
    }

    public function productPicture($id){
        $ada = DB::table('images')->where('product_id','=', $id)->count();
        $pictures = DB::table('images')->where('product_id','=', $id)->get();

        return view('backend.products.products_picture')->with('pictures', $pictures)->with('id',$id)->with('ada',$ada);
    }

    public function productsStorePicture(Request $request){ //test with postman
        $validator = Validator::make($request->all(), [
            'id'       => 'required|integer|exists:product,id',
            'image'  => 'required|image|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $image = $request->image;
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            $path = 'theme/backend/images/product/' . $filename;
            Image::make($image->getRealPath())->fit(600, 730)->save($path);
            DB::table('images')->insert(['product_id' => $request->id, 'image' => $filename, 'created_at' => $time_now]);
            return back()->with('status', 'Image was successfully added!');
        }
    }
    public function productDeletePicture($id){
        $ale = DB::table('images')->where('id', $id)->first();
        $path = 'theme/backend/images/product/' . $ale->image;
        File::delete($path);
        DB::delete('DELETE FROM images WHERE id = ?',[$id]);
        return back()->with('status', 'Image was successfully deleted!');
    }
    public function productDelete($id){
        $product        = Product::where('id', $id)->delete();
        $product_cat    = ProductToCategory::where('product_id', $id)->delete();
        return redirect('isa-cms/products')->with('status', 'Product was successfully deleted!');
    }

    public function productCombination($id){
        $product = Product::where('parent_id', $id)->get();
        $value_pair = DB::table('product')
        ->join('product_to_attribute', 'product.id', '=', 'product_to_attribute.product_id')
        ->join('attribute', 'product_to_attribute.attribute_id', '=', 'attribute.id')
        ->join('attribute_value', 'product_to_attribute.value_id', '=', 'attribute_value.id')
        ->select('product_to_attribute.product_id', 'attribute.name as attribute_name', 'attribute_value.value as value_name')
        ->where('parent_id', $id)->get();
        $parent_product = Product::select('product_name')->where('id', $id)->first();
        session(['parent_combination_id' => $id]);
        return view('backend.products.products_combination')->with('product', $product)->with('value_pair', $value_pair)->with('parent_product', $parent_product);
    }

    public function productCombinationCreate(){
        $data['id'] = session('parent_combination_id');
        $data['product']   = Product::find($data['id']);
        $data['attribute'] = Attribute::all();
        return view('backend.products.products_combination_create')->with('data', $data);
    }

    public function productCombinationStore(Request $request){
        $validator = Validator::make($request->all(), [
            'price'     => 'required',
            'quantity'  => 'required',
            'parent_id' => 'required',
            'attrVal'   => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $parent_product = Product::find($request->parent_id);
            $product = new Product;

            $product->brand_id                 = $parent_product->brand_id;
            $product->parent_id                = $request->parent_id;
            $product->product_name             = $parent_product->product_name;
            $product->product_seo              = $parent_product->product_seo;
            $product->product_meta_title       = $parent_product->product_meta_title;
            $product->product_meta_description = $parent_product->product_meta_description;
            $product->product_meta_keyword     = $parent_product->product_meta_keyword;
            $product->sku                      = $parent_product->sku;
            $product->upc                      = $parent_product->upc;
            $product->price                    = $request->price;
            $product->weight                   = $parent_product->weight;
            $product->quantity                 = $request->quantity;
            $product->min_quantity             = $parent_product->min_quantity;
            $product->subtract_quantity        = $parent_product->subtract_quantity;
            $product->product_description      = $parent_product->product_description;
            $product->status                   = $request->status;
            $product->created_at               = $time_now;

            $product->save();
            $attrVal = $request->attrVal;
            foreach ($attrVal as $item){
                $pieces = explode("|", $item);
                $productAttr = new ProductToAttribute;
                $productAttr->product_id    = $product->id;
                $productAttr->attribute_id  = $pieces[0];
                $productAttr->value_id      = $pieces[1];
                $productAttr->created_at    = $time_now;

                $productAttr->save();
            }

            if($request->discount['amount'] !=0){
                $this->createDiscount($product->id, $request->discount);
            }
            return back()->with('status', 'Combination was successfully added!');
        }
    }

    public function productCombinationEdit($id){
        $data['id'] = $id;
        $data['parent_id']  = session('parent_combination_id');
        $data['product']    = Product::find($id);
        $data['attribute']  = Attribute::all();
        $data['value_pair'] = DB::table('product')
        ->join('product_to_attribute', 'product.id', '=', 'product_to_attribute.product_id')
        ->join('attribute', 'product_to_attribute.attribute_id', '=', 'attribute.id')
        ->join('attribute_value', 'product_to_attribute.value_id', '=', 'attribute_value.id')
        ->select('product_to_attribute.product_id', 'attribute.name as attribute_name', 'attribute.id as attribute_id', 'attribute_value.value as value_name', 'attribute_value.id as value_id')
        ->where('product.id', $id)->get();
        return view('backend.products.products_combination_edit')->with('data', $data);
    }

    public function productCombinationUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'price'     => 'required',
            'quantity'  => 'required',
            'id' => 'required',
            'attrVal'   => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $product = Product::find($request->id);

            $product->price                    = $request->price;
            $product->quantity                 = $request->quantity;
            $product->status                   = $request->status;
            $product->created_at               = $time_now;

            $product->save();

            $product = ProductToAttribute::where('product_id', $request->id)->delete();

            $attrVal = $request->attrVal;
            foreach ($attrVal as $item){
                $pieces = explode("|", $item);
                $productAttr = new ProductToAttribute;
                $productAttr->product_id    = $request->id;
                $productAttr->attribute_id  = $pieces[0];
                $productAttr->value_id      = $pieces[1];
                $productAttr->created_at    = $time_now;

                $productAttr->save();
            }
            if($request->discount['discount_id'] == '-'){
                if($request->discount['amount'] !=0){
                    $this->createDiscount($request->id, $request->discount);
                }
            }else{
                $this->updateDiscount($request->discount);
            }
            return back()->with('status', 'Combination was successfully updated!');
        }
    }

    public function productCombinationDelete($id){
        $product = Product::where('id', $id)->delete();
        return back()->with('status', 'Combination was successfully deleted!');
    }

    public function order(){
        $orders = DB::table('order')
        ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
        ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'order.id')
        ->get(); 
        $category = Category::all();
        return view('backend.orders.orders')->with('category', $category)->with('orders', $orders);
    }
    public function orderDetail($id){
        //$order  = Order::find($id);
        $order = DB::table('order')
        ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
        ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'order.id', 'email', 'order.order_status_id')
        ->where('order.id', $id)
        ->first();
        $detail = Order::find($id)->orderProduct;
        return view('backend.orders.orders_detail')->with('order', $order)->with('detail', $detail);
    }
    public function orderUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'id'          => 'required|integer|exists:order,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            DB::table('order')->where('id', $request->id)->update([
                'order_status_id' => '2'
            ]);
            return back()->with('status', 'Payment status was successfully updated!');
        }
    }
    public function orderDelete($id){
        $order = Order::where('id', $id)->delete();
        return redirect('isa-cms/orders')->with('status', 'Order was successfully deleted!');
    }

    public function customersDelete($id){
        $order = User::where('id', $id)->delete();
        return redirect('isa-cms/customers')->with('status', 'Customer was successfully deleted!');
    }

    public function customers(){
        $customers = DB::select('SELECT * FROM users ORDER BY firstname ASC');
        return view('backend.customers.customers')->with('customers', $customers);
    }
    public function customersEdit($id){
        $data['province'] = array();
        $data['customer'] = User::find($id);
        $data['country']  = Country::all();
        if(!empty($data['customer']->address->country_id)){
            $data['province'] = Province::where('country_id', $data['customer']->address->country_id)->get();
        }

        return view('backend.customers.customers_edit')->with('data', $data);
    }
    public function customersUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'id'          => 'required|integer|exists:users,id',
            'firstname'   => 'required|min:3|max:50',
            'lastname'    => 'required|min:3|max:50',
            'email'       => 'required|email|email:users,email,'.$request->id,
            'phone'       => 'required',
            'address'     => 'required',
            'city'        => 'required',
            'postcode'    => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $customer = User::find($request->id);
            $customer->firstname  = $request->firstname;
            $customer->lastname  = $request->lastname;
            $customer->email      = $request->email;
            $customer->phone      = $request->phone;
            $customer->updated_at = $time_now;
            $customer->save();

            $address              = Address::firstOrNew(array('id' => $request->id_address));
            $address->address     = $request->address;
            $address->city        = $request->city;
            $address->postcode    = $request->postcode;
            $address->user_id     = $customer->id;
            $address->country_id  = $request->state;
            $address->province_id = $request->province;
            $address->updated_at  = $time_now;
            $address->save();
            
            $address->save();
            return back()->with('status', 'Customer was successfully updated!');
        }
    }

    public function users(){
        $users = DB::select('SELECT u.*, r.name as role FROM admins u LEFT JOIN role_user h ON u.id = h.user_id LEFT JOIN roles r ON h.role_id = r.id ORDER BY u.name ASC');
        return view('backend.users.users')->with('users', $users);
    }

    public function usersCreate(){
        $roles = DB::table('roles')->get();
        return view('backend.users.users_create')->with('roles', $roles);
    }
    public function usersStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3|max:50',
            'email'     => 'required|email|unique:admins,email',
            'password'  => 'required|min:6|max:50',
            'role'      => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $password = bcrypt($request->password);
            $id = DB::table('admins')->insertGetId([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $password,
                'created_at'     => $time_now
            ]);
            if($id){
                DB::table('role_user')->insert(
                    ['role_id' => $request->role, 'user_id' => $id]
                );
            }
            return back()->with('status', 'User has successfully added!');
        }
    }
    public function usersDelete($id){
        DB::delete('DELETE FROM admins WHERE id = ?',[$id]);
        return redirect('isa-cms/users')->with('status', 'User has successfully deleted!');
    }
    public function usersEdit($id){
        $user  = DB::table('admins')->leftJoin('role_user', 'role_user.user_id', '=', 'admins.id')->where('id', $id)->first();
        $roles = DB::table('roles')->get();
        return view('backend.users.users_edit')->with('user', $user)->with('roles', $roles);
    }
    public function usersUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|min:3|max:50',
            'email'     => 'required|email|unique:admins,email,'.$request->id,
            'password'  => 'min:6|max:50',
            'role'      => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            if ($request->has('password')) {
                $password = bcrypt($request->password);
                DB::table('admins')->where('id', $request->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'updated_at' => $time_now
                ]);
                DB::table('role_user')->where('user_id', $request->id)->update([
                    'role_id' => $request->role,
                ]);
            }
            else{
                DB::table('admins')->where('id', $request->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'updated_at' => $time_now
                ]);
                DB::table('role_user')->where('user_id', $request->id)->update([
                    'role_id' => $request->role,
                ]);
            }
            return back()->with('status', 'User was successfully updated!');
        }
    }

    public function brands(){
        $brand = Brand::all();
        return view('backend.brands.brands')->with('brand', $brand);
    }

    public function brandsCreate(){
        return view('backend.brands.brands_create');
    }

    public function brandsStore(Request $request){
        $validator = Validator::make($request->all(), [
            'status'      => 'required',
            'name'        => 'required|min:3|max:50',
            'description' => 'required|min:3|max:100'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $brand = new Brand;

            $brand->name        = $request->name;
            $brand->description = $request->description;
            $brand->is_active   = $request->status;
            $brand->created_at  = $time_now;

            $brand->save();
            return back()->with('status', 'category was successfully added!');
        }
    }

    public function brandsEdit($id){
        $brand = Brand::find($id);
        return view('backend.brands.brands_edit')->with('brand', $brand);
    }
    public function brandsUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'status'      => 'required',
            'name'        => 'required|min:3|max:50',
            'description' => 'required|min:3|max:100'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $brand    = Brand::find($request->id);

            $brand->name         = $request->name;
            $brand->description  = $request->description;
            $brand->is_active    = $request->status;
            $brand->updated_at   = $time_now;

            $brand->save();
            return back()->with('status', 'category was successfully updated!');
        }
    }

    public function brandsDelete($id){
        $brand = Brand::find($id);
        $brand->delete();
        return redirect('isa-cms/brands')->with('status', 'Category was successfully deleted!');
    }

    public function attributes(){
        $attribute = Attribute::all();
        return view('backend.attributes.attributes')->with('attribute', $attribute);
    }

    public function attributesCreate(){
        return view('backend.attributes.attributes_create');
    }

    public function attributesStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name'        => 'required|min:3|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $attribute = new Attribute;

            $attribute->name        = $request->name;
            $attribute->description = $request->description;
            $attribute->is_active   = $request->status;
            $attribute->created_at  = $time_now;

            $attribute->save();
            return back()->with('status', 'Attribute was successfully added!');
        }
    }

    public function attributesEdit($id){
        $attribute = Attribute::find($id);
        return view('backend.attributes.attributes_edit')->with('attribute', $attribute);
    }
    public function attributesUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'status'      => 'required',
            'name'        => 'required|min:3|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now  = Carbon::now();
            $attribute = Attribute::find($request->id);

            $attribute->name         = $request->name;
            $attribute->description  = $request->description;
            $attribute->is_active    = $request->status;
            $attribute->updated_at   = $time_now;

            $attribute->save();
            return back()->with('status', 'Attribute was successfully updated!');
        }
    }

    public function attributesDelete($id){
        $attribute = Attribute::find($id);
        $attribute->delete();
        return redirect('isa-cms/attributes')->with('status', 'Attribute was successfully deleted!');
    }

    public function values($id){
        $value = Attribute::find($id)->attribute_value;
        session(['attribute_id' => $id]);
        return view('backend.values.values')->with('value', $value);
    }

    public function valuesCreate(){
        $id = session('attribute_id');
        return view('backend.values.values_create')->with('attribute_id', $id);
    }

    public function valuesStore(Request $request){
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now = Carbon::now();
            $attribute = new AttributeValue;

            $attribute->value        = $request->name;
            $attribute->attribute_id = $request->attribute_id;
            $attribute->created_at   = $time_now;

            $attribute->save();
            return back()->with('status', 'Value was successfully added!');
        }
    }

    public function valuesEdit($id){
        $attribute = AttributeValue::find($id);
        $id = session('attribute_id');
        return view('backend.values.values_edit')->with('attribute', $attribute)->with('attribute_id', $id);
    }
    public function valuesUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'id'   => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $time_now  = Carbon::now();
            $attribute = AttributeValue::find($request->id);

            $attribute->value        = $request->name;
            $attribute->updated_at   = $time_now;

            $attribute->save();
            $id = session('attribute_id');
            return redirect('isa-cms/attributes/values/list/'.$id)->with('status', 'Value was successfully updated!');
        }
    }

    public function valuesDelete($id){
        $attribute = AttributeValue::find($id);
        $attribute->delete();
        $id = session('attribute_id');
        return redirect('isa-cms/attributes/values/list/'.$id)->with('status', 'Value was successfully deleted!');
    }



}
