<?php
global $option_slider;
?>

<div class="submit_container">  
<div class="submit_container_header"><?php _e('Slider Option','wpestate');?></div>

   <p class="full_form">
       <label for="prop_slider_type"><?php _e('Slider type ','wpestate');?></label>
       <select id="prop_slider_type" name="prop_slider_type" class="select-submit2">
           <?php print $option_slider;?>
       </select>
    </p>
</div>
