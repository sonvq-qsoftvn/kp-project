<?php
// create page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
	
$objmedia_es = new admin;
$objmedia_en = new admin;
$obj_media_update_es = new admin;
$obj_media_update_en = new admin;
$media_id = $_GET['media_id'];
$event_id = $_GET['event_id'];

$objgallerylist = new admin;
$objgallerylist_num = new admin;

$objgallerylist->allGalleryByIDNoLimit($event_id,$limit);
$objgallerylist_num->allGalleryByID_count($event_id);
$num = $objgallerylist_num->num_rows();

$arrayMediaId = [];
if ($num > 0) {
    while($row = $objgallerylist->next_record()) {
        $arrayMediaId[] = $objgallerylist->f('m_id');
    }
}


if ($arrayMediaId > 0) {
    $currentIndexOfMedia = array_search($media_id, $arrayMediaId);

    $previousIndex = $currentIndexOfMedia - 1;
    $nextIndex = $currentIndexOfMedia + 1;

    $previousMediaId = 0;
    $nextMediaId = 0;
    if (isset($arrayMediaId[$previousIndex])) {
        $previousMediaId = $arrayMediaId[$previousIndex];
    }
    
    if (isset($arrayMediaId[$nextIndex])) {
        $nextMediaId = $arrayMediaId[$nextIndex];
    }

	//var_dump($currentIndexOfMedia);
	//var_dump($arrayMediaId);
	//var_dump(count($arrayMediaId));

    
}

// -- Get All Details about this media --
$objmedia_es->allGalleryByMediaID_ES($media_id);
$objmedia_es->next_record();
$objmedia_en->allGalleryByMediaID_EN($media_id);
$objmedia_en->next_record();

if(isset($_REQUEST['submit_update']) || isset($_REQUEST['submit_and_previous']) || isset($_REQUEST['submit_and_next'])) {

    $event_id = $_POST['event_id'];
    $set_privacy=$_POST['set_privacy'];
    $media_name_es = addslashes($_POST['media_name_es']);
    $caption_es = addslashes($_POST['caption_es']);
    $alternate_text_es = addslashes($_POST['alternate_text_es']);
    $description_es  = addslashes($_POST['description_es']);
    $media_name_en = addslashes($_POST['media_name_en']);
    $caption_en = addslashes($_POST['caption_en']);
    $alternate_text_en = addslashes($_POST['alternate_text_en']);
    $description_en = addslashes($_POST['description_en']);
    $language_id_es = $_POST['language_id_es'];
    $language_id_en = $_POST['language_id_en'];
   	
    /*update the Spanish  description*/
    $obj_media_update_es->update_media_details($media_id,$language_id_es,$set_privacy,$media_name_es,$caption_es,$alternate_text_es,$description_es);
    /*update the English  description*/
    $obj_media_update_en->update_media_details($media_id,$language_id_en,$set_privacy,$media_name_en,$caption_en,$alternate_text_en,$description_en);
    
    if (isset($_REQUEST['submit_update'])) {
        header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
    } else if (isset($_REQUEST['submit_and_previous'])) {
        header("location:".$obj_base_path->base_path() . "/admin/event/" . $event_id . "/edit-gallery/" . $previousMediaId);
    } else if (isset($_REQUEST['submit_and_next'])) {
        header("location:".$obj_base_path->base_path() . "/admin/event/" . $event_id . "/edit-gallery/" . $nextMediaId);
    }
    $updated_msg="Media successfully saved."
?>
		
<?php } ?>
<?php
    function videoType($video_url) {
		if (strpos($video_url, 'youtube') > 0) {
		    return 'youtube';
		} elseif (strpos($video_url, 'vimeo') > 0) {
		    return 'vimeo';
		} elseif (strpos($video_url, 'dailymotion') > 0) {
		    return 'dailymotion';
		} else {
		    return 'image';
		}
	}
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kcpasa - Create gallery</title>

    <link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <!-- Ajax File Upload -->
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
    <!-- Ajax File Upload -->


    <script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>

    <script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
    <script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


    <!-- jQuery lightBox plugin -->
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

    <!--jquery tooltips -->
    <script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.tipsy.js" type="text/javascript"></script>
    <!--jquery tooltips -->

    <link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

    <?php include("../include/analyticstracking.php")?>
    <style>
        .lang_name {
            background: #FFFFFF;
            float: right;
            color: #FF0000;
            border: 1px solid #CCCCCC;
            margin: 8px 62px 0 0;
            padding: 2px;
            font: bold 22px/22px Arial, Helvetica, sans-serif;
            display: inline-block;
        }
        .lang_name_eng {
            background: #FFFFFF;
            color: #FF0000;
            border: 1px solid #CCCCCC;
            margin: 8px 0 10px 0px;
            padding: 2px;
            font: bold 22px/22px Arial, Helvetica, sans-serif;
            display: inline-block;
        }
    </style>
</head>

