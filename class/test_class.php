<?php 

class test extends DB_Sql 
{
    function getAllAds($limit, $short_by, $add_then_by, $whereClause){
        if ($short_by!="" && $add_then_by== "") {          
            $order_by = 'Order By '.$short_by.' ASC';
        } else if($short_by=="" && $add_then_by!= "" ) {          
            $order_by = 'Order By '.$add_then_by.' ASC';  
        } else if($short_by!="" && $add_then_by!= "") {
            $order_by = 'Order By '.$short_by.' , '.$add_then_by.' ASC'; 
        } else {          
            $order_by = 'Order By ka.ad_id ASC';             
        }
        $sql = "SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) join ".$this->prefix()."ad_clients as kc ON (ka.client_id=kc.client_id) WHERE kac.language_id='es' AND curdate() < duration $whereClause $order_by  $limit";

        return $this->query($sql);
    }

    function getAllAdsCount($whereClause){  
        $sql = "SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) join ".$this->prefix()."ad_clients as kc ON (ka.client_id=kc.client_id) WHERE kac.language_id='es' AND curdate() < duration $whereClause";

        return $this->query($sql);
    }

    function getAllexpiredAds($limit, $short_by, $add_then_by, $whereClause){    
        if ($short_by!="" && $add_then_by== "") {          
            $order_by = 'Order By '.$short_by.' ASC';
        } else if($short_by=="" && $add_then_by!= "" ) {          
            $order_by = 'Order By '.$add_then_by.' ASC';  
        } else if($short_by!="" && $add_then_by!= "") {
            $order_by = 'Order By '.$short_by.' , '.$add_then_by.' ASC'; 
        } else {          
            $order_by = 'Order By ka.ad_id ASC';             
        }

        $sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) join ".$this->prefix()."ad_clients as kc ON (ka.client_id=kc.client_id) WHERE kac.language_id='es' $whereClause $order_by $limit";
        return $this->query($sql);
    }

    function getAllexpiredCount($whereClause){
        $sql="SELECT * FROM ".$this->prefix()."ad as ka join ".$this->prefix()."ad_content as kac ON (ka.ad_id=kac.ad_id) join ".$this->prefix()."ad_clients as kc ON (ka.client_id=kc.client_id) WHERE kac.language_id='es' $whereClause";
        return $this->query($sql);
    }
  
};

?>