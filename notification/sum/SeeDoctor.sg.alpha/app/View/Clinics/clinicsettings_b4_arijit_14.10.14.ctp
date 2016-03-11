<?php
$my_data=$this->request->data;

?>
<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/clinics">Clinics</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >Edit Clinic</a> 
                    </li>
                </ul>
            </div>
        </div>
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
    <div class="utopia-widget-title">
        <?php
            echo $this->Html->image('../admin/img/icons2/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
        ?>
        
        <span>Edit Clinic Form</span>
    </div>

    <div class="row-fluid">
        <div class="utopia-widget-content">
            <div class="span12 utopia-form-freeSpace">
                <div class="sample-form">
                    <?php echo $this->Form->create('Clinic',$settings=array('class'=>'form-horizontal','id'=>'validation','name'=>'validation','enctype'=>'multipart/form-data')); ?>
                    
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="old image">Old Image:</label>

                                <div class="controls">
                                    <?php
                                                if($my_data['Clinic']['logo']=='')
                                                {
                                                            echo "No Clinic Logo presently";
                                                }
                                                else
                                                {
                                                            echo $this->Html->image('../admin/uploads/'.$my_data['Clinic']['logo'],array('alt'=>'logo','style'=>'height:50px; width:50px;'));
                                                }
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="logo">Upload New Image:</label>

                                <div class="controls">
                                    <input class='input-fluid' id='logo' name='logo' type='file'/>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmangersid">Clinic Manager*:</label>

                                <div class="controls">
                                    <?php
                                        $options_arr=array();
                                        foreach($all_owners as $k=>$v)
                                        {
                                           $options_arr[$v['Clinicmanager']['id']]=$v['Clinicmanager']['clinicmanagers_fname'].' '.$v['Clinicmanager']['clinicmanagers_lname'];
                                        }
                                         
                                        echo $this->Form->input('clinicmanagersid',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'clinicmanagersid', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select Clinic Manager','class'=>'chzn-select-deselect'));
                                    ?>
                                    
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label" for="name">Clinic Name*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('name',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'name'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="license">License Number*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('license',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'license'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="handphone">Hand Phone Number*:</label>

                                <div class="controls">
                                    <?php
                                    echo '+65&nbsp;&nbsp;&nbsp;'.$this->Form->input('handphone',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'handphone','style'=>'width:77%;'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="url">Clinic url*:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('url',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'url'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="address">Address*:</label>

                                <div class="controls">
                                    
                                    <?php echo $this->Form->input('address',array('type' => 'textarea','id' => 'address','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                    
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmangersid">Clinic Speciality*:</label>

                                <div class="controls">
                                    <?php
                                        $options_arr2[0]='Please Select Speciality';
                                        foreach($all_base_specialities as $k=>$v)
                                        {
                                           $options_arr2[$v['Speciality']['id']]=$v['Speciality']['specialities_name'];
                                        }
                                         
                                        echo $this->Form->input('type',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'type', 'options'=>$options_arr2,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'chzn-select-deselect','onchange'=>'ajax_sub(this.value,"'.BASE_URL.'administrator/producesub")'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="clinicmangersid">Clinic Sub Speciality*:</label>

                                <div class="controls" id='sub'>
                                    <?php
                                        $options_arr=array();
                                        
                                        if($all_sub_specialities!=array())
                                        {
                                                foreach($all_sub_specialities as $k=>$v)
                                                {
                                                   $options_arr[$v['Speciality']['id']]=$v['Speciality']['specialities_name'];
                                                }
                                                echo $this->Form->input('subtype',array('type'=>'select','label' => FALSE, 'div' => FALSE, 'id' => 'subtype', 'options'=>$options_arr,'style'=>'width:60%;','data-placeholder'=>'Select Speciality','class'=>'chzn-select-deselect'));
                                        }
                                        else
                                        {
                                               echo $this->Form->input('subtype',array('label' => FALSE, 'div' => FALSE, 'type' => 'hidden', 'class' => 'input-fluid', 'id' => 'subtype'))."No subspeciality for the selected speciality";
                                        }
                                        
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="address">About*:</label>

                                <div class="controls">
                                    
                                    <?php echo $this->Form->input('about',array('type' => 'textarea','id' => 'about','label' => FALSE,'cols'=>20,'rows'=>10,'div' => FALSE,'class' => 'input-fluid ck_editor')); ?>
                                    
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="url">Waiting Time:</label>

                                <div class="controls">
                                    <?php
                                    echo $this->Form->input('waitingtime',array('label' => FALSE, 'div' => FALSE, 'type' => 'text', 'class' => 'input-fluid', 'id' => 'waitingtime'));
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                            <label class="control-label" for="optionsCheckbox">Wall settings 1:</label>

                            <div class="controls">
                                <label class="checkbox">
                                    <input  type="checkbox" value="1" name='display_waiting' <?php if($my_data['Clinic']['displaywaiting']==1){?>checked='checked'<?php }?>>
                                    Display waiting time on clinic wall
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="optionsCheckbox">Wall settings 2:</label>

                            <div class="controls">
                                <label class="checkbox">
                                    <input  type="checkbox" value="1" name='allow_post' <?php if($my_data['Clinic']['allowpost']==1){?>checked='checked'<?php }?>>
                                    Allow users to post on clinic wall?
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="optionsCheckbox">Wall settings 3:</label>

                            <div class="controls">
                                <label class="checkbox">
                                    <input  type="checkbox" value="1" name='lock_wall' <?php if($my_data['Clinic']['lockwall']==1){?>checked='checked'<?php }?>>
                                    Lock clinic wall?
                                </label>
                            </div>
                        </div>
                         <div class="control-group">
                                <label class="control-label" for="insurances">Insurances*:</label>

                                <div class="controls">
                                    <select id='insurances' name='insurances[]' multiple>
                                    <?php
                                                $checked_arr=array();//items to be kept selected 
                                                
                                                //extracting current clinics
                                                if(count($current_insurances)==0)
                                                {
                                                            $checked_arr=array();
                                                }
                                                else
                                                {
                                                            foreach($current_insurances as $v)
                                                            {
                                                                        $checked_arr[]=$v[Insurancetoclinic][insuranceid];
                                                            }
                                                }
                                                
                                                //creating the dropdown
                                                foreach($all_insurances as $k=>$v)
                                                {
                                                            ?>
                                                            <option <?php if(gettype(array_search($v['Insurance']['id'],$checked_arr))!='boolean'){?>selected='selected'<?php }?> value="<?php echo $v['Insurance']['id'];?>"><?php echo $v['Insurance']['insurances_name'];?></option>
                                                            <?php
                                                }
                                    ?>
                                    </select>
                                                
                                    
                                </div>
                            </div>
                         
                            <div class="utopia-from-action">
                                <button class="btn btn-primary span5" type="button" onclick='do_validate();'>Save changes</button>
                               <button class="btn span5" type="button" onclick="window.location.href='<?php echo BASE_URL;?>administrator/clinics'">Cancel</button>
                            </div>
                        </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!--script for this page only-->
<script>
            // ajax calls
            
            function ajax_sub(id,u)
            {
                        
                        var xmlhttp;
                        if (window.XMLHttpRequest)
                          {// code for IE7+, Firefox, Chrome, Opera, Safari
                          xmlhttp=new XMLHttpRequest();
                          }
                        else
                          {// code for IE6, IE5
                          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                          }
                        xmlhttp.onreadystatechange=function()
                          {
                                    
                          if (xmlhttp.readyState==4)
                            {
                            document.getElementById("sub").innerHTML=xmlhttp.responseText;
                            }
                          }
                        xmlhttp.open("GET",u+'?specialityid='+id,true);
                        xmlhttp.send();
            }
            
            //change handphone to 8 digit
            
            $(window).load(function(){v=$('#handphone').val();if(v.length==10){new_v='';for(i=2;i<v.length;i++){new_v+=v[i];}$('#handphone').val(new_v);}});
            
            //form validation
            
            function do_validate()
            {
                        
                        status=1;
                        cm=document.getElementById('clinicmanagersid').value;
                         
                        n=document.getElementById('name').value;
                         
                        l=document.getElementById('license').value;
                         
                        hp=document.getElementById('handphone').value;
                        
                        hp='65'+hp;
                        u=document.getElementById('url').value;
                         
                        addr=CKEDITOR.instances.address.getData();
                        cs=document.getElementById('type').value;
                        a=CKEDITOR.instances.about.getData();
                        
                 
                        
                        var phExp=/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
                         
                        if (n=='')
                        {
                                    alert('Please enter clinic name');
                                    document.getElementById('name').focus();
                                    status=0;
                        }
                        else if (l=='')
                        {
                                    alert('Please enter clinic license number');
                                    document.getElementById('license').focus();
                                    status=0;
                        }
                        else if (cm=='')
                        {
                                    alert('Please select a clinic manager');
                                    document.getElementById('clinicmanagersid').focus();
                                    status=0;
                        }
                        else if (hp=='')
                        {
                                    alert('Please enter hand phone');
                                    document.getElementById('handphone').focus();
                                    status=0;
                        }
                        //else if (!hp.match(phExp))
                        //{
                        //         alert('Invalid hand phone');
                        //         document.getElementById('handphone').focus();
                        //         status=0;   
                        //}
                        else if (addr=='')
                        {
                                    alert('Please enter address');
                                    document.getElementById('address').focus();
                                    status=0;
                        }
                        else if (u=='')
                        {
                                    alert('Please enter url');
                                    document.getElementById('url').focus();
                                    status=0;
                        }
                        else if (!u.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/))
                        {
                                 alert('Invalid clinic url');
                                 document.getElementById('url').focus();
                                 status=0;   
                        }
                        else if (cs==''||cs==0)
                        {
                                    alert('Please enter speciality');
                                    document.getElementById('type').focus();
                                    status=0;
                        }
                        else if (a=='')
                        {
                                    alert('Please enter about');
                                    document.getElementById('about').focus();
                                    status=0;
                        }
                        else if (validation.elements["insurances[]"].selectedIndex == -1)
                        {
                                    alert("Please select an insurance.");
                                    status=0;
                        }
                        
                        if (status==1)
                        {
                                    document.validation.submit();           
                        }
            }
</script>