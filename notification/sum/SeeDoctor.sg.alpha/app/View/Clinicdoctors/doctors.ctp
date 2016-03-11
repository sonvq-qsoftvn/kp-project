<!--<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>clinicmanager/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>clinicmanager/clinics">Clinics</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Doctors</a> 
                    </li>
                </ul>
            </div>
        </div>-->
<?php
if($msg!=array())
{
?>
<div class="alert alert-error">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">Failure!</h4>
                        <ul>
                                    
                        <?php
                        foreach($msg as $k=>$v)
                        {
                        ?>
    <li><?php echo $v;?></li>
                                    
                        <?php
                                    
                        }
                        ?>
                        </ul>
            </div>
<?php
}
?>


<section id="utopia-wizard-form" class="utopia-widget utopia-form-box">
<!--    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>Set Doctors Form</span>
    </div>-->

    <div class="rgeistration-wrapp">
        <div class="user-head">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Doctor',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
                    
                        <fieldset>
                            
                                <div class="control-group">
                                    <label class="control-label" for="name">DOCTORS:</label>
    
                                    <div class="controls">
                                        <div class="control-group">
                                            
    
                                            
                                            <div class="controls">
                                                
                                               <table border=0 cellspacing='5' cellpadding=12 id='doc_script_<?php if(empty($slots_arr)){echo '0'; }else{echo count($slots_arr);}?>'>   
                                                <?php
                                                if(!empty($slots_arr))
                                                    {
                                                
                                                  foreach($slots_arr as $key=>$each_slot)
                                                  { 
                                                  $my_count=$key+1;
                                                ?>
                                                      
                                                <tr class='myclass_<?php echo $my_count;?>'>
                                                             
                                                           <th style='text-align: left; font-size: large;'>
                                                               
                                                       
                                                           
                                                           <input type='hidden' value='1' name='status[]' id='mystatus_<?php echo $my_count;?>'/>
                                                           
                                                          </th> <th style='text-align:right;'> <a href='javascript:deletedoctor("<?php echo $my_count;?>")'><?php echo $this->Html->image('../admin/img/icons2/close.png',array('class'=>'utopia-icons1-small-img','title'=>'delete'));?></a></th>
                                                </tr>
                                                            
                                                            
                                                       <tr class='myclass_<?php echo $my_count;?>'>
                                                          <td>Doctor First Name:</td>
                                                           <td>
                                                              <input type="text" name='doc_f_name[]' value="<?php echo $each_slot['Doctor']['f_name'];?>">
                                                           </td>
                                                       </tr>
                                                       
                                                       
                                                       <tr class='myclass_<?php echo $my_count;?>'>
                                                          <td>Doctor Last Name:</td>
                                                           <td>
                                                              <input type="text" name='doc_l_name[]' value="<?php echo $each_slot['Doctor']['l_name'];?>">
                                                           </td>
                                                       </tr>
                                                       
                                                       
                                                      <tr class='myclass_<?php echo $my_count;?>'>
                                                            <td>Doctor Title :</td>
                                                            <td> 
                                                                <select name='doc_title[]' >
                                                                    <option <?php if($each_slot['Doctor']['title']=='Consultant'){?>selected='selected'<?php }else{ ?> value='Consultant' <?php } ?> > Consultant </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='Dentist'){?>selected='selected'<?php }else{ ?> value='Dentist' <?php } ?>>  Dentist </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='Doctor'){?>selected='selected'<?php }else{ ?> value='Doctor' <?php } ?>>  Doctor </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='General Practitioner'){?>selected='selected'<?php }else{ ?> value='General Practitioner' <?php } ?>>  General Practitioner </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='Family Physician'){?>selected='selected'<?php }else{ ?> value='Family Physician' <?php } ?>>  Family Physician </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='Surgeon'){?>selected='selected'<?php }else{ ?> value='Surgeon' <?php } ?> > Surgeon </option>
                                                                    <option <?php if($each_slot['Doctor']['title']=='Practitioner'){?>selected='selected'<?php }else{ ?> value='Practitioner' <?php } ?> > Practitioner </option>
                                                                 </select>
                                                             </td>
                                                     </tr>
                                                     
                                                     
                                                     <tr class='myclass_<?php echo $my_count;?>'>
                                                            <td>Doctor Qualification :</td>
                                                            <td> 
                                                                 <input type="text" name='doc_qualification[]' value="<?php echo $each_slot['Doctor']['qualification'];?>">        
                                                            </td>
                                                     </tr>
                                                            <tr class='myclass_<?php echo $my_count;?>'>
                                                            <td colspan=2><hr/></td></tr>
                                                            
                                                            
                                     <tr class='myclass_<?php echo $my_count;?>'>
                                                            <td>Doctor image :</td>
                                                            <td> 
                                                                 <input type="file" name='doc_image[]'>        
                                                            </td>
                                                            
                                                            <?php echo $this->Html->image('../admin/uploads/'.$doctors['Doctor']['img'],array('width'=>'233px','height'=>'199px','alt'=>'')); ?>
                                                     </tr>
                                                            <tr class='myclass_<?php echo $my_count;?>'>
                                                            <td colspan=2><hr/></td></tr>                       
                                                            
                                                            
                                                                
                                                    <?php }} ?>
                                                 
                                               </table>
                                              
                                                
                                            </div>
                                            
                                           
                                            
                                              <div class="controls">
                                                 <input type='hidden' name='addslot_of_<?php if(empty($slots_arr)){echo '0'; }else{echo $my_count;}?>_slots' id='hdn_<?php if(empty($slots_arr)){echo '0'; }else{ echo count($slots_arr);}?>' value='<?php if(empty($slots_arr)){echo '0'; }else{echo count($slots_arr);}?>'/>
                                               <input value='Add Doctor' class='btn btn-success span2' type='button' onclick="addslot('<?php if(empty($slots_arr)){echo '0'; }else{echo count($slots_arr);}?>');" />
                                               </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            
                            
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate()' >Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>clinicmanager/clinics'">Cancel</button>
                               
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script type='text/javascript'>

