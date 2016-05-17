<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  
$add_link               =   get_dasboard_add_listing();
$dash_profile           =   get_dashboard_profile_link();
$dash_favorite          =   get_dashboard_favorites();
$dash_link              =   get_dashboard_link();
$activeprofile          =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$user_pack              =   get_the_author_meta( 'package_id' , $userID );    
$clientId               =   esc_html( get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );

?>



   

    <?php 
    $is_membership=0;

    $paid_submission_status = esc_html ( get_option('wp_estate_paid_submission','') );  
    if ($paid_submission_status == 'membership'){
        wpestate_get_pack_data_for_user_top($userID,$user_pack,$user_registered,$user_package_activation); 
        $is_membership=1;             
    }

   if ( $is_membership==1){ ?>

        <?php
            $stripe_profile_user    =   get_user_meta($userID,'stripe',true);
            $subscription_id        =   get_user_meta( $userID, 'stripe_subscription_id', true );
            $enable_stripe_status   =   esc_html ( get_option('wp_estate_enable_stripe','') );
            if( $stripe_profile_user!='' && $subscription_id!='' && $enable_stripe_status==='yes'){
                echo '<span id="stripe_cancel" data-original-title="'.__('subscription will be cancelled at the end of current period','wpestate').'" data-stripeid="'.$userID.'">'.__('cancel stripe subscription','wpestate').'</span>';
            }
        
        ?>

        <div class="pack_description ">
            <div class="pack-unit">
                <div class="pack_description_unit">
                <?php  print '<h4>'.__('Change your Package','wpestate').'</h4>'; ?>
                </div>    
                    <div id="package_pick">
                        <?php wpestate_display_packages(); ?></br>
                        <label for="pack_recurring"><?php _e('make payment recurring ','wpestate');?></label>
                        <input type="checkbox" name="pack_recuring" id="pack_recuring" value="1" style="display:block;" /> 

                        <?php
                        $enable_paypal_status= esc_html ( get_option('wp_estate_enable_paypal','') );
                        $enable_stripe_status= esc_html ( get_option('wp_estate_enable_stripe','') );
                        $enable_direct_status= esc_html ( get_option('wp_estate_enable_direct_pay','') );
                        
                        
                        if($enable_paypal_status==='yes'){
                            print '<div id="pick_pack"></div>';
                        }
                        if($enable_stripe_status==='yes'){
                            wpestate_show_stripe_form_membership();
                        }
                        
                        if($enable_direct_status==='yes'){
                            print '<div id="direct_pay" class="wpb_button  wpb_btn-info wpb_btn-large">'.__('Wire Transfer','wpestate').'</div>';
                        }
                        
                        
                        ?>
                    </div>
            </div>   
        </div>

        <div class="pack_description ">
            <div class="pack-unit">
            <div class="pack_description_unit">     
            <?php print '<h4>'.__('Packages Available','wpestate').'</h4>';?>
            </div>    
            <?php
            $currency           =   esc_html( get_option('wp_estate_submission_curency', '') );
            $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
            $args = array(
                'post_type'         => 'membership_package',
                'posts_per_page'    => -1,
                'meta_query'        =>  array(
                                            array(
                                            'key' => 'pack_visible',
                                            'value' => 'yes',
                                            'compare' => '=',
                                         )
                                      )
            );
            $pack_selection = new WP_Query($args);

                    while($pack_selection->have_posts() ){
                        $pack_selection->the_post();
                        $postid             = $post->ID;
                        $pack_list          = get_post_meta($postid, 'pack_listings', true);
                        $pack_featured      = get_post_meta($postid, 'pack_featured_listings', true);
                        $pack_price         = get_post_meta($postid, 'pack_price', true);
                        $unlimited_lists    = get_post_meta($postid, 'mem_list_unl', true);
                        $biling_period      = get_post_meta($postid, 'biling_period', true);
                        $billing_freq       = get_post_meta($postid, 'billing_freq', true); 
                        $pack_time          = get_post_meta($postid, 'pack_time', true);
                        $unlimited_listings = get_post_meta($postid,  'mem_list_unl',true);

                        if($billing_freq>1){
                            $biling_period.='s';
                        }
                        if ($where_currency == 'before') {
                            $price = $currency . ' ' . $pack_price;
                        } else {
                            $price = $pack_price . ' ' . $currency;
                        }


                        print'<div class="pack-listing">';
                        print'<div class="pack-listing-title">'.get_the_title().' - <span class="submit-price">'.$price.'</span> </div>';
                        print '<div class="pack-listing-period">'.__('Time Period: ','wpestate').' '.$billing_freq.' '.wpestate_show_bill_period($biling_period).'</div> ';

                        if($unlimited_listings==1){
                            print'<div class="pack-listing-period">'.__('Unlimited','wpestate').' '.__('listings ','wpestate').' </div>';
                        }else{
                            print'<div class="pack-listing-period">'.$pack_list.' '.__('Listings','wpestate').' </div>';    
                        }

                        print'<div class="pack-listing-period">'.$pack_featured.' '.__('Featured','wpestate').'</div> ';  
                        print '</div>';
                    }
         print '</div></div>';          
        }

        wp_reset_query();
        
        
        ?>

            
<?php
function wpestate_show_bill_period($biling_period){
  
        if($biling_period=='Day' || $biling_period=='Days'){
            return  __('days','wpestate');
        }
        else if($biling_period=='Week' || $biling_period=='Weeks'){
           return  __('weeks','wpestate');
        }
        else if($biling_period=='Month' || $biling_period=='Months'){
            return  __('months','wpestate');
        }
        else if($biling_period=='Year'){
            return  __('year','wpestate');
        }

}

?>
            