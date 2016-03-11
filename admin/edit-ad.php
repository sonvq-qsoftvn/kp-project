<?php

// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	
	$objmedia_es = new admin;
        $objmedia_en = new admin;
	$obj_media_update_es = new admin;
	$obj_media_update_en = new admin;
        
        
          $obj_ads_client=new admin;
        
        $obj_ads_client->getAllClient();
        
          //print_r($_REQUEST);
        
	 $edit_ad_id = $_REQUEST['ad_id'];
        
   
	 $obj_media_update_es->featch_ad_data_by_es_id($edit_ad_id);
	 $obj_media_update_es->next_record();
	 
	 
	      
	 $obj_media_update_en->featch_ad_data_by_en_id($edit_ad_id);
	 
	 $obj_media_update_en->next_record();


	 $strto_time_from_date_edit =strtotime($obj_media_update_en->f('From_date'));
	 $strto_time_duration_date_edit =strtotime($obj_media_update_en->f('duration'));
	  
	 $total_dduration_date =($strto_time_duration_date_edit - $strto_time_from_date_edit) / (60*60*24);
	    
	    //echo "<br>".$total_dduration_date;
  
//exit;

                //$strto_time_from_date = date('Y-m-d', $strto_time_from);
                
                
                
		// $last_duration_date_time = $strto_time_from +($_POST['duration_date'])*(60*60*24);
                
                // $strto_time_from_duration_date = date('Y-m-d',$last_duration_date_time);



      
      
           
	 if(isset($_REQUEST['ad_position']))
	 {
         
		  $edit_ad_id = $_REQUEST['ad_edit_id'];
 
		
		if( $_POST['ad_size']=='bottom')
		  {
			   $ad_position=0; 
			        
			  
			  }else{
				  
				 $ad_position=$_POST['ad_position']; 
				
			
		    }
		
		
		
		################### for insrt kpc_ad ###########################
		
		$strto_time_from =strtotime( $_POST['from_date']);

                $strto_time_from_date = date('Y-m-d', $strto_time_from);
                
                
                
		 $last_duration_date_time = $strto_time_from +($_POST['duration_date'])*(60*60*24);
                
                 $strto_time_from_duration_date = date('Y-m-d',$last_duration_date_time);
		
		
		 
		   $all_result_value = $obj_media_update_es->chek_dateduretion($_POST['ad_position'],$ad_size);
		   
		   $all_result = mysql_fetch_array( $all_result_value);
		   
		
                        $ad_size=$_POST['ad_size'];                       
                        $from_date = $strto_time_from_date;
                        $duration = $strto_time_from_duration_date;
			$ad_client_id=$_POST['client_id']; 	 
				 
		
		
	       ################### for spanish insrt kpc_contain table ###########################
	       
		         $image_name_es= $_POST['ad_photo_es'];
                         $ad_title_es = addslashes($_POST['ad_title_es']);
                         $ad_contain_es = addslashes($_POST['ad_contain_es']);
                         $ad_text_es  = addslashes($_POST['ad_text_es']);
                         $ad_url_es  = addslashes($_POST['ad_url_es']);
                         
                         
                            if($_POST['call_to_action_es']=="")
                            {
                             
                             $call_to_action_es  = "Click for more"; 
                             
                             
                             }else{
                             
                             $call_to_action_es  = addslashes($_POST['call_to_action_es']); 
                             
                             
                          }
                         
                          
		         $lenguage_id_es='es';
		
               ######################### end######################################################
		
		################### for English insrt kpc_contain table ###########################
                            $image_name_en= $_POST['ad_photo_en'];
                            $ad_title_en = addslashes($_POST['ad_title_en']);
                            $ad_contain_en = addslashes($_POST['ad_contain_en']);
                            $ad_url_en  = addslashes($_POST['ad_url_en']);
                            $ad_text_en  = addslashes($_POST['ad_text_en']);
                            
                            if($_POST['call_to_action_en']=="")
                            {
                             
                             $call_to_action_en  = "Click for more"; 
                             
                             
                             }else{
                             
                             $call_to_action_en  = addslashes($_POST['call_to_action_en']); 
                             
                             
                          }

                            $lenguage_id_en='en';
                            
         
	     
                
            
		
             $obj_media_update_es->update_ad($edit_ad_id,$ad_size,$ad_position, $from_date,$duration,$ad_client_id);
	    
            /*update the English  description*/
	    
	      $obj_media_update_es->update_ad_contain_es($edit_ad_id, $ad_title_es,$ad_contain_es,$ad_text_es,$lenguage_id_es,$ad_url_es,$image_name_es,  $call_to_action_es);
             
	      $obj_media_update_es->update_ad_contain_en($edit_ad_id, $ad_title_en,$ad_contain_en,$ad_text_en,$lenguage_id_en,$ad_url_en,$image_name_en, $call_to_action_en);
	    
              //exit;
              //$obj_media_update_en->update_media_details($media_id,$language_id_en,$set_privacy,$media_name_en,$caption_en,$alternate_text_en,$description_en);
		$_SESSION['ad_advertisment']='SuccessfullyUpdate Data';
                header("location:".$obj_base_path->base_path()."/admin/ad-list/");
                die; 
               
		?>
		
		<?php
        
         
     }	
         
         
         
	
	
