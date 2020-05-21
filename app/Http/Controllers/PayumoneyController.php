<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Softon\Indipay\Facades\Indipay;  
use Session;
use App\Order;
class PayumoneyController extends Controller
{
    public function payumoneyPayment()
    {
    	$order_id = Session::get('order_id');
    	$grand_total = Session::get('grand_total');
    	$orderDetails = Order::where('id',$order_id)->first();
    	
    	$orderDetails = json_decode(json_encode($orderDetails));
    	$nameArr = explode(' ',$orderDetails->name);
    	if(empty($nameArr[1]))
    	{
    		$lastname = "";
    	}
    	else
    	{
    		$lastname = $nameArr[1];
    	}
    	$parameters = [
        'txnid' => $order_id,
        'order_id' => $order_id,
        'amount' => $grand_total,
        'firstname'=>$nameArr[0],
        'lastname'=>$lastname,
        'email'=>$orderDetails->user_email,
        'phone'=>$orderDetails->mobile,
        'productinfo'=> $order_id,
        'service_provider'=>'',
        'zipcode'=>$orderDetails->pincode,
        'city'=>$orderDetails->city,
        'state'=>$orderDetails->state,
        'country'=>$orderDetails->country,
        'address1'=>$orderDetails->address,
        'address2'=>'',
        'curl'=>url('payumoney/response'),
      ];
      
      $order = Indipay::prepare($parameters);
      return Indipay::process($order);
    }

    public function payumoneyResponse(Request $request)
    {
    	$response = Indipay::response($response);
    	if($response['status'] == 'success' && $response['unmappedstatus'] == 'captured'){
    		echo "success";
    	}
    	else
    	{
    		echo "fails";
    	}
    }
}
