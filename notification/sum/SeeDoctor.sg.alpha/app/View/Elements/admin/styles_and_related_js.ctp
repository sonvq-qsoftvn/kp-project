
    <?php
    echo $this->Html->css('../admin/css/fonts');
    echo $this->Html->css('../admin/css/utopia-white');
    echo $this->Html->css('../admin/css/utopia-responsive');
    echo $this->Html->css('../admin/css/datepicker');
    echo $this->Html->css('../admin/css/ui-lightness/jquery-ui');
    echo $this->Html->css('../admin/css/weather');
    echo $this->Html->css('../admin/css/gallery/modal');
    echo $this->Html->css('../admin/css/validationEngine.jquery');
    echo $this->Html->css('../admin/css/chosen');
    echo $this->Html->css('../admin/css/ie');
    echo $this->Html->css('../admin/css/multiselect');
    echo $this->Html->script('../admin/js/jquery.min');
    echo $this->Html->script('../admin/js/jquery.cookie');
    echo $this->Html->script('../admin/js/multiselect');
    ?>

    
    <script type="text/javascript">
	function reload()
	{
	    window.location.href=window.location;
	}
        
        $(document).ready(function() {
            $(".theme-changer a").live('click', function() {
                $('link[href*="utopia-white.css"]').attr("href",$(this).attr('rel'));
                $('link[href*="utopia-dark.css"]').attr("href",$(this).attr('rel'));
                $('link[href*="utopia-wooden.css"]').attr("href",$(this).attr('rel'));
                $.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
                $('.user-info').removeClass('user-active');
                $('.user-dropbox').hide();
            });
        });
    </script>

    <!--[if IE 8]>
    <?php
    echo $this->Html->css('../admin/css/ie8');
    ?>
   
    <![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <?php
    echo $this->Html->script('../admin/js/html5');
    ?>
    
    <![endif]-->

    <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {
           filter: none;
        }
      </style>
    <![endif]-->