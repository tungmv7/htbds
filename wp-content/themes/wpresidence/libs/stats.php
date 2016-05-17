<?php

if( !function_exists('wp_estate_count_page_stats') ):
    function wp_estate_count_page_stats($prop_id) {
        
        // get the total no of 
        $total_views=  intval( get_post_meta($prop_id, 'wpestate_total_views', true) );
        if($total_views==''){
            $total_views=1;
        }else{
            $total_views++;
        }
        update_post_meta($prop_id, 'wpestate_total_views', $total_views );
        
        $today = date('m-d-Y', time() );
        $detailed_views=  get_post_meta($prop_id, 'wpestate_detailed_views', true);
 
        
        if($detailed_views=='' || !is_array($detailed_views)){
            $detailed_views         =   array();
            $detailed_views[$today] =   1;
   
            
        }else{
            if( !isset( $detailed_views[$today] ) ){
                
                if( count($detailed_views) > 60 ){
                    array_shift($detailed_views);
                }
                
                $detailed_views[$today]=1;
                
            }else{
            
                $detailed_views[$today]=intval($detailed_views[$today])+1;
            }
            
        }
        
        $detailed_views=  update_post_meta($prop_id, 'wpestate_detailed_views', $detailed_views);
       
        
        // ro remove 
        /*   
        print 'todal views'.  $total_views=  get_post_meta($prop_id, 'wpestate_total_views', true).'/';
        $detailed_views=  get_post_meta($prop_id, 'wpestate_detailed_views', true);
        print_R($detailed_views);      
        
        */    
    }
endif;



if( !function_exists('wp_estate_return_traffic_labels') ):
    function wp_estate_return_traffic_labels($prop_id,$first_rec=14) {
        
        $detailed_views=  get_post_meta($prop_id, 'wpestate_detailed_views', true);
    
        if(!is_array($detailed_views)){
            $detailed_views=array();
        }
        
        $array_label    = array_keys    ($detailed_views);
        $array_label    = array_slice($array_label, -1*$first_rec, $first_rec, false);
        return $array_label;
    }
endif;


if( !function_exists('wp_estate_return_traffic_data') ):
    function wp_estate_return_traffic_data($prop_id,$first_rec=14) {
        
        $detailed_views=  get_post_meta($prop_id, 'wpestate_detailed_views', true);
        if(!is_array($detailed_views)){
            $detailed_views=array();
        }
        $array_values   = array_values    ($detailed_views);
        $array_values   = array_slice($array_values, -1*$first_rec, $first_rec, false);
        return $array_values;
    }
endif;


if( !function_exists('wp_estate_return_traffic_data_accordion') ):
    function wp_estate_return_traffic_data_accordion($prop_id,$first_rec=14) {
        
        $detailed_views=  get_post_meta($prop_id, 'wpestate_detailed_views', true);
        if(!is_array($detailed_views)){
            $detailed_views=array();
        }
        
        // since this runs before we increment the visits - on acc page style
        $today = date('m-d-Y', time() );
        
        if(isset($detailed_views[$today])){
            $detailed_views[$today]=  intval($detailed_views[$today])+1;
        }
        
        $array_values   = array_values    ($detailed_views);
        $array_values   = array_slice($array_values, -1*$first_rec, $first_rec, false);
         
        

       
        
        return $array_values;
    }
endif;