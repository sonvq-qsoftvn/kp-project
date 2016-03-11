 <?php
class Facebook
{

    /**
     * @var The page id to edit
     */
    private $page_id = '1439110063020924';
    /**
     * @var the page access token given to the application above
     */
    private $page_access_token = 'CAAHOt8fDZCKkBAOZC6ZB66uh8zoDbiGfsvwuRhZB8Os9qUZAkfzvvSBK8ZCxMARrINQzVJhBfY8VYDzGq9DBifZATwFuATSQ2YHIwbbw3Q6KHKPD4IUJ24lNOrGANrWZC7hvEkmU9daGZBVVw4W3st0bdmWwWI8EIQL5mQHa0j8lijoSZAT4S89RZACyOh7rL3RRvsZD';
    /**
     * @var The back-end service for page's wall
     */
    private $post_url = '';
    /**
     * Constructor, sets the url's
     */
    public function Facebook()
    {
        $this->post_url = 'https://graph.facebook.com/'.$this->page_id.'/feed';
    }

  public function renew_access()
  {
       $url = 'https://graph.facebook.com/oauth/access_token?client_id=CLIENT_ID&client_secret=CLIENT_SECRET&display=popup&code=_CODE_&redirect_uri=THIS_FILE_FULL_URL'; // THIS_FILE_FULL_URL = like http://site.com/fb.post.php

       // request this url to renew access token to send posts when offline. get the access_token and set self::$page_access_token = _ACCESS_TOKEN_ 

  }

  private function getcode()
  {
    $url = 'https://www.facebook.com/dialog/oauth?client_id=CLIENT_ID&redirect_uri=THIS_FILE_FULL_URL'; // THIS_FILE_FULL_URL = like http://site.com/fb.post.php

    // request this url to get _CODE_ to send posts when offline. then get the access_token and set self::$page_access_token = _ACCESS_TOKEN_ 

  }

  private function want_to_send()
  {
     // check for somethings if you want to send or you don't
    // for eg. check for time or any other check if sent before, or just return true to pass
      return true;
  }


    public function message($data)
    {
        // need token
        $data['access_token'] = $this->page_access_token;
        if(!$data['properties'])
        $data['properties'] = '{"TITLE":"DESC"}';
         try{
          if(self::want_to_send())
          {
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,$this->post_url);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
              curl_setopt($ch, CURLOPT_POST, true);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              curl_setopt($ch, CURLOPT_USERAGENT , 'facebook-php-3.1');
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
              $return = curl_exec($ch);
              curl_close ($ch);
           }

    }
    catch ( exception $e){
         //throw new Exception($e);
         // or
         error_log(json_encode($data));
      }

        //return $return; // if you want return
    }
}

$facebook = new Facebook();


 // make a simple post test
$facebook->message(array( 'message'  => 'The status header',
                          'link'        => 'http://cekirdek.com.tr',
                          'picture'  => 'http://domain.com/picture_url.png',
                          'name'        => 'Name of the picture, shown just above it',
                          'description' => 'Full description explaining whether the header or the picture' ) );
 ?>