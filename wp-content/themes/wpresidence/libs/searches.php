<?php
// register the custom post type
add_action( 'init', 'wpestate_create_saved_search' );

if( !function_exists('wpestate_create_saved_search') ):
function wpestate_create_saved_search() {
register_post_type( 'wpestate_search',
		array(
			'labels' => array(
				'name'          => __( 'Searches','wpestate'),
				'singular_name' => __( 'Searches','wpestate'),
				'add_new'       => __('Add New Searches','wpestate'),
                'add_new_item'          =>  __('Add Searches','wpestate'),
                'edit'                  =>  __('Edit Searches' ,'wpestate'),
                'edit_item'             =>  __('Edit Searches','wpestate'),
                'new_item'              =>  __('New Searches','wpestate'),
                'view'                  =>  __('View Searches','wpestate'),
                'view_item'             =>  __('View Searches','wpestate'),
                'search_items'          =>  __('Search Searches','wpestate'),
                'not_found'             =>  __('No Searches found','wpestate'),
                'not_found_in_trash'    =>  __('No Searches found','wpestate'),
                'parent'                =>  __('Parent Searches','wpestate')
			),
		'public' => false,
		'has_archive' => false,
		'rewrite' => array('slug' => 'searches'),
		'supports' => array('title'),
		'can_export' => true,
		'register_meta_box_cb' => 'wpestate_add_searches',
                 'menu_icon'=>get_template_directory_uri().'/img/searches.png'
		)
	);
}
endif; // end   wpestate_create_invoice_type  

////////////////////////////////////////////////////////////////////////////////////////////////
// Add Invoice metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_searches') ):
function wpestate_add_searches() {	
        add_meta_box(  'estate_invoice-sectionid',  __( 'Search Details', 'wpestate' ),'wpestate_search_details','wpestate_search' ,'normal','default');
}
endif; // end   wpestate_add_pack_invoices  



////////////////////////////////////////////////////////////////////////////////////////////////
// Invoice Details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_search_details') ):

function wpestate_search_details( $post ) {
    global $post;
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_invoice_noncename' );

    
}

endif; // end   wpestate_invoice_details  


?>