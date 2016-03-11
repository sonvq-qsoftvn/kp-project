<?php
/**
 * Steve's Pinterest API for PHP
 *
 * copyright � 2015 Steve Havelka
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Pinterest {

    const SUCCESS = 0;
    const INVALID_LOGIN = -1;
    const NOT_LOGGED_IN = -2;
    const MISSING_PIN_URL = -10;
    const MISSING_PIN_DESCRIPTION = -11;
    const MISSING_PIN_IMAGE_PREVIEW = -12;
    const UNABLE_TO_PIN = -13;
    const BAD_REPIN_URL = -14;
    const REPIN_URL_NOT_FOUND = -15;
    const UNABLE_TO_REPIN = -16;
    const IMAGE_DOESNT_EXIST = -20;
    const UNABLE_TO_CREATE_IMAGE_PREVIEW = -21;
    const UNABLE_TO_GET_BOARDS = -30;
    const UNABLE_TO_GET_ACCOUNT_NAME = -31;
    const UNABLE_TO_DELETE = -40;

    /**
     * The path to the cookie file, set at object creation time.
     */
    protected $cookie_jar = "";

    /**
     * Our CSRF token, which we've gotten from our cookie jar
     */
    protected $csrf_token = "";

    /**
     * Are we logged in?
     */
    protected $is_logged_in = false;

    /**
     * Our pin URL
     */
    public $pin_url = "";

    /**
     * Our pin description
     */
    public $pin_description = "";

    /**
     * The pin image preview
     */
    public $pin_image_preview = "";


    /**
     * The pin board names and IDs
     */
    public $boards = array();


    /**
     * The pin ID of the last-pinned pin
     */
    public $last_pin_id = 0;



    /**
     * Create a Pinterest object.  Call with an argument to
     * define a cookie jar.  Otherwise, we'll use a temp file.
     */
    function __construct($cookie_path = null) {

        if( $cookie_path ) {

            // If the given cookie path exists, then let's assume
            // we're already logged in
            $this->cookie_jar = $cookie_path;
            if( file_exists($this->cookie_jar) ) {

                // Set up our logged-in state
                $this->csrf_token = Pinterest::get_csrf_token($this->cookie_jar);
                $this->is_logged_in = true;

                // And get the list of boards
                $this->get_boards();

            }

        } else
            $this->cookie_jar = tempnam(sys_get_temp_dir(), "cookies"); // good 

    }



    /**
     * This method logs you into Pinterest, using the
     * cookie store tied to this instance of the object.
     *
     * NOTES on login:
     *
     * The follow variables are joined with a &, urlencoded,
     * and posted to
     * https://www.pinterest.com/resource/UserSessionResource/create/
     *
     * source_url (string): /login/
     * data (JSON): {"options":{"username_or_email":"mylogin","password":"mypass"},"context":{}}
     * module_path (string): App()>LoginPage()>Login()>Button(class_name=primary, text=Log In, type=submit, size=large)
     *
     */
    private $login_url = "https://www.pinterest.com/resource/UserSessionResource/create/";

    function login($username, $password) {

        // Prepare the login data json
        $data_json = array(
            "options" => array(
                "username_or_email" => $username,
                "password" => $password
            ),
            "context" => array()
        );

        // And prepare the post data array
        $post = array(
            "source_url" => "/login/",
            "data" => json_encode($data_json, JSON_FORCE_OBJECT),
            "module_path" => "App()>LoginPage()>Login()>Button(class_name=primary, text=Log In, type=submit, size=large)"
        );

        // Now make the post string
        $post_arr = array();
        foreach( $post as $k => $v )
            $post_arr[] = "{$k}=" . urlencode($v);

        $post_string = join("&", $post_arr);

        // Fix up parens
        $post_string = Pinterest::fix_encoding($post_string);


        // Now set up the CURL call
        $ch = \curl_init($this->login_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEJAR => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "https://www.pinterest.com/login/",
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-CSRFToken: 1234',
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest',
                'Cookie: csrftoken=1234;'
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        \curl_close($ch);

        // If the result is json, we've succeeded!
        if( json_decode($res) === null ) {
            $this->is_logged_in = false;
            return Pinterest::INVALID_LOGIN;
        } else {
            $this->csrf_token = Pinterest::get_csrf_token($this->cookie_jar);
            $this->is_logged_in = true;
            $this->get_boards();
            return Pinterest::SUCCESS;
        }

    }





    /**
     * Get the board IDs for this Pinterest account.
     *
     * NOTES on getting board IDs:
     *
     * The follow variables are joined with a &, urlencoded,
     * and getted to
     * http://www.pinterest.com/resource/BoardPickerBoardsResource/get/
     *
     * source_url (string): /pin/create/bookmarklet/?url=http%3A%2F%2Fyellow5.com%2F
     * pinFave (numeric): 1
     * description (string): YELLOW+NUMPER+FIVE
     * data={"options":{"filter":"all","field_set_key":"board_picker"},"context":{}}
     * module_path=App()>PinBookmarklet()>PinCreate()>PinForm()>BoardPickerDropdownButton(view_type=compact, dropdown_options=[object Object], selected_index=0, disabled=false, color="", arrow=down, label_module=[object Object], use_dropdown2=true, selected_board_id=null, resource=BoardPickerBoardsResource(filter=all))
     * _ (timestamp): 1422584574944
     */
    private $get_boards_url = "https://www.pinterest.com/resource/BoardPickerBoardsResource/get/";

    public function get_boards() {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;


        // OK!  We're ready!  Prepare the board get JSON
        $data_json = array(
            "options" => array(
                "filter" => "all",
                "field_set_key" => "board_picker"
            ),
            "context" => array()
        );

        // And prepare the get data array
        $get = array(
            "source_url" => "/pin/create/bookmarklet/?url=",
            "pinFave" => "1",
            "description" => "",
            "data" => json_encode($data_json, JSON_FORCE_OBJECT)
        );

        // Now make the get string
        $get_arr = array();
        foreach( $get as $k => $v )
            $get_arr[] = "{$k}=" . urlencode($v);

        $get_string = join("&", $get_arr);

        // Fix up parens
        $get_string = Pinterest::fix_encoding($get_string);


        // Now set up the CURL call
        $ch = \curl_init($this->get_boards_url . "?{$get_string}");
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "https://www.pinterest.com/pin/create/bookmarklet/?url=&pinFave=1&description=",
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        $json = json_decode($res, TRUE);
                var_dump($json);die;
        \curl_close($ch);

        // If the result is json, we've succeeded!
        if( $json === null ) {
            return Pinterest::UNABLE_TO_GET_BOARDS;
        } else {

            // Ok, we got json--did we actually make an image preview?
            if( isset($json['resource_response']['data']['all_boards']) ) {

                // Pull out the board name and ID pair
                foreach( $json['resource_response']['data']['all_boards'] as $board )
                    $this->boards[$board['name']] = $board['id'];

                return Pinterest::SUCCESS;

            } else
                return Pinterest::UNABLE_TO_GET_BOARDS;

        }

    }






    /**
     * Get the logged-in account username
     */
    private $get_account_name_url = "https://www.pinterest.com/";
    public function get_account_name() {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;


        // Now set up the CURL call
        $ch = \curl_init($this->get_account_name_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "",
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        $json = json_decode($res, TRUE);
        \curl_close($ch);


        // If the result is json, we've succeeded!
        if( $json === null ) {
            return Pinterest::UNABLE_TO_GET;
        } else {

            // Ok, we got json--did we actually get the data we want?
            if( isset($json['resource_data_cache'][1]['resource']['options']['username']) )
                return $json['resource_data_cache'][1]['resource']['options']['username'];
            else
                return Pinterest::UNABLE_TO_GET_ACCOUNT_NAME;

        }

    }








    /**
     * Generate an image preview on Pinterest's AWS.
     *
     * NOTES on image preview:
     *
     * The follow variables are joined with a &, urlencoded,
     * and posted to
     * http://www.pinterest.com/resource/ImagePreviewResource/create/
     *
     * source_url (string): /pin/create/bookmarklet/?url=http%3A%2F%2Fyellow5.com%2Fpokey%2F
     * pinFave (numeric): 1
     * description (string): yellow5.com
     * data (JSON): {"options":{"content_type":"image/jpeg","base64_payload":"/9j/4A ... ALL BASE64-ENCODED DATA OF AN IMAGE ... xz8/vQB//2Q=="},"context":{}}
     *
     */
    private $image_preview_url = "https://www.pinterest.com/resource/ImagePreviewResource/create/";

    public function generate_image_preview($path) {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;

        // Need a pin URL and description, too
        if( !$this->pin_url )
            return Pinterest::MISSING_PIN_URL;

        if( !$this->pin_description )
            return Pinterest::MISSING_PIN_DESCRIPTION;

        // Can't make a preview if the image doesn't exist
        if( !$path )
            return Pinterest::IMAGE_DOESNT_EXIST;

        $image = file_get_contents($path);
        if( !$image )
            return Pinterest::IMAGE_DOESNT_EXIST;

        // Save the image
        $image_tmpfile = tempnam(sys_get_temp_dir(), "image");
        file_put_contents($image_tmpfile, $image);


        // OK!  We're ready!  Prepare the image preview JSON
		
		$fileExtension = $this->mime_type($path);
		
        $data_json = array(
            "options" => array(
                "content_type" => $fileExtension,
                "base64_payload" => base64_encode($image)
            ),
            "context" => array()
        );

        // And prepare the post data array
        $post = array(
            "source_url" => "/pin/create/bookmarklet/?url=" . urlencode($this->pin_url),
            "pinFave" => "1",
            "description" => urlencode($this->pin_description),
            "data" => json_encode($data_json, JSON_FORCE_OBJECT)
        );

        // Now make the post string
        $post_arr = array();
        foreach( $post as $k => $v )
            $post_arr[] = "{$k}=" . urlencode($v);

        $post_string = join("&", $post_arr);

        // Fix up parens
        $post_string = Pinterest::fix_encoding($post_string);


        // Now set up the CURL call
        $ch = \curl_init($this->image_preview_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "https://www.pinterest.com/pin/create/bookmarklet/?url=" . urlencode($this->pin_url) . "&pinFave=1&description=" . urlencode($this->pin_url),
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-CSRFToken: ' . $this->csrf_token,
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        $json = json_decode($res, TRUE);
        \curl_close($ch);

        // If the result is json, we've succeeded!
        if( $json === null ) {
            return Pinterest::UNABLE_TO_CREATE_IMAGE_PREVIEW;
        } else {

            // Ok, we got json--did we actually make an image preview?
            if( isset($json['resource_response']['data']['image_url']) )
                return $json['resource_response']['data']['image_url'];
            else
                return Pinterest::UNABLE_TO_CREATE_IMAGE_PREVIEW;

        }

    }




    /**
     * Submit the pin!
     *
     * NOTES on pinning:
     *
     * The follow variables are joined with a &, urlencoded,
     * and posted to
     * http://www.pinterest.com/resource/PinResource/create/
     *
     * source_url=/pin/create/bookmarklet/?url=http%3A%2F%2Fyellow5.com%2Fpokey%2F
     * pinFave=1
     * description=HOORAY
     * data={"options":{"board_id":"01234567890123456789","description":"HOORAY","link":"http://yellow5.com/pokey/","image_url":"https://s3.amazonaws.com/media.pinterest.com/previews/012345abcdef.jpeg","method":"bookmarklet","is_video":null},"context":{}}
     * module_path=App()>PinBookmarklet()>PinCreate()>PinForm(description=HOORAY, default_board_id=null, show_cancel_button=true, cancel_text=Close, link=http://yellow5.com/pokey/, show_uploader=false, image_url=https://s3.amazonaws.com/media.pinterest.com/previews/012345abcdef.jpeg, is_video=null, heading=Pick a board, pin_it_script_button=true)
     */
    private $create_pin_url = "https://www.pinterest.com/resource/PinResource/create/";

    public function pin($board_id) {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;

        // Need a pin URL and description, too
        if( !$this->pin_url )
            return Pinterest::MISSING_PIN_URL;

        // Is it a repin?
        if( Pinterest::is_repin_url($this->pin_url) )
            return $this->repin($board_id);
        else {

            // Not repinning?  We need description and image preview
            if( !$this->pin_image_preview )
                return Pinterest::MISSING_PIN_IMAGE_PREVIEW;
            if( !$this->pin_description )
                return Pinterest::MISSING_PIN_DESCRIPTION;

        }



        // OK!  We're ready!  Prepare the pin JSON
        $data_json = array(
            "options" => array(
                "board_id" => $board_id,
                "description" => $this->pin_description,
                "link" => $this->pin_url,
                "image_url" => $this->pin_image_preview,
                "method" => "bookmarklet",
                "is_video" => null
            ),
            "context" => array()
        );

        // Set up the "module path" data
        $module_path = "module_path=App()>PinBookmarklet()>PinCreate()>PinForm(description=, default_board_id=null, show_cancel_button=true, cancel_text=Close, link=, show_uploader=false, image_url=, is_video=null, heading=Pick a board, pin_it_script_button=true)";

        // And prepare the post data array
        $post = array(
            "source_url" => "/pin/create/bookmarklet/?url=" . urlencode($this->pin_url),
            "pinFave" => "1",
            "description" => urlencode($this->pin_description),
            "data" => json_encode($data_json, JSON_FORCE_OBJECT),
            "module_path" => urlencode($module_path)
        );

        // Now make the post string
        $post_arr = array();
        foreach( $post as $k => $v )
            $post_arr[] = "{$k}=" . urlencode($v);

        $post_string = join("&", $post_arr);

        // Fix up parens
        $post_string = Pinterest::fix_encoding($post_string);


        // Now set up the CURL call
        $ch = \curl_init($this->create_pin_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "https://www.pinterest.com/pin/create/bookmarklet/?url=&pinFave=1&description=",
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-CSRFToken: ' . $this->csrf_token,
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        \curl_close($ch);
        $json = json_decode($res, TRUE);

        // If the result is json, we've succeeded!
        if( $json === null ) {
            $this->last_pin_id = 0;
            return Pinterest::UNABLE_TO_PIN;
        } else {
            $this->last_pin_id = $json['resource_response']['data']['id'];
            return Pinterest::SUCCESS;
        }


    }






    /**
     * Repin an existing pin
     *
     * NOTES on repinning:
     *
     * The follow variables are joined with a &, urlencoded,
     * and posted to
     * http://www.pinterest.com/resource/RepinResource/create/
     *
     * source_url=/pin/33124503410/
     * data={"options":{"board_id":"2098031983153","description":"test","link":"http://example.com/","is_video":false,"pin_id":"314018941820"},"context":{}}
     * module_path=App()>Closeup(resource=PinResource(link_selection=true, fetch_visual_search_objects=true, id=))>PinActionBar(resource=PinResource(link_selection=true, fetch_visual_search_objects=true, id=))>ShowModalButton(module=PinCreate)#Modal(module=PinCreate(resource=PinResource(id=)))
     */
    private $repin_url = "https://www.pinterest.com/resource/RepinResource/create/";

    public function repin($board_id) {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;

        // Let's make sure the pin URL conforms to the pinterest URL format
        if( !preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $this->pin_url, $matches) )
            return Pinterest::BAD_REPIN_URL;

        // Get the original pin ID
        $pin_id = $matches[1];

        // And get the source URL and description
        $repin_source = file_get_contents(trim($this->pin_url));
        if( !$repin_source )
            return Pinterest::REPIN_URL_NOT_FOUND;

        // this is the source URL
        preg_match("<meta property=\"og:see_also\" name=\"og:see_also\" content=\"(.*?)\" data-app>", $repin_source, $matches);
        $pin_url = $matches[1];

        // this is the source URL
	if( $this->pin_description )
	  $pin_description = $this->pin_description;
	else {
	    preg_match("<meta property=\"og:description\" name=\"og:description\" content=\"(.*?)\" data-app>", $repin_source, $matches);
	    $pin_description = html_entity_decode($matches[1]);
	    $pin_description = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $pin_description);
	}


        // OK!  We're ready!  Prepare the pin JSON
        $data_json = array(
            "options" => array(
                "board_id" => $board_id,
                "description" => stripslashes($pin_description),
                "link" => stripslashes($pin_url),
                "is_video" => null,
                "pin_id" => $pin_id,
            ),
            "context" => array()
        );

        // Set up the "module path" data
        $module_path = "App()>Closeup(resource=PinResource(link_selection=true, fetch_visual_search_objects=true, id=))>PinActionBar(resource=PinResource(link_selection=true, fetch_visual_search_objects=true, id=))>ShowModalButton(module=PinCreate)#Modal(module=PinCreate(resource=PinResource(id=)))";

        // And prepare the post data array
        $post = array(
            "source_url" => "/pin/{$pin_id}/",
            "data" => json_encode($data_json, JSON_FORCE_OBJECT),
            "module_path" => urlencode($module_path)
        );

        // Now make the post string
        $post_arr = array();
        foreach( $post as $k => $v )
            $post_arr[] = "{$k}=" . urlencode($v);

        $post_string = join("&", $post_arr);

        // Fix up parens
        $post_string = Pinterest::fix_encoding($post_string);


        // Now set up the CURL call
        $ch = \curl_init($this->repin_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => $this->pin_url,
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-CSRFToken: ' . $this->csrf_token,
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        \curl_close($ch);
        $json = json_decode($res, TRUE);

        // If the result is json, we've succeeded!
        if( $json === null ) {
            $this->last_pin_id = 0;
            return Pinterest::UNABLE_TO_REPIN;
        } else {
            $this->last_pin_id = $json['resource_response']['data']['id'];
            return Pinterest::SUCCESS;
        }


    }








    /**
     * Delete a pin
     *
     * NOTES on deleting:
     *
     * The follow variables are joined with a &, urlencoded,
     * and posted to
     * http://www.pinterest.com/resource/PinResource/delete/
     *
     * source_url=/pin/3314398133410/
     * data={"options":{"id":"31098183153"},"context":{}}
     * module_path:Modal()>ConfirmDialog(template=delete_pin, ga_category=pin_delete)
     */
    private $delete_pin_url = "https://www.pinterest.com/resource/PinResource/delete/";

    public function delete_pin($pin_id) {

        // Can't do anything if we're not logged in
        if( !$this->is_logged_in )
            return Pinterest::NOT_LOGGED_IN;

        // OK!  We're ready!  Prepare the pin JSON
        $data_json = array(
            "options" => array(
                "id" => $pin_id
            ),
            "context" => array()
        );

        // Set up the "module path" data
        $module_path = "Modal()>ConfirmDialog(template=delete_pin, ga_category=pin_delete)";

        // And prepare the post data array
        $post = array(
            "source_url" => "/pin/{$pin_id}/",
            "data" => json_encode($data_json, JSON_FORCE_OBJECT),
            "module_path" => urlencode($module_path)
        );

        // Now make the post string
        $post_arr = array();
        foreach( $post as $k => $v )
            $post_arr[] = "{$k}=" . urlencode($v);

        $post_string = join("&", $post_arr);

        // Fix up parens
        $post_string = Pinterest::fix_encoding($post_string);


        // Now set up the CURL call
        $ch = \curl_init($this->delete_pin_url);
        \curl_setopt_array($ch, array(
            CURLOPT_COOKIEFILE => $this->cookie_jar,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0",
            CURLOPT_REFERER => "https://www.pinterest.com/pin/{$pin_id}/",
            CURLOPT_HTTPHEADER => array(
                'Host: www.pinterest.com',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Accept-Language: en-US,en;q=0.5',
                'DNT: 1',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Pinterest-AppState: active',
                'X-CSRFToken: ' . $this->csrf_token,
                'X-NEW-APP: 1',
                'X-APP-VERSION: 04cf8cc',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false   // remove me later
        ));

        // Run the CURL call
        $res = \curl_exec($ch);
        \curl_close($ch);
        $json = json_decode($res, TRUE);
	print_r($json);

        // If the result is json, we've succeeded!
        if( $json === null ) {
            return Pinterest::UNABLE_TO_DELETE;
        } else {
            return Pinterest::SUCCESS;
        }


    }






    /**
     * Fix URL-encoding for some characters
     */
    public static function fix_encoding($str) {
        return str_replace(
            array("%28", "%29", "%7E"),
            array("(", ")", "~"),
            $str
        );
    }


    /**
     * Is the pin URL a repin URL?
     */
    public static function is_repin_url($str) {
      return preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $str, $matches);
    }




    /**
     * Get a pin's preview URL
     */
    public static function get_pin_preview_url($pin_url) {

        // Let's make sure the pin URL conforms to the pinterest URL format
        if( !preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $pin_url, $matches) )
            return Pinterest::BAD_REPIN_URL;

        // Get the original pin ID
        $pin_id = $matches[1];

        // And get the source URL and description
        $repin_source = file_get_contents(trim($pin_url));

        // this is the source URL
        preg_match("<meta property=\"og:image\" name=\"og:image\" content=\"(.*?)\" data-app>", $repin_source, $matches);
        $image_preview_url = $matches[1];

        return $image_preview_url;

    }




    /**
     * Get a pin's description
     */
    public static function get_pin_description($pin_url) {

        // Let's make sure the pin URL conforms to the pinterest URL format
        if( !preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $pin_url, $matches) )
            return Pinterest::BAD_REPIN_URL;

        // Get the original pin ID
        $pin_id = $matches[1];

        // And get the source URL and description
        $repin_source = file_get_contents(trim($pin_url));

        // this is the source URL
        preg_match("<meta property=\"og:description\" name=\"og:description\" content=\"(.*?)\" data-app>", $repin_source, $matches);
        $description = html_entity_decode($matches[1]);
        $description = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $description);

        return $description;

    }





    /**
     * Get a pin's image URL
     */
    public static function get_pin_image_url($pin_url) {

        // Let's make sure the pin URL conforms to the pinterest URL format
        if( !preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $pin_url, $matches) )
            return Pinterest::BAD_REPIN_URL;

        // Get the original pin ID
        $pin_id = $matches[1];

        // And get the source URL and description
        $repin_source = file_get_contents(trim($pin_url));

        // this is the source URL
        preg_match("<meta property=\"twitter:image:src\" name=\"twitter:image:src\" content=\"(.*?)\" data-app>", $repin_source, $matches);
        $image_url = $matches[1];

        return $image_url;

    }





    /**
     * Get a pin's pinner
     */
    public static function get_pin_pinner($pin_url) {

        // Let's make sure the pin URL conforms to the pinterest URL format
        if( !preg_match("/https?:\/\/(?:www\.|)pinterest\.com\/pin\/(\d+)/", $pin_url, $matches) )
            return Pinterest::BAD_REPIN_URL;

        // Get the original pin ID
        $pin_id = $matches[1];

        // And get the source URL and description
        $repin_source = file_get_contents(trim($pin_url));

        // this is the source URL
        preg_match("<meta property=\"pinterestapp:pinner\" name=\"pinterestapp:pinner\" content=\"(.*?)\" data-app>", $repin_source, $matches);
        $pinner = $matches[1];
        $pinner = str_replace("https://www.pinterest.com/", "", $pinner);
        $pinner = rtrim($pinner, "/");

        return $pinner;

    }





    /**
     * Get a CSRF token from the given cookie file
     */
    public static function get_csrf_token($file) {

        // Failsafe
        if( !file_exists($file) )
            return null;

        // Step through the file, line by line..
        foreach( file($file) as $line ) {

            $line = trim($line);

            // Skip blank and comment lines
            if( $line == "" or substr($line, 0, 2) == "# " )
                continue;

            list($domain, $tailmatch, $path, $secure, $expires, $name, $value) = explode("\t", $line);

            // Do we have our token?
            if( $name == "csrftoken" )
                return $value;

        }

        // Couldn't find it..
        return null;

    }
	
	function mime_type($file) {
		// there's a bug that doesn't properly detect
		// the mime type of css files
		// https://bugs.php.net/bug.php?id=53035
		// so the following is used, instead
		// src: http://www.freeformatter.com/mime-types-list.html#mime-types-list
		
		/**
		 *                  **DISCLAIMER**
		 * This will just match the file extension to the following
		 * array. It does not guarantee that the file is TRULY that
		 * of the extension that this function returns.
		 */
		$mime_type = array(
			"3dml"			=>	"text/vnd.in3d.3dml",
			"3g2"			=>	"video/3gpp2",
			"3gp"			=>	"video/3gpp",
			"7z"			=>	"application/x-7z-compressed",
			"aab"			=>	"application/x-authorware-bin",
			"aac"			=>	"audio/x-aac",
			"aam"			=>	"application/x-authorware-map",
			"aas"			=>	"application/x-authorware-seg",
			"abw"			=>	"application/x-abiword",
			"ac"			=>	"application/pkix-attr-cert",
			"acc"			=>	"application/vnd.americandynamics.acc",
			"ace"			=>	"application/x-ace-compressed",
			"acu"			=>	"application/vnd.acucobol",
			"adp"			=>	"audio/adpcm",
			"aep"			=>	"application/vnd.audiograph",
			"afp"			=>	"application/vnd.ibm.modcap",
			"ahead"			=>	"application/vnd.ahead.space",
			"ai"			=>	"application/postscript",
			"aif"			=>	"audio/x-aiff",
			"air"			=>	"application/vnd.adobe.air-application-installer-package+zip",
			"ait"			=>	"application/vnd.dvb.ait",
			"ami"			=>	"application/vnd.amiga.ami",
			"apk"			=>	"application/vnd.android.package-archive",
			"application"		=>	"application/x-ms-application",
			"apr"			=>	"application/vnd.lotus-approach",
			"asf"			=>	"video/x-ms-asf",
			"aso"			=>	"application/vnd.accpac.simply.aso",
			"atc"			=>	"application/vnd.acucorp",
			"atom"			=>	"application/atom+xml",
			"atomcat"		=>	"application/atomcat+xml",
			"atomsvc"		=>	"application/atomsvc+xml",
			"atx"			=>	"application/vnd.antix.game-component",
			"au"			=>	"audio/basic",
			"avi"			=>	"video/x-msvideo",
			"aw"			=>	"application/applixware",
			"azf"			=>	"application/vnd.airzip.filesecure.azf",
			"azs"			=>	"application/vnd.airzip.filesecure.azs",
			"azw"			=>	"application/vnd.amazon.ebook",
			"bcpio"			=>	"application/x-bcpio",
			"bdf"			=>	"application/x-font-bdf",
			"bdm"			=>	"application/vnd.syncml.dm+wbxml",
			"bed"			=>	"application/vnd.realvnc.bed",
			"bh2"			=>	"application/vnd.fujitsu.oasysprs",
			"bin"			=>	"application/octet-stream",
			"bmi"			=>	"application/vnd.bmi",
			"bmp"			=>	"image/bmp",
			"box"			=>	"application/vnd.previewsystems.box",
			"btif"			=>	"image/prs.btif",
			"bz"			=>	"application/x-bzip",
			"bz2"			=>	"application/x-bzip2",
			"c"			=>	"text/x-c",
			"c11amc"		=>	"application/vnd.cluetrust.cartomobile-config",
			"c11amz"		=>	"application/vnd.cluetrust.cartomobile-config-pkg",
			"c4g"			=>	"application/vnd.clonk.c4group",
			"cab"			=>	"application/vnd.ms-cab-compressed",
			"car"			=>	"application/vnd.curl.car",
			"cat"			=>	"application/vnd.ms-pki.seccat",
			"ccxml"			=>	"application/ccxml+xml,",
			"cdbcmsg"		=>	"application/vnd.contact.cmsg",
			"cdkey"			=>	"application/vnd.mediastation.cdkey",
			"cdmia"			=>	"application/cdmi-capability",
			"cdmic"			=>	"application/cdmi-container",
			"cdmid"			=>	"application/cdmi-domain",
			"cdmio"			=>	"application/cdmi-object",
			"cdmiq"			=>	"application/cdmi-queue",
			"cdx"			=>	"chemical/x-cdx",
			"cdxml"			=>	"application/vnd.chemdraw+xml",
			"cdy"			=>	"application/vnd.cinderella",
			"cer"			=>	"application/pkix-cert",
			"cgm"			=>	"image/cgm",
			"chat"			=>	"application/x-chat",
			"chm"			=>	"application/vnd.ms-htmlhelp",
			"chrt"			=>	"application/vnd.kde.kchart",
			"cif"			=>	"chemical/x-cif",
			"cii"			=>	"application/vnd.anser-web-certificate-issue-initiation",
			"cil"			=>	"application/vnd.ms-artgalry",
			"cla"			=>	"application/vnd.claymore",
			"class"			=>	"application/java-vm",
			"clkk"			=>	"application/vnd.crick.clicker.keyboard",
			"clkp"			=>	"application/vnd.crick.clicker.palette",
			"clkt"			=>	"application/vnd.crick.clicker.template",
			"clkw"			=>	"application/vnd.crick.clicker.wordbank",
			"clkx"			=>	"application/vnd.crick.clicker",
			"clp"			=>	"application/x-msclip",
			"cmc"			=>	"application/vnd.cosmocaller",
			"cmdf"			=>	"chemical/x-cmdf",
			"cml"			=>	"chemical/x-cml",
			"cmp"			=>	"application/vnd.yellowriver-custom-menu",
			"cmx"			=>	"image/x-cmx",
			"cod"			=>	"application/vnd.rim.cod",
			"cpio"			=>	"application/x-cpio",
			"cpt"			=>	"application/mac-compactpro",
			"crd"			=>	"application/x-mscardfile",
			"crl"			=>	"application/pkix-crl",
			"cryptonote"		=>	"application/vnd.rig.cryptonote",
			"csh"			=>	"application/x-csh",
			"csml"			=>	"chemical/x-csml",
			"csp"			=>	"application/vnd.commonspace",
			"css"			=>	"text/css",
			"csv"			=>	"text/csv",
			"cu"			=>	"application/cu-seeme",
			"curl"			=>	"text/vnd.curl",
			"cww"			=>	"application/prs.cww",
			"dae"			=>	"model/vnd.collada+xml",
			"daf"			=>	"application/vnd.mobius.daf",
			"davmount"		=>	"application/davmount+xml",
			"dcurl"			=>	"text/vnd.curl.dcurl",
			"dd2"			=>	"application/vnd.oma.dd2+xml",
			"ddd"			=>	"application/vnd.fujixerox.ddd",
			"deb"			=>	"application/x-debian-package",
			"der"			=>	"application/x-x509-ca-cert",
			"dfac"			=>	"application/vnd.dreamfactory",
			"dir"			=>	"application/x-director",
			"dis"			=>	"application/vnd.mobius.dis",
			"djvu"			=>	"image/vnd.djvu",
			"dna"			=>	"application/vnd.dna",
			"doc"			=>	"application/msword",
			"docm"			=>	"application/vnd.ms-word.document.macroenabled.12",
			"docx"			=>	"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
			"dotm"			=>	"application/vnd.ms-word.template.macroenabled.12",
			"dotx"			=>	"application/vnd.openxmlformats-officedocument.wordprocessingml.template",
			"dp"			=>	"application/vnd.osgi.dp",
			"dpg"			=>	"application/vnd.dpgraph",
			"dra"			=>	"audio/vnd.dra",
			"dsc"			=>	"text/prs.lines.tag",
			"dssc"			=>	"application/dssc+der",
			"dtb"			=>	"application/x-dtbook+xml",
			"dtd"			=>	"application/xml-dtd",
			"dts"			=>	"audio/vnd.dts",
			"dtshd"			=>	"audio/vnd.dts.hd",
			"dvi"			=>	"application/x-dvi",
			"dwf"			=>	"model/vnd.dwf",
			"dwg"			=>	"image/vnd.dwg",
			"dxf"			=>	"image/vnd.dxf",
			"dxp"			=>	"application/vnd.spotfire.dxp",
			"ecelp4800"		=>	"audio/vnd.nuera.ecelp4800",
			"ecelp7470"		=>	"audio/vnd.nuera.ecelp7470",
			"ecelp9600"		=>	"audio/vnd.nuera.ecelp9600",
			"edm"			=>	"application/vnd.novadigm.edm",
			"edx"			=>	"application/vnd.novadigm.edx",
			"efif"			=>	"application/vnd.picsel",
			"ei6"			=>	"application/vnd.pg.osasli",
			"eml"			=>	"message/rfc822",
			"emma"			=>	"application/emma+xml",
			"eol"			=>	"audio/vnd.digital-winds",
			"eot"			=>	"application/vnd.ms-fontobject",
			"epub"			=>	"application/epub+zip",
			"es"			=>	"application/ecmascript",
			"es3"			=>	"application/vnd.eszigno3+xml",
			"esf"			=>	"application/vnd.epson.esf",
			"etx"			=>	"text/x-setext",
			"exe"			=>	"application/x-msdownload",
			"exi"			=>	"application/exi",
			"ext"			=>	"application/vnd.novadigm.ext",
			"ez2"			=>	"application/vnd.ezpix-album",
			"ez3"			=>	"application/vnd.ezpix-package",
			"f"			=>	"text/x-fortran",
			"f4v"			=>	"video/x-f4v",
			"fbs"			=>	"image/vnd.fastbidsheet",
			"fcs"			=>	"application/vnd.isac.fcs",
			"fdf"			=>	"application/vnd.fdf",
			"fe_launch"		=>	"application/vnd.denovo.fcselayout-link",
			"fg5"			=>	"application/vnd.fujitsu.oasysgp",
			"fh"			=>	"image/x-freehand",
			"fig"			=>	"application/x-xfig",
			"fli"			=>	"video/x-fli",
			"flo"			=>	"application/vnd.micrografx.flo",
			"flv"			=>	"video/x-flv",
			"flw"			=>	"application/vnd.kde.kivio",
			"flx"			=>	"text/vnd.fmi.flexstor",
			"fly"			=>	"text/vnd.fly",
			"fm"			=>	"application/vnd.framemaker",
			"fnc"			=>	"application/vnd.frogans.fnc",
			"fpx"			=>	"image/vnd.fpx",
			"fsc"			=>	"application/vnd.fsc.weblaunch",
			"fst"			=>	"image/vnd.fst",
			"ftc"			=>	"application/vnd.fluxtime.clip",
			"fti"			=>	"application/vnd.anser-web-funds-transfer-initiation",
			"fvt"			=>	"video/vnd.fvt",
			"fxp"			=>	"application/vnd.adobe.fxp",
			"fzs"			=>	"application/vnd.fuzzysheet",
			"g2w"			=>	"application/vnd.geoplan",
			"g3"			=>	"image/g3fax",
			"g3w"			=>	"application/vnd.geospace",
			"gac"			=>	"application/vnd.groove-account",
			"gdl"			=>	"model/vnd.gdl",
			"geo"			=>	"application/vnd.dynageo",
			"gex"			=>	"application/vnd.geometry-explorer",
			"ggb"			=>	"application/vnd.geogebra.file",
			"ggt"			=>	"application/vnd.geogebra.tool",
			"ghf"			=>	"application/vnd.groove-help",
			"gif"			=>	"image/gif",
			"gim"			=>	"application/vnd.groove-identity-message",
			"gmx"			=>	"application/vnd.gmx",
			"gnumeric"		=>	"application/x-gnumeric",
			"gph"			=>	"application/vnd.flographit",
			"gqf"			=>	"application/vnd.grafeq",
			"gram"			=>	"application/srgs",
			"grv"			=>	"application/vnd.groove-injector",
			"grxml"			=>	"application/srgs+xml",
			"gsf"			=>	"application/x-font-ghostscript",
			"gtar"			=>	"application/x-gtar",
			"gtm"			=>	"application/vnd.groove-tool-message",
			"gtw"			=>	"model/vnd.gtw",
			"gv"			=>	"text/vnd.graphviz",
			"gxt"			=>	"application/vnd.geonext",
			"h261"			=>	"video/h261",
			"h263"			=>	"video/h263",
			"h264"			=>	"video/h264",
			"hal"			=>	"application/vnd.hal+xml",
			"hbci"			=>	"application/vnd.hbci",
			"hdf"			=>	"application/x-hdf",
			"hlp"			=>	"application/winhlp",
			"hpgl"			=>	"application/vnd.hp-hpgl",
			"hpid"			=>	"application/vnd.hp-hpid",
			"hps"			=>	"application/vnd.hp-hps",
			"hqx"			=>	"application/mac-binhex40",
			"htke"			=>	"application/vnd.kenameaapp",
			"html"			=>	"text/html",
			"hvd"			=>	"application/vnd.yamaha.hv-dic",
			"hvp"			=>	"application/vnd.yamaha.hv-voice",
			"hvs"			=>	"application/vnd.yamaha.hv-script",
			"i2g"			=>	"application/vnd.intergeo",
			"icc"			=>	"application/vnd.iccprofile",
			"ice"			=>	"x-conference/x-cooltalk",
			"ico"			=>	"image/x-icon",
			"ics"			=>	"text/calendar",
			"ief"			=>	"image/ief",
			"ifm"			=>	"application/vnd.shana.informed.formdata",
			"igl"			=>	"application/vnd.igloader",
			"igm"			=>	"application/vnd.insors.igm",
			"igs"			=>	"model/iges",
			"igx"			=>	"application/vnd.micrografx.igx",
			"iif"			=>	"application/vnd.shana.informed.interchange",
			"imp"			=>	"application/vnd.accpac.simply.imp",
			"ims"			=>	"application/vnd.ms-ims",
			"ipfix"			=>	"application/ipfix",
			"ipk"			=>	"application/vnd.shana.informed.package",
			"irm"			=>	"application/vnd.ibm.rights-management",
			"irp"			=>	"application/vnd.irepository.package+xml",
			"itp"			=>	"application/vnd.shana.informed.formtemplate",
			"ivp"			=>	"application/vnd.immervision-ivp",
			"ivu"			=>	"application/vnd.immervision-ivu",
			"jad"			=>	"text/vnd.sun.j2me.app-descriptor",
			"jam"			=>	"application/vnd.jam",
			"jar"			=>	"application/java-archive",
			"java"			=>	"text/x-java-source,java",
			"jisp"			=>	"application/vnd.jisp",
			"jlt"			=>	"application/vnd.hp-jlyt",
			"jnlp"			=>	"application/x-java-jnlp-file",
			"joda"			=>	"application/vnd.joost.joda-archive",
			"jpeg"			=>	"image/jpeg",
			"jpg"			=>	"image/jpeg",
			"jpgv"			=>	"video/jpeg",
			"jpm"			=>	"video/jpm",
			"js"			=>	"application/javascript",
			"json"			=>	"application/json",
			"karbon"		=>	"application/vnd.kde.karbon",
			"kfo"			=>	"application/vnd.kde.kformula",
			"kia"			=>	"application/vnd.kidspiration",
			"kml"			=>	"application/vnd.google-earth.kml+xml",
			"kmz"			=>	"application/vnd.google-earth.kmz",
			"kne"			=>	"application/vnd.kinar",
			"kon"			=>	"application/vnd.kde.kontour",
			"kpr"			=>	"application/vnd.kde.kpresenter",
			"ksp"			=>	"application/vnd.kde.kspread",
			"ktx"			=>	"image/ktx",
			"ktz"			=>	"application/vnd.kahootz",
			"kwd"			=>	"application/vnd.kde.kword",
			"lasxml"		=>	"application/vnd.las.las+xml",
			"latex"			=>	"application/x-latex",
			"lbd"			=>	"application/vnd.llamagraphics.life-balance.desktop",
			"lbe"			=>	"application/vnd.llamagraphics.life-balance.exchange+xml",
			"les"			=>	"application/vnd.hhe.lesson-player",
			"link66"		=>	"application/vnd.route66.link66+xml",
			"lrm"			=>	"application/vnd.ms-lrm",
			"ltf"			=>	"application/vnd.frogans.ltf",
			"lvp"			=>	"audio/vnd.lucent.voice",
			"lwp"			=>	"application/vnd.lotus-wordpro",
			"m21"			=>	"application/mp21",
			"m3u"			=>	"audio/x-mpegurl",
			"m3u8"			=>	"application/vnd.apple.mpegurl",
			"m4v"			=>	"video/x-m4v",
			"ma"			=>	"application/mathematica",
			"mads"			=>	"application/mads+xml",
			"mag"			=>	"application/vnd.ecowin.chart",
			"map"			=>	"application/json",
			"mathml"		=>	"application/mathml+xml",
			"mbk"			=>	"application/vnd.mobius.mbk",
			"mbox"			=>	"application/mbox",
			"mc1"			=>	"application/vnd.medcalcdata",
			"mcd"			=>	"application/vnd.mcd",
			"mcurl"			=>	"text/vnd.curl.mcurl",
			"md"			=>	"text/x-markdown", // http://bit.ly/1Kc5nUB
			"mdb"			=>	"application/x-msaccess",
			"mdi"			=>	"image/vnd.ms-modi",
			"meta4"			=>	"application/metalink4+xml",
			"mets"			=>	"application/mets+xml",
			"mfm"			=>	"application/vnd.mfmp",
			"mgp"			=>	"application/vnd.osgeo.mapguide.package",
			"mgz"			=>	"application/vnd.proteus.magazine",
			"mid"			=>	"audio/midi",
			"mif"			=>	"application/vnd.mif",
			"mj2"			=>	"video/mj2",
			"mlp"			=>	"application/vnd.dolby.mlp",
			"mmd"			=>	"application/vnd.chipnuts.karaoke-mmd",
			"mmf"			=>	"application/vnd.smaf",
			"mmr"			=>	"image/vnd.fujixerox.edmics-mmr",
			"mny"			=>	"application/x-msmoney",
			"mods"			=>	"application/mods+xml",
			"movie"			=>	"video/x-sgi-movie",
			"mp1"			=>	"audio/mpeg",
			"mp2"			=>	"audio/mpeg",
			"mp3"			=>	"audio/mpeg",
			"mp4"			=>	"video/mp4",
			"mp4a"			=>	"audio/mp4",
			"mpc"			=>	"application/vnd.mophun.certificate",
			"mpeg"			=>	"video/mpeg",
			"mpga"			=>	"audio/mpeg",
			"mpkg"			=>	"application/vnd.apple.installer+xml",
			"mpm"			=>	"application/vnd.blueice.multipass",
			"mpn"			=>	"application/vnd.mophun.application",
			"mpp"			=>	"application/vnd.ms-project",
			"mpy"			=>	"application/vnd.ibm.minipay",
			"mqy"			=>	"application/vnd.mobius.mqy",
			"mrc"			=>	"application/marc",
			"mrcx"			=>	"application/marcxml+xml",
			"mscml"			=>	"application/mediaservercontrol+xml",
			"mseq"			=>	"application/vnd.mseq",
			"msf"			=>	"application/vnd.epson.msf",
			"msh"			=>	"model/mesh",
			"msl"			=>	"application/vnd.mobius.msl",
			"msty"			=>	"application/vnd.muvee.style",
			"mts"			=>	"model/vnd.mts",
			"mus"			=>	"application/vnd.musician",
			"musicxml"		=>	"application/vnd.recordare.musicxml+xml",
			"mvb"			=>	"application/x-msmediaview",
			"mwf"			=>	"application/vnd.mfer",
			"mxf"			=>	"application/mxf",
			"mxl"			=>	"application/vnd.recordare.musicxml",
			"mxml"			=>	"application/xv+xml",
			"mxs"			=>	"application/vnd.triscape.mxs",
			"mxu"			=>	"video/vnd.mpegurl",
			"n3"			=>	"text/n3",
			"nbp"			=>	"application/vnd.wolfram.player",
			"nc"			=>	"application/x-netcdf",
			"ncx"			=>	"application/x-dtbncx+xml",
			"n-gage"		=>	"application/vnd.nokia.n-gage.symbian.install",
			"ngdat"			=>	"application/vnd.nokia.n-gage.data",
			"nlu"			=>	"application/vnd.neurolanguage.nlu",
			"nml"			=>	"application/vnd.enliven",
			"nnd"			=>	"application/vnd.noblenet-directory",
			"nns"			=>	"application/vnd.noblenet-sealer",
			"nnw"			=>	"application/vnd.noblenet-web",
			"npx"			=>	"image/vnd.net-fpx",
			"nsf"			=>	"application/vnd.lotus-notes",
			"oa2"			=>	"application/vnd.fujitsu.oasys2",
			"oa3"			=>	"application/vnd.fujitsu.oasys3",
			"oas"			=>	"application/vnd.fujitsu.oasys",
			"obd"			=>	"application/x-msbinder",
			"oda"			=>	"application/oda",
			"odb"			=>	"application/vnd.oasis.opendocument.database",
			"odc"			=>	"application/vnd.oasis.opendocument.chart",
			"odf"			=>	"application/vnd.oasis.opendocument.formula",
			"odft"			=>	"application/vnd.oasis.opendocument.formula-template",
			"odg"			=>	"application/vnd.oasis.opendocument.graphics",
			"odi"			=>	"application/vnd.oasis.opendocument.image",
			"odm"			=>	"application/vnd.oasis.opendocument.text-master",
			"odp"			=>	"application/vnd.oasis.opendocument.presentation",
			"ods"			=>	"application/vnd.oasis.opendocument.spreadsheet",
			"odt"			=>	"application/vnd.oasis.opendocument.text",
			"oga"			=>	"audio/ogg",
			"ogv"			=>	"video/ogg",
			"ogx"			=>	"application/ogg",
			"onetoc"		=>	"application/onenote",
			"opf"			=>	"application/oebps-package+xml",
			"org"			=>	"application/vnd.lotus-organizer",
			"osf"			=>	"application/vnd.yamaha.openscoreformat",
			"osfpvg"		=>	"application/vnd.yamaha.openscoreformat.osfpvg+xml",
			"otc"			=>	"application/vnd.oasis.opendocument.chart-template",
			"otf"			=>	"application/x-font-otf",
			"otg"			=>	"application/vnd.oasis.opendocument.graphics-template",
			"oth"			=>	"application/vnd.oasis.opendocument.text-web",
			"oti"			=>	"application/vnd.oasis.opendocument.image-template",
			"otp"			=>	"application/vnd.oasis.opendocument.presentation-template",
			"ots"			=>	"application/vnd.oasis.opendocument.spreadsheet-template",
			"ott"			=>	"application/vnd.oasis.opendocument.text-template",
			"oxt"			=>	"application/vnd.openofficeorg.extension",
			"p"			=>	"text/x-pascal",
			"p10"			=>	"application/pkcs10",
			"p12"			=>	"application/x-pkcs12",
			"p7b"			=>	"application/x-pkcs7-certificates",
			"p7m"			=>	"application/pkcs7-mime",
			"p7r"			=>	"application/x-pkcs7-certreqresp",
			"p7s"			=>	"application/pkcs7-signature",
			"p8"			=>	"application/pkcs8",
			"par"			=>	"text/plain-bas",
			"paw"			=>	"application/vnd.pawaafile",
			"pbd"			=>	"application/vnd.powerbuilder6",
			"pbm"			=>	"image/x-portable-bitmap",
			"pcf"			=>	"application/x-font-pcf",
			"pcl"			=>	"application/vnd.hp-pcl",
			"pclxl"			=>	"application/vnd.hp-pclxl",
			"pcurl"			=>	"application/vnd.curl.pcurl",
			"pcx"			=>	"image/x-pcx",
			"pdb"			=>	"application/vnd.palm",
			"pdf"			=>	"application/pdf",
			"pfa"			=>	"application/x-font-type1",
			"pfr"			=>	"application/font-tdpfr",
			"pgm"			=>	"image/x-portable-graymap",
			"pgn"			=>	"application/x-chess-pgn",
			"pgp"			=>	"application/pgp-signature",
			"pic"			=>	"image/x-pict",
			"pki"			=>	"application/pkixcmp",
			"pkipath"		=>	"application/pkix-pkipath",
			"plb"			=>	"application/vnd.3gpp.pic-bw-large",
			"plc"			=>	"application/vnd.mobius.plc",
			"plf"			=>	"application/vnd.pocketlearn",
			"pls"			=>	"application/pls+xml",
			"pml"			=>	"application/vnd.ctc-posml",
			"png"			=>	"image/png",
			"pnm"			=>	"image/x-portable-anymap",
			"portpkg"		=>	"application/vnd.macports.portpkg",
			"potm"			=>	"application/vnd.ms-powerpoint.template.macroenabled.12",
			"potx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.template",
			"ppam"			=>	"application/vnd.ms-powerpoint.addin.macroenabled.12",
			"ppd"			=>	"application/vnd.cups-ppd",
			"ppm"			=>	"image/x-portable-pixmap",
			"ppsm"			=>	"application/vnd.ms-powerpoint.slideshow.macroenabled.12",
			"ppsx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.slideshow",
			"ppt"			=>	"application/vnd.ms-powerpoint",
			"pptm"			=>	"application/vnd.ms-powerpoint.presentation.macroenabled.12",
			"pptx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.presentation",
			"prc"			=>	"application/x-mobipocket-ebook",
			"pre"			=>	"application/vnd.lotus-freelance",
			"prf"			=>	"application/pics-rules",
			"psb"			=>	"application/vnd.3gpp.pic-bw-small",
			"psd"			=>	"image/vnd.adobe.photoshop",
			"psf"			=>	"application/x-font-linux-psf",
			"pskcxml"		=>	"application/pskc+xml",
			"ptid"			=>	"application/vnd.pvi.ptid1",
			"pub"			=>	"application/x-mspublisher",
			"pvb"			=>	"application/vnd.3gpp.pic-bw-var",
			"pwn"			=>	"application/vnd.3m.post-it-notes",
			"pya"			=>	"audio/vnd.ms-playready.media.pya",
			"pyv"			=>	"video/vnd.ms-playready.media.pyv",
			"qam"			=>	"application/vnd.epson.quickanime",
			"qbo"			=>	"application/vnd.intu.qbo",
			"qfx"			=>	"application/vnd.intu.qfx",
			"qps"			=>	"application/vnd.publishare-delta-tree",
			"qt"			=>	"video/quicktime",
			"qxd"			=>	"application/vnd.quark.quarkxpress",
			"ram"			=>	"audio/x-pn-realaudio",
			"rar"			=>	"application/x-rar-compressed",
			"ras"			=>	"image/x-cmu-raster",
			"rcprofile"		=>	"application/vnd.ipunplugged.rcprofile",
			"rdf"			=>	"application/rdf+xml",
			"rdz"			=>	"application/vnd.data-vision.rdz",
			"rep"			=>	"application/vnd.businessobjects",
			"res"			=>	"application/x-dtbresource+xml",
			"rgb"			=>	"image/x-rgb",
			"rif"			=>	"application/reginfo+xml",
			"rip"			=>	"audio/vnd.rip",
			"rl"			=>	"application/resource-lists+xml",
			"rlc"			=>	"image/vnd.fujixerox.edmics-rlc",
			"rld"			=>	"application/resource-lists-diff+xml",
			"rm"			=>	"application/vnd.rn-realmedia",
			"rmp"			=>	"audio/x-pn-realaudio-plugin",
			"rms"			=>	"application/vnd.jcp.javame.midlet-rms",
			"rnc"			=>	"application/relax-ng-compact-syntax",
			"rp9"			=>	"application/vnd.cloanto.rp9",
			"rpss"			=>	"application/vnd.nokia.radio-presets",
			"rpst"			=>	"application/vnd.nokia.radio-preset",
			"rq"			=>	"application/sparql-query",
			"rs"			=>	"application/rls-services+xml",
			"rsd"			=>	"application/rsd+xml",
			"rss"			=>	"application/rss+xml",
			"rtf"			=>	"application/rtf",
			"rtx"			=>	"text/richtext",
			"s"			=>	"text/x-asm",
			"saf"			=>	"application/vnd.yamaha.smaf-audio",
			"sbml"			=>	"application/sbml+xml",
			"sc"			=>	"application/vnd.ibm.secure-container",
			"scd"			=>	"application/x-msschedule",
			"scm"			=>	"application/vnd.lotus-screencam",
			"scq"			=>	"application/scvp-cv-request",
			"scs"			=>	"application/scvp-cv-response",
			"scurl"			=>	"text/vnd.curl.scurl",
			"sda"			=>	"application/vnd.stardivision.draw",
			"sdc"			=>	"application/vnd.stardivision.calc",
			"sdd"			=>	"application/vnd.stardivision.impress",
			"sdkm"			=>	"application/vnd.solent.sdkm+xml",
			"sdp"			=>	"application/sdp",
			"sdw"			=>	"application/vnd.stardivision.writer",
			"see"			=>	"application/vnd.seemail",
			"seed"			=>	"application/vnd.fdsn.seed",
			"sema"			=>	"application/vnd.sema",
			"semd"			=>	"application/vnd.semd",
			"semf"			=>	"application/vnd.semf",
			"ser"			=>	"application/java-serialized-object",
			"setpay"		=>	"application/set-payment-initiation",
			"setreg"		=>	"application/set-registration-initiation",
			"sfd-hdstx"		=>	"application/vnd.hydrostatix.sof-data",
			"sfs"			=>	"application/vnd.spotfire.sfs",
			"sgl"			=>	"application/vnd.stardivision.writer-global",
			"sgml"			=>	"text/sgml",
			"sh"			=>	"application/x-sh",
			"shar"			=>	"application/x-shar",
			"shf"			=>	"application/shf+xml",
			"sis"			=>	"application/vnd.symbian.install",
			"sit"			=>	"application/x-stuffit",
			"sitx"			=>	"application/x-stuffitx",
			"skp"			=>	"application/vnd.koan",
			"sldm"			=>	"application/vnd.ms-powerpoint.slide.macroenabled.12",
			"sldx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.slide",
			"slt"			=>	"application/vnd.epson.salt",
			"sm"			=>	"application/vnd.stepmania.stepchart",
			"smf"			=>	"application/vnd.stardivision.math",
			"smi"			=>	"application/smil+xml",
			"snf"			=>	"application/x-font-snf",
			"spf"			=>	"application/vnd.yamaha.smaf-phrase",
			"spl"			=>	"application/x-futuresplash",
			"spot"			=>	"text/vnd.in3d.spot",
			"spp"			=>	"application/scvp-vp-response",
			"spq"			=>	"application/scvp-vp-request",
			"src"			=>	"application/x-wais-source",
			"sru"			=>	"application/sru+xml",
			"srx"			=>	"application/sparql-results+xml",
			"sse"			=>	"application/vnd.kodak-descriptor",
			"ssf"			=>	"application/vnd.epson.ssf",
			"ssml"			=>	"application/ssml+xml",
			"st"			=>	"application/vnd.sailingtracker.track",
			"stc"			=>	"application/vnd.sun.xml.calc.template",
			"std"			=>	"application/vnd.sun.xml.draw.template",
			"stf"			=>	"application/vnd.wt.stf",
			"sti"			=>	"application/vnd.sun.xml.impress.template",
			"stk"			=>	"application/hyperstudio",
			"stl"			=>	"application/vnd.ms-pki.stl",
			"str"			=>	"application/vnd.pg.format",
			"stw"			=>	"application/vnd.sun.xml.writer.template",
			"sub"			=>	"image/vnd.dvb.subtitle",
			"sus"			=>	"application/vnd.sus-calendar",
			"sv4cpio"		=>	"application/x-sv4cpio",
			"sv4crc"		=>	"application/x-sv4crc",
			"svc"			=>	"application/vnd.dvb.service",
			"svd"			=>	"application/vnd.svd",
			"svg"			=>	"image/svg+xml",
			"swf"			=>	"application/x-shockwave-flash",
			"swi"			=>	"application/vnd.aristanetworks.swi",
			"sxc"			=>	"application/vnd.sun.xml.calc",
			"sxd"			=>	"application/vnd.sun.xml.draw",
			"sxg"			=>	"application/vnd.sun.xml.writer.global",
			"sxi"			=>	"application/vnd.sun.xml.impress",
			"sxm"			=>	"application/vnd.sun.xml.math",
			"sxw"			=>	"application/vnd.sun.xml.writer",
			"t"			=>	"text/troff",
			"tao"			=>	"application/vnd.tao.intent-module-archive",
			"tar"			=>	"application/x-tar",
			"tcap"			=>	"application/vnd.3gpp2.tcap",
			"tcl"			=>	"application/x-tcl",
			"teacher"		=>	"application/vnd.smart.teacher",
			"tei"			=>	"application/tei+xml",
			"tex"			=>	"application/x-tex",
			"texinfo"		=>	"application/x-texinfo",
			"tfi"			=>	"application/thraud+xml",
			"tfm"			=>	"application/x-tex-tfm",
			"thmx"			=>	"application/vnd.ms-officetheme",
			"tiff"			=>	"image/tiff",
			"tmo"			=>	"application/vnd.tmobile-livetv",
			"torrent"		=>	"application/x-bittorrent",
			"tpl"			=>	"application/vnd.groove-tool-template",
			"tpt"			=>	"application/vnd.trid.tpt",
			"tra"			=>	"application/vnd.trueapp",
			"trm"			=>	"application/x-msterminal",
			"tsd"			=>	"application/timestamped-data",
			"tsv"			=>	"text/tab-separated-values",
			"ttf"			=>	"application/x-font-ttf",
			"ttl"			=>	"text/turtle",
			"twd"			=>	"application/vnd.simtech-mindmapper",
			"txd"			=>	"application/vnd.genomatix.tuxedo",
			"txf"			=>	"application/vnd.mobius.txf",
			"txt"			=>	"text/plain",
			"ufd"			=>	"application/vnd.ufdl",
			"umj"			=>	"application/vnd.umajin",
			"unityweb"		=>	"application/vnd.unity",
			"uoml"			=>	"application/vnd.uoml+xml",
			"uri"			=>	"text/uri-list",
			"ustar"			=>	"application/x-ustar",
			"utz"			=>	"application/vnd.uiq.theme",
			"uu"			=>	"text/x-uuencode",
			"uva"			=>	"audio/vnd.dece.audio",
			"uvh"			=>	"video/vnd.dece.hd",
			"uvi"			=>	"image/vnd.dece.graphic",
			"uvm"			=>	"video/vnd.dece.mobile",
			"uvp"			=>	"video/vnd.dece.pd",
			"uvs"			=>	"video/vnd.dece.sd",
			"uvu"			=>	"video/vnd.uvvu.mp4",
			"uvv"			=>	"video/vnd.dece.video",
			"vcd"			=>	"application/x-cdlink",
			"vcf"			=>	"text/x-vcard",
			"vcg"			=>	"application/vnd.groove-vcard",
			"vcs"			=>	"text/x-vcalendar",
			"vcx"			=>	"application/vnd.vcx",
			"vis"			=>	"application/vnd.visionary",
			"viv"			=>	"video/vnd.vivo",
			"vsd"			=>	"application/vnd.visio",
			"vsf"			=>	"application/vnd.vsf",
			"vtu"			=>	"model/vnd.vtu",
			"vxml"			=>	"application/voicexml+xml",
			"wad"			=>	"application/x-doom",
			"wav"			=>	"audio/x-wav",
			"wax"			=>	"audio/x-ms-wax",
			"wbmp"			=>	"image/vnd.wap.wbmp",
			"wbs"			=>	"application/vnd.criticaltools.wbs+xml",
			"wbxml"			=>	"application/vnd.wap.wbxml",
			"weba"			=>	"audio/webm",
			"webm"			=>	"video/webm",
			"webp"			=>	"image/webp",
			"wg"			=>	"application/vnd.pmi.widget",
			"wgt"			=>	"application/widget",
			"wm"			=>	"video/x-ms-wm",
			"wma"			=>	"audio/x-ms-wma",
			"wmd"			=>	"application/x-ms-wmd",
			"wmf"			=>	"application/x-msmetafile",
			"wml"			=>	"text/vnd.wap.wml",
			"wmlc"			=>	"application/vnd.wap.wmlc",
			"wmls"			=>	"text/vnd.wap.wmlscript",
			"wmlsc"			=>	"application/vnd.wap.wmlscriptc",
			"wmv"			=>	"video/x-ms-wmv",
			"wmx"			=>	"video/x-ms-wmx",
			"wmz"			=>	"application/x-ms-wmz",
			"woff"			=>	"application/x-font-woff",
			"woff2"			=>	"application/font-woff2",
			"wpd"			=>	"application/vnd.wordperfect",
			"wpl"			=>	"application/vnd.ms-wpl",
			"wps"			=>	"application/vnd.ms-works",
			"wqd"			=>	"application/vnd.wqd",
			"wri"			=>	"application/x-mswrite",
			"wrl"			=>	"model/vrml",
			"wsdl"			=>	"application/wsdl+xml",
			"wspolicy"		=>	"application/wspolicy+xml",
			"wtb"			=>	"application/vnd.webturbo",
			"wvx"			=>	"video/x-ms-wvx",
			"x3d"			=>	"application/vnd.hzn-3d-crossword",
			"xap"			=>	"application/x-silverlight-app",
			"xar"			=>	"application/vnd.xara",
			"xbap"			=>	"application/x-ms-xbap",
			"xbd"			=>	"application/vnd.fujixerox.docuworks.binder",
			"xbm"			=>	"image/x-xbitmap",
			"xdf"			=>	"application/xcap-diff+xml",
			"xdm"			=>	"application/vnd.syncml.dm+xml",
			"xdp"			=>	"application/vnd.adobe.xdp+xml",
			"xdssc"			=>	"application/dssc+xml",
			"xdw"			=>	"application/vnd.fujixerox.docuworks",
			"xenc"			=>	"application/xenc+xml",
			"xer"			=>	"application/patch-ops-error+xml",
			"xfdf"			=>	"application/vnd.adobe.xfdf",
			"xfdl"			=>	"application/vnd.xfdl",
			"xhtml"			=>	"application/xhtml+xml",
			"xif"			=>	"image/vnd.xiff",
			"xlam"			=>	"application/vnd.ms-excel.addin.macroenabled.12",
			"xls"			=>	"application/vnd.ms-excel",
			"xlsb"			=>	"application/vnd.ms-excel.sheet.binary.macroenabled.12",
			"xlsm"			=>	"application/vnd.ms-excel.sheet.macroenabled.12",
			"xlsx"			=>	"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
			"xltm"			=>	"application/vnd.ms-excel.template.macroenabled.12",
			"xltx"			=>	"application/vnd.openxmlformats-officedocument.spreadsheetml.template",
			"xml"			=>	"application/xml",
			"xo"			=>	"application/vnd.olpc-sugar",
			"xop"			=>	"application/xop+xml",
			"xpi"			=>	"application/x-xpinstall",
			"xpm"			=>	"image/x-xpixmap",
			"xpr"			=>	"application/vnd.is-xpr",
			"xps"			=>	"application/vnd.ms-xpsdocument",
			"xpw"			=>	"application/vnd.intercon.formnet",
			"xslt"			=>	"application/xslt+xml",
			"xsm"			=>	"application/vnd.syncml+xml",
			"xspf"			=>	"application/xspf+xml",
			"xul"			=>	"application/vnd.mozilla.xul+xml",
			"xwd"			=>	"image/x-xwindowdump",
			"xyz"			=>	"chemical/x-xyz",
			"yaml"			=>	"text/yaml",
			"yang"			=>	"application/yang",
			"yin"			=>	"application/yin+xml",
			"zaz"			=>	"application/vnd.zzazz.deck+xml",
			"zip"			=>	"application/zip",
			"zir"			=>	"application/vnd.zul",
			"zmm"			=>	"application/vnd.handheld-entertainment+xml"
		);
		
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if (isset($mime_type[$extension])) {
			return $mime_type[$extension];
		} else {
			throw new Exception("Unknown file type");
		}
	}

}

