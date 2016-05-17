<?php

///////////////////////////////////////////////////////////////////////////////////////////
/////// register shortcodes
///////////////////////////////////////////////////////////////////////////////////////////

function wpestate_shortcodes(){
    wpestate_register_shortcodes();
    wpestate_tiny_short_codes_register();
    add_filter('widget_text', 'do_shortcode');
}

///////////////////////////////////////////////////////////////////////////////////////////
// register tiny plugins functions
///////////////////////////////////////////////////////////////////////////////////////////

function wpestate_tiny_short_codes_register() {
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    
    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'wpestate_add_plugin');
        add_filter('mce_buttons_3', 'wpestate_register_button');    
    }

}

/////////////////////////////////////////////////////////////////////////////////////////
/////// push the code into Tiny buttons array
///////////////////////////////////////////////////////////////////////////////////////////

function wpestate_register_button($buttons) {
    array_push($buttons, "|", "slider_recent_items");     
    array_push($buttons, "|", "testimonials");
    array_push($buttons, "|", "recent_items");  
    array_push($buttons, "|", "featured_agent"); 
    array_push($buttons, "|", "featured_article");
    array_push($buttons, "|", "featured_property");
    array_push($buttons, "|", "list_items_by_id"); 
    array_push($buttons, "|", "login_form"); 
    array_push($buttons, "|", "register_form");
    array_push($buttons, "|", "advanced_search");
    array_push($buttons, "|", "font_awesome");
    array_push($buttons, "|", "spacer"); 
    array_push($buttons, "|", "icon_container");
    array_push($buttons, "|", "list_agents");
    array_push($buttons, "|", "places_list");
    array_push($buttons, "|", "listings_per_agent");
    array_push($buttons, "|", "property_page_map");
    return $buttons;
}



///////////////////////////////////////////////////////////////////////////////////////////
/////// poins to the right js 
///////////////////////////////////////////////////////////////////////////////////////////

