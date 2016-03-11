<?php
session_start();

include("class/db_mysql.inc");
include("class/user_class.php");
include("class/pagination.class.php");
include("class/class.phpmailer.php");
//include("include/fpdf/fpdf.php");
//include("pdfb/pdfb.php");
//include("pdfb/pdfb.php");
include('include/pdf_barcode/Barcode.php');
require('include/pdf_barcode/alphapdf.php');
$obj_base_path = new DB_Sql;
//page name
$_SESSION['ses_page_name']=basename($_SERVER['PHP_SELF']);

?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<?php
$obj=new user;
$obj_cat=new user;

############# Code For Language Change ###############
if($_REQUEST['languageId']!= "")
{
	$_SESSION['langSessId'] = $_REQUEST['languageId'];
}

if($_SESSION['langSessId']=='')
{
?>	
<script>
$(document).ready(function(){
	
	var language = window.navigator.userLanguage || window.navigator.language;
	//alert(language); 
	if(language=="es"){
		<?php	
		$_SESSION['langSessId'] = 'spn';
		$_SESSION['langSessDir'] = "languages/spanish";
		?>
		$('#languageId').val("spn");
	}
	else{
		<?php	
		$_SESSION['langSessId'] = 'eng';
		$_SESSION['langSessDir'] = "languages/english";
		?>
		$('#languageId').val("eng");
	}
	$('#frmlanguage').submit();
})
</script>
<?php	
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
	include("languages/english.php");
	include($_SESSION['langSessDir']."/".$page);
}
else
{
	include("languages/spanish.php");
	include($_SESSION['langSessDir']."/".$page);
}
?>
<?php
if($_SESSION['ses_admin_id']!=""){
// Check if user has lang or not
$obj_check = new user;
$obj_check->getAdminById($_SESSION['ses_admin_id']);
$obj_check->next_record();

if($obj_check->f('language')==""){
?>

<script>
$(document).ready(function(){
	if($('#language').length){
		if($('#languageId').val()=="spn")
			$('#language').val("Spanish");
		else
			$('#language').val("English");
	}
});
</script>
<?php
}
}
?>