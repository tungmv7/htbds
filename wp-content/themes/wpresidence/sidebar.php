<!-- begin sidebar -->
<div class="clearfix visible-xs"></div>
<?php 
$sidebar_name   =   $options['sidebar_name'];
$sidebar_class  =   $options['sidebar_class'];

if( ('no sidebar' != $options['sidebar_class']) && ('' != $options['sidebar_class'] ) && ('none' != $options['sidebar_class']) ){
?>    
    <div class="col-xs-12 <?php print esc_html($options['sidebar_class']);?> widget-area-sidebar" id="primary" >
        <?php 
        
        if(  'estate_property' == get_post_type() && !is_tax() ){
            $sidebar_agent_option_value=    get_post_meta($post->ID, 'sidebar_agent_option', true);
      
            if($sidebar_agent_option_value =='global'){
                $enable_global_property_page_agent_sidebar= esc_html ( get_option('wp_estate_global_property_page_agent_sidebar','') );
                if($enable_global_property_page_agent_sidebar=='yes'){
                   get_template_part ('/templates/property_list_agent'); 
                }
            }elseif ($sidebar_agent_option_value =='yes') {
                get_template_part ('/templates/property_list_agent');
            }
        }
        ?>
        
        <ul class="xoxo">
            <?php 
            generated_dynamic_sidebar( $options['sidebar_name'] ); ?>
        </ul>

    </div>   

<?php
}
?>
<!-- end sidebar -->