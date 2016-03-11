<?php
include('include/user_inc.php');


// Script to test if the CURL extension is installed on this server

// Define function to test
function _is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

// Ouput text to user based on test
if (_is_curl_installed()) {
  echo "cURL is <span style=\"color:blue\">installed</span> on this server";
} else {
  echo "cURL is NOT <span style=\"color:red\">installed</span> on this server";
}



	$last_duration_date_time = strtotime('07/08/2014') + 30*(60*60*24);
        echo "LDD= ".$last_duration_date_time;
	$strto_time_from_duration_date = date('Y-m-d',$last_duration_date_time);
        echo "STFDD= ".$strto_time_from_duration_date;


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1" />
<title>Profile Setting</title>
<head>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<!-- jQuery lightBox plugin -->
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $obj_base_path->base_path(); ?>/include/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<link href="<?php echo $obj_base_path->base_path(); ?>/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/style99.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $obj_base_path->base_path(); ?>/css/header-frontend.css" rel="stylesheet" type="text/css" />

<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
<script type="text/javascript">
function sumi() {
    alert("hi!");
//var strMD5 = $.md5("Essence2");
var strVal="Essence2";
var strMD5 = $().crypt({

                method: "md5",

                source: strVal

            });

alertt(strMD5);
}
</script>
<script>
    function sumi1() {
    var hash = CryptoJS.MD5("123456");
    alert(hash);
    }
</script>

</head>
<form action="" name="f1">
    <input type="button" onclick="sumi1()" value="click" name="click">
</form>


