<a href="#" class="backtop "><i class="fa fa-chevron-up"></i></a>
<a href="#" class="contact-box "><i class="fa fa-envelope-o"></i></a>
 
<div class="contactformwrapper hidden"> 
       
   
        <div id="footer-contact-form">
        <h4><?php _e('Contact Us','wpestate')?></h4>
        <p><?php _e('Use the form below to contact us!','wpestate');?></p>
        <div class="alert-box error">
            <div class="alert-message" id="footer_alert-agent-contact"></div>
        </div> 
        
        <input type="text" placeholder="<?php _e('Your Name','wpestate');?>" required="required"   id="foot_contact_name"  name="contact_name" class="form-control" value="" tabindex="373"> 
        <input type="email" required="required" placeholder="<?php _e('Your Email','wpestate')?>"  id="foot_contact_email" name="contact_email" class="form-control" value="" tabindex="374">
        <input type="email" required="required" placeholder="<?php _e('Your Phone','wpestate')?>"  id="foot_contact_phone" name="contact_phone" class="form-control" value="" tabindex="374">
        <textarea placeholder="<?php _e('Type your message...','wpestate')?>" required="required" id="foot_contact_content" name="contact_content" class="form-control" tabindex="375"></textarea>
        <input type="hidden" name="contact_footer_ajax_nonce" id="contact_footer_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-footer-contact' );?>" />

        <div class="btn-cont">
            <button type="submit" id="btn-cont-submit" class="wpb_button  wpb_btn-info wpb_btn-large vc_button"><?php _e('Send','wpestate');?></button>
            <i class="mk-contact-loading mk-icon-spinner mk-icon-spin"></i> 
            <i class="mk-contact-success mk-icon-ok-sign"></i> 
            <input type="hidden" value="" name="contact_to">
            <div class="bottom-arrow"></div>
        </div>  
    </div>
    
</div>
