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
        
        
	
 
           
if(isset($_REQUEST['ad_position']))
	{
          

		
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
                             
                             $call_to_action_es  = "Clic por mas"; 
                             
                             
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
                            $ad_url_en  = addslashes($_POST['ad_url_es']);
                            //$call_to_action_en  = addslashes($_POST['call_to_action_en']);
                            $lenguage_id_en='en';
                            
                            if($_POST['call_to_action_en']=="")
                         {
                             
                             $call_to_action_en  = "Click for more"; 
                             
                             
                         }else{
                             
                             $call_to_action_en  = addslashes($_POST['call_to_action_en']); 
                             
                             
                         }
         
	     
                
            
		
              $result_last_ad_id= $obj_media_update_es->insert_ad($ad_size,$ad_position, $from_date,$duration,$ad_client_id);
	    
            /*update the English  description*/
	    
	     $obj_media_update_es->insert_ad_contain_es($result_last_ad_id, $ad_title_es,$ad_contain_es,$ad_text_es,$lenguage_id_es,$ad_url_es,$image_name_es,$call_to_action_es);
             
	     $obj_media_update_es->insert_ad_contain_en($result_last_ad_id, $ad_title_en,$ad_contain_en,$ad_text_en,$lenguage_id_en,$ad_url_en,$image_name_en,$call_to_action_en);
	    
             $obj_media_update_en->update_media_details($media_id,$language_id_en,$set_privacy,$media_name_en,$caption_en,$alternate_text_en,$description_en);
		$_SESSION['ad_advertisment']='Successfully Ad';
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
 
//On completion clear the status
mestatus.text('Photo Uploaded Sucessfully!');
$('#ad_photo_es').val(response);
$('#imgshow').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/'+response+'" alt="" width="150" height="72" />');
$('#me1').html('');
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

  
	$('#ad_size').change(function(){
								  
		if($('#ad_size').val()=='bottom')
		{
			
			$('#postion_id').hide()
			
			
			}else{
				
			$('#postion_id').show()	
				
				
	}
								  
						   
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
	   data:"ad_position="+add_position+"&ad_size="+ad_size+"&start_date="+$('#event_date_st').val()+"&end_date="+duration_date,
	   success: function(data){
               
              //alert(data);
		
	 if(data==1)
         {
             
             alert('Date Is Already  Booked');
             
             return false;
             
         }else{
             
             
            $('#frm_ad').submit();
            
             
             
             
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
        
        
//   $('#ad_title_es').blur(function(){
//   
//   
//   var check_char = $('#ad_title_es').val().length;
//   
//   if(check_char>=25)
//   {
//       
//      $('#ad_title_es').focus();  
//     alert('Maximum characters: 25');  
//     
//      
//       
//       return false;
//       
//   }
//   
//   
//   
//   
//   
//   })     
//        
//  
//  
//   $('#ad_title_en').blur(function(){
//   
//   
//   var check_char = $('#ad_title_en').val().length;
//   
//   if(check_char>=25)
//   {
//       
//       $('#ad_title_en').focus(); 
//     alert('Maximum characters: 25');
//     
//    
//     return false;
//       
//   }
//   
//   
//   
//   
//   
//   })
//        
//    
//     $('#ad_text_en').blur(function(){
//   
//   
//   var check_char = $('#ad_text_en').val().length;
//   
//   if(check_char>=90)
//   {
//       
//       $('#ad_text_en').focus(); 
//     alert('Maximum characters: 90');
//     
//    
//     return false;
//       
//   }
//   
//   
//   
//   
//   
//   })
//    
//    
//    
//  $('#ad_text_es').blur(function(){
//   
//   
//   var check_char = $('#ad_text_es').val().length;
//   
//   if(check_char>=90)
//   {
//       
//       $('#ad_text_es').focus(); 
//     alert('Maximum characters: 90');
//     
//    
//     return false;
//       
//   }
//   
//   
//   
//   
//   
//   })   
    
    
    


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
		//document.frm.limit.value = count-len;
	}

var count_text = "90";
function limiter_text(){
	
		var tex = document.frm.ad_text_es.value;
		var len = tex.length;
		if(len > count_text){
				tex = tex.substring(0,count_text);
				document.frm.ad_text_es.value =tex;
				return false;
		}
		//document.frm.limit.value = count_text-len;
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
		//document.frm.limit.value = count1-len;
	}

var count_text1 = "90";
function limiter_text1(){
	
		var tex = document.frm.ad_text_en.value;
		var len = tex.length;
		if(len > count_text1){
				tex = tex.substring(0,count_text1);
				document.frm.ad_text_en.value =tex;
				return false;
		}
		//document.frm.limit.value = count_text1-len;
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
		<table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
		<form name="frm" id="frm_ad" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
		<input type="hidden" name="media_id" value="<?php echo $objmedia_en->f('m_id')?>" id="media_id"/>
                <input type="hidden" name="language_id_es" value="<?php echo $objmedia_es->f('language_id')?>" id="language_id_es"/>
		<input type="hidden" name="language_id_en" value="<?php echo $objmedia_en->f('language_id')?>" id="language_id_en"/>
<!--		<tr>
		<td><div id="url_image_show"></div></td>
                <td>&nbsp;</td>
		</tr>-->
                
                
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Client</td>
		<td width="87%">
			
                    <select  name="client_id" id="client_id">
         <option value="">--Please Select client--</option>
         
          <?php while($row = $obj_ads_client->next_record())
			     { ?>
         
            <option value="<?php echo  $obj_ads_client->f('client_id'); ?>"><?php echo  $obj_ads_client->f('Contact_first_name'); ?> <?php echo  $obj_ads_client->f('Contact_last_name'); ?></option>
             
         
                     <?php } ?>
	       
		</select>
		
		</td>
                
                
                </tr>
                
                
                
               
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Size</td>
		<td width="87%">
			
		<select id="ad_size" name="ad_size">
         <option value="">--Please Select Size--</option>
	         <option value="bottom">bottom</option>
		 <option value="banner">banner</option>
		 <option value="full">full</option>	
		</select>
		
		</td>
                
                
                </tr>
              
		
		<tr id="postion_id">
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Position</td>
		<td width="87%">
			
		<select id="ad_position" name="ad_position">
        
       
		  
		 <?php for($i=1;$i<11;$i++) {	?>
			
	         <option value="<?php echo $i ?>"><?php echo $i ?></option>
		 
		 <?php  }?>
		 	
		</select>
		
		</td>
		</tr>
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">From Date</td>
		<td width="87%">
			
		    <input type="text" name="from_date" id="event_date_st" value="" size="52"/>
		
		</td>
		</tr>
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Duration::</td>
		
		
		<td width="87%">
			
			<select name="duration_date" id="duration_date">
			
			<option value="7">1 week
			</option>
			
			<option value="14">	2 weeks
			</option>
			<option value="30">1 month
			</option>
			<option value="180">6 months
			</option>		   
		        <option value="365">1 year
			</option>
		   </select>
		   
		   
		
		</td>
		
		</tr>
                
              
                
                
		
		<br />
                
        
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 3;">Language ::</td>
                <td><strong>Espanol </strong></td>
		</tr>
                
                <br />
                
                
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
		<span id="imgshow"></span>
		<input type="hidden" name="ad_photo_es" id="ad_photo_es" value="<?php if($_POST['ad_photo_es']){ echo $_POST['ad_photo_es']; }?>" /></a></li>
		<!--<li>|</li>
		<li><a href="#">Media Library</a></li>-->
		</ul>
		</div>   
                
                </td>
                
                
		</tr>   
                
                
                
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Title ::</td>
		<td width="87%">
                    <input type="text" name="ad_title_es" id="ad_title_es"  value="" onkeyup="limiter()"  size="52"/>
		</td>
		</tr>
		
		
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Text ::</td>
		<td width="87%">
		<textarea name="ad_text_es" id="ad_text_es" rows="2" cols="50" onkeyup="limiter_text()"><?php echo $objmedia_es->f('alternative_text')?></textarea>
		</td>
		</tr>
		
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Alternate Text::</td>
		<td width="87%">
		
		
		<textarea name="ad_contain_es" id="ad_contain_es" rows="2" cols="50"></textarea>
		
		</td>
		</tr> 
                
                
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Url ::</td>
		<td width="87%">
		<input type="text" name="ad_url_es" id="ad_url_es"  value=""  size="52"/>
		</td>
		</tr>
                
                
                  <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Call To Action</td>
		<td width="87%">
			
		    <input type="text" name="call_to_action_es" id="call_to_action_es" value="" size="52"/>
		
		</td>
		</tr>
                
		
		<br/>
    <!-------------------For English  Language----------------------------->
                <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Language ::</td>
                <td><strong>English</strong></td>
		</tr>
 <!-------------------For English  image upload----------------------------->
		
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
		<span id="imgshow1"></span>
		<input type="hidden" name="ad_photo_en" id="ad_photo_en" value="<?php if($_POST['ad_photo_en']){ echo $_POST['ad_photo_en']; }?>" /></a></li>
		<!--<li>|</li>
		<li><a href="#">Media Library</a></li>-->
		</ul>
		</div>   
                    </td>
		</tr>
		
		
		
		
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Title ::</td>
		<td width="87%">
                    <input type="text" name="ad_title_en" id="ad_title_en"  value=""  size="52" onkeyup="limiter1()" />
		</td>
		</tr>
		
		
		
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Text ::</td>
		<td width="87%">
		<textarea name="ad_text_en" id="ad_text_en" rows="2" cols="50" onkeyup="limiter_text1()"><?php echo $objmedia_es->f('alternative_text')?></textarea>
		</td>
		</tr>
 
 
 
		<tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Alternate Text::</td>
		<td width="87%">
		
		
		<textarea name="ad_contain_en" id="ad_contain_en" rows="2" cols="50"></textarea>
		
		</td>
		</tr>
 
 
               <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Ad Url ::</td>
		<td width="87%">
		<input type="text" name="ad_url_en" id="ad_url_en"  value=""  size="52"/>
		</td>
		</tr>
 
 
   <tr>
		<td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;">Call To Action</td>
		<td width="87%">
			
		    <input type="text" name="call_to_action_en" id="call_to_action_es" value="" size="52"/>
		
		</td>
		</tr>
 
		
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

<script type="text/javascript">
<!--
//var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1" , {defaultTab:0});
var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
//-->
</script>
</body>
</html>
