<?php 
$compare_submit =   get_compare_link();
global $leftcompare;
$left_class='';

if ( isset($leftcompare) && $leftcompare==1 ){
    $left_class="margin_compare";
}

?>
<!--Compare Starts here-->     
<div class="prop-compare <?php echo esc_html($left_class); ?>">
    <form method="post" id="form_compare" action="<?php print esc_url($compare_submit); ?>">
        <h4><?php _e('Compare properties','wpestate')?></h4>
        <button   id="submit_compare" class="wpb_button  wpb_btn-info wpb_btn-large"> <?php _e('Compare','wpestate');?> </button>
    </form>
</div>    
<!--Compare Ends here-->  