<?php
add_action('add_meta_boxes', 'estate_sidebar_meta');
add_action('save_post', 'estate_save_postdata', 1, 2);


if( !function_exists('estate_sidebar_meta') ):

function estate_sidebar_meta() {
    global $post;
    add_meta_box('wpestate-sidebar-post',       __('Sidebar Settings',  'wpestate'), 'estate_sidebar_box', 'post');
    add_meta_box('wpestate-sidebar-page',       __('Sidebar Settings',  'wpestate'), 'estate_sidebar_box', 'page');
    add_meta_box('wpestate-sidebar-property',   __('Sidebar Settings',  'wpestate'), 'estate_sidebar_box', 'estate_property');
    add_meta_box('wpestate-sidebar-agent',      __('Sidebar Settings',  'wpestate'), 'estate_sidebar_box', 'estate_agent');
    add_meta_box('wpestate-settings-post',      __('Post Settings',     'wpestate'), 'estate_post_options_box', 'post', 'normal', 'default' );
    add_meta_box('wpestate-settings-page',      __('Page Settings',     'wpestate'), 'estate_page_options_box', 'page', 'normal', 'default' );
    if( basename(get_page_template($post->ID))== 'property_list.php' ||  basename(get_page_template($post->ID))== 'property_list_half.php'){
        add_meta_box('wpestate-pro_list_adv',       __('Property List Advanced Options','wpestate'), 'estate_prop_advanced_function', 'page', 'normal', 'low');
    }
    add_meta_box('wpestate-header',             __('Appearance Options','wpestate'), 'estate_header_function', 'page', 'normal', 'low');
    add_meta_box('wpestate-header',             __('Appearance Options','wpestate'), 'estate_header_function', 'post', 'normal', 'low');
    add_meta_box('wpestate-header',             __('Appearance Options','wpestate'), 'estate_header_function', 'estate_agent', 'normal', 'low');
    add_meta_box('wpestate-header',             __('Appearance Options','wpestate'), 'estate_header_function', 'estate_property', 'normal', 'low');
    
}
endif; // end   estate_sidebar_meta  




///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Header Option
///////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_header_function') ):
function estate_header_function(){
    global $post;
    $header_array   =   array(
                            'global',
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    
    $header_type    =   get_post_meta ( $post->ID, 'header_type', true);
    $header_select  =   '';
    
    foreach($header_array as $key=>$value){
       $header_select.='<option value="'.$key.'" ';
       if($key==$header_type){
           $header_select.=' selected="selected" ';
       }
       $header_select.='>'.$value.'</option>'; 
    }
   
    ////////// end logo header
    $cache_array                =   array('global','no','yes');
    $header_transparent         =   get_post_meta ( $post->ID, 'header_transparent', true);
    $header_transparent_select  =   '';
    
    foreach($cache_array as $key=>$value){
       $header_transparent_select.='<option value="'.$value.'" ';
       if($value==$header_transparent){
           $header_transparent_select.=' selected="selected" ';
       }
       $header_transparent_select.='>'.$value.'</option>'; 
    }
    print'
    <h3 class="pblankh">'.__('Select header type','wpestate').'</h3>
    <select name="header_type">
        '.$header_select.'
    </select>';
    
    print'
    <h3 class="pblankh">'.__('Use transparent header','wpestate').'</h3>
    <select name="header_transparent">
        '.$header_transparent_select.'
    </select>';
    
    estate_page_map_box($post);
    estate_page_slider_box($post);
    estate_prpg_design_option($post);
    }
    
endif;



if(!function_exists('estate_prpg_design_option')):
    function estate_prpg_design_option(){
        global $post;
        if(   'estate_property' == get_post_type() ){
            print '<p class="meta-options pblank">
            <h3 class="pblankh">'.__('Content options','wpestate').'</h3>
            </p>';
            
            $sidebar_agent_option='';    
            $sidebar_option_values=array('global','no','yes');
            $sidebar_agent_option_value=    get_post_meta($post->ID, 'sidebar_agent_option', true);


            foreach ($sidebar_option_values as $key=>$value) {
                $sidebar_agent_option.='<option value="' . $value . '"';
                if ($value == $sidebar_agent_option_value) {
                    $sidebar_agent_option.=' selected="selected"';
                }
                $sidebar_agent_option.='>' . $value . '</option>';
            }

            // slider type
            $slider_type                    =   array('global','vertical','horizontal','full width header');
            $local_pgpr_slider_type_symbol='';
            $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);

            foreach($slider_type as $value){
                $local_pgpr_slider_type_symbol.='<option value="'.$value.'"';
                if ($local_pgpr_slider_type_status==$value){
                    $local_pgpr_slider_type_symbol.=' selected="selected" ';
                }
                $local_pgpr_slider_type_symbol.='>'.$value.'</option>';
            }
            
            //  content
            $content_type                       =   array('global','accordion','tabs');
            $local_pgpr_content_type_symbol     =   '';
            $local_pgpr_content_type_status     =  get_post_meta($post->ID, 'local_pgpr_content_type', true);

            foreach($content_type as $value){
                $local_pgpr_content_type_symbol.='<option value="'.$value.'"';
                if ($local_pgpr_content_type_status==$value){
                    $local_pgpr_content_type_symbol.=' selected="selected" ';
                }
                $local_pgpr_content_type_symbol.='>'.$value.'</option>';
            }

            print ' <p class="meta-options"><label for="sidebar_agent_option">'.__('Show Agent on Sidebar ? ','wpestate').' </label><br />
            <select id="sidebar_agent_option" name="sidebar_agent_option" style="width: 200px;">
            ' . $sidebar_agent_option . '
            </select>

            <p class="meta-options"><label for="local_pgpr_slider_type">'.__('Slider Type ? ','wpestate').' </label><br />
            <select id="local_pgpr_slider_type" name="local_pgpr_slider_type"  style="width: 200px;">
                '.$local_pgpr_slider_type_symbol.'
            </select> 

         
            
            <p class="meta-options"><label for="local_pgpr_content_type">'.__('Show Content as ','wpestate').' </label><br />
            <select id="local_pgpr_content_type" name="local_pgpr_content_type"  style="width: 200px;">
                '.$local_pgpr_content_type_symbol.'
            </select> 

            </p>'; 
            }  
    }
