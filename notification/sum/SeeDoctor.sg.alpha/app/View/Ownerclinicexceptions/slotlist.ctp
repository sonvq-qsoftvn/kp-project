<?php
if(count($openinghours)==0)
{
    echo "Sorry no slot to be cancelled on this date!!!";     
}
else
{
?>
    <select name='cancelledslotid'>
                                         
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
