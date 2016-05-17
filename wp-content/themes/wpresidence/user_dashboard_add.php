<?php
// Template Name: User Dashboard Submit
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect( home_url() );exit;
} 
set_time_limit (600);

//print_R($_POST);

$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$status_values                  =   esc_html( get_option('wp_estate_status_list') );
$status_values_array            =   explode(",",$status_values);
$feature_list_array             =   array();
$feature_list                   =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array             =   explode( ',',$feature_list);
$allowed_html                   =   array();

global $show_err;



if( isset( $_GET['listing_edit'] ) && is_numeric( $_GET['listing_edit'] ) ){
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// If we have edit load current values
    ///////////////////////////////////////////////////////////////////////////////////////////
    $edit_id                        =  intval ($_GET['listing_edit']);
  
    $the_post= get_post( $edit_id); 
    if( $current_user->ID != $the_post->post_author ) {
        exit('You don\'t have the rights to edit this');
    }
    $show_err                       =   '';
    $action                         =   'edit';
    $submit_title                   =   get_the_title($edit_id);
    $submit_description             =   get_post_field('post_content', $edit_id);
    
   
  
    $prop_category_array            =   get_the_terms($edit_id, 'property_category');
    if(isset($prop_category_array[0])){
         $prop_category_selected   =   $prop_category_array[0]->term_id;
    }
    
    $prop_action_category_array     =   get_the_terms($edit_id, 'property_action_category');
    if(isset($prop_action_category_array[0])){
        $prop_action_category_selected           =   $prop_action_category_array[0]->term_id;
    }
   
    
    $property_city_array            =   get_the_terms($edit_id, 'property_city');
    if(isset($property_city_array [0])){
          $property_city                  =   $property_city_array [0]->name;
    }
    
    $property_area_array            =   get_the_terms($edit_id, 'property_area');
    if(isset($property_area_array [0])){
        $property_area                  =   $property_area_array [0]->name;
    }
    
    $property_county_state_array            =   get_the_terms($edit_id, 'property_county_state');
    if(isset($property_county_state_array [0])){
        $property_county_state                 =   $property_county_state_array [0]->name;
    }
  
    $property_address               =   esc_html( get_post_meta($edit_id, 'property_address', true) );
    $property_county                =   esc_html( get_post_meta($edit_id, 'property_county', true) );
   // $property_state                 =   esc_html( get_post_meta($edit_id, 'property_state', true) );
    $property_zip                   =   esc_html( get_post_meta($edit_id, 'property_zip', true) );
     $country_selected               =   esc_html( get_post_meta($edit_id, 'property_country', true) );
    $prop_stat                      =   esc_html( get_post_meta($edit_id, 'property_status', true) );
    $property_status                =   '';


    foreach ($status_values_array as $key=>$value) {
        $value = trim($value);
        $value_wpml=$value;
        $slug_status=sanitize_title($value);
        if (function_exists('icl_translate') ){
            $value_wpml= icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
        }
        
        $property_status.='<option value="' . $value . '"';
        if ($value == $prop_stat) {
            $property_status.='selected="selected"';
        }
        $property_status.='>' . $value_wpml . '</option>';
    }

    $property_price                 =   floatval   ( get_post_meta($edit_id, 'property_price', true) );
    $property_label                 =   esc_html ( get_post_meta($edit_id, 'property_label', true) );  
    $property_label_before          =   esc_html ( get_post_meta($edit_id, 'property_label_before', true) );  
    $property_size                  =   floatval   ( get_post_meta($edit_id, 'property_size', true) ); 
    $owner_notes                    =   esc_html ( get_post_meta($edit_id, 'owner_notes', true) ); 
    $property_lot_size              =   floatval   ( get_post_meta($edit_id, 'property_lot_size', true) );
    $property_rooms                 =   floatval   ( get_post_meta($edit_id, 'property_rooms', true) );
    $property_bedrooms              =   floatval   ( get_post_meta($edit_id, 'property_bedrooms', true) ); 
    $property_bathrooms             =   floatval   ( get_post_meta($edit_id, 'property_bathrooms', true) );
    $property_roofing               =   esc_html ( get_post_meta($edit_id, 'property_roofing', true) ); 
    $option_video                   =   '';
    $video_values                   =   array('vimeo', 'youtube');
    $video_type                     =   esc_html ( get_post_meta($edit_id, 'embed_video_type', true) ); 
    $google_camera_angle            =   intval   ( get_post_meta($edit_id, 'google_camera_angle', true) );
    
    $plan_title_array               =   get_post_meta($edit_id, 'plan_title', true);
    $plan_desc_array                =   get_post_meta($edit_id, 'plan_description', true) ;
    $plan_image_array               =   get_post_meta($edit_id, 'plan_image', true) ;
    $plan_size_array                =   get_post_meta($edit_id, 'plan_size', true) ;
    $plan_rooms_array               =   get_post_meta($edit_id, 'plan_rooms', true) ;
    $plan_bath_array                =   get_post_meta($edit_id, 'plan_bath', true);
    $plan_price_array               =   get_post_meta($edit_id, 'plan_price', true) ;
    
    
    

    foreach ($video_values as $value) {
        $option_video.='<option value="' . $value . '"';
        if ($value == $video_type) {
            $option_video.='selected="selected"';
        }
        $option_video.='>' . $value . '</option>';
    }
    
    $option_slider='';
    $slider_values = array('full top slider', 'small slider');
   // $slider_type = get_post_meta($edit_id, 'prop_slider_type', true);
    /*
    foreach ($slider_values as $value) {
        $option_slider.='<option value="' . $value . '"';
        if ($value == $slider_type) {
            $option_slider.='selected="selected"';
        }
        $option_slider.='>' . $value . '</option>';
    }
    */
    $embed_video_id                 =   esc_html( get_post_meta($edit_id, 'embed_video_id', true) );
    $property_latitude              =   floatval( get_post_meta($edit_id, 'property_latitude', true)); 
    $property_longitude             =   floatval( get_post_meta($edit_id, 'property_longitude', true));
    $google_view                    =   intval( get_post_meta($edit_id, 'property_google_view', true) );

    if($google_view==1){
        $google_view_check  =' checked="checked" ';
    }else{
         $google_view_check =' ';
    }
    
    
  
    
    $google_camera_angle            =   intval( get_post_meta($edit_id, 'google_camera_angle', true) );; 
   
    //  custom fields
    $custom_fields = get_option( 'wp_estate_custom_fields', true);  
    $custom_fields_array=array();
    $i=0;
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name =   $custom_fields[$i][0];
           $type =   $custom_fields[$i][2];
          // $slug =   str_replace(' ','_',$name);
           $slug         =   wpestate_limit45(sanitize_title( $name ));
           $slug         =   sanitize_key($slug);
           
           $custom_fields_array[$slug]=esc_html(get_post_meta($edit_id, $slug, true));
           $i++;
        }
    }

            

}else{    
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// If default view make vars blank 
    ///////////////////////////////////////////////////////////////////////////////////////////
    $action                         =   'view';
    $submit_title                   =   ''; 
    $submit_description             =   ''; 
    $prop_category                  =   ''; 
    $property_address               =   ''; 
    $property_county                =   ''; 
    $property_state                 =   ''; 
    $property_zip                   =   ''; 
    $country_selected               =   ''; 
    $prop_stat                      =   ''; 
    $property_status                =   '';
    $property_price                 =   ''; 
    $property_label                 =   '';   
    $property_label_before          =   '';  
    $property_size                  =   ''; 
    $owner_notes                    =   '';   
    $property_lot_size              =   ''; 
    $property_year                  =   ''; 
    $property_rooms                 =   ''; 
    $property_bedrooms              =   ''; 
    $property_bathrooms             =   ''; 
    $option_video                   =   '';
    $option_slider                  =   '';
    $video_type                     =   '';  
    $embed_video_id                 =   ''; 
    $property_latitude              =   ''; 
    $property_longitude             =   '';  
    $google_view                    =   ''; 
    $google_camera_angle            =   ''; 
    $prop_category                  =   '';  
    $plan_title_array               =   '';
    $plan_desc_array                =   '';
    $plan_image_array               =   '';
    $plan_size_array                =   '';
    $plan_rooms_array               =   '';
    $plan_bath_array                =   '';
    $plan_price_array               =   '';
    
    
    $custom_fields = get_option( 'wp_estate_custom_fields', true);    
    $custom_fields_array=array();
    $i=0;
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name =   $custom_fields[$i][0];
           $type =   $custom_fields[$i][2];
          // $slug =   str_replace(' ','_',$name);
           $slug         =   wpestate_limit45(sanitize_title( $name ));
           $slug         =   sanitize_key($slug);
           $custom_fields_array[$slug]='';
           $i++;
        }
    }
    




    foreach ($status_values_array as $key=>$value) {
        $value = trim($value);
        $value_wpml=$value;
        $slug_status=sanitize_title($value);
        if (function_exists('icl_translate') ){
            $value_wpml= icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
        }
        $property_status.='<option value="' . $value . '"';
        $property_status.='>' . $value_wpml . '</option>';
    }
    
    

    $video_values                   =   array('vimeo', 'youtube');
    foreach ($video_values as $value) {
      $option_video.='<option value="' . $value . '"';
      $option_video.='>' . $value . '</option>';
    }    

    $option_slider='';
    $slider_values = array('full top slider', 'small slider');
      
     foreach ($slider_values as $value) {
        $option_slider.='<option value="' . $value . '"';
        $option_slider.='>' . $value . '</option>';
     }
}





        


