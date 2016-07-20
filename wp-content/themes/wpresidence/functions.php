<?php
require_once 'libs/css_js_include.php';
require_once 'libs/metaboxes.php';
require_once 'libs/plugins.php';
require_once 'libs/help_functions.php';//
require_once 'libs/pin_management.php';//
require_once 'libs/ajax_functions.php';
require_once 'libs/ajax_upload.php';
require_once 'libs/3rdparty.php';
require_once 'libs/theme-setup.php';//
require_once 'libs/general-settings.php';//
require_once 'libs/listing_functions.php';
require_once 'libs/theme-slider.php';
require_once 'libs/agents.php';
//require_once ('libs/invoices.php');
require_once ('libs/searches.php');
//require_once ('libs/membership.php');
require_once ('libs/property.php');
require_once ('libs/shortcodes_install.php');
require_once ('libs/shortcodes.php');
require_once ('libs/widgets.php');
require_once ('libs/events.php');
require_once ('libs/WalkScore.php');
require_once ('libs/emailfunctions.php');
require_once ('libs/searchfunctions.php');
require_once ('libs/stats.php');
require_once ('libs/megamenu.php');
require_once ('profiling.php');

define('ULTIMATE_NO_EDIT_PAGE_NOTICE', true);
define('ULTIMATE_NO_PLUGIN_PAGE_NOTICE', true);
# Disable check updates -
define('BSF_6892199_CHECK_UPDATES',false);

# Disable license registration nag -
define('BSF_6892199_NAG', false);


function wpestate_admin_notice() {
    global $pagenow;
    global $typenow;

    if($pagenow=='themes.php'){
        return;
    }

    if (!empty($_GET['post'])) {
        $allowed_html   =   array();
        $post = get_post( esc_html($_GET['post']) );
        $typenow = $post->post_type;
    }


    if ( WP_MEMORY_LIMIT < 96 ) {
        print '<div class="error">
            <p>'.esc_html__( 'Wordpress Memory Limit is set to ', 'wpestate' ).' '.WP_MEMORY_LIMIT.' '.esc_html__( 'Recommended memory limit should be at least 96MB. Please refer to : ','wpestate').'<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">'.esc_html__('Increasing memory allocated to PHP','wpestate').'</a></p>
        </div>';
    }

    if (!defined('PHP_VERSION_ID')) {
        $version = explode('.', PHP_VERSION);
        define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }

    if(PHP_VERSION_ID<50600){
        $version = explode('.', PHP_VERSION);
        print '<div class="error">
            <p>'.__( 'Your PHP version is ', 'wpestate' ).' '.$version[0].'.'.$version[1].'.'.$version[2].'. We recommend upgrading the PHP version to at least 5.6.1. The upgrade should be done on your server by your hosting company. </p>
        </div>';
    }

    if( !extension_loaded('gd') && !function_exists('gd_info')){
        $version = explode('.', PHP_VERSION);
        print '<div class="error">
            <p>'.__( 'PHP GD library is NOT installed on your web server and because of that the theme will not be able to work with images. Please contact your hosting company in order to activate this library.','wpestate').' </p>
        </div>';
    }




    if ( !extension_loaded('mbstring')) {
        print '<div class="error">
            <p>'.__( 'MbString extension not detected. Please contact your hosting provider in order to enable it.', 'wpestate' ).'</p>
        </div>';
    }

    //print  $pagenow.' / '.$typenow .' / '.basename( get_page_template($post) );

    if (is_admin() &&   $pagenow=='post.php' && $typenow=='page' && basename( get_page_template($post))=='property_list_half.php' ){
        $header_type    =   get_post_meta ( $post->ID, 'header_type', true);

        if ( $header_type != 5){
            print '<div class="error">
            <p>'.esc_html__( 'Half Map Template - make sure your page has the "media header type" set as google map ', 'wpestate' ).'</p>
            </div>';
        }

    }

    if (is_admin() &&   $pagenow=='edit-tags.php'  && $typenow=='estate_property') {

        print '<div class="error">
            <p>'.esc_html__( 'Please do not manually change the slugs when adding new terms. If you need to edit a term name copy the new name in the slug field also.', 'wpestate' ).'</p>
        </div>';
    }





}




add_action( 'admin_notices', 'wpestate_admin_notice' );


