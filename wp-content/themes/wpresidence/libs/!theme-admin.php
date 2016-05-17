<?php
if( !function_exists('wpestate_new_general_set') ):
function wpestate_new_general_set() {  
   if($_SERVER['REQUEST_METHOD'] === 'POST'){	
  
        $allowed_html   =   array();
        
        // cusotm fields
        if( isset( $_POST['add_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['add_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_field_type'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses ( $_POST['add_field_order'][sanitize_key($key)],$allowed_html);
                $temp_array[4]= wp_kses ( $_POST['add_dropdown_order'][sanitize_key($key)],$allowed_html);
                $new_custom[]=$temp_array;
            }

          
            usort($new_custom,"wpestate_sorting_function");
            update_option( 'wp_estate_custom_fields', $new_custom );   
        }
       
       // multiple currencies
        if( isset( $_POST['add_curr_name'] ) ){
            foreach( $_POST['add_curr_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_curr_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_curr_value'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses( $_POST['add_curr_order'][sanitize_key($key)] ,$allowed_html);
                $new_custom_cur[]=$temp_array;
            }
            
            update_option( 'wp_estate_multi_curr', $new_custom_cur );   

       }else{
           
       }

       
       

        if( isset( $_POST['theme_slider'] ) ){
            update_option( 'wp_estate_theme_slider', true);  
        }
        
       
        $permission_array=array(
            'add_field_name',
            'add_field_label',
            'add_field_type',
            'add_field_order',
            'adv_search_how',
            'adv_search_what',
            'adv_search_label',
        );
        
        $tags_array=array(
            'co_address',
            'direct_payment_details',
            'new_user',
            'admin_new_user',
            'purchase_activated',
            'password_reset_request',
            'password_reseted',
            'purchase_activated',
            'approved_listing',
            'new_wire_transfer',
            'admin_new_wire_transfer',
            'admin_expired_listing',
            'matching_submissions',
            'paid_submissions',
            'featured_submission',
            'account_downgraded',
            'membership_cancelled',
            'free_listing_expired',
            'new_listing_submission' ,
            'listing_edit',
            'recurring_payment',
            'subject_new_user',
            'subject_admin_new_user',
            'subject_purchase_activated',
            'subject_password_reset_request',
            'subject_password_reseted',
            'subject_purchase_activated',
            'subject_approved_listing',
            'subject_new_wire_transfer',
            'subject_admin_new_wire_transfer',
            'subject_admin_expired_listing',
            'subject_matching_submissions',
            'subject_paid_submissions',
            'subject_featured_submission',
            'subject_account_downgraded',
            'subject_membership_cancelled',
            'subject_free_listing_expired',
            'subject_new_listing_submission' ,
            'subject_listing_edit',
            'subject_recurring_payment'
        );
        
        
        //$variable!='add_field_name'&& $variable!='add_field_label' && $variable!='add_field_type' && $variable!='add_field_order' && $variable!= 'adv_search_how' && $variable!='adv_search_what' && $variable!='adv_search_label'
        foreach($_POST as $variable=>$value){	
            if ($variable!='submit'){
                if (!in_array($variable, $permission_array)){
                    $variable   =   sanitize_key($variable);
                    if( in_array($variable, $tags_array) ){
                        $allowed_html_br=array(
                                'br' => array(),
                                'em' => array(),
                                'strong' => array()
                        );
                        $postmeta   =   wp_kses($value,$allowed_html_br);
                    }else{
                        $postmeta   =   wp_kses($value,$allowed_html);
                    
                    }
                    update_option( wpestate_limit64('wp_estate_'.$variable), $postmeta );                
                }else{
                    update_option( 'wp_estate_'.$variable, $value );
                }	
            }	
        }
        
        if( isset($_POST['is_custom']) && $_POST['is_custom']== 1 && !isset($_POST['add_field_name']) ){
            update_option( 'wp_estate_custom_fields', '' ); 
        }
        
        if( isset($_POST['is_custom_cur']) && $_POST['is_custom_cur']== 1 && !isset($_POST['add_curr_name']) ){
            update_option( 'wp_estate_multi_curr', '' );
        }
    
        
        if (isset($_POST['show_save_search'])){
            $allowed_html=array();
            $show_save_search= wp_kses( $_POST['show_save_search'],$allowed_html );
            $search_alert= wp_kses( $_POST['search_alert'],$allowed_html );
            wp_estate_schedule_email_events( $show_save_search,$search_alert);
            wp_estate_schedule_user_check();  
        }
        
        if ( isset($_POST['auto_curency']) ){
            if( $_POST['auto_curency']=='yes' ){
                wp_estate_enable_load_exchange();
            }else{
                wp_clear_scheduled_hook('wpestate_load_exchange_action');
            }
        }
    
}
    


    
$allowed_html   =   array();  
$active_tab = isset( $_GET[ 'tab' ] ) ? wp_kses( $_GET[ 'tab' ],$allowed_html ) : 'general_settings';  

require_once get_template_directory().'/libs/help_content.php';

print '<div class="wrap">';
    print '<div class="wrap-topbar">';
        
        print   '<div id="general_settings" data-menu="general_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/general.png'.'" alt="general settings">'.__('General','wpestate').'
                </div>';
        
        print   '<div id="social_contact" data-menu="social_contact_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/general.png'.'" alt="general settings">'.__('Social & Contact','wpestate').'
                </div>';
        
        print   '<div id="map_settings" data-menu="map_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/map.png'.'" alt="general settings">'.__('Map','wpestate').'
                </div>';
         
        print   '<div id="design_settings" data-menu="design_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/design.png'.'" alt="general settings">'.__('Design','wpestate').'
                </div>';
        
        print   '<div id="advanced_settings" data-menu="advanced_settings_sidebar" class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/advanced.png'.'" alt="general settings">'.__('Advanced','wpestate').'
                </div>';
            
        print   '<div id="membership_settings" data-menu="membership_settings_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/membership.png'.'" alt="general settings">'.__('Membership','wpestate').'
                </div>';
        
        print   '<div id="advanced_search_settings" data-menu="advanced_search_settings_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/search.png'.'" alt="general settings">'.__('Search','wpestate').'
                </div>';
        
        print   '<div id="help_custom" data-menu="help_custom_sidebar"  class="admin_top_bar_button"> 
                    <img src="'.get_template_directory_uri().'/img/admin/search.png'.'" alt="general settings">'.__('Help & Custom','wpestate').'
                </div>';
        
    print '</div>';


    print '
    <div id="wpestate_sidebar_menu">
        <div id="general_settings_sidebar" class="theme_options_sidebar">
            <ul>
                <li data-optiontab="global_settings_tab" class="selected_option">'.__('Global Theme Settings','wpestate').'</li>
                <li data-optiontab="appearance_options_tab"   class="">'.__('Appearance','wpestate').'</li>
                <li data-optiontab="logos_favicon_tab"   class="">'.__('Logos & Favicon','wpestate').'</li>
                <li data-optiontab="price_curency_tab"   class="">'.__('Price & Currency','wpestate').'</li>
                <li data-optiontab="custom_fields_tab"   class="">'.__('Custom Fields','wpestate').'</li>
                <li data-optiontab="ammenities_features_tab"   class="">'.__('Features & Amenities','wpestate').'</li>
                <li data-optiontab="listing_labels_tab"   class="">'.__('Listings Labels','wpestate').'</li>   
                <li data-optiontab="theme_slider_tab"   class="">'.__('Theme Slider','wpestate').'</li>   

            </ul>
        </div>
        
        <div id="social_contact_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="contact_details_tab" class="">'.__('Contact Details','wpestate').'</li>
                <li data-optiontab="social_accounts_tab" class="">'.__('Social Accounts','wpestate').'</li>
                <li data-optiontab="contact7_tab" class="">'.__('Contact 7 Settings','wpestate').'</li>

            </ul>
        </div>
        

        <div id="map_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="general_map_tab" class="">'.__('Map Settings','wpestate').'</li>
                <li data-optiontab="pin_management_tab" class="">'.__('Pins Management','wpestate').'</li>
                <li data-optiontab="generare_pins_tab" class="">'.__('Generate Pins','wpestate').'</li>
               
            </ul>
        </div>
        
        <div id="design_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="property_page_tab" class="">'.__('Property Page','wpestate').'</li>
                <li data-optiontab="custom_colors_tab" class="">'.__('Custom Colors','wpestate').'</li>
          

            </ul>
        </div>
        
        <div id="advanced_search_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
                <li data-optiontab="advanced_search_settings_tab" class="">'.__('Advanced Search Settings','wpestate').'</li>
            </ul>
        </div>
        
        <div id="membership_settings_sidebar" class="theme_options_sidebar" style="display:none;">
            <ul>
               <li data-optiontab="membership_settings_tab" class="">'.__('Membership Settings','wpestate').'</li>
            </ul>
        </div>

 
        <div id="advanced_settings_sidebar" class="theme_options_sidebar" style="display:none;">
             <ul>
                <li data-optiontab="export_settings_tab" class="selected_option">'.__('Export Settings','wpestate').'</li>
                <li data-optiontab="email_management_tab" class="selected_option">'.__('Email Management','wpestate').'</li>
            </ul>
        </div>
        
        <div id="help_custom_sidebar" class="theme_options_sidebar" style="display:none;">
             <ul>
                <li data-optiontab="help_custom_sidebar_tab" class="selected_option">'.__('Help & Custom','wpestate').'</li>
            </ul>
        </div>
        
        



    </div>';

    print ' <div id="wpestate_wrapper_admin_menu"> 
                <div id="general_settings_sidebar_tab" class="theme_options_wrapper_tab">
                    <div id="global_settings_tab" class="theme_options_tab">
                        <h1>'.__('General Settings','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';    
                        new_wpestate_theme_admin_general_settings();
                    print '        
                    </div>

                    <div id="appearance_options_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Appearance','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_appeareance();
                    print '        
                    </div>

                    <div id="logos_favicon_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Logos & Favicon','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_theme_admin_logos_favicon();
                    print '        
                    </div>
                    

                    <div id="price_curency_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Price & Currency','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_price_currency();
                    print '        
                    </div>



                    <div id="custom_fields_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Custom Fields','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_custom_fields();
                    print '        
                    </div>
                    
                    <div id="ammenities_features_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Features & Amenities','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_ammenities_features();
                    print '        
                    </div>

                    <div id="listing_labels_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Listings Labels','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_listing_labels();
                    print '        
                    </div>
                    
                    <div id="theme_slider_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Theme Slider ','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_theme_slider();
                    print '        
                    </div>

 
                </div>
                
                <div id="social_contact_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                        <div id="contact_details_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Contact Details','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_theme_contact_details();
                        print '        
                        </div>

                        <div id="social_accounts_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Social Accounts ','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_theme_social_accounts();
                        print '        
                        </div>
                    
                        <div id="contact7_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Contact 7 Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_contact7();
                        print '        
                        </div>
                </div> 




                <div id="map_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                        <div id="general_map_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Map  Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_map_details();
                        print '        
                        </div>
                        
                        <div id="pin_management_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Pin Management','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_pin_management();
                        print '        
                        </div>
                        

                        
                        <div id="generare_pins_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Generate Pins','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_generate_pins();
                        print '        
                        </div>
                </div> 




                
                <div id="design_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                        <div id="property_page_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Property Page Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_property_page_details();
                        print '        
                        </div>

                        <div id="custom_colors_tab" class="theme_options_tab" style="display:none;">
                            <h1>'.__('Custom Colors Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_custom_colors();
                        print '        
                        </div>
                </div> 
                
                <div id="advanced_search_settings_sidebar_tab" class="theme_options_wrapper_tab"  style="display:none">
                        <div id="advanced_search_settings_tab" class="theme_options_tab">
                            <h1>'.__('Advanced Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_advanced_search_settings();
                        print '        
                        </div>
                </div> 
                


                <div id="membership_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">
                    
                        <div id="membership_settings_tab" class="theme_options_tab" >
                            <h1>'.__('Membership Settings','wpestate').'</h1>
                            <div class="theme_option_separator"></div>';
                            new_wpestate_membership_settings();
                        print '        
                        </div>

                </div> 
                
                <div id="social_contact_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">social_contact_sidebar_tab
                </div> 
                


                <div id="advanced_settings_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">

                    <div id="export_settings_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Export Settings','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_export_settings();
                    print '        
                    </div>
                    
                    <div id="email_management_tab" class="theme_options_tab" style="display:none;">
                        <h1>'.__('Email Management','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_email_management();
                    print '        
                    </div>

     
                </div> 


                <div id="help_custom_sidebar_tab" class="theme_options_wrapper_tab" style="display:none">

                    <div id="help_custom_tab" class="theme_options_tab" >
                        <h1>'.__('Help&Custom','wpestate').'</h1>
                        <div class="theme_option_separator"></div>';
                        new_wpestate_help_custom();
                    print '        
                    </div>
                </div>


           </div>';

print '</div>';

print '-----------';
print '
    
    
        <form method="post" action="" id="estate_admin_form">
        <div class="wpestate_admin_search_bar">
            <label class="wpestate_adv_search_label">'.__('Theme Help Search - there are over 200 articles to help you setup and use the theme. Please use this search and if your question is not here, please open a ticket in our client support system.','wpestate').'</label>
            <input type="text" id="wpestate_search_bar" placeholder="'.__('Search help documentation. For ex. type: Adv ','wpestate').'">
            <div id="wpestate_admin_results">
            </div>
        </div>
        <div class="wpestate-tab-wrapper-container">
        <div class="wpestate-tab-wrapper">';
            print '<div class="ourlogo"><a href="http://wpestate.org/" target="_blank"><img src="'.get_template_directory_uri().'/img/logoadmin.png" alt="logo"></a></div>';
            
            print '<div class="wpestate-tab-item '; 
            print $active_tab == 'general_settings'  ? 'wpestate-tab-active' : '';
            print '"><a href="themes.php?page=libs/theme-admin.php&tab=general_settings">'.__('General Settings','wpestate').'</a></div>';
                
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'social_contact' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=social_contact">'.__('Social & Contact','wpestate').'</a></div>';
           
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'appearance' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=appearance">'.__('Appearance','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'property_page' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=property_page">'.__('Property Page','wpestate').'</a></div>';
            
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'price_set' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=price_set">'.__('Price & Currency','wpestate').'</a></div>';
            
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'mapsettings' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=mapsettings">'.__('Google Maps Settings','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'membership' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=membership">'.__('Membership & Payment Settings ','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'design' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=design">'.__('Design','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'pin_management' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=pin_management">'.__('Pin Management','wpestate').'</a></div>';
            
            //     print '<div class="wpestate-tab-item ';
            //     print $active_tab == 'icon_management' ? 'wpestate-tab-active' : ''; 
            //     print'"><a href="themes.php?page=libs/theme-admin.php&tab=icon_management">'.__('Icon Management','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'custom_fields' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=custom_fields">'.__('Listings Custom Fields','wpestate').'</a></div>';
         
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'adv_search' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=adv_search">'.__('Advanced Search','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'display_features' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=display_features">'.__('Listings Features & Amenities ','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'listings_labels' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=listings_labels">'.__('Listings Labels','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'theme-slider' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=theme-slider">'.__('Set Theme Slider','wpestate').'</a></div>';
          
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'generate_pins' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=generate_pins">'.__('Generate Pins','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'email_management' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=email_management">'.__('Email Management','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'help_custom' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=help_custom">'.__('Help & Custom','wpestate').'</a></div>';
            
            
       print '</div>';
   //wpestate_admin_results  source: autofill,
    print '<script type="text/javascript">
    //<![CDATA[
    
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    function decodeHtml(html) {
  
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }
                jQuery(document).ready(function(){
                    var autofill='.$help_content.';
                    jQuery("#wpestate_search_bar" ).autocomplete({
                   
                    source: function( request, response ) {
                   
                     response( jQuery.ui.autocomplete.filter(
                       autofill, extractLast( request.term ) ) );
                   },
                    focus: function( event, ui ) {
                        jQuery( "#wpestate_admin_results" ).val( decodeHtml( ui.item.label ) );
                        return false;
                    }, select: function( event, ui ) { 
                        window.open(ui.item.value,"_blank");
                    }
                    
                    
                    
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                        return jQuery( "<li>" )
                        .append( "" + decodeHtml( item.label )+ "" )
                            .appendTo( ul );
                    };
                

           });
           //]]>
           </script>';
   

    switch ($active_tab) {
            case "general_settings":
                wpestate_theme_admin_general_settings();
                break;
            case "social_contact":
                wpestate_theme_admin_social();
                break;
            case "appearance":
                wpestate_theme_admin_apperance();
                break;
            case "design":
                wpestate_theme_admin_design();
                break;
            case "help_custom":
                wpestate_theme_admin_help();
                break;
            case "mapsettings":
                wpestate_theme_admin_mapsettings();
                break;
            case "membership":
                wpestate_theme_admin_membershipsettings();
                break;
            case "adv_search":
                wpestate_theme_admin_adv_search();
                break;
            case "pin_management":
                wpestate_show_pins();
                break;
            case "custom_fields":
                wpestate_custom_fields();
                break;
            case "display_features":
                wpestate_display_features();
                break;
            case "listings_labels":
                wpestate_display_labels();
                break;   
            case "theme-slider":
                wpestate_theme_slider();
                break;
            case "generate_pins":
                wpestate_generate_file_pins();
                break;
            case "property_page":
                wpestate_property_page_settings();
                break;
            case "price_set":
                wpestate_price_set();
                break;
            case "email_management":
                wpestate_email_management();
                break;
    }
            
         
     
        
                   
print '</div></form></div></div>';
}
endif; // end   wpestate_new_general_set  


if( !function_exists('wpestate_generate_file_pins') ):
function   wpestate_generate_file_pins(){
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Generate pins','wpestate').'</h1>';
     print '<a href="http://help.wpresidence.net/#!/googlemaps" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '<table class="form-table">   <tr valign="top">
           <td>';  
          
    if ( get_option('wp_estate_readsys','') =='yes' ){
        
        $path=estate_get_pin_file_path(); 
   
        if ( file_exists ($path) && is_writable ($path) ){
              wpestate_listing_pins();
            _e('File was generated','wpestate');
        }else{
            print ' <div class="notice_file">'.__('the file Google map does NOT exist or is NOT writable','wpestate').'</div>';
        }
   
    }else{
        _e('Pin Generation works only if the file reading option in Google Map setting is set to yes','wpestate');
    }
    
    print '</td>
           </tr></table>';
    print '</div>';   
}
endif;


if( !function_exists('wpestate_show_advanced_search_options') ):

function  wpestate_show_advanced_search_options($i,$adv_search_what){
    $return_string='';

    $curent_value='';
    if(isset($adv_search_what[$i])){
        $curent_value=$adv_search_what[$i];        
    }
    
   // $curent_value=$adv_search_what[$i];
    $admin_submission_array=array('types',
                                  'categories',
                                  'county / state',
                                  'cities',
                                  'areas',
                                  'property price',
                                  'property size',
                                  'property lot size',
                                  'property rooms',
                                  'property bedrooms',
                                  'property bathrooms',
                                  'property address',                               
                                  'property zip',
                                  'property country',
                                  'property status',
                                  'property id',
                                  'keyword'
                                );
    
    foreach($admin_submission_array as $value){

        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    
    $i=0;
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){          
            $name =   $custom_fields[$i][0];
            $type =   $custom_fields[$i][1];
            $slug =   str_replace(' ','-',$name);

            $return_string.='<option value="'.$slug.'" '; 
            if($curent_value==$slug){
               $return_string.= ' selected="selected" ';
            }
            $return_string.= '>'.$name.'</option>';    
            $i++;  
        }
    }  
    $slug='none';
    $name='none';
    $return_string.='<option value="'.$slug.'" '; 
    if($curent_value==$slug){
        $return_string.= ' selected="selected" ';
    }
    $return_string.= '>'.$name.'</option>';    

       
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_options  



if( !function_exists('wpestate_show_advanced_search_how') ):
function  wpestate_show_advanced_search_how($i,$adv_search_how){
    $return_string='';
    $curent_value='';
    if (isset($adv_search_how[$i])){
         $curent_value=$adv_search_how[$i];
    }
   
    
    
    $admin_submission_how_array=array('equal',
                                      'greater',
                                      'smaller',
                                      'like',
                                      'date bigger',
                                      'date smaller');
    
    foreach($admin_submission_how_array as $value){
        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_how  





if( !function_exists('wpestate_dropdowns_theme_admin') ):
    function wpestate_dropdowns_theme_admin($array_values,$option_name,$pre=''){
        
        $dropdown_return    =   '';
        $option_value       =   esc_html ( get_option('wp_estate_'.$option_name,'') );
        foreach($array_values as $value){
            $dropdown_return.='<option value="'.$value.'"';
              if ( $option_value == $value ){
                $dropdown_return.='selected="selected"';
            }
            $dropdown_return.='>'.$pre.$value.'</option>';
        }
        
        return $dropdown_return;
        
    }
endif;




if( !function_exists('wpestate_dropdowns_theme_admin_with_key') ):
    function wpestate_dropdowns_theme_admin_with_key($array_values,$option_name){
        
        $dropdown_return    =   '';
        $option_value       =   esc_html ( get_option('wp_estate_'.$option_name,'') );
        foreach($array_values as $key=>$value){
            $dropdown_return.='<option value="'.$key.'"';
              if ( $option_value == $key ){
                $dropdown_return.='selected="selected"';
            }
            $dropdown_return.='>'.$value.'</option>';
        }
        
        return $dropdown_return;
        
    }
endif;


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Advanced Search Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_adv_search') ):
function wpestate_theme_admin_adv_search(){
    $cache_array                    =   array('yes','no');
    
    $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    
    
    
    $value_array=array('no','yes');
    $custom_advanced_search_select = wpestate_dropdowns_theme_admin($value_array,'custom_advanced_search');
    
    $search_array = array (1,2,3);
    $show_adv_search_type= wpestate_dropdowns_theme_admin($search_array,'adv_search_type',__('Type','wpestate').' ');
    
    
    $show_adv_search_general_select     = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_general');
    $show_adv_search_slider_select      = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_slider');
    $show_adv_search_visible_select     = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_visible');
    $show_adv_search_extended_select    = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_extended');
    $show_save_search_select            = wpestate_dropdowns_theme_admin($cache_array,'show_save_search');
    $show_slider_price_select           = wpestate_dropdowns_theme_admin($cache_array,'show_slider_price');
    $show_dropdowns_select              = wpestate_dropdowns_theme_admin($cache_array,'show_dropdowns');
    
    
    
    
    $period_array   =array( 0 =>__('daily','wpestate'),
                            1 =>__('weekly','wpestate') 
                            );
    
    $search_alert_select = wpestate_dropdowns_theme_admin_with_key($period_array,'search_alert');
    
 
    
   
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Advanced Search','wpestate').'</h1>';  
    print '<a href="http://help.wpresidence.net/#!/advsearchfields" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '
        <table class="form-table">
           
        <tr valign="top">
            <th scope="row"> <label for="adv_search_type">'.__('Advanced Search Type ?','wpestate').'</label></th>
            <td> 
                <select id="adv_search_type" name="adv_search_type">
                    '.$show_adv_search_type.'
                </select> 
            </td>
        </tr> 


        <tr valign="top">
            <th scope="row"> <label for="show_save_search">'.__('Use Saved Search Feature ?','wpestate').'</label></th>
            <td> 
                <select id="show_save_search" name="show_save_search">
                    '.$show_save_search_select.'
                </select> 
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="search_alert">'.__('Send emails','wpestate').'</label></th>
            <td> 
                <select id="search_alert" name="search_alert">
                    '.$search_alert_select.'
                </select> 
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="custom_advanced_search">'.__('Use Custom Fields For Advanced Search ?','wpestate').'</label></th>
            <td> 
                <select id="custom_advanced_search" name="custom_advanced_search">
                    '.$custom_advanced_search_select.'
                </select> 
            </td>
        </tr>
        
     
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_inclose">'.__('Show Advanced Search ?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_general" name="show_adv_search_general">
                    '.$show_adv_search_general_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_slider">'.__('Show Advanced Search over sliders or images ?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_slider" name="show_adv_search_slider">
                    '.$show_adv_search_slider_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_visible">'.__('Keep Advanced Search visible?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_visible" name="show_adv_search_visible">
                    '.$show_adv_search_visible_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_visible">'.__('Show Amenities and Features fields?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_extended" name="show_adv_search_extended">
                    '.$show_adv_search_extended_select.'
		 </select>
            </td>
            <td>'.__('*for speed reasons, the "features checkboxes" will not filter the pins on the map','wpestate').'</td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_slider_price">'.__('Show Slider for Price?','wpestate').'</label></th>
           
            <td> <select id="show_slider_price" name="show_slider_price">
                    '.$show_slider_price_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_dropdowns">'.__('Show Dropdowns for beds, bathrooms or rooms?(*only works with Custom Fields - YES)','wpestate').'</label></th>
            <td> <select id="show_dropdowns" name="show_dropdowns">
                    '.$show_dropdowns_select.'
		 </select>
            </td>
        </tr>
        

         <tr valign="top">
            <th scope="row"><label for="show_slider_price_values">'.__('Minimum and Maximum value for Price Slider','wpestate').'</label></th>
           
            <td>
                <input type="text" name="show_slider_min_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_min_price','')).'"/>
                -   
                <input type="text" name="show_slider_max_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_max_price','')).'"/>
            </td>
        </tr>


        </table>';

    print '<h1 class="wpestate-tabh1">'.__('Custom Fields for Advanced Search','wpestate').'</h1>'; 
    print'    <table class="form-table">
       
         <tr valign="top">
            <th scope="row"></th>
            <td>
            </td>
             <td>  
            </td>
         </tr>
         <tr valign="top">
            <th scope="row"><label for="admin_submission"><strong>'.__('Place in advanced search form','wpestate').'</strong></label></th>          
            <td><strong>'.__('Search field','wpestate').'</strong></td>
            <td><strong>'.__('How it will compare','wpestate').'</strong></td>
            <td><strong>'.__('Label on Front end','wpestate').'</strong></td>
        </tr>'; 
        
    $i=0;
    while( $i < 8 ){
       $i++;
      
       print '
       <tr valign="top">
            <th scope="row"><label for="admin_submission">'.__('Spot no ','wpestate').$i.'</label></th>
           
            <td><select id="adv_search_what'.$i.'" name="adv_search_what[]">';
                print   wpestate_show_advanced_search_options($i-1,$adv_search_what);
	print'	</select>
            </td>
            <td><select id="adv_search_how'.$i.'" name="adv_search_how[]">';
                 print  wpestate_show_advanced_search_how($i-1,$adv_search_how);
        
        $new_val=''; 
        if( isset($adv_search_label[$i-1]) ){
            $new_val=$adv_search_label[$i-1]; 
        }
         
        
        print '	</select>
            </td>
            <td>
                <input type="text" id="adv_search_label'.$i.'" name="adv_search_label[]" value="'.$new_val.'">
            </td>
        </tr>';
    }
 
        
        
        print' </table>
       
        <p style="margin-left:10px;">
         '.__('*Do not duplicate labels and make sure search fields do not contradict themselves','wpestate').'</br>
        '.__('*Labels will not apply for taxonomy dropdowns fields','wpestate').'</br>
      
        </p>';
        
        print '<h1 class="wpestate-tabh1">'.__('Amenities and Features for Advanced Search','wpestate').'</h1>'; 
        $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
        $feature_list_array =   explode( ',',$feature_list);
       
        $advanced_exteded =  get_option('wp_estate_advanced_exteded');
        
        print ' <p style="margin-left:10px;">  '.__('*Hold CTRL for multiple selection','wpestate').'</p>'
        . '<input type="hidden" name="advanced_exteded[]" value="none">'
        . '<p style="margin-left:10px;"> <select name="advanced_exteded[]" multiple="multiple" style="height:400px;">';
        foreach($feature_list_array as $checker => $value){
            $post_var_name  =   str_replace(' ','_', trim($value) );
            print '<option value="'.$post_var_name.'"' ;
            if(is_array($advanced_exteded)){
                if( in_array ($post_var_name,$advanced_exteded) ){
                    print ' selected="selected" ';
                } 
            }
            
            print '>'.$value.'</option>';                
        }
        print '</select></p>';
        print'
        <p class="submit">
           <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>
        
        ';
}
endif; // end   wpestate_theme_admin_adv_search  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Membership Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_membershipsettings') ):
function wpestate_theme_admin_membershipsettings(){
    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );    
    $paypal_client_id               =   esc_html( get_option('wp_estate_paypal_client_id','') );
    $paypal_client_secret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );
    $paypal_api_username            =   esc_html( get_option('wp_estate_paypal_api_username','') );
    $paypal_api_password            =   esc_html( get_option('wp_estate_paypal_api_password','') );
    $paypal_api_signature           =   esc_html( get_option('wp_estate_paypal_api_signature','') );
    $paypal_rec_email               =   esc_html( get_option('wp_estate_paypal_rec_email','') );
    $free_feat_list                 =   esc_html( get_option('wp_estate_free_feat_list','') );
    $free_mem_list                  =   esc_html( get_option('wp_estate_free_mem_list','') );
    $cache_array                    =   array('yes','no');  
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );
    
    $args=array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );
     $direct_payment_details         =   wp_kses( get_option('wp_estate_direct_payment_details','') ,$args);
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $free_mem_list_unl='';
    if ( intval( get_option('wp_estate_free_mem_list_unl', '' ) ) == 1){
        $free_mem_list_unl=' checked="checked" ';  
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $paypal_array                   =   array( 'sandbox','live' );
    $paypal_api_select              =   wpestate_dropdowns_theme_admin($paypal_array,'paypal_api');

    $submission_curency_array       =   array(get_option('wp_estate_submission_curency_custom',''),'USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','ILS','INR','JPY','MYR','MXN','NOK','NZD','PHP','PLN','GBP','SGD','SEK','CHF','TWD','THB','TRY');
    $submission_curency_symbol      =   wpestate_dropdowns_theme_admin($submission_curency_array,'submission_curency');
    
    $paypal_array                   =   array('no','per listing','membership');
    $paid_submission_symbol         =   wpestate_dropdowns_theme_admin($paypal_array,'paid_submission');
    $admin_submission_symbol        =   wpestate_dropdowns_theme_admin($cache_array,'admin_submission');
    $user_agent_symbol              =   wpestate_dropdowns_theme_admin($cache_array,'user_agent');
    $enable_paypal_symbol           =   wpestate_dropdowns_theme_admin($cache_array,'enable_paypal');
    $enable_stripe_symbol           =   wpestate_dropdowns_theme_admin($cache_array,'enable_stripe');
    $enable_direct_pay_symbol       =   wpestate_dropdowns_theme_admin($cache_array,'enable_direct_pay');
   
    
    
    $free_feat_list_expiration= intval ( get_option('wp_estate_free_feat_list_expiration','') );
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Membership & Payment Settings','wpestate').'</h1>';  
    print '<a href="http://help.wpresidence.net/#!/freesubmission" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '
        <table class="form-table">
        
        <tr valign="top">
            <th scope="row"><label for="admin_submission">'.__('Submited Listings should be approved by admin?','wpestate').'</label></th>
           
            <td> <select id="admin_submission" name="admin_submission">
                    '.$admin_submission_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="user_agent">'.__('Front end registred users should be saved as agents?','wpestate').'</label></th>
           
            <td> <select id="user_agent" name="user_agent">
                    '.$user_agent_symbol.'
		 </select>
            </td>
        </tr>
        

         <tr valign="top">
            <th scope="row"><label for="paid_submission">'.__('Enable Paid Submission ?','wpestate').'</label></th>
           
            <td> <select id="paid_submission" name="paid_submission">
                    '.$paid_submission_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="enable_paypal">'.__('Enable Paypal?','wpestate').'</label></th>
           
            <td> <select id="enable_paypal" name="enable_paypal">
                    '.$enable_paypal_symbol.'
		 </select>
            </td>
        </tr>

     
        
        <tr valign="top">
            <th scope="row"><label for="enable_stripe">'.__('Enable Stripe?','wpestate').'</label></th>
           
            <td> <select id="enable_stripe" name="enable_stripe">
                    '.$enable_stripe_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="enable_direct_pay">'.__('Enable Direct Payment / Wire Payment?','wpestate').'</label></th>
           
            <td> <select id="enable_direct_pay" name="enable_direct_pay">
                    '.$enable_direct_pay_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="submission_curency">'.__('Currency For Paid Submission','wpestate').'</label></th>
            <td>
                <select id="submission_curency" name="submission_curency">
                    '.$submission_curency_symbol.'
                </select> 
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="submission_curency_custom">'.__('Custom Currency Symbol - *select it from the list above after you add it.','wpestate').'</label></th>
            <td>
               <input type="text" id="submission_curency_custom" name="submission_curency_custom" class="regular-text"  value="'.get_option('wp_estate_submission_curency_custom','').'"/>
            </td>
        </tr>

         <tr valign="top">
            <th scope="row"><label for="paypal_client_id">'.__('Paypal Client id','wpestate').'</label></th>
            <td><input  type="text" id="paypal_client_id" name="paypal_client_id" class="regular-text"  value="'.$paypal_client_id.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_client_secret ">'.__('Paypal Client Secret Key ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_client_secret" name="paypal_client_secret"  class="regular-text" value="'.$paypal_client_secret.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api">'.__('Paypal & Stripe Api ','wpestate').'</label></th>
            <td>
              <select id="paypal_api" name="paypal_api">
                    '.$paypal_api_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_username">'.__('Paypal Api User Name ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_username" name="paypal_api_username"  class="regular-text" value="'.$paypal_api_username.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_password ">'.__('Paypal API Password ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_password" name="paypal_api_password"  class="regular-text" value="'.$paypal_api_password.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_signature">'.__('Paypal API Signature','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_signature" name="paypal_api_signature"  class="regular-text" value="'.$paypal_api_signature.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_rec_email">'.__('Paypal receiving email','wpestate').'</label></th>
            <td><input  type="text" id="paypal_rec_email" name="paypal_rec_email"  class="regular-text" value="'.$paypal_rec_email.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="stripe_secret_key">'.__('Stripe Secret Key','wpestate').'</label></th>
            <td><input  type="text" id="stripe_secret_key" name="stripe_secret_key"  class="regular-text" value="'.$stripe_secret_key.'"/> </td>
        </tr>
       
        <tr valign="top">
            <th scope="row"><label for="stripe_publishable_key">'.__('Stripe Publishable Key','wpestate').'</label></th>
            <td><input  type="text" id="stripe_publishable_key" name="stripe_publishable_key" class="regular-text" value="'.$stripe_publishable_key.'"/> </td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="direct_payment_details">'.__('Wire instructions for direct payment','wpestate').'</label></th>
            <td><textarea id="direct_payment_details" name="direct_payment_details"  style="width:325px;" class="regular-text" >'.$direct_payment_details.'</textarea> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="price_submission">'.__('Price Per Submission (for "per listing" mode)','wpestate').'</label></th>
           <td><input  type="text" id="price_submission" name="price_submission"  value="'.$price_submission.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="price_featured_submission">'.__('Price to make the listing featured (for "per listing" mode)','wpestate').'</label></th>
           <td><input  type="text" id="price_featured_submission" name="price_featured_submission"  value="'.$price_featured_submission.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="free_mem_list">'.__('Free Membership - no of listings (for "membership" mode)','wpestate').' </label></th>
            <td>
                <input  type="text" id="free_mem_list" name="free_mem_list" style="margin-right:20px;"  value="'.$free_mem_list.'"/> 
       
                <input type="hidden" name="free_mem_list_unl" value="">
                <input type="checkbox"  id="free_mem_list_unl" name="free_mem_list_unl" value="1" '.$free_mem_list_unl.' />
                <label for="free_mem_list_unl">'.__('Unlimited listings ?','wpestate').'</label>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="free_feat_list">'.__('Free Membership - no of featured listings (for "membership" mode)','wpestate').' </label></th>
            <td>
                <input  type="text" id="free_feat_list" name="free_feat_list" style="margin-right:20px;"    value="'.$free_feat_list.'"/>
              
            </td>
        </tr>
        
  
        <tr valign="top">
            <th scope="row"><label for="free_feat_list_expiration">'.__('Free Membership Listings - no of days until a free listing will expire. *Starts from the moment the property is published on the website. (for "membership" mode) ','wpestate').' </label></th>
            <td>
                <input  type="text" id="free_feat_list_expiration" name="free_feat_list_expiration" style="margin-right:20px;"    value="'.$free_feat_list_expiration.'"/>
              
            </td>
        </tr>

        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
        </p>  
    ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_membershipsettings  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Map Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_mapsettings') ):
function wpestate_theme_admin_mapsettings(){
    $general_longitude              =   esc_html( get_option('wp_estate_general_longitude') );
    $general_latitude               =   esc_html( get_option('wp_estate_general_latitude') );
    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    $cache_array                    =   array('yes','no');
    $default_map_zoom               =   intval   ( get_option('wp_estate_default_map_zoom','') );
    $zoom_cluster                   =   esc_html ( get_option('wp_estate_zoom_cluster ','') );
    $hq_longitude                   =   esc_html ( get_option('wp_estate_hq_longitude') );
    $hq_latitude                    =   esc_html ( get_option('wp_estate_hq_latitude') );
    $min_height                     =   intval   ( get_option('wp_estate_min_height','') );
    $max_height                     =   intval   ( get_option('wp_estate_max_height','') );

    $readsys_symbol                 =   wpestate_dropdowns_theme_admin($cache_array,'readsys');
    $ssl_map_symbol                 =   wpestate_dropdowns_theme_admin($cache_array,'ssl_map');
    $cache_symbol                   =   wpestate_dropdowns_theme_admin($cache_array,'cache');
    $show_filter_map_symbol         =   wpestate_dropdowns_theme_admin($cache_array,'show_filter_map');
    $home_small_map_symbol          =   wpestate_dropdowns_theme_admin($cache_array,'home_small_map');
    $pin_cluster_symbol             =   wpestate_dropdowns_theme_admin($cache_array,'pin_cluster');

    
    
    $geolocation_radius         =   esc_html ( get_option('wp_estate_geolocation_radius','') );
   
   
    $idx_symbol             =   wpestate_dropdowns_theme_admin($cache_array,'idx_enable');

    
    
     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $cache_array2                       =   array('no','yes');
    $keep_min_symbol                    =   wpestate_dropdowns_theme_admin($cache_array2,'keep_min');
    $show_adv_search_symbol_map_close   =   wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_map_close');
    $show_g_search_symbol               =   wpestate_dropdowns_theme_admin($cache_array2,'show_g_search');

     
     
    $map_style  =   esc_html ( get_option('wp_estate_map_style','') );
    
    $map_types = array('SATELLITE','HYBRID','TERRAIN','ROADMAP');
    $default_map_type_symbol               =   wpestate_dropdowns_theme_admin($map_types,'default_map_type');

    
   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
 
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Google Maps Settings','wpestate').'</h1>';  
    print '<a href="http://help.wpresidence.net/#!/googlemaps" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '
       <table class="form-table">';
       $path=estate_get_pin_file_path(); 
   
    if ( file_exists ($path) && is_writable ($path) ){
       
    }else{
        print ' <div class="notice_file">'.__('the file Google map does NOT exist or is NOT writable','wpestate').'</div>';
    }
    
    
    print'
        <tr valign="top">
            <th scope="row"><label for="readsys">'.__('Use file reading for pins? (*recommended for over 200 listings. Read the manual for diffrences betwen file and mysql reading)','wpestate').'</label></th>
           
            <td> <select id="readsys" name="readsys">
                    '.$readsys_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="ssl_map">'.__('Use Google maps with SSL ?','wpestate').'</label></th>
           
            <td> <select id="ssl_map" name="ssl_map">
                    '.$ssl_map_symbol.'
		 </select>
            </td>
        </tr>

        <tr valign="top">
           <th scope="row"><label for="api_key">'.__('Google Maps API KEY','wpestate').'</label></th>
           <td><input  type="text" id="api_key" name="api_key" class="regular-text" value="'.$api_key.'"/></td>
        </tr>
          <tr valign="top">
            <th scope="row"></th>
            <td>'.__('The Google Maps JavaScript API v3 does not require an API key to function correctly. However, we strongly encourage you to get  an APIs Console key and post the code in Theme Options. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">here</a>','wpestate').'.</td>
        </tr>
        <tr valign="top">
            <th scope="row"> <label for="general_latitude">'.__('Starting Point Latitude','wpestate').'</label></th>
            <td><input  type="text" id="general_latitude"  name="general_latitude"   value="'.$general_latitude.'"/></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="general_longitude">'.__('Starting Point Longitude','wpestate').'</label></th>
            <td><input  type="text" id="general_longitude" name="general_longitude"  value="'.$general_longitude.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="default_map_zoom">'.__(' Default Map zoom (1 to 20) ','wpestate').'</label></th>
            <td>
                <input type="text" id="default_map_zoom" name="default_map_zoom" value="'.$default_map_zoom.'">   
            </td>
        </tr> 

        <tr valign="top">
            <th scope="row"><label for="default_map_type">'.__('Map Type','wpestate').'</label></th>
           
            <td> <select id="default_map_type" name="default_map_type">
                    '.$default_map_type_symbol.'
		 </select>
            </td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Use Cache for Google maps ?(*cache will renew it self every 3h)','wpestate').'</label></th>
           
            <td> <select id="cache" name="cache">
                    '.$cache_symbol.'
		 </select>
            </td>
        </tr>
        
      
        
        <tr valign="top">
            <th scope="row"><label for="pin_cluster">'.__('Use Pin Cluster on map','wpestate').'</label></th>
           
            <td> <select id="pin_cluster" name="pin_cluster">
                    '.$pin_cluster_symbol.'
		 </select>
            </td>
        </tr>
        
        
         <tr valign="top">
            <th scope="row"><label for="zoom_cluster">'.__('Maximum zoom level for Cloud Cluster to appear','wpestate').'</label></th>
            <td><input id="zoom_cluster" type="text" size="36" name="zoom_cluster" value="'.$zoom_cluster.'" /></td>       
        </tr>
        
         <tr valign="top">
            <th scope="row"> <label for="hq_latitude">'.__('Contact Page - Company HQ Latitude','wpestate').'</label></th>
            <td><input  type="text" id="hq_latitude"  name="hq_latitude"   value="'.$hq_latitude.'"/></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="hq_longitude">'.__('Contact Page - Company HQ Longitude','wpestate').'</label></th>
            <td><input  type="text" id="hq_longitude" name="hq_longitude"  value="'.$hq_longitude.'"/> </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Enable dsIDXpress to use the map ','wpestate').'</label></th>          
            <td> <select id="idx_enable" name="idx_enable">
                    '.$idx_symbol.'
		 </select>
            </td>
        </tr>';
        /*
         <tr valign="top">
            <th scope="row"><label for="geolocation">'.__('Enable Geolocation','wpestate').'</label></th>
           
            <td> <select id="geolocation" name="geolocation">
                    '.$geolocation_symbol.'
		 </select>
            </td>
        </tr>
         */        
        print'
         <tr valign="top">
            <th scope="row"><label for="geolocation_radius">'.__('Geolocation Circle over map (in meters)','wpestate').'</label></th>
            <td>  <input id="geolocation_radius" type="text" size="36" name="geolocation_radius" value="'.$geolocation_radius.'" /></td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="min_height">'.__('Height of the Google Map when closed','wpestate').'</label></th>
            <td>  <input id="min_height" type="text" size="36" name="min_height" value="'.$min_height.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="max_height">'.__('Height of Google Map when open','wpestate').'</label></th>
            <td>  <input id="max_height" type="text" size="36" name="max_height" value="'.$max_height.'" /></td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="keep_min">'.__('Force Google Map at the "closed" size ? ','wpestate').'</label></th>
           
            <td> <select id="keep_min" name="keep_min">
                    '.$keep_min_symbol.'
		 </select>
            </td>
        </tr>


        <tr valign="top">
            <th scope="row"><label for="keep_min">'.__('Show Google Search over Map? ','wpestate').'</label></th>
           
            <td> <select id="show_g_search" name="show_g_search">
                    '.$show_g_search_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="map_style">'.__('Style for Google Map. Use https://snazzymaps.com/ to create styles ','wpestate').'</label></th>
            <td> 
           
                <textarea id="map_style" style="width:270px;height:350px;" name="map_style">'.stripslashes($map_style).'</textarea>
            </td>
        </tr>
        

        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>  
    ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_mapsettings  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_general_settings') ):
function wpestate_theme_admin_general_settings(){
    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    $logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
    $footer_logo_image              =   esc_html( get_option('wp_estate_footer_logo_image','') );
    $mobile_logo_image              =   esc_html( get_option('wp_estate_mobile_logo_image','') );
    $favicon_image                  =   esc_html( get_option('wp_estate_favicon_image','') );
    $google_analytics_code          =   esc_html ( get_option('wp_estate_google_analytics_code','') );
  
    $general_country                =   esc_html( get_option('wp_estate_general_country') );

   
    $front_end_register             =   esc_html( get_option('wp_estate_front_end_register','') );
    $front_end_login                =   esc_html( get_option('wp_estate_front_end_login','') );  
   
  
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $measure_sys='';
    $measure_array=array( __('feet','wpestate')     =>__('ft','wpestate'),
                          __('meters','wpestate')   =>__('m','wpestate') 
                        );
    
    $measure_array_status= esc_html( get_option('wp_estate_measure_sys','') );

    foreach($measure_array as $key => $value){
            $measure_sys.='<option value="'.$value.'"';
            if ($measure_array_status==$value){
                $measure_sys.=' selected="selected" ';
            }
            $measure_sys.='>'.__('square','wpestate').' '.$key.' - '.$value.'<sup>2</sup></option>';
    }


    $enable_top_bar_symbol      = wpestate_dropdowns_theme_admin($cache_array,'enable_top_bar');
    $enable_autocomplete_symbol = wpestate_dropdowns_theme_admin($cache_array,'enable_autocomplete');
    $enable_user_pass_symbol    = wpestate_dropdowns_theme_admin($cache_array,'enable_user_pass');
   
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
   
    $date_languages=array(  'xx'=> 'default',
                            'af'=>'Afrikaans',
                            'ar'=>'Arabic',
                            'ar-DZ' =>'Algerian',
                            'az'=>'Azerbaijani',
                            'be'=>'Belarusian',
                            'bg'=>'Bulgarian',
                            'bs'=>'Bosnian',
                            'ca'=>'Catalan',
                            'cs'=>'Czech',
                            'cy-GB'=>'Welsh/UK',
                            'da'=>'Danish',
                            'de'=>'German',
                            'el'=>'Greek',
                            'en-AU'=>'English/Australia',
                            'en-GB'=>'English/UK',
                            'en-NZ'=>'English/New Zealand',
                            'eo'=>'Esperanto',
                            'es'=>'Spanish',
                            'et'=>'Estonian',
                            'eu'=>'Karrikas-ek',
                            'fa'=>'Persian',
                            'fi'=>'Finnish',
                            'fo'=>'Faroese',
                            'fr'=>'French',
                            'fr-CA'=>'Canadian-French',
                            'fr-CH'=>'Swiss-French',
                            'gl'=>'Galician',
                            'he'=>'Hebrew',
                            'hi'=>'Hindi',
                            'hr'=>'Croatian',
                            'hu'=>'Hungarian',
                            'hy'=>'Armenian',
                            'id'=>'Indonesian',
                            'ic'=>'Icelandic',
                            'it'=>'Italian',
                            'it-CH'=>'Italian-CH',
                            'ja'=>'Japanese',
                            'ka'=>'Georgian',
                            'kk'=>'Kazakh',
                            'km'=>'Khmer',
                            'ko'=>'Korean',
                            'ky'=>'Kyrgyz',
                            'lb'=>'Luxembourgish',
                            'lt'=>'Lithuanian',
                            'lv'=>'Latvian',
                            'mk'=>'Macedonian',
                            'ml'=>'Malayalam',
                            'ms'=>'Malaysian',
                            'nb'=>'Norwegian',
                            'nl'=>'Dutch',
                            'nl-BE'=>'Dutch-Belgium',
                            'nn'=>'Norwegian-Nynorsk',
                            'no'=>'Norwegian',
                            'pl'=>'Polish',
                            'pt'=>'Portuguese',
                            'pt-BR'=>'Brazilian',
                            'rm'=>'Romansh',
                            'ro'=>'Romanian',
                            'ru'=>'Russian',
                            'sk'=>'Slovak',
                            'sl'=>'Slovenian',
                            'sq'=>'Albanian',
                            'sr'=>'Serbian',
                            'sr-SR'=>'Serbian-i18n',
                            'sv'=>'Swedish',
                            'ta'=>'Tamil',
                            'th'=>'Thai',
                            'tj'=>'Tajiki',
                            'tr'=>'Turkish',
                            'uk'=>'Ukrainian',
                            'vi'=>'Vietnamese',
                            'zh-CN'=>'Chinese',
                            'zh-HK'=>'Chinese-Hong-Kong',
                            'zh-TW'=>'Chinese Taiwan',
        );  

    
    $date_lang_symbol =  wpestate_dropdowns_theme_admin_with_key($date_languages,'date_lang');

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $where_currency_symbol          =   '';
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol_status   =   esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($where_currency_symbol_array as $value){
            $where_currency_symbol.='<option value="'.$value.'"';
            if ($where_currency_symbol_status==$value){
                $where_currency_symbol.=' selected="selected" ';
            }
            $where_currency_symbol.='>'.$value.'</option>';
    }

   

    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('General Settings','wpestate').'</h1>';  
    print '<a href="http://help.wpresidence.net/#!/theme_options" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
    print '<table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="logo_image">'.__('Your Logo','wpestate').'</label></th>
            <td>
                <input id="logo_image" type="text" size="36" name="logo_image" value="'.$logo_image.'" />
		<input id="logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" /></br>
                '.__('If you add images directly into the input fields (without Upload button) please use the full image path. For ex: http://www.wpresidence..... . If you use the "upload"  button use also "Insert into Post" button from the pop up window.','wpestate').'
       
            </td>
        </tr> 
        
      
        
        <tr valign="top">
            <th scope="row"><label for="footer_logo_image">'.__('Retina ready logo (add _2x after the name. For ex logo_2x.jpg) ','wpestate').'</label></th>
            <td>
                <input id="footer_logo_image" type="text" size="36" name="footer_logo_image" value="'.$footer_logo_image.'" />
		<input id="footer_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="logo_image">'.__('Mobile/Tablets Logo','wpestate').'</label></th>
            <td>
                <input id="mobile_logo_image" type="text" size="36" name="mobile_logo_image" value="'.$mobile_logo_image.'" />
		<input id="mobile_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
            </td>
        </tr> 
        
        
        <tr valign="top">
            <th scope="row"><label for="favicon_image">'.__('Your Favicon','wpestate').'</label></th>
            <td>
	        <input id="favicon_image" type="text" size="36" name="favicon_image" value="'.$favicon_image.'" />
		<input id="favicon_image_button" type="button"  class="upload_button button" value="'.__('Upload Favicon','wpestate').'" />
            </td>
        </tr> 
        
        
        <tr valign="top">
            <th scope="row"><label for="google_analytics_code">'.__('Google Analytics Tracking id (ex UA-41924406-1)','wpestate').'</label></th>
            <td><input cols="57" rows="2" name="google_analytics_code" id="google_analytics_code" value="'.$google_analytics_code.'"></input></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="country_list">'.__('Country:','wpestate').'</label></th>
            <td>'.wpestate_general_country_list($general_country).'</td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="">'.__('Measurement Unit','wpestate').'</label></th>
            <td> <select id="measure_sys" name="measure_sys">
                    '.$measure_sys.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="">'.__('Enable Autocomplete in Front End Submission Form','wpestate').'</label></th>
            <td> <select id="enable_autocomplete" name="enable_autocomplete">
                    '.$enable_autocomplete_symbol.'
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="">'.__('Users can type the password on registration form','wpestate').'</label></th>
            <td> <select id="enable_user_pass" name="enable_user_pass">
                    '.$enable_user_pass_symbol.'
		 </select>
            </td>
        </tr>

         
        <tr valign="top">
            <th scope="row"><label for="">'.__('Language for datepicker','wpestate').'</label></th>
            <td> <select id="date_lang" name="date_lang">
                    '.$date_lang_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="">'.__(' Export Theme Options','wpestate').'</label></th>
            <td> <textarea  rows="15" cols="75" id="export_theme_options" onclick="this.focus();this.select()" name="export_theme_options">'.wpestate_export_theme_options().'</textarea>
            </td>
        </tr>
        

        </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>    
    ';
    
 print '</div>';   
}
endif; // end   wpestate_theme_admin_general_settings  



function wpestate_export_theme_options(){
    $export_options = array(
        'wp_estate_show_top_bar_user_login',
        'wp_estate_show_top_bar_user_menu',
        'wp_estate_show_adv_search_general',
        'wp_estate_currency_symbol',
        'wp_estate_where_currency_symbol',
        'wp_estate_measure_sys',
        'wp_estate_facebook_login',
        'wp_estate_google_login',
        'wp_estate_yahoo_login',
        'wp_estate_wide_status',
        'wp_estate_header_type',
        'wp_estate_prop_no',
        'wp_estate_show_empty_city',
        'wp_estate_blog_sidebar',
        'wp_estate_blog_sidebar_name',
        'wp_estate_blog_unit',
        'wp_estate_general_latitude',
        'wp_estate_general_longitude',
        'wp_estate_default_map_zoom',
        'wp_estate_cache',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_pin_cluster',
        'wp_estate_zoom_cluster',
        'wp_estate_hq_latitude',
        'wp_estate_hq_longitude',
        'wp_estate_idx_enable',
        'wp_estate_geolocation_radius',
        'wp_estate_min_height',
        'wp_estate_max_height',
        'wp_estate_keep_min',
        'wp_estate_paid_submission',
        'wp_estate_admin_submission',
        'wp_estate_user_agent',
        'wp_estate_price_submission',
        'wp_estate_price_featured_submission',
        'wp_estate_submission_curency',
        'wp_estate_free_mem_list',
        'wp_estate_free_feat_list',
        'wp_estate_free_feat_list_expiration',
        'wp_estate_custom_advanced_search',
        'wp_estate_adv_search_type',
        'wp_estate_show_adv_search',
        'wp_estate_show_adv_search_map_close',
        'wp_estate_cron_run',
        'wp_estate_show_no_features',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_status_list',
        'wp_estate_slider_cycle',
        'wp_estate_show_save_search',
        'wp_estate_search_alert',
        'wp_estate_adv_search_type',
        'wp_estate_color_scheme',
        'wp_estate_main_color',
        'wp_estate_background_color',
        'wp_estate_content_back_color',
        'wp_estate_header_color',
        'wp_estate_breadcrumbs_font_color',
        'wp_estate_font_color',
        'wp_estate_menu_items_color',
        'wp_estate_link_color',
        'wp_estate_headings_color',
        'wp_estate_sidebar_heading_boxed_color',
        'wp_estate_sidebar_heading_color',
        'wp_estate_sidebar_widget_color',
        'wp_estate_sidebar2_font_color',
        'wp_estate_footer_back_color',
        'wp_estate_footer_font_color',
        'wp_estate_footer_copy_color',
        'wp_estate_menu_font_color',
        'wp_estate_menu_hover_back_color',
        'wp_estate_menu_hover_font_color',
        'wp_estate_top_bar_back',
        'wp_estate_top_bar_font',
        'wp_estate_adv_search_back_color',
        'wp_estate_adv_search_font_color',
        'wp_estate_box_content_back_color',
        'wp_estate_box_content_border_color',
        'wp_estate_hover_button_color',
        'wp_estate_show_g_search',
        'wp_estate_show_adv_search_extended',
        'wp_estate_readsys',
        'wp_estate_ssl_map',
        'wp_estate_enable_stripe',    
        'wp_estate_enable_paypal',    
        'wp_estate_enable_direct_pay',    
        'wp_estate_global_property_page_agent_sidebar',
        'wp_estate_global_prpg_slider_type',
        'wp_estate_global_prpg_content_type',
        'wp_estate_logo_margin',
        'wp_estate_header_transparent',
        'wp_estate_default_map_type',
        'wp_estate_prices_th_separator',
        'wp_estate_multi_curr',
        'wp_estate_date_lang',
        'wp_estate_blog_unit',
        'wp_estate_enable_autocomplete',
        'wp_estate_enable_user_pass',
        'wp_estate_auto_curency',
        'wp_estate_status_list',
        'wp_estate_custom_fields',
        'wp_estate_subject_password_reset_request',
        'wp_estate_password_reset_request',
        'wp_estate_subject_password_reseted',
        'wp_estate_password_reseted',
        'wp_estate_subject_purchase_activated',
        'wp_estate_purchase_activated',
        'wp_estate_subject_approved_listing',
        'wp_estate_approved_listing',
        'wp_estate_subject_new_wire_transfer',
        'wp_estate_new_wire_transfer',
        'wp_estate_subject_admin_new_wire_transfer',
        'wp_estate_admin_new_wire_transfer',
        'wp_estate_subject_admin_new_user',
        'wp_estate_admin_new_user',
        'wp_estate_subject_new_user',
        'wp_estate_new_user',
        'wp_estate_subject_admin_expired_listing',
        'wp_estate_admin_expired_listing',
        'wp_estate_subject_matching_submissions',
        'wp_estate_subject_paid_submissions',
        'wp_estate_paid_submissions',
        'wp_estate_subject_featured_submission',
        'wp_estate_featured_submission',
        'wp_estate_subject_account_downgraded',
        'wp_estate_account_downgraded',
        'wp_estate_subject_membership_cancelled',
        'wp_estate_membership_cancelled',
        'wp_estate_subject_membership_activated',
        'wp_estate_membership_activated',
        'wp_estate_subject_free_listing_expired',
        'wp_estate_free_listing_expired',
        'wp_estate_subject_new_listing_submission',
        'wp_estate_new_listing_submission',
        'wp_estate_subject_listing_edit',
        'wp_estate_listing_edit',
        'wp_estate_subject_recurring_payment',
        'wp_estate_subject_recurring_payment',
         'wp_estate_custom_css',
        'wp_estate_company_name',
        'wp_estate_telephone_no',
        'wp_estate_mobile_no',
        'wp_estate_fax_ac',
        'wp_estate_skype_ac',
        'wp_estate_co_address',
        'wp_estate_facebook_link',
        'wp_estate_twitter_link',
        'wp_estate_pinterest_link',
        'wp_estate_linkedin_link',
        'wp_estate_contact_form_7_agent',
        'wp_estate_contact_form_7_contact',
        'wp_estate_global_revolution_slider',
        'wp_estate_repeat_footer_back',
        'wp_estate_prop_list_slider',
        'wp_estate_agent_sidebar',
        'wp_estate_agent_sidebar_name',
        'wp_estate_property_list_type',
        'wp_estate_property_list_type_adv',
        'wp_estate_prop_unit',
        'wp_estate_general_font',
        'wp_estate_headings_font_subset',
        'wp_estate_copyright_message',
        'wp_estate_show_graph_prop_page',
        'wp_estate_map_style',
        'wp_estate_submission_curency_custom',
        'wp_estate_free_mem_list_unl',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_type',
        'wp_estate_adv_search_type',
        'wp_estate_show_save_search',
        'wp_estate_show_adv_search_slider',
        'wp_estate_show_adv_search_visible',
        'wp_estate_show_slider_price',
        'wp_estate_show_dropdowns',
        'wp_estate_show_slider_min_price',
        'wp_estate_show_slider_max_price',
        'wp_estate_feature_list',
        'wp_estate_show_no_features',
        'wp_estate_advanced_exteded',
        'wp_estate_adv_search_what',
        'wp_estate_adv_search_how',
        'wp_estate_adv_search_label',
        'wp_estate_adv_search_type',
        'wp_estate_property_adr_text',
        'wp_estate_property_features_text',
        'wp_estate_property_description_text',
        'wp_estate_property_details_text',
        'wp_estate_new_status',
        'wp_estate_status_list',
        'wp_estate_theme_slider',
        'wp_estate_slider_cycle',
        );
    
    $return_exported_data=array();
    // esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($export_options as $option){
        $real_option=get_option($option);
        
        if(is_array($real_option)){
            $return_exported_data[$option]= get_option($option) ;
        }else{
            $return_exported_data[$option]=esc_html( get_option($option) );
        }
     
    }
    
    return base64_encode( serialize( $return_exported_data) );
    
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Social $  Contact
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_theme_admin_social') ):
function wpestate_theme_admin_social(){
    $fax_ac                     =   esc_html ( get_option('wp_estate_fax_ac','') );
    $skype_ac                   =   esc_html ( get_option('wp_estate_skype_ac','') );
    $telephone_no               =   esc_html ( get_option('wp_estate_telephone_no','') );
    $mobile_no                  =   esc_html ( get_option('wp_estate_mobile_no','') );
    $company_name               =   esc_html ( stripslashes(get_option('wp_estate_company_name','') ) );
    $email_adr                  =   esc_html ( get_option('wp_estate_email_adr','') );
    $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );   
    $co_address                 =   esc_html ( stripslashes( get_option('wp_estate_co_address','') ) );
    $facebook_link              =   esc_html ( get_option('wp_estate_facebook_link','') );
    $twitter_link               =   esc_html ( get_option('wp_estate_twitter_link','') );
    $google_link                =   esc_html ( get_option('wp_estate_google_link','') );
    $linkedin_link              =   esc_html ( get_option('wp_estate_linkedin_link','') );
    $pinterest_link             =   esc_html ( get_option('wp_estate_pinterest_link','') );  
    $twitter_consumer_key       =   esc_html ( get_option('wp_estate_twitter_consumer_key','') );
    $twitter_consumer_secret    =   esc_html ( get_option('wp_estate_twitter_consumer_secret','') );
    $twitter_access_token       =   esc_html ( get_option('wp_estate_twitter_access_token','') );
    $twitter_access_secret      =   esc_html ( get_option('wp_estate_twitter_access_secret','') );
    $twitter_cache_time         =   intval   ( get_option('wp_estate_twitter_cache_time','') );
    $zillow_api_key             =   esc_html ( get_option('wp_estate_zillow_api_key','') );
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    $company_contact_image      =   esc_html( get_option('wp_estate_company_contact_image','') );
    $google_oauth_api           =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    $google_oauth_client_secret =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    $google_api_key             =   esc_html ( get_option('wp_estate_google_api_key','') );
    
    
    $social_array               =   array('no','yes');
   
    $facebook_login_select      = wpestate_dropdowns_theme_admin($social_array,'facebook_login');
    $google_login_select        = wpestate_dropdowns_theme_admin($social_array,'google_login');
    $yahoo_login_select         = wpestate_dropdowns_theme_admin($social_array,'yahoo_login');
    $contact_form_7_contact     = stripslashes( esc_html( get_option('wp_estate_contact_form_7_contact','') ) );
    $contact_form_7_agent       = stripslashes( esc_html( get_option('wp_estate_contact_form_7_agent','') ) );
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">Social</h1>';
    print '<a href="http://help.wpresidence.net/#!/social" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
   
    print '<table class="form-table">     
        <tr valign="top">
            <th scope="row"><label for="company_contact_image">'.__('Image for Contact Page','wpestate').'</label></th>
            <td>
	        <input id="company_contact_image" type="text" size="36" name="company_contact_image" value="'.$company_contact_image.'" />
		<input id="company_contact_image_button" type="button"  class="upload_button button" value="'.__('Upload Image','wpestate').'" />
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="company_name">'.__('Company Name','wpestate').'</label></th>
            <td>  <input id="company_name" type="text" size="36" name="company_name" value="'.$company_name.'" /></td>
        </tr>   
        
    	<tr valign="top">
            <th scope="row"><label for="email_adr">'.__('Email','wpestate').'</label></th>
            <td>  <input id="email_adr" type="text" size="36" name="email_adr" value="'.$email_adr.'" /></td>
        </tr>    
        
        <tr valign="top">
            <th scope="row"><label for="duplicate_email_adr">'.__('Send all contact emails to:','wpestate').'</label></th>
            <td>  <input id="duplicate_email_adr" type="text" size="36" name="duplicate_email_adr" value="'.$duplicate_email_adr.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="telephone_no">'.__('Telephone','wpestate').'</label></th>
            <td>  <input id="telephone_no" type="text" size="36" name="telephone_no" value="'.$telephone_no.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="mobile_no">'.__('Mobile','wpestate').'</label></th>
            <td>  <input id="mobile_no" type="text" size="36" name="mobile_no" value="'.$mobile_no.'" /></td>
        </tr> 
        
         <tr valign="top">
            <th scope="row"><label for="fax_ac">'.__('Fax','wpestate').'</label></th>
            <td>  <input id="fax_ac" type="text" size="36" name="fax_ac" value="'.$fax_ac.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="skype_ac">'.__('Skype','wpestate').'</label></th>
            <td>  <input id="skype_ac" type="text" size="36" name="skype_ac" value="'.$skype_ac.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="co_address">'.__('Address','wpestate').'</label></th>
            <td><textarea cols="57" rows="2" name="co_address" id="co_address">'.$co_address.'</textarea></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="facebook_link">'.__('Facebook Link','wpestate').'</label></th>
            <td>  <input id="facebook_link" type="text" size="36" name="facebook_link" value="'.$facebook_link.'" /></td>
        </tr>        
        
        <tr valign="top">
            <th scope="row"><label for="twitter_link">'.__('Twitter Page Link','wpestate').'</label></th>
            <td>  <input id="twitter_link" type="text" size="36" name="twitter_link" value="'.$twitter_link.'" /></td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="google_link">'.__('Google+ Link','wpestate').'</label></th>
            <td>  <input id="google_link" type="text" size="36" name="google_link" value="'.$google_link.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="pinterest_link">'.__('Pinterest Link','wpestate').'</label></th>
            <td>  <input id="pinterest_link" type="text" size="36" name="pinterest_link" value="'.$pinterest_link.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="linkedin_link">'.__('Linkedin Link','wpestate').'</label></th>
            <td>  <input id="linkedin_link" type="text" size="36" name="linkedin_link" value="'.$linkedin_link.'" /></td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="twitter_consumer_key">'.__('Twitter Consumer Key','wpestate').'</label></th>
            <td>  <input id="twitter_consumer_key" type="text" size="36" name="twitter_consumer_key" value="'.$twitter_consumer_key.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="twitter_consumer_secret">'.__('Twitter Consumer Secret','wpestate').'</label></th>
            <td>  <input id="twitter_consumer_secret" type="text" size="36" name="twitter_consumer_secret" value="'.$twitter_consumer_secret.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="twitter_access_token">'.__('Twitter Access Token','wpestate').'</label></th>
            <td>  <input id="twitter_account" type="text" size="36" name="twitter_access_token" value="'.$twitter_access_token.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="twitter_access_secret">'.__('Twitter Access Token Secret','wpestate').'</label></th>
            <td>  <input id="twitter_access_secret" type="text" size="36" name="twitter_access_secret" value="'.$twitter_access_secret.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="twitter_cache_time">'.__('Twitter Cache Time in hours','wpestate').'</label></th>
            <td>  <input id="twitter_cache_time" type="text" size="36" name="twitter_cache_time" value="'.$twitter_cache_time.'" /></td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="facebook_api">'.__('Facebook Api Key (for Facebook login)','wpestate').'</label></th>
            <td>  <input id="facebook_api" type="text" size="36" name="facebook_api" value="'.$facebook_api.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="facebook_secret">'.__('Facebook secret code (for Facebook login) ','wpestate').'</label></th>
            <td>  <input id="facebook_secret" type="text" size="36" name="facebook_secret" value="'.$facebook_secret.'" /></td>
        </tr>
       
        <tr valign="top">
            <th scope="row"><label for="google_oauth_api">'.__('Google OAuth client id (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_oauth_api" type="text" size="36" name="google_oauth_api" value="'.$google_oauth_api.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_oauth_client_secret">'.__('Google Client Secret (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_oauth_client_secret" type="text" size="36" name="google_oauth_client_secret" value="'.$google_oauth_client_secret.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_api_key">'.__('Google Api key (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_api_key" type="text" size="36" name="google_api_key" value="'.$google_api_key.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="facebook_login">'.__('Allow login via Facebook ? ','wpestate').'</label></th>
            <td> <select id="facebook_login" name="facebook_login">
                    '.$facebook_login_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_login">'.__('Allow login via Google ?','wpestate').' </label></th>
            <td> <select id="google_login" name="google_login">
                    '.$google_login_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="yahoo_login">'.__('Allow login via Yahoo ? ','wpestate').'</label></th>
            <td> <select id="yahoo_login" name="yahoo_login">
                    '.$yahoo_login_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="contact_form_7_agent">'.__('Contact form 7 code for agent (ex: [contact-form-7 id="2725" title="contact me"])','wpestate').'</label></th>
            <td> 
                <input type="text" size="36" id="contact_form_7_agent" name="contact_form_7_agent" value="'.$contact_form_7_agent.'" />
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="contact_form_7_contact">'.__('Contact form 7 code for contact page template (ex: [contact-form-7 id="2725" title="contact me"])','wpestate').'</label></th>
            <td> 
                 <input type="text" size="36" id="contact_form_7_contact" name="contact_form_7_contact" value="'.$contact_form_7_contact.'" />
            </td>
        </tr>
        

    </table>
    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
    </p>';
print '</div>';
}
endif; // end   wpestate_theme_admin_social  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Apperance
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_apperance') ):
function wpestate_theme_admin_apperance(){
    $cache_array                =   array('yes','no');
    $prop_no                    =   intval   ( get_option('wp_estate_prop_no','') );
    $blog_sidebar_name          =   esc_html ( get_option('wp_estate_blog_sidebar_name','') );
    $zillow_api_key             =   esc_html ( get_option('wp_estate_zillow_api_key','') );  
    $copyright_message          =   esc_html (stripslashes( get_option('wp_estate_copyright_message','') ) );   
    $logo_margin                =   intval( get_option('wp_estate_logo_margin','') ); 
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    $show_empty_city_status_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_empty_city');
    $show_top_bar_user_menu_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_menu');
    $show_top_bar_user_login_symbol     = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_login');
    
    $blog_sidebar_array=array('no sidebar','right','left');
    $agent_sidebar_pos_select     = wpestate_dropdowns_theme_admin($blog_sidebar_array,'agent_sidebar');

    
    $blog_sidebar_select ='';
    $blog_sidebar= esc_html ( get_option('wp_estate_blog_sidebar','') );
    $blog_sidebar_array=array('no sidebar','right','left');

    foreach($blog_sidebar_array as $value){
            $blog_sidebar_select.='<option value="'.$value.'"';
            if ($blog_sidebar==$value){
                    $blog_sidebar_select.='selected="selected"';
            }
            $blog_sidebar_select.='>'.$value.'</option>';
    }

    
    
    $agent_sidebar_name          =   esc_html ( get_option('wp_estate_agent_sidebar_name','') );
    $agent_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $agent_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($agent_sidebar_name==$sidebar['id']){ 
               $agent_sidebar_name_select.=' selected="selected"';
            }
        $agent_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $blog_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $blog_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($blog_sidebar_name==$sidebar['id']){ 
               $blog_sidebar_name_select.=' selected="selected"';
            }
        $blog_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
   ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $blog_unit_array    =   array(
                                'grid'    =>__('grid','wpestate'),
                                'list'      => __('list','wpestate')
                            );
    
    $blog_unit_select = wpestate_dropdowns_theme_admin_with_key($blog_unit_array,'blog_unit');
            
    $prop_unit_array    =   array(
                                'grid'    =>__('grid','wpestate'),
                                'list'      => __('list','wpestate')
                            );
    $prop_unit_select_view   = wpestate_dropdowns_theme_admin_with_key($prop_unit_array,'prop_unit');
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $blog_sidebar_array =   array('no sidebar','right','left');
    $prop_unit_select   =   wpestate_dropdowns_theme_admin($blog_sidebar_array,'blog_sidebar');
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $general_font_select='';
    $general_font= esc_html ( get_option('wp_estate_general_font','') );
    if($general_font!='x'){
        $general_font_select='<option value="'.$general_font.'">'.$general_font.'</option>';
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
  
    $wide_array=array(
               "1"  =>  __("wide","wpestate"),
               "2"  =>  __("boxed","wpestate")
            );
    $wide_status_symbol   = wpestate_dropdowns_theme_admin_with_key($wide_array,'wide_status');

    
    $google_fonts_array = array(                          
                                                            "Abel" => "Abel",
                                                            "Abril Fatface" => "Abril Fatface",
                                                            "Aclonica" => "Aclonica",
                                                            "Acme" => "Acme",
                                                            "Actor" => "Actor",
                                                            "Adamina" => "Adamina",
                                                            "Advent Pro" => "Advent Pro",
                                                            "Aguafina Script" => "Aguafina Script",
                                                            "Aladin" => "Aladin",
                                                            "Aldrich" => "Aldrich",
                                                            "Alegreya" => "Alegreya",
                                                            "Alegreya SC" => "Alegreya SC",
                                                            "Alex Brush" => "Alex Brush",
                                                            "Alfa Slab One" => "Alfa Slab One",
                                                            "Alice" => "Alice",
                                                            "Alike" => "Alike",
                                                            "Alike Angular" => "Alike Angular",
                                                            "Allan" => "Allan",
                                                            "Allerta" => "Allerta",
                                                            "Allerta Stencil" => "Allerta Stencil",
                                                            "Allura" => "Allura",
                                                            "Almendra" => "Almendra",
                                                            "Almendra SC" => "Almendra SC",
                                                            "Amaranth" => "Amaranth",
                                                            "Amatic SC" => "Amatic SC",
                                                            "Amethysta" => "Amethysta",
                                                            "Andada" => "Andada",
                                                            "Andika" => "Andika",
                                                            "Angkor" => "Angkor",
                                                            "Annie Use Your Telescope" => "Annie Use Your Telescope",
                                                            "Anonymous Pro" => "Anonymous Pro",
                                                            "Antic" => "Antic",
                                                            "Antic Didone" => "Antic Didone",
                                                            "Antic Slab" => "Antic Slab",
                                                            "Anton" => "Anton",
                                                            "Arapey" => "Arapey",
                                                            "Arbutus" => "Arbutus",
                                                            "Architects Daughter" => "Architects Daughter",
                                                            "Arimo" => "Arimo",
                                                            "Arizonia" => "Arizonia",
                                                            "Armata" => "Armata",
                                                            "Artifika" => "Artifika",
                                                            "Arvo" => "Arvo",
                                                            "Asap" => "Asap",
                                                            "Asset" => "Asset",
                                                            "Astloch" => "Astloch",
                                                            "Asul" => "Asul",
                                                            "Atomic Age" => "Atomic Age",
                                                            "Aubrey" => "Aubrey",
                                                            "Audiowide" => "Audiowide",
                                                            "Average" => "Average",
                                                            "Averia Gruesa Libre" => "Averia Gruesa Libre",
                                                            "Averia Libre" => "Averia Libre",
                                                            "Averia Sans Libre" => "Averia Sans Libre",
                                                            "Averia Serif Libre" => "Averia Serif Libre",
                                                            "Bad Script" => "Bad Script",
                                                            "Balthazar" => "Balthazar",
                                                            "Bangers" => "Bangers",
                                                            "Basic" => "Basic",
                                                            "Battambang" => "Battambang",
                                                            "Baumans" => "Baumans",
                                                            "Bayon" => "Bayon",
                                                            "Belgrano" => "Belgrano",
                                                            "Belleza" => "Belleza",
                                                            "Bentham" => "Bentham",
                                                            "Berkshire Swash" => "Berkshire Swash",
                                                            "Bevan" => "Bevan",
                                                            "Bigshot One" => "Bigshot One",
                                                            "Bilbo" => "Bilbo",
                                                            "Bilbo Swash Caps" => "Bilbo Swash Caps",
                                                            "Bitter" => "Bitter",
                                                            "Black Ops One" => "Black Ops One",
                                                            "Bokor" => "Bokor",
                                                            "Bonbon" => "Bonbon",
                                                            "Boogaloo" => "Boogaloo",
                                                            "Bowlby One" => "Bowlby One",
                                                            "Bowlby One SC" => "Bowlby One SC",
                                                            "Brawler" => "Brawler",
                                                            "Bree Serif" => "Bree Serif",
                                                            "Bubblegum Sans" => "Bubblegum Sans",
                                                            "Buda" => "Buda",
                                                            "Buenard" => "Buenard",
                                                            "Butcherman" => "Butcherman",
                                                            "Butterfly Kids" => "Butterfly Kids",
                                                            "Cabin" => "Cabin",
                                                            "Cabin Condensed" => "Cabin Condensed",
                                                            "Cabin Sketch" => "Cabin Sketch",
                                                            "Caesar Dressing" => "Caesar Dressing",
                                                            "Cagliostro" => "Cagliostro",
                                                            "Calligraffitti" => "Calligraffitti",
                                                            "Cambo" => "Cambo",
                                                            "Candal" => "Candal",
                                                            "Cantarell" => "Cantarell",
                                                            "Cantata One" => "Cantata One",
                                                            "Cardo" => "Cardo",
                                                            "Carme" => "Carme",
                                                            "Carter One" => "Carter One",
                                                            "Caudex" => "Caudex",
                                                            "Cedarville Cursive" => "Cedarville Cursive",
                                                            "Ceviche One" => "Ceviche One",
                                                            "Changa One" => "Changa One",
                                                            "Chango" => "Chango",
                                                            "Chau Philomene One" => "Chau Philomene One",
                                                            "Chelsea Market" => "Chelsea Market",
                                                            "Chenla" => "Chenla",
                                                            "Cherry Cream Soda" => "Cherry Cream Soda",
                                                            "Chewy" => "Chewy",
                                                            "Chicle" => "Chicle",
                                                            "Chivo" => "Chivo",
                                                            "Coda" => "Coda",
                                                            "Coda Caption" => "Coda Caption",
                                                            "Codystar" => "Codystar",
                                                            "Comfortaa" => "Comfortaa",
                                                            "Coming Soon" => "Coming Soon",
                                                            "Concert One" => "Concert One",
                                                            "Condiment" => "Condiment",
                                                            "Content" => "Content",
                                                            "Contrail One" => "Contrail One",
                                                            "Convergence" => "Convergence",
                                                            "Cookie" => "Cookie",
                                                            "Copse" => "Copse",
                                                            "Corben" => "Corben",
                                                            "Cousine" => "Cousine",
                                                            "Coustard" => "Coustard",
                                                            "Covered By Your Grace" => "Covered By Your Grace",
                                                            "Crafty Girls" => "Crafty Girls",
                                                            "Creepster" => "Creepster",
                                                            "Crete Round" => "Crete Round",
                                                            "Crimson Text" => "Crimson Text",
                                                            "Crushed" => "Crushed",
                                                            "Cuprum" => "Cuprum",
                                                            "Cutive" => "Cutive",
                                                            "Damion" => "Damion",
                                                            "Dancing Script" => "Dancing Script",
                                                            "Dangrek" => "Dangrek",
                                                            "Dawning of a New Day" => "Dawning of a New Day",
                                                            "Days One" => "Days One",
                                                            "Delius" => "Delius",
                                                            "Delius Swash Caps" => "Delius Swash Caps",
                                                            "Delius Unicase" => "Delius Unicase",
                                                            "Della Respira" => "Della Respira",
                                                            "Devonshire" => "Devonshire",
                                                            "Didact Gothic" => "Didact Gothic",
                                                            "Diplomata" => "Diplomata",
                                                            "Diplomata SC" => "Diplomata SC",
                                                            "Doppio One" => "Doppio One",
                                                            "Dorsa" => "Dorsa",
                                                            "Dosis" => "Dosis",
                                                            "Dr Sugiyama" => "Dr Sugiyama",
                                                            "Droid Sans" => "Droid Sans",
                                                            "Droid Sans Mono" => "Droid Sans Mono",
                                                            "Droid Serif" => "Droid Serif",
                                                            "Duru Sans" => "Duru Sans",
                                                            "Dynalight" => "Dynalight",
                                                            "EB Garamond" => "EB Garamond",
                                                            "Eater" => "Eater",
                                                            "Economica" => "Economica",
                                                            "Electrolize" => "Electrolize",
                                                            "Emblema One" => "Emblema One",
                                                            "Emilys Candy" => "Emilys Candy",
                                                            "Engagement" => "Engagement",
                                                            "Enriqueta" => "Enriqueta",
                                                            "Erica One" => "Erica One",
                                                            "Esteban" => "Esteban",
                                                            "Euphoria Script" => "Euphoria Script",
                                                            "Ewert" => "Ewert",
                                                            "Exo" => "Exo",
                                                            "Expletus Sans" => "Expletus Sans",
                                                            "Fanwood Text" => "Fanwood Text",
                                                            "Fascinate" => "Fascinate",
                                                            "Fascinate Inline" => "Fascinate Inline",
                                                            "Federant" => "Federant",
                                                            "Federo" => "Federo",
                                                            "Felipa" => "Felipa",
                                                            "Fjord One" => "Fjord One",
                                                            "Flamenco" => "Flamenco",
                                                            "Flavors" => "Flavors",
                                                            "Fondamento" => "Fondamento",
                                                            "Fontdiner Swanky" => "Fontdiner Swanky",
                                                            "Forum" => "Forum",
                                                            "Francois One" => "Francois One",
                                                            "Fredericka the Great" => "Fredericka the Great",
                                                            "Fredoka One" => "Fredoka One",
                                                            "Freehand" => "Freehand",
                                                            "Fresca" => "Fresca",
                                                            "Frijole" => "Frijole",
                                                            "Fugaz One" => "Fugaz One",
                                                            "GFS Didot" => "GFS Didot",
                                                            "GFS Neohellenic" => "GFS Neohellenic",
                                                            "Galdeano" => "Galdeano",
                                                            "Gentium Basic" => "Gentium Basic",
                                                            "Gentium Book Basic" => "Gentium Book Basic",
                                                            "Geo" => "Geo",
                                                            "Geostar" => "Geostar",
                                                            "Geostar Fill" => "Geostar Fill",
                                                            "Germania One" => "Germania One",
                                                            "Give You Glory" => "Give You Glory",
                                                            "Glass Antiqua" => "Glass Antiqua",
                                                            "Glegoo" => "Glegoo",
                                                            "Gloria Hallelujah" => "Gloria Hallelujah",
                                                            "Goblin One" => "Goblin One",
                                                            "Gochi Hand" => "Gochi Hand",
                                                            "Gorditas" => "Gorditas",
                                                            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
                                                            "Graduate" => "Graduate",
                                                            "Gravitas One" => "Gravitas One",
                                                            "Great Vibes" => "Great Vibes",
                                                            "Gruppo" => "Gruppo",
                                                            "Gudea" => "Gudea",
                                                            "Habibi" => "Habibi",
                                                            "Hammersmith One" => "Hammersmith One",
                                                            "Handlee" => "Handlee",
                                                            "Hanuman" => "Hanuman",
                                                            "Happy Monkey" => "Happy Monkey",
                                                            "Henny Penny" => "Henny Penny",
                                                            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
                                                            "Holtwood One SC" => "Holtwood One SC",
                                                            "Homemade Apple" => "Homemade Apple",
                                                            "Homenaje" => "Homenaje",
                                                            "IM Fell DW Pica" => "IM Fell DW Pica",
                                                            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
                                                            "IM Fell Double Pica" => "IM Fell Double Pica",
                                                            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
                                                            "IM Fell English" => "IM Fell English",
                                                            "IM Fell English SC" => "IM Fell English SC",
                                                            "IM Fell French Canon" => "IM Fell French Canon",
                                                            "IM Fell French Canon SC" => "IM Fell French Canon SC",
                                                            "IM Fell Great Primer" => "IM Fell Great Primer",
                                                            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
                                                            "Iceberg" => "Iceberg",
                                                            "Iceland" => "Iceland",
                                                            "Imprima" => "Imprima",
                                                            "Inconsolata" => "Inconsolata",
                                                            "Inder" => "Inder",
                                                            "Indie Flower" => "Indie Flower",
                                                            "Inika" => "Inika",
                                                            "Irish Grover" => "Irish Grover",
                                                            "Istok Web" => "Istok Web",
                                                            "Italiana" => "Italiana",
                                                            "Italianno" => "Italianno",
                                                            "Jim Nightshade" => "Jim Nightshade",
                                                            "Jockey One" => "Jockey One",
                                                            "Jolly Lodger" => "Jolly Lodger",
                                                            "Josefin Sans" => "Josefin Sans",
                                                            "Josefin Slab" => "Josefin Slab",
                                                            "Judson" => "Judson",
                                                            "Julee" => "Julee",
                                                            "Junge" => "Junge",
                                                            "Jura" => "Jura",
                                                            "Just Another Hand" => "Just Another Hand",
                                                            "Just Me Again Down Here" => "Just Me Again Down Here",
                                                            "Kameron" => "Kameron",
                                                            "Karla" => "Karla",
                                                            "Kaushan Script" => "Kaushan Script",
                                                            "Kelly Slab" => "Kelly Slab",
                                                            "Kenia" => "Kenia",
                                                            "Khmer" => "Khmer",
                                                            "Knewave" => "Knewave",
                                                            "Kotta One" => "Kotta One",
                                                            "Koulen" => "Koulen",
                                                            "Kranky" => "Kranky",
                                                            "Kreon" => "Kreon",
                                                            "Kristi" => "Kristi",
                                                            "Krona One" => "Krona One",
                                                            "La Belle Aurore" => "La Belle Aurore",
                                                            "Lancelot" => "Lancelot",
                                                            "Lato" => "Lato",
                                                            "League Script" => "League Script",
                                                            "Leckerli One" => "Leckerli One",
                                                            "Ledger" => "Ledger",
                                                            "Lekton" => "Lekton",
                                                            "Lemon" => "Lemon",
                                                            "Lilita One" => "Lilita One",
                                                            "Limelight" => "Limelight",
                                                            "Linden Hill" => "Linden Hill",
                                                            "Lobster" => "Lobster",
                                                            "Lobster Two" => "Lobster Two",
                                                            "Londrina Outline" => "Londrina Outline",
                                                            "Londrina Shadow" => "Londrina Shadow",
                                                            "Londrina Sketch" => "Londrina Sketch",
                                                            "Londrina Solid" => "Londrina Solid",
                                                            "Lora" => "Lora",
                                                            "Love Ya Like A Sister" => "Love Ya Like A Sister",
                                                            "Loved by the King" => "Loved by the King",
                                                            "Lovers Quarrel" => "Lovers Quarrel",
                                                            "Luckiest Guy" => "Luckiest Guy",
                                                            "Lusitana" => "Lusitana",
                                                            "Lustria" => "Lustria",
                                                            "Macondo" => "Macondo",
                                                            "Macondo Swash Caps" => "Macondo Swash Caps",
                                                            "Magra" => "Magra",
                                                            "Maiden Orange" => "Maiden Orange",
                                                            "Mako" => "Mako",
                                                            "Marck Script" => "Marck Script",
                                                            "Marko One" => "Marko One",
                                                            "Marmelad" => "Marmelad",
                                                            "Marvel" => "Marvel",
                                                            "Mate" => "Mate",
                                                            "Mate SC" => "Mate SC",
                                                            "Maven Pro" => "Maven Pro",
                                                            "Meddon" => "Meddon",
                                                            "MedievalSharp" => "MedievalSharp",
                                                            "Medula One" => "Medula One",
                                                            "Megrim" => "Megrim",
                                                            "Merienda One" => "Merienda One",
                                                            "Merriweather" => "Merriweather",
                                                            "Metal" => "Metal",
                                                            "Metamorphous" => "Metamorphous",
                                                            "Metrophobic" => "Metrophobic",
                                                            "Michroma" => "Michroma",
                                                            "Miltonian" => "Miltonian",
                                                            "Miltonian Tattoo" => "Miltonian Tattoo",
                                                            "Miniver" => "Miniver",
                                                            "Miss Fajardose" => "Miss Fajardose",
                                                            "Modern Antiqua" => "Modern Antiqua",
                                                            "Molengo" => "Molengo",
                                                            "Monofett" => "Monofett",
                                                            "Monoton" => "Monoton",
                                                            "Monsieur La Doulaise" => "Monsieur La Doulaise",
                                                            "Montaga" => "Montaga",
                                                            "Montez" => "Montez",
                                                            "Montserrat" => "Montserrat",
                                                            "Moul" => "Moul",
                                                            "Moulpali" => "Moulpali",
                                                            "Mountains of Christmas" => "Mountains of Christmas",
                                                            "Mr Bedfort" => "Mr Bedfort",
                                                            "Mr Dafoe" => "Mr Dafoe",
                                                            "Mr De Haviland" => "Mr De Haviland",
                                                            "Mrs Saint Delafield" => "Mrs Saint Delafield",
                                                            "Mrs Sheppards" => "Mrs Sheppards",
                                                            "Muli" => "Muli",
                                                            "Mystery Quest" => "Mystery Quest",
                                                            "Neucha" => "Neucha",
                                                            "Neuton" => "Neuton",
                                                            "News Cycle" => "News Cycle",
                                                            "Niconne" => "Niconne",
                                                            "Nixie One" => "Nixie One",
                                                            "Nobile" => "Nobile",
                                                            "Nokora" => "Nokora",
                                                            "Norican" => "Norican",
                                                            "Nosifer" => "Nosifer",
                                                            "Nothing You Could Do" => "Nothing You Could Do",
                                                            "Noticia Text" => "Noticia Text",
                                                            "Nova Cut" => "Nova Cut",
                                                            "Nova Flat" => "Nova Flat",
                                                            "Nova Mono" => "Nova Mono",
                                                            "Nova Oval" => "Nova Oval",
                                                            "Nova Round" => "Nova Round",
                                                            "Nova Script" => "Nova Script",
                                                            "Nova Slim" => "Nova Slim",
                                                            "Nova Square" => "Nova Square",
                                                            "Numans" => "Numans",
                                                            "Nunito" => "Nunito",
                                                            "Odor Mean Chey" => "Odor Mean Chey",
                                                            "Old Standard TT" => "Old Standard TT",
                                                            "Oldenburg" => "Oldenburg",
                                                            "Oleo Script" => "Oleo Script",
                                                            "Open Sans" => "Open Sans",
                                                            "Open Sans Condensed" => "Open Sans Condensed",
                                                            "Orbitron" => "Orbitron",
                                                            "Original Surfer" => "Original Surfer",
                                                            "Oswald" => "Oswald",
                                                            "Over the Rainbow" => "Over the Rainbow",
                                                            "Overlock" => "Overlock",
                                                            "Overlock SC" => "Overlock SC",
                                                            "Ovo" => "Ovo",
                                                            "Oxygen" => "Oxygen",
                                                            "PT Mono" => "PT Mono",
                                                            "PT Sans" => "PT Sans",
                                                            "PT Sans Caption" => "PT Sans Caption",
                                                            "PT Sans Narrow" => "PT Sans Narrow",
                                                            "PT Serif" => "PT Serif",
                                                            "PT Serif Caption" => "PT Serif Caption",
                                                            "Pacifico" => "Pacifico",
                                                            "Parisienne" => "Parisienne",
                                                            "Passero One" => "Passero One",
                                                            "Passion One" => "Passion One",
                                                            "Patrick Hand" => "Patrick Hand",
                                                            "Patua One" => "Patua One",
                                                            "Paytone One" => "Paytone One",
                                                            "Permanent Marker" => "Permanent Marker",
                                                            "Petrona" => "Petrona",
                                                            "Philosopher" => "Philosopher",
                                                            "Piedra" => "Piedra",
                                                            "Pinyon Script" => "Pinyon Script",
                                                            "Plaster" => "Plaster",
                                                            "Play" => "Play",
                                                            "Playball" => "Playball",
                                                            "Playfair Display" => "Playfair Display",
                                                            "Podkova" => "Podkova",
                                                            "Poiret One" => "Poiret One",
                                                            "Poller One" => "Poller One",
                                                            "Poly" => "Poly",
                                                            "Pompiere" => "Pompiere",
                                                            "Pontano Sans" => "Pontano Sans",
                                                            "Port Lligat Sans" => "Port Lligat Sans",
                                                            "Port Lligat Slab" => "Port Lligat Slab",
                                                            "Prata" => "Prata",
                                                            "Preahvihear" => "Preahvihear",
                                                            "Press Start 2P" => "Press Start 2P",
                                                            "Princess Sofia" => "Princess Sofia",
                                                            "Prociono" => "Prociono",
                                                            "Prosto One" => "Prosto One",
                                                            "Puritan" => "Puritan",
                                                            "Quantico" => "Quantico",
                                                            "Quattrocento" => "Quattrocento",
                                                            "Quattrocento Sans" => "Quattrocento Sans",
                                                            "Questrial" => "Questrial",
                                                            "Quicksand" => "Quicksand",
                                                            "Qwigley" => "Qwigley",
                                                            "Radley" => "Radley",
                                                            "Raleway" => "Raleway",
                                                            "Rammetto One" => "Rammetto One",
                                                            "Rancho" => "Rancho",
                                                            "Rationale" => "Rationale",
                                                            "Redressed" => "Redressed",
                                                            "Reenie Beanie" => "Reenie Beanie",
                                                            "Revalia" => "Revalia",
                                                            "Ribeye" => "Ribeye",
                                                            "Ribeye Marrow" => "Ribeye Marrow",
                                                            "Righteous" => "Righteous",
                                                            "Rochester" => "Rochester",
                                                            "Rock Salt" => "Rock Salt",
                                                            "Rokkitt" => "Rokkitt",
                                                            "Ropa Sans" => "Ropa Sans",
                                                            "Rosario" => "Rosario",
                                                            "Rosarivo" => "Rosarivo",
                                                            "Rouge Script" => "Rouge Script",
                                                            "Ruda" => "Ruda",
                                                            "Ruge Boogie" => "Ruge Boogie",
                                                            "Ruluko" => "Ruluko",
                                                            "Ruslan Display" => "Ruslan Display",
                                                            "Russo One" => "Russo One",
                                                            "Ruthie" => "Ruthie",
                                                            "Sail" => "Sail",
                                                            "Salsa" => "Salsa",
                                                            "Sancreek" => "Sancreek",
                                                            "Sansita One" => "Sansita One",
                                                            "Sarina" => "Sarina",
                                                            "Satisfy" => "Satisfy",
                                                            "Schoolbell" => "Schoolbell",
                                                            "Seaweed Script" => "Seaweed Script",
                                                            "Sevillana" => "Sevillana",
                                                            "Shadows Into Light" => "Shadows Into Light",
                                                            "Shadows Into Light Two" => "Shadows Into Light Two",
                                                            "Shanti" => "Shanti",
                                                            "Share" => "Share",
                                                            "Shojumaru" => "Shojumaru",
                                                            "Short Stack" => "Short Stack",
                                                            "Siemreap" => "Siemreap",
                                                            "Sigmar One" => "Sigmar One",
                                                            "Signika" => "Signika",
                                                            "Signika Negative" => "Signika Negative",
                                                            "Simonetta" => "Simonetta",
                                                            "Sirin Stencil" => "Sirin Stencil",
                                                            "Six Caps" => "Six Caps",
                                                            "Slackey" => "Slackey",
                                                            "Smokum" => "Smokum",
                                                            "Smythe" => "Smythe",
                                                            "Sniglet" => "Sniglet",
                                                            "Snippet" => "Snippet",
                                                            "Sofia" => "Sofia",
                                                            "Sonsie One" => "Sonsie One",
                                                            "Sorts Mill Goudy" => "Sorts Mill Goudy",
                                                            "Special Elite" => "Special Elite",
                                                            "Spicy Rice" => "Spicy Rice",
                                                            "Spinnaker" => "Spinnaker",
                                                            "Spirax" => "Spirax",
                                                            "Squada One" => "Squada One",
                                                            "Stardos Stencil" => "Stardos Stencil",
                                                            "Stint Ultra Condensed" => "Stint Ultra Condensed",
                                                            "Stint Ultra Expanded" => "Stint Ultra Expanded",
                                                            "Stoke" => "Stoke",
                                                            "Sue Ellen Francisco" => "Sue Ellen Francisco",
                                                            "Sunshiney" => "Sunshiney",
                                                            "Supermercado One" => "Supermercado One",
                                                            "Suwannaphum" => "Suwannaphum",
                                                            "Swanky and Moo Moo" => "Swanky and Moo Moo",
                                                            "Syncopate" => "Syncopate",
                                                            "Tangerine" => "Tangerine",
                                                            "Taprom" => "Taprom",
                                                            "Telex" => "Telex",
                                                            "Tenor Sans" => "Tenor Sans",
                                                            "The Girl Next Door" => "The Girl Next Door",
                                                            "Tienne" => "Tienne",
                                                            "Tinos" => "Tinos",
                                                            "Titan One" => "Titan One",
                                                            "Trade Winds" => "Trade Winds",
                                                            "Trocchi" => "Trocchi",
                                                            "Trochut" => "Trochut",
                                                            "Trykker" => "Trykker",
                                                            "Tulpen One" => "Tulpen One",
                                                            "Ubuntu" => "Ubuntu",
                                                            "Ubuntu Condensed" => "Ubuntu Condensed",
                                                            "Ubuntu Mono" => "Ubuntu Mono",
                                                            "Ultra" => "Ultra",
                                                            "Uncial Antiqua" => "Uncial Antiqua",
                                                            "UnifrakturCook" => "UnifrakturCook",
                                                            "UnifrakturMaguntia" => "UnifrakturMaguntia",
                                                            "Unkempt" => "Unkempt",
                                                            "Unlock" => "Unlock",
                                                            "Unna" => "Unna",
                                                            "VT323" => "VT323",
                                                            "Varela" => "Varela",
                                                            "Varela Round" => "Varela Round",
                                                            "Vast Shadow" => "Vast Shadow",
                                                            "Vibur" => "Vibur",
                                                            "Vidaloka" => "Vidaloka",
                                                            "Viga" => "Viga",
                                                            "Voces" => "Voces",
                                                            "Volkhov" => "Volkhov",
                                                            "Vollkorn" => "Vollkorn",
                                                            "Voltaire" => "Voltaire",
                                                            "Waiting for the Sunrise" => "Waiting for the Sunrise",
                                                            "Wallpoet" => "Wallpoet",
                                                            "Walter Turncoat" => "Walter Turncoat",
                                                            "Wellfleet" => "Wellfleet",
                                                            "Wire One" => "Wire One",
                                                            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
                                                            "Yellowtail" => "Yellowtail",
                                                            "Yeseva One" => "Yeseva One",
                                                            "Yesteryear" => "Yesteryear",
                                                            "Zeyada" => "Zeyada",
                                                    );

    $font_select='';
    foreach($google_fonts_array as $key=>$value){
        $font_select.='<option value="'.$key.'">'.$value.'</option>';
    }
    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );

    $header_array   =   array(
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    $header_select   = wpestate_dropdowns_theme_admin_with_key($header_array,'header_type');

    $header_array_logo  =   array(
                            'type1',
                            'type2',
                            'type3'
                        );
    $logo_header_select   = wpestate_dropdowns_theme_admin($header_array_logo,'logo_header_type');

    
    $cache_array                =   array('no','yes');
    $header_transparent_select  =   wpestate_dropdowns_theme_admin($cache_array,'header_transparent');
    $footer_background          =   get_option('wp_estate_footer_background','');
    
    $repeat_array=array('repeat','repeat x','repeat y','no repeat');
    $repeat_footer_back_symbol  = wpestate_dropdowns_theme_admin($repeat_array,'repeat_footer_back');

    $global_revolution_slider   =   get_option('wp_estate_global_revolution_slider','');
    $global_header              =   get_option('wp_estate_global_header','');
    
     
    $prop_list_array=array(
               "1"  =>  __("standard ","wpestate"),
               "2"  =>  __("half map","wpestate")
            );
    $property_list_type_symbol   = wpestate_dropdowns_theme_admin_with_key($prop_list_array,'property_list_type');
    $property_list_type_symbol_adv   = wpestate_dropdowns_theme_admin_with_key($prop_list_array,'property_list_type_adv');

    $prop_list_slider = array( 
                "0"  =>  __("no ","wpestate"),
                "1"  =>  __("yes","wpestate")
                );
    $prop_unit_slider_symbol = wpestate_dropdowns_theme_admin_with_key($prop_list_slider,'prop_list_slider');
    
    

    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Appearance','wpestate').'</h1>';
    print '<a href="http://help.wpresidence.net/#!/app" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
   
    print '<table class="form-table">     
         
        <tr valign="top">
            <th scope="row"><label for="wide_status">'.__('Wide or Boxed?','wpestate').' </label></th>
               <td> <select id="wide_status" name="wide_status">
                    '.$wide_status_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_top_bar_user_menu">'.__('Show top bar widget menu ?','wpestate').' </label></th>
               <td> <select id="show_top_bar_user_menu" name="show_top_bar_user_menu">
                    '.$show_top_bar_user_menu_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_top_bar_user_login">'.__('Show user login menu in header ?','wpestate').' </label></th>
               <td> <select id="show_top_bar_user_login" name="show_top_bar_user_login">
                    '.$show_top_bar_user_login_symbol.'
		 </select>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="header_transparent">'.__('Global transparent header?','wpestate').' </label></th>
               <td> <select id="header_transparent" name="header_transparent">
                    '.$header_transparent_select.'
		 </select>
            </td>
        </tr>
        
    <tr valign="top">
            <th scope="row"><label for="logo_header_type">'.__('Header Type?','wpestate').' </label></th>
               <td> <select id="logo_header_type" name="logo_header_type">
                    '.$logo_header_select.'
		 </select>
            </td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="header_type">'.__('Media Header Type?','wpestate').' </label></th>
               <td> <select id="header_type" name="header_type">
                    '.$header_select.'
		 </select>
            </td>
        </tr>
        
    <tr valign="top">
            <th scope="row"><label for="logo_margin">'.__('Margin Top for logo','wpestate').' </label></th>
            <td> 
                <input type="text" id="logo_margin" name="logo_margin" value="'.$logo_margin.'">   
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="global_revolution_slider">'.__('Global Revolution Slider','wpestate').' </label></th>
             <td> 	
               <input type="text" id="global_revolution_slider" name="global_revolution_slider" value="'.$global_revolution_slider.'">   
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="global_header">'.__('Global Header Static Image','wpestate').' </label></th>
             <td> 	
                <input id="global_header" type="text" size="36" name="global_header" value="'.$global_header.'" />
		<input id="global_header_button" type="button"  class="upload_button button" value="'.__('Upload Header Image','wpestate').'" />
            </td>
        </tr>

      <tr valign="top">
            <th scope="row"><label for="footer_background">'.__('Background for Footer','wpestate').' </label></th>
             <td> 	
                <input id="footer_background" type="text" size="36" name="footer_background" value="'.$footer_background.'" />
		<input id="footer_background_button" type="button"  class="upload_button button" value="'.__('Upload Background Image for Footer','wpestate').'" />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="repeat_footer_back">'.__('Repeat Footer background ?','wpestate').' </label></th>
               <td> <select id="repeat_footer_back" name="repeat_footer_back">
                    '.$repeat_footer_back_symbol.'
		 </select>
            </td>
        </tr>


        <tr valign="top">
            <th scope="row"><label for="prop_no">'.__('Properties List - Properties number per page','wpestate').'</label></th>
            <td>
                <input type="text" id="prop_no" name="prop_no" value="'.$prop_no.'">   
            </td>
        </tr> 
      
      
        <tr valign="top">
         
            <th scope="row"><label for="prop_list_slider">'.__('Use Slider in Property Unit','wpestate').'</label></th>
            <td>
                <select id="prop_list_slider" name="prop_list_slider">
                    '.$prop_unit_slider_symbol.'
                </select>  
            </td>
        </tr> 
      
      
        
        <tr valign="top">
            <th scope="row"><label for="show_empty_city">'.__('Show Cities and Areas with 0 properties in advanced search?','wpestate').' </label></th>
               <td> <select id="show_empty_city" name="show_empty_city">
                    '.$show_empty_city_status_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="agent_sidebar">'.__('Agent Sidebar Position','wpestate').'</label></th>
            <td><select id="agent_sidebar" name="agent_sidebar">
                    '.$agent_sidebar_pos_select.'
                </select>
            </td>
        </tr> 
        <tr valign="top">
            <th scope="row"><label for="agent_sidebar_name">'.__('Agent page Sidebar','wpestate').'</label></th>
            <td><select id="agent_sidebar_name" name="agent_sidebar_name">
                    '.$agent_sidebar_name_select.'
                 </select></td>
         </tr>
         



        <tr valign="top">
            <th scope="row"><label for="blog_sidebar">'.__('Property Submission Post, Blog Category/Archive Sidebar Position','wpestate').'</label></th>
            <td><select id="blog_sidebar" name="blog_sidebar">
                    '.$blog_sidebar_select.'
                </select>
            </td>
        </tr> 
              
        <tr valign="top">
            <th scope="row"><label for="blog_sidebar_name">'.__('Property Submission Post, Blog Category/Archive Sidebar','wpestate').'</label></th>
            <td><select id="blog_sidebar_name" name="blog_sidebar_name">
                    '.$blog_sidebar_name_select.'
                 </select></td>
         </tr>
        
         <tr valign="top">
            <th scope="row"><label for="blog_unit">'.__('Blog Category/Archive List type','wpestate').'</label></th>
            <td><select id="blog_unit" name="blog_unit">
                    '.$blog_unit_select.'
                 </select></td>
         </tr>
         

        <tr valign="top">
            <th scope="row"><label for="property_list_type">'.__('Property List Type for Taxonomy pages','wpestate').'</label></th>
            <td><select id="property_list_type" name="property_list_type">
                    '.$property_list_type_symbol.'
                 </select></td>
         </tr>
         

        <tr valign="top">
            <th scope="row"><label for="property_list_type_adv">'.__('Property List Type for Advanced Search','wpestate').'</label></th>
            <td><select id="property_list_type_adv" name="property_list_type_adv">
                    '.$property_list_type_symbol_adv.'
                 </select></td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="prop_unit">'.__('Property List display(*global option)','wpestate').'</label></th>
            <td><select id="prop_unit" name="prop_unit">
                    '.$prop_unit_select_view.'
                 </select></td>
         </tr>
        
        
        <tr valign="top">
            <th scope="row"><label for="general_font">'.__('Main Font','wpestate').'</label></th>
            <td><select id="general_font" name="general_font">
                    '.$general_font_select.'
                    <option value="">- original font -</option>
                    '.$font_select.'                   
		</select>   </td>
         </tr> 
        <tr valign="top">
            <th scope="row"><label for="headings_font_subset">'.__('Second Font subset','wpestate').'</label></th>
            <td>
                <input type="text" id="headings_font_subset" name="headings_font_subset" value="'.$headings_font_subset.'">    
            </td>
         </tr> 
       
       
         
         
         <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Copyright Message','wpestate').'</label></th>
            <td><textarea cols="57" rows="2" id="copyright_message" name="copyright_message">'.$copyright_message.'</textarea></td>
        </tr>
        
         
        
      
        
         <tr valign="top">
            <th scope="row"><label for="zillow_api_key">'.__('Zillow Api Key','wpestate').'</label></th>
            <td>  <input id="zillow_api_key" type="text" size="36" name="zillow_api_key" value="'.$zillow_api_key.'" /></td>
        </tr>
        
        
        
       
        
      
        
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
    </p>';
    print '</div>';
}
endif; // end   wpestate_theme_admin_apperance  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Design
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_design') ):

function wpestate_theme_admin_design(){ 
    $main_color                     =  esc_html ( get_option('wp_estate_main_color','') );
    $background_color               =  esc_html ( get_option('wp_estate_background_color','') );
    $content_back_color             =  esc_html ( get_option('wp_estate_content_back_color','') );
    $header_color                   =  esc_html ( get_option('wp_estate_header_color','') );
    $menu_items_color               =  esc_html ( get_option('wp_estate_menu_items_color','') );
    $breadcrumbs_font_color         =  esc_html ( get_option('wp_estate_breadcrumbs_font_color','') );
    $font_color                     =  esc_html ( get_option('wp_estate_font_color','') );
    $link_color                     =  esc_html ( get_option('wp_estate_link_color','') );
    $headings_color                 =  esc_html ( get_option('wp_estate_headings_color','') );
  
    $footer_back_color              =  esc_html ( get_option('wp_estate_footer_back_color','') );
    $footer_font_color              =  esc_html ( get_option('wp_estate_footer_font_color','') );
    $footer_copy_color              =  esc_html ( get_option('wp_estate_footer_copy_color','') );
    $sidebar_widget_color           =  esc_html ( get_option('wp_estate_sidebar_widget_color','') );
    $sidebar_heading_color          =  esc_html ( get_option('wp_estate_sidebar_heading_color','') );
    $sidebar_heading_boxed_color    =  esc_html ( get_option('wp_estate_sidebar_heading_boxed_color','') );
    $menu_font_color                =  esc_html ( get_option('wp_estate_menu_font_color','') );
    $menu_hover_back_color          =  esc_html ( get_option('wp_estate_menu_hover_back_color','') );
    $menu_hover_font_color          =  esc_html ( get_option('wp_estate_menu_hover_font_color','') );
    $agent_color                    =  esc_html ( get_option('wp_estate_agent_color','') );
    $sidebar2_font_color            =  esc_html ( get_option('wp_estate_sidebar2_font_color','') );
    $top_bar_back                   =  esc_html ( get_option('wp_estate_top_bar_back','') );
    $top_bar_font                   =  esc_html ( get_option('wp_estate_top_bar_font','') );
    $adv_search_back_color          =  esc_html ( get_option('wp_estate_adv_search_back_color ','') );
    $adv_search_font_color          =  esc_html ( get_option('wp_estate_adv_search_font_color','') );  
    $box_content_back_color         =  esc_html ( get_option('wp_estate_box_content_back_color','') );
    $box_content_border_color       =  esc_html ( get_option('wp_estate_box_content_border_color','') );
    $hover_button_color             =  esc_html ( get_option('wp_estate_hover_button_color','') );
    
    
    $custom_css                     =  esc_html ( stripslashes( get_option('wp_estate_custom_css','') ) );
    
    $color_scheme_array=array('no','yes');
    $color_scheme_select   = wpestate_dropdowns_theme_admin($color_scheme_array,'color_scheme');
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Design','wpestate').'</h1>';
    print '<a href="http://help.wpresidence.net/#!/design" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '<table class="form-table desgintable">     
         <tr valign="top">
            <th scope="row"><label for="color_scheme">'.__('Use Custom Colors ?','wpestate').'</label></th>
            <td><select id="color_scheme" name="color_scheme">
                   '.$color_scheme_select.'
                </select>   
            </td>
         </tr> 
         
        <tr valign="top">
            <th scope="row"><label for="main_color">'.__('Main Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="main_color" maxlength="7" class="inptxt " value="'.$main_color.'"/>
            	<div id="main_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$main_color.';"  ></div></div>
            </td>
        </tr> 

         <tr valign="top">
            <th scope="row"><label for="background_color">'.__('Background Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="background_color" maxlength="7" class="inptxt " value="'.$background_color.'"/>
            	<div id="background_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$background_color.';"  ></div></div>
            </td>
        </tr> 
   
         
        <tr valign="top">
            <th scope="row"><label for="content_back_color">'.__('Content Background Color','wpestate').'</label></th>
            <td>
                <input type="text" name="content_back_color" value="'.$content_back_color.'" maxlength="7" class="inptxt" />
            	<div id="content_back_color" class="colorpickerHolder" ><div class="sqcolor"  style="background-color:#'.$content_back_color.';" ></div></div>
            </td>
        </tr> 
        
     
        <tr valign="top">
            <th scope="row"><label for="breadcrumbs_font_color">'.__('Breadcrumbs, Meta and Second Line Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="breadcrumbs_font_color" value="'.$breadcrumbs_font_color.'" maxlength="7" class="inptxt" />
            	<div id="breadcrumbs_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$breadcrumbs_font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="font_color">'.__('Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="font_color" value="'.$font_color.'" maxlength="7" class="inptxt" />
            	<div id="font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="link_color">'.__('Link Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="link_color" value="'.$link_color.'" maxlength="7" class="inptxt" />
            	<div id="link_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$link_color.';" ></div></div>
            </td>
        </tr> 
        
        
        <tr valign="top">
            <th scope="row"><label for="headings_color">'.__('Headings Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="headings_color" value="'.$headings_color.'" maxlength="7" class="inptxt" />
            	<div id="headings_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$headings_color.';" ></div></div>
            </td>
        </tr>
        
     
        <tr valign="top">
            <th scope="row"><label for="footer_back_color">'.__('Footer Background Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_back_color" value="'.$footer_back_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_back_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="footer_font_color">'.__('Footer Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_font_color" value="'.$footer_font_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_font_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="footer_copy_color">'.__('Footer Copyright Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_copy_color" value="'.$footer_copy_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_copy_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_copy_color.';" ></div></div>
            </td>
        </tr> 
          
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_widget_color">'.__('Sidebar Widget Background Color( for "boxed" widgets)','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_widget_color" value="'.$sidebar_widget_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_widget_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$sidebar_widget_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_heading_boxed_color">'.__('Sidebar Heading Color (boxed widgets)','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_heading_boxed_color" value="'.$sidebar_heading_boxed_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_boxed_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_boxed_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_heading_color">'.__('Sidebar Heading Color ','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_heading_color" value="'.$sidebar_heading_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="sidebar2_font_color">'.__('Sidebar Font color','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar2_font_color" value="'.$sidebar2_font_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar2_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar2_font_color.';"></div></div>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="header_color">'.__('Header Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="header_color" value="'.$header_color.'" maxlength="7" class="inptxt" />
            	<div id="header_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$header_color.';" ></div></div>
            </td>
        </tr> 
            
        <tr valign="top">
            <th scope="row"><label for="menu_items_color">'.__('Menu Item Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_items_color" value="'.$menu_items_color.'"  maxlength="7" class="inptxt" />
            	<div id="menu_items_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_items_color.';" ></div></div>
            </td>
        </tr> 
        

        <tr valign="top">
            <th scope="row"><label for="menu_font_color">'.__('Top Menu Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_font_color" value="'.$menu_font_color.'"  maxlength="7" class="inptxt" />
            	<div id="menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="menu_hover_back_color">'.__('Top Menu hover back color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_hover_back_color" value="'.$menu_hover_back_color.'"  maxlength="7" class="inptxt" />
           	<div id="menu_hover_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_back_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="menu_hover_font_color">'.__('Top Menu hover font color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_hover_font_color" value="'.$menu_hover_font_color.'" maxlength="7" class="inptxt" />
            	<div id="menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_font_color.';" ></div></div>
            </td>
        </tr> 
 
        <tr valign="top">
            <th scope="row"><label for="top_bar_back">'.__('Top Bar Background Color (Header Widget Menu)','wpestate').'</label></th>
            <td>
	         <input type="text" name="top_bar_back" value="'.$top_bar_back.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_back" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_back.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="top_bar_font">'.__('Top Bar Font Color (Header Widget Menu)','wpestate').'</label></th>
            <td>
	         <input type="text" name="top_bar_font" value="'.$top_bar_font.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_font" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_font.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="adv_search_back_color">'.__('Map Advanced Search Button Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="adv_search_back_color" value="'.$adv_search_back_color.'" maxlength="7" class="inptxt" />
            	<div id="adv_search_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_back_color.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="adv_search_font_color">'.__('Advanced Search Font Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="adv_search_font_color" value="'.$adv_search_font_color.'" maxlength="7" class="inptxt" />
            	<div id="adv_search_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_font_color.';"></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="box_content_back_color">'.__('Boxed Content Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="box_content_back_color" value="'.$box_content_back_color.'" maxlength="7" class="inptxt" />
            	<div id="box_content_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_back_color.';"></div></div>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="box_content_border_color">'.__('Border Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="box_content_border_color" value="'.$box_content_border_color.'" maxlength="7" class="inptxt" />
            	<div id="box_content_border_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_border_color.';"></div></div>
            </td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="hover_button_color">'.__('Hover Button Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="hover_button_color" value="'.$hover_button_color.'" maxlength="7" class="inptxt" />
            	<div id="hover_button_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$hover_button_color.';"></div></div>
            </td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="custom_css">'.__('Custom Css','wpestate').'</label></th>
            <td><textarea cols="57" rows="5" name="custom_css" id="custom_css">'.$custom_css.'</textarea></td>
        </tr>
        
 </table>    
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>';
    print '</div>';
}
endif; // end   wpestate_theme_admin_design  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  help and custom
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_help') ):
function wpestate_theme_admin_help(){
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Help','wpestate').'</h1>';
    print '<table class="form-table">  
 
        <tr valign="top">
            <td> '.__('For theme help please check http://help.wpresidence.net/. If your question is not here, please go to http://support.wpestate.org, create an account and post a ticket. The registration is simple and as soon as you send a ticket we are notified. We usually answer in the next 24h (except weekends). Please use this system and not the email. It will help us answer your questions much faster. Thank you!','wpestate').'
            </td>             
        </tr>
        
        <tr valign="top">
            <td> '.__('For custom work on this theme please go to  <a href="http://support.wpestate.org/" target="_blank">http://support.wpestate.org</a>, create a ticket with your request and we will offer a free quote.','wpestate').'
            </td>             
        </tr>
        
        <tr valign="top">
            <td> '.__('For help files please go to  <a href="http://help.wpresidence.net/">http://help.wpresidence.net</a>.','wpestate').'
            </td>             
        </tr>
        
         
        <tr valign="top">
            <td>  '.__('Subscribe to our mailing list in order to receive news about new features and theme upgrades. <a href="http://eepurl.com/CP5U5">Subscribe Here!</a>','wpestate').'
            </td>             
        </tr>
        </table>
        
      ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_help  



if( !function_exists('wpestate_general_country_list') ):
    function wpestate_general_country_list($selected){
        $countries = array(__("Afghanistan","wpestate"),__("Albania","wpestate"),__("Algeria","wpestate"),__("American Samoa","wpestate"),__("Andorra","wpestate"),__("Angola","wpestate"),__("Anguilla","wpestate"),__("Antarctica","wpestate"),__("Antigua and Barbuda","wpestate"),__("Argentina","wpestate"),__("Armenia","wpestate"),__("Aruba","wpestate"),__("Australia","wpestate"),__("Austria","wpestate"),__("Azerbaijan","wpestate"),__("Bahamas","wpestate"),__("Bahrain","wpestate"),__("Bangladesh","wpestate"),__("Barbados","wpestate"),__("Belarus","wpestate"),__("Belgium","wpestate"),__("Belize","wpestate"),__("Benin","wpestate"),__("Bermuda","wpestate"),__("Bhutan","wpestate"),__("Bolivia","wpestate"),__("Bosnia and Herzegowina","wpestate"),__("Botswana","wpestate"),__("Bouvet Island","wpestate"),__("Brazil","wpestate"),__("British Indian Ocean Territory","wpestate"),__("Brunei Darussalam","wpestate"),__("Bulgaria","wpestate"),__("Burkina Faso","wpestate"),__("Burundi","wpestate"),__("Cambodia","wpestate"),__("Cameroon","wpestate"),__("Canada","wpestate"),__("Cape Verde","wpestate"),__("Cayman Islands","wpestate"),__("Central African Republic","wpestate"),__("Chad","wpestate"),__("Chile","wpestate"),__("China","wpestate"),__("Christmas Island","wpestate"),__("Cocos (Keeling) Islands","wpestate"),__("Colombia","wpestate"),__("Comoros","wpestate"),__("Congo","wpestate"),__("Congo, the Democratic Republic of the","wpestate"),__("Cook Islands","wpestate"),__("Costa Rica","wpestate"),__("Cote d'Ivoire","wpestate"),__("Croatia (Hrvatska)","wpestate"),__("Cuba","wpestate"),__("Cyprus","wpestate"),__("Czech Republic","wpestate"),__("Denmark","wpestate"),__("Djibouti","wpestate"),__("Dominica","wpestate"),__("Dominican Republic","wpestate"),__("East Timor","wpestate"),__("Ecuador","wpestate"),__("Egypt","wpestate"),__("El Salvador","wpestate"),__("Equatorial Guinea","wpestate"),__("Eritrea","wpestate"),__("Estonia","wpestate"),__("Ethiopia","wpestate"),__("Falkland Islands (Malvinas)","wpestate"),__("Faroe Islands","wpestate"),__("Fiji","wpestate"),__("Finland","wpestate"),__("France","wpestate"),__("France Metropolitan","wpestate"),__("French Guiana","wpestate"),__("French Polynesia","wpestate"),__("French Southern Territories","wpestate"),__("Gabon","wpestate"),__("Gambia","wpestate"),__("Georgia","wpestate"),__("Germany","wpestate"),__("Ghana","wpestate"),__("Gibraltar","wpestate"),__("Greece","wpestate"),__("Greenland","wpestate"),__("Grenada","wpestate"),__("Guadeloupe","wpestate"),__("Guam","wpestate"),__("Guatemala","wpestate"),__("Guinea","wpestate"),__("Guinea-Bissau","wpestate"),__("Guyana","wpestate"),__("Haiti","wpestate"),__("Heard and Mc Donald Islands","wpestate"),__("Holy See (Vatican City State)","wpestate"),__("Honduras","wpestate"),__("Hong Kong","wpestate"),__("Hungary","wpestate"),__("Iceland","wpestate"),__("India","wpestate"),__("Indonesia","wpestate"),__("Iran (Islamic Republic of)","wpestate"),__("Iraq","wpestate"),__("Ireland","wpestate"),__("Israel","wpestate"),__("Italy","wpestate"),__("Jamaica","wpestate"),__("Japan","wpestate"),__("Jordan","wpestate"),__("Kazakhstan","wpestate"),__("Kenya","wpestate"),__("Kiribati","wpestate"),__("Korea, Democratic People's Republic of","wpestate"),__("Korea, Republic of","wpestate"),__("Kuwait","wpestate"),__("Kyrgyzstan","wpestate"),__("Lao, People's Democratic Republic","wpestate"),__("Latvia","wpestate"),__("Lebanon","wpestate"),__("Lesotho","wpestate"),__("Liberia","wpestate"),__("Libyan Arab Jamahiriya","wpestate"),__("Liechtenstein","wpestate"),__("Lithuania","wpestate"),__("Luxembourg","wpestate"),__("Macau","wpestate"),__("Macedonia (FYROM)","wpestate"),__("Madagascar","wpestate"),__("Malawi","wpestate"),__("Malaysia","wpestate"),__("Maldives","wpestate"),__("Mali","wpestate"),__("Malta","wpestate"),__("Marshall Islands","wpestate"),__("Martinique","wpestate"),__("Mauritania","wpestate"),__("Mauritius","wpestate"),__("Mayotte","wpestate"),__("Mexico","wpestate"),__("Micronesia, Federated States of","wpestate"),__("Moldova, Republic of","wpestate"),__("Monaco","wpestate"),__("Mongolia","wpestate"),__("Montserrat","wpestate"),__("Morocco","wpestate"),__("Mozambique","wpestate"),__("Montenegro","wpestate"),__("Myanmar","wpestate"),__("Namibia","wpestate"),__("Nauru","wpestate"),__("Nepal","wpestate"),__("Netherlands","wpestate"),__("Netherlands Antilles","wpestate"),__("New Caledonia","wpestate"),__("New Zealand","wpestate"),__("Nicaragua","wpestate"),__("Niger","wpestate"),__("Nigeria","wpestate"),__("Niue","wpestate"),__("Norfolk Island","wpestate"),__("Northern Mariana Islands","wpestate"),__("Norway","wpestate"),__("Oman","wpestate"),__("Pakistan","wpestate"),__("Palau","wpestate"),__("Panama","wpestate"),__("Papua New Guinea","wpestate"),__("Paraguay","wpestate"),__("Peru","wpestate"),__("Philippines","wpestate"),__("Pitcairn","wpestate"),__("Poland","wpestate"),__("Portugal","wpestate"),__("Puerto Rico","wpestate"),__("Qatar","wpestate"),__("Reunion","wpestate"),__("Romania","wpestate"),__("Russian Federation","wpestate"),__("Rwanda","wpestate"),__("Saint Kitts and Nevis","wpestate"),__("Saint Lucia","wpestate"),__("Saint Vincent and the Grenadines","wpestate"),__("Samoa","wpestate"),__("San Marino","wpestate"),__("Sao Tome and Principe","wpestate"),__("Saudi Arabia","wpestate"),__("Senegal","wpestate"),__("Seychelles","wpestate"),__("Serbia","wpestate"),__("Sierra Leone","wpestate"),__("Singapore","wpestate"),__("Slovakia (Slovak Republic)","wpestate"),__("Slovenia","wpestate"),__("Solomon Islands","wpestate"),__("Somalia","wpestate"),__("South Africa","wpestate"),__("South Georgia and the South Sandwich Islands","wpestate"),__("Spain","wpestate"),__("Sri Lanka","wpestate"),__("St. Helena","wpestate"),__("St. Pierre and Miquelon","wpestate"),__("Sudan","wpestate"),__("Suriname","wpestate"),__("Svalbard and Jan Mayen Islands","wpestate"),__("Swaziland","wpestate"),__("Sweden","wpestate"),__("Switzerland","wpestate"),__("Syrian Arab Republic","wpestate"),__("Taiwan, Province of China","wpestate"),__("Tajikistan","wpestate"),__("Tanzania, United Republic of","wpestate"),__("Thailand","wpestate"),__("Togo","wpestate"),__("Tokelau","wpestate"),__("Tonga","wpestate"),__("Trinidad and Tobago","wpestate"),__("Tunisia","wpestate"),__("Turkey","wpestate"),__("Turkmenistan","wpestate"),__("Turks and Caicos Islands","wpestate"),__("Tuvalu","wpestate"),__("Uganda","wpestate"),__("Ukraine","wpestate"),__("United Arab Emirates","wpestate"),__("United Kingdom","wpestate"),__("United States","wpestate"),__("United States Minor Outlying Islands","wpestate"),__("Uruguay","wpestate"),__("Uzbekistan","wpestate"),__("Vanuatu","wpestate"),__("Venezuela","wpestate"),__("Vietnam","wpestate"),__("Virgin Islands (British)","wpestate"),__("Virgin Islands (U.S.)","wpestate"),__("Wallis and Futuna Islands","wpestate"),__("Western Sahara","wpestate"),__("Yemen","wpestate"),__("Zambia","wpestate"),__("Zimbabwe","wpestate"));
        $country_select='<select id="general_country" style="width: 200px;" name="general_country">';

        foreach($countries as $country){
            $country_select.='<option value="'.$country.'"';  
            if($selected==$country){
                $country_select.='selected="selected"';
            }
            $country_select.='>'.$country.'</option>';
        }

        $country_select.='</select>';
        return $country_select;
    }
endif; // end   wpestate_general_country_list  


function wpestate_sorting_function($a, $b) {
    return $a[3] - $b[3];
};

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Wpestate Price settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_price_set') ):
function wpestate_price_set(){
    $custom_fields = get_option( 'wp_estate_multi_curr', true);     
    $current_fields='';
    
    $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
    
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol          =   wpestate_dropdowns_theme_admin($where_currency_symbol_array,'where_currency_symbol');
   
    $enable_auto_symbol_array       =   array('yes','no');
    $enable_auto_symbol             =   wpestate_dropdowns_theme_admin($enable_auto_symbol_array,'auto_curency');
    
    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $current_fields.='
                <div class=field_row>
                <div    class="field_item"><strong>'.__('Currency Symbol','wpestate').'</strong></br><input   type="text" name="add_curr_name[]"   value="'.$custom_fields[$i][0].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Label','wpestate').'</strong></br><input  type="text" name="add_curr_label[]"   value="'.$custom_fields[$i][1].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Value','wpestate').'</strong></br><input  type="text" name="add_curr_value[]"   value="'.$custom_fields[$i][2].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Position','wpestate').'</strong></br><input  type="text" name="add_curr_order[]"   value="'.$custom_fields[$i][3].'"  ></div>
                
                <a class="deletefieldlink" href="#">'.__('delete','wpestate').'</a>
            </div>';    
            $i++;
        }
    }
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Price and Currency','wpestate').'</h1>';

    print '<table class="form-table">';
    
    print '<tr valign="top">
            <th scope="row"><label for="prices_th_separator">'.__('Price - thousands separator','wpestate').'</label></th>
            <td>
                <input type="text" name="prices_th_separator" id="prices_th_separator" value="'.  stripslashes ( get_option('wp_estate_prices_th_separator','') ).'"> 
            </td>
        </tr>   
        

        <tr valign="top">
            <th scope="row"><label for="">'.__('Currency symbol','wpestate').'</label></th>
            <td><input  type="text" id="currency_symbol" name="currency_symbol"  value="'.$currency_symbol.'"/> </td>
        </tr>

        <tr valign="top">
            <th scope="row">'.__('Currency label - will appear on front end','wpestate').'</th>
            <td>
            <input  type="text" id="currency_label_main"  name="currency_label_main"   value="'. get_option('wp_estate_currency_label_main','').'" size="40"/>
            </td>
        </tr>
                    

        <tr valign="top">
            <th scope="row"><label for="">'.__('Where to show the currency symbol?','wpestate').'</label></th>
            <td>
                <select id="where_currency_symbol" name="where_currency_symbol">
                    '.$where_currency_symbol.'
                </select> 
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="">'.__('Enable auto loading of exchange rates from Yahoo(1 time per day)?','wpestate').'</label></th>
            <td>
                <select id="auto_curency" name="auto_curency">
                    '.$enable_auto_symbol.'
                </select> 
            </td>
        </tr>
    </table> ';
    
    
    
 
     print' <form method="post" action="">
        <h3 style="margin-left:10px;width:100%;float:left;">'.__('Add Currencies for Multi Currency features','wpestate').'</h3>
     
        <div id="custom_fields">
             '.$current_fields.'
            <input type="hidden" name="is_custom_cur" value="1">   
        </div>

       <table class="form-table">
            <tbody>
                <tr valign="top">
                    <tr valign="top">
                        <th scope="row">'.__('Currency','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_name"  name="currency_name"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Currency label - will appear on front end','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_label"  name="currency_label"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Currency Value compared with the based currency','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_value"  name="currency_value"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Show currency before or after price - in front pages','wpestate').'</th>
                        <td>
                             <select id="where_cur" name="where_cur"  style="width:236px;">
                                <option value="before"> before </option>
                                <option value="after">  after </option>
                            </select>
                        </td>
                    </tr>
            </tbody>
        </table>   
        
       <a href="#" id="add_curency">'.__(' click to add currency','wpestate').'</a><br>
    </form> ';
    print '
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>';
}
endif;




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_property_page_settings') ):
function wpestate_property_page_settings(){
    $sidebar_agent                  =   array('yes','no');
    $slider_type                    =   array('vertical','horizontal');
    $social_array                   =   array('no','yes');
    $content_type                   =   array('accordion','tabs');
   
    $enable_global_property_page_agent_sidebar_symbol           =   wpestate_dropdowns_theme_admin($sidebar_agent,'global_property_page_agent_sidebar');
    $global_prpg_slider_type_symbol                             =   wpestate_dropdowns_theme_admin($slider_type,'global_prpg_slider_type');
    $global_prpg_content_type_symbol                            =   wpestate_dropdowns_theme_admin($content_type,'global_prpg_content_type');
    $walkscore_api                                              =   esc_html ( get_option('wp_estate_walkscore_api','') );
    $show_graph_prop_page                                       =   wpestate_dropdowns_theme_admin($social_array,'show_graph_prop_page');
  
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Property Page Appearance','wpestate').'</h1>';  
   
    print '<table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="logo_image">'.__('Add Agent on Sidebar','wpestate').'</label></th>
            <td>
                <select id="global_property_page_agent_sidebar" name="global_property_page_agent_sidebar">
                    '.$enable_global_property_page_agent_sidebar_symbol.'
                </select> 
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="global_prpg_slider_type">'.__('Slider Type','wpestate').'</label></th>
            <td>
                <select id="global_prpg_slider_type" name="global_prpg_slider_type">
                    '.$global_prpg_slider_type_symbol.'
                </select> 
            </td>
        </tr> 
        

        <tr valign="top">
            <th scope="row"><label for="global_prpg_content_type">'.__('Show Content as ','wpestate').'</label></th>
            <td>
                <select id="global_prpg_content_type" name="global_prpg_content_type">
                    '.$global_prpg_content_type_symbol.'
                </select> 
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="walkscore_api">'.__('Walkscore APi Key','wpestate').'</label></th>
            <td>
                <input type="text" name="walkscore_api" id="walkscore_api" value="'.$walkscore_api.'"> 
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="show_graph_prop_page">'.__('Show Graph on Property Page','wpestate').'</label></th>
            <td>
                <select id="show_graph_prop_page" name="show_graph_prop_page">
                    '.$show_graph_prop_page.'
                </select> 
            </td>
        </tr> 

        </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>    
    ';
    
 print '</div>';   
}
endif; // end   wpestate_theme_admin_general_settings  




if( !function_exists('new_wpestate_theme_admin_general_settings') ):
function new_wpestate_theme_admin_general_settings(){
    
    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    
    $general_country                =   esc_html( get_option('wp_estate_general_country') );
    $measure_sys='';
    $measure_array=array( __('feet','wpestate')     =>__('ft','wpestate'),
                          __('meters','wpestate')   =>__('m','wpestate') 
                        );
    
    $measure_array_status= esc_html( get_option('wp_estate_measure_sys','') );

    foreach($measure_array as $key => $value){
            $measure_sys.='<option value="'.$value.'"';
            if ($measure_array_status==$value){
                $measure_sys.=' selected="selected" ';
            }
            $measure_sys.='>'.__('square','wpestate').' '.$key.' - '.$value.'<sup>2</sup></option>';
    }

    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Country','wpestate').'</div>
        <div class="option_row_explain">'.__('Pick the country','wpestate').'</div>    
        '.wpestate_general_country_list($general_country).'
    </div>';
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Measurement Unit','wpestate').'</div>
        <div class="option_row_explain">'.__('Select the measurement unit you will use on the website','wpestate').'</div>    
            <select id="measure_sys" name="measure_sys">
                '.$measure_sys.'
            </select>
    </div>';
    
    
    $enable_autocomplete_symbol = wpestate_dropdowns_theme_admin($cache_array,'enable_autocomplete');
      
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Enable Autocomplete in Front End Submission Form','wpestate').'</div>
        <div class="option_row_explain">'.__('If yes a the address filed in front end submission form will have the Google Places autocomplete','wpestate').'</div>    
            <select id="enable_autocomplete" name="enable_autocomplete">
                '.$enable_autocomplete_symbol.'
            </select>
    </div>';
    
    
    $enable_user_pass_symbol    = wpestate_dropdowns_theme_admin($cache_array,'enable_user_pass');

    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Users can type the password on registration form','wpestate').'</div>
        <div class="option_row_explain">'.__('Users can type the password on registration form','wpestate').'</div>    
            <select id="enable_user_pass" name="enable_user_pass">
                '.$enable_user_pass_symbol.'
            </select>
    </div>';
    
    
    $date_languages=array(  'xx'=> 'default',
                            'af'=>'Afrikaans',
                            'ar'=>'Arabic',
                            'ar-DZ' =>'Algerian',
                            'az'=>'Azerbaijani',
                            'be'=>'Belarusian',
                            'bg'=>'Bulgarian',
                            'bs'=>'Bosnian',
                            'ca'=>'Catalan',
                            'cs'=>'Czech',
                            'cy-GB'=>'Welsh/UK',
                            'da'=>'Danish',
                            'de'=>'German',
                            'el'=>'Greek',
                            'en-AU'=>'English/Australia',
                            'en-GB'=>'English/UK',
                            'en-NZ'=>'English/New Zealand',
                            'eo'=>'Esperanto',
                            'es'=>'Spanish',
                            'et'=>'Estonian',
                            'eu'=>'Karrikas-ek',
                            'fa'=>'Persian',
                            'fi'=>'Finnish',
                            'fo'=>'Faroese',
                            'fr'=>'French',
                            'fr-CA'=>'Canadian-French',
                            'fr-CH'=>'Swiss-French',
                            'gl'=>'Galician',
                            'he'=>'Hebrew',
                            'hi'=>'Hindi',
                            'hr'=>'Croatian',
                            'hu'=>'Hungarian',
                            'hy'=>'Armenian',
                            'id'=>'Indonesian',
                            'ic'=>'Icelandic',
                            'it'=>'Italian',
                            'it-CH'=>'Italian-CH',
                            'ja'=>'Japanese',
                            'ka'=>'Georgian',
                            'kk'=>'Kazakh',
                            'km'=>'Khmer',
                            'ko'=>'Korean',
                            'ky'=>'Kyrgyz',
                            'lb'=>'Luxembourgish',
                            'lt'=>'Lithuanian',
                            'lv'=>'Latvian',
                            'mk'=>'Macedonian',
                            'ml'=>'Malayalam',
                            'ms'=>'Malaysian',
                            'nb'=>'Norwegian',
                            'nl'=>'Dutch',
                            'nl-BE'=>'Dutch-Belgium',
                            'nn'=>'Norwegian-Nynorsk',
                            'no'=>'Norwegian',
                            'pl'=>'Polish',
                            'pt'=>'Portuguese',
                            'pt-BR'=>'Brazilian',
                            'rm'=>'Romansh',
                            'ro'=>'Romanian',
                            'ru'=>'Russian',
                            'sk'=>'Slovak',
                            'sl'=>'Slovenian',
                            'sq'=>'Albanian',
                            'sr'=>'Serbian',
                            'sr-SR'=>'Serbian-i18n',
                            'sv'=>'Swedish',
                            'ta'=>'Tamil',
                            'th'=>'Thai',
                            'tj'=>'Tajiki',
                            'tr'=>'Turkish',
                            'uk'=>'Ukrainian',
                            'vi'=>'Vietnamese',
                            'zh-CN'=>'Chinese',
                            'zh-HK'=>'Chinese-Hong-Kong',
                            'zh-TW'=>'Chinese Taiwan',
        );  

    
    $date_lang_symbol =  wpestate_dropdowns_theme_admin_with_key($date_languages,'date_lang');
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Language for datepicker','wpestate').'</div>
        <div class="option_row_explain">'.__('Language for datepicker','wpestate').'</div>    
           <select id="date_lang" name="date_lang">
                    '.$date_lang_symbol.'
		 </select>
    </div>';
      
    $google_analytics_code          =   esc_html ( get_option('wp_estate_google_analytics_code','') );
  
    
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Google Analytics Tracking id','wpestate').'</div>
        <div class="option_row_explain">'.__('Google Analytics Tracking id (ex UA-41924406-1)','wpestate').'</div>    
        <input  name="google_analytics_code" id="google_analytics_code" value="'.$google_analytics_code.'"></input>
    </div>';
    
    
   
}
endif; // end   wpestate_theme_admin_general_settings  



if( !function_exists('new_wpestate_theme_admin_logos_favicon') ):
function new_wpestate_theme_admin_logos_favicon(){
    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    $logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
    $footer_logo_image              =   esc_html( get_option('wp_estate_footer_logo_image','') );
    $mobile_logo_image              =   esc_html( get_option('wp_estate_mobile_logo_image','') );
    $favicon_image                  =   esc_html( get_option('wp_estate_favicon_image','') );
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Your Favicon','wpestate').'</div>
        <div class="option_row_explain">'.__('Your Favicon ','wpestate').'</div>    
            <input id="favicon_image" type="text" size="36" name="favicon_image" value="'.$favicon_image.'" />
            <input id="favicon_image_button" type="button"  class="upload_button button" value="'.__('Upload Favicon','wpestate').'" />
       
    </div>';   
     
     
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Your Logo','wpestate').'</div>
        <div class="option_row_explain">'.__('If you add images directly into the input fields (without Upload button) please use the full image path. For ex: http://www.wpresidence..... . If you use the "upload"  button use also "Insert into Post" button from the pop up window.','wpestate').'</div>    
            <input id="logo_image" type="text" size="36" name="logo_image" value="'.$logo_image.'" />
            <input id="logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" /></br>
            '.'
       
    </div>';
     
  
        
      
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Retina Logo','wpestate').'</div>
        <div class="option_row_explain">'.__('Retina ready logo (add _2x after the name. For ex logo_2x.jpg) ','wpestate').'</div>    
            <input id="footer_logo_image" type="text" size="36" name="footer_logo_image" value="'.$footer_logo_image.'" />
            <input id="footer_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
       
    </div>';
     
      
    
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Mobile/Tablets Logo','wpestate').'</div>
        <div class="option_row_explain">'.__('Mobile/Tablets Logo ','wpestate').'</div>    
            <input id="mobile_logo_image" type="text" size="36" name="mobile_logo_image" value="'.$mobile_logo_image.'" />
            <input id="mobile_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
       
    </div>';
      
   
       
}
endif;



function   new_wpestate_export_settings(){
    
      
    print'<div class="estate_option_row">
        <div class="label_option_row">'.__('Export Theme Options','wpestate').'</div>
        <div class="option_row_explain">'.__('Export Theme Options ','wpestate').'</div>    
            <textarea  rows="15" style="width:100%;" id="export_theme_options" onclick="this.focus();this.select()" name="export_theme_options">'.wpestate_export_theme_options().'</textarea>
       
    </div>';
   
}



function  new_wpestate_theme_contact_details (){
    
    $company_contact_image      =   esc_html( get_option('wp_estate_company_contact_image','') );
       
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Image for Contact Page','wpestate').'</div>
    <div class="option_row_explain">'.__('Image for contact page ','wpestate').'</div>    
        <input id="company_contact_image" type="text" size="36" name="company_contact_image" value="'.$company_contact_image.'" />
        <input id="company_contact_image_button" type="button"  class="upload_button button" value="'.__('Upload Image','wpestate').'" />
    </div>';
    
    
    $company_name               =   esc_html ( stripslashes(get_option('wp_estate_company_name','') ) );
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Comapny Name','wpestate').'</div>
    <div class="option_row_explain">'.__('company name for contact page','wpestate').'</div>    
        <input id="company_name" type="text" size="36" name="company_name" value="'.$company_name.'" />
    </div>';
             
    $email_adr                  =   esc_html ( get_option('wp_estate_email_adr','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Email','wpestate').'</div>
    <div class="option_row_explain">'.__('company email','wpestate').'</div>    
      <input id="email_adr" type="text" size="36" name="email_adr" value="'.$email_adr.'" />
    </div>';
    
    
    $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );   
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Duplicate Email','wpestate').'</div>
    <div class="option_row_explain">'.__('Send all contact emails to','wpestate').'</div>    
      <input id="duplicate_email_adr" type="text" size="36" name="duplicate_email_adr" value="'.$duplicate_email_adr.'" />
    </div>';
    
    $telephone_no               =   esc_html ( get_option('wp_estate_telephone_no','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Telephone','wpestate').'</div>
    <div class="option_row_explain">'.__('company telehphone','wpestate').'</div>    
    <input id="telephone_no" type="text" size="36" name="telephone_no" value="'.$telephone_no.'" />
    </div>';
     
    $mobile_no                  =   esc_html ( get_option('wp_estate_mobile_no','') );
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Mobile','wpestate').'</div>
    <div class="option_row_explain">'.__('company mobile','wpestate').'</div>    
    <input id="mobile_no" type="text" size="36" name="mobile_no" value="'.$mobile_no.'" />
    </div>';
     
    $fax_ac                     =   esc_html ( get_option('wp_estate_fax_ac','') );
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Fax','wpestate').'</div>
    <div class="option_row_explain">'.__('company fax','wpestate').'</div>    
    <input id="fax_ac" type="text" size="36" name="fax_ac" value="'.$fax_ac.'" />
    </div>';
     
    $skype_ac                   =   esc_html ( get_option('wp_estate_skype_ac','') );
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Skype','wpestate').'</div>
    <div class="option_row_explain">'.__('Company skype','wpestate').'</div>    
    <input id="skype_ac" type="text" size="36" name="skype_ac" value="'.$skype_ac.'" />
    </div>';
    
    $co_address                 =   esc_html ( stripslashes( get_option('wp_estate_co_address','') ) );
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Comapny Adress','wpestate').'</div>
    <div class="option_row_explain">'.__('Adress of the company','wpestate').'</div>    
        <textarea cols="57" rows="2" name="co_address" id="co_address">'.$co_address.'</textarea>
    </div>';
    
     
   
    
}

function new_wpestate_theme_social_accounts(){
    
    
    $facebook_link              =   esc_html ( get_option('wp_estate_facebook_link','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Facebook Link','wpestate').'</div>
    <div class="option_row_explain">'.__('Facebook page link','wpestate').'</div>    
        <input id="facebook_link" type="text" size="36" name="facebook_link" value="'.$facebook_link.'" />
    </div>';
    
      
    $twitter_link               =   esc_html ( get_option('wp_estate_twitter_link','') );
      print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twiter Link','wpestate').'</div>
    <div class="option_row_explain">'.__('Twiter  page link','wpestate').'</div>    
       <input id="twitter_link" type="text" size="36" name="twitter_link" value="'.$twitter_link.'" />
    </div>';
      
      
    $google_link                =   esc_html ( get_option('wp_estate_google_link','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Google+ Link','wpestate').'</div>
    <div class="option_row_explain">'.__('Google+ page link','wpestate').'</div>    
       <input id="google_link" type="text" size="36" name="google_link" value="'.$google_link.'" />
    </div>';
      
    $linkedin_link              =   esc_html ( get_option('wp_estate_linkedin_link','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Linkedin Link','wpestate').'</div>
    <div class="option_row_explain">'.__('Linkedin page link','wpestate').'</div>    
        <input id="linkedin_link" type="text" size="36" name="linkedin_link" value="'.$linkedin_link.'" />
    </div>';
      
    $pinterest_link             =   esc_html ( get_option('wp_estate_pinterest_link','') );  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Pinterest Link','wpestate').'</div>
    <div class="option_row_explain">'.__('Pinterest page link','wpestate').'</div>    
        <input id="pinterest_link" type="text" size="36" name="pinterest_link" value="'.$pinterest_link.'" />
    </div>';
      
    
    $twitter_consumer_key       =   esc_html ( get_option('wp_estate_twitter_consumer_key','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twitter consumer_key','wpestate').'</div>
    <div class="option_row_explain">'.__('Twitter consumer_key','wpestate').'</div>    
        <input id="twitter_consumer_key" type="text" size="36" name="twitter_consumer_key" value="'.$twitter_consumer_key.'" />
    </div>';
      
    $twitter_consumer_secret    =   esc_html ( get_option('wp_estate_twitter_consumer_secret','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twitter Consumer Secret','wpestate').'</div>
    <div class="option_row_explain">'.__('Twitter Consumer Secret','wpestate').'</div>    
        <input id="twitter_consumer_secret" type="text" size="36" name="twitter_consumer_secret" value="'.$twitter_consumer_secret.'" />
    </div>';
      
    $twitter_access_token       =   esc_html ( get_option('wp_estate_twitter_access_token','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twitter Access Token','wpestate').'</div>
    <div class="option_row_explain">'.__('Twitter Access Token','wpestate').'</div>    
        <input id="twitter_account" type="text" size="36" name="twitter_access_token" value="'.$twitter_access_token.'" />
    </div>';
      
    $twitter_access_secret      =   esc_html ( get_option('wp_estate_twitter_access_secret','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twitter Access Secret','wpestate').'</div>
    <div class="option_row_explain">'.__('Twitter Access Secret','wpestate').'</div>    
        <input id="twitter_access_secret" type="text" size="36" name="twitter_access_secret" value="'.$twitter_access_secret.'" />
    </div>';
      
    
    $twitter_cache_time         =   intval   ( get_option('wp_estate_twitter_cache_time','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Twitter Cache Time','wpestate').'</div>
    <div class="option_row_explain">'.__('Twitter Cache Time','wpestate').'</div>    
       <input id="twitter_cache_time" type="text" size="36" name="twitter_cache_time" value="'.$twitter_cache_time.'" />
    </div>';
      
      
    $zillow_api_key             =   esc_html ( get_option('wp_estate_zillow_api_key','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Zillow Api Key','wpestate').'</div>
    <div class="option_row_explain">'.__('Zillow Api Key','wpestate').'</div>    
       <input id="zillow_api_key" type="text" size="36" name="zillow_api_key" value="'.$zillow_api_key.'" />
    </div>';
      
      
    
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Facebook Api key','wpestate').'</div>
    <div class="option_row_explain">'.__('Facebook Api key','wpestate').'</div>    
        <input id="facebook_api" type="text" size="36" name="facebook_api" value="'.$facebook_api.'" />
    </div>';
      
    
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Facebook Secret','wpestate').'</div>
    <div class="option_row_explain">'.__('Facebook Secret','wpestate').'</div>    
        <input id="facebook_secret" type="text" size="36" name="facebook_secret" value="'.$facebook_secret.'" />
    </div>';
      
    
    $google_oauth_api           =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Google Oauth Api','wpestate').'</div>
    <div class="option_row_explain">'.__('Google Oauth Api','wpestate').'</div>    
        <input id="google_oauth_api" type="text" size="36" name="google_oauth_api" value="'.$google_oauth_api.'" />
    </div>';
      
    $google_oauth_client_secret =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Google Oauth Client Secret','wpestate').'</div>
    <div class="option_row_explain">'.__('Google Oauth Client Secret','wpestate').'</div>    
        <input id="google_oauth_client_secret" type="text" size="36" name="google_oauth_client_secret" value="'.$google_oauth_client_secret.'" />
    </div>';
      
    $google_api_key             =   esc_html ( get_option('wp_estate_google_api_key','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Google api key','wpestate').'</div>
    <div class="option_row_explain">'.__('Google api key','wpestate').'</div>    
        <input id="google_api_key" type="text" size="36" name="google_api_key" value="'.$google_api_key.'" />
    </div>';
      
    
    $social_array               =   array('no','yes');
   
    $facebook_login_select      = wpestate_dropdowns_theme_admin($social_array,'facebook_login');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Allow login via Facebook ? ','wpestate').'</div>
    <div class="option_row_explain">'.__('Allow login via Facebook ? ','wpestate').'</div>    
        <select id="facebook_login" name="facebook_login">
            '.$facebook_login_select.'
        </select>
    </div>';
      
      
    $google_login_select        = wpestate_dropdowns_theme_admin($social_array,'google_login');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Allow login via Google ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Allow login via Google ?','wpestate').'</div>    
        <select id="google_login" name="google_login">
            '.$google_login_select.'
        </select>
    </div>';
      
    $yahoo_login_select         = wpestate_dropdowns_theme_admin($social_array,'yahoo_login');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Allow login via Yahoo ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Allow login via Yahoo ?','wpestate').'</div>    
        <select id="yahoo_login" name="yahoo_login">
            '.$yahoo_login_select.'
        </select>
    </div>';
}

function new_wpestate_contact7(){
    
    $contact_form_7_contact     = stripslashes( esc_html( get_option('wp_estate_contact_form_7_contact','') ) );
    $contact_form_7_agent       = stripslashes( esc_html( get_option('wp_estate_contact_form_7_agent','') ) );
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Contact form 7 code for agent','wpestate').'</div>
    <div class="option_row_explain">'.__('Contact form 7 code for agent (ex: [contact-form-7 id="2725" title="contact me"])','wpestate').'</div>    
         <input type="text" size="36" id="contact_form_7_agent" name="contact_form_7_agent" value="'.$contact_form_7_agent.'" />
    </div>';
    
      
  
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Contact form 7 code for contact page','wpestate').'</div>
    <div class="option_row_explain">'.__('Contact form 7 code for contact page template (ex: [contact-form-7 id="2725" title="contact me"])','wpestate').'</div>    
         <input type="text" size="36" id="contact_form_7_contact" name="contact_form_7_contact" value="'.$contact_form_7_contact.'" />
    </div>';
}


function new_wpestate_appeareance(){
    $cache_array                =   array('yes','no');
  
    $wide_array=array(
            "1"  =>  __("wide","wpestate"),
            "2"  =>  __("boxed","wpestate")
         );
    $wide_status_symbol   = wpestate_dropdowns_theme_admin_with_key($wide_array,'wide_status');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Wide or Boxed?','wpestate').'</div>
    <div class="option_row_explain">'.__('Wide or Boxed?','wpestate').'</div>    
        <select id="wide_status" name="wide_status">
            '.$wide_status_symbol.'
        </select>
    </div>';

    $show_top_bar_user_menu_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_menu');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show top bar widget menu ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show top bar widget menu ?','wpestate').'</div>    
       <select id="show_top_bar_user_menu" name="show_top_bar_user_menu">
            '.$show_top_bar_user_menu_symbol.'
        </select>
    </div>';
    
    $show_top_bar_user_login_symbol     = wpestate_dropdowns_theme_admin($cache_array,'show_top_bar_user_login');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show user login menu in header ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show user login menu in header ?','wpestate').'</div>    
        <select id="show_top_bar_user_login" name="show_top_bar_user_login">
            '.$show_top_bar_user_login_symbol.'
        </select>
    </div>';
        
        
    $cache_array                =   array('no','yes');
    $header_transparent_select  =   wpestate_dropdowns_theme_admin($cache_array,'header_transparent');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Global transparent header?','wpestate').'</div>
    <div class="option_row_explain">'.__('Global transparent header?','wpestate').'</div>    
        <select id="header_transparent" name="header_transparent">
            '.$header_transparent_select.'
        </select>
    </div>';
    
    
    $header_array_logo  =   array(
                            'type1',
                            'type2',
                            'type3'
                        );
    $logo_header_select   = wpestate_dropdowns_theme_admin($header_array_logo,'logo_header_type');

    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Header Type?','wpestate').'</div>
    <div class="option_row_explain">'.__('Header Type?','wpestate').'</div>    
        <select id="logo_header_type" name="logo_header_type">
            '.$logo_header_select.'
        </select>
    </div>';
    
    
    
    $header_array   =   array(
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    $header_select   = wpestate_dropdowns_theme_admin_with_key($header_array,'header_type');

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Media Header Type?','wpestate').'</div>
    <div class="option_row_explain">'.__('Media Header Type?','wpestate').'</div>    
        <select id="header_type" name="header_type">
            '.$header_select.'
        </select>
    </div>';
       
    
    
    $logo_margin                =   intval( get_option('wp_estate_logo_margin','') ); 
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Margin Top for logo','wpestate').'</div>
    <div class="option_row_explain">'.__('Margin Top for logo','wpestate').'</div>    
        <input type="text" id="logo_margin" name="logo_margin" value="'.$logo_margin.'"> 
    </div>';
          
   
    $global_revolution_slider   =   get_option('wp_estate_global_revolution_slider','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Global Revolution Slider','wpestate').'</div>
    <div class="option_row_explain">'.__('Global Revolution Slider','wpestate').'</div>    
        <input type="text" id="global_revolution_slider" name="global_revolution_slider" value="'.$global_revolution_slider.'">   
    </div>';
    
    
    $global_header              =   get_option('wp_estate_global_header','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Global Header Static Image','wpestate').'</div>
    <div class="option_row_explain">'.__('Global Header Static Image','wpestate').'</div>    
        <input id="global_header" type="text" size="36" name="global_header" value="'.$global_header.'" />
        <input id="global_header_button" type="button"  class="upload_button button" value="'.__('Upload Header Image','wpestate').'" />
    </div>';
    
    $footer_background          =   get_option('wp_estate_footer_background','');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Background for Footer','wpestate').'</div>
    <div class="option_row_explain">'.__('Background for Footer','wpestate').'</div>    
        <input id="footer_background" type="text" size="36" name="footer_background" value="'.$footer_background.'" />
        <input id="footer_background_button" type="button"  class="upload_button button" value="'.__('Upload Background Image for Footer','wpestate').'" />
                 
    </div>';
    

    $repeat_array=array('repeat','repeat x','repeat y','no repeat');
    $repeat_footer_back_symbol  = wpestate_dropdowns_theme_admin($repeat_array,'repeat_footer_back');

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Repeat Footer background ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Repeat Footer background ?','wpestate').'</div>    
        <select id="repeat_footer_back" name="repeat_footer_back">
            '.$repeat_footer_back_symbol.'
        </select>     
    </div>';

    
    $prop_no                    =   intval   ( get_option('wp_estate_prop_no','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Properties List - Properties number per page','wpestate').'</div>
    <div class="option_row_explain">'.__('Properties List - Properties number per page','wpestate').'</div>    
        <input type="text" id="prop_no" name="prop_no" value="'.$prop_no.'"> 
    </div>';
    
    
    $prop_list_slider = array( 
                "0"  =>  __("no ","wpestate"),
                "1"  =>  __("yes","wpestate")
                );
    $prop_unit_slider_symbol = wpestate_dropdowns_theme_admin_with_key($prop_list_slider,'prop_list_slider');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Slider in Property Unit','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Slider in Property Unit','wpestate').'</div>    
        <select id="prop_list_slider" name="prop_list_slider">
            '.$prop_unit_slider_symbol.'
        </select>  
    </div>';
    
    
    $show_empty_city_status_symbol      = wpestate_dropdowns_theme_admin($cache_array,'show_empty_city');  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Cities and Areas with 0 properties in advanced search','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Cities and Areas with 0 properties in advanced search','wpestate').'</div>    
        <select id="show_empty_city" name="show_empty_city">
            '.$show_empty_city_status_symbol.'
        </select>
    </div>';
    
    
    
    $blog_sidebar_array=array('no sidebar','right','left');
    $agent_sidebar_pos_select     = wpestate_dropdowns_theme_admin($blog_sidebar_array,'agent_sidebar');

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Agent Sidebar Position','wpestate').'</div>
    <div class="option_row_explain">'.__('Agent Sidebar Position','wpestate').'</div>    
       <select id="agent_sidebar" name="agent_sidebar">
            '.$agent_sidebar_pos_select.'
        </select>
    </div>';
    
    
    $agent_sidebar_name          =   esc_html ( get_option('wp_estate_agent_sidebar_name','') );
    $agent_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $agent_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($agent_sidebar_name==$sidebar['id']){ 
                $agent_sidebar_name_select.=' selected="selected"';
            }
        $agent_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Agent page Sidebar','wpestate').'</div>
    <div class="option_row_explain">'.__('Agent page Sidebar','wpestate').'</div>    
       <select id="agent_sidebar_name" name="agent_sidebar_name">
            '.$agent_sidebar_name_select.'
        </select>
    </div>';
    
    
    $blog_sidebar_select ='';
    $blog_sidebar= esc_html ( get_option('wp_estate_blog_sidebar','') );
    $blog_sidebar_array=array('no sidebar','right','left');

    foreach($blog_sidebar_array as $value){
            $blog_sidebar_select.='<option value="'.$value.'"';
            if ($blog_sidebar==$value){
                    $blog_sidebar_select.='selected="selected"';
            }
            $blog_sidebar_select.='>'.$value.'</option>';
    }
    
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Submission Post, Blog Category/Archive Sidebar Position','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Submission Post, Blog Category/Archive Sidebar Position','wpestate').'</div>    
        <select id="blog_sidebar" name="blog_sidebar">
            '.$blog_sidebar_select.'
        </select>
    </div>';
    
    
    
    $blog_sidebar_name          =   esc_html ( get_option('wp_estate_blog_sidebar_name','') );
   
    $blog_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $blog_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($blog_sidebar_name==$sidebar['id']){ 
               $blog_sidebar_name_select.=' selected="selected"';
            }
        $blog_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Submission Post, Blog Category/Archive Sidebar','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Submission Post, Blog Category/Archive Sidebar','wpestate').'</div>    
        <select id="blog_sidebar_name" name="blog_sidebar_name">
            '.$blog_sidebar_name_select.'
        </select>
    </div>';
    
    
    $blog_unit_array    =   array(
                        'grid'    =>__('grid','wpestate'),
                        'list'      => __('list','wpestate')
                        );
    
    $blog_unit_select = wpestate_dropdowns_theme_admin_with_key($blog_unit_array,'blog_unit');
      
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Blog Category/Archive List type','wpestate').'</div>
    <div class="option_row_explain">'.__('Blog Category/Archive List type','wpestate').'</div>    
        <select id="blog_unit" name="blog_unit">
            '.$blog_unit_select.'
        </select>
    </div>';
    
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Blog Category/Archive List type','wpestate').'</div>
    <div class="option_row_explain">'.__('Blog Category/Archive List type','wpestate').'</div>    
        <select id="blog_unit" name="blog_unit">
            '.$blog_unit_select.'
        </select>
    </div>';
    
    
      
    $prop_list_array=array(
               "1"  =>  __("standard ","wpestate"),
               "2"  =>  __("half map","wpestate")
            );
    $property_list_type_symbol   = wpestate_dropdowns_theme_admin_with_key($prop_list_array,'property_list_type');
   
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property List Type for Taxonomy pages','wpestate').'</div>
    <div class="option_row_explain">'.__('Property List Type for Taxonomy pages','wpestate').'</div>    
        <select id="property_list_type" name="property_list_type">
            '.$property_list_type_symbol.'
        </select>
    </div>';
    
    
    
   
    $property_list_type_symbol_adv   = wpestate_dropdowns_theme_admin_with_key($prop_list_array,'property_list_type_adv');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property List Type for Advanced Search','wpestate').'</div>
    <div class="option_row_explain">'.__('Property List Type for Advanced Search','wpestate').'</div>    
        <select id="property_list_type_adv" name="property_list_type_adv">
            '.$property_list_type_symbol_adv.'
        </select>
    </div>';
    
    
    
    
    $prop_unit_array    =   array(
                                'grid'    =>__('grid','wpestate'),
                                'list'      => __('list','wpestate')
                            );
    $prop_unit_select_view   = wpestate_dropdowns_theme_admin_with_key($prop_unit_array,'prop_unit');
    

    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property List display(*global option)','wpestate').'</div>
    <div class="option_row_explain">'.__('Property List display(*global option)','wpestate').'</div>    
        <select id="prop_unit" name="prop_unit">
            '.$prop_unit_select_view.'
        </select>
    </div>';
    
        $google_fonts_array = array(                          
                                                            "Abel" => "Abel",
                                                            "Abril Fatface" => "Abril Fatface",
                                                            "Aclonica" => "Aclonica",
                                                            "Acme" => "Acme",
                                                            "Actor" => "Actor",
                                                            "Adamina" => "Adamina",
                                                            "Advent Pro" => "Advent Pro",
                                                            "Aguafina Script" => "Aguafina Script",
                                                            "Aladin" => "Aladin",
                                                            "Aldrich" => "Aldrich",
                                                            "Alegreya" => "Alegreya",
                                                            "Alegreya SC" => "Alegreya SC",
                                                            "Alex Brush" => "Alex Brush",
                                                            "Alfa Slab One" => "Alfa Slab One",
                                                            "Alice" => "Alice",
                                                            "Alike" => "Alike",
                                                            "Alike Angular" => "Alike Angular",
                                                            "Allan" => "Allan",
                                                            "Allerta" => "Allerta",
                                                            "Allerta Stencil" => "Allerta Stencil",
                                                            "Allura" => "Allura",
                                                            "Almendra" => "Almendra",
                                                            "Almendra SC" => "Almendra SC",
                                                            "Amaranth" => "Amaranth",
                                                            "Amatic SC" => "Amatic SC",
                                                            "Amethysta" => "Amethysta",
                                                            "Andada" => "Andada",
                                                            "Andika" => "Andika",
                                                            "Angkor" => "Angkor",
                                                            "Annie Use Your Telescope" => "Annie Use Your Telescope",
                                                            "Anonymous Pro" => "Anonymous Pro",
                                                            "Antic" => "Antic",
                                                            "Antic Didone" => "Antic Didone",
                                                            "Antic Slab" => "Antic Slab",
                                                            "Anton" => "Anton",
                                                            "Arapey" => "Arapey",
                                                            "Arbutus" => "Arbutus",
                                                            "Architects Daughter" => "Architects Daughter",
                                                            "Arimo" => "Arimo",
                                                            "Arizonia" => "Arizonia",
                                                            "Armata" => "Armata",
                                                            "Artifika" => "Artifika",
                                                            "Arvo" => "Arvo",
                                                            "Asap" => "Asap",
                                                            "Asset" => "Asset",
                                                            "Astloch" => "Astloch",
                                                            "Asul" => "Asul",
                                                            "Atomic Age" => "Atomic Age",
                                                            "Aubrey" => "Aubrey",
                                                            "Audiowide" => "Audiowide",
                                                            "Average" => "Average",
                                                            "Averia Gruesa Libre" => "Averia Gruesa Libre",
                                                            "Averia Libre" => "Averia Libre",
                                                            "Averia Sans Libre" => "Averia Sans Libre",
                                                            "Averia Serif Libre" => "Averia Serif Libre",
                                                            "Bad Script" => "Bad Script",
                                                            "Balthazar" => "Balthazar",
                                                            "Bangers" => "Bangers",
                                                            "Basic" => "Basic",
                                                            "Battambang" => "Battambang",
                                                            "Baumans" => "Baumans",
                                                            "Bayon" => "Bayon",
                                                            "Belgrano" => "Belgrano",
                                                            "Belleza" => "Belleza",
                                                            "Bentham" => "Bentham",
                                                            "Berkshire Swash" => "Berkshire Swash",
                                                            "Bevan" => "Bevan",
                                                            "Bigshot One" => "Bigshot One",
                                                            "Bilbo" => "Bilbo",
                                                            "Bilbo Swash Caps" => "Bilbo Swash Caps",
                                                            "Bitter" => "Bitter",
                                                            "Black Ops One" => "Black Ops One",
                                                            "Bokor" => "Bokor",
                                                            "Bonbon" => "Bonbon",
                                                            "Boogaloo" => "Boogaloo",
                                                            "Bowlby One" => "Bowlby One",
                                                            "Bowlby One SC" => "Bowlby One SC",
                                                            "Brawler" => "Brawler",
                                                            "Bree Serif" => "Bree Serif",
                                                            "Bubblegum Sans" => "Bubblegum Sans",
                                                            "Buda" => "Buda",
                                                            "Buenard" => "Buenard",
                                                            "Butcherman" => "Butcherman",
                                                            "Butterfly Kids" => "Butterfly Kids",
                                                            "Cabin" => "Cabin",
                                                            "Cabin Condensed" => "Cabin Condensed",
                                                            "Cabin Sketch" => "Cabin Sketch",
                                                            "Caesar Dressing" => "Caesar Dressing",
                                                            "Cagliostro" => "Cagliostro",
                                                            "Calligraffitti" => "Calligraffitti",
                                                            "Cambo" => "Cambo",
                                                            "Candal" => "Candal",
                                                            "Cantarell" => "Cantarell",
                                                            "Cantata One" => "Cantata One",
                                                            "Cardo" => "Cardo",
                                                            "Carme" => "Carme",
                                                            "Carter One" => "Carter One",
                                                            "Caudex" => "Caudex",
                                                            "Cedarville Cursive" => "Cedarville Cursive",
                                                            "Ceviche One" => "Ceviche One",
                                                            "Changa One" => "Changa One",
                                                            "Chango" => "Chango",
                                                            "Chau Philomene One" => "Chau Philomene One",
                                                            "Chelsea Market" => "Chelsea Market",
                                                            "Chenla" => "Chenla",
                                                            "Cherry Cream Soda" => "Cherry Cream Soda",
                                                            "Chewy" => "Chewy",
                                                            "Chicle" => "Chicle",
                                                            "Chivo" => "Chivo",
                                                            "Coda" => "Coda",
                                                            "Coda Caption" => "Coda Caption",
                                                            "Codystar" => "Codystar",
                                                            "Comfortaa" => "Comfortaa",
                                                            "Coming Soon" => "Coming Soon",
                                                            "Concert One" => "Concert One",
                                                            "Condiment" => "Condiment",
                                                            "Content" => "Content",
                                                            "Contrail One" => "Contrail One",
                                                            "Convergence" => "Convergence",
                                                            "Cookie" => "Cookie",
                                                            "Copse" => "Copse",
                                                            "Corben" => "Corben",
                                                            "Cousine" => "Cousine",
                                                            "Coustard" => "Coustard",
                                                            "Covered By Your Grace" => "Covered By Your Grace",
                                                            "Crafty Girls" => "Crafty Girls",
                                                            "Creepster" => "Creepster",
                                                            "Crete Round" => "Crete Round",
                                                            "Crimson Text" => "Crimson Text",
                                                            "Crushed" => "Crushed",
                                                            "Cuprum" => "Cuprum",
                                                            "Cutive" => "Cutive",
                                                            "Damion" => "Damion",
                                                            "Dancing Script" => "Dancing Script",
                                                            "Dangrek" => "Dangrek",
                                                            "Dawning of a New Day" => "Dawning of a New Day",
                                                            "Days One" => "Days One",
                                                            "Delius" => "Delius",
                                                            "Delius Swash Caps" => "Delius Swash Caps",
                                                            "Delius Unicase" => "Delius Unicase",
                                                            "Della Respira" => "Della Respira",
                                                            "Devonshire" => "Devonshire",
                                                            "Didact Gothic" => "Didact Gothic",
                                                            "Diplomata" => "Diplomata",
                                                            "Diplomata SC" => "Diplomata SC",
                                                            "Doppio One" => "Doppio One",
                                                            "Dorsa" => "Dorsa",
                                                            "Dosis" => "Dosis",
                                                            "Dr Sugiyama" => "Dr Sugiyama",
                                                            "Droid Sans" => "Droid Sans",
                                                            "Droid Sans Mono" => "Droid Sans Mono",
                                                            "Droid Serif" => "Droid Serif",
                                                            "Duru Sans" => "Duru Sans",
                                                            "Dynalight" => "Dynalight",
                                                            "EB Garamond" => "EB Garamond",
                                                            "Eater" => "Eater",
                                                            "Economica" => "Economica",
                                                            "Electrolize" => "Electrolize",
                                                            "Emblema One" => "Emblema One",
                                                            "Emilys Candy" => "Emilys Candy",
                                                            "Engagement" => "Engagement",
                                                            "Enriqueta" => "Enriqueta",
                                                            "Erica One" => "Erica One",
                                                            "Esteban" => "Esteban",
                                                            "Euphoria Script" => "Euphoria Script",
                                                            "Ewert" => "Ewert",
                                                            "Exo" => "Exo",
                                                            "Expletus Sans" => "Expletus Sans",
                                                            "Fanwood Text" => "Fanwood Text",
                                                            "Fascinate" => "Fascinate",
                                                            "Fascinate Inline" => "Fascinate Inline",
                                                            "Federant" => "Federant",
                                                            "Federo" => "Federo",
                                                            "Felipa" => "Felipa",
                                                            "Fjord One" => "Fjord One",
                                                            "Flamenco" => "Flamenco",
                                                            "Flavors" => "Flavors",
                                                            "Fondamento" => "Fondamento",
                                                            "Fontdiner Swanky" => "Fontdiner Swanky",
                                                            "Forum" => "Forum",
                                                            "Francois One" => "Francois One",
                                                            "Fredericka the Great" => "Fredericka the Great",
                                                            "Fredoka One" => "Fredoka One",
                                                            "Freehand" => "Freehand",
                                                            "Fresca" => "Fresca",
                                                            "Frijole" => "Frijole",
                                                            "Fugaz One" => "Fugaz One",
                                                            "GFS Didot" => "GFS Didot",
                                                            "GFS Neohellenic" => "GFS Neohellenic",
                                                            "Galdeano" => "Galdeano",
                                                            "Gentium Basic" => "Gentium Basic",
                                                            "Gentium Book Basic" => "Gentium Book Basic",
                                                            "Geo" => "Geo",
                                                            "Geostar" => "Geostar",
                                                            "Geostar Fill" => "Geostar Fill",
                                                            "Germania One" => "Germania One",
                                                            "Give You Glory" => "Give You Glory",
                                                            "Glass Antiqua" => "Glass Antiqua",
                                                            "Glegoo" => "Glegoo",
                                                            "Gloria Hallelujah" => "Gloria Hallelujah",
                                                            "Goblin One" => "Goblin One",
                                                            "Gochi Hand" => "Gochi Hand",
                                                            "Gorditas" => "Gorditas",
                                                            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
                                                            "Graduate" => "Graduate",
                                                            "Gravitas One" => "Gravitas One",
                                                            "Great Vibes" => "Great Vibes",
                                                            "Gruppo" => "Gruppo",
                                                            "Gudea" => "Gudea",
                                                            "Habibi" => "Habibi",
                                                            "Hammersmith One" => "Hammersmith One",
                                                            "Handlee" => "Handlee",
                                                            "Hanuman" => "Hanuman",
                                                            "Happy Monkey" => "Happy Monkey",
                                                            "Henny Penny" => "Henny Penny",
                                                            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
                                                            "Holtwood One SC" => "Holtwood One SC",
                                                            "Homemade Apple" => "Homemade Apple",
                                                            "Homenaje" => "Homenaje",
                                                            "IM Fell DW Pica" => "IM Fell DW Pica",
                                                            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
                                                            "IM Fell Double Pica" => "IM Fell Double Pica",
                                                            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
                                                            "IM Fell English" => "IM Fell English",
                                                            "IM Fell English SC" => "IM Fell English SC",
                                                            "IM Fell French Canon" => "IM Fell French Canon",
                                                            "IM Fell French Canon SC" => "IM Fell French Canon SC",
                                                            "IM Fell Great Primer" => "IM Fell Great Primer",
                                                            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
                                                            "Iceberg" => "Iceberg",
                                                            "Iceland" => "Iceland",
                                                            "Imprima" => "Imprima",
                                                            "Inconsolata" => "Inconsolata",
                                                            "Inder" => "Inder",
                                                            "Indie Flower" => "Indie Flower",
                                                            "Inika" => "Inika",
                                                            "Irish Grover" => "Irish Grover",
                                                            "Istok Web" => "Istok Web",
                                                            "Italiana" => "Italiana",
                                                            "Italianno" => "Italianno",
                                                            "Jim Nightshade" => "Jim Nightshade",
                                                            "Jockey One" => "Jockey One",
                                                            "Jolly Lodger" => "Jolly Lodger",
                                                            "Josefin Sans" => "Josefin Sans",
                                                            "Josefin Slab" => "Josefin Slab",
                                                            "Judson" => "Judson",
                                                            "Julee" => "Julee",
                                                            "Junge" => "Junge",
                                                            "Jura" => "Jura",
                                                            "Just Another Hand" => "Just Another Hand",
                                                            "Just Me Again Down Here" => "Just Me Again Down Here",
                                                            "Kameron" => "Kameron",
                                                            "Karla" => "Karla",
                                                            "Kaushan Script" => "Kaushan Script",
                                                            "Kelly Slab" => "Kelly Slab",
                                                            "Kenia" => "Kenia",
                                                            "Khmer" => "Khmer",
                                                            "Knewave" => "Knewave",
                                                            "Kotta One" => "Kotta One",
                                                            "Koulen" => "Koulen",
                                                            "Kranky" => "Kranky",
                                                            "Kreon" => "Kreon",
                                                            "Kristi" => "Kristi",
                                                            "Krona One" => "Krona One",
                                                            "La Belle Aurore" => "La Belle Aurore",
                                                            "Lancelot" => "Lancelot",
                                                            "Lato" => "Lato",
                                                            "League Script" => "League Script",
                                                            "Leckerli One" => "Leckerli One",
                                                            "Ledger" => "Ledger",
                                                            "Lekton" => "Lekton",
                                                            "Lemon" => "Lemon",
                                                            "Lilita One" => "Lilita One",
                                                            "Limelight" => "Limelight",
                                                            "Linden Hill" => "Linden Hill",
                                                            "Lobster" => "Lobster",
                                                            "Lobster Two" => "Lobster Two",
                                                            "Londrina Outline" => "Londrina Outline",
                                                            "Londrina Shadow" => "Londrina Shadow",
                                                            "Londrina Sketch" => "Londrina Sketch",
                                                            "Londrina Solid" => "Londrina Solid",
                                                            "Lora" => "Lora",
                                                            "Love Ya Like A Sister" => "Love Ya Like A Sister",
                                                            "Loved by the King" => "Loved by the King",
                                                            "Lovers Quarrel" => "Lovers Quarrel",
                                                            "Luckiest Guy" => "Luckiest Guy",
                                                            "Lusitana" => "Lusitana",
                                                            "Lustria" => "Lustria",
                                                            "Macondo" => "Macondo",
                                                            "Macondo Swash Caps" => "Macondo Swash Caps",
                                                            "Magra" => "Magra",
                                                            "Maiden Orange" => "Maiden Orange",
                                                            "Mako" => "Mako",
                                                            "Marck Script" => "Marck Script",
                                                            "Marko One" => "Marko One",
                                                            "Marmelad" => "Marmelad",
                                                            "Marvel" => "Marvel",
                                                            "Mate" => "Mate",
                                                            "Mate SC" => "Mate SC",
                                                            "Maven Pro" => "Maven Pro",
                                                            "Meddon" => "Meddon",
                                                            "MedievalSharp" => "MedievalSharp",
                                                            "Medula One" => "Medula One",
                                                            "Megrim" => "Megrim",
                                                            "Merienda One" => "Merienda One",
                                                            "Merriweather" => "Merriweather",
                                                            "Metal" => "Metal",
                                                            "Metamorphous" => "Metamorphous",
                                                            "Metrophobic" => "Metrophobic",
                                                            "Michroma" => "Michroma",
                                                            "Miltonian" => "Miltonian",
                                                            "Miltonian Tattoo" => "Miltonian Tattoo",
                                                            "Miniver" => "Miniver",
                                                            "Miss Fajardose" => "Miss Fajardose",
                                                            "Modern Antiqua" => "Modern Antiqua",
                                                            "Molengo" => "Molengo",
                                                            "Monofett" => "Monofett",
                                                            "Monoton" => "Monoton",
                                                            "Monsieur La Doulaise" => "Monsieur La Doulaise",
                                                            "Montaga" => "Montaga",
                                                            "Montez" => "Montez",
                                                            "Montserrat" => "Montserrat",
                                                            "Moul" => "Moul",
                                                            "Moulpali" => "Moulpali",
                                                            "Mountains of Christmas" => "Mountains of Christmas",
                                                            "Mr Bedfort" => "Mr Bedfort",
                                                            "Mr Dafoe" => "Mr Dafoe",
                                                            "Mr De Haviland" => "Mr De Haviland",
                                                            "Mrs Saint Delafield" => "Mrs Saint Delafield",
                                                            "Mrs Sheppards" => "Mrs Sheppards",
                                                            "Muli" => "Muli",
                                                            "Mystery Quest" => "Mystery Quest",
                                                            "Neucha" => "Neucha",
                                                            "Neuton" => "Neuton",
                                                            "News Cycle" => "News Cycle",
                                                            "Niconne" => "Niconne",
                                                            "Nixie One" => "Nixie One",
                                                            "Nobile" => "Nobile",
                                                            "Nokora" => "Nokora",
                                                            "Norican" => "Norican",
                                                            "Nosifer" => "Nosifer",
                                                            "Nothing You Could Do" => "Nothing You Could Do",
                                                            "Noticia Text" => "Noticia Text",
                                                            "Nova Cut" => "Nova Cut",
                                                            "Nova Flat" => "Nova Flat",
                                                            "Nova Mono" => "Nova Mono",
                                                            "Nova Oval" => "Nova Oval",
                                                            "Nova Round" => "Nova Round",
                                                            "Nova Script" => "Nova Script",
                                                            "Nova Slim" => "Nova Slim",
                                                            "Nova Square" => "Nova Square",
                                                            "Numans" => "Numans",
                                                            "Nunito" => "Nunito",
                                                            "Odor Mean Chey" => "Odor Mean Chey",
                                                            "Old Standard TT" => "Old Standard TT",
                                                            "Oldenburg" => "Oldenburg",
                                                            "Oleo Script" => "Oleo Script",
                                                            "Open Sans" => "Open Sans",
                                                            "Open Sans Condensed" => "Open Sans Condensed",
                                                            "Orbitron" => "Orbitron",
                                                            "Original Surfer" => "Original Surfer",
                                                            "Oswald" => "Oswald",
                                                            "Over the Rainbow" => "Over the Rainbow",
                                                            "Overlock" => "Overlock",
                                                            "Overlock SC" => "Overlock SC",
                                                            "Ovo" => "Ovo",
                                                            "Oxygen" => "Oxygen",
                                                            "PT Mono" => "PT Mono",
                                                            "PT Sans" => "PT Sans",
                                                            "PT Sans Caption" => "PT Sans Caption",
                                                            "PT Sans Narrow" => "PT Sans Narrow",
                                                            "PT Serif" => "PT Serif",
                                                            "PT Serif Caption" => "PT Serif Caption",
                                                            "Pacifico" => "Pacifico",
                                                            "Parisienne" => "Parisienne",
                                                            "Passero One" => "Passero One",
                                                            "Passion One" => "Passion One",
                                                            "Patrick Hand" => "Patrick Hand",
                                                            "Patua One" => "Patua One",
                                                            "Paytone One" => "Paytone One",
                                                            "Permanent Marker" => "Permanent Marker",
                                                            "Petrona" => "Petrona",
                                                            "Philosopher" => "Philosopher",
                                                            "Piedra" => "Piedra",
                                                            "Pinyon Script" => "Pinyon Script",
                                                            "Plaster" => "Plaster",
                                                            "Play" => "Play",
                                                            "Playball" => "Playball",
                                                            "Playfair Display" => "Playfair Display",
                                                            "Podkova" => "Podkova",
                                                            "Poiret One" => "Poiret One",
                                                            "Poller One" => "Poller One",
                                                            "Poly" => "Poly",
                                                            "Pompiere" => "Pompiere",
                                                            "Pontano Sans" => "Pontano Sans",
                                                            "Port Lligat Sans" => "Port Lligat Sans",
                                                            "Port Lligat Slab" => "Port Lligat Slab",
                                                            "Prata" => "Prata",
                                                            "Preahvihear" => "Preahvihear",
                                                            "Press Start 2P" => "Press Start 2P",
                                                            "Princess Sofia" => "Princess Sofia",
                                                            "Prociono" => "Prociono",
                                                            "Prosto One" => "Prosto One",
                                                            "Puritan" => "Puritan",
                                                            "Quantico" => "Quantico",
                                                            "Quattrocento" => "Quattrocento",
                                                            "Quattrocento Sans" => "Quattrocento Sans",
                                                            "Questrial" => "Questrial",
                                                            "Quicksand" => "Quicksand",
                                                            "Qwigley" => "Qwigley",
                                                            "Radley" => "Radley",
                                                            "Raleway" => "Raleway",
                                                            "Rammetto One" => "Rammetto One",
                                                            "Rancho" => "Rancho",
                                                            "Rationale" => "Rationale",
                                                            "Redressed" => "Redressed",
                                                            "Reenie Beanie" => "Reenie Beanie",
                                                            "Revalia" => "Revalia",
                                                            "Ribeye" => "Ribeye",
                                                            "Ribeye Marrow" => "Ribeye Marrow",
                                                            "Righteous" => "Righteous",
                                                            "Rochester" => "Rochester",
                                                            "Rock Salt" => "Rock Salt",
                                                            "Rokkitt" => "Rokkitt",
                                                            "Ropa Sans" => "Ropa Sans",
                                                            "Rosario" => "Rosario",
                                                            "Rosarivo" => "Rosarivo",
                                                            "Rouge Script" => "Rouge Script",
                                                            "Ruda" => "Ruda",
                                                            "Ruge Boogie" => "Ruge Boogie",
                                                            "Ruluko" => "Ruluko",
                                                            "Ruslan Display" => "Ruslan Display",
                                                            "Russo One" => "Russo One",
                                                            "Ruthie" => "Ruthie",
                                                            "Sail" => "Sail",
                                                            "Salsa" => "Salsa",
                                                            "Sancreek" => "Sancreek",
                                                            "Sansita One" => "Sansita One",
                                                            "Sarina" => "Sarina",
                                                            "Satisfy" => "Satisfy",
                                                            "Schoolbell" => "Schoolbell",
                                                            "Seaweed Script" => "Seaweed Script",
                                                            "Sevillana" => "Sevillana",
                                                            "Shadows Into Light" => "Shadows Into Light",
                                                            "Shadows Into Light Two" => "Shadows Into Light Two",
                                                            "Shanti" => "Shanti",
                                                            "Share" => "Share",
                                                            "Shojumaru" => "Shojumaru",
                                                            "Short Stack" => "Short Stack",
                                                            "Siemreap" => "Siemreap",
                                                            "Sigmar One" => "Sigmar One",
                                                            "Signika" => "Signika",
                                                            "Signika Negative" => "Signika Negative",
                                                            "Simonetta" => "Simonetta",
                                                            "Sirin Stencil" => "Sirin Stencil",
                                                            "Six Caps" => "Six Caps",
                                                            "Slackey" => "Slackey",
                                                            "Smokum" => "Smokum",
                                                            "Smythe" => "Smythe",
                                                            "Sniglet" => "Sniglet",
                                                            "Snippet" => "Snippet",
                                                            "Sofia" => "Sofia",
                                                            "Sonsie One" => "Sonsie One",
                                                            "Sorts Mill Goudy" => "Sorts Mill Goudy",
                                                            "Special Elite" => "Special Elite",
                                                            "Spicy Rice" => "Spicy Rice",
                                                            "Spinnaker" => "Spinnaker",
                                                            "Spirax" => "Spirax",
                                                            "Squada One" => "Squada One",
                                                            "Stardos Stencil" => "Stardos Stencil",
                                                            "Stint Ultra Condensed" => "Stint Ultra Condensed",
                                                            "Stint Ultra Expanded" => "Stint Ultra Expanded",
                                                            "Stoke" => "Stoke",
                                                            "Sue Ellen Francisco" => "Sue Ellen Francisco",
                                                            "Sunshiney" => "Sunshiney",
                                                            "Supermercado One" => "Supermercado One",
                                                            "Suwannaphum" => "Suwannaphum",
                                                            "Swanky and Moo Moo" => "Swanky and Moo Moo",
                                                            "Syncopate" => "Syncopate",
                                                            "Tangerine" => "Tangerine",
                                                            "Taprom" => "Taprom",
                                                            "Telex" => "Telex",
                                                            "Tenor Sans" => "Tenor Sans",
                                                            "The Girl Next Door" => "The Girl Next Door",
                                                            "Tienne" => "Tienne",
                                                            "Tinos" => "Tinos",
                                                            "Titan One" => "Titan One",
                                                            "Trade Winds" => "Trade Winds",
                                                            "Trocchi" => "Trocchi",
                                                            "Trochut" => "Trochut",
                                                            "Trykker" => "Trykker",
                                                            "Tulpen One" => "Tulpen One",
                                                            "Ubuntu" => "Ubuntu",
                                                            "Ubuntu Condensed" => "Ubuntu Condensed",
                                                            "Ubuntu Mono" => "Ubuntu Mono",
                                                            "Ultra" => "Ultra",
                                                            "Uncial Antiqua" => "Uncial Antiqua",
                                                            "UnifrakturCook" => "UnifrakturCook",
                                                            "UnifrakturMaguntia" => "UnifrakturMaguntia",
                                                            "Unkempt" => "Unkempt",
                                                            "Unlock" => "Unlock",
                                                            "Unna" => "Unna",
                                                            "VT323" => "VT323",
                                                            "Varela" => "Varela",
                                                            "Varela Round" => "Varela Round",
                                                            "Vast Shadow" => "Vast Shadow",
                                                            "Vibur" => "Vibur",
                                                            "Vidaloka" => "Vidaloka",
                                                            "Viga" => "Viga",
                                                            "Voces" => "Voces",
                                                            "Volkhov" => "Volkhov",
                                                            "Vollkorn" => "Vollkorn",
                                                            "Voltaire" => "Voltaire",
                                                            "Waiting for the Sunrise" => "Waiting for the Sunrise",
                                                            "Wallpoet" => "Wallpoet",
                                                            "Walter Turncoat" => "Walter Turncoat",
                                                            "Wellfleet" => "Wellfleet",
                                                            "Wire One" => "Wire One",
                                                            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
                                                            "Yellowtail" => "Yellowtail",
                                                            "Yeseva One" => "Yeseva One",
                                                            "Yesteryear" => "Yesteryear",
                                                            "Zeyada" => "Zeyada",
                                                    );

    $font_select='';
    foreach($google_fonts_array as $key=>$value){
        $font_select.='<option value="'.$key.'">'.$value.'</option>';
    }
    
    $general_font_select='';
    $general_font= esc_html ( get_option('wp_estate_general_font','') );
    if($general_font!='x'){
        $general_font_select='<option value="'.$general_font.'">'.$general_font.'</option>';
    }
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Main Font','wpestate').'</div>
    <div class="option_row_explain">'.__('Main Font','wpestate').'</div>    
        <select id="general_font" name="general_font">
            '.$general_font_select.'
            <option value="">- original font -</option>
            '.$font_select.'                   
        </select> 
    </div>';
    

    
    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Second Font subset','wpestate').'</div>
    <div class="option_row_explain">'.__('Second Font subset','wpestate').'</div>    
        <input type="text" id="headings_font_subset" name="headings_font_subset" value="'.$headings_font_subset.'">  
    </div>';
    
    $copyright_message          =   esc_html (stripslashes( get_option('wp_estate_copyright_message','') ) );   
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Copyright Message','wpestate').'</div>
    <div class="option_row_explain">'.__('Copyright Message','wpestate').'</div>    
        <textarea cols="57" rows="2" id="copyright_message" name="copyright_message">'.$copyright_message.'</textarea></td>  
    </div>';
       
}

function new_wpestate_property_page_details(){
    $sidebar_agent                  =   array('yes','no');
    $slider_type                    =   array('vertical','horizontal');
    $social_array                   =   array('no','yes');
    $content_type                   =   array('accordion','tabs');
   
    $enable_global_property_page_agent_sidebar_symbol           =   wpestate_dropdowns_theme_admin($sidebar_agent,'global_property_page_agent_sidebar');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Add Agent on Sidebar','wpestate').'</div>
    <div class="option_row_explain">'.__('Add Agent on Sidebar','wpestate').'</div>    
        <select id="global_property_page_agent_sidebar" name="global_property_page_agent_sidebar">
            '.$enable_global_property_page_agent_sidebar_symbol.'
        </select> 
    </div>';
    
    $global_prpg_slider_type_symbol                             =   wpestate_dropdowns_theme_admin($slider_type,'global_prpg_slider_type');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Slider Type','wpestate').'</div>
    <div class="option_row_explain">'.__('Slider Type','wpestate').'</div>    
        <select id="global_prpg_slider_type" name="global_prpg_slider_type">
            '.$global_prpg_slider_type_symbol.'
        </select> 
    </div>';
    
    $global_prpg_content_type_symbol                            =   wpestate_dropdowns_theme_admin($content_type,'global_prpg_content_type');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Content as ','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Content as ','wpestate').'</div>    
        <select id="global_prpg_content_type" name="global_prpg_content_type">
            '.$global_prpg_content_type_symbol.'
        </select> 
    </div>';
    
    $walkscore_api                                              =   esc_html ( get_option('wp_estate_walkscore_api','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Walkscore APi Key','wpestate').'</div>
    <div class="option_row_explain">'.__('Walkscore APi Key','wpestate').'</div>    
        <input type="text" name="walkscore_api" id="walkscore_api" value="'.$walkscore_api.'"> 
    </div>';
    
    
    $show_graph_prop_page                                       =   wpestate_dropdowns_theme_admin($social_array,'show_graph_prop_page');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Graph on Property Page','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Graph on Property Page','wpestate').'</div>    
        <select id="show_graph_prop_page" name="show_graph_prop_page">
            '.$show_graph_prop_page.'
        </select> 
    </div>';
}
 

function new_wpestate_price_currency(){
    
     
    $custom_fields = get_option( 'wp_estate_multi_curr', true);     
    $current_fields='';
    
    $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
    
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol          =   wpestate_dropdowns_theme_admin($where_currency_symbol_array,'where_currency_symbol');
   
    $enable_auto_symbol_array       =   array('yes','no');
    $enable_auto_symbol             =   wpestate_dropdowns_theme_admin($enable_auto_symbol_array,'auto_curency');
    
    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $current_fields.='
                <div class=field_row>
                <div    class="field_item"><strong>'.__('Currency Symbol','wpestate').'</strong></br><input   type="text" name="add_curr_name[]"   value="'.$custom_fields[$i][0].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Label','wpestate').'</strong></br><input  type="text" name="add_curr_label[]"   value="'.$custom_fields[$i][1].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Value','wpestate').'</strong></br><input  type="text" name="add_curr_value[]"   value="'.$custom_fields[$i][2].'"  ></div>
                <div    class="field_item"><strong>'.__('Currency Position','wpestate').'</strong></br><input  type="text" name="add_curr_order[]"   value="'.$custom_fields[$i][3].'"  ></div>
                
                <a class="deletefieldlink" href="#">'.__('delete','wpestate').'</a>
            </div>';    
            $i++;
        }
    }
    
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Price - thousands separator','wpestate').'</div>
    <div class="option_row_explain">'.__('Price - thousands separator','wpestate').'</div>    
        <input type="text" name="prices_th_separator" id="prices_th_separator" value="'.  stripslashes ( get_option('wp_estate_prices_th_separator','') ).'"> 
    </div>';
 
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Currency symbol','wpestate').'</div>
    <div class="option_row_explain">'.__('Currency symbol','wpestate').'</div>    
        <input  type="text" id="currency_symbol" name="currency_symbol"  value="'.$currency_symbol.'"/>
    </div>';
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Currency label - will appear on front end','wpestate').'</div>
    <div class="option_row_explain">'.__('Currency label - will appear on front end','wpestate').'</div>    
        <input  type="text" id="currency_label_main"  name="currency_label_main"   value="'. get_option('wp_estate_currency_label_main','').'" size="40"/>
    </div>';
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Where to show the currency symbol?','wpestate').'</div>
    <div class="option_row_explain">'.__('Where to show the currency symbol?','wpestate').'</div>    
        <select id="where_currency_symbol" name="where_currency_symbol">
            '.$where_currency_symbol.'
        </select> 
    </div>';

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable auto loading of exchange rates from Yahoo(1 time per day)?','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable auto loading of exchange rates from Yahoo(1 time per day)?','wpestate').'</div>    
        <select id="auto_curency" name="auto_curency">
            '.$enable_auto_symbol.'
        </select> 
    </div>';

 
    print'<div class="estate_option_row"> <form method="post" action="">
        <h3 style="margin-left:10px;width:100%;float:left;">'.__('Add Currencies for Multi Currency features','wpestate').'</h3>
     
        <div id="custom_fields">
             '.$current_fields.'
            <input type="hidden" name="is_custom_cur" value="1">   
        </div>

       <table class="form-table">
            <tbody>
                <tr valign="top">
                    <tr valign="top">
                        <th scope="row">'.__('Currency','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_name"  name="currency_name"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Currency label - will appear on front end','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_label"  name="currency_label"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Currency Value compared with the based currency','wpestate').'</th>
                        <td>
                            <input  type="text" id="currency_value"  name="currency_value"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Show currency before or after price - in front pages','wpestate').'</th>
                        <td>
                             <select id="where_cur" name="where_cur"  style="width:236px;">
                                <option value="before"> before </option>
                                <option value="after">  after </option>
                            </select>
                        </td>
                    </tr>
            </tbody>
        </table>   
        
       <a href="#" id="add_curency">'.__(' click to add currency','wpestate').'</a><br>
    </form> </div> ';
}



function new_wpestate_map_details(){
    $cache_array                    =   array('yes','no');
    $cache_array2                   =   array('no','yes');
    $show_filter_map_symbol         =   wpestate_dropdowns_theme_admin($cache_array,'show_filter_map');
    $home_small_map_symbol          =   wpestate_dropdowns_theme_admin($cache_array,'home_small_map');
    $show_adv_search_symbol_map_close   =   wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_map_close');
    
    
    $path=estate_get_pin_file_path(); 
   
    if ( file_exists ($path) && is_writable ($path) ){
    }else{
        print ' <div class="notice_file">'.__('the file Google map does NOT exist or is NOT writable','wpestate').'</div>';
    }
    
    $readsys_symbol                 =   wpestate_dropdowns_theme_admin($cache_array,'readsys');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use file reading for pins? ','wpestate').'</div>
    <div class="option_row_explain">'.__('Use file reading for pins? (*recommended for over 200 listings. Read the manual for diffrences betwen file and mysql reading)','wpestate').'</div>    
        <select id="readsys" name="readsys">
            '.$readsys_symbol.'
        </select>
    </div>';
       
    $ssl_map_symbol                 =   wpestate_dropdowns_theme_admin($cache_array,'ssl_map');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Google maps with SSL ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Google maps with SSL ?','wpestate').'</div>    
        <select id="ssl_map" name="ssl_map">
            '.$ssl_map_symbol.'
        </select>
    </div>';  

    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Google Maps API KEY','wpestate').'</div>
    <div class="option_row_explain">'.__('The Google Maps JavaScript API v3 does not require an API key to function correctly. However, we strongly encourage you to get  an APIs Console key and post the code in Theme Options. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">here</a>','wpestate').'</div>    
        <input  type="text" id="api_key" name="api_key" class="regular-text" value="'.$api_key.'"/>
    </div>'; 

    $general_latitude               =   esc_html( get_option('wp_estate_general_latitude') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Starting Point Latitude','wpestate').'</div>
    <div class="option_row_explain">'.__('Starting Point Latitude','wpestate').'</div>    
    <input  type="text" id="general_latitude"  name="general_latitude"   value="'.$general_latitude.'"/>
    </div>'; 
    
    $general_longitude              =   esc_html( get_option('wp_estate_general_longitude') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Starting Point Longitude','wpestate').'</div>
    <div class="option_row_explain">'.__('Starting Point Longitude','wpestate').'</div>    
    <input  type="text" id="general_longitude" name="general_longitude"  value="'.$general_longitude.'"/>
    </div>'; 
       
    $default_map_zoom               =   intval   ( get_option('wp_estate_default_map_zoom','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Default Map zoom (1 to 20)','wpestate').'</div>
    <div class="option_row_explain">'.__('Default Map zoom (1 to 20)','wpestate').'</div>    
    <input type="text" id="default_map_zoom" name="default_map_zoom" value="'.$default_map_zoom.'">   
    </div>'; 
    
    $map_types = array('SATELLITE','HYBRID','TERRAIN','ROADMAP');
    $default_map_type_symbol               =   wpestate_dropdowns_theme_admin($map_types,'default_map_type');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Map Type','wpestate').'</div>
    <div class="option_row_explain">'.__('Map Type','wpestate').'</div>    
        <select id="default_map_type" name="default_map_type">
            '.$default_map_type_symbol.'
        </select> 
    </div>'; 
        
    $cache_symbol                   =   wpestate_dropdowns_theme_admin($cache_array,'cache');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Cache for Google maps ?(*cache will renew it self every 3h)','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Cache for Google maps ?(*cache will renew it self every 3h)','wpestate').'</div>    
        <select id="cache" name="cache">
            '.$cache_symbol.'
        </select>
    </div>'; 

    $pin_cluster_symbol             =   wpestate_dropdowns_theme_admin($cache_array,'pin_cluster');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Pin Cluster on map','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Pin Cluster on map','wpestate').'</div>    
        <select id="pin_cluster" name="pin_cluster">
            '.$pin_cluster_symbol.'
        </select>
    </div>'; 
       
    $zoom_cluster                   =   esc_html ( get_option('wp_estate_zoom_cluster ','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Maximum zoom level for Cloud Cluster to appear','wpestate').'</div>
    <div class="option_row_explain">'.__('Maximum zoom level for Cloud Cluster to appear','wpestate').'</div>    
        <input id="zoom_cluster" type="text" size="36" name="zoom_cluster" value="'.$zoom_cluster.'" />
    </div>'; 
    
    $hq_latitude                    =   esc_html ( get_option('wp_estate_hq_latitude') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Contact Page - Company HQ Latitude','wpestate').'</div>
    <div class="option_row_explain">'.__('Contact Page - Company HQ Latitude','wpestate').'</div>    
        <input  type="text" id="hq_latitude"  name="hq_latitude"   value="'.$hq_latitude.'"/>
    </div>'; 
        
    $hq_longitude                   =   esc_html ( get_option('wp_estate_hq_longitude') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Contact Page - Company HQ Longitude','wpestate').'</div>
    <div class="option_row_explain">'.__('Contact Page - Company HQ Longitude','wpestate').'</div>    
        <input  type="text" id="hq_longitude" name="hq_longitude"  value="'.$hq_longitude.'"/>
    </div>';   
        
    
    $idx_symbol             =   wpestate_dropdowns_theme_admin($cache_array,'idx_enable');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable dsIDXpress to use the map','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable dsIDXpress to use the map','wpestate').'</div>    
        <select id="idx_enable" name="idx_enable">
            '.$idx_symbol.'
        </select>
    </div>';     
    
    
    $geolocation_radius         =   esc_html ( get_option('wp_estate_geolocation_radius','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Geolocation Circle over map (in meters)','wpestate').'</div>
    <div class="option_row_explain">'.__('Geolocation Circle over map (in meters)','wpestate').'</div>    
       <input id="geolocation_radius" type="text" size="36" name="geolocation_radius" value="'.$geolocation_radius.'" />
    </div>'; 
       
    $min_height                     =   intval   ( get_option('wp_estate_min_height','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Height of the Google Map when closed','wpestate').'</div>
    <div class="option_row_explain">'.__('Height of the Google Map when closed','wpestate').'</div>    
       <input id="min_height" type="text" size="36" name="min_height" value="'.$min_height.'" />
    </div>';  
      
    $max_height                     =   intval   ( get_option('wp_estate_max_height','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Height of Google Map when open','wpestate').'</div>
    <div class="option_row_explain">'.__('Height of Google Map when open','wpestate').'</div>    
       <input id="max_height" type="text" size="36" name="max_height" value="'.$max_height.'" />
    </div>'; 
      
    $keep_min_symbol                    =   wpestate_dropdowns_theme_admin($cache_array2,'keep_min');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Force Google Map at the "closed" size ? ','wpestate').'</div>
    <div class="option_row_explain">'.__('Force Google Map at the "closed" size ?','wpestate').'</div>    
        <select id="keep_min" name="keep_min">
            '.$keep_min_symbol.'
        </select>
    </div>'; 
     
    
    $show_g_search_symbol               =   wpestate_dropdowns_theme_admin($cache_array2,'show_g_search');

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Google Search over Map?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Google Search over Map?','wpestate').'</div>    
        <select id="show_g_search" name="show_g_search">
            '.$show_g_search_symbol.'
        </select>
    </div>'; 
     
    $map_style  =   esc_html ( get_option('wp_estate_map_style','') );    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Style for Google Map. Use https://snazzymaps.com/ to create styles','wpestate').'</div>
    <div class="option_row_explain">'.__('Style for Google Map. Use https://snazzymaps.com/ to create styles ','wpestate').'</div>    
        <textarea id="map_style" style="width:100%;height:350px;" name="map_style">'.stripslashes($map_style).'</textarea>
    </div>'; 


       
        
  
        

}   







    
        
function new_wpestate_custom_colors(){
    $menu_items_color               =  esc_html ( get_option('wp_estate_menu_items_color','') );
    $agent_color                    =  esc_html ( get_option('wp_estate_agent_color','') );
    $color_scheme_array=array('no','yes');
    $color_scheme_select   = wpestate_dropdowns_theme_admin($color_scheme_array,'color_scheme');
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Custom Colors ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Custom Colors ?','wpestate').'</div>    
        <select id="color_scheme" name="color_scheme">
            '.$color_scheme_select.'
         </select>
    </div>'; 
       
    $main_color                     =  esc_html ( get_option('wp_estate_main_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Main Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Main Color','wpestate').'</div>    
        <input type="text" name="main_color" maxlength="7" class="inptxt " value="'.$main_color.'"/>
        <div id="main_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$main_color.';"  ></div></div>
    </div>';   
    
    $background_color               =  esc_html ( get_option('wp_estate_background_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Background Color','wpestate').'</div>    
        <input type="text" name="background_color" maxlength="7" class="inptxt " value="'.$background_color.'"/>
        <div id="background_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$background_color.';"  ></div></div>
    </div>'; 

    $content_back_color             =  esc_html ( get_option('wp_estate_content_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Content Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Content Background Color','wpestate').'</div>    
        <input type="text" name="content_back_color" value="'.$content_back_color.'" maxlength="7" class="inptxt" />
        <div id="content_back_color" class="colorpickerHolder" ><div class="sqcolor"  style="background-color:#'.$content_back_color.';" ></div></div>
    </div>'; 
        
    $breadcrumbs_font_color         =  esc_html ( get_option('wp_estate_breadcrumbs_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Breadcrumbs, Meta and Second Line Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Breadcrumbs, Meta and Second Line Font Color','wpestate').'</div>    
        <input type="text" name="breadcrumbs_font_color" value="'.$breadcrumbs_font_color.'" maxlength="7" class="inptxt" />
        <div id="breadcrumbs_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$breadcrumbs_font_color.';" ></div></div>
    </div>';  
    
    
    $font_color                     =  esc_html ( get_option('wp_estate_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Font Color','wpestate').'</div>    
        <input type="text" name="font_color" value="'.$font_color.'" maxlength="7" class="inptxt" />
        <div id="font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$font_color.';" ></div></div>
    </div>';
       
    $link_color                     =  esc_html ( get_option('wp_estate_link_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Link Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Link Color','wpestate').'</div>    
        <input type="text" name="link_color" value="'.$link_color.'" maxlength="7" class="inptxt" />
        <div id="link_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$link_color.';" ></div></div>
    </div>';
  
    $headings_color                 =  esc_html ( get_option('wp_estate_headings_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Headings Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Headings Color','wpestate').'</div>    
        <input type="text" name="headings_color" value="'.$headings_color.'" maxlength="7" class="inptxt" />
        <div id="headings_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$headings_color.';" ></div></div>
    </div>';
        
        
    $footer_back_color              =  esc_html ( get_option('wp_estate_footer_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Footer Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Footer Background Color','wpestate').'</div>    
        <input type="text" name="footer_back_color" value="'.$footer_back_color.'" maxlength="7" class="inptxt" />
        <div id="footer_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_back_color.';" ></div></div>
    </div>';
        
    $footer_font_color              =  esc_html ( get_option('wp_estate_footer_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Footer Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Footer Font Color','wpestate').'</div>    
        <input type="text" name="footer_font_color" value="'.$footer_font_color.'" maxlength="7" class="inptxt" />
        <div id="footer_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_font_color.';" ></div></div>
    </div>';
        
    $footer_copy_color              =  esc_html ( get_option('wp_estate_footer_copy_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Footer Copyright Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Footer Copyright Font Color','wpestate').'</div>    
        <input type="text" name="footer_copy_color" value="'.$footer_copy_color.'" maxlength="7" class="inptxt" />
        <div id="footer_copy_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_copy_color.';" ></div></div>
    </div>';
        
    $sidebar_widget_color           =  esc_html ( get_option('wp_estate_sidebar_widget_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Sidebar Widget Background Color( for "boxed" widgets)','wpestate').'</div>
    <div class="option_row_explain">'.__('Sidebar Widget Background Color( for "boxed" widgets)','wpestate').'</div>    
        <input type="text" name="sidebar_widget_color" value="'.$sidebar_widget_color.'" maxlength="7" class="inptxt" />
        <div id="sidebar_widget_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$sidebar_widget_color.';" ></div></div>
    </div>';
          
        
    $sidebar_heading_boxed_color    =  esc_html ( get_option('wp_estate_sidebar_heading_boxed_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Sidebar Heading Color (boxed widgets)','wpestate').'</div>
    <div class="option_row_explain">'.__('Sidebar Heading Color (boxed widgets)','wpestate').'</div>    
        <input type="text" name="sidebar_heading_boxed_color" value="'.$sidebar_heading_boxed_color.'" maxlength="7" class="inptxt" />
        <div id="sidebar_heading_boxed_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_boxed_color.';"></div></div>
    </div>';
         
    $sidebar_heading_color          =  esc_html ( get_option('wp_estate_sidebar_heading_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Sidebar Heading Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Sidebar Heading Color','wpestate').'</div>    
        <input type="text" name="sidebar_heading_color" value="'.$sidebar_heading_color.'" maxlength="7" class="inptxt" />
        <div id="sidebar_heading_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_color.';"></div></div>
    </div>';
        
    $sidebar2_font_color            =  esc_html ( get_option('wp_estate_sidebar2_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Sidebar Font color','wpestate').'</div>
    <div class="option_row_explain">'.__('Sidebar Font color','wpestate').'</div>    
        <input type="text" name="sidebar2_font_color" value="'.$sidebar2_font_color.'" maxlength="7" class="inptxt" />
        <div id="sidebar2_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar2_font_color.';"></div></div>
    </div>';
          
      
    $header_color                   =  esc_html ( get_option('wp_estate_header_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Header Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Header Background Color','wpestate').'</div>    
        <input type="text" name="header_color" value="'.$header_color.'" maxlength="7" class="inptxt" />
        <div id="header_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$header_color.';" ></div></div>
    </div>';
        
    $menu_font_color                =  esc_html ( get_option('wp_estate_menu_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Top Menu Font Color','wpestate').'</div>    
        <input type="text" name="menu_font_color" value="'.$menu_font_color.'"  maxlength="7" class="inptxt" />
        <div id="menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_font_color.';" ></div></div>
    </div>';
        
    $menu_hover_back_color          =  esc_html ( get_option('wp_estate_menu_hover_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu hover back color','wpestate').'</div>
    <div class="option_row_explain">'.__('Top Menu hover back color','wpestate').'</div>    
       <input type="text" name="menu_hover_back_color" value="'.$menu_hover_back_color.'"  maxlength="7" class="inptxt" />
        <div id="menu_hover_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_back_color.';"></div></div>
    </div>';
    
    $menu_hover_font_color          =  esc_html ( get_option('wp_estate_menu_hover_font_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Menu hover font color','wpestate').'</div>
    <div class="option_row_explain">'.__('Top Menu hover font color','wpestate').'</div>    
        <input type="text" name="menu_hover_font_color" value="'.$menu_hover_font_color.'" maxlength="7" class="inptxt" />
        <div id="menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_font_color.';" ></div></div>
    </div>';
        
    $top_bar_back                   =  esc_html ( get_option('wp_estate_top_bar_back','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Bar Background Color (Header Widget Menu)','wpestate').'</div>
    <div class="option_row_explain">'.__('Top Bar Background Color (Header Widget Menu)','wpestate').'</div>    
        <input type="text" name="top_bar_back" value="'.$top_bar_back.'" maxlength="7" class="inptxt" />
        <div id="top_bar_back" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_back.';"></div></div>
    </div>';
     
    $top_bar_font                   =  esc_html ( get_option('wp_estate_top_bar_font','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Top Bar Font Color (Header Widget Menu)','wpestate').'</div>
    <div class="option_row_explain">'.__('Top Bar Font Color (Header Widget Menu)','wpestate').'</div>    
        <input type="text" name="top_bar_font" value="'.$top_bar_font.'" maxlength="7" class="inptxt" />
        <div id="top_bar_font" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_font.';"></div></div>
    </div>';
          
    $adv_search_back_color          =  esc_html ( get_option('wp_estate_adv_search_back_color ','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Map Advanced Search Button Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Map Advanced Search Button Background Color','wpestate').'</div>    
        <input type="text" name="adv_search_back_color" value="'.$adv_search_back_color.'" maxlength="7" class="inptxt" />
        <div id="adv_search_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_back_color.';"></div></div>
    </div>';
        
    $adv_search_font_color          =  esc_html ( get_option('wp_estate_adv_search_font_color','') );  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Font Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Advanced Search Font Color','wpestate').'</div>    
        <input type="text" name="adv_search_font_color" value="'.$adv_search_font_color.'" maxlength="7" class="inptxt" />
        <div id="adv_search_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_font_color.';"></div></div>
    </div>';
        
    $box_content_back_color         =  esc_html ( get_option('wp_estate_box_content_back_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Boxed Content Background Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Boxed Content Background Color','wpestate').'</div>    
        <input type="text" name="box_content_back_color" value="'.$box_content_back_color.'" maxlength="7" class="inptxt" />
        <div id="box_content_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_back_color.';"></div></div>
    </div>';
        
    $box_content_border_color       =  esc_html ( get_option('wp_estate_box_content_border_color','') );
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Border Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Border Color','wpestate').'</div>    
        <input type="text" name="box_content_border_color" value="'.$box_content_border_color.'" maxlength="7" class="inptxt" />
        <div id="box_content_border_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_border_color.';"></div></div>
    </div>';
       
    $hover_button_color             =  esc_html ( get_option('wp_estate_hover_button_color','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Hover Button Color','wpestate').'</div>
    <div class="option_row_explain">'.__('Hover Button Color','wpestate').'</div>    
        <input type="text" name="hover_button_color" value="'.$hover_button_color.'" maxlength="7" class="inptxt" />
        <div id="hover_button_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$hover_button_color.';"></div></div>
    </div>';
     
       
    $custom_css                     =  esc_html ( stripslashes( get_option('wp_estate_custom_css','') ) );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Custom Css','wpestate').'</div>
    <div class="option_row_explain">'.__('Custom Css','wpestate').'</div>    
        <textarea cols="57" rows="5" name="custom_css" id="custom_css">'.$custom_css.'</textarea>
    </div>';
        

     
}


function new_wpestate_membership_settings(){
    $free_mem_list                  =   esc_html( get_option('wp_estate_free_mem_list','') );
    $cache_array                    =   array('yes','no');  
   

    $admin_submission_symbol        =   wpestate_dropdowns_theme_admin($cache_array,'admin_submission');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Submited Listings should be approved by admin?','wpestate').'</div>
    <div class="option_row_explain">'.__('Submited Listings should be approved by admin?','wpestate').'</div>    
        <select id="admin_submission" name="admin_submission">
            '.$admin_submission_symbol.'
        </select>
    </div>';
  
    $user_agent_symbol              =   wpestate_dropdowns_theme_admin($cache_array,'user_agent');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Front end registred users should be saved as agents?','wpestate').'</div>
    <div class="option_row_explain">'.__('Front end registred users should be saved as agents?','wpestate').'</div>    
        <select id="user_agent" name="user_agent">
            '.$user_agent_symbol.'
        </select>
    </div>';
    
    $paypal_array                   =   array('no','per listing','membership');
    $paid_submission_symbol         =   wpestate_dropdowns_theme_admin($paypal_array,'paid_submission');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable Paid Submission ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable Paid Submission ?','wpestate').'</div>    
        <select id="paid_submission" name="paid_submission">
            '.$paid_submission_symbol.'
        </select>
    </div>';

    $enable_paypal_symbol           =   wpestate_dropdowns_theme_admin($cache_array,'enable_paypal');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable Paypal?','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable Paypal?','wpestate').'</div>    
        <select id="enable_paypal" name="enable_paypal">
            '.$enable_paypal_symbol.'
        </select>
    </div>';
   
    
    $enable_stripe_symbol           =   wpestate_dropdowns_theme_admin($cache_array,'enable_stripe');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable Stripe?','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable Stripe?','wpestate').'</div>    
        <select id="enable_stripe" name="enable_stripe">
            '.$enable_stripe_symbol.'
        </select>
    </div>';

    $enable_direct_pay_symbol       =   wpestate_dropdowns_theme_admin($cache_array,'enable_direct_pay');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Enable Direct Payment / Wire Payment?','wpestate').'</div>
    <div class="option_row_explain">'.__('Enable Direct Payment / Wire Payment?','wpestate').'</div>    
        <select id="enable_direct_pay" name="enable_direct_pay">
            '.$enable_direct_pay_symbol.'
        </select>
    </div>'; 
        
       
    $submission_curency_array       =   array(get_option('wp_estate_submission_curency_custom',''),'USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','ILS','INR','JPY','MYR','MXN','NOK','NZD','PHP','PLN','GBP','SGD','SEK','CHF','TWD','THB','TRY');
    $submission_curency_symbol      =   wpestate_dropdowns_theme_admin($submission_curency_array,'submission_curency');
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Currency For Paid Submission','wpestate').'</div>
    <div class="option_row_explain">'.__('Currency For Paid Submission','wpestate').'</div>    
        <select id="submission_curency" name="submission_curency">
            '.$submission_curency_symbol.'
        </select> 
    </div>'; 
       
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Custom Currency Symbol - *select it from the list above after you add it.','wpestate').'</div>
    <div class="option_row_explain">'.__('Custom Currency Symbol - *select it from the list above after you add it.','wpestate').'</div>    
        <input type="text" id="submission_curency_custom" name="submission_curency_custom" class="regular-text"  value="'.get_option('wp_estate_submission_curency_custom','').'"/>
    </div>'; 
      
    $paypal_client_id               =   esc_html( get_option('wp_estate_paypal_client_id','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal Client id','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal Client id','wpestate').'</div>    
        <input  type="text" id="paypal_client_id" name="paypal_client_id" class="regular-text"  value="'.$paypal_client_id.'"/>
    </div>'; 
     
    $paypal_client_secret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal Client Secret Key','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal Client Secret Key','wpestate').'</div>    
        <input  type="text" id="paypal_client_secret" name="paypal_client_secret"  class="regular-text" value="'.$paypal_client_secret.'"/> 
    </div>'; 
      
    $paypal_array                   =   array( 'sandbox','live' );
    $paypal_api_select              =   wpestate_dropdowns_theme_admin($paypal_array,'paypal_api');  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal & Stripe Api ','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal & Stripe Api ','wpestate').'</div>    
        <select id="paypal_api" name="paypal_api">
            '.$paypal_api_select.'
        </select>
    </div>'; 
      
    $paypal_api_username            =   esc_html( get_option('wp_estate_paypal_api_username','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal Api User Name','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal Api User Name','wpestate').'</div>    
       <input  type="text" id="paypal_api_username" name="paypal_api_username"  class="regular-text" value="'.$paypal_api_username.'"/>
    </div>'; 
    
    $paypal_api_password            =   esc_html( get_option('wp_estate_paypal_api_password','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal API Password','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal API Password','wpestate').'</div>    
       <input  type="text" id="paypal_api_password" name="paypal_api_password"  class="regular-text" value="'.$paypal_api_password.'"/>
    </div>'; 
        
    $paypal_api_signature           =   esc_html( get_option('wp_estate_paypal_api_signature','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal API Signature','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal API Signature','wpestate').'</div>    
       <input  type="text" id="paypal_api_signature" name="paypal_api_signature"  class="regular-text" value="'.$paypal_api_signature.'"/>
    </div>';
        
    $paypal_rec_email               =   esc_html( get_option('wp_estate_paypal_rec_email','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Paypal receiving email','wpestate').'</div>
    <div class="option_row_explain">'.__('Paypal receiving email','wpestate').'</div>    
       <input  type="text" id="paypal_rec_email" name="paypal_rec_email"  class="regular-text" value="'.$paypal_rec_email.'"/>
    </div>';
      
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Stripe Secret Key','wpestate').'</div>
    <div class="option_row_explain">'.__('Stripe Secret Key','wpestate').'</div>    
       <input  type="text" id="stripe_secret_key" name="stripe_secret_key"  class="regular-text" value="'.$stripe_secret_key.'"/> 
    </div>';
        
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Stripe Publishable Key','wpestate').'</div>
    <div class="option_row_explain">'.__('Stripe Publishable Key','wpestate').'</div>    
       <input  type="text" id="stripe_publishable_key" name="stripe_publishable_key" class="regular-text" value="'.$stripe_publishable_key.'"/>
    </div>';
    
    
    $args=array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'br' => array(),
        'em' => array(),
        'strong' => array(),
    );
    $direct_payment_details         =   wp_kses( get_option('wp_estate_direct_payment_details','') ,$args);
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Wire instructions for direct payment','wpestate').'</div>
    <div class="option_row_explain">'.__('Wire instructions for direct payment','wpestate').'</div>    
        <textarea id="direct_payment_details" name="direct_payment_details"  style="width:325px;" class="regular-text" >'.$direct_payment_details.'</textarea> 
    </div>';   
    
    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );   
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Price Per Submission (for "per listing" mode)','wpestate').'</div>
    <div class="option_row_explain">'.__('Price Per Submission (for "per listing" mode)','wpestate').'</div>    
       <input  type="text" id="price_submission" name="price_submission"  value="'.$price_submission.'"/> 
    </div>'; 
      
    
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') ); 
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Price to make the listing featured (for "per listing" mode)','wpestate').'</div>
    <div class="option_row_explain">'.__('Price to make the listing featured (for "per listing" mode)','wpestate').'</div>    
       <input  type="text" id="price_featured_submission" name="price_featured_submission"  value="'.$price_featured_submission.'"/>
    </div>'; 
       
    
    $free_mem_list_unl='';
    if ( intval( get_option('wp_estate_free_mem_list_unl', '' ) ) == 1){
        $free_mem_list_unl=' checked="checked" ';  
    }
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Free Membership - no of listings (for "membership" mode)','wpestate').'</div>
    <div class="option_row_explain">'.__('Free Membership - no of listings (for "membership" mode)','wpestate').'</div>    
        <input  type="text" id="free_mem_list" name="free_mem_list" style="margin-right:20px;"  value="'.$free_mem_list.'"/> 
        <input type="hidden" name="free_mem_list_unl" value="">
        <input type="checkbox"  id="free_mem_list_unl" name="free_mem_list_unl" value="1" '.$free_mem_list_unl.' />
    </div>'; 
     
    $free_feat_list                 =   esc_html( get_option('wp_estate_free_feat_list','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Free Membership - no of featured listings (for "membership" mode)','wpestate').'</div>
    <div class="option_row_explain">'.__('Free Membership - no of featured listings (for "membership" mode)','wpestate').'</div>    
         <input  type="text" id="free_feat_list" name="free_feat_list" style="margin-right:20px;"    value="'.$free_feat_list.'"/>
    </div>';
        
    $free_feat_list_expiration= intval ( get_option('wp_estate_free_feat_list_expiration','') );
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Free Membership Listings - no of days until a free listing will expire. *Starts from the moment the property is published on the website. (for "membership" mode) ','wpestate').'</div>
    <div class="option_row_explain">'.__('Free Membership Listings - no of days until a free listing will expire. *Starts from the moment the property is published on the website. (for "membership" mode) ','wpestate').'</div>    
        <input  type="text" id="free_feat_list_expiration" name="free_feat_list_expiration" style="margin-right:20px;"    value="'.$free_feat_list_expiration.'"/>
    </div>';
  
     
}    



function new_wpestate_pin_management(){  
    $pins       =   array();
    $taxonomy   =   'property_action_category';
    $tax_terms  =   get_terms($taxonomy,'hide_empty=0');

    $taxonomy_cat = 'property_category';
    $categories = get_terms($taxonomy_cat,'hide_empty=0');

    // add only actions
    foreach ($tax_terms as $tax_term) {
        $name                    =  sanitize_key ( wpestate_limit64('wp_estate_'.$tax_term->slug) );
        $limit54                 =  sanitize_key ( wpestate_limit54($tax_term->slug) );
        $pins[$limit54]          =  esc_html( get_option($name) );  
    } 

    // add only categories
    foreach ($categories as $categ) {
        $name                           =   sanitize_key( wpestate_limit64('wp_estate_'.$categ->slug));
        $limit54                        =   sanitize_key(wpestate_limit54($categ->slug));
        $pins[$limit54]                 =   esc_html( get_option($name) );
    }
    
    // add combinations
    foreach ($tax_terms as $tax_term) {
        foreach ($categories as $categ) {
            $limit54            =   sanitize_key ( wpestate_limit27($categ->slug).wpestate_limit27($tax_term->slug) );
            $name               =   'wp_estate_'.$limit54;
            $pins[$limit54]     =   esc_html( get_option($name) ) ;        
        }
    }

  
    $name='wp_estate_idxpin';
    $pins['idxpin']=esc_html( get_option($name) );  

    $name='wp_estate_userpin';
    $pins['userpin']=esc_html( get_option($name) );  
   
    $taxonomy = 'property_action_category';
    $tax_terms = get_terms($taxonomy,'hide_empty=0');

    $taxonomy_cat = 'property_category';
    $categories = get_terms($taxonomy_cat,'hide_empty=0');

    print'<p class="admin-exp">'.__('Add new Google Maps pins for single actions / single categories.','wpestate').'</p>';
    print '<p class="admin-exp" >'.__('If you add images directly into the input fields (without Upload button) please use the full image path. For ex: http://www.wpresidence..... . If you use the "upload"  button use also "Insert into Post" button from the pop up window.','wpestate');

    foreach ($tax_terms as $tax_term) { 
            $limit54   =  $post_name  =   sanitize_key(wpestate_limit54($tax_term->slug));
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('For action ','wpestate').'<strong>'.$tax_term->name.' </strong></div>
            <div class="option_row_explain">'.__('For action ','wpestate').'<strong>'.$tax_term->name.' </strong></div>    
                <input type="text"    class="pin-upload-form" size="36" name="'.$post_name.'" value="'.$pins[$limit54].'" />
                <input type="button"  class="upload_button button pin-upload" value="'.__('Upload Pin','wpestate').'" />
            </div>';
            
               
    }
     
    
    foreach ($categories as $categ) {  
            $limit54   =   $post_name  =   sanitize_key(wpestate_limit54($categ->slug));
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('For category: ','wpestate').'<strong>'.$categ->name.' </strong>  </div>
            <div class="option_row_explain">'.__('For category: ','wpestate').'<strong>'.$categ->name.' </strong></div>    
                <input type="text"    class="pin-upload-form" size="36" name="'.$post_name.'" value="'.$pins[$limit54].'" />
                <input type="button"  class="upload_button button pin-upload" value="'.__('Upload Pin','wpestate').'"  />
            </div>';
                 
    }
    
    
    print '<p class="admin-exp">'.__('Add new Google Maps pins for actions & categories combined (example: \'apartments in sales\')','wpestate').'</p>';  
      
    foreach ($tax_terms as $tax_term) {
    
        foreach ($categories as $categ) {
            $limit54=sanitize_key(wpestate_limit27($categ->slug)).sanitize_key( wpestate_limit27($tax_term->slug) );
            
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('For action','wpestate').' <strong>'.$tax_term->name.'</strong>, '.__('category','wpestate').': <strong>'.$categ->name.'</strong>   </div>
            <div class="option_row_explain">'.__('For action','wpestate').' <strong>'.$tax_term->name.'</strong>, '.__('category','wpestate').': <strong>'.$categ->name.'</strong>  </div>    
                <input id="'.$limit54.'" type="text" size="36" name="'. $limit54.'" value="'.$pins[$limit54].'" />
                <input type="button"  class="upload_button button pin-upload" value="'.__('Upload Pin','wpestate').'" />
            </div>';
                
        }
    }


    print'<div class="estate_option_row">
            <div class="label_option_row">'.__('For IDX (if plugin is enabled) ','wpestate').'</div>
            <div class="option_row_explain">'.__('For IDX (if plugin is enabled) ','wpestate').'</div>    
                <input id="idxpin" type="text" size="36" name="idxpin" value="'.$pins['idxpin'].'" />
                <input type="button"  class="upload_button button pin-upload" value="'.__('Upload Pin','wpestate').'" />
            </div>';
    
    
     print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Userpin in geolocation','wpestate').'</div>
            <div class="option_row_explain">'.__('Userpin in geolocation','wpestate').'</div>    
                <input id="userpin" type="text" size="36" name="userpin" value="'.$pins['userpin'].'" />
                <input type="button"  class="upload_button button pin-upload" value="'.__('Upload Pin','wpestate').'" />
            </div>';
}


 function new_wpestate_advanced_search_settings(){
    $cache_array                    =   array('yes','no');
    
    $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    
    
    
    $value_array=array('no','yes');
    $custom_advanced_search_select = wpestate_dropdowns_theme_admin($value_array,'custom_advanced_search');
    
    $search_array = array (1,2,3);
    $show_adv_search_type= wpestate_dropdowns_theme_admin($search_array,'adv_search_type',__('Type','wpestate').' ');
    
    
    $show_adv_search_general_select     = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_general');
    $show_adv_search_slider_select      = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_slider');
    $show_adv_search_visible_select     = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_visible');
    $show_adv_search_extended_select    = wpestate_dropdowns_theme_admin($cache_array,'show_adv_search_extended');
    $show_save_search_select            = wpestate_dropdowns_theme_admin($cache_array,'show_save_search');
    $show_slider_price_select           = wpestate_dropdowns_theme_admin($cache_array,'show_slider_price');
    $show_dropdowns_select              = wpestate_dropdowns_theme_admin($cache_array,'show_dropdowns');
    
    
    
    
    $period_array   =array( 0 =>__('daily','wpestate'),
                            1 =>__('weekly','wpestate') 
                            );
    
    $search_alert_select = wpestate_dropdowns_theme_admin_with_key($period_array,'search_alert');
    
 
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Advanced Search Type ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Advanced Search Type ?','wpestate').'</div>    
        <select id="adv_search_type" name="adv_search_type">
                    '.$show_adv_search_type.'
                </select> 
    </div>';
     
     
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Saved Search Feature ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Saved Search Feature ?','wpestate').'</div>    
        <select id="show_save_search" name="show_save_search">
            '.$show_save_search_select.'
        </select> 
    </div>';


    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Send emails','wpestate').'</div>
    <div class="option_row_explain">'.__('Send emails','wpestate').'</div>    
        <select id="search_alert" name="search_alert">
            '.$search_alert_select.'
        </select>
    </div>';
       
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Use Custom Fields For Advanced Search ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Use Custom Fields For Advanced Search ?','wpestate').'</div>    
        <select id="custom_advanced_search" name="custom_advanced_search">
            '.$custom_advanced_search_select.'
        </select> 
    </div>';
        
     
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Advanced Search ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Advanced Search ?','wpestate').'</div>    
        <select id="show_adv_search_general" name="show_adv_search_general">
            '.$show_adv_search_general_select.'
        </select>
    </div>';    
     
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Advanced Search over sliders or images ?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Advanced Search over sliders or images ?','wpestate').'</div>    
        <select id="show_adv_search_slider" name="show_adv_search_slider">
            '.$show_adv_search_slider_select.'
        </select>
    </div>';  
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Keep Advanced Search visible?','wpestate').'</div>
    <div class="option_row_explain">'.__('Keep Advanced Search visible?','wpestate').'</div>    
        <select id="show_adv_search_visible" name="show_adv_search_visible">
            '.$show_adv_search_visible_select.'
        </select>
    </div>';
     
     
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Amenities and Features fields?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Amenities and Features fields?','wpestate').' / '.__('*for speed reasons, the "features checkboxes" will not filter the pins on the map','wpestate').'</div>    
        <select id="show_adv_search_extended" name="show_adv_search_extended">
            '.$show_adv_search_extended_select.'
        </select>
    </div>';
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Slider for Price?','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Slider for Price?','wpestate').'</div>    
        <select id="show_slider_price" name="show_slider_price">
            '.$show_slider_price_select.'
        </select>
    </div>';
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show Dropdowns for beds, bathrooms or rooms?(*only works with Custom Fields - YES)','wpestate').'</div>
    <div class="option_row_explain">'.__('Show Dropdowns for beds, bathrooms or rooms?(*only works with Custom Fields - YES)','wpestate').'</div>    
        <select id="show_dropdowns" name="show_dropdowns">
            '.$show_dropdowns_select.'
        </select>
    </div>';
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Minimum and Maximum value for Price Slider','wpestate').'</div>
    <div class="option_row_explain">'.__('Minimum and Maximum value for Price Slider','wpestate').'</div>    
        <input type="text" name="show_slider_min_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_min_price','')).'"/>
        -   
        <input type="text" name="show_slider_max_price"  class="inptxt " value="'.floatval(get_option('wp_estate_show_slider_max_price','')).'"/>
    </div>';
        


    print '<h1 class="wpestate-tabh1">'.__('Custom Fields for Advanced Search','wpestate').'</h1>'; 
    print'    <table class="form-table">
       
         <tr valign="top">
            <th scope="row"></th>
            <td>
            </td>
             <td>  
            </td>
         </tr>
         <tr valign="top">
            <th scope="row"><label for="admin_submission"><strong>'.__('Place in advanced search form','wpestate').'</strong></label></th>          
            <td><strong>'.__('Search field','wpestate').'</strong></td>
            <td><strong>'.__('How it will compare','wpestate').'</strong></td>
            <td><strong>'.__('Label on Front end','wpestate').'</strong></td>
        </tr>'; 
        
    $i=0;
    while( $i < 8 ){
       $i++;
      
       print '
       <tr valign="top">
            <th scope="row"><label for="admin_submission">'.__('Spot no ','wpestate').$i.'</label></th>
           
            <td><select id="adv_search_what'.$i.'" name="adv_search_what[]">';
                print   wpestate_show_advanced_search_options($i-1,$adv_search_what);
	print'	</select>
            </td>
            <td><select id="adv_search_how'.$i.'" name="adv_search_how[]">';
                 print  wpestate_show_advanced_search_how($i-1,$adv_search_how);
        
        $new_val=''; 
        if( isset($adv_search_label[$i-1]) ){
            $new_val=$adv_search_label[$i-1]; 
        }
         
        
        print '	</select>
            </td>
            <td>
                <input type="text" id="adv_search_label'.$i.'" name="adv_search_label[]" value="'.$new_val.'">
            </td>
        </tr>';
    }
 
        
        
        print' </table>
       
        <p style="margin-left:10px;">
         '.__('*Do not duplicate labels and make sure search fields do not contradict themselves','wpestate').'</br>
        '.__('*Labels will not apply for taxonomy dropdowns fields','wpestate').'</br>
      
        </p>';
        
        print '<h1 class="wpestate-tabh1">'.__('Amenities and Features for Advanced Search','wpestate').'</h1>'; 
        $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
        $feature_list_array =   explode( ',',$feature_list);
       
        $advanced_exteded =  get_option('wp_estate_advanced_exteded');
        
        print ' <p style="margin-left:10px;">  '.__('*Hold CTRL for multiple selection','wpestate').'</p>'
        . '<input type="hidden" name="advanced_exteded[]" value="none">'
        . '<p style="margin-left:10px;"> <select name="advanced_exteded[]" multiple="multiple" style="height:400px;">';
        foreach($feature_list_array as $checker => $value){
            $post_var_name  =   str_replace(' ','_', trim($value) );
            print '<option value="'.$post_var_name.'"' ;
            if(is_array($advanced_exteded)){
                if( in_array ($post_var_name,$advanced_exteded) ){
                    print ' selected="selected" ';
                } 
            }
            
            print '>'.$value.'</option>';                
        }
        print '</select></p>';
 } 
        
 
 
 
 
function new_wpestate_custom_fields(){
   
    $custom_fields = get_option( 'wp_estate_custom_fields', true);     
    $current_fields='';

    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $current_fields.='
                <div class=field_row>
                <div    class="field_item"><strong>'.__('Field Name','wpestate').'</strong></br><input  type="text" name="add_field_name[]"   value="'.$custom_fields[$i][0].'"  ></div>
                <div    class="field_item"><strong>'.__('Field Label','wpestate').'</strong></br><input  type="text" name="add_field_label[]"   value="'.$custom_fields[$i][1].'"  ></div>
                <div    class="field_item"><strong>'.__('Field Type','wpestate').'</strong></br>'.wpestate_fields_type_select($custom_fields[$i][2]).'</div>
                <div    class="field_item"><strong>'.__('Field Order','wpestate').'</strong></br><input  type="text" name="add_field_order[]" value="'.$custom_fields[$i][3].'"></div>     
                <div    class="field_item newfield"><strong>'.__('Dropdown values','wpestate').'</strong></br><textarea name="add_dropdown_order[]">'.$custom_fields[$i][4].'</textarea></div>     
             
                <a class="deletefieldlink" href="#">'.__('delete','wpestate').'</a>
            </div>';    
            $i++;
        }
    }
 

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Custom Fields list','wpestate').'</div>
    <div class="option_row_explain">'.__('List of already added custom fields','wpestate').'</div>    
        <div id="custom_fields">
        '.$current_fields.'
        <input type="hidden" name="is_custom" value="1">   
        </div>
    </div>';
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Add New Custom Field','wpestate').'</div>
    <div class="option_row_explain">'.__('Fill the form in order to add a new custom field','wpestate').'</div>  
     
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <tr valign="top">
                        <th scope="row">'.__('Field name','wpestate').'</th>
                        <td>
                            <input  type="text" id="field_name"  name="field_name"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Field Label','wpestate').'</th>
                        <td>
                            <input  type="text" id="field_label"  name="field_label"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Field Type','wpestate').'</th>
                        <td>
                            <select id="field_type" name="field_type"  style="width:310px;">
                                <option value="short text"> short text  </option>
                                <option value="long text">  long text   </option>
                                <option value="numeric">    numeric     </option>
                                <option value="date">       date        </option>
                                 <option value="dropdown">       dropdown        </option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__(' Order in listing page','wpestate').'</th>
                        <td>
                             <input  type="text" id="field_order"  name="field_order"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Dropdown values separated by "," (only for dropdown field type)','wpestate').'</th>
                        <td>
                            <textarea id="drodown_values"  name="drodown_values"  ></textarea>
                        </td>
                    </tr>   
            </tbody>
        </table>   
        
       <a href="#" id="add_field">'.__(' click to add field','wpestate').'</a><br>
  </div>'; 
       

}




function new_wpestate_ammenities_features(){
    $feature_list                           =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list                           =   str_replace(', ',',&#13;&#10;',$feature_list);
    
    $cache_array=array('yes','no');
    $show_no_features_symbol =  wpestate_dropdowns_theme_admin($cache_array,'show_no_features');
    
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Add New Element in Features and Amenities','wpestate').'</div>
    <div class="option_row_explain">'.__('Add New Element in Features and Amenities','wpestate').'</div>    
        <input  type="text" id="new_feature"  name="new_feature"   value="type here feature name.. " size="40"/><br>
        <a href="#" id="add_feature"> click to add feature </a><br>
    </div>';
  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Features and Amenities list','wpestate').'</div>
    <div class="option_row_explain">'.__('list of already added features and amenities','wpestate').'</div>    
        <textarea id="feature_list" name="feature_list" rows="15" cols="42">'. $feature_list.'</textarea> 
    </div>';
      
     print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Show the Features and Amenities that are not available','wpestate').'</div>
    <div class="option_row_explain">'.__('Show the Features and Amenities that are not available','wpestate').'</div>    
        <select id="show_no_features" name="show_no_features">
            '.$show_no_features_symbol.'
        </select> 
    </div>';

}




function new_wpestate_listing_labels(){
    $cache_array                            =   array('yes','no');
    $status_list                            =   esc_html( get_option('wp_estate_status_list') );
    $status_list                            =   str_replace(', ',',&#13;&#10;',$status_list);
    $property_adr_text                      =   stripslashes ( esc_html( get_option('wp_estate_property_adr_text') ) );
    $property_description_text              =   stripslashes ( esc_html( get_option('wp_estate_property_description_text') ) );
    $property_details_text                  =   stripslashes ( esc_html( get_option('wp_estate_property_details_text') ) );
    $property_features_text                 =   stripslashes ( esc_html( get_option('wp_estate_property_features_text') ) );
   
   
        
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Adress Label','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Adress Label','wpestate').'</div>    
        <input  type="text" id="property_adr_text"  name="property_adr_text"   value="'.$property_adr_text.'"/>
    </div>';
              
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Features Label','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Features Label','wpestate').'</div>    
        <input  type="text" id="property_features_text"  name="property_features_text"   value="'.$property_features_text.'" size="40"/>
    </div>';
                
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Description Label','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Description Label','wpestate').'</div>    
        <input  type="text" id="property_description_text"  name="property_description_text"   value="'.$property_description_text.'" size="40"/>
    </div>';

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Details Label','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Details Label','wpestate').'</div>    
        <input  type="text" id="property_details_text"  name="property_details_text"   value="'.$property_details_text.'" size="40"/>
    </div>';

    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Property Status ','wpestate').'</div>
    <div class="option_row_explain">'.__('Property Status (* you may need to add new css classes - please see the help files) ','wpestate').'</div>    
        <input  type="text" id="new_status"  name="new_status"   value="type here the new status... " size="40"/>
        <a href="#new_status" id="add_status"> click to add new status </a><br>
        <textarea id="status_list" name="status_list" rows="7" cols="42">'.$status_list.'</textarea>  
    </div>';
}
 
 function new_wpestate_theme_slider(){
    $theme_slider   =   get_option( 'wp_estate_theme_slider', true); 
    $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Select Properties ','wpestate').'</div>
    <div class="option_row_explain">'.__('Select properties for slider - *hold CTRL for multiple select ','wpestate').'</div>';    
        
        $args = array(  'post_type'         =>  'estate_property',
                        'post_status'       =>  'publish',
                        'nopaging'      =>  'true',
                        'cache_results'  => false,
                        'update_post_meta_cache'  =>   false,
                        'update_post_term_cache'  =>   false,
                );

        $recent_posts = new WP_Query($args);
        print '<select name="theme_slider[]"  id="theme_slider"  multiple="multiple">';
        while ($recent_posts->have_posts()): $recent_posts->the_post();
             $theid=get_the_ID();
             print '<option value="'.$theid.'" ';
             if( is_array($theme_slider) && in_array($theid, $theme_slider) ){
                 print ' selected="selected" ';
             }
             print'>'.get_the_title().'</option>';
        endwhile;
        print '</select>';
     
    print '</div>';
    
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Number of milisecons before auto cycling an item','wpestate').'</div>
    <div class="option_row_explain">'.__('Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide. ','wpestate').'</div>    
        <input  type="text" id="slider_cycle" name="slider_cycle"  value="'.$slider_cycle.'"/> 
    </div>';
     
 }
 
 
 function new_wpestate_email_management(){
     
        $emails=array(
            'new_user'                  =>  __('New user  notification','wpestate'),
            'admin_new_user'            =>  __('New user admin notification','wpestate'),
            'purchase_activated'        =>  __('Purchase Activated','wpestate'),
            'password_reset_request'    =>  __('Password Reset Request','wpestate'),
            'password_reseted'          =>  __('Password Reseted','wpestate'),
            'purchase_activated'        =>  __('Purchase Activated','wpestate'),
            'approved_listing'          =>  __('Approved Listings','wpestate'),
            'new_wire_transfer'         =>  __('New wire Transfer','wpestate'),
            'admin_new_wire_transfer'   =>  __('Admin - New wire Transfer','wpestate'),
            'admin_expired_listing'     =>  __('Admin - Expired Listing','wpestate'),
            'matching_submissions'      =>  __('Matching Submissions','wpestate'),
            'paid_submissions'          =>  __('Paid Submission','wpestate'),
            'featured_submission'       =>  __('Featured Submission','wpestate'),
            'account_downgraded'        =>  __('Account Downgraded','wpestate'),
            'membership_cancelled'      =>  __('Membership Cancelled','wpestate'),
            'free_listing_expired'      =>  __('Free Listing Expired','wpestate'),
            'new_listing_submission'    =>  __('New Listing Submission','wpestate'),
            'listing_edit'              =>  __('Listing Edit','wpestate'),
            'recurring_payment'         =>  __('Recurring Payment','wpestate'),
            'membership_activated'      =>  __('Membership Activated','wpestate'),
           
        );
        
        
        print '<div class="email_row">'.__('Global variables: %website_url as website url,%website_name as website name, %user_email as user_email, %username as username','wpestate').'</div>';
        
        
        foreach ($emails as $key=>$label ){
            $value          = stripslashes( get_option('wp_estate_'.$key,'') );
            $value_subject  = stripslashes( get_option('wp_estate_subject_'.$key,'') );
              
            print'<div class="estate_option_row">
            <div class="label_option_row">'.__('Subject for','wpestate').' '.$label.'</div>
            <div class="option_row_explain">'.__('Email subject for').' '.$label.'</div>
            <input type="text" style="width:100%" name="subject_'.$key.'" value="'.$value_subject.'" />
            </br>
            <div class="label_option_row">'.__('Content for','wpestate').' '.$label.'</div>
            <div class="option_row_explain">'.__('Email content for').' '.$label.'</div>
            <textarea rows="10" style="width:100%" name="'.$key.'">'.$value.'</textarea>
            <div class="extra_exp"> '.wpestate_emails_extra_details($key).'</div>
            </div>';
    
         
        

        }

        
}



 
 function new_wpestate_generate_pins(){
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Generate the pins','wpestate').'</div>
    <div class="option_row_explain">'.__('Generate the pins for the read from file map option','wpestate').'</div>    
        click to generate the pins
    </div>';
      
}
         

function new_wpestate_help_custom(){
  
    print'<div class="estate_option_row">
    <div class="label_option_row">'.__('Help and Custom','wpestate').'</div>
    <div class="option_row_explain">'.__('Help and custom work','wpestate').'</div>    
       <p> '.__('For theme help please check http://help.wpresidence.net/. If your question is not here, please go to http://support.wpestate.org, create an account and post a ticket. The registration is simple and as soon as you send a ticket we are notified. We usually answer in the next 24h (except weekends). Please use this system and not the email. It will help us answer your questions much faster. Thank you!','wpestate').' </p>
       <p> '.__('For custom work on this theme please go to  <a href="http://support.wpestate.org/" target="_blank">http://support.wpestate.org</a>, create a ticket with your request and we will offer a free quote.','wpestate').' </p>
       <p> '.__('Subscribe to our mailing list in order to receive news about new features and theme upgrades. <a href="http://eepurl.com/CP5U5">Subscribe Here!</a>','wpestate').' </p>
                   
    </div>';
        
}

?>