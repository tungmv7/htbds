<?php
//////////////////////////////////////////////////////////////////////////////////////
//// Call zillow
//////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_call_zillow') ):
function wpestate_call_zillow( $sell_estimate_adr,$sell_estimate_city,$sell_estimate_state){
    $key =  esc_html ( get_option('wp_estate_zillow_api_key','') );
    $return_array=array();
   
    
    $addr   =   urlencode ($sell_estimate_adr);
    $city   =   urlencode ($sell_estimate_city);
    $state  =   urlencode ($sell_estimate_state);
    
    $location=$city.','.$state;
     $url="http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=".$key."&address=".$addr."&citystatezip=".$location ; 
    
    $xml = simplexml_load_file($url) 
        or die("Error: Could not connect to Zillow API");

  
 
    if(  $xml->message[0]->code[0] >= 500  ){
         $return_array['suma']=0;
    }else{
        $return_array['suma']=    $xml->response[0]->results[0]->result[0]->zestimate[0]->amount[0];
        $return_array['data']=    $xml->response[0]->results[0]->result[0]->zestimate[0]->{'last-updated'}[0];
            
    }
     return $return_array; 
}
endif;
////////////////////////////////////////////////////////////////////////////////
/// Facebook  Login
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_facebook_login') ):

function estate_facebook_login($get_vars){
    require 'resources/facebook.php';
       
   
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    $facebook = new Facebook(array(
        'appId'  => $facebook_api,
        'secret' => $facebook_secret,
        'cookie' => true
     ));
    $secret      =   $facebook_secret;
    $params = array(
        'redirect_uri' => get_dashboard_profile_link(),
        'scope' => 'email',
        );
    
   
    $login_url   =   $facebook->getLoginUrl($params); 
   $user_id     =   $facebook->getUser();

  if($user_id==0){
      $login_url = $facebook->getLoginUrl($params); 
      wp_redirect($login_url);exit;
  }else{
        $user_profile = $facebook->api('/me?fields=id,email,name','GET');
        //print_r($user_profile);
   
        if(isset($user_profile['last_name'])){
            $full_name=$user_profile['first_name']. $user_profile['last_name'];
        }
        
        if(isset($user_profile['name'])){
            $full_name=$user_profile['name'];
        }
        
        if(isset($user_profile['email'])){
            $email=$user_profile['email'];
        }else{
            $email=$full_name.'@facebook.com';
        }
        
        
        $identity_code=$secret.$user_profile['id'];  
        wpestate_register_user_via_google($email,$full_name,$identity_code); 
        $info                   = array();
        $info['user_login']     = $full_name;
        $info['user_password']  = $identity_code;
        $info['remember']       = true;
       
        $user_signon            = wp_signon( $info, true );
        
        
        if ( is_wp_error($user_signon) ){ 
            wp_redirect( home_url() ); exit;
        }else{
            wpestate_update_old_users($user_signon->ID);
            wp_redirect(get_dashboard_profile_link());exit;
        }
        
                
  }
}

endif; // end   estate_facebook_login 





////////////////////////////////////////////////////////////////////////////////
/// estate_google_oauth_login  Login
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_google_oauth_login') ):

function estate_google_oauth_login($get_vars){
    set_include_path( get_include_path() . PATH_SEPARATOR . get_template_directory().'/libs/resources');
    $allowed_html   =   array();
    require_once 'src/Google_Client.php';
    require_once 'src/contrib/Google_Oauth2Service.php';
    $google_client_id       =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    $google_client_secret   =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    $google_redirect_url    =   get_dashboard_profile_link();
    $google_developer_key   =   esc_html ( get_option('wp_estate_google_api_key','') );

    $gClient = new Google_Client();
    $gClient->setApplicationName('Login to WpResidence');
    $gClient->setClientId($google_client_id);
    $gClient->setClientSecret($google_client_secret);
    $gClient->setRedirectUri($google_redirect_url);
    $gClient->setDeveloperKey($google_developer_key);
    $google_oauthV2 = new Google_Oauth2Service($gClient);
    
    if (isset($_GET['code'])) { 
        $code= esc_html( wp_kses($_GET['code'],$allowed_html ) );
        $gClient->authenticate($code);
    }
    
    
    
    if ($gClient->getAccessToken()) 
    {     
        $allowed_html      =   array();
        $dashboard_url     =   get_dashboard_profile_link();
        $user              =   $google_oauthV2->userinfo->get();
        $user_id           =   $user['id'];
        $full_name         =   wp_kses($user['name'], $allowed_html);
        $email             =   wp_kses($user['email'], $allowed_html);
       // $profile_url                      = filter_var($user['link'], FILTER_VALIDATE_URL);
       // $profile_image_url                = filter_var($user['picture'], FILTER_VALIDATE_URL);
       
        
        
        
        $full_name=  str_replace(' ','.',$full_name);  
        wpestate_register_user_via_google($email,$full_name,$user_id); 
        $wordpress_user_id=username_exists($full_name);
        wp_set_password( $code, $wordpress_user_id ) ;
        
        $info                   = array();
        $info['user_login']     = $full_name;
        $info['user_password']  = $code;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
        
 
        
        if ( is_wp_error($user_signon) ){ 
            wp_redirect( home_url() );  exit;
        }else{
            wpestate_update_old_users($user_signon->ID);
            wp_redirect($dashboard_url);exit;
        }
    }
    
    
    
}