?>
      
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kcpasa - Create gallery</title>
	
<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
<!-- Ajax File Upload -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
<!-- Ajax File Upload -->


<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<!--jquery tooltips -->
<script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
<!--jquery tooltips -->

<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

<?php include("../include/analyticstracking.php")?>

<script type="text/javascript">
    
   
    

$(function(){
   
   
   
 
  
var btnUpload=$('#me1');
var mestatus=$('#mestatus1');
var files=$('#files');

 

new AjaxUpload(btnUpload, {



action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadAdphoto.php',
name: 'uploadfile',
onSubmit: function(file, ext){
  
   var ad_size =$('#ad_size').val();
    
     
    
      if($('#ad_size').val()=="")
      {
         
        
        alert('please select ad Size');
        
        return false;
        
        
        
    }
    
    
    this.setData({ad_size:ad_size});
    
  
if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
// extension is not allowed 
mestatus.text('Only JPG, PNG or GIF files are allowed');
return false;
}
mestatus.html('Your file is being uploaded - please wait');
},
onComplete: function(file, response){
 
 //alert(response);
//On completion clear the status
mestatus.text('Photo Uploaded Sucessfully!');
$('#ad_photo_es').val(response);
$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/'+response+'" alt="" width="150" height="72" />');
$('#me1').html('');

$('#same_image_tr').show();

$('#up_image_next').trigger('click');
//On completion clear the status
}
});

});


$(function(){
var btnUpload=$('#me2');
var mestatus=$('#mestatus2');
var files=$('#files');
new AjaxUpload(btnUpload, {
action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadAdphoto.php?ad_size',
name: 'uploadfile',
onSubmit: function(file, ext){
    
    
    if($('#ad_size').val()=="")
    {
        
        
        alert('please select ad Size');
        
        return false;
        
        
        
    }
   
   
   this.setData({ad_size:ad_size}); 
    
if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
   
// extension is not allowed 
mestatus.text('Only JPG, PNG or GIF files are allowed');
return false;
}
mestatus.html('Your file is being uploaded - please wait');
},
onComplete: function(file, response){
    
     
    
//On completion clear the status
mestatus.text('Photo Uploaded Sucessfully!');
$('#ad_photo_en').val(response);
$('#imgshow1').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/'+response+'"  width="150" height="72" alt="" />');
$('#me2').html('');
$('#up_image_next').trigger('click');
//On completion clear the status
}
});

});





