<?php 
  class administrator extends DB_Sql 
{
//=========================Administrator Api ===============================
		function api_setting($api_login_id,$transaction_key,$top_banner_image,$top_banner_link,$side_banner_image,$side_banner_link)
			{
				$sql="update ".$this->prefix()."setting set api_login_id = '".$api_login_id."' , transaction_key = '".$transaction_key."' , topbanner_image = '".$top_banner_image."' , topbanner_link = '".$top_banner_link."' , sidebanner_image = '".$side_banner_image."' ,  	sidebanner_link = '".$side_banner_link."' ";
				$this->query($sql); 
			}
			
		function api_show()
			{
				$sql = "select * from ".$this->prefix()."setting " ;
				$this->query($sql);
			}
//=========================End==============================================


 //========================= Admin login===================================
		function check_admin_user($user_name,$pasword)
			{
				//echo $this->prefix(); exit;
				$sql = "select * from ".$this->prefix()."admin where username='".$user_name."' and 
				password='".md5($pasword)."' AND admin_type=1";
				$this->query($sql);
				 if($this->num_rows()>0)
					{
					   return 1;
					}
					   return 0;
			}
		function get_admin_user($user_name,$pasword)
			{
				$sql = "select * from ".$this->prefix()."admin where username='".$user_name."' and 
				password='".$pasword."' AND admin_type=1";
				$this->query($sql);
				
			}	
//============= Admin change password =========== 

		function getAdminUserDetails($admin_id)
		{
			$sql = "SELECT * FROM ".$this->prefix()."admin WHERE admin_id='".$admin_id."'";
			$this->query($sql);
			if($this->num_rows() > 0)
			{
				return 1;
			}
			return 0;
		}
		function updateAdminUserDetails($newpasswordmd5,$new_password,$user_id)
		{
			$sql="UPDATE ".$this->prefix()."admin SET password='".$newpasswordmd5."',rem_password='".$new_password."' WHERE  admin_type=1 AND  admin_id=".$user_id;
			$this->query($sql);
			return 1;
		}
		//==================================== End ============================================
		//==============================  Manage page ======================
		
		function list_page($limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."page  order by page_id desc $limit";
				$this->query($sql);
			}
		function showpage_by_id($page_id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."page  where page_id=".$page_id;
	 			$this->query($sql);
			}
		function edit_page($page_name,$page_content,$page_id,$page_link)
			{
				$sql = "update ".$this->prefix()."page set page_name='".$page_name."',page_content='".$page_content."',page_link='".$page_link."' where page_id=".$page_id;
				/*echo $sql;
				exit;*/
	 			$this->query($sql);
			}
		function add_page($page_name,$page_content,$page_link)
			{
				$sql = "INSERT INTO ".$this->prefix()."page set page_name='".$page_name."',page_content='".$page_content."',page_link='".$page_link."' ";
				//exit;
	 			$this->query($sql);
			}	
		function deletepage($page_id)
			{
				$sql="delete from ".$this->prefix()."page where page_id=".$page_id;
				/*echo $sql;
				exit;*/
				$this->query($sql);	
			}	
		function list_page_all()			
			{
				$sql="select * from ".$this->prefix()."page  order by page_id desc ";
				$this->query($sql);
			}								
// ================================== End ==================================

// ================================== Manage event ==================================
		function event_list($limit)
		{
			$sql="SELECT * FROM ".$this->prefix()."events WHERE event_status=0 ORDER BY event_id DESC  $limit";
			$this->query($sql);
		}
		
		function event_list_num()
		{
			$sql="SELECT * FROM ".$this->prefix()."events  WHERE event_status=0   ";
			$this->query($sql);
		}
		function edit_com_set($commission,$event_id)
		{
			$sql="UPDATE ".$this->prefix()."events SET commission='".$commission."' WHERE event_id='".$event_id."' ";
			$this->query($sql);
		}		
		function edit_home_page_event($home_page_event,$event_id)
		{
			$sql="UPDATE ".$this->prefix()."events SET home_page_event='".$home_page_event."' WHERE event_id='".$event_id."' ";
			$this->query($sql);
		}	
		function edit_home_page_event_order($event_order,$event_id)
		{
			$sql="UPDATE ".$this->prefix()."events SET event_order='".$event_order."' WHERE event_id='".$event_id."' ";
			$this->query($sql);
		}	
			
// ================================== End ==================================

// ================================== Delete event ==================================
		function delete_event_byid($event_id)
		{
			$sql="UPDATE ".$this->prefix()."events SET event_status=1 WHERE event_id='".$event_id."' ";
			$this->query($sql);
		}
		
// ================================== End ==================================
// ================================== Manage commission ==================================
		function commission_select()
			{
				$sql = "SELECT * FROM ".$this->prefix()."commission  WHERE id=1" ;
	 			$this->query($sql);
			}
		function update_commission_value($amount)	
			{
				$sql = "UPDATE ".$this->prefix()."commission SET amount='".$amount."'  WHERE id=1";
	 			$this->query($sql);
			}
// ================================== End ==================================

// ================================== Manage report ==================================
		/*function event_list_report($limit)
		{
			$sql="SELECT * FROM ".$this->prefix()."events WHERE event_launch=1 $limit";
			//$this->query($sql);
			//$sql="select * from ".$this->prefix()."events  order by page_id desc limit $page,$limit";
			$this->query($sql);
		}
		
		function event_list_report_num()
		{
			$sql="SELECT * FROM ".$this->prefix()."events WHERE event_launch=1  ORDER BY event_id ";
			$this->query($sql);
		}*/	 
		function event_total_sate_report($event_id)
		{
			$sql="SELECT SUM(b.total_amount) as tot FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  WHERE a.event_id=".$event_id."  AND a.order_voided=0 GROUP BY a.event_id";
			
			$this->query($sql);
		}
		function event_total_sale_amt($event_id)
		{
			$sql="SELECT SUM(b.without_commission) as tot FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  WHERE a.event_id=".$event_id."  AND a.order_voided=0 GROUP BY a.event_id";
			
			$this->query($sql);
		}
		function event_total_commission_earn($event_id)
		{
			$sql="SELECT SUM(b.commission_amount) as tot FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  WHERE a.event_id=".$event_id."  AND a.order_voided=0 GROUP BY a.event_id";
			
			$this->query($sql);
		}
		function event_wise_sale_report($event_id,$limit)
		{
			$sql="SELECT * FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  WHERE a.event_id=".$event_id."  ORDER BY a.date DESC $limit";
			
			$this->query($sql);
		}
		function edit_order_voided($transaction_id){
			$sql="UPDATE ".$this->prefix()."order SET order_voided=1 WHERE confirmation_id='".$transaction_id."' ";
			$this->query($sql);
		}
		
		function add_report_payment($amount,$pay_type,$event_id){
			$sql="INSERT INTO ".$this->prefix()."events_payment SET amount='".$amount."',pay_type='".$pay_type."',event_id='".$event_id."',pay_date=now() ";
			$this->query($sql);
		}
		function report_settlement($event_id){
	
		$sql="SELECT SUM(amount) AS amt FROM ".$this->prefix()."events_payment   WHERE event_id='".$event_id."' GROUP BY  event_id  ";
		$this->query($sql);
		
		}
		function report_settlement_detail($event_id){
	
		$sql="SELECT * FROM ".$this->prefix()."events_payment   WHERE event_id='".$event_id."'  ";
		$this->query($sql);
		
		}
		
// ================================== End ==================================
// ================================== Sale ==================================
		function sale_detail_by_id($order_id)			
		{
			$sql="SELECT * FROM ".$this->prefix()."order  WHERE order_id='".$order_id."' ";
			$this->query($sql);
		}
		function Userdetail_by_id($user_id)
		{
			$sql = "SELECT * FROM ".$this->prefix()."user  WHERE user_id=".$user_id." ";
			$this->query($sql);
		}
		function event_price_detail($event_id,$price_level_id){
	
			$sql="SELECT * FROM ".$this->prefix()."price_level  WHERE event_id='".$event_id."' AND price_level_id='".$price_level_id."' ";
			return $this->query($sql);
		}
		function orders_detail_by_id($order_id){
	
			$sql="SELECT a.*,b.commission_amount as commission_amount FROM ".$this->prefix()."order_detail a INNER JOIN  ".$this->prefix()."organization_sale b ON a.order_id=b.order_id WHERE a.order_id='".$order_id."' ";
			return $this->query($sql);
		}
		function event_detail_by_id($event_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."events  WHERE event_id='".$event_id."' ";
			$this->query($sql);
		}
		
		
		
// ================================== End ==================================
//==============================  Manage User ======================
		
