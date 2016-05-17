<?php 

class wpestate_custom_menu {

    function __construct() {

        // add custom menu form 
        add_filter( 'wp_setup_nav_menu_item', array( $this, 'wpestate_add_custom_nav_fields' ) );

        // save menu custom filed
        add_action( 'wp_update_nav_menu_item', array( $this, 'wpestate_update_custom_nav_fields'), 10, 3 );
        
        // edit  walker
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'wpestate_edit_walker'), 10, 2 );

    } 

    /* Add custom fields to $item nav object */
    function wpestate_add_custom_nav_fields( $menu_item ) {
    
        $menu_item->menu_icon               = get_post_meta( $menu_item->ID, '_menu_item_menu_icon', true );
        $menu_item->megamenu                = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
        $menu_item->megamenu_background     = get_post_meta( $menu_item->ID, '_menu_item_megamenu_background', true );
        $menu_item->megamenu_widgetarea     = get_post_meta( $menu_item->ID, '_menu_item_megamenu_widgetarea', true );
        $menu_item->megamenu_styles         = get_post_meta( $menu_item->ID, '_menu_item_megamenu_styles', true );
        return $menu_item;
        
    }
    
    /* Save menu custom fields*/    
    function wpestate_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    
        //save icon
        if (!empty($_REQUEST['menu-item-menu_icon']) && is_array( $_REQUEST['menu-item-menu_icon']) ) {
            $menu_icon_value = $_REQUEST['menu-item-menu_icon'][$menu_item_db_id];
            update_post_meta( $menu_item_db_id, '_menu_item_menu_icon', $menu_icon_value );
        }

        //
        if (!isset($_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id])) {
            $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id] = '';        
        }
        
        $menu_mega_enabled_value = $_REQUEST['edit-menu-item-megamenu'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu', $menu_mega_enabled_value );

        //save backround
        if (!isset($_REQUEST['menu-item-megamenu-background'][$menu_item_db_id])) {
            $_REQUEST['menu-item-megamenu-background'][$menu_item_db_id] = '';
        }
        $mega_menu_background_value = $_REQUEST['menu-item-megamenu-background'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_background', $mega_menu_background_value );

        if (!isset($_REQUEST['menu-item-megamenu-border'][$menu_item_db_id])) {
            $_REQUEST['menu-item-megamenu-border'][$menu_item_db_id] = '';
        }
        $menu_item_megamenu_border = $_REQUEST['menu-item-megamenu-border'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu-item-megamenu-border', $menu_item_megamenu_border);
        
        
        
        
        //save widget area
        if (!isset($_REQUEST['menu-item-megamenu-widgetarea'][$menu_item_db_id])) {
            $_REQUEST['menu-item-megamenu-widgetarea'][$menu_item_db_id] = '';
        }
        $mega_menu_widgetarea_value = $_REQUEST['menu-item-megamenu-widgetarea'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_widgetarea', $mega_menu_widgetarea_value );


        // save styles
        if (!isset($_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id])) {
            $_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id] = '';
        }
        $mega_menu_styles_value = $_REQUEST['menu-item-megamenu-styles'][$menu_item_db_id];        
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_styles', $mega_menu_styles_value );




    }
    
    
    function wpestate_edit_walker($walker,$menu_id) {
        return 'Walker_Nav_Menu_Edit_Custom'; 
    }
}

new wpestate_custom_menu();





