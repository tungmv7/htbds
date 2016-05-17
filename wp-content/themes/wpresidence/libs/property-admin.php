<?php
if( !function_exists('wpestate_fields_type_select') ):

function wpestate_fields_type_select($real_value){

    $select = '<select id="field_type" name="add_field_type[]" style="width:140px;">';
    $values = array('short text','long text','numeric','date','dropdown');
    
    foreach($values as $option){
        $select.='<option value="'.$option.'"';
            if( $option == $real_value ){
                 $select.= ' selected="selected"  ';
            }       
        $select.= ' > '.$option.' </option>';
    }   
    $select.= '</select>';
    return $select;
}
endif; // end   wpestate_fields_type_select  






if( !function_exists('wpestate_custom_fields') ):

function wpestate_custom_fields(){
    
    $custom_fields = get_option( 'wp_estate_custom_fields', true);     
    $current_fields='';

    
    $i=0;
    if( !empty($custom_fields)){    
        while($i< count($custom_fields) ){
            $current_fields.='
                <div class=field_row>
                <div    class="field_item"><strong>'.__('Field Name','wpestate').'</strong></br><input  type="text" name="add_field_name[]"   value="'.$custom_fields[$i][0].'"  ></div>
                <div    class="field_item"><strong>'.__('Field Label','wpestate').'</strong></br><input  type="text" name="add_field_label[]"   value="'.$custom_fields[$i][1].'"  ></div>
                <div    class="field_item"><strong>'.__('Field Type','wpestate').'</strong></br>'.wpestate_fields_type_select($custom_fields[$i][2]).'</div>
                <div    class="field_item"><strong>'.__('Field Order','wpestate').'</strong></br><input  type="text" name="add_field_order[]" value="'.$custom_fields[$i][3].'"></div>     
                <div    class="field_item newfield"><strong>'.__('Dropdown values','wpestate').'</strong></br><textarea name="add_dropdown_order[]">'.$custom_fields[$i][4].'</textarea></div>     
             
                <a class="deletefieldlink" href="#">'.__('delete','wpestate').'</a>
            </div>';    
            $i++;
        }
    }
 
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Custom Fields','wpestate').'</h1>'; 
    print '<a href="http://help.wpresidence.net/#!/customfields" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print' <form method="post" action="">
    
        <div id="custom_fields">
        '.$current_fields.'
        <input type="hidden" name="is_custom" value="1">   
        </div>

        <h3 style="margin-left:10px;">'.__('Add New Custom Field','wpestate').'</h3>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <tr valign="top">
                        <th scope="row">'.__('Field name','wpestate').'</th>
                        <td>
                            <input  type="text" id="field_name"  name="field_name"   value="" size="40"/>
                        </td>
                    </tr>
                     
                    <tr valign="top">
                        <th scope="row">'.__('Field Label','wpestate').'</th>
                        <td>
                            <input  type="text" id="field_label"  name="field_label"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Field Type','wpestate').'</th>
                        <td>
                            <select id="field_type" name="field_type"  style="width:310px;">
                                <option value="short text"> short text  </option>
                                <option value="long text">  long text   </option>
                                <option value="numeric">    numeric     </option>
                                <option value="date">       date        </option>
                                 <option value="dropdown">       dropdown        </option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__(' Order in listing page','wpestate').'</th>
                        <td>
                             <input  type="text" id="field_order"  name="field_order"   value="" size="40"/>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th scope="row">'.__('Dropdown values separated by "," (only for dropdown field type)','wpestate').'</th>
                        <td>
                            <textarea id="drodown_values"  name="drodown_values"  ></textarea>
                        </td>
                    </tr>   
            </tbody>
        </table>   
        
       <a href="#" id="add_field">'.__(' click to add field','wpestate').'</a><br>

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" style="margin-left:10px;" value="'.__('Save Changes','wpestate').'" />
        </p>

    </form> 
    </div> 
    ';
}
endif; // end   wpestate_custom_fields  










if( !function_exists('wpestate_display_features') ):

function wpestate_display_features(){
    $feature_list                           =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list                           =   str_replace(', ',',&#13;&#10;',$feature_list);
    
    $cache_array=array('yes','no');
    $show_no_features_symbol =  wpestate_dropdowns_theme_admin($cache_array,'show_no_features');
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Listings Features & Amenities','wpestate').'</h1>';  
    print '<a href="http://help.wpresidence.net/#!/editsettings" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Add New Element in Features and Amenities </th>
                    <td>
                        <input  type="text" id="new_feature"  name="new_feature"   value="type here feature name.. " size="40"/><br>
                        <a href="#" id="add_feature"> click to add feature </a><br>
                        <textarea id="feature_list" name="feature_list" rows="15" cols="42">'. $feature_list.'</textarea>  
                    </td>

                </tr>
                

                <tr valign="top">
                    <th scope="row">Show the Features and Amenities that are not available </th>
                    <td>
                        <select id="show_no_features" name="show_no_features">
                            '.$show_no_features_symbol.'
                        </select>
                    </td>
                </tr>
                
            </tbody>
        </table>   

        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" style="margin-left:10px;" value="Save Changes" />
        </p>

    </form> 
    </div> 
    ';
}
endif; // end   wpestate_display_features  






if( !function_exists('wpestate_display_labels') ):

function wpestate_display_labels(){
       
    $cache_array                            =   array('yes','no');
    $status_list                            =   esc_html( get_option('wp_estate_status_list') );
    $status_list                            =   str_replace(', ',',&#13;&#10;',$status_list);
    $property_adr_text                      =   stripslashes ( esc_html( get_option('wp_estate_property_adr_text') ) );
    $property_description_text              =   stripslashes ( esc_html( get_option('wp_estate_property_description_text') ) );
    $property_details_text                  =   stripslashes ( esc_html( get_option('wp_estate_property_details_text') ) );
    $property_features_text                 =   stripslashes ( esc_html( get_option('wp_estate_property_features_text') ) );
   
   


    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Listings Labels','wpestate').'</h1>';    
    print '<a href="http://help.wpresidence.net/#!/editsettings" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
    print '
    <form method="post" action="">
        <table class="form-table">
            <tbody>
              
                <tr valign="top">
                    <th scope="row">Property Adress Label</th>
                    <td>
                        <input  type="text" id="property_adr_text"  name="property_adr_text"   value="'.$property_adr_text.'" size="40"/>
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Property Features Label</th>
                    <td>
                        <input  type="text" id="property_features_text"  name="property_features_text"   value="'.$property_features_text.'" size="40"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Property Description Label</th>
                    <td>
                        <input  type="text" id="property_description_text"  name="property_description_text"   value="'.$property_description_text.'" size="40"/>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Property Details Label</th>
                    <td>
                        <input  type="text" id="property_details_text"  name="property_details_text"   value="'.$property_details_text.'" size="40"/>
                    </td>
                </tr>

                  <tr valign="top">
                    <th scope="row">Property Status (* you may need to add new css classes - please see the help files) </th>
                    <td>
                        <input  type="text" id="new_status"  name="new_status"   value="type here the new status... " size="40"/>
                        <a href="#new_status" id="add_status"> click to add new status </a><br>
                        <textarea id="status_list" name="status_list" rows="7" cols="42">'.$status_list.'</textarea>  
                    </td>
                </tr>


               

            </tbody>
        </table>   



        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" style="margin-left:10px;" value="Save Changes" />
        </p>

    </form> 
    </div> 
    ';
}
endif; // end   wpestate_display_labels  

?>