//javascript validations
function do_validate()
{
	error_status=0;
	status_arr=document.getElementsByName('status[]');
	f_name_arr=document.getElementsByName('doc_f_name[]');
	l_name_arr=document.getElementsByName('doc_l_name[]');
	title_arr=document.getElementsByName('doc_title[]');
	qual_arr=document.getElementsByName('doc_qualification[]');
	for(i=0;i<status_arr.length;i++)
	{
		if(status_arr[i].value==0)
		{
			continue;
		}
		else
		{
			if(f_name_arr[i].value=='')
			{
				alert('Please input first name of all the doctor\'s');
				error_status=1;
				break;
			}
			else if(l_name_arr[i].value=='')
			{
				alert('Please input last name of all the doctor\'s');
				error_status=1;
				break;
			}
			else if(qual_arr[i].value=='')
			{
				alert('Please input qualification of all the doctor\'s');
				error_status=1;
				break;
			}
			
			
		}
	}
	
	if(error_status==0)
	{
		document.validation.submit();
	}
}




//functions for operations like delete and add
            function deletedoctor(k)
            {
                        //mc=slot number
                        //k= day

                       $('#mystatus_'+k).val('0');
                        $('.myclass_'+k).fadeOut(2000);
            }
            function addslot(k)
            {         
               
             
            c=parseInt($('#hdn_'+k).val())+1;  
            
            
            text="<tr class='myclass_"+c+"'>";
            text+="<th style='text-align: left; font-size: large;'>Doctor &nbsp;"+c+"</th>";
            text+="<th style='text-align:right;'>";
            text+="<input type='hidden' value='1' name='status[]' id='mystatus_"+c+"'/>";
            text+="<a href='javascript:deletedoctor("+c+")'>";
            text+='<?php echo $this->Html->image('../admin/img/icons2/close.png',array('class'=>'utopia-icons2-small-img','title'=>'delete'));?>';
            text+="</a>";
            text+="</th>";
            text+="</tr>";
            
            text+="<tr class='myclass_"+c+"'>";
            text+= "<td>Doctor First Name:</td>";
            text+="<td>";
            text+="<input type='text' name='doc_f_name[]'>";
            text+="</td>";
            text+="</tr>";
            
            text+="<tr class='myclass_"+c+"' >";
            text+= "<td>Doctor Lirst Name:</td>";
            text+="<td>";
            text+="<input type='text' name='doc_l_name[]'>";
            text+="</td>";
            text+="</tr>";
            
            text+="<tr class='myclass_"+c+"' >";
            text+= "<td>Doctor Title:</td>";
            text+="<td>";
            text+="<select name='doc_title[]'>";
            text+="<option value='Consultant'>Consultant</option>";
            text+="<option value='Dentist'>Dentist</option>";
            text+="<option value='Doctor'>Doctor</option>";
            text+="<option value='General Practitioner'>General Practitioner</option>";
            text+="<option value='Family Physician'>Family Physician</option>";
            text+="<option value='Surgeon'>Surgeon</option>";
            text+="<option value='Practitioner'>Practitioner</option>";
            text+="</select>";
            text+="</td>";
            text+="</tr>";
            
            text+="<tr class='myclass_"+c+"' >";
            text+= "<td>Doctor Qualification:</td>";
            text+="<td>";
            text+="<input type='text' name='doc_qualification[]'>";
            text+="</td>";
            text+="</tr>";
            
            text+="<tr class='myclass_"+c+"' >";
            text+= "<td>Doctor image:</td>";
            text+="<td>";
            text+="<input type='file' name='doc_image[]'>";
            text+="</td>";
            text+="</tr>";
            
            text+="<input type='hidden' value='' name='id[]'>";
            text+="<tr class='myclass_"+c+"'><td colspan=2><hr/></td></tr>";
        
         $('#hdn_'+k).val(c);
        $('#doc_script_'+k).append(text);
        
       
            }
    
</script>

