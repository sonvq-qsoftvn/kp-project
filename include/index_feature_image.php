<!-----------FOR  FEATURE  IMAGE------------------>								
<?php  
    $objfeatureimage->isfeatureImage($eachVal['id']); 
    $objfeatureimage->next_record();
    $altImg = ($_SESSION['set_lang_index'] == 'es') ? stripslashes($eachVal['event_name_sp']) : stripslashes($eachVal['event_name_en']);
    if($objfeatureimage->num_rows()) : ?>
        <a href="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo htmlentities(stripslashes($objfeatureimage->f('media_url')));?>" class="feature">
            <img alt="<?php echo $altImg; ?>" itemprop="image" src="<?php echo $obj_base_path->base_path(); ?>/files/event/medium/<?php echo htmlentities(stripslashes($objfeatureimage->f('media_url')));?>"  border="0"  />
        </a>
    <?php else :
        $objEventTmp->getOrgEvent($eachVal['id']);
        $objEventTmp->next_record();
        if($objEventTmp->f('event_photo')) : ?>
            <a href="<?php echo $obj_base_path->base_path(); ?>/files/event/large/<?php echo $objEventTmp->f('event_photo');?>" class="feature">
                <img alt="<?php echo $altImg; ?>" itemprop="image" src="<?php echo $obj_base_path->base_path(); ?>/files/event/medium/<?php echo $objEventTmp->f('event_photo');?>"  border="0"  />
            </a>
        <?php endif;		
    endif; ?>
<!--------------FOR FEATURE IMAGE  END------------------------->