function wpestate_add_plugin($plugin_array) {   
    $plugin_array['slider_recent_items']        = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['testimonials']               = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['recent_items']               = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['featured_agent']             = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['featured_article']           = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['featured_property']          = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['login_form']                 = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['register_form']              = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['list_items_by_id']           = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['advanced_search']            = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['font_awesome']               = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['spacer']                     = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['icon_container']             = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['list_agents']                = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['places_list']                = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['listings_per_agent']         = get_template_directory_uri() . '/js/shortcodes.js';
    $plugin_array['property_page_map']          = get_template_directory_uri() . '/js/shortcodes.js';
    return $plugin_array;
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// register shortcodes
///////////////////////////////////////////////////////////////////////////////////////////


function wpestate_register_shortcodes() {
    add_shortcode('slider_recent_items', 'wpestate_slider_recent_posts_pictures');
        
    add_shortcode('spacer', 'wpestate_spacer_shortcode_function');
    add_shortcode('recent-posts', 'wpestate_recent_posts_function');
    add_shortcode('testimonial', 'wpestate_testimonial_function');
    add_shortcode('recent_items', 'wpestate_recent_posts_pictures');
    add_shortcode('featured_agent', 'wpestate_featured_agent');
    add_shortcode('featured_article', 'wpestate_featured_article');
    add_shortcode('featured_property', 'wpestate_featured_property');
    add_shortcode('login_form', 'wpestate_login_form_function');
    add_shortcode('register_form', 'wpestate_register_form_function');
    add_shortcode('list_items_by_id', 'wpestate_list_items_by_id_function');
    add_shortcode('advanced_search', 'wpestate_advanced_search_function');
    add_shortcode('font_awesome', 'wpestate_font_awesome_function');
    add_shortcode('icon_container', 'wpestate_icon_container_function');
    add_shortcode('list_agents','wpestate_list_agents_function');
    add_shortcode('places_list', 'wpestate_places_list_function');
    add_shortcode( 'listings_per_agent', 'wplistingsperagent_shortcode_function' );
    add_shortcode( 'property_page_map', 'wpestate_property_page_map_function' );
}



////////////////////////////////////////////////////////////////////////////////
// add shortcodes to visual composer
////////////////////////////////////////////////////////////////////////////////

if( function_exists('vc_map') ):
    vc_map(
    array(
        "name" => __("Google Map with Property Marker","wpestate"),//done
        "base" => "property_page_map",
        "class" => "",
        "category" => __('Content','wpestate'),
        'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
        'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
        'weight'=>100,
        'icon'   =>'wpestate_vc_logo',
        'description'=>__('Google Map with Property Marker','wpestate'),

        "params" => array(

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Property ID","wpestate"),
                "param_name" => "propertyid",
                "value" => "",
                "description" => __("The Id of the property you want to show","wpestate")
            ),

         


        ) 

       )

    );


    array(
        "name" => __("Listings per agent","wpestate"),//done
        "base" => "listings_per_agent",
        "class" => "",
        "category" => __('Content','wpestate'),
        'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
        'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
        'weight'=>100,
        'icon'   =>'wpestate_vc_logo',
        'description'=>__('Listings per agent','wpestate'),

        "params" => array(

           array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Agent ID","wpestate"),
                "param_name" => "agentid",
                "value" => "",
                "description" => __("Agent ID to show the listings of a particular agent","wpestate")
            ),

         

            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Number of Listings","wpestate"),
                "param_name" => "nooflisting",
                "value" => "",
                 "description" => __("Number of Listings to display","wpestate")

            ),

        ) 

       );

  

     vc_map( array(
        "name" => esc_html__( "List Cities or Areas","wpestate"),//done
        "base" => "places_list",
        "class" => "",
        "category" => esc_html__( 'Content','wpestate'),
        'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
        'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
        'weight'=>100,
        'icon'   =>'wpestate_vc_logo',
        'description'=>esc_html__( 'List Cities or Areas','wpestate'),  
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__( "Cities or Areas IDs, separated by comma","wpestate"),
                "param_name" => "place_list",
                "value" => "",
                "description" => esc_html__( "Cities or Areas IDs, separated by comma","wpestate")
            )  ,
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__( "Places per row","wpestate"),
                "param_name" => "place_per_row",
                "value" => "4",
                "description" => esc_html__( "How many items listed per row?","wpestate")
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__( "Extra Class Name","wpestate"),
                "param_name" => "extra_class_name",
                "value" => "",
                "description" => esc_html__( "Extra Class Name","wpestate")
            )
        )    
    ) 
    );    

    vc_map(
    array(
       "name" => __("List Agents","wpestate"),//done
       "base" => "list_agents",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Agent Lists','wpestate'),
       "params" => array(
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title","wpestate"),
             "param_name" => "title",
             "value" => "",
             "description" => __("Section Title","wpestate")
          ),
         
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Category Id's","wpestate"),
             "param_name" => "category_ids",
             "value" => "",
             "description" => __("list of agent category id's sepearated by comma","wpestate")
          ),
             array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Action Id's","wpestate"),
             "param_name" => "action_ids",
             "value" => "",
             "description" => __("list of agent action ids separated by comma ","wpestate")
          ), 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("City Id's ","wpestate"),
             "param_name" => "city_ids",
             "value" => "",
             "description" => __("list of agent city ids separated by comma","wpestate")
          ),
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Area Id's","wpestate"),
             "param_name" => "area_ids",
             "value" => "",
             "description" => __("list of agent area ids separated by comma ","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items","wpestate"),
             "param_name" => "number",
             "value" => 4,
             "description" => __("how many items","wpestate")
          ) , 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items per row","wpestate"),
             "param_name" => "rownumber",
             "value" => 4,
             "description" => __("The number of items per row","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link to global listing","wpestate"),
             "param_name" => "link",
             "value" => "",
             "description" => __("link to global listing","wpestate")
          ) ,array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Random Pick (yes/no) ","wpestate"),
             "param_name" => "random_pick",
             "value" => "no",
             "description" => __("Choose if agents should display randomly on page refresh. )","wpestate")
          ) 
       )
    )
    );


      vc_map(
    array(
       "name" => __("Recent Items Slider","wpestate"),//done
       "base" => "slider_recent_items",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Recent Items Slider Shortcode','wpestate'),
       "params" => array(
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title","wpestate"),
             "param_name" => "title",
             "value" => "",
             "description" => __("Section Title","wpestate")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("What type of items","wpestate"),
             "param_name" => "type",
             "value" => "properties",
             "description" => __("list properties or articles","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Category Id's","wpestate"),
             "param_name" => "category_ids",
             "value" => "",
             "description" => __("list of category id's sepearated by comma (*only for properties)","wpestate")
          ),
             array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Action Id's","wpestate"),
             "param_name" => "action_ids",
             "value" => "",
             "description" => __("list of action ids separated by comma (*only for properties)","wpestate")
          ), 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("City Id's ","wpestate"),
             "param_name" => "city_ids",
             "value" => "",
             "description" => __("list of city ids separated by comma (*only for properties)","wpestate")
          ),
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Area Id's","wpestate"),
             "param_name" => "area_ids",
             "value" => "",
             "description" => __("list of area ids separated by comma (*only for properties)","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items","wpestate"),
             "param_name" => "number",
             "value" => 4,
             "description" => __("how many items","wpestate")
          ),array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show featured listings only?","wpestate"),
             "param_name" => "show_featured_only",
             "value" => "no",
             "description" => __("Show featured listings only? (yes/no)","wpestate")
          ) ,array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Auto scroll period","wpestate"),
             "param_name" => "autoscroll",
             "value" => "0",
             "description" => __("Auto scroll period in seconds - 0 for manual scroll, 1000 for 1 second, 2000 for 2 seconds and so on.","wpestate")
          ) 
        )
    )
    );








      vc_map( array(
       "name" => __("Icon content box","wpestate"),//done
       "base" => "icon_container",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
        'icon'   =>'wpestate_vc_logo',
        'description'=>__('Icon Content Box Shortcode','wpestate'),  
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Box Title","wpestate"),
             "param_name" => "title",
             "value" => "Title",
             "description" => __("Box Title goes here","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Image url","wpestate"),
             "param_name" => "image",
             "value" => "",
             "description" => __("Image or Icon url","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Content of the box","wpestate"),
             "param_name" => "content_box",
             "value" => "Content of the box goes here",
             "description" => __("Content of the box goes here","wpestate")
          )
          ,
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Image Effect","wpestate"),
             "param_name" => "image_effect",
             "value" => "yes",
             "description" => __("Use image effect? yes/no","wpestate")
          ) ,
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link","wpestate"),
             "param_name" => "link",
             "value" => "",
             "description" => __("The link with http:// in front","wpestate")
          )
          
       )
    ) );    




      vc_map(
           array(
           "name" => __("Spacer","wpestate"),
           "base" => "spacer",
           "class" => "",
           "category" => __('Content','wpestate'),
           'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
           'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
           'weight'=>102,
            'icon'   =>'wpestate_vc_logo',
            'description'=>__('Spacer Shortcode','wpestate'),
           "params" => array(
               array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Spacer Type","wpestate"),
                 "param_name" => "type",
                 "value" => "1",
                 "description" => __("Space Type : 1 with no middle line, 2 with middle line","wpestate")
              )   ,
               array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Space height","wpestate"),
                 "param_name" => "height",
                 "value" => "40",
                 "description" => __("Space height in px","wpestate")
              )   
           )
        )   
    );



    vc_map( array(
       "name" => __("List items by ID","wpestate"),//done
       "base" => "list_items_by_id",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
        'icon'   =>'wpestate_vc_logo',
        'description'=>__('List Items by ID Shortcode','wpestate'),
       "params" => array(
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title","wpestate"),
             "param_name" => "title",
             "value" => "",
             "description" => __("Section Title","wpestate")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("What type of items","wpestate"),
             "param_name" => "type",
             "value" => "properties",
             "description" => __("List properties or articles","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Items IDs","wpestate"),
             "param_name" => "ids",
             "value" => "",
             "description" => __("List of IDs separated by comma","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items","wpestate"),
             "param_name" => "number",
             "value" => "3",
             "description" => __("How many items do you want to show ?","wpestate")
          ) ,
            
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items per row","wpestate"),
             "param_name" => "rownumber",
             "value" => 4,
             "description" => __("The number of items per row","wpestate")
          ) , 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Vertical or horizontal ?","wpestate"),
             "param_name" => "align",
             "value" => "vertical",
             "description" => __("What type of alignment (vertical or horizontal) ?","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link to global listing","wpestate"),
             "param_name" => "link",
             "value" => "#",
             "description" => __("link to global listing with http","wpestate")
          )
       )
    ) );    

   

    vc_map(
           array(
           "name" => __("Testimonial",'wpestate'),
           "base" => "testimonial",
           "class" => "",
           "category" => __('Content','wpestate'),
           'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
           'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
           'weight'=>102,
           'icon'   =>'wpestate_vc_logo',
           'description'=>__('Testiomonial Shortcode','wpestate'),
           "params" => array(
              array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Client Name","wpestate"),
                 "param_name" => "client_name",
                 "value" => "Name Here",
                 "description" => __("Client name here","wpestate")
              ),
               array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Title Client","wpestate"),
                 "param_name" => "title_client",
                 "value" => "happy client",
                 "description" => __("title or client postion ","wpestate")
              ),
               array(
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Image","wpestate"),
                 "param_name" => "imagelinks",
                 "value" => "",
                 "description" => __("Path to client picture, (best size 120px  x 120px) ","wpestate")
              ) ,
               array(
                 "type" => "textarea",
                 "holder" => "div",
                 "class" => "",
                 "heading" => __("Testimonial Text Here.","wpestate"),
                 "param_name" => "testimonial_text",
                 "value" => "",
                 "description" => __("Testimonial Text Here. ","wpestate")
              )
           )
        )   
    );
    
    vc_map(
    array(
       "name" => __("Recent Items","wpestate"),//done
       "base" => "recent_items",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Recent Items Shortcode','wpestate'),
       "params" => array(
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title","wpestate"),
             "param_name" => "title",
             "value" => "",
             "description" => __("Section Title","wpestate")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("What type of items","wpestate"),
             "param_name" => "type",
             "value" => "properties",
             "description" => __("list properties or articles","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Category Id's","wpestate"),
             "param_name" => "category_ids",
             "value" => "",
             "description" => __("list of category id's sepearated by comma","wpestate")
          ),
             array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Action Id's","wpestate"),
             "param_name" => "action_ids",
             "value" => "",
             "description" => __("list of action ids separated by comma (*only for properties)","wpestate")
          ), 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("City Id's ","wpestate"),
             "param_name" => "city_ids",
             "value" => "",
             "description" => __("list of city ids separated by comma (*only for properties)","wpestate")
          ),
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Area Id's","wpestate"),
             "param_name" => "area_ids",
             "value" => "",
             "description" => __("list of area ids separated by comma (*only for properties)","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items","wpestate"),
             "param_name" => "number",
             "value" => 4,
             "description" => __("how many items","wpestate")
          ) , 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("No of items per row","wpestate"),
             "param_name" => "rownumber",
             "value" => 4,
             "description" => __("The number of items per row","wpestate")
          ) , 
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Vertical or horizontal ?","wpestate"),
             "param_name" => "align",
             "value" => "vertical",
             "description" => __("What type of alignment (vertical or horizontal) ?","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Link to global listing","wpestate"),
             "param_name" => "link",
             "value" => "",
             "description" => __("link to global listing","wpestate")
          ),array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Show featured listings only?","wpestate"),
             "param_name" => "show_featured_only",
             "value" => "no",
             "description" => __("Show featured listings only? (yes/no)","wpestate")
          ) ,array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Random Pick (yes/no) ","wpestate"),
             "param_name" => "random_pick",
             "value" => "no",
             "description" => __("Choose if properties should display randomly on page refresh. (*only for properties)","wpestate")
          ) 
       )
    )
    );

  
    
    vc_map(
    array(
       "name" => __("Featured Agent","wpestate"),
       "base" => "featured_agent",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Featured Agent Shortcode','wpestate'),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Agent Id","wpestate"),
             "param_name" => "id",
             "value" => "0",
             "description" => __("Agent Id","wpestate")
          ),
           array(
             "type" => "textarea",
             "holder" => "div",
             "class" => "",
             "heading" => __("Notes","wpestate"),
             "param_name" => "notes",
             "value" => "",
             "description" => __("Notes for featured agent","wpestate")
          )
       )
    )
    );
    
    vc_map(
       array(
       "name" => __("Featured Article","wpestate"),
       "base" => "featured_article",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Featured Article Shortcode','wpestate'),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Id of the article","wpestate"),
             "param_name" => "id",
             "value" => "",
             "description" => __("The id of the article","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Featured text","wpestate"),
             "param_name" => "second_line",
             "value" => "",
             "description" => __("featured text","wpestate")
          )
       )
    )
    );
    
    vc_map(
    array(
       "name" => __("Featured Property","wpestate"),
       "base" => "featured_property",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Featured Property Shortcode','wpestate'),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Property id","wpestate"),
             "param_name" => "id",
             "value" => "",
             "description" => __("Property id","wpestate")
          ),
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Second Line","wpestate"),
             "param_name" => "sale_line",
             "value" => "",
             "description" => __("Second line text","wpestate")
          )           
       )
    )
    );

    
    vc_map(array(
       "name" => __("Login Form","wpestate"),
       "base" => "login_form",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Login Form Shortcode','wpestate'),  
       "params" => array( array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Register link text","wpestate"),
             "param_name" => "register_label",
             "value" => "",
             "description" => __("Register link text","wpestate")
            )     , 
            array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Register page url","wpestate"),
             "param_name" => "register_url",
             "value" => "",
             "description" => __("Register page url","wpestate")
          )      )
    )
    );
    
    
    vc_map(
     array(
       "name" => __("Register Form","wpestate"),
       "base" => "register_form",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Register Form Shortcode','wpestate'),    
       "params" => array()
    )
            
    );
    
    
    
    
    vc_map(
        array(
       "name" => __("Advanced Search","wpestate"),
       "base" => "advanced_search",
       "class" => "",
       "category" => __('Content','wpestate'),
       'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
       'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
       'weight'=>100,
       'icon'   =>'wpestate_vc_logo',
       'description'=>__('Advanced Search Shortcode','wpestate'),     
       "params" => array(
           array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => __("Title","wpestate"),
             "param_name" => "title",
             "value" => "",
             "description" => __("Section Title","wpestate")
          ))
    )
           
            
    );
    
    