endif; // end   estate_google_oauth_login 

////////////////////////////////////////////////////////////////////////////////
/// Open ID Login
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_open_id_login') ):

function estate_open_id_login($get_vars){
    require 'resources/openid.php';  
    $openid         =   new LightOpenID( wpestate_get_domain_openid() );
    $allowed_html   =   array();
    if( $openid->validate() ){
        
        $dashboard_url          =   get_dashboard_profile_link();
        $openid_identity        =   wp_kses( $get_vars['openid_identity'],$allowed_html);
        $openid_identity_check  =   wp_kses( $get_vars['openid_identity'],$allowed_html);
        
        
        if(strrpos  ($openid_identity_check,'google') ){
            $email                  =   wp_kses ( $get_vars['openid_ext1_value_contact_email'],$allowed_html );
            $last_name              =   wp_kses ( $get_vars['openid_ext1_value_namePerson_last'],$allowed_html );
            $first_name             =   wp_kses ( $get_vars['openid_ext1_value_namePerson_first'],$allowed_html );
            $full_name              =   $first_name.$last_name;
            $openid_identity_pos    =   strrpos  ($openid_identity,'id?id=');
            $openid_identity        =   str_split($openid_identity, $openid_identity_pos+6);
            $openid_identity_code   =   $openid_identity[1]; 
        }
        
        if(strrpos  ($openid_identity_check,'yahoo')){
            $email                  =   wp_kses ( $get_vars['openid_ax_value_email'] ,$allowed_html);
            $full_name              =   wp_kses ( str_replace(' ','.',$get_vars['openid_ax_value_fullname']) ,$allowed_html);            
            $openid_identity_pos    =   strrpos  ($openid_identity,'/a/.');
            $openid_identity        =   str_split($openid_identity, $openid_identity_pos+4);
            $openid_identity_code   =   $openid_identity[1]; 
        }
       
        wpestate_register_user_via_google($email,$full_name,$openid_identity_code); 
        $info                   = array();
        $info['user_login']     = $full_name;
        $info['user_password']  = $openid_identity_code;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
        
 
        
        if ( is_wp_error($user_signon) ){ 
            wp_redirect( home_url() );  exit;
        }else{
            wpestate_update_old_users($user_signon->ID);
            wp_redirect($dashboard_url);exit;
        }
           
     } 
   }// end  estate_open_id_login
endif; // end   estate_open_id_login  







////////////////////////////////////////////////////////////////////////////////
/// Twiter API v1.1 functions
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('getConnectionWithAccessToken') ):
 function getConnectionWithAccessToken($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret) {
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
    return $connection;
} 
endif;
                
//convert links to clickable format
if( !function_exists('wpestate_convert_links') ):
function wpestate_convert_links($status,$targetBlank=true,$linkMaxLen=250){
    // the target
    $target=$targetBlank ? " target=\"_blank\" " : "";

    // convert link to url
    /*$status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

    
    $result = preg_replace(
    "/\{([<>])([a-zA-Z0-9_]*)(\?{0,1})([a-zA-Z0-9_]*)\}(.*)\{\\1\/\\2\}/iseU", 
    "CallFunction('\\1','\\2','\\3','\\4','\\5')",
    $result
);
    */
    $status = preg_replace_callback(
    "/((http:\/\/|https:\/\/)[^ )]+)/",
    function($m,$target,$linkMaxLen) { 
        return "'<a href=\"$m[1]\" title=\"$m[1]\" $target >'. ((strlen('$m[1]')>=$linkMaxLen ? substr('$m[1]',0,$linkMaxLen).'...':'$m[1]')).'</a>'"; 
    },
    $status
);
    
    // convert @ to follow
    $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

    // convert # to search
    $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

    // return the status
    return $status;
}
endif;

                

