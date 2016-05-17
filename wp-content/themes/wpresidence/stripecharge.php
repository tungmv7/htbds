<?php
// Template Name:Stripe Charge Page
// Wp Estate Pack
require_once('libs/stripe/lib/Stripe.php');
$allowed_html =array();

$stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
$stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );
$stripe = array(
    "secret_key"      => $stripe_secret_key,
    "publishable_key" => $stripe_publishable_key
);
Stripe::setApiKey($stripe['secret_key']);     
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////webhook part
//////////////////////////////////////////////////////////////////////////////////////////////////



// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);








if( is_email($_POST['stripeEmail']) ){
   $stripeEmail=  wp_kses ( esc_html($_POST['stripeEmail']) ,$allowed_html);  
}else{
    exit('none mail');
}

if( isset($_POST['userID']) && !is_numeric( $_POST['userID'] ) ){
    exit();
}

if( isset($_POST['invoice_id']) && !is_numeric( $_POST['invoice_id'] ) ){
    exit();
}

if( isset($_POST['booking_id']) && !is_numeric( $_POST['booking_id'] ) ){
    exit();
}

if( isset($_POST['depozit']) && !is_numeric( $_POST['depozit'] ) ){
    exit();
}

if( isset($_POST['pack_id']) && !is_numeric( $_POST['pack_id'] ) ){
    exit();
}

if( isset($_POST['pay_ammout']) && !is_numeric( $_POST['pay_ammout'] ) ){
    exit();
}

if( isset($_POST['stripe_recuring']) && !is_numeric( $_POST['stripe_recuring'] ) ){
    exit();
}

if( isset($_POST['submission_pay']) && !is_numeric( $_POST['submission_pay'] ) ){
    exit();
}

if( isset($_POST['propid']) && !is_numeric( $_POST['propid'] ) ){
    exit();
}

if( isset($_POST['featured_pay']) && !is_numeric( $_POST['featured_pay'] ) ){
    exit();
}

if( isset($_POST['is_upgrade']) && !is_numeric( $_POST['is_upgrade'] ) ){
    exit();
}



$current_user = wp_get_current_user();
$userID         =   $current_user->ID;
$user_email     =   $current_user->user_email;
$username       =   $current_user->user_login;
$submission_curency_status = esc_html( get_option('wp_estate_submission_curency','') );

