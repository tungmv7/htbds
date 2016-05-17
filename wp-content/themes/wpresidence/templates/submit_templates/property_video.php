<?php
global $embed_video_id;
global $option_video;
?>

<div class="submit_container "> 
<div class="submit_container_header"><?php _e('Video Option','wpestate');?></div>

    <p class="full_form">
       <label for="embed_video_type"><?php _e('Video from','wpestate');?></label>
       <select id="embed_video_type" name="embed_video_type" class="select-submit2">
           <?php print $option_video;?>
       </select>
    </p>

   <p class="full_form sidebar_full_form">     
       <label for="embed_video_id"><?php _e('Embed Video id: ','wpestate');?></label>
       <input type="text" id="embed_video_id" class="form-control"  name="embed_video_id" size="40" value="<?php print $embed_video_id;?>">
   </p>
</div> 