endif;






///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Property Listing advanced options
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_prop_advanced_function') ):
function estate_prop_advanced_function(){
    global $post;
    
    if( basename(get_page_template($post->ID))!= 'property_list.php' && basename(get_page_template($post->ID))!= 'property_list_half.php' ){
        _e('Only for "Properties List" page template ! ','wpestate');
        return;
    }
    
    $args = array(
        'hide_empty'    => false 
    );  
    
    $actions_select     =   '';
    $categ_select       =   '';
    $taxonomy           =   'property_action_category';
    $tax_terms          =   get_terms($taxonomy,$args);

    $current_adv_filter_search_action = get_post_meta ( $post->ID, 'adv_filter_search_action', true);
    if($current_adv_filter_search_action==''){
        $current_adv_filter_search_action=array();
    }
    
    
    $all_selected='';
    if(!empty($current_adv_filter_search_action) && $current_adv_filter_search_action[0]=='all'){
      $all_selected=' selected="selected" ';  
    }
   
    $actions_select.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
    if( !empty( $tax_terms ) ){                       
        foreach ($tax_terms as $tax_term) {
            $actions_select.='<option value="'.$tax_term->name.'" ';
            if( in_array  ( $tax_term->name,$current_adv_filter_search_action) ){
              $actions_select.=' selected="selected" ';  
            }
            $actions_select.=' />'.$tax_term->name.'</option>';      
        } 
    }
      
   
    
    //////////////////////////////////////////////////////////////////////////////////////////
    $taxonomy           =   'property_category';
    $tax_terms          =   get_terms($taxonomy,$args);

    $current_adv_filter_search_category = get_post_meta ( $post->ID, 'adv_filter_search_category', true);
    if($current_adv_filter_search_category==''){
        $current_adv_filter_search_category=array();
    }
    
    $all_selected='';
    if( !empty($current_adv_filter_search_category) && $current_adv_filter_search_category[0]=='all'){
      $all_selected=' selected="selected" ';  
    }
    
    $categ_select.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
    if( !empty( $tax_terms ) ){                       
        foreach ($tax_terms as $tax_term) {
            $categ_select.='<option value="'.$tax_term->name.'" ';
            if( in_array  ( $tax_term->name, $current_adv_filter_search_category) ){
              $categ_select.=' selected="selected" ';  
            }
            $categ_select.=' />'.$tax_term->name.'</option>';      
        } 
    }
    
  
 //////////////////////////////////////////////////////////////////////////////////////////   
    
    $select_city='';
    $taxonomy = 'property_city';
    $tax_terms_city = get_terms($taxonomy,$args);
    $current_adv_filter_city = get_post_meta ( $post->ID, 'current_adv_filter_city', true);
    
    if($current_adv_filter_city==''){
        $current_adv_filter_city=array();
    }

    $all_selected='';
    if( !empty($current_adv_filter_city) && $current_adv_filter_city[0]=='all'){
      $all_selected=' selected="selected" ';  
    }
    
    $select_city.='<option value="all" '.$all_selected.' >'.__('all','wpestate').'</option>';
    foreach ($tax_terms_city as $tax_term) {
        
        $select_city.= '<option value="' . $tax_term->name . '" ';
        if( in_array  ( $tax_term->name, $current_adv_filter_city) ){
              $select_city.=' selected="selected" ';  
        }
        $select_city.= '>' . $tax_term->name . '</option>';
    } 
  
     
 //////////////////////////////////////////////////////////////////////////////////////////   
    
    $select_area='';
    $taxonomy = 'property_area';
    $tax_terms_area = get_terms($taxonomy,$args);
    $current_adv_filter_area = get_post_meta ( $post->ID, 'current_adv_filter_area', true);
    if($current_adv_filter_area==''){
        $current_adv_filter_area=array();
    }
    
    $all_selected='';
    if(!empty($current_adv_filter_area) && $current_adv_filter_area[0]=='all'){
      $all_selected=' selected="selected" ';  
    }
    
    $select_area.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
    foreach ($tax_terms_area as $tax_term) {
        $term_meta=  get_option( "taxonomy_$tax_term->term_id");
        $select_area.= '<option value="' . $tax_term->name . '" ';
        if( in_array  ( $tax_term->name, $current_adv_filter_area) ){
              $select_area.=' selected="selected" ';  
        }
        $select_area.= '>' . $tax_term->name . '</option>';
    } 

//////////////////////////////////   
    
    
    
    $show_filter_area_select='';
    $cache_array=array('yes','no');
    $show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);
    
    foreach($cache_array as $value){
         $show_filter_area_select.='<option value="'.$value.'"';
         if ( $show_filter_area == $value ){
                 $show_filter_area_select.=' selected="selected" ';
         }
         $show_filter_area_select.='>'.$value.'</option>';
    }
    
    
    
    
    
    
    $show_featured_only_select='';
    $show_featured_only  =   get_post_meta($post->ID, 'show_featured_only', true);
    foreach($cache_array as $value){
       
         $show_featured_only_select.='<option value="'.$value.'" ';
         if ( $show_featured_only == $value ){
                 $show_featured_only_select.=' selected="selected" ';
         }
         $show_featured_only_select.='>'.$value.'</option>';
    }

    $listing_filter = get_post_meta($post->ID, 'listing_filter',true );

    $listing_filter_array=array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "3"=>__('Newest first','wpestate'),
                            "4"=>__('Oldest first','wpestate'),
                            "5"=>__('Bedrooms High to Low','wpestate'),
                            "6"=>__('Bedrooms Low to high','wpestate'),
                            "7"=>__('Bathrooms High to Low','wpestate'),
                            "8"=>__('Bathrooms Low to high','wpestate'),
                            "0"=>__('Default','wpestate')
                            );
    
    
 print '
     *press CTRL for multiple selection
     <table>
     <tr>
    <td width="33%" valign="top" align="left">
        <p class="meta-options">
            <label   for="filter_search_action[]">Pick actions</label> </br>
            <select  name="adv_filter_search_action[]"  multiple="multiple" style="width:250px;" >
            '.$actions_select.'
             </select>
        </p>
    </td>
    
    <td width="33%" valign="top" align="left">
        <p class="meta-options">
           <label for="adv_filter_search_category[]">Pick category</label> </br>
           <select  name="adv_filter_search_category[]"  multiple="multiple" style="width:250px;" >
           '.$categ_select.'
           </select>
        </p>
    </td>
    
    </tr>
    

    <tr>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
                <label for="current_adv_filter_city[]">Pick City</label> </br>
                <select  name="current_adv_filter_city[]"  multiple="multiple" style="width:250px;" >
                '.$select_city.'
                </select>
            </p>
        </td>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
               <label for="current_adv_filter_area[]">Pick Area</label> </br>
                <select  name="current_adv_filter_area[]"  multiple="multiple" style="width:250px;" >
                '.$select_area.'
                </select>
            </p>
        </td>

    </tr>
    
    <tr>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
               <label for="listing_filter_div">Default sort ?</label><br />
               <select id="listing_filter_div" name="listing_filter"  style="width:250px;">';
               foreach($listing_filter_array as $key=>$value){
                  print '<option  value="'.$key.'" ';
                      if($key==$listing_filter){
                          print ' selected="selected" ';
                      }
                  print '>'.$value.'</option>'; 
               }        
               print '
               </select>
            </p>
        </td>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
               <label for="show_featured_only">Show featured only </label><br />
                <select id="show_featured_only"  name="show_featured_only" style="width:250px;" >
                ' .$show_featured_only_select . '
                </select>
            </p>
        </td>

    </tr>
    
    <tr>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
                <label for="show_filter_area">Show filter area</label><br />
              <select id="show_filter_area"  name="show_filter_area" style="width:250px;" >
              ' .$show_filter_area_select . '
              </select>
            </p>
        </td>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
              
             
            </p>
        </td>

    </tr>
  


     </table>

     
    
 
     