		function list_user($limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."organization a INNER JOIN  ".$this->prefix()."admin b ON a.organization_id=b.organization_id WHERE b.seller_type=1  AND a.organization_status=0 ORDER BY a.organization_id desc $limit";
				$this->query($sql);
			}
			
		function list_user_all()			
			{
				$sql="SELECT * FROM ".$this->prefix()."organization a INNER JOIN  ".$this->prefix()."admin b ON a.organization_id=b.organization_id WHERE b.seller_type=1  AND a.organization_status=0 ORDER BY a.organization_id DESC ";
				$this->query($sql);
			}	
			
			
			
			
// ================================== End ==================================	
//==============================  Manage buyer User ======================
		
		function list_buyeruser($name,$email,$limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."user WHERE 1  ";
				
				if($name)
				$sql.=" AND CONCAT(f_name,' ',l_name) LIKE '%".$name."%' ";
				
				if($email)
				$sql.=" AND  email LIKE '%".$email."%' ";
				
				$sql.=" ORDER BY user_id DESC $limit";				
				
				$this->query($sql);
			}
			
		function list_buyeruser_all($name,$email)			
			{
				$sql="SELECT * FROM ".$this->prefix()."user  WHERE 1  ";
				
				if($name)
				$sql.=" AND CONCAT(f_name ,' ',l_name) LIKE  '%".$name."%' ";
				
				if($email)
				$sql.=" AND  email LIKE '%".$email."%' ";
				
				$this->query($sql);
			}			
// ================================== End ==================================

//====================================== Extension Checking ++++++++++++++++++++++++++++++++++++//

	

// ================================== thumb nail ==================================

function create_thumbnail($infile,$outfile,$maxw,$maxh,$stretch = FALSE) {
  clearstatcache();
  if (!is_file($infile)) {
    trigger_error("Cannot open file: $infile",E_USER_WARNING);
    return FALSE;
  }
  if (is_file($outfile)) {
      trigger_error("Output file already exists: $outfile",E_USER_WARNING);
    return FALSE;
  }
 
  $functions = array(
    'image/png' => 'ImageCreateFromPng',
    'image/jpeg' => 'ImageCreateFromJpeg',
  );
 
  // Add GIF support if GD was compiled with it
  if (function_exists('ImageCreateFromGif')) { $functions['image/gif'] = 'ImageCreateFromGif'; }
 
  $size = getimagesize($infile);
 
  // Check if mime type is listed above
  if (!$function = $functions[$size['mime']]) {
      trigger_error("MIME Type unsupported: {$size['mime']}",E_USER_WARNING);
    return FALSE;
  }
 
  // Open source image
  if (!$source_img = $function($infile)) {
      trigger_error("Unable to open source file: $infile",E_USER_WARNING);
    return FALSE;
  }
 
  $save_function = "image" . strtolower(substr(strrchr($size['mime'],'/'),1));
 
  // Scale dimensions
  list($neww,$newh) = $this->scale_dimensions($size[0],$size[1],$maxw,$maxh,$stretch);
 
  if ($size['mime'] == 'image/png') {
    // Check if this PNG image is indexed
    $temp_img = imagecreatefrompng($infile);
    if (imagecolorstotal($temp_img) != 0) {
      // This is an indexed PNG
      $indexed_png = TRUE;
    } else {
      $indexed_png = FALSE;
    }
    imagedestroy($temp_img);
  }
 
  // Create new image resource
  if ($size['mime'] == 'image/gif' || ($size['mime'] == 'image/png' && $indexed_png)) {
    // Create indexed 
    $new_img = imagecreate($neww,$newh);
    // Copy the palette
    imagepalettecopy($new_img,$source_img);
 
    $color_transparent = imagecolortransparent($source_img);
    if ($color_transparent >= 0) {
      // Copy transparency
      imagefill($new_img,0,0,$color_transparent);
      imagecolortransparent($new_img, $color_transparent);
    }
  } else {
    $new_img = imagecreatetruecolor($neww,$newh);
  }
 
  // Copy and resize image
  imagecopyresampled($new_img,$source_img,0,0,0,0,$neww,$newh,$size[0],$size[1]);
 
  // Save output file
  if ($save_function == 'imagejpeg') {
      // Change the JPEG quality here
      if (!$save_function($new_img,$outfile,75)) {
          trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  } else {
      if (!$save_function($new_img,$outfile)) {
          trigger_error("Unable to save output image",E_USER_WARNING);
          return FALSE;
      }
  }
 
  // Cleanup
  imagedestroy($source_img);
  imagedestroy($new_img);
 
  return TRUE;
}
// Scales dimensions
function scale_dimensions($w,$h,$maxw,$maxh,$stretch = FALSE) {
    if (!$maxw && $maxh) {
      // Width is unlimited, scale by width
      $newh = $maxh;
      if ($h < $maxh && !$stretch) { $newh = $h; }
      else { $newh = $maxh; }
      $neww = ($w * $newh / $h);
    } elseif (!$maxh && $maxw) {
      // Scale by height
      if ($w < $maxw && !$stretch) { $neww = $w; }
      else { $neww = $maxw; }
      $newh = ($h * $neww / $w);
    } elseif (!$maxw && !$maxh) {
      return array($w,$h);
    } else {
      if ($w / $maxw > $h / $maxh) {
        // Scale by height
        if ($w < $maxw && !$stretch) { $neww = $w; }
        else { $neww = $maxw; }
        $newh = ($h * $neww / $w);
      } elseif ($w / $maxw <= $h / $maxh) {
        // Scale by width
        if ($h < $maxh && !$stretch) { $newh = $h; }
        else { $newh = $maxh; }
        $neww = ($w * $newh / $h);
      }
    }
    return array(round($neww),round($newh));
}

// ================================== End ==================================
	
//==============================  Manage banner ======================
		
		function list_banner($limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."banner  ORDER BY id DESC $limit";
				$this->query($sql);
			}
		function banner_by_id($id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."banner  WHERE id=".$id;
	 			$this->query($sql);
			}
		function add_banner($banner_name,$image,$banner_link)
			{
				$sql = "INSERT INTO ".$this->prefix()."banner set banner_name='".$banner_name."', banner_link='".$banner_link."',image='".$image."',add_date=now()";
	 			$this->query($sql);
			}	
		function edit_banner($banner_name,$image,$banner_link,$id)
			{
				$sql = "UPDATE ".$this->prefix()."banner SET banner_name='".$banner_name."', banner_link='".$banner_link."',image='".$image."' WHERE id=".$id;
	 			$this->query($sql);
			}			
		function delete_banner($id)
			{
				$sql="DELETE FROM ".$this->prefix()."banner WHERE id=".$id;
				$this->query($sql);	
			}		
		function list_banner_all()			
			{
				$sql="SELECT * FROM ".$this->prefix()."banner  ORDER BY banner_order ";
				$this->query($sql);
			}
		function update_order_banner($banner_order,$banner_id){
		
				$sql = "UPDATE ".$this->prefix()."banner SET banner_order='".$banner_order."' WHERE id=".$banner_id;
	 			$this->query($sql);
			}
			
		function even_slider_banner($limit){
		
				$sql="SELECT * FROM ".$this->prefix()."eventslider  ORDER BY slider_id DESC $limit";
				$this->query($sql);
		}
		function event_banner_all(){
		
			$sql="SELECT * FROM ".$this->prefix()."eventslider  ORDER BY `order`";
			$this->query($sql);
		
		}
		function slider_order_banner($slider_order,$slider_id){
		
				$sql = "UPDATE ".$this->prefix()."eventslider SET `order`='".$slider_order."' WHERE `slider_id`='".$slider_id."'";
	 			$this->query($sql);
			}
		function slider_by_id($id){
		
				$sql = "SELECT * FROM ".$this->prefix()."eventslider  WHERE slider_id=".$id;
	 			$this->query($sql);
		}
		function update_event_slider($event_link,$event_banner_image,$status,$slider_id)	{
		
			$sql = "UPDATE ".$this->prefix()."eventslider SET `link`='".$event_link."',`image`='".$event_banner_image."',`status`='".$status."' WHERE `slider_id`=".$slider_id;
	 			$this->query($sql);
		
		}
		function delete_slider_image($id){
		
			$sql="DELETE FROM ".$this->prefix()."eventslider WHERE slider_id=".$id;
			$this->query($sql);	
		}	
			
											
// ================================== End ==================================

// ===========================Insert Even Image Slider==================================
			function insert_event_slider($event_link,$event_banner_image,$order,$status){
			
			 $sql="INSERT INTO ".$this->prefix()."eventslider(`link`,`image`,`order`,`status`)values('".$event_link."','".$event_banner_image."','".$order."','".$status."')";
	 			$this->query($sql);
			
			}

//=================== end=========================================================	

//================= upadte top Bannner ================================================
function update_top_banner($top_banner_link,$top_banner_image){

	 $sql="update ".$this->prefix()."setting set topbanner_link='".$top_banner_link."',topbanner_image='".$top_banner_image."'";
	 $this->query($sql); 
	 			
}
//=================== End =============================================


//================= upadte Side Bannner ================================================

function update_side_banner($side_banner_link,$side_banner_image){
	
	 $sql="update ".$this->prefix()."setting set sidebanner_link='".$side_banner_link."',sidebanner_image='".$side_banner_image."'";
	 $this->query($sql); 
}

//================================ end =============================================

//================seleect all banner===============================================
function select_top_banner(){

	 $sql="select topbanner_link,topbanner_image,sidebanner_link,sidebanner_image  from ".$this->prefix()."setting";
	 $this->query($sql);
	$this->next_record();
	
	
	 
}







// ================================== payment information ==================================
		function organization_by_id($organization_id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."organization  WHERE organization_id=".$organization_id;
	 			$this->query($sql);
			}	
// ================================== End ==================================
//=============  event =========== 

	//step 1
	function add_event($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$admin_id,$organization_id)
	{
		$sql="INSERT INTO ".$this->prefix()."events set event_name='".$event_name."',event_date='".$event_date."',venue='".$venue."',description='".mysql_real_escape_string($description)."',on_sale_date='".$on_sale_date."',sale_close_date='".$sale_close_date."',category_id='".$category_id."',age='".$age."',event_web_site='".$event_web_site."',event_image='".$event_image."' ,admin_id='".$admin_id."',organization_id='".$organization_id."' ";
		$rs=$this->query($sql);
		return mysql_insert_id();
	}
	function edit_event_step_1($event_name,$event_date,$venue,$description,$on_sale_date,$sale_close_date,$category_id,$age,$event_web_site,$event_image,$event_id)
	{
		$sql="UPDATE ".$this->prefix()."events set event_name='".$event_name."',event_date='".$event_date."',venue='".$venue."',description='".mysql_real_escape_string($description)."',on_sale_date='".$on_sale_date."',sale_close_date='".$sale_close_date."',category_id='".$category_id."',age='".$age."',event_web_site='".$event_web_site."',event_image='".$event_image."'
		WHERE event_id='".$event_id."'
		  ";
		  
		$rs=$this->query($sql);
		return mysql_insert_id();
	}
	function add_venue($venue_name,$venue_country,$venue_address,$venue_city,$venue_state,$venue_zip,$venue_timezone,$event_id,$admin_id,$organization_id)
	{
		
		
		$sql="INSERT INTO ".$this->prefix()."venue SET venue_name='".$venue_name."',venue_country='".$venue_country."',venue_address='".$venue_address."',venue_city='".$venue_city."',venue_state='".$venue_state."',venue_zip='".$venue_zip."',venue_timezone='".$venue_timezone."',
		event_id='".$event_id."',admin_id='".$admin_id."',	venue_active=1, organization_id='".$organization_id."'  ";
		$rs=$this->query($sql);	
		$venue=mysql_insert_id();
		
		//update rest record
		$sle_up="UPDATE ".$this->prefix()."events SET venue='".$venue."' WHERE event_id='".$event_id."'";
		$this->query($sle_up);	
	}
	
	function event_list_venue_by_organization($organization_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."venue WHERE organization_id='".$organization_id."'  ";
			$this->query($sql);
		}
	function event_total_sold_ticket($event_id)
		{
			$sql="SELECT SUM(ticket_sold) as total_sold_event FROM ".$this->prefix()."price_level WHERE event_id='".$event_id."' GROUP BY event_id  ";
			$this->query($sql);
		}		
	/*function event_list_venue($event_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."venue WHERE event_id='".$event_id."'  ";
			$this->query($sql);
		}		
	function event_list_venue_selected($event_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."venue WHERE event_id='".$event_id."' AND venue_active=1  ";
			$this->query($sql);
		}	
	
	function event_list($organization_id,$limit)
		{
			$sql="SELECT * FROM ".$this->prefix()."events WHERE organization_id='".$organization_id."'   $limit";
			//$this->query($sql);
			//$sql="select * from ".$this->prefix()."events  order by page_id desc limit $page,$limit";
			$this->query($sql);
		}
	
		
	function event_list_num($organization_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."events  WHERE organization_id='".$organization_id."'  ORDER BY event_id ";
			$this->query($sql);
		}
	function getVenueById($venue_id,$organization_id){
	
		$sql = "SELECT * FROM ".$this->prefix()."venue WHERE venue_id='".$venue_id."' AND organization_id=".$organization_id;
		$this->query($sql);
	}*/		
	function getEvent($event_id)
		{
			$sql="SELECT * FROM ".$this->prefix()."events  WHERE event_id='".$event_id."' ";
			return $this->query($sql);
		}	
	//step 2
	function add_event_price($price_name,$price_amount,$ticket_limit,$price_status,$price_description,$event_id)
	{
		$sql="INSERT INTO ".$this->prefix()."price_level SET price_name='".$price_name."',price_amount='".$price_amount."',ticket_limit='".$ticket_limit."',price_status='".$price_status."',price_description='".$price_description."',event_id='".$event_id."'   ";
		$rs=$this->query($sql);
		return mysql_insert_id();
	}
	//step 2
	function edit_event_price($price_name,$price_amount,$ticket_limit,$price_status,$price_description,$event_id,$price_level_id)
	{
		$sql="UPDATE ".$this->prefix()."price_level SET price_name='".$price_name."',price_amount='".$price_amount."',ticket_limit='".$ticket_limit."',price_status='".$price_status."',price_description='".$price_description."',event_id='".$event_id."' WHERE price_level_id='".$price_level_id."'   ";
		$rs=$this->query($sql);
		return mysql_insert_id();
	}
	
	function event_price_list($event_id){
	
		$sql="SELECT * FROM ".$this->prefix()."price_level  WHERE event_id='".$event_id."'  AND price_level_status=0";
		return $this->query($sql);
	}
	
	function event_price_level_by_id($price_level_id){
	
		$sql="SELECT * FROM ".$this->prefix()."price_level  WHERE price_level_id='".$price_level_id."' ";
		return $this->query($sql);
	}
	function delete_event_price_level_by_id($price_level_id){
	
		//$sql="DELETE FROM ".$this->prefix()."price_level  WHERE price_level_id='".$price_level_id."' ";
		$sql="UPDATE ".$this->prefix()."price_level SET price_level_status=1  WHERE price_level_id='".$price_level_id."' ";
		return $this->query($sql);
	}
	function edit_inventory_capacity($inventory_capacity,$event_id){
		$sql="UPDATE ".$this->prefix()."events SET inventory_capacity='".$inventory_capacity."'  WHERE event_id='".$event_id."' ";
		return $this->query($sql);
	
	}
	function price_level_is_on_sale($price_level_id){
	
		$sql="SELECT * FROM ".$this->prefix()."order_detail  WHERE price_level_id='".$price_level_id."' ";
		return $this->query($sql);
	}
	//step 3
	
	function url_present_check($url_short_name,$event_id){
		
		$sql="SELECT * FROM ".$this->prefix()."events WHERE url_short_name='".$url_short_name."' AND event_id!='".$event_id."'";
		return $this->query($sql);
	}	
	
	function edit_step3_event($print_at_home,$print_date_enable,$print_date_disable,$will_call,$will_date_enable,$will_date_disable,$print_add_desc,$will_add_desc,$donation_enable,$donation_name,$online_service_fee,$ticket_note,$ticket_transaction_limit,$checkout_time_limit,$private_event,$url_short_name,$custom_fee,$custom_fee_name,$custom_fee_type,$custom_fee_amt,$custom_apply_fee,$event_id)
	{
		$sql="UPDATE ".$this->prefix()."events SET print_at_home='".$print_at_home."',print_date_enable='".$print_date_enable."',print_date_disable='".$print_date_disable."',		
		will_call='".$will_call."',will_date_enable='".$will_date_enable."',will_date_disable='".$will_date_disable."',
		print_add_desc='".$print_add_desc."',will_add_desc='".$will_add_desc."',
		donation_enable='".$donation_enable."',donation_name='".$donation_name."',
		online_service_fee='".$online_service_fee."',ticket_note='".$ticket_note."',
		ticket_transaction_limit='".$ticket_transaction_limit."',checkout_time_limit='".$checkout_time_limit."',
		private_event='".$private_event."',url_short_name='".$url_short_name."'	,
		custom_fee='".$custom_fee."',custom_fee_name='".$custom_fee_name."',custom_fee_type='".$custom_fee_type."',custom_fee_amt='".$custom_fee_amt."',custom_apply_fee='".$custom_apply_fee."'
		WHERE event_id='".$event_id."'   ";
		$rs=$this->query($sql);		
	}
	//step 4	
	function edit_step4_event($event_id)
	{
		$sql="UPDATE ".$this->prefix()."events SET event_launch=1
		WHERE event_id='".$event_id."'   ";
		$rs=$this->query($sql);		
	}	
	
	//event step
	function event_step_no($event_id,$event_step){
		
		$sql="SELECT * FROM ".$this->prefix()."events  WHERE event_id='".$event_id."'  ";
		$this->query($sql);
		$this->next_record();
		if($event_step > $this->f('event_step')){
			$sql="UPDATE ".$this->prefix()."events SET event_step='".$event_step."' WHERE event_id='".$event_id."'   ";
			$rs=$this->query($sql);
		}
		
	}
	function category_list(){
	
		$sql="SELECT * FROM ".$this->prefix()."event_category  ORDER BY category_name ";
		return $this->query($sql);
	}
//==================================== End ============================================
// ================================== Delete Org ==================================
		function delete_Org_byid($organization_id)
		{
			$sql="UPDATE ".$this->prefix()."organization SET organization_status=1 WHERE organization_id='".$organization_id."' ";
			$this->query($sql);
		}
		
// ================================== End ==================================
// ================================== Manage seller ==================================
function update_user_detail($fname,$lname,$phone,$fax,$admin_id,$time_zone)
		{
			
			$sql="UPDATE ".$this->prefix()."admin SET fname='".$fname."',lname='".$lname."',phone='".$phone."',fax='".$fax."',time_zone='".$time_zone."' WHERE admin_id='".$admin_id."'   ";
			$rs=$this->query($sql);
			
		}
	function update_user_password($old_pass,$new_password,$admin_id)
		{
			
			//pass match
			$sql1 = "select * from ".$this->prefix()."admin WHERE password='".$old_pass."' AND admin_id=".$admin_id;
			$this->query($sql1);
			
			if($this->num_rows()>0){
			
				$sql="UPDATE ".$this->prefix()."admin SET password='".$new_password."'  WHERE admin_id='".$admin_id."'   ";
				$rs=$this->query($sql);
				return 3;
			}
			else {
			
				return 2;
			}
			
		}
// ================================== End ==================================
//==================================== Country list ============================================
	function countries_list(){
	
		$sql="SELECT * FROM ".$this->prefix()."countries  ";
		return $this->query($sql);
	}
//==================================== End ============================================
//==============================  Manage advertisement ======================
		
		function list_advertisement($limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."advertisement  ORDER BY id DESC $limit";
				$this->query($sql);
			}
		function advertisement_by_id($id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."advertisement  WHERE id=".$id;
	 			$this->query($sql);
			}
		function add_advertisement($banner_name,$image,$url)
			{
				$sql = "INSERT INTO ".$this->prefix()."advertisement set advertisement_name='".$banner_name."',image='".$image."',url='".$url."',add_date=now()";
	 			$this->query($sql);
			}	
		function edit_advertisement($banner_name,$image,$url,$id)
			{
				$sql = "UPDATE ".$this->prefix()."advertisement SET advertisement_name='".$banner_name."',image='".$image."',url='".$url."' WHERE id=".$id;
	 			$this->query($sql);
			}			
		function delete_advertisement($id)
			{
				$sql="DELETE FROM ".$this->prefix()."advertisement WHERE id=".$id;
				$this->query($sql);	
			}		
		function list_advertisement_all()			
			{
				$sql="SELECT * FROM ".$this->prefix()."advertisement  ORDER BY id DESC ";
				$this->query($sql);
			}							
// ================================== End ==================================	
// ================================== Event ads ==================================	

		function edit_event_ads($event_ads1,$event_ads2,$event_id)
			{
				$sql = "UPDATE ".$this->prefix()."events SET event_ads1='".$event_ads1."',event_ads2='".$event_ads2."'  WHERE event_id=".$event_id;
	 			$this->query($sql);
			}
// ================================== End ==================================	
// ================================== Sale detail ==================================
		function sale_report($limit)
		{
			$sql="SELECT * FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  ORDER BY a.date DESC $limit";
			
			$this->query($sql);
		}	
		function sale_report_num()
		{
			$sql="SELECT * FROM ".$this->prefix()."order a INNER JOIN ".$this->prefix()."organization_sale b ON a.order_id=b.order_id  ";
			
			$this->query($sql);
		}
		function order_detail_by_transaction_id($transaction_id){
	
			$sql="SELECT a.*,b.commission_amount as commission_amount,b.without_commission as without_commission,b.organization_id FROM ".$this->prefix()."order a INNER JOIN  ".$this->prefix()."organization_sale b ON a.order_id=b.order_id WHERE a.confirmation_id='".$transaction_id."' ";
			return $this->query($sql);
		}
		function edit_seller_admin_amt($organization_id,$without_commission){
		
			$sql = "UPDATE ".$this->prefix()."organization SET total_earning=total_earning-'".$without_commission."'  WHERE organization_id=".$organization_id;
	 		$this->query($sql);
		}
// ================================== End ==================================
//====================================================== User login mail =======================================================
	function user_login_mail($password,$email){
	
		$output='<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
    <tbody><tr>
        <td valign="top" align="center">

            <table width="100%" cellspacing="0" cellpadding="0">                  
                 
                <tbody><tr>
                    <td style="background-color:#1a1c35;border-top:1px solid #57658e;border-bottom:1px solid #262f47">
                        <center>
                            <a target="_blank" style="color:#4c5a81;color:#4c5a81;color:#4c5a81" href="'.$this->base_path().'">
                            <img border="0" align="middle" alt="Ticket Hype" title="Ticket Hype" src="'.$this->base_path().'/images/email_logo.jpg"></a>
                        </center>
                                            </td>
                </tr>
                            </tbody></table>

            <table width="550" cellspacing="0" cellpadding="20" bgcolor="#FFFFFF">
                <tbody><tr>
                    <td valign="top" bgcolor="#FFFFFF" style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms;border-left:1px solid #e0e0e0;border-right:1px solid #e0e0e0;border-bottom:1px solid #e0e0e0">
                                    <p style="margin-top:0px">
                                    </p><div style="font-size:20px;font-weight:bold;color:#f3164f;font-family:arial;line-height:100%;padding:20px 0px">Ticket Hype Ticketing Login Information</div>
                                
                                
                                
                                    <span style="font-size:12px;color:#444444;line-height:150%;font-family:trebuchet ms">Thanks for using Ticket Hype Ticketing!<br><br>

We created you a login so that you can return to Ticket Hype at anytime to view your purchase history or locate your tickets. <br><br>

Your password has temporarily been set to: '.$password.'.<br><br>
Log into your TicketHype account at any time at: <a target="_blank" href="'.$this->base_path().'/login" style="font-weight:bold;">Login</a><br><br>

All the best,<br>
Ticket Hype</span>
                            <p></p>
                    </td>
                </tr>
                                    <tr>
                        <td valign="top" style="background-color:#e9e9e9;border-top:22px solid #f4f4f4;padding:10px 10px">
                            <div style="font-size:10px;color:#666666;line-height:100%;font-family:verdana">
                                <div style="float:right">
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/twitter_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" height="43" src="'.$this->base_path().'/images/facebook_icon.png"></a>
    <a target="_blank" href="#"><img width="43" border="0" src="'.$this->base_path().'/images/youtube_icon.png"></a>
    </div><div>Copyright &copy; 2011 Ticket Hype, Inc. All rights reserved.</div>                            </div>
                        </td>
                    </tr>
                            </tbody></table>
        </td>
    </tr>
</tbody></table>';
	//echo $output; exit;
	//from email
	$this->admin_setting();
	$this->next_record();
	$from=$this->f('email');
	$to=$email;
	$subject='Ticket Hype Ticketing Account Information';
	$com_name='Ticket Hype';
	/*// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Ticket Hype <'.$from.'>' . "\r\n";*/
	
	// Mail it
	//mail($to, $subject, $output, $headers);
	$this->send_mail($from,$to,$subject,$output,$com_name);
	}	
	
	//====================================================== end =======================================================	
		//====================================================== admin setting =======================================================
	function admin_setting(){
	
			$sql = "SELECT * FROM ".$this->prefix()."setting WHERE id=1" ;
			$this->query($sql);
			
	}
	//====================================================== end =======================================================
// ================================== Delete Buyer user ==================================
		function delete_user_id($user_id)
		{
			$sql="DELETE FROM ".$this->prefix()."user WHERE user_id='".$user_id."' ";
			$this->query($sql);
		}
		
// ================================== End ==================================
// ================================== Manage Buyer ==================================
function update_buyeruser_detail($f_name,$l_name,$address,$user_id)
		{
			
			$sql="UPDATE ".$this->prefix()."user SET f_name='".$f_name."',l_name='".$l_name."',address='".$address."' WHERE user_id='".$user_id."'   ";
			$rs=$this->query($sql);
			
		}
	function update_buyeruser_password($old_pass,$new_password,$user_id)
		{
			
			//pass match
			$sql1 = "select * from ".$this->prefix()."user WHERE password='".$old_pass."' AND user_id=".$user_id;
			$this->query($sql1);
			
			if($this->num_rows()>0){
			
				$sql="UPDATE ".$this->prefix()."user SET password='".$new_password."'  WHERE user_id='".$user_id."'   ";
				$rs=$this->query($sql);
				return 3;
			}
			else {
			
				return 2;
			}
			
		}
// ================================== End ==================================
//==============================  Manage ticket solution ======================
		
		function list_ticket_solution($limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."solution  ORDER BY ticket_solution_id DESC $limit";
				$this->query($sql);
			}
		function ticket_solution_by_id($ticket_solution_id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."solution  WHERE ticket_solution_id=".$ticket_solution_id;
	 			$this->query($sql);
			}
		function list_ticket_solution_all()			
			{
				$sql="SELECT * FROM ".$this->prefix()."solution   ";
				$this->query($sql);
			}	
		function add_ticket_solution($name,$description,$image,$slug,$description_detail)
			{
				$sql = "INSERT INTO ".$this->prefix()."solution set name='".$name."',description='".$description."',image='".$image."',slug='".$slug."' ,description_detail='".$description_detail."' ";
	 			$this->query($sql);
			}	
		function edit_ticket_solution($name,$description,$image,$ticket_solution_id,$description_detail)
			{
				$sql = "UPDATE ".$this->prefix()."solution SET name='".$name."',description='".$description."',image='".$image."',description_detail='".$description_detail."' WHERE ticket_solution_id=".$ticket_solution_id;
	 			$this->query($sql);
			}			
		function delete_ticket_solution($ticket_solution_id)
			{
				$sql="DELETE FROM ".$this->prefix()."solution WHERE ticket_solution_id=".$ticket_solution_id;
				$this->query($sql);	
			}
		function seoUrl($string) {
			//Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
			$string = strtolower($string);
			//Strip any unwanted characters
			$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
			//Clean multiple dashes or whitespaces
			$string = preg_replace("/[\s-]+/", " ", $string);
			//Convert whitespaces and underscore to dash
			$string = preg_replace("/[\s_]/", "-", $string);
			
			$rec_slug=$this->ticket_solution_urlcheck($string);
			do {
				// some code to run only one more time if expression is true
				
				if ($rec_slug == 0){	
					break;
				}
				$string=$string.rand(1,9);
				$rec_slug=$this->ticket_solution_urlcheck($string);
				
			    continue;
				
			} while (true);
						
			return $string;
		}  
		function ticket_solution_urlcheck($string){
			
			$sql = "SELECT * FROM ".$this->prefix()."solution  WHERE slug='".$string."'";
	 		$this->query($sql);
			return $this->num_rows();
		
		}		
							
// ================================== End ==================================	
//==============================  Manage ticket solution detail ======================
		
		function list_ticket_solution_detail($ticket_solution_id,$limit)			
			{
				$sql="SELECT * FROM ".$this->prefix()."solution_detail WHERE ticket_solution_id='".$ticket_solution_id."' $limit";
				$this->query($sql);
			}
		function ticket_solution_detail_by_id($id)
			{
				$sql = "SELECT * FROM ".$this->prefix()."solution_detail  WHERE id=".$id;
	 			$this->query($sql);
			}
		function list_ticket_solution_detail_all($ticket_solution_id)			
			{
				$sql="SELECT * FROM ".$this->prefix()."solution_detail  WHERE ticket_solution_id='".$ticket_solution_id."'  ";
				$this->query($sql);
			}	
		function add_ticket_solution_detail($name,$description,$image,$ticket_solution_id)
			{
				$sql = "INSERT INTO ".$this->prefix()."solution_detail set name='".$name."',description='".$description."',image='".$image."',ticket_solution_id='".$ticket_solution_id."' ";
	 			$this->query($sql);
			}	
		function edit_ticket_solution_detail($name,$description,$image,$ticket_solution_id,$id)
			{
				$sql = "UPDATE ".$this->prefix()."solution_detail SET name='".$name."',description='".$description."',image='".$image."',ticket_solution_id='".$ticket_solution_id."' WHERE id=".$id;
	 			$this->query($sql);
			}			
		function delete_ticket_solution_detail($id)
			{
				$sql="DELETE FROM ".$this->prefix()."solution_detail WHERE id=".$id;
				$this->query($sql);	
			}		
							
// ================================== End ==================================
// =========================== mail ================================	
	function send_mail($from,$to,$subject,$body,$name='',$attachment=false,$filename=false,$reply_to=false){
		
	include_once "../sendMail/lib/swift_required.php";
	 // This is your From email address
	$from = array("info@tickethype.com"=> 'Ticket Hype');
 	//$from = array('someone@example.com' => 'Name To Appear');
	
	 // Email recipients
	 $to = array("$to "=>'');
 	//$to = array('amit.unified@gmail.com'=>'Test Test' );
	
	 // Login credentials
	 $username = 'dhanani';
	 $password = 'dhanani';
	
	 // Setup Swift mailer parameters
	 $transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 587);
	 $transport->setUsername($username);
	 $transport->setPassword($password);
	 $swift = Swift_Mailer::newInstance($transport);
	
	 // Create a message (subject)
	 $message = new Swift_Message($subject);
	
	 // attach the body of the email
	$message->setFrom($from);
	$message->setBody($body, 'text/html');
	$message->setTo($to);
	
	//$message->attach(Swift_Attachment::fromPath($attachment)->setFileName($filename));

	
	if($recipients = $swift->send($message, $failures))
	{
	  // This will let us know how many users received this message
	  //echo 'Message sent out to '.$recipients.' users';
	  return true;
	}
	// something went wrong =(
	else
	{
	 //echo "Something went wrong - ";
	 // print_r($failures);
	  return false;
	}
		
	}
	
