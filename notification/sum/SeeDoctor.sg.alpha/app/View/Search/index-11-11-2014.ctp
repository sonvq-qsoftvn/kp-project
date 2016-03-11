<?php
echo "sumitra search";
pr($search);
?>
<section class="emai-registration">
    <div class="topheading-box">
       <div class="container">
             <h2>Clinic</h2>
       </div>
    </div>
      <div class="container">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="client_info">
            <tr class="client_info_title">
                <td class="col-1">&nbsp;</td>
                <td class="col-2">Clinic Name</td>
                <td class="col-3">Specialities</td>
                <td class="col-4">Closed/Open <!--<a href="#" class="downarrow"><img src="images/downarrow.png" alt=""></a>--></td>
                <!--<td class="col-4">Unlike</td>-->
            </tr>
           <?php
           $i=1;
           foreach($search as $data){?>
            <tr class="client_info_cont_g_bar">
            <td class="col-1"><?php echo  $i;?></td>
            <td class="col-2"><a href='<?php echo BASE_URL.'clinics/clincwall/'.$data['Clinic']['id'] ?>'><?php echo $data['Clinic']['name']?></a></td>
            <td class="col-3"><?php echo $data['Speciality']['specialities_name']?></td>
            <!--<td class="col-4"><?php echo $data['Speciality']['address']?></td>-->
            <!--<td class="col-4"><a href="#"><img src="images/thunbdown.ong.png" /></a></td>-->
            </tr>
            <?php
            $i++;
            } ?>
            
        </table>
      </div>
    </section>