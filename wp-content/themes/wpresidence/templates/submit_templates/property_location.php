<?php
global $property_address;
global $country_selected;
global $property_state;
global $property_zip;
global $property_state;
global $property_county;
global $property_latitude;
global $property_longitude;
global $google_view_check;
global $google_camera_angle;
global $property_area;
global $property_city;
global $property_county_state;


?>


<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Location','wpestate');?></div>

    <p class="full_form">
        <label for="property_address"><?php _e('*Address (mandatory) ','wpestate');?></label>
        <input type="text" placeholder="<?php _e('Enter address','wpestate')?>" id="property_address" class="form-control" size="40" name="property_address" rows="3" cols="42" value ="<?php print $property_address; ?>"/>
    </p>

  
        <div class="advanced_city_div half_form">
        <label for="property_city"><?php  _e('City','wpestate');?></label>
        
            <?php 
             $enable_autocomplete_status= esc_html ( get_option('wp_estate_enable_autocomplete','') );
             if($enable_autocomplete_status=='no'){
                $selected_city_id=-1;
                /*
                if($property_city!=''){
                    $term_city = get_term_by( 'name', $property_city, 'property_city');
                    $selected_city_id = $term_city->term_id;
                }
                */
                        
                $args=array(
                    'class'       => 'select-submit2',
                    'hide_empty'  => false,
                    'selected'    => $property_city,
                    'name'        => 'property_city',
                    'id'          => 'property_city_submit',
                    'orderby'     => 'NAME',
                    'order'       => 'ASC',
                    'show_option_none'   => __('None','wpestate'),
                    'taxonomy'    => 'property_city',
                    'hierarchical'=> true,
                    'value_field' => 'name'
                );
                wp_dropdown_categories( $args );
            }else{
            ?>
                <input type="text" id="property_city_submit" name="property_city" class="form-control" placeholder="<?php _e('Enter city','wpestate')?>" size="40" value="<?php print $property_city;?>" >
            <?php
            }
            ?>
        </div>


        <div class="advanced_area_div half_form half_form_last">
        <label for="property_area"><?php _e('Neighborhood','wpestate');?></label>
         
        <?php 
        
         
        if($enable_autocomplete_status=='no'){
            
            $select_area='';
            $taxonomy = 'property_area';
            $args_tax = array('hide_empty'        => false );
            $tax_terms = get_terms($taxonomy,$args_tax);

           
           
            foreach ($tax_terms as $tax_term) {
                $term_meta=  get_option( "taxonomy_$tax_term->term_id");
                $select_area.= '<option value="' . $tax_term->name . '" data-parentcity="' . $term_meta['cityparent'] . '"';
                    if($property_area==$tax_term->name ){
                          $select_area.= ' selected="selected" ';
                    }
                $select_area.= '>' . $tax_term->name . '</option>';
            }
          
        ?>
      
            <select id="property_area_submit" name="property_area"  class="cd-select">
               <option data-parentcity="none" value="none"><?php  _e('None','wpestate'); ?></option>
               <option data-parentcity="all" value="all"><?php   _e('All Areas','wpestate'); ?></option>
               <?php  echo ($select_area); ?>
            </select>
        
            <select id="property_area_submit_hidden" name="property_area_hidden"  class="cd-select">
                <option data-parentcity="none" value="none"><?php  _e('None','wpestate'); ?></option>
                <option data-parentcity="all" value="all"><?php  _e('All Areas','wpestate'); ?></option>
                <?php  echo ($select_area); ?>
            </select>
        <?php } else{ ?>
            <input type="text" id="property_area" name="property_area" class="form-control" size="40" value="<?php print $property_area;?>">
        <?php } ?>
        
        <!--
     
        -->
    </div> 


    <p class="half_form">
        <label for="property_zip"><?php _e('Zip ','wpestate');?></label>
        <input type="text" id="property_zip" class="form-control" size="40" name="property_zip" value="<?php print $property_zip;?>">
    </p>
<!--
    <p class="half_form ">
        <label for="property_state"><?php _e('State ','wpestate');?></label>
        <input type="text" id="property_state" class="form-control" size="40" name="property_state" value="<?php print $property_state;?>">
    </p>-->
    
    <p class="half_form  half_form_last" style="margin-bottom: 16px;">
        <label for="property_county"><?php _e('County / State','wpestate');?></label>
        <?php  
        if($enable_autocomplete_status=='no'){
            $selected_county_id=-1;
     
         /*  if($property_county_state!=''){
                $term_county = get_term_by( 'name', $property_county_state, 'property_county_state');
                $selected_county_id = $term_county->term_id;
            }
           */     
            $select_state='';
            $taxonomy = 'property_county_state';
            $tax_terms = get_terms($taxonomy,$args);
            
          
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $property_county_state,
                'name'        => 'property_county',
                'id'          => 'property_county',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_county_state',
                'hierarchical'=> true,
                'value_field' => 'name'
              );
              wp_dropdown_categories( $args );
       
        }else{
        ?>
            <input type="text" id="property_county" class="form-control"  size="40" name="property_county" value="<?php print $property_county;?>">
        <?php
        }
        ?>
        
     
    </p>
    
    
    
    
    
    <p class="half_form ">
        <label for="property_country"><?php _e('Country ','wpestate'); ?></label>
        <?php print wpestate_country_list($country_selected,'select-submit2'); ?>
    </p>

    <p class="full_form" style="float:left;">
        <button id="google_capture"  class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php _e('Place Pin with Property Address','wpestate');?></button>
    </p>

    <p class="full_form">
        <div id="googleMapsubmit" ></div>   
    </p>  

    <p class="half_form">            
         <label for="property_latitude"><?php _e('Latitude (for Google Maps)','wpestate'); ?></label>
         <input type="text" id="property_latitude" class="form-control" style="margin-right:20px;" size="40" name="property_latitude" value="<?php print $property_latitude; ?>">
    </p>

    <p class="half_form half_form_last">    
         <label for="property_longitude"><?php _e('Longitude (for Google Maps)','wpestate');?></label>
         <input type="text" id="property_longitude" class="form-control" style="margin-right:20px;" size="40" name="property_longitude" value="<?php print $property_longitude;?>">
    </p>

    <p class="half_form">
        <label for="property_google_view"><?php _e('Enable Google Street View','wpestate');?></label>
        <input type="hidden"    name="property_google_view" value="">
        <input type="checkbox"  id="property_google_view"  name="property_google_view" value="1" <?php print $google_view_check;?> >                           
    </p></br>

    <p class="half_form half_form_last">
        <label for="google_camera_angle"><?php _e('Google Street View - Camera Angle (value from 0 to 360)','wpestate');?></label>
        <input type="text" id="google_camera_angle" class="form-control" style="margin-right:0px;" size="5" name="google_camera_angle" value="<?php print $google_camera_angle;?>">
    </p>

</div> 
