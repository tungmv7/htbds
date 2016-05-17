<?php
global $options;
$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );

$agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
                    
$agent_facebook     = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
$agent_twitter      = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
$agent_linkedin     = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
$agent_pinterest    = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
$name               = get_the_title();
$link               = get_permalink();

$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',
    'style' => 'border-bottom: none !important;'
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}
           
?>




    <div class="agent_unit" data-link="<?php print esc_url($link);?>">
        <div class="agent-unit-img-wrapper">
            <?php 
            print $thumb_prop; 
            print '<div class="listing-cover"></div>
                   <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>';
            ?>
        </div>    
            
        <div class="agent-title">
            <?php
            print '<h4><a href="' . $link . '">' . $name. '</a></h4>';
            ?>
        </div> 

    </div>