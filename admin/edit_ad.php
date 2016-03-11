<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$obj_social = new admin;
$objsociallist = new admin;
$obj_social_update = new admin;


$event_id=$_REQUEST['event_id'];
//echo $event_id;
$social_id = $_REQUEST['social_id'];
//echo $social_id;
$admin_id = $_SESSION['ses_user_id'];

$objsociallist->allPromotionByID($social_id,$admin_id);
$objsociallist->next_record();
//echo "s_lang= ".$objsociallist->f('social_lang');
$social_lang_arr = explode(",",$objsociallist->f('social_lang'));

/*----------For Check  box language--------*/
 foreach($social_lang_arr as $lang)
  {
	if($lang=="es")
	 {
	   $social_lang_es="es";
	 }
	elseif($lang=="en")
	 {
	   $social_lang_en="en";
	 }
  }
/*----------For Check  box language--------*/

//===============CODE FOR update===================//

if(isset($_REQUEST['submit'])) /*save for media image*/
	{
		
		$e_id=$_POST['event_id'];
		$sc_id=$_POST['social_id'];
		$social_url=$_POST['social_url'];
		$social_type=$_POST['social_type'];
		$social_lang=$_POST['social_lang']; //social_lang ARRAY
		$urlstr="";
		if(!empty($social_lang)){
		 $urlstr=implode(",",$social_lang);
		}
		else{
			$urlstr="es";
			//echo $urlstr;
		}
		
		// -- add Content --		
		//$objmedia->update_media_gallery($set_privacy,$media_id);
		$obj_social_update->update_social($sc_id,$social_url,$social_type,$urlstr);
		
		header("location:".$obj_base_path->base_path()."/admin/promotion-list/event/".$e_id);
		$msg = "Social updated successfully";
	        //exit();
         }
	
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kcpasa - Edit Social</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>




<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->


<script language="javascript" type="text/javascript">
function allSocialCheck(source) {
		//alert("alj");
  checkboxes = document.getElementsByName('social_promotion[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

</script>


</head>

<body class="body1">
<?php include("admin_header.php"); ?>
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
           <div class="blue_box10"><p>Add Social</p></div>
          
				<div class="blue_boxr">
				  <ul>
				   <li><a href="<?php echo $obj_base_path->base_path()."/admin/add-promotion/event/".$event_id?>" class="here">Create/Edit Social</a></li>
				   <li><a href="<?php echo $obj_base_path->base_path()."/admin/promotion-list/event/".$event_id?>">List Social</a></li>
			
				 </ul>
			   </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    <div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#090;">
        <strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?>
		
		</strong></div>
	<?php if($msg!=""){?>
	<div style="font-family:Arial, Helvetica, sans-serif; padding-left:10px; color:#090;">
        <strong><?php echo $msg;?>		
		</strong></div>	
	<?php
	}?>	
	   
    <div class="myevent_box"> 
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
                <div class="guide_box2">
                   <!-- <form action="" method="post" onsubmit="return validation();">-->
		   <form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"  enctype="multipart/form-data">
                    <fieldset>
                    <!--[if !IE]>start table_wrapper<![endif]-->
                    <div class="table_wrapper">
                      <div class="table_wrapper_inner">														
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="sptable">
                         <tr>
                          <td colspan="2"><font color="#FF0000"><?php //echo $msg;?></font></td>
                         </tr>
                         <tr>
			<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Social URL ::</td>
			<td width="87%">
			<input type="text" name="social_url" id="social_url" size="40" value="<?php echo $objsociallist->f('social_url');?>"/>
			</td>
			</tr>
                         <tr>
			<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Type ::</td>
			<td width="87%">
			<input type="text" name="social_type" id="social_type" size="40"  value="<?php echo $objsociallist->f('social_type');?>"/>
			</td>
			</tr>                                                   
			<tr>
			<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Social Language ::</td>
			<td width="87%">
			<input type="checkbox" name="social_lang[]" id="social_lang" value="es" <?php if($social_lang_es==trim("es")){echo "checked";}?> >Espanol &nbsp
			<input type="checkbox" name="social_lang[]" id="social_lang" value="en"  <?php if($social_lang_en==trim("en")){echo "checked";}?> >English 
			</td>
			</tr>                                                       
                        <tr>
			<td>&nbsp;</td>	
			<td>
			<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="event_id"/>
			<input type="hidden" name="social_id" value="<?php echo $objsociallist->f('sc_id');?>" id="social_id"/>
			
			<input type="submit" name="submit" id="submit" value="Update Social" class="createbtn" style="cursor:pointer;"/>
			</td>
			</td>
                        </tr>
                        </table>
                      </div>
                    </div>											
                    </fieldset>
                    </form>
		   
		<div class="clear"></div>
                </div>
	      
            </div>
        </div>
    <div class="clear"></div>
    </div>
    
    
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>


</body>
</html>
