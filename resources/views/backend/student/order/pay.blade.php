<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<?php $rpayAmount = $order->total_amount; ?>
<body onload="clickrpaybutton()">
	<button id="rzp-button1" style="display: none;">Pay</button>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	{!!Form::open(['method' => 'POST', 'action' => ['App\Http\Controllers\Backend\OrdersController@paymentResponse'], 'class' => 'form-horizontal','name'=>'razorpayform'])!!}
	    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
	    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
	    <input type="hidden" name="razorpay_order_id"  id="razorpay_order_id" >
	{!!Form::close()!!}
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script type="text/javascript">
		var options = {
		    "key": "{{$_ENV['RAZORPAYAPIKEY']}}", // Enter the Key ID generated from the Dashboard
		    "currency": "INR",
		    "name": "LMS",
		    "backdrop":false,
		    "description": "Payment for Order Id : {{$order->id}}",
		    "image": "{{ asset('frontend/images/logo.svg') }}",
		    "order_id": "{{$order->razorpay_order_id}}",
		    "handler": function (response){
		    	document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
			    document.getElementById('razorpay_signature').value = response.razorpay_signature;
			    document.getElementById('razorpay_order_id').value = "{{encrypt($order->razorpay_order_id)}}";
			    document.razorpayform.submit();
		    },
		    "prefill": {
		        "name": "{{$order->user->name}}",
		        "email": "{{$order->user->email}}",
		        "contact": "{{$order->user->phone_number}}"
		    },
		    "notes":{
		    	"merchant_order_id":"{{$order->id}}"
		    },
		    "theme": {
		        "color": "#F44236"
		    },
		    "modal": {
		    	"ondismiss": function(){
			            window.location.href = "{{route('order.details',encrypt($order->id))}}";
		        }
		    }
		};
		var rzp1 = new Razorpay(options);
		document.getElementById('rzp-button1').onclick = function(e){
		    rzp1.open();
		    e.preventDefault();
	}
	</script>
	<script type="text/javascript">
		function clickrpaybutton()
		{
			document.getElementById('rzp-button1').click();
		}
	</script>
</body>
</html>