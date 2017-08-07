<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\OrderProduct;
use App\Cart;
use App\Veritrans\Veritrans;

use Mail;
use Validator;
use Crypt;
use DB;
use Session;

class HomeController extends Controller{
    public function __construct(){   
        Veritrans::$serverKey = 'VT-server-hV8ouznOVaZHXkbGCiAoBF4i';
        Veritrans::$isProduction = false;
        date_default_timezone_set('asia/jakarta');
    }
    
    public function productListLv1Filter($id, $orderby_1, $orderby_2){   
        $products = DB::table('product')
            ->select('product.id', 'product.product_name', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', 
                DB::raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->join('images', 'product.id', '=', 'images.product_id')
            ->whereIn('category.parent_id', function ($query) use ($id){
                $query->select('id')
                      ->from('category')
                      ->where('category.parent_id', $id);
                })
            ->where('product.status', 'Y')
            ->where('product.parent_id', '0')
            ->orderBy($orderby_1, $orderby_2)
            ->groupBy('product.id')
            ->take(6)
            ->get();
        return $products;
    }

    public function productListLv1($id, $min_price, $max_price){
        if($max_price == "more"){
            $column = 'product.price'; $condition = '>='; $value = '1';
        }else{
            $column = 'product.price'; $condition = '<='; $value = $max_price;
        }

        $products = DB::table('product')
            ->select('product.id', 'product.product_name', 'product.quantity', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', DB::raw('(select image from images where images.product_id = product.id limit 1) as image'), 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->join('images', 'product.id', '=', 'images.product_id')
            ->whereIn('category.parent_id', function ($query) use ($id){
                $query->select('id')
                      ->from('category')
                      ->where('category.parent_id', function ($query) use ($id){
                            $query->select('id')
                                  ->from('category')
                                  ->where('category.category_seo', $id);
                            }
                        );
                    }
                )
            ->where('product.status', 'Y')
            ->where('product.parent_id', '0')
            ->where('product.price', '>=', $min_price)
            ->where($column, $condition, $value)
            ->groupBy('product.id')
            ->paginate(9);
        return $products;
    }

    public function productListLv2($id, $min_price, $max_price){   
        if($max_price == "more"){
            $column = 'product.price'; $condition = '>='; $value = '1';
        }else{
            $column = 'product.price'; $condition = '<='; $value = $max_price;
        }

        $products = DB::table('product')
        ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
        ->join('category', 'product_to_category.category_id', '=', 'category.id')
        ->join('images', 'product.id', '=', 'images.product_id')
        ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
        ->select('product.id', 'product.product_name',  'product.quantity', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', DB::raw('(select image from images where images.product_id = product.id limit 1) as image'), 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
        ->where('category.parent_id', function ($query) use ($id){
            $query->select('id')
                ->from('category')
                ->where('category_seo', $id);
            })
        ->where('product.status', 'Y')
        ->where('product.parent_id', '0')
        ->where('product.price', '>=', $min_price)
        ->where($column, $condition, $value)
        ->groupBy('product.id')
        ->paginate(9);

        return $products;
    }

    public function productListLv3($id, $min_price, $max_price){  
        if($max_price == "more"){
            $column = 'product.price'; $condition = '>='; $value = '1';
        }else{
            $column = 'product.price'; $condition = '<='; $value = $max_price;
        }

        $products = DB::table('product')
        ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
        ->join('category', 'product_to_category.category_id', '=', 'category.id')
        ->join('images', 'product.id', '=', 'images.product_id')
        ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
        ->select('product.id', 'product.product_name',  'product.quantity', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', DB::raw('(select image from images where images.product_id = product.id limit 1) as image'), 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
        ->where('category.category_seo', $id)
        ->where('product.status', 'Y')
        ->where('product.parent_id', '0')
        ->where('product.price', '>=', $min_price)
        ->where($column, $condition, $value)
        ->groupBy('product.id')
        ->paginate(9);

        return $products;
    }

    public function title_1($seo){
        $category = DB::table('category')
        ->select('category.id', 'category_name','category_seo', 'category.parent_id')
        ->where('category.id', function ($query) use ($seo){
            $query->select('id')
                ->from('category')
                ->where('category_seo', $seo);
            })
        ->first();

        return $category;
    }

    public function title_2($seo){
        $category = DB::table('category')
        ->select('category.id', 'category_name','category_seo', 'category.parent_id')
        ->where('category.id', function ($query) use ($seo){
            $query->select('parent_id')
                ->from('category')
                ->where('category.category_seo', $seo);
            })
        ->first();

        return $category;
    }

    public function title_3($seo){
        $category = DB::table('product')
        ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
        ->join('category', 'product_to_category.category_id', '=', 'category.id')
        ->select('category.id', 'category_name','category_seo', 'category.parent_id', 'product_name')
        ->where('product.product_seo', $seo)
        ->first();

        return $category;
    }

    public function categoryList1(){
        $categories = DB::table('category')
        ->select('id', 'category_name','category_seo', 'category.parent_id')
        ->get();

        return $categories;
    }
    
    public function categoryList2(){   
        $data = DB::table('category')
        ->select('category_name', 'category_seo', 'id')
        ->where('parent_id', '=', 0)
        ->get();

        return $data;
    }

    public function categoryList3($id){
        $categories = DB::table('category')
        ->select('category.id', 'category_name','category_seo', 'category.parent_id')
        ->where('category.parent_id', $id)
        ->get();

        return $categories;
    }

    public function home(){
        $data = array();
        $data['title'] = 'Home - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['fashion_cat'] = $this->categoryList3(32);
        $data['fashion_seller'] = $this->productListLv1Filter(32, 'purchase_count', 'desc');
        $data['fashion_new'] = $this->productListLv1Filter(32, 'id', 'desc');
        $data['fashion_populer'] = $this->productListLv1Filter(32, 'viewed', 'desc');

        $data['elektronik_cat'] = $this->categoryList3(31);
        $data['elektronik_seller'] = $this->productListLv1Filter(31, 'purchase_count', 'desc');
        $data['elektronik_new'] = $this->productListLv1Filter(31, 'id', 'desc');
        $data['elektronik_populer'] = $this->productListLv1Filter(31, 'viewed', 'desc');

        return view('frontend.default.home')->with('data', $data);
    }

    public function category_1($seo){
        $data = array();
        $data['title'] = 'Home - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $seo_explode = explode('=', $seo);
        $seo_1 = $seo_explode[0];
        if(isset($seo_explode[1])){
            $price = explode('&', $seo_explode[1]);
            $min_price = $price[0];
            $max_price = $price[1];
        }else{
            $min_price = 0;
            $max_price = 'more';
        }

        $data['product'] = $this->productListLv1($seo_1, $min_price, $max_price);
        $data['title_1'] = $this->title_1($seo_1);
        $data['seo']     = $seo_1;
        return view('frontend.default.category_1')->with('data', $data);
    }

    public function category_2($seo_1, $seo){
        $data = array();
        $data['title'] = 'Home - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $seo_explode = explode('=', $seo);
        $seo_2 = $seo_explode[0];
        if(isset($seo_explode[1])){
            $price = explode('&', $seo_explode[1]);
            $min_price = $price[0];
            $max_price = $price[1];
        }else{
            $min_price = 0;
            $max_price = 'more';
        }

        $data['product']     = $this->productListLv2($seo_2, $min_price, $max_price);
        $data['title_1']     = $this->title_1($seo_1);
        $data['title_2']     = $this->title_1($seo_2);

        return view('frontend.default.category_2')->with('data', $data);
    }

    public function category_3($seo_1, $seo_2, $seo){
        $data = array();
        $data['title'] = 'Home - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $seo_explode = explode('=', $seo);
        $seo_3 = $seo_explode[0];
        if(isset($seo_explode[1])){
            $price = explode('&', $seo_explode[1]);
            $min_price = $price[0];
            $max_price = $price[1];
        }else{
            $min_price = 0;
            $max_price = 'more';
        }

        $data['product']     = $this->productListLv3($seo_3, $min_price, $max_price);
        $data['title_1']     = $this->title_1($seo_1);
        $data['title_2']     = $this->title_1($seo_2);
        $data['title_3']     = $this->title_1($seo_3);

        return view('frontend.default.category_3')->with('data', $data);
    }

    public function productDetail($seo){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['title_3'] = $this->title_3($seo);
        $data['title_2'] = $this->title_2($data['title_3']->category_seo);
        $data['title_1'] = $this->title_2($data['title_2']->category_seo);
        $data['stock'] = '-';
        
        DB::table('product')->where('product_seo', '=', $seo)->increment('viewed');
        $data['product']      = DB::table('product')
        ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
        ->select('product.id as product_id', 'product_name', 'product.quantity', 'price', DB::raw('(select image from images where images.product_id = product.id limit 1) as image'), 'sku', 'product_description', 'product_detail', 'product_spesification', 'product_seo', 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
        ->where('product_seo', '=', $seo)
        ->where('product.parent_id', '=', 0)
        ->first();
        $data['combination'] = DB::select("SELECT product_to_attribute.attribute_id, attribute.name as attribute_name, GROUP_CONCAT(distinct value_id SEPARATOR ',') AS value_id, GROUP_CONCAT(distinct attribute_value.value SEPARATOR ',') AS value_name FROM `product_to_attribute` 
            INNER JOIN product ON product_to_attribute.product_id = product.id
            INNER JOIN attribute ON product_to_attribute.attribute_id = attribute.id 
            INNER JOIN attribute_value ON product_to_attribute.value_id = attribute_value.id 
            WHERE parent_id = ? GROUP BY attribute_id",[$data['product']->product_id]);

        $data['images'] = DB::table('images')->select('image')->where('images.product_id', $data['product']->product_id)->get();

        if(!empty($data['combination'])){
            return view('frontend.default.detail_option')->with('data', $data);
        }else{
            return view('frontend.default.detail')->with('data', $data);
        }
    }

    public function signin(){  
        $data = array();
        $data['title'] = 'Login - Isacommerce Best Ecommerce Platform'; 
        $data['all_category'] = array("1"=>"Fashion", "2"=>"Electronic");
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        return view('frontend.default.signin')->with('data', $data);
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email|max:50',
            'password' => 'required|min:6|max:20',
            'firstname' => 'required|min:2|max:50',
            'lastname' => 'required|min:2|max:50',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $id = DB::table('users')->insertGetId(
            array(
                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'password'   => bcrypt($request->password),
                'email'      => $request->email,
                'is_confirm' => 'N'
                )
            ); 

            return back()->with('status', 'Registration has success, please check email to confirm your account.');
        }
    }

    public function processLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'login_email' => 'required|email|exists:users,email|max:50',
            'login_password' => 'required|min:6|max:20'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $userdata = array(
                'email'     => $request->login_email,
                'password'  => $request->login_password
            );
            if (Auth::attempt($userdata)){
                $users  = DB::table('users')->where('email', $request->login_email)->first();
                session(['user_id' => $users->id]);
                if(session()->has('id')){
                    return redirect('checkout/address');
                }else{
                    return redirect('users/profile');
                }
            }else{        
                return redirect('signin-signup');
            }
        }
    }

    public function signout(){  
        Auth::logout();
        session()->flush();
        return redirect('/signin-signup')->with('signout', 'You have successfully logout.');
    }


    public function usersProfile(){   
        $data = array();
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        return view('frontend.default.users_profile')->with('data', $data);
    }

     public function updateProfile(Request $request){
        $id=$request->user()->id;
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:3|max:50|regex:/^[a-zA-Z]+$/u',
            'lastname'  => 'required|min:3|max:50|regex:/^[a-zA-Z]+$/u',
            'email'     => 'required|email|unique:users,email,'.$id,
            'phone'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            if ($request->has('password')) {
                $password = bcrypt($request->password);
                DB::table('users')->where('id', $id)->update([
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'email'     => $request->email,
                    'phone'     => $request->phone,
                    'password'  => $password
                ]);
            }
            else{
                DB::table('users')->where('id', $id)->update([
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);
            }
            return back()->with('status', 'Profile was successfully updated!');
        }
    }

    public function usersShipping(){   
        $id = Auth::user()->id;
        $data = array();
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $data['country'] = DB::table('country')->get();
        $data['province'] = DB::table('province')->get();
        $data['address'] = DB::table('address')->where('user_id', '=', session('user_id'))->first();

        return view('frontend.default.users_address')->with('data', $data);
    }

    public function buy($seo){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $product = DB::table('product')->where('product_seo', '=', $seo)->first();
        $product_combination = DB::table('product')->where('parent_id', '=', $product->id)->get();
        if(count($product_combination)){
            return redirect('product/'.$seo);
        }else{
            $cart    = DB::table('cart')->where('product_id', '=', $product->id)->where('session_id', '=', session('id'))->first();
            $session_id = (session()->has('id') ? session('id') : session(['id' => rand(0,100).''.time()]));

            if(!empty($cart)){
                $quantity = $cart->quantity+1;
                DB::table('cart')->where('product_id', '=', $product->id)->where('session_id', '=', session('id'))->update([
                    'quantity'    => $quantity
                ]);
            }else{
                DB::table('cart')->insert([
                    'product_id'  => $product->id, 
                    'session_id'  => session('id'),
                    'quantity' => 1
                ]);
            }
            return redirect('cart');
        }
    }

     /*public function buyDetail(Request $request){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        
        $product = DB::table('product')->where('id', '=', $request->product_id)->first();
        if(!isset($product->quantity) || $product->quantity <= 0 || $request->product_id == 0){
            return back();
        }else{
            $cart    = DB::table('cart')->where('product_id', '=', $request->product_id)->where('session_id', '=', session('id'))->first();
            $session_id = (session()->has('id') ? session('id') : session(['id' => rand(0,100).''.time()]));

            if(!empty($cart)){
                $quantity = $cart->quantity+1;
                DB::table('cart')->where('product_id', '=', $product->id)->where('session_id', '=', session('id'))->update([
                    'quantity'    => $quantity
                ]);
            }else{
                DB::table('cart')->insert([
                    'product_id'  => $product->id, 
                    'session_id'  => session('id'),
                    'quantity' => 1
                ]);
            }
            return redirect('cart');
        }
    }*/

    /*public function buyDetail(Request $request){   
        $data['title']        = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $combination = $request->combination;
        $lenght      = count($combination);

        for($j=0; $j<$lenght; $j++){
            if(!empty($combination[$j])){
                $pieces           = explode("|", $combination[$j]);
                $attribute_id[$j] = $pieces[0];
                $value_id[$j]     = $pieces[1];
            }else{
                return back();
            }
        }*/

       /* $product = DB::select("SELECT product_id, COUNT(product_id) as count, attribute_id, value_id FROM `product_to_attribute` inner join product on product_to_attribute.product_id = product.id where product.parent_id = ? and attribute_id in (?) and value_id in (?) group by product_id ORDER BY `count` DESC LIMIT 1", [$request->parent_id, $attribute_id, $value_id]);*/
        /*$product = DB::table('product_to_attribute')
        ->join('product', 'product_to_attribute.product_id', '=', 'product.id')
        ->select('product_id', DB::raw('count(product_id) as count'), 'attribute_id', 'value_id')
        ->where('product.parent_id', $request->parent_id)
        ->whereIn('attribute_id', $attribute_id)
        ->whereIn('value_id', $value_id)
        ->groupBy('product_id')
        ->orderBy('count', 'desc')
        ->first();

        if($product->count != $lenght){
            $data['stock'] = 'Out Of Stock';
            return back()->with('data', $data);
        }else{
            $cart    = DB::table('cart')->where('product_id', '=', $product->product_id)->where('session_id', '=', session('id'))->first();
            $session_id = (session()->has('id') ? session('id') : session(['id' => rand(0,100).''.time()]));

            if(!empty($cart)){
                $quantity = $cart->quantity+1;
                DB::table('cart')->where('product_id', '=', $product->product_id)->where('session_id', '=', session('id'))->update([
                    'quantity'    => $quantity
                ]);
            }else{
                DB::table('cart')->insert([
                    'product_id'  => $product->product_id, 
                    'session_id'  => session('id'),
                    'quantity' => 1
                ]);
            }
            return redirect('cart');
        }
    }*/

    public function cart(){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $data['cart'] = DB::table('cart')
        ->join('product', 'cart.product_id', '=', 'product.id')
        ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
        ->select('cart.id as cart_id', 'cart.quantity', 'product_name', 'sku', 'status', 'price', 'cart.product_id',
            DB::raw('(select image from images where images.product_id = product.id or images.product_id = product.parent_id limit 1) as image'), 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
        ->where('session_id', '=', session('id'))
        ->get();

        $data['value_pair'] = DB::table('cart')
        ->join('product', 'cart.product_id', '=', 'product.id')
        ->join('product_to_attribute', 'product.id', '=', 'product_to_attribute.product_id')
        ->join('attribute', 'product_to_attribute.attribute_id', '=', 'attribute.id')
        ->join('attribute_value', 'product_to_attribute.value_id', '=', 'attribute_value.id')
        ->select('product_to_attribute.product_id', 'attribute.name as attribute_name', 'attribute_value.value as value_name')
        ->where('session_id', '=', session('id'))
        ->get();

        return view('frontend.default.cart')->with('data', $data);
    }

    public function cartDelete($id){   
        DB::table('cart')->where('id', '=', $id)->delete();

        return back();
    }

    public function updateUserCart(Request $request){
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $i = $request->i;
            $quantity = $request->quantity;
            $cart = $request->cart;
            for($j=0; $j<=$i; $j++){
                DB::table('cart')->where('id', $cart[$j])->update([
                    'quantity' => $quantity[$j],
                    'user_id'  => session('user_id'),
                ]);
            }
            if(session()->has('user_id')){
                return redirect('checkout/address');
            }else{
                return redirect('checkout/signin');
            }
        }
    }

    public function chkoutSignin(){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $data['country'] = DB::table('country')->get();
        $data['province'] = DB::table('province')->get();

        return view('frontend.default.checkout_signin')->with('data', $data);
    }

    public function chkoutGuest(Request $request){   
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:3|max:50',
            'lastname' => 'required|min:3|max:50',
            'email'    => 'required|email',
            'phone'    => 'required|min:3|max:50'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
            $data['all_category'] = $this->categoryList2();
            $data['category']     = $this->categoryList1();
            $data['cart']         = $this->getCart();

            session(['firstname'    => $request->firstname ]);
            session(['lastname'    => $request->lastname ]);
            session(['email'       => $request->email ]);
            session(['phone'       => $request->phone ]);

            return redirect('checkout/address');
        }
    }

    public function chkoutAddress(){   
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();
        $data['country'] = DB::table('country')->get();
        $data['province'] = DB::table('province')->get();
        $data['address'] = DB::table('address')->where('user_id', '=', session('user_id'))->first();

        return view('frontend.default.checkout_address')->with('data', $data);
    }

    public function updateAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'city'      => 'required|min:3|max:50',
            'address'   => 'required|min:3|max:50',
            'postcode'  => 'required|min:3|max:50'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            session(['country_id'  => $request->state ]);
            session(['province_id' => $request->province ]);
            session(['city'        => $request->city ]);
            session(['address'     => $request->address ]);
            session(['postcode'    => $request->postcode ]);
            if($request->address_id != null){
                DB::table('address')->where('id', $request->address_id)->update([
                   'country_id'  => $request->state,
                   'province_id' => $request->province,
                   'city'        => $request->city,
                   'address'     => $request->address,
                   'postcode'    => $request->postcode
                ]);
            }else{
                if(session()->has('user_id')){
                    DB::table('address')->insert([
                       'user_id'     => session('user_id'),
                       'country_id'  => $request->state,
                       'province_id' => $request->province,
                       'city'        => $request->city,
                       'address'     => $request->address,
                       'postcode'    => $request->postcode
                    ]);
                }
            }
        }
       return redirect('summary');
    }

