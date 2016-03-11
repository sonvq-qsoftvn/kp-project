
<?php 
$last_delemeter = end(explode('/', $this->request->here));

?>

<script type="text/javascript">
 
   
    
  
    
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
                            
                            
                            alert(result);
                            
                         
			
                        if(result==0)
                        {
                            
                           $('show_message_usename').show(); 
                           
                           
                           return false;
                            
                        }
                        
                        
                         $('show_message_usename').hide(); 
                         //var input_userid_val= $('#input_userid').val();
                            // alert(result);  
                            
                            
               var url1 = '<?php echo BASE_URL.'messages/ajax_conversation'; ?>';
		$.ajax({
			type: 'POST',
			url: url1,
			data: {username:user_name,user_id:$.trim(result)},
			success:function(result1)
			{
			
                          
                            
                            $("#message_content" ).html(result1);
                            
                            //$("#message_content" ).before(result);
				
			}
	}); 
                            
                            
                            
				
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
                                
                                <div id="show_message_usename" style="display:none;">your user name is not exiting </div>
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
                 <div id='message_content'> 
                     
		
                     
                       </div>
		
                </div>
            </div>
        </div>
      </div>
    </section>
    
  
<input type="hidden" name="input_userid" id="input_userid"/>
         
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





