<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Crypt;
//use Request;

class AjaxController extends Controller
{

    public function getProvince($id)
    {
        $cities = DB::table("province")->where("country_id",$id)->lists("name","id");
        return json_encode($cities);
    }

    public function getAttrValues($id)
    {
        $cities = DB::table("attribute_value")->where("attribute_id",$id)->lists("value","id");
        return json_encode($cities);
    }

    public function showPosts()
    {
        $posts = DB::table('product')->paginate(5);
        return view('blog')->with('posts', $posts);
    }

    public function paginate()
    {
        $posts = DB::table('product')->paginate(5);
        return response()->json(view('posts')->with('posts', $posts)->render());
    }

    public function wishlistCreate($id)
    {
        if(session('user_id') == null){
            $data = 0;
        }else{
            try{
                DB::table('wishlist')->insert([
                    'user_id'     => session('user_id'),
                    'product_id'  => $id
                ]);
                $data = 1;
            }catch(\Exception $e){
                $data = 500;
            }
        }
        return json_encode($data);
    }

    public function wishlistRemove($id)
    {
        try{
            DB::table('wishlist')->where('user_id', session('user_id'))->where('product_id', $id)->delete();
            $data = 1;
        }catch(\Exception $e){
            $data = 500;
        }
        return json_encode($data);
    }

    public function wishlistCheck($id)
    {
        $data = 0;
        $wishlist = DB::table('wishlist')->where('user_id', session('user_id'))->where('product_id', $id)->first();
        if(!empty($wishlist)){
            $data = 1;
        }
        return json_encode($data);
    }

    public function updateQty($id_1, $id_2){
        $cart    = DB::table('cart')->where('id', $id_1)->first();
        $product = DB::table('product')->select('quantity')->where('id', $cart->product_id)->first();
        if($product->quantity < $id_2){
            $status = 'Out of stock';
        }else{
            DB::table('cart')->where('id', $id_1)->update([
                'quantity'    => $id_2
            ]);

            $status = 'In stock';
        }
        return json_encode($status);
    }

    public function regConfirm($id){
       try{
            $id_user = Crypt::decrypt($id);
            DB::table('users')->where('id', $id_user)->update([
                'is_confirm' => 'Y'
            ]);
            $msg = 'Your account has successfuly confirmed.';
        } 
        catch(\Exception $e){
            $msg = 'Your account has failed to confirm.';
        }
        return view('frontend.default.reg_confirmation')->with('message', $msg);
    }

    public function filterDetail(Request $request){        
        foreach ($request->attribute_value as $av) {
            $pieces           = explode("|", $av);
            $attribute_id[] = $pieces[1];
            $value_id[]     = $pieces[2];
        }

        $product = array();
        $data['product'] = DB::table('product') //return wrong
        ->join('product_to_attribute', 'product.id', '=', 'product_to_attribute.product_id')
        ->select('product_id', DB::raw('count(product_id) as count'))
        ->where('product.parent_id', $request->parent_id)
        ->whereIn('attribute_id', $attribute_id)
        ->whereIn('value_id', $value_id)
        ->groupBy('product_id')
        ->get();
        foreach ($data['product'] as $row) {
            if($row->count == count($request->attribute_value)){
                $product[] = $row->product_id;
            }
        }
         
        $data['combination'] = DB::table('product_to_attribute')
            ->join('product', 'product_to_attribute.product_id', '=', 'product.id')
            ->join('attribute', 'product_to_attribute.attribute_id', '=', 'attribute.id')
            ->join('attribute_value', 'product_to_attribute.value_id', '=', 'attribute_value.id')
            ->select('product_to_attribute.attribute_id', 'attribute.name as attribute_name', DB::raw('GROUP_CONCAT(DISTINCT value_id) as value_id'), DB::raw('GROUP_CONCAT(DISTINCT attribute_value.value) as value_name'))
            ->where('parent_id', $request->parent_id)
            ->whereIn('product.id', $product)
            ->whereNotIn('attribute.id', $attribute_id)
            ->groupBy('attribute_id')
            ->get();

        /*echo '<pre>';
        print_r($product);
        echo '</pre>';*/
        return json_encode($data['combination']);
    }

