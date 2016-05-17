<?php
// Template Name: Advanced Search Results
// Wp Estate Pack
global $keyword;
wp_cache_flush();
get_header();
$current_user = wp_get_current_user();
set_time_limit (0);
    
$options            =   wpestate_page_details($post->ID);
$show_compare       =   1;
$area_array         =   ''; 
$city_array         =   '';  
$action_array       =   '';
$categ_array        =   '';
$id_array           =   '';
$countystate_array  =   '';

$compare_submit         =   get_compare_link();
$currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$prop_no                =   intval ( get_option('wp_estate_prop_no', '') );
$show_compare_link      =   'yes';
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.$userID;
$curent_fav             =   get_option($user_option);
$custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
$meta_query             =   array();
           
$adv_search_what        =   '';
$adv_search_how         =   '';
$adv_search_label       =   '';             
$adv_search_type        =   '';   
$adv_search_type        =   get_option('wp_estate_adv_search_type','');  

$prop_unit          =   esc_html ( get_option('wp_estate_prop_unit','') );
$prop_unit_class    =   '';
$align_class        =   '';
if($prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$adv_search_what    =   get_option('wp_estate_adv_search_what','');
$adv_search_how     =   get_option('wp_estate_adv_search_how','');
$adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
$adv_search_type    =   get_option('wp_estate_adv_search_type','');

$adv_search_type        =   get_option('wp_estate_adv_search_type','');  

if( !isset($_GET['is2']) ){
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type1 or type 3
    //////////////////////////////////////////////////////////////////////////////////////
    if( $custom_advanced_search==='yes' ){
        $args = $mapargs    =   wpestate_search_results_custom ('search');        
        $return_custom      =   wpestate_search_with_keyword($adv_search_what, $adv_search_label);

       
        if(isset($return_custom['keyword'])){
            $keyword        =   $return_custom['keyword'];
          
        }

        if(isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
        }

    }else{
        $args = $mapargs = wpestate_search_results_default ('search');
    }

}else{
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type 2 city.area,state
    //////////////////////////////////////////////////////////////////////////////////////
    $args=wpestated_advanced_search_tip2();
    $mapargs = array(
        'post_type'      =>  'estate_property',
        'post_status'    =>  'publish',
        'nopaging'       =>  'true',
        'cache_results'  => false,
        'paged'           => $paged,
        'posts_per_page'  => 30,
    );
   $mapargs=$args;
}


if( !empty($id_array)){
    $args=  array(  'post_type'     => 'estate_property',
                    'p'           =>    $id_array
            );
    $prop_selection =   new WP_Query( $args);

}else{

    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    add_filter( 'posts_orderby', 'wpestate_my_order' );
    if( !empty($keyword) ){
       add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
    $prop_selection =   new WP_Query($args);
    remove_filter( 'posts_orderby', 'wpestate_my_order' );

    if( !empty($keyword) ){
        remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
}

//print_r($args);

   
// print_r($prop_selection);
$num = $prop_selection->found_posts;
$selected_pins  =   wpestate_listing_pins($mapargs,1);//call the new pins  
   
$property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));
$half_map_results = 0;


if ( $property_list_type_status == 2 ){
    get_template_part('templates/half_map_core');
    $half_map_results=1;
    
}else{
    get_template_part('templates/normal_map_core'); 
}






$adv_search_type        =   get_option('wp_estate_adv_search_type','');        
if ($adv_search_type==1){

    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
        array(  
           // 'markers2'           =>  $selected_pins,
            'half_map_results'   => $half_map_results
        )
    );
}else{
    if ( get_option('wp_estate_readsys','') =='yes' ){
        $path=estate_get_pin_file_path();
        $json_string=file_get_contents($path);       
    }else{
        $json_string= wpestate_listing_pins();
    }
        
        
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
        array(  
          //  'markers2'           =>  $json_string,
            'half_map_results'   => $half_map_results
        )
    );
   
}

get_footer(); 
?>