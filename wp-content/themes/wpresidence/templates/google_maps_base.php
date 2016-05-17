<!-- Google Map -->
<?php
global $post;



if( !is_tax() && !is_category() && isset($post->ID) ){
    $gmap_lat           =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
    $gmap_long          =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
    $property_add_on    =   ' data-post_id="'.$post->ID.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
    $closed_height      =   get_current_map_height($post->ID);
    $open_height        =   get_map_open_height($post->ID);
    $open_close_status  =   get_map_open_close_status($post->ID);
    
}else{
    $gmap_lat           =   esc_html( get_option('wp_estate_general_latitude','') );
    $gmap_long          =   esc_html( get_option('wp_estate_general_longitude','') );
    $property_add_on    =   ' data-post_id="" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
    $closed_height      =   intval (get_option('wp_estate_min_height',''));
    $open_height        =   get_option('wp_estate_max_height','');
    $open_close_status  =   esc_html( get_option('wp_estate_keep_min','' ) ); 
}

?>



<div id="gmap_wrapper"  <?php print $property_add_on; ?> style="height:<?php print $closed_height;?>px"  >
    <div id="googleMap"  style="height:<?php print $closed_height;?>px">   
    </div>    
    
   
  
   <div class="tooltip"> <?php _e('click to enable zoom','wpestate');?></div>
   <div id="gmap-loading"><?php _e('Loading Maps','wpestate');?>
         <div class="spinner map_loader" id="listing_loader_maps">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
   </div>
   
   
   <div id="gmap-noresult">
       <?php _e('We didn\'t find any results','wpestate');?>
   </div>
   
   <div class="gmap-controls">
        <?php
        // show or not the open close map button
        if( isset($post->ID) && !is_tax() && !is_category()){
            if (get_map_open_close_status($post->ID) == 0 ){
                print ' <div id="openmap"><i class="fa fa-angle-down"></i>'.__('open map','wpestate').'</div>';
            }
        }else{
            if( esc_html( get_option('wp_estate_keep_min','' ) )=='no'){
                print ' <div id="openmap"><i class="fa fa-angle-down"></i>'.__('open map','wpestate').'</div>';
            }
        }
        ?>
        <div id="gmap-control">
            <span  id="map-view"><i class="fa fa-picture-o"></i><?php _e('View','wpestate');?></span>
                <span id="map-view-roadmap"     class="map-type"><?php _e('Roadmap','wpestate');?></span>
                <span id="map-view-satellite"   class="map-type"><?php _e('Satellite','wpestate');?></span>
                <span id="map-view-hybrid"      class="map-type"><?php _e('Hybrid','wpestate');?></span>
                <span id="map-view-terrain"     class="map-type"><?php _e('Terrain','wpestate');?></span>
            <span  id="geolocation-button"><i class="fa fa-map-marker"></i><?php _e('My Location','wpestate');?></span>
            <span  id="gmap-full" ><i class="fa fa-arrows-alt"></i><?php _e('Fullscreen','wpestate');?></span>
            <span  id="gmap-prev"><i class="fa fa-chevron-left"></i><?php _e('Prev','wpestate');?></span>
            <span  id="gmap-next" ><?php _e('Next','wpestate');?><i class="fa fa-chevron-right"></i></span>

            <?php
                $street_view_class=" ";
                if(  get_option('wp_estate_show_g_search','') ==='yes'){
                    $street_view_class=" lower_street ";
            ?>
                    <input type="text" id="google-default-search" name="google-default-search" placeholder="<?php _e('Google Maps Search','wpestate');?>" value="" class="advanced_select  form-control">  
            <?php        
                }
            ?>
        </div>

        <div id="gmapzoomplus"><i class="fa fa-plus"></i> </div>
        <div id="gmapzoomminus"><i class="fa fa-minus"></i></div>
        
        <?php 
            if( isset($post->ID) && get_post_type($post->ID)=='estate_property' && !is_tax() && !is_archive() ){
             
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
        ?>
                    <div id="street-view" class="<?php echo esc_html($street_view_class);?>"><i class="fa fa-location-arrow"></i> <?php _e('Street View','wpestate');?> </div>
        <?php   
                } 
            }
        ?>
   </div>
 

</div>    
<!-- END Google Map --> 