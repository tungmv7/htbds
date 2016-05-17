<?php 
$show_adv_search_status     =   get_option('wp_estate_show_adv_search','');
$global_header_type         =   get_option('wp_estate_header_type','');
$adv_search_type            =   get_option('wp_estate_adv_search_type','');
?>
<div class="header_media with_search_<?php echo esc_html($adv_search_type);?>">

    <?php
if ( is_category() || is_tax() || is_archive() || is_search() ){
    $header_type=0;
}else{
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
}

if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
    $custom_image               =   esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
    $rev_slider                 =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 
    
    
    ////////////////////////////////////////////////////////////////////////////
    // if taxonomy
    ////////////////////////////////////////////////////////////////////////////
    if( is_tax() ){
        $taxonmy    =   get_query_var('taxonomy');
        if ( $taxonmy !=='property_action_category' && $taxonmy!='property_category'  ){
            global $term_data;
            $term       =   get_query_var( 'term' );
            $term_data  =   get_term_by('slug', $term, $taxonmy);
            $place_id   =   $term_data->term_id;
            $term_meta  =   get_option( "taxonomy_$place_id");
            if( isset($term_meta['category_featured_image']) && $term_meta['category_featured_image']!='' ){
               $header_type=7;
            }
        }
      
    }
    
    ////////////////////////////////////////////////////////////////////////////
    // if property page
    ////////////////////////////////////////////////////////////////////////////
    
    
    if(is_singular('estate_property')){
        $prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );
        $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);
          
        if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'full width header'){
            $header_type=8;
        }
        if($local_pgpr_slider_type_status=='full width header'){
            $header_type=8;
        }
    }
    
    
    
     
    if (!$header_type==0){  // is not global settings
          switch ($header_type) {
            case 1://none
                break;
            case 2://image
                print '<img src="'.$custom_image.'"  class="img-responsive" alt="header_image"/>';
                break;
            case 3://theme slider
                wpestate_present_theme_slider();
                break;
            case 4://revolutin slider
                putRevSlider($rev_slider);
                break;
            case 5://google maps
                get_template_part('templates/google_maps_base'); 
                break;
            case 7://google maps
                get_template_part('templates/header_taxonomy'); 
                break;
            case 8:
                wpestate_listing_full_width_slider($post->ID);
                break;
          }
        
         
            
    }else{    // we don't have particular settings - applt global header
          switch ($global_header_type) {
            case 0://image
                break;
            case 1://image
                $global_header  =   get_option('wp_estate_global_header','');
                print '<img src="'.$global_header.'"  class="img-responsive" class="headerimg" alt="header_image"/>';
                break;
            case 2://theme slider
                wpestate_present_theme_slider();
                break;
            case 3://revolutin slider
                 $global_revolution_slider   =  get_option('wp_estate_global_revolution_slider','');
                 putRevSlider($global_revolution_slider);
                break;
            case 4://google maps
                get_template_part('templates/google_maps_base'); 
                break;
            case 8:
                wpestate_listing_full_width_slider($post->ID);
                break;
          }
    
    } // end if header
}
    

    
    
    

    
                     
?>
    
<?php
$show_adv_search_general    =   get_option('wp_estate_show_adv_search_general','');

$global_header_type         =   get_option('wp_estate_header_type','');
$show_adv_search_slider     =   get_option('wp_estate_show_adv_search_slider','');
$show_mobile                =   0;  

if ( is_category() || is_tax() || is_archive() || is_search() ){
    $header_type=0;
}else{
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
}
    
if($show_adv_search_general ==  'yes' && !is_404() && !is_page_template('property_list_half.php')){
    
    if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
        if($header_type == 1){
          //nothing  
        }else if($header_type == 0){ 
            if($global_header_type==4){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
            }else if( $global_header_type==0){
               //nonthing 
            }else{
                if($show_adv_search_slider=='yes'){
                    $show_mobile=1;
                    get_template_part('templates/advanced_search');  
                }
            }

        }else if($header_type == 5){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
        }else{
             if($show_adv_search_slider=='yes'){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
            }
        }  
    }
}
?>   
</div>

<?php 

if( $show_mobile == 1 ){
    get_template_part('templates/adv_search_mobile');
}
?>