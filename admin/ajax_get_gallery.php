<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../include/admin_inc.php');

$obj_media_gallery = new admin;

$obj_media_gallery->allGalleryNotInEventPagination($_POST['event_id'], $_POST['admin'], 15, $_POST['offset']);
?>		
  
<?php while($row = $obj_media_gallery->next_record()) {
    $arr_url=explode('=',$obj_media_gallery->f('media_url'));
    $video_url=$obj_media_gallery->f('media_url');
    $var=videoType($video_url);
?>
    <?php echo 'hiaha'; ?>
    <tr>
        <td><input type="checkbox" name="gallery_media[]" value="<?php echo $obj_media_gallery->f('m_id'); ?>"  id="gal_media"></td>
        <td>
            <?php if($obj_media_gallery->f('media_format')!="video") { ?>
                <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url'); ?>"/><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $obj_media_gallery->f('media_url'); ?>" alt="" />
            <?php } else { ?>
                <?php  if($var=="youtube") { ?>
                    <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>" /><iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$obj_media_gallery->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
                <?php } elseif($var=="vimeo") {  ?>
                    <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>"/><iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$obj_media_gallery->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <?php } elseif($var=="dailymotion") {  
                    $dm_vid_arr=explode('_',end(explode('/',$obj_media_gallery->f('media_url'))));
                    $dm_vid = $dm_vid_arr[0];
                ?>
                    <input type="hidden" name="media_url_all[]" value="<?php echo $obj_media_gallery->f('media_url');?>"/><iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
               <?php } ?>
            <?php } ?>
        </td>
        <td><input type="hidden" name="media_name[]" value="<?php echo $obj_media_gallery->f('media_name'); ?>"/><?php echo  $obj_media_gallery->f('media_name'); ?>&nbsp
        <input type="hidden" name="media_format[]" value="<?php echo $obj_media_gallery->f('media_format'); ?>"/><?php echo $obj_media_gallery->f('media_format'); ?></td>
        <td><?php echo $obj_media_gallery->f('upload_date'); ?></td>
        <input type="hidden" name="caption[]" value="<?php echo $obj_media_gallery->f('caption'); ?>"/>
        <input type="hidden" name="set_privacy_all[]" value="<?php echo $obj_media_gallery->f('set_privacy'); ?>"/>
        <input type="hidden" name="language_all[]" value="<?php echo $obj_media_gallery->f('language_id'); ?>"/>
        <input type="hidden" name="alternet_text_all[]" value="<?php echo $obj_media_gallery->f('alternative_text'); ?>"/>
        <input type="hidden" name="description_all[]" value="<?php echo $obj_media_gallery->f('description'); ?>"/>
    </tr>
    <tr>
       <td>&nbsp;</td>
    </tr>
<?php } ?>	  
		  
