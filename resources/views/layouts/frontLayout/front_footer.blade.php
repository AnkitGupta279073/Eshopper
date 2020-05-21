<footer id="footer"><!--Footer-->
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="{{ url('/page/contact') }}">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="{{ url('/page/terms-condition') }}">Terms & Condition</a></li>
								<li><a href="{{ url('/page/privacy-policy') }}">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="{{ url('/page/about-us') }}">About Us</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="javascript:void(0)" class="searchform" type="post">
								@csrf
								<input onfocus="enableSubscriber();" onfocusout="checkSubscriber();" name="subscriber_email" id="subscriber_email" type="email" placeholder="Your email address" required="" />
								<button id="btnSubmit" type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<span id="statusSubscriber" style="display: none;color: red;"></span>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->

	<script type="text/javascript">
		function checkSubscriber() {
			var subscriber_email = $("#subscriber_email").val();
			$.ajax({

						type:'post',
						url:"/check-subscriber-email",
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data:{subscriber_email:subscriber_email},
						success:function(resp){
							if(resp == 'exit')
							{
								$("#btnSubmit").hide();
								$("#statusSubscriber").show();
								$("#statusSubscriber").html('Subscriber Email Already Exit.');
							}
							else if(resp == 'save')
							{
								$("#subscriber_email").html('');
								$("#btnSubmit").show();
								$("#statusSubscriber").show();
								$("#statusSubscriber").html('Thanku For Subscribing.');
							}
						},error:function(){
							alert("error");
						}
			});
		}

		function enableSubscriber() {
			$("#btnSubmit").show();
		}
	</script>