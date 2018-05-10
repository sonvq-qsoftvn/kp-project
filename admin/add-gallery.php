<?php
// create page
// -------- include file -------------
include('../include/admin_inc.php');
//creation of objects
$objlist = new admin;
$objmedia = new admin;
$objevent_media = new admin;
$obj_media_language = new admin;
$obj_media_gallery = new admin;
$objEventDetails = new admin;

$event_id_arr=explode('/',$_REQUEST['event_id']);
$event_id = $event_id_arr[1];

if(isset($_REQUEST['submit'])) /*save for media image*/
{
    $event_id = $_POST['event_id'];
    $media_id = $_POST['media_id'];
    $set_privacy = $_POST['set_privacy'];

    $media_name = addslashes($_POST['media_name']);
    $media_name_sp = addslashes($_POST['media_name_sp']);
    $caption = addslashes($_POST['caption']);
    $caption_sp = addslashes($_POST['caption_sp']);
    $alternate_text = addslashes($_POST['alternate_text']);
    $alternate_text_sp = addslashes($_POST['alternate_text_sp']);
    $description = addslashes($_POST['description']);
    $description_sp = addslashes($_POST['description_sp']);

    if (strpos($media_id, ',') !== false) {
        $media_id_arr = explode(',', $media_id);

        if(count($media_id_arr) > 0) {
            foreach ($media_id_arr as $singleId) {
                // add for en_US
                $obj_media_language->add_media_language($singleId,'en_US',$media_name,$caption,$alternate_text,$description);
                // add for es_MX
                $obj_media_language->add_media_language($singleId,'es_MX',$media_name_sp,$caption_sp,$alternate_text_sp,$description_sp);
            }
        }
    } else {
        // add for en_US
        $obj_media_language->add_media_language($media_id,'en_US',$media_name,$caption,$alternate_text,$description);
        // add for es_MX
        $obj_media_language->add_media_language($media_id,'es_MX',$media_name_sp,$caption_sp,$alternate_text_sp,$description_sp);
    }

    header("location:".$obj_base_path->base_path()."/admin/gallery-list/event/".$event_id);
}

if (isset($_REQUEST['submit_url'])) /* save for media url */ {
    $event_id = $_POST['event_id'];
    $media_id = $_POST['vid_media_id'];
    $url = $_POST['url'];
    $set_privacy = $_POST['set_privacy'];
    $media_name = addslashes($_POST['media_name']);
    $media_name_sp = addslashes($_POST['media_name_sp']);
    $caption = addslashes($_POST['caption']);
    $caption_sp = addslashes($_POST['caption_sp']);
    $alternate_text = addslashes($_POST['alternate_text']);
    $alternate_text_sp = addslashes($_POST['alternate_text_sp']);
    $description = addslashes($_POST['description']);
    $description_sp = addslashes($_POST['description_sp']);

    // Save for en_US
    $language = 'en_US';
    $obj_media_language->add_media_language($media_id, $language, $media_name, $caption, $alternate_text, $description);

    // Save for es_MX
    $language = 'es_MX';
    $obj_media_language->add_media_language($media_id, $language, $media_name_sp, $caption_sp, $alternate_text_sp, $description_sp);
    header("location:" . $obj_base_path->base_path() . "/admin/gallery-list/event/" . $event_id);
}