add_action('after_setup_theme', 'wp_estate_init');
if( !function_exists('wp_estate_init') ):
    function wp_estate_init() {

        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }

        load_theme_textdomain('wpestate', get_template_directory() . '/languages');
        set_post_thumbnail_size(940, 198, true);
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support('custom-background' );
        wp_estate_setup();
        add_action('widgets_init', 'register_wpestate_widgets' );
        add_action('init', 'wpestate_shortcodes');
        wp_oembed_add_provider('#https?://twitter.com/\#!/[a-z0-9_]{1,20}/status/\d+#i', 'https://api.twitter.com/1/statuses/oembed.json', true);
        wpestate_image_size();
        add_filter('excerpt_length', 'wp_estate_excerpt_length');
        add_filter('excerpt_more', 'wpestate_new_excerpt_more');
        add_action('tgmpa_register', 'wpestate_required_plugins');
        add_action('wp_enqueue_scripts', 'wpestate_scripts'); // function in css_js_include.php
        add_action('admin_enqueue_scripts', 'wpestate_admin');// function in css_js_include.php
        update_option( 'image_default_link_type', 'file' );
    }
endif; // end   wp_estate_init





///////////////////////////////////////////////////////////////////////////////////////////
/////// If admin create the menu
///////////////////////////////////////////////////////////////////////////////////////////
if (is_admin()) {
    add_action('admin_menu', 'wpestate_manage_admin_menu');
}

if( !function_exists('wpestate_manage_admin_menu') ):

    function wpestate_manage_admin_menu() {
        global $theme_name;
        add_theme_page('WpResidence Options', 'WpResidence Options', 'administrator', 'libs/theme-admin.php', 'wpestate_new_general_set' );
        add_theme_page('Import WpResidence Themes', 'WpResidence Import', 'administrator', 'libs/theme-import.php', 'wpestate_new_import' );

        require_once 'libs/property-admin.php';
        require_once 'libs/pin-admin.php';
        require_once 'libs/theme-admin.php';
        require_once 'libs/theme-import.php';
    }

endif; // end   wpestate_manage_admin_menu










//////////////////////////////////////////////////////////////////////////////////////////////
// page details : setting sidebar position etc...
//////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_page_details') ):


function wpestate_page_details($post_id){

    $return_array=array();

    if($post_id !='' && !is_home() && !is_tax() ){
        $sidebar_name   =  esc_html( get_post_meta($post_id, 'sidebar_select', true) );
        $sidebar_status =  esc_html( get_post_meta($post_id, 'sidebar_option', true) );
    }else{
        $sidebar_name   = esc_html( get_option('wp_estate_blog_sidebar_name', '') );
        $sidebar_status = esc_html( get_option('wp_estate_blog_sidebar', '') );
    }

    if(  'estate_agent' == get_post_type() && $sidebar_name=='' & $sidebar_status=='' ) {
            $sidebar_status = esc_html ( get_option('wp_estate_agent_sidebar','') );
            $sidebar_name   = esc_html ( get_option('wp_estate_agent_sidebar_name','') );
    }



    if(''==$sidebar_name){
        $sidebar_name='primary-widget-area';
    }
    if(''==$sidebar_status){
        $sidebar_status='right';
    }



    if( 'left'==$sidebar_status ){
        $return_array['content_class']  =   'col-md-9 col-md-push-3 rightmargin';
        $return_array['sidebar_class']  =   'col-md-3 col-md-pull-9 ';
    }else if( $sidebar_status=='right'){
        $return_array['content_class']  =   'col-md-9 rightmargin';
        $return_array['sidebar_class']  =   'col-md-3';
    }else{
        $return_array['content_class']  =   'col-md-12';
        $return_array['sidebar_class']  =   'none';
    }

    $return_array['sidebar_name']  =   $sidebar_name;

    return $return_array;

}

endif; // end   wpestate_page_details



///////////////////////////////////////////////////////////////////////////////////////////
/////// generate custom css
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head', 'wpestate_generate_options_css');

if( !function_exists('wpestate_generate_options_css') ):

function wpestate_generate_options_css() {

    $general_font   = esc_html( get_option('wp_estate_general_font', '') );
    $custom_css     = stripslashes  ( get_option('wp_estate_custom_css')  );
    $color_scheme   = esc_html( get_option('wp_estate_color_scheme', '') );

    if ($general_font != '' || $color_scheme == 'yes' || $custom_css != ''){
        echo "<style type='text/css'>" ;
        if ($general_font != '') {
            require_once ('libs/custom_general_font.php');
        }


        if ($color_scheme == 'yes') {
           require_once ('libs/customcss.php');
        }
        print ($custom_css);
        echo "</style>";
    }

}

endif; // end   generate_options_css


///////////////////////////////////////////////////////////////////////////////////////////
///////  Display navigation to next/previous pages when applicable
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wp_estate_content_nav')) :

    function wp_estate_content_nav($html_id) {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) :
            ?>
            <nav id="<?php echo esc_attr($html_id); ?>">
                <h3 class="assistive-text"><?php _e('Post navigation', 'wpestate'); ?></h3>
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'wpestate')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'wpestate')); ?></div>
            </nav><!-- #nav-above -->
        <?php
        endif;
    }

