<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 


use Dompdf\Dompdf;

class Pdf
{ 
    public function __construct() 
    { 
        require_once 'dompdf/autoload.inc.php';
        $pdf = new DOMPDF();

        $CI =& get_instance();
        $CI->dompdf = $pdf;
    } 
} 
?>