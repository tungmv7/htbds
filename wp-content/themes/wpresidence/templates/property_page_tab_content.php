<?php
global $property_adr_text;
global $property_details_text;
global $property_features_text;
global $feature_list_array;
global $use_floor_plans;
global $property_description_text;
global $post;
$walkscore_api= esc_html ( get_option('wp_estate_walkscore_api','') );
$show_graph_prop_page= esc_html( get_option('wp_estate_show_graph_prop_page', '') );
?>
<div role="tabpanel" id="tab_prpg">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
        <?php
                _e('Thông tin chung','wpestate');
        ?>
        </a>
        
    </li>
    
    <li role="presentation">
        <a href="#address" aria-controls="address" role="tab" data-toggle="tab">
            <?php
                _e('Vị trí & Tiện ích','wpestate');
            ?>
        </a>
    </li>
    
    <li role="presentation">
        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">
            <?php
                 _e('Giá & Chính sách', 'wpestate');
            ?>
        </a>
    </li>

  <li role="presentation">
      <a href="#images" aria-controls="details" role="tab" data-toggle="tab">
          <?php
          _e('Hình ảnh', 'wpestate');
          ?>
      </a>
  </li>
    
    <?php
    $prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') ); 
    $local_pgpr_slider_type_status  =   get_post_meta($post->ID, 'local_pgpr_slider_type', true);
    ?>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="description">
        <?php 
            $content = get_the_content();
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);

            if($content!=''){                            
                print $content;     
            }

            get_template_part ('/templates/download_pdf');
        ?>      
    </div>

    <div role="tabpanel" class="tab-pane" id="address">
        <?php
        $content = get_post_meta($post->ID, 'property-location', true);
        $content = apply_filters('meta_content', $content);
//        $content = str_replace(']]>', ']]&gt;', $content);
        print $content;
        ?>
    </div>
      
    <div role="tabpanel" class="tab-pane" id="details">
        <?php echo get_post_meta($post->ID, 'property-price', true); ?>
    </div>
      <div role="tabpanel" class="tab-pane" id="images">
          <?php echo get_post_meta($post->ID, 'property-images', true); ?>
      </div>
    <?php
    $prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );        
    if( ($local_pgpr_slider_type_status == 'global' && $prpg_slider_type_status == 'full width header') ||
        $local_pgpr_slider_type_status  == 'full width header' ){
    ?>
    <div role="propmap" class="tab-pane" id="propmap">
        <?php print do_shortcode('[property_page_map propertyid="'.$post->ID.'" istab="1"][/property_page_map]') ?>
    </div> 
    <?php } ?>

      
      
  </div>

</div>