<?php
// Index Page
// Wp Estate Pack
get_header();
global $current_user;
global $feature_list_array;
global $propid;
$current_user = wp_get_current_user();
wp_estate_count_page_stats($post->ID);

$propid = $post->ID;
$options = wpestate_page_details($post->ID);
$gmap_lat = esc_html(get_post_meta($post->ID, 'property_latitude', true));
$gmap_long = esc_html(get_post_meta($post->ID, 'property_longitude', true));
$unit = esc_html(get_option('wp_estate_measure_sys', ''));
$currency = esc_html(get_option('wp_estate_currency_symbol', ''));
$use_floor_plans = intval(get_post_meta($post->ID, 'use_floor_plans', true));


if (function_exists('icl_translate')) {
    $where_currency = icl_translate('wpestate', 'wp_estate_where_currency_symbol', esc_html(get_option('wp_estate_where_currency_symbol', '')));
    $property_description_text = icl_translate('wpestate', 'wp_estate_property_description_text', esc_html(get_option('wp_estate_property_description_text')));
    $property_details_text = icl_translate('wpestate', 'wp_estate_property_details_text', esc_html(get_option('wp_estate_property_details_text')));
    $property_features_text = icl_translate('wpestate', 'wp_estate_property_features_text', esc_html(get_option('wp_estate_property_features_text')));
    $property_adr_text = icl_translate('wpestate', 'wp_estate_property_adr_text', esc_html(get_option('wp_estate_property_adr_text')));
} else {
    $where_currency = esc_html(get_option('wp_estate_where_currency_symbol', ''));
    $property_description_text = esc_html(get_option('wp_estate_property_description_text'));
    $property_details_text = esc_html(get_option('wp_estate_property_details_text'));
    $property_features_text = esc_html(get_option('wp_estate_property_features_text'));
    $property_adr_text = stripslashes(esc_html(get_option('wp_estate_property_adr_text')));
}


$agent_id = '';
$content = '';
$userID = $current_user->ID;
$user_option = 'favorites' . $userID;
$curent_fav = get_option($user_option);
$favorite_class = 'isnotfavorite';
$favorite_text = __('add to favorites', 'wpestate');
$feature_list = esc_html(get_option('wp_estate_feature_list'));
$feature_list_array = explode(',', $feature_list);
$pinteres = array();
$property_city = get_the_term_list($post->ID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_category = get_the_term_list($post->ID, 'property_category', '', ', ', '');
$property_action = get_the_term_list($post->ID, 'property_action_category', '', ', ', '');
$slider_size = 'small';
$thumb_prop_face = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'property_full');

if ($curent_fav) {
    if (in_array($post->ID, $curent_fav)) {
        $favorite_class = 'isfavorite';
        $favorite_text = __('favorite', 'wpestate');
    }
}

if (has_post_thumbnail()) {
//    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
}


if ($options['content_class'] == 'col-md-12') {
    $slider_size = 'full';
}

