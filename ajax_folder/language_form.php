<?php

############# Code For Language Change ###############
if($_REQUEST['languageId'] != "")
{
	$_SESSION['langSessId'] = $_REQUEST['languageId'];
}

if($_SESSION['langSessId']=='')
{
	$_SESSION['langSessId'] = 'spn';
	$_SESSION['langSessDir'] = "languages/spanish";
}	
else
{
	if($_REQUEST['languageId'])
	{
		$_SESSION['langSessId'] = $_REQUEST['languageId'];
		if($_REQUEST['languageId']== 'eng')
			$_SESSION['langSessDir'] = "languages/english";
		else
			$_SESSION['langSessDir'] = "languages/spanish";
	}
}
$url = basename($_SERVER['PHP_SELF']);
/*$url = $_SERVER['REQUEST_URI'];
$url_arr = explode("/",$url);*/
if($url !="")	$page = $url;
else			$page = "index.php";

if($_SESSION['langSessId'] == 'eng')
{
	include("../include/languages/english.php");
	include($_SESSION['langSessDir']."/".$page);
}
else
{
	include("../include/languages/spanish.php");
	include($_SESSION['langSessDir']."/".$page);
}

?>