<body class="body1">
    <?php include("admin_header.php"); ?>
    <div id="maindiv">
        <div class="clear"></div>
        <div class="body_bg">
            <div class="clear"></div>
            <div class="container">
                <?php include("admin_header_menu.php");?>
                <div class="clear"></div>		
                <!--start body-->
                <div id="body">
                    <div class="body2"> 
                        <div class="clear"></div>
                        <div class="blue_box1">
                            <div class="blue_box10"><p><?= AD_EDIT_GALLERY ?></p></div>
                            <?php include("admin_menu/editgallery_menu.php");?>
                        </div> 
                        <div class="clear"></div>
                    </div>	
                </div>
             </div>
            <!---------------------put your div--here-------------------------------------------------- --> 
        
    
            <div class="myevent_box">
            <!----------------------------------------->        
                <div class="mediaimage">
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <form name="frm" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
                            <input type="hidden" name="media_id" value="<?php echo $objmedia_en->f('m_id')?>" id="media_id"/>
                            <input type="hidden" name="language_id_es" value="<?php echo $objmedia_es->f('language_id')?>" id="language_id_es"/>
                            <input type="hidden" name="language_id_en" value="<?php echo $objmedia_en->f('language_id')?>" id="language_id_en"/>
                            <tr>
                                <td colspan="3">
                                    <div align="center"><?php echo $updated_msg;?></div>
                                </td>
                            </tr>
                            <!---------image And url------------>
                            <tr>
                                <td colspan="2">
                                    <?php   
                                        $video_url=$objmedia_es->f('media_url');
                                        $var=videoType($video_url);
                                    ?>
                                    <?php if($objmedia_es->f('media_format')!="video") { ?>
                                        <img style="margin-bottom: 15px" src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $objmedia_es->f('media_url'); ?>" alt="" width="150" height="90" />
                                    <?php } else { ?>
                                        <?php  if($var=="youtube") { ?>
                                            <iframe width="150" height="90" src="//www.youtube.com/embed/<?php echo end(explode('=',$objmedia_es->f('media_url')));?>" frameborder="0" allowfullscreen></iframe>
                                        <?php } elseif($var=="vimeo") { ?>
                                            <iframe src="//player.vimeo.com/video/<?php echo  end(explode('/',$objmedia_es->f('media_url')));?>" width="150" height="90" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                        <?php } elseif($var=="dailymotion") {
                                            $dm_vid_arr=explode('_',end(explode('/',$objmedia_es->f('media_url'))));
                                            $dm_vid = $dm_vid_arr[0];
                                        ?>
                                            <iframe frameborder="0" width="150" height="90" src="//www.dailymotion.com/embed/video/<?php echo  $dm_vid;?>" allowfullscreen></iframe>
                                        <?php } ?>
                                    <?php }?>  
                                </td>
                                <td style="text-align: right">
                                     <?php if ($num > 1) : ?>
                                        <?php if ($currentIndexOfMedia > 0) : ?>
                                            <input style="margin-top: 40px" type="submit" name="submit_and_previous" value="<?= AD_PREVIOUS_BUTTON ?>" class="createbtn" />
                                        <?php endif; ?>
                                        <?php if ($currentIndexOfMedia != (count($arrayMediaId) - 1)) : ?>                                            
                                            <input style="margin-top: 40px" type="submit" name="submit_and_next" value="<?= AD_NEXT_BUTTON ?>" class="createbtn" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <a href="<?php echo $obj_base_path->base_path()."/admin/gallery-list/event/".$event_id ?>">
                                        <input type="button" name="" value="<?= AD_CANCEL ?>" class="createbtn" />
                                    </a>
                                    <input type="submit" name="submit_update" value="<?= AD_SAVE_EXIT ?>" class="createbtn" />                                    
                                </td>
                            </tr>
                            <!---------image And url------------>
                            <tr>
                                <td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_SET_PRIVACY ?> ::</td>
                                <td colspan="2">
                                    <input type="radio" name="set_privacy" id="set_privacy" value="0" <?php if($objmedia_es->f('set_privacy')=='0') echo "checked";?>> <?= AD_PUBLIC ?><br>
                                    <input type="radio" name="set_privacy" id="set_privacy" value="1"  <?php if($objmedia_es->f('set_privacy')=='1') echo "checked";?>> <?= AD_PRIVATE ?><br>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><span class="lang_name">SP</span></td>
                                <td style="position: relative">
                                    <div style="float: left;position: absolute;left: -50px;">
                                        <img src="https://www.kpasapp.com/images/globe1.jpg" alt="" width="38" height="38" border="0" />
                                    </div>
                                    <span class="lang_name_eng">EN</span>
                                </td>
                            </tr>
                            <tr>
                                <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_MEDIA_NAME ?> ::</td>
                                <td>
                                    <input type="text" name="media_name_es" id="media_name_es" value="<?php echo $objmedia_es->f('media_name')?>" size="52"/>
                                </td>
                                <td>
                                    <input type="text" name="media_name_en" id="media_name_en" value="<?php echo $objmedia_en->f('media_name')?>"  size="52"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_CAPTION ?> ::</td>
                                <td>
                                    <input type="text" name="caption_es" id="caption_es"  value="<?php echo $objmedia_es->f('caption')?>"  size="52"/>
                                </td>
                                <td>
                                    <input type="text" name="caption_en" id="caption_en"  value="<?php echo $objmedia_en->f('caption')?>"  size="52"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_ALTERNATIVE_TEXT ?> ::</td>
                                <td>
                                    <textarea style="width: 280px; height: 23px;" name="alternate_text_es" id="alternate_text_es"><?php echo $objmedia_es->f('alternative_text')?></textarea>
                                </td>
                                <td>
                                    <textarea style="width: 280px; height: 23px;"  name="alternate_text_en" id="alternate_text_en"><?php echo $objmedia_en->f('alternative_text')?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_DESCRIPTION ?> ::</td>
                                <td>
                                    <textarea style="width: 280px;" name="description_es" id="description_es" rows="10"><?php echo $objmedia_es->f('description')?></textarea>
                                </td>
                                <td>
                                    <textarea style="width: 280px;" name="description_en" id="description_en" rows="10"><?php echo $objmedia_en->f('description')?></textarea>
                                </td>
                            </tr>     
                        </form> 
                    </table>
                </div>
                <!----------------------------------------->
                <div class="clear"></div>
            </div>        
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <!------------------------end maindiv----------------------------------------------- -->
    <?php include("admin_footer.php"); ?>

    <script type="text/javascript">
        var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2" , {defaultTab:0});
    </script>
</body>
</html>
