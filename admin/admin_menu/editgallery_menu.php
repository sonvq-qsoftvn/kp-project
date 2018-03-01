<?php
$allUrlSet = explode("/", $_SERVER['REQUEST_URI']);
$page_set = $allUrlSet[count($allUrlSet) - 2];
$event_id = $allUrlSet[count($allUrlSet) - 3];
?>
<div class="blue_boxr">
    <ul>
        <li><a href="<?php echo $obj_base_path->base_path(); ?>/admin/gallery-list/event/<?php echo $event_id ?>" <?php if ($page_set == "edit-gallery") { ?> class="here" <?php } ?>>
                <?= AD_LIST_SELECT ?>
            </a>
        </li>
        <li>
            <a href="#">
                <?= AD_PROMOTE ?>
            </a>
        </li>	   
    </ul>
</div>