<style media="screen" type="text/css">

.adv_prop_container{
float:left;
width:22%;
margin-right:10px;
}

</style>
';
}

endif;
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Listing options
///////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_listing_options') ):
  function estate_listing_options(){

      
    global $post;
    if ( 'property_list.php'== basename( get_page_template() )){
   
        $listing_action  =   get_post_meta($post->ID, 'listing_action', true);
        $listing_categ   =   get_post_meta($post->ID, 'listing_categ', true);
        $listing_city    =   get_post_meta($post->ID, 'listing_city', true);
        $listing_area    =   get_post_meta($post->ID, 'listing_area', true);
      
        $args = array(
        'hide_empty'    => false  
        ); 

        $taxonomy = 'property_action_category';
        $tax_terms = get_terms($taxonomy,$args);

        $taxonomy_categ = 'property_category';
        $tax_terms_categ = get_terms($taxonomy_categ,$args);

        $actions_select     =   '';
        $categ_select       =   '';


        ///////////////////////// actions
        if( !empty( $tax_terms ) ){                       
            foreach ($tax_terms as $tax_term) {
              $actions_select.='<option value="'.$tax_term->name.'" ';
              if ($tax_term->name == $listing_action ){
                   $actions_select.=' selected="selected" ';
              }
              $actions_select.=' >'.$tax_term->name.'</option>';
            } 
        }


        /////////////////////////categ
        
        if( !empty( $tax_terms_categ ) ){                       
            foreach ($tax_terms_categ as $categ) {
              $categ_select.='<option value="'.$categ->name.'" ';   
               if ($categ->name == $listing_categ ){
                   $categ_select.=' selected="selected" ';
              }
              $categ_select.='>'.$categ->name.'</option>';
            }
        }

        
        ///////////////////////// city 
        $select_city='';
        $taxonomy = 'property_city';
        $tax_terms = get_terms($taxonomy,$args);
        foreach ($tax_terms as $tax_term) {
           $select_city.= '<option value="' . $tax_term->name . '" ';
           if ( $tax_term->name  == $listing_city ){
                   $select_city.=' selected="selected" ';
              }
           $select_city.='>' . $tax_term->name . '</option>';
        }

        if ($select_city==''){
              $select_city.= '<option value="">No Cities</option>';
        }

        
        
        /////////////////////////area 
        $select_area='';
        $taxonomy = 'property_area';
        $tax_terms = get_terms($taxonomy,$args);

        foreach ($tax_terms as $tax_term) {
            $term_meta=  get_option( "taxonomy_$tax_term->term_id");
            $select_area.= '<option value="' . $tax_term->name . '" data-parentcity="' . $term_meta['cityparent'] . '" ';
            
             if ( $tax_term->name  == $listing_area ){
                   $select_area.=' selected="selected" ';
              }
      
            $select_area.= '>' . $tax_term->name . '</option>';
             
         }
   
        print '
        <p class="meta-options">
            <label for="listing_action">'.__('Action category','wpestate').'</label><br />
            <select  name="listing_action" >
                <option value="all">'.__('All Listings','wpestate').'</option>
                '.$actions_select.'
           </select>
        </p>


        <p class="meta-options">
        <label for="listing_categ">'.__('Pick Category','wpestate').'</label><br />
            <select name="listing_categ"  >
                <option value="all">'.__('All Types','wpestate').'</option>
                '. $categ_select.'
            </select>
        </p>

        <p class="meta-options">
            <label for="listing_city">'.__('Pick City','wpestate').'</label><br />
            <select  name="listing_city"  >
                <option value="all">'.__('All Cities','wpestate').'</option>
                '. $select_city.'
             </select>
        </p>

        <p class="meta-options">
            <label for="listing_area">'.__('Pick Area','wpestate').'</label><br />
            <select  name="listing_area">
                <option data-parentcity="*" value="all">'.__('All Areas','wpestate').'</option>
                '.$select_area.'
            </select>
        </p>
         ';
      
      
        }else{
            print _e('These Options are available for "Property list" page template only!','wpestate');
        }
   
  }
