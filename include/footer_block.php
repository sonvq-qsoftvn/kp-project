<?php 
$footer_block=new User;
$footer_block_pre=new User;
$obj=new User;
$page_name=basename($_SERVER['PHP_SELF']);

//showpage_content_by_page_link($page_id);
//echo $_REQUEST['p'];
$page_id=explode("-",$_REQUEST['p']);
$obj->showpage_content_by_page_link($page_id[0]);
 if($obj->num_rows() > 0){
$obj->next_record();
$_REQUEST['p']=$obj->f(page_id);
}

if($page_name=='content.php'){
$page_name=$page_name."?p=".$_REQUEST['p'];

}

//echo $page_name;
$footer_block_pre->list_pages_of_block($page_name,1);
if($footer_block_pre->num_rows() > 0){
	echo $footer_block->footer_image_list(); 
}

?>