	/*function send_mail($from,$to,$subject,$body,$name=''){
		$sql="SELECT * FROM ".$this->prefix()."setting WHERE id=1 ";
		$this->query($sql);
		$this->next_record();
		
		if($this->f('smtp_active')==1){
			require_once "Mail.php";
			//echo $this->f('smtp_active'); exit;
			$from1 = $name." <".$from.">";			
			$host = $this->f('smtp_host');
			$port = $this->f('smtp_port');
			$username = $this->f('smtp_username');
			$password = $this->f('smtp_password');
	 
			$headers = array("MIME-Version"=> '1.0', 
			"Content-type" => "text/html; charset=iso-8859-1",
			"From" => $from,
			"To" => $to, 
			"Subject" => $subject);			
			
			$smtp = Mail::factory('smtp',
			array ('host' => $host,
			'port' => $port,
			'auth' => true,
			'username' => $username,
			'password' => $password));			 
			$mail = $smtp->send($to, $headers, $body);
			
		}
		else{
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$name.' <'.$from.'>' . "\r\n";
			// Mail it
			mail($to, $subject, $body, $headers);
		}
	
	}*/
	
	function getDetailsMer($limit)
	{
		$sql = "SELECT A.* FROM  ".$this->prefix()."user as A, ".$this->prefix()."merchant_pay_details as B WHERE A.`user_id` = B.admin_id ORDER BY A.date_created DESC $limit";
		$this->query($sql);
	}
	
