<?php

if (!function_exists('wpestate_search_results_custom')):
function wpestate_search_results_custom($tip=''){
    $real_custom_fields      =   get_option( 'wp_estate_custom_fields', true); 
    $adv_search_what    =   get_option('wp_estate_adv_search_what','');
    $adv_search_how     =   get_option('wp_estate_adv_search_how','');
    $adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
    $adv_search_type    =   get_option('wp_estate_adv_search_type','');
    $keyword            =   '';
    $area_array         =   ''; 
    $city_array         =   '';  
    $action_array       =   '';
    $categ_array        =   '';
    $meta_query         =   '';
    $id_array           =   '';
    $countystate_array  =   '';
    $allowed_html   =   array();
    $new_key        =   0;
    
   
       
    foreach($adv_search_what as $key=>$term ){
        $new_key        =   $key+1;  
        $new_key        =   'val'.$new_key; 
        
       
        
        if($term === 'none' || $term === 'keyword' || $term === 'property id'){
            // do nothng
        }else if( $term === 'categories' ) {
            
                
                if( $tip === 'ajax' ){
                    $input_name         =   $new_key;
                    $input_value        =    wp_kses($_POST[$new_key],$allowed_html);
                }else{
                    $input_name         =   'filter_search_type';
                    if(isset($_REQUEST['filter_search_type'][0])){
                        $input_value        =  wp_kses( $_REQUEST['filter_search_type'][0],$allowed_html);
                    }
                }

            
                if (isset($_REQUEST[$input_name]) && $input_value!='all' && $input_value!='' ){
                    $taxcateg_include   =   array();
                    $taxcateg_include[] =   wp_kses($input_value,$allowed_html);
  
                    $categ_array=array(
                        'taxonomy'  => 'property_category',
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
                } 
        } 
       
        else if($term === 'types'){ 
                if( $tip === 'ajax' ){
                    $input_name         =   $new_key;
                    $input_value        =  wp_kses(  $_POST[$new_key],$allowed_html);
                }else{
                    $input_name         =   'filter_search_action';
                    if(isset($_REQUEST['filter_search_action'][0])){
                        $input_value        =   wp_kses( $_REQUEST['filter_search_action'][0],$allowed_html);
                    }
                }
                
                
                if (isset($_REQUEST[$input_name]) && $input_value!='all' && $input_value!='' ){
                    $taxaction_include   =   array();   

                    $taxaction_include[] = wp_kses($input_value,$allowed_html);

                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
        }

        else if($term === 'cities'){
                if( $tip === 'ajax' ){
                    $input_name         =   $new_key;
                    $input_value        =   wp_kses($_POST[$new_key],$allowed_html);
                }else{
                    $input_name         =   'advanced_city';
                    $input_value        =    wp_kses( $_REQUEST['advanced_city'],$allowed_html);
                }
                
               if (isset($_REQUEST[$input_name]) && $input_value!='all' && $input_value!='' ){
                    $taxcity   =   array();   
                    $taxcity[] = wp_kses($input_value,$allowed_html);
                    $city_array = array(
                        'taxonomy'  => 'property_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
        }

        else if($term === 'areas'){
                
                if( $tip === 'ajax' ){
                    $input_name         =   $new_key;
                    $input_value        =   wp_kses($_POST[$new_key],$allowed_html);
                }else{
                    $input_name         =   'advanced_area';
                    $input_value        =   wp_kses( $_REQUEST['advanced_area'],$allowed_html);
                }
                
                if (isset($_REQUEST[$input_name]) && $input_value!='all' && $input_value!='' ){
                    $taxarea   =   array();   
                    $taxarea[] = wp_kses($input_value,$allowed_html);
                    $area_array = array(
                        'taxonomy'  => 'property_area',
                        'field'     => 'slug',
                        'terms'     => $taxarea
                    );
                }
        }
        
        else if($term === 'county / state'){
           
            
                if( $tip === 'ajax' ){
                    $input_name         =   $new_key;
                    $input_value        =   wp_kses($_POST[$new_key],$allowed_html);
                     
                }else{
                    $input_name         =   'advanced_contystate';
                    $input_value        =   wp_kses( $_REQUEST['advanced_contystate'],$allowed_html);
                              
                }
                                     
                    
                if (isset($_REQUEST[$input_name]) && $input_value!='all' && $input_value!='' ){
                    $taxcountystate   =     array();   
                    $taxcountystate[] =     wp_kses($input_value,$allowed_html);
           
                    $countystate_array = array(
                        'taxonomy'  => 'property_county_state',
                        'field'     => 'slug',
                        'terms'     => $taxcountystate
                    );
                }
        } 
        else{ 
          
            $term         =   str_replace(' ', '_', $term);
            $slug         =   wpestate_limit45(sanitize_title( $term )); 
            
            $slug         =   sanitize_key($slug);             
            //$string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );   
            $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );   
            
            //if ( $real$adv_search_what[$key]
            
            $slug_name    =   sanitize_key($string);
            
            $compare_array      =   array();
            $show_slider_price  =   get_option('wp_estate_show_slider_price','');
            
          
            if ( $adv_search_what[$key] === 'property country'){
                
                if( $tip === 'ajax' ){
                    $term_value= wp_kses( $_REQUEST[$new_key],$allowed_html);
                }else{
                    if(isset($_GET['advanced_country'])){
                        $term_value=  esc_html( wp_kses( $_GET['advanced_country'], $allowed_html) );
                    }
                }
                
                if( $term_value!='' && $term_value!='all' && $term_value!='all' &&  $term_value != $adv_search_label[$key]){
                    $compare_array['key']        = 'property_country';
                    $compare_array['value']      =  wp_kses($term_value,$allowed_html);
                    $compare_array['type']       = 'CHAR';
                    $compare_array['compare']    = 'LIKE';
                    $meta_query[]                = $compare_array;
                }
                
            }else if ( $adv_search_what[$key] === 'property price' && $show_slider_price ==='yes'){
                
                $compare_array['key']        = 'property_price';
                
                if( $tip === 'ajax' ){                   
                    $price_low  = floatval($_POST['slider_min']);
                    $price_max  = floatval($_POST['slider_max']);
                }else{
                    $price_low  = floatval( $_GET['price_low'] );
                    $price_max  = floatval( $_GET['price_max'] );
                }

                $custom_fields = get_option( 'wp_estate_multi_curr', true);
                if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                    $i=intval($_COOKIE['my_custom_curr_pos']);
                    $price_max       =   $price_max / $custom_fields[$i][2];
                    $price_low       =   $price_low / $custom_fields[$i][2];
                }
                
                $compare_array['key']        = 'property_price';
                $compare_array['value']      = array($price_low, $price_max);
                $compare_array['type']       = 'numeric';
                $compare_array['compare']    = 'BETWEEN';
                $meta_query[]                = $compare_array;
                
            }else{
                if( $tip === 'ajax' ){
                    $term_value= wp_kses( $_REQUEST[$new_key],$allowed_html);
                }else{
                    $term_value='';
                    
                 //   print '$slug_name '.$slug_name.'</br>';
                    if(isset($_GET[$slug_name])){
                        $term_value =  esc_html( wp_kses($_GET[$slug_name], $allowed_html) );
                    }
                }
                
                // rest of things
             //   print $adv_search_what[$key].' vs '.$term_value.'</br>';
                if( $adv_search_label[$key] != $term_value && $term_value != '' && $term_value != 'all'){ // if diffrent than the default values
                    $compare        =   '';
                    $search_type    =   ''; 
                    $allowed_html   =   array();
                    $compare        =   $adv_search_how[$key];

                    if($compare === 'equal'){
                       $compare         =   '='; 
                       $search_type     =   'numeric';
                       $term_value      =   floatval ($term_value );

                    }else if($compare === 'greater'){
                        $compare        = '>='; 
                        $search_type    = 'numeric';
                        $term_value     =  floatval ( $term_value );

                    }else if($compare === 'smaller'){
                        $compare        ='<='; 
                        $search_type    ='numeric';
                        $term_value     = floatval ( $term_value );

                    }else if($compare === 'like'){
                        $compare        = 'LIKE'; 
                        $search_type    = 'CHAR';
                       
                        $term_value     = wp_kses( $term_value ,$allowed_html);

                    }else if($compare === 'date bigger'){
                        $compare        ='>=';  
                        $search_type    ='DATE';
                        $term_value     =  str_replace(' ', '-', $term_value);
                        $term_value     = wp_kses( $term_value,$allowed_html );

                    }else if($compare === 'date smaller'){
                        $compare        = '<='; 
                        $search_type    = 'DATE';
                        $term_value     =  str_replace(' ', '-', $term_value);
                        $term_value     = wp_kses( $term_value,$allowed_html );
                    }

                    $compare_array['key']        = $slug;
                    $compare_array['value']      = $term_value;
                    $compare_array['type']       = $search_type;
                    $compare_array['compare']    = $compare;
                    $meta_query[]                = $compare_array;

                }// end if diffrent
            } 
        }////////////////// end last else
    } ///////////////////////////////////////////// end for each adv search term
    if($tip === 'search'){
        $meta_query = wpestate_add_feature_to_search($meta_query); 
    }
    if($tip === 'ajax'){
       $meta_query = wpestate_add_feature_to_search_ajax($meta_query);
    }
    
    
    
    if($tip === 'search'){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if($paged>1){
            $meta_query         =   get_option('wpestate_pagination_meta_query','');
            $categ_array        =   get_option('wpestate_pagination_categ_query','');
            $action_array       =   get_option('wpestate_pagination_action_query','');
            $city_array         =   get_option('wpestate_pagination_city_query','');
            $area_array         =   get_option('wpestate_pagination_area_query','');
            $county_state_array =   get_option('wpestate_pagination_county_state_query','');
        }else{
            update_option('wpestate_pagination_meta_query',$meta_query);
            update_option('wpestate_pagination_categ_query',$categ_array);
            update_option('wpestate_pagination_action_query',$action_array);
            update_option('wpestate_pagination_city_query',$city_array);
            update_option('wpestate_pagination_area_query',$area_array);
            update_option('wpestate_pagination_county_state_query',$countystate_array);
        }
    }
    
    if($tip === 'ajax'){
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
    }
    
    
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                'relation' => 'AND',
                                $categ_array,
                                $action_array,
                                $city_array,
                                $area_array,
                                $countystate_array
                            )
    );  
//  print '</br></br>';
//  print_r($_GET);
//  print '</br></br>';    
//  print_r($real_custom_fields);
// print '</br></br>';
// print_r($args);
return $args;
    
    
    
}
endif;










