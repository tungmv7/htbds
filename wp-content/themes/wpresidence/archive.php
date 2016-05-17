<?php
// Archive Page
// Wp Estate Pack
get_header();
$options    =   wpestate_page_details('');
$blog_unit  =   esc_html ( get_option('wp_estate_blog_unit','') ); 

?>

<div class="row"> 
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($options['content_class']);?> ">
          <?php get_template_part('templates/ajax_container'); ?>
          <h1 class="entry-title">
             <?php 
             if (is_category() ) {
                    printf(__('Category Archives: %s', 'wpestate'), '<span>' . single_cat_title('', false) . '</span>');
             }else if (is_day()) {
                    printf(__('Daily Archives: %s', 'wpestate'), '<span>' . get_the_date() . '</span>'); 
             } elseif (is_month()) {
                    printf(__('Monthly Archives: %s', 'wpestate'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'wpestate')) . '</span>'); 
             } elseif (is_year()) {
                    printf(__('Yearly Archives: %s', 'wpestate'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'wpestate')) . '</span>');
             } else {
                _e('Blog Archives', 'wpestate'); 
             }
            
             ?>
          </h1>
          <div class="blog_list_wrapper">
          <?php   
           while (have_posts()) : the_post();
                if($blog_unit=='list'){
                    get_template_part('templates/blog_unit');
                }else{
                    get_template_part('templates/blog_unit2');
                }       
           endwhile;
           wp_reset_query();
           ?>
           </div>
        <?php kriesi_pagination('', $range = 2); ?>    

    </div>
       
<?php  include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>