<?php
class Advanced_Search_widget extends WP_Widget {
	
	function Advanced_Search_widget(){
		$widget_ops = array('classname' => 'advanced_search_sidebar', 'description' => 'Advanced Search Widget');
		$control_ops = array('id_base' => 'advanced_search_widget');
		//$this->WP_Widget('advanced_search_widget', 'Wp Estate: Advanced Search', $widget_ops, $control_ops);
                parent::__construct('advanced_search_widget', 'Wp Estate: Advanced Search', $widget_ops, $control_ops);
                
	}
	
	function form($instance){
		$defaults = array('title' => 'Advanced Search' );
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
		</p><p>
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
                $select_tax_action_terms='';
                $select_tax_category_terms='';
                
		$title = apply_filters('widget_title', $instance['title']);

		print $before_widget;

		if($title) {
                    print $before_title.$title.$after_title;
		}else{
                    print '<div class="widget-title-sidebar_blank"></div>';
                }
                
                $adv_submit=get_adv_search_link();
                
                //  show cities or areas that are empty ?
                $args = wpestate_get_select_arguments();
                $action_select_list =   wpestate_get_action_select_list($args);
                $categ_select_list  =   wpestate_get_category_select_list($args);
                $select_city_list   =   wpestate_get_city_select_list($args); 
                $select_area_list   =   wpestate_get_area_select_list($args);
                $select_county_state_list   =   wpestate_get_county_state_select_list($args);

    
                $adv_search_what        =   get_option('wp_estate_adv_search_what','');
                $adv_search_label       =   get_option('wp_estate_adv_search_label','');
                $adv_search_how         =   get_option('wp_estate_adv_search_how','');
                
                $custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
                print '<form role="search" method="get"   action="'.$adv_submit.'" >';
                            if($custom_advanced_search=='yes'){
                                $this->custom_fields_widget($adv_search_what,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label,$select_county_state_list);
                                
                                
                            }else{ // not custom search
                                $this->normal_fields_widget($action_select_list,$categ_select_list,$select_city_list,$select_area_list);
                  
                            }
                $extended_search = get_option('wp_estate_show_adv_search_extended','');
                if($extended_search=='yes'){            
                    show_extended_search('widget');
                }
                
                if (function_exists('icl_translate') ){
                    print do_action( 'wpml_add_language_form_field' );
                }
                
                print'<button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_widget">'.__('Search','wpestate').'</button>
                </form>  
                '; 
		print $after_widget;
                
	}

        
        
        
        
        
        
        
        function custom_fields_widget($adv_search_what,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label,$select_county_state_list){
            foreach($adv_search_what as $key=>$search_field){
                wpestate_show_search_field('sidebar',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
            } 
        }//end custom fields function
         
        function normal_fields_widget($action_select_list,$categ_select_list,$select_city_list,$select_area_list){
            $form = wpestate_show_search_field_classic_form('sidebar',$action_select_list,$categ_select_list ,$select_city_list,$select_area_list);
            print $form;
        }
    
}// end class
?>