endif; // end   estate_listing_options





////////////////////////////////////////////////////////////////////////////////////////////////
// Manage Revolution Slider
////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_page_slider_box') ):
function estate_page_slider_box($post) {
    global $post;
    $rev_slider           = get_post_meta($post->ID, 'rev_slider', true);
    print '  
    <p class="meta-options pblank">
        <h3 class="pblankh">'.__('Options for Revolution Slider (if Header Type "revolution slider" is selected)','wpestate').'</h3>
    </p>
    <p class="meta-options">	
        <label for="page_custom_lat">'.__('Revolution Slider Name','wpestate').'</label><br />
        <input type="text" id="rev_slider" name="rev_slider" size="40" value="'.$rev_slider.'">
    </p>
    ';
}
endif; // end   estate_page_slider_box  


////////////////////////////////////////////////////////////////////////////////////////////////
// Manage Google Maps
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_page_map_box') ): 
function estate_page_map_box($post) {
    global $post;
    $page_lat           = get_post_meta($post->ID, 'page_custom_lat', true);
    $page_long          = get_post_meta($post->ID, 'page_custom_long', true);
    $page_custom_image  = get_post_meta($post->ID, 'page_custom_image', true);
    $page_custom_zoom   = get_post_meta($post->ID, 'page_custom_zoom', true);
    $min_height         = intval( esc_html(get_post_meta($post->ID, 'min_height', true)) );
    $max_height         = intval( esc_html(get_post_meta($post->ID, 'max_height', true)) );
    $cache_array        = array('yes','no');
    $keep_min_symbol    = '';
    $keep_min_status    = esc_html ( get_post_meta($post->ID, 'keep_min', true) );

    foreach($cache_array as $value){
            $keep_min_symbol.='<option value="'.$value.'"';
            if ($keep_min_status==$value){
                    $keep_min_symbol.=' selected="selected" ';
            }
            $keep_min_symbol.='>'.$value.'</option>';
    }
    
    if ($page_custom_zoom==''){
        $page_custom_zoom=15;
    }
    print '
        <p class="meta-options pblank">
            <h3 class="pblankh">'.__('Options for Google Maps (if Header Type "google map" is selected)','wpestate').'</h3>
        </p>';
    
    if( get_post_type($post->ID)!="estate_property" ){
        print '
       
        <p class="meta-options">
            '.__('  Leave these blank in order to get the general map settings.','wpestate').'
        </p>
        
        <p class="meta-options">	
            <label for="page_custom_lat">'.__('Map - Center point  Latitudine: ','wpestate').'</label><br />
            <input type="text" id="page_custom_lat" name="page_custom_lat" size="40" value="'.$page_lat.'">
        </p>

        <p class="meta-options">	
            <label for="page_custom_long">'.__('Map - Center point  Longitudine: ','wpestate').'</label><br />
            <input type="text" id="page_custom_long" name="page_custom_long" size="40" value="'.$page_long.'">
        </p>



        <p class="meta-options">
            <label for="page_custom_zoom">'.__('Zoom Level for map (1-20)','wpestate').'</label><br />
            <select name="page_custom_zoom" id="page_custom_zoom">';

            for ($i=1;$i<21;$i++){
                print '<option value="'.$i.'"';
                if($page_custom_zoom==$i){
                    print ' selected="selected" ';
                }
                print '>'.$i.'</option>';
            }
            print'
            </select>
        </p>';
    }
 
    print'
        <p class="meta-options">
            <label for="min_height">'.__('Height of the map when closed','wpestate').'</label><br />
            <input id="min_height" type="text" size="36" name="min_height" value="'.$min_height.'" />
        <p>

        <p class="meta-options">
           <label for="max_height">'.__('Height of map when open','wpestate').'</label><br />
           <input id="max_height" type="text" size="36" name="max_height" value="'.$max_height.'" />
        <p>

        <p class="meta-options">
            <label for="keep_min">'.__('Force map at the "closed" size ? ','wpestate').'</label><br />
            <select id="keep_min" name="keep_min">
            <option value=""></option>
               '.$keep_min_symbol.'
            </select>           
        <p>
    
        <p class="meta-options pblank">
            <h3 class="pblankh">'.__('Options for Static Image  (if Header Type "image" is selected)','wpestate').'</h3>
        </p>
     
        <p class="meta-options">
             <label for="page_custom_image">'.__('Header Image','wpestate').'</label><br />
             <input id="page_custom_image" type="text" size="36" name="page_custom_image" value="'.$page_custom_image.'" />
             <input id="page_custom_image_button" type="button"   size="40" class="upload_button button" value="'.__('Upload Image','wpestate').'" />
        </p>
        
        <p class="meta-options pblank">
        </p>';
}
endif; // end   estate_page_map_box 


