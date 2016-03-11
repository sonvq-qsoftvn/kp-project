<script language="javascript" type="text/javascript">
$(function(){
		var btnUpload=$('#me');
		var mestatus=$('#mestatus');
		var files=$('#files');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $obj_base_path->base_path(); ?>/admin/upload_ticket.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					mestatus.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				mestatus.html('<img src="ajax-loader.gif" height="16" width="16">');
			},
			onComplete: function(file, response){
				//On completion clear the status
				mestatus.text('Photo Uploaded Sucessfully!');
				$('#photoname').val(response);
				$('#imgid').html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/ticket/thumb/'+response+'" />')
				$('#me').html('');
				
				//On completion clear the status
			}
		});
		
	});

function closePopUp()
{
	var checkValue = save_new_popup();
	if(checkValue)
	setTimeout("$('#fancybox-close').trigger('click')",3000);
}

function save_new_popup()
{
	if(!checkticketReg())
	{
		return 0;
	}
	else
	{
	  var ticketVal = $("#ticket_form").serialize();
	  //alert(ticketVal);
	  $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_add_event_tickets_final.php",
	  // async: false,
	   cache: false,
	   type: "POST",
	   data: ticketVal,   
	   success: function(data){ 
	     $(".ticket_common_class").val('');
		 $('#edit_ticket').val(0);
	     $("#save_create_ticket_display").html(data);
		$('html, body').animate({scrollTop: $("#show_popup").offset().top}, 2000);
	   }
	 });
	return 1;
	}
}



function editFinalTicket(ticket_id)
{
	 data = "ticket_id="+ticket_id;
	 $.ajax({ 
	   url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_edit_ticket_final.php",
	   async: false,
	   cache: false,
	   type: "POST",
	   dataType: 'json',
	   data: data,   
	   success: function(data){ 
	  
		// Fill the Text field
	  // alert(data['ticket_name_en']);
	   $('#ticket_name_en').val(data['ticket_name_en']);
	   $('#ticket_name_sp').val(data['ticket_name_sp']);
	   $('#description_en').val(data['description_en']);
	   $('#description_sp').val(data['description_sp']);
	   $('#price_mx').val(data['price_mx']);
	   $('#price_us').val(data['price_us']);
	   $('#ticket_num').val(data['ticket_num']);
	   $('#from_ticket').val(data['from_ticket']);
	   $('#to_ticket').val(data['to_ticket']);
	   $('#eairly_dis_percen').val(data['eairly_dis_percen']);
	   $('#eairly_days').val(data['eairly_days']);
	   $('#group_dis_per').val(data['group_dis_per']);
	   $('#group_dis_days').val(data['group_dis_days']);
	   
	   if(data['members_only']=="Y")
		  document.getElementById("members_only1").checked = true ;
	   else
			document.getElementById("members_only2").checked = true ;
	   
	   $('#edit_ticket').val(1);
	   $('#exit_ticket_id').val(ticket_id);
	   //End Fill the Text field
	   
	   //save_new_popup();
	   }
	 });
}
</script>



