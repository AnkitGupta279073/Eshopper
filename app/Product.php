<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use Session;

class Product extends Model
{
    public function attributes(){
    	return $this->hasMany('App\ProductsAttribute','product_id');
    }

    public static function cartCount()
    {
    	if(Auth::check())
    	{
    		// if user is login

    		$user_email = Auth::User()->email;
    		$cartCount = DB::table('cart')->where('user_email',$user_email)->sum('quantity');
    	}
    	else
    	{
    		// if user is not login
    		$session_id = Session::get('session_id');
    		$cartCount = DB::table('cart')->where('session_id',$session_id)->sum('quantity');	
    	}
    	return $cartCount;
    }

    public static function productCount($cat_id)
    {
    	return $productCount = Product::where(['category_id'=>$cat_id,'status'=>1])->count();

    }
    public static function getCurrencyRates($price){
        $getCurrencies = Currency::where('status',1)->get();
        foreach($getCurrencies as $currency){
            if($currency->currency_code == "USD"){
                $USD_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == "GBP"){
                $GBP_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == "EUR"){
                $EUR_Rate = round($price/$currency->exchange_rate,2);
            }
        }
        $currenciesArr = array('USD_Rate'=>$USD_Rate,'GBP_Rate'=>$GBP_Rate,'EUR_Rate'=>$EUR_Rate);
        return $currenciesArr;
    }

    public static function getProductStock($product_id,$product_size)
    {
            $getProductStock = ProductsAttribute::select('stock')->where('product_id',$product_id)->where('size',$product_size)->first();
            return $getProductStock->stock;
    }

    public static function deleteCartProduct($cart_id,$user_email)
    {
        DB::table('cart')->where('id',$cart_id)->where('user_email',$user_email)->delete();
    }

    public static function getProductStatus($product_id)
    {
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }

    public static function getAttributeCount($product_id,$product_size)
    {
            $getAttributeCount = ProductsAttribute::where('product_id',$product_id)->where('size',$product_size)->count();
            return $getAttributeCount;
    }

    public static function getCategoryStatus($category_id)
    {
            $getCategoryStatus = Category::select('status')->where('id',$category_id)->first();
            return $getCategoryStatus->status;
    }

    public static function getShippingCharges($total_weight,$country){
        $shippingDetails = ShippingCharge::where('country',$country)->first();
        if($total_weight>0){
            if($total_weight>0 && $total_weight<=500){
                $shipping_charges = $shippingDetails->shipping_charges0_500g;
            }else if($total_weight>=501 && $total_weight<=1000){
                $shipping_charges = $shippingDetails->shipping_charges0_1000g;
            }else if($total_weight>=1001 && $total_weight<=2000){
                $shipping_charges = $shippingDetails->shipping_charges1001_2000g;
            }else if($total_weight>=2001 && $total_weight<=5000){
                $shipping_charges = $shippingDetails->shipping_charges2001_5000g;
            }else{
                $shipping_charges = 0;    
            }
        }else{
            $shipping_charges = 0;
        }
        return $shipping_charges;
    }

    public static function getGrandTotal()
    {
        $getGrandTotal = '';
        $user_email = Auth::user()->email;
        $cart_details = DB::table('cart')->where('user_email',$user_email)->get();
        $cart_details = json_decode(json_encode($cart_details),true);
       
        // echo $cart_details['product_id'];
        foreach($cart_details as $cart)
        {
            
            $productPrice = ProductsAttribute::where(['product_id'=>$cart['product_id'],'size'=>$cart['size']])->first();
            // print_r($productPrice);exit();
            $priceArray[] = $productPrice->price;
        }
        $getGrandTotal = array_sum($priceArray) - Session::get('CouponAmount') + Session::get('ShippingCharges');
        return $getGrandTotal;
    }

    public static function getProductPrice($product_id,$size)
    {
        $getProductPrice = ProductsAttribute::select('price')->where('product_id',$product_id)->where('size',$size)->first();
        return $getProductPrice->price;
    }
}
