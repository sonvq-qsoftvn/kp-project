<?php

require "autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class twitterStatus {
    
    // Kpasapp twitter
    protected $_consumerKey = "WYbfbjuX4eqW0qF2mJ2rIBmOm";
    protected $_consumerSecret = "aTmDvvqWbKktwZBBM2ECgvRdX2ZI4Q2aif6rnlCtv1M7NOzy1k";
    protected $_oauthToken = "1599232681-bzVoXe2IdU5lnJFlwqu11WqYfIkdCY39UWdsPQQ";
    protected $_oauthSecret = "bA3wFO7Ji15tE3bZ1LUn9epSvfPNVEA7ttlz6qggYAi6N";

    public function postStatus ($status) {
        try {
            $connection = new TwitterOAuth(
                    $this->_consumerKey, 
                    $this->_consumerSecret, 
                    $this->_oauthToken,
                    $this->_oauthSecret
            );
            $content = $connection->get('account/verify_credentials');
            $connection->post('statuses/update', array('status' => $status));
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}