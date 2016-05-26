<?php

global $propid;
$agent_id   = intval( get_post_meta($propid, 'property_agent', true) );

if(is_singular('estate_agent')){
    $agent_id = get_the_ID();
}



$contact_form_7_agent   =   stripslashes( ( get_option('wp_estate_contact_form_7_agent','') ) );
$contact_form_7_contact =   stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
if (function_exists('icl_translate') ){
    $contact_form_7_agent     =   icl_translate('wpestate','contact_form7_agent', $contact_form_7_agent ) ;
    $contact_form_7_contact   =   icl_translate('wpestate','contact_form7_contact', $contact_form_7_contact ) ;
}
?>
  
<div class="agent_contanct_form1" style="margin: 2em 0;">
    <div class="company_headline" style="float: none">
    <?php    
     if ( basename(get_page_template())!='contact_page.php') { ?>
             <h3 id="show_contact"><?php _e('Gửi liên hệ', 'wpestate'); ?></h3>
     <?php 
           }else{
     ?>
             <h4 id="show_contact"><?php _e('Gửi liên hệ', 'wpestate'); ?></h4>
     <?php } ?>
    </div>
    <?php if ( ($contact_form_7_agent =='' && basename(get_page_template())!='contact_page.php') || ( $contact_form_7_contact=='' && basename(get_page_template())=='contact_page.php')  ){ ?>


        <div class="alert-box error">
          <div class="alert-message" id="alert-agent-contact"></div>
        </div> 


        <input name="contact_name" id="agent_contact_name" type="text" style="width: 100%"  placeholder="<?php _e('Your Name', 'wpestate'); ?>"
               aria-required="true" class="form-control">
        <input type="text" name="email" class="form-control" id="agent_user_email" style="width: 48%" aria-required="true" placeholder="<?php _e('Your Email', 'wpestate'); ?>" >
        <input type="text" name="phone"  class="form-control" id="agent_phone" style="width: 48%" placeholder="<?php _e('Your Phone', 'wpestate'); ?>" >

        <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true" placeholder="<?php _e('Your Message', 'wpestate'); ?>" ></textarea>	

        <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large"  id="agent_submit" value="<?php _e('Send Message', 'wpestate');?>">

        <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php echo intval($propid);?>">
        <input name="prop_id" type="hidden"  id="agent_id" value="<?php echo intval($agent_id);?>">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-property-contact' );?>" />

       

    <?php 
    }else{
        if ( basename(get_page_template())=='contact_page.php') {
          //  $contact_form_7_contact = stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
            echo do_shortcode($contact_form_7_contact);
        }else{
            wp_reset_query();
            echo do_shortcode($contact_form_7_agent);
        }
      
      
    }
    ?>
</div>