if(!function_exists('wpestate_search_results_default')):
function wpestate_search_results_default($tip=''){
    
    $area_array         =   ''; 
    $city_array         =   '';  
    $action_array       =   '';
    $categ_array        =   '';
    $id_array           =   '';
    $countystate_array  =   '';
    $allowed_html       =   array();
    
    if($tip === 'ajax'){
        $type_name      =   'category_values';
        $type_name_value=   wp_kses( $_REQUEST[$type_name] ,$allowed_html );
        $action_name    =   'action_values';
        $action_name_value  = wp_kses( $_REQUEST[$action_name] ,$allowed_html );
        $city_name      =   'city';
        $area_name      =   'area';
        $rooms_name     =   'advanced_rooms';
        $bath_name      =   'advanced_bath';
        $price_low_name =   'price_low';
        $price_max_name =   'price_max';
    }else{
        $type_name          =   'filter_search_type';
        $type_name_value    =   wp_kses( $_REQUEST[$type_name][0] ,$allowed_html );
        $action_name        =   'filter_search_action';
        $action_name_value  =    wp_kses( $_REQUEST[$action_name][0],$allowed_html );
        
        
        $city_name      =   'advanced_city';
        $area_name      =   'advanced_area';
        $rooms_name     =   'advanced_rooms';
        $bath_name      =   'advanced_bath';
        $price_low_name =   'price_low';
        $price_max_name =   'price_max';
    }

    if ( $type_name_value!='all' && $type_name_value!='' ){
        $taxcateg_include   =   array();     
        $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );
           
        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( $action_name_value !='all' && $action_name_value !='') {
        $taxaction_include   =   array();   
        $taxaction_include   =   sanitize_title ( wp_kses( $action_name_value ,$allowed_html) );   
        
        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
     }


    
    if (isset($_REQUEST[$city_name]) and $_REQUEST[$city_name] != 'all' && $_REQUEST[$city_name] != '') {
        $taxcity[] = sanitize_title ( wp_kses ( $_REQUEST[$city_name],$allowed_html ) );
        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxcity
         );
     }

 
    if (isset($_REQUEST[$area_name]) and $_REQUEST[$area_name] != 'all' && $_REQUEST[$area_name] != '') {
        $taxarea[] = sanitize_title ( wp_kses ($_REQUEST[$area_name],$allowed_html) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxarea
        );
     }

   
    
    $meta_query = $rooms = $baths = $price = array();
    if (isset($_REQUEST[$rooms_name]) && is_numeric($_REQUEST[$rooms_name])) {
        $rooms['key'] = 'property_bedrooms';
        $rooms['value'] = floatval ($_REQUEST[$rooms_name]);
        $meta_query[] = $rooms;
    }

    if (isset($_REQUEST[$bath_name]) && is_numeric($_REQUEST[$bath_name])) {
        $baths['key'] = 'property_bathrooms';
        $baths['value'] = floatval ($_REQUEST[$bath_name]);
        $meta_query[] = $baths;
    }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_REQUEST[$price_low_name])){
        $price_low = floatval($_REQUEST[$price_low_name]);
    }

    $price_max='';
    $custom_fields = get_option( 'wp_estate_multi_curr', true);
              
      
    if( isset($_REQUEST[$price_max_name])  && $_REQUEST[$price_max_name] && floatval($_REQUEST[$price_max_name])>0 ){
            $price_max          = floatval($_REQUEST[$price_max_name]);
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_max       =   $price_max / $custom_fields[$i][2];
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
            
            $price['key']       = 'property_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
    }else {
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
      
            $price['key']       = 'property_price';
            $price['value']     =  $price_low;
            $price['type']      = 'numeric';
            $price['compare']   = '>=';
            $meta_query[]       = $price;
    }


 
     if($tip === 'search'){
        $meta_query = wpestate_add_feature_to_search($meta_query); 
    }
    if($tip === 'ajax'){
       $meta_query = wpestate_add_feature_to_search_ajax($meta_query);
    }
    
    
    $meta_order         =   'prop_featured';
    $meta_directions    =   'DESC';   
    $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
                case 1:
                    $meta_order='property_price';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 2:
                    $meta_order='property_price';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 3:
                    $meta_order='';
                    $meta_directions='DESC';
                    $order_by='ID';
                    break;
                case 4:
                    $meta_order='';
                    $meta_directions='ASC';
                    $order_by='ID';
                    break;
                case 5:
                    $meta_order='property_bedrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 6:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
                case 7:
                    $meta_order='property_bathrooms';
                    $meta_directions='DESC';
                    $order_by='meta_value_num';
                    break;
                case 8:
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }

    
    
    
    
    if($tip === 'search'){
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if($paged>1){
            $meta_query         =   get_option('wpestate_pagination_meta_query','');
            $categ_array        =   get_option('wpestate_pagination_categ_query','');
            $action_array       =   get_option('wpestate_pagination_action_query','');
            $city_array         =   get_option('wpestate_pagination_city_query','');
            $area_array         =   get_option('wpestate_pagination_area_query','');
            $county_state_array =   get_option('wpestate_pagination_county_state_query','');
        }else{
            update_option('wpestate_pagination_meta_query',$meta_query);
            update_option('wpestate_pagination_categ_query',$categ_array);
            update_option('wpestate_pagination_action_query',$action_array);
            update_option('wpestate_pagination_city_query',$city_array);
            update_option('wpestate_pagination_area_query',$area_array);
            update_option('wpestate_pagination_county_state_query',$countystate_array);
        }
    }
    
    if($tip === 'ajax'){
        $paged      =   intval($_POST['newpage']);
    }
    $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
    
    
    
    
    
    
    
    
    
    
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => $prop_no,
        'meta_key'        => $meta_order,
        'orderby'         => $order_by,
        'order'           => $meta_directions,
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                'relation' => 'AND',
                                $categ_array,
                                $action_array,
                                $city_array,
                                $area_array,
                              
                            )
    );      
   // print_R($args);
    return $args;
    
}
endif;



