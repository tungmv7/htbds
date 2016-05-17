<?php
global $post;
global $userID;
global $where_currency;
global $currency;
global $current_user;
?>

<div class="col-md-12 invoice_unit " data-booking-confirmed="<?php echo esc_html(get_post_meta($post->ID, 'item_id', true));?>" data-invoice-confirmed="<?php echo intval($post->ID); ?>">
    <div class="col-md-2">
         <?php echo get_the_title(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php echo get_the_date(); ?> 
    </div>
    
    <div class="col-md-2">
        <?php 
            $invoice_type= esc_html(get_post_meta($post->ID, 'invoice_type', true)); 
             //quick solution -  to be changed 
            if($invoice_type == 'Listing'){
                _e('Listing','wpestate');
            }else if($invoice_type == 'Upgrade to Featured') {
                _e('Upgrade to Featured','wpestate');
            } else if($invoice_type == 'Publish Listing with Featured'){
                _e('Publish Listing with Feature','wpestate');
            }else if($invoice_type == 'Package'){
                _e('Package','wpestate');
            }
        
        ?>
    </div>
    
    <div class="col-md-2">
        <?php 
            $bill_type = esc_html(get_post_meta($post->ID, 'biling_type', true));
            //quick solution -  to be changed 
            if($bill_type =='One Time' ){
                _e('One Time','wpestate');
            }else if( $bill_type == 'Recurring'){
                 _e('Recurring','wpestate');
            }
        ?>
    </div>
    
    <div class="col-md-2">
        <?php 
        $status = esc_html(get_post_meta($post->ID, 'pay_status', true));
        if($status==0){
            _e('Not Paid','wpestate');
        }else{
            _e('Paid','wpestate');
        }   
        ?>      
    </div>
    
    <div class="col-md-2">
        <?php 
        $price = get_post_meta($post->ID, 'item_price', true);
        //$currency                   =   esc_html( get_post_meta($post->ID, 'invoice_currency',true) );
       
      
       echo wpestate_show_price_booking_for_invoice($price,$currency,$where_currency,0,1) ?>
    </div>
</div>
