<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;
global $prop_unit;

$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';
$show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);
$current_adv_filter_search_meta     = 'All Actions';
$current_adv_filter_category_meta   = 'All Types';
$current_adv_filter_city_meta       = 'All Cities';
$current_adv_filter_area_meta       = 'All Areas';
$current_adv_filter_county_meta       = 'All Counties/States';       
if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =__('All Actions','wpestate');
    $current_adv_filter_category_label  =__('All Types','wpestate');
    $current_adv_filter_city_label      =__('All Cities','wpestate');
    $current_adv_filter_area_label      =__('All Areas','wpestate');
    $current_adv_filter_county_label    =__('All Counties/States','wpestate');
    
    $taxonmy                            = get_query_var('taxonomy');
//  $term                               = get_query_var( 'name' );
    $term                               = single_cat_title('',false);
    
    
    
    if ($taxonmy == 'property_city_agent'){
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_city_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_area_agent'){
        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_area_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_action_category_agent'){
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_category_meta   =   sanitize_title($term);
    }
    if ($taxonmy == 'property_action_category_agent'){
        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_search_meta     =   sanitize_title($term);
    }
     if ($taxonmy == 'property_county_state'){
        $current_adv_filter_county_label    =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_county_meta     =   sanitize_title($term);
    }
    
}


?>


<div data-toggle="dropdown" id="second_filter_action" class="hide" data-value="<?php print $current_adv_filter_search_meta;?>"> <?php print esc_html($current_adv_filter_search_label);?>  </div>           
<div data-toggle="dropdown" id="second_filter_categ" class="hide" data-value="<?php print $current_adv_filter_category_meta;?> "> <?php print esc_html($current_adv_filter_category_label);?> </div>           
<div data-toggle="dropdown" id="second_filter_cities" class="hide" data-value="<?php print $current_adv_filter_city_meta;?>"> <?php print esc_html($current_adv_filter_city_label);?>  </div>           
<div data-toggle="dropdown" id="second_filter_areas"  class="hide" data-value="<?php print $current_adv_filter_area_meta;?>"><?php print esc_html($current_adv_filter_area_label);?></div>           
<div data-toggle="dropdown" id="second_filter_county"  class="hide" data-value=""><?php print esc_html($current_adv_filter_county_label);?></div>           
      