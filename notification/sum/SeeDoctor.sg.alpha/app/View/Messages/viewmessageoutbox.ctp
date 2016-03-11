<div class="row-fluid">
            <div class="span12">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/dashboard">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL;?>administrator/outbox" >Outbox</a> <span class="divider">/</span>
                    </li>
                    <li class='active disabled'>
                        <a href="#" >View Message</a> 
                    </li>
                </ul>
            </div>
</div>
<div class="row-fluid">

                <div class="span12">
                    <section class="utopia-widget">
                        <div class="utopia-widget-title">
                            <?php
                            echo $this->Html->image('../admin/img/icons/paragraph_justify.png',array('class'=>'utopia-widget-icon'));
                            ?>
                            <span>SUB &nbsp;: &nbsp;<?php echo $thismessage['Messagecontent']['subject'];?></span>
                        </div>

                        <div class="utopia-widget-content">
                                    
                            
                            <div class="row-fluid">
                                <!-- Child Messages Are Shown Here -->
                                <?php
                                if(count($child_messages)!=0)
                                {
                                    foreach($child_messages as $child)
                                    {
                                    ?>
                                    <table style='width:100%;'>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $child['Messagecontent']['id'];?>","imgid_<?php echo $child['Messagecontent']['id'];?>");'>
                                        <td>
                                            From&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                                if($uid==$child['Messagecontent']['fromid']&&$child['Messagecontent']['fromtype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $child['Messagecontent']['fromuname'];
                                                }
                                            ?>
                                        </td>
                                        <td rowspan=2 style='text-align:right;padding-left:5%;'>
                                            Sent on&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $child['Messagecontent']['datesent'];?>
                                        </td>
                                        <td style='text-align:center;' rowspan=2>
                                            <img id='imgid_<?php echo $child['Messagecontent']['id']?>' imgvalue='down' src='<?php echo BASE_URL;?>app/webroot/admin/img/icons2/directional_down.png' height='20px' width='20px' style='vertical-align: center;'>
                                        </td>
                                    </tr>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $child['Messagecontent']['id'];?>","imgid_<?php echo $child['Messagecontent']['id'];?>");'>
                                        <td>
                                            To&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                         
                                                if($uid==$child['Message']['toid']&&$child['Message']['totype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $child['Message']['touname'];
                                                }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan='3' >
                                            <hr/>
                                        </td>
                                    </tr>
                                    <tr id='msg_<?php echo $child['Messagecontent']['id']?>' style='display:none;'>
                                        <td colspan=3 style='padding-top:1%;padding-bottom:2%;' >
                                            <?php
                                                echo $child['Messagecontent']['message'];
                                                
                                            ?>
                                            <hr/>
                                        </td>
                                    </tr>
                                </table>
                                    <?php
                                    }
                                }
                                ?>
                                <!-- Child Messages List ends -->
                                <table style='width:100%;'>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $thismessage['Messagecontent']['id'];?>","imgid_<?php echo $thismessage['Messagecontent']['id'];?>");'>
                                        <td>
                                            From&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                                if($uid==$thismessage['Messagecontent']['fromid']&&$thismessage['Messagecontent']['fromtype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $thismessage['Messagecontent']['fromuname'];
                                                }
                                            ?>
                                        </td>
                                        <td rowspan=2 style='text-align:right;padding-left:5%;'>
                                            Sent on&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $thismessage['Messagecontent']['datesent'];?>
                                        </td>
                                        <td style='text-align:center;' rowspan=2>
                                            <img id='imgid_<?php echo $thismessage['Messagecontent']['id']?>' imgvalue='up' src='<?php echo BASE_URL;?>app/webroot/admin/img/icons2/directional_up.png' height='20px' width='20px' style='vertical-align: center;'>
                                        </td>
                                    </tr>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $thismessage['Messagecontent']['id'];?>","imgid_<?php echo $thismessage['Messagecontent']['id'];?>");'>
                                        <td>
                                            To&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                         
                                                if($uid==$thismessage['Message']['toid']&&$thismessage['Message']['totype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $thismessage['Message']['touname'];
                                                }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan='3' >
                                            <hr/>
                                        </td>
                                    </tr>
                                    <tr id='msg_<?php echo $thismessage['Messagecontent']['id']?>'>
                                        <td colspan=3 style='padding-top:1%;padding-bottom:2%;' >
                                            <?php
                                                echo $thismessage['Messagecontent']['message'];
                                                
                                            ?>
                                            <hr/>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Parent Messages Are Shown Here -->
                                <?php
                                if(count($parent_messages)!=0)
                                {
                                    foreach($parent_messages as $parent)
                                    {
                                    ?>
                                    <table style='width:100%;'>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $parent['Messagecontent']['id'];?>","imgid_<?php echo $parent['Messagecontent']['id'];?>");'>
                                        <td>
                                            From&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                                if($uid==$parent['Messagecontent']['fromid']&&$parent['Messagecontent']['fromtype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $parent['Messagecontent']['fromuname'];
                                                }
                                            ?>
                                        </td>
                                        <td rowspan=2 style='text-align:right;padding-left:5%;'>
                                            Sent on&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $parent['Messagecontent']['datesent'];?>
                                        </td>
                                        <td style='text-align:center;' rowspan=2>
                                            <img id='imgid_<?php echo $parent['Messagecontent']['id']?>' imgvalue='down' src='<?php echo BASE_URL;?>app/webroot/admin/img/icons2/directional_down.png' height='20px' width='20px' style='vertical-align: center;'>
                                        </td>
                                    </tr>
                                    <tr style='cursor:pointer;' onclick='maketoggle("msg_<?php echo $parent['Messagecontent']['id'];?>","imgid_<?php echo $parent['Messagecontent']['id'];?>");'>
                                        <td>
                                            To&nbsp;&nbsp;:&nbsp;&nbsp;
                                            <?php
                                         
                                                if($uid==$parent['Message']['toid']&&$parent['Message']['totype']=='superadmin')
                                                {
                                                    echo 'You';
                                                }
                                                else
                                                {
                                                    echo $parent['Message']['touname'];
                                                }
                                            ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan='3' >
                                            <hr/>
                                        </td>
                                    </tr>
                                    <tr id='msg_<?php echo $parent['Messagecontent']['id']?>' style='display:none;'>
                                        <td colspan=3 style='padding-top:1%;padding-bottom:2%;' >
                                            <?php
                                                echo $parent['Messagecontent']['message'];
                                                
                                            ?>
                                            <hr/>
                                        </td>
                                    </tr>
                                </table>
                                    <?php
                                    }
                                }
                                ?>
                                <!-- Parent Messages List ends -->

                                
                            </div>
                        </div>
                    </section>
                </div>
</div>
