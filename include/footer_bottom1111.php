<?php
$objright_bottom=new user;

if($_SESSION['langSessId']=="eng")
    {
    $lang_param_id =  "en";
    $objright_bottom->bottom_ad_image($lang_param_id); 
    }

elseif($_SESSION['langSessId']=="spn")
    {
    $lang_param_id = "es";
    $objright_bottom->bottom_ad_image($lang_param_id); 
    }
    
 /*----------is the  ulr has http or  not? checking---------------*/   
    function addhttp($url)
        {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url))
        {
        $url = "http://" . $url;
        }
        return $url;
        }
 /*----------is the  ulr has http or  not? checking---------------*/ 
?>
     <div class="left_panel addbox-left">
<?php while($rows= $objright_bottom->next_record())
{
?>
<div class="addbox-innerbox">
<div class="add10"><a href="#"><img src="<?php echo $obj_base_path->base_path(); ?>/files/event/advertisement/thumb/<?php echo $objright_bottom->f('ad_image_name') ?>" border="0"/></a></div>
<div class="addboxtext-right">
<h2><?php echo $objright_bottom->f('ad_title') ?></h2>
<div class="textadd-container"><?php echo $objright_bottom->f('ad_text') ?> </div>
<div class="botbutt-add"> <a target="_blank" href="<?php echo addhttp($objright_bottom->f('link_url')) ?>"><?php echo $objright_bottom->f('call_to_action') ?></a></div>
</div>
</div>	
<?php } ?>
</div>