	function merchant_details_num()
	{
		$sql="SELECT A.* FROM  ".$this->prefix()."user as A, ".$this->prefix()."merchant_pay_details as B WHERE A.`user_id` = B.`admin_id`  ";
		$this->query($sql);
	}
	
	function setPaymentMerchant($user_id,$service_fee,$flat_per_ticket)
	{
		$sql = "INSERT INTO ".$this->prefix()."set_payment_by_admin set user_id='".$user_id."',service_fee='".$service_fee."',service_fee_per_ticket='".$flat_per_ticket."' ";
		
		$this->query($sql);
	}	

	function merchant_payment_details($user_id)
	{
		$sql="SELECT * FROM  ".$this->prefix()."set_payment_by_admin ".$this->prefix()." WHERE `user_id` = '$user_id' ";
		
		$this->query($sql);
	}
	
	function editPaymentMerchant($ticket_fee,$subscrtion_fee,$set_payment_id)
	{
		
		$sql = "UPDATE ".$this->prefix()."set_payment_by_admin SET service_fee='".$subscrtion_fee."',service_fee_per_ticket='".$ticket_fee."' WHERE set_payment_id=".$set_payment_id;
		$this->query($sql);
	}			

	function check_txnid($tnxid){
		$sql = "SELECT * FROM ".$this->prefix()."reccuring_pay_details WHERE txn_id='".$tnxid."'" ;
		$this->query($sql);			
	}

function insertByPaypal($data)
{
	$sql="INSERT INTO ".$this->prefix()."reccuring_pay_details SET 
		item_name='".$data['item_name']."',
		item_number='".$data['item_number']."',
		payment_amount='".$data['payment_amount']."',
		txn_id='".$data['txn_id']."',
		user_id='".$data['user_id']."'
		 ";
		 //echo $sql;
	$this->query($sql);
	return mysql_insert_id();
}
	function getSitePayDtls($id)
	{
		$sql = "SELECT * FROM  ".$this->prefix()."set_payment_by_admin where id='$id'";
		$this->query($sql);
	}
	
function getSinglerecurringMerDtls($id)
{
	$sql = "SELECT * FROM  ".$this->prefix()."reccuring_creditcard_pay where id='$id' ";
	$this->query($sql);
}

function recurringMerDtls($limit)
{
	$sql = "SELECT * FROM  ".$this->prefix()."reccuring_creditcard_pay  ORDER BY cur_date DESC $limit";
	$this->query($sql);
}

function recurringMerDtls_num()
{
	$sql = "SELECT * FROM  ".$this->prefix()."reccuring_creditcard_pay ";
	$this->query($sql);
}

function getTicketFee($mer_id)
{
	$sql="SELECT * FROM  ".$this->prefix()."fee_per_mer ".$this->prefix()." WHERE `mer_id` = '$mer_id' ";
	$this->query($sql);
}

function add_ticket_per_merchant($admin_id,$organise_id,$ticket_fee)
{
	$sql = "INSERT INTO ".$this->prefix()."fee_per_mer set mer_id='".$admin_id."',organise_id='".$organise_id."',ticket_fee='".$ticket_fee."' ";
	$this->query($sql);
}	

function perTicketDetails($ticket_id)
{
	$sql="SELECT * FROM  ".$this->prefix()."fee_per_mer ".$this->prefix()." WHERE `fee_id` = '$ticket_id' ";
	$this->query($sql);
}

function edit_ticket_per_merchant($ticket_fee,$ticket_id)
{
	$sql = "UPDATE ".$this->prefix()."fee_per_mer SET ticket_fee='".$ticket_fee."' WHERE `fee_id` = '$ticket_id' ";
	$this->query($sql);
}	
		
function getTPaymentType($admin_id)
{
	$sql="SELECT * FROM  ".$this->prefix()."merchant_pay_details ".$this->prefix()." WHERE `admin_id` = '$admin_id' ";
	$this->query($sql);
}

function ticketInfo($admin_id)
{
	$sql = "SELECT B.ticket_limit, B.ticket_sold,SUM(B.ticket_limit) tot_limit, SUM(B.ticket_sold) tot_ticket_sold FROM `ticket_events` AS A, ticket_price_level AS B WHERE A.`event_id` = B.`event_id` AND A.`admin_id` ='$admin_id' ORDER BY A.`event_id` ";
	$this->query($sql);
}

// paypal Section =================

function updatePayments($data){	
	if(is_array($data)){	

	$sql = "INSERT INTO ".$this->prefix()."calculate_payments set txnid='".$data['txn_id']."',payment_amount='".$data['payment_amount']."',payment_status='".$data['payment_status']."' ,itemid='".$data['item_number']."' ,createdtime='".date("Y-m-d H:i:s")."',ticket_sold='".$data['ticket_sold']."',admin_id='".$data['admin_id']."' ";
	$this->query($sql);
   return mysql_insert_id();
    }
}

function check_txnid_ticket($tnxid){
	$sql = "SELECT * FROM ".$this->prefix()."calculate_payments WHERE txnid='".$tnxid."'" ;
	$this->query($sql);			
}
	
function adminDetails($admin_id){
	$sql = "SELECT * FROM ".$this->prefix()."admin WHERE admin_id='".$admin_id."'" ;
	$this->query($sql);			
}
	
function adminBillingDetails($admin_id){
	$sql = "SELECT * FROM ".$this->prefix()."admin_card_billing WHERE admin_id='".$admin_id."'" ;
	$this->query($sql);			
}
	
function add_admin_per_ticket($x_card_num,$x_exp_date,$x_first_name,$x_last_name,$x_address,$x_city,$x_state,$x_country,$x_zip,$email,$phone,$ticket_sold,$transId,$dateTime,$admin_id,$total_amount,$subscription_fee)
{
	$sql="INSERT INTO ".$this->prefix()."admin_per_ticket SET 
		card_no='".$x_card_num."',
		x_exp_date='".$x_exp_date."',
		fname='".$x_first_name."',
		lname='".$x_last_name."',
		address='".$x_address."',
		city='".$x_city."',
		state='".$x_state."',
		country='".$x_country."',
		zip='".$x_zip."',
		email='".$email."',
		ticket_sold='".$ticket_sold."',
		amount='".$total_amount."',
		subscription_fee='".$subscription_fee."',
		transaction_id='".$transId."',
		createdtime='".$dateTime."',
		admin_id='".$admin_id."',
		phone='".$phone."'
		 ";
		 //echo $sql;
		return $this->query($sql);
}	

// Get Information of Ticket Seller Who choose Option #2

function ticket_seller_nextOption($limit)
{
	$sql = "SELECT A.*,B.* FROM `ticket_admin_card_billing` as A, ticket_admin as B WHERE A.`admin_id` = B.`admin_id` ORDER BY A.id DESC $limit";
	$this->query($sql);			
}

function ticket_seller_nextOption_num()
{
	$sql = "SELECT A.*,B.* FROM `ticket_admin_card_billing` as A, ticket_admin as B WHERE A.`admin_id` = B.`admin_id` ";
	$this->query($sql);			
}

function getTPaymentDetails($admin_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."admin_per_ticket WHERE admin_id='".$admin_id."' ORDER BY createdtime DESC LIMIT 1" ;
	$this->query($sql);			
}

function allPayDtlsMerchant($limit,$keyword=false)
{
	if($keyword){
		list($first,$last) = explode(" ",$keyword);
		if($first!="" && $last!="")
			$inner= " Where fname like '%".$keyword."%' OR fname like '%".$first."%' OR lname like '%".$keyword."%' OR lname like '%".$last."%' ";
		else if($first!="" && $last=="")
			$inner= " Where fname like '%".$keyword."%' OR fname like '%".$first."%' OR lname like '%".$keyword."%' ";
		else if($first=="" && $last!="")
			$inner= " Where fname like '%".$keyword."%' OR lname like '%".$keyword."%' OR lname like '%".$last."%' ";
	}else{
	$inner='';	
	}
	$sql = "SELECT * FROM ".$this->prefix()."admin_per_ticket ".$inner." ORDER BY createdtime  $limit " ;
	$this->query($sql);			
}

function allPayDtlsMerchant_num()
{
	$sql = "SELECT * FROM ".$this->prefix()."admin_per_ticket ORDER BY createdtime " ;
	$this->query($sql);			
}
	
