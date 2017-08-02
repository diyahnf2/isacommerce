<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Veritrans\Veritrans;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
        $this->middleware('oauth');
        $this->middleware('oauth-user');
    }

    public function sendEmail($emailcontent){
        Mail::send($emailcontent['view'], $emailcontent, function($message) use ($emailcontent){
            $message->to($emailcontent['email'], $emailcontent['subject'])->subject($emailcontent['subject']);
        });
    }

    public function testEmail(){
        $id =5;
        $emailcontent = array (
            'title'         => "isacommerce",
            'id_user'       => Crypt::encrypt($id),
            'f_name'        => 'name',
            'l_name'        => 'name',
            'subject'       => 'Email Confirm',
            'email'         => 'diyahnf@gmail.com',
            'view'          => 'email.register'
        );

        $this->sendEmail($emailcontent);
    }

    public function cronjob_2(){
        $date = date('Y-m-d H:i:s');
        $newdate_1 = date('Y-m-d 00:00:00', strtotime('-3 days', strtotime($date)));
        $newdate_2 = date('Y-m-d 23:59:59', strtotime('-3 days', strtotime($date))); 
        $email = app('db')->table('withdrawal')
        ->join('customer', 'withdrawal.id_user', '=', 'customer.id')
        ->select('customer.id as id_user','email', 'fullname', 'withdrawal.created_at', 'bank_name', 'bank_account_number', 'recipient_name', 'amount')
        ->whereBetween('withdrawal.created_at', [$newdate_1, $newdate_2])
        ->get();

        if($email){
            $emailcontent = array (
                'detail' => $email
            );
            Mail::send('email.withdrawal', $emailcontent, function($message){
                $message->to('diyahnf@gmail.com', 'Withdrawal')->subject('[Featours] - Withdrawal');
            });
        }
    }


    public function allProduct(){
        try{
            $product = app('db')->TABLE('product')->GET();
            return response()->json(['status' => 'success','data' => $product]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

     public function register(Request $request){
        $rules = array(
            'email'            => 'required|email|unique:users,email|max:50',
            'password'         => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
            'firstname'        => 'required|min:2|max:50',
            'lastname'         => 'required|min:2|max:50',
            'isagree'          => 'required|boolean'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                $password = password_hash($request->password, PASSWORD_BCRYPT);
                $id = app('db')->TABLE('users')->insertGetId(
                    array(
                        'email'          => $request->email,
                        'password'       => $password, 
                        'firstname'      => $request->firstname,
                        'lastname'       => $request->lastname,
                        'is_confirm'     => 'N'
                    )
                );

                 $emailcontent = array (
                    'title'         => "isacommerce",
                    'id_user'       => Crypt::encrypt($id),
                    'f_name'        => $request->firstname,
                    'l_name'        => $request->lastname,
                    'subject'       => 'Email Confirm',
                    'email'         => $request->email,
                    'view'          => 'email.register'
                );

                $this->sendEmail($emailcontent);

                return response()->json(['status' => 'success', 'data' => array('id_user' => $id)], 200);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function loginUser(Request $request){
        $rules = array(
            'email'         => 'required|email|max:50',
            'password'      => 'required|min:6|max:20',
            'type_device'   => 'required',
        );

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = date('Y-m-d H:i:s');
            $user = app('db')->table('users')->where('email', '=', $request->email)->first();

            if (count($user) && password_verify($request->password, $user->password)){ 
                if($user->is_confirm != 'Y'){
                    return response()->json(['status' => 'failed','message' => 'Please confirm your email address to finish signing up!']);
                }

                try{
                    $other_login = app('db')->TABLE('users')->WHERE('id_device', '=', $request->id_device)->FIRST();
                    if(!empty($other_login)){
                        app('db')->TABLE('users')->WHERE('id', $other_login->id)->UPDATE(array('id_device' => ''));
                    }

                    $id = app('db')->TABLE('users')->WHERE('id', $user->id)->UPDATE(
                    array(
                        'last_login'  => $date, 
                        'id_device'   => $request->id_device, 
                        'type_device' => $request->type_device
                        )
                    );

                    $mobile = ($user->phone == null ? '' : $user->phone);

                    $data = array();
                    $data['id_user']              = $user->id;
                    $data['firstname']            = $user->firstname;
                    $data['lastname']             = $user->lastname;
                    $data['email']                = $user->email;
                    $data['mobile']               = $mobile;

                    return response()->json(['status' => 'success','data' => $data]);
                }

                catch(\Exception $e){
                    return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
                }
            }
            else{
                return response()->json(['status' => 'failed','message' => 'Incorrect email or password. Please try again.']);
            }
        }
    }

    public function productListLv1Filter($orderby_1, $orderby_2){   
        $products = app('db')->table('product')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->select('product.id as id_product', 'product.product_name', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', 
                app('db')->raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->where('product.status', 'Y')
            ->orderBy($orderby_1, $orderby_2)
            ->take(12)
            ->get();
        return $products;
    }

    public function filterSeller(){   
        $data = array();
        try{
            $product = $this->productListLv1Filter('purchase_count', 'desc');
            $m = 0;
            foreach ($product as $p) {
                $data[$m]['id_product']    = $p->id_product;
                $data[$m]['product_name']  = $p->product_name;
                $data[$m]['product_seo']  = $p->product_seo;
                $data[$m]['price']  = $p->price;
                $data[$m]['category_name']  = $p->category_name;
                $data[$m]['thumb'] = 'http://isacommerce.idesolusiasia.com/theme/backend/images/product/'.$p->image;
                $m++;
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function filterNew(){   
        $data = array();
        try{
            $product = $this->productListLv1Filter('id', 'desc');
            $m = 0;
            foreach ($product as $p) {
                $data[$m]['id']    = $p->id;
                $data[$m]['product_name']  = $p->product_name;
                $data[$m]['product_seo']  = $p->product_seo;
                $data[$m]['price']  = $p->price;
                $data[$m]['category_name']  = $p->category_name;
                $data[$m]['thumb'] = 'http://isacommerce.idesolusiasia.com/theme/backend/images/product/'.$p->image;
                $m++;
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function filterPopular(){   
        $data = array();
        try{
            $product = $this->productListLv1Filter('viewed', 'desc');
            $m = 0;
            foreach ($product as $p) {
                $data[$m]['id']    = $p->id;
                $data[$m]['product_name']  = $p->product_name;
                $data[$m]['product_seo']  = $p->product_seo;
                $data[$m]['price']  = $p->price;
                $data[$m]['category_name']  = $p->category_name;
                $data[$m]['thumb'] = 'http://isacommerce.idesolusiasia.com/theme/backend/images/product/'.$p->image;
                $m++;
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function productDetail($id){ 
        $data = array();
        try{  
            $product= app('db')->table('product')
            ->select('id as id_product', 'product_name', 'price', app('db')->raw('(select image from images where images.product_id = product.id limit 1) as image'), 'sku', 'product_description','quantity')
            ->where('id', '=', $id)
            ->first();

            $data['id_product']    = $product->id_product;
            $data['product_name']  = $product->product_name;
            $data['quantity']  = $product->quantity;
            $data['price']  = $product->price;
            $data['sku']  = $product->sku;
            $data['product_description']  = $product->product_description;
            $data['thumb'] = 'http://isacommerce.idesolusiasia.com/theme/backend/images/product/'.$product->image;

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }        
    }

    public function usersProfile($id){ 
        $data = array();
        try{  
            $user= app('db')->table('users')
            ->select('firstname', 'lastname', 'email', 'phone')
            ->where('id', '=', $id)
            ->first();

            return response()->json(['status' => 'success','data' => $user]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function updateProfile(Request $request){
        $id=$request->id_user;
        $v = Validator::make($request->all(), [
            'id_user'   => 'required',
            'firstname' => 'required|min:3|max:50',
            'lastname'  => 'required|min:3|max:50',
            'email'     => 'required|email|unique:users,email,'.$id
        ]);

        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $phone = ($request->has('phone') ? $request->phone : '');
            if ($request->has('password')) {
                $password = password_hash($request->password, PASSWORD_BCRYPT);
                app('db')->table('users')->where('id', $request->id_user)->update([
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'email'     => $request->email,
                    'phone'     => $request->phone,
                    'password'  => $password
                ]);
            }
            else{
                app('db')->table('users')->where('id', $request->id_user)->update([
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'email'     => $request->email,
                    'phone'     => $phone
                ]);
            }

            return response()->json(['status' => 'success', 'message' => 'Profile was successfully updated!']);
        }
    }

    public function usersShipping($id){ 
        $data = array();
        try{  
            $user= app('db')->table('address')
            ->join('country', 'address.country_id', '=', 'country.id')
            ->select('address.id as id_address', 'address', 'city', 'postcode', app('db')->raw('(select name from province where province.country_id = country.id limit 1) as province'), 'country.name as country')
            ->where('user_id', '=', $id)
            ->first();

            return response()->json(['status' => 'success','data' => $user]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function updateShipping(Request $request){
        $v = Validator::make($request->all(), [
            'id_user'     => 'required',
            'city'        => 'required|min:3|max:50',
            'address'     => 'required|min:3|max:50',
            'postcode'    => 'required|min:3|max:50',
            'id_country'  => 'required',
            'id_province' => 'required'
        ]);
         if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            if ($request->has('id_address')){
                app('db')->table('address')->where('id', $request->id_address)->update([
                    'country_id'  => $request->id_country,
                    'province_id' => $request->id_province,
                    'city'        => $request->city,
                    'address'     => $request->address,
                    'postcode'    => $request->postcode
                ]);
            }else{
                app('db')->table('address')->insert([
                    'country_id'  => $request->id_country,
                    'province_id' => $request->id_province,
                    'city'        => $request->city,
                    'address'     => $request->address,
                    'postcode'    => $request->postcode,
                    'user_id'     => $request->id_user
                ]);
            }
            
            return response()->json(['status' => 'success', 'message' => 'Shipping was successfully updated!']);
        }
    }

    public function usersOrder($id){ 
        $data = array();
        try{  
           $data = app('db')->table('order')
            ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
            ->select('invoice_no', 'address', 'city', 'postcode', 'total', 'order_status.name', 'order.created_at')
            ->where('user_id', '=', $id)
            ->get();

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function usersOrderDetail($id){
        $data = array();
        try{  
            $data['order'] = app('db')->table('order')
            ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
            ->join('province', 'order.province_id', '=', 'province.id')
            ->join('country', 'order.country_id', '=', 'country.id')
            ->select('invoice_no', 'firstname', 'lastname', 'total', 'order_status.name as status', 'order.created_at', 'email', 'order.order_status_id', 'address', 'city', 'postcode', 'province.name as province', 'country.name as country')
            ->where('order.invoice_no', $id)
            ->first();

            $data['detail'] = app('db')->table('order_product')
            ->select('product_id', 'product_name', 'quantity', 'price', 'total')
            ->where('order_id', function ($query) use ($id){
                $query->select('id')
                    ->from('order')
                    ->where('invoice_no', $id);
                })
            ->get();

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function allCategory(){ 
        $data = array();
        try{  
            $data = app('db')->table('category')
            ->select('id as id_category', 'category_name','category_seo', 'category.parent_id')
            ->get();

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }


    public function productbyCategory($level, $id){ 
        $data = array();
        try{  
            if($level == 1){
                $data = $this->productListLv1($id);
            }elseif($level == 2){
                $data = $this->productListLv2($id);
            }elseif($level == 3){
                $data = $this->productListLv3($id);
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function productListLv1($id){   
        $products = app('db')->table('product')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->select('product.id as product_id', 'product.product_name', 'product.product_seo', 'product.price', 'category.category_name', 'product.viewed', 'product.purchase_count', 'category.parent_id', app('db')->raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->whereIn('category.parent_id', function ($query) use ($id){
                $query->select('id')
                      ->from('category')
                      ->where('category.parent_id', $id);
                    }
                )
            ->where('product.status', 'Y')
            ->get();
        return $products;
    }

    public function productListLv2($id){   
        $products = app('db')->table('product')
        ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
        ->join('category', 'product_to_category.category_id', '=', 'category.id')
        ->join('images', 'product.id', '=', 'images.product_id')
        ->select('product.id as product_id', 'product.product_name', 'product.product_seo', 'product.price', 'product.viewed', 'product.purchase_count', 'category.category_name', 'category.category_seo', 'category.parent_id', 'images.image')
        ->where('product.status', 'Y')
        ->where('category.parent_id', $id)
        ->get();

        return $products;
    }

    public function productListLv3($id){   
        $products = app('db')->table('product')
        ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
        ->join('category', 'product_to_category.category_id', '=', 'category.id')
        ->join('images', 'product.id', '=', 'images.product_id')
        ->select('product.id as product_id', 'product.product_name', 'product.product_seo', 'product.price', 'product.viewed', 'product.purchase_count', 'category.category_name', 'category.category_seo' ,'category.parent_id', 'images.image')
        ->where('category.id', $id)
        ->where('product.status', 'Y')
        ->get();

        return $products;
    }

    public function addtoCart(Request $request){   
         $rules = array(
            'id_user'    => 'required',
            'id_product' => 'required',
            'id_session' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                app('db')->table('cart')->insert([
                    'product_id' => $request->id_product, 
                    'user_id'    => $request->id_user, 
                    'session_id' => $request->id_session,
                    'quantity'   => 1
                ]);
                return response()->json(['status' => 'success', 'message' => 'Item successfully added'], 200);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function getCart($id){ 
        $data = array();
        try{  
            $data = app('db')->table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->select('cart.id as id_cart', 'cart.quantity', 'product_name', 'sku', 'price', 
                app('db')->raw('(select image from images where images.product_id = product.id limit 1) as image'))
            ->where('session_id', '=', $id)
            ->get();

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        } 
    }

    public function updateCart(Request $request){   
         $rules = array(
            'id_cart'  => 'required',
            'quantity' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                $id_user = ($request->has('id_user') ? $request->id_user : '');
                $quantity = $request->quantity;
                $id_cart = $request->id_cart;
                $i = count($id_cart);
                for($j=0; $j<$i; $j++){
                    app('db')->table('cart')->where('id', $id_cart[$j])->update([
                        'quantity' => $quantity[$j],
                        'user_id'  => $id_user
                    ]);
                }
                return response()->json(['status' => 'success', 'message' => 'Cart successfully updated'], 200);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function paymentCreate(Request $request){   
         $rules = array(
            'firstname'    => 'required|min:2|max:50',
            'lastname'     => 'required|min:2|max:50',
            'email'        => 'required|email|unique:users,email|max:50',
            'phone'        => 'required',
            'address'      => 'required',
            'city'         => 'required',
            'postcode'     => 'required',
            'id_country'   => 'required',
            'id_province'  => 'required',
            'id_session'   => 'required'

        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                $id_user = ($request->has('id_user') ? $request->id_user : '');
                $chars = "123456789ABCDEFGHIJKLMN0PQRSTUVWXYZ";
                $data['invoice_no'] = "";
                for ($i = 0; $i < 10; $i++) {
                    $data['invoice_no'] .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                $order_id = app('db')->table('order')->insertGetId([
                    'invoice_no'  => $data['invoice_no'] , 
                    'user_id'     => $id_user, 
                    'firstname'   => $request->firstname,
                    'lastname'    => $request->lastname, 
                    'email'       => $request->email, 
                    'phone'       => $request->phone,
                    'address'     => $request->address, 
                    'city'        => $request->city, 
                    'postcode'    => $request->postcode,
                    'country_id'  => $request->id_country, 
                    'province_id' => $request->id_province, 
                    'comment'     => '',
                    'order_status_id' => '1', 
                ]);

                $cart = app('db')->table('cart')
                ->join('product', 'cart.product_id', '=', 'product.id')
                ->select('product.id as product_id', 'product_name', 'sku', 'status', 'price', 'cart.quantity')
                ->where('session_id', '=', $request->id_session)
                ->get();

                $data['grand_total'] = 0;
                foreach ($cart as $cr) {
                    app('db')->table('order_product')->insert([
                        'order_id'     => $order_id, 
                        'product_id'   => $cr->product_id, 
                        'product_name' => $cr->product_name,
                        'quantity'     => $cr->quantity, 
                        'price'        => $cr->price, 
                        'total'        => $cr->quantity*$cr->price
                    ]);
                    $data['grand_total'] = $data['grand_total'] + ($cr->quantity*$cr->price);

                    $product = app('db')->table('product')->where('id', '=', $cr->product_id)->first();
                    $new_qty = $product->quantity - $cr->quantity;
                    app('db')->table('product')->where('id', $cr->product_id)->update([
                        'quantity' => $new_qty
                    ]);
                }
                app('db')->table('order')->where('id', $order_id)->update([
                    'total' => $data['grand_total']
                ]);

                return response()->json(['status' => 'success', 'data' => $data], 200);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function paymentCancel($id){  // minus testing
        try{
            $order_product = app('db')->table('order_product')->where('order_id', '=', $id)->get();
            foreach($order_product as $o) {
                $product = app('db')->table('product')->where('id', '=', $o->product_id)->first();
                $new_qty = $product->quantity + $o->quantity;
                app('db')->table('product')->where('id', $o->product_id)->update([
                    'quantity' => $new_qty
                ]);
            }
            $order = app('db')->table('order')->where('id', '=', $id)->delete();
            app('db')->table('order_product')->where('order_id', '=', $id)->delete();

            return response()->json(['status' => 'success', 'message' =>  'Order has successfully deleted'], 200);
        }
        catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

}
