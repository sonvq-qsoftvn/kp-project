
 <section class="emai-registration">
               <div class="banner">
                    <div class="container pro">
                         <div class="see_doctor">
                              <h1>See Doctor <strong>Anytime.</strong></h1>
                              <p>Find and book your favorite doctor</p>
                              <div class="find_doctor">
                                   <ul id="tabs_nav">
                                        <li><a href="#tad1">Find Doctor</a></li>
                                        <li><a href="#tad2">Find Dentist</a></li>
                                   </ul>
                                   <div class="tabs_content_container">
                                   <form name="form_doctor" action="<?php echo BASE_URL."search/index/1"?>" method="get">
                                        <div id="tad1" class="tab_content">
                                             <div class="find_doctor_element">
     <input type="text" name="clinic_doc" class="user-in typeahead" placeholder="Name of Clinic, Doctor, Condition or Procedure">
                                             </div>
                                             <div class="find_doctor_element">
                                                  <select name="specialist" class="custom-select">
                                                    <option value="">--Select Specialities--</option>
                                                     <?php
                                                       foreach($specialities_detail_doctor_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                  </select>
                                             </div>
                                             <div class="find_doctor_nearest">
                                                  <div class="nearest-to">Nearest To :</div>
                                                  <div class="nearest-to-field"><input type="text" name="near" class="user-in" placeholder="" style="height:auto !important;"></div>
                                             </div>
                                             <div class="find_doctor_advanced">Advanced Search Options :
                                                  <?php echo $this->Html->image('../frontend/images/btn_ad_search.jpg',array('alt'=>'')); ?>
                                             </div>
                                             <div class="currently_open">
                                                  <div><input type="checkbox" name="curr_open"> Currently Open</div>
                                                  <div><input type="checkbox" name="24_hr"> 24 hours</div>
                                             </div>
                                             <div class="find_doctor_element">
                                                  <select name="insurance" class="custom-select">
                                                    <option value="">--Select Insurance--</option>
                                                       <?php
                                                       foreach($insurance_detail_doctor_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option  <?php if($par_insurance[$key]=="parent"){ ?> disabled <?php } ?>  value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                       
                                                  </select>
                                             </div>
                                             <div class="find_doctor_element">
                                                  <select name="eligibility" class="custom-select">
                                                    <option value="">--Select Eligibility--</option>
                                                    <?php
                                                       foreach($eligibility_detail_doctor_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option <?php if($par_eligility[$key]=="parent"){ ?> disabled <?php } ?> value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                   </select>
                                             </div>
                                             <input type="hidden" name="sp_type" value="0" id="sp_type"/><!---its for doctor specialities type-->
                                             <div class="find_now"><button type="submit">Find Now</button></div>
                                        </div>
                                   </form>    
 
 
 <!------------------------------------SEARCH DENTIST SECTION--------------------------->
 
 
                                   <form name="form_dentist" action="<?php echo BASE_URL."search/index/1"?>" method="get">
 
                                             <div id="tad2" class="tab_content">
                                            <div class="find_doctor_element">
         <input type="text" name="clinic_doc" class="user-in typeahead" placeholder="Name of Clinic, Dentist, Condition or Procedure">
                                            </div>
                                             <div class="find_doctor_element">
                                             
                                                  <select name="specialist" class="custom-select" id="specialist">
                                                       <option value="">--Select Specialities--</option>
                                                       <?php
                                                       foreach($specialities_detail_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>

                                                  </select>
                                                  
                                             </div>
                                             <div class="find_doctor_nearest">
                                                  <div class="nearest-to">Nearest To :</div>
                                                  <div class="nearest-to-field"><input type="text" name="near" class="user-in" placeholder=""></div>
                                             </div>
                                             <div class="find_doctor_advanced">Advanced Search Options :
                                                  <?php echo $this->Html->image('../frontend/images/btn_ad_search.jpg',array('alt'=>'')); ?>
                                             </div>
                                             <div class="currently_open">
                                                  <div><input type="checkbox" name="curr_open" value="cur_open"> Currently Open</div>
                                                  <div><input type="checkbox" name="24_hr" value="24_hr"> 24 hours</div>
                                             </div>
                                             <div class="find_doctor_element">
                                                  <select name="insurance" class="custom-select">
                                                    <option value="">--Select Insurance--</option>
                                                       <?php
                                                       foreach($insurance_detail_doctor_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option  <?php if($par_insurance[$key]=="parent"){ ?> disabled <?php } ?>  value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                       
                                                  </select>
                                             </div>
                                             <div class="find_doctor_element">
                                                  <select name="eligibility" class="custom-select">
                                                    <option value="">--Select Eligibility--</option>
                                                    <?php
                                                       foreach($eligibility_detail_doctor_arr as $key=>$val)
                                                       {
                                                       ?>
                                                       <option <?php if($par_eligility[$key]=="parent"){ ?> disabled <?php } ?>  value="<?php echo $key;?>"><?php echo $val;?></option>
                                                       <?php
                                                       }
                                                       ?>
                                                 </select>
                                             </div>
                                             <input type="hidden" name="sp_type" value="1" id="sp_type"/><!---its for dentist specialities type-->
                               <!--<div class="find_now"><button type="button" id="sub_buton" onclick="search_dentist()">Find Now</button></div>-->
                               <div class="find_now"><button type="submit" >Find Now</button></div>
                                   </form>
<!----------------------------------SEARCH DENTIST SECTION--------------------------------------------------->
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="banner_slider">
                              <ul class="bxslider">
                                   <?php
                                   foreach($all_bannerlogo as $eachbannerlogo)
                                   {//echo $eachbannerlogo['Companylogo']['company_logo'];
                                   ?>
                                   <li><?php echo $this->Html->image('../frontend/images/home_baner.png',array('class'=>'home_baner')); ?>
								   <?php echo $this->Html->image('../admin/company_logo/banner_logo/'.$eachbannerlogo['Companylogo']['company_logo'],array('alt'=>'')); ?>
								   </li>
                                  
                                   
                                   
                                   <!--<li><?php //echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?></li>
                                   <li><?php //echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?></li>
                                   <li><?php //echo $this->Html->image('../frontend/images/mobile_screen.png',array('alt'=>'')); ?></li>-->
                                   <?php
                                  }
                                   ?>
                              </ul>
                         </div>
                    </div>
               </div>
               <div class="slider1">
                    <div class="container">
                         <div class="slider_main">
                              <ul class="bxslider1">
                              <?php 
					foreach($all_wallposts as $each_wallposts)
					{?>
                                   <li>
                                        <div class="icon1"><?php echo $this->Html->image('../frontend/images/icon12.jpg',array('alt'=>'')); ?></div>
                                        <p>
                                             <?php echo ucfirst($each_wallposts['Wallpost']['post_main_text']); ?>
                                        </p>
                                        <div class="icon2"><?php echo $this->Html->image('../frontend/images/icon13.jpg',array('alt'=>'')); ?></div>
                                        <h2><?php echo ucwords($each_wallposts['Wallpost']['alias_fname'].' '.$each_wallposts['Wallpost']['alias_lname']); ?></h2>
                                        <p class="robert_detgails"><?php echo ucwords($each_wallposts['Wallpost']['alias_designation']); ?><br><?php echo ucwords($each_wallposts['Clinic']['name']); ?></p>
                                   </li>
                                <?php } ?>
                                   <!--<li>
                                        <div class="icon1"><?php echo $this->Html->image('../frontend/images/icon12.jpg',array('alt'=>'')); ?></div>
                                        <p>
                                             Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem 
                                             aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta. Sed ut perspiciatis 
                                             unde omnis iste natus error sit voluptatem accusantium doloremque laudantium
                                        </p>
                                        <div class="icon2"><?php echo $this->Html->image('../frontend/images/icon13.jpg',array('alt'=>'')); ?></div>
                                        <h2>Robert Teoh</h2>
                                        <p class="robert_detgails">Family Physician<br>Bedok Reservoir Family Clinic</p>
                                   </li>
                                   <li>
                                        <div class="icon1"><?php echo $this->Html->image('../frontend/images/icon12.jpg',array('alt'=>'')); ?></div>
                                        <p>
                                             Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem 
                                             aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta. Sed ut perspiciatis 
                                             unde omnis iste natus error sit voluptatem accusantium doloremque laudantium
                                        </p>
                                        <div class="icon2"><?php echo $this->Html->image('../frontend/images/icon13.jpg',array('alt'=>'')); ?></div>
                                        <h2>Robert Teoh</h2>
                                        <p class="robert_detgails">Family Physician<br>Bedok Reservoir Family Clinic</p>
                                   </li>
                                   <li>
                                        <div class="icon1"><?php echo $this->Html->image('../frontend/images/icon12.jpg',array('alt'=>'')); ?></div>
                                        <p>
                                             Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem 
                                             aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta. Sed ut perspiciatis 
                                             unde omnis iste natus error sit voluptatem accusantium doloremque laudantium
                                        </p>
                                        <div class="icon2"><?php echo $this->Html->image('../frontend/images/icon13.jpg',array('alt'=>'')); ?></div>
                                        <h2>Robert Teoh</h2>
                                        <p class="robert_detgails">Family Physician<br>Bedok Reservoir Family Clinic</p>
                                   </li>-->
                              </ul>
                          </div>
                    </div>
               </div>
               <div class="featured_events"> 
                    <div class="container">
                         <div class="featured_events_title"><h2>Featured Events</h2></div>
                         <div class="featured_events_para">
                             <p> <?php echo $FEVENT_TEXT; ?> </p>
                         </div>
                         <div class="featured_events_items">
                        <?php 
						foreach($all_doctors as $each_doctor)
						{?>
                              <div class="col-md-3 col-sm-6">
                                   <?php if($each_doctor['Doctor']['img']!=''){echo $this->Html->image('../admin/uploads/'.$each_doctor['Doctor']['img'],array('alt'=>'','height'=>'255' ,'width'=>'255'));} else{echo $this->Html->image('../frontend/images/no-avatar.jpg',array('alt'=>'No Image','height'=>'255' ,'width'=>'255'));} ?>
                                   <h2><?php echo ucwords($each_doctor['Doctor']['f_name'].' '.$each_doctor['Doctor']['l_name'])?></h2>
                                   <p><?php echo ucwords($each_doctor['Doctor']['qualification'])?></p>
                              </div>
                              <?php } ?>
                         </div>
                    </div>
               </div>
               <div class="featured_in">
                    <div class="container">
                         <div class="featured_in_title"><h2>FEATURED IN</h2></div>
			 
                         <div class="featured_in_items">
                              
                              <?php
                              foreach($all_companylogo as $eachcompanylogo)
                              {
                              ?>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php  echo $this->Html->image('../admin/company_logo/thumb_company_logo/'.$eachcompanylogo['Companylogo']['company_logo'],array('alt'=>'')); ?>
                             </div>
                              <?php
                              }
                              ?>
                              <!--<div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php //echo $this->Html->image('../frontend/images/f_in1.jpg',array('alt'=>'')); ?>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php //echo $this->Html->image('../frontend/images/f_in2.jpg',array('alt'=>'')); ?>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php //echo $this->Html->image('../frontend/images/f_in3.jpg',array('alt'=>'')); ?>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php //echo $this->Html->image('../frontend/images/f_in4.jpg',array('alt'=>'')); ?>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-6">
                                   <?php //echo $this->Html->image('../frontend/images/f_in5.jpg',array('alt'=>'')); ?>
                              </div>-->
                         </div>
                    </div>
               </div>
               <div class="getin_touch">
                    <div class="container">
                         <div class="getin_touch_title"><h2>GET IN TOUCH</h2></div>
                         <div class="getin_touch_para">
                             <p> <?php echo html_entity_decode($GIT_TEXT); ?> </p>
                         </div>
                         <div class="getin_touch_items">
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                   <ul class="getin_touch_left">
                                        <p><?php echo  html_entity_decode($GIT_CONT); ?></p>
                                        <!--<li><a href="#">Find Doctors &amp; Dentists</a></li>
                                       <li><a href="#">Book them for a consultation</a></li>
                                       <li><a href="#">Track your appointments</a></li>
                                       <li><a href="#">Stay in touch!</a></li>-->
                                   </ul>
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-12">
                                   <ul class="getin_touch_middle">
                                        <li><a target=_blank"" href="<?php echo $FACEBOOK_LINK; ?>"><?php echo $this->Html->image('../frontend/images/facebook_icon.jpg',array('alt'=>'')); ?></a></li>
                                        <li><a target=_blank"" href="<?php echo $TWITTER_LINK; ?>"><?php echo $this->Html->image('../frontend/images/twitter_icon.jpg',array('alt'=>'')); ?></a></li>
                                        <li><a target=_blank"" href="<?php echo $YOUTUBE_LINK; ?>"><?php echo $this->Html->image('../frontend/images/youtube_icon.jpg',array('alt'=>'')); ?></a></li>
                                        <li><a target=_blank"" href="<?php echo $GOOGLE_LINK; ?>"><?php echo $this->Html->image('../frontend/images/google_plus_icon.jpg',array('alt'=>'')); ?></a></li>
                                   </ul>
                              </div>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                   <div class="getin_touch_right">
                                        <?php //echo $this->Html->image('../frontend/images/mobile_img.jpg',array('alt'=>'')); ?>
                                        <?php echo $this->Html->image('../admin/company_logo/footer_image/'.$footerlogo,array('alt'=>'')); ?>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </section>

<script>
$(document).on('click','.find_doctor_advanced',function(){
	$(this).next().slideToggle();	
})
</script>

<!------------------------------Auto Complete------------------------------------------------->



<script>     
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });

    cb(matches);
  };
};
 
var states = [<?php echo $dat;?>];



$('.typeahead').typeahead({



  hint: true,
  highlight: true,
  minLength: 1
},
{
  
  name: 'states',
  displayKey: 'value',
  source: substringMatcher(states)
});


</script>

