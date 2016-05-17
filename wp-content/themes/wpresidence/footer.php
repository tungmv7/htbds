</div><!-- end content_wrapper started in header -->
<?php
//print_R($_COOKIE);
$footer_background          =   get_option('wp_estate_footer_background','');
$repeat_footer_back_status  =   get_option('wp_estate_repeat_footer_back','');
$footer_style       =   '';
$footer_back_class  =   '';


if ($footer_background!=''){
    $footer_style='style=" background-image: url('.$footer_background.') "';
}

if( $repeat_footer_back_status=='repeat' ){
    $footer_back_class = ' footer_back_repeat ';
}else if( $repeat_footer_back_status=='repeat x' ){
    $footer_back_class = ' footer_back_repeat_x ';
}else if( $repeat_footer_back_status=='repeat y' ){
    $footer_back_class = ' footer_back_repeat_y ';
}else if( $repeat_footer_back_status=='no repeat' ){
    $footer_back_class = ' footer_back_repeat_no ';
}


if( !wpestate_half_map_conditions ($post->ID) ){

//if (!is_page_template('property_list_half.php') ){
?>    
    <footer id="colophon" role="contentinfo" <?php echo ($footer_style); ?> class=" <?php echo ($footer_back_class);?> ">    
        <div id="footer-widget-area" class="row">
           <?php get_sidebar('footer');?>
        </div><!-- #footer-widget-area -->

        <div class="sub_footer">  
            <div class="sub_footer_content">
                <span class="copyright">
                    <?php   
                    $message = stripslashes( esc_html (get_option('wp_estate_copyright_message', '')) );
                    if (function_exists('icl_translate') ){
                        $property_copy_text      =   icl_translate('wpestate','wp_estate_property_copyright_text', $message );
                        print ($property_copy_text);
                    }else{
                        print ($message);
                    }
                    ?>
                </span>

                <div class="subfooter_menu">
                    <?php      
                        wp_nav_menu( array(
                           // 'menu'              => 'footer_menu',
                            'theme_location'    => 'footer_menu',
                          //  'depth'             => 1                           
                        ));  
                    ?>
                </div>  
            </div>  
        </div>
    </footer><!-- #colophon -->
<?php } ?>

<?php get_template_part('templates/footer_buttons');?>
<?php get_template_part('templates/navigational');?>

<?php wp_get_schedules(); ?>

<?php wp_footer(); ?>

<?php
$ga = esc_html(get_option('wp_estate_google_analytics_code', ''));
if ($ga != '') { ?>

<script>
    //<![CDATA[
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo esc_html($ga); ?>', '<?php     echo esc_html($_SERVER['SERVER_NAME']); ?>');
  ga('send', 'pageview');
//]]>
</script>

<?php
}
?>

<?php
//print_r($_COOKIE);
?>


</div> <!-- end class container -->
</div> <!-- end website wrapper -->
</body>
</html>