<a href='<?php echo BASE_URL;?>logout'><h3>LOG OUT</h3></a>
<h1>
    Welcome
<?php
if($this->Session->read('reid_user_login_type')=='fb')
{
    echo $this->Session->read('reid_user_name');

}
else
{
    echo $uname;

}
?>
 to seedoctor.sg
 </h1>