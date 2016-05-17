<?php
global $prop_id ;
global $agent_email;
global $agent_urlc;
$agent_id   = intval( get_post_meta($post->ID, 'property_agent', true) );
$prop_id    = $post->ID;  
$author_email=get_the_author_meta( 'user_email'  );
if ($agent_id!=0){                        
        $args = array(
            'post_type' => 'estate_agent',
            'p' => $agent_id
        );

        $agent_selection = new WP_Query($args);
        $thumb_id       = '';
        $preview_img    = '';
        $agent_skype    = '';
        $agent_phone    = '';
        $agent_mobile   = '';
        $agent_email    = '';
        $agent_pitch    = '';
        $link           = '';
        $name           = 'No agent';

        if( $agent_selection->have_posts() ){
          
               while ($agent_selection->have_posts()): $agent_selection->the_post();
                    $thumb_id           = get_post_thumbnail_id($post->ID);
                    $preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
                    $preview_img         = $preview[0];
                    $agent_skype         = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
                    $agent_phone         = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
                    $agent_mobile        = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
                    $agent_email         = esc_html( get_post_meta($post->ID, 'agent_email', true) );
                    if($agent_email==''){
                        $agent_email=$author_email;
                    }
                    $agent_pitch         = esc_html( get_post_meta($post->ID, 'agent_pitch', true) );
                  
                    $agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
            
                    $agent_facebook      = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
                    $agent_twitter       = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
                    $agent_linkedin      = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
                    $agent_pinterest     = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
                    $agent_urlc           = esc_html( get_post_meta($post->ID, 'agent_website', true) );
                    $link                = get_permalink();
                    $name                = get_the_title();
            
                    include( locate_template('templates/agentdetails.php'));
                    get_template_part('templates/agent_contact');    
                   
               endwhile;
               wp_reset_query();
              
       } // end if have posts
}   // end if !=0
else{  

        if ( get_the_author_meta('user_level') !=10){
        
            $preview_img    =   get_the_author_meta( 'custom_picture'  );
            if($preview_img==''){
                $preview_img=get_template_directory_uri().'/img/default-user.png';
            }
       
            $agent_skype         = get_the_author_meta( 'skype'  );
            $agent_phone         = get_the_author_meta( 'phone'  );
            $agent_mobile        = get_the_author_meta( 'mobile'  );
            $agent_email         = get_the_author_meta( 'user_email'  );
            $agent_pitch         = '';
            $agent_posit         = get_the_author_meta( 'title'  );
            $agent_facebook      = get_the_author_meta( 'facebook'  );
            $agent_twitter       = get_the_author_meta( 'twitter'  );
            $agent_linkedin      = get_the_author_meta( 'linkedin'  );
            $agent_pinterest     = get_the_author_meta( 'pinterest'  );
            $agent_urlc           = get_the_author_meta( 'website'  );
            $link                = get_permalink();
            $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');;
            
       
     
         
        
            
        include( locate_template('templates/agentdetails.php'));
        get_template_part('templates/agent_contact');    
            
        
        }
}
?>