endif;



function custom_css_wpestate($class_string, $tag) {
  if ($tag =='vc_tabs' ) {
    $class_string .= ' wpestate_tabs'; 
  }

  if ($tag =='vc_tour' ) {
    $class_string .= ' wpestate_tour'; 
  }
  
  if ($tag =='vc_accordion' ) {
    $class_string .= ' wpestate_accordion'; 
  }
  
  if ($tag =='vc_accordion_tab' ) {
    $class_string .= ' wpestate_accordion_tab'; 
  }
  
  if ($tag =='vc_carousel' ) {
    $class_string .= ' wpestate_carousel'; 
  }

  if ($tag =='vc_progress_bar' ) {
    $class_string .= ' wpestate_progress_bar'; 
  }

  if ($tag =='vc_toggle' ) {
    $class_string .= ' wpestate_toggle'; 
  }
  
  if ($tag =='vc_message' ) {
    $class_string .= ' wpestate_message'; 
  }
  
  if ($tag =='vc_posts_grid' ) {
    $class_string .= ' wpestate_posts_grid'; 
  }
  
  if ($tag =='vc_cta_button' ) {
    $class_string .= ' wpestate_cta_button '; 
  }
  
  if ($tag =='vc_cta_button2' ) {
    $class_string .= ' wpestate_cta_button2 '; 
  }
  
  
  
  return $class_string.' '.$tag;
}


// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'custom_css_wpestate', 10,2)

?>