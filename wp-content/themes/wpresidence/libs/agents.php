<?php
// register the custom post type
add_action('init', 'wpestate_create_agent_type', 1);

if (!function_exists('wpestate_create_agent_type')):

    function wpestate_create_agent_type()
    {
        register_post_type('estate_agent',
            array(
                'labels' => array(
                    'name' => __('Agents', 'wpestate'),
                    'singular_name' => __('Agent', 'wpestate'),
                    'add_new' => __('Add New Agent', 'wpestate'),
                    'add_new_item' => __('Add Agent', 'wpestate'),
                    'edit' => __('Edit', 'wpestate'),
                    'edit_item' => __('Edit Agent', 'wpestate'),
                    'new_item' => __('New Agent', 'wpestate'),
                    'view' => __('View', 'wpestate'),
                    'view_item' => __('View Agent', 'wpestate'),
                    'search_items' => __('Search Agent', 'wpestate'),
                    'not_found' => __('No Agents found', 'wpestate'),
                    'not_found_in_trash' => __('No Agents found', 'wpestate'),
                    'parent' => __('Parent Agent', 'wpestate')
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'agents'),
                'supports' => array('title', 'editor', 'thumbnail', 'comments'),
                'can_export' => true,
                'register_meta_box_cb' => 'wpestate_add_agents_metaboxes',
                'menu_icon' => get_template_directory_uri() . '/img/agents.png'
            )
        );
        // add custom taxonomy
/*
// add custom taxonomy
        register_taxonomy('property_category_agent', array('estate_agent'), array(
                'labels' => array(
                    'name' => __('Agent Categories', 'wpestate'),
                    'add_new_item' => __('Add New Agent Category', 'wpestate'),
                    'new_item_name' => __('New Agent Category', 'wpestate')
                ),
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'agent_listings')
            )
        );


        register_taxonomy('property_action_category_agent', 'estate_agent', array(
                'labels' => array(
                    'name' => __('Agent Action Categories', 'wpestate'),
                    'add_new_item' => __('Add New Agent Action', 'wpestate'),
                    'new_item_name' => __('New Agent Action', 'wpestate')
                ),
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'agent-action')
            )
        );


// add custom taxonomy
        register_taxonomy('property_city_agent', 'estate_agent', array(
                'labels' => array(
                    'name' => __('Agent City', 'wpestate'),
                    'add_new_item' => __('Add New Agent City', 'wpestate'),
                    'new_item_name' => __('New Agent City', 'wpestate')
                ),
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'agent-city', 'with_front' => false)
            )
        );


        // add custom taxonomy
        register_taxonomy('property_area_agent', 'estate_agent', array(
                'labels' => array(
                    'name' => __('Agent Neighborhood', 'wpestate'),
                    'add_new_item' => __('Add New Agent Neighborhood', 'wpestate'),
                    'new_item_name' => __('New Agent Neighborhood', 'wpestate')
                ),
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'agent-area')

            )
        );

        // add custom taxonomy
        register_taxonomy('property_county_state_agent', array('estate_agent'), array(
                'labels' => array(
                    'name' => __('Agent County / State', 'wpestate'),
                    'add_new_item' => __('Add New Agent County / State', 'wpestate'),
                    'new_item_name' => __('New Agent County / State', 'wpestate')
                ),
                'hierarchical' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'agent-state')

            )
        );
        */
    }
endif; // end   wpestate_create_agent_type  


////////////////////////////////////////////////////////////////////////////////////////////////
// Add agent metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('wpestate_add_agents_metaboxes')):
    function wpestate_add_agents_metaboxes()
    {
        // add_meta_box('estate_agent-sectionid', __('Agent Settings', 'wpestate'), 'estate_agent', 'estate_agent', 'normal', 'default');
    }
endif; // end   wpestate_add_agents_metaboxes  