////////////////////////////////////////////////////////////////////////////////
///////////////// payment for booking 
////////////////////////////////////////////////////////////////////////////////
if ( isset($_POST['booking_id']) ){
    // do nothing    
}else if ( isset ($_POST['submission_pay'])  && $_POST['submission_pay']==1  ){
    ////////////////////////////////////////////////////////////////////////////////
    ////////////////// payment for submission
    ////////////////////////////////////////////////////////////////////////////////    
    try {
        $token  = wp_kses ( $_POST['stripeToken'] ,$allowed_html);
        $customer = Stripe_Customer::create(array(
            'email' => $stripeEmail,
            'card'  => $token
        ));

        $userId         =   intval($_POST['userID']);
        $listing_id     =   intval($_POST['propid']);
        $pay_ammout     =   intval($_POST['pay_ammout']);
        $is_featured    =   0;
        $is_upgrade     =   0;
        
        if ( isset($_POST['featured_pay']) && $_POST['featured_pay']==1 ){
            $is_featured    =   intval($_POST['featured_pay']);
        }

        if ( isset($_POST['is_upgrade']) && $_POST['is_upgrade']==1 ){
            $is_upgrade    =   intval($_POST['is_upgrade']);
        }
        
        $charge = Stripe_Charge::create(array(
            'customer' => $customer->id,
            'amount'   => $pay_ammout,
            'currency' => $submission_curency_status
        ));
        
      
        $time = time(); 
        $date = date('Y-m-d H:i:s',$time);
    
        if($is_upgrade==1){
            update_post_meta($listing_id, 'prop_featured', 1);
            $invoice_id = wpestate_insert_invoice('Upgrade to Featured','One Time',$listing_id,$date,$current_user->ID,0,1,'' );
            wpestate_email_to_admin(1);
            update_post_meta($invoice_id, 'pay_status', 1); 
        }else{
            update_post_meta($listing_id, 'pay_status', 'paid');
            // if admin does not need to approve - make post status as publish
            $admin_submission_status = esc_html ( get_option('wp_estate_admin_submission','') );
            $paid_submission_status  = esc_html ( get_option('wp_estate_paid_submission','') );

            if($admin_submission_status=='no'  && $paid_submission_status=='per listing' ){

                $post = array(
                    'ID'            => $listing_id,
                    'post_status'   => 'publish'
                    );
                 $post_id =  wp_update_post($post ); 
            }
        // end make post publish


        if($is_featured==1){
            update_post_meta($listing_id, 'prop_featured', 1);
            $invoice_id = wpestate_insert_invoice('Publish Listing with Featured','One Time',$listing_id,$date,$current_user->ID,1,0,'' );
        }else{
            $invoice_id = wpestate_insert_invoice('Listing','One Time',$listing_id,$date,$current_user->ID,0,0,'' );
        }
        update_post_meta($invoice_id, 'pay_status', 1); 
        wpestate_email_to_admin(0);
        }
        
        $redirect = get_dashboard_link();
      wp_redirect($redirect);exit;
        
    
       
        
    }
    catch (Exception $e) {
      $error = '<div class="alert alert-danger">
                        <strong>Error!</strong> '.$e->getMessage().'
                        </div>';
      print $error;
    }
    
    
    
    
    
    
    
    
    
    
    
}else if ( isset ($_POST['stripe_recuring'] ) && $_POST['stripe_recuring'] ==1 ) { 
////////////////////////////////////////////////////////////////////////////////
////////////////// payment for pack recuring
////////////////////////////////////////////////////////////////////////////////    
    try {
        $dash_profile_link = get_dashboard_profile_link();
        $token          =   wp_kses ( esc_html($_POST['stripeToken']) ,$allowed_html);
        $pack_id        =   intval($_POST['pack_id']);
        $stripe_plan    =   esc_html(get_post_meta($pack_id, 'pack_stripe_id', true));

        $customer = Stripe_Customer::create(array(
            "card" =>  $token,
            "plan" =>  $stripe_plan,
            "email" => $stripeEmail
        ));
        
        $stripe_customer_id=$customer->id;
        $subscription_id = $customer->subscriptions['data'][0]['id'];
       
        
        
 
        if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
            wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
            wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
        }else{
            wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
        }      
        // wp_redirect( $dash_profile_link );  exit;
        
        $current_stripe_customer_id =  get_user_meta( $current_user->ID, 'stripe', true );
        $is_stripe_recurring        =   get_user_meta( $current_user->ID, 'has_stripe_recurring',true );
        if ($current_stripe_customer_id !=='' && $is_stripe_recurring==1){
            if( $current_stripe_customer_id !== $stripe_customer_id ){
                wpestate_stripe_cancel_subscription_on_upgrade();
            }
        }
        
        
        update_user_meta( $current_user->ID, 'stripe', $stripe_customer_id );
        update_user_meta( $current_user->ID, 'stripe_subscription_id', $subscription_id );
        update_user_meta( $current_user->ID, 'has_stripe_recurring',1 );
       
        
        
        
        wp_redirect( $dash_profile_link ); exit;
 
    }
    catch (Exception $e) {
        $error = '<div class="alert alert-danger">
                          <strong>Error!</strong> '.$e->getMessage().'
                          </div>';
        print $error;
    }
 
    
    
    

    
}else{

////////////////////////////////////////////////////////////////////////////////
////////////////// payment for pack
////////////////////////////////////////////////////////////////////////////////  
    try {
        $dash_profile_link = get_dashboard_profile_link();

        $token  = wp_kses (esc_html($_POST['stripeToken']),$allowed_html);
        $customer = Stripe_Customer::create(array(
            'email' => $stripeEmail,
            'card'  => $token
        ));

        $userId     =   intval($_POST['userID']);
        $pay_ammout =   intval($_POST['pay_ammout']);
        $pack_id    =   intval($_POST['pack_id']);
        $charge     =   Stripe_Charge::create(array(
                        'customer' => $customer->id,
                        'amount'   => $pay_ammout,
                        'currency' => $submission_curency_status
        ));


    
        if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
            wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
            wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
        }else{
            wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
        }      
        
        /*
        print_r($customer);
     
        $stripe_customer_id=$customer->id;
        $subscription_id = $customer->subscriptions['data'][0]['id'];
        $current_stripe_customer_id =   get_user_meta( $current_user->ID, 'stripe', true );
        $is_stripe_recurring        =   get_user_meta( $current_user->ID, 'has_stripe_recurring',true );
       
        if ($current_stripe_customer_id !=='' && $is_stripe_recurring==1){
            if( $current_stripe_customer_id !== $stripe_customer_id ){
                wpestate_stripe_cancel_subscription_on_upgrade();
            }
        }
      */
        
        update_user_meta( $current_user->ID, 'has_stripe_recurring',0 );
        wp_redirect( $dash_profile_link );  exit;
    
    }
    catch (Exception $e) {
        $error = '<div class="alert alert-danger">
                          <strong>Error!</strong> '.$e->getMessage().'
                          </div>';
        print $error;
    }
    
    
}

  
function wpestate_stripe_cancel_subscription_on_upgrade(){
    global $current_user;  
    require_once(get_template_directory().'/libs/stripe/lib/Stripe.php');
    
    $current_user = wp_get_current_user();
    $userID                 =   $current_user->ID;

    $stripe_customer_id =  get_user_meta( $userID, 'stripe', true );
    $subscription_id =     get_user_meta( $userID, 'stripe_subscription_id', true );
    
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );

    $stripe = array(
        "secret_key"      => $stripe_secret_key,
        "publishable_key" => $stripe_publishable_key
    );

    Stripe::setApiKey($stripe['secret_key']);
   
    $submission_curency_status = esc_html( get_option('wp_estate_submission_curency','') );
 
    
    $cu = Stripe_Customer::retrieve($stripe_customer_id);
    $cu->subscriptions->retrieve($subscription_id)->cancel(
    array("at_period_end" => true ));
    update_user_meta( $current_user->ID, 'stripe_subscription_id', '' );
}




?>