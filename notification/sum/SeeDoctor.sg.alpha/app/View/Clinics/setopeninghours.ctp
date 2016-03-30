<?php
	//showing serverside validation errors

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
	<section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Set Opening Hours</h2></div></div> 
	
		<div class="ourdoctors">
			<div class="container">
				<div class="set_openingbasebox">
					<!--<div class="sample-form">-->
					<?php echo $this->Form->create('Clinic',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
						<fieldset>
							<input type='hidden' id='max_id' value='<?php echo $maxid;?>'>
							<?php
								
								$days_arr[1]='Monday';
								$days_arr[2]='Tuesday';
								$days_arr[3]='Wednesday';
								$days_arr[4]='Thrusday';
								$days_arr[5]='Friday';
								$days_arr[6]='Saturday';
								$days_arr[7]='Sunday';
								
								foreach($days_arr as $k=>$v)
								{
							?>
									<!--<div class="control-group">
									<label class="control-label" for="name"><?php echo $v;?>:</label>-->
									<div class="dayblock">
										<div class="dayleft"><div class="dayname"><?php echo $v;?>:</div></div>
										<div class="controls dayright">
											<div class="control-group">
												<div class="controls">
													<table border=0 class="dayright_tab" id='slot_table_<?php echo $k;?>'>
														<?php
															if(count($slots_arr[$k]))
															{
																foreach($slots_arr[$k] as $key=>$each_slot)
																{
																	$my_count=$key+1;
														?>
																	<tr class='myclass_<?php echo $k;?>_<?php echo $my_count;?> tr_top'>
																		<th>
																			<input type='hidden' value='1' name='status_<?php echo $k.'_'.$my_count;?>' id='mystatus_<?php echo $k.'_'.$my_count;?>'/>
																			<input type='hidden' value='<?php echo $each_slot['Openinghour']['id'];?>' name='id_<?php echo $k.'_'.$my_count;?>' id='id_<?php echo $k.'_'.$my_count;?>' />
																			<div class="lefttitletxt"><i class="sloticon"></i>Slot <?php echo $my_count;?></div>
																		</th>
																		<th style="text-align: right;">
																			<a href='javascript:deleteopeninghour("<?php echo $k;?>","<?php echo $my_count;?>")'>
																					  <?php echo $this->Html->image('../admin/img/icons2/slot_closeicon.png',array('class'=>'utopia-icons2-small-img','title'=>'delete'));?>
																			</a>
																		</th>
																	</tr>
															  
																	<tr class='myclass_<?php echo $k;?>_<?php echo $my_count;?> fromtr'>
																		<td class="full_w">From : </td>
																		<td class="ful_td">
																			<div class="fieldblockbox">
																				<div class="left_fieldblock">
																					<label>Hours</label>
																					<div class="select_dropdownbox">
																						<select id='from_hours_<?php echo $k.'_'.$my_count;?>' name='from_hours_<?php echo $k.'_'.$my_count;?>'>
																							<?php
																								for($i=0;$i<=23;$i++)
																								{
																							?>
																									<option <?php if($i==$each_slot['Openinghour']['fromhour']){?>selected='selected'<?php }?>><?php echo sprintf('%02d',$i);?></option>
																							<?php
																								}
																							?>
																						</select>
																					</div>
																				</div>
																				<div class="right_fieldblock">
																					<label>Minutes</label>
																					<div class="select_dropdownbox">
																						<select id=from_minutes_<?php echo $k.'_'.$my_count; ?> name='from_minutes_<?php echo $k.'_'.$my_count;?>' >
																							<?php
																								for($i=0;$i<=59;$i++)
																								{
																							?>
																								    <option <?php if($i==$each_slot['Openinghour']['fromminutes']){?>selected='selected'<?php }?>><?php echo sprintf('%02d',$i);?></option>
																							<?php
																								}
																							?>
																						</select>
																					</div>
																				</div>
																			</div>
																		</td>
																	</tr>
																	<tr class='myclass_<?php echo $k;?>_<?php echo $my_count;?> fromtr'>
																		<td class="full_w">To :</td>
																		<td class="ful_td">
																			<div class="fieldblockbox">
																				<div class="left_fieldblock">
																					<label>Hours</label>
																					<div class="select_dropdownbox">
																						<select id='to_hours_<?php echo $k.'_'.$my_count;?>' name='to_hours_<?php echo $k.'_'.$my_count;?>'>
																							<?php
																								for($i=0;$i<=23;$i++)
																								{
																							?>
																								<option <?php if($i==$each_slot['Openinghour']['tohour']){?>selected='selected'<?php }?>><?php echo sprintf('%02d',$i);?></option>
																							<?php
																								}
																							?>
																						</select>
																					</div>
																				</div>
																				<div class="right_fieldblock">
																					<label>Minutes</label>
																					<div class="select_dropdownbox">
																						<select name='to_minutes_<?php echo $k.'_'.$my_count;?>' id='to_minutes_<?php echo $k.'_'.$my_count;?>'>
																							<?php
																								for($i=0;$i<=59;$i++)
																								{
																							?>
																									<option <?php if($i==$each_slot['Openinghour']['tominutes']){?>selected='selected'<?php }?>><?php echo sprintf('%02d',$i);?> </option>
																							<?php
																								}
																							?>
																						</select>
																					</div>
																				</div>
																			</div>
																		</td>
																	</tr>
																	<!--<tr class='myclass_<?php echo $k;?>_<?php echo $my_count;?>'>
																			  <td colspan=2>
																					    <hr/>
																			  </td>
																	</tr>-->
																<?php
																}				
															}
														?>
													</table>
													<table>
														<tr>
															<td class="for_btn">
																<div class="controls addslot_btn">
																	<input type='hidden' name='number_of_<?php echo $k;?>_slots' id='hdn_<?php echo $k;?>' value='<?php echo count($slots_arr[$k]);?>'/>
																	<input value='Add Slot' class='btn_addnew' type='button' onclick="addslot('<?php echo $k;?>');" />
																</div>
															</td>
														</tr>
													</table>
												</div>
										    </div>
										</div>
									</div>
									<hr style='border-color:#808080;'/>
							   
						    <?php
						    }
						    ?>
								
								<div class="utopia-from-action">
								    <button onclick='javascript:do_validate();' class="btn btn-primary span5" type="button" >Save changes</button>
								   <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinics'">Cancel</button>
								   
								</div>
							 </fieldset>
						<?php echo $this->Form->end(); ?>
					<!-- </div>-->
				  </div>
			</div>
	    </div>
</section>
<script type='text/javascript'>
            //validation for opening hours
            function do_validate()
            {
                        error_status=0;
                        days_arr=Array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
                        //traversing through the days 1-7
                        for(i=1;i<8;i++)
                        {
                        	   if(error_status==1)
		                       {
		                         break;
		                       }
                               n=$('#hdn_'+i).val(); //storing number of slots for the current day
                               
                               //defining arrays for storing timings
                               fromtime= new Array();
                               totime=new Array();
                               count_slot=0;
                               //traversing through the slots
                               for(j=1;j<=n;j++)
                               {
                                    status_tmp=$('#mystatus_'+i+'_'+j).val(); //picking up the status of current slot
                                    
                                    //if status 0 ignoring
                                    if(status_tmp==0)
                                    {
                                                continue;
                                    }
                                    else
                                    {
                                    	
                                                //picking up timings for current slot
                                                fh=$('#from_hours_'+i+'_'+j).val();
                                                fm=$('#from_minutes_'+i+'_'+j).val();
                                                th=$('#to_hours_'+i+'_'+j).val();
                                                tm=$('#to_minutes_'+i+'_'+j).val();
                                                
                                                //calculating from & to time
                                                ft=fh+':'+fm;
                                                tt=th+':'+tm;
                                                
                                                //checking if no to time is greater than or equal to from time
                                                if (tt<=ft)
                                                {
                                                   error_status=1;
                                                   alert('To time can\'t be less than or equal to from time on '+days_arr[i-1]+" slot"+j);
                                                   break;         
                                                }
                                                else
                                                {
                                                	//storing the times in arrays
                                                	fromtime[count_slot]=ft;
                                                	totime[count_slot]=tt;
                                                	count_slot++;
                                                }
                                                
                                    }
                               }
                               
                               if(error_status==1)
                               {
                               		break;
                               }
                               else
                               {
                               	
                               		for(errortestloop=0;errortestloop<count_slot;errortestloop++)
                               		{
                               			for(errortestloop2=0;errortestloop2<count_slot;errortestloop2++)
                               			{
                               				
                               				if(errortestloop==errortestloop2)
                               				{
                               					continue;
                               				}
                               				else
                               				{
                               					if( ( fromtime[errortestloop] >= fromtime[errortestloop2] && fromtime[errortestloop] < totime[errortestloop2]) || ( totime[errortestloop] > fromtime[errortestloop2] && totime[errortestloop] <= totime[errortestloop2] ) )
                               					{
                               						alert('Overlapping timeslots on '+days_arr[i-1]+'. Please correct the errors.');
                               						
                               						error_status=1;
                               						break;
                               					}
                               				}
                               				
                               			}
                               			
                               			if(error_status==1)
		                               	{
		                               		break;
		                               	}
                               			
                               		}
                               }
                               
                        }
                        if(error_status==0)
                        {
                        			
                                    document.validation.submit();
                        }
            }
            
            //delete an opening hour
            
		function deleteopeninghour(k,mc)
		{
			//var current_val = parseInt($('#hdn_'+k).val());
			//current_val = current_val-1;
			
			$('#mystatus_'+k+'_'+mc).val('0');
			//if (current_val > 0) {
			//	$('#hdn_'+k).val(current_val);
			//}
			//else{
			//	$('#hdn_'+k).val('0');
			//}
			$('.myclass_'+k+'_'+mc).fadeOut();
		}
            
            //add one more slot
            
            function addslot(k)
            {
                        maxid=$('#max_id').val();
                        maxid=parseInt(maxid)+1;
                        $('#max_id').val(maxid);
                        c=parseInt($('#hdn_'+k).val())+1;
                        var txt="<tr class='myclass_"+k+"_"+c+" tr_top'><th  style='text-align: left;font-size: large;'><input type='hidden' id='mystatus_"+k+"_"+c+"' name='status_"+k+"_"+c+"' value='1'><input type='hidden' name='id_"+k+"_"+c+"' id='id_"+k+"_"+c+"' value='"+maxid+"'> <div class='lefttitletxt'><i class='sloticon'></i>Slot </div></th><th style='text-align:right;'><a href='javascript:deleteopeninghour("+k+","+c+")'><img src='<?php echo BASE_URL;?>app/webroot/admin/img/icons2/slot_closeicon.png' class='utopia-icons2-small-img' title='delete'></a></th></tr><tr class='myclass_"+k+"_"+c+" fromtr'><td class='full_w'>From :</td><td class='ful_td'><div class='fieldblockbox'><div class='left_fieldblock'><label>Hours</label><div class='select_dropdownbox'><select name='from_hours_"+k+"_"+c+"' id='from_hours_"+k+"_"+c+"' >";
                        for(ai=0;ai<=23;ai++)
                        {
                            txt+="<option>"+pad2(ai)+"</option>";
                        }
                        txt+="</select></div></div><div class='right_fieldblock'><label>Minutes</label><div class='select_dropdownbox'><select name='from_minutes_"+k+"_"+c+"' id='from_minutes_"+k+"_"+c+"' >";
                        for(bi=0;bi<=59;bi++)
                        {
                            txt+="<option>"+pad2(bi)+"</option>";
                        }
                        txt+="</select></div></div></div></td></tr>";
                        
                        txt+="<tr class='myclass_"+k+"_"+c+" fromtr'><td class='full_w'>To :</td><td class='ful_td'><div class='fieldblockbox'><div class='left_fieldblock'><label>Hours</label><div class='select_dropdownbox'><select name='to_hours_"+k+"_"+c+"' id='to_hours_"+k+"_"+c+"' >";
                        for(ai=0;ai<=23;ai++)
                        {
                            txt+="<option>"+pad2(ai)+"</option>";
                        }
                        txt+="</select></div></div><div class='right_fieldblock'><label>Minutes</label><div class='select_dropdownbox'><select name='to_minutes_"+k+"_"+c+"' id='to_minutes_"+k+"_"+c+"' >";
                        for(bi=0;bi<=59;bi++)
                        {
                            txt+="<option>"+pad2(bi)+"</option>";
                        }
                        txt+="</select></div></div></div></td></tr>";
                        
                        $('#hdn_'+k).val(c);
                        //$('#slot_table_'+k).prepend(txt);
				    $('#slot_table_'+k).append(txt);
            }
            
            //function for padding a number like 1 to 01 or 2 to  02
            function pad2(number)
            {
                        return (number < 10 ? '0' : '') + number;
            }
    
</script>