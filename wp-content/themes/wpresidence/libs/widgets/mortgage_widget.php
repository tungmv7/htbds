<?php
class Mortgage_widget extends WP_Widget {
	
	function Mortgage_widget(){
		$widget_ops = array('classname' => 'mortgage_calculator_li', 'description' => 'Mortgage Calculator.');
		$control_ops = array('id_base' => 'mortgage_widget');
		//$this->WP_Widget('mortgage_widget', 'Wp Estate: Mortgage', $widget_ops, $control_ops);
                parent::__construct('mortgage_widget', 'Wp Estate: Mortgage', $widget_ops, $control_ops);
	}
	
	function form($instance){
		$defaults = array('title' => 'Contact');
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $title_instance='';
                $display='';
                
                if(isset($instance['title'])){
                   $title_instance=$instance['title'];
                }
                
		$title = apply_filters('widget_title',$title_instance );

		print $before_widget;

		if($title) {
			print $before_title.$title.$after_title;
		}
		$display.='<div class="mortgage_calculator_div">
                <h3 class="widget-title-sidebar"> '.__('Mortgage Calculator','wpestate').'</h3>
                <div id="input_formula">
                    <label for="sale_price">'.__('Sale Price','wpestate').'</label>    
                    <div class="sale_price_wrapper">    
                        <input type="text" id="sale_price" value="100000" class="form-control">
                    </div>
                    
                    <label for="percent_down">'.__('Percent Down','wpestate').'</label>    
                    <div class="percent_down_wrapper">    
                        <input type="text" id="percent_down" value="10" class="form-control">
                    </div>
                  
                    <label for="term_years">'.__('Term (Years)','wpestate').'</label>    
                    <div class="years_wrapper">    
                        <input type="text" id="term_years" value="30" class="form-control">
                    </div>
                    
                    <label for="interest_rate">'.__('Interest Rate in %','wpestate').'</label>    
                    <div class="interest_wrapper">    
                        <input type="text" id="interest_rate" value="5" class="form-control">
                    </div>
                    
                    <div id="morg_results">
                        <span id="am_fin"></span>
                        <span id="morgage_pay"></span>                      
                        <span id="anual_pay"></span>
                    </div>
                    <button class="wpb_button  wpb_btn-info wpb_btn-large" id="morg_compute">'.__('Calculate','wpestate').'</button>
                   
                </div>
                
                ';
		
		$display.='</div>';
		print $display;
		print $after_widget;
	}




}

?>