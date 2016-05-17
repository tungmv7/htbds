<?php
// this is the slider for the blog post
// embed_video_id embed_video_type
global $slider_size;
$video_id       =   '';
$video_thumb    =   '';
$video_alone    =   0;
$full_img       =   '';
$arguments      = array(
                    'numberposts' => -1,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent' => $post->ID,
                    'post_status' => null,
                    'exclude' => get_post_thumbnail_id(),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );

$post_attachments   = get_posts($arguments);
$video_id           = esc_html( get_post_meta($post->ID, 'embed_video_id', true) );
$video_type         = esc_html( get_post_meta($post->ID, 'embed_video_type', true) );
      
$prop_stat = esc_html( get_post_meta($post->ID, 'property_status', true) );    
if (function_exists('icl_translate') ){
    $prop_stat     =   icl_translate('wpestate','wp_estate_property_status_'.$prop_stat, $prop_stat ) ;                                      
}
$ribbon_class       = str_replace(' ', '-', $prop_stat);    
        
        
if ($post_attachments || has_post_thumbnail() || get_post_meta($post->ID, 'embed_video_id', true)) {  ?>   
    <div id="carousel-listing" class="carousel slide post-carusel carouselvertical" data-ride="carousel" data-interval="false">
        <?php 
        if($prop_stat!='normal'){
            print '<div class="slider-property-status verticalstatus ribbon-wrapper-'.$ribbon_class.' '.$ribbon_class.'">' . $prop_stat . '</div>';
        }
        ?>
        
        <?php  
        $indicators='';
        $round_indicators='';
        $slides ='';
        $captions='';
        $counter=0;
        $has_video=0;
        if($video_id!=''){
            $has_video  =   1; 
            $counter    =   1;
            $videoitem  =   'videoitem';
            if ($slider_size    ==  'full'){
                $videoitem  =  'videoitem_full';
            }
          
            
            $indicators.='<li data-target="#carousel-listing"  data-video_data="'.$video_type.'" data-video_id="'.$video_id.'"  data-slide-to="0" class="active video_thumb_force">
                         <img src= "'.get_video_thumb($post->ID).'" alt="video_thumb" class="img-responsive"/>
                         <span class="estate_video_control"><i class="fa fa-play"></i> </span>
                         </li>'; 

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="0" class="active"></li>';

            $slides .= '<div class="item active '.$videoitem.'">';

             if($video_type=='vimeo'){
                 $slides .= custom_vimdeo_video($video_id);
             }else{
                  $slides.= custom_youtube_video($video_id);
             }

             $slides   .= '</div>';
             $captions .= '<span data-slide-to="0" class="active" >'.__('Video','wpestate').'</span>';
        }

        if( has_post_thumbnail() ){
              $counter++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id( $post->ID );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');
            
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider');
            }
          
            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);
    
            $indicators.= '<li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                           </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'" ></li>';
            $slides .= '<div class="item '.$active.' ">
                           <a href="'.$full_prty[0].'" rel="prettyPhoto[pp_gal]" class="prettygalery"> 
                                <img  src="'.$full_img[0].'"  alt="'.$attachment_meta['alt'].'" class="img-responsive" />
                           </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'" >'. $attachment_meta['caption'].'</span>';

        }



        foreach ($post_attachments as $attachment) {
            $counter++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            }
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);

            $indicators.= ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.$preview[0].'"  alt="slider" />
                            </li>';
            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'"></li>';

            $slides .= '<div class="item '.$active.'">
                        <a href="'.$full_prty[0].'" rel="prettyPhoto[pp_gal]" class="prettygalery" > 
                            <img  src="'.$full_img[0].'" alt="'.$attachment_meta['alt'].'"  class="img-responsive" />
                         </a>
                        </div>';

            $captions .= '<span data-slide-to="'.($counter-1).'" class="'.$active.'">'. $attachment_meta['caption'].'</span>';                    
        }// end foreach
        ?>

    <?php 
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    $global_header_type         =   get_option('wp_estate_header_type','');

  
  
    if ( $header_type == 0 ){ // global
        if ($global_header_type != 4){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$post->ID.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
                ?>
                <div id="slider_enable_map">    <i class="fa fa-map-marker"></i>        </div>
                <?php 
                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    print '  <div id="slider_enable_street"> <i class="fa fa-location-arrow"></i>    </div>';
                      $no_street='';
                }
                ?>
              
                <div id="slider_enable_slider" class="slideron <?php echo   $no_street; ?>"> <i class="fa fa-picture-o"></i>         </div>
                
                <div id="gmapzoomplus"  class="smallslidecontrol"><i class="fa fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol"><i class="fa fa-minus"></i></div>
        
                <div id="googleMapSlider" <?php print $property_add_on; ?> >              
                </div> 
        <?php       
        }
    }else{
        if($header_type!=5){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.$post->ID.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
                ?>
                <div id="slider_enable_map">    <i class="fa fa-map-marker"></i>        </div>
                <?php 
                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    print '  <div id="slider_enable_street"> <i class="fa fa-location-arrow"></i>    </div>';
                      $no_street='';
                }
                ?>
                <div id="slider_enable_slider" class="slideron <?php echo   $no_street; ?>"> <i class="fa fa-picture-o"></i>         </div>
                
                <div id="gmapzoomplus"  class="smallslidecontrol" ><i class="fa fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol" ><i class="fa fa-minus"></i></div>
                
                <div id="googleMapSlider" <?php print $property_add_on; ?> >   
                </div>
        <?php        
        }
    }
       
   
    ?>    

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <?php print $slides;?>
    </div>

    <!-- Indicators -->    
   <!-- <div class="carusel-back"></div>  -->
    <ol  id="carousel-indicators-vertical">
      <?php print $indicators; ?>
    </ol>

    <!--
    <ol class="carousel-round-indicators">
        <?php // print $round_indicators;?>
    </ol> 
    -->

    <div class="caption-wrapper vertical-wrapper">   
      <div class="vertical-wrapper-back"></div>  
      <?php print $captions;?>
     <!--   <div class="caption_control"></div> -->
    </div>  

    <!-- Controls -->
    <a class="left vertical carousel-control" href="#carousel-listing" data-slide="prev">
      <i class="fa fa-angle-left"></i>
    </a>
    <a class="right vertical carousel-control" href="#carousel-listing" data-slide="next">
      <i class="fa fa-angle-right"></i>
    </a>
    </div>

<?php
} // end if post_attachments
?>