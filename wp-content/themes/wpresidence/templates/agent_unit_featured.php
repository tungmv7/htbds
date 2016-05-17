<?php
global $options;
global $notes;
$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$name               = get_the_title();
$link               = get_permalink();

$agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );

$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',    
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



<!-- <div class="col-md-<?php //print $col_class;?> listing_wrapper"> -->
    <div class="agent_unit agent_unit_featured" data-link="<?php print esc_url($link);?>">
        <?php 
        print '<div class="agent-unit-img-wrapper">';
        print $thumb_prop; 
        print '<div class="listing-cover"></div>
               <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>';
        print '</div>';
        ?>
 
            
        <div class="">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>
            <div class="agent_position">'. $agent_posit .'</div>';
            
            
            
            print '<div class="agent_featured_details">';
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fa fa-phone"></i>' . $agent_phone . '</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i>' . $agent_mobile . '</div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i>' . $agent_email . '</div>';
            }

           
            print '</div>';
            
            print '<div class="featured_agent_notes">'.$notes.'</div>';
            print '<a class="wpb_button_a see_my_list_featured" href="'.$link.'" target="_blank">
                    <span class="wpb_button  wpb_wpb_button wpb_regularsize wpb_mail  vc_button">'.__('My Listings','wpestate').'</span>
                </a>';
          
            ?>
        </div> 
    

    </div>
<!-- </div>    -->