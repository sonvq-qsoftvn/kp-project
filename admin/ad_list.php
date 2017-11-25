<?php
include('../include/admin_inc.php');
include('../class/test_class.php');

//create object
$objadlist = new test();
$objadlist_num = new test();
$obj_ads_client=new admin;
$obj_ads_client->getAllClient();
$event_id=$_REQUEST['event_id'];
$uri =   $_SERVER['REQUEST_URI']; 
?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php
// Search 
$items =10;
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

if(!empty($url_parts) && isset($url_parts['short_by']) && $url_parts['short_by']!=""){
    $short_by = $url_parts['short_by'];    
}else{    
    $short_by = "";
}

if(!empty($url_parts) && isset($url_parts['add_then_by']) && $url_parts['add_then_by']!="")
{
    $add_then_by = $url_parts['add_then_by'];    
}else{
    $add_then_by = "";
}

$whereClause = '';
if($_REQUEST['add_size'])
{
    $whereClause .= " AND ka.ad_size = '".$_REQUEST['add_size']."'";
}

if($_REQUEST['position_id'])
{
    $whereClause .= " AND ka.position_id = '".$_REQUEST['position_id']."'";
}

if($_REQUEST['client_id'])
{
    $whereClause .= " AND ka.client_id = '".$_REQUEST['client_id']."'";
}

