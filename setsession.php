<?php
session_start();
if($_REQUEST['languageId']=='es'){
$_SESSION['langSessId'] = 'spn';
		$_SESSION['langSessDir'] = "languages/spanish";
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
}elseif($_REQUEST['languageId']=='en'){
    
    $_SESSION['langSessId'] = 'eng';
		$_SESSION['langSessDir'] = "languages/english";
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
}
echo $_SESSION['site_lang'];
exit;
?>