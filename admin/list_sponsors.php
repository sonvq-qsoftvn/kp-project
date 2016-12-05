<?php
include('../include/admin_inc.php');

$obj_sponsors = new admin;
$obj_sponsors->getAllSponsors();
$num = $obj_sponsors->num_rows();
$items = 10;
$page = 1;

$uri =   $_SERVER['REQUEST_URI']; 
     
?>

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

<!-- jQuery lightBox plugin -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Admin Sponsors List</title>
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
function del(gID)
{
	if(confirm("Are you sure you want to delete this sponsor?"))
	{
		window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete-sponsors/"+gID;
	}	
}

</script>

<?php include("../include/analyticstracking.php")?>
</head>

<body class="body1">
    <?php include("admin_header.php");?>

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
                            <div class="blue_box10"><p>Sponsors Management</p></div>
                            <?php include("admin_menu/sponsors_menu.php");?>
                        </div>

                       <div class="clear"></div>                        
                    </div>	
                 </div>
            </div>

            <div class="clear"></div>

            <div class="myevent_box">		 
                <?php
                    if($num>0)
                    {
                        $target = $obj_base_path->base_path()."/admin/list_sponsors.php";
                        $p = new pagination;
                        $p->Items($num);
                        $p->limit($items);
                        $p->target($target);
                        $p->currentPage($page);
                        $p->calculate();
                        $p->changeClass("pagination");		
                ?>
                <?php if ($num > 10) : ?>
                    <div style="width: 150px; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
                <?php endif; ?>
                <?php
                    }
                 ?>
            </div>		

            <div class="clear"></div>	
            <div style="color:green; margin-top:10px; font-size: 18px;">
                <?php
                if(isset($_SESSION['media_del_msg'])){
                    echo $_SESSION['media_del_msg'];
                    unset($_SESSION['media_del_msg']);
                }

				if(isset($_SESSION['msg'])){
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
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
                                <td width="10%" class="top_txt">Name</td>  
                                <td width="10%" class="top_txt">Link</td>                                
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
                                    while($row = $obj_sponsors->next_record())
                                    {
                            ?>


                            <tr>
                                <td><?php echo $obj_sponsors->f('name');?></td>
                                <td><?php echo $obj_sponsors->f('link');?></td>                
                                <td style="padding: 5px;">
                                    <span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-sponsors/<?php echo $obj_sponsors->f('id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
                                    <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $obj_sponsors->f('id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
                                </td>
                            </tr>
                            <?php
                                    } //while  end 
                            ?>
                            <?php if ($num > 10) : ?>
                                <td colspan="10" align="left"><div style="width: 150px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
                            <?php endif; ?>
                            <?php
                                }
                                else
                                {
                            ?>
                            <tr><td colspan="10" align="center" style="padding-top:10px;"><font color="#FF0000">No Sponsors Found</font></td></tr>
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