     public function searchVehicle(Request $request){
        $address = $request->address;
        $query =  DB::table('vehicle_repo');
        if($request->vehicle_no){
            $query->where('vehicle_no', 'like', '%'. $request->vehicle_no .'%');
        } 
        if($request->address){
            $address = $request->address;
            $query->where(function ($query) use ($address){
                $query->where('mailing_address_nobr', 'like', '%'. $address .'%')
                      ->orWhere('company_address', 'like', '%'. $address .'%');
            });
        }  
        $data  = $query->get();
        $count = count($data);

        return response()->json(['status' => 'success', 'count' => $count, 'data'=> $data]);
    }


    public function priceDetail(Request $request){     
        $date = date('Y-m-d 00:00:00');   
        foreach ($request->attribute_value as $av) {
            $pieces           = explode("|", $av);
            $attribute_id[] = $pieces[1];
            $value_id[]     = $pieces[2];
        }

        $data['product'] = DB::table('product') //return wrong
        ->join('product_to_attribute', 'product.id', '=', 'product_to_attribute.product_id')
        ->select('product_id', DB::raw('count(product_id) as count'))
        ->where('product.parent_id', $request->parent_id)
        ->whereIn('attribute_id', $attribute_id)
        ->whereIn('value_id', $value_id)
        ->groupBy('product_id')
        ->get();
        foreach ($data['product'] as $row) {
            if($row->count == count($request->attribute_value)){
                $product_id = $row->product_id;
            }
        }

        $product = DB::table('product')
        ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
        ->select('price', 'quantity','discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
        ->where('product.id', $product_id)
        ->get();
        //check discount
        $product_result = array();
        foreach ($product as $p) {
            $product_result['quantity'] = $p->quantity;
            $product_result['product_id'] = $product_id;
            if(!empty($p->discount_amount) && ($p->discount_amount !=0 ) && ($p->is_active == 'Y') && ($p->expiry >= $date )){
                $product_result['old_price'] = $p->price;
                if($p->discount_operation == '-'){
                    $product_result['price'] = $p->price - $p->discount_amount;
                    $product_result['discount'] = '-'.number_format($p->discount_amount, 2);
                }elseif($p->discount_operation == '%'){
                    $product_result['price'] = $p->price - ($p->price*$p->discount_amount/100);
                    $product_result['discount'] = '-'.$p->discount_amount.''.$p->discount_operation;
                }elseif($p->discount_operation == 's'){
                    $product_result['price'] = $p->discount_amount;
                    $product_result['discount'] = 'Special Price !';
                }
            }else{
                $product_result['price'] = $p->price;
                $product_result['discount'] = 0;
            }

        }

        //echo $product_id;
        /*echo '<pre>';
        print_r($product_result);
        echo '</pre>';*/
        return json_encode($product_result);
    }

    public function buyDetail($id){        
        $product = DB::table('product')->where('id', '=', $id)->first();
        if(!isset($product->quantity) || $product->quantity <= 0 || $id == 0){
            $data = 0;
        }else{
            try{
                $cart    = DB::table('cart')->where('product_id', '=', $id)->where('session_id', '=', session('id'))->first();
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
                $data = 1;
            }catch(\Exception $e){
                $data = 500;
            }
        }
        return json_encode($data);
    }

    public function buyDirect($id){        
        $product = DB::table('product')->where('id', '=', $id)->first();
        if(!isset($product->quantity) || $product->quantity <= 0 || $id == 0){
            $data = 0;
        }else{
            try{
                $product_combinationa = DB::table('product')->where('parent_id', '=', $id)->first();
                if(!empty($product_combinationa )){
                    $data = 200;
                }else{
                    $cart    = DB::table('cart')->where('product_id', '=', $id)->where('session_id', '=', session('id'))->first();
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
                    $data = 1;
                }
            }catch(\Exception $e){
                $data = 500;
            }
        }
        return json_encode($data);
    }

    public function cart(){   
        $date = date('Y-m-d 00:00:00');
        if(session()->has('id')){
            $data = DB::table('cart')
            ->join('product', 'cart.product_id', '=', 'product.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->select('product_name', 'price', 'cart.quantity', 'cart.id as cart_id', 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry', DB::raw('(select image from images where images.product_id = product.id or images.product_id = product.parent_id limit 1) as image'))
            ->where('session_id', '=', session('id'))
            ->get();
            $i=0;
            foreach ($data as $p) {
                $result[$i]['product_name'] = $p->product_name;
                $result[$i]['quantity'] = $p->quantity;
                $result[$i]['cart_id'] = $p->cart_id;
                $result[$i]['image'] = $p->image;
                if(!empty($p->discount_amount) && ($p->discount_amount !=0 ) && ($p->is_active == 'Y') && ($p->expiry >= $date )){
                    if($p->discount_operation == '-'){
                        $result[$i]['price'] = $p->price - $p->discount_amount;
                    }elseif($p->discount_operation == '%'){
                        $result[$i]['price'] = $p->price - ($p->price*$p->discount_amount/100);
                    }elseif($p->discount_operation == 's'){
                        $result[$i]['price'] = $p->discount_amount;
                    }
                }else{
                    $result[$i]['price'] = $p->price;
                }
                $i++;
            }
        }else{
            $data = 0;
        }
       return json_encode($result);
    }

    public function product_category_1($seo, $sort_type){
        $date = date('Y-m-d 00:00:00');
        $sort = explode("|", $sort_type);
        $products = DB::table('product')
            ->join('product_to_category', 'product.id', '=', 'product_to_category.product_id')
            ->join('category', 'product_to_category.category_id', '=', 'category.id')
            ->leftJoin('discount', 'product.id', '=', 'discount.product_id')
            ->select('product.id', 'product.product_name', 'product.quantity', 'product.product_seo', 'product.price', DB::raw('(select image from images where images.product_id = product.id limit 1) as image'), 'discount.is_active', 'discount_operation', 'discount_amount', 'expiry')
            ->whereIn('category.parent_id', function ($query) use ($seo){
                $query->select('id')
                      ->from('category')
                      ->where('category.parent_id', function ($query) use ($seo){
                            $query->select('id')
                                  ->from('category')
                                  ->where('category.category_seo', $seo);
                            }
                        );
                    }
                )
            ->where('product.status', 'Y')
            ->where('product.parent_id', '0')
            ->orderBy($sort[0], $sort[1])
            ->take(9)
            ->get();
        $i=0;
        foreach ($products as $p) {
            $result[$i]['id'] = $p->id;
            $result[$i]['product_name'] = $p->product_name;
            $result[$i]['quantity'] = $p->quantity;
            $result[$i]['product_seo'] = $p->product_seo;
            $result[$i]['image'] = $p->image;
            if(!empty($p->discount_amount) && ($p->discount_amount !=0 ) && ($p->is_active == 'Y') && ($p->expiry >= $date )){
                if($p->discount_operation == '-'){
                    $result[$i]['price'] = $p->price - $p->discount_amount;
                }elseif($p->discount_operation == '%'){
                    $result[$i]['price'] = $p->price - ($p->price*$p->discount_amount/100);
                }elseif($p->discount_operation == 's'){
                    $result[$i]['price'] = $p->discount_amount;
                }
                $result[$i]['old_price'] = $p->price;
            }else{
                $result[$i]['price'] = $p->price;
                $result[$i]['old_price'] = null;
            }
            $i++;
        }
        return json_encode($result);
    }
}