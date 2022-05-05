<!DOCTYPE html>
<html>
<head>
	<title>Order Receipt</title>
	<!-- FOR JQUERY -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- FOR BOOTSTRAP -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js" integrity="sha512-YLG3N5dufxTTEyEgDIKb3IMDTz/NsWiGH6+6OvzrJBu/XZNRiZb9UxuNoMn8RdTtuKgpjtzTeWm/ITkZkj2i3Q==" crossorigin="anonymous"></script>

	<style type="text/css">
		.print{
			width: 500px;
			padding: 10px 10px;
		}
		.logo-container{
			display: flex;
			justify-content: center;
		}
		.logo-container img{
			width: 70px;
			height: 70px;
		}
		.products-container{
			padding: 20px 20px;
		}
		.product-details-content{
			display: inline-flex;
			justify-content: space-between;
			word-break: break-word;
		}
		.product-details-content .name-container{
			width: 200px;
		}
		.product-details-content .price-container{
			width: 200px;
		}
		.order-details-container{
			padding: 20px 20px;
		}
	</style>
</head>
<body>
	<div class="print">
		<div class="logo-container">
			<img src="<?= base_url().LOGO ?>">
		</div>
		<div class="order-details-container">
			<span>Date: <strong><?= date('M d, Y H:i a', strtotime($order['created_date'])) ?></strong></span><br>
			<span>Order Number: <strong><?= $order['order_number']; ?></strong></span><br>
			<span>Mode of Payment: <strong><?= $order['mode_of_payment']; ?></strong></span><br>
			<span>Staff: <strong><?= $user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'] ?></strong></span>
		</div>

		<div class="products-container">
			<span>Products: </span>
			<?php foreach ($products as $key => $product): ?>
				<div class="product-details-content">
					<div class="name-container"><?= $product->quantity ?> x <?= $product->name; ?></div>
					<div class="price-container"><span>&#8369;</span><?= number_format($product->price * $product->quantity, 2); ?></div>
				</div><br>
			<?php endforeach ?>
			<div class="product-details-content">
				<div class="name-container"><strong>Total Amount</strong></div>
				<div class="price-container"><strong><span>&#8369;</span><?= number_format($order['total_amount'],2) ?></strong></div>
			</div>
			<?php if ($order['mode_of_payment'] == "CASH"): ?>
				<hr>
				<div class="product-details-content">
					<div class="name-container"><strong>Cash Amount</strong></div>
					<div class="price-container"><strong><span>&#8369;</span><?= number_format($order['cash_payment_amount'],2) ?></strong></div>
				</div>
				<div class="product-details-content">
					<div class="name-container"><strong>Change</strong></div>
					<div class="price-container"><strong><span>&#8369;</span><?= number_format($order['cash_payment_amount'] - $order['total_amount'],2) ?></strong></div>
				</div>
			<?php endif ?>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		const element = $('.print').html();
		//var filename = $('.department-name').val()+"_bonus_"+$('.cut-off-date').val()+".pdf";

		var name = $('.name').text();
		var date = $('.date-payroll').text();
		var filename = '<?= $order['order_number'] ?>'+".pdf"
		var opt = {
		    margin:       .5,
		    filename:     filename,
		    image:        { type: 'jpeg', quality: 0.98 },
		    html2canvas:  {
		        scale: 1.2,           // higher quality
		        windowWidth: 10124,   // simulate a browser size that causes the page's responsive CSS to output a pleasing layout in the rendered PDF
		    },
		    jsPDF:        { unit: 'pt', format: 'dl', orientation: 'portrait' }
		};    
	    html2pdf().set(opt).from(element).save();
	    setTimeout(function(){
	    	window.close();
	    }, 1000)
	})
</script>