<?php
global $term_data;


$place_id                       =$term_data->term_id;
$category_attach_id             ='';
$category_tax                   ='';
$category_featured_image        ='';
$category_name                  ='';
$category_featured_image_url    ='';
$term_meta                      = get_option( "taxonomy_$place_id");
$category_tagline               ='';
$page_tax                       ='';

if(isset($term_meta['category_featured_image'])){
    $category_featured_image=$term_meta['category_featured_image'];
}

if(isset($term_meta['category_attach_id'])){
    $category_attach_id=$term_meta['category_attach_id'];
    $category_featured_image= wp_get_attachment_image_src( $category_attach_id, 'full');
    $category_featured_image_url=$category_featured_image[0];
}

if(isset($term_meta['category_tax'])){
    $category_tax=$term_meta['category_tax'];
    $term= get_term( $place_id, $category_tax);
    $category_name=$term->name;
}

if(isset($term_meta['category_tagline'])){
    $category_tagline=stripslashes ( $term_meta['category_tagline'] );           
}

if(isset($term_meta['page_tax'])){
    $page_tax=$term_meta['page_tax'];           
}



print '<div class="listing_main_image" id="listing_main_image_photo"  style="background-image: url('.$category_featured_image_url.')">';
print '<h1 class="entry-title entry-tax">'.$term_data->name.'</h1>';
print '<div class="tax_tagline">'.$category_tagline.'</div>';
print '<div class="img-overlay"></div>';
print '</div>';

