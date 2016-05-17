<?php
// Template Name: User Dashboard Search Results
// Wp Estate Pack
if ( !is_user_logged_in() ) {   
     wp_redirect(  home_url() );exit;
} 



$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation        =   get_the_author_meta( 'package_activation' , $userID );   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
$edit_link                      =   get_dasboard_add_listing();
$floor_link                     =   get_dasboard_floor_plan();
$processor_link                 =   get_procesor_link();


if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
          exit('you don\'t have the right to delete this');
    }else{
        $delete_id=$_GET['delete_id'];
        $the_post= get_post( $delete_id); 

        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to delete this');;
        }else{
         
           
            // delete attchaments
            $arguments = array(
                'numberposts' => -1,
                'post_type' => 'attachment',
                'post_parent' => $delete_id,
                'post_status' => null,
                'exclude' => get_post_thumbnail_id(),
                'orderby' => 'menu_order',
                'order' => 'ASC'
            );
            $post_attachments = get_posts($arguments);
            
            foreach ($post_attachments as $attachment) {
               wp_delete_post($attachment->ID);                      
             }
           
            wp_delete_post( $delete_id ); 
         
        }  
        
    }
    
    
}  
  


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
        $page_title=esc_html($_POST['prop_name']);
        $args = array(
            'cache_results'             =>  false,
        'update_post_meta_cache'    =>  false,
        'update_post_term_cache'    =>  false,
                   'post_type'        =>  'estate_property',
                   'author'           =>  $current_user->ID,
                   'posts_per_page'   =>  -1 ,
                   's'                => $page_title
               );


        $prop_selection = new WP_Query($args);
        if( !$prop_selection->have_posts() ){
            print '<h4>'.__('You don\'t have any properties yet!','wpestate').'</h4>';
        }else{
            print '
            <form action="'.get_dasboard_searches_link().'" id="search_dashboard_auto" method="POST">
                <input type="text" id="prop_name" name="prop_name" value="" placeholder="'.__('Search a listing','wpestate').'">  
                <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large" id="search_form_submit_1" value="'.__('Search','wpestate').'">
            </form> '; 
            
                
         }
       
           
        while ($prop_selection->have_posts()): $prop_selection->the_post();          
               get_template_part('templates/dashboard_listing_unit'); 
               
        endwhile;   
        wp_reset_postdata();  
            
            
            
        $args = array(
                'cache_results'             =>  false,
                'update_post_meta_cache'    =>  false,
                'update_post_term_cache'    =>  false,
                'post_type'        =>  'estate_property',
                'author'           =>  $current_user->ID,
                'posts_per_page'   =>  -1 ,

             );
        
        $autofill='';
        $prop_selection = new WP_Query($args);
        while ($prop_selection->have_posts()): $prop_selection->the_post();          

               $autofill.= '"'.get_the_title().'",';
        endwhile; 
        
        
        print '<script type="text/javascript">
           //<![CDATA[
                 jQuery(document).ready(function(){
                     var autofill=['.$autofill.']
                     jQuery( "#prop_name" ).autocomplete({
                     source: autofill
                 });
           });
           //]]>
           </script>';
        kriesi_pagination($prop_selection->max_num_pages, $range =2);
        ?>    
    </div>
    
   
  
</div>  



<?php get_footer(); ?>