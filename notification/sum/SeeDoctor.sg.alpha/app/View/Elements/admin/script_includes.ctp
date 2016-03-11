<?php
echo $this->Html->script('../admin/js/utopia');
echo $this->Html->script('../admin/js/jquery.hoverIntent.min');
echo $this->Html->script('../admin/js/jquery.easing.1.3');
echo $this->Html->script('../admin/js/jquery.datatable');
echo $this->Html->script('../admin/js/tables');
echo $this->Html->script('../admin/js/jquery.sparkline');
echo $this->Html->script('../admin/js/jquery.vticker-min');
echo $this->Html->script('../admin/js/angular');
echo $this->Html->script('../admin/js/upload/load-image.min');
echo $this->Html->script('../admin/js/upload/image-gallery.min');
echo $this->Html->script('../admin/js/jquery.simpleWeather');
echo $this->Html->script('../admin/js/bootstrap-datepicker');
//echo $this->Html->script('../admin/js/jquery.validationEngine');
//echo $this->Html->script('../admin/js/jquery.validationEngine-en');
echo $this->Html->script('../admin/js/maskedinput');
echo $this->Html->script('../admin/js/chosen.jquery');
//echo $this->Html->script('../admin/js/map');
//echo $this->Html->script('../admin/js/gmap3');
?>

<script type="text/javascript" src="<?php echo BASE_URL;?>/app/webroot/admin/js/header6654.js?v1"></script>
<?php
echo $this->Html->script('../admin/js/sidebar');
?>
<script type="text/javascript">

    $(function() {

        $( "#utopia-dashboard-datepicker" ).datepicker().css({marginBottom:'20px'});

        //jQuery("#validation").validationEngine();
        $("#phone").mask("(999) 9999999999");
        $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

        //$.simpleWeather({
        //    zipcode: '10001',
        //    unit: 'f',
        //    success: function(weather) {
        //        html = '<h2>'+weather.city+', '+weather.region+'</h2>';
        //        html += '<img style="float:left" width="125px " src="'+weather.image+'">';
        //        html += '<p>'+weather.temp+'&deg; '+weather.units.temp+'<br /><span>'+weather.currently+'</span></p>';
        //        html += '<a href="'+weather.link+'">View Forecast &raquo;</a>';
        //
        //        $("#utopia-dashboard-weather").css({marginBottom:'20px'}).html(html);
        //    },
        //    error: function(error) {
        //        $("#utopia-dashboard-weather").html('<p>'+error+'</p>');
        //    }
        //});


        /* maps with route directions */
        //$("#utopia-google-map-5").gmap3(
        //    { action:'getRoute',
        //        options:{
        //            origin:'48 Pirrama Road, Pyrmont NSW',
        //            destination:'Bondi Beach, NSW',
        //            travelMode:google.maps.DirectionsTravelMode.DRIVING
        //        },
        //        callback:function (results) {
        //            if (!results) return;
        //            $(this).gmap3(
        //                { action:'init',
        //                    zoom:13,
        //                    mapTypeId:google.maps.MapTypeId.ROADMAP,
        //                    streetViewControl:true,
        //                    center:[-33.879, 151.235]
        //                },
        //                { action:'addDirectionsRenderer',
        //                    options:{
        //                        preserveViewport:true,
        //                        draggable:false,
        //                        directions:results
        //                    }
        //                }
        //            );
        //        }
        //    }
        //);
        /* maps with route directions end */
        
    });

    
    $("#utopia-sparkline-type1").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9], {type:"line", height:48, width:140});

    $('.utopia-activity-feeds').vTicker({
        speed: 500,
        pause: 3000,
        animation: 'fade',
        height: 335,
        mousePause: true,
        showItems: 4
    });

    $(document).ready(function(){id='#<?php echo $left_sidebar_selected;?>';$(id).addClass("current");});
    
    //permanent delete confirmation function
    
    function do_confirm(url_sent)
    {
        if (confirm('All your related records will also be deleted and once deleted it can\'t be restored.Do you still want to delete?'))
        {
            window.location.href=url_sent;
        }
    }
    
    //trash confirmation function
    
    function do_trash(url_sent)
    {
        if (confirm('Confirm delete?'))
        {
            window.location.href=url_sent;
        }
    }
    
    //function for slidetoggle
    function maketoggle(id,imgid)
    {
        $('#'+id).fadeToggle(2000);
       
            imgvalue=$('#'+imgid).attr('imgvalue');
            if (imgvalue=='up')
            {
                $('#'+imgid).attr('imgvalue','down');
                $('#'+imgid).attr('src','<?php echo BASE_URL;?>app/webroot/admin/img/icons2/directional_down.png');
            }
            else if (imgvalue=='down')
            {
                $('#'+imgid).attr('imgvalue','up');
                $('#'+imgid).attr('src','<?php echo BASE_URL;?>app/webroot/admin/img/icons2/directional_up.png');
            }
        
    }
</script>
<script>
   // $(document).ready(function(){if($('#validation').length){$('#validation').validationEngine('hideAll');}});
</script>
