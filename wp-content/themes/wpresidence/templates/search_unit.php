<?php
global $custom_advanced_search;  
global $adv_search_what;
global $adv_search_how;
global $adv_search_label;


?>
<div class="search_unit_wrapper">
    <h4> <?php the_title(); ?> </h4>
    <a class="delete_search" data-searchid="<?php print $post->ID; ?>"><?php _e('delete search','wpestate');?></a>
    <?php  
    $search_arguments=  get_post_meta($post->ID, 'search_arguments', true) ;
    $search_arguments_decoded= (array)json_decode($search_arguments,true);
    
    
    //print  json_last_error();
    //print_r($search_arguments_decoded);
    
    print '<div class="search_param"><strong>'.__('Search Parameters: ','wpestate').'</strong>';
    wpestate_show_search_params($search_arguments_decoded,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
    print '</div>';
    
    
    ?>
</div>