///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////


if( 'POST' == $_SERVER['REQUEST_METHOD'] && $_POST['action']=='view' ) {
    
    $paid_submission_status    = esc_html ( get_option('wp_estate_paid_submission','') );
     
    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($userID) > 0)  ){ // if user can submit
        
        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
           exit('Sorry, your not submiting from site'); 
        }
   
        if( !isset($_POST['prop_category']) ) {
            $prop_category=0;           
        }else{
            $prop_category  =   intval($_POST['prop_category']);
        }
  
        if( !isset($_POST['prop_action_category']) ) {
            $prop_action_category=0;           
        }else{
            $prop_action_category  =   wp_kses(esc_html($_POST['prop_action_category']),$allowed_html);
        }
        
        if( !isset($_POST['property_city']) ) {
            $property_city='';           
        }else{
            $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
        }
        
        if( !isset($_POST['property_area']) ) {
            $property_area='';           
        }else{
            $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
        }
       
        
        if( !isset($_POST['property_county']) ) {
            $property_county_state='';           
        }else{
            $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
        }
       
        
        
        
                
        $show_err                       =   '';
        $post_id                        =   '';
        $submit_title                   =   wp_kses( $_POST['wpestate_title'],$allowed_html ); 
        $submit_description             =   wp_filter_nohtml_kses( $_POST['wpestate_description']);     
        $property_address               =   wp_kses( $_POST['property_address'],$allowed_html);
        $property_county                =   wp_kses( $_POST['property_county'],$allowed_html);
    //    $property_state                 =   wp_kses( $_POST['property_state'],$allowed_html);
        $property_zip                   =   wp_kses( $_POST['property_zip'],$allowed_html);
        $country_selected               =   wp_kses( $_POST['property_country'],$allowed_html);     
        $prop_stat                      =   wp_kses( $_POST['property_status'],$allowed_html);
        $property_status                =   '';
        
        foreach ($status_values_array as $key=>$value) {
            $value = trim($value);
            $value_wpml=$value;
            $slug_status=sanitize_title($value);
            if (function_exists('icl_translate') ){
                $value_wpml= icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
            }
            
            $property_status.='<option value="' . $value . '"';
            if ($value == $prop_stat) {
                $property_status.='selected="selected"';
            }
            $property_status.='>' . $value_wpml . '</option>';
        }

        $property_price                 =   wp_kses( esc_html($_POST['property_price']),$allowed_html);
        $property_label                 =   wp_kses( esc_html($_POST['property_label']),$allowed_html);   
        $property_label_before          =   wp_kses( esc_html($_POST['property_label_before']),$allowed_html); 
        $property_size                  =   wp_kses( esc_html($_POST['property_size']),$allowed_html);  
        $owner_notes                    =   wp_kses( esc_html($_POST['owner_notes']),$allowed_html);  
        $property_lot_size              =   wp_kses( esc_html($_POST['property_lot_size']),$allowed_html); 
        $property_rooms                 =   wp_kses( esc_html($_POST['property_rooms']),$allowed_html); 
        $property_bedrooms              =   wp_kses( esc_html($_POST['property_bedrooms']),$allowed_html); 
        $property_bathrooms             =   wp_kses( esc_html($_POST['property_bathrooms']),$allowed_html); 
        $option_video                   =   '';
        $video_values                   =   array('vimeo', 'youtube');
        $video_type                     =   wp_kses( esc_html($_POST['embed_video_type']),$allowed_html); 
        $google_camera_angle            =   wp_kses( esc_html($_POST['google_camera_angle']),$allowed_html); 
        $has_errors                     =   false;
        $errors                         =   array();
        
        $moving_array=array();
        foreach($feature_list_array as $key => $value){
            $post_var_name    =   str_replace(' ','_', trim($value) );
            $post_var_name    =   wpestate_limit45(sanitize_title( $post_var_name ));
            $post_var_name    =   sanitize_key($post_var_name);
            
            if(isset($_POST[$post_var_name])){
                $feature_value    =   wp_kses( esc_html($_POST[$post_var_name]) ,$allowed_html);
            }
            
            if($feature_value==1){
                $moving_array[]=$post_var_name;
            }        
       }
        
      
        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
        
        $option_slider='';
        $slider_values = array('full top slider', 'small slider'); 
    
        $embed_video_id                 =   wp_kses( esc_html($_POST['embed_video_id']),$allowed_html); 
        $property_latitude              =   floatval( $_POST['property_latitude']); 
        $property_longitude             =   floatval( $_POST['property_longitude']); 
        $google_view                    =   wp_kses( esc_html( $_POST['property_google_view']),$allowed_html); 

        if($google_view==1){
            $google_view_check=' checked="checked" ';
        }else{
             $google_view_check=' ';
        }
   
        $google_camera_angle            =   intval( $_POST['google_camera_angle']); 
        $prop_category                  =   get_term( $prop_category, 'property_category');
        if(isset($prop_category->term_id)){
            $prop_category_selected         =   $prop_category->term_id;
        }
    
        $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
        if(isset($prop_action_category->term_id)){
             $prop_action_category_selected  =   $prop_action_category->term_id;
        }
       
        
        // save custom fields
     
        $i=0;
        if( !empty($custom_fields)){  
            while($i< count($custom_fields) ){
               $name =   $custom_fields[$i][0];
               $type =   $custom_fields[$i][1];
               $slug =   str_replace(' ','_',$name);
               $slug         =   wpestate_limit45(sanitize_title( $name ));
               $slug         =   sanitize_key($slug);
               $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
               $i++;
            }
        }    
            
        if($submit_title==''){
            $has_errors=true;
            $errors[]=__('Please submit a title for your property','wpestate');
        }
        
        if($submit_description==''){
            $has_errors=true;
            $errors[]=__('Please submit a description for your property','wpestate');
        }
        
        if ($_POST['attachid']==''){
            $has_errors=true;
            $errors[]=__('Please submit an image for your property','wpestate'); 
        }
        
        if($property_address==''){
            $has_errors=true;
            $errors[]=__('Please submit an address for your property','wpestate');
        }
         
        /*  if($property_price==''){
            $has_errors=true;
            $errors[]=__('Please submit the price','wpestate');
        }
        */
        if($has_errors){
            foreach($errors as $key=>$value){
                $show_err.=$value.'</br>';
            }            
        }else{
            $paid_submission_status = esc_html ( get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';
            
            $admin_submission_status= esc_html ( get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';  
            }
            
            
            $post = array(
                'post_title'	=> $submit_title,
                'post_content'	=> $submit_description,
                'post_status'	=> $new_status, 
                'post_type'     => 'estate_property' ,
                'post_author'   => $current_user->ID 
            );
            $post_id =  wp_insert_post($post );  
            
            if( $paid_submission_status == 'membership'){ // update pack status
                wpestate_update_listing_no($current_user->ID);                
                //if($prop_featured==1){
                 //   wpestate_update_featured_listing_no($current_user->ID); 
                //}
               
            }
       
        }
        
      

        
        
        if($post_id) {
            // uploaded images
            $order=0;
            $attchs=explode(',',$_POST['attachid']);
            $last_id='';
            foreach($attchs as $att_id){
                if( !is_numeric($att_id) ){
                 
                }else{
                    if($last_id==''){
                        $last_id=  $att_id;  
                    }
                    $order++;
                    wp_update_post( array(
                                'ID' => $att_id,
                                'post_parent' => $post_id,
                                'menu_order'=>$order
                            ));
                        
                    
                }
            }
            
            if( is_numeric($_POST['attachthumb']) && $_POST['attachthumb']!=''  ){
                set_post_thumbnail( $post_id, wp_kses(esc_html($_POST['attachthumb']),$allowed_html )); 
            }else{
                set_post_thumbnail( $post_id, $last_id );                
            }
            //end uploaded images
            
            
            if( isset($prop_category->name) ){
                wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
            }  
            if ( isset ($prop_action_category->name) ){
                wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
            }  
            if( isset($property_city) && $property_city!='none' ){
                if($property_city == -1 ){
                    $property_city='';
                }
                
                wp_set_object_terms($post_id,$property_city,'property_city'); 
            }  
            if( isset($property_area) && $property_area!='none' ){
                wp_set_object_terms($post_id,$property_area,'property_area'); 
            }  
            if( isset($property_county_state) && $property_county_state!='none' ){
                if($property_county_state == -1){
                    $property_county_state='';
                }
                wp_set_object_terms($post_id,$property_county_state,'property_county_state'); 
            }  
            
            //taxonomy185 Array ( [cityparent] => London ) 
            if($property_area!=''){
                $terms= get_term_by('name', $property_area, 'property_area');
                //print_R($terms);
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('cityparent'=>$property_city);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
          
   
            update_post_meta($post_id, 'sidebar_agent_option', 'global');
            update_post_meta($post_id, 'local_pgpr_slider_type', 'global');
            update_post_meta($post_id, 'local_pgpr_content_type', 'global');
       
            update_post_meta($post_id, 'prop_featured', 0);
            update_post_meta($post_id, 'property_address', $property_address);
            update_post_meta($post_id, 'property_county', $property_county);
            update_post_meta($post_id, 'property_zip', $property_zip);
        //    update_post_meta($post_id, 'property_state', $property_state);
            update_post_meta($post_id, 'property_country', $country_selected);
            update_post_meta($post_id, 'property_size', $property_size);
            update_post_meta($post_id, 'owner_notes', $owner_notes);
            update_post_meta($post_id, 'property_lot_size', $property_lot_size);  
            update_post_meta($post_id, 'property_rooms', $property_rooms);  
            update_post_meta($post_id, 'property_bedrooms', $property_bedrooms);
            update_post_meta($post_id, 'property_bathrooms', $property_bathrooms);
            update_post_meta($post_id, 'property_status', $prop_stat);
            update_post_meta($post_id, 'property_price', $property_price);
            update_post_meta($post_id, 'property_label', $property_label);
            update_post_meta($post_id, 'property_label_before', $property_label_before);
            update_post_meta($post_id, 'embed_video_type', $video_type);
            update_post_meta($post_id, 'embed_video_id',  $embed_video_id );
            update_post_meta($post_id, 'property_latitude', $property_latitude);
            update_post_meta($post_id, 'property_longitude', $property_longitude);
            update_post_meta($post_id, 'property_google_view',  $google_view);
            update_post_meta($post_id, 'google_camera_angle', $google_camera_angle);
            update_post_meta($post_id, 'pay_status', 'not paid');
            update_post_meta($post_id, 'page_custom_zoom', 16);
            
            $sidebar =  get_option( 'wp_estate_blog_sidebar', true); 
            update_post_meta($post_id, 'sidebar_option', $sidebar);
            
             $sidebar_name   = get_option( 'wp_estate_blog_sidebar_name', true); 
             update_post_meta($post_id, 'sidebar_select', $sidebar_name);
              
            if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
                $user_id_agent            =   get_the_author_meta( 'user_agent_id' , $current_user->ID  );
                update_post_meta($post_id, 'property_agent', $user_id_agent);                
            }
           
            // save custom fields
            $custom_fields = get_option( 'wp_estate_custom_fields', true);  
     
            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                   $name =   $custom_fields[$i][0];
                   $type =   $custom_fields[$i][2];
                   $slug =   str_replace(' ','_',$name);
                    $slug         =   wpestate_limit45(sanitize_title( $name ));
                    $slug         =   sanitize_key($slug);
                   if($type=='numeric'){
                        $value_custom    =   intval(wp_kses( $_POST[$slug],$allowed_html ) );
                       
                        if($value_custom==0){
                            $value_custom='';
                        }
                       
                       update_post_meta($post_id, $slug, $value_custom);
                   }else{
                       $value_custom    =   esc_html(wp_kses( $_POST[$slug],$allowed_html ) );
                       update_post_meta($post_id, $slug, $value_custom);
                   }
                   $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
                   $i++;
                }
            }
            
            
            
            
            foreach($feature_list_array as $key => $value){
                $post_var_name      =   str_replace(' ','_', trim($value) );
                $post_var_name      =   wpestate_limit45(sanitize_title( $post_var_name ));
                $post_var_name      =   sanitize_key($post_var_name);
                
                if( isset($_POST[$post_var_name])){
                    $feature_value  =   wp_kses( esc_html($_POST[$post_var_name]) ,$allowed_html);
                    update_post_meta($post_id, $post_var_name, $feature_value);
                }
                
                
                $moving_array[] =   $post_var_name;
            }
   
            // get user dashboard link
            $redirect = get_dashboard_link();
            
            $arguments=array(
                'new_listing_url'   => get_permalink($post_id),
                'new_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'new_listing_submission',$arguments);
    
            wp_reset_query();
            wp_redirect( $redirect);
            exit;
        }
        
        }//end if user can submit  
    
    
    
} // end post

