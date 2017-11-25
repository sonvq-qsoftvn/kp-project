<?php if($_SESSION['langSessId']=='eng')
{
$footer_text = 'Use of KPasapp is subject to our <a href="'.$obj_base_path->base_path().'/en/terms-conditions-privacy-policy/"> Terms of Service </a>. Copyright Â© 2011 KPasapp , Inc. All Rights Reserved.';
 
	$url=$obj_base_path->base_path()."/en/terms-conditions-privacy-policy/";
	$contact_url=$obj_base_path->base_path()."/en/contact-us/";
}
elseif($_SESSION['langSessId']=='spn')
{
$footer_text = 'El uso de KPasapp est&aacute; sujeto a nuestras <a href="'.$obj_base_path->base_path().'/es/terminos-y-condiciones-pol-ticas-de-privacidad/"> Condiciones de uso </a>.  Copyright &copy; 2011 KPasapp, Inc. Todos los derechos reservados.';

	$url=$obj_base_path->base_path()."/es/terminos-y-condiciones-pol-ticas-de-privacidad/";
	$contact_url=$obj_base_path->base_path()."/es/contactenos/";

}
?>
<div id="footer_box">
    	<div class="footer_top">
        	<div class="link_box">
			<ul class="heading">
			<li><a href="<?php echo $url; ?>"><?php if($_SESSION['langSessId']=='eng'){ echo "Terms & Condition"; }else { echo htmlentities("TÃ©rminos y Condiciones");}?></a></li>
			</ul>
		</div>
		<div class="link_box">
			<ul class="heading">
			<li><a href="<?php echo $contact_url;?>"><?php if($_SESSION['langSessId']=='eng'){ echo "Contact Us"; }else { echo htmlentities("ContÃ¡ctenos");}?></a></li>
			</ul>
		</div>
            
            <div class="clear"></div>
         </div>
        <div class="footer_bot">
        	<div class="copyright"><?=$footer_text?></div>
            <div class="right_part">
            	<div class="leftimg"></div>
            	<div class="footer_map">
                	
                </div>
            </div>
        </div>
    </div>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '109787646434119');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=109787646434119&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
