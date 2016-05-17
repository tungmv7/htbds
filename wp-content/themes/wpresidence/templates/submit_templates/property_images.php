<?php
global $action;
global $edit_id;
$images='';
$thumbid='';
$attachid='';
$floor_link                     =   get_dasboard_floor_plan();
$floor_link                     =   esc_url_raw ( add_query_arg( 'floor_edit', $edit_id, $floor_link) ) ;
$use_floor_plans                =   get_post_meta($edit_id, 'use_floor_plans', true);
   
if ($action=='edit'){
    $arguments = array(
          'numberposts' => -1,
          'post_type' => 'attachment',
     
          'post_parent' => $edit_id,
          'post_status' => null,
    
          'orderby' => 'menu_order',
          'order' => 'ASC'
      );
    

    $post_attachments = get_posts($arguments);
    $post_thumbnail_id = $thumbid = get_post_thumbnail_id( $edit_id );
 
   
    foreach ($post_attachments as $attachment) {
        $preview =  wp_get_attachment_image_src($attachment->ID, 'user_picture_profile');    
        
        if($preview[0]!=''){
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.$preview[0].'" alt="thumb" /><i class="fa fa-trash-o"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }else{
            $images .=  '<div class="uploaded_images" data-imageid="'.$attachment->ID.'"><img src="'.get_template_directory_uri().'/img/pdf.png" alt="thumb" /><i class="fa fa-trash-o"></i>';
            if($post_thumbnail_id == $attachment->ID){
                $images .='<i class="fa thumber fa-star"></i>';
            }
        }
        
        
        $images .='</div>';
        $attachid.= ','.$attachment->ID;
    }
}

?>
<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Media','wpestate');?></div>
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
            
                if ( isset($_POST['attachid']) && $_POST['attachid']!=''){
                    $attchs=explode(',',$_POST['attachid']);
                    $attachid='';
                    foreach($attchs as $att_id){
                        if( $att_id!='' && is_numeric($att_id) ){
                            $attachid .= $att_id.',';
                            $preview =  wp_get_attachment_image_src($att_id, 'user_picture_profile');    
        
                            if($preview[0]!=''){
                                $images .=  '<div class="uploaded_images" data-imageid="'.$att_id.'"><img src="'.$preview[0].'" alt="thumb" /><i class="fa fa-trash-o"></i>';
                               
                            }else{
                                $images .=  '<div class="uploaded_images" data-imageid="'.$att_id.'"><img src="'.get_template_directory_uri().'/img/pdf.png" alt="thumb" /><i class="fa fa-trash-o"></i>';
                               
                            }
                            $images .='</div>';
                        }
                
                    }
                    print $images;
                }
                
            ?>  
            </div>
          
            <button id="aaiu-uploader"  class="wpb_button  wpb_btn-success wpb_btn-large vc_button">
                <?php _e('Select Media','wpestate');?>
            </button>
            <input type="hidden" name="attachid" id="attachid" value="<?php echo esc_html($attachid);?>">
            <input type="hidden" name="attachthumb" id="attachthumb" value="<?php echo esc_html($thumbid);?>">
            <p class="full_form full_form_image">
                <?php 
                _e('* At least 1 image is required for a valid submission.Minimum size is 500/500px','wpestate');print '</br>'; 
                _e('** Double click on the image to select featured.','wpestate');print '</br>';
                _e('*** Change images order with Drag & Drop.','wpestate');print '</br>';
                _e('**** PDF files upload supported as well.','wpestate');?>
            </p>
        </div>  
    </div>
    <?php
    if ($action=='edit'){
    ?>
        <a href="<?php echo esc_url($floor_link);?>" class="wpb_button manage_floor wpb_btn-success wpb_btn-large vc_button" target="_blank"><?php _e('manage floorplans','wpestate');?></a>

    <?php
    }
    ?>
</div>  