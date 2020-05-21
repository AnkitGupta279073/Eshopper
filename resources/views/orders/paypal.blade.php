@extends('layouts.frontLayout.front_design')
@section('content')
<?php use App\Order;

if(empty(Session::get('grand_total')) || empty(Session::get('grand_total')))
{
	return redirect('/');
	
}
?>
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="#">Home</a></li>
			  <li class="active">Thanks</li>
			</ol>
		</div>
	</div>
</section>

<section id="do_action">
	<div class="container">
		<div class="heading" align="center">
			<h3>YOUR ORDER HAS BEEN PLACED</h3>
			<p>Your order number is {{ Session::get('order_id') }} and total payable about is INR {{ Session::get('grand_total') }}</p>
			<p>Please make payment by clicking on below Payment Button</p>
			<?php
			$orderDetails = Order::getOrderDetails(Session::get('order_id'));
			$orderDetails = json_decode(json_encode($orderDetails));
			/*echo "<pre>"; print_r($orderDetails); die;*/
			$nameArr = explode(' ',$orderDetails->name);
			if (array_key_exists(1, $nameArr)) {

                $last_name = $nameArr[1];
            
            }else
            {
                $last_name = "";
            }
           
			$getCountryCode = Order::getCountryCode($orderDetails->country);
			?>
			 <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="sb-kfzjb1497304@business.example.com">
				<input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
				<input type="hidden" name="currency_code" value="INR">
				<input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
				<input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
				<input type="hidden" name="last_name" value="{{ $last_name }}">
				<input type="hidden" name="address1" value="{{ $orderDetails->address }}">
				<input type="hidden" name="address2" value="">
				<input type="hidden" name="city" value="{{ $orderDetails->city }}">
				<input type="hidden" name="state" value="{{ $orderDetails->state }}">
				<input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
				<input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
				<input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
				<input type="hidden" name="return" value="{{ url('paypal/thanks') }}">
				<input type="hidden" name="cancel_return" value="{{ url('paypal/cancel') }}">
				<input type="hidden" name="notify_url" value="{{ url('/paypal/ipn') }}">
				<input type="hidden" name="cpp_header_image" value="http://sample_site.com/images/product1.jpg">
          		<input type="hidden" name="currency_code" value="INR">
          		<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          		<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	</div>
</section>

@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>