endif; // wpestate_content_nav





///////////////////////////////////////////////////////////////////////////////////////////
///////  Comments
///////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('wpestate_comment')) :
    function wpestate_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php _e('Pingback:', 'wpestate'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?></p>
                <?php
                break;
                default :
                ?>




                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

                <?php
                $avatar = wpestate_get_avatar_url(get_avatar($comment, 55));
                print '<div class="blog_author_image singlepage" style="background-image: url(' . $avatar . ');">';
                comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'wpestate'), 'depth' => $depth, 'max_depth' => $args['max_depth'])));
                print'</div>';
                ?>

                <div id="comment-<?php comment_ID(); ?>" class="comment">
                    <?php edit_comment_link(__('Edit', 'wpestate'), '<span class="edit-link">', '</span>'); ?>
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                            <?php
                            print '<div class="comment_name">' . get_comment_author_link().'</div>';
                            print '<span class="comment_date">'.__(' on ','wpestate').' '. get_comment_date() . '</span>';
                            ?>
                        </div><!-- .comment-author .vcard -->

                    <?php if ($comment->comment_approved == '0') : ?>
                            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'wpestate'); ?></em>
                            <br />
                    <?php endif; ?>

                    </div>

                    <div class="comment-content"><?php comment_text(); ?></div>
                </div><!-- #comment-## -->
                <?php
                break;
        endswitch;
    }


endif; // ends check for  wpestate_comment



////////////////////////////////////////////////////////////////////////////////
/// Add new profile fields
////////////////////////////////////////////////////////////////////////////////

add_filter('user_contactmethods', 'wpestate_modify_contact_methods');
if( !function_exists('wpestate_modify_contact_methods') ):

function wpestate_modify_contact_methods($profile_fields) {

	// Add new fields
        $profile_fields['facebook']                     = 'Facebook';
        $profile_fields['twitter']                      = 'Twitter';
        $profile_fields['linkedin']                     = 'Linkedin';
        $profile_fields['pinterest']                    = 'Pinterest';
        $profile_fields['website']                          = 'Website';
	$profile_fields['phone']                        = 'Phone';
        $profile_fields['mobile']                       = 'Mobile';
	$profile_fields['skype']                        = 'Skype';
	$profile_fields['title']                        = 'Title/Position';
        $profile_fields['custom_picture']               = 'Picture Url';
        $profile_fields['small_custom_picture']         = 'Small Picture Url';
        $profile_fields['package_id']                   = 'Package Id';
        $profile_fields['package_activation']           = 'Package Activation';
        $profile_fields['package_listings']             = 'Listings available';
        $profile_fields['package_featured_listings']    = 'Featured Listings available';
        $profile_fields['profile_id']                   = 'Paypal Recuring Profile';
        $profile_fields['user_agent_id']                = 'User Agent Id';
        $profile_fields['stripe']                       = __('Stripe Consumer Profile','wpestate');
	return $profile_fields;
}

endif; // end   wpestate_modify_contact_methods




if( !current_user_can('activate_plugins') ) {
    function wpestate_admin_bar_render() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
       }

    add_action( 'wp_before_admin_bar_render', 'wpestate_admin_bar_render' );

    add_action( 'admin_init', 'wpestate_stop_access_profile' );
    if( !function_exists('wpestate_stop_access_profile') ):
    function wpestate_stop_access_profile() {
        global $pagenow;

        if( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE === true ) {
            wp_die( __('Please edit your profile page from site interface.','wpestate') );
        }

        if($pagenow=='user-edit.php'){
            wp_die( __('Please edit your profile page from site interface.','wpestate') );
        }
    }
    endif; // end   wpestate_stop_access_profile

}// end user can activate_plugins






///////////////////////////////////////////////////////////////////////////////////////////
// prevent changing the author id when admin hit publish
///////////////////////////////////////////////////////////////////////////////////////////

add_action( 'transition_post_status', 'wpestate_correct_post_data',10,3 );

if( !function_exists('wpestate_correct_post_data') ):

function wpestate_correct_post_data( $strNewStatus,$strOldStatus,$post) {
    /* Only pay attention to posts (i.e. ignore links, attachments, etc. ) */
    if( $post->post_type !== 'estate_property' )
        return;

    if( $strOldStatus === 'new' ) {
        update_post_meta( $post->ID, 'original_author', $post->post_author );
    }



    /* If this post is being published, try to restore the original author */
      if( $strNewStatus === 'publish' ) {

         // print_r($post);
         //$originalAuthor = get_post_meta( $post->ID, 'original_author' );

            $originalAuthor_id =$post->post_author;
            $user = get_user_by('id',$originalAuthor_id);
            $user_email=$user->user_email;

            if( $user->roles[0]=='subscriber'){
                $arguments=array(
                    'post_id'           =>  $post->ID,
                    'property_url'      =>  get_permalink($post->ID),
                    'property_title'    =>  get_the_title($post->ID)
                );



                wpestate_select_email_type($user_email,'approved_listing',$arguments);

            }
    }
}
endif; // end   wpestate_correct_post_data