////////////////////////////////////////////////////////////////////////////////////////////////
// Manage Custom Header of the page
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_page_map_box_agent') ):
function estate_page_map_box_agent($post) {
    global $post;
    $page_lat           = get_post_meta($post->ID, 'page_custom_lat', true);
    $page_long          = get_post_meta($post->ID, 'page_custom_long', true);
    $page_custom_image  = get_post_meta($post->ID, 'page_custom_image', true);
    $page_custom_zoom  = get_post_meta($post->ID, 'page_custom_zoom', true);
    
    if ($page_custom_zoom==''){
        $page_custom_zoom=15;
    }
    
    print '
   
    <p class="meta-options">
        <label for="page_custom_image">'.__('Replace Map with this image','wpestate').'</label><br />
        <input id="page_custom_image" type="text" size="36" name="page_custom_image" value="'.$page_custom_image.'" />
	<input id="page_custom_image_button" type="button"   size="40" class="upload_button button" value="'.__('Upload Image','wpestate').'" />
     </p>
     
     <p class="meta-options">
       <label for="page_custom_zoom">'.__('Zoom Level for map (1-20)','wpestate').'</label><br />
       <select name="page_custom_zoom" id="page_custom_zoom">';
      
      for ($i=1;$i<21;$i++){
           print '<option value="'.$i.'"';
           if($page_custom_zoom==$i){
               print ' selected="selected" ';
           }
           print '>'.$i.'</option>';
       }
        
     print'
       </select>
     <p>
    ';
     
}
endif; // end   estate_page_map_box_agent  



