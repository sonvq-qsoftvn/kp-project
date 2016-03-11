<?php

require_once 'vendor/autoload.php';

/* 
 * Example status
 */
//$status = [
//    'link' => 'http://kpasapp.com',
//    'message' => 'Visit kpasapp, Eventos Baja California Sur',
//];

class facebookStatus {

    // Kpasapp facebook app
    protected $_appID = "445192265673724";
    protected $_appSecret = "41f5bccae260641bce323da48eb35776";
    // For bcs.kpasapp
    protected $_accessToken = "CAAGU5mbaKZCwBAOk1UZBW6ZA2M4OwnwZCYCZCJUBfpFZBS5h5TXezOyL22pGLPircEyWiZBjYaQ7PiduPa38doAON7mzZBf6OqA2wnQ8fKhZAVKNEkB9TFOx3aRD5jgCd9omZABSaFDqBCg03WPwzQlCZAbmTUu6xMBEILhZC5N0agxdb5qQdR8EZA5C3";
    
    
    // marcel.lavabre app
    protected $_appID1 = "1664330993816127";
    protected $_appSecret1 = "f99894c47ff01a126db80d82e5757828";        
    // For marcel.lavabre
    protected $_accessToken1 = "CAAXps0Gs0j8BALJQDwPgqVGkGZBABl0nSxLLcAs1gwMEi0lgllZBqsmZCeQxH2ZCPoxFx5lgP1k0diXwYYK5HBidwC8VLupCedolFMWuHzkiLnnZA17xyvtZBNjrRBpQkGUg3fmvF1lfGf7GufKgOEeFUax29yh4NSuPjD47WAAQmQhiCvdUuDkqlST8QWrHQZD";
    
    // For master.kpasapp
    protected $_pageAccessToken = "CAAGU5mbaKZCwBAFodtvVM2v16wKKoqitlPd1LBPI9A6b95RRbiKZC69ex8ZCWOEEHjzG3mbvORNe2CNlpzZAblSem5VQsyz7sEZAInMupByvEfNjcnNlEDgVTfZBT2g6pgllRAAzhc8bd88qxfTInCQWUvR6rTWJ6QLppoyoAoHDrEtLR3cHDT";
    
    // For EventsLosCabos
    protected $_pageAccessToken2 = "CAAGU5mbaKZCwBAAV0Emo0F7HXt85VBBRZAZAuZC0zDzKk6XVR6sCeG2YpLdu0ZApylJZCgSs68YJZB3aomc1jL1DscdEKJvqYDi29xZANNa1wVUt6GL5MXMaekvXSAmJC2h2Oittz0DeVR6qYx8kQAeUOUqpnP3xpG8gJLbwT3lB9kAJWTbH7z9j";

    // For Kpasappcom-Eventos-Los-Cabos-1570388476613467
    protected $_pageAccessToken3 = "CAAGU5mbaKZCwBADgy31LK9Hkoq1RQnKp3m9BiZA5G6zKAg2bw1W4KxwXLsKCuCZBr95aUvpYrwGDYWxRaBwmoc3Eg2M8hQY6jVdVbFDd8nNOPgRgy76DZCqLBSKrJ3TVr0ufwQ5fLQ40ehf41YUtCXLATI5Sdu5k9Y2ZC0EZCULBmSQFjmH85Y";
    
    protected $_defaultGraphVersion = "v2.5";
    
    public function postStatus($status) {
        $fb = new Facebook\Facebook([
            'app_id' => $this->_appID,
            'app_secret' => $this->_appSecret,
            'default_graph_version' => $this->_defaultGraphVersion,
        ]);
                
        $fb1 = new Facebook\Facebook([
            'app_id' => $this->_appID1,
            'app_secret' => $this->_appSecret1,
            'default_graph_version' => $this->_defaultGraphVersion,
        ]);

        try {
            // Post to https://www.facebook.com/bcs.kpasapp
            $response = $fb->post('/me/feed', $status, $this->_accessToken);
            
            // Post to https://www.facebook.com/master.kpasapp/
            $response2 = $fb->post('/633059556824338/feed', $status, $this->_pageAccessToken);
            
            // Post to https://www.facebook.com/groups/eventsbcs/
            $response3 = $fb->post('/723256584381647/feed', $status, $this->_accessToken);
            
            // Post to https://www.facebook.com/groups/1415807262056337/
            $response4 = $fb->post('/1415807262056337/feed', $status, $this->_accessToken);
            
            // Post to https://www.facebook.com/EventsLosCabos
            $response5 = $fb->post('/160581567659992/feed', $status, $this->_pageAccessToken2);                
                
            // Post to https://www.facebook.com/Kpasappcom-Eventos-Los-Cabos-1570388476613467
            $response6 = $fb->post('/1570388476613467/feed', $status, $this->_pageAccessToken3);
            
            // Post to https://www.facebook.com/marcel.lavabre
            $response7 = $fb1->post('/me/feed', $status, $this->_accessToken1);
            
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

    }

}