///////////////////////////////////////////////////////////////////////////////////////////
// get attachment info
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_get_attachment') ):
    function wp_get_attachment( $attachment_id ) {

            $attachment = get_post( $attachment_id );


            if($attachment){
                return array(
                        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
                        'caption' => $attachment->post_excerpt,
                        'description' => $attachment->post_content,
                        'href' => get_permalink( $attachment->ID ),
                        'src' => $attachment->guid,
                        'title' => $attachment->post_title
                );
            }else{
                return array(
                        'alt' => '',
                        'caption' => '',
                        'description' => '',
                        'href' => '',
                        'src' => '',
                        'title' => ''
                );
            }
    }
endif;


add_action('get_header', 'wpestate_my_filter_head');

if( !function_exists('wpestate_my_filter_head') ):
    function wpestate_my_filter_head() {
      remove_action('wp_head', '_admin_bar_bump_cb');
    }
endif;


///////////////////////////////////////////////////////////////////////////////////////////
// loosing session fix
///////////////////////////////////////////////////////////////////////////////////////////
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');


///////////////////////////////////////////////////////////////////////////////////////////
// remove vc as theme
///////////////////////////////////////////////////////////////////////////////////////////

 /*
  if (function_exists('vc_set_as_theme')) {
      vc_set_as_theme($disable_updater = false);
  }
*/

///////////////////////////////////////////////////////////////////////////////////////////
// forgot pass action
///////////////////////////////////////////////////////////////////////////////////////////

add_action('wp_head','hook_javascript');
if( !function_exists('hook_javascript') ):
function hook_javascript(){
    global $wpdb;
    $allowed_html   =   array();
    if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
        $reset_key  = esc_html( wp_kses($_GET['key'],$allowed_html) );
        $user_login = esc_html( wp_kses($_GET['login'],$allowed_html) );
        $user_data  = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users
                WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));


        if(!empty($user_data)){
                $user_login = $user_data->user_login;
                $user_email = $user_data->user_email;

                if(!empty($reset_key) && !empty($user_data)) {
                        $new_password = wp_generate_password(7, false);
                        wp_set_password( $new_password, $user_data->ID );
                        //mailing the reset details to the user
                        $message = __('Your new password for the account at:','wpestate') . "\r\n\r\n";
                        $message .= get_bloginfo('name') . "\r\n\r\n";
                        $message .= sprintf(__('Username: %s','wpestate'), $user_login) . "\r\n\r\n";
                        $message .= sprintf(__('Password: %s','wpestate'), $new_password) . "\r\n\r\n";
                        $message .= __('You can now login with your new password at: ','wpestate') . get_option('siteurl')."/" . "\r\n\r\n";

                        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                        $arguments=array(
                            'user_pass'        =>  $new_password,
                        );
                        wpestate_select_email_type($user_email,'password_reseted',$arguments);

                        $mess= '<div class="login-alert">'.__('A new password was sent via email!','wpestate').'</div>';

                }
                else {
                    exit('Not a Valid Key.');
                }
        }// end if empty
  PRINT  $mes='<div class="login_alert_full">'.__('We have just sent you a new password. Please check your email!','wpestate').'</div>';

    }

}
endif;



add_action('wpcf7_before_send_mail', 'wpcf7_update_email_body');

function wpcf7_update_email_body($contact_form) {

    // don't copy my code little f.... - use your brain if you have one
    $submission = WPCF7_Submission::get_instance();
    $url        = $submission->get_meta( 'url' );
    $postid     = url_to_postid( $url );

    if ( $submission ){
        if( isset($postid) && get_post_type($postid) == 'estate_property' ){
            $mail = $contact_form->prop('mail');
            $mail['recipient']  = wpestate_return_agent_email_listing($postid);
            $mail['body'] .= __('Message sent from page: ','wpestate').get_permalink($postid);
            $contact_form->set_properties(array('mail' => $mail));
        }

        if(isset($postid) && get_post_type($postid) == 'estate_agent' ){
            $mail = $contact_form->prop('mail');
            $mail['recipient']  = esc_html( get_post_meta($postid, 'agent_email', true) );
            $mail['body'] .= __('Message sent from page: ','wpestate').get_permalink($postid);
            $contact_form->set_properties(array('mail' => $mail));
        }

    }

}


