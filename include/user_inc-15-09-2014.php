<?php
session_start();

include("class/db_mysql.inc");
include("class/user_class.php");
include("class/EasyGoogleMap.class.php");
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
/**----------get browser details-----------------*/
function browser(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browsers = array(
                        'Chrome' => array('Google Chrome','Chrome/(.*)\s'),
                        'MSIE' => array('Internet Explorer','MSIE\s([0-9\.]*)'),
                        'Firefox' => array('Firefox', 'Firefox/([0-9\.]*)'),
                        'Safari' => array('Safari', 'Version/([0-9\.]*)'),
                        'Opera' => array('Opera', 'Version/([0-9\.]*)')
                        ); 
                         
    $browser_details = array();
     
        foreach ($browsers as $browser => $browser_info){
            if (preg_match('@'.$browser.'@i', $user_agent)){
                $browser_details['name'] = $browser_info[0];
                    preg_match('@'.$browser_info[1].'@i', $user_agent, $version);
                $browser_details['version'] = $version[1];
                    break;
            } else {
                $browser_details['name'] = 'Unknown';
                $browser_details['version'] = 'Unknown';
            }
        }
     return $browser_details['name'];
    return 'Browser: '.$browser_details['name'].' Version: '.$browser_details['version'];
}
$res= browser();

 /**----------get browser details------move it to include file-----------*/
?>
<script type="text/javascript" src="<?php echo $obj_base_path->base_path(); ?>/js/jquery.js"></script>

<?php
$obj=new user;
$obj_cat=new user;

//echo "hh ".$_REQUEST['languageId']; 

############# Code For Language Change ###############
if($_REQUEST['languageId']!= "")
{
	$_SESSION['langSessId'] = $_REQUEST['languageId'];
	if($_SESSION['ses_admin_id'] == ''){
		$_SESSION['site_lang'] = $_REQUEST['languageId'];
	}
}
// ujjal : set session according to es or en url

if($_REQUEST['lang']!= "")
{
	if($_REQUEST['lang']=='es'){
		$_SESSION['langSessId']='spn';
		$_SESSION['set_lang'] = 'es';
		$_SESSION['site_lang'] = 'es';
		$_SESSION['langSessDir'] = "languages/spanish";
		
		
	}elseif($_REQUEST['lang']=='en'){
		$_SESSION['langSessId']='eng';
		$_SESSION['set_lang'] = 'en';
		$_SESSION['site_lang'] = 'en';
		$_SESSION['langSessDir'] = "languages/english";
		
	}
	
	
}

if($_SESSION['langSessId']=='')
{
	//echo 1;
?>	

<script language="javascript" type="text/javascript">
	
$(document).ready(function(){
	var browser='<?php echo $res?>';
	if (browser!='Unknown') {
		
	
			var language = window.navigator.userLanguage || window.navigator.language;
			
			    alert(language); 
			if(language=="es" || language=="es-MX" || language=="es_MX"){
				<?php	
				/*$_SESSION['langSessId'] = 'spn';
				$_SESSION['langSessDir'] = "languages/spanish";
				if($_SESSION['ses_admin_id'] == ''){
					$_SESSION['site_lang'] = $_REQUEST['languageId'];
				}*/
				?>
				$.ajax({
					url:"setsession.php?languageId=<?php echo $_REQUEST['lang']?>",  
					success:function(data) {
					   
					}
				     });
				
				$('#languageId').val("spn");
			}
			else{
				<?php	
				/*$_SESSION['langSessId'] = 'eng';
				$_SESSION['langSessDir'] = "languages/english";
				if($_SESSION['ses_admin_id'] == ''){
					$_SESSION['site_lang'] = $_REQUEST['languageId'];
				}
				*/
				?>
				$.ajax({
					url:"setsession.php?languageId=<?php echo $_REQUEST['lang']?>",  
					success:function(data) {
					   
					}
				     });
				$('#languageId').val("eng");
			}
			$('#frmlanguage').submit();
	}
})
</script>
<?php	
}	
else
{
	//echo 2;
	if($_REQUEST['languageId'])
	{
		$_SESSION['langSessId'] = $_REQUEST['languageId'];
		if($_SESSION['ses_admin_id'] == ''){
			$_SESSION['site_lang'] = $_REQUEST['languageId'];
		}
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
else		$page = "index.php";

if($_SESSION['langSessId'] == 'eng')
{
	include("languages/english.php");
	include($_SESSION['langSessDir']."/".$page);
}
else if($_SESSION['langSessId'] == 'spn')
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