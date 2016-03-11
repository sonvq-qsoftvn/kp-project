<?php
$allUrlSet = explode("/", $_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet) - 1];
//echo $page_set;
?>
<div class="blue_boxr">
    <ul>
        <li>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/events" <?php if ($page_set == "events" || basename($_SERVER['PHP_SELF']) == "edit_event.php") { ?> class="here" <?php } ?>>
                <?= AD_CREATE ?>/<?= AD_EDIT ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-list" <?php if ($page_set == "event-list") { ?> class="here" <?php } ?>>
                <?= AD_LIST ?>/<?= AD_SELECT ?>
            </a>
        </li>
        <?php if (basename($_SERVER['PHP_SELF']) == "edit_event.php") { ?>
            <li>
                <a href="<?php echo $obj_base_path->base_path(); ?>/admin/add-promotion/event/<?php echo $page_set; ?>">
                    <?= AD_PROMOTE ?>
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="#">
                <?= AD_BOOKINGS ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/event-final-report">
                <?= AD_REPORTS ?>
            </a>
        </li>	
        <li>
            <a href="<?php echo $obj_base_path->base_path(); ?>/admin/export.php">
                <?= AD_EXPORT ?>
            </a>
        </li>						   
    </ul>
</div>