	function merchantBillingInfo($limit)
	{
		$sql = "SELECT A.status,A.id,B.*,C.* FROM  ".$this->prefix()."admin_card_billing as A, ".$this->prefix()."merchant_pay_details as B,".$this->prefix()."admin as C WHERE A.`admin_id` = B.admin_id AND B.`admin_id`=C.`admin_id` ORDER BY B.payment_dtls_id DESC $limit";
		$this->query($sql);
	}


	function merchantBillingInfo_num()
	{
		$sql = "SELECT B.*,C.* FROM  ".$this->prefix()."admin_card_billing as A, ".$this->prefix()."merchant_pay_details as B,".$this->prefix()."admin as C WHERE A.`admin_id` = B.admin_id AND B.`admin_id`=C.`admin_id` ORDER BY B.payment_dtls_id DESC ";
		$this->query($sql);
	}

	function mer_bill_By_admin($payment_dtls_id)
	{
		$sql = "SELECT * FROM  ".$this->prefix()."merchant_pay_details as A WHERE A.`payment_dtls_id` = '".$payment_dtls_id."' ";
		$this->query($sql); 
	}

	function get_mer_info($payment_dtls_id)
	{
		$sql = "SELECT A.*,B.* FROM  ".$this->prefix()."merchant_pay_details as A, ".$this->prefix()."admin as B WHERE A.`admin_id`= B.`admin_id` AND A.`payment_dtls_id` = '".$payment_dtls_id."' ";
		$this->query($sql);
	}

