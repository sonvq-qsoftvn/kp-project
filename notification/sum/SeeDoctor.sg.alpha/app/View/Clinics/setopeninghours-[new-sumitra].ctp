
     <section class="emai-registration">
		<div class="topheading-box"><div class="container"><h2>Set Opening Hours</h2></div></div>
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
		<div class="ourdoctors">
			<div class="container">
				<div class="set_openingbasebox">
				 <?php echo $this->Form->create('Clinic',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
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
				 echo $k;
			    
                            ?>
					<div class="dayblock">
						<div class="dayleft"><div class="dayname"><?php echo $v;?>:</div></div>
						<div class="dayright">
							<div class="dat_topbar">
								<div class="lefttitletxt"><i class="sloticon"><?php echo $this->Html->image('../frontend/images/sloticon.png',array('alt'=>'')); ?></i> Slot 1</div>
								<div class="righticonbox"><a href="#"><i><?php echo $this->Html->image('../frontend/images/slot_closeicon.png',array('alt'=>'')); ?></i></a></div>
							</div>
							<div class="clearfix"></div>
							<div class="frompanelbox">
								<div class="from_leftpl">
									<div class="labeltxt">From</div>
									<div class="fieldblockbox">
										<div class="left_fieldblock">
											<label>Hours</label>
											<div class="select_dropdownbox"><select><option>08</option></select></div>
										</div>
										<div class="right_fieldblock">
											<label>Minutes</label>
											<div class="select_dropdownbox"><select><option>08</option></select></div>
										</div>
									</div>
								</div>
								<div class="from_rightpl">
									<div class="labeltxt">To</div>
									<div class="fieldblockbox">
										<div class="left_fieldblock"><label>Hours</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
										<div class="right_fieldblock"><label>Minutes</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
									  </div>
								</div>
							</div>
							<div class="dat_topbar">
								<div class="lefttitletxt"><i class="sloticon"><?php echo $this->Html->image('../frontend/images/sloticon.png',array('alt'=>'')); ?></i> Slot 2</div>
								<div class="righticonbox"><a href="#"><i><?php echo $this->Html->image('../frontend/images/slot_closeicon.png',array('alt'=>'')); ?></i></a></div>
							</div>
							<div class="clearfix"></div>
							<div class="frompanelbox">
								<div class="from_leftpl">
									<div class="labeltxt">From</div>
									<div class="fieldblockbox">
										<div class="left_fieldblock"><label>Hours</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
										<div class="right_fieldblock"><label>Minutes</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
									</div>
								</div>
								<div class="from_rightpl">
									<div class="labeltxt">To</div>
									<div class="fieldblockbox">
										<div class="left_fieldblock"><label>Hours</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
										<div class="right_fieldblock"><label>Minutes</label> <div class="select_dropdownbox"><select><option>08</option></select></div></div>
									</div>
								</div>
								
							</div>
						
						<div class="clearfix"></div>
		<input type='hidden' name='number_of_<?php echo $k;?>_slots' id='hdn_<?php echo $k;?>' value='<?php echo count($slots_arr[$k]);?>'/>
                <div class="addslot_btn"><input value='Add Slot' type='button' onclick="addslot('<?php echo $k;?>');" /></div>
						</div>
					 </div>
					<?php
					} //End foreach for days
					?>
					
					    <div class="utopia-from-action">
					    <button onclick='javascript:do_validate();' class="btn btn-primary span5" type="button" >Save changes</button>
					    <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinics'">Cancel</button>
					    </div>
				  </div>
			  
		   </div>
		</div>
	</section>
    <div class="scrolltop"></div>   
