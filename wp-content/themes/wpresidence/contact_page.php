<?php
// Template Name: Contact Page 
// Wp Estate Pack
get_header();
$options            =   wpestate_page_details($post->ID);
$company_name       =   esc_html(stripslashes( get_option('wp_estate_company_name', '') ) );
$company_picture    =   esc_html( get_option('wp_estate_company_contact_image', '') );
$company_email      =   esc_html( get_option('wp_estate_email_adr', '') );
$mobile_no          =   esc_html ( get_option('wp_estate_mobile_no','') );
$telephone_no       =   esc_html( get_option('wp_estate_telephone_no', '') );
$fax_ac             =   esc_html( get_option('wp_estate_fax_ac', '') );
$skype_ac           =   esc_html( get_option('wp_estate_skype_ac', '') );

if (function_exists('icl_translate') ){
    $co_address      =  esc_html( icl_translate('wpestate','wp_estate_co_address_text', ( get_option('wp_estate_co_address') ) ) );
}else{
    $co_address      = esc_html( stripslashes ( get_option('wp_estate_co_address', '') ) );
}

$facebook_link      =   esc_html( get_option('wp_estate_facebook_link', '') );
$twitter_link       =   esc_html( get_option('wp_estate_twitter_link', '') );
$google_link        =   esc_html( get_option('wp_estate_google_link', '') );
$linkedin_link      =   esc_html ( get_option('wp_estate_linkedin_link','') );
$pinterest_link     =   esc_html ( get_option('wp_estate_pinterest_link','') );
$agent_email        =   $company_email;

//wpestate_check_free_listing_expiration();
?>


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="<?php print esc_html($options['content_class']);?>">
        
       
          
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="contact-wrapper">    
            <div class="col-md-4 contact_page_company_picture">
                <?php print '<img src="'.$company_picture.'"  class="contact-comapany-logo img-responsive" alt="company logo"/> '; ?>    
            </div>
            
            <div class="col-md-8 contact_page_company_details">
                <div class="company_headline ">   
                    <h3><?php print esc_html($company_name);?></h3>
                    <div class="header_social">
                        <?php
                        if($facebook_link!=''){
                            print ' <a href="'. $facebook_link.'"><i class="fa fa-facebook"></i></a>';
                        }

                        if($twitter_link!=''){
                           print ' <a href="'.$twitter_link.'"><i class="fa fa-twitter"></i></a>';
                        }
                        
                        if($google_link!=''){
                            print ' <a href="'. $google_link.'"><i class="fa fa-google-plus"></i></a>';
                        }

                        if($linkedin_link!=''){
                            print ' <a href="'.$linkedin_link.'"><i class="fa fa-linkedin"></i></a>';
                        }

                        if($pinterest_link!=''){
                             print ' <a href="'. $pinterest_link.'"><i class="fa fa-pinterest"></i></a>';
                        }
                        ?>
                    </div>     
                </div>   
         
                <?php      
                    if ($telephone_no) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-phone"></i><a href="tel:' . $telephone_no . '">'; print  $telephone_no . '</a></div>';
                    }

                     if ($mobile_no) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-mobile"></i><a href="tel:' . $mobile_no . '">'; print  $mobile_no . '</a></div>';
                    }

                    if ($company_email) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-envelope-o"></i>'; print '<a href="mailto:'.$company_email.'">' . $company_email . '</a></div>';
                    }
                    
                    if ($fax_ac) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-print"></i>';print   $fax_ac . '</div>';
                    }
                    
                    if ($skype_ac) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-skype"></i>';print   $skype_ac . '</div>';
                    }

                    if ($co_address) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-home"></i>';print   $co_address . '</div>';
                    }
                ?>
                
            </div>
            </div>    
           
                
                
       
         
                
                
            <div class="single-content contact-content">    
                <?php the_content(); ?>
                <?php get_template_part('templates/agent_contact');   ?>
           </div><!-- single content-->
           
        <?php endwhile; // end of the loop. ?>
    </div>
  
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>