function wpestate_return_agent_email_listing($postid){

    $agent_id   = intval( get_post_meta($postid, 'property_agent', true) );

    if ($agent_id!=0){
        $agent_email = esc_html( get_post_meta($agent_id, 'agent_email', true) );
    }else{
        $author_id           =  wpsestate_get_author($postid);
        $agent_email         =  get_the_author_meta( 'user_email',$author_id  );
    }
    return $agent_email;
}


add_filter( 'option_posts_per_page', 'tdd_tax_filter_posts_per_page' );
function tdd_tax_filter_posts_per_page( $value ) {
    $prop_no            =   intval( get_option('wp_estate_prop_no','') );
    return (is_tax('estate_property')) ? 1 : $prop_no;
}





//add_filter( 'posts_results', 'cache_meta_data', 9999, 2 );
function cache_meta_data( $posts, $object ) {
  //  global $posts;

    $posts_to_cache = array();
    // this usually makes only sense when we have a bunch of posts
    if ( empty( $posts ) || is_wp_error( $posts ) || is_single() || is_page() || count( $posts ) < 20 ){

        return $posts;

    }

    foreach( $posts as $post ) {
        if ( isset( $post->ID ) && isset( $post->post_type ) ) {
            $posts_to_cache[$post->ID] = 1;
        }
    }

    if ( empty( $posts_to_cache ) )
        return $posts;
 //print_r($posts_to_cache);
    update_meta_cache( 'post', array_keys( $posts_to_cache ) );
    unset( $posts_to_cache );

    return $posts;
}


if ( !function_exists('estate_get_pin_file_path')):

    function estate_get_pin_file_path(){
        if (function_exists('icl_translate') ) {
            $path=get_template_directory().'/pins-'.apply_filters( 'wpml_current_language', 'en' ).'.txt';
        }else{
            $path=get_template_directory().'/pins.txt';
        }

        return $path;
    }

endif;




