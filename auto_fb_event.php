<!html>
<head>
    <title>My Facebook Event App</title>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js'></script>
    
    <!--------------------->
    
      <script type='text/javascript'>
 
        function createEvent(name, startTime, endTime, location, description) {
             alert("2nd  event");
            var eventData = {
                "accessToken": fbtoken,
                "start_time" : startTime,
                "end_time":endTime,
                "location" : location,
                "name" : name,
                "description":description,
                "privacy_type":"OPEN"
            }
            alert("2nd  event2"+eventData);
            /* make the API call */
//FB.api("/me",function (response) {
//      if (response && !response.error) {
//        /* handle the result */
//      }
//    }
//);
            FB.api("/me/events",'get',eventData,function(response){
                console.log(response);
                alert(eventData);
                alert(response);
                if(response.id){
                    alert("We have successfully created a Facebook event with ID: "+response.id);
                }
            });
        }
         
        function createMyEvent(){
            alert("1st  event");
            var name = "My Amazing Event";
            var startTime = "2014-06-30T17:54:00-04:00";//2012-08-30T17:54:00-04:00
            var endTime = "2014-08-30T17:54:00-04:00";
            var location = "Dhaka";//2013-12-21T19:30:00-0800
            var description = "It will be freaking awesome";
            alert(name+","+startTime+","+endTime+","+location+","+description);
            createEvent(name, startTime,endTime, location, description);
        }
        </script>  
<!------------------------------>
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
                var session = FB.getAuthResponse()();
                fbtoken = session.accessToken;
                fbuserid = session.uid;
            }
    });
 
    FB.getLoginStatus(function(response) {
        if (response.session) {
            var session = FB.getAuthResponse()();
            fbtoken = session.accessToken;
            fbuserid = session.uid;
        }
        else{
            loginFB();
        }
    });
 
    function loginFB() {
        FB.login(function(response) {
            if (response.session) {
                var session = FB.getAuthResponse()();
                fbtoken = session.accessToken;
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
<form method="post" name="f1">
<input type="button" name="event" value="Create Event" onclick="createMyEvent();"/>
</form>
</body>
</html>