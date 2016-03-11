<?php
include('include/user_inc.php');
$venue_id = $_REQUEST['venue_id'];

//create object

$obj_venue=new user;
$obj_ticket=new user;
$obj_ticket_img=new user;


// Venue Details
$obj_venue->venue_details_venueid($venue_id);
$obj_venue->next_record();


//print_r($_SESSION);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venue</title>
<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="<?php echo $obj_base_path->base_path(); ?>/js/slides.min.jquery.js"></script>

<style>
	.fancybox-title iframe {
    min-height: 30px;
    vertical-align: middle;
}

</style>

</head>
<body>
<a title="1st title" class="fancybox" href="http://fancyapps.com/fancybox/demo/1_b.jpg"><img src="http://fancyapps.com/fancybox/demo/1_s.jpg" alt=""/></a>

<a
title="2nd title" class="fancybox" href="http://fancyapps.com/fancybox/demo/2_b.jpg">
    <img src="http://fancyapps.com/fancybox/demo/2_s.jpg" alt="" />
    </a>
    
    <script type="text/javascript">
	$(".fancybox")
    .attr('rel', 'gallery')
    .fancybox({
    beforeShow: function () {
        if (this.title) {
            // New line
            this.title += '<br />';

            // Add tweet button
            this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';

            // Add FaceBook like button
            this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>';
        }
    },
    afterShow: function () {
        // Render tweet button
        twttr.widgets.load();
    },
    helpers: {
        title: {
            type: 'inside'
        }, //<-- add a comma to separate the following option
        buttons: {} //<-- add this for buttons
    },
    closeBtn: false, // you will use the buttons now
    arrows: false
});
</script>
    
    </body>
</html>