<?php 
class test extends DB_Sql 
{

function getAllAds($limit,$short_by,$add_then_by,$whereClause){
//echo '<br><br>'.'$limit='.$limit.'$short_by='.$short_by.'$add_then_by='.$add_then_by.'<br><br>';
    
      if($short_by!="" && $add_then_by== ""){
          
         $order_by = 'Order By '.$short_by.' ASC';
          
          
      }else if($short_by=="" && $add_then_by!= "" ){
          
           $order_by = 'Order By '.$add_then_by.' ASC';
          
          
      }else if($short_by!="" && $add_then_by!= "")
      {

          $order_by = 'Order By '.$short_by.' , '.$add_then_by.' ASC'; 

      }else{
          
          $order_by = 'Order By ka.ad_id ASC'; 
            
      }
    $sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) join ".$this->prefix()."ad_clients as kc ON (ka.client_id=kc.client_id)   WHERE kac.language_id='es' AND curdate() < duration $whereClause $order_by  $limit";
	
	//echo $sql;
	return $this->query($sql);
}

function getAllAdsCount(){
  
	$sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) WHERE kac.language_id='es' AND curdate() < duration Order By ka.ad_id DESC";
	//echo $sql;
	return $this->query($sql);
}

function getAllexpiredAds($limit){
    // $sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) WHERE kac.language_id='es' And curdate()>ka.duration ".$limit;
     $sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) WHERE kac.language_id='es' ".$limit;
	//echo $sql;
     return $this->query($sql);
}

function getAllexpiredCount(){
    
	//$sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) WHERE kac.language_id='es' And curdate()>duration";
	$sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) WHERE kac.language_id='es' ";
	//echo $sql;
	return $this->query($sql);
}
  
	

};

?>