////////////////////////////////////////////////////////////////////////////////////////////////
// Agent details
////////////////////////////////////////////////////////////////////////////////////////////////
if (!function_exists('estate_agent')):
    function estate_agent($post)
    {
        wp_nonce_field(plugin_basename(__FILE__), 'estate_agent_noncename');
        global $post;

        print'
    <p class="meta-options">
    <label for="agent_position">' . __('Position:', 'wpestate') . ' </label><br />
    <input type="text" id="agent_position" size="58" name="agent_position" value="' . esc_html(get_post_meta($post->ID, 'agent_position', true)) . '">
    </p>

    <p class="meta-options">
    <label for="agent_email">' . __('Email:', 'wpestate') . ' </label><br />
    <input type="text" id="agent_email" size="58" name="agent_email" value="' . esc_html(get_post_meta($post->ID, 'agent_email', true)) . '">
    </p>

    <p class="meta-options">
    <label for="agent_phone">' . __('Phone: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_phone" size="58" name="agent_phone" value="' . esc_html(get_post_meta($post->ID, 'agent_phone', true)) . '">
    </p>

    <p class="meta-options">
    <label for="agent_mobile">' . __('Mobile:', 'wpestate') . ' </label><br />
    <input type="text" id="agent_mobile" size="58" name="agent_mobile" value="' . esc_html(get_post_meta($post->ID, 'agent_mobile', true)) . '">
    </p>

    <p class="meta-options">
    <label for="agent_skype">' . __('Skype: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_skype" size="58" name="agent_skype" value="' . esc_html(get_post_meta($post->ID, 'agent_skype', true)) . '">
    </p>
    
                
    <p class="meta-options">
    <label for="agent_facebook">' . __('Facebook: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_facebook" size="58" name="agent_facebook" value="' . esc_html(get_post_meta($post->ID, 'agent_facebook', true)) . '">
    </p>
    
    <p class="meta-options">
    <label for="agent_twitter">' . __('Twitter: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_twitter" size="58" name="agent_twitter" value="' . esc_html(get_post_meta($post->ID, 'agent_twitter', true)) . '">
    </p>
    
    <p class="meta-options">
    <label for="agent_linkedin">' . __('Linkedin: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_linkedin" size="58" name="agent_linkedin" value="' . esc_html(get_post_meta($post->ID, 'agent_linkedin', true)) . '">
    </p>
    
    <p class="meta-options">
    <label for="agent_pinterest">' . __('Pinterest: ', 'wpestate') . '</label><br />
    <input type="text" id="agent_pinterest" size="58" name="agent_pinterest" value="' . esc_html(get_post_meta($post->ID, 'agent_pinterest', true)) . '">
    </p>
    
    <p class="meta-options">
        <label for="agent_website">' . __('Website (without http): ', 'wpestate') . '</label><br />
        <input type="text" id="agent_website" size="58" name="agent_website" value="' . esc_html(get_post_meta($post->ID, 'agent_website', true)) . '">
    </p>
    ';
    }
endif; // end   estate_agent  


add_action('save_post', 'wpsx_5688_update_post', 1, 2);

if (!function_exists('wpsx_5688_update_post')):
    function wpsx_5688_update_post($post_id, $post)
    {

        if (!is_object($post) || !isset($post->post_type)) {
            return;
        }

        if ($post->post_type != 'estate_agent') {
            return;
        }

        if (!isset($_POST['agent_email'])) {
            return;
        }
        if ('yes' == esc_html(get_option('wp_estate_user_agent', ''))) {
            $allowed_html = array();
            $user_id = get_post_meta($post_id, 'user_meda_id', true);
            $email = wp_kses($_POST['agent_email'], $allowed_html);
            $phone = wp_kses($_POST['agent_phone'], $allowed_html);
            $skype = wp_kses($_POST['agent_skype'], $allowed_html);
            $position = wp_kses($_POST['agent_position'], $allowed_html);
            $mobile = wp_kses($_POST['agent_mobile'], $allowed_html);
            $desc = wp_kses($_POST['content'], $allowed_html);
            $image_id = get_post_thumbnail_id($post_id);
            $full_img = wp_get_attachment_image_src($image_id, 'agent_picture_single_page');
            $facebook = wp_kses($_POST['agent_facebook'], $allowed_html);
            $twitter = wp_kses($_POST['agent_twitter'], $allowed_html);
            $linkedin = wp_kses($_POST['agent_linkedin'], $allowed_html);
            $pinterest = wp_kses($_POST['agent_pinterest'], $allowed_html);
            $agent_website = wp_kses($_POST['agent_website'], $allowed_html);

            update_user_meta($user_id, 'aim', '/' . $full_img[0] . '/');
            update_user_meta($user_id, 'phone', $phone);
            update_user_meta($user_id, 'mobile', $mobile);
            update_user_meta($user_id, 'description', $desc);
            update_user_meta($user_id, 'skype', $skype);
            update_user_meta($user_id, 'title', $position);
            update_user_meta($user_id, 'custom_picture', $full_img[0]);
            update_user_meta($user_id, 'facebook', $facebook);
            update_user_meta($user_id, 'twitter', $twitter);
            update_user_meta($user_id, 'linkedin', $linkedin);
            update_user_meta($user_id, 'pinterest', $pinterest);
            update_user_meta($user_id, 'website', $agent_website);

            update_user_meta($user_id, 'small_custom_picture', $image_id);

            $new_user_id = email_exists($email);
            if ($new_user_id) {
                //   _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else {
                $args = array(
                    'ID' => $user_id,
                    'user_email' => $email
                );
                wp_update_user($args);
            }
        }//end if
    }
endif;
?>