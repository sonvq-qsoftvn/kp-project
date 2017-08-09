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
    
    function editSavedSubEvent($ses_user_id, $event_name_sp, $event_name_en, $short_desc_sp, $short_desc_en, $event_start_date_time, $event_start_ampm, $event_end_date_time, $event_end_ampm, $venue_state, $venue_county, $venue_city, $venue, $page_content_en, $page_content_sp, $event_tag, $file_name, $identical_function, $recurring, $sub_events, $Paypal, $Bank, $Oxxo, $Mobile, $Offline, $publish_date, $event_time, $event_time_period, $r_month, $r_month_day, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $r_span_start, $r_span_end, $event_start, $event_end, $all_day, $event_lasts, $attendees, $invitation_only, $password_protect_check, $pass_protected, $radio_access, $pay_ticket_fee, $promo_charge, $paper_less_mob_ticket, $print, $will_call, $status, $unique_id, $privacy, $event_id) {
        $connection = $this->connection();
        if($connection != null) {
            // prepare sql and bind parameters
            $stmt = $connection->prepare("UPDATE kcp_general_subevents
            SET event_name_sp = :event_name_sp, event_name_en = :event_name_en, 
            event_short_desc_en = :event_short_desc_en, event_short_desc_sp = :event_short_desc_sp, 
            admin_id = :admin_id, event_start_date_time = :event_start_date_time,            
            event_start_ampm = :event_start_ampm, event_end_date_time = :event_end_date_time, 
            event_end_ampm = :event_end_ampm, event_venue_state = :event_venue_state,
            event_venue_county = :event_venue_county, event_venue_city = :event_venue_city,
            event_venue = :event_venue, event_details_en = :event_details_en,
            event_details_sp = :event_details_sp, event_tag = :event_tag,
            event_photo = :event_photo, identical_function = :identical_function,
            recurring = :recurring, sub_events = :sub_events,
            Paypal = :Paypal, Bank_deposite = :Bank_deposite,
            Oxxo_Payment = :Oxxo_Payment, Mobile_Payment = :Mobile_Payment,
            Offline_Payment = :Offline_Payment, publish_date = :publish_date,
            event_time = :event_time, event_time_period = :event_time_period,
            r_month = :r_month, r_month_day = :r_month_day,
            mon = :mon, tue = :tue, wed = :wed, thu = :thu, fri = :fri, sat = :sat, sun = :sun,
            r_span_start = :r_span_start, r_span_end = :r_span_end,
            event_start = :event_start, event_end = :event_end,
            all_day = :all_day, event_lasts = :event_lasts,
            attendees_share = :attendees_share, attendees_invitation = :attendees_invitation,
            password_protect = :password_protect,
            password_protect_text = :password_protect_text,
            all_access = :all_access, include_promotion = :include_promotion,
            include_payment = :include_payment, paper_less_mob_ticket = :paper_less_mob_ticket,
            print = :print, will_call = :will_call, set_privacy = :set_privacy, status = :status
            WHERE unique_id = :unique_id");
            $stmt->bindParam(':event_name_sp', $event_name_sp);
            $stmt->bindParam(':event_name_en', $event_name_en);
            $stmt->bindParam(':event_short_desc_en', $short_desc_en);
            $stmt->bindParam(':event_short_desc_sp', $short_desc_sp);
            $stmt->bindParam(':admin_id', $ses_user_id);
            $stmt->bindParam(':event_start_date_time', $event_start_date_time);            
            $stmt->bindParam(':event_start_ampm', $event_start_ampm);            
            $stmt->bindParam(':event_end_date_time', $event_end_date_time);            
            $stmt->bindParam(':event_end_ampm', $event_end_ampm);
            $stmt->bindParam(':event_venue_state', $venue_state);
            $stmt->bindParam(':event_venue_county', $venue_county);
            $stmt->bindParam(':event_venue_city', $venue_city);
            $stmt->bindParam(':event_venue', $venue);
            $stmt->bindParam(':event_details_en', $page_content_en);
            $stmt->bindParam(':event_details_sp', $page_content_sp);
            $stmt->bindParam(':event_tag', $event_tag);
            $stmt->bindParam(':event_photo', $file_name);
            $stmt->bindParam(':identical_function', $identical_function);
            $stmt->bindParam(':recurring', $recurring);
            $stmt->bindParam(':sub_events', $sub_events);
            $stmt->bindParam(':Paypal', $Paypal);
            $stmt->bindParam(':Bank_deposite', $Bank);
            $stmt->bindParam(':Oxxo_Payment', $Oxxo);
            $stmt->bindParam(':Mobile_Payment', $Mobile);
            $stmt->bindParam(':Offline_Payment', $Offline);
            $stmt->bindParam(':publish_date', $publish_date);
            $stmt->bindParam(':event_time', $event_time);
            $stmt->bindParam(':event_time_period', $event_time_period);
            $stmt->bindParam(':r_month', $r_month);
            $stmt->bindParam(':r_month_day', $r_month_day);
            $stmt->bindParam(':mon', $mon);
            $stmt->bindParam(':tue', $tue);
            $stmt->bindParam(':wed', $wed);
            $stmt->bindParam(':thu', $thu);
            $stmt->bindParam(':fri', $fri);
            $stmt->bindParam(':sat', $sat);
            $stmt->bindParam(':sun', $sun);
            $stmt->bindParam(':r_span_start', $r_span_start);
            $stmt->bindParam(':r_span_end', $r_span_end);
            $stmt->bindParam(':event_start', $event_start);
            $stmt->bindParam(':event_end', $event_end);
            $stmt->bindParam(':all_day', $all_day);
            $stmt->bindParam(':event_lasts', $event_lasts);
            $stmt->bindParam(':attendees_share', $attendees);
            $stmt->bindParam(':attendees_invitation', $invitation_only);
            $stmt->bindParam(':password_protect', $password_protect_check);
            $stmt->bindParam(':password_protect_text', $pass_protected);
            $stmt->bindParam(':all_access', $radio_access);
            $stmt->bindParam(':include_promotion', $promo_charge);
            $stmt->bindParam(':include_payment', $pay_ticket_fee);
            $stmt->bindParam(':paper_less_mob_ticket', $paper_less_mob_ticket);
            $stmt->bindParam(':print', $print);
            $stmt->bindParam(':will_call', $will_call);
            $stmt->bindParam(':set_privacy', $privacy);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':unique_id', $unique_id);
            $stmt->execute();
            return true;
        }
        return false;
    }
    
    function addSubEvent($event_name_sp,$event_name_en,$short_desc_sp,$short_desc_en,$event_start_date_time,$event_start_ampm,$event_end_date_time,$event_end_ampm,$venue_state,$venue_county,$venue_city,$venue,$page_content_en,$page_content_sp,$event_tag,$file_name,$identical_function,$recurring,$sub_events,$Paypal,$Bank,$Oxxo,$Mobile,$Offline,$publish_date,$event_time,$event_time_period,$r_month,$r_month_day,$mon,$tue,$wed,$thu,$fri,$sat,$sun,$r_span_start,$r_span_end,$event_start,$event_end,$all_day,$event_lasts,$attendees,$invitation_only,$password_protect_check,$pass_protected,$radio_access,$pay_ticket_fee,$promo_charge,$paper_less_mob_ticket,$print,$will_call,$event_id,$status,$unique_id,$privacy,$event_id) {
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
		$identical_function = empty($identical_function) ? 0 : $identical_function;
		$recurring = empty($recurring) ? 0 : $recurring;
		$sub_events = empty($sub_events) ? 0 : $sub_events;
		$Paypal = empty($Paypal) ? '' : $Paypal;
		$Bank = empty($Bank) ? '' : $Bank;
		$Oxxo = empty($Oxxo) ? '' : $Oxxo;
		$Mobile = empty($Mobile) ? '' : $Mobile;
		$Offline = empty($Offline) ? '' : $Offline;
		$event_time = empty($event_time) ? '' : $event_time;
		$event_time_period = empty($event_time_period) ? '' : $event_time_period;
		$r_month = empty($r_month) ? '' : $r_month;
		$r_month_day = empty($r_month_day) ? '' : $r_month_day;
		$mon = empty($mon) ? 0 : $mon;
		$tue = empty($tue) ? 0 : $tue;
		$wed = empty($wed) ? 0 : $wed;
		$thu = empty($thu) ? 0 : $thu;
		$fri = empty($fri) ? 0 : $fri;
		$sat = empty($sat) ? 0 : $sat;
		$sun = empty($sun) ? 0 : $sun;
		$r_span_start = empty($r_span_start) ? '0000-00-00' : $r_span_start;
		$r_span_end = empty($r_span_end) ? '0000-00-00' : $r_span_end;
		$event_start = empty($event_start) ? '' : $event_start;
		$event_end = empty($event_end) ? '' : $event_end;
		$all_day = empty($all_day) ? 0 : $all_day;
		$event_lasts = empty($event_lasts) ? '' : $event_lasts;
		$attendees = empty($attendees) ? 0 : $attendees;
		$invitation_only = empty($invitation_only) ? 0 : $invitation_only;
		$password_protect_check = empty($password_protect_check) ? 0 : $password_protect_check;
		$paper_less_mob_ticket = empty($paper_less_mob_ticket) ? 0 : $paper_less_mob_ticket;
		$print = empty($print) ? 0 : $print;
		$will_call = empty($will_call) ? 0 : $will_call;



        $currentTime = time();
        $connection = $this->connection();
        if($connection != null) {
            // prepare sql and bind parameters
            $stmt = $connection->prepare("INSERT INTO kcp_general_subevents SET
            parent_id = :parent_id,
            event_name_sp = :event_name_sp, event_name_en = :event_name_en, 
            event_short_desc_en = :event_short_desc_en, event_short_desc_sp = :event_short_desc_sp, 
            admin_id = :admin_id, event_start_date_time = :event_start_date_time,            
            event_start_ampm = :event_start_ampm, event_end_date_time = :event_end_date_time, 
            event_end_ampm = :event_end_ampm, event_venue_state = :event_venue_state,
            event_venue_county = :event_venue_county, event_venue_city = :event_venue_city,
            event_venue = :event_venue, event_details_en = :event_details_en,
            event_details_sp = :event_details_sp, event_tag = :event_tag,
            event_photo = :event_photo, identical_function = :identical_function,
            recurring = :recurring, sub_events = :sub_events,
            Paypal = :Paypal, Bank_deposite = :Bank_deposite,
            Oxxo_Payment = :Oxxo_Payment, Mobile_Payment = :Mobile_Payment,
            Offline_Payment = :Offline_Payment, publish_date = :publish_date,
            event_time = :event_time, event_time_period = :event_time_period,
            r_month = :r_month, r_month_day = :r_month_day,
            mon = :mon, tue = :tue, wed = :wed, thu = :thu, fri = :fri, sat = :sat, sun = :sun,
            r_span_start = :r_span_start, r_span_end = :r_span_end,
            event_start = :event_start, event_end = :event_end,
            all_day = :all_day, event_lasts = :event_lasts,
            attendees_share = :attendees_share, attendees_invitation = :attendees_invitation,
            password_protect = :password_protect,
            password_protect_text = :password_protect_text,
            all_access = :all_access, include_promotion = :include_promotion,
            include_payment = :include_payment, paper_less_mob_ticket = :paper_less_mob_ticket,
            print = :print, will_call = :will_call, set_privacy = :set_privacy, status = :status,
            unique_id = :unique_id, post_date = :post_date");
            $stmt->bindParam(':admin_id', $_SESSION['ses_user_id']);
            $stmt->bindParam(':parent_id', $event_id);            
            $stmt->bindParam(':event_name_sp', $event_name_sp);
            $stmt->bindParam(':event_name_en', $event_name_en);
            $stmt->bindParam(':event_short_desc_en', $short_desc_en);
            $stmt->bindParam(':event_short_desc_sp', $short_desc_sp);
            $stmt->bindParam(':event_start_date_time', $event_start_date_time);            
            $stmt->bindParam(':event_start_ampm', $event_start_ampm);            
            $stmt->bindParam(':event_end_date_time', $event_end_date_time);            
            $stmt->bindParam(':event_end_ampm', $event_end_ampm);
            $stmt->bindParam(':event_venue_state', $venue_state);
            $stmt->bindParam(':event_venue_county', $venue_county);
            $stmt->bindParam(':event_venue_city', $venue_city);
            $stmt->bindParam(':event_venue', $venue);
            $stmt->bindParam(':event_details_en', $page_content_en);
            $stmt->bindParam(':event_details_sp', $page_content_sp);
            $stmt->bindParam(':event_tag', $event_tag);
            $stmt->bindParam(':event_photo', $file_name);
            $stmt->bindParam(':identical_function', $identical_function);
            $stmt->bindParam(':recurring', $recurring);
            $stmt->bindParam(':sub_events', $sub_events);
            $stmt->bindParam(':Paypal', $Paypal);
            $stmt->bindParam(':Bank_deposite', $Bank);
            $stmt->bindParam(':Oxxo_Payment', $Oxxo);
            $stmt->bindParam(':Mobile_Payment', $Mobile);
            $stmt->bindParam(':Offline_Payment', $Offline);
            $stmt->bindParam(':publish_date', $publish_date);
            $stmt->bindParam(':event_time', $event_time);
            $stmt->bindParam(':event_time_period', $event_time_period);
            $stmt->bindParam(':r_month', $r_month);
            $stmt->bindParam(':r_month_day', $r_month_day);
            $stmt->bindParam(':mon', $mon);
            $stmt->bindParam(':tue', $tue);
            $stmt->bindParam(':wed', $wed);
            $stmt->bindParam(':thu', $thu);
            $stmt->bindParam(':fri', $fri);
            $stmt->bindParam(':sat', $sat);
            $stmt->bindParam(':sun', $sun);
            $stmt->bindParam(':r_span_start', $r_span_start);
            $stmt->bindParam(':r_span_end', $r_span_end);
            $stmt->bindParam(':event_start', $event_start);
            $stmt->bindParam(':event_end', $event_end);
            $stmt->bindParam(':all_day', $all_day);
            $stmt->bindParam(':event_lasts', $event_lasts);
            $stmt->bindParam(':attendees_share', $attendees);
            $stmt->bindParam(':attendees_invitation', $invitation_only);
            $stmt->bindParam(':password_protect', $password_protect_check);
            $stmt->bindParam(':password_protect_text', $pass_protected);
            $stmt->bindParam(':all_access', $radio_access);
            $stmt->bindParam(':include_promotion', $promo_charge);
            $stmt->bindParam(':include_payment', $pay_ticket_fee);
            $stmt->bindParam(':paper_less_mob_ticket', $paper_less_mob_ticket);
            $stmt->bindParam(':print', $print);
            $stmt->bindParam(':will_call', $will_call);
            $stmt->bindParam(':set_privacy', $privacy);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':unique_id', $unique_id);
            $stmt->bindParam(':post_date', $currentTime);
            $stmt->execute();
            return $connection->lastInsertId();
        }
        return false;
        
    }

    function addPage($page_name, $title_sp, $page_content, $page_content_sp, $page_link, 
            $social, $path, $file_name, $publish) {

        $connection = $this->connection();
        
        if($connection != null) {
            // prepare sql and bind parameters
            $stmt = $connection->prepare("INSERT INTO kcp_page 
            SET page_name = :page_name, title_sp = :title_sp, page_content = :page_content, page_content_sp = :page_content_sp, 
            page_link = :page_link, path = :path, social = :social, photo = :photo, create_time = :create_time, publish = :publish");
            $stmt->bindParam(':page_name', $page_name);
            $stmt->bindParam(':title_sp', $title_sp);
            $stmt->bindParam(':page_content', $page_content);
            $stmt->bindParam(':page_content_sp', $page_content_sp);
            $stmt->bindParam(':page_link', $page_link);
            $stmt->bindParam(':path', $path);
            $stmt->bindParam(':social', $social);
            $stmt->bindParam(':photo', $file_name);
            $stmt->bindParam(':create_time', time());
            $stmt->bindParam(':publish', $publish);

            $stmt->execute();
            return $connection->lastInsertId();
        }
        return false;
    }

}
