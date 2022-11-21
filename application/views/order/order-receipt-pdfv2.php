<?php
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
			<span>Receipt No.: #0001</span><br>
			<span>Cashier Name: '.$user_in_charge_details['firstname']." ".$user_in_charge_details['lastname'].'</span><br>
		</div><br>

		<div style="font-size: 13px; padding: 0px 0px;">
			<<<span>Dine - In</span>>>
		</div>

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
    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    ob_end_clean();
	$dompdf->stream($order['order_number'].".pdf", array("Attachment" => false));
?>