if(!function_exists('wpestate_add_feature_to_search_ajax')):
function wpestate_add_feature_to_search_ajax($meta_query){
    $allowed_html=array();
  
    $all_checkers=explode(",", wp_kses($_POST['all_checkers'],$allowed_html) );

    foreach ($all_checkers as $cheker){
        if($cheker!=''){
            $post_var_name  =   str_replace(' ','_', trim($cheker) );
            $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
            $input_name     =   sanitize_key($input_name);

            $check_array    =   array();
            $check_array['key']   =   $input_name;
            $check_array['value'] =  1;
            $check_array['compare']     = 'CHAR';
            $meta_query[]   =   $check_array;
        }        
    }
    
    
    
    return $meta_query;
}
endif;
















if(!function_exists('wpestate_add_feature_to_search')):
function wpestate_add_feature_to_search($meta_query){
    $feature_list_array =   array();
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);

    foreach($feature_list_array as $checker => $value){
        $post_var_name  =   str_replace(' ','_', trim($value) );
        $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
        $input_name     =   sanitize_key($input_name);

        if ( isset( $_REQUEST[$input_name] ) && $_REQUEST[$input_name]==1 ){

            $feature=array();
            $feature['key']         = $input_name;
            $feature['value']       = 1;
            $feature['type']        = '=';
            $feature['compare']     = 'CHAR';
            $meta_query[]           = $feature;
        }
    }
    return $meta_query;
}
endif;














