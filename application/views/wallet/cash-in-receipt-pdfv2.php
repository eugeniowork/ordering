<?php
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
	$dompdf->stream("receipt.pdf", array("Attachment" => false));
?>