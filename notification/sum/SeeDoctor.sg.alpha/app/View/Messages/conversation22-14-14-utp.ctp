
<?php 
$last_delemeter = end(explode('/', $this->request->here));

?>
<script>
    
    
 function send_message_all()
 {
    
    
     var user_name= $('#form_username').val();
     var subject= $('#subject').val();
     var message= $('#message').val();
    
    
var url = '<?php echo BASE_URL.'messages/save_message'; ?>';
		$.ajax({
			type: 'POST',
			url: url,
			data: {username:user_name,subject:subject,message:message},
			success:function(result)
			{
				
				
			}
	});	
  }			

</script>



    <section class="emai-registration">
    <div class="topheading-box">
       <div class="container">
             <h2>Message</h2>
       </div>
    </div>
      <div class="container">
      	<div class="msg_container">
            <div class="msg_nav">
                <!--<ul>
                  <li class="inbox"><a href="<?php echo BASE_URL;?>messages/MessageInbox" >Inbox</a></li>
                   <li class="compose_active"><a href="<?php echo BASE_URL;?>messages/conversation/9/Clinicmanager">Compose</a></li>
                    <li class="outbox"><a href="<?php echo BASE_URL;?>messages/MessageOutbox" >Outbox</a></li>
                    <li class="draft"><a href="<?php echo BASE_URL;?>messages/MessageTrash">Trash</a></li>
                </ul>-->
		<?php echo $this->element("frontend/message_tab");?>
                <div class="all_msg">
                    <select class="custom-select" style="width:220px;">
                        <option value="">All Messages (5)</option>
                        <option value="">test 1</option>
                        <option value="">test 2</option>
                        <option value="">test 3</option>
                    </select>
                </div>
            </div>
		<!----Logged user details and Get user message Start----->
	<?php 
		$logged_user_var = 0;
		$to_user_var = 0;
		if(count($all_messages))
		{
			$logged_user_details = array();
		
			$to_user_details = array();
		
		}
		else
		{
			$logged_user_details=$logged_user_details['User'];
			
		}
		//pr($to_user_details);
		
			for($i=0;$i<count($all_messages);$i++)
		{
			if($logged_user_var == 1 && $to_user_var == 1)
			{
				break;
			}
			if($all_messages[$i]['User']['id']==$this->Session->read('reid_user_uid') && $all_messages[$i]['User']['user_type']!='superadmin')
			{
				$logged_user_var = 1 ;
				$logged_user_details = $all_messages[$i]['User'];
				//print_r($logged_user_details);
			}
			else
			{
				$to_user_var = 1;
				$to_user_details = $all_messages[$i]['User'];
				//print_r($to_user_details);
			}
			if($all_messages[$i]['ToUser']['id']==$this->Session->read('reid_user_uid') && $all_messages[$i]['ToUser']['user_type']!='superadmin')
			{
				$logged_user_var = 1 ;
				$logged_user_details = $all_messages[$i]['ToUser'];
				//print_r($logged_user_details);
			}
			else
			{
				$to_user_var = 1;
				$to_user_details = $all_messages[$i]['ToUser'];
				//print_r($to_user_details);
			}
			
		}
	?>
		<!----Logged user details and Get user message End----->
            <div class="compose_msg">
		<!-----Sender user Details Start----->
            	<div class="col-xs-12 col-sm-12 col-md-4 msg_composer_main">
                	<div class="msg_composer">
                    	<!--<div class="left"><img src="images/pic10.jpg" /></div>-->
                        <div class="right">
                    		<h2><?php echo $to_user_details['username'];?></h2>
				<p><?php if($to_user_details['user_type']==2){echo "Clinic Manager";}
				elseif($to_user_details['user_type']==1){echo "User";}else{echo "Superadmin";}?></p>
                        </div>
                    </div>
                </div>
		<!-----Sender user Details End----->
            	<div class="col-xs-12 col-sm-12 col-md-8">
		<!------For Send Message Start----->
                	<div class="msg_list_in">
                    	<div class="left"><!--<img src="images/pic8.jpg" />--></div>
			<h4><?php echo $logged_user_details['username'];?></h4><!----NA---->
                        <div class="middle">
				
                       
			
				<?php echo $this->Form->create('Messagecontent',$settings=array( 'url' => array('controller' => 'messages', 'action' => 'save_message'),'id'=>'comment_form','name'=>'comment_form')); ?>
				
				<input type="hidden"  name="toid" value="<?php echo $to_user_details['id'];?>">
				<input type="hidden"  name="touname" value="<?php echo $to_user_details['username'];?>">
				<?php if($to_user_details['user_type']==2){$usertype="Clinicmanager";}
				elseif($to_user_details['user_type']==1){$usertype="user";}else{$usertype="superadmin";}?>
				<input type="hidden" name="totype" value="<?php echo $usertype;?>">
				
				<input type="hidden"  name="fromid" value="<?php echo $logged_user_details['id'];?>">
				<input type="hidden" name="fromuname" value="<?php echo $logged_user_details['username'];?>">
				<?php if($logged_user_details['user_type']==2){$usertype="Clinicmanager";}
				elseif($logged_user_details['user_type']==1){$usertype="user";}?>
				<input type="hidden" name="fromtype" value="<?php echo $usertype;?>">
                                
                                <p>Please Enter User Name</p>
                                <input type="text" name="form_username" id="form_username" class="typeahead" >
