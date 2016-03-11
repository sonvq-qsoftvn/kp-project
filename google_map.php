<?php
include("class/EasyGoogleMap.class.php");
//echo "hii"; exit;
//echo $_GET['add']; exit;
$setAddress					= $_GET['add'];
$infoWindowText             =  str_replace(",","<br>",$_GET['add']);


$gm = new EasyGoogleMap("");
$gm->SetMarkerIconStyle('PUSH_PIN');
$gm->SetMapZoom(17);
$gm->SetAddress($setAddress);
$gm->SetMapWidth('350');
$gm->SetMapHeight('350');
$gm->SetInfoWindowText($infoWindowText);
//$gm->SetSideClick($setSideClickText);
?>
<html>
<head>
<?php echo $gm->GmapsKey(); ?>
<style type="text/css">
body{margin:0px;padding:0px;font-family:Tahoma;font-size:11px;font-weight:normal;color:#505050;}
</style>
</head>
<body>
<?php echo $gm->MapHolder(); ?>
<?php echo $gm->InitJs(); ?>
<?php echo $gm->GetSideClick(); ?>
<?php echo $gm->UnloadMap(); ?>
</body>
</html>