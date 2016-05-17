<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" class="form-control" name="s" id="s" placeholder="<?php _e( 'Type Keyword', 'wpestate' ); ?>" />
    <button class="wpb_button  wpb_btn-info wpb_btn-large"  id="submit-form"><?php _e('Search','wpestate');?></button>
</form>
