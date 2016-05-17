<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$options=wpestate_page_details($post->ID); 
global $more;
$more = 0;
?>

<div id="post" <?php post_class('row');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($options['content_class']);?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php 
        while ( have_posts() ) : the_post();
        if (esc_html( get_post_meta($post->ID, 'post_show_title', true) ) != 'no') { ?> 
            <h1 class="entry-title single-title" ><?php the_title(); ?></h1>
        <?php 
        } 
        
        if (has_post_thumbnail()){
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
        }
        ?>
            
        <div class="meta-info"> 
            <div class="meta-element"> <?php _e('Posted by ', 'wpestate'); print ' '.get_the_author().' ';_e('on', 'wpestate'); print' '.the_date('', '', '', FALSE); ?></div>
            <div class="meta-element"> <?php print '<span class="meta-separator"> | </span><i class="fa fa-file-o"></i> '; the_category(', ')?></div>
            <div class="meta-element"> <?php print '<span class="meta-separator"> | </span><i class="fa fa-comment-o"></i> '; comments_number( '0', '1' );  ?>   </div>   
            
            
            <div class="prop_social_single">

                <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '. get_permalink()); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a> 
                <?php if (isset($pinterest[0])){ ?>
                   <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($pinterest[0]);?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
                <?php } ?>


            </div>
            
        </div> 


        <div class="single-content">
            <?php 
            global $more;
            $more=0;
            get_template_part('templates/postslider');   
            the_content('Continue Reading');                     
            $args = array(
                       'before'           => '<p>' . __('Pages:','wpestate'),
                       'after'            => '</p>',
                       'link_before'      => '',
                       'link_after'       => '',
                       'next_or_number'   => 'number',
                       'nextpagelink'     => __('Next page','wpestate'),
                       'previouspagelink' => __('Previous page','wpestate'),
                       'pagelink'         => '%',
                       'echo'             => 1
              ); 
            wp_link_pages( $args ); 
            
           
            ?>                           
        </div>    
     
            
        <!-- #related posts start-->    
        <?php  get_template_part('templates/related_posts');?>    
        <!-- #end related posts -->   
        
        <!-- #comments start-->
        <?php comments_template('', true);?> 	
        <!-- end comments -->   
        
        <?php endwhile; // end of the loop. ?>
    </div>
       
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php get_footer(); ?>