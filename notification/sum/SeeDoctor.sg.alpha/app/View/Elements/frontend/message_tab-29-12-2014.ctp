
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL;?>app/webroot/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL;?>app/webroot/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<ul>
<li class="<?php if($active=='inbox'){ echo "inbox_active" ; } else{ echo "inbox" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageInbox">Inbox</a></li>
<!--<li class="compose"><a href="<?php echo BASE_URL;?>messages/conversation/9/Clinicmanager">Compose</a></li>-->
<li class="<?php if($active=='compose'){ echo "compose_active" ; } else{ echo "compose" ;}?>" ><a href="<?php echo BASE_URL;?>messages/conversation">Compose</a></li>
<li class="<?php if($active=='outbox'){ echo "outbox_active" ; } else{ echo "outbox" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageOutbox" >Outbox</a></li>
<li class="<?php if($active=='trash'){ echo "draft_active" ; } else{ echo "draft" ;}?>"><a href="<?php echo BASE_URL;?>messages/MessageTrash">Trash</a></li>
</ul>

<!----Fancy open data start ---->



<script>
    function selectUserType(val)
     {
       // alert(val);
        if(val=='super_admin')
        {
           // alert("1");
            $("#user").hide();
            $("#clinic_manager").hide();
            $("#admin").show();
        }
        else if(val=='user')
        {
            //alert("2");
            $("#clinic_manager").hide();
            $("#admin").hide();
            $("#user").show();
        }
        else if(val=='clinic_manager')
        {
            //alert("3");
            $("#user").hide();
            $("#admin").hide();
            $("#clinic_manager").show();
            
        }
        
     }
</script>

<script>
   function dropdwnResult(rest)
    {
     alert("hello"+rest)
     
     var choose_user=$("#choose_user").val();
     
     if (choose_user=='super_admin')
        {
            user_type='superadmin';
        }
        else if (choose_user=='user')
        {
            user_type='user';
        }
        else if (choose_user=='clinic_manager')
        {
            user_type='Clinicmanager';
        }
     
     var res=rest;
     
     window.location.href="<?php echo BASE_URL;?>messages/conversation/"+res+"/"+user_type;        
        
        
    }
</script>

<style>
    #user{
        display: none;
    }
     #clinic_manager{
        display: none;
    }
     #admin{
        display: none;
    }
</style>

<div style="display: none">
   <!-- <div id="logindiv" style="width: 230px;height:200px;overflow: hidden; background-color: #FFF;">-->
    <div id="logindiv" style="width: 240px;height:200px; background-color: #FFF;">
               <div>
                <select onchange="selectUserType(this.value)" id="choose_user" >
                    <option value="" id="">--Select One--</option>
                    <option value="super_admin" >SuperAdmin</option>
                    <option value="user">User</option>
                    <option value="clinic_manager" ">Clinic Manager</option>
                </select>
               </div>
            
            
            <div id="user">
            
                    <select name="user" onchange="dropdwnResult(this.value)">
                         <option value="" id="">--Select One--</option>
                       <?php foreach($user as $u)
                        { 
                        ?>
                            <option value="<?php echo $u['User']['id']; ?>"><?php echo $u['User']['username'];?></option>
                        <?php } ?>
                    </select>
                </div>
            <div id="clinic_manager">
               
                    <select name="clinic_manager" onchange="dropdwnResult(this.value)">
                        <option value="" id="">--Select One--</option>
                       <?php foreach($clinic_manager as $clm)
                        { 
                        ?>
                        <option value="<?php echo $clm['User']['id']; ?>"><?php echo $clm['User']['username'];?></option>
                  <?php } ?>
                    </select>
              
            </div>
            <div id="admin">
               
                    <select name="admin" onchange="dropdwnResult(this.value)">
                        <option value="" id="">--Select One--</option>
                        <?php foreach($admin as $superadmin)
                        { 
                        ?> 
                            <option value="<?php echo $superadmin['Admin']['id']; ?>"><?php echo $superadmin['Admin']['username'];?></option>
                       <?php } ?>
                    </select>
               
            </div>
            
           
    </div>
</div>

<!------fancy open end ------>

<script type="text/javascript">
    $(document).ready(function() {
        $("#loginbutton").fancybox({
            'titleShow'     : true,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic',
        });
    });
</script>