if( !function_exists('wpestate_show_search_field_classic_form') ):
    function  wpestate_show_search_field_classic_form($postion,$action_select_list,$categ_select_list ,$select_city_list,$select_area_list){

        $allowed_html=array();
        if ($postion=='main'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low';
            $price_max      = 'price_max';
            $ammount        = 'amount';
            $slider         = 'slider_price';
            $drop_class     = '';

        }else if($postion=='sidebar'){
            $caret_class    = ' caret_sidebar ';
            $main_class     = ' sidebar_filter_menu ';
            $appendix       = 'sidebar-';
            $price_low      = 'price_low_widget';
            $price_max      = 'price_max_widget';
            $ammount        = 'amount_wd';
            $slider         = 'slider_price_widget';
            $drop_class     = '';

        }else if($postion=='shortcode'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low_sh';
            $price_max      = 'price_max_sh';
            $ammount        = 'amount_sh';
            $slider         = 'slider_price_sh';
            $drop_class     = 'listing_filter_select ';

        } else if($postion=='mobile'){
            $caret_class    = ' caret_filter ';
            $main_class     = ' filter_menu_trigger ';
            $appendix       = '';
            $price_low      = 'price_low_mobile';
            $price_max      = 'price_max_mobile';
            $ammount        = 'amount_mobile';
            $slider         = 'slider_price_mobile';
            $drop_class     = '';
        }

        $return_string='';

        if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
            $full_name = get_term_by('slug', esc_html( wp_kses( $_GET['filter_search_action'][0],$allowed_html) ),'property_action_category');
            $adv_actions_value=$adv_actions_value1= $full_name->name;
            $adv_actions_value1 = mb_strtolower ( str_replace(' ', '-', $adv_actions_value1) );
        }else{
            $adv_actions_value=__('All Actions','wpestate');
            $adv_actions_value1='all';
        }

        $return_string.='
        <div class="dropdown form-control '.$drop_class.' " >
            <div data-toggle="dropdown" id="'.$appendix.'adv_actions" class="'.$main_class.'" data-value="'.strtolower ( rawurlencode ( $adv_actions_value1) ).'">
                '.$adv_actions_value.'
            <span class="caret '.$caret_class.'"></span> </div>
            <input type="hidden" name="filter_search_action[]" value="';
            if(isset($_GET['filter_search_action'][0])){
                 $return_string.= strtolower( esc_attr($_GET['filter_search_action'][0]) );

            };  $return_string.='">
            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.$appendix.'adv_actions">
                '.$action_select_list.'
            </ul>
        </div>';






        if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''&& $_GET['filter_search_type'][0]!='all'  ){
            $full_name = get_term_by('slug', esc_html( wp_kses( $_GET['filter_search_type'][0],$allowed_html) ),'property_category');
            $adv_categ_value= $adv_categ_value1=$full_name->name;
            $adv_categ_value1 = mb_strtolower ( str_replace(' ', '-', $adv_categ_value1));
        }else{
            $adv_categ_value    = __('All Types','wpestate');
            $adv_categ_value1   ='all';
        }

        $return_string.='
        <div class="dropdown form-control '.$drop_class.'" >
            <div data-toggle="dropdown" id="'.$appendix.'adv_categ" class="'.$main_class.'" data-value="'.strtolower ( rawurlencode( $adv_categ_value1)).'">
                '.$adv_categ_value.'
            <span class="caret '.$caret_class.'"></span> </div>
            <input type="hidden" name="filter_search_type[]" value="';
            if(isset($_GET['filter_search_type'][0])){
                $return_string.= strtolower ( esc_attr( $_GET['filter_search_type'][0] ) );
            }
            $return_string.='">
            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.$appendix.'adv_categ">
                '.$categ_select_list.'
            </ul>
        </div>';

        if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
            $full_name = get_term_by('slug',esc_html( wp_kses($_GET['advanced_city'] ,$allowed_html)), 'property_city');
            $advanced_city_value    = $advanced_city_value1 =   $full_name->name;
            $advanced_city_value1   = mb_strtolower(str_replace(' ', '-', $advanced_city_value1));
        }else{
            $advanced_city_value=__('All Cities','wpestate');
            $advanced_city_value1='all';
        }

        $return_string.='
        <div class="dropdown form-control '.$drop_class.'" >
            <div data-toggle="dropdown" id="'.$appendix.'advanced_city" class="'.$main_class.'" data-value="'. strtolower (rawurlencode ($advanced_city_value1)).'">
                '.$advanced_city_value.'
                <span class="caret '.$caret_class.'"></span> </div>
            <input type="hidden" name="advanced_city" value="';
            if(isset($_GET['advanced_city'])){
                $return_string.=strtolower ( esc_attr($_GET['advanced_city'] ) );

            }
            $return_string.='">
            <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="'.$appendix.'advanced_city">
                '.$select_city_list.'
            </ul>
        </div>';


        if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''&& $_GET['advanced_area']!='all'){
            $full_name = get_term_by('slug', esc_html(wp_kses($_GET['advanced_area'],$allowed_html)),'property_area');
            $advanced_area_value=$advanced_area_value1= $full_name->name;
            $advanced_area_value1 = mb_strtolower (str_replace(' ', '-', $advanced_area_value1));
        }else{
            $advanced_area_value=__('All Areas','wpestate');
            $advanced_area_value1='all';
        }


        $return_string.='
        <div class="dropdown form-control '.$drop_class.'" >
            <div data-toggle="dropdown" id="'.$appendix.'advanced_area" class="'.$main_class.'" data-value="'.strtolower( rawurlencode( $advanced_area_value1)).'">
                '.$advanced_area_value.'
                <span class="caret '.$caret_class.'"></span> </div>
                <input type="hidden" name="advanced_area" value="';
                if(isset($_GET['advanced_area'])){
                    $return_string.=strtolower( esc_attr($_GET['advanced_area'] ) );
                }
                $return_string.='">
            <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-area"  aria-labelledby="'.$appendix.'advanced_area">
                '.$select_area_list.'
            </ul>
        </div>';

        $return_string.='
        <input type="text" id="'.$appendix.'adv_rooms" class="form-control" name="advanced_rooms"  placeholder="'.__('Type Bedrooms No.','wpestate').'"
               value="';
        if ( isset ( $_GET['advanced_rooms'] ) ) {
            $return_string.=   esc_attr( $_GET['advanced_rooms'] );

        }
        $return_string.='">
        <input type="text" id="'.$appendix.'adv_bath"  class="form-control" name="advanced_bath"   placeholder="'.__('Type Bathrooms No.','wpestate').'"
               value="';
        if (isset($_GET['advanced_bath'])) {
            $return_string.=  esc_attr( $_GET['advanced_bath'] );

        }
        $return_string.='">';


        $show_slider_price      =   get_option('wp_estate_show_slider_price','');
        $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );


        if ($show_slider_price==='yes'){
                $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                $max_price_slider= ( floatval(get_option('wp_estate_show_slider_max_price','')) );

                if(isset($_GET['price_low'])){
                    $min_price_slider=  floatval($_GET['price_low']) ;
                }

                if(isset($_GET['price_low'])){
                    $max_price_slider=  floatval($_GET['price_max']) ;
                }

                $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);

        $return_string.='
        <div class="adv_search_slider">
            <p>
                <label for="'.$ammount.'">'.__('Price range:','wpestate').'</label>
                <span id="'.$ammount.'"  style="border:0; color:#f6931f; font-weight:bold;">'.$price_slider_label.'</span>
            </p>
            <div id="'.$slider.'"></div>';
            $custom_fields = get_option( 'wp_estate_multi_curr', true);
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);

                if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                    $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                    $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                }
            }
        $return_string.='
            <input type="hidden" id="'.$price_low.'"  name="price_low"  value="'.$min_price_slider.'>" />
            <input type="hidden" id="'.$price_max.'"  name="price_max"  value="'.$max_price_slider.'>" />
        </div>';

        }else{
        $return_string.='
            <input type="text" id="'.$price_low.'" class="form-control advanced_select" name="price_low"  placeholder="'.__('Type Min. Price','wpestate').'" value=""/>
            <input type="text" id="'.$price_max.'" class="form-control advanced_select" name="price_max"  placeholder="'.__('Type Max. Price','wpestate').'" value=""/>';

        }


        return $return_string;


    }