class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

   // var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );


    function start_lvl(&$output, $depth = 0, $args = array()) {  
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
    }
    

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $_wp_nav_menu_max_depth;
        global $wp_registered_sidebars;
       
        
        
        if ( $depth > $_wp_nav_menu_max_depth ) {
            $_wp_nav_menu_max_depth   =$depth;
        }else{
            $_wp_nav_menu_max_depth  =$_wp_nav_menu_max_depth;
        }
     
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
        
        ob_start();
        
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );


    
        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }
    
        $classes = array(
            'wpestate-megamenu',
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );
    
        $title = $item->title;
    
        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            $title = sprintf( __( '%s (Invalid)', "wpestate"), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            $title = sprintf( __('%s (Pending)', "wpestate"), $item->title );
        }
    
        $title = empty( $item->label ) ? $title : $item->label;
       
        ?>
        <li id="menu-item-<?php echo esc_html($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', "wpestate"); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down',"wpestate"); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo esc_html($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', "wpestate"); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php _e( 'Edit Menu Item', "wpestate"); ?></a>
                    </span>
                </dt>
            </dl>
    
            <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_html($item_id); ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo esc_html($item_id); ?>">
                            <?php _e( 'URL', "wpestate" ); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo esc_html($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Navigation Label', "wpestate" ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo esc_html($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Title Attribute', "wpestate" ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo esc_html($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo esc_html($item_id); ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo esc_html($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_html($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php _e( 'Open link in a new window/tab', "wpestate" ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'CSS Classes (optional)', "wpestate" ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo esc_html($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Link Relationship (XFN)', "wpestate"  ); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo esc_html($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Description', "wpestate" ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo esc_html($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_html($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', "wpestate"); ?></span>
                    </label>
                </p>


                <p class="description description-wide">
                <label for="edit-menu-item-target-<?php echo esc_html($item_id); ?>">
                        <strong><?php _e( 'Menu Item Icon(ex: fa fa-comment)', "wpestate" ); ?></strong><br />
                        <input class="widefat" type="text" id="edit-menu-item-menu-icon-<?php echo esc_html($item_id); ?>" name="menu-item-menu_icon[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->menu_icon ); ?>" />   
                     
                </label>
                </p>

                <p class="field-megamenu-checkbox">
                    <?php 

                        $value = get_post_meta( $item->ID, '_menu_item_megamenu', true);
                        if($value != "") $value = "checked='checked'";

                    ?>
                    <label for="edit-menu-item-megamenu-<?php echo esc_html($item_id); ?>">
                        <input type="checkbox" value="enabled" class="edit-menu-item-wpestate-megamenu-check" id="edit-menu-item-megamenu-<?php echo esc_html($item_id); ?>" name="edit-menu-item-megamenu[<?php echo esc_html($item_id); ?>]" <?php echo esc_html($value); ?> />
                        <strong><em><?php _e( 'Set as Mega Menu?', "wpestate" ); ?></em></strong>
                    </label>
                </p>

                 <p class="field-megamenu-widgets description description-wide">
                    <label for="edit-menu-item-megamenu-widgetarea-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Mega Menu Widget Area', 'wpestate' ); ?>
                        <select id="edit-menu-item-megamenu-widgetarea-<?php echo esc_html($item_id); ?>" class="widefat code edit-menu-item-megamenu-widgetarea" name="menu-item-megamenu-widgetarea[<?php echo esc_html($item_id); ?>]">
                            <option value="0"><?php _e( 'Select Widget Area', 'wpestate' ); ?></option>
                            <?php
                            if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
                            foreach( $wp_registered_sidebars as $sidebar ):
                            ?>
                            <option value="<?php echo esc_html($sidebar['id']); ?>" <?php selected( $item->megamenu_widgetarea, $sidebar['id'] ); ?>><?php echo esc_html($sidebar['name']); ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </label>
                </p>

                <a href="#" id="wpestate-media-upload-<?php echo esc_html($item_id); ?>" class="load_back_menu  "><?php _e( 'Upload Background Image | ', 'wpestate' ); ?></a>
              
                <a href="#" id="wpestate-media-remove-<?php echo esc_html($item_id); ?>" class="remove-megamenu-background" style="<?php echo ( trim( $item->megamenu_background ) ) ? 'display: inline;' : '';?>"><?php _e('Remove Image','wpestate');?></a>
                <p class="field-megamenu-background description description-wide">
                    <label for="edit-menu-item-megamenu-background-<?php echo esc_html($item_id); ?>">
                        <input type="hidden" id="edit-menu-item-megamenu-background-<?php echo esc_html($item_id); ?>" class="widefat code edit-menu-item-megamenu-background" name="menu-item-megamenu-background[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_html($item->megamenu_background); ?>" />
                        <img src="<?php echo esc_html($item->megamenu_background); ?>" id="wpestate-media-img-<?php echo esc_html($item_id); ?>" class="wpestate-megamenu-background-image" style="<?php echo ( trim( esc_html($item->megamenu_background) ) ) ? 'display: inline;' : '';?>" />
                       
                    </label>
                </p>

                <p class="field-megamenu-styles description description-wide">
                    <label for="edit-menu-item-megamenu-styles-<?php echo esc_html($item_id); ?>">
                        <?php _e( 'Container Styles( *set custom styles for mega menu container only:.  Ex: background position, background repeat )', "wpestate" ); ?><br />
                        <textarea id="edit-menu-item-megamenu-styles-<?php echo esc_html($item_id); ?>" class="widefat edit-menu-item-megamenu-styles" rows="3" cols="20" name="menu-item-megamenu-styles[<?php echo esc_html($item_id); ?>]"><?php echo esc_html( $item->megamenu_styles ); // textarea_escaped ?></textarea>
                    </label>
                </p>

                
                <p class="field-megamenu-checkbox-border">
                    <?php 

                        $value = get_post_meta( $item->ID, '_menu-item-megamenu-border', true);
                        if($value != "") {
                            $value = "checked='checked'";
                        }
                    ?>
                    <label for="menu-item-megamenu-border-<?php echo esc_html($item_id); ?>">
                        <input type="checkbox" value="enabled" class="menu-item-megamenu-border" id="menu-item-megamenu-border-<?php echo esc_html($item_id); ?>" name="menu-item-megamenu-border[<?php echo esc_html($item_id); ?>]" <?php echo esc_html($value); ?> />
                        <strong><em><?php _e( 'Draw border right on mega menu column?', "wpestate" ); ?></em></strong>
                    </label>
                </p>
           

                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( __('Original: %s', "wpestate"), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_html($item_id); ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php _e('Remove', "wpestate" ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_html($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                        ?>#menu-item-settings-<?php echo esc_html($item_id); ?>"><?php _e('Cancel', "wpestate"); ?></a>
                </div>

                <?php
                // Helps plugins hook their own fields.
                do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
                ?>
    
                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_html($item_id); ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_html($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        
        $output .= ob_get_clean();

        }
}


// used on header.php main navigation
class wpestate_custom_walker extends Walker_Nav_Menu {

        var $columns        = 0;
        var $max_columns    = 0;
        var $rows           = 1;
        var $rowsCounter    = array();
        var $mega_active    = 0;

        
        // starts at the begining of the level
        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent         =   str_repeat("\t", $depth);
            $style          =   '';
    
            
            if($depth === 0 && $this->active_megamenu) 
            {
            
                if( !empty($this->megamenu_background)) {
                    $style .= 'Background-image:url('.$this->megamenu_background.');';
                }
                
                if (!empty($this->megamenu_styles) ){
                    $style .=  $this->megamenu_styles;
                }
                
              
            }

            $output .= "\n$indent<ul style=\"$style\" class=\"  sub-menu {to_replace_class}\">\n";

            

        }
    
        // shows at the end of the level
        function end_lvl(&$output, $depth = 0, $args = array()) {
            $indent     = str_repeat("\t", $depth);
            $output    .= "$indent</ul>\n";
            
            if($depth === 0) 
            {
                if($this->active_megamenu)
                {

                    $output = str_replace("{to_replace_class}", "wpestate_megamenu_col_".$this->max_columns."", $output);
                    
                    foreach($this->rowsCounter as $row => $columns)
                    {
                        $output = str_replace("{current_row_".$row."}", "wpestate_megamenu_col_".$columns, $output);
                    }
                    
                    $this->columns = 0;
                    $this->max_columns = 0;
                    $this->rowsCounter = array();
                    
                }
                else
                {
                    $output = str_replace("{to_replace_class}", "", $output);
                }
            }
        }    


        // shows ar start of the element
        function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
            global $wp_query;
            $item_output            = '';
            $li_text_block_class    = '';
            $column_class           = '';

            $this->megamenu_widgetarea  = get_post_meta( $item->ID, '_menu_item_megamenu_widgetarea', true);
            $this->megamenu_background  = get_post_meta( $item->ID, '_menu_item_megamenu_background', true );
            $this->megamenu_styles      = get_post_meta( $item->ID, '_menu_item_megamenu_styles', true );
            $this->megamenu_border      = get_post_meta( $item->ID, '_menu-item-megamenu-border', true );
            

            if($depth === 0)
            {   
                $this->active_megamenu = get_post_meta( $item->ID, '_menu_item_megamenu', true);
                if($this->active_megamenu) {
                    $column_class .= " with-megamenu";
                } else {
                    $column_class .= " no-megamenu";
                }

            }


            
            if($depth === 1 && $this->active_megamenu)
            {
                $this->columns ++;
                
                $this->rowsCounter[$this->rows] = $this->columns;
                
                if($this->max_columns < $this->columns) {
                    $this->max_columns = $this->columns; 
                }
                
                $column_class  = ' {current_row_'.$this->rows.'}';
                
                if($this->columns == 1){
                    $column_class  .= " wpestate_megamenu_first_element";
                }

                if($this->megamenu_widgetarea == false) {
                
                    $title = apply_filters( 'the_title', $item->title, $item->ID );

                    if($title != "&#8211;" && $title != '"&#8211;"')
                    {
                        $menu_icon_tag  = ! empty( $item->menu_icon ) ? '<i class="'.esc_attr( $item->menu_icon ).'"></i>' : '';
                        $attributes = ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn) .'"' : '';      

                        $item_output .= $args->before;
                        $item_output .= '<div class="megamenu-title"'. $attributes .'>';
                        $item_output .= '<a href="'.$item->url.'">';
                        $item_output .= $menu_icon_tag;
                        $item_output .= $args->link_before . $title . $args->link_after.'</a>';
                        $item_output .= '</div>';
                        $item_output .= $args->after;
                    }

                } else {
                     if( is_active_sidebar( $this->megamenu_widgetarea )) {
                        $item_output .= '<div class="megamenu-widgets-container">';
                        ob_start();
                        dynamic_sidebar( $this->megamenu_widgetarea );
                        $temp=ob_get_contents();
                        ob_end_clean(); 
                        $item_output .= '<ul>'.$temp. '</ul></div>';
                       
                    }
                }
               

               
            } else {

                if($depth === 2 && $this->megamenu_widgetarea && $this->active_megamenu) {

                if( is_active_sidebar( $this->megamenu_widgetarea ) ) {
                    $item_output .= '<div class="megamenu-widgets-container">';
                    ob_start();
                    dynamic_sidebar( $this->megamenu_widgetarea );
                    $temp=ob_get_contents();
                    ob_end_clean(); 
                    $item_output .= '<ul>'.$temp. '</ul></div>';
            }
            } else {

                    $menu_icon_tag  = ! empty( $item->menu_icon ) ? '<i class="'.esc_attr( $item->menu_icon ).'"></i>' : '';
                    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ' href="#"';            

                    if(isset($args->before)){
                        $item_output .= $args->before;
                    }
                    $item_output .= '<a class="menu-item-link" '. $attributes .'>';
                    $item_output .= $menu_icon_tag;
                    
                    if( isset($args->link_before)){
                        $item_output .= $args->link_before;
                    }
                    
                    $item_output .=  apply_filters( 'the_title', $item->title, $item->ID );
                    
                    if(isset($args->link_after)){
                       $item_output .=   $args->link_after;
                    }
                    $item_output .= '</a>';
                    
                    if(isset($args->after)){
                        $item_output .= $args->after;
                    }
                }
            }
            
            
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';
    
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    
             $border_class='';
            if (!empty($this->megamenu_border) ){
                $border_class.=  'mega_menu_border';
            }
            
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.'  '.$border_class.' "';
            
           
                
            $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
            
            
            
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
}