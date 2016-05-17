<?php
global $options;
global $agent_wid;

if($agent_wid!=0){
    $thumb_id           = get_post_thumbnail_id($agent_wid);
    $preview            = wp_get_attachment_image_src(get_post_thumbnail_id($agent_wid), 'property_listings');
    $agent_skype        = esc_html( get_post_meta($agent_wid, 'agent_skype', true) );
    $agent_phone        = esc_html( get_post_meta($agent_wid, 'agent_phone', true) );
    $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agent_mobile', true) );
    $agent_email        = esc_html( get_post_meta($agent_wid, 'agent_email', true) );

    $agent_posit        = esc_html( get_post_meta($agent_wid, 'agent_position', true) );
    $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agent_facebook', true) );
    $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agent_twitter', true) );
    $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agent_linkedin', true) );
    $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agent_pinterest', true) );
    $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agent_website', true) );
    $name               = get_the_title($agent_wid);
    $link               = get_permalink($agent_wid);

    $extra= array(
            'data-original'=>$preview[0],
            'class'	=> 'lazyload img-responsive',    
            );
    $thumb_prop    = get_the_post_thumbnail($agent_wid, 'property_listings',$extra);

    if($thumb_prop==''){
        $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
    }
    
}else{
    
    $thumb_prop    =   get_the_author_meta( 'custom_picture',$agent_wid  );
    if($thumb_prop==''){
        $thumb_prop=get_template_directory_uri().'/img/default-user.png';
    }
    
    $thumb_prop = '<img src="'.$thumb_prop.'" alt="agent-images">';
    
    $agent_skype         = get_the_author_meta( 'skype' ,$agent_wid );
    $agent_phone         = get_the_author_meta( 'phone'  ,$agent_wid);
    $agent_mobile        = get_the_author_meta( 'mobile'  ,$agent_wid);
    $agent_email         = get_the_author_meta( 'user_email' ,$agent_wid );
    $agent_pitch         = '';
    $agent_posit         = get_the_author_meta( 'title' ,$agent_wid );
    $agent_facebook      = get_the_author_meta( 'facebook',$agent_wid  );
    $agent_twitter       = get_the_author_meta( 'twitter' ,$agent_wid );
    $agent_linkedin      = get_the_author_meta( 'linkedin'  ,$agent_wid);
    $agent_pinterest     = get_the_author_meta( 'pinterest',$agent_wid  );
    $agent_urlc          = get_the_author_meta( 'website' ,$agent_wid );
    $link                = get_permalink();
    $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');

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
            
        <div class="">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>
            <div class="agent_position">'. $agent_posit .'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fa fa-phone"></i>' . $agent_phone . '</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i>' . $agent_mobile . '</div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i>' . $agent_email . '</div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fa fa-skype"></i>' . $agent_skype . '</div>';
            }
            
            if ($agent_urlc) {
                print '<div class="agent_detail"><i class="fa fa-desktop"></i><a href="http://'.$agent_urlc.'" target="_blank">'.$agent_urlc.'</a></div>';
            }
            
            
            ?>
        </div> 
    
        
        <div class="agent_unit_social">
           <div class="social-wrapper"> 
               
               <?php
               
                if($agent_facebook!=''){
                    print ' <a href="'. $agent_facebook.'"><i class="fa fa-facebook"></i></a>';
                }

                if($agent_twitter!=''){
                    print ' <a href="'.$agent_twitter.'"><i class="fa fa-twitter"></i></a>';
                }
                
                if($agent_linkedin!=''){
                    print ' <a href="'.$agent_linkedin.'"><i class="fa fa-linkedin"></i></a>';
                }
                
                if($agent_pinterest!=''){
                     print ' <a href="'. $agent_pinterest.'"><i class="fa fa-pinterest"></i></a>';
                }

               
               ?>
              
            </div>
        </div>
    </div>
<!-- </div>    -->