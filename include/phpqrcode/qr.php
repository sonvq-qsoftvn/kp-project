<?php 
    
    //html PNG location prefix
    

    include "qrlib.php";   
	
	function get_qr_image($qrcode){
		 //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
		$PNG_WEB_DIR = 'temp/';
		//ofcourse we need rights to create temp dir
		if (!file_exists($PNG_TEMP_DIR))
		mkdir($PNG_TEMP_DIR); 		
		$filename = $PNG_TEMP_DIR.'test.png';
		
		//processing form input
		//remember to sanitize user input in real-life solution !!!
		$errorCorrectionLevel = 'L';
		$errorCorrectionLevel = 'M';    
		
		$matrixPointSize = 6;
		$matrixPointSize = min(max((int)6, 1), 10);		
		
		// user data
		$filename = $PNG_TEMP_DIR.'test'.md5($qrcode.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($qrcode, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		
		//display generated file
		//echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
		return $PNG_WEB_DIR.basename($filename);
	
	}
    
   

    