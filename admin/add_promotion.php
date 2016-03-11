<?php
session_start();

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$obj_social = new admin;
$obj_social_admin = new admin;
$objeventsocial = new admin;
$obj_social_event = new admin;
$objsociallist = new admin;
$objsociallist_num = new admin;
$objevent_social = new admin;
$objadmin_social = new admin;
$objEventDetails = new admin;
$objadminsocial = new admin;
$objsocialUrl= new admin;
$objDeleteEvent= new admin;
$event_id=$_REQUEST['event_id'];
//echo $event_id;
$admin_id = $_SESSION['ses_user_id'];

$objsociallist->getAllSocial($limit);
$num=$objsociallist->num_rows();
//echo "num= ".$num;

//===============CODE FOR INSERT===================//

/*=================================================================================*/
		function social_type($social_type) {
			if (strpos($social_type, 'facebook') > 0) {
			return 'FB';
			} elseif (strpos($social_type, 'twitter') > 0) {
			return 'twitter';
			} 
			else {
			return 'socialsite';
			}
		}
/*==================================================================================*/

	if(isset($_POST['save_hidden']) && $_REQUEST['save_hidden']=="1")
	{
		//echo "<pre>";print_r($_POST);exit;
		
		// For Checkbox Only
		
			$event_id=$_POST['event_id'];
			$social_url_arr = $_POST['social_url_arr'];
			$social_id_arr = $_POST['social_promotion'];
		
			//print_r($set_privacy_arr);
			$objDeleteEvent->deleteEventSocial($event_id);
			for($i=0;$i<sizeof($social_id_arr);$i++)
			{
				// -- add Content --	
				$objevent_social->add_social_withEvent($social_id_arr[$i],$event_id);
				
				$objadminsocial->getPromotionAdmiById($admin_id,$social_id_arr[$i]);
				$num_admin = $objadminsocial->num_rows();
				if($num_admin<1)
				{
					$objadmin_social->add_social_withAdmin($social_id_arr[$i],$admin_id);
				}
				
			}
		
		// For Checkbox Only
		
		
		// Add Url
		
			$e_id=$_POST['event_id'];
			$social_url=trim($_POST['social_url']);
			$social_type=social_type($social_url);
			$social_name=$_POST['social_name'];
			$social_lang=$_POST['social_lang'];
			
			$urlstr="";
			if(!empty($social_lang)){
			 $urlstr=implode(",",$social_lang);
			}
			else{
				$urlstr="es";
			}
			
		
			//cheking is Url is already exist....
			$objsocialUrl->isUrl($social_url);
			$objsocialUrl->next_record();
			$numurl=$objsocialUrl->num_rows();
			$social_id1=$objsocialUrl->f('social_id');
			//echo "sic=".$social_id1."<br/>";
			//echo "numURL= ".$numurl;
			
			// -- add Content --		
			 if($numurl<1)
			   { //echo  "enterif";
				$social_id = $obj_social->add_social($social_url,$social_type,$social_name,$urlstr);
				//echo $social_id."<br/>";
				$obj_social_admin->add_social_by_admin($social_id,$admin_id);
				$obj_social_event->add_social_on_event($social_id,$e_id);
			   }
			  else
			   {
				//echo  "enterelse";
				$socialid=$objsocialUrl->f('social_id');
				$objeventsocial->isEventForSocial($socialid,$e_id); //is there  same event for  same social id check from `kcp_event_social` table
				$numevent=$objeventsocial->num_rows();
				if($numevent<1)
				{
					$obj_social_admin->add_social_by_admin($socialid,$admin_id);
					$obj_social_event->add_social_on_event($socialid,$e_id);
				}
					
			   }
			  // exit();
			header("location:".$obj_base_path->base_path()."/admin/add-promotion/event/".$e_id);
			//$("#add_social").show();
			$msg = "Social add successfully";
			exit(); 
		
		// Add Url
		
		
		
		
	}
	if(isset($_REQUEST['check_submit'])) /*save for media image*/
	{
		//echo "<pre>";print_r($_POST);exit;
		
		$event_id=$_POST['event_id'];
		$social_url_arr = $_POST['social_url_arr'];
		$social_id_arr = $_POST['social_promotion'];
	  if($social_id_arr!="")
	   {	
		$objDeleteEvent->deleteEventSocial($event_id);
		for($i=0;$i<sizeof($social_id_arr);$i++)
		{
			//echo "<br/><==start>".$social_url_arr[$i]."<br/>".$social_id_arr[$i]."<br/><==end>";
			
			// -- add Content --	
			$objevent_social->add_social_withEvent($social_id_arr[$i],$event_id);
			
			$objadminsocial->getPromotionAdmiById($admin_id,$social_id_arr[$i]);
			$num_admin = $objadminsocial->num_rows();
			if($num_admin<0)
			{
				$objadmin_social->add_social_withAdmin($social_id_arr[$i],$admin_id);
			}
			
		}
		header("location:".$obj_base_path->base_path()."/admin/add-promo-schedule/event/".$event_id);
		exit();
	   }
	  else
	    {
		$msg = "No page url has been selected.";
		$_SESSION['msg'] = $msg;
		header("location:".$obj_base_path->base_path()."/admin/add-promotion/event/".$event_id);
		exit();
	    }
         }
	 
	
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Promotion</title>
	
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
	
