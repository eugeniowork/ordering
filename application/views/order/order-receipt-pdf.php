<?php
	$products_list = "";
    foreach ($products as $key => $product) {
    	$products_list .= "
    		<tr>
    			<td>".$product->quantity. " x " . $product->name."</td>
    			<td>Php ".number_format($product->price * $product->quantity, 2)."</td>
    		</tr>
    	";
    }

    $for_cash = "";
    if($order['mode_of_payment'] == "CASH"){
    	$for_cash .= "
    		<tfoot style='border-top:1px solid #333'>
	    		<tr>
					<th>Cash Amount</th>
					<th><span>Php </span>".number_format($order['cash_payment_amount'],2)."</th>
				</tr>
				<tr>
					<th>Change</th>
					<th><span>Php </span>".number_format($order['cash_payment_amount'] - $order['grand_total'],2)."</th>
				</tr>
			</tfoot>
    	";
    }

    $html = '
    	<style>
		    @page {
		        margin: 0cm 0cm;
		    }
		</style>
		<div class="logo-container" style="font-size: 12px;">
			<center><img src="'.base_url().LOGO.'" style="width: 70px;height: 70px;"></center>
		</div><br>

		<div class="order-details-container" style="font-size: 12px; padding: 0px 20px;">
			<span>Date: <strong>'.date('M d, Y h:i a', strtotime($order['created_date'])).'</strong></span><br>
			<span>Order Number: <strong>'.$order['order_number'].'</strong></span><br>
			<span>Mode of Payment: <strong>'.$order['mode_of_payment'].'</strong></span><br>
			<span>Staff: <strong>'.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</strong></span>
		</div><br>

		<div class="products-container" style="font-size: 12px; padding: 0px 20px;">
			<span>Products: </span>
			<table width="100%" cellspacing="0" cellpadding="3">
				<tbody>
					'.$products_list.'
				</tbody>
				<tfoot style="border-top:1px solid #333">
					<tr>
						<th>Sub Total</th>
						<th><span>Php </span>'.number_format($order['total_amount'],2).'</th>
					</tr>
					<tr>
						<th>Discount</th>
						<th><span>Php </span>'.number_format($order['discount_total'],2).'</th>
					</tr>
					<tr>
						<th>Grand Total</th>
						<th><span>Php </span>'.number_format($order['grand_total'],2).'</th>
					</tr>
				</tfoot>
				'.$for_cash.'
			</table>
		</div>
    ';

	$this->load->library('dompdf_library');

	$options = new Dompdf\Options();
    $options->setTempDir('temp'); // temp folder with write permission
    $options->setIsRemoteEnabled(true);

    $dompdf = new Dompdf\DOMPDF();
    $dompdf->setOptions($options);
    $dompdf->set_option('enable_html5_parser', TRUE);

	$dompdf->loadHtml($html);

	//DOM PDF SIZE CONVERTION
    //1 inch = 72 point
    //1 inch = 2.54 cm
    // 1 1/4 = 1.25 inch = 3.175 cm = 3.175/2.54*72 = 90 height
    //1 3/4 = 1.75 inch = 4.445 cm = 4.445/2.54*72 = 126 width
    // array('','',width, height)
    $dompdf->setPaper(array(0,0,200,300));

    $dompdf->render();

    ob_end_clean();
	$dompdf->stream($order['order_number'].".pdf", array("Attachment" => false));
?>