endif;


add_filter( 'redirect_canonical','wpestate_disable_redirect_canonical',10,2 );
function wpestate_disable_redirect_canonical( $redirect_url ,$requested_url){
    //print '$redirect_url'.$redirect_url;
    //print '$requested_url'.$requested_url;
    if ( is_page_template('property_list.php') || is_page_template('property_list_half.php') ){

        $redirect_url = false;
    }


    return $redirect_url;
}

if(!function_exists('convertAccentsAndSpecialToNormal')):
function convertAccentsAndSpecialToNormal($string) {
    $table = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Ă'=>'A', 'Ā'=>'A', 'Ą'=>'A', 'Æ'=>'A', 'Ǽ'=>'A',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ă'=>'a', 'ā'=>'a', 'ą'=>'a', 'æ'=>'a', 'ǽ'=>'a',

        'Þ'=>'B', 'þ'=>'b', 'ß'=>'Ss',

        'Ç'=>'C', 'Č'=>'C', 'Ć'=>'C', 'Ĉ'=>'C', 'Ċ'=>'C',
        'ç'=>'c', 'č'=>'c', 'ć'=>'c', 'ĉ'=>'c', 'ċ'=>'c',

        'Đ'=>'Dj', 'Ď'=>'D', 'Đ'=>'D',
        'đ'=>'dj', 'ď'=>'d',

        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ĕ'=>'E', 'Ē'=>'E', 'Ę'=>'E', 'Ė'=>'E',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'ę'=>'e', 'ė'=>'e',

        'Ĝ'=>'G', 'Ğ'=>'G', 'Ġ'=>'G', 'Ģ'=>'G',
        'ĝ'=>'g', 'ğ'=>'g', 'ġ'=>'g', 'ģ'=>'g',

        'Ĥ'=>'H', 'Ħ'=>'H',
        'ĥ'=>'h', 'ħ'=>'h',

        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'Ĭ'=>'I', 'Į'=>'I',
        'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'į'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'ı'=>'i',

        'Ĵ'=>'J',
        'ĵ'=>'j',

        'Ķ'=>'K',
        'ķ'=>'k', 'ĸ'=>'k',

        'Ĺ'=>'L', 'Ļ'=>'L', 'Ľ'=>'L', 'Ŀ'=>'L', 'Ł'=>'L',
        'ĺ'=>'l', 'ļ'=>'l', 'ľ'=>'l', 'ŀ'=>'l', 'ł'=>'l',

        'Ñ'=>'N', 'Ń'=>'N', 'Ň'=>'N', 'Ņ'=>'N', 'Ŋ'=>'N',
        'ñ'=>'n', 'ń'=>'n', 'ň'=>'n', 'ņ'=>'n', 'ŋ'=>'n', 'ŉ'=>'n',

        'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ō'=>'O', 'Ŏ'=>'O', 'Ő'=>'O', 'Œ'=>'O',
        'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'œ'=>'o', 'ð'=>'o',

        'Ŕ'=>'R', 'Ř'=>'R',
        'ŕ'=>'r', 'ř'=>'r', 'ŗ'=>'r',

        'Š'=>'S', 'Ŝ'=>'S', 'Ś'=>'S', 'Ş'=>'S',
        'š'=>'s', 'ŝ'=>'s', 'ś'=>'s', 'ş'=>'s',

        'Ŧ'=>'T', 'Ţ'=>'T', 'Ť'=>'T',
        'ŧ'=>'t', 'ţ'=>'t', 'ť'=>'t',

        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ŭ'=>'U', 'Ů'=>'U', 'Ű'=>'U', 'Ų'=>'U',
        'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'ű'=>'u', 'ų'=>'u',

        'Ŵ'=>'W', 'Ẁ'=>'W', 'Ẃ'=>'W', 'Ẅ'=>'W',
        'ŵ'=>'w', 'ẁ'=>'w', 'ẃ'=>'w', 'ẅ'=>'w',

        'Ý'=>'Y', 'Ÿ'=>'Y', 'Ŷ'=>'Y',
        'ý'=>'y', 'ÿ'=>'y', 'ŷ'=>'y',

        'Ž'=>'Z', 'Ź'=>'Z', 'Ż'=>'Z', 'Ž'=>'Z',
        'ž'=>'z', 'ź'=>'z', 'ż'=>'z', 'ž'=>'z',

        '“'=>'"', '”'=>'"', '‘'=>"'", '’'=>"'", '•'=>'-', '…'=>'...', '—'=>'-', '–'=>'-', '¿'=>'?', '¡'=>'!', '°'=>' degrees ',
        '¼'=>' 1/4 ', '½'=>' 1/2 ', '¾'=>' 3/4 ', '⅓'=>' 1/3 ', '⅔'=>' 2/3 ', '⅛'=>' 1/8 ', '⅜'=>' 3/8 ', '⅝'=>' 5/8 ', '⅞'=>' 7/8 ',
        '÷'=>' divided by ', '×'=>' times ', '±'=>' plus-minus ', '√'=>' square root ', '∞'=>' infinity ',
        '≈'=>' almost equal to ', '≠'=>' not equal to ', '≡'=>' identical to ', '≤'=>' less than or equal to ', '≥'=>' greater than or equal to ',
        '←'=>' left ', '→'=>' right ', '↑'=>' up ', '↓'=>' down ', '↔'=>' left and right ', '↕'=>' up and down ',
        '℅'=>' care of ', '℮' => ' estimated ',
        'Ω'=>' ohm ',
        '♀'=>' female ', '♂'=>' male ',
        '©'=>' Copyright ', '®'=>' Registered ', '™' =>' Trademark ',
    );

    $string = strtr($string, $table);
    // Currency symbols: £¤¥€  - we dont bother with them for now
    $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);

    return $string;
}
endif;


