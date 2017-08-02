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











































    public function loginUser(Request $request){
        $rules = array(
            'email'    => 'required|email|max:50',
            'password' => 'required|min:6|max:20',
            'type_device'   => 'required',
        );

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = date('Y-m-d H:i:s');
            $user = app('db')->table('customer')->where('email', '=', $request->email)->first();

            if (count($user) && password_verify($request->password, $user->password)){ 
                if($user->is_confirm != 'Y'){
                    return response()->json(['status' => 'failed','message' => 'Please confirm your email address to finish signing up!']);
                }

                $referral   = app('db')->TABLE('referral')->WHERE('id_user', '=', $user->id)->FIRST();

                if(!empty($referral)){
                    $parent               = app('db')->TABLE('customer')->WHERE('id', $referral->parent_id)->FIRST();
                    $parent_referral_code = $parent->referral_code;
                }else{
                    $parent_referral_code = '';
                }

                try{
                    $other_login = app('db')->TABLE('customer')->WHERE('id_device', '=', $request->id_device)->FIRST();
                    if(!empty($other_login)){
                        app('db')->TABLE('customer')->WHERE('id', $other_login->id)->UPDATE(array('id_device' => ''));
                    }

                    $id = app('db')->TABLE('customer')->WHERE('id', $user->id)->UPDATE(
                    array(
                        'last_login'  => $date, 
                        'id_device'   => $request->id_device, 
                        'type_device' => $request->type_device
                        )
                    );

                    $mobile = ($user->mobile == null ? '' : $user->mobile);

                    $data = array();
                    $data['id_user']              = $user->id;
                    $data['name']                 = $user->fullname;
                    $data['email']                = $user->email;
                    $data['referral_code']        = $user->referral_code;
                    $data['mobile']               = $mobile;
                    $data['login_type']           = $user->login_type;
                    $data['referral_point']       = $user->referral_point;
                    $data['parent_referral_code'] = $parent_referral_code;

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

    public function register(Request $request){
        $rules = array(
            'email'            => 'required|email|unique:customer,email|max:50',
            'password'         => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
            'fullname'         => 'required|min:2|max:50',
            'mobile'           => 'required|digits_between:6,20',
            'id_country'       => 'required',
            'isagree'          => 'required|boolean'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                $date = date('Y-m-d H:i:s');
                $password = password_hash($request->password, PASSWORD_BCRYPT);
                
                $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $res = "";
                for ($i = 0; $i < 8; $i++) {
                    $res .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
                
                $id = app('db')->TABLE('customer')->insertGetId(
                    array(
                        'email'          => $request->email,
                        'password'       => $password, 
                        'fullname'       => $request->fullname,
                        'mobile'         => $request->mobile,
                        'id_country'     => $request->id_country,
                        'login_type'     => 'email',
                        'type_device'    => $request->type_device,
                        'referral_code'  => $res,
                        'referral_point' => 0,
                        'is_confirm'     => 'N',
                        'created_at'     => $date
                    )
                );
                
                $emailcontent = array (
                    'title'         => "Featours",
                    'id_user'       => Crypt::encrypt($id),
                    'u_name'        => $request->fullname,
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

    public function social_login(Request $request){
        $date = date('Y-m-d H:i:s');
        $rules = array(
            'email' => 'required|email|max:50',
            'name' => 'required',
            'type_device' => 'required',
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $user = app('db')->TABLE('customer')->WHERE('email', '=', $request->email)->FIRST();
            $other_login = app('db')->TABLE('customer')->WHERE('id_device', '=', $request->id_device)->FIRST();
            if(!empty($other_login)){
                app('db')->TABLE('customer')->WHERE('id', $other_login->id)->UPDATE(array('id_device' => ''));
            }
            if(count($user)){
                if($user->login_type != $request->login_type){
                    if($user->login_type == 'email'){
                        $message = 'Your account is already exist. Please use another email';
                    }else{
                        $message = 'Your account has been associated with '.$user->login_type.'. Please use another email';
                    }
                    return response()->json(['status' => 'failed', 'message' => $message]);
                }else{
                    app('db')->TABLE('customer')->WHERE('id', $user->id)->UPDATE(
                    array(
                        'last_login'  => $date, 
                        'id_device'   => $request->id_device, 
                        'type_device' => $request->type_device
                        )
                    );
    
                    $mobile = ($user->mobile == null ? '' : $user->mobile);
                    $data = array();
                    $data['id_user']              = $user->id;
                    $data['name']                 = $user->fullname;
                    $data['email']                = $user->email;
                    $data['referral_code']        = $user->referral_code;
                    $data['id_social']            = $request->id_social;
                    $data['login_type']           = $request->login_type;
                    $data['mobile']               = $mobile;
                    $data['referral_point']       = $user->referral_point;
                    $data['parent_referral_code'] = '';
                    $data['status']               = 'login';

                    return response()->json(['status' => 'success','data' => $data]);
                }
            }else{
                try{
                    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    $res = "";
                    for ($i = 0; $i < 8; $i++) {
                        $res .= $chars[mt_rand(0, strlen($chars)-1)];
                    }
                    
                    $id = app('db')->table('customer')->insertGetId(
                    array(
                        'email'          => $request->email,
                        'fullname'       => $request->name,
                        'referral_code'  => $res,
                        'id_social'      => $request->id_social,
                        'login_type'     => $request->login_type,
                        'id_device'      => $request->id_device,
                        'type_device'    => $request->type_device,
                        'is_confirm'     => 'Y',
                        'referral_point' => 0,
                        'created_at'     => $date
                        )
                    );

                    $data = array();
                    $data['id_user']              = $id;
                    $data['name']                 = $request->name;
                    $data['email']                = $request->email;
                    $data['referral_code']        = $res;
                    $data['id_social']            = $request->id_social;
                    $data['login_type']           = $request->login_type;
                    $data['mobile']               = '';
                    $data['referral_point']       = 0;
                    $data['parent_referral_code'] = '';
                    $data['status']               = 'register';

                    return response()->json(['status' => 'success','data' => $data]);
                }
                catch(\Exception $e){
                    return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
                }
            }
        }
    }

    public function passwordChange(Request $request){
        $rules = array(
            'id_user'          => 'required',
            'old_password'     => 'required|min:6|max:20',
            'new_password'     => 'required|min:6|max:20',
            'confirm_password' => 'required|same:new_password',
        );

        $password = password_hash($request->new_password, PASSWORD_BCRYPT);
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $user = app('db')->TABLE('customer')->WHERE('id', '=', $request->id_user)->FIRST();
            if (password_verify($request->old_password, $user->password)) {
                try{
                    $id = app('db')->TABLE('customer')->WHERE('id', $user->id)->UPDATE(array('password' => $password));
                    return response()->json(['status' => 'success']);
                }
                catch(\Exception $e){
                    return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
                }
            }else{
                return response()->json(['status' => 'failed','message' => 'Your old password is invalid.']);
            }
        }
    }

    public function forgotPassword(Request $request){
        $rules = array(
            'email' => 'required|email|max:50'
        );

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $user  = app('db')->TABLE('customer')->WHERE('email', '=', $request->email)->COUNT();
            if($user == 0){
                return response()->json(['status' => 'failed', 'message' => 'Email not found']);
            }else{
                try{
                    $email = Crypt::encrypt($request->email);
                    $emailcontent = array (
                        'title'         => "Featours",
                        'email'         => $email,
                        'subject'       => 'Forgot Password',
                        'email'         => $request->email,
                        'crypt_email'   =>  Crypt::encrypt($request->email),
                        'view'          => 'email.forgot_password'
                    );

                    $this->sendEmail($emailcontent);
                    return response()->json(['status' => 'success']);
                }
                catch(\Exception $e){
                    return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
                }
            }
        }
    }

    public function feedbackCreate(Request $request){   
        $date = date('Y-m-d H:i:s');
        $rules = array(
            'id_user'  => 'required',
            'messages' => 'required'
        );

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            try{
                $id = app('db')->table('feedback')->insert(
                    array(
                        'id_user'    => $request->id_user,
                        'message'    => $request->messages,
                        'created_at' => $date
                    )
                );  
                $email = app('db')->TABLE('customer')->SELECT('email')->WHERE('id', $request->id_user)->FIRST();
                $emailcontent = array (
                    'title'   => $request->messages,
                    'id_user' => $request->id_user,
                    'email'   => $email->email,
                    'subject' => 'Feedback',
                    'email'   => 'ccare@featours.com',
                    'view'    => 'email.feedback'
                );
                $this->sendEmail($emailcontent);    
                return response()->json(['status' => 'success']);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function allCategory(){
        try{
            $category = app('db')->TABLE('category')->GET();
            $data = array();
            $m = 0;
            foreach ($category as $o) {
                $data[$m]['id']    = $o->id;
                $data[$m]['name']  = $o->name;
                $data[$m]['thumb'] = 'http://featours.com/backend/images/category/'.$o->thumb;
                if($o->id == 1){
                    $data[$m]['title'] = 'Select the Adventure';
                }else{
                    $data[$m]['title'] = 'Select the Service';
                }
                $m++;
            }
            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function serviceByCategory($id){
        try{
            $service = app('db')->TABLE('service')
            ->JOIN('category', 'service.id_category', '=', 'category.id')
            ->SELECT('service.id as id_service','service.name')
            ->WHERE('category.id', $id)
            ->WHERE('service.is_shown', '1')
            ->GET();

            $data = array();
            $m = 0;
            foreach ($service as $o) {
                $data[$m]['id_service'] = $o->id_service;
                $data[$m]['name'] = $o->name;
                $detail = app('db')->table('photo')->where('id_service', $o->id_service)->get();
                if(empty($detail)){
                    $data[$m]['thumb'] = 'http://featours.com/backend/images/service/default.jpg';
                }else{
                    foreach ($detail as $d) {
                        $data[$m]['thumb'] = 'http://featours.com/backend/images/service/'.$d->filename;
                    }
                }
                $m++;
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function serviceByCategory2($id){
        try{
            $service = app('db')->TABLE('service')
            ->JOIN('category', 'service.id_category', '=', 'category.id')
            ->SELECT('service.id as id_service','service.name')
            ->WHERE('category.id', $id)
            ->WHERE('service.is_shown', '1')
            ->get();

            $data = array();
            $m = 0;
            foreach ($service as $o) {
                $data[$m]['id_service'] = $o->id_service;
                $data[$m]['name']       = $o->name;

                $detail = app('db')->table('photo')->where('id_service', $o->id_service)->get();

                if(empty($detail)){
                    $n = 0;
                    $data[$m]['thumb'][$n] = 'http://featours.com/backend/images/service/default.jpg';
                }else{
                    $n = 0;
                    foreach ($detail as $d) {
                        $data[$m]['thumb'][$n] = 'http://featours.com/backend/images/service/'.$d->filename;
                        $n++;
                    }
                }
                $m++;
            }
            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function serviceById($id){
        try{
            $service = app('db')->TABLE('service')
            ->JOIN('price', 'service.id', '=', 'price.id_service')
            ->SELECT('service.id as id_service','service.name', 'service.description', 'service.duration', 'price.rate_local as price', 'service.longitude', 'service.longitude', 'service.latitude', 'service.term_condition', 'service.slug')
            ->WHERE('service.id', $id)
            ->GET();

            $data = array();
            foreach ($service as $o) {
                $data['id_service']  = $o->id_service;
                $data['name']        = $o->name;
                $data['description'] = $o->description;
                $data['price']       = $o->price;
                $data['duration']    = $o->duration;
                $data['longitude']   = $o->longitude;
                $data['latitude']    = $o->latitude;
                $data['url']         = 'http://featours.com/services/'.$o->slug;
                $data['share_text']  = 'Check out this '.$o->name.' by Featours!';
                $detail              = app('db')->table('photo')->where('id_service', $o->id_service)->get();
                $data['thumb']       = array();
                $n = 0;
                foreach ($detail as $d) {
                    $data['thumb'][$n] = 'http://featours.com/backend/images/service/'.$d->filename;
                    $n++;
                }
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

   public function priceTypeDate(Request $request){
        $rules = array(
            'id_service' => 'required',
            'start_date' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $k = 0; 
            $date = $request->start_date.' 00:00:00';
            try{
                $price = app('db')->table('price')
                ->join('service', 'price.id_service', '=', 'service.id')
                ->select('price.id as id_price','price.title as name','price.is_stock', 'price.stock as limit', 'rate_local as price_wni', 'rate_wna as price_wna', 'price.min_order', 'price.type', 'price.validity', 'price.warning')
                ->where('price.id_service', $request->id_service)
                ->get();

                $j=0;
                foreach($price as $row){
                    if($row->validity == $date){
                        $price_type[$j]['id_price'] = $row->id_price;
                        $price_type[$j]['name'] = $row->name;
                        if($row->is_stock == 'N'){
                            $price_type[$j]['limit'] = 99;
                        }else{
                            $price_type[$j]['limit'] = $row->limit;
                        }
                        $price_type[$j]['min_order'] = $row->min_order;
                        $price_type[$j]['price_wni'] = $row->price_wni;
                        $price_type[$j]['price_wna'] = $row->price_wna;
                        $price_type[$j]['type']      = $row->type;
                        $price_type[$j]['warning']   = $row->warning;
                        $k++;
                        $j++;
                    }           
                }
                if($k == 0){
                    $j=0;
                    foreach($price as $row){
                        if($row->type == 'FIX'){
                            $price_type[$j]['id_price'] = $row->id_price;
                            $price_type[$j]['name'] = $row->name;
                            if($row->is_stock == 'N'){
                                $price_type[$j]['limit'] = 99;
                            }else{
                                $price_type[$j]['limit'] = $row->limit;
                            }
                            $price_type[$j]['min_order'] = $row->min_order;
                            $price_type[$j]['price_wni'] = $row->price_wni;
                            $price_type[$j]['price_wna'] = $row->price_wna;
                            $price_type[$j]['type']      = $row->type;
                            $price_type[$j]['warning']   = $row->warning;
                            $j++;
                        }
                    }
                }
                return response()->json(['status' => 'success', 'data' => array('id_service' => $request->id_service, 'price_type' => $price_type)]);
            }
            catch(\Exception $e){
                return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
            }
        }
    }

    public function purchase(Request $request){ 
        $rules = array(
            'id_service' => 'required',
            'id_user'    => 'required',
            'start_date' => 'required|date',
            'quantity'   => 'required',
            'use_point'  => 'integer'
        );

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            if($request->transaction_type == "review"){
                $data_review = $this->purchase_review($request->all());
                if(!empty($data_review['status'])){
                    return response()->json(['status' => $data_review['status'], $data_review['param'] => $data_review['value']], $data_review['code']);
                }else{
                    return response()->json(['status' => 'success','data' => $data_review]);
                }
            }
            elseif($request->transaction_type == "purchase"){
                $data_review   = $this->purchase_review($request->all());
                if(!empty($data_review['status'])){
                    return response()->json(['status' => $data_review['status'], $data_review['param'] => $data_review['value']], $data_review['code']);
                }else{
                    $data_purchase = $this->purchase_process($request->all(), $data_review);
                    if(!empty($data_purchase['status'])){
                        return response()->json(['status' => $data_purchase['status'], $data_purchase['param'] => $data_purchase['value']], $data_purchase['code']);
                    }else{
                        return response()->json(['status' => 'success','data' => $data_purchase]);
                    }
                }
            }
        }
    }

    public function purchase_review($data_input){ 
        $quantity  = $data_input['quantity'];
        $keylength = count($quantity);
        $dt        = strtotime($data_input['start_date']);
        $day       = date("l", $dt);
        $date      = date("j", $dt);
        $month     = date("F", $dt);
        $year      = date("Y", $dt);
            
        $dates     = $day.', '.$date.' '.$month.' '.$year;
        
        $users     = app('db')->table('customer')->select('referral_point')->where('id', $data_input['id_user'])->first();

        $service = app('db')->table('service')
        ->join('category', 'service.id_category', '=', 'category.id')
        ->select('service.id as id_service', 'service.name', 'category.max_point_used', 'category.point_accept')
        ->where('service.id', $data_input['id_service'])
        ->first();

        if(!empty($service)){
            if(($service->point_accept == 'Y') || ($service->point_accept == 'y')){
                $max_point = $service->max_point_used;
            }
            elseif(($service->point_accept == 'Y') && ($service->max_point == 0)){
                $max_point = 0; // unlimited
            }
            elseif($service->point_accept == 'N'){
                $max_point = -1; // cant use point
            }
                
            $transaction  = app('db')->table('price')->select('id', 'title as price_type', 'rate_local','rate_wna', 'type', 'validity')->where('id_service', $data_input['id_service'])
            ->orderBy('title', 'asc')->get();
            if(!empty($transaction)){
                $transactions = array();
                $start = strtotime($data_input['end_date']);
                $end = strtotime($data_input['start_date']);
                $days_between = ceil(abs($end - $start) / 86400);
                if(!empty($data_input['end_date'])){
                    $end_date = $data_input['end_date'].' 00:00:00';
                }else{
                    $end_date = $data_input['start_date'].' 00:00:00';
                }
                $start_date = $data_input['start_date'].' 00:00:00';
                $j = 0;
                $total = 0; 
                for($i=0; $i<$keylength; $i++){
                    $k = 0;
                    $title  = app('db')->table('price')->select('title', 'type')->where('id', $quantity[$i]['id_price'])->first();
                    foreach($transaction as $row){
                        if(($title->title == $row->price_type) && ($row->validity == $start_date)){
                            $transactions[$j]['id_price']   = $row->id;
                            $transactions[$j]['price_type'] = $row->price_type;
                            if($quantity[$i]['type'] == 'wna'){
                                $transactions[$j]['price'] = $row->rate_wna;
                            }elseif($quantity[$i]['type'] == 'wni'){
                                $transactions[$j]['price'] = $row->rate_local;
                            }elseif($quantity[$i]['type'] == 'general'){
                                $transactions[$j]['price'] = $row->rate_wna;
                            }                                   
                            $transactions[$j]['quantity'] = $quantity[$i]['quantity'];
                            $transactions[$j]['type']     = $quantity[$i]['type'];
                            $transactions[$j]['subtotal'] = $quantity[$i]['quantity'] * $transactions[$j]['price'];
                            $subtotal                     = $transactions[$j]['subtotal'];
                            //$transactions[$j]['t']        = $row->type;
                            $k++;
                            $j++;
                        }       
                    }
                    if($k == 0){
                        foreach($transaction as $row){
                            if(($title->title == $row->price_type) && ($row->type == 'FIX')){
                                $transactions[$j]['id_price'] = $row->id;
                                $transactions[$j]['price_type'] = $row->price_type;
                                if($quantity[$i]['type'] == 'wna'){
                                    $transactions[$j]['price'] = $row->rate_wna;
                                }elseif($quantity[$i]['type'] == 'wni'){
                                    $transactions[$j]['price'] = $row->rate_local;
                                }elseif($quantity[$i]['type'] == 'general'){
                                    $transactions[$j]['price'] = $row->rate_wna;
                                }
                                $transactions[$j]['quantity'] = $quantity[$i]['quantity'];
                                $transactions[$j]['type']     = $quantity[$i]['type'];
                                $transactions[$j]['subtotal'] = $quantity[$i]['quantity'] * $transactions[$j]['price'];
                                $subtotal                     = $transactions[$j]['subtotal'];
                                //$transactions[$j]['t']        = $row->type;
                                $j++;
                            }
                        }
                    }
                    $total = $total + $subtotal;
                }

                $discount_status = $this->discount_code($total, $data_input['discount_code']);
                if($discount_status == 0){
                    $discount = 0;
                }
                if($discount_status == 1){
                    $discount = 0;
                    $data_response['status'] = 'failed';
                    $data_response['param']  = 'message';
                    $data_response['value']  = 'Voucher code has been out of stock';
                    $data_response['code']   = 200;

                    return $data_response;
                }
                if($discount_status == 2){
                    $discount = 0;
                    $data_response['status'] = 'failed';
                    $data_response['param']  = 'message';
                    $data_response['value']  = 'Your voucher code has been expired';
                    $data_response['code']   = 200;

                    return $data_response;
                }
                if($discount_status == 3){
                    $discount = 0;
                    $data_response['status'] = 'failed';
                    $data_response['param']  = 'message';
                    $data_response['value']  = 'Your voucher code is invalid';
                    $data_response['code']   = 200;

                    return $data_response;

                }
                else{
                    $discount = $discount_status;
                }

                //if use referral point
                $point_can_use = $this->referral_point($data_input['use_point'], $data_input['id_user']);
                if($data_input['use_point'] > $point_can_use){
                    $point_use = $point_can_use;
                }else{
                    $point_use = $data_input['use_point'];
                }
                        
                if($max_point > 0){
                    if($point_use > $max_point){
                        $point_use = $max_point;
                    }
                }elseif($max_point < 0){
                    $point_use = 0;
                }

                //count grand total
                $total_2 = $total - $discount;
                if($total_2 > $point_use){
                    $grand_total = $total_2 - $point_use;
                }elseif($total_2 < $point_use){
                    $grand_total = 0 ;
                    $point_use   = $total_2;
                }
                $data_response = array();
                $data_response['id_service']     = $data_input['id_service'];
                $data_response['name']           = $service->name;
                $data_response['purchase_date']  = $dates;
                $data_response['referral_point'] = $users->referral_point;
                $data_response['max_point_used'] = $max_point;
                $data_response['transaction']    = $transactions;
                $data_response['point_use']      = $point_use;
                //$data_response['point_can_use']  = $point_can_use;
                $data_response['discount']       = $discount;
                $data_response['total']          = $total;
                $data_response['grand_total'] = $grand_total;

                return $data_response;
            }
        }
    }

    public function purchase_process($data_input, $data_review){ 
        $date          = date('Y-m-d H:i:s');
        $quantity      = $data_input['quantity'];
        $keylength     = count($quantity);
        $data_response = array();
        $end_date      = ((!empty($data_input['end_date'])) ? $data_input['end_date'] : $data_input['start_date']);
        // ----------------------------------------------------- validation check ---------------------------------------------------------------
        //quantity
        $q = 0;
        for($l=0; $l<$keylength; $l++){
            $price_Q = app('db')->table('price')->select('stock', 'is_stock')->where('id', $quantity[$l]['id_price'])->first();
            if(($price_Q->is_stock == 'Y' && !empty($price_Q) && ($quantity[$l]['quantity'] > $price_Q->stock)) || $price_Q->is_stock == 'N' && !empty($price_Q) && ($quantity[$l]['quantity'] > 99)){
                $q++;
            }
        }

        if($q > 0){
            $data_response['status'] = 'failed';
            $data_response['param']  = 'message';
            $data_response['value']  = 'Invalid quantity';
            $data_response['code']   = 200;

            return $data_response;
        }

        //point
        if($data_input['use_point'] > $data_review['point_use']){ //first-> point_can_use
            $data_response['status'] = 'failed';
            $data_response['param']  = 'message';
            $data_response['value']  = 'Invalid point';
            $data_response['code']   = 200;

            return $data_response;
        }

        //grand total
        if($data_review['grand_total'] != $data_input['grand_total']){
            $data_response['status'] = 'failed';
            $data_response['param']  = 'message';
            $data_response['value']  = 'Invalid total';
            $data_response['code']   = 200;

            return $data_response;
        }

        // promo code
        $disc_code = '';
        if(!empty($data_input['discount_code'])){
            $disc  = app('db')->table('discount_code')->select('num_voucher')->where('voucher_code', $data_input['discount_code'])->where('num_voucher', '>', 0)
            ->where('expiry', '>=', $date)->where('is_active', '=', '1')->first();
            if(!empty($disc)){
                $disc_code = $data_input['discount_code'];
            }else{
                $disc_code = '-';
                $data_response['status'] = 'failed';
                $data_response['param']  = 'message';
                $data_response['value']  = 'Invalid voucher code';
                $data_response['code']   = 200;

                return $data_response;
            }
        }
        // ----------------------------------------------------- end of validation check ---------------------------------------------------------------
                        
        $new_total = $data_review['grand_total'];

        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $booking_number = "";
        for ($i = 0; $i < 10; $i++) {
            $booking_number .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        //insert purchase
        $accomodation         = ((!empty($data_input['accomodation'])) ? $data_input['accomodation'] : '');
        $special_request      = ((!empty($data_input['special_request'])) ? $data_input['special_request'] : '');
        $accomodation_room    = ((!empty($data_input['accomodation_room'])) ? $data_input['accomodation_room'] : '');
        $id_purchase = app('db')->table('purchase')->insertGetId( 
        array(
            'id_service'        => $data_input['id_service'],
            'id_user'           => $data_input['id_user'],
            'status'            => 'process',
            'start_date'        => $data_input['start_date'],
            'end_date'          => $end_date,
            'voucher_code'      => $disc_code,
            'accomodation'      => $accomodation,
            'accomodation_room' => $accomodation_room,
            'special_request'   => $special_request,
            'amount'            => $new_total,
            'booking_number'    => $booking_number,
            'point_use'         => $data_review['point_use'],
            'created_at'        => $date
            )
        );

        // decrease number of voucher code
        if($disc_code != '-' && $disc_code != ''){
            $disc_decrease = $disc->num_voucher - 1;
            app('db')->table('discount_code')->where('voucher_code', $data_input['discount_code'])->update(array('num_voucher' => $disc_decrease));
        }

        // decrease number of stock
        //quantity
        $q = 0;
        $transactions = $data_review['transaction'];
        for($l=0; $l<$keylength; $l++){
            $price_Q = app('db')->table('price')->select('stock')->where('id', $transactions[$l]['id_price'])->where('is_stock', 'Y')->first();
            if(!empty($price_Q)){
                $new_stock = $price_Q->stock - $quantity[$l]['quantity'];
                app('db')->table('price')->where('id', $transactions[$l]['id_price'])->update(array('stock' => $new_stock));
            }
        }
        
        //insert purchase detail
        $translenght    = count($transactions);
        for($i=0; $i<$translenght; $i++){
            if($quantity[$i]['type'] == 'wni'){
                $status = 'Local';
            }elseif($quantity[$i]['type'] == 'wna'){
                $status = 'Foreigner';
            }elseif($quantity[$i]['type'] == 'general'){
                $status = '';
                                }
            app('db')->table('purchase_detail')->insert( // new function
                array(
                'id_purchase' => $id_purchase,
                'quantity'    => $transactions[$i]['quantity'],
                'price_title' => $transactions[$i]['price_type'].' '.$status,
                'rate'        => $transactions[$i]['price'],
                'id_price'    => $transactions[$i]['id_price'],
                'validity'    => $date,
                'created_at'  => $date
                )
            );
        }

        //if use referral point
        if($data_review['point_use'] != 0){
            $this->use_referral_point($data_input['id_user'], $data_review['point_use'], $id_purchase);
        }

        
        $data_response['id_purchase'] = $id_purchase;
        $data_response['booking_number'] = $booking_number;
        $data_response['grand_total'] = $data_review['grand_total'];    

        return $data_response;
    }

    public function referral_point($id, $id_user){
        if(!empty($id)){
            $u_point = app('db')->table('customer')->select('referral_point')->where('id', $id_user)->first();
            $point_use = $u_point->referral_point;
        }else{
            $point_use = 0;
        }
        return $point_use;
    }

    public function discount_code($total, $code){
        $date = date('Y-m-d');
        $get_discount = app('db')->table('discount_code')->select('discount_operation', 'discount_amount', 'num_voucher', 'expiry', 'is_active')
                        ->where('voucher_code', $code)->first();
        if(!empty($get_discount) && ($get_discount->num_voucher > 0) && ($get_discount->expiry > $date) && ($get_discount->is_active == 1)){
            if($get_discount->discount_operation == '%'){
                $discount = $total * $get_discount->discount_amount / 100;
            }elseif($get_discount->discount_operation == '-'){
                $discount = $get_discount->discount_amount;
            }
            return $discount;
        }
        elseif(!empty($get_discount) && $get_discount->num_voucher <= 0){
            return 1; // out of stock
        }
        elseif(!empty($get_discount) && $get_discount->expiry < $date){
            return 2; //expired discount code
        }
        elseif(empty($code)){
            return 0; // not using any discount code
        }
        else{
            return 3; // invalid discount code
        }
    }

    public function use_referral_point($id_user, $point_use, $id_purchase){
        $date = date('Y-m-d H:i:s');
        $u_point = app('db')->table('customer')->select('referral_point')->where('id', $id_user)->first();
        $new_point = $u_point->referral_point - $point_use;

        app('db')->table('customer')->where('id', $id_user)->update( 
            array(
                'referral_point' => $new_point,
                'updated_at' => $date
        ));

        app('db')->table('point_transaction')->insert(
            array(
                'id_user'         => $id_user,
                'id_relation'     => $id_purchase,
                'table_relation'  => 'purchase',
                'type'            => 'credit', 
                'amount'          => $point_use,
                'current_balance' => $new_point, 
                'is_withdrawal'   => 'N',
                'description'     => 'You use your point for purchase',
                'created_at'      => $date
            )
        );  
    }   

    public function freeOrder($id){
        try{
            $free_order = app('db')->table('customer')
            ->select('referral_point', 'referral_code')
            ->where('customer.id', $id)
            ->first();
            
            return response()->json(['status' => 'success','data' => $free_order]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function myOrder($id){
        try{
            $orders = app('db')->table('purchase')
            ->join('customer', 'purchase.id_user', '=', 'customer.id')
            ->join('service', 'purchase.id_service', '=', 'service.id')
            ->select('purchase.id', 'purchase.booking_number', 'purchase.start_date', 'service.name', 'purchase.status', 'purchase.amount', 'purchase.created_at as date_created')
            ->where('customer.id', $id)
            ->orderBy('purchase.created_at', 'desc')
            ->get();

            $data = array();
            $m = 0;
            foreach ($orders as $o) {
                $data[$m]['id_purchase']    = $o->id;
                $data[$m]['booking_number'] = $o->booking_number;
                $data[$m]['start_date']     = $o->start_date;
                $data[$m]['service_name']   = $o->name;
                $data[$m]['status']         = $o->status;
                $data[$m]['amount']         = $o->amount;
                $data[$m]['date_created']   = $o->date_created;
                //$data[$m]['url']            = 'http://featours.com/isa-cms/isa-veritrans?order_id='.$o->booking_number.'&gross_amount='.$o->amount;
               
                $detail = app('db')->table('purchase_detail')->where('id_purchase', $o->id)->get();
                $data[$m]['detail'] = array();
                $n = 0;
                foreach ($detail as $d) {
                    $data[$m]['detail'][$n]['id_price']    = $d->id_price;
                    $data[$m]['detail'][$n]['price_title'] = $d->price_title;
                    $data[$m]['detail'][$n]['rate']        = $d->rate;
                    $data[$m]['detail'][$n]['quantity']    = $d->quantity;

                    $n++;
                }
                $m++;
            }
            return response()->json(['status' => 'success','data' => $data]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }


    public function getProfile($id){
        try{
            $user = app('db')->table('customer')
            ->where('customer.id', $id)
            ->first();

            $parent = app('db')->table('customer')
            ->join('referral', 'customer.id', '=', 'referral.parent_id')
            ->select('customer.referral_code')
            ->where('referral.id_user', $id)
            ->first();

            $mobile = ($user->mobile == null) ? "" : $user->mobile;

            if(count($parent)){
                $r_parent = $parent->referral_code;
            }else{
                $r_parent = '';
            }

            return response()->json(
                array('status' => 'success', 'data' => array('id_user' => $user->id, 'name' => $user->fullname, 'email' => $user->email, 'referral_code' => $user->referral_code,  'referral_point' => $user->referral_point, 'mobile' => $mobile, 'parent_referral_code' => $r_parent, 'login_type' => $user->login_type)
                )
            );
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function updateProfile(Request $request){
        $rules = array(
            'id_user' => 'required',
            'email'   => 'required|email|unique:customer,email,'.$request->id_user,
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = date('Y-m-d H:i:s');
            $user  = app('db')->table('customer')->where('id', '=', $request->id_user)->first();

            if(!empty($request->input('parent_referral_code')) && $request->input('parent_referral_code') != ' ' && $request->input('parent_referral_code') != '-'){
                if($request->parent_referral_code == $user->referral_code){
                    return response()->json(['status' => 'failed','message' => 'You can not use your own referral code']); // -- response ---
                }else{
                    //$s_point = app('db')->table('referral_point_set')->where('type', '=', 'S')->first();
                    //$t_point = app('db')->table('referral_point_set')->where('type', '=', 'T')->first();
                    $parent  = app('db')->table('customer')->where('referral_code', '=', $request->parent_referral_code)->first();
                
                    if(!empty($parent)){
                        $check_parent  = app('db')->table('referral')
                        ->join('customer', 'referral.parent_id', '=', 'customer.id')
                        ->select('customer.referral_code')
                        ->where('referral.id_user', '=', $request->id_user)
                        ->first();

                        if(empty($check_parent)){
                            $u_referral_point = $user->referral_point + 15000;
                            app('db')->table('point_transaction')->insert(
                            array(
                                'id_user'         => $request->id_user,
                                'type'            => 'debit', 
                                'amount'          => 15000,
                                'current_balance' => $u_referral_point, 
                                'is_withdrawal'   => 'N',
                                'description'     => 'You register using '.$parent->fullname.' referral code',
                                'created_at'      => $date
                                )
                            );
                        }
                        elseif(!empty($check_parent) && ($check_parent->referral_code == $request->parent_referral_code)){
                            $u_referral_point = $user->referral_point;
                        }
                        elseif(!empty($check_parent) && ($check_parent->referral_code != $request->parent_referral_code)){
                            return response()->json(['status' => 'failed','message' => 'You can not change your parent referral code']); // -- response ---
                        }
                        
                        app('db')->table('customer')->where('id', $request->id_user)->update(
                            array(
                            'email'          => $request->email, 
                            'fullname'       => $request->name, 
                            'mobile'         => $request->mobile,
                            'referral_point' => $u_referral_point,
                            'id_country'     => $request->id_country
                            )
                        );

                        if(empty($check_parent)){
                            app('db')->table('referral')->insert(
                                array(
                                    'id_user'        => $request->id_user,
                                    'parent_id'      => $parent->id, 
                                    'is_transaction' => 0,
                                    'created_at'     => $date
                                )
                            );  

                            $emailcontent = array (
                                'title'   => "Featours",
                                'u_name'  => $user->fullname,
                                'p_name'  => $parent->fullname,
                                'email'   => $parent->email,
                                'subject' => 'Notification',
                                'view'    => 'email.referral'
                            );
                            $this->sendEmail($emailcontent);
                        }
                    }else{
                        return response()->json(['status' => 'failed','message' => 'Your parent referral code is invalid']); // -- response ---
                    }

                    return response()->json(['status' => 'success','id_user' => $request->id_user]); // -- response ---
                }
            }else{
                app('db')->table('customer')->where('id', $request->id_user)->update(
                    array(
                    'email'      => $request->email, 
                    'fullname'   => $request->name, 
                    'mobile'     => $request->mobile,
                    'id_country' => $request->id_country
                    )
                );

                return response()->json(['status' => 'success','id_user' => $request->id_user]); // -- response ---
            }
        }
    }

    public function updateReferral(Request $request){
        $rules = array(
            'id_user' => 'required',
            'parent_referral_code' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = date('Y-m-d H:i:s');
            $user_rc  = app('db')->table('customer')->select('referral_code', 'fullname')->where('id', '=', $request->id_user)->first();

            if($request->parent_referral_code == $user_rc->referral_code){
                return response()->json(['status' => 'failed','message' => 'You can not use your own referral code']); // -- response ---
            }else{
                //$s_point = app('db')->table('referral_point_set')->where('type', '=', 'S')->first();
                //$t_point = app('db')->table('referral_point_set')->where('type', '=', 'T')->first();
                $parent  = app('db')->table('customer')->where('referral_code', '=', $request->parent_referral_code)->first();
                
                if(!empty($parent)){
                    $check_parent  = app('db')->table('referral')
                        ->join('customer', 'referral.parent_id', '=', 'customer.id')
                        ->select('customer.referral_code')
                        ->where('referral.id_user', '=', $request->id_user)
                        ->first();

                    $user  = app('db')->table('customer')->where('id', '=', $request->id_user)->first();
                    if(empty($check_parent)){
                        $u_referral_point = $user->referral_point + 15000;
                        app('db')->table('point_transaction')->insert(
                            array(
                                'id_user'         => $request->id_user,
                                'type'            => 'debit', 
                                'amount'          => 15000,
                                'current_balance' => $u_referral_point, 
                                'is_withdrawal'   => 'N',
                                'description'     => 'You register using '.$parent->fullname.' referral code',
                                'created_at'      => $date
                            )
                        );
                    }
                    elseif(!empty($check_parent) && ($check_parent->referral_code != $request->parent_referral_code)){
                        return response()->json(['status' => 'failed','message' => 'You can not change your parent referral code']); // -- response ---
                    }
                    elseif(!empty($check_parent) && ($check_parent->referral_code == $request->parent_referral_code)){
                        return response()->json(['status' => 'failed','message' => 'You have already set your parent referral code']); // -- response ---
                    }

                    app('db')->table('customer')->where('id', $request->id_user)->update(
                        array(
                            'referral_point' => $u_referral_point
                        )
                    );

                    if(empty($check_parent)){
                        app('db')->table('referral')->insert(
                        array(
                            'id_user'        => $request->id_user,
                            'parent_id'      => $parent->id, 
                            'is_transaction' => 0,
                            'created_at'     => $date
                            )
                        );  

                        /*app('db')->table('customer')->where('id', $parent->id)->update( 
                            array(
                                'referral_point' => $parent->referral_point+$s_point->point,
                                'updated_at'     => $date
                            )
                        );  

                        app('db')->table('point_transaction')->insert(
                            array(
                                'id_user'         => $parent->id,
                                'type'            => 'debit', 
                                'amount'          => $s_point->point,
                                'current_balance' => $parent->referral_point+$s_point->point, 
                                'is_withdrawal'   => 'N',
                                'description'     => $user_rc->fullname.' register with your referral code',
                                'created_at'      => $date
                            )
                        );*/

                        $emailcontent = array (
                            'title'  => "Featours",
                            'u_name' => $user_rc->fullname,
                            'p_name' => $parent->fullname,
                            'email'  => $parent->email,
                            'subject' => 'Notification',
                            'view'    => 'email.referral'
                        );
                        $this->sendEmail($emailcontent);
                    }
                }else{
                    return response()->json(['status' => 'invalid','message' => 'Your parent referral code is invalid']); // -- response ---
                }
                return response()->json(['status' => 'success','id_user' => $request->id_user]); // -- response ---
            }
        }
    }

    public function logout($id){
        try{
            app('db')->table('customer')->where('id', $id)->update(array('id_device' => ''));
            return response()->json(['status' => 'success', 'id_user' => $id]);
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
        
    }   

    public function purchaseCancel(Request $request){
        $date = date('Y-m-d H:i:s');
        try{
            $purchase = app('db')->table('purchase')->where('booking_number', $request->booking_number)->select('id', 'voucher_code', 'point_use', 'id_user', 'status')->first();
            if($purchase->status != 'paid'){
                $purchase_detail = app('db')->table('purchase_detail')->where('id_purchase', $purchase->id)->get();

                if(!empty($purchase->voucher_code)){
                    $voucher_code = app('db')->table('discount_code')->where('voucher_code', $purchase->voucher_code)->select('num_voucher')->first();
                    $new_vc = $voucher_code->num_voucher + 1;
                    app('db')->table('discount_code')->where('voucher_code', $purchase->voucher_code)->update( 
                        array(
                            'num_voucher' => $new_vc
                        )
                    );
                }
                
                if($purchase->point_use > 0){
                    $customer = app('db')->table('customer')->where('id', $purchase->id_user)->select('referral_point')->first();
                    $new_rp = $customer->referral_point + $purchase->point_use;
                    app('db')->table('customer')->where('id', $purchase->id_user)->update( 
                        array(
                            'referral_point' => $new_rp
                        )
                    );

                    app('db')->table('point_transaction')->where('id_relation', $purchase->id)->where('table_relation', 'purchase')->delete();
                }

                foreach($purchase_detail as $p){
                    $price = app('db')->table('price')->where('id', $p->id_price)->first();
                    if($price->is_stock == 'Y'){
                        $new_quantity = $price->stock + $p->quantity;
                        app('db')->table('price')->where('id', $p->id_price)->update(array('stock' => $new_quantity));
                    }
                }
                
                app('db')->table('purchase')->where('booking_number', $request->booking_number)->delete();
                app('db')->table('purchase_detail')->where('id_purchase', $purchase->id)->delete();
                
                return response()->json(['status' => 'success', 'message' => 'Your order has been canceled']);
            }
        }
        catch(\Exception $e){
            return response()->json(['status' => 'error','message' => 'Something went wrong. Please try again later.'], 500);
        }
    }

    public function vtweb(Request $request){
        $date = date('Y-m-d H:i:s');
        $purchase = app('db')->table('purchase')->where('booking_number', $request->booking_number)->select('id', 'status', 'amount')->first();
        if($purchase->status == 'paid'){
            return response()->json(
                array('status' => 'paid', 'message' => 'You have already paid for this booking')
            );
        }

        $vt = new Veritrans;

       /* $transaction_details = array(
            'order_id'      => $request->booking_number,
            'gross_amount'  => $purchase->amount
        );

        $token_id = $request->id_token;

        $transaction_data = array(
              'payment_type'  => 'credit_card',
              'credit_card'   => array(
                  'token_id'      => $token_id,
                  'bank'          => $request->bank
                ),
              'transaction_details' => $transaction_details,
        );
        $response= $vt->vtdirect_charge($transaction_data);*/

        // Success
        if($request->bank == 'test' || ($response->transaction_status == 'capture' && $response->fraud_status != 'challenge') || $response->transaction_status == 'settlement' || $response->transaction_status == 'success') {
            app('db')->table('purchase')->where('booking_number', $request->booking_number)->update([
            'status' => 'paid', 'updated_at' => $date
             ]);
            $this->add_point_to_parent($request->booking_number);
            $this->booking_summary($request->booking_number);
            return response()->json(
                array('status' => 'success', 'message' => 'Your transaction is successfull')
            );
        }
        // Pending
        else if($response->transaction_status == 'pending') {
            app('db')->table('purchase')->where('booking_number', $request->booking_number)->update([
            'status' => 'pending', 'updated_at' => $date
             ]);
            return response()->json(
                array('status' => 'failed', 'message' => 'Your transaction is currently pending')
            );
        }
        // Deny
        else if($response->transaction_status == 'deny') {
            app('db')->table('purchase')->where('booking_number', $request->booking_number)->update([
            'status' => 'denied', 'updated_at' => $date
             ]);
            return response()->json(
                array('status' => 'failed', 'message' => 'Your transaction is denied. Please try again.')
            );
        }
        // Challenge
        else if($response->transaction_status == 'challenge' || $response->fraud_status == 'challenge') {
            $data = $vt->cancel($request->booking_number);
            app('db')->table('purchase')->where('booking_number', $request->booking_number)->update([
            'status' => 'challenge', 'updated_at' => $date
             ]);
            return response()->json(
                array('status' => 'failed', 'message' => 'Your transaction is denied. Please try again.')
            );
        }
        // Failure
        else if($response->transaction_status == 'failure') {
            app('db')->table('purchase')->where('booking_number', $request->booking_number)->update([
            'status' => 'failure', 'updated_at' => $date
             ]);
            return response()->json(
                array('status' => 'failed', 'message' => 'Your transaction is failed. Please try with other credit card.')
            );
        }
        // Error
        else{
            return response()->json(
                array('status' => 'failed', 'message' => 'Something went wrong. Please try again in a minutes')
            );
        }
    }

    public function add_point_to_parent($booking_number){
        $date = date('Y-m-d H:i:s');
        $purchase = app('db')->table('purchase')->where('booking_number', $booking_number)->select('id_user','amount')->first();
        $referral = app('db')->table('referral')->where('id_user', '=', $purchase->id_user)->select('parent_id', 'is_transaction')->first();

        if(!empty($referral) && ($referral->is_transaction == 0)){          
            $id_user = $purchase->id_user;
            $parent_id = $referral->parent_id;
            $referral_point = app('db')->table('referral_point_set')->select('point')->where('type', 'T')->first();
            $t_point = 3/100*$purchase->amount;

            app('db')->table('referral')->where('id_user', $id_user)->update( 
                array(
                    'is_transaction' => 1,
                    'updated_at' => $date
                ));

            // give point to parent
            $parent_point = app('db')->table('customer')->select('referral_point')->where('id', $parent_id)->first();
            app('db')->table('customer')->where('id', $parent_id)->update( 
                array(
                    'referral_point' => $parent_point->referral_point+$t_point,
                    'updated_at' => $date
                )
            );

            $user  = app('db')->table('customer')->where('id', '=', $id_user)->first();
            app('db')->table('point_transaction')->insert(
                array(
                    'id_user'         => $parent_id,
                    'type'            => 'debit', 
                    'amount'          => $t_point,
                    'current_balance' => $parent_point->referral_point+$t_point, 
                    'is_withdrawal'   => 'N',
                    'description'     => $user->fullname.' first transaction',
                    'created_at'      => $date
                )
            );
        }
    }

    public function transaction_process(Request $request){
        $vt = new Veritrans;
        $order_id = $request->input('order_id');
        $action = $request->input('action');
        switch ($action) {
            case 'status':
                $data = $vt->status($order_id);
                return response()->json(
                    array('status' => 'success', 'data' => $data)
                );
                break;
            case 'approve':
                $data = $vt->approve($order_id);
                return response()->json(
                    array('status' => 'success', 'data' => $data)
                );
                break;
            case 'expire':
                $data = $vt->expire($order_id);
                return response()->json(
                    array('status' => 'success', 'data' => $data)
                );
                break;
            case 'cancel':
                $data = $vt->cancel($order_id);
                return response()->json(
                    array('status' => 'success', 'data' => $data)
                );
                break;
        } 
    }

    public function booking_summary($booking_number){
        $purchase = app('db')->table('purchase')->where('booking_number', $booking_number)
                   ->join('service', 'purchase.id_service', '=', 'service.id')
                   ->join('customer', 'purchase.id_user', '=', 'customer.id')
                   ->select('service.name as service_name','purchase.start_date', 'purchase.id', 'customer.fullname', 'customer.email', 'purchase.voucher_code', 'purchase.point_use', 'purchase.amount')
                   ->first();
        $purchase_detail = app('db')->table('purchase_detail')->where('id_purchase', $purchase->id)
                           ->join('price', 'purchase_detail.id_price', '=', 'price.id')
                           ->select('purchase_detail.quantity', 'purchase_detail.price_title', 'price.rate_local', 'price.rate_wna')
                           ->get();
        $voucher = 0;
        if(!empty($purchase->voucher_code)){
             $voucher_code = app('db')->table('discount_code')->where('voucher_code', $purchase->voucher_code)->first();
             $voucher = $voucher_code->discount_amount;
        }

        $dt    = strtotime($purchase->start_date);
        $day   = date("l", $dt);
        $date  = date("j", $dt);
        $month = date("F", $dt);
        $year  = date("Y", $dt);
        
        $dates = $day.', '.$date.' '.$month.' '.$year;

        $emailcontent = array (
            'service'  => $purchase->service_name,
            'date'     => $dates,
            'user'     => $purchase->fullname,
            'purchase' => $purchase_detail,
            'amount'   => $purchase->amount,
            'point'    => $purchase->point_use,
            'voucher'  => $voucher,
            'email'    => $purchase->email,
            'booking_number' => $booking_number
        );

        Mail::send('email.booking_summary', $emailcontent, function($message) use ($emailcontent){
            $message->to($emailcontent['email'], 'Booking Summary')->subject('Booking Summary');
        });
    }

    public function withdrawalCreate(Request $request){
        $rules = array(
            'id_user'   => 'required',
            'amount'    => 'required',
            'bank_account_number' => 'required',
            'bank_name' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = date('Y-m-d H:i:s');
            $users  = app('db')->table('customer')->select('referral_point', 'email', 'fullname')->where('id', $request->id_user)->first();
            if($users->referral_point < 250000){
                return response()->json(['status' => 'failed','message' => 'At least 250.000 point needed to this withdrawn']);
            }elseif($users->referral_point < $request->amount){
                return response()->json(['status' => 'failed','message' => 'The maximum featours point to withdrawn is '.$users->referral_point]); //poin tidak cukup
            }
            else{
                $new_point = $users->referral_point - $request->amount;
                app('db')->table('customer')->where('id', $request->id_user)->update( 
                array(
                    'referral_point' => $new_point,
                    'updated_at' => $date
                    )
                );

                $id_wd = app('db')->table('withdrawal')->insertGetId(
                array(
                    'id_user'             => $request->id_user,
                    'bank_name'           => $request->bank_name,
                    'bank_account_number' => $request->bank_account_number,
                    'amount'              => $request->amount,
                    'recipient_name'      => $request->recipient_name,
                    'created_at'          => $date
                    )
                ); 

                app('db')->table('point_transaction')->insert(
                array(
                    'id_user'         => $request->id_user,
                    'id_relation'     => $id_wd,
                    'table_relation'  => 'withdrawal',
                    'type'            => 'credit', 
                    'amount'          => $request->amount,
                    'current_balance' => $new_point, 
                    'is_withdrawal'   => 'Y',
                    'description'     => 'You withdrawn '.$request->amount,
                    'created_at'      => $date
                    )
                );  

                //send email to user
                $dt2   = date('Y-m-d H:i:s', strtotime('+48 hours', strtotime($date)));
                $dt    = strtotime($dt2);
                $day   = date("l", $dt);
                $datej = date("j", $dt);
                $month = date("F", $dt);
                $year  = date("Y", $dt);
                $hour  = date("h", $dt);
                $minutes = date("i", $dt);
                $ampm    = date("A", $dt);
                
                $dates       = $day.', '.$datej.' '.$month.' '.$year;
                $cancel_date = $dates.' at '.$hour.':'.$minutes.' '.$ampm;

                //$cancel_date = date('Y-m-d H:i:s', strtotime('+48 hours', strtotime($date)));
                $id_ecrypt    = Crypt::encrypt($id_wd);
                $emailcontent = array (
                    'title'               => "Featours",
                    'id_withdrawal'       => $id_ecrypt,
                    'amount'              => $request->amount,
                    'bank_name'           => $request->bank_name,
                    'bank_account_number' => $request->bank_account_number,
                    'recipient_name'      => $request->recipient_name,
                    'cancel_date'         => $cancel_date,
                    'email'               => $users->email,
                    'name'                => $users->fullname
                );

                Mail::send('email.withdrawal_req', $emailcontent, function($message) use ($emailcontent){
                    $message->to($emailcontent['email'], '[Featours] Withdrawal')->subject('[Featours] Withdrawal');
                });
                return response()->json(['status' => 'success', 'current_point' => $new_point]);
            }
        }
    }


    public function transPoint(Request $request){
        $rules = array(
            'id_user'        => 'required',
            'mark'           => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()){
            $msg = $v->messages();
            return response()->json(['status'  => 'failed', 'message' => $msg->first()]);
        }
        else{
            $date = app('db')->select('select CURRENT_DATE() - INTERVAL 6 MONTH as old_date');
            foreach ($date as $d) {
                $later = $d->old_date;
            }

            $date_2 = app('db')->select('select CURRENT_DATE()+1 as now_date');
            foreach ($date_2 as $d_2) {
                $now = $d_2->now_date;
            }

            if($request->mark == '='){
                $transaction = app('db')->table('point_transaction')
                ->select('id as id_transaction', 'created_at as date', 'description', 'type', 'amount', 'current_balance')
                ->where('id_user', $request->id_user)
                ->whereBetween('created_at', [$later,$now])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

                $data = array_reverse($transaction);
            }elseif($request->mark == '<'){
                $transaction = app('db')->table('point_transaction')
                ->select('id as id_transaction', 'created_at as date', 'description', 'type', 'amount', 'current_balance')
                ->where('id_user', $request->id_user)
                ->where('id', '<', $request->id_transaction)
                ->whereBetween('created_at', [$later,$now])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

                $data = array_reverse($transaction);

            }elseif($request->mark == '>'){
                $transaction = app('db')->table('point_transaction')
                ->select('id as id_transaction', 'created_at as date', 'description', 'type', 'amount', 'current_balance')
                ->where('id_user', $request->id_user)
                ->where('id', '>', $request->id_transaction)
                ->whereBetween('created_at', [$later,$now])
                ->orderBy('created_at', 'desc')
                ->get();

                $data = array_reverse($transaction);
            }

            return response()->json(['status' => 'success','data' => $data]);
        }
    }
}
