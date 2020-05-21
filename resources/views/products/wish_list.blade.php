@extends('layouts.frontLayout.front_design')
@section('content')
<?php use App\Product; ?>
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Wish List</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				@if(Session::has('flash_message_success'))
		            <div class="alert alert-success alert-block">
		                <button type="button" class="close" data-dismiss="alert">×</button> 
		                    <strong>{!! session('flash_message_success') !!}</strong>
		            </div>
		        @endif
		        @if(Session::has('flash_message_error'))
		            <div class="alert alert-error alert-block" style="background-color:#f4d2d2">
		                <button type="button" class="close" data-dismiss="alert">×</button> 
		                    <strong>{!! session('flash_message_error') !!}</strong>
		            </div>
        		@endif   
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php $total_amount = 0; ?>
						@foreach($userWishList as $wishlist)
							<tr>
								<td class="cart_product">
									<a href=""><img style="width:100px;" src="{{ asset('/images/backend_images/product/small/'.$wishlist->image) }}" alt=""></a>
								</td>
								<td class="cart_description">
									<h4><a href="">{{ $wishlist->product_name }}</a></h4>
									<p>Product Code: {{ $wishlist->product_code }}</p>
								</td>
								<td class="cart_price">
									@php
										$productPrice = Product::getProductPrice($wishlist->product_id,$wishlist->size)
									@endphp
									<p>INR {{ $productPrice }}</p>
								</td>
								<td class="cart_quantity">
									<p>{{ $wishlist->quantity }}</p>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">INR {{ $productPrice*$wishlist->quantity }}</p>
								</td>
								<form name="addtoCartForm" id="addtoCartForm" action="{{ url('add-cart') }}" method="post">{{ csrf_field() }}
		                        <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}">
		                        <input type="hidden" name="product_name" value="{{ $wishlist->product_name }}">
		                        <input type="hidden" name="product_code" value="{{ $wishlist->product_code }}">
		                        <input type="hidden" name="product_color" value="{{ $wishlist->product_color }}">
		                        <input type="hidden" name="price" id="price" value="{{ $wishlist->price }}">
		                        <input type="hidden" name="size" id="size" value="{{ $wishlist->product_id }}-{{ $wishlist->size }}">
								<td class="cart_delete">
									<button type="submit" class="btn btn-fefault cart" id="cartButton" name="cartButton" value="Add to Cart">
												<i class="fa fa-shopping-cart"></i>
												Add to Cart
											</button>
									<a class="cart_quantity_delete" href="{{ url('/wish-list/delete-product/'.$wishlist->id) }}"><i class="fa fa-times"></i></a>
								</td>
								</form>
							</tr>
							<?php $total_amount = $total_amount + ($productPrice*$wishlist->quantity); ?>
						@endforeach
						
					</tbody>
				</table>
			</div>
		</div>
</section> <!--/#wishlist_items-->
@endsection