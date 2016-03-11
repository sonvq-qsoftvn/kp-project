<?php
//
// require("class/db_mysql.inc");
//	require("class/user_class.php");
//echo "helloww";
//	/*----------------------------------------------------------------------------*/
//		        $obj_cart_trans=new user;
//			$obj_cart_trans->getAll_cart_by_trns_id(319);
//                       // $num=$obj_cart_trans->num_rows();
//                       
//                        //echo $num;
////                        $ticket_fee_inc=$obj_cart_trans->f('ticket_fee_included');
////			echo "TFI".$ticket_fee_inc;
//                        $cnt=0;
//                        while($obj_cart_trans->next_record())
//                         {
//                          echo "ok";
//				$ticket_fee_inc=$obj_cart_trans->f('ticket_fee_included');
//				$promo_fee_inc=$obj_cart_trans->f('promo_fee_included');
//                                echo "tckt_fee_inc=".$ticket_fee_inc;
//                                echo "promo_fee_inc=".$promo_fee_inc;
//                                $payment_currency='USD';
//                                $sumticket=4;
//                            if($payment_currency=='USD')
//			         {
//                                  echo "check usd";
//					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us'));
//					 echo "fee_incl_amount=".$fee_incl_amount;
//                                         $fee_non_incl_amount = 0.00;
//                                         echo "fee_non_incl_amount=".$fee_non_incl_amount;
//					}
//					elseif($ticket_fee_inc== 1 && $promo_fee_inc == 0)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_us'));
//                                          echo "fee_incl_amount3= ".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('promo_fee_us'));
//                                          echo "fee_non_incl_amount4=".$fee_non_incl_amount;
//					}
//					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 1)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('promo_fee_us'));
//                                          echo "fee_incl_amount=".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_us'));
//                                          echo "fee_non_incl_amount=".$fee_non_incl_amount;
//					}
//					elseif($ticket_fee_inc== 0 && $promo_fee_inc == 0)
//					{
//					  $fee_incl_amount = 0.00;
//                                          echo "fee_incl_amount7=".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_us')+$obj_cart_trans->f('promo_fee_us'));
//					  echo "fee_non_incl_amount8=".$fee_non_incl_amount;
//                                        }
//				
//			         }
//			    elseif($payment_currency=='MXN')
//			         {
//                                  echo "check";
//					if($ticket_fee_inc== 1 && $promo_fee_inc == 1)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx'));
//					   echo "fee_incl_amount1=".$fee_incl_amount;
//                                           $fee_non_incl_amount = 0.00;
//                                            echo "fee_non_incl_amount2=".$fee_non_incl_amount;
//					}
//					else if($ticket_fee_inc== 1 && $promo_fee_inc == 0)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_mx'));
//                                           echo "fee_incl_amount3= ".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('promo_fee_mx'));
//                                          echo "fee_non_incl_amount4=".$fee_non_incl_amount;
//					}
//					else if($ticket_fee_inc== 0 && $promo_fee_inc == 1)
//					{
//					  $fee_incl_amount = $sumticket*($obj_cart_trans->f('promo_fee_mx'));
//                                          echo "fee_incl_amount5=".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_mx'));
//                                          echo "fee_non_incl_amount6=".$fee_non_incl_amount;
//					}
//					else if($ticket_fee_inc== 0 && $promo_fee_inc == 0)
//					{
//					  $fee_incl_amount = 0.00;
//                                          echo "fee_incl_amount7=".$fee_incl_amount;
//					  $fee_non_incl_amount = $sumticket*($obj_cart_trans->f('ticket_fee_mx')+$obj_cart_trans->f('promo_fee_mx'));
//					  echo "fee_non_incl_amount8=".$fee_non_incl_amount;
//                                        }
//				
//			         }
//                                 echo "<=========================>";
//                                 $cnt++;
//                         }
//		/*---------------------------------------------------------------------------*/

?>



<!DOCTYPE html>
<html>
  <head>
    <title>Showing pixel and tile coordinates</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
      
    <?php
      $Address = urlencode("Malecon, Alvaro Obregon, La Paz, Baja California Sur");
      $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
      $xml = simplexml_load_file($request_url) or die("url not loading");
      $status = $xml->status;
      if ($status=="OK") {
          $Lat = $xml->result->geometry->location->lat;
          $Lon = $xml->result->geometry->location->lng;
          $LatLng = $Lat.",".$Lon;
      }
    ?>
 
      
var map;
var TILE_SIZE = 256;
var chicago = new google.maps.LatLng(<?php echo $LatLng;?>);

function bound(value, opt_min, opt_max) {
  if (opt_min != null) value = Math.max(value, opt_min);
  if (opt_max != null) value = Math.min(value, opt_max);
  return value;
}

function degreesToRadians(deg) {
  return deg * (Math.PI / 180);
}

function radiansToDegrees(rad) {
  return rad / (Math.PI / 180);
}

/** @constructor */
function MercatorProjection() {
  this.pixelOrigin_ = new google.maps.Point(TILE_SIZE / 2,
      TILE_SIZE / 2);
  this.pixelsPerLonDegree_ = TILE_SIZE / 360;
  this.pixelsPerLonRadian_ = TILE_SIZE / (2 * Math.PI);
}

MercatorProjection.prototype.fromLatLngToPoint = function(latLng,
    opt_point) {
  var me = this;
  var point = opt_point || new google.maps.Point(0, 0);
  var origin = me.pixelOrigin_;

  point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;

  // Truncating to 0.9999 effectively limits latitude to 89.189. This is
  // about a third of a tile past the edge of the world tile.
  var siny = bound(Math.sin(degreesToRadians(latLng.lat())), -0.9999,
      0.9999);
  point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) *
      -me.pixelsPerLonRadian_;
  return point;
};

MercatorProjection.prototype.fromPointToLatLng = function(point) {
  var me = this;
  var origin = me.pixelOrigin_;
  var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
  var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
  var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) -
      Math.PI / 2);
  return new google.maps.LatLng(lat, lng);
};

function createInfoWindowContent() {
  var numTiles = 1 << map.getZoom();
  var projection = new MercatorProjection();
  var worldCoordinate = projection.fromLatLngToPoint(chicago);
  var pixelCoordinate = new google.maps.Point(
      worldCoordinate.x * numTiles,
      worldCoordinate.y * numTiles);
  var tileCoordinate = new google.maps.Point(
      Math.floor(pixelCoordinate.x / TILE_SIZE),
      Math.floor(pixelCoordinate.y / TILE_SIZE));

  return "<?php echo urldecode($Address);?>";
}

function initialize() {
  var mapOptions = {
    zoom: 17,
    center: chicago
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var coordInfoWindow = new google.maps.InfoWindow();
  coordInfoWindow.setContent(createInfoWindowContent());
  coordInfoWindow.setPosition(chicago);
  coordInfoWindow.open(map);

  google.maps.event.addListener(map, 'zoom_changed', function() {
    coordInfoWindow.setContent(createInfoWindowContent());
    coordInfoWindow.open(map);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>