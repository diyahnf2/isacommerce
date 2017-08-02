<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;


class apiMaintenance extends Controller
{
	public function __construct()
    {
        date_default_timezone_set('asia/jakarta');
    }

    

    public function sync_referral_point(){
    	app('db')->table('customer')->update( 
			array(
				'referral_point' => 0
			)
		);

		$referral  = app('db')->table('referral')->get();
		foreach ($referral as $r) {
			$id_user   = $r->id_user;
			$id_parent = $r->parent_id;

			$s_point = app('db')->table('referral_point_set')->where('type', '=', 'S')->first();
			$t_point = app('db')->table('referral_point_set')->where('type', '=', 'T')->first();

			$user  = app('db')->table('customer')->select('referral_point')->where('id', $id_user)->first();
			app('db')->table('customer')->where('id', $id_user)->update( 
			array(
				'referral_point' => $user->referral_point + $t_point->point
				)
			);

			$parent  = app('db')->table('customer')->select('referral_point')->where('id', $id_parent)->first();
			if($r->is_transaction == 1){
				app('db')->table('customer')->where('id', $id_parent)->update( 
					array(
						'referral_point' => $parent->referral_point + $s_point->point + $t_point->point
					)
				);
			}else{
				app('db')->table('customer')->where('id', $id_parent)->update( 
					array(
						'referral_point' => $parent->referral_point + $s_point->point
					)
				);
			}
		}

		$point_transaction  = app('db')->table('point_transaction')
		->join('customer', 'point_transaction.id_user', '=', 'customer.id')
		->select('amount', 'id_user')
		->where('type', 'credit')->get();

		foreach ($point_transaction as $p) {
			$user = app('db')->table('customer')->select('referral_point')->where('id', $p->id_user)->first();
			app('db')->table('customer')->where('id', $p->id_user)->update( 
			array(
				'referral_point' => $user->referral_point - $p->amount
				)
			);
		}

		return response()->json(
			array('status' => 'success','message' => 'Synchronization has been completed !')
		);
    }



    public function delete_parent($email){
    	$user  = app('db')->table('customer')->select('id')->where('email', $email)->first();
    	app('db')->table('referral')->where('id_user', $user->id)->delete();

    	return response()->json(
			array('status' => 'success','message' => 'Delete completed !')
		);
    }

    public function cancel_withdrawal($id){
    	try{
    		//date check
    		$date = date('Y-m-d H:i:s');
    		$id_withdrawal = Crypt::decrypt($id);
	    	$user  = app('db')->table('withdrawal')->select('id_user', 'amount', 'created_at')->where('id', $id_withdrawal)->first();
	    	$exp_date = date('Y-m-d H:i:s', strtotime('+48 hours', strtotime($user->created_at)));
	    	if($exp_date >= $date){
	    		$user_point  = app('db')->table('customer')->select('referral_point')->where('id', $user->id_user)->first();
		    	$new_point = $user->amount + $user_point->referral_point;

		    	app('db')->table('customer')->where('id', $user->id_user)->update( 
					array(
						'referral_point' => $new_point
					)
				);

				app('db')->table('withdrawal')->where('id', $id_withdrawal)->delete();
				app('db')->table('point_transaction')->where('id_relation', $id_withdrawal)->where('table_relation', 'withdrawal')->delete();
				$msg = 'Your withdrawal has successfuly canceled.';
    		}else{
    			$msg = 'Sorry, your withdrawal has been processed.';
    		}
	    }

    	catch(\Exception $e){
            $msg = 'Your withdrawal has failed to canceled.';
        }
		
		return view('email.withdrawal_confirm')->with('message', $msg);
    }
}