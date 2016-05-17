<?php
class Featured_Agent extends WP_Widget {
	
	function Featured_Agent(){
		$widget_ops = array('classname' => 'featured_sidebar', 'description' => 'Put a featured agent on sidebar.');
		$control_ops = array('id_base' => 'featured_agent');
		//$this->WP_Widget('Featured_Agent', 'Wp Estate: Featured Agent', $widget_ops, $control_ops);
                parent::__construct('Featured_Agent', 'Wp Estate: Featured Agent', $widget_ops, $control_ops);
	}
	 
	function form($instance){
		$defaults = array('title' => 'Featured Agent',
                                  'prop_id'=>'',
                                  
                    );
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='<p>
			<label for="'.$this->get_field_id('prop_id').'">Agent Id:</label>
		</p><p>
			<input id="'.$this->get_field_id('prop_id').'" name="'.$this->get_field_name('prop_id').'" value="'.$instance['prop_id'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['prop_id'] = $new_instance['prop_id'];
		
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
                global $agent_wid;
		print $before_widget;
            
		   
          
                $agent_wid=$instance['prop_id'];
                get_template_part('templates/agent_unit_widget'); 
               
               

		print $display;
		print $after_widget;
	 }




}

?>