///////////////////////////////////////////////////////////////////////////////////////////
/////// Edit Part Code
///////////////////////////////////////////////////////////////////////////////////////////
if( 'POST' == $_SERVER['REQUEST_METHOD'] && $_POST['action']=='edit' ) {
     if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
       exit('Sorry, your not submiting from site');
    }     
        $has_errors                     =   false;
        $show_err                       =   '';
        $edited                         =   0;
        $edit_id                        =   intval( $_POST['edit_id'] );
        $post                           =   get_post( $edit_id ); 
        $author_id                      =   $post->post_author ;
        if($current_user->ID !=  $author_id){
            exit('you don\'t have the rights to edit');
        }
        
        $images_todelete                =   wp_kses( esc_html($_POST['images_todelete']),$allowed_html );
        $images_delete_arr              =   explode(',',$images_todelete);
        foreach ($images_delete_arr as $key=>$value){
             $img                       =   get_post( $value ); 
             $author_id                 =   $img->post_author ;
             if($current_user->ID !=  $author_id){
                exit('you don\'t have the rights to delete images');
             }else{
                  wp_delete_post( $value );   
             }
                      
        }
          
        
        if( !isset($_POST['prop_category']) ) {
            $prop_category=0;           
        }else{
            $prop_category  =   intval($_POST['prop_category']);
        }
        
        if($prop_category==-1){
            wp_delete_object_term_relationships($edit_id,'property_category'); 
        }
            
            
            
        if( !isset($_POST['prop_action_category']) ) {
            $prop_action_category=0;           
        }else{
            $prop_action_category  =   wp_kses(esc_html($_POST['prop_action_category']),$allowed_html);
        }
        
        if($prop_action_category==-1){
            wp_delete_object_term_relationships($edit_id,'property_action_category'); 
        }
            
            
            
        if( !isset($_POST['property_city']) ) {
            $property_city=0;           
        }else{
            $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
        }
        
        if( !isset($_POST['property_area']) ) {
            $property_area=0;           
        }else{
            $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
        }
        
        
        if( !isset($_POST['property_county']) ) {
            $property_county_state=0;           
        }else{
            $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
        }
        
     
            
       
        
        $submit_title                   =   wp_kses( esc_html($_POST['wpestate_title']) ,$allowed_html); 
        $submit_description             =   wp_filter_nohtml_kses( $_POST['wpestate_description']);
        $property_address               =   wp_kses( esc_html($_POST['property_address']),$allowed_html);
        $property_county                =   wp_kses( esc_html($_POST['property_county']),$allowed_html);
   //     $property_state                 =   wp_kses( $_POST['property_state'],$allowed_html);
        $property_zip                   =   wp_kses( esc_html($_POST['property_zip']),$allowed_html);
        $country_selected               =   wp_kses( esc_html($_POST['property_country']),$allowed_html);     
        $prop_stat                      =   wp_kses( esc_html($_POST['property_status']),$allowed_html);
        $property_status                =   '';
        
        foreach ($status_values_array as $key=>$value) {
            $value = trim($value);
            $property_status.='<option value="' . $value . '"';
            if ($value == $prop_stat) {
                $property_status.='selected="selected"';
            }
            $property_status.='>' . $value . '</option>';
        }

        $property_price                 =   wp_kses( esc_html ($_POST['property_price']),$allowed_html);
        $property_label                 =   wp_kses( esc_html ($_POST['property_label']),$allowed_html); 
        $property_label_before          =   wp_kses( esc_html ($_POST['property_label_before']),$allowed_html);  
        $property_size                  =   wp_kses( esc_html ($_POST['property_size']),$allowed_html);  
        $owner_notes                    =   wp_kses( esc_html ($_POST['owner_notes']),$allowed_html);  
        $property_lot_size              =   wp_kses( esc_html ($_POST['property_lot_size']),$allowed_html); 
       // $property_year                  =   wp_kses( $_POST['property_year'],$allowed_html); 
        $property_rooms                 =   wp_kses( esc_html ($_POST['property_rooms']),$allowed_html); 
        $property_bedrooms              =   wp_kses( esc_html ($_POST['property_bedrooms']),$allowed_html); 
        $property_bathrooms             =   wp_kses( esc_html ($_POST['property_bathrooms']),$allowed_html); 
        $option_video                   =   '';
        $video_values                   =   array('vimeo', 'youtube');
        $video_type                     =   wp_kses( esc_html ($_POST['embed_video_type']),$allowed_html); 
        $google_camera_angle            =   wp_kses( esc_html ($_POST['google_camera_angle']),$allowed_html); 

        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
        
        $option_slider='';
        $slider_values = array('full top slider', 'small slider');
    

        $embed_video_id                 =   wp_kses( esc_html($_POST['embed_video_id']),$allowed_html); 
        $property_latitude              =   floatval( $_POST['property_latitude']); 
        $property_longitude             =   floatval( $_POST['property_longitude']); 
        $google_view                    =   wp_kses( esc_html($_POST['property_google_view']),$allowed_html); 

        if($google_view==1){
            $google_view_check=' checked="checked" ';
        }else{
             $google_view_check=' ';
        }
       
        

        $google_camera_angle            =   intval( $_POST['google_camera_angle']); 
        $prop_category                  =   get_term( $prop_category, 'property_category');
        $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');     

      
     
        
        if($submit_title==''){
            $has_errors=true;
            $errors[]=__('Please submit a title for your property','wpestate');
        }
        
        if($submit_description==''){
            $has_errors=true;
            $errors[]=__('*Please submit a description for your property','wpestate');
        }
        
        if ($_POST['attachid']==''){
            $has_errors=true;
            $errors[]=__('*Please submit an image for your property','wpestate'); 
        }
        
        if($property_address==''){
            $has_errors=true;
            $errors[]=__('*Please submit an address for your property','wpestate');
        }
         
      
        
       if($has_errors){
            foreach($errors as $key=>$value){
                $show_err.=$value.'</br>';
            }
            
        }else{
            $new_status='pending';
            $admin_submission_status = esc_html ( get_option('wp_estate_admin_submission','') );
            $paid_submission_status  = esc_html ( get_option('wp_estate_paid_submission','') );
              
            if($admin_submission_status=='no' ){
               $new_status=get_post_status($edit_id);  
            }
            
            
            $post = array(
                    'ID'            => $edit_id,
                    'post_title'    => $submit_title,
                    'post_content'  => $submit_description,
                    'post_type'     => 'estate_property',
                    'post_status'   => $new_status
            );

            $post_id =  wp_update_post($post );  
            $edited=1;
        }
        
      
     
     

        if( $edited==1) {
            //uploaded images
            $attchs=explode(',',$_POST['attachid']);
            $last_id='';
            
            // check for deleted images
            $arguments = array(
                        'numberposts'   => -1,
                        'post_type'     => 'attachment',
                        'post_parent'   => $post_id,
                        'post_status'   => null,
                        'orderby'       => 'menu_order',
                        'order'         => 'ASC'
            );
            $post_attachments = get_posts($arguments);
                  
            $new_thumb=0;
            $curent_thumb=get_post_thumbnail_id($post_id);
            foreach ($post_attachments as $attachment){
                if ( !in_array ($attachment->ID,$attchs) ){
                    wp_delete_post($attachment->ID);
                    if( $curent_thumb == $attachment->ID ){
                        $new_thumb=1;
                    }
                }
            }
          
            // check for deleted images
              
           $order=0;
            foreach($attchs as $att_id){
                if( !is_numeric($att_id) ){
                 
                }else{
                    if($last_id==''){
                        $last_id=  $att_id;  
                    }
                    $order++;
                    wp_update_post( array(
                                'ID' => $att_id,
                                'post_parent' => $post_id, 
                                'menu_order'=>$order
                            ));
                        
                    
                }
            }
         
            if( is_numeric($_POST['attachthumb']) && $_POST['attachthumb']!=''  ){
                set_post_thumbnail( $post_id, $_POST['attachthumb'] ); 
            } 
            if($new_thumb==1 || !has_post_thumbnail($post_id) || $_POST['attachthumb']==''){
                set_post_thumbnail( $post_id, $last_id );
            }
            
            //end uploaded images
            
            if( isset($prop_category->name) ){
                 wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
            }  
           
            if ( isset ($prop_action_category->name) ){
                 wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
            }  
           
            
            
            if( isset($property_city) && $property_city!='none'  ){
                if($property_city == -1 ){
                    $property_city='';
                }
                wp_set_object_terms($post_id,$property_city,'property_city'); 
            }  
            
            if( isset($property_area) && $property_area!='none' ){
                wp_set_object_terms($post_id,$property_area,'property_area'); 
            }  
            
            if( isset($property_county_state) && $property_county_state!='none' ){
                if($property_county_state == -1){
                    $property_county_state='';
                }
                wp_set_object_terms($post_id,$property_county_state,'property_county_state'); 
            }  
            
            
            if($property_area!=''){
                $terms= get_term_by('name', $property_area, 'property_area');
                //print_R($terms);
                if (isset($terms->term_id)){
                    $t_id=$terms->term_id;
                    $term_meta=array('cityparent'=>$property_city);
                    add_option( "taxonomy_$t_id", $term_meta );
                }
               
            }
          
          
            update_post_meta($post_id, 'property_address', $property_address);
            update_post_meta($post_id, 'property_county', $property_county);
            update_post_meta($post_id, 'property_zip', $property_zip);
         //   update_post_meta($post_id, 'property_state', $property_state);
            update_post_meta($post_id, 'property_country', $country_selected);
            update_post_meta($post_id, 'property_size', $property_size);
            update_post_meta($post_id, 'owner_notes', $owner_notes);
            update_post_meta($post_id, 'property_lot_size', $property_lot_size);  
            update_post_meta($post_id, 'property_rooms', $property_rooms);  
            update_post_meta($post_id, 'property_bedrooms', $property_bedrooms);
            update_post_meta($post_id, 'property_bathrooms', $property_bathrooms);
            update_post_meta($post_id, 'property_status', $prop_stat);
            update_post_meta($post_id, 'property_price', $property_price);
            update_post_meta($post_id, 'property_label', $property_label);
            update_post_meta($post_id, 'property_label_before', $property_label_before);
            update_post_meta($post_id, 'embed_video_type', $video_type);
            update_post_meta($post_id, 'embed_video_id', $embed_video_id);
            update_post_meta($post_id, 'property_latitude', $property_latitude);
            update_post_meta($post_id, 'property_longitude', $property_longitude);
            update_post_meta($post_id, 'property_google_view', $google_view);
            update_post_meta($post_id, 'google_camera_angle', $google_camera_angle);
         
            foreach($feature_list_array as $key => $value){
                $post_var_name    =   str_replace(' ','_', trim(wp_kses($value,$allowed_html)) );
                $post_var_name    =   wpestate_limit45(sanitize_title( $post_var_name ));
                $post_var_name    =   sanitize_key($post_var_name);
                if($post_var_name!=''){
                    $feature_value=wp_kses( esc_html($_POST[$post_var_name]),$allowed_html );
                    update_post_meta($post_id, $post_var_name, $feature_value);
                }
            }
        
    
            // save custom fields
            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                    $name =   $custom_fields[$i][0];
                    $type =   $custom_fields[$i][1];
                    $slug =   str_replace(' ','_',$name);
                    $slug         =   wpestate_limit45(sanitize_title( $name ));
                    $slug         =   sanitize_key($slug);
                    if($type=='numeric'){
                        $value_custom    =   intval(wp_kses( esc_html($_POST[$slug]),$allowed_html ) );
                        if($value_custom==0){
                            $value_custom='';
                        }
                        update_post_meta($post_id, $slug, $value_custom);
                    }else{
                        $value_custom    =   esc_html(wp_kses( $_POST[$slug],$allowed_html ) );
                        update_post_meta($post_id, $slug, $value_custom);
                    }
                        $custom_fields_array[$slug]= wp_kses( $_POST[$slug],$allowed_html); ;
                    $i++;
                }
            }
            // get user dashboard link
            $redirect = get_dashboard_link();
            wp_reset_query();
            
            $arguments=array(
                'editing_listing_url'   => get_permalink($post_id),
                'editing_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'listing_edit',$arguments);
           
            wp_redirect( $redirect);
            exit;
        }// end if edited
}




get_header();
$options=wpestate_page_details($post->ID);



///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////
?> 


<div id="cover"></div>
<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>

    <div class="col-md-3">
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    <div class="col-md-9 dashboard-margin">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
         

           <?php endwhile; // end of the loop. ?>
           <?php  get_template_part('templates/front_end_submission');  ?> 
    </div>
    

</div>   



<?php get_footer();?>