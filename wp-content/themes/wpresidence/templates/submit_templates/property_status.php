<?php
global $property_status;
?>

<div class="submit_container">     
<div class="submit_container_header"><?php _e('Select Property Status','wpestate');?></div>                
   <p class="full_form">
       <label for="property_status"><?php _e('Property Status','wpestate');?></label>
       <select id="property_status" name="property_status" class="select-submit">
           <option value="normal"><?php _e('normal','wpestate');?></option>
           <?php print $property_status ?>
       </select>
   </p>
</div>