<!--                                <input type="text" name="username" id="username" class="typeahead subject_text  tt-input" >-->
                                <div style="clear:both;"></div>
				<p>Subject</p>
                                <input type="text" name="subject" id="subject" class="subject_text">
				<p>Message</p>
                                <textarea rows="5" cols="5" name="message" id="message" class="text_msg"></textarea>
                                <input type="button" name="save" value="Send" class="save btn_send" onclick="return send_message_all()"/>
				
				<?php echo $this->Form->end(); ?>
		
		
                        </div>
                        <!--<div class="days_ago">3 days ago</div>-->
			</div>
                
        
		<!------For Send Message End----->
			
		<!------For Messages Show Start----->
		<?php
		if(count($all_messages))
		{
			
		
		foreach($all_messages as $value)
		{
		
			if($value['User']['id']==$to_user_details['id'])
			{
				
		?>
			<div class="msg_list_out">
				<div class="right" style='border-radius:0% 0% 0% 0%'><h4><?php echo $to_user_details['username'];?></h4><!--<img src="images/pic9.jpg" />--></div>
				<div class="middle" <?php if($m_id==$value['Message']['id']){ ?>style="box-shadow: 0 0 5px #000;"<?php }?> id="middle_<?php echo $value['Message']['id'];?>">
				<div class="add_msg"><?php echo $this->Html->image('../frontend/images/icon31.jpg',array('alt'=>'')); ?></div>
				<h4 style='color:tomato;'><?php echo $value['Messagecontent']['subject'];?></h4>
				<p><?php echo $value['Messagecontent']['message'];?></p>
				</div>
				<div class="days_ago">
				<?php $ret_str=($this->Functions->calculate_time_gap(date('Y-m-d H:i:s'),$value['Messagecontent']['datesent']));if($ret_str['Y']!=0||$ret_str['M']!=0){echo "Nearly ";} if($ret_str['Y']!=0){ echo $ret_str['Y'].' Year'; if($ret_str['Y']>1){echo 's';}}if($ret_str['M']!=0){ echo ' '.$ret_str['M'].' Month'; if($ret_str['M']>1){echo 's';}}if($ret_str['d']!=0){ echo ' '.$ret_str['d'].' Day'; if($ret_str['d']>1){echo 's ';}}if($ret_str['h']!=0){ echo ' '.$ret_str['h'].' Hour'; if($ret_str['h']>1){echo 's ';}}if($ret_str['m']!=0){ echo ' '.$ret_str['m'].' Minute'; if($ret_str['m']>1){echo 's ';}}if($ret_str['Y']!=0||$ret_str['M']!=0||$ret_str['d']!=0||$ret_str['h']!=0||$ret_str['m']!=0){echo ' ago ';}else{echo 'Just Now';}?>
				</div>
			</div>
		<?php
			}
			else
			{
			
		?>
			
			<div class="msg_list_in">
				<div class="left" style='border-radius:0% 0% 0% 0%'><h4><?php echo $logged_user_details['username'];?></h4><!--<img src="images/pic8.jpg" />--></div>
				<div class="middle"  <?php if($m_id==$value['Message']['id']){ ?>style="box-shadow: 0 0 7px #000;"<?php }?>  id="middle_<?php echo $value['Message']['id'];?>">
				<div class="add_msg"><?php echo $this->Html->image('../frontend/images/icon31.jpg',array('alt'=>'')); ?></div>
				<h4 style='color:tomato;'><?php echo $value['Messagecontent']['subject'];?></h4>
				<p><?php echo $value['Messagecontent']['message'];?></p>
				
				</div>
				<div class="days_ago">
				<?php $ret_str=($this->Functions->calculate_time_gap(date('Y-m-d H:i:s'),$value['Messagecontent']['datesent']));if($ret_str['Y']!=0||$ret_str['M']!=0){echo "Nearly ";} if($ret_str['Y']!=0){ echo $ret_str['Y'].' Year'; if($ret_str['Y']>1){echo 's';}}if($ret_str['M']!=0){ echo ' '.$ret_str['M'].' Month'; if($ret_str['M']>1){echo 's';}}if($ret_str['d']!=0){ echo ' '.$ret_str['d'].' Day'; if($ret_str['d']>1){echo 's ';}}if($ret_str['h']!=0){ echo ' '.$ret_str['h'].' Hour'; if($ret_str['h']>1){echo 's ';}}if($ret_str['m']!=0){ echo ' '.$ret_str['m'].' Minute'; if($ret_str['m']>1){echo 's ';}}if($ret_str['Y']!=0||$ret_str['M']!=0||$ret_str['d']!=0||$ret_str['h']!=0||$ret_str['m']!=0){echo ' ago ';}else{echo 'Just Now';}?>
				</div>
			</div>
			
			
		<?php
			}
		}
		}
		?>
		
                </div>
            </div>
        </div>
      </div>
    </section>
    
  

         
<!--/////////////////////////////////////////////////////////Auto Complete//////////////////////////////////////////////////////////////-->

<!------------------------------Auto Complete------------------------------------------------->

<?php
     echo $this->Html->css('../frontend/css/styles');
     echo $this->Html->script('../frontend/js/typehead.min');
?>

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
 
var states = [<?php echo $auto_data;?>];
 //alert(states);
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







<script>
	$(document).ready(function()
		{
			//alert("hi");
			$('html, body').animate({scrollTop: $("#middle_<?php echo $last_delemeter;?>").offset().top}, 2000);
                        
                        
                 });       
                        
                        
/*var substringMatcher = function(strs) {
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
 
var all_username = [<?php echo $auto_data;?>];



$('.typeahead').typeahead({



  hint: true,
  highlight: true,
  minLength: 1
},
{
    
    //alert(all_username);
  
  name: 'states',
  displayKey: 'value',
  source: substringMatcher(all_username)
});


         
  */                      
		
</script>





