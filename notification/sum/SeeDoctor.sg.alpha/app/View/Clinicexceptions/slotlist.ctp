<?php

//This code snippet generates a timing list/ basic slot list on the date provided the names and ids like cancelledslotids doesnot suggest that it has been used for cancel purpose only its a global code snippet

if(count($openinghours)==0)
{
    echo "Sorry no slot to be cancelled on this date!!!";     //this message is only for checking purpose and is not shown anywhere
}
else
{
?>
    <select name='cancelledslotid' id='cancelledslotid'>
                                        
                                         <?php
                                         foreach($openinghours as $oh)
                                         {
                                                    ?>
                                                    <option value='<?php echo $oh['Openinghour']['id'];?>'><?php echo sprintf("%02d",$oh['Openinghour']['fromhour']).':'.sprintf("%02d",$oh['Openinghour']['fromminutes']).' - '.sprintf("%02d",$oh['Openinghour']['tohour']).':'.sprintf("%02d",$oh['Openinghour']['tominutes']);?></option>
                                                    <?php
                                         }
                                         ?>
                                         
    </select>
<?php
}
?>
