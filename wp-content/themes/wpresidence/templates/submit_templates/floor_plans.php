<?php
global $action;
global $edit_id;
global $plan_title_array;
global $plan_image_array;
global $plan_size_array;
global $plan_rooms_array;
global $plan_bath_array;
global $plan_price_array;
$images='';
$thumbid='';
$attachid='';
?>

<div class="submit_container">
<div class="submit_container_header"><?php _e('Floor Plans','wpestate');?></div>
    
    <?php 
    if ($action != 'edit'){ 
    ?>
    
    <div class="plan_row">    
        <p class="full_form floor_p">
            <label for="plan_title"><?php _e('Plan Title','wpestate');?></label><br />
            <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />
        </p>

        <p class="full_form floor_p">
            <label for="plan_description"><?php _e('Plan Description','wpestate');?></label><br />
            <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea>
        </p>

        <p class="half_form floor_p">
            <label for="plan_size"><?php _e('Plan Size','wpestate');?></label><br />
            <input id="plan_size" type="text" size="36" name="plan_size[]" value="" />
        </p>

        <p class="half_form floor_p half_form_last">
            <label for="plan_rooms"><?php _e('Plan Rooms','wpestate');?></label><br />
            <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" />
        </p>

        <p class="half_form floor_p">
            <label for="plan_bath"><?php _e('Plan Bathrooms','wpestate');?> </label><br />
            <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" />
        </p>

        <p class="half_form floor_p half_form_last">
            <label for="plan_price"><?php _e('Plan Price','wpestate');?></label><br />
            <input id="plan_price" type="text" size="36" name="plan_price[]" value="" />
        </p>
        
        <p class="full_form floor_p">
            <label for="plan_image"><?php _e('Plan Image','wpestate');?></label><br />
            <input id="plan_image" type="text" size="36" name="plan_image[]" value="" />
            <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="<?php _e('Upload Image','wpestate');?>" />
        </p>

      
        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 
                    <div id="aaiu-upload-imagelist">
                        <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                    </div>

                    <div id="imagelist">
                    <?php 
                        if($images!=''){
                            print $images;
                        }
                    ?>  
                    </div>

                    <button id="aaiu-uploader-floor"  class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php _e('Select Images','wpestate');?></button>
                    <input type="hidden" name="attachid" id="attachid" value="<?php echo esc_html($attachid);?>">
                    <input type="hidden" name="attachthumb" id="attachthumb" value="<?php echo esc_html($thumbid);?>">

            </div>
        </div>  

    </div>
    <?php } else{ ?>


    <?php 
    if(is_array($plan_title_array)){
        foreach ($plan_title_array as $key=> $plan_name) {

            if ( isset($plan_desc_array[$key])){
                $plan_desc=$plan_desc_array[$key];
            }else{
                $plan_desc='';
            }

            if ( isset($plan_image_array[$key])){
                $plan_img=$plan_image_array[$key];
            }else{
                $plan_img='';
            }

            if ( isset($plan_size_array[$key])){
                $plan_size=$plan_size_array[$key];
            }else{
                $plan_size='';
            }

            if ( isset($plan_rooms_array[$key])){
                $plan_rooms=$plan_rooms_array[$key];
            }else{
                $plan_rooms='';
            }

            if ( isset($plan_bath_array[$key])){
                $plan_bath=$plan_bath_array[$key];
            }else{
                $plan_bath='';
            }

            if ( isset($plan_price_array[$key])){
                $plan_price=$plan_price_array[$key];
            }else{
                $plan_price='';
            }
        ?>

        <div class="plan_row">    
            <p class="meta-options floor_p">
                <label for="plan_title"><?php _e('Plan Title','wpestate');?></label><br />
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="<?php $plan_name;?>" />
           </p>

            <p class="meta-options floor_p">
                <label for="plan_description"><?php _e('Plan Description','wpestate');?></label><br />
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ><?php echo esc_html($plan_desc);?></textarea>
            </p>

            <p class="meta-options floor_p">
                <label for="plan_image"><?php _e('Plan Image','wpestate');?></label><br />
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="<?php echo esc_url($plan_img);?>" />
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="<?php _e('Upload Image','wpestate');?>" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_size"><?php _e('Plan Size','wpestate');?></label><br />
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="<?php echo esc_html($plan_size);?>" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_rooms"><?php _e('Plan Rooms','wpestate');?></label><br />
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="<?php echo esc_html($plan_rooms);?>" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_bath"><?php _e('Plan Bathrooms','wpestate');?> </label><br />
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="<?php  echo esc_html($plan_bath);?>" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_price"><?php _e('Plan Price','wpestate');?></label><br />
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="<?php $plan_price;?>" />
            </p>

        </div>

        <?php 
        
            }//end else
        } // end foreach
    } // end if 
    ?>
</div>


















