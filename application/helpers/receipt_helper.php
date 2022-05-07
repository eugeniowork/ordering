<?php 
	
	function generateOrderReceipt($order_id){
		$CI =& get_instance();

		$order_details = $CI->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);

		$products = $CI->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);

		$user_in_charge_id = $order_details['user_in_charge'];
		$user_in_charge_details = $CI->global_model->get("users", "*", "id = '$user_in_charge_id'", [], "single", []);

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
	    if($order_details['mode_of_payment'] == "CASH"){
	    	$for_cash .= "
	    		<tr>
					<th>Cash Amount</th>
					<th><span>Php </span>".number_format($order_details['cash_payment_amount'],2)."</th>
				</tr>
				<tr>
					<th>Change</th>
					<th><span>Php </span>".number_format($order_details['cash_payment_amount'] - $order_details['total_amount'],2)."</th>
				</tr>
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
				<span>Date: <strong>'.date('M d, Y h:i a', strtotime($order_details['created_date'])).'</strong></span><br>
				<span>Order Number: <strong>'.$order_details['order_number'].'</strong></span><br>
				<span>Mode of Payment: <strong>'.$order_details['mode_of_payment'].'</strong></span><br>
				<span>Staff: <strong>'.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</strong></span>
			</div><br>

			<div class="products-container" style="font-size: 12px; padding: 0px 20px;">
				<span>Products: </span>
				<table width="100%" cellspacing="0" cellpadding="3">
					<tbody>
						'.$products_list.'
					</tbody>
					<tfoot>
						<tr>
							<th>Total Amount</th>
							<th><span>Php </span>'.number_format($order_details['total_amount'],2).'</th>
						</tr>
						'.$for_cash.'
					</tfoot>
				</table>
			</div>
	    ';

	    $CI->load->library('dompdf_library');
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

	    $output = $dompdf->output();

	    return $output;
	}

	function generateCashInReceipt($cash_in_id){
		$CI =& get_instance();

		$cash_in_details = $CI->global_model->get("views_cash_in_request", "*","id = {$cash_in_id} ",[],"single", []);

		$user_in_charge_id = $cash_in_details['user_in_charge'];
		$user_in_charge_details = $CI->global_model->get("users", "*", "id = '$user_in_charge_id'", [], "single", []);

		$html = '
			<style>
			    @page {
			        margin: 0cm 0cm;
			    }
			</style>
			<div class="logo-container" style="font-size: 12px;">
				<center><img src="'.base_url().LOGO.'" style="width: 70px;height: 70px;"></center>
			</div><br>

			<center style="color: #007bff">Cash In Receipt</center><br>

			<div class="order-details-container" style="font-size: 12px; padding: 0px 20px;">
				<span>Staff: <strong>'.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</strong></span><br>
				<span>Date: <strong>'.date('M d, Y h:i a', strtotime($cash_in_details['created_date'])).'</strong></span><br>
				<span>Reference No: <strong>'.$cash_in_details['reference_no'].'</strong></span><br>
				<span>Amount: <strong>Php '.number_format($cash_in_details['request_amount'], 2).'</strong></span><br>
				<span>Cash Amount: <strong>Php '.number_format($cash_in_details['cash_amount'], 2).'</strong></span><br>
				<span>Change: <strong>Php '.number_format($cash_in_details['cash_amount'] - $cash_in_details['request_amount'], 2).'</strong></span><br>
			</div><br>
		';

		$CI->load->library('dompdf_library');
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

	    $output = $dompdf->output();

	    return $output;
	}
?>