$admin = $_SESSION['ses_user_id'];
//$obj_media_gallery->allGalleryNotInEventPagination($event_id, $admin, 15, 0);
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
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajax_upload_multiple.js" ></script>
    <!-- Ajax File Upload -->

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

    <script language="javascript" type="text/javascript">
        var executed = false;
        $( document ).ready(function(){
            setTimeout(function(){
                $(window).scroll(function() {
                    if(($(window).scrollTop() + $(window).height() > $(document).height() - 300)
                        && ($('#type_gal').is(':checked'))){
                        callGetAjaxGallery();
                    }
                });
            }, 1000);
        });

        /**
         * Show loading indicator when calling ajax
         */
        $(document).ajaxSend(function(event, request, settings) {
            $('#loading-indicator').show();
        });

        $(document).ajaxComplete(function(event, request, settings) {
            $('#loading-indicator').hide();
        });

        function callGetAjaxGallery() {
            if (!executed) {
                executed = true;
                var offset = $('.gallery-container').attr('data-offset');
                var newOffset = parseInt(offset) + 15;
                console.log(offset);
                var data = "event_id=<?php echo $event_id; ?>&admin=<?php echo $admin; ?>&limit=15&offset="+offset;
                $.ajax({
                    url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax_get_gallery.php",
                    cache: false,
                    type: "POST",
                    data: data,
                    success: function(data){
                        executed = false;
                        $('.gallery-container').attr('data-offset', newOffset);
                        $(".gallery-container").append(data);
                    }
                });
            }
        }

        function allMediaCheck(source) {
            checkboxes = document.getElementsByName('gallery_media[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

    </script>

    <script language="javascript" type="text/javascript">
        function show_upload_media(resval) {
            var getvalue=resval;
            if(getvalue=='select_image')
            {
                $("#url").val("");
                //        $(".fromgallery").hide();
                //        $("#for_upload_url").hide();
                //        $("#for_upload_image").show();
                //        $("#radio_all").hide();

            }
            else
            {
                $('#gallery_photo').val("");
                $(".fromgallery").hide();
                $("#for_upload_image").hide();
                $("#for_upload_url").show();
                $("#radio_all").hide();
            }
        }
    </script>

    <script language="javascript" type="text/javascript">
        function ajaxSaveUploadMedia(event_id) {
            var gal_photo=$('#gallery_photo').val();
            var url_media=$("#url").val();
            if (gal_photo!="" || url_media!="") {
                $.ajax({
                    url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_image_submit_multiple.php",
                    cache: false,
                    type: "POST",
                    data: 'image_gallery='+gal_photo+'&url_media='+url_media+'&event_id='+event_id,
                    success: function(data){
                        //alert(data);
                        data = JSON.parse(data);
                        if(data['type'] == 'single') {
                            var response = data['data'];
                            var res = response.split("||");
                            if(res[0]!=""){
                                $("#for_upload_image").hide();
                                $("#for_upload_url").hide();
                                $("#media_id").val(res[0]);
                                $("#vid_media_id").val(res[0]);

                                $("#cancel_image_media").click(function(){
                                    //alert("hi");
                                    cancel_media(res[0]);
                                });
                                $("#cancel_url_media").click(function(){
                                    //alert("hi");
                                    cancel_media(res[0]);
                                });
                                //$("#url_image_show").val(res[1]);
                                //alert("again_res check"+res[2]);
                                if (res[2].trim()=="image") {
                                    //alert("image has");
                                    $(".mediaurl").hide();
                                    $(".mediaimage").show();
                                    $("#url_image_show").html('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/'+res[1]+'"/>');

                                } else {
                                    //alert("image not");
                                    $(".mediaimage").hide();
                                    $(".mediaurl").show();
                                    $("#url_video_show").html(res[1]);
                                }

                                $('#radio_all').css({'padding-left':0+'px'});
                                $("#radio_all").hide();
                            } else {
                                alert($('#something-went-wrong').html());
                            }
                        } else {
                            var response = data['data'];
                            var list_media_id = "";
                            var count = 0;
                            $("#url_image_show").html('');
                            $("#url_video_show").html('');
                            response.forEach(function(element) {
                                var res = element.split("||");
                                if(res[0]!=""){
                                    if(count == 0) {
                                        list_media_id = res[0];
                                    } else {
                                        list_media_id = list_media_id + ',' + res[0];
                                    }
                                    $("#for_upload_image").hide();
                                    $("#for_upload_url").hide();
                                    $("#media_id").val(list_media_id);
                                    $("#vid_media_id").val(list_media_id);

                                    $("#cancel_image_media").click(function(){
                                        cancel_media(list_media_id);
                                    });
                                    $("#cancel_url_media").click(function(){
                                        cancel_media(list_media_id);
                                    });
                                    if (res[2].trim()=="image") {
                                        $(".mediaurl").hide();
                                        $(".mediaimage").show();
                                        $("#url_image_show").append('<img style="border: 1px solid gray; margin: 0 10px 10px 0px" src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/'+res[1]+'"/>');
                                    } else {
                                        $(".mediaimage").hide();
                                        $(".mediaurl").show();
                                        $("#url_video_show").append(res[1] + "<br/>");
                                    }
                                    $('#radio_all').css({'padding-left':0+'px'});
                                    $("#radio_all").hide();
                                    count++;
                                } else {
                                    alert($('#something-went-wrong').html());
                                }
                            });

                        }

                    }
                });
            }
            else
            {
                alert($('#please-upload-image').html());
            }

        }
    </script>

    <script type="text/javascript">
        function next_lang() {
            var media_id=$("#media_id").val();
            var event_id=$("#eid_nl").val();
            var set_privacy=$("#set_privacy:checked").val();
            var language=$("#language").val();
            var media_name=$("#media_name").val();
            var caption=$("#caption").val();
            var alternate_text=$("#alternate_text").val();
            var description=$("#description").val();
            $.ajax({
                url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_media_for_next_language_multiple.php",
                cache: false,
                type: "POST",
                data: 'set_privacy='+set_privacy+'&language='+language+'&media_name='+media_name+'&caption='+caption+'&alternate_text='+alternate_text+'&description='+description+'&media_id='+media_id+'&event_id='+event_id,
                success: function(data){
                    var res = data.split("||");
                    var lang=res[1].trim();
                    if (data!="") // "1"."||".$set_privacy."||".$language;
                    {
                        //change the field value after next language  clicking
                        $("#set_privacy:checked").val(res[0]);
                        $("#language").val(lang);
                        $("#media_name").val("");
                        $("#caption").val("");
                        $("#alternate_text").val("");
                        $("#description").val("");
                        $("#nxt_but").hide();
                        $("#saveNdExit").show();
                    } else {
                        alert("not enter");
                    }
                }
            });
        }
    </script>


    <script type="text/javascript">
        $(function(){
            var btnUpload=$('#type_image');
            var mestatus=$('#mestatus2');
            var files=$('#files');
            new AjaxUpload(btnUpload, {
                action: '<?php echo $obj_base_path->base_path(); ?>/admin/uploadgalleryphoto.php',
                name: 'uploadfile',
                onSubmit: function(file, ext){
                    if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                        // extension is not allowed 
                        mestatus.text($('#format-allowed').html());
                        return false;
                    }
                    mestatus.html($('#file-being-uploaded').html());
                },
                onComplete: function(file, response){
                    //On completion clear the status
                    console.log(response)
                    response = JSON.parse(response);
                    console.log(response);

                    mestatus.text($('#photo-upload-success').html());
                    var list_image = response.join();
                    console.log(list_image);
                    $('#gallery_photo').val(list_image);

                    $('#imgshow').html('');
                    response.forEach(function(element) {

                        $('#imgshow').append('<img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/'+element+'" alt="" />');
                    });

                    $('#me1').html('');
                    $('#up_image_next').trigger('click');
                    //On completion clear the status
                }
            });

        });
    </script>
    <script language="javascript" type="text/javascript">
        function check_type(getval) {
            var type=getval;
            if (type=="select_gal") {
                $('#radio_all').css({'padding-left':135+'px'});
                $(".fromgallery").show();
                $(".mediaimage").hide();
                $(".mediaurl").hide();
                $("#for_upload_url").hide();
                $("#for_upload_image").hide();
                callGetAjaxGallery();
            }
        }
    </script>

    <!---cancel media Ajax------->
    <script type="text/javascript">
        function cancel_media(media_id){
            $.ajax({
                url: "<?php echo $obj_base_path->base_path(); ?>/admin/ajax/ajax_cancel_media.php",
                cache: false,
                type: "POST",
                data: 'media_id='+media_id,
                success: function(data){
                    window.location = '<?php echo $obj_base_path->base_path()?>/admin/gallery-list/event/<?php echo $event_id ?>'
                }
            });
        }
    </script>
    <!---cancel media Ajax end------->

    <style>
        #loading-indicator, #page-loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url(/images/ajax.gif) center center no-repeat rgba(0,0,0,.8);
            z-index: 999999;
        }
        .mediaurl {
            display: none;
        }
        .mediaimage {
            display: none;
        }
        .fromgallery {
            display: none;
        }
        #nxt_but {
            display: none;
        }
        #nxt_but_url {
            display: none;
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
        .lang_name {
            background: #FFFFFF;
            float: right;
            color: #FF0000;
            border: 1px solid #CCCCCC;
            margin: 8px 52px 0 0;
            padding: 2px;
            font: bold 22px/22px Arial, Helvetica, sans-serif;
            display: inline-block;
        }
    </style>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

    <?php include("../include/analyticstracking.php")?>

