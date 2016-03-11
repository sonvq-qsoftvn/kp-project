<?php
include('../include/admin_inc.php');

//create object


$objadlist = new admin;
$objadlist_num = new admin;

$event_id=$_REQUEST['event_id'];
//echo "e_id=".$event_id;
//echo "hello";

$uri =   $_SERVER['REQUEST_URI']; 
     
  


?>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-media.js?v=1.0.6"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>


<?php
// Serach 
$items = 30;
$page = 1;
		
if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
{
	$limit = " LIMIT ".(($page-1)*$items).",$items";
	$i = $items*($page-1)+1;
}
else
{
	$limit = " LIMIT $items";
	$i = 1;
}

$url_parsed1= $obj_base_path->base_path().$uri;
$url_parsed = parse_url($url_parsed1);
parse_str($url_parsed['query'], $url_parts);




if(!empty($url_parts) && isset($url_parts['short_by']) && $url_parts['short_by']!="")
{
    
    $short_by = $url_parts['short_by'];
    
    
}else{
    
    $short_by ="";
    
    
    
}

if(!empty($url_parts) && isset($url_parts['add_then_by']) && $url_parts['add_then_by']!="")
{
    
    $add_then_by = $url_parts['add_then_by'];
    

    
    
}else{
    
    $add_then_by ="";
    
    
}


$objadlist->getAllAds($limit,$short_by,$add_then_by);
$objadlist_num->getAllAdsCount();

$num = $objadlist_num->num_rows();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Promotion List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<style>
.event_header{
	font-family:Arial, Helvetica, sans-serif; padding-left:10px;
	}
	.add_media{
		width: auto;
		height: 34px;
		background: #00f;
		margin: 0;
		display: inline-block;
	
	}
	.add_media a{
		font-size: 18px;
		line-height: 34px;
		font-weight:normal;
		color: #fff;
		text-align: center;
		padding:0 12px;
		margin: 0;
		display: block;
		text-decoration: none;
		cursor: pointer;
	}
</style>
<script language="javascript">
function feature_image_save(e_id)
{
	//alert("HI!");
	var media_id=$('input[name=feature_img]:checked').val();
	var event_id=e_id;
	//alert("m_id= "+media_id);
	//alert("e_id= "+event_id);
	$.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_saved_feature_image.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   data: "media_id="+media_id+"&event_id="+event_id, 
	   success: function(data){ 
	    // alert(data);
	     if(data!="")
	      {
		window.location = "<?php echo $obj_base_path->base_path();?>/admin/edit-event/"+e_id;
	      }
	   }
	 });
         
     
         
}


$(document).ready(function(){

    $( "#add_short_by" ).change(function() {
        
       var short_by_val     =  $("#add_short_by" ).val();
       
       var uri =  '<?php echo $_SERVER['REQUEST_URI'] ?>';
     
  
       var  url = "<?php echo $obj_base_path->base_path();?>"+uri+"?short_by="+short_by_val;


       window.location.href = url;
    
    
    
    });
    
    
    $( "#add_then_by" ).change(function() {
        
        var add_then_by     =  $("#add_then_by" ).val();   
        var uri =  '<?php echo $_SERVER['REQUEST_URI'] ?>';
       
        var  url = "<?php echo $obj_base_path->base_path();?>"+uri+"&add_then_by="+add_then_by;

        window.location.href = url;
    
    });
    
    


});


</script>
<script language="javascript">
function del(gID)
{
	if(confirm("Are you sure you want to delete this Ad?"))
	{
          
          
               
		window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete-ad/"+gID;
	}
	
}
</script>


<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1"><?php include("admin_header.php");?>

