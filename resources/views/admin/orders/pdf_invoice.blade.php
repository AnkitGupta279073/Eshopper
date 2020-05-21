<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style type="text/css">
        .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/frontend_images/home/logo.png">
      </div>
      <h1>INVOICE</h1>
      <div id="project" class="clearfix">
        <div><span>Order ID </span> #{{ $orderDetails->id }}</div>
        <div><span>Order Date</span> {{ $orderDetails->created_at }}</div>
        <div><span>Order Amount</span> {{ $orderDetails->grand_total }}</div>
        <div><span>Order Status</span> {{ $orderDetails->order_status }}</div>
        <div><span>Payment Method</span> {{ $orderDetails->payment_method }}</div>
      </div>
      <div id="project" style="float: right;">
        <div><strong>Shipping Address</strong></div>
        <div>{{ $orderDetails->name }}</div>
        <div>{{ $orderDetails->address }}</div>
        <div>{{ $orderDetails->city }}</div>
        <div>{{ $orderDetails->state }}</div>
        <div>{{ $orderDetails->country }}</div>
        <div>{{ $orderDetails->pincode }}</div>
        <div>{{ $orderDetails->mobile }}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
              <td style="width:18%"><strong>Product Code</strong></td>
              <td style="width:18%" class="text-center"><strong>Size</strong></td>
              <td style="width:18%" class="text-center"><strong>Color</strong></td>
              <td style="width:18%" class="text-center"><strong>Price</strong></td>
              <td style="width:18%" class="text-center"><strong>Qty</strong></td>
              <td style="width:18%" class="text-right"><strong>Totals</strong></td>
            </tr>
        </thead>
        <tbody>
          <?php $Subtotal = 0; ?>
          @foreach($orderDetails->orders as $pro)
          <tr>
            <td class="text-left">{{ $pro->product_code }}</td>
            <td class="text-center">{{ $pro->product_size }}</td>
            <td class="text-center">{{ $pro->product_color }}</td>
            <td class="text-center">INR {{ $pro->product_price }}</td>
            <td class="text-center">{{ $pro->product_qty }}</td>
            <td class="text-right">INR {{ $pro->product_price * $pro->product_qty }}</td>
          </tr>
          <?php $Subtotal = $Subtotal + ($pro->product_price * $pro->product_qty); ?>
          @endforeach
          <tr>
            <td colspan="5">SUBTOTAL</td>
            <td class="total">INR {{ $Subtotal }}</td>
          </tr>
          <tr>
            <td colspan="5"><strong>Shipping Charges (+)</strong></td>
            <td class="total">INR {{ $orderDetails->shipping_charges }}</td>
          </tr>
          <tr>
            <td colspan="5"><strong>Coupon Discount (-)</strong></td>
            <td class="total">INR {{ $orderDetails->coupon_amount }}</td>
          </tr>
          <tr>
            <td colspan="5" class="grand total">GRAND TOTAL</td>
            <td class="grand total">INR {{ $orderDetails->grand_total }}</td>
          </tr>
        </tbody>
      </table>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>