<?php
include('include/user_inc.php');


$obj_saved_events=new user;
$obj_saved_events_num=new user;
$obj_del_saved=new user;

if($_REQUEST['saved_id']){
	
	$obj_del_saved->delSavedEvents($_REQUEST['saved_id']);
	$_SESSION['saved_msg'] = "Event unsaved!";
	header("location:".$obj_base_path->base_path()."/savedevents");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Saved Events</title>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=AIzaSyCaEfiGqBVrb7GgQKoYeCkb7CNMcQGfT-s" type="text/javascript"></script>

</head>

<body>

<?php include("include/secondary_header.php");?>
<?php include("include/menu_header.php");?>

<div id="maindiv">
<div class="clear"></div>

	<div class="body_bg">
    	<div class="clear"></div>
    	<div class="container">
         <div class="left_panel bg">
           <div class="cheese_box">
			 <div class="blue_box1">
			   <div class="blue_boxh"><p>Saved Event</p></div>
			 </div>
             <div class="clear"></div>
             <?php if($_SESSION['saved_msg']){?>
              <p style="font-size:16px;color:#F00;"><?php echo $_SESSION['saved_msg'];$_SESSION['saved_msg'] = '';?></p><?php } ?>
             <div class="Tchai_box" style="width: auto;">
               <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tool_event">
                  <tr>
                    <th width="40%">Event Name</th>
                    <th width="37%">Venue Name</th>
                    <th width="23%">Manage</th>
                  </tr>
                  <?php
				    $items = 10;
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
					$target=$obj_base_path->base_path()."/savedevents.php";	
					
					$obj_saved_events->savedEventByUser($limit,$_SESSION['ses_admin_id']);
					$obj_saved_events_num->savedEventByUserCount($_SESSION['ses_admin_id']);
					$num = $obj_saved_events_num->num_rows();
					if($num>0)
					{
						$p = new pagination;
						$p->Items($num);
						$p->limit($items);
						$p->target($target);
						$p->currentPage($page);
						$p->calculate();
						$p->changeClass("pagination1");
						$i=0;
						while($obj_saved_events->next_record())
						{
                  ?>
                  <tr>
                    <td><?php if($_SESSION['langSessId']=='eng') { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_en').'</a>'; } else { echo '<a href="'.$obj_base_path->base_path().'/event/'.$obj_saved_events->f('id').'">'.$obj_saved_events->f('event_name_sp').'</a>';}?></td>
                    <td><?php echo '<a href="'.$obj_base_path->base_path().'/venue/'.$obj_saved_events->f('venue_id').'">'.$obj_saved_events->f('venue_name').'</a>';?></td>
                    <td>
                    	<a href="<?php echo $obj_base_path->base_path(); ?>/savedevents/<?php echo $obj_saved_events->f('saved_id');?>">Remove</a>&nbsp;&nbsp;
                        <a href="">Share</a>&nbsp;&nbsp;
                        <a href="">Invite friends</a>
                    </td>
                  </tr>
                  <?php
						}
				  ?>
                  <tr>
                    <td colspan="3"><?php $p->show();?></td>
                  </tr>
                  <?php
					}
					else{
				  ?>
                   <tr>
                    <td colspan="3"> <span style="font-size:14px;color:red">No Record Found</span></td>
                  </tr>
                   <?php
						}
				  ?>
                </table>
             </div>
           </div>
           <div class="clear"></div>
                    
         </div>
         <?php include("include/frontend_rightsidebar.php");?>
         <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <?php include("include/frontend_footer.php");?>
</div>


</body>
</html>