<div class="event_popup1" id="show_popup"  style="width:650px;">	
    <div class="event_popup5"  style="width:650px;"><h1>Ticket management form</h1></div>
    <div id="save_create_ticket_display" style="padding-left:10px;">
    <div style=" max-height:95px; overflow:auto;">
    <?php	
     //Fetch records from final table
    $obj_final_tickets->allTicketListCount($obj->f('event_id'));
    if($obj_final_tickets->num_rows()){
        while($obj_final_tickets->next_record()){
    ?>
           <div style="margin:0 0 10px 0; border-bottom: 1px dotted #666;">
            <div>
                <span><?php echo $obj_final_tickets->f('ticket_name_en');?></span><span> USD <?php echo $obj_final_tickets->f('price_us');?></span> 
                <span style="margin-right:25px; float:right; cursor:pointer;" onClick="deleteFinal('<?php echo $obj_final_tickets->f('ticket_id') ?>_<?php echo $obj->f('event_id');?>')">
				<img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> 
				<span style="margin-right:10px; float:right;cursor:pointer;" onClick="editFinalTicket(<?php echo $obj_final_tickets->f('ticket_id') ?>)">
				<img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span>
            </div>
            <div>
                <span><?php echo $obj_final_tickets->f('ticket_name_sp');?></span> <span> MXP <?php echo $obj_final_tickets->f('price_mx');?></span> 
                <span style="margin-right:25px; float:right;cursor:pointer;" onClick="deleteFinal('<?php echo $obj_final_tickets->f('ticket_id') ?>_<?php echo $obj->f('event_id');?>')"><img src="<?php echo $obj_base_path->base_path(); ?>/images/cross.gif" alt="" width="20" height="16" /> &nbsp;&nbsp;Delete</span> <span style="margin-right:10px; float:right;cursor:pointer;" onClick="editFinalTicket(<?php echo $obj_final_tickets->f('ticket_id') ?>)"><img src="<?php echo $obj_base_path->base_path(); ?>/images/edit.gif" alt="" width="20" height="16" />&nbsp;&nbsp; Edit</span> 
            </div>
        </div>
    
     <?php
        }
    }
     ?>
     </div>
    </div>
    
    <div class="clear"></div>
    <form method="post" name="ticket_form" id="ticket_form" enctype="multipart/form-data" enctype="multipart/form-data" onsubmit="return checkticketReg()">
      <input type="hidden" name="photoname" id="photoname" value="" />
      <input type="hidden" name="edit_ticket" id="edit_ticket" value="0" />
      <input type="hidden" name="exit_ticket_id" id="exit_ticket_id" value="0" />
      <input type="hidden" name="exit_event_id" id="exit_event_id" value="<?php echo $_GET['id'];?>" />
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #bbb; margin: 15px auto 0 auto;">
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><input type="text" name="ticket_name_sp" id="ticket_name_sp" value="Nombre" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" class="inputbg ticket_common_class" />
         <div style="color:red; margin:0 4px;" id="sp_name_err"></div>
         </td>
       </tr>
       <tr>
         <td>
            <div style="width: 184px; float: left;"><span class="tit">EN</span></div><input type="text" name="ticket_name_en" id="ticket_name_en" value="Name" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue" style="width: 360px;" class="inputbg ticket_common_class" />
         <div style="color:red; margin:0 4px;" id="en_name_err"></div>
            </td>
       </tr>
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">SP</span></div><textarea name="description_sp" id="description_sp" class="textareabg ticket_common_class" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Descripción</textarea></td>
       </tr>
       <tr>
         <td><div style="width: 184px; float: left;"><span class="tit">EN</span></div><textarea name="description_en" id="description_en" class="textareabg ticket_common_class" onClick="if(this.defaultValue==this.value) this.value=''" onBlur="if (this.value=='') this.value=this.defaultValue">Description</textarea></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <th style=" width: 149px;">Price MX pesos</th>
             <td><input type="text" name="price_mx" id="price_mx" class="inputbg ticket_common_class" onBlur="checDecimal('price_mx','shw_price_mx')"  /><span style="color:red; margin:0 4px;" id="shw_price_mx">&nbsp;</span></td>
           </tr>
           <tr>
             <th>Price US dollars</th>
             <td><input type="text" name="price_us" id="price_us" class="inputbg ticket_common_class" onBlur="checDecimal('price_us','shw_price_us')" /><span style="color:red; margin:0 4px;" id="shw_price_us">&nbsp;</span></td>
           </tr>
           <tr>
             <th>Number of Available tickets </th>
             <td><input type="text" name="ticket_num" id="ticket_num" class="inputbg ticket_common_class" onBlur="checkInt('ticket_num','shw_num_avail')" /><span style="color:red; margin:0 4px;" id="shw_num_avail">&nbsp;</span></td>
           </tr>
           <tr>
             <th colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <th width="24%">From </th>
                 <td width="28%"><input type="text" name="from_ticket" id="from_ticket" class="inputbg1 ticket_common_class"  /><span style="color:red; margin:0 4px;" id="shw_frm_ticket">&nbsp;</span></td>
                 <th width="6%">To</th>
                 <td width="30%"><input type="text" name="to_ticket" id="to_ticket" class="inputbg1 ticket_common_class" value="<?php echo $obj->f('event_end_date_time')?>"  /><span style="color:red; margin:0 4px;" id="shw_to_ticket">&nbsp;</span></td>
               </tr>
             </table></th>
             </tr>
         </table></td>
       </tr>
       
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="25%"  style="text-align:right;padding: 5px 15px;"><strong>Early bird discount</strong></td>
             <td width="12%"><input type="text" name="eairly_dis_percen" id="eairly_dis_percen" class="inputbg2 ticket_common_class" /></td>
             <td width="10%"><strong>% up to</strong></td>
             <td width="12%"><input type="text" name="eairly_days" id="eairly_days" class="inputbg2 ticket_common_class" /></td>
             <td width="30%"><p><strong>Days before the event</strong></td>
           </tr>
           
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="25%"  style="text-align:right;padding: 5px 15px;"><strong>Group Discount</strong></td>
             <td width="12%"><input type="text" name="group_dis_per" id="group_dis_per" class="inputbg2 ticket_common_class" /></td>
             <td width="10%"><strong> % over</strong></td>
             <td width="12%"><input type="text" name="group_dis_days" id="group_dis_days" class="inputbg2 ticket_common_class" /></td>
             <td width="30%"><p><strong>Tickets</strong></p></td>
           </tr>
           <tr>
             <td colspan="5"><div style="float:left; margin:0 20px;width:135px;font-weight:bold; text-align:right;">Members only</div><input type="radio" name="members_only" id="members_only1" value="Y" /> Yes&nbsp;&nbsp;<input type="radio" name="members_only" id="members_only2" value="N" /> No</td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="27%" style="text-align:right;padding: 5px 15px;"><strong>Ticket Icon</strong></td>
             <td>
             	<div id="me" class="styleall" style=" cursor:pointer;"><span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;">Click Here To Upload Ticket Icon</span></span></div><span id="mestatus"></span><br /><span id="imgid"></span>
             </td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><input type="button" name="Submit2" value="Save & Create a new ticket" class="createbtn"  onclick="save_new_popup()"/></td>
             <td><input type="button" name="Submit2" value="Save & Exit" class="createbtn" onClick="closePopUp()"/></td>
           </tr>
         </table></td>
       </tr>       
     </table>
    </form>
    </div>