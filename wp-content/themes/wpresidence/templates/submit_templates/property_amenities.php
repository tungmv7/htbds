<?php
global $feature_list_array;
global $edit_id;
global $moving_array;
?>


<div class="submit_container ">  
<div class="submit_container_header"><?php _e('Amenities and Features','wpestate');?></div>

<?php

foreach($feature_list_array as $key => $value){
    $post_var_name =   str_replace(' ','_', trim($value) );
    $post_var_name =   wpestate_limit45(sanitize_title( $post_var_name ));
    $post_var_name =   sanitize_key($post_var_name);

    $value_label=$value;
    if (function_exists('icl_translate') ){
        $value_label    =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
    }

    print '<p class="full_form featurescol">
           <input type="hidden"    name="'.$post_var_name.'" value="" style="display:block;">
           <input type="checkbox"   id="'.$post_var_name.'" name="'.$post_var_name.'" value="1" ';

    if (esc_html(get_post_meta($edit_id, $post_var_name, true)) == 1) {
        print' checked="checked" ';
    }else{
        if(is_array($moving_array) ){                      
            if( in_array($post_var_name,$moving_array) ){
                print' checked="checked" ';
            }
        }
    }
    print' /><label for="'.$post_var_name.'">'.$value_label.'</label></p>';  
}
?>
</div>
