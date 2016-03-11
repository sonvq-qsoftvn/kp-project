<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $title_for_layout;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $meta_description_content;?>">
    <meta name="author" content="Unified Infotech Pvt. Ltd.">

    <!-- styles -->
    <?php
	echo $this->Element('admin/styles_and_related_js');
    ?>

</head>

<body>

<div class="container-fluid">

    <!-- Header starts -->
    <div class="row-fluid">
        <div class="span12">

            <div class="header-top">

                <div class="header-wrapper">

                    <a href="<?php echo BASE_URL;?>administrator/dashboard" class="utopia-logo">
                    <?php
		    //echo $this->Html->image('../admin/img/utopia-logo.png',array('alt'=>'Utopia'));
		    ?><br/>
		    SeeDoctor.sg
                    </a>

                    <div class="header-right">

                        <div class="header-divider">&nbsp;</div>
			<?php
			    
			   
			    echo $this->Element('admin/top_dropdown_menu');
			?>
                    </div><!-- End header right -->

                </div><!-- End header wrapper -->

            </div><!-- End header -->

        </div>

    </div>

    <!-- Header ends -->

    <div class="row-fluid">
	<?php
        echo $this->Element('admin/left_sidebar');
	?>

        <!-- Body start -->
        <div class="span10 body-container">
