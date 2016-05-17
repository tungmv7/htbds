<?php
///////////////////////////////////////////////////////////////////////////////////////////
/////// Theme Setup
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_setup') ):
function wp_estate_setup() {    
      if (isset($_GET['activated']) && is_admin()){
             ////////////////////  insert comapre and advanced search page
        $page_check = get_page_by_title('Compare Listings');
        if (!isset($page_check->ID)) {
            $my_post = array(
                'post_title' => 'Compare Listings',
                'post_type' => 'page',
                'post_status' => 'publish',
            );
            $new_id = wp_insert_post($my_post);
            update_post_meta($new_id, '_wp_page_template', 'compare_listings.php');
        }
        
        
        ////////////////////  insert comapre and advanced search page 
        $page_check = get_page_by_title('Advanced Search');
        if (!isset($page_check->ID)) {
            $my_post = array(
                'post_title' => 'Advanced Search',
                'post_type' => 'page',
                'post_status' => 'publish',
            );
            $new_id = wp_insert_post($my_post);
            update_post_meta($new_id, '_wp_page_template', 'advanced_search_results.php');
        }
          
        ////////////////////  insert sales and rental categories 
        $actions = array(   'Rentals',
                            'Sales'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => $key
            );

            if(!term_exists($key, 'property_action_category') ){
                wp_insert_term($key, 'property_action_category', $my_cat);
            }
        }

        ////////////////////  insert listings type categories 
        $actions = array(   'Apartments', 
                            'Houses', 
                            'Land', 
                            'Industrial',
                            'Offices',
                            'Retail',
                            'Condos',
                            'Duplexes',
                            'Villas'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => str_replace(' ', '-', $key)
            );
        
            if(!term_exists($key, 'property_category') ){
                wp_insert_term($key, 'property_category', $my_cat);
            }
        }      
      }// end if activated
      
      
        add_option('wp_estate_show_top_bar_user_login','no');
        add_option('wp_estate_show_top_bar_user_menu','no');
        add_option('wp_estate_show_adv_search_general','yes');
        add_option('wp_estate_currency_symbol', '$');
        add_option('wp_estate_where_currency_symbol', 'before');
        add_option('wp_estate_measure_sys','ft');
        add_option('wp_estate_facebook_login', 'no');
        add_option('wp_estate_google_login', 'no');
        add_option('wp_estate_yahoo_login', 'no');
        add_option('wp_estate_wide_status', 1);
        add_option('wp_estate_header_type', 4);      
        add_option('wp_estate_prop_no', '12');
        add_option('wp_estate_show_empty_city', 'no');
        add_option('wp_estate_blog_sidebar', 'right');
        add_option('wp_estate_blog_sidebar_name', 'primary-widget-area');
        add_option('wp_estate_blog_unit', 'normal');
        add_option('wp_estate_general_latitude', '40.781711');
        add_option('wp_estate_general_longitude', '-73.955927');
        add_option('wp_estate_default_map_zoom', '15');
        add_option('wp_estate_cache', 'no');
        add_option('wp_estate_show_adv_search_map_close', 'yes');
        add_option('wp_estate_pin_cluster', 'yes');
        add_option('wp_estate_zoom_cluster', 10);
        add_option('wp_estate_hq_latitude', '40.781711');
        add_option('wp_estate_hq_longitude', '-73.955927');
        add_option('wp_estate_idx_enable', 'no');
        add_option('wp_estate_geolocation_radius', 1000);
        add_option('wp_estate_min_height', 300);
        add_option('wp_estate_max_height', 450);
        add_option('wp_estate_keep_min', 'no');

        add_option('wp_estate_paid_submission', 'no');
        add_option('wp_estate_admin_submission', 'yes');
        add_option('wp_estate_user_agent', 'no');
        add_option('wp_estate_price_submission', 0);
        add_option('wp_estate_price_featured_submission', 0);
        add_option('wp_estate_submission_curency', 'USD');
        add_option('wp_estate_paypal_api', 'sandbox');     
        add_option('wp_estate_free_mem_list', 0);
        add_option('wp_estate_free_feat_list', 0);
        add_option('wp_estate_free_feat_list_expiration', 0);
        
        $custom_fields=array(
                    array('property year','Year Built','date',1),
                    array('property garage','Garages','short text',2),
                    array('property garage size','Garage Size','short text',3),
                    array('property date','Available from','short text',4),
                    array('property basement','Basement','short text',5),
                    array('property external construction','external construction','short text',6),
                    array('property roofing','Roofing','short text',7),
                    );
        add_option( 'wp_estate_custom_fields', $custom_fields); 
 
        add_option('wp_estate_custom_advanced_search', 'no');
        add_option('wp_estate_adv_search_type', 1);
        add_option('wp_estate_show_adv_search', 'yes');
        add_option('wp_estate_show_adv_search_map_close', 'yes');
        add_option('wp_estate_cron_run', time());
        $default_feature_list='attic, gas heat, ocean view, wine cellar, basketball court, gym,pound, fireplace, lake view, pool, back yard, front yard, fenced yard, sprinklers, washer and dryer, deck, balcony, laundry, concierge, doorman, private space, storage, recreation, roof deck';
        add_option('wp_estate_feature_list', $default_feature_list);
        add_option('wp_estate_show_no_features', 'yes');
        
        add_option('wp_estate_property_features_text', 'Property Features');
        add_option('wp_estate_property_description_text', 'Property Description');
        add_option('wp_estate_property_details_text',  'Property Details ');
        $default_status_list='open house, sold';
        add_option('wp_estate_status_list', $default_status_list);
        add_option( 'wp_estate_slider_cycle', 0); 
        add_option( 'wp_estate_show_save_search', 'no'); 
        add_option('wp_estate_search_alert',1);
        add_option('wp_estate_adv_search_type',1);
        
        // colors option
        add_option('wp_estate_color_scheme', 'no');
        add_option('wp_estate_main_color', '3C90BE');
        add_option('wp_estate_background_color', 'f3f3f3');
        add_option('wp_estate_content_back_color', 'ffffff');
        add_option('wp_estate_header_color', 'ffffff');
        add_option('wp_estate_breadcrumbs_font_color', '99a3b1');
        add_option('wp_estate_font_color', '768082');
        add_option('wp_estate_menu_items_color', '768082');
         /* --- */add_option('wp_estate_link_color', '#a171b');
        add_option('wp_estate_headings_color', '434a54');     
        add_option('wp_estate_sidebar_heading_boxed_color', '434a54');
        add_option('wp_estate_sidebar_heading_color', '434a54');
        add_option('wp_estate_sidebar_widget_color', 'fdfdfd');
        add_option('wp_estate_sidebar2_font_color', '888C8E');
        add_option('wp_estate_footer_back_color', '282D33');
        add_option('wp_estate_footer_font_color', '72777F');
        add_option('wp_estate_footer_copy_color', '72777F');
        add_option('wp_estate_menu_font_color', '434a54');
        add_option('wp_estate_menu_hover_back_color', '3C90BE');
        add_option('wp_estate_menu_hover_font_color', 'ffffff');
        add_option('wp_estate_top_bar_back', 'fdfdfd');
        add_option('wp_estate_top_bar_font', '1a171b');
        add_option('wp_estate_adv_search_back_color', 'fdfdfd');
        add_option('wp_estate_adv_search_font_color', '1a171b');
        add_option('wp_estate_box_content_back_color', 'fdfdfd');
        add_option('wp_estate_box_content_border_color', '347DA4');
        add_option('wp_estate_hover_button_color', 'f0f0f0');
        add_option('wp_estate_show_g_search', 'no');
        add_option('wp_estate_show_adv_search_extended', 'no');
        add_option('wp_estate_readsys', 'no');
        add_option('wp_estate_ssl_map','no');  
        add_option('wp_estate_enable_stripe','no');    
        add_option('wp_estate_enable_paypal','no');    
        add_option('wp_estate_enable_direct_pay','no');    
        //1.10
        add_option('wp_estate_global_property_page_agent_sidebar','no');
        add_option('wp_estate_global_prpg_slider_type','horizontal');
        add_option('wp_estate_global_prpg_content_type','accordion');
        add_option('wp_estate_logo_margin',0);
        add_option('wp_estate_header_transparent','no');
        add_option('wp_estate_default_map_type','ROADMAP');
        add_option('wp_estate_prices_th_separator','.');
        add_option( 'wp_estate_multi_curr', '');
        add_option('wp_estate_date_lang','default');
        add_option('wp_estate_blog_unit', 'grid');
        add_option('wp_estate_logo_header_type','type1');
        
        add_option('wp_estate_enable_autocomplete', 'no');
        add_option('wp_estate_enable_user_pass', 'no');
        add_option('wp_estate_auto_curency','no');
        
        add_option('wp_estate_use_mimify','no');
      //  $approved_listing=__(' Your listing was approved','wpestate');
       // add_option ('wp_estate_password_reseted',$approved_listing);
        
        

        // password_reset_request
        $to_save=__('Password Reset Request','wpestate');
        add_option ('wp_estate_subject_password_reset_request',$to_save);
        
        $to_save=__('Someone requested that the password be reset for the following account:
%website_url 
Username: %username.
If this was a mistake, just ignore this email and nothing will happen. To reset your password, visit the following address:%reset_link,
Thank You!','wpestate');
        add_option ('wp_estate_password_reset_request',$to_save);
        
       
        
        
        // password_reseted
        $to_save=__('Your Password was Reset','wpestate');
        add_option ('wp_estate_subject_password_reseted',$to_save);
        
        $to_save=__('Your new password for the account at: %website_url: 
Username:%username, 
Password:%user_pass.
You can now login with your new password at: %website_url','wpestate');
        add_option ('wp_estate_password_reseted',$to_save);
        

         
        // purchase_activated
        $to_save=__('Your purchase was activated','wpestate');
        add_option ('wp_estate_subject_purchase_activated',$to_save);
        
        $to_save=__('Hi there,
Your purchase on  %website_url is activated! You should go check it out.','wpestate');
        add_option ('wp_estate_purchase_activated',$to_save);
          

        
        // approved_listing
        $to_save=__('Your listing was approved','wpestate');
        add_option ('wp_estate_subject_approved_listing',$to_save);
        
        $to_save=__('Hi there,
Your listing, %property_title was approved on  %website_url! The listing is: %property_url.
You should go check it out.','wpestate');
        add_option ('wp_estate_approved_listing',$to_save);
        

        
        
        // new_wire_transfer
        $to_save=__('You ordered a new Wire Transfer','wpestate');
        add_option ('wp_estate_subject_new_wire_transfer',$to_save);
        
        $to_save=__('We received your Wire Transfer payment request on  %website_url !
Please follow the instructions below in order to start submitting properties as soon as possible.
The invoice number is: %invoice_no, Amount: %total_price. 
Instructions:  %payment_details.','wpestate');
        add_option ('wp_estate_new_wire_transfer',$to_save);
        

        
        $to_save=__('Somebody ordered a new Wire Transfer','wpestate');
        add_option ('wp_estate_subject_admin_new_wire_transfer',$to_save);
        
        $to_save=__('Hi there,
You received a new Wire Transfer payment request on %website_url.
The invoice number is:  %invoice_no,  Amount: %total_price.
Please wait until the payment is made to activate the user purchase.','wpestate');
        add_option ('wp_estate_admin_new_wire_transfer',$to_save);
    

        
        $to_save=__('New User Registration','wpestate');
        add_option ('wp_estate_subject_admin_new_user',$to_save);
        
        $to_save=__('New user registration on %website_url.
Username: %user_login_register, 
E-mail: %user_email_register','wpestate');
        add_option ('wp_estate_admin_new_user',$to_save);
  

   
        $to_save=__('Your username and password on %website_url','wpestate');
        add_option ('wp_estate_subject_new_user',$to_save);
        
        $to_save=__('Hi there,
Welcome to %website_url! You can login now using the below credentials:
Username:%user_login_register
Password: %user_pass_register
If you have any problems, please contact me.
Thank you!','wpestate');
        add_option ('wp_estate_new_user',$to_save);
        
     
        
       
        $to_save=__('Expired Listing sent for approval on %website_url','wpestate');
        add_option ('wp_estate_subject_admin_expired_listing',$to_save);
        
        $to_save=__('Hi there,
A user has re-submited a new property on %website_url! You should go check it out.
This is the property title: %submission_title.','wpestate');
        add_option ('wp_estate_admin_expired_listing',$to_save);
        

        
        //Matching Submissions  
        $to_save=__('Matching Submissions on %website_url','wpestate');
        add_option ('wp_estate_subject_matching_submissions',$to_save);
        
        $to_save=__('Hi there,
A new submission matching your chosen criteria has been published at %website_url.
These are the new submissions: 
%matching_submissions
','wpestate');
        add_option ('wp_estate_matching_submissions',$to_save);
        

        
        
        //Paid Submissions  
        $to_save=__('New Paid Submission on %website_url','wpestate');
        add_option ('wp_estate_subject_paid_submissions',$to_save);
        
        $to_save=__('Hi there,
You have a new paid submission on  %website_url! You should go check it out.','wpestate');
        add_option ('wp_estate_paid_submissions',$to_save);
       

         //Paid Submissions  
        $to_save=__('New Feature Upgrade on  %website_url','wpestate');
        add_option ('wp_estate_subject_featured_submission',$to_save);
        
        $to_save=__('Hi there,
You have a new featured submission on  %website_url! You should go check it out.','wpestate');
        add_option ('wp_estate_featured_submission',$to_save);
        

        
        //account_downgraded  
        $to_save=__('Account Downgraded on %website_url','wpestate');
        add_option ('wp_estate_subject_account_downgraded',$to_save);
        
        $to_save=__('Hi there,
You downgraded your subscription on %website_url. Because your listings number was greater than what the actual package offers, we set the status of all your listings to "expired". You will need to choose which listings you want live and send them again for approval.
Thank you!','wpestate');
        add_option ('wp_estate_account_downgraded',$to_save);
        
        //Membership Cancelled
        $to_save=__('Membership Cancelled on %website_url','wpestate');
        add_option ('wp_estate_subject_membership_cancelled',$to_save);
        
        $to_save=__('Hi there,
Your subscription on %website_url was cancelled because it expired or the recurring payment from the merchant was not processed. All your listings are no longer visible for our visitors but remain in your account.
Thank you.','wpestate');
        add_option ('wp_estate_membership_cancelled',$to_save);

       
        
        // Membership Activated
        $to_save=__('Membership Activated on %website_url','wpestate');
        add_option ('wp_estate_subject_membership_activated',$to_save);
        
        $to_save=__('Hi there,
Your new membership on %website_url is activated! You should go check it out.','wpestate');
        add_option ('wp_estate_membership_activated',$to_save);


        
        //Free Listing expired
        $to_save=__('Free Listing expired on %website_url','wpestate');
        add_option ('wp_estate_subject_free_listing_expired',$to_save);
        
        $to_save=__('Hi there,
One of your free listings on  %website_url has "expired". The listing is %expired_listing_url.
Thank you!','wpestate');
        add_option ('wp_estate_free_listing_expired',$to_save);

        
        
        
        //New Listing Submission
        $to_save=__('New Listing Submission on %website_url','wpestate');
        add_option ('wp_estate_subject_new_listing_submission',$to_save);
        
        $to_save=__('Hi there,
A user has submited a new property on %website_url! You should go check it out.This is the property title %new_listing_title!','wpestate');
        add_option ('wp_estate_new_listing_submission',$to_save);

        

        
        
        //listing edit
        $to_save=__('Listing Edited on %website_url','wpestate');
        add_option ('wp_estate_subject_listing_edit',$to_save);
        
        $to_save=__('Hi there,
A user has edited one of his listings  on %website_url ! You should go check it out. The property name is : %editing_listing_title!','wpestate');
        add_option ('wp_estate_listing_edit',$to_save);


        
        
        //recurring_payment
        $to_save=__('Recurring Payment on %website_url','wpestate');
        add_option ('wp_estate_subject_recurring_payment',$to_save);
        
        $to_save=__('Hi there,
We charged your account on %merchant for a subscription on %website_url ! You should go check it out.','wpestate');
        add_option ('wp_estate_recurring_payment',$to_save);
        

}
endif; // end   wp_estate_setup  
?>