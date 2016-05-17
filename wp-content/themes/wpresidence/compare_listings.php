<?php
// Template Name: Compare Listings
// Wp Estate Pack
get_header();
$options        =   wpestate_page_details($post->ID);
$show_string    =   '';

if (!isset($_POST['selected_id'])) {
    print '<div class="nocomapare">'.__('page should be accesible only via the compare button','wpestate').'</div>';
    exit();
}

foreach ($_POST['selected_id'] as $key => $value) {
    if (!is_numeric($value)) {
        exit();
    }
    $list_prop[] = $value;
}


$unit           =   esc_html ( get_option('wp_estate_measure_sys', '') );
$currency       =   esc_html ( get_option('wp_estate_currency_symbol', '') );
$where_currency =   esc_html ( get_option('wp_estate_where_currency_symbol', '') );
$measure_sys    =   esc_html ( get_option('wp_estate_measure_sys','') ); 
$counter        =   0;
$properties     =   array();
$id_array       =   array();
$args = array(
        'post_type'     => 'estate_property',
        'post_status'   => 'publish',
        'post__in'      => $list_prop
);

$prop_selection = new WP_Query($args);
while ($prop_selection->have_posts()): $prop_selection->the_post();

    $property = array();
    $id_array[]                     =   $post->ID;
    $property['link']               =   get_permalink($post->ID);
    $property['title']              =   get_the_title();
    $attr                           =   array(
                                            'class'=>'lazyload img-responsive'
                                        ); 
    $property['image']              =   get_the_post_thumbnail($post->ID, 'property_listings',$attr );
    $property['type']               =   get_the_term_list($post->ID, 'property_category', '', ', ', '');
    $property['property_city']      =   get_the_term_list($post->ID, 'property_city', '', ', ', '');
    $property['property_area']      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
    $property['property_zip']       =   esc_html ( get_post_meta($post->ID, 'property_zip', true) );
  //  $property['property_state']     =   esc_html ( get_post_meta($post->ID, 'property_state', true) );
    $property['property_size']      =   floatval ( get_post_meta($post->ID, 'property_size', true) );
    $property['property_lot_size']  =   floatval( get_post_meta($post->ID, 'property_lot_size', true) );
    $property['property_size']      =   floatval(get_post_meta($post->ID, 'property_size', true));
    if ($property['property_size'] != '') {
        $property['property_size']  =   wpestate_sizes_no_format($property['property_size']) . ' '.$measure_sys.'<sup>2</sup>';                            
    }

    $property['property_lot_size'] = floatval( get_post_meta($post->ID, 'property_lot_size', true));
    if ($property['property_lot_size'] != '') {
        $property['property_lot_size'] = wpestate_sizes_no_format($property['property_lot_size']) .' '.$measure_sys.'<sup>2</sup>';
    }

    $property['property_rooms']     =   floatval( get_post_meta($post->ID, 'property_rooms', true));
    $property['property_bedrooms']  =   floatval( get_post_meta($post->ID, 'property_bedrooms', true));
    $property['property_bathrooms'] =   floatval ( get_post_meta($post->ID, 'property_bathrooms', true));
   
    if( floatval( get_post_meta($post->ID, 'property_price', true) ) !=0 ){
        $price =  wpestate_show_price($post->ID,$currency,$where_currency,1);
    }else{
        $price='';
    }
    $property['price']  =   $price;
    $feature_list_array =   array();
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);

    foreach ($feature_list_array as $key=>$checker) {
        $checker            =   trim($checker);
        $post_var_name      =   str_replace(' ','_', trim($checker) );
        $input_name         =   wpestate_limit45(sanitize_title( $post_var_name ));
        $input_name         =   sanitize_key($input_name);
        $property[$checker] =   esc_html (get_post_meta($post->ID,$input_name, true) );
    }
    $counter++;
    $properties[] = $property;
endwhile; 
wp_reset_query();
wp_reset_postdata();
?>


