<?php
global $options;
$thumb_id   =   get_post_thumbnail_id($post->ID);
$link       =   get_permalink();
$title      =   get_the_title();
$col_class  =   4;

if($options['content_class']=='col-md-12'){
    $col_class=3;
}
?>

<div class=" col-md-<?php print $col_class;?> related-unit "> 
    
        <?php 
  
        $preview = wp_get_attachment_image_src($thumb_id, 'blog_thumb');
       
        $unit_class="";
        if ($preview[0]!='') {
            $unit_class="has_thumb"; ?>
            <div class="related_blog_unit_image" data-related-link="<?php print esc_url($link);?>">
                <a href="<?php print esc_url($link);?>"><img src="<?php print $preview[0];?>" class=" lazyload img-responsive" alt="thumb"></a>
                    <?php print '<div class="listing-cover">
                    <div class="listing-cover-title"><a href="'.$link.'">'.$title.'</a><span class="listing-cover-plus-related ">+</span></div></div>';
                    ?>
            </div>                              
        <?php    
        }else{
          //  print '<a href="'.get_permalink().'"><img src="'. get_template_directory_uri().'/img/postnoimg250.jpg" alt="no thumb"><a>';
        }
        ?>
   
</div>

<!-- <a href="<?php //the_permalink(); ?>"><?php // print get_the_title(); ?></a> -->