if(isset($_REQUEST['chek_list']) &&  $_REQUEST['chek_list']=='all_expired_ads') {
    $objadlist->getAllexpiredAds($limit,$short_by,$add_then_by,$whereClause);
    $objadlist_num->getAllexpiredCount($whereClause);
    $num = $objadlist_num->num_rows();       
} else {          
    $objadlist->getAllAds($limit,$short_by,$add_then_by,$whereClause);
    $objadlist_num->getAllAdsCount($whereClause);
    $num = $objadlist_num->num_rows();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kcpasa - Admin Promotion List</title>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

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
.date-pick {
    margin-top: 5px;
    height: 20px;
    text-indent: 10px;
    width: 100px;
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
.save-on-blur {
    margin-top: 5px;
    height: 20px;
    text-indent: 10px;
    width: 70px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script language="javascript">

$(document).ready(function(){
    $("#add_short_by").change(function() {		
        var short_by_val = $("#add_short_by").val();               
        <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>	      
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by="+short_by_val+"&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";	    
        <?php else : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by="+short_by_val+"&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>";
        <?php endif; ?>
        window.location.href = url;
        return false;
    });
        
    $( "#add_then_by" ).change(function() {	
        var add_then_by = $("#add_then_by").val();
        <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by="+add_then_by+"&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";
        <?php else : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by="+add_then_by+"&client_id=<?php echo $_REQUEST['client_id']?>";	       	
        <?php endif; ?>		
        window.location.href = url;
        return false;
    });

    $("#add_owner").change(function() {
        var short_by_add_owner = $("#add_owner").val();
        <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
            var  url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id="+short_by_add_owner+"&page=<?php echo $_REQUEST['page']?>";    
        <?php else : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id="+short_by_add_owner;
        <?php endif; ?>
        window.location.href = url;
        return false;
    });
 
    $( "#add_short_by_size" ).change(function() {	
        var short_by_va_size =  $("#add_short_by_size" ).val();
        <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size="+short_by_va_size+"&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";
        <?php else : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size="+short_by_va_size+"&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>";  
        <?php endif; ?>
        window.location.href = url;
        return false;
    });

    $( "#add_then_by_position" ).change(function() {
        var short_by_va_position = $("#add_then_by_position" ).val();
        <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id="+short_by_va_position+"&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";               
        <?php else : ?>
            var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=<?php echo $_REQUEST['chek_list']?>&add_size=<?php echo $_REQUEST['add_size']?>&position_id="+short_by_va_position+"&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>";				
        <?php endif; ?>
        window.location.href = url;
        return false;
    });

});


    function expired_ads()
    {
        if (document.getElementById('check_list').checked) {
            <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
                var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=all_expired_ads&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";               
            <?php else : ?>
                var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=all_expired_ads&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>";				
            <?php endif; ?>
        } else {
            <?php if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page'])) : ?>
                var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>&page=<?php echo $_REQUEST['page']?>";               
            <?php else : ?>
                var url = "<?php echo $obj_base_path->base_path();?>/admin/ad_list.php?chek_list=&add_size=<?php echo $_REQUEST['add_size']?>&position_id=<?php echo $_REQUEST['position_id']?>&short_by=<?php echo $_REQUEST['short_by']?>&add_then_by=<?php echo $_REQUEST['add_then_by']?>&client_id=<?php echo $_REQUEST['client_id']?>";				
            <?php endif; ?>
        }
        window.location.href = url;
        return false;
    }
</script>
<script language="javascript">
    function del(gID)
    {
        if(confirm("Are you sure you want to delete this Ad?"))
        {
            window.location="<?php echo $obj_base_path->base_path(); ?>/admin/delete-ad/"+gID;
        }
    }

    function clear_url()
    {
        window.location='<?php echo $obj_base_path->base_path(); ?>/admin/ad_list.php';
        return false;
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
     
            <div style="width:100px; padding: 5px; float:left">Filter On:</div>
            <div style="padding: 5px;  float:left">
                <div>
                    <select id="add_owner">
                        <option value="">Ad Owner</option> 
                        <?php while($row = $obj_ads_client->next_record()) { ?>
                            <option value="<?php echo  $obj_ads_client->f('client_id'); ?>"<?php if($_REQUEST['client_id']==$obj_ads_client->f('client_id')){?> selected <?php } ?>   ><?php echo  $obj_ads_client->f('business_name'); ?> </option>
                        <?php } ?>                 
                    </select>
                </div>
            </div>
            <div style="padding: 5px; float:left">
                <div>         
                    <select id="add_short_by_size">
                        <option value="">Ad Size</option>            
                        <option value="banner"  <?php if($_REQUEST['add_size']=="banner"){?> selected <?php } ?> >banner</option>
                        <option value="full"  <?php if($_REQUEST['add_size']=="full"){?> selected <?php } ?> >full</option>
                        <option value="bottom"  <?php if($_REQUEST['add_size']=="bottom"){?> selected <?php } ?>>bottom</option>                            
                    </select>         
                </div>      
            </div>     
            <div style="padding: 5px;  float:left">                
                <div>
                    <select id="add_then_by_position">
                        <option value="">Ad Position</option>               
                        <option value="1"  <?php if($_REQUEST['position_id']=="1"){?> selected <?php } ?>>1</option>
                        <option value="2" <?php if($_REQUEST['position_id']=="2"){?> selected <?php } ?>>2</option>
                        <option value="3" <?php if($_REQUEST['position_id']=="3"){?> selected <?php } ?>>3</option>             
                        <option value="4" <?php if($_REQUEST['position_id']=="4"){?> selected <?php } ?> >4</option>
                        <option value="5" <?php if($_REQUEST['position_id']=="5"){?> selected <?php } ?>>5</option>
                        <option value="6" <?php if($_REQUEST['position_id']=="6"){?> selected <?php } ?>>6</option>
                        <option value="7" <?php if($_REQUEST['position_id']=="7"){?> selected <?php } ?>>7</option>             
                        <option value="8" <?php if($_REQUEST['position_id']=="8"){?> selected <?php } ?> >8</option>
                        <option value="9"<?php if($_REQUEST['position_id']=="9"){?> selected <?php } ?>>9</option>             
                        <option value="10" <?php if($_REQUEST['position_id']=="10"){?> selected <?php } ?>>10</option>
                    </select>
                </div>
            </div>     
            <div class="clear"></div>
            <div style="width:180px; padding: 5px; float:left">
                <div style="float:left;">Sort By: </div>     
                <div>         
                    <select id="add_short_by">
                        <option value="">Choose One</option>
                        <option value="ka.client_id"  <?php if($_REQUEST['short_by']=="ka.client_id"){?> selected <?php } ?>>Ad owner</option>
                        <option value="From_date" <?php if($_REQUEST['short_by']=="From_date"){?> selected <?php } ?>>From Date</option>
                        <option value="ad_title" <?php if($_REQUEST['short_by']=="ad_title"){?> selected <?php } ?>>Ad Name</option>
                        <option value="ad_size" <?php if($_REQUEST['short_by']=="ad_size"){?> selected <?php } ?>>Ad size</option>             
                        <option value="position_id" <?php if($_REQUEST['short_by']=="position_id"){?> selected <?php } ?>>Ad position </option>
                    </select>         
                </div>      
            </div>     
            <div style="width:180px; padding: 5px;  float:left">
                <div style="float:left;">Then By: </div>
                <div>
                    <select id="add_then_by">
                        <option value="">Choose One</option>
                        <option value="ka.client_id"  <?php if($_REQUEST['add_then_by']=="ka.client_id"){?> selected <?php } ?>>Ad owner</option>
                        <option value="From_date" <?php if($_REQUEST['add_then_by']=="From_date"){?> selected <?php } ?>>From Date</option>
                        <option value="ad_title" <?php if($_REQUEST['add_then_by']=="ad_title"){?> selected <?php } ?>>Ad Name</option>
                        <option value="ad_size" <?php if($_REQUEST['add_then_by']=="ad_size"){?> selected <?php } ?>>Ad size</option>             
                        <option value="position_id" <?php if($_REQUEST['add_then_by']=="position_id"){?> selected <?php } ?>>Ad position </option>
                    </select>
                </div>
            </div>
     
            <div style="width:54px; padding: 5px; float:left"> <input type="button" onClick="clear_url()" value="Clear"/> </div>             
            <div style="width:148px; padding: 5px; float:left"> <strong>Show past ads </strong></div>      
            <div style="width:20px; padding: 5px; float:left"> 
                <input type="checkbox" name="chek_list" id="check_list" value="all_expired_ads" <?php if($_REQUEST['chek_list']!=""){?> checked="checked" <?php } ?> onclick="expired_ads()"/>
            </div>
            <div>	
                <div class="myevent_box">		 
                    <?php if($num>0) : ?>
                        <?php
                            $target = $obj_base_path->base_path()."/admin/ad_list.php?short_by=".$_REQUEST['short_by']."&add_then_by=".$_REQUEST['add_then_by'];
                            $p = new pagination;
                            $p->Items($num);
                            $p->limit($items);
                            $p->target($target);
                            $p->currentPage($page);
                            $p->calculate();
                            $p->changeClass("pagination");		
                        ?>	
                        <div style="width: 150px; float:right; margin: 0 auto; 	font: normal 11px/18px Arial, Helvetica, sans-serif;"><?php $p->show();?></div>
                    <?php endif; ?>
                </div>		

                <div class="clear"></div>		
                <div class="myevent_box">
                    <div class="event_header" style="color:#FF0000"><strong><?php echo $msg;?></strong></div>
                    <div class="myevent_left" style="width: 1000px;">
                        <div class="guide_box2">
						
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="id_detail2">
                                <tr>
                                    <?php if ($_SESSION['ses_account_type'] == 2) : ?>
                                        <td width="8%" class="top_txt"><?= Spotlight ?></td>
                                    <?php endif; ?>
                                    <td width="10%" class="top_txt">Ad Size</td>  
                                    <td width="10%" class="top_txt">Ad Position</td> 
                                    <td width="10%" class="top_txt">Ad Sub Position</td>
                                    <td width="21%" class="top_txt">Ad Title</td>
                                    <td width="16%" class="top_txt">Ad owner </td>
                                    <td width="14%" class="top_txt">From Date</td>
                                    <td width="14%" class="top_txt">End Date</td>
                                    <td width="14%" class="top_txt">Total Click</td>
                                    <td width="40%" class="top_txt">Manage</td>
                                </tr>
                                <?php if($num>0) : ?>
                                    <?php
                                        $p = new pagination;
                                        $p->Items($num);
                                        $p->limit($items);
                                        $p->target($target);
                                        $p->currentPage($page);
                                        $p->calculate();
                                        $p->changeClass("pagination");

                                        while($row = $objadlist->next_record()) {
                                    ?>
                                            <tr>
                                                <?php if ($_SESSION['ses_account_type'] == 2) : ?>
                                                    <td><input type="checkbox" id="<?php echo $objadlist->f('ad_id');?>" class="set_spotlight" name="set_spotlight" value="1" <?php if ($objadlist->f('spotlight') == 1) { echo 'checked'; } ?> /></td>
                                                <?php endif; ?>
                                                <td><?php echo $objadlist->f('ad_size');?></td>
                                                <td><input class="save-on-blur" data-ads-id="<?php echo $objadlist->f('ad_id');?>" 
                                                           data-origin-value="<?php echo $objadlist->f('position_id');?>" 
                                                           value="<?php echo $objadlist->f('position_id');?>" 
                                                           type="text" 
                                                           data-field="position_id" /></td>                
                                                <td><input class="save-on-blur" data-ads-id="<?php echo $objadlist->f('ad_id');?>" 
                                                           data-origin-value="<?php echo $objadlist->f('sub_position_id');?>" 
                                                           value="<?php echo $objadlist->f('sub_position_id');?>" 
                                                           type="text" 
                                                           data-field="sub_position_id" /></td>
                                                <td><?php echo $objadlist->f('ad_title');?></td>
                                                <td><?php echo $objadlist->f('business_name');?></td>
                                                <td><input type="text"  
                                                           value="<?php echo $objadlist->f('From_date');?>" 
                                                           data-ads-id="<?php echo $objadlist->f('ad_id');?>" 
                                                           class="date-pick"
                                                           data-origin-value="<?php echo $objadlist->f('From_date');?>" 
                                                           data-field="From_date"
                                                           data-result="end_date_<?php echo $objadlist->f('ad_id'); ?>"
                                                           readonly /></td>
											   
                                                <td id="end_date_<?php echo $objadlist->f('ad_id'); ?>" ><?php echo $objadlist->f('duration');?></td>
                                                <td><?php echo $objadlist->f('click_count');?></td>
                                                <td style="padding: 5px;">
                                                    <span style="margin:0;"><a href="<?php echo $obj_base_path->base_path(); ?>/admin/edit-ad/<?php echo $objadlist->f('ad_id');?>"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" /></a></span>
                                                    <span style="margin:0;"><a href="javascript:void(0);" onClick="del('<?php echo $objadlist->f('ad_id');?>');"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /></a></span>
                                                </td>   

                                            </tr>
                                    <?php } ?>
                                    <td colspan="10" align="left"><div style="width: 150px; float:right; margin: 0 auto;"><?php $p->show();?></div></td></tr>
                                <?php else : ?>
                                    <tr><td colspan="10" align="center" style="padding-top:10px;"><font color="#FF0000">No Ad Found</font></td></tr>
                                <?php endif; ?>
                            </table>
                        </div>	
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>	
            </div>
            <div class="clear"></div>					
        </div>
    </div>
	
 <!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>
 <script>
	$( function() {
		$('.date-pick').datepicker({ 
			//minDate: 0, 
			firstDay: 1,
			showButtonPanel: true, 
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst) {
                var valueInputed = $(this).val();
                var elementName= $(this).attr('data-field');
                var originValue = $(this).attr('data-origin-value');
                var elementResult = $(this).attr('data-result');
                var adId = $(this).attr('data-ads-id');
                var that = $(this);

                console.log("valueInputed = " + valueInputed);
                console.log("originValue = " + originValue);
                if (valueInputed != originValue) {
                    // call Ajax to save
                    $.ajax({ 
                        url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_save_ad_from_date.php",
                        cache: false,
                        type: "POST",
                        data: { 
                            "field_name": elementName, 
                            "ad_id": adId,
                            "save_value": valueInputed
                        },
                        success: function(datas){ 
                            $(that).attr('data-origin-value', valueInputed);
                            console.log('set value for origin value to be new inputed value = ' + valueInputed);
                            toastr.success('Your inputed data is saved successfully', 'Data saved successfully');
                            console.log(datas);
                            $("#" + elementResult).html(datas);
                        },
                        error: function(datas){ 
                            toastr.error('Something wrong, please try again later', 'Fail to save values to database');
                            $(this).val(originValue);  
                        }
                    });
                }

            }
		});
		//$( "#datepicker1" ).datepicker();
	});
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "2000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $('.set_spotlight').change(function(){
        this.value = (Number(this.checked));        
        $.ajax({ 
            url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_save_spotlight.php",
            cache: false,
            type: "POST",
            data: { 
                "spotlight": this.value, 
                "ad_id": this.id
            },
            success: function(datas){ 
                
            }
        });
    });
    
    function isInteger(n) {
        return /^[0-9]+$/.test(n);
    }    

    $('.save-on-blur').bind('blur', function(){        
        var valueInputed = $(this).val();
        var elementName= $(this).attr('data-field');
        var originValue = $(this).attr('data-origin-value');
        var adId = $(this).attr('data-ads-id');
        var that = $(this);
        
        if (elementName == "position_id" || elementName == "sub_position_id") {
            if (valueInputed == "" || !isInteger(valueInputed) || Number(valueInputed) < 0) {                
                //alert('Please input a valid positive integer value');
                toastr.error('Please input a valid positive integer value', 'Validation fail');
                $(this).val(originValue);    
                
                return false;
            }
        }
        console.log("valueInputed = " + valueInputed);
        console.log("originValue = " + originValue);
        if (valueInputed != originValue) {
            // call Ajax to save
            $.ajax({ 
                url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_save_position_subpotition.php",
                cache: false,
                type: "POST",
                data: { 
                    "field_name": elementName, 
                    "ad_id": adId,
                    "save_value": valueInputed
                },
                success: function(datas){ 
                    $(that).attr('data-origin-value', valueInputed);
                    console.log('set value for origin value to be new inputed value = ' + valueInputed);
                    toastr.success('Your inputed data is saved successfully', 'Data saved successfully');
                },
                error: function(datas){ 
                    toastr.error('Something wrong, please try again later', 'Fail to save values to database');
                    $(this).val(originValue);  
                }
            });
        }
         
    });
</script>
</body>
</html>