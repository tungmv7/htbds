<?php
// Template Name: User Dashboard Favorite
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect(  home_url() );exit;
} 

$current_user = wp_get_current_user();  
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$currency                       =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

get_header();
$options=wpestate_page_details($post->ID);
?> 


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-md-3">
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    <div class="col-md-9 dashboard-margin">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php } ?>
         
        <?php
        if( !empty($curent_fav)){
             $args = array(
                 'post_type'        => 'estate_property',
                 'post_status'      => 'publish',
                 'posts_per_page'   => -1 ,
                 'post__in'         => $curent_fav 
             );


             $prop_selection = new WP_Query($args);
             $counter = 0;
             $options['related_no']=4;
             print '<div id="listing_ajax_container">';
             while ($prop_selection->have_posts()): $prop_selection->the_post(); 
      
                    get_template_part('templates/property_unit');
         
             endwhile;
             print '</div>';
        }else{
            print '<h4>'.__('You don\'t have any favorite properties yet!','wpestate').'</h4>';
        }



      
        ?>    
       
                
                
    </div>
    
 
  
</div>   

<?php get_footer(); ?>