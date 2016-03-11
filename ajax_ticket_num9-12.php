<?php
include('include/user_inc.php');

$obj_upd = new user;
$obj_ticket = new user;
$obj_total = new user;
$count = $_POST['count'];
$cart_id = $_POST['cart_id'];

/*echo $count." ".$cart_id;
exit;*/

$obj_upd->upd_ckeckout($count,$cart_id);
?>		
  

<form action="" method="post">	  
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="event_review">
    <tr>
      <th width="16%">Quantity</th>
      <th width="17%">TicketName</th>
      <th width="16%">Price</th>
      <th width="15%">Fee</th>
      <th width="20%">Total</th>
      <th width="16%">&nbsp;</th>
    </tr>
    
    <?php 
    $count = 1;
    $obj_ticket->getTicket($_SESSION['ses_admin_id'],$_SESSION['unique']);
    while($row = $obj_ticket->next_record()){
    ?>
    
    <tr>
      <td>
      <select name="ticket_num" id="ticket_num<?php echo $count;?>" onchange="tkt_num(<?php echo $count;?>,<?php echo $obj_ticket->f('cart_id');?>);">
        <?php for($i=0;$i<=$obj_ticket->f('ticket_num');$i++) {?>
            <option value="<?php echo $i;?>" <?php if($i == $obj_ticket->f('ticket')){ echo "selected";}?>><?php echo $i;?></option>
        <?php } ?>
      </select>
      <?php //echo $obj_ticket->f('ticket');?></td>
      <td>
      <?php
      if($_SESSION['langSessId']=='eng') {
        echo $obj_ticket->f('ticket_name_en');
      }
      elseif($_SESSION['langSessId']=='spn')
      {
        echo $obj_ticket->f('ticket_name_sp');
      }
      ?>
      </td>
      <td><?php 
      if($_SESSION['pay'] == 'us'){
        echo $obj_ticket->f('us_price');
      }elseif($_SESSION['pay'] == 'mx'){
        echo $obj_ticket->f('mx_price');
      }
      ?></td>
      <td></td>
      <td><?php 
      if($_SESSION['pay'] == 'us'){
        echo $obj_ticket->f('ticket')*$obj_ticket->f('us_price');
      }elseif($_SESSION['pay'] == 'mx'){
        echo $obj_ticket->f('ticket')*$obj_ticket->f('mx_price');
      }
      ?></td>
      <td><a href="<?php echo $obj_base_path->base_path()."/payment.php?action=del&tid=".$obj_ticket->f('cart_id'); ?>">Remove</a></td>
    </tr>
    
    <?php
        $count++;
    }
    ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><strong>Total : <?php $obj_total->totalTicket($_SESSION['ses_admin_id'],$_SESSION['unique']); $obj_total->next_record(); //echo $obj_total->f('Total');?></strong>
      <input type="hidden" name="ticket" value="<?php echo $obj_total->f('Total');?>" />
      </td>
      <td><strong>Total : <?php $obj_total->totalAmount($_SESSION['ses_admin_id'],$_SESSION['pay'],$_SESSION['unique']); $obj_total->next_record(); echo $obj_total->f('Amt');?></strong></td>
      <td><?php if($_SESSION['pay'] == 'us'){ echo "US$";}elseif($_SESSION['pay'] == 'mx'){echo "MX Pesos";}?></td>
    </tr>
    <tr>
        <td colspan="6" style="text-align:right;"><input type="submit" value="Checkout" /></td>
    </tr>
  </table>		  
</form>