<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;
global $prop_unit;

$current_name      =    '';
$current_slug      =    '';
$listings_list     =    '';
$show_filter_area  =    '';

if( isset($post->ID) ){
    $show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);
}

$current_adv_filter_search_meta     = 'All Actions';
$current_adv_filter_category_meta   = 'Tất cả';
$current_adv_filter_city_meta       = 'Tất cả';
$current_adv_filter_area_meta       = 'All Areas';
$current_adv_filter_county_meta       = 'All Counties/States';
        
if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =__('All Actions','wpestate');
    $current_adv_filter_category_label  =__('Loại','wpestate');
    $current_adv_filter_city_label      =__('Thành phố','wpestate');
    $current_adv_filter_area_label      =__('All Areas','wpestate');

    
    $taxonmy                            = get_query_var('taxonomy');
    $term                               = single_cat_title('',false);
    
    
    
    if ($taxonmy == 'property_city'){
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_city_meta   =   sanitize_title($term);
    }
//    if ($taxonmy == 'property_area'){
//        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$term) );
//        $current_adv_filter_area_meta   =   sanitize_title($term);
//    }
    if ($taxonmy == 'property_category'){
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$term) );
        $current_adv_filter_category_meta   =   sanitize_title($term);
    }
//    if ($taxonmy == 'property_action_category'){
//        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$term) );
//        $current_adv_filter_search_meta     =   sanitize_title($term);
//    }
//    if ($taxonmy == 'property_county_state'){
//        $current_adv_filter_county_label    =   ucwords( str_replace('-',' ',$term) );
//        $current_adv_filter_county_meta     =   sanitize_title($term);
//    }
    
}


if(is_page_template('property_list.php')){
    
//    $current_adv_filter_search_action   =   get_post_meta ( $post->ID, 'adv_filter_search_action', true);
//    if($current_adv_filter_search_action[0]=='all'){
//        $current_adv_filter_search_label    =__('All Actions','wpestate');
//        $current_adv_filter_search_meta     = 'All Actions';
//    }else{
//        $current_adv_filter_search_label    =   ucwords( str_replace('-',' ',$current_adv_filter_search_action[0]) );
//        $current_adv_filter_search_meta     =   sanitize_title($current_adv_filter_search_action[0]);
//    }
   

    $current_adv_filter_search_category =   get_post_meta ( $post->ID, 'adv_filter_search_category', true);    
    if($current_adv_filter_search_category[0]=='all'){
        $current_adv_filter_category_label  =__('Tất cả','wpestate');
        $current_adv_filter_category_meta   = 'Tất cả';
    }else{
        $current_adv_filter_category_label  =   ucwords( str_replace('-',' ',$current_adv_filter_search_category[0]) );
        $current_adv_filter_category_meta   =   sanitize_title($current_adv_filter_search_category[0]);
    }
     
   
//    $current_adv_filter_area        =   get_post_meta ( $post->ID, 'current_adv_filter_area', true);
//    if($current_adv_filter_area[0]=='all'){
//        $current_adv_filter_area_label      =__('All Areas','wpestate');
//        $current_adv_filter_area_meta       = 'All Areas';
//    }else{
//        $current_adv_filter_area_label  =   ucwords( str_replace('-',' ',$current_adv_filter_area[0]) );
//        $current_adv_filter_area_meta   =   sanitize_title($current_adv_filter_area[0]);
//    }
    
    
    $current_adv_filter_city        =   get_post_meta ( $post->ID, 'current_adv_filter_city', true);
    if($current_adv_filter_city[0]=='all'){
        $current_adv_filter_city_label      =__('Tất cả','wpestate');
        $current_adv_filter_city_meta       = 'Tất cả';
    }else{
        $current_adv_filter_city_label  =   ucwords( str_replace('-',' ',$current_adv_filter_city[0]) );
        $current_adv_filter_city_meta   =   sanitize_title($current_adv_filter_city[0]);
    }
}




$selected_order         = __('Sort by','wpestate');
$listing_filter         =   '';
if( isset($post->ID) ){
    $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
}
$listing_filter_array   = array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "3"=>__('Newest first','wpestate'),
                            "4"=>__('Oldest first','wpestate'),
                            "5"=>__('Bedrooms High to Low','wpestate'),
                            "6"=>__('Bedrooms Low to high','wpestate'),
                            "7"=>__('Bathrooms High to Low','wpestate'),
                            "8"=>__('Bathrooms Low to high','wpestate'),
                            "0"=>__('Default','wpestate')
                        );
    

$args = wpestate_get_select_arguments();


foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
}   
      

$order_class='';
if( $show_filter_area != 'yes' ){
    $order_class=' order_filter_single ';  
}


        
if( $show_filter_area=='yes' ){

        if ( is_tax() ){
            $curent_term    =   get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $current_slug   =   $curent_term->slug;
            $current_name   =   $curent_term->name;
            $current_tax    =   $curent_term->taxonomy; 
        }


    $action_select_list =   wpestate_get_action_select_list($args);
    $categ_select_list  =   wpestate_get_category_select_list($args);
    $select_city_list   =   wpestate_get_city_select_list($args); 
    $select_area_list   =   wpestate_get_area_select_list($args);
    
        
}// end if show filter

?>

    <?php if( $show_filter_area=='yes' ){  
        ?>
    <div class="listing_filters_head"> 
        <input type="hidden" id="page_idx" value="<?php 
                if ( !is_tax() && !is_category() ) { 
                   print $post->ID;
                }?>">



            <?php
          //   if( !empty($categories) ){ ?>
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_categ" class="filter_menu_trigger" data-value="<?php print $current_adv_filter_category_meta;?>"> <?php print esc_html($current_adv_filter_category_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_categ">
                      <?php print $categ_select_list;?>
                  </ul>        
                </div>                           
             <?php   
        //     }
             ?>


     
        
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_cities" class="filter_menu_trigger" data-value="<?php print $current_adv_filter_city_meta;?>"> <?php print esc_html($current_adv_filter_city_label);?> <span class="caret caret_filter"></span> </div>           
                  <ul id="filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_cities">
                      <?php print $select_city_list;?>
                  </ul>        
                </div>  


        <?php
        $prop_unit_list_class    =   '';
        $prop_unit_grid_class    =   'icon_selected';
        if($prop_unit=='list'){
            $prop_unit_grid_class="";
            $prop_unit_list_class="icon_selected";
        }

        ?>    
        
        <div class="listing_filter_select listing_filter_views">
            <div id="grid_view" class="<?php echo esc_html($prop_unit_grid_class); ?>"> 
                <i class="fa fa-th"></i>
            </div>
        </div>

        <div class="listing_filter_select listing_filter_views">
             <div id="list_view" class="<?php echo esc_html($prop_unit_list_class); ?>">
                 <i class="fa fa-bars"></i>                   
             </div>
        </div>
          <div data-toggle="dropdown" id="a_filter_county" class="" data-value="<?php print $current_adv_filter_county_meta;?>"></div> 
    </div> 
    <?php }else{
    ?>
        <div data-toggle="dropdown" id="a_filter_action" class="" data-value="<?php print esc_html($current_adv_filter_search_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_categ" class="" data-value="<?php print esc_html($current_adv_filter_category_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_cities" class="" data-value="<?php print esc_html($current_adv_filter_city_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_areas" class="" data-value="<?php print esc_html($current_adv_filter_area_meta);?>"></div>           
        <div data-toggle="dropdown" id="a_filter_county" class="" data-value="<?php print esc_html($current_adv_filter_county_meta);?>"></div>           
              
    <?php
    } 
    ?>      