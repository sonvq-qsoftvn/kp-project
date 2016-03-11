<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	
	
		///////////////////////////////////////////////////////////common functionality////////////////////////////
		
		
	
	
	
	
        
        ////////////////////////////////////////////////for frontend///////////////////////////////////////////////
	
        //user login & settings
	
        Router::connect('/', array('controller' => 'users', 'action' => 'home', 'home'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'login'));
        Router::connect('/logincheck', array('controller' => 'users', 'action' => 'logincheck', 'logincheck'));
        Router::connect('/register', array('controller' => 'users', 'action' => 'register', 'register'));
        Router::connect('/dashboard', array('controller' => 'users', 'action' => 'dashboard', 'dashboard'));
	Router::connect('/userprofile', array('controller' => 'users', 'action' => 'userprofile', 'userprofile'));
  	Router::connect('/save_user_profile', array('controller' => 'users', 'action' => 'save_user_profile'));
        Router::connect('/facebook_login', array('controller' => 'users', 'action' => 'facebook_login', 'facebook_login'));
        Router::connect('/get_fb_id', array('controller' => 'users', 'action' => 'get_fb_id', 'get_fb_id'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout', 'logout'));
     Router::connect('/userupdate', array('controller' => 'users', 'action' => 'userupdate', 'userupdate'));
     Router::connect('/forgotpassword', array('controller' => 'users', 'action' => 'forgotpassword', 'forgotpassword'));
        
     //clinicmanager registration
     
     Router::connect('/registerclinicmanager', array('controller' => 'clinicmanagers', 'action' => 'register', 'register'));
     Router::connect('/registerclinicmanagercaptcha', array('controller' => 'clinicmanagers', 'action' => 'captcha_fetch', 'captcha_fetch'));
     Router::connect('/clintlist', array('controller' => 'clinics', 'action' => 'clintlist', 'clintlist'));
     Router::connect('/change_password', array('controller' => 'users', 'action' => 'changepassword', 'change_password'));
     
        ////////////////////////////////////clinic manager section///////////////////////////////////////////////
        
        //clinic manager logins &settings
        Router::connect('/clinicmanager', array('controller' => 'clinicowners', 'action' => 'index', 'index'));
	Router::connect('/clinicmanager/dashboard', array('controller' => 'clinicowners', 'action' => 'dashboard', 'dashboard'));
        Router::connect('/clinicmanager/logincheck', array('controller' => 'clinicowners', 'action' => 'logincheck'));
        Router::connect('/clinicmanager/logout', array('controller' => 'clinicowners', 'action' => 'logout'));

       //clinic manager Change Password
		Router::connect('/clinicmanager/changepassword', array('controller' => 'clinicowners', 'action' => 'changepassword','changepassword'));
		Router::connect('/clinicmanager/forgotpassword', array('controller' => 'clinicowners', 'action' => 'forgotpassword','forgotpassword'));
        Router::connect('/clinicmanager/resetpassword/', array('controller' => 'clinicowners', 'action' => 'resetpassword','resetpassword'));

	//Manage Clinics
        Router::connect('/clinicmanager/clinics', array('controller' => 'ownerclinics', 'action' => 'index','index'));
        Router::connect('/clinicmanager/disapprovedclinics', array('controller' => 'ownerclinics', 'action' => 'disapprovedclinics','disapprovedclinics'));
        Router::connect('/clinicmanager/clinicsettings', array('controller' => 'ownerclinics', 'action' => 'clinicsettings','clinicsettings'));
        Router::connect('/clinicmanager/deleteclinic', array('controller' => 'ownerclinics', 'action' => 'deleteclinic'));
        Router::connect('/clinicmanager/addclinic', array('controller' => 'ownerclinics', 'action' => 'addclinic','addclinic'));
        Router::connect('/clinicmanager/disapproveclinic', array('controller' => 'ownerclinics', 'action' => 'disapprove','disapprove'));
        Router::connect('/clinicmanager/approveclinic', array('controller' => 'ownerclinics', 'action' => 'approve','approve'));
        Router::connect('/clinicmanager/producesub', array('controller' => 'ownerclinics', 'action' => 'producesub','producesub'));
        Router::connect('/clinicmanager/openinghours', array('controller' => 'ownerclinics', 'action' => 'openinghours','openinghours'));
        
        //Manage Doctors 
       
        Router::connect('/clinicmanager/doctors', array('controller' => 'clinicdoctors', 'action' => 'doctors','doctors'));
        
        
        //managing Clinic exceptions
        
        Router::connect('/clinicmanager/clinicexceptions', array('controller' => 'ownerclinicexceptions', 'action' => 'index','index'));
        Router::connect('/clinicmanager/deleteexception', array('controller' => 'ownerclinicexceptions', 'action' => 'deleteexception'));
        Router::connect('/clinicmanager/addexception', array('controller' => 'ownerclinicexceptions', 'action' => 'addexception','addexception'));
        
        //common functionality
        Router::connect('/clinicmanager/slotlist', array('controller' => 'ownerclinicexceptions', 'action' => 'slotlist','slotlist'));
	Router::connect('/clinicmanager/slotlist2', array('controller' => 'appointments', 'action' => 'slotlist2','slotlist2'));
        
		
        
        ////////////////////////////////////////////administrator section//////////////////////////////////////////////
        
        //login & settings
        
        Router::connect('/administrator', array('controller' => 'admins', 'action' => 'index', 'index'));
	Router::connect('/administrator/dashboard', array('controller' => 'admins', 'action' => 'dashboard', 'dashboard'));
        Router::connect('/administrator/logincheck', array('controller' => 'admins', 'action' => 'logincheck'));
        Router::connect('/administrator/logout', array('controller' => 'admins', 'action' => 'logout'));
        Router::connect('/administrator/changepassword', array('controller' => 'admins', 'action' => 'changepassword'));
        
        //cms management links
        
        Router::connect('/administrator/cmsforpages', array('controller' => 'contents', 'action' => 'index','index'));
        Router::connect('/administrator/editcontent', array('controller' => 'contents', 'action' => 'editcontent','editcontent'));
        
        //speciality management links
        
        Router::connect('/administrator/specialitymaster', array('controller' => 'specialities', 'action' => 'index','index'));
        Router::connect('/administrator/editspeciality', array('controller' => 'specialities', 'action' => 'editspeciality','editspeciality'));
        Router::connect('/administrator/deletespeciality', array('controller' => 'specialities', 'action' => 'deletespeciality'));
        Router::connect('/administrator/addspeciality', array('controller' => 'specialities', 'action' => 'addspeciality','addspeciality'));
        
        //insurance management links
        
        Router::connect('/administrator/insurancemaster', array('controller' => 'insurances', 'action' => 'index','index'));
        Router::connect('/administrator/editinsurance', array('controller' => 'insurances', 'action' => 'editinsurance','editinsurance'));
        Router::connect('/administrator/deleteinsurance', array('controller' => 'insurances', 'action' => 'deleteinsurance'));
        Router::connect('/administrator/addinsurance', array('controller' => 'insurances', 'action' => 'addinsurance','addinsurance'));
        
        
         //eligibity management links
        
        Router::connect('/administrator/eligibilitymaster', array('controller' => 'eligibilities', 'action' => 'index','index'));
        Router::connect('/administrator/editeligibility', array('controller' => 'eligibilities', 'action' => 'editeligibility','editeligibility'));
        Router::connect('/administrator/deleteeligibility', array('controller' => 'eligibilities', 'action' => 'deleteeligibility'));
        Router::connect('/administrator/addeligibility', array('controller' => 'eligibilities', 'action' => 'addeligibility','addeligibility'));
        
        //managing clinic managers
        
        Router::connect('/administrator/clinicmanagers', array('controller' => 'clinicmanagers', 'action' => 'index','index'));
        Router::connect('/administrator/editclinicmanager', array('controller' => 'clinicmanagers', 'action' => 'editclinicmanager','editclinicmanager'));
        Router::connect('/administrator/deleteclinicmanager', array('controller' => 'clinicmanagers', 'action' => 'deleteclinicmanager'));
        Router::connect('/administrator/addclinicmanager', array('controller' => 'clinicmanagers', 'action' => 'addclinicmanager'));
        
        //managing users 
        
        Router::connect('/administrator/users', array('controller' => 'users', 'action' => 'index','index'));
        Router::connect('/administrator/edituser', array('controller' => 'users', 'action' => 'edituser','edituser'));
        Router::connect('/administrator/deleteuser', array('controller' => 'users', 'action' => 'deleteuser'));
        Router::connect('/administrator/adduser', array('controller' => 'users', 'action' => 'adduser','adduser'));
        
		//managing doctors 
        
        Router::connect('/administrator/doctors', array('controller' => 'doctors', 'action' => 'index','index'));
       // Router::connect('/administrator/edituser', array('controller' => 'users', 'action' => 'edituser','edituser'));
        Router::connect('/administrator/deletedoctors', array('controller' => 'doctors', 'action' => 'deletedoctors'));
       // Router::connect('/administrator/adduser', array('controller' => 'users', 'action' => 'adduser','adduser'));
	
        
        //managing Wall posts 
        
        Router::connect('/administrator/wallposts', array('controller' => 'wallposts', 'action' => 'index','index'));
        Router::connect('/administrator/viewwallpost', array('controller' => 'wallposts', 'action' => 'viewwallpost','viewwallpost'));
        
        //managing updates from the heart
        
        Router::connect('/administrator/updatesfromtheheart', array('controller' => 'updates', 'action' => 'index','index'));
        Router::connect('/administrator/editupdate', array('controller' => 'updates', 'action' => 'editupdate','editupdate'));
        Router::connect('/administrator/deleteupdate', array('controller' => 'updates', 'action' => 'deleteupdate'));
        Router::connect('/administrator/addupdate', array('controller' => 'updates', 'action' => 'addupdate','addupdate'));
        
        //managing clinics
        
        Router::connect('/administrator/clinics', array('controller' => 'clinics', 'action' => 'index','index'));
        Router::connect('/administrator/disapprovedclinics', array('controller' => 'clinics', 'action' => 'disapprovedclinics','disapprovedclinics'));
        Router::connect('/administrator/clinicsettings', array('controller' => 'clinics', 'action' => 'clinicsettings','clinicsettings'));
        Router::connect('/administrator/deleteclinic', array('controller' => 'clinics', 'action' => 'deleteclinic'));
        Router::connect('/administrator/addclinic', array('controller' => 'clinics', 'action' => 'addclinic','addclinic'));
        Router::connect('/administrator/disapproveclinic', array('controller' => 'clinics', 'action' => 'disapprove','disapprove'));
        Router::connect('/administrator/approveclinic', array('controller' => 'clinics', 'action' => 'approve','approve'));
        Router::connect('/administrator/producesub', array('controller' => 'clinics', 'action' => 'producesub','producesub'));
        Router::connect('/administrator/openinghours', array('controller' => 'clinics', 'action' => 'openinghours','openinghours'));
        
        //managing exceptions
        
        Router::connect('/administrator/clinicexceptions', array('controller' => 'clinicexceptions', 'action' => 'index','index'));
        Router::connect('/administrator/deleteexception', array('controller' => 'clinicexceptions', 'action' => 'deleteexception'));
        Router::connect('/administrator/addexception', array('controller' => 'clinicexceptions', 'action' => 'addexception','addexception'));
        
		//common functionality
       	Router::connect('/administrator/slotlist', array('controller' => 'clinicexceptions', 'action' => 'slotlist','slotlist'));
	Router::connect('/administrator/slotlist2', array('controller' => 'appointments', 'action' => 'slotlist2','slotlist2'));
        
        //managing appointments
        
        	Router::connect('/administrator/appointments', array('controller' => 'appointments', 'action' => 'index','index'));
		Router::connect('/administrator/deleteappointment', array('controller' => 'appointments', 'action' => 'deleteappointment','deleteappointment'));
                
                Router::connect('/administrator/approveappoints', array('controller' => 'appointments', 'action' => 'changestatus'));
                Router::connect('/administrator/pastappoinment', array('controller' => 'appointments', 'action' => 'pastappoinment'));
                
		Router::connect('/administrator/addappointment', array('controller' => 'appointments', 'action' => 'addappointment','addappointment'));
		Router::connect('/administrator/clinicownerappointments', array('controller' => 'appointments', 'action' => 'ownerappointment','ownerappointment'));
        	Router::connect('/administrator/clinicpendingappointments', array('controller' => 'appointments', 'action' => 'clinicpendingappoinment','clinicpendingappoinment'));
		
		
		
		
        /************************************managing messages**************************/
        
        //inbox
        
        Router::connect('/administrator/inbox', array('controller' => 'messages', 'action' => 'inbox','inbox'));
        Router::connect('/administrator/viewmessage', array('controller' => 'messages', 'action' => 'viewmessage','viewmessage'));
        Router::connect('/administrator/sendtotrash', array('controller' => 'messages', 'action' => 'sendtotrash','sendtotrash'));
        Router::connect('/administrator/composemessage', array('controller' => 'messages', 'action' => 'composemessage','composemessage'));
        Router::connect('/administrator/ajaxselectuser', array('controller' => 'messages', 'action' => 'ajaxselectuser'));
        
        //outbox
        
        Router::connect('/administrator/outbox', array('controller' => 'messages', 'action' => 'outbox'));
        Router::connect('/administrator/viewmessageoutbox', array('controller' => 'messages', 'action' => 'viewmessageoutbox','viewmessageoutbox'));
        Router::connect('/administrator/sendtotrashoutbox', array('controller' => 'messages', 'action' => 'sendtotrashoutbox','sendtotrashoutbox'));
        
         //draft
        
        Router::connect('/administrator/draft', array('controller' => 'messages', 'action' => 'draft','draft'));
        Router::connect('/administrator/sendtotrashdraft', array('controller' => 'messages', 'action' => 'sendtotrashdraft','sendtotrashdraft'));
        
        
        //compose,forward,reply,delete trush msg
        
        
        Router::connect('/administrator/reply', array('controller' => 'messages', 'action' => 'reply','reply'));
        Router::connect('/administrator/trash', array('controller' => 'messages', 'action' => 'trash','trash'));
	Router::connect('/administrator/restoretrashmsg', array('controller' => 'messages', 'action' => 'restoretrashmsg'));
	Router::connect('/administrator/forwardmessage', array('controller' => 'messages', 'action' => 'forwardmessage','forwardmessage'));
        //Router::connect('/administrator/deletetrushmsg', array('controller' => 'messages', 'action' => 'deletetrushmsg'));

	//managing Featured in company  name logo 
        
        Router::connect('/administrator/listfeaturein', array('controller' => 'companylogos', 'action' => 'index','index'));
        Router::connect('/administrator/editfeature', array('controller' => 'companylogos', 'action' => 'editfeature','editfeature'));
        Router::connect('/administrator/deletefeature', array('controller' => 'companylogos', 'action' => 'deletefeature'));
        Router::connect('/administrator/addfeature', array('controller' => 'companylogos', 'action' => 'addfeature','addfeature'));
        
        
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	//Router::connect('/*', array('controller' => 'users', 'action' => 'home','home'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