/*---------MULTIPLE CHECK BOX SECTION START -----------*/

function allSocialCheck(source) {
		//alert("alj");
  checkboxes = document.getElementsByName('social_promotion[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

/*---------MULTIPLE CHECK BOX SECTION END -----------*/

/*---------Show Hide the ADD SOCIAL section --------*/
function addSocial()
{
	$("#add_social").toggle();
}

/*---------Show Hide the ADD SOCIAL section --------*/
</script>
<style>
#add_social
{
display: none;
}
</style>
<!------------------Delete Social----------------------->
<script language="javascript">
function del(gID)
{
	if(confirm("Are you sure you want to delete this Social ?"))
	{
		//alert("hohooh");
		window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete_promotion.php?id="+gID+"&event_id="+<?php echo $event_id ?>;
	}
	
}
</script>
<!------------------Delete Social----------------------->

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
           <div class="blue_box10"><p>Promotion</p></div>
           <div class="blue_boxr">
	       <ul>
		 <li><a href="<?php echo $obj_base_path->base_path()."/admin/add-promotion/event/".$event_id?>" class="here">List/Select Social Pages</a></li>
		 <!--<li><a href="<?php //echo $obj_base_path->base_path()."/admin/promotion-list/event/".$event_id?>">List Social</a></li>-->
	       </ul>
	    </div>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <div class="event_header" style="color:#FF0000"><strong><?php  if($_SESSION['msg']){ echo $_SESSION['msg']; $_SESSION['msg'] = ''; } ?></strong></div>
	<!--------Event Details Start------------->
	      <div>
	      <?php $objEventDetails->event_details_byID($event_id);
	      $objEventDetails->next_record();
	      //event_name   Event_Start_DateTime   Event_Venue   Event_City
	      echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
	      ?>
	      </div>
	<!--------Event Details End------------->
    <!---------------------put your div--here-------------------------------------------------- --> 
  
	   
    <div class="myevent_box"> 
        <div class="table_wrapper">
            <div class="myevent_left" style="width: 1000px;">
                <div class="guide_box2">
                   <!-- <form action="" method="post" onsubmit="return validation();">-->
		   
		<!--1st All Select  Form start-->
		<div>
		 <form name="frm" id="frm" method="post" action=""  enctype="multipart/form-data">
		 <input type="hidden" name="save_hidden" id="save_hidden" value="0" />
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
			<tr>
			<!--<td><input type="checkbox" name="all_social" id="checkAllSocial" onClick="allSocialCheck(this)" value="all_social"></td>-->
<td width="2%" class="top_txt"><input type="checkbox" name="all_social" id="checkAllSocial" onClick="allSocialCheck(this)" value="all_social">Select All</td>
			<td width="31%" class="top_txt">Social Page Url</td>
			<td width="16%" class="top_txt">Social Name</td>
			<td width="19%" class="top_txt">Social Type</td>
			<td width="14%" class="top_txt">Social Language</td>
			<td width="17%" class="top_txt">Manage Social</td>
			
			
			</tr>
	                <?php
			 if($num>0)
			  {
			    while($row = $objsociallist->next_record())
			     {
				$arr=explode(",",$objsociallist->f('eventid'));
				
			     ?>
			  
			<tr>
			<!--<td>&nbsp</td>-->
			
			<td><input type="checkbox" name="social_promotion[]" value="<?php echo $objsociallist->f('sc_id'); ?>"  id="social_promotion" <?php if(in_array($event_id,$arr)){echo "checked";}?>></td>
			<td><a href="<?php echo $objsociallist->f('social_url');?>" target=_blank><?php echo $objsociallist->f('social_url');?></a></td>
			<td><?php echo $objsociallist->f('social_name');?></td>
			<td><?php echo $objsociallist->f('social_type');?></td>
			<td><?php echo $objsociallist->f('social_lang');?></td>
			<!----Edit And  Delete START------>
			<td>
			<span style="margin:0;"><?php if($objsociallist->f('admin_id')==$_SESSION['ses_user_id']){?><a href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $event_id?>/edit-promotion/<?php echo $objsociallist->f('sc_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />Edit</a><?php }?></span>
	
        <span style="margin:0;"><?php if($objsociallist->f('admin_id')==$_SESSION['ses_user_id']){?><a href="javascript:void(0);" onClick="del('<?php echo $objsociallist->f('sc_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a><?php }?></span>
			
			<span style="margin:0;"><a href="<?php echo $objsociallist->f('social_url');?>" target=_blank>Priview</a></span>
		        </td>
	 <!----Edit And  Delete END------>
			<!--<td align="center"></td>-->
			<input type="hidden" name="social_url_arr[]" value="<?php echo $objsociallist->f('social_url');?>"/>
			<input type="hidden" name="social_id_arr[]" value="<?php echo $objsociallist->f('sc_id');?>"/>
			<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="event_id"/>
			</tr>
   
			<?php
			} //while  end
			?>
			<tr>					
			<td><input type="submit" name="check_submit" value="Save & Set Posting Schedule" class="createbtn"></td>
			<td><div><input type="button" name="social_but" value="Add Social" class="createbtn" onclick="addSocial();"></div></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>
 		 <?php
			}
			else
			{
		?>
		<tr><td colspan="7" align="center" style="padding-top:10px;"><font color="#FF0000">No Media Found</font></td></tr>
		<?php
			}
		?>
		
		</table>
		<div id="add_social">
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
			<input type="text" name="social_url" id="social_url" size="40"/>
			</td>
			</tr>
                        
			<tr>
			<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Social Name ::</td>
			<td width="87%">
			<input type="text" name="social_name" id="social_name" size="40"/>
			</td>
			</tr>
			<tr>
			<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Social Language ::</td>
			<td width="87%">
			<input type="checkbox" name="social_lang[]" id="social_lang" value="es" checked>Espanol &nbsp
			<input type="checkbox" name="social_lang[]" id="social_lang" value="en">English 
			</td>
			</tr>                                                       
                        <tr>
			<td>&nbsp;</td>	
			<td>
			<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="event_id"/>
			<!--<input type="submit" name="submit" id="submit" value="Add Social" class="createbtn" style="cursor:pointer;"/>-->
			<input type="button" name="submit1" id="submit1" value="Add Social" class="createbtn" style="cursor:pointer;" />
			</td>
			</td>
                        </tr>
                        </table>
                      </div>
		    </div>										
                 </fieldset>
		</div>
		</form><!----1st  form end----->
		</div>
		<!----1st All SElect  Form Div----->
		
		   
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

<script>
	$('#submit1').click(function(){
		//alert("test");
		$('#save_hidden').val(1);
		$('#frm').attr('action', 'add_promotion');
		$('#frm').submit();
		
		
	});
</script>

</body>
</html>