<div class="row">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <h1 class="entry-title compare_title"><?php _e('Compare Listings', 'wpestate'); ?></h1>
        <div class="compare_wrapper col-md-12"">
            
                        <div class="compare_legend_head"></div>
                        <?php
                        for ($i = 0; $i <= $counter - 1; $i++) {
                            ?>
                            <div class="compare_item_head"> 
                                <a href="<?php print esc_url($properties[$i]['link']); ?>"><?php print $properties[$i]['image']; ?></a>				
                                <h4><a href="<?php print esc_url($properties[$i]['link']); ?>"><?php print esc_html($properties[$i]['title']); ?></a> </h4>  
                         
                                <div class="property_price"><?php print ($properties[$i]['price']); ?></div>
                                <div class="article_property_type"><?php print __('Type: ','wpestate').$properties[$i]['type']; ?></div>
                            </div>          
                            <?php
                        }
                        ?>
                        
                         <?php
                    $show_att = array(
                        'property_city'                     =>__('city','wpestate'),
                        'property_area'                     =>__('area','wpestate'),
                        'property_zip'                      =>__('zip','wpestate'),
                        'property_size'                     =>__('size','wpestate'),
                        'property_lot_size'                 =>__('lot size','wpestate'),
                        'property_rooms'                    =>__('rooms','wpestate'),
                        'property_bedrooms'                 =>__('bedrooms','wpestate'),
                        'property_bathrooms'                =>__('bathrooms','wpestate'),
                       
                    );

                    foreach ($show_att as $key => $value) {
                     //   $show_string=str_replace('_', ' ', str_replace('property_', '', $key)) ;
                        print '<div class="compare_item '.$key.'"> 
                               <div class="compare_legend_head_in">' .$value . '</div>';

                        for ($i = 0; $i <= $counter - 1; $i++) {
                            print'<div class="prop_value">' . $properties[$i][$key] . '</div>';
                        }
                        print'</div>';
                    }

                    /////////////////////////////////////////////////// custom fields
                    $j= 0;
                    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
                    if( !empty($custom_fields)){  
                        while($j< count($custom_fields) ){
                            $name =   $custom_fields[$j][0];
                            $label=   $custom_fields[$j][1];
                            $type =   $custom_fields[$j][2];
                            //$slug =   sanitize_key( str_replace(' ','_',$name) );
                            $slug         =   wpestate_limit45(sanitize_title( $name )); 
                            $slug         =   sanitize_key($slug);
                            if (function_exists('icl_translate') ){
                                $label     =   icl_translate('wpestate','wp_estate_property_custom_'.$label, $label ) ;
                            }
                            print '<div class="compare_item '.$slug.'"> 
                            <div class="compare_legend_head_in">' .$label . '</div>';
                            for ($i = 0; $i < count($id_array); $i++) {
                               print'<div class="prop_value">'. esc_html(get_post_meta($id_array[$i], $slug, true)) . '</div>';
                             }                        
                            $j++;       
                            print'</div>';
                         }
                    }          

                    // on off attributes         
                    foreach ($feature_list_array as $key => $value) {
                        $value=trim($value);
                        if (function_exists('icl_translate') ){
                            $value     =   icl_translate('wpestate','wp_estate_property_custom_'.$value, $value ) ;                                      
                        }
                        $post_var_name=  str_replace(' ','_', trim($value) );
                        print '<div class="compare_item '.$post_var_name.'"> 
                               <div class="compare_legend_head_in">' . str_replace('_', ' ', str_replace('property_', '', $value)) . '</div>';

                        for ($i = 0; $i <= $counter - 1; $i++) {
                            print'<div class="prop_value">';
                            if ($properties[$i][$value] == 1) {
                                print '<i class="fa fa-check compare_yes"></i>';
                            } else {
                                print '<i class="fa fa-times compare_no"></i>';
                            }
                            print'</div>';
                        }
                        print'</div>';
                                                     
                    }
                    ?>
        
        </div><!-- end compare wrapper-->
     
</div>   
<?php get_footer(); ?>