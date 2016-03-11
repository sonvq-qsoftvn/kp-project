<!html>
<head>
    <title>My Facebook Event App</title>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
</head>
<body>
Welcome to our New Facebook App <span id='fbinfo'><fb:name uid='loggedinuser' useyou='false'></fb:name></span>
<div id='fb-root'></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type='text/javascript'>

    var fbuserid, fbtoken;
    var appid = "508763702557865";
    var loggedin = false;
    $(document).ready(function() {
        //loginFB();
    });

    FB.init({appId: appid, status: true, cookie: true, xfbml: true});
    FB.Event.subscribe('auth.sessionChange', function(response) {
            if (response.session) {
                var session = FB.getSession();
                fbtoken = session.access_token;
                fbuserid = session.uid;
            }
    });

    FB.getLoginStatus(function(response) {
        if (response.session) {
            var session = FB.getSession();
            fbtoken = session.access_token;
            fbuserid = session.uid;
        }
        else{
            loginFB();
        }
    });

    function loginFB() {
        FB.login(function(response) {
            if (response.session) {
                var session = FB.getSession();
                fbtoken = session.access_token;
                fbuserid = session.uid;
            }
        }, {perms:'create_event'});
    }

    function logoutFB() {
        FB.logout(function(response) {
            // user is now logged out
        });
    }

</script>
</body>
</html>