    public function updateShipping(Request $request){
        $validator = Validator::make($request->all(), [
            'city'      => 'required|min:3|max:50',
            'address'   => 'required|min:3|max:50',
            'postcode'  => 'required|min:3|max:50'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        else{
            if($request->address_id != null){
                DB::table('address')->where('id', $request->address_id)->update([
                    'country_id'  => $request->state,
                    'province_id' => $request->province,
                    'city'        => $request->city,
                    'address'     => $request->address,
                    'postcode'    => $request->postcode
                ]);
            }else{
                DB::table('address')->insert([
                    'country_id'  => $request->state,
                    'province_id' => $request->province,
                    'city'        => $request->city,
                    'address'     => $request->address,
                    'postcode'    => $request->postcode,
                    'user_id'     => session('user_id')
                ]);
            }
            
            return back()->with('status', 'Shipping address was successfully updated!');
        }
    }


    public function chkSummary(){
        if(session()->has('id')){
            $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
            $data['all_category'] = $this->categoryList2();
            $data['category']     = $this->categoryList1();
            $data['cart']         = $this->getCart();

            $data['cart'] = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->select('cart.session_id', 'product_name', 'sku', 'status', 'price', 'cart.quantity', 'cart.id as cart_id',  'discount.is_active', 'discount_operation', 'discount_amount', 'expiry', DB::raw('(select image from images where images.product_id = product.id or images.product_id = product.parent_id limit 1) as image'))
            ->where('session_id', '=', session('id'))
            ->get();

            return view('frontend.default.checkout_payment')->with('data', $data);
        }else{
            return redirect('/');
        }
       
    }

    public function chkPayment(Request $request){   
        if(session()->has('id')){
            $chars = "123456789ABCDEFGHIJKLMN0PQRSTUVWXYZ";
            $invoice_no = "";
            for ($i = 0; $i < 10; $i++) {
                $invoice_no .= $chars[mt_rand(0, strlen($chars)-1)];
            }

            if(session()->has('invoice_no')){
                $gross_amount = $this->chkPaymentUpdate($request->all());
                return app('App\Http\Controllers\VtwebController')->vtweb(session('invoice_no'), $gross_amount);
            }

            if(session()->has('user_id')){
                $user     = DB::table('users')->where('id', '=', session('user_id'))->first();
                $order_id = DB::table('order')->insertGetId([
                    'invoice_no'  => $invoice_no, 
                    'user_id'     => session('user_id'), 
                    'firstname'   => $user->firstname,
                    'lastname'    => $user->lastname, 
                    'email'       => $user->email, 
                    'phone'       => $user->phone,
                    'address'     => session('address'), 
                    'city'        => session('city'), 
                    'postcode'    => session('postcode'),
                    'country_id'  => session('country_id'), 
                    'province_id' => session('province_id'), 
                    'comment'     => '',
                    'order_status_id' => '1', 
                ]);
            }else{
                $order_id = DB::table('order')->insertGetId([
                    'invoice_no'  => $invoice_no, 
                    'user_id'     => session('user_id'), 
                    'firstname'   => session('firstname'), 
                    'lastname'    => session('lastname'),  
                    'email'       => session('email'),  
                    'phone'       => session('phone'), 
                    'address'     => session('address'), 
                    'city'        => session('city'), 
                    'postcode'    => session('postcode'),
                    'country_id'  => session('country_id'), 
                    'province_id' => session('province_id'), 
                    'comment'     => '',
                    'order_status_id' => '1', 
                ]);
            }  

            session(['invoice_no' => $invoice_no]);
            $cart = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->select('product.id as product_id', 'product_name', 'sku', 'status', 'price', 'cart.quantity', 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
            ->where('session_id', '=', session('id'))
            ->get();

            $grand_total = 0;
            foreach ($cart as $cr) {
                $date = date('Y-m-d 00:00:00');
                if(!empty($cr->discount_amount ) && ($cr->discount_amount !=0 ) && ($cr->is_active == 'Y') && ($cr->expiry >= $date )){
                    if($cr->discount_operation == '-'){
                        $price = $cr->price - $cr->discount_amount;
                    }elseif($cr->discount_operation == '%'){
                        $price = $cr->price - ($cr->price*$cr->discount_amount/100);
                    }elseif($cr->discount_operation == 's'){
                        $price = $cr->discount_amount;
                    }
                }else{
                    $price = $cr->price;
                }
                DB::table('order_product')->insert([
                    'order_id'     => $order_id, 
                    'product_id'   => $cr->product_id, 
                    'product_name' => $cr->product_name,
                    'quantity'     => $cr->quantity, 
                    'price'        => $price, 
                    'total'        => $cr->quantity*$price
                ]);
                $grand_total = $grand_total + ($cr->quantity*$price);

                $product = DB::table('product')->where('id', '=', $cr->product_id)->first();
                $new_qty = $product->quantity - $cr->quantity;
                DB::table('product')->where('id', $cr->product_id)->update([
                    'quantity' => $new_qty
                ]);
        }
        DB::table('order')->where('id', $order_id)->update([
            'total' => $grand_total + (0.1*$grand_total),
        ]);

        $tax = 0.1*$grand_total;
        $gross_amount = $grand_total + $tax;

        //session()->forget('id'); // move to paymet success change to upsert
        //return redirect('payment/success');
        return app('App\Http\Controllers\VtwebController')->vtweb($invoice_no, $gross_amount);
        echo $price;
        }else{
            return redirect('/');
        }
    }

     public function chkPaymentUpdate($data){   
        if(session()->has('user_id')){
            $user     = DB::table('users')->where('id', '=', session('user_id'))->first();
            DB::table('order')->where('invoice_no', session('invoice_no'))->update([
               'user_id'     => session('user_id'), 
               'firstname'   => $user->firstname,
               'lastname'    => $user->lastname, 
               'email'       => $user->email, 
               'phone'       => $user->phone,
               'address'     => session('address'), 
               'city'        => session('city'), 
               'postcode'    => session('postcode'),
               'country_id'  => session('country_id'), 
               'province_id' => session('province_id'), 
               'comment'     => '',
               'order_status_id' => '1', 
            ]);
        }else{
            DB::table('order')->where('invoice_no', session('invoice_no'))->update([
                'user_id'     => session('user_id'), 
                'firstname'   => session('firstname'), 
                'lastname'    => session('lastname'),  
                'email'       => session('email'),  
                'phone'       => session('phone'), 
                'address'     => session('address'), 
                'city'        => session('city'), 
                'postcode'    => session('postcode'),
                'country_id'  => session('country_id'), 
                'province_id' => session('province_id'), 
                'comment'     => '',
                'order_status_id' => '1', 
            ]);
        }  

        $order = DB::table('order')->where('invoice_no', '=', session('invoice_no'))->first();
        $order_product = app('db')->table('order_product')->where('order_id', '=', $order->id)->get();
        foreach($order_product as $o) {
            $product = DB::table('product')->where('id', '=', $o->product_id)->first();
            $new_qty = $product->quantity + $o->quantity;
            DB::table('product')->where('id', $o->product_id)->update([
                'quantity' => $new_qty
            ]);
        }
        DB::table('order_product')->where('order_id', '=', $order->id)->delete();
        $cart = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->select('product.id as product_id', 'product_name', 'sku', 'status', 'price', 'cart.quantity', 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
            ->where('session_id', '=', session('id'))
            ->get();

        $grand_total = 0;
        foreach ($cart as $cr) {
            $date = date('Y-m-d 00:00:00');
            if(!empty($cr->discount_amount ) && ($cr->discount_amount !=0 ) && ($cr->is_active == 'Y') && ($cr->expiry >= $date )){
                if($cr->discount_operation == '-'){
                    $price = $cr->price - $cr->discount_amount;
                }elseif($cr->discount_operation == '%'){
                    $price = $cr->price - ($cr->price*$cr->discount_amount/100);
                }elseif($cr->discount_operation == 's'){
                    $price = $cr->discount_amount;
                }
            }else{
                $price = $cr->price;
            }
            DB::table('order_product')->insert([
                'order_id'     => $order->id, 
                'product_id'   => $cr->product_id, 
                'product_name' => $cr->product_name,
                'quantity'     => $cr->quantity, 
                'price'        => $price, 
                'total'        => $cr->quantity*$price
            ]);

            $grand_total = $grand_total + ($cr->quantity*$price);

            $product = DB::table('product')->where('id', '=', $cr->product_id)->first();
            $new_qty = $product->quantity - $cr->quantity;
            DB::table('product')->where('id', $cr->product_id)->update([
                'quantity' => $new_qty
            ]);
        }
        DB::table('order')->where('id',  $order->id)->update([
            'total' => $grand_total + (0.1*$grand_total),
        ]);

        $tax = 0.1*$grand_total;
        $gross_amount = $grand_total + $tax;
        return $gross_amount;
    }

    public function successPayment($id){
        session()->forget('id');
        session()->forget('invoice_no');
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['message'] = app('App\Http\Controllers\VtwebController')->notification();
        $this->shoppingSummary($id);
        return view('frontend.default.checkout_payment_success')->with('data', $data);
    }

    public function shoppingSummary($id){
        $data['order'] = DB::table('order')
        ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
        ->join('province', 'order.province_id', '=', 'province.id')
        ->join('country', 'order.country_id', '=', 'country.id')
        ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'order.id', 'email', 'order.order_status_id', 'address', 'city', 'postcode', 'province.name as province', 'country.name as country')
        ->where('order.invoice_no', $id)
        ->first();

        $data['detail'] = DB::table('order_product')
        ->where('order_id', function ($query) use ($id){
            $query->select('id')
                ->from('order')
                ->where('invoice_no', $id);
            })
        ->get();

        $emailcontent = array (
            'title'  => "IsaCommerce",
            'data'   => $data,
            'email'  => $data['order']->email
        );

        Mail::send('email.shopping_summary', $emailcontent, function($message) use ($emailcontent){
            $message->to($emailcontent['email'], 'Invoice')->subject('Invoice');
        });
    }

    public function usersWishlist(){
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['wishlist'] = DB::table('wishlist')
        ->join('product', 'wishlist.product_id', '=', 'product.id')
        ->select('wishlist.id', 'product.product_seo', 'product.product_name', 'product.price', 'wishlist.created_at', DB::raw('(select image from images where images.product_id = product.id or images.product_id = product.parent_id limit 1) as image'))
        ->where('user_id', '=', session('user_id'))->get();

        return view('frontend.default.users_wishlist')->with('data', $data);
    }

    public function deleteWishlist($id){
        DB::table('wishlist')->where('id', $id)->delete();
        return back();
    }

    public function usersOrder(){
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['order'] = DB::table('order')
            ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
            ->select('invoice_no', 'address', 'city', 'postcode', 'total', 'order_status.name', 'order.created_at')
            ->where('user_id', '=', session('user_id'))
            ->get();

        return view('frontend.default.users_order_history')->with('data', $data);
    }

    public function usersOrderDetail($id){
        $data['title'] = 'Profile - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $data['order'] = DB::table('order')
        ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
        ->join('province', 'order.province_id', '=', 'province.id')
        ->join('country', 'order.country_id', '=', 'country.id')
        ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'order.id', 'email', 'order.order_status_id', 'address', 'city', 'postcode', 'province.name as province', 'country.name as country')
        ->where('order.invoice_no', $id)
        ->first();

        $data['detail'] = DB::table('order_product')
        ->where('order_id', function ($query) use ($id){
            $query->select('id')
                ->from('order')
                ->where('invoice_no', $id);
            })
        ->get();

        if(empty($data['order'])){
            return redirect('/users/orders');
        }

        return view('frontend.default.users_order_history_detail')->with('data', $data);
    }

    public function getCart(){
        if(session()->has('id')){
            $data = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('cart.session_id', 'product_name', 'sku', 'status', 'price', 'cart.quantity', 'cart.id as cart_id', 
                DB::raw('(select image from images where images.product_id = product.id or images.product_id = product.parent_id limit 1) as image'))
            ->where('session_id', '=', session('id'))
            ->get();

            return $data;
        }else{
            return 0;
        }
    }

    public function productSearch($key="all&", $price="0&more"){  
        $data['title'] = 'Home - Isacommerce Best Ecommerce Platform';
        $data['all_category'] = $this->categoryList2();
        $data['category']     = $this->categoryList1();
        $data['cart']         = $this->getCart();

        $key_explode = explode('&', $key);
        $data['category_seo'] = $key_explode[0];
        $data['keyword']      = $key_explode[1];

        $price_explode = explode('&', $price);
        $data['min_price'] = $price_explode[0];
        $data['max_price'] = $price_explode[1];

        if($data['max_price'] == "more"){
            $column = 'product.price';
            $condition = '>=';
            $value = '1';
        }else{
            $column = 'product.price';
            $condition = '<=';
            $value = $data['max_price'];
        }

        if($data['category_seo'] == 'all'){
            $data['product'] = DB::table('product')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->select('product.id', 'product.product_name', 'product.product_seo', 'product.price', 'product.viewed', 'product.purchase_count', 
                DB::raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->where('product_name', 'like', '%'. $data['keyword'] .'%')
            ->where('product.price', '>=', $data['min_price'])
            ->where($column, $condition, $value)
            ->distinct()
            ->paginate(9);
        }else{
            $category = DB::table('category')->select('id')->where('category_seo', $data['category_seo'])->first();
            $category_id = $category->id;
            $data['product'] = DB::table('product')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->select('product.id', 'product.product_name', 'product.product_seo', 'product.price', 'product.viewed', 'product.purchase_count',
                DB::raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->whereIn('category.parent_id', function ($query) use ($category_id){
                $query->select('id')
                      ->from('category')
                      ->where('category.parent_id', $category_id);
                })
            ->where('product_name', 'like', '%'. $data['keyword'] .'%')
            ->where('product.price', '>=', $data['min_price'])
            ->where($column, $condition, $value)
            ->distinct()
            ->paginate(9);
        }
        
        return view('frontend.default.category_search')->with('data', $data);
    }
}
