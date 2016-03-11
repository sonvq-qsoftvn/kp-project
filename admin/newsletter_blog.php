<?php
include('../include/admin_inc.php');

$_SESSION['error_generate'] = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($_POST['from_date'] > $_POST['to_date']) {
        $_SESSION['error_generate'] = 'Date from cannot be greater than date to';
    } else {
        $_SESSION['error_generate'] = "";
        if($_POST['generate_type'] == 'newsletter') {
            header('Location: ' . $obj_base_path->base_path() . '/admin/generate_newsletter.php?from_date=' . $_POST['from_date'] . '&to_date=' . $_POST['to_date'] . '&language=' . $_POST['generate_submit']);
        } else if ($_POST['generate_type'] == 'blog') {
            header('Location: '. $obj_base_path->base_path() . '/admin/generate_blog.php?from_date=' . $_POST['from_date'] . '&to_date=' . $_POST['to_date'] . '&language=' . $_POST['generate_submit']);
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Generate Newsletter/Blog</title>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/header.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/style_event.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/jquery1-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.js" type="text/javascript"></script>
    <link href="<?php echo $obj_base_path->base_path(); ?>/css/SpryAssets2/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/custom-form-elements.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.validate.js"></script>
    <script src="<?php echo $obj_base_path->base_path(); ?>/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <!-- jQuery lightBox plugin -->
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <!-- Ajax File Upload -->
    <script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/ajaxupload.3.5.js" ></script>
    <!-- Ajax File Upload -->
</head>

<body class="body1">

    <?php include("admin_header.php"); ?>

    <div id="maindiv">
        <div class="clear"></div>
        <div class="body_bg">
            <div class="clear"></div>
            <div class="container">
                <?php include("admin_header_menu.php"); ?> 
                <div id="body">
                    <div class="body2"> 
                        <div class="blue_box1">
                            <div class="blue_box11"><p>Newsletter / Blog Generation</p></div>
                        </div> 
                    </div>	
                </div>
            </div>
            <div class="container">
                <div class="left_panel bg" style="width:978px;">
                    <div class="cheese_box">

                        <div class="clear"></div>
                        <div style="width: 976px; float: none; margin: 0 auto;">	
                            <div class="Tchai_box1" style="">

                                <div class="clear"></div>

                                <form action="" method="post" class="basic-grey" id="generate-form" novalidate>
                                    <h1>Content generation module
                                        <span>Please select content type, date range and language for content generation</span>
                                    </h1>
                                    <?php if (isset($_SESSION['error_generate'])) : ?>
                                        <label class="error"><?php echo $_SESSION['error_generate']; ?></label>
                                    <?php endif; ?>
                                    <label>
                                        <span>Type :</span>
                                        <div class="radio-custom">
                                            <input type="radio" value="newsletter" name="generate_type" id="radio1" class="radio" checked/>
                                            <label class="radio-label-btn" for="radio1">Newsletter</label>
                                        </div>
                                        <div class="radio-custom">
                                            <input type="radio" name="generate_type" value="blog" id="radio2" class="radio"/>
                                            <label class="radio-label-btn" for="radio2">Blog</label>
                                        </div>
                                        
                                    </label>
                                    <div class="clear"></div>
                                    <label>
                                        <span>Date From :</span>
                                        <input id="from_date" type="text" name="from_date" placeholder="Start Date" required />
                                    </label>

                                    <label>
                                        <span>Date To :</span>
                                        <input id="to_date" type="text" name="to_date" placeholder="End Date" required />
                                    </label>  
                                    <label class="submit-button">
                                        <input type="submit" class="button button-red" name="generate_submit" value="English" /> 
                                    </label>    
                                    <label class="submit-button">
                                        <input type="submit" class="button button-purple" name="generate_submit" value="Espanol" /> 
                                    </label>    
                                    <div class="clear"></div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
<?php include("admin_footer.php"); ?>
    
<script>
    $(document).ready(function() {
        var today = new Date();
        var jumbDay = (7 - today.getDay()) + 7;        
        
        $('#from_date').datepicker({            
            dateFormat: 'dd/mm/yy'
        });
        $("#from_date").datepicker().datepicker("setDate", new Date());
        
        $('#to_date').datepicker({            
            dateFormat: 'dd/mm/yy',
            defaultDate: new Date(today.getFullYear(),today.getMonth(),today.getDate() + jumbDay)
        });

        $("#to_date").datepicker().datepicker("setDate", new Date(today.getFullYear(),today.getMonth(),today.getDate() + jumbDay));
        
        $("#generate-form").validate();
    });
</script>


</body>

</html>
