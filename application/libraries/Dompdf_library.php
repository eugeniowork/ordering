<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
class Dompdf_library {
		
	public function __construct() {
		$pdf = new Dompdf();

		$CI =& get_instance();
		$CI->pdf = $pdf;
		
	}
	
}