	function edit_mer_billing_info($paypay_email,$api_login_id,$trans_key,$api_url,$payment_type,$provider_name,$payment_form,$payment_dtls_id)
	{
		$sql = "update ".$this->prefix()."merchant_pay_details set paypal_email='".$paypay_email."',api_login_id='".$api_login_id."',transction_key='".$trans_key."' ,api_url='".$api_url."' ,payment_type='".$payment_type."',provider_name='".$provider_name."' ,payment_form='".$payment_form."' where payment_dtls_id=".$payment_dtls_id;
		/*echo $sql;
		exit;*/
		$this->query($sql);
	}
	
	function lastTicketDate($admin_id)
	{
		$sql = "SELECT createdtime FROM ".$this->prefix()."admin_per_ticket WHERE id IN (SELECT max(`id`) id FROM ".$this->prefix()."admin_per_ticket WHERE `admin_id`='$admin_id' )";
		$this->query($sql);
	}
	
	function getSoldTicket($dateTime,$get_event_id)
	{
		$sql = "SELECT sum(ticket_sold) tot_ticket_sold FROM ".$this->prefix()."price_level_by_date WHERE `date_time` > '$dateTime' AND event_id='$get_event_id'";
		//echo $sql;
		$this->query($sql);
	}
	
	function getEventByAdmin($admin_id)
	{
		$sql="SELECT * FROM ".$this->prefix()."events  WHERE admin_id ='".$admin_id."' ";
		$this->query($sql);
	}	