////////////////////////////////////////////////////////////////////////////////////////////////
// Manage page options
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_page_options_box') ):
function estate_page_options_box($post) {
    global $post;

    $page_title = get_post_meta($post->ID, 'page_show_title', true);
    $selected_no = $selected_yes = '';

    if ($page_title == 'no') {
        $selected_no = 'selected="selected"';
    } else {
        $selected_yes = 'selected="selected"';
    }

    if ($page_title != '') {
        $page_title_select = '<option value="' . $page_title . '" selected="selected">' . $page_title . '</option>';
    }

    print '
    <p class="meta-options">	
    <label for="page_show_title">'.__('Show Title: ','wpestate').'</label><br />
    <select id="page_show_title" name="page_show_title" style="width: 200px;">
            <option value="yes" ' . $selected_yes . '>yes</optionpage_show_title>
            <option value="no" ' . $selected_no . '>no</option>
    </select></p>';
}
endif; // end   estate_page_options_box  


////////////////////////////////////////////////////////////////////////////////////////////////
// Manage post options
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_post_options_box') ):
function estate_post_options_box($post) {
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    global $post;

    $option = '';
    $title_values = array('yes', 'no');
    $post_title = get_post_meta($post->ID, 'post_show_title', true);
    foreach ($title_values as $value) {
        $option.='<option value="' . $value . '"';
        if ($value == $post_title) {
            $option.='selected="selected"';
        }
        $option.='>' . $value . '</option>';
    }

    print '<p class="meta-options">	
                <label for="post_show_title">'.__('Show Title:','wpestate').' </label><br />
                <select id="post_show_title" name="post_show_title" style="width: 200px;">
                        ' . $option . '
                </select><br />
          </p>';

    $option = '';
    $title_values = array('yes', 'no');
    $group_pictures = get_post_meta($post->ID, 'group_pictures', true);
    foreach ($title_values as $value) {
        $option.='<option value="' . $value . '"';
        if ($value == $group_pictures) {
            $option.='selected="selected"';
        }
        $option.='>' . $value . '</option>';
    }

    print'
        <p class="meta-options">	
                <label for="group_pictures">'.__('Group pictures in slider?(*only for blog posts)','wpestate').' </label><br />
                <select id="group_pictures" name="group_pictures" style="width: 200px;">
                        ' . $option . '
                </select><br />
        </p>

         <p class="meta-options">
                <label for="embed_video_id">'.__('Embed Video id: ','wpestate').'</label><br />     
                <input type="text" id="embed_video_id" name="embed_video_id" value="'.esc_html( get_post_meta($post->ID, 'embed_video_id', true) ).'">
          </p>';
    
    
    
        $option_video='';
        $video_values = array('vimeo', 'youtube');
        $video_type = get_post_meta($post->ID, 'embed_video_type', true);

        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
      print '
       <p class="meta-options">
                <label for="embed_video_type">'.__('Video from ','wpestate').'</label><br />
                 <select id="embed_video_type" name="embed_video_type" style="width: 200px;">
                        ' . $option_video . '
                </select><br />
   
        </p>        
        ';
}
endif; // end   estate_post_options_box  





