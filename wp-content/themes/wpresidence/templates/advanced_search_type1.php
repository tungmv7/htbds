<?php 
global $post;
global $adv_search_type;
$adv_search_what            =   get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';

if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}

$extended_search    =   get_option('wp_estate_show_adv_search_extended','');
$extended_class     =   '';

if ($adv_search_type==2){
     $extended_class='adv_extended_class2';
}

if ( $extended_search =='yes' ){
    $extended_class='adv_extended_class';
    if($show_adv_search_visible=='no'){
        $close_class='adv-search-1-close-extended';
    }
       
}

?>

 


<div class="adv-search-1 <?php echo esc_html($close_class.' '.$extended_class);?>" id="adv-search-1" > 
    <div id="adv-search-header-1"> <?php _e('Advanced Search','wpestate');?></div>   
    <form role="search" method="get"   action="<?php esc_url(print $adv_submit); ?>" >
        <?php
        if (function_exists('icl_translate') ){
            print do_action( 'wpml_add_language_form_field' );
        }
        ?>   
        
        
        <div class="adv1-holder">
            <?php
            $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
            if ( $custom_advanced_search == 'yes'){
                foreach($adv_search_what as $key=>$search_field){
                    wpestate_show_search_field('mainform',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
                }
            }else{
                $search_form = wpestate_show_search_field_classic_form('main',$action_select_list,$categ_select_list ,$select_city_list,$select_area_list);
                print $search_form;
            }

            if($extended_search=='yes'){
               show_extended_search('adv');
            }
            ?>
        </div>
       
        <input name="submit" type="submit" class="wpb_button  wpb_btn_adv_submit wpb_btn-large" id="advanced_submit_2" value="<?php _e('SEARCH PROPERTIES','wpestate');?>">
        <?php if ($adv_search_type!=2) { ?>
        <div id="results">
            <?php _e('We found ','wpestate'); ?> <span id="results_no">0</span> <?php _e('results.','wpestate'); ?>  
            <span id="showinpage"> <?php _e('Do you want to load the results now ?','wpestate');?> </span>
        </div>
        <?php } ?>

    </form>   
       <div style="clear:both;"></div>
</div>  