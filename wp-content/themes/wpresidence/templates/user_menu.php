<?php 
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  
$add_link               =   get_dasboard_add_listing();
$dash_profile           =   get_dashboard_profile_link();
$dash_favorite          =   get_dashboard_favorites();
$dash_link              =   get_dashboard_link();
$dash_searches          =   get_searches_link();
$activeprofile          =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$activesearch           =   '';
$activeinvoices         =   '';
$user_pack              =   get_the_author_meta( 'package_id' , $userID );    
$clientId               =   esc_html( get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
$home_url               =   home_url();
$dash_invoices          =   wpestate_get_invoice_link();

if ( basename( get_page_template() ) == 'user_dashboard.php' ){
    $activedash  =   'user_tab_active';    
}else if ( basename( get_page_template() ) == 'user_dashboard_add.php' ){
    $activeadd   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_profile.php' ){
    $activeprofile   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_favorite.php' ){
    $activefav   =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_searches.php' ){
    $activesearch  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_invoices.php' ){
    $activeinvoices  =   'user_tab_active';
}
?>


<div class="user_tab_menu">

    <div class="user_dashboard_links">
        <?php if( $dash_profile!=$home_url ){ ?>
            <a href="<?php print esc_url($dash_profile);?>"  class="<?php print $activeprofile; ?>"><i class="fa fa-cog"></i> <?php _e('My Profile','wpestate');?></a>
        <?php } ?>
        <?php if( $dash_link!=$home_url ){ ?>
            <a href="<?php print esc_url($dash_link);?>"     class="<?php print $activedash; ?>"> <i class="fa fa-map-marker"></i> <?php _e('My Properties List','wpestate');?></a>
        <?php } ?>
        <?php if( $add_link!=$home_url ){ ?>
            <a href="<?php print esc_url ($add_link);?>"      class="<?php print $activeadd; ?>"> <i class="fa fa-plus"></i><?php _e('Add New Property','wpestate');?></a>  
        <?php } ?>
        <?php if( $dash_favorite!=$home_url ){ ?>
            <a href="<?php print esc_url($dash_favorite);?>" class="<?php print $activefav; ?>"><i class="fa fa-heart"></i> <?php _e('Favorites','wpestate');?></a>
        <?php } ?>
        <?php if( $dash_searches!=$home_url ){ ?>
            <a href="<?php print esc_url($dash_searches);?>" class="<?php print $activesearch; ?>"><i class="fa fa-search"></i> <?php _e('Saved Searches','wpestate');?></a>
        <?php } 
        if( $dash_invoices!=$home_url ){ ?>
            <a href="<?php print esc_url($dash_invoices);?>" class="<?php print $activeinvoices; ?>"><i class="fa fa-file-text-o"></i> <?php _e('My Invoices','wpestate');?></a>
        <?php } ?>
            
            
            
        <a href="<?php echo wp_logout_url();?>" title="Logout"><i class="fa fa-power-off"></i> <?php _e('Log Out','wpestate');?></a>
    </div>
      <?php  get_template_part('templates/user_memebership_profile');  ?>
</div>

 