<div id="maindiv">
	
   
	
	<div class="clear"></div>
	<div class="body_bg">
     <div class="clear"></div>
     <div class="container">
        <?php include("admin_header_menu.php");?>
		 <div class="clear"></div>		
		<!--start body-->
		   <div id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <div class="blue_box1">
           		<div class="blue_box10"><p>Ad Management</p></div>
			     <?php include("admin_menu/createad_menu.php");?>
			   </div>
			   
			   
			    
			 <div class="clear"></div>
                         
                         <div style="color:green;">
        <?php
        
        if(isset($_SESSION['media_del_msg'])){
        
        
        echo $_SESSION['media_del_msg'];
        
        unset($_SESSION['media_del_msg']);
        }
        
        
        
    
    ?>
    
    </div>
                         
                         
                         
                         
            </div>	
		 </div>
		 </div>
     
 
     
     <div style="width:180px; padding: 5px; float:left">
     <div style="float:left;">Short By: </div>
     
     <div>
         
         <select id="add_short_by">
                <option value="">Ad owner</option>
                <option value="From_date">From Date</option>
                <option value="ad_title">Ad Name</option>
                <option value="ad_size">Ad size</option>             
                <option value="position_id">Ad position </option>
         </select>
         
     </div>
     
     </div>
     
     <div style="width:180px; padding: 5px;  float:left">
     <div style="float:left;">Then By: </div>
     
     <div>
         
         <select  id="add_then_by">
                <option value="">Ad owner</option>
                <option value="From_date">From Date</option>
                <option value="ad_title">Ad Name</option>
                <option value="ad_size">Ad size</option>             
                <option value="ad_position">Ad position </option>
         </select>
         
     </div>
     
     </div>
     
     
     <div style="width:20px; padding: 5px;  float:left"> <input type="submit" value="search"/> </div>
     
     
     
     
			<div>	
			
<!--			<span class="add_media"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-promotion/event/<?php echo $event_id?>" >add social network</a></span></div>
			-->
<!--         <input type="hidden" name="listEvent" id="listEvent" value="1" /> -->
        	
		 <div class="myevent_box">		 
	 	
			<?php
		 if($num>0)
			{
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");		
		?>	
			<div style="width: 150px; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
			<?php
			}
		 ?>
			</div>		
          
	 <div class="clear"></div>		
	 <div class="myevent_box">
	   <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
	    <div class="myevent_left" style="width: 1000px;">
		<div class="guide_box2">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
                        <td width="10%" class="top_txt">Ad Size</td>  
                        <td width="10%" class="top_txt">Ad Position</td> 
			<td width="20%" class="top_txt">Ad Title</td>
			
			<td width="20%" class="top_txt">From Date</td>
                        <td width="20%" class="top_txt">End Date</td>
                        <td width="30%" class="top_txt">Manage</td>
			</tr>
	                <?php
			 if($num>0)
			  {
				$p = new pagination;
				$p->Items($num);
				$p->limit($items);
				$p->target($target);
				$p->currentPage($page);
				$p->calculate();
				$p->changeClass("pagination");
				//$j=1;
			    while($row = $objadlist->next_record())
			     {
			     ?>
		
		
		<tr>
		<!--<td>&nbsp</td>-->
		<td><?php echo $objadlist->f('ad_size');?></td>
                <td><?php echo $objadlist->f('position_id');?></td>                
		<td><?php echo $objadlist->f('ad_title');?></td>
	
               
                <td><?php echo $objadlist->f('From_date');?></td>
                 <td><?php echo $objadlist->f('duration');?></td>
		<!--<td align="center"></td>-->
		<td style="padding: 5px;">
        	<span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-ad/<?php echo $objadlist->f('ad_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
        	
            <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objadlist->f('ad_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
            <span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/event/<?php echo $objadlist->f('ad_id');?>" target="_blank" style="color:#000;">Preview</a></span>
           <!-- <span style="margin:0 10px 0 0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/list-tickets/<?php echo stripslashes($objadlist->f('ad_id'));?>">View Tickets</a></span>-->
        </td>
                 
       </tr>
    
 
  <?php // $j++;
  } //while  end ?>
         <td colspan="7" align="left"><div style="width: 150px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Ad Found</font></td></tr>
		<?php
			}
		?>
</table>
    	</div>	
		<div class="clear"></div>
	</div>
	</div>
	<div class="clear"></div>	
	</div>
    <div class="clear"></div>
					
</div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
</body>
</html>