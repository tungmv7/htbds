<?php

class Zillow_Estimate_Widget extends WP_Widget {	
	function Zillow_Estimate_Widget()
	{
		$widget_ops = array('classname' => 'zillow_widget', 'description' => 'estimate your property');
		$control_ops = array('id_base' => 'zillow_estimate_widget');
		//$this->WP_Widget('zillow_estimate_widget', 'Wp Estate Zillow Estimate Widget', $widget_ops, $control_ops);
                parent::__construct('zillow_estimate_widget', 'Wp Estate Zillow Estimate Widget', $widget_ops, $control_ops);
	}

	function form($instance)
	{
		$defaults = array('title' => 'Estimate your home');
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='
                <p><label for="'.$this->get_field_id('title').'">Title:</label></p>
                <p><input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" /></p>
                ';
		print $display;
	}


	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['zillow_api_key'] = $new_instance['zillow_api_key'];
		return $instance;
	}


	function widget($args, $instance)
	{       
                $display='';
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		print $before_widget;
		if($title) {
			print $before_title.$title.$after_title;
		}
		
                $zillow_api_key=   esc_html ( get_option('wp_estate_zillow_api_key','') );
		
                ///////////////////// fiind out who is the compare page
                $pages = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'zillow_estimate_page.php'
                        ));

                if( $pages ){
                    $zillow_submit = get_permalink( $pages[0]->ID);
                }else{
                    $zillow_submit='';
                }

                if($zillow_submit!=''){
                    if( $zillow_api_key!=''){
                       print '
                        <div class="zillow-wrapper">    
                        <form method="post" action="'.$zillow_submit.'">
                       
                        <div class="zill_estimate_adr1-wrapper">    
                            <input type="text" class="form-control" id="zill_estimate_adr1"   name="zill_estimate_adr"    placeholder="'.__('Your Address','wpestate').'">
                        </div>
                        
                        <div class="zill_estimate_city1-wrapper">
                            <input type="text" class="form-control" id="zill_estimate_city1"  name="zill_estimate_city"   placeholder="'.__('Your City','wpestate').'">
                        </div>
                        
                        <div class="zill_estimate_state1-wrapper">                       
                            <input type="text" class="form-control" id="zill_estimate_state1" name="zill_estimate_state"  placeholder="'.__('Your State Code (ex CA)','wpestate').'">
                        </div>
                        
                        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="zill_submit_estimate">'.__('Get Estimation','wpestate').'</button>
                        </form>
                        </div>
                        ';       
                    }
                    else{
                        $display.='<p>Please add Zillow Api Key in Theme Options </p>';
                    }
                }else{
                        $display.='<p>Please create a page with the "Zillow Estimate" template.</p> ';
                }
                
                print $display;
		print $after_widget;
	}

}

?>