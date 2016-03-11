<?php
// home page
include('../include/admin_inc.php');

//create object
$objlist=new admin;
$objlist_num=new admin;
$obj_ticket=new admin;
$obj_venue=new admin;
$obj_sale=new admin;
$obj_ticket=new admin;

//session value
$admin_id=$_SESSION['ses_user_id'];
$organization_id=$_SESSION['ses_organization_id'];
	
	
	//$back_20_days = mktime(0, 0, 0, 01, 05-20, 11);
		//echo date("m/d/y", $back_20_days); exit;
		//$obj_sale->total_sale_on_day($organization_id,'2012-01-06');
		//$obj_sale->num_rows();
		/*for($j=0;$j<14;$j++){
			$back_20_days = mktime(0, 0, 0, date("m"), date("d")-$j, date("y"));
			echo date("m/d/y", $back_20_days)."<br>";
		}*/
		
		
		//echo $line1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome to our site</title>
<link rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" type="text/css" media="all">
<link rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/css/style.css" type="text/css" media="all">

<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/cufon-replace.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_900.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_300.font.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/Avenir_500.font.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/chart/jquery.jqplot.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/examples.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/syntaxhighlighter/styles/shCoreDefault.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/syntaxhighlighter/styles/shThemejqPlot.min.css" />
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
<script class="include" type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/jquery.min.js"></script>
 <script class="include" type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/syntaxhighlighter/scripts/shCore.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- End Don't touch this! -->
<!-- Additional plugins go here -->
<script class="include" language="javascript" type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/plugins/jqplot.dateAxisRenderer.min.js"></script>
<!-- End additional plugins -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/chart/examples/example.min.js"></script>
<script class="code" type="text/javascript">
		$(document).ready(function(){
		
		<?php
		$line1='';
		$line2='';
		for($j=0;$j<14;$j++){
			$back_14_days = mktime(0, 0, 0, date("m"), date("d")-$j, date("y"));
			//$mq_date=date("m/d/y", $back_14_days);
			$date=date("Y-m-d", $back_14_days);
			//total sale per day
			$obj_sale->total_sale_on_day($organization_id,$date);
			$num=$obj_sale->num_rows();
			
			$line1.="['".$date." 12:00AM',".$num."]";
			if($j!=13)
			$line1.=', ';
			
			//total sale per day
			$obj_ticket->total_sale_Ticket_on_day($organization_id,$date);
			$num1=$obj_ticket->num_rows();
			
			$line2.="['".$date." 12:00AM',".$num1."]";
			if($j!=13)
			$line2.=', ';
			
		}		
		
		?>
		  var line1=[<?php echo $line1; ?>];
		   var line2=[<?php echo $line2; ?>];
		  var plot1 = $.jqplot('chart1', [line1,line2], {
			title:'Two Week Snapshot',
			axes:{
				xaxis:{
					renderer:$.jqplot.DateAxisRenderer,
					tickOptions:{formatString:'%b %e'}, 
				}
			},
			series:[{lineWidth:4, markerOptions:{style:'square'}}]
		  });
		});