function estate_create_onetime_nonce($action = -1) {
    $time = time();
  // print $time.$action;
   $nonce = wp_create_nonce($time.$action);
    return $nonce . '-' . $time;
}
//1455041901register_ajax_nonce_topbar

function estate_verify_onetime_nonce( $_nonce, $action = -1) {
    $parts  =   explode( '-', $_nonce );
    $nonce  =   $toadd_nonce    = $parts[0];
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }

    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    $used_nonces[$toadd_nonce] = $expires;
    asort( $used_nonces );
    update_option( '_sh_used_nonces',$used_nonces );
    return true;
}




function estate_verify_onetime_nonce_login( $_nonce, $action = -1) {
    $parts = explode( '-', $_nonce );
    $nonce =$toadd_nonce= $parts[0];
    $generated = $parts[1];

    $nonce_life = 60*60;
    $expires    = (int) $generated + $nonce_life;
    $expires2   = (int) $generated + 120;
    $time       = time();

    if( ! wp_verify_nonce( $nonce, $generated.$action ) || $time > $expires ){
        return false;
    }

    //Get used nonces
    $used_nonces = get_option('_sh_used_nonces');

    if( isset( $used_nonces[$nonce] ) ) {
        return false;
    }

    if(is_array($used_nonces)){
        foreach ($used_nonces as $nonce=> $timestamp){
            if( $timestamp > $time ){
                break;
            }
            unset( $used_nonces[$nonce] );
        }
    }

    //Add nonce in the stack after 2min
    if($time > $expires2){
        $used_nonces[$toadd_nonce] = $expires;
        asort( $used_nonces );
        update_option( '_sh_used_nonces',$used_nonces );
    }
    return true;
}

function wpestate_file_upload_max_size() {
  static $max_size = -1;

  if ($max_size < 0) {
    // Start with post_max_size.
    $max_size = wpestate_parse_size(ini_get('post_max_size'));

    // If upload_max_size is less, then reduce. Except if upload_max_size is
    // zero, which indicates no limit.
    $upload_max = wpestate_parse_size(ini_get('upload_max_filesize'));
    if ($upload_max > 0 && $upload_max < $max_size) {
      $max_size = $upload_max;
    }
  }
  return $max_size;
}

function wpestate_parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
  }
  else {
    return round($size);
  }
}


/*

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

function _remove_script_version( $src ){
    print $src;
    $parts = explode( '?', $src );
    return $parts[0];
}

 */

add_filter( 'meta_content', 'wptexturize'        );
add_filter( 'meta_content', 'convert_smilies'    );
add_filter( 'meta_content', 'convert_chars'      );
add_filter( 'meta_content', 'wpautop'            );
add_filter( 'meta_content', 'shortcode_unautop'  );
add_filter( 'meta_content', 'prepend_attachment' );

?>
