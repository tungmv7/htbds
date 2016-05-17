<?php

class Tweet_Widget extends WP_Widget {	
	function Tweet_Widget()
	{
		$widget_ops = array('classname' => 'twitter_wrapper', 'description' => 'show your latest tweets');
		$control_ops = array('id_base' => 'twitter-widget');
		//$this->WP_Widget('twitter-widget', 'Wp Estate Twitter Widget', $widget_ops, $control_ops);
                parent::__construct('twitter-widget', 'Wp Estate Twitter Widget', $widget_ops, $control_ops);
	}

	function form($instance)
	{
		$defaults = array('title' => 'Latest Tweets', 'twitter_id' => '','tweets_no' => 3);
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='<p><label for="'.$this->get_field_id('title').'">'.__('Title','wpestate').':</label>
		</p><p><input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p><p><label for="'.$this->get_field_id('twitter_id').'">'.__('Your Twitter Username','wpestate').':</label>
		</p><p><input id="'.$this->get_field_id('twitter_id').'" name="'.$this->get_field_name('twitter_id').'" value="'.$instance['twitter_id'].'" />
		</p><p><label for="'.$this->get_field_id('tweets_no').'">'.__('How many Tweets','wpestate').':</label>
		</p><p><input id="'.$this->get_field_id('tweets_no').'" name="'.$this->get_field_name('tweets_no').'" value="'.$instance['tweets_no'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['tweets_no'] = $new_instance['tweets_no'];
		return $instance;
	}


	function widget($args, $instance)
	{       
                $display='';
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		print $before_widget;
		if($title) {
		//	print $before_title.$title.$after_title;
		}
		$twitter_consumer_key       = get_option('wp_estate_twitter_consumer_key','');
                $twitter_consumer_secret    = get_option('wp_estate_twitter_consumer_secret','');
                $twitter_access_token       = get_option('wp_estate_twitter_access_token','');
                $twitter_access_secret      = get_option('wp_estate_twitter_access_secret','');
      
                $twitter_cache_time         = get_option('wp_estate_twitter_cache_time','');
                $username                   = $instance['twitter_id'];
		$how_many                   = $instance['tweets_no'];
                
		
                $tw_last_cache_time = get_option('$tw_last_cache_time');
                $diff = time() - $tw_last_cache_time;
                $crt = $twitter_cache_time * 3600;
                
                if($diff >= $crt || empty($tp_twitter_plugin_last_cache_time)){   
                    require_once get_template_directory().'/libs/widgets/twitter-api-wordpress.php';
                }
                
                $settings = array(
                        'oauth_access_token' => $twitter_access_token,
                        'oauth_access_token_secret' =>$twitter_access_secret,
                        'consumer_key' => $twitter_consumer_key,
                        'consumer_secret' => $twitter_consumer_secret
                );
                $url            = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
                $getfield       = '?screen_name='.$username;
                $request_method = 'GET';
                $twitter_instance = new Twitter_API_WordPress( $settings );

          

                
                if( $twitter_consumer_key!='' && $twitter_consumer_secret!=''  && $twitter_access_token!=''  && $twitter_access_secret!=''  ){
                
                            if($username!=''){
                                     $got_tweets = $twitter_instance
                                    ->set_get_field( $getfield )
                                    ->build_oauth( $url, $request_method )
                                    ->process_request();
                                    $got_tweets=  json_decode($got_tweets);

                                      
                                      if(!empty($tweets->errors)){
                                         $display='<strong>'.$tweets->errors[0]->message.'</strong>';
                                      }
                                      for($i = 0;$i <= count($got_tweets); $i++){
                                                  if(!empty($got_tweets[$i])){
                                                          $got_tweets_array[$i]['when'] =    $got_tweets[$i]->created_at;
                                                          $got_tweets_array[$i]['text'] =  $got_tweets[$i]->text;			
                                                          $got_tweets_array[$i]['status'] = $got_tweets[$i]->id_str;			
                                                  }	
                                          }
                                      update_option('twiter_array_serial',serialize($got_tweets_array));							
                                      update_option('tw_last_cache_time',time());



                                      $wpestate_tweets = maybe_unserialize(get_option('twiter_array_serial'));
                                  
                                      if(!empty($wpestate_tweets)){
                                           print '<div class="wpestate_tweet_icon"><i class="fa fa-twitter"></i></div>  ';
                                              /*   <div class="wpestate_recent_tweets">
                                                      <ul id="sidebar_twiter_widget">';
                                                      */
                                                      $fctr       =   1;
                                                      $counter    =   0;
                                                      $slides     =   '';
                                                      $indicators =   '';
                                                foreach($wpestate_tweets as $tweet){

                                                     if($counter==0){
                                                            $active=" active ";
                                                          }else{
                                                            $active=" ";
                                                          }
                                                          $indicators.= '<li data-target="#twiter-carousel" data-slide-to="'.($counter).'" class="'. $active.'">
                                                                          </li>';


                                                    $string_twet = preg_replace(
                                                                  "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
                                                                  "<a href=\"\\0\">\\0</a>", 
                                                                  $tweet['text']);

                                                    $slides.= '
                                                    <div class="item '.$active.'">
                                                        <span>'.$string_twet.'</span><br />
                                                        <a class="twitter_time" target="_blank" href="http://twitter.com/'.$username.'/statuses/'.$tweet['status'].'">'.wpestate_relative_time($tweet['when']).'</a>
                                                    </div>';



                                                    if($fctr == $how_many){ 
                                                        break; 
                                                    }
                                                    $fctr++;
                                                    $counter++;
                                                }
                                              /*print '</ul>
                                                  <div id="tw_control"></div>
                                              </div>';*/
                                              
                                           print '<div class="carousel slide wpestate_recent_tweets" data-ride="carousel" data-interval="5000" id="twiter-carousel">
                                                    <div class="carousel-inner">
                                                        '.$slides.'
                                                    </div>
                  
                                                    <ol class="carousel-indicators" id="tw_control">
                                                         '.$indicators.'
                                                    </ol>
                                                   </div>';
                                            }
                                            }else{
                                               $display.=__('Please add your Twitter ID!','wpestate');
                                            }
                }
                else{
                    $display.=__('Please add Twitter Api access info in Theme Options ','wpestate');
                }
                
              

                
                print $display;
		print $after_widget;
	}

}

?>