if(!function_exists('wpestated_advanced_search_tip2')):
function wpestated_advanced_search_tip2(){
    $categ_array        =   '';
    $action_array       =   '';
    $area_array         =  ''; 
    $city_array         =  ''; 
    $countystate_array  =  '';
    $location_array     =  '';
    $meta_query         =   array();
    $allowed_html       =   array();
    
    if (isset($_GET['filter_search_type']) && $_GET['filter_search_type'][0]!='all' && $_GET['filter_search_type'][0]!='' ){
        $taxcateg_include   =   array();

        foreach($_GET['filter_search_type'] as $key=>$value){
            $taxcateg_include[]= sanitize_title (  esc_html( wp_kses($value, $allowed_html ) ) );
        }

        $categ_array=array(
            'taxonomy'     => 'property_category',
            'field'        => 'slug',
            'terms'        => $taxcateg_include
        );
    }

    if ( ( isset($_GET['filter_search_action']) && $_GET['filter_search_action'][0]!='all' && $_GET['filter_search_action'][0]!='') ){
        $taxaction_include   =   array();   

        foreach( $_GET['filter_search_action'] as $key=>$value){
            $taxaction_include[]    = sanitize_title ( esc_html (  wp_kses($value, $allowed_html ) ) );
        }

        $action_array=array(
             'taxonomy'     => 'property_action_category',
             'field'        => 'slug',
             'terms'        => $taxaction_include
        );
    }
     
    if ( isset($_GET['adv_location']) && $_GET['adv_location']!='') {
        $taxlocation[] = sanitize_title (  esc_html( wp_kses($_GET['adv_location'], $allowed_html) ) );
        $area_array = array(
            'taxonomy'     => 'property_area',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );

        $city_array = array(
            'taxonomy'     => 'property_city',
            'field'        => 'slug',
            'terms'        => $taxlocation
        );
        
        $countystate_array = array(
            'taxonomy'      => 'property_county_state',
            'field'         => 'slug',
            'terms'         => $taxlocation
        );
        $location_array     = array( 
                                    'relation' => 'OR',
                                    $city_array,
                                    $area_array,
                                    $countystate_array
                                );
        }
     
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    /*
    if($paged>1){

       $meta_query= get_option('wpestate_pagination_meta_query','');
       $categ_array= get_option('wpestate_pagination_categ_query','');
       $action_array= get_option('wpestate_pagination_action_query','');
       $city_array= get_option('wpestate_pagination_city_query','');
       $area_array=get_option('wpestate_pagination_area_query','');
       $county_state_array=get_option('wpestate_pagination_county_state_query','');
    }else{
        update_option('wpestate_pagination_meta_query',$meta_query);
        update_option('wpestate_pagination_categ_query',$categ_array);
        update_option('wpestate_pagination_action_query',$action_array);
        update_option('wpestate_pagination_city_query',$city_array);
        update_option('wpestate_pagination_area_query',$area_array);
        update_option('wpestate_pagination_county_state_query',$countystate_array);
    }
    */
        
        
    $args = array(
        'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
        
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $location_array
                               )
    );
    
    return ($args);
 
}
endif;




