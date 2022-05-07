<?php 
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
	$dompdf->stream($cash_in_details['reference_no'].".pdf", array("Attachment" => false));

?>