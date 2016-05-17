<?php
global $full_page;
global $is_shortcode;
global $row_number_col;
global $place_id;
global $place_per_row;
$place_id                       =   intval($place_id);
$category_attach_id             =   '';
$category_tax                   =   '';
$category_featured_image        =   '';
$category_name                  =   '';
$category_featured_image_url    =   '';
$term_meta                      =   get_option( "taxonomy_$place_id");
$category_tagline='';
        


$col_class  =   'col-md-6';
$col_org    =   4;


if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

if(isset($is_widget) && $is_widget==1 ){
    $col_class='col-md-12';
    $col_org    =   12;
}
$category_description='';

$category_count =0;



if(isset($term_meta['category_featured_image'])){
    $category_featured_image=$term_meta['category_featured_image'];
}

if(isset($term_meta['category_attach_id'])){
    $category_attach_id=$term_meta['category_attach_id'];
    $category_featured_image= wp_get_attachment_image_src( $category_attach_id, 'property_listings');
    $category_featured_image_url=$category_featured_image[0];
}
        
if(isset($term_meta['category_tax'])){
    $category_tax=$term_meta['category_tax'];
    $term= get_term( $place_id, $category_tax);
    $category_name=$term->name;
    $category_count=$term->count;
    $category_description = $term->description;
}

 if(isset($term_meta['category_tagline'])){
    $category_tagline=  stripslashes( $term_meta['category_tagline'] );           
}

$term_link =  get_term_link( $place_id, $category_tax );
if ( is_wp_error( $term_link ) ) {
    $term_link='';
}
 
if($category_featured_image_url==''){
    $category_featured_image_url=get_template_directory_uri().'/img/defaults/default_property_listings.jpg';
}


?>  



<div class="<?php echo esc_html($col_class);?> listing_wrapper" data-org="<?php echo esc_html($col_org);?>" data-listid="<?php echo intval($post->ID);?>" > 
    <div class="property_listing places_listing" data-link="<?php echo esc_url($term_link);?>" >
        <div class="listing-unit-img-wrapper">
            <?php
            print   '<a href="'.$term_link.'"><img src="'.$category_featured_image_url.'" alt="places"/></a>';
            print   '<div class="listing-cover"></div><a href="'.$term_link.'"> <span class="listing-cover-plus">+</span></a>'; 
            ?>
        </div>
  
        <h4><a href="<?php echo esc_url($term_link); ?>">
            <?php
                echo mb_substr( $category_name,0,44); 
                if(mb_strlen($category_name)>44){
                    echo '...';   
                } 
            ?>
            </a> 
        </h4> 
        <div class="listing_details the_grid_view"><?php  if($category_description!=''){ echo wpestate_strip_excerpt_by_char($category_description,90); } ?></div>
        
        <div class="listing_unit_price_wrapper">
            <?php echo esc_html($category_count).' '.__('Listings','wpestate' )?>                    
            <div class="listing_actions">
                               
                    <div class="share_unit">
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($term_link); ?>&amp;t=<?php echo urlencode($category_name); ?>" target="_blank" class="social_facebook"></a>
                        <a href="http://twitter.com/home?status=<?php echo urlencode($category_name.' '.$term_link); ?>" class="social_tweet" target="_blank"></a>
                        <a href="https://plus.google.com/share?url=<?php echo esc_url($term_link); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="social_google"></a> 
                        <a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url($term_link); ?>&amp;media=<?php if (isset( $category_featured_image_url)){ echo esc_url($category_featured_image_url); }?>&amp;description=<?php echo urlencode($category_name); ?>" target="_blank" class="social_pinterest"></a>
                    </div>
                    <span class="share_list"  data-original-title="<?php _e('share','wpestate');?>" ></span>
                  
            </div>
        </div>
        
     
           
    </div>          
</div>
            
          
       
       