<?php if($obj_min_ticket_cost->f('price_us') == null && $obj_min_ticket_cost->f('price_mx') == null) : ?>
    <?php if($eachVal['all_access'] == 1) : ?>
        <p><?= TICKET_RESERVATION_REQUIRED ?></p>    
    <?php elseif ($eachVal['all_access'] == 0) : ?>
        <p><?= NO_TICKETS_AVAILABLE ?></p>
    <?php endif; ?>
<?php elseif ($obj_min_ticket_cost->f('price_us') == "0.00" && $obj_min_ticket_cost->f('price_mx') == "0.00") : ?>
    <p><?= TICKET_RESERVATION_REQUIRED ?></p>    
<?php else : ?>
    <p><?= TICKET_RESERVATION_FROM ?> 
        <?php if ($obj_min_ticket_cost->f('price_us') != "0.00" && $obj_min_ticket_cost->f('price_us') != null) : ?>
            <a target="_blank" href="<?php echo $eventURL ?>">US $<?php echo number_format($obj_min_ticket_cost->f('price_us'), 2); ?> </a>
        <?php endif; ?>
        <?php if ($obj_min_ticket_cost->f('price_us') != "0.00" && $obj_min_ticket_cost->f('price_us') != null
            && $obj_min_ticket_cost->f('price_mx') != "0.00" && $obj_min_ticket_cost->f('price_mx') != null) : ?>
            <?php echo ' / '; ?>
        <?php endif; ?>
        <?php if ($obj_min_ticket_cost->f('price_mx') != "0.00" && $obj_min_ticket_cost->f('price_mx') != null) : ?>
            <a target="_blank" href="<?php echo $eventURL; ?>">MXP <?php echo number_format($obj_min_ticket_cost->f('price_mx'), 2); ?></a>
        <?php endif; ?>
    </p>
<?php endif; ?>

<?php 
    $objEventById->getCategoryByEventId($eachVal['id']); 
    if ($objEventById->num_rows() > 0) {
        while($objEventById->next_record()){
			
            echo '<p>';
            if ($_SESSION['langSessId']=='eng') {
                echo ($objEventById->f('category_name'));
            } else {
                echo ($objEventById->f('category_name_sp'));
            }
            $objSubEventById->getSubCategoryByCategoryIdAndEventId($eachVal['id'], $objEventById->f('category_id'));
            
            if ($objSubEventById->num_rows()) {
                $count = 0;
                echo ' (';
                while($objSubEventById->next_record()){
                    if ($count > 0) {
                        echo ", ";
                    }
                    if ($_SESSION['langSessId']=='eng') {
                        echo $objSubEventById->f('category_name');
                    } else {
                        echo $objSubEventById->f('category_name_sp');

                    }
                    $count++;
                }    
                echo ')';
            }                        
            echo '</p>';
        } 
    }
    
?>