<?php 
	echo "hii"; exit;
	$expire=time()+60*60*24*30;
    setcookie('first_name1','amit',$expire);
	header("Location:".$obj_base_path->base_path()."/index.php");
?>
