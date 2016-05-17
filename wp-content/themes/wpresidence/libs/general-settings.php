<?php


if( !function_exists('wpestate_show_price_label_slider') ):
function wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency){

    $th_separator       =  stripslashes(  get_option('wp_estate_prices_th_separator','') );
    
        
    $custom_fields = get_option( 'wp_estate_multi_curr', true);
    //print_r($_COOKIE);
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        
        if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
            $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
            $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
        }
        
        $currency               =   $custom_fields[$i][0];
        $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
        $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
        
        if ($custom_fields[$i][3] == 'before') {  
            $price_slider_label = $currency .' '. $min_price_slider.' '.__('to','wpestate').' '.$currency .' '. $max_price_slider;      
        } else {
            $price_slider_label =  $min_price_slider.' '.$currency.' '.__('to','wpestate').' '.$max_price_slider.' '.$currency;      
        }
        
    }else{
        $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
        $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
        
        if ($where_currency == 'before') {
            $price_slider_label = $currency .' '.($min_price_slider).' '.__('to','wpestate').' '.$currency .' ' .$max_price_slider;
        } else {
            $price_slider_label =  $min_price_slider.' '.$currency.' '.__('to','wpestate').' '.$max_price_slider.' '.$currency;
        }  
    }
    
    return $price_slider_label;
                            
    
}
endif;


///////////////////////////////////////////////////////////////////////////////////////////
/////// disable toolbar for subscribers
///////////////////////////////////////////////////////////////////////////////////////////

if (!current_user_can('manage_options') ) { show_admin_bar(false); }

///////////////////////////////////////////////////////////////////////////////////////////
/////// Define thumb sizes
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_image_size') ): 
    function wpestate_image_size(){
        add_image_size('user_picture_profile', 255, 143, true);
        add_image_size('agent_picture_single_page', 320, 180, true);
        add_image_size('agent_picture_thumb' , 120, 120, true);
        add_image_size('blog_thumb'          , 272, 189, true);
        add_image_size('blog_unit'           , 1110, 385, true);
        add_image_size('slider_thumb'        , 143,  83, true);
        add_image_size('property_featured_sidebar',261,225,true);
        add_image_size('blog-full'           , 940, 529, true);
        add_image_size('property_listings'   , 525, 328, true); // 1.62 was 265/163 until v1.12
        add_image_size('property_full'       , 980, 777, true);
        add_image_size('listing_full_slider' , 835, 467, true);
        add_image_size('listing_full_slider_1', 1110, 623, true);
        add_image_size('property_featured'   , 940, 390, true);
        add_image_size('property_full_map'   , 1920, 790, true);
        add_image_size('property_map1'       , 400, 161, true);
        add_image_size('widget_thumb'        , 105, 70, true);
        add_image_size('user_thumb'          , 45, 45, true);
        add_image_size('custom_slider_thumb'          , 36, 36, true);
        
        set_post_thumbnail_size(  250, 220, true);
    }
endif;
///////////////////////////////////////////////////////////////////////////////////////////
/////// register sidebars
///////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wpestate_widgets_init') ):
function wpestate_widgets_init() {
    register_nav_menu( 'primary', __( 'Primary Menu', 'wpestate' ) ); 
    register_nav_menu( 'mobile', __( 'Mobile Menu', 'wpestate' ) ); 
    register_nav_menu( 'footer_menu', __( 'Footer Menu', 'wpestate' ) ); 
    
    register_sidebar(array(
        'name' => __('Primary Widget Area', 'wpestate'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Secondary Widget Area', 'wpestate'),
        'id' => 'secondary-widget-area',
        'description' => __('The secondary widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('First Footer Widget Area', 'wpestate'),
        'id' => 'first-footer-widget-area',
        'description' => __('The first footer widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Second Footer Widget Area', 'wpestate'),
        'id' => 'second-footer-widget-area',
        'description' => __('The second footer widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Third Footer Widget Area', 'wpestate'),
        'id' => 'third-footer-widget-area',
        'description' => __('The third footer widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => __('Fourth Footer Widget Area', 'wpestate'),
        'id' => 'fourth-footer-widget-area',
        'description' => __('The fourth footer widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));
    
    
    register_sidebar(array(
        'name' => __('Top Bar Left Widget Area', 'wpestate'),
        'id' => 'top-bar-left-widget-area',
        'description' => __('The top bar left widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
       
    register_sidebar(array(
        'name' => __('Top Bar Right Widget Area', 'wpestate'),
        'id' => 'top-bar-right-widget-area',
        'description' => __('The top bar right widget area', 'wpestate'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
       
       
}
endif; // end   wpestate_widgets_init  


/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt
/////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wp_estate_excerpt_length') ):
    function wp_estate_excerpt_length($length) {
        return 64;
    }
endif; // end   wp_estate_excerpt_length  


/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt more
/////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_new_excerpt_more') ):
    function wpestate_new_excerpt_more( $more ) {
        return ' ...';
    }
endif; // end   wpestate_new_excerpt_more  



/////////////////////////////////////////////////////////////////////////////////////////
///// strip words
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_strip_words') ):
    function wpestate_strip_words($text, $words_no) {
        
       
        $temp = explode(' ', $text, ($words_no + 1));
        if (count($temp) > $words_no) {
            array_pop($temp);
        }
        return implode(' ', $temp);
          }
endif; // end   wpestate_strip_words 


if( !function_exists('wpestate_strip_excerpt_by_char') ):
    function wpestate_strip_excerpt_by_char($text, $chars_no) {
        $return_string  = '';
        $return_string  =  mb_substr( $text,0,$chars_no); 
            if(mb_strlen($text)>$chars_no){
                $return_string.= ' ...';   
            } 
        return $return_string;
        }
        
endif; // end   wpestate_strip_words 




/////////////////////////////////////////////////////////////////////////////////////////
///// add extra div for wp embeds
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_embed_html') ): 
    function wpestate_embed_html( $html ) {
        if (strpos($html,'twitter') !== false) {
            return '<div class="video-container-tw">' . $html . '</div>';
        }else{
            return '<div class="video-container">' . $html . '</div>';
        }

    }
endif;
add_filter( 'embed_oembed_html', 'wpestate_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'wpestate_embed_html' ); // Jetpack

/////////////////////////////////////////////////////////////////////////////////////////
///// html in conmment
/////////////////////////////////////////////////////////////////////////////////////////
add_action('init', 'wpestate_html_tags_code', 10);

if( !function_exists('wpestate_html_tags_code') ): 
    function wpestate_html_tags_code() {

      global $allowedposttags, $allowedtags;
      $allowedposttags = array(
          'strong' => array(),
          'em' => array(),
          'pre' => array(),
          'code' => array(),
          'a' => array(
            'href' => array (),
            'title' => array ())
      );

      $allowedtags = array(
          'strong' => array(),
          'em' => array(),
          'pre' => array(),
          'code' => array(),
          'a' => array(
            'href' => array (),
            'title' => array ())
      );
    }
endif;

?>