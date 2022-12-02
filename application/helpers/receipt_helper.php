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
	    		<tfoot style='border-top:1px solid #333'>
		    		<tr>
						<th>Cash Amount</th>
						<th><span>Php </span>".number_format($order_details['cash_payment_amount'],2)."</th>
					</tr>
					<tr>
						<th>Change</th>
						<th><span>Php </span>".number_format($order_details['cash_payment_amount'] - $order_details['grand_total'],2)."</th>
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
					<tfoot style="border-top:1px solid #333">
						<tr>
							<th>Sub Total</th>
							<th><span>Php </span>'.number_format($order_details['total_amount'],2).'</th>
						</tr>
						<tr>
							<th>Discount</th>
							<th><span>Php </span>'.number_format($order_details['discount_total'],2).'</th>
						</tr>
						<tr>
							<th>Grand Total</th>
							<th><span>Php </span>'.number_format($order_details['grand_total'],2).'</th>
						</tr>
					</tfoot>
					'.$for_cash.'
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

		$title = "ADAMSON UNIVERSITY <br> ADAMSON-OZANAM EDUCATIONAL INSTITUITIONS, INC.";
		$company_address = "900 SAN MARCELINO ST. BRGY. 660-A ZONE 71 ERMITA MANILA";
		$company_tin = "001356269-000";

		$html = '
			<style>
				body{
					color: black;
					borders: 1px solid black;
				}
			    @page {
			        margin: 0px 270px;
			    }
			</style>
			<br>
			<div style="text-align:center; font-size: 10px; padding: 0px 10px;">
				<span>'.$title.'</span><br>
				<span>'.$company_address.'</span><br>
				<span>VAT REGISTERED TIN# '.$company_tin.' NVAT</span><br>
			</div><br>

			<div style="text-align:center; font-size: 15px; padding: 0px 1px;">
				<span>'.APPNAME.'</span>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<span>Date: '.date('d M Y', strtotime($cash_in_details['created_date'])).'</span>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<span>Receipt No.: '.$cash_in_details['reference_no'].'</span><br>
				<span>Cashier Name: '.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</span><br>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<table width="100%" cellspacing="0" cellpadding="3">
					<tbody>
						<tr>
							<td>Amount</td>
							<td style="text-align: right;"><b>P'.number_format($cash_in_details['request_amount'],2).'</b></td>
						</tr>
						<tr>
							<td>Cash Amount</td>
							<td style="text-align: right;"><b>P'.number_format($cash_in_details['cash_amount'],2).'</b></td>
						</tr>
						<tr>
							<td>Change</td>
							<td style="text-align: right;"><b>P'.number_format($cash_in_details['cash_amount'] - $cash_in_details['request_amount'],2).'</b></td>
						</tr>
					</tbody>
				</table>
			</div><br><br><br>

			<div style="text-align:center; font-size: 10px; padding: 0px 10px;">
				<span>DATE ISSUED: '.date('Y-m-d', strtotime($cash_in_details['created_date'])).'</span><br>
				<span>THIS SERVES AS AN OFFICIAL RECEIPT</span>
				<span>"THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAX"</span>
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
		$dompdf->setPaper('A4', 'portrait');

		$dompdf->render();

	    $output = $dompdf->output();

	    return $output;
	}

	function generateOrderReceiptV2($order_id){
		$CI =& get_instance();

		$order = $CI->global_model->get("views_order_history", "*", "id = '$order_id'", [], "single", []);

		$products = $CI->global_model->get("order_history_products", "*", "order_history_id = '$order_id'", [], "multiple", []);

		//GET DISCOUNTS
		$order_discounts = $CI->global_model->get("order_history_discounts", "*", "order_history_id = '$order_id'", [], "multiple", []);

		$user_in_charge_id = $order['user_in_charge'];
		$user_in_charge_details = $CI->global_model->get("users", "*", "id = '$user_in_charge_id'", [], "single", []);

		$title = "ADAMSON UNIVERSITY <br> ADAMSON-OZANAM EDUCATIONAL INSTITUITIONS, INC.";
		$company_address = "900 SAN MARCELINO ST. BRGY. 660-A ZONE 71 ERMITA MANILA";
		$company_tin = "001356269-000";

		$total_vatable = 0;
		$total_vat = 0;
		$products_list = "";
		foreach ($products as $key => $product) {
			$total_vatable += ($product->price_without_vat * $product->quantity);
			$total_vat += ($product->price * $product->quantity);

			$products_list .= "
				<tr>
					<td style='text-align: left;'>".$product->name."</td>
					<td style='text-align: right;'>P".number_format($product->price, 2)."</td>
					<td style='text-align: right;'>".$product->quantity. "</td>
					<td style='text-align: right;'>P".number_format($product->price * $product->quantity, 2)."</td>
				</tr>
			";
		}

		$discount_list = "";
		foreach ($order_discounts as $key => $discount) {
			$discount_list .= "
				<tr>
					<td style='text-align: left;' colspan='3'><b>".$discount->name."</b></td>
					<td style='text-align: right;'>- P".number_format($discount->amount, 2)."</td>
				</tr>
			";
		}

		$points_redeem = "";
	    if($order['points_redeem'] > 0){
	    	$points_redeem .= "
	    		<tr>
	    			<td style='text-align: left;' colspan='3'><b>Points Redeem</b></td>
	    			<td style='text-align: right;'>- P".number_format($order['points_redeem'], 2)."</td>
	    		</tr>
	    	";
	    }

		$cash_amount = "";
		$change_amount = "";
		if($order['mode_of_payment'] == "CASH"){
			$cash_amount = "
				<tr>
					<td style='text-align: left;' colspan='3'><b>Cash</b></td>
					<td style='text-align: right;'>P".number_format($order['cash_payment_amount'], 2)."</td>
				</tr>
			";

			$change_amount = "
				<tfoot style='border-top:2px dashed #c9c5c5;'>
		    		<tr>
		    			<td style='text-align: left;' colspan='3'><b>Change</b></td>
		    			<td style='text-align: right;'>P".number_format($order['cash_payment_amount'] - $order['grand_total'], 2)."</td>
		    		</tr>
				</tfoot>
			";
		}

		$html = '
			<style>
				body{
					color: black;
					borders: 1px solid black;
				}
			    @page {
			        margin: 0px 270px;
			    }
			</style>
			<br>
			<div style="text-align:center; font-size: 10px; padding: 0px 10px;">
				<span>'.$title.'</span><br>
				<span>'.$company_address.'</span><br>
				<span>VAT REGISTERED TIN# '.$company_tin.' NVAT</span><br>
			</div><br>

			<div style="text-align:center; font-size: 15px; padding: 0px 1px;">
				<span>'.APPNAME.'</span>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<span>Date: '.date('d M Y', strtotime($order['actual_date_pickup'])).'</span>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<span>Receipt No.: '.$order['order_number'].'</span><br>
				<span>Cashier Name: '.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</span><br>
			</div><br>

			<div style="font-size: 13px; padding: 0px 0px;">
				<table width="100%" cellspacing="0" cellpadding="3">
					<thead style="border-bottom:2px dashed #c9c5c5;">
						<tr>
							<th style="text-align: left;">Item</th>
							<th style="text-align: right;">Price</th>
							<th style="text-align: right;">Qty</th>
							<th style="text-align: right;">Total</th>
						</tr>
					</thead>
					<tbody>
						'.$products_list.'
					</tbody>

					<tfoot style="border:2px dashed #c9c5c5; border-right: none; border-left: none; font-size: 17px;">
						<tr>
							<td style="text-align: center;" colspan="3">Total</td>
							<td style="text-align: right;"><b>P'.number_format($order['total_amount'],2).'</b></td>
						</tr>
					</tfoot>

					<tfoot style="border-top:2px dashed #c9c5c5;">
						<tr>
							<td style="text-align: left;" colspan="3"><b>Sub Total</b></td>
							<td style="text-align: right;">P'.number_format($order['total_amount'],2).'</td>
						</tr>
						'.$discount_list.'
						'.$points_redeem.'
						'.$cash_amount.'
						<tr>
							<td style="text-align: left;" colspan="3"><b>Total Payment</b></td>
							<td style="text-align: right;">P'.number_format($order['grand_total'],2).'</td>
						</tr>
					</tfoot>
					'.$change_amount.'

					<tfoot style="border:2px dashed #c9c5c5; border-right: none; border-left: none;">
						<tr>
							<td style="text-align: left;" colspan="3"><b>Total Vatable</b></td>
							<td style="text-align: right;">P'.number_format($total_vatable,2).'</td>
						</tr>
						<tr>
							<td style="text-align: left;" colspan="3"><b>Total Vat</b></td>
							<td style="text-align: right;">P'.number_format($total_vat - $total_vatable,2).'</td>
						</tr>
					</tfoot>
				</table>
			</div><br><br><br>

			<div style="text-align:center; font-size: 10px; padding: 0px 10px;">
				<span>DATE ISSUED: '.date('Y-m-d', strtotime($order['actual_date_pickup'])).'</span><br>
				<span>THIS SERVES AS AN OFFICIAL RECEIPT</span>
				<span>"THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAX"</span>
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
		$dompdf->setPaper('A4', 'portrait');

	    $dompdf->render();

	    $output = $dompdf->output();

	    return $output;
	}
?>