////////////////////////////////////////////////////////////////////////////////////////////////
// Manage Sidebars per posts/page
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_sidebar_box') ):
function estate_sidebar_box($post) {

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'wpestate_sidebar_noncename');
    global $post;
    global $wp_registered_sidebars ;
    $sidebar_name   = get_post_meta($post->ID, 'sidebar_select', true);
    $sidebar_option = get_post_meta($post->ID, 'sidebar_option', true);
    
    $sidebar_values = array(   0=>'right', 
                               1=>'left', 
                               2=>'none');
    
    $option         = '';

    foreach ($sidebar_values as $key=>$value) {
        $option.='<option value="' . $value . '"';
        if ($value == $sidebar_option) {
            $option.=' selected="selected"';
        }
        $option.='>' . $value . '</option>';
    }

    print '   
    <p class="meta-options"><label for="sidebar_option">'.__('Where to show the sidebar: ','wpestate').' </label><br />
        <select id="sidebar_option" name="sidebar_option" style="width: 200px;">
        ' . $option . '
        </select>
    </p>';
    
    print'
    <p class="meta-options"><label for="sidebar_select">'.__('Select the sidebar: ','wpestate').'</label><br />                  
        <select name="sidebar_select" id="sidebar_select" style="width: 200px;">';
        foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
            print'<option value="' . ($sidebar['id'] ) . '"';
            if ($sidebar_name == $sidebar['id']) {
                print' selected="selected"';
            }
            print' >' . ucwords($sidebar['name']) . '</option>';
        }
        print '
        </select>
    </p>';
       
    
        
}
endif; // end   estate_sidebar_box  





