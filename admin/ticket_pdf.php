<?php
//pdf ticket
//include file
include('../include/admin_inc.php');
include('../include/phpqrcode/qr.php');
require('../include/pdf_barcode/alphapdf.php');
include('../include/pdf_barcode/Barcode.php');

//create object
$objlist=new admin;
$obj=new admin;
$obj_venue=new admin;
$obj_event=new admin;
$obj_events=new admin;
$obj_order=new admin;

$order_id=$_REQUEST['order_id'];

//session value
$organization_id=$_SESSION['ses_organization_id'];

//order by id
$obj->order_detail_by_Userid($order_id,$organization_id);
if($obj->num_rows()>0){
$obj->next_record();

//event by id
$objlist->event_by_id($obj->f('event_id'));
$objlist->next_record();
//get venue
$obj_venue->venue_by_id($objlist->f('venue'));
$obj_venue->next_record();

 	$pdf = new AlphaPDF('P', 'pt');
	
	//get order detail
	$obj_order->orders_detail_by_id($order_id);			
	while($obj_order->next_record()){
	
	//event detail by id 
	$obj_event->eventdetail_by_id($obj->f('event_id'));
	$obj_event->next_record();
	
	//price event
	$obj_events->event_price_detail($obj->f('event_id'),$obj_order->f('price_level_id'));
	$obj_events->next_record();
	// -------------------------------------------------- //
	//                  PROPERTIES
	// -------------------------------------------------- //
	
	$fontSize = 8;
	$marge    = 7;   // between barcode and hri in pixel
	$x        = 496;  // barcode center
	$y        = 150;  // barcode center
	$height   = 30;   // barcode height in 1D ; module size in 2D
	$width    = 1.1;    // barcode height in 1D ; not use in 2D
	$angle    = 270;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
	
	$code     = $obj_order->f('barcode'); // barcode, of course ;)
	//$code     = '12345678906665\n';
	//$code     = '923456789237';
	//$type     = 'ean13';
	//$type     = 'code39';
	$type     = 'code128';
	$black    = '000000'; // color in hexa	
	
	// -------------------------------------------------- //
	//            ALLOCATE FPDF RESSOURCE
	// -------------------------------------------------- //
	
	$pdf->AddPage();
	
	// -------------------------------------------------- //
	//                      BARCODE
	// -------------------------------------------------- //
	
	$data = Barcode::fpdf($pdf, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
	$pdf->SetFont('Arial','B',$fontSize);
	$pdf->SetTextColor(0, 0, 0);
	$len = $pdf->GetStringWidth($data['hri']);
	Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
	$pdf->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
	
	// -------------------------------------------------- //
	//                      HRI
	// -------------------------------------------------- //
	
	$pdf->SetFont('Arial','B',$fontSize);
	$pdf->SetTextColor(0, 0, 0);
	
	//include('include/barcode/html/test.php');
	//$pdf = new FPDF();
	//$pdf->AddPage();
	$pdf->SetFont('Arial','',11);
	//for($i=1;$i<=300;$i++)
	//$pdf->Cell(0,5,"Line $i",0,1);
	// Logo
	$pdf->Image($obj_base_path->base_path().'/images/logo.jpg',60,30,100);
	$pdf->text(490,42,'Admit one');
	$pdf->text(348,54,'Print this ticket & present it at the event');
	$pdf->SetFont('Arial','',12);
	$pdf->Image($obj_base_path->base_path().'/images/barcode1.jpg',60,80,400);
	$pdf->Image($obj_base_path->base_path().'/images/barcode2.jpg',522,80,16);
	//qr image
	//$pdf->Image($obj_base_path->base_path().'/include/phpqrcode/'.get_qr_image($obj->f('qr_code')),372,115,78);
	$pdf->Image($obj_base_path->base_path().'/include/phpqrcode/'.get_qr_image('testpqr'),372,115,78);
	
	if($obj->f('ticket_holder'))
	$pdf->text(80,109,$obj->f('ticket_holder'));
	else
	$pdf->text(80,109,$obj_order->f('ticket_holder'));
	
	
	$pdf->text(80,123,$obj_events->f('price_name'));
	$pdf->SetFont('Arial','',8);
	$pdf->text(255,109,'Face Value $'.number_format($obj_events->f('price_amount'),2,'.', ''));
	$pdf->SetFont('Arial','B',12);
	//event name
	if(substr($objlist->f('event_name'),38,1)!=' '){
		$st='-';
		//$st=substr($objlist->f('event_name'),39,1);
	}
	$pdf->text(80,152,substr($objlist->f('event_name'),0,39).$st);
	$pdf->text(80,165,substr($objlist->f('event_name'),39,39));
	
	if($obj->f('order_voided')==1){
		//void
		// set alpha to semi-transparency
		$pdf->SetAlpha(0.5);
			
		// draw jpeg image
		$pdf->Image($obj_base_path->base_path().'/images/void_img.gif',70,90,400);
		
		// restore full opacity
		$pdf->SetAlpha(1);	
		//end	
	}
	
	$pdf->SetFont('Arial','',9);
	$pdf->text(80,180,date('D M j, Y \a\t g:i a',strtotime($objlist->f('event_date'))));
	$pdf->SetFont('Arial','',6);
	$pdf->text(80,198,$obj_venue->f('venue_address')." ". $obj_venue->f('venue_city')." ".$obj_venue->f('venue_state')." ".$obj_venue->f('venue_zip'));
	
	$pdf->SetTextColor(255,255,255);
	$pdf->SetFont('Arial','',7);
	$pdf->text(85,226,'Powered by tickethype.com');
	
	if($objlist->f('event_ads1'))
	$pdf->Image($obj_base_path->base_path().'/files/event_ads/thumb/'.$objlist->f('event_ads1'),60,250,200);
	else
	$pdf->Image($obj_base_path->base_path().'/images/adv_img.jpg',60,250,200);
	
	if($objlist->f('event_ads2'))
	$pdf->Image($obj_base_path->base_path().'/files/event_ads/thumb/'.$objlist->f('event_ads2'),340,250,200);
	else
	$pdf->Image($obj_base_path->base_path().'/images/tweat_win.jpg',340,250,200);
	
	$pdf->SetTextColor(153,153,153);
	$pdf->text(62,460,'Ticket holder acknowledges all risks incidental to the event for which this ticket is');
	$pdf->text(62,470,'issued, whether occurring before, during or after the event.
	Upon admission, the ticket');
	$pdf->text(62,480,'holder agrees to comply with all applicable laws, by-laws, regulations and venue rules.');
	$pdf->text(62,490,'Failure to comply with venue rules may result in ejection from the event. Venue');
	$pdf->text(62,500,'management reserves the right to refuse admission and/or eject any individual whose');
	$pdf->text(62,510,'behavior is believed to be questionable. Ejection cancels this ticket and with that, the');
	$pdf->text(62,520,'holder forfeits any claim to a refund of the ticket price or any associated service or');
	$pdf->text(62,530,'delivery fees. The price displayed on the ticket represents the face value of the ticket');
	$pdf->text(62,540,'and does not include all service and delivery fees where applicable. Lost and/or stolen');
	$pdf->text(62,550,'tickets will not be honored. All sales are final - No refunds, no exchanges. This ticket is');
	$pdf->text(62,560,'for purchase or transfer by electronic means only. Purchase of this ticket from, or sale');
	$pdf->text(62,570,'of this ticket by, a third party is not authorized. Tickets not purchased electronically');
	$pdf->text(62,580,'carry risk of being fraudulent. Ticket Hype, Inc. is not responsible for any inconvenience');
	$pdf->text(62,590,'caused by unauthorized duplication. In the event that duplicate copies are presented,');
	$pdf->text(62,600,'the venue reserves the right to refuse entry to all ticket holders and may refund the');
	$pdf->text(62,610,'original ticket buyer the face value of the ticket. This refund will represent full');
	$pdf->text(62,620,'reimbursement.');
	$pdf->SetFont('Arial','',10);
	$pdf->text(62,640,'Ticket Note : '.$objlist->f('ticket_note'));
	
	$pdf->Image($obj_base_path->base_path().'/images/bg1.gif',360,457,180);
	$pdf->SetFont('Arial','',10);
	$pdf->text(370,470,'Instructions:');
	$pdf->SetFont('Arial','',8);
	$pdf->text(370,490,'Present this ticket at the venue to gain');
	$pdf->text(370,500,'entrance. Please bring photo identification and');
	$pdf->text(370,510,'the credit card used to purchase this ticket to');
	$pdf->text(370,520,'the event, as the venue reserves the right to');
	$pdf->text(370,530,'require one, or both, for entry. This ticket is');
	$pdf->text(370,540,'valid for one entry only. Unauthorized');
	$pdf->text(370,550,'duplication or sale of this ticket may prevent');
	$pdf->text(370,560,'you from being admitted into the event.');
		
	}
	
	$pdf->Output();
	}
	else echo "You dont have access.";
?>