</script>
<?php include("../include/analyticstracking.php")?><!---------For Google  Analytics--------->
</head>
<body>
<!--start maincontainer-->
	
	<div id="maincontainer">
	 <!--start head-->
	 <?php include("header.php")?>
		<!--start body-->
		<section id="body">
			<div class="body2"> 
			   <div class="clear"></div>
			   <?php include("top_menu.php");?>                  
                <?php include("sidebar.php");  ?>
				 <div id="coupon_admin" style="margin: 4px 8px 0 8px;">
			  <div class="custom_box">
              	<div class="step" style="margin: 10px 10px 0 0;">
					<div class="coupons">COMPLETE YOUR SETUP...</div>
				</div>
                 <div class="clear"></div>
				 <div class="custom_box2">
				 <div class="setup_box">
					<a href="<?php echo $obj_base_path->base_path(); ?>/admin/event"> <div class="setup_left">
				 <div><h1>Add your EVENT</h1></div>
				 <div><p>Setup your first event to go on sale</p></div>
				 </div></a>
				 <div class="setup_right"><img src="<?php echo $obj_base_path->base_path(); ?>/images/thick_mark.png" alt="" width="24" height="23"></div>
				 </div>
				 <div class="setup_box">
				<a href="<?php echo $obj_base_path->base_path(); ?>/admin/seller"> <div class="setup_left">
				 <div><h1>FILL OUT YOUR PROFILE</h1></div>
				 <div><p>We need a few more pieces of basic information</p></div>
				 </div> </a>
				 <div class="setup_right"><img src="<?php echo $obj_base_path->base_path(); ?>/images/circle.png" alt="" width="18" height="18"></div>
				 </div>
				 <div class="setup_box">
				 <a href="<?php echo $obj_base_path->base_path(); ?>/admin/payment-settings"><div class="setup_left">
				 <div><h1>GET PAID</h1></div>
				 <div><p>Tell us how much you'd like to be paid for your ticket sales</p></div>
				 </div> </a>
				 <div class="setup_right"><img src="<?php echo $obj_base_path->base_path(); ?>/images/circle.png" alt="" width="18" height="18"></div>
				 </div>
				 <div class="clear"></div>
			  </div>
			  </div>                                
             <div class="clear"></div>
			 <div id="coupon_admin" style="margin: 10px 0 10px 10px;">
			  <div class="custom_box">              	
                 <div class="clear"></div>
				 <div class="custom_box2">
				<div class="barcode_box">
			
           					 <div id="chart1" style="height:299px; width:681px;"></div>
			
              <div class="clear"></div>			  
			 </div>
			  <div class="clear"></div>
			  <div class="upcoming_box">
			  <div class="textupcoming">UPCOMING EVENTS</div>
			  <div class="clear"></div>
			  <div>
			    <table align="center" width="672" border="0" cellspacing="0" cellpadding="0" class="upcoming_bg">
                  <tr>
                    <th>Event</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                  </tr>
                  <?php
							$items = 25;
							$page = 1;
									
							if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and $page = $_REQUEST['page'] and $page!=1)
							{
								$limit = " LIMIT ".(($page-1)*$items).",$items";
								$i = $items*($page-1)+1;
							}
							else
							{
								$limit = " LIMIT $items";
								$i = 1;
							}
								
							//event list
							$objlist->event_list_upcoming($organization_id,$limit);
							$objlist_num->event_list_upcoming_num($organization_id);
							$num = $objlist_num->num_rows();
							
							if($num>0)
							{				
								$p = new pagination;
								$p->Items($num);
								$p->limit($items);
								$p->target($target);
								$p->currentPage($page);
								$p->calculate();
				
								$p->changeClass("pagination");			
								while($row = $objlist->next_record())
								{
								//total sold ticket
								$obj_ticket->event_total_sold_ticket($objlist->f('event_id'));
								$obj_ticket->next_record();
								//get venue
								$obj_venue->getVenueById($objlist->f('venue'),$objlist->f('organization_id'));
								$obj_venue->next_record();
						?>
						<tr>          
						  <td ><a style="font-size:12px; font-weight:bold; color:#006988;" href="<?php echo $obj_base_path->base_path(); ?>/admin/event/<?php echo $objlist->f('event_id');?>"><?php echo $objlist->f('event_name');?></a></td>
						  <td > <?php echo date('D M j, Y \a\t g:i a',strtotime($objlist->f('event_date'))); ?></td>
						  <td ><?php echo $obj_venue->f('venue_name'); ?> (<?php echo $obj_venue->f('venue_city'); ?> <?php echo $obj_venue->f('venue_state'); ?>)</td>
						</tr>
						  
						  <?php
						  }
						  
						  
							}
							else
							{
						?>
						<tr><td colspan="3" align="center" style="padding-top:10px;">No Data Found</td></tr>
						<?php
							}
						?>
                </table>
				<div style="text-align:center"><?php if($num>0) $p->show();?></div>
                </div>
			  </div> 			
			  </div>
			  </div>                                
             <div class="clear"></div>
			 <div>              	
             <div class="clear"></div>
            </div>			 
            </div>			 
            </div>	
		 	</div>
          </section>		
		<!--end body-->	
		
	  <div class="clear"></div>
	</div>
<!--end maincontainer-->

<?php include("footer.php"); ?>
</body>
</html>
