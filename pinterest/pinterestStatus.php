<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "Pinterest.class.php";

class pinterestStatus {   

    public function postStatus ($status) {
        try {
            
            // Create the pinterest object and log in
            $p = new Pinterest();
            $p->login("vuquangson1610@gmail.com", "langtudeptrai");

            // Get the boards
            $p->get_boards();
            
            // Set up the pin
            $p->pin_url = $status['url'];;
            $p->pin_description = $status['description'];
            
            if (isset($status['image'])) {
               $p->pin_image_preview = $p->generate_image_preview($status['image']);    
            }            
            
            // Pin to the board called "kpasapp"
            $p->pin($p->boards['kpasapp']);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }        

}