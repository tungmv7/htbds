<?php
global $unit;
global $property_size;
global $property_lot_size;
global $property_rooms;
global $property_bedrooms;
global $property_bathrooms;
global $custom_fields_array;
global $owner_notes;
$measure_sys            = esc_html ( get_option('wp_estate_measure_sys','') ); 
?> 


<div class="submit_container">
<div class="submit_container_header"><?php _e('Listing Details','wpestate');?></div>

    <p class="half_form">
        <label for="property_size"> <?php _e('Size in','wpestate');print ' '.$measure_sys.'<sup>2</sup> '.__(' (*only numbers)','wpestate');?></label>
        <input type="text" id="property_size" size="40" class="form-control"  name="property_size" value="<?php print $property_size;?>">
    </p>

    <p class="half_form half_form_last">
        <label for="property_lot_size"> <?php  _e('Lot Size in','wpestate');print ' '.$measure_sys.'<sup>2</sup> '.__(' (*only numbers)','wpestate');?> </label>
        <input type="text" id="property_lot_size" size="40" class="form-control"  name="property_lot_size" value="<?php print $property_lot_size;?>">
    </p>

    <p class="half_form ">
        <label for="property_rooms"><?php _e('Rooms (*only numbers)','wpestate');?></label>
        <input type="text" id="property_rooms" size="40" class="form-control"  name="property_rooms" value="<?php print $property_rooms;?>">
    </p>

     <p class="half_form half_form_last">
        <label for="property_bedrooms "><?php _e('Bedrooms (*only numbers)','wpestate');?></label>
        <input type="text" id="property_bedrooms" size="40" class="form-control"  name="property_bedrooms" value="<?php print $property_bedrooms;?>">
    </p>

    <p class="half_form ">
        <label for="property_bathrooms"><?php _e('Bathrooms (*only numbers)','wpestate');?></label>
        <input type="text" id="property_bathrooms" size="40" class="form-control"  name="property_bathrooms" value="<?php print $property_bathrooms;?>">
    </p>

     <!-- Add custom details -->

     <?php
     $custom_fields = get_option( 'wp_estate_custom_fields', true);    

     $i=0;
     if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
            $name               =   $custom_fields[$i][0];
            $label              =   $custom_fields[$i][1];
            $type               =   $custom_fields[$i][2];
            $order              =   $custom_fields[$i][3];
            $dropdown_values    =   $custom_fields[$i][4];
            $slug               =   str_replace(' ','_',$name);
           
            $slug         =   wpestate_limit45(sanitize_title( $name ));
            $slug         =   sanitize_key($slug);
            $post_id      =     $post->ID;
            $show         =     1;  
            $i++;
           
            if (function_exists('icl_translate') ){
                $label     =   icl_translate('wpestate','wp_estate_property_custom_front_'.$label, $label ) ;
            }   

            if($i%2!=0){
                print '<p class="half_form half_form_last">';
            }else{
                print '<p class="half_form">';
            }
            $value=$custom_fields_array[$slug];
            wpestate_show_custom_field($show,$slug,$name,$label,$type,$order,$dropdown_values,$post_id,$value);
           

       }
    }

    ?>  
     
     <p class="full_form ">
        <label for="owner_notes"><?php _e('Owner/Agent notes (*not visible on front end)','wpestate');?></label>
      
        <textarea id="owner_notes" class="form-control"  name="owner_notes" ><?php print $owner_notes;?></textarea>
    </p>


</div>  