if(!function_exists('wpestate_show_search_params')):
function wpestate_show_search_params($args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label){
  
  // print_R($args);
    if( isset($args['tax_query'] )){
           
        foreach($args['tax_query'] as $key=>$query ){

          // print_r($query);
            
          /*  if(is_array($query)){
                print 'is array ';
                print ' / '. $query['taxonomy'];
            }
            */

            if( isset($query['relation'] ) && $query['relation']==='OR' ){
                $value=$query[0]['terms'][0];
                $value=  ucwords(str_replace('-', ' ', $value));
                print '<strong>'.__('County, City or Area is ','wpestate').':</strong> '.rawurldecode($value);    
            }
            
          // had  $query['terms'][0] 
            if ( isset($query['taxonomy']) && isset( $query['terms']) && $query['taxonomy'] == 'property_category'){
                
                if( is_array( $query['terms'] ) ){
                    $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
            
                $page = get_term_by( 'slug',$term ,'property_category');
                if(isset($page->name)){
                    print '<strong>'.__('Category','wpestate').':</strong> '. $page->name .', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset( $query['terms'] ) && $query['taxonomy']=='property_action_category' ){
                
                if( is_array( $query['terms'] ) ){
                   $term = $query['terms'][0];
                }else{
                    $term=$query['terms'];
                }
           
                
                $page = get_term_by( 'slug',$term,'property_action_category');
                
                if(isset($page->name)){
                    print '<strong>'.__('For','wpestate').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_city'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_city');
                if(isset($page->name)){
                    print '<strong>'.__('City','wpestate').':</strong> '.$page->name.', ';  
                }
            }

            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_area'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_area');
                if(isset($page->name)){
                    print '<strong>'.__('Area','wpestate').':</strong> '.$page->name.', ';  
                }
            }
            if ( isset($query['taxonomy']) && isset($query['terms']) && $query['taxonomy']=='property_county_state'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_county_state');
                if(isset($page->name)){
                    print '<strong>'.__('County / State','wpestate').':</strong> '.$page->name.', ';  
                }
            }
         
        }
    }
    
    // print_r($args);
    $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

    if( isset($args['meta_query'] ) && $args['meta_query']!='' ){
        foreach($args['meta_query'] as $key=>$query ){
            $admin_submission_array=array(
                        'types'             =>__('types','wpestate'),
                        'categories'        =>__('categories','wpestate'),
                        'cities'            =>__('cities','wpestate'),
                        'areas'             =>__('areas','wpestate'),
                        'property price'    =>__('property price','wpestate'),
                        'property size'     =>__('property size','wpestate'),
                        'property lot size' =>__('property lot size','wpestate'),
                        'property rooms'    =>__('property rooms','wpestate'),
                        'property bedrooms' =>__('property bedrooms','wpestate'),
                        'property bathrooms'=>__('property bathrooms','wpestate'),
                        'property address'  =>__('property address','wpestate'),
                        'property county'   =>__('property county','wpestate'),
                        'property state'    =>__('property state','wpestate'),
                        'property zip'      =>__('property zip','wpestate'),
                        'property country'  =>__('property country','wpestate'),
                        'property status'   =>__('property status','wpestate')
            );
            $label=str_replace('_',' ',$query['key']);

            if(array_key_exists ($label, $admin_submission_array)){
               $label=$admin_submission_array[$label];
            }
            
            if($custom_advanced_search==='yes'){
                $custm_name = wpestate_get_custom_field_name($query['key'],$adv_search_what,$adv_search_label);
            
                if ( isset($query['compare']) ){
                    if ($query['compare']=='BETWEEN'){
                  
                            if($query['key']=='property_price'){
                                if($query['value'][0]==0){
                                    $min_val=0;
                                }else{
                                     $min_val=wpestate_show_price_floor($query['value'][0],$currency,$where_currency,1);
                                }
                                print '<strong>'.__('price range from: ','wpestate').'</strong> '. $min_val.' '.__('to','wpestate').' '.wpestate_show_price_floor($query['value'][1],$currency,$where_currency,1);   
                            }else{
                                print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query['value'].', ';   
                            }
                        
                    }else if ($query['compare']=='LIKE'){
                        print $label. __(' similar with ','wpestate').' <strong>'.str_replace('_',' ',$query['value']).'</strong>, '; 
                    
                        
                    }else if ($query['compare']=='CHAR'){
                        print __(' has','wpestate').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';       
                    
                        
                    }else if ($query['compare']=='='){
                        print '<strong>'.$custm_name.'</strong> '. __(' equal with ','wpestate').' <strong>'.$query['value'].'</strong>, ';    
                        
                    }else if ( $query['compare'] == '<=' ){
                        if($query['key']=='property_price'){
                            if(isset($query['value'])){
                                print wpestate_show_price_floor($query['value'],$currency,$where_currency,1); 
                            }
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.__('smaller than ','wpestate').' '.$query['value'].', '; 
                        }

                    }else{  
                        if(isset($query['value'])){
                            if($query['key']=='property_price'){
                                print '<strong>'.__('price range from ','wpestate').'</strong> '. wpestate_show_price_floor($query['value'],$currency,$where_currency,1).' '.__('to','wpestate').' ';   
                            }else{
                                print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query['value'].', ';   
                            }
                        }
                    }                
                }else{
                    print '<strong>'.$custm_name.':</strong> '.$query['value'].', ';
                } //end elese query compare


            }else{
                if ( isset( $query['compare'] ) ){
                    $custm_name = wpestate_get_custom_field_name($query['key'],$adv_search_what,$adv_search_label);

                    if ( $query['compare'] == 'CHAR' ){
                        print __(' has','wpestate').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';     
                    }else if ( $query['compare'] == '<=' ){
                        if($query['key']=='property_price'){
                          
                            print wpestate_show_price_floor($query['value'],$currency,$where_currency,1); 
                            
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.__('smaller than ','wpestate').' '. wpestate_show_price_floor($query['value'],$currency,$where_currency,1) .', '; 
                        }          
                    } else{
                         if($query['key']=='property_price'){
                            if($query['value'][0]==0){
                                $min_val=0;
                            }else{
                                 $min_val=wpestate_show_price_floor($query['value'][0],$currency,$where_currency,1);
                            }
                            print '<strong>'.__('price range from: ','wpestate').'</strong> '. $min_val.' '.__('to','wpestate').' '.wpestate_show_price_floor($query['value'][1],$currency,$where_currency,1);   
                        }else{
                            print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query['value'].', ';   
                        }        
                    }

                }else{
                    print '<strong>'.$label.':</strong> '.$query['value'].', ';
                } //end elese query compare

            }//end else if custom adv search

        }
    }

}
endif;

if( !function_exists('wpestate_search_with_keyword')):
function wpestate_search_with_keyword($adv_search_what,$adv_search_label ){
    $keyword=''; 
    $return_custom='';
    $id_array='';
    $allowed_html =array();
    foreach($adv_search_what as $key=>$term ){
        if( $term === 'keyword' ){
           
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            $return_custom['keyword']      =    esc_attr(  wp_kses ( $_GET[$slug_name], $allowed_html) );
           
        }else if($term === 'property id' ){
            
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            
            if(isset($_GET[$slug_name])){
                $id_array     =     intval ($_GET[$slug_name]);
            }
            $return_custom['id_array'] = $id_array;        
            
        }   
        
            
    }
    return $return_custom;
}
endif;


if( !function_exists('wpestate_search_with_keyword_ajax')):
function wpestate_search_with_keyword_ajax($adv_search_what,$adv_search_label ){
    $keyword=''; 
    $allowed_html   =   array();
    $new_key        =   0;
    foreach($adv_search_what as $key=>$term ){
        if( $term === 'keyword' ){
            $new_key    =   $key+1;  
            $new_key    =   'val'.$new_key;
            $keyword= wp_kses( $_POST[$new_key],$allowed_html );
       }
    }
    return $keyword;
}
endif;