$(document).ready(function(){
    limiter_text();
    limiter_text1();
    limiter_call_to_action_en();
    limiter_call_to_action_es();
        
    $('#ad_size').change(function(){								  
        if($('#ad_size').val()=='bottom')
        {			
            $('#postion_id').hide();            
        } else {				
            $('#postion_id').show()	
        }				   
        limiter_text();
        limiter_text1();
        limiter_call_to_action_en();
        limiter_call_to_action_es();
    });				   

$('#submit_add').click(function(){

        
    if($('#ad_size').val()=="")
    {
        
        alert('please select Size');
        
        return false;
        
        }else if($('#ad_photo_es').val()==""){
            
            
           alert('Please Upload Photo For Espanoal'); 
            
            return false;
            
     }else if($('#ad_photo_en').val()==""){
         
         
           alert('Please Upload Photo For English'); 
            
             return false;
        
    }else if($('#ad_position').val()==""){
        
        
         alert('please select Position');
        
        return false;
        
        
    }else if($('#event_date_st').val()==""){
        
        
        
         alert('please add From Date');
         
            $('#event_date_st').focus();
        
        return false;
        

        
    }
    
    var duration_date = $('#duration_date').val();
  
    var from_date   =  $('#event_date_st').val();
    
    
	
        if($('#ad_size').val()=='bottom'){
            
           var add_position=0; 
        }else{
          var add_position = $('#ad_position').val();	
    
        }
    
    
    var ad_size = $('#ad_size').val();
    
    
     $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_get_date.php",
	   cache: false,
	   type: "POST",
	   data:"ad_position="+add_position+"&ad_size="+ad_size+"&start_date="+$('#event_date_st').val()+"&end_date="+duration_date+"&edit_ad_id=<?php echo $edit_ad_id;?>",
	   success: function(data){
               
              //alert(data);
		
	 if(data==1)
         {
             
             alert('Date Is Already  Booked');
             
             return false;
             
         }else{
             
             
            $('#frm_ad').submit();
	    return false;
            
             
             
             
         }
		
	
	   }
           
	 });	
	
    
    
    
	
	
	
});
	
$('#event_date_st').datepicker({
		firstDay: 1 ,	   
		showButtonPanel: true,
		minDate: 0,
		/*beforeShowDay: function(date){
			var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
			return [ array.indexOf(string) == -1 ]},*/
		
		
		
	});


});