?>


    <div class="row">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <div class=" <?php print esc_html($options['content_class']); ?> ">
            <?php get_template_part('templates/ajax_container'); ?>
            <?php
            while (have_posts()) :
            the_post();
            $price = (get_post_meta($post->ID, 'property_price', true));
            //$price_label    =   esc_html ( get_post_meta($post->ID, 'property_label', true) );
            //$price_label_before = esc_html(get_post_meta($post->ID, 'property_label_before', true));
            $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_image_src($image_id, 'property_full_map');
            $full_img = wp_get_attachment_image_src($image_id, 'full');
            $image_url = $image_url[0];
            $full_img = $full_img [0];
            //            if ($price != 0) {
            //               $price = wpestate_show_price(get_the_ID(),$currency,$where_currency,1);
            //            }else{
            //               $price='<span class="price_label price_label_before">'.$price_label_before.'</span><span class="price_label ">'.$price_label.'</span>';
            //            }
            ?>

            <h1 class="entry-title entry-prop"><?php the_title(); ?></h1>
            <div class="single-content listing-content">


                <?php


                $status = esc_html(get_post_meta($post->ID, 'property_status', true));
                if (function_exists('icl_translate')) {
                    $status = icl_translate('wpestate', 'wp_estate_property_status_' . $status, $status);
                }

                ?>


                <div class="notice_area">

                    <div class="property_categs">
                        <span class="price_area" style="margin: 0; padding: 0"><?php print ($price); ?></span>
                    </div>
            
                    <span class="adres_area">

                        <?php print ($property_category) . ' ' . __('in', 'wpestate') ?>
                        <?php

                        $property_address = esc_html(get_post_meta($post->ID, 'property_address', true));
                        if ($property_address != '') {
                            print esc_html($property_address);
                        }

                        if ($property_city != '') {
                            if ($property_address != '') {
                                print ', ';
                            }
                            print ($property_city);
                        }

                        ?>

                    </span>

                    <div class="download_pdf"></div>

                    <div class="prop_social">
                        <div class="no_views dashboad-tooltip"
                             data-original-title="<?php _e('Number of Page Views', 'wpestate'); ?>"><i
                                class="fa fa-eye-slash "></i><?php echo intval(get_post_meta($post->ID, 'wpestate_total_views', true)); ?>
                        </div>
                        <i class="fa fa-print" id="print_page" data-propid="<?php print $post->ID; ?>"></i>
                        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                        <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
                           class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                        <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                           onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"
                           target="_blank" class="share_google"><i class="fa fa-google-plus fa-2"></i></a>
                        <?php if (isset($pinterest[0])) { ?>
                            <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($pinterest[0]); ?>&amp;description=<?php echo urlencode(get_the_title()); ?>"
                               target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>
                        <?php } ?>

                    </div>
                </div>

                <?php //print 'Status:'.$status.'</br>';
                ?>

                <?php //get_template_part('templates/listingslider');
                // slider type -> vertical or horizinalt
                $local_pgpr_slider_type_status = get_post_meta($post->ID, 'local_pgpr_slider_type', true);
                $prpg_slider_type_status = esc_html(get_option('wp_estate_global_prpg_slider_type', ''));


                $show_slider = 1;
                if ($local_pgpr_slider_type_status == 'full width header') {
                    $show_slider = 0;
                }

                if ($local_pgpr_slider_type_status == 'global' && $prpg_slider_type_status == 'full width header') {
                    $show_slider = 0;
                }

                if ($show_slider == 1) {


                    if ($local_pgpr_slider_type_status == 'global') {
                        $prpg_slider_type_status = esc_html(get_option('wp_estate_global_prpg_slider_type', ''));
                        if ($prpg_slider_type_status == 'vertical') {
                            get_template_part('templates/listingslider-vertical');
                        } else {
                            get_template_part('templates/listingslider');
                        }
                    } elseif ($local_pgpr_slider_type_status == 'vertical') {
                        get_template_part('templates/listingslider-vertical');
                    } else {
                        get_template_part('templates/listingslider');
                    }


                }
                ?>



                <?php

                // content type -> tabs or accordion

                $local_pgpr_content_type_status = get_post_meta($post->ID, 'local_pgpr_content_type', true);
                if ($local_pgpr_content_type_status == 'global') {
                    $global_prpg_content_type_status = esc_html(get_option('wp_estate_global_prpg_content_type', ''));
                    if ($global_prpg_content_type_status == 'tabs') {
                        get_template_part('/templates/property_page_tab_content');
                    } else {
                        get_template_part('/templates/property_page_acc_content');
                    }
                } elseif ($local_pgpr_content_type_status == 'tabs') {
                    get_template_part('/templates/property_page_tab_content');
                } else {
                    get_template_part('/templates/property_page_acc_content');
                }

                ?>






                <?php
                wp_reset_query();
                ?>



                <?php
                endwhile; // end of the loop
                $show_compare = 1;

                $sidebar_agent_option_value = get_post_meta($post->ID, 'sidebar_agent_option', true);
                $enable_global_property_page_agent_sidebar = esc_html(get_option('wp_estate_global_property_page_agent_sidebar', ''));
                if ($sidebar_agent_option_value == 'global') {
                    if ($enable_global_property_page_agent_sidebar != 'yes') {
                        get_template_part('/templates/agent_area');
                    }

                } else if ($sidebar_agent_option_value != 'yes') {
                    get_template_part('/templates/agent_area');
                }

                get_template_part('/templates/similar_listings');

                ?>
            </div><!-- end single content -->
        </div><!-- end 9col container-->

        <?php include(locate_template('sidebar.php')); ?>
    </div>

<?php get_footer(); ?>