</head>

<body class="body1">
<div id="loading-indicator" style="display: none;"></div>
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
                        <div class="blue_box10"><p><?= AD_ADD_MEDIA ?></p></div>
                        <?php include("admin_menu/creategallery_menu.php");?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <!---------------------put your div--here-------------------------------------------------- -->
        <!------------------Event Details------------------------->
        <div>
            <?php $objEventDetails->event_details_byID($event_id);
            $objEventDetails->next_record();
            //event_name   Event_Start_DateTime   Event_Venue   Event_City
            echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city');
            ?>
        </div>
        <!------------------Event Details End------------------------->

        <div class="myevent_box" style="position:relative">
            <div id="radio_all" >
                <input type="radio" name="type" id="type_gal" value="from_gal"  onclick="check_type('select_gal')"> <?= AD_SELECT_FROM_YOUR_GALLERY ?> <br>
                <input type="radio" name="type" id="type_image" value="media_image"  onclick="show_upload_media('select_image')"> <?= AD_UPLOAD_NEW_MEDIA ?><br>
                <input type="radio" name="type" id="type_url" value="media_url"  onclick="show_upload_media('select_url')"> <?= AD_MEDIA_URL ?><br>
                <br/>
                <span id="mestatus2"></span>
            </div>

            <form name="frm" method="post" action="<?php echo $obj_base_path->base_path(); ?>/admin/process_gallery.php" enctype="multipart/form-data">
                <div class="fromgallery">
                    <input type="submit" name="check_submit" value="<?= AD_SAVE_EXIT ?>" class="createbtn" style="position: absolute; left: 0px; margin-top: 0px; top: 6px;" />
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
                        <tbody class="gallery-container" data-offset="15">
                        <tr>
                            <td><input type="checkbox" name="gal_media" id="checkAllMedia" onClick="allMediaCheck(this)" value="gal_media"></td>
                            <td></td>
                            <td width="80%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><strong><?= AD_FILE ?> </strong></td>
                            <td width="20%"><strong><?= AD_CREATION_DATE ?></strong></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </form><!-----------that is  for  form gallery--------------------->


            <!-----------that is  for image file upload--------------------->
            <div id="for_upload_image" style="display: none">
                <form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top">
                                <div class="event_ticket">
                                    <p><?= AD_UPLOAD_FILES ?></p>
                                    <ul style="margin-left: 10px;">
                                        <li>
                                            <a href="#" class="here">
                                                <?php if(!$_POST['gallery_photo']){ ?>

                                                    <div id="me1" class="styleall" style=" cursor:pointer; ">
                                                        <span style=" cursor:pointer; font-family:Verdana, Geneva, sans-serif; font-size:9px;"><span style=" cursor:pointer;"><?= AD_SELECT_FILE_FROM_YOUR_COMPUTER ?> </span></span>
                                                    </div>
                                                    <span id="mestatus1"></span>
                                                <?php } else { ?>
                                                    <img src="<?php echo $obj_base_path->base_path(); ?>/files/event/thumb/<?php echo $_POST['gallery_photo']; ?>" alt="" />
                                                <?php }  ?>
                                                <div class="clear"></div>
                                                <span id="imgshow"></span>
                                                <input type="hidden" name="gallery_photo" id="gallery_photo" value="<?php if($_POST['gallery_photo']){ echo $_POST['gallery_photo']; }?>" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="button" name="submit" value="<?= AD_NEXT_BUTTON ?> >>" class="createbtn" onclick="ajaxSaveUploadMedia(<?php echo $event_id;?>)" style="height: 28px; display: none;" id="up_image_next"></td>
                        </tr>
                    </table>
                </form>
            </div><!------first  time  show hide media  image--->

            <div class="mediaimage">
                <form name="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onSubmit="return check()" enctype="multipart/form-data">
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <input type="hidden" name="event_id" value="<?php echo $event_id;?>" id="eid_nl"/>
                        <input type="hidden" name="media_id" value="" id="media_id"/>
                        <tr>
                            <td colspan="2" >
                                <div id="url_image_show" style="margin-bottom: 15px"></div>
                            </td>
                            <td style="text-align: right">
                                <input type="button" name="cancel" id="cancel_image_media" value="<?= AD_CANCEL ?>" class="createbtn" />
                                <input type="submit" name="submit" value="<?= AD_SAVE_EXIT?>" class="createbtn" id="saveNdExit" />
                            </td>
                        </tr>
                        <tr>
                            <td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_SET_PRIVACY ?> ::</td>
                            <td colspan="2">
                                <input type="radio" name="set_privacy" id="set_privacy" value="0" > <?= AD_PUBLIC ?><br>
                                <input type="radio" name="set_privacy" id="set_privacy" value="1" checked="checked"> <?= AD_PRIVATE ?><br>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span class="lang_name">SP</span></td>
                            <td style="position: relative">
                                <div style="float: left;position: absolute;left: -45px;">
                                    <img src="https://www.kpasapp.com/images/globe1.jpg" alt="" width="38" height="38" border="0" />
                                </div>
                                <span class="lang_name_eng">EN</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_MEDIA_NAME ?> ::</td>
                            <td>
                                <input type="text" name="media_name_sp" id="media_name" size="52"
                                       value="<?php echo $objEventDetails->f('event_name_sp'); ?>" />
                            </td>
                            <td>
                                <input type="text" name="media_name" id="media_name" size="52"
                                       value="<?php echo $objEventDetails->f('event_name_en'); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_CAPTION ?> ::</td>
                            <td>
                                <input type="text" name="caption_sp" id="caption" size="52"/>
                            </td>
                            <td>
                                <input type="text" name="caption" id="caption" size="52"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_ALTERNATIVE_TEXT ?> ::</td>
                            <td>
                                <textarea name="alternate_text_sp" id="alternate_text" rows="2" cols="50"><?php echo $objEventDetails->f('event_name_sp').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name_sp').",".$objEventDetails->f('city'); ?></textarea>
                            </td>
                            <td>
                                <textarea name="alternate_text" id="alternate_text" rows="2" cols="50"><?php echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city'); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_DESCRIPTION ?> ::</td>
                            <td>
                                <textarea name="description_sp" id="description" rows="10" cols="50"><?php echo $objEventDetails->f('event_short_desc_sp'); ?></textarea>
                            </td>
                            <td>
                                <textarea name="description" id="description" rows="10" cols="50"><?php echo $objEventDetails->f('event_short_desc_en'); ?></textarea>
                            </td>
                        </tr>
                    </table>
                </form>
            </div><!-----------end of mediaimage-------------------->

            <!-----------that is  for media url--------------------->
            <div id="for_upload_url" style="display: none">
                <form name="frmurl" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_MEDIA_URL?> ::</td>
                            <td width="87%">
                                <textarea name="url" id="url" rows="5" cols="40"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="button" name="buttonsave" value="<?= AD_NEXT_BUTTON ?> >>" class="createbtn" onclick="ajaxSaveUploadMedia(<?php echo $event_id;?>)" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <!------first  time  show hide media  URL--->

            <!------for next language media  URL--->
            <div class="mediaurl">
                <form name="frmurl" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <table width="80%" border=0 align="center" cellpadding="0" cellspacing="0">
                        <input type="hidden" name="event_id" value="<?php echo $event_id;?>"/>
                        <input type="hidden" name="vid_media_id" value="" id="vid_media_id"/>
                        <tr class="media_url" >
                            <td>
                                <div id="url_video_show" style="margin-bottom: 10px"></div>
                            </td>
                            <td colspan="2" style="text-align: right">
                                <input type="button" name="cancel" id="cancel_url_media" value="<?= AD_CANCEL ?>" class="createbtn"  />
                                <input type="submit" name="submit_url" value="<?= AD_SAVE_EXIT ?>" class="createbtn"  id="saveNdExit_url" />
                            </td>
                        </tr>
                        <tr>
                            <td style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_SET_PRIVACY ?> ::</td>
                            <td colspan="2">
                                <input type="radio" name="set_privacy" id="set_privacy_url" value="0" > <?= AD_PUBLIC ?><br>
                                <input type="radio" name="set_privacy" id="set_privacy_url" value="1" checked="checked"> <?= AD_PRIVATE ?><br>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span class="lang_name">SP</span></td>
                            <td style="position: relative">
                                <div style="float: left;position: absolute;left: -45px;">
                                    <img src="https://www.kpasapp.com/images/globe1.jpg" alt="" width="38" height="38" border="0" />
                                </div>
                                <span class="lang_name_eng">EN</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_MEDIA_NAME ?> ::</td>
                            <td>
                                <input type="text"
                                       value="<?php echo $objEventDetails->f('event_name_sp'); ?>"
                                       name="media_name_sp" id="media_name_url"/>
                            </td>
                            <td>
                                <input type="text"
                                       value="<?php echo $objEventDetails->f('event_name_en'); ?>"
                                       name="media_name" id="media_name_url"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_CAPTION ?> ::</td>
                            <td>
                                <input type="text" name="caption_sp" id="caption_url" />
                            </td>
                            <td>
                                <input type="text" name="caption" id="caption_url" />
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_ALTERNATIVE_TEXT ?> ::</td>
                            <td>
                                <textarea name="alternate_text_sp" id="alternate_text_url" rows="2" cols="50"><?php echo $objEventDetails->f('event_name_sp').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name_sp').",".$objEventDetails->f('city'); ?></textarea>
                            </td>
                            <td>
                                <textarea name="alternate_text" id="alternate_text_url" rows="2" cols="50"><?php echo $objEventDetails->f('event_name_en').",".date("D",strtotime($objEventDetails->f('event_start_date_time')))." ".date("M",strtotime($objEventDetails->f('event_start_date_time')))." ".date("d",strtotime($objEventDetails->f('event_start_date_time')))." ".$objEventDetails->f('event_start_ampm').",".$objEventDetails->f('venue_name').",".$objEventDetails->f('city'); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="13%" style="font: normal 12px/18px Arial, Helvetica, sans-serif; padding: 0;"><?= AD_DESCRIPTION ?> ::</td>
                            <td>
                                <textarea name="description_sp" id="description_url" rows="10" cols="50"><?php echo $objEventDetails->f('event_short_desc_sp'); ?></textarea>
                            </td>
                            <td>
                                <textarea name="description" id="description_url" rows="10" cols="50"><?php echo $objEventDetails->f('event_short_desc_en'); ?></textarea>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <!------ END for next language media  URL--->
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<!------------------------end maindiv----------------------------------------------- -->
<?php include("admin_footer.php"); ?>


<div style="display: none">
    <p id="file-being-uploaded"><?= AD_YOUR_FILE_IS_BEING_UPLOADED ?></p>
    <p id="something-went-wrong"><?= AD_SOMETHING_WENT_WRONG ?></p>
    <p id="please-upload-image"><?= AD_PLEASE_UPLOAD_IMAGE ?></p>
    <p id="photo-upload-success"><?= AD_PHOTO_UPLOADED_SUCESSFULLY ?></p>
    <p id="format-allowed"><?= AD_PHOTO_FORMAT_ALLOWED ?></p>
</div>
</body>
</html>