//convert dates to readable format	
if( !function_exists('wpestate_relative_time') ):
function wpestate_relative_time($a) {
        //get current timestampt
        $b = strtotime("now"); 
        //get timestamp when tweet created
        $c = strtotime($a);
        //get difference
        $d = $b - $c;
        //calculate different time values
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;

        if(is_numeric($d) && $d > 0) {
                //if less then 3 seconds
                if($d < 3) return __("right now","wpestate");
                //if less then minute
                if($d < $minute) return floor($d) .__( " seconds ago","wpestate");
                //if less then 2 minutes
                if($d < $minute * 2) return __("about 1 minute ago","wpestate");
                //if less then hour
                if($d < $hour) return floor($d / $minute) . __(" minutes ago","wpestate");
                //if less then 2 hours
                if($d < $hour * 2) return __("about 1 hour ago","wpestate");
                //if less then day
                if($d < $day) return floor($d / $hour) . __(" hours ago","wpestate");
                //if more then day, but less then 2 days
                if($d > $day && $d < $day * 2) return __("yesterday","wpestate");
                //if less then year
                if($d < $day * 365) return floor($d / $day) .__( " days ago","wpestate");
                //else return more than a year
                return __("over a year ago","wpestate");
        }
    }

endif; 

///////////////////////////////////////////////////////////////////////////////////////////
// register google user
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_register_user_via_google') ):
    
function wpestate_register_user_via_google($email,$full_name,$openid_identity_code){
  
   if ( email_exists( $email ) ){ 
   
           if(username_exists($full_name) ){
               return;
           }else{
               $user_id  = wp_create_user( $full_name, $openid_identity_code,' ' );  
               wpestate_update_profile($user_id); 
               if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
                    wpestate_register_as_user($full_name,$user_id);
               }
           }
          
    }else{
      
          if(username_exists($full_name) ){
                return;
           }else{
                $user_id  = wp_create_user( $full_name, $openid_identity_code, $email ); 
                wpestate_update_profile($user_id);
                if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
                         wpestate_register_as_user($full_name,$user_id);
                }
           }
     
    }
   
}
endif; // end   wpestate_register_user_via_google 




///////////////////////////////////////////////////////////////////////////////////////////
// get domain open id
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_domain_openid') ):

function wpestate_get_domain_openid(){
    $realm_url = get_home_url();
    $realm_url= str_replace('http://','',$realm_url);
    $realm_url= str_replace('https://','',$realm_url);  
    return $realm_url;
}

endif; // end   wpestate_get_domain_openid 





///////////////////////////////////////////////////////////////////////////////////////////
// paypal functions - get acces token
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_access_token') ):

function wpestate_get_access_token($url, $postdata) {
	$clientId                       =   esc_html( get_option('wp_estate_paypal_client_id','') );
        $clientSecret                   =   esc_html( get_option('wp_estate_paypal_client_secret','') );
       
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
	curl_setopt($curl, CURLOPT_HEADER, false); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
#	curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
		//echo "Time took: " . $info['total_time']*1000 . "ms\n";
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}

	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode( $response );
	return $jsonResponse->access_token;
}

endif; // end   wpestate_get_access_token 


///////////////////////////////////////////////////////////////////////////////////////////
// paypal functions - make post call
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_make_post_call') ):

function wpestate_make_post_call($url, $postdata,$token) {
	//global $token;
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer '.$token,
				'Accept: application/json',
				'Content-Type: application/json'
				));
	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
	#curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
	$response = curl_exec( $curl );
	if (empty($response)) {
	    // some kind of an error happened
	    die(curl_error($curl));
	    curl_close($curl); // close cURL handler
	} else {
	    $info = curl_getinfo($curl);
		//echo "Time took: " . $info['total_time']*1000 . "ms\n";
	    curl_close($curl); // close cURL handler
		if($info['http_code'] != 200 && $info['http_code'] != 201 ) {
			echo "Received error: " . $info['http_code']. "\n";
			echo "Raw response:".$response."\n";
			die();
	    }
	}

	// Convert the result from JSON format to a PHP array 
	$jsonResponse = json_decode($response, TRUE);
	return $jsonResponse;
}

endif; // end   wpestate_make_post_call 
?>
