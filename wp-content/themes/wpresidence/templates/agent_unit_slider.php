<?php
global $options;
$thumb_id = get_post_thumbnail_id($post->ID);
$preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype = esc_html(get_post_meta($post->ID, 'agent_skype', true));
$agent_phone = esc_html(get_post_meta($post->ID, 'agent_phone', true));
$agent_mobile = esc_html(get_post_meta($post->ID, 'agent_mobile', true));
$agent_email = esc_html(get_post_meta($post->ID, 'agent_email', true));

$agent_posit = esc_html(get_post_meta($post->ID, 'agent_position', true));

$agent_facebook = esc_html(get_post_meta($post->ID, 'agent_facebook', true));
$agent_twitter = esc_html(get_post_meta($post->ID, 'agent_twitter', true));
$agent_linkedin = esc_html(get_post_meta($post->ID, 'agent_linkedin', true));
$agent_pinterest = esc_html(get_post_meta($post->ID, 'agent_pinterest', true));
$name = get_the_title();
$link = get_permalink();

$extra = array(
    'data-original' => $preview[0],
    'class' => 'lazyload img-responsive',
    'style' => 'border-bottom: none !important;'
);
$thumb_prop = get_the_post_thumbnail($post->ID, 'property_listings', $extra);

//if ($thumb_prop == '') {
//    $thumb_prop = '<img src="' . get_template_directory_uri() . '/img/default_user.png" alt="agent-images" class="agent-logo">';
//}

$col_class = 4;
if ($options['content_class'] == 'col-md-12') {
    $col_class = 3;
}

?>
<style type="text/css">
    .agents-listing {
        min-height: 200px;
    }
    .agents-listing .property_listing {
        min-height: 200px;
        margin-bottom: 0 !important;
        padding-bottom: 0;
    }
    .agents-listing .blog_unit_image {
        min-height: 140px;
        border-bottom: 3px solid #009688!important;
    }
    .agents-listing .blog_unit_image span{
        position: absolute;
        top: 0;
        left: 0;
        transform: translate(50%, 50%);
        height: 100%;
        width: 100%;
    }
    .agents-listing .blog_unit_image img {
        max-width: 120px;
        margin: 0 auto;
        position: absolute;
        top: 0;
        left: 0;
        transform: translate(-50%, -50%);
    }
</style>
<div class="col-md- shortcode-col listing_wrapper blog2v agents-listing" style="position: relative;" data-link="<?php print esc_url($link); ?>">
    <div class="property_listing">
        <div class="blog_unit_image">
            <span>
            <?php
            print $thumb_prop;
            ?>
            </span>
            <div class="listing-cover"></div>
        </div>
        <?php
        print '<h4><a href="' . $link . '">' . $name . '</a></h4>';
        ?>
    </div>

</div>