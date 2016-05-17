<?php
class Featured_widget extends WP_Widget {
	
	function Featured_widget(){
		$widget_ops = array('classname' => 'featured_sidebar', 'description' => 'Put a featured listing on sidebar.');
		$control_ops = array('id_base' => 'featured_widget');
		//$this->WP_Widget('featured_widget', 'Wp Estate: Featured Listing', $widget_ops, $control_ops);
                parent::__construct('featured_widget', 'Wp Estate: Featured Listing', $widget_ops, $control_ops);
	}
	
	function form($instance){
		$defaults = array('title' => 'Featured Listing',
                                  'prop_id'=>'',
                                  'second_line'=>''
                    );
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='<p>
			<label for="'.$this->get_field_id('prop_id').'">Property Id:</label>
		</p><p>
			<input id="'.$this->get_field_id('prop_id').'" name="'.$this->get_field_name('prop_id').'" value="'.$instance['prop_id'].'" />
		</p><p>
			<label for="'.$this->get_field_id('second_line').'">Second Line:</label>
		</p><p>
			<input id="'.$this->get_field_id('second_line').'" name="'.$this->get_field_name('second_line').'" value="'.$instance['second_line'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['prop_id'] = $new_instance['prop_id'];
		$instance['second_line'] = $new_instance['second_line'];
		
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
		print $before_widget;
                $display.='<div class="featured_sidebar_intern">';
		
                $args=array( 
                            'post_type'         => 'estate_property',
                            'post_status'       => 'publish',
                            'p'                 =>  $instance['prop_id']
                            );
                $the_query = new WP_Query( $args );

                // The Loop
                while ( $the_query->have_posts() ) :
                        $the_query->the_post();
                        $link        =  get_permalink();
                        $thumb_id    =  get_post_thumbnail_id($instance['prop_id']);
                        $preview     =  wp_get_attachment_image_src($thumb_id, 'property_featured_sidebar'); 
                        if($preview[0]==''){
                            $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured_sidebar.jpg';
                        }
                        $display    .=  '<div class="featured_widget_image" data-link="'.get_permalink().'">
                                        <a href="'.get_permalink().'"><img  src="'.$preview[0].'" class="img-responsive" alt="slider-thumb" /></a>
                                            <div class="listing-cover"></div>
                                            <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>
                                        </div>';
                        $display    .=  '<div class="featured_title"><a href="'.$link.'" class="featured_title_link">'.get_the_title().'</a></div>';
                endwhile;
                
                wp_reset_query();
				
                if($instance['second_line']){
                    $display    .=  '<div class="featured_second_line">'.$instance['second_line'].'</div>';
                }

		$display.='</div>';
		print $display;
		print $after_widget;
	 }




}

?>