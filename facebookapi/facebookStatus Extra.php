<?php

require_once 'vendor/autoload.php';

/* 
 * Example status
 */
//$status = [
//    'link' => 'http://kpasapp.com',
//    'message' => 'Visit kpasapp, Eventos Baja California Sur',
//];

class facebookStatusExtra {

    // Kpasapp facebook app
    protected $_appID = "445192265673724";
    protected $_appSecret = "41f5bccae260641bce323da48eb35776";
    // For bcs.kpasapp
    protected $_accessToken = "CAAGU5mbaKZCwBABKdZAZApiopoH0UE4lOpvH7aBQRaLE2c4Bt6tNVsKYrpPZAQYskXRqurUkGirjpynonL2wSz2emXbn8nps0lLlNU2A6T7xUdrJBbkl3DvNJgW0YGhTM7Ee2NTI6jraSG4crlorxK1WB7h2PxZAZAwGLyviSkhCydzkcMqqDv4rRdEjW3vYgZD";
    
    
    // marcel.lavabre app
    protected $_appID1 = "1664330993816127";
    protected $_appSecret1 = "f99894c47ff01a126db80d82e5757828";        
    // For marcel.lavabre
    protected $_accessToken1 = "CAAXps0Gs0j8BALJQDwPgqVGkGZBABl0nSxLLcAs1gwMEi0lgllZBqsmZCeQxH2ZCPoxFx5lgP1k0diXwYYK5HBidwC8VLupCedolFMWuHzkiLnnZA17xyvtZBNjrRBpQkGUg3fmvF1lfGf7GufKgOEeFUax29yh4NSuPjD47WAAQmQhiCvdUuDkqlST8QWrHQZD";
    
    
    // For master.kpasapp
    protected $_pageAccessToken = "CAAGU5mbaKZCwBACzZBbbyHZB399cZBho5EFLUAsiur9HtAPyrJ5kZCQe6OWuIBVxTxZB5zZBv0RpP3ZCz6cxmMf1XzpLtuueHurXRqOTjTWfFc92VM6u36Kv6p1G2x4VgC56CIZCM9UzvkYTxJ0CxqbyrCovyhlzKa3e4pMPI8h3pQcN1cf8nKcOK";
    
    // For EventsLosCabos
    protected $_pageAccessToken2 = "CAAGU5mbaKZCwBAJeZAXvSMPBg5n5Rit7nZBhJFPffW3JtIk8fBb8eZApfI1USAo7g25wu8lU1ylx3OU7geB5Iv0sdE3o1chW9iGikfOrlD5HB61UABfr7SYZC438jTGjwOC5NHU7JgBHeUy0ZBDZC1b2onBsqCw1Tu2o8pExreDdlgWlnKbsKeH";

    // For Kpasappcom-Eventos-Los-Cabos-1570388476613467
    protected $_pageAccessToken3 = "CAAGU5mbaKZCwBAI42exr6ZA6o6rg1rZBFh2m0FKyDVgJ5WbcLbxZCPC23CuZAAdZBEIp95KdJGINwEIpWfmqdjTg7xoZAuV6cc9iWswT2XzUd1bh0UjKY0GJlvl1vqDWJiv7r4SpUMYZAmavHt1uut8PZA40sK4jMevt5MmvRTkNZCIy4umBnYKrjq";

    protected $_defaultGraphVersion = "v2.5";
    
    public function postStatus($status, $socialId) {
        $fb = new Facebook\Facebook([
            'app_id' => $this->_appID,
            'app_secret' => $this->_appSecret,
            'default_graph_version' => $this->_defaultGraphVersion,
        ]);
        

        try {
            if ($socialId == "51") {
                // Post to https://www.facebook.com/bcs.kpasapp
                $response = $fb->post('/me/feed', $status, $this->_accessToken);
                echo "Posted on https://www.facebook.com/bcs.kpasapp status: " . $status['message'];
            }
            
            if ($socialId == "50") {
                // Post to https://www.facebook.com/master.kpasapp/
                $response2 = $fb->post('/633059556824338/feed', $status, $this->_pageAccessToken);
                echo "Posted on https://www.facebook.com/master.kpasapp/ status: " . $status['message'];
            }
            
            if ($socialId == "53") {
                // Post to https://www.facebook.com/groups/eventsbcs/
                $response3 = $fb->post('/723256584381647/feed', $status, $this->_accessToken);
                echo "Posted on https://www.facebook.com/groups/eventsbcs/ status: " . $status['message'];
            }
            
            if ($socialId == "52") {
                // Post to https://www.facebook.com/groups/1415807262056337/
                $response4 = $fb->post('/1415807262056337/feed', $status, $this->_accessToken);
                echo "Posted on https://www.facebook.com/groups/1415807262056337/ status: " . $status['message'];
            }
            
            if ($socialId == "55") {
                // Post to https://www.facebook.com/EventsLosCabos
                $response5 = $fb->post('/160581567659992/feed', $status, $this->_pageAccessToken2);
                echo "Posted on https://www.facebook.com/EventsLosCabos status: " . $status['message'];
            }
            
            if ($socialId == "56") {
                // Post to https://www.facebook.com/Kpasappcom-Eventos-Los-Cabos-1570388476613467
                $response6 = $fb->post('/1570388476613467/feed', $status, $this->_pageAccessToken3);
                echo "Posted on https://www.facebook.com/Kpasappcom-Eventos-Los-Cabos-1570388476613467 status: " . $status['message'];
            }
            
            if ($socialId == "54") {
                $fb1 = new Facebook\Facebook([
                    'app_id' => $this->_appID1,
                    'app_secret' => $this->_appSecret1,
                    'default_graph_version' => $this->_defaultGraphVersion,
                ]);
                // Post to https://www.facebook.com/marcel.lavabre
                $response7 = $fb1->post('/me/feed', $status, $this->_accessToken1);
                echo "Posted on https://www.facebook.com/marcel.lavabre status: " . $status['message'];
            }
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }


    }

}