<?php
// Template Name: User Dashboard Invoices
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect(  home_url() );exit;
} 

$current_user = wp_get_current_user();   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$currency                       =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

get_header();
$options=wpestate_page_details($post->ID);
?> 


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-md-3">
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    <div class="col-md-9 dashboard-margin">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php } ?>
         
        <?php
        $args = array(
                'post_type'        => 'wpestate_invoice',
                'post_status'      => 'publish',
                'posts_per_page'   => -1 ,
                'author'           => $userID,
                
            );
          


            $prop_selection = new WP_Query($args);
            $counter                =   0;
            $options['related_no']  =   4;
            $total_confirmed        =   0;
            $total_issued           =   0;
            $templates              =   '<div class="no_invoices">'.__('No invoices','wpestate').'</div>';
            
            if( $prop_selection->have_posts() ){
                ob_start(); 
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/invoice_listing_unit'); 
                    $status = esc_html(get_post_meta($post->ID, 'invoice_status', true));
                    $type   = esc_html(get_post_meta($post->ID, 'invoice_type', true));
                    $price  = esc_html(get_post_meta($post->ID, 'item_price', true));
                    
                    $total_issued='-';
                    $total_confirmed = $total_confirmed + $price;
                    
                endwhile;
                $templates = ob_get_contents();
                ob_end_clean(); 
            }
     
       print '<div class="col-md-12 invoice_filters">
                    <div class="col-md-2">
                        <input type="text" id="invoice_start_date" class="form-control" name="invoice_start_date" placeholder="'.__('from date','wpestate').'"> 
                    </div>
                    
                    <div class="col-md-2">
                        <input type="text" id="invoice_end_date" class="form-control"  name="invoice_end_date" placeholder="'.__('to date','wpestate').'"> 
                    </div>
                    

                    <div class="col-md-2">
                        <select id="invoice_type" name="invoice_type" class="form-control select-submit2">
                            <option value="">'.__('Any','wpestate').'</option>
                            <option value="Upgrade to Featured">'.__('Upgrade to Featured','wpestate').'</option>   
                            <option value="Publish Listing with Featured">'.__('Publish Listing with Featured','wpestate').'</option>
                            <option value="Package">'.__('Package','wpestate').'</option>
                            <option value="Listing">'.__('Listing','wpestate').'</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select id="invoice_status" name="invoice_status" class="form-control">
                            <option value="">'.__('Any','wpestate').'</option>
                            <option value="1">'.__('Paid','wpestate').'</option>
                            <option value="0">'.__('Not Paid','wpestate').'</option>   
                        </select>
                    
                    </div>

                </div>
                    
           
                <div class="col-md-12 invoice_totals">
                <strong>'.__('Total Invoices: ','wpestate').'</strong><span id="invoice_confirmed">'.wpestate_show_price_custom_invoice($total_confirmed).'</span>
               </div>
                ';
                
                
                print '<div class="col-md-12 invoice_unit_title">
                    <div class="col-md-2">
                        <strong> '.__('Title','wpestate').'</strong> 
                    </div>

                    <div class="col-md-2">
                         <strong> '.__('Date','wpestate').'</strong> 
                    </div>

                    <div class="col-md-2">
                         <strong> '.__('Invoice Type','wpestate').'</strong> 
                    </div>

                    <div class="col-md-2">
                        <strong> '.__('Billing Type','wpestate').'</strong> 
                    </div>

                    <div class="col-md-2">
                        <strong> '.__('Status','wpestate').'</strong> 
                    </div>

                    <div class="col-md-2">
                         <strong> '.__('Price','wpestate').'</strong> 
                    </div>
                </div>
                ';
                
                print '<div id="container-invoices">';
                print $templates;
                print '</div>';
             ?>          
                
    </div>
    
 
  
</div>   

<?php get_footer(); ?>