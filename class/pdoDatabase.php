<?php

class pdoDatabase {

    protected $_servername = "localhost";
    protected $_username = "kpasappc_kcpasa";
    protected $_password = "kcpasa!";
    protected $_dbname = "kpasappc_kcpasa";

    protected function connection() {
        try {
            $conn = new PDO("mysql:host=$this->_servername;dbname=$this->_dbname", $this->_username, $this->_password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
        return null;
    }

    public function insertAdsClient($business_name, $cont_f_name, $cont_l_name, $address, $city, $zip, $email, $tel, $cell) {
        
        $connection = $this->connection();
        
        if($connection != null) {
            // prepare sql and bind parameters
            $stmt = $connection->prepare("INSERT INTO kcp_ad_clients (business_name, Contact_first_name, Contact_last_name, address, city, zip, email, tel, cell) 
            VALUES (:business_name, :cont_f_name, :cont_l_name, :address, :city, :zip, :email, :tel, :cell)");
            $stmt->bindParam(':business_name', $business_name);
            $stmt->bindParam(':cont_f_name', $cont_f_name);
            $stmt->bindParam(':cont_l_name', $cont_l_name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':zip', $zip);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':cell', $cell);

            $stmt->execute();
            return true;
        }
        return false;
    }
    
    function updateClientInfo($business_name, $cont_f_name, $cont_l_name, $address, $city, $zip, $email, $tel, $cell, $client_id)
    {
        $connection = $this->connection();
        
        if($connection != null) {
            // prepare sql and bind parameters
            $stmt = $connection->prepare("UPDATE kcp_ad_clients 
            SET business_name = :business_name, Contact_first_name = :cont_f_name, Contact_last_name = :cont_l_name, address = :address, 
            city = :city, zip = :zip, email = :email, tel = :tel, cell = :cell
            WHERE client_id = :client_id");
            $stmt->bindParam(':business_name', $business_name);
            $stmt->bindParam(':cont_f_name', $cont_f_name);
            $stmt->bindParam(':cont_l_name', $cont_l_name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':zip', $zip);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':cell', $cell);
            $stmt->bindParam(':client_id', $client_id);

            $stmt->execute();
            return true;
        }
        return false;

    }

}
