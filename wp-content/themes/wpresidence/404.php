<?php
// Wp Estate Pack
get_header();
$options=wpestate_page_details($post->ID); 
?>



<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="<?php print esc_html($options['content_class']);?> ">
        
         <?php get_template_part('templates/ajax_container'); ?>
        
       
           <h1 class="entry-title"><?php _e('Page not found','wpestate');?></h1>
         
            <div class="single-content content404 col-md-12">    
                <p>
                <?php _e( 'We\'re sorry. Your page could not be found, But you can check our latest listings & articles', 'wpestate' ); ?>
                </p>

                <div class="list404">  
                <h3><?php _e('Latest Listings','wpestate');?></h3>
                <?php
                 
                $args = array(
                     'post_type'        => 'estate_property',
                     'post_status'      => 'publish',
                     'paged'            => 0,
                     'posts_per_page'   => 10, 
                 );

                 $recent_posts = new WP_Query($args);
                   print '<ul>';
                   while ($recent_posts->have_posts()): $recent_posts->the_post();
                        print '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                   endwhile;
                   print '</ul>';
                ?>
                </div>

                <div class="list404">  
                <h3><?php _e('Latest Articles','wpestate');?></h3>
                <?php
                  $args = array(
                     'post_type'        => 'post',
                     'post_status'      => 'publish',
                     'paged'            => 0,
                     'posts_per_page'   => 10, 
                 );

                 $recent_posts = new WP_Query($args);
                   print '<ul>';
                   while ($recent_posts->have_posts()): $recent_posts->the_post();
                        print '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                   endwhile;
                   print '</ul>';
                ?>
                </div>
        
            </div><!-- single content-->
     
    </div>
  
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>