////////////////////////////////////////////////////////////////////////////////////////////////
// Saving of custom data
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_save_postdata') ):
function estate_save_postdata($post_id) {
    global $post;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    
  

    ///////////////////////////////////// Check permissions   
    if(isset($_POST['post_type'])){       
            if ('page' == $_POST['post_type'] or 'post' == $_POST['post_type'] or 'estate_property' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return;
            }
            else {
                if (!current_user_can('edit_post', $post_id))
                    return;
            }
     }

   
     
    $allowed_keys=array(
        'sidebar_option',
        'sidebar_select',
        'post_show_title',
        'group_pictures',
        'embed_video_id',
        'embed_video_type',      
        'page_show_title',
        'adv_filter_search_action',
        'adv_filter_search_category',
        'current_adv_filter_city',
        'current_adv_filter_area',
        'listing_filter',
        'show_featured_only',
        'show_filter_area',
        'header_type',
        'header_transparent',
        'page_custom_lat',
        'page_custom_long',
        'page_custom_zoom',
        'min_height',
        'max_height',
        'keep_min',
        'page_custom_image',
        'rev_slider',
        'sidebar_agent_option',
        'local_pgpr_slider_type',
        'local_pgpr_content_type',
        'agent_position',
        'agent_email',
        'agent_phone',
        'agent_mobile',
        'agent_skype',
        'agent_facebook',
        'agent_twitter',
        'agent_linkedin',
        'agent_pinterest',
        'agent_website',
        'item_id',
        'item_price',
        'purchase_date',
        'buyer_id',
        'biling_period',
        'billing_freq',
        'pack_listings',
        'mem_list_unl',
        'pack_featured_listings',
        'pack_price',
        'pack_visible',
        'pack_stripe_id',
        'property_address',
        'property_zip',
        'property_state',
        'property_country',
        'property_status',
        'prop_featured',
        'property_price',
        'property_label',
        'property_label_before',
        'property_size',
        'property_lot_size',
        'property_rooms',
        'property_bedrooms',
        'property_bathrooms',
        'embed_video_type',
        'embed_video_id',
        'owner_notes',       
        'property_latitude',
        'property_longitude',
        'property_google_view',
        'google_camera_angle',
        'page_custom_zoom',
        'property_agent',
        'property_user',
        'use_floor_plans'
    );
    
    $custom_fields = get_option( 'wp_estate_custom_fields', true);    
     if( !empty($custom_fields)){  
        $i=0;
        while($i< count($custom_fields) ){     
            $name =   $custom_fields[$i][0]; 
            $slug         =     wpestate_limit45(sanitize_title( $name )); 
            $slug         =     sanitize_key($slug); 
            $allowed_keys[]=     $slug;
            $i++;
       }
    }
    
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
    
    
    
    foreach($feature_list_array as $key => $value){
        $post_var_name=  str_replace(' ','_', trim($value) );
        $input_name =   wpestate_limit45(sanitize_title( $post_var_name ));
        $input_name =   sanitize_key($input_name);
        $allowed_keys[]=     $input_name;
    }
    
    
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        if( !is_array ($value) ){
           
            if (in_array ($key, $allowed_keys)) {
                $postmeta = wp_filter_kses( $value );
                if (in_array($key, ['property-location', 'property-price'])) {
                    $postmeta = $value;
                }
                update_post_meta($post_id, sanitize_key($key), $postmeta );
            }
            
            //$postmeta = wp_filter_kses( $value ); 
            //update_post_meta($post_id, sanitize_key($key), $postmeta );
            
            
            
        }       
    }
    
    //////////////////////////////////////////////////////////////////
    //// change listing author id
    //////////////////////////////////////////////////////////////////
    if ( isset($_POST['property_user'])){
        $current_id = wpsestate_get_author($post_id);
        $new_user=intval($_POST['property_user']);
        
        if($current_id != $new_user && $new_user!=0 ){
            // change author
            $post = array(
                'ID'            => $post_id,
                'post_author'   => $new_user
            );

            wp_update_post($post ); 
        }
        
    }
    ///////////////////////////// end change author id
    
    //////////////////////////////////////////////////////////////////
    /// save floor plan
    //////////////////////////////////////////////////////////////////
    
    if(isset($_POST['plan_title'])){        
            update_post_meta($post->ID, 'plan_title',wpestate_sanitize_array ( $_POST['plan_title'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_title','' );
        }
    }
     
    if(isset($_POST['plan_description'])){        
            update_post_meta($post->ID, 'plan_description',wpestate_sanitize_array ( $_POST['plan_description'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_description','' );
        }
    }
     
    if(isset($_POST['plan_image_attach'])){        
            update_post_meta($post->ID, 'plan_image_attach',wpestate_sanitize_array ( $_POST['plan_image_attach'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_image_attach','' );
        }
    }
    
    if(isset($_POST['plan_image'])){        
            update_post_meta($post->ID, 'plan_image',wpestate_sanitize_array ( $_POST['plan_image'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_image','' );
        }
    }
    
    if(isset($_POST['plan_size'])){        
            update_post_meta($post->ID, 'plan_size',wpestate_sanitize_array ( $_POST['plan_size'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_size','' );
        }
    }
    
    
      if(isset($_POST['plan_rooms'])){        
            update_post_meta($post->ID, 'plan_rooms',wpestate_sanitize_array ( $_POST['plan_rooms'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_rooms','' );
        }
    }
    
      if(isset($_POST['plan_bath'])){        
            update_post_meta($post->ID, 'plan_bath',wpestate_sanitize_array ( $_POST['plan_bath'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_bath','' );
        }
    }
    
      if(isset($_POST['plan_price'])){        
            update_post_meta($post->ID, 'plan_price',wpestate_sanitize_array ( $_POST['plan_price'] ) );
    }else{
        if(isset($post->ID)){
            update_post_meta($post->ID, 'plan_price','' );
        }
    }
    
    
    //////////////////////////////////////// end save floor plan
    
    
    
    if(isset($_POST['adv_filter_search_action'])){        
        update_post_meta($post->ID, 'adv_filter_search_action',wpestate_sanitize_array ( $_POST['adv_filter_search_action'] ) );
     }else{
         if(isset($post->ID)){
            update_post_meta($post->ID, 'adv_filter_search_action','' );
         }
     }
     
     if(isset($_POST['adv_filter_search_category'])){
        update_post_meta($post->ID, 'adv_filter_search_category', wpestate_sanitize_array ($_POST['adv_filter_search_category']) );
     }else{
         if(isset($post->ID)){
            update_post_meta($post->ID, 'adv_filter_search_category','' ); 
         } 
     }
     
     if(isset($_POST['current_adv_filter_city'])){
        update_post_meta($post->ID, 'current_adv_filter_city',wpestate_sanitize_array($_POST['current_adv_filter_city']) );
     }else{
         if(isset($post->ID)){
            update_post_meta($post->ID, 'current_adv_filter_city','' ); 
         } 
     }
     
     
     if(isset($_POST['current_adv_filter_area'])){
        update_post_meta($post->ID, 'current_adv_filter_area',wpestate_sanitize_array ($_POST['current_adv_filter_area']) );
     }else{
         if(isset($post->ID)){
            update_post_meta($post->ID, 'current_adv_filter_area','' ); 
         } 
     }
     
    
    
    
    
}
endif; // end   estate_save_postdata  

if( !function_exists('wpestate_sanitize_array') ): 
    function wpestate_sanitize_array($original){
        $new_Array=array();
        $allowed_html=array();
        foreach($original as $key=>$value){
            $new_Array[sanitize_key($key)]=  wp_kses(esc_html($value),$allowed_html);
        }
        return $new_Array;
    }
endif;
?>