var count = "25";   //Example: var count = "175";
	function limiter(){
	
		var tex = document.frm.ad_title_es.value;
		var len = tex.length;
		if(len > count){
				tex = tex.substring(0,count);
				document.frm.ad_title_es.value =tex;
				return false;
		}
		document.frm.limit.value = count-len;
	}

    var count_text = "90";
    var count_text_full = "180";
    function limiter_text(){
        var tex = document.frm.ad_text_es.value;
        var len = tex.length;
        if($('#ad_size').val()=='full') {
            var textCount = count_text_full;
        } else {
            var textCount = count_text;
        }
        
        if(len > textCount){
            tex = tex.substring(0,textCount);
            document.frm.ad_text_es.value =tex;
            return false;
        }
        document.frm.limit_text.value = textCount-len;
    }       
        
  var count1 = "25";   //Example: var count = "175";
	function limiter1(){
	
		var tex = document.frm.ad_title_en.value;
		var len = tex.length;
		if(len > count1){
				tex = tex.substring(0,count1);
				document.frm.ad_title_en.value =tex;
				return false;
		}
		document.frm.limit1.value = count1-len;
	}

    var count_text1 = "90";
    var count_text1_full = "180";
    function limiter_text1(){
        var tex = document.frm.ad_text_en.value;
        var len = tex.length;
        if($('#ad_size').val()=='full') {
            var textCount = count_text1_full;
        } else {
            var textCount = count_text1;
        }
        
        if(len > textCount){
            tex = tex.substring(0,textCount);
            document.frm.ad_text_en.value =tex;
            return false;
        }
        document.frm.limit_text1.value = textCount-len;
    }
    
             
    var count_call_to_action_es = "20";
    var count_call_to_action_full_es = "40";
    function limiter_call_to_action_es(){
        var tex = document.frm.call_to_action_es.value;            
        var len = tex.length;
        if($('#ad_size').val()=='full') {
            var textCount = count_call_to_action_full_es;
        } else {
            var textCount = count_call_to_action_es;
        }
        if(len > textCount){
            tex = tex.substring(0,textCount);
            document.frm.call_to_action_es.value =tex;
            return false;
        }
        document.frm.limit_action.value = textCount-len;
    }     
        
        
    var count_call_to_action_en = "20";
    var count_call_to_action_full_en = "40";
    function limiter_call_to_action_en(){
        var tex = document.frm.call_to_action_en.value;            
        var len = tex.length;
        if($('#ad_size').val()=='full') {
            var textCount = count_call_to_action_full_en;
        } else {
            var textCount = count_call_to_action_en;
        }
        if(len > textCount){
            tex = tex.substring(0,textCount);
            document.frm.call_to_action_en.value =tex;
            return false;
        }
        document.frm.limit_action1.value = textCount-len;
    }     

      function ad_same_image_for_en()
        {
            
            if($("#chek_same_image").is(':checked'))
            {
                
               var same_image =  $("#ad_photo_es").val();
               
                $("#ad_photo_en").val(same_image);
                
                $('#imgshow1').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/'+same_image+'"  width="150" height="72" alt="" />');
                
                $("#upload_file_hide_en").hide();
                $("#me2").hide();
                
                
                
                
                
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
           <div class="blue_box10"><p>Ad Management</p></div>
           	<?php include("admin_menu/createad_menu.php");?>
           </div> 
         <div class="clear"></div>
        </div>	
      </div>
     </div>
    <!---------------------put your div--here-------------------------------------------------- --> 
        
    
    <div class="myevent_box">
	<!----------------------------------------->
        
         <div class="mediaimage">
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0" class="abck-form add-ads-table">
		<form name="frm" id="frm_ad" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
		<input type="hidden" name="media_id" value="<?php echo $objmedia_en->f('m_id')?>" id="media_id"/>
                <input type="hidden" name="language_id_es" value="<?php echo $objmedia_es->f('language_id')?>" id="language_id_es"/>
		<input type="hidden" name="language_id_en" value="<?php echo $objmedia_en->f('language_id')?>" id="language_id_en"/>
		<tr>
		<td><div id="url_image_show"></div></td>
                <td>&nbsp;</td>
		</tr>
                <tr><td><div align="center"><?php echo $updated_msg;?></div></td><td>&nbsp;</td></tr>
                
                
                 <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Client</td>
		<td width="87%">
			
                    <select  name="client_id" id="client_id">
         <option value="">--Please Select client--</option>
         
          <?php while($row = $obj_ads_client->next_record())
			     { ?>
         
            <option value="<?php echo  $obj_ads_client->f('client_id'); ?>" <?php if($obj_ads_client->f('client_id')==$obj_media_update_es->f('client_id')) echo 'selected=selected' ?>   ><?php echo  $obj_ads_client->f('business_name'); ?></option>
             
         
                     <?php } ?>
	       
		</select>
		
		</td>
                
                
                </tr>
                
                
                
 
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Size</td>
		<td width="87%">
			
		<select id="ad_size" name="ad_size">
         <option value="">--Please Select Size--</option>
	         <option value="bottom" <?php if($obj_media_update_es->f('ad_size')=="bottom") echo 'selected=selected' ?>  >bottom</option>
		 <option value="banner" <?php if($obj_media_update_es->f('ad_size')=="banner") echo 'selected=selected' ?> >banner</option>
		 <option value="full" <?php if($obj_media_update_es->f('ad_size')=="full") echo 'selected=selected' ?> >full</option>	
		</select>
		
		</td>
                
                
                </tr>
              
		
		<tr id="postion_id">
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Position</td>
		<td width="87%">
			
		<select id="ad_position" name="ad_position">
        
       
		  
		 <?php for($i=1;$i<11;$i++) {	?>
			
	         <option value="<?php echo $i ?>" <?php if($i==$obj_media_update_es->f('position_id')) echo 'selected=selected' ?> ><?php echo $i ?></option>
		 
		 <?php  }?>
		 	
		</select>
		
		</td>
		</tr>
		
		
		<tr>
		<td width="18%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">From Date</td>
		<td width="82%">
                    
                    <?php 
                          $strto_time_from_edit= strtotime($obj_media_update_es->f('From_date'));
			 $strto_time_from_date_edit = date('m/d/Y',  $strto_time_from_edit);
                         
                         ?>
		    <input type="text" name="from_date" id="event_date_st" value="<?php echo  $strto_time_from_date_edit; ?>" size="52"/>
		
		</td>
		</tr>
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Duration::</td>
		
		
		<td width="87%">
			
			<select name="duration_date" id="duration_date">
			
			<option value="7"  <?php if($total_dduration_date==7) echo 'selected=selected' ?>>1 week
			</option>
			
			<option value="14"  <?php if($total_dduration_date==14) echo 'selected=selected' ?>>2 weeks
			</option>
			<option value="30"  <?php if($total_dduration_date==30) echo 'selected=selected' ?>>1 month
			</option>
			<option value="180"  <?php if($total_dduration_date==180) echo 'selected=selected' ?>>6 months
			</option>		   
		        <option value="365"  <?php if($total_dduration_date==365) echo 'selected=selected' ?>>1 year
			</option>
		   </select>
		   
		   
		
		</td>
		
		</tr>
		
		<br />
                
              
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language :: </td>
                <td><strong>Espanol</strong></td>
		</tr>
                
             
              <tr>
                  <td colspan="2">
                
                <div class="event_ticket">
		<!--<h1>Set gallery image <img src="<?php //echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>-->
		<p>Upload Files</p>
		<ul style="margin-left: 10px;">
		<li><a href="#" class="here"> 
			    
		<?php if(!$_POST['ad_photo_es']){ ?>
		
		<div id="me1" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Select file from your computer For Espanol</span></span></div><span id="mestatus1"></span>
		<?php } else { ?>
		<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['ad_photo_es']; ?>" alt="" />
		<?php }  ?>
		<div class="clear"></div>
                <span id="imgshow"><img src="<?php echo $obj_base_path->base_path()."/files/event/advertisement/thumb/".$obj_media_update_es->f('ad_image_name') ?>"  width="150" height="72" alt="" /></span>
                </td>
</span>
<input type="hidden" name="ad_photo_es" id="ad_photo_es" value="<?php if($_POST['ad_photo_es']){ 
    echo $_POST['ad_photo_es'];
    }else{
      echo $obj_media_update_es->f('ad_image_name');   
    }?>" /></a></li>
		
		</ul>
		</div>   
                
                </td>
       
		</tr>   
                
                <tr id="same_image_tr" style="display: none">
                    <td >Same Image For en</td>
                    <td ><input type="checkbox" name="chek_same_image" id="chek_same_image"  onclick="ad_same_image_for_en()"</td>                   
                </tr>
                
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Title ::</td>
		<td width="87%">
                    <input type="text" name="ad_title_es" id="ad_title_es"  value="<?php echo $obj_media_update_es->f('ad_title') ?>"  size="52" onkeyup="limiter()"/>
                    
                    
                    
                     <?php
            $call_to_action_es_title = strlen($obj_media_update_es->f('ad_title'));
            $call_to_action_remaining_action_title_es= 25-$call_to_action_es_title ;
        ?>
                    
                    <span>     
                    <script type="text/javascript">
			  <?php if($call_to_action_es_title>0) { ?>
				document.write("<input type=text name=limit class=small-text readonly value=<?php echo $call_to_action_remaining_action_title_es;?>>");
			  <?php } else { ?>
				document.write("<input type=text name=limit class=small-text readonly value="+count+">");
			  <?php } ?>
		</script>
                    
                  </span>  
                    
                    
                    
		</td>
		</tr>
		
		
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;" ">Ad Text ::</td>
		<td width="87%">
		<textarea name="ad_text_es" id="ad_text_es" rows="4" cols="50" onkeyup="limiter_text();"><?php echo $obj_media_update_es->f('ad_text')?></textarea>

        <span>   
            <script type="text/javascript">			
                document.write("<input type=text name=limit_text class=small-text readonly value="+count_text+">");			 
            </script>
        </span> 
                
                
                
		</td>
		</tr>
		
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Alternate Text::</td>
		<td width="87%">
		
		
		<textarea name="ad_contain_es" id="ad_contain_es" rows="4" cols="50"><?php echo $obj_media_update_es->f('ad_alternate_text')?></textarea>
		
		</td>
		</tr> 
                
                
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Url ::</td>
		<td width="87%">
		<input type="text" name="ad_url_es" id="ad_url_es"  value="<?php echo $obj_media_update_es->f('link_url')?>"  size="52"/>
		</td>
		</tr>
                
                
                
                 <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Call To Action</td>
		<td width="87%">			
                    <input type="text" name="call_to_action_es" id="call_to_action_es" value="<?php echo $obj_media_update_es->f('call_to_action')?>" size="52" onkeyup="limiter_call_to_action_es()"/>    
                    <span>     
                        <script type="text/javascript">
                            document.write("<input type=text name=limit_action class=small-text readonly value="+count_call_to_action_es+">");
                        </script>                    
                    </span> 
		</td>
		</tr>
                
		
		<br/>
    <!-------------------For English  Language----------------------------->
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language :: </td>
                <td><strong>English</strong></td>
		</tr>
 <!-------------------For English  image upload----------------------------->
 
<!--   <tr>
                    <td>&nbsp;</td>
                    <td><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/"<?php echo $obj_media_update_es->f('ad_image_name')?>  width="150" height="72" alt="" /></td>

                </tr>
 -->
 
		
		<tr>
                    <td colspan="2">                   
                <div class="event_ticket"">
		<!--<h1>Set gallery image <img src="<?php //echo $obj_base_path->base_path(); ?>/images/question_mark.gif" alt="" width="31" height="28" border="0"/></h1>-->
		<p>Upload Files</p>
		<ul style="margin-left: 10px;">
		<li><a href="#" class="here"> 
			    
		<?php if(!$_POST['ad_photo_en']){ ?>
		
		<div id="me2" class="styleall" style=" cursor:pointer; "><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Select file from your computer For English</span></span></div><span id="mestatus2"></span>
		<?php } else { ?>
		<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['ad_photo_en']; ?>" alt="" />
		<?php }  ?>
		<div class="clear"></div>
		<span id="imgshow1"><img src="<?php echo $obj_base_path->base_path()."/files/event/advertisement/thumb/".$obj_media_update_en->f('ad_image_name') ?>"  width="150" height="72" alt="" /></span>
               </span>
      
<input type="hidden" name="ad_photo_en" id="ad_photo_en" value="<?php if($_POST['ad_photo_en']){ 
    echo $_POST['ad_photo_en'];
    }else{
      echo $obj_media_update_en->f('ad_image_name');   
    }?>" /></a></li>
              
    
                    
                    <!--<li>|</li>
		<li><a href="#">Media Library</a></li>-->
		</ul>
		</div>   
                    </td>
		</tr>
		
		
		
		
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Title ::</td>
		<td width="87%">
                    <input type="text" name="ad_title_en" id="ad_title_en"  value="<?php echo $obj_media_update_en->f('ad_title')?>"  size="52" onkeyup="limiter1()"/>
                    
                    
               <?php
	       
                 $call_to_action_length_title = strlen($obj_media_update_en->f('ad_title'));
		  
		$call_to_action_remaining_title= 25-$call_to_action_length_title;
          ?>
                    
                    <span>     
                    <script type="text/javascript">
			  <?php if($call_to_action_length_title>0) { ?>
				document.write("<input type=text name=limit1 class=small-text readonly value=<?php echo $call_to_action_remaining_title;?>>");
			  <?php } else { ?>
				document.write("<input type=text name=limit1 class=small-text readonly value="+count1+">");
			  <?php } ?>
		</script>
                    
                  </span>        
                    
                    
                    
                    
                    
		</td>
		</tr>
		
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Text ::</td>
		<td width="87%">
		<textarea name="ad_text_en" id="ad_text_en" rows="4" cols="50" onkeyup="limiter_text1();"><?php echo $obj_media_update_en->f('ad_text')?></textarea>
        <span>
            <script type="text/javascript">			
				document.write("<input type=text name=limit_text1 class=small-text readonly value="+count_text1+">");			 
            </script>
        </span>   
                
                
                
		</td>
		</tr>
 
 
 
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Alternate Text::</td>
		<td width="87%">
		
		
		<textarea name="ad_contain_en" id="ad_contain_en" rows="4" cols="50"><?php echo $obj_media_update_en->f('ad_alternate_text')?></textarea>
		
                 
                
                
		</td>
		</tr>
 
 
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Url ::</td>
		<td width="87%">
		<input type="text" name="ad_url_en" id="ad_url_en"  value="<?php echo $obj_media_update_en->f('link_url')?>"  size="52"/>
		</td>
		</tr>
 
 
  <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Call To Action</td>
		<td width="87%">			
		    <input type="text" name="call_to_action_en" id="call_to_action_en" value="<?php echo $obj_media_update_en->f('call_to_action')?>" size="52"  onkeyup="limiter_call_to_action_en()"/>    
                    <span>     
                        <script type="text/javascript">
                            document.write("<input type=text name=limit_action1 class=small-text readonly value="+count_call_to_action_en+">");
                        </script>                    
                    </span> 
		</td>
		</tr>
 
 
 
 <input type="hidden" name="ad_edit_id" value="<?php echo $edit_ad_id?>"/>
		
                <tr>
                    <td>&nbsp;</td>
<!--                 <td><a href="<?php echo $obj_base_path->base_path()."/admin/gallery-list/add_ad" ?>"><input type="button" name="" value="Cancel" class="createbtn" ></a></td>				-->
                 <td><input type="button" name="submit_add" value="Save & exit" class="createbtn" id="submit_add" /> </td>
		</tr>
		</form>
		</table>
	       </div>
	<!----------------------------------------->
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
