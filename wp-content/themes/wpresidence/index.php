<?php
// Index Page
// Wp Estate Pack
get_header();
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

$options=wpestate_page_details($post_id);


$blog_unit          =   esc_html ( get_option('wp_estate_blog_unit','') );
?>

<div id="post" <?php post_class('row');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>

    <div class=" col-xs-12  <?php print esc_html($options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <div class="single-content blog_list_wrapper">

        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
        $args = array(
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'paged'         => $paged,
        );

        $blog_selection = new WP_Query($args);
        if($blog_selection->have_posts()){
            while ($blog_selection->have_posts()): $blog_selection->the_post();
                if($blog_unit=='list'){
                    get_template_part('templates/blog_unit');
                }else{
                    get_template_part('templates/blog_unit2');
                }
            endwhile;
            wp_reset_query();
        }else{
            print '<h3 class="noposts">'.__('There are no posts published!','wpestate').'</h3>';
        }

        ?>


        </div><!-- single content-->
         <?php kriesi_pagination($blog_selection->max_num_pages, $range = 2); ?>
    </div><!-- end 9col container-->

<?php  include(locate_template('sidebar.php')); ?>
</div>

<?php get_footer(); ?>