	function optionTwoEvent($event_id)
	{
		$sql = "SELECT payment_dtls_id  FROM ".$this->prefix()."merchant_pay_details AS A, ticket_events AS B WHERE A.`admin_id` = B.`admin_id` AND event_id= '$event_id'";
		$this->query($sql);
	}
	
	function updateMerStatus($id,$status)
	{
		$sql = "update ".$this->prefix()."admin_card_billing set status='".$status."' where id=".$id;
		/*echo $sql;
		exit;*/
		$this->query($sql);
	}

	function servFeeOptionTwo($order_id)
	{
		$sql = "SELECT A.service_fee  FROM `".$this->prefix()."servicefee_optiontwo` AS A,".$this->prefix()."order AS B WHERE A.`event_id` = B.`event_id` AND B.order_id = '".$order_id."'";
		$this->query($sql);
	}
		
	function sale_detail_option($order_id)
	{
		$sql = "SELECT * FROM `ticket_order` AS A,ticket_events AS B,ticket_admin_card_billing AS C WHERE A.`event_id` = B.`event_id` AND B.admin_id = C.admin_id AND A.`order_id` ='".$order_id."' ";
		$this->query($sql);
	}


	// =========================== end ================================	
	
	
function categorylist()
{
	$sql="SELECT * FROM ".$this->prefix()."event_category WHERE parent_category = '0'";
	return $this->query($sql);
}
function getAllCat($limit)
{
	$sql="SELECT * FROM ".$this->prefix()."event_category WHERE parent_category = '0' $limit ";
	return $this->query($sql);
}
function getAllCatnum()
{
	$sql="SELECT * FROM ".$this->prefix()."event_category WHERE parent_category = '0'";
	return $this->query($sql);
}

function getAllSubCat($limit)
{
	$sql="SELECT * FROM ".$this->prefix()."event_category WHERE parent_category != '0' $limit ";
	return $this->query($sql);
}

function getAllSubCatnum()
{
	$sql="SELECT * FROM ".$this->prefix()."event_category WHERE parent_category != '0' ";
	return $this->query($sql);
}

	
function addEventCategory($parent_id,$category_name,$category_name_sp)
{
	$sql = "INSERT INTO ".$this->prefix()."event_category SET parent_category = '".$parent_id."',category_name = '".$category_name."',category_name_sp = '".$category_name_sp."'";
	$this->query($sql);
}

function editEventCategory($parent_id,$category_name,$category_id)
{
	$sql = "UPDATE ".$this->prefix()."event_category SET parent_category = '".$parent_id."',category_name = '".$category_name."' WHERE category_id = '".$category_id."'";
	$this->query($sql);
}	
	
function allCategoryList($limit)			
{
	$sql="SELECT A.category_name as cat1,A.category_id parentcat_id,B.category_id as subcat_id, A.category_status, A.parent_category, B.category_name as cat2 FROM kcp_event_category A LEFT JOIN kcp_event_category B ON(A.category_id=B.parent_category) ORDER BY A.category_id ASC $limit";
	$this->query($sql);
}

function allCategoryListnum()			
{
	$sql="SELECT A.category_name as cat1,A.category_id parentcat_id,B.category_id as subcat_id, A.category_status, A.parent_category, B.category_name as cat2 FROM kcp_event_category A LEFT JOIN kcp_event_category B ON(A.category_id=B.parent_category) ORDER BY A.category_id ASC";
	$this->query($sql);
}

function getParentCatName($category_id)			
{
	$sql="SELECT A.category_name as cat1,A.category_id parentcat_id,B.category_id as subcat_id, B.category_name as cat2 FROM kcp_event_category A INNER JOIN kcp_event_category B ON(A.category_id=B.parent_category) WHERE B.category_id = $category_id";
	$this->query($sql);
}

function parentcategory($category_id)
{
	$sql = "SELECT * FROM ".$this->prefix()."event_category  WHERE parent_category = 0 AND category_id = '".$category_id."'";
	$this->query($sql);
}


function getCategoryById($id)
{
	$sql = "SELECT * FROM ".$this->prefix()."event_category  WHERE category_id = ".$id;
	$this->query($sql);
}

function allCategoryListCount()			
{
	$sql="SELECT * FROM ".$this->prefix()."event_category";
	$this->query($sql);
}	

function changeEventCategoryStatus($id,$status)			
{
	if($status == 'Y')
	{
	  $new_status = 'N';
	}
	else
	{
	  $new_status = 'Y';
	}
	
	$sql="UPDATE ".$this->prefix()."event_category SET category_status = '".$new_status."' WHERE category_id = '".$id."'";
	$this->query($sql);
}

function deleteEventCategory($id)
{
	$sql="DELETE FROM ".$this->prefix()."event_category WHERE parent_category = '".$id."'";
	$this->query($sql);
	
	$sql2="DELETE FROM ".$this->prefix()."event_category WHERE category_id = '".$id."'";
	$this->query($sql2);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function statelist()
{
	$sql="SELECT * FROM ".$this->prefix()."state WHERE country_id = '138'";
	return $this->query($sql);
}

function countylist($state)
{
	$sql="SELECT * FROM ".$this->prefix()."county WHERE state_id = '".$state."'";
	return $this->query($sql);
}

function citylist($county)
{
	$sql="SELECT * FROM ".$this->prefix()."city WHERE county_id = '".$county."'";
	return $this->query($sql);
}

function getStateNameByCountry($countryId)
{
	$sql="SELECT * FROM ".$this->prefix()."state WHERE country_id = '".$countryId."' ORDER BY id ASC";
	return $this->query($sql);
}

function getCountyNameByState($stateId)
{
	$sql="SELECT * FROM ".$this->prefix()."county WHERE state_id = '".$stateId."' ORDER BY id ASC";
	return $this->query($sql);
}

function getCityNameByCounty($countyId)
{
	$sql="SELECT * FROM ".$this->prefix()."city WHERE county_id = '".$countyId."' ORDER BY id ASC";
	return $this->query($sql);
}

function addVenue($venue_country,$venue_state,$venue_county,$venue_city,$venue_name,$venue_address,$venue_zip)
{
	$sql = "INSERT INTO ".$this->prefix()."venue SET venue_country = '".$venue_country."',venue_state = '".$venue_state."',venue_county = '".$venue_county."',venue_city = '".$venue_city."',venue_name = '".$venue_name."',venue_address = '".$venue_address."',venue_zip = '".$venue_zip."',admin_id = '1',organization_id = '1'";
	$this->query($sql);
}
	
function allVenueList($limit)			
{
	$sql="SELECT A.*,B.county_name,C.state_name,D.city_name FROM ".$this->prefix()."venue AS A, ".$this->prefix()."county AS B, ".$this->prefix()."state AS C, ".$this->prefix()."city AS D WHERE A.venue_county = B.id AND A.venue_state = C.id AND A.venue_city = D.id ORDER BY A.venue_id DESC $limit";
	$this->query($sql);
}

function allVenueListCount()			
{
	$sql="SELECT * FROM ".$this->prefix()."venue";
	$this->query($sql);
}	
	
function deleteVenue($id)
{
	$sql="DELETE FROM ".$this->prefix()."venue WHERE venue_id = '".$id."'";
	$this->query($sql);
}

function getVenueById($id)
{
	$sql = "SELECT * FROM ".$this->prefix()."venue WHERE venue_id = ".$id;
	$this->query($sql);
}

function editVenue($venue_country,$venue_state,$venue_county,$venue_city,$venue_name,$venue_address,$venue_zip,$venue_id)
{
	$sql = "UPDATE ".$this->prefix()."venue SET venue_country = '".$venue_country."',venue_state = '".$venue_state."',venue_county = '".$venue_county."',venue_city = '".$venue_city."',venue_name = '".$venue_name."',venue_address = '".$venue_address."',venue_zip = '".$venue_zip."' WHERE venue_id = '".$venue_id."'";
	$this->query($sql);
}

function allCityList($limit)			
{
	$sql = "SELECT A.*,B.printable_name,C.state_name,D.county_name FROM ".$this->prefix()."city AS A, ".$this->prefix()."countries AS B, ".$this->prefix()."state AS C, ".$this->prefix()."county AS D WHERE A.county_id = D.id AND D.state_id = C.id AND C.country_id =  B.id ORDER BY A.id DESC $limit";
	$this->query($sql);
}

function allCityListCount()			
{
	$sql="SELECT * FROM ".$this->prefix()."city";
	$this->query($sql);
}
	
function deleteCity($id)
{
	$sql="DELETE FROM ".$this->prefix()."city WHERE id = '".$id."'";
	$this->query($sql);
	
	$sql2="DELETE FROM ".$this->prefix()."venue WHERE venue_city = '".$id."'";
	$this->query($sql2);
}

function addCity($venue_county,$city_name)
{
	$sql = "INSERT INTO ".$this->prefix()."city SET county_id = '".$venue_county."',city_name = '".$city_name."'";
	$this->query($sql);
}

function selectcityDetailsByID($city_id)
{
	$sql="SELECT A.id, A.county_id, A.city_name, B.id as counid, B.state_id, B.county_name, C.id as stateid, C.country_id, C.state_name, D.id as cid, D.printable_name FROM ".$this->prefix()."city A, ".$this->prefix()."county B, ".$this->prefix()."state C, ".$this->prefix()."countries D WHERE A.county_id = B.id AND B.state_id = C.id AND C.country_id = D.id AND A.id =".$city_id;
	$this->query($sql);
}
function selectstateByID($cid){
		$sql="SELECT * FROM ".$this->prefix()."state where country_id=".$cid;
		return $this->query($sql);
	}
function Municipio($stateid){
		$sql="SELECT * FROM ".$this->prefix()."county where state_id=".$stateid;
		return $this->query($sql);
	}
function updateCity($venue_county,$city_name,$cityid)
{
	$sql = "UPDATE ".$this->prefix()."city SET county_id = '".$venue_county."', city_name = '".$city_name."' where id=".$cityid;
	$this->query($sql);
}




function updateAdminSettings($event_show_number,$show_weekly_recurring_events)
{
	$sql = 'UPDATE '.$this->prefix().'admin SET event_show_number = "'.$event_show_number.'",show_weekly_recurring_events="'.$show_weekly_recurring_events.'" WHERE admin_id = 1';
	$this->query($sql);
}

function selectAdministratorInfo()
{
	$sql = "SELECT * FROM ".$this->prefix()."admin WHERE admin_id = '1'";
	$this->query($sql);
}

function delsubcat($scid)
{
	$sql="DELETE FROM ".$this->prefix()."event_category WHERE parent_category != 0 AND category_id = ".$scid;
	$this->query($sql);
}

function delcat($cid)
{
	$sql="DELETE FROM ".$this->prefix()."event_category WHERE parent_category = 0 AND category_id =".$cid;
	$this->query($sql);
	
	$sql="DELETE FROM ".$this->prefix()."event_category WHERE parent_category = ".$cid;
	$this->query($sql);
}
} // end of class

?>