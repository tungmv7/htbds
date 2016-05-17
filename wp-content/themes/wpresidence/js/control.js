/*global $, jQuery, ajaxcalls_vars, document, control_vars, window*/
var width,height;
width   = jQuery(window).width();
height  = jQuery(window).height();

jQuery(window).scroll(function () {
    "use strict";
    var scroll = jQuery(window).scrollTop();
    if (scroll >= 100) {
        if (!Modernizr.mq('only all and (max-width: 1023px)')) {
            
            jQuery(".master_header").addClass("master_header_sticky");
            jQuery('.logo').addClass('miclogo');
            jQuery(".header_wrapper").addClass("navbar-fixed-top");
            jQuery(".header_wrapper").addClass("customnav");
   
            jQuery('.barlogo').show();
            jQuery('#user_menu_open').hide();
            jQuery('.navicon-button').removeClass('opensvg');
        }
        jQuery('.contact-box').addClass('islive');
        jQuery('.backtop').addClass('islive');
    } else {
        jQuery(".master_header").removeClass("master_header_sticky");
        jQuery(".header_wrapper").removeClass("navbar-fixed-top");
        jQuery(".header_wrapper").removeClass("customnav");
        jQuery('.contact-box ').removeClass('islive');
        jQuery('.backtop').removeClass('islive');
        jQuery('.contactformwrapper').addClass('hidden');
        jQuery('.barlogo').hide();
        jQuery('#user_menu_open').hide();
        jQuery('.logo').removeClass('miclogo');
    }
});



jQuery(window).resize(function() {
    "use strict";    
    // check because crome mobile trigger resize event on  scroll
    if(jQuery(window).width() != width ){
        jQuery('#mobile_menu').hide('10');
    }
    wpestate_half_map_responsive();
   
    
    
});


function wpestate_half_map_responsive(){
     
    if (Modernizr.mq('only screen and (min-width: 640px)') && Modernizr.mq('only screen and (max-width: 1025px)')) {
        var half_map_header = jQuery('.master_header ').height();
      
        jQuery('#google_map_prop_list_wrapper,#google_map_prop_list_sidebar').css('top',half_map_header).css('margin-top','0px');
        
    }
    
}



Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&'+control_vars.price_separator);
};


function wpestate_lazy_load_carousel_property_unit(){
    jQuery('.property_unit_carousel img').each(function(event){
          var new_source='';
          new_source=jQuery(this).attr('data-lazy-load-src');
          if(typeof (new_source)!=='undefined' && new_source!==''){
              jQuery(this).attr('src',new_source);
          }
      });
}

jQuery(document).ready(function ($) {
   "use strict";
    var screen_width,screen_height,map_tab;
    
    map_tab=0
    $('#propmaptrigger').click(function(){
        if(map_tab===0){
            wpestate_map_shortcode_function();
            map_tab=1;
            
        }
    });
    
    $('.slider_container').each(function(index){
        var autoscroll_slider = parseInt ( $(this).find('.shortcode_slider_wrapper').attr('data-auto'));
        var element;
        var slideTimer;
        
        element= $(this).find(".slider_control_right");
        
        if (autoscroll_slider!==0){
                slideTimer = setInterval(function(){
                    slider_control_right_function(element);
                }, autoscroll_slider
            );
        }
        
        $(this).find('.slider_control_right').click(function(){
            clearInterval(slideTimer);
            slider_control_right_function($(this));
            if (autoscroll_slider!==0){
                slideTimer = setInterval(function(){
                    slider_control_right_function(element);
                    }, autoscroll_slider
                );
            }
        });
    
           
        $(this).find('.slider_control_left').click(function(){
            clearInterval(slideTimer);
            slider_control_left_function($(this));
            if (autoscroll_slider!==0){
                slideTimer = setInterval(function(){
                    slider_control_right_function(element);
                    }, autoscroll_slider
                );
            }
        });

        
    });
     
   
  
    
    function slider_control_left_function(element){
        var step_size,margin_left,new_value,last_element,base_value,parent;
        parent=element.parent();
        step_size   =   parent.find('.shortcode_slider_list').width();
        margin_left =   parseInt(parent.find('.shortcode_slider_list').css('margin-left'), 10);
        new_value   =   margin_left-285;
        base_value  =   -15;
        parent.find('.shortcode_slider_list').css('margin-left',new_value+'px');
        last_element = parent.find('.shortcode_slider_list li:last-child');
        parent.find('.shortcode_slider_list li:last-child').remove();
        parent.find('.shortcode_slider_list').prepend(last_element);
           restart_js_after_ajax();
        
        parent.find('.shortcode_slider_list').animate({
            'margin-left':base_value
        },800, function() {
           
        });
    }
        
        
   
    function slider_control_right_function(elemenet){
        var step_size,margin_left,new_value, first_element, parent;
        parent=elemenet.parent();
   
        step_size   =   parent.find('.shortcode_slider_list').width();
        margin_left =   parseInt(parent.find('.shortcode_slider_list').css('margin-left'), 10);
        //new_value   =   margin_left-step_size-90;
        new_value   =   margin_left-285;
       
        parent.find('.shortcode_slider_list').animate({
            'margin-left':new_value
        },800, function() {
            first_element = parent.find('.shortcode_slider_list li:nth-child(1)');
            parent.find('.shortcode_slider_list li:nth-child(1)').remove();
            parent.find('.shortcode_slider_list').append(first_element);
            parent.find('.shortcode_slider_list').css('margin-left',-15+'px');
               restart_js_after_ajax();
        });
    }
    
    
    $(window).bind("load", function() {
        wpestate_lazy_load_carousel_property_unit();
    });

    wpestate_half_map_responsive();
  

    $('.show_stats').click(function(event){
        event.preventDefault();
        var parent,listing_id;
        listing_id = $(this).attr('data-listingid');
        $('.statistics_wrapper').slideUp();
        parent = $(this).parent().parent().parent();
        parent.find('.statistics_wrapper').slideDown(); 

        wpestate_load_stats(listing_id);
    });
   
     $('.tabs_stats').click(function(){
       var parent,listing_id;
       listing_id = $(this).attr('data-listingid');
       //console.log("tabs "+listing_id);
       wpestate_load_stats_tabs(listing_id);
    });
    
  
    
    ////////////////////////////////////////////////////////////////////////////
    //new retina script
    ////////////////////////////////////////////////////////////////////////////
        
        $('.retina_ready').dense();
        var image_unnit = $('<div data-1x="'+control_vars.path+'/css/css-images/unit.png" data-2x="'+control_vars.path+'/css/css-images/unit_2x.png" />').dense('getImageAttribute');
        $('.featured_div,.icon-fav-off,.icon-fav-on,.compare-action').css('background-image', 'url(' + image_unnit + ')').css('background-size','175px 53px');
        
        var image_unnit = $('<div data-1x="'+control_vars.path+'/css/css-images/unitshare.png" data-2x="'+control_vars.path+'/css/css-images/unitshare_2x.png" />').dense('getImageAttribute');
        $('.share_list').css('background-image', 'url(' + image_unnit + ')').css('background-size','40px 16px');

        var image_unnit = $('<div data-1x="'+control_vars.path+'/css/css-images/icon_bed1.png" data-2x="'+control_vars.path+'/css/css-images/icon_bed1_2x.png" />').dense('getImageAttribute');
        $('.inforoom').css('background-image', 'url(' + image_unnit + ')').css('background-size','19px 10px');

        var image_unnit = $('<div data-1x="'+control_vars.path+'/css/css-images/icon_bath1.png" data-2x="'+control_vars.path+'/css/css-images/icon_bath1_2x.png" />').dense('getImageAttribute');
        $('.infobath').css('background-image', 'url(' + image_unnit + ')').css('background-size','14px 13px');

        var image_unnit = $('<div data-1x="'+control_vars.path+'/css/css-images/icon-size1.png" data-2x="'+control_vars.path+'/css/css-images/icon-size1_2x.png" />').dense('getImageAttribute');
        $('.infosize').css('background-image', 'url(' + image_unnit + ')').css('background-size','15px 12px');

    
    ////////////////////////////////////////////////////////////////////////////
    //invoice filters
    ////////////////////////////////////////////////////////////////////////////
    jQuery("#invoice_start_date").datepicker({
        dateFormat : "yy-mm-dd",
      
    }, jQuery.datepicker.regional[control_vars.datepick_lang]).datepicker('widget').wrap('<div class="ll-skin-melon"/>');
    
    
    jQuery("#invoice_end_date").datepicker({
        dateFormat : "yy-mm-dd",
      
    }, jQuery.datepicker.regional[control_vars.datepick_lang]).datepicker('widget').wrap('<div class="ll-skin-melon"/>');
    
    
    
    $('#invoice_start_date, #invoice_end_date, #invoice_type ,#invoice_status ').change(function(){
        filter_invoices();
    });
   
    ////////////////////////////////////////////////////////////////////////////
    //new mobile menu 1.10 
    ////////////////////////////////////////////////////////////////////////////

    $('.all-elements').animate({
            minHeight: 100+'%'
    });
    
    $('.header-tip').addClass('hide-header-tip');
    
    var vc_size;
    var var_parents=new Array();
    var var_parents_back=new Array();
    
    
    
    $('.mobile-trigger').click(function() {
        if(  $('#all_wrapper').hasClass('moved_mobile') ){
            close_mobile_menu();
        }else{
           
           
            $('#all_wrapper').css('-webkit-transform','translate(266px, 0px)');
            $('#all_wrapper').css('-moz-transform','translate(266px, 0px)');
            $('#all_wrapper').css('-ms-transform','translate(266px, 0px)');
            $('#all_wrapper').css('-o-transform','translate(266px, 0px)');
            $('#all_wrapper').addClass('moved_mobile');
            
            $('.mobilewrapper-user').hide();
            $('.mobilewrapper').show();
            $('.mobilewrapper').css('-webkit-transform','translate(0px, 0px)'); 
            $('.mobilewrapper').css('-moz-transform','translate(0px, 0px)');  
            $('.mobilewrapper').css('-ms-transform','translate(0px, 0px)');  
            $('.mobilewrapper').css(' -o-transform','translate(0px, 0px)');  
            $('body').css('overflow-x','hidden');
             
        }
    });
     
     
     $('.mobile-trigger-user').click(function () {
        if ($('#all_wrapper').hasClass('moved_mobile_user')) {
            close_mobile_user_menu();
        } else {
            $('#all_wrapper').css('-webkit-transform', 'translate(-265px, 0px)');
            $('#all_wrapper').css('-moz-transform', 'translate(-265px, 0px)');
            $('#all_wrapper').css('-ms-transform', 'translate(-265px, 0px)');
            $('#all_wrapper').css('-o-transform', 'translate(-265px, 0px)');
            $('#all_wrapper').addClass('moved_mobile_user');
          
            $('.mobilewrapper-user').show();
            $('.mobilewrapper').hide();
            $('.mobilewrapper-user').css('-webkit-transform', 'translate(0px, 0px)');
            $('.mobilewrapper-user').css('-moz-transform', 'translate(0px, 0px)');
            $('.mobilewrapper-user').css('-ms-transform', 'translate(0px, 0px)');
            $('.mobilewrapper-user').css(' -o-transform', 'translate(0px, 0px)');
        }
    });
     
    $('.mobilemenu-close-user').click(function(){
        close_mobile_user_menu();
    });
    
    
    $('.mobilemenu-close').click(function() {
        close_mobile_menu();        
    });
    
    function close_mobile_user_menu(){
        $('#all_wrapper').css('-webkit-transform', 'translate(0px, 0px)');
        $('#all_wrapper').css('-moz-transform', 'translate(0px, 0px)');
        $('#all_wrapper').css('-ms-transform', 'translate(0px, 0px)');
        $('#all_wrapper').css('-o-transform', 'translate(0px, 0px)');
        $('#all_wrapper').removeClass('moved_mobile_user');


        $('.mobilewrapper-user').hide();
        $('.mobilewrapper').hide();
        $('.mobilewrapper-user').css('-webkit-transform', 'translate(265px, 0px)');
        $('.mobilewrapper-user').css('-moz-transform', 'translate(265px, 0px)');
        $('.mobilewrapper-user').css('-ms-transform', 'translate(265px, 0px)');
        $('.mobilewrapper-user').css('-o-transform', 'translate(265px, 0px)');
    }
    
    function close_mobile_menu(){
    
          
            
        $('#all_wrapper').css('-webkit-transform','translate(0px, 0px)');  
        $('#all_wrapper').css('-moz-transform','translate(0px, 0px)'); 
        $('#all_wrapper').css('-ms-transform','translate(0px, 0px)'); 
        $('#all_wrapper').css('-o-transform','translate(0px, 0px)'); 
        $('#all_wrapper').removeClass('moved_mobile');    
        
        $('.mobilewrapper').hide();
        $('.mobilewrapper-user').hide();
        $('.mobilewrapper').css('-webkit-transform','translate(-265px, 0px)'); 
        $('.mobilewrapper').css('-moz-transform','translate(-265px, 0px)');
        $('.mobilewrapper').css('-ms-transform','translate(-265px, 0px)');
        $('.mobilewrapper').css('-o-transform','translate(-265px, 0px)');
     
       
    }
    
    
    $('#menu-main-menu li').click(function(event ){
        event.stopPropagation();
        var selected;
        selected = $(this).find('.sub-menu:first');
        selected.slideToggle();
    });

        
    
    ////////////////////////////////////////////////////////////////////////////
    // multiple cur set cookige
    ////////////////////////////////////////////////////////////////////////////
    
    $('.list_sidebar_currency li').click(function(){
        var ajaxurl,data,pos,symbol,coef,curpos;
        data=$(this).attr('data-value');
        pos=$(this).attr('data-pos');
        symbol=$(this).attr('data-symbol');
        coef=$(this).attr('data-coef');
        curpos=$(this).attr('data-curpos');
        
        ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_set_cookie_multiple_curr',
                'curr'      :   data,
                'pos'       :   pos,
                'symbol'    :   symbol,
                'coef'      :   coef,
                'curpos'    :   curpos,
            },
            success: function (data) {     
         
               location.reload();
            },
            error: function (errorThrown) {}
        });//end ajax     
        
    });
    
    
    
    
    
    
    
    ////////////////////////////////////////////////////////////////////////////
    // map control
    ////////////////////////////////////////////////////////////////////////////
    $('#map-view').click(function(event){
        $('.map-type').fadeIn(400);
    });
    
    $('.map-type').click(function(){
        var map_type;
        $('.map-type').hide();
        map_type=$(this).attr('id');
        wpestate_change_map_type(map_type);
        
    });

    ////////////////////////////////////////////////////////////////////////////
    // listing map actions
    ////////////////////////////////////////////////////////////////////////////
   
    if (typeof enable_half_map_pin_action == 'function'){
        enable_half_map_pin_action();
    }
    ////////////////////////////////////////////////////////////////////////////
    /// direct pay
    ////////////////////////////////////////////////////////////////////////////
    
    $('.perpack').click(function(){
        var direct_pay_modal, selected_pack,selected_prop,include_feat,attr;
        selected_prop   =   $(this).attr('data-listing');
        
        var price_pack  =   $(this).parent().parent().find('.submit-price-total').text();;
     
     
        if (control_vars.where_curency === 'after'){
            price_pack = price_pack +' '+control_vars.submission_curency;
        }else{
            price_pack = control_vars.submission_curency+' '+price_pack;
        }
        
        price_pack=control_vars.direct_price+': '+price_pack;
        
        
        include_feat=' data-include-feat="0" ';
        $('#send_direct_bill').attr('data-include-feat',0);
        $('#send_direct_bill').attr('data-listing',selected_prop);
         
        if ( $(this).parent().find('.extra_featured').attr('checked') ){
            include_feat=' data-include-feat="1" ';
            $('#send_direct_bill').attr('data-include-feat',1);
        }

        attr = $(this).attr('data-isupgrade');
        if (typeof attr !== typeof undefined && attr !== false) {
            include_feat=' data-include-feat="1" ';
            $('#send_direct_bill').attr('data-include-feat',1);
        }


        window.scrollTo(0, 0);
        direct_pay_modal='<div class="modal fade" id="direct_pay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'+control_vars.direct_title+'</h4><div class="modal-body listing-submit"><span class="to_be_paid">'+price_pack+'</span><span>'+control_vars.direct_pay+'</span><div id="send_direct_bill" '+include_feat+' data-listing="'+selected_prop+'">'+control_vars.send_invoice+'</div></div></div></div></div></div>';
        jQuery('body').append(direct_pay_modal);
        jQuery('#direct_pay_modal').modal();
        enable_direct_pay_perlisting();
        
          $('#direct_pay_modal').on('hidden.bs.modal', function (e) {
               $('#direct_pay_modal').remove();
        })
        
    });
    
    
    $('#direct_pay').click(function(){
        var direct_pay_modal, selected_pack,selected_prop,include_feat,attr, price_pack;

        selected_pack=$('#pack_select').val();
        var price_pack  =   $('#pack_select option:selected').attr('data-price');
     
        if (control_vars.where_curency === 'after'){
            price_pack = price_pack +' '+control_vars.submission_curency;
        }else{
            price_pack = control_vars.submission_curency+' '+price_pack;
        }
        
        price_pack=control_vars.direct_price+': '+price_pack;
        
        if(selected_pack!==''){
            window.scrollTo(0, 0);
            direct_pay_modal='<div class="modal fade" id="direct_pay_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">'+control_vars.direct_title+'</h4><div class="modal-body listing-submit"><span class="to_be_paid">'+price_pack+'</span><span>'+control_vars.direct_pay+'</span><div id="send_direct_bill" data-pack="'+selected_pack+'">'+control_vars.send_invoice+'</div></div></div></div></div></div>';
            jQuery('body').append(direct_pay_modal);
            jQuery('#direct_pay_modal').modal();
            enable_direct_pay();
        }
        
        $('#direct_pay_modal').on('hidden.bs.modal', function (e) {
               $('#direct_pay_modal').remove();
        })
         
    });
        
        
     
        
    function  enable_direct_pay_perlisting(){
        jQuery('#send_direct_bill').unbind('click');
        jQuery('#send_direct_bill').click(function(){
            jQuery('#send_direct_bill').unbind('click');
            var selected_pack,ajaxurl,include_feat;
           
            selected_pack   =   jQuery(this).attr('data-listing');
            include_feat    =   jQuery(this).attr('data-include-feat')
            ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
            
         
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'wpestate_direct_pay_pack_per_listing',
                    'selected_pack'     :   selected_pack,
                    'include_feat'      :   include_feat,
                },
                success: function (data) {
                    jQuery('#send_direct_bill').hide();
                    jQuery('#direct_pay_modal .listing-submit span:nth-child(2)').empty().html(control_vars.direct_thx);
                },
                error: function (errorThrown) {}
            });//end ajax  

        });
         
    }    
        
        
    function enable_direct_pay(){
        jQuery('#send_direct_bill').click(function(){
            jQuery('#send_direct_bill').unbind('click');
            var selected_pack,ajaxurl;
            selected_pack=jQuery(this).attr('data-pack');
            ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
            
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'            :   'wpestate_direct_pay_pack',
                    'selected_pack'     :   selected_pack,
                },
                success: function (data) {     
                    jQuery('#send_direct_bill').hide();
                    jQuery('#direct_pay_modal .listing-submit span:nth-child(2)').empty().html(control_vars.direct_thx);
                  
                },
                error: function (errorThrown) {}
            });//end ajax  

 
    
    
        });
        
    }    
     
  
    
    ////////////////////////////////////////////////////////////////////////////
    /// stripe
    ////////////////////////////////////////////////////////////////////////////
    $('#pack_select').change(function(){
        var stripe_pack_id,stripe_ammount,the_pick;
        $( "#pack_select option:selected" ).each(function() {
            stripe_pack_id=$(this).val();
            stripe_ammount=parseFloat( $(this).attr('data-price'))*100;
            the_pick=$(this).attr('data-pick');
        });
    
        $('#pack_id').val(stripe_pack_id);
        $('#pay_ammout').val(stripe_ammount);
        $('#stripe_form').attr('data-amount',stripe_ammount);
        
        $('.stripe_buttons').each(function(){
            $(this).hide();
            if( $(this).attr('id') === the_pick){
                 $(this).show();
            }
        })

    });
    
      $('#pack_recuring').click(function () {
        if( $(this).attr('checked') ) {
            $('#stripe_form').append('<input type="hidden" name="stripe_recuring" id="stripe_recuring" value="1">');
        }else{
            $('#stripe_recuring').remove();
        }
    });
    
    ////////////////////////////////////////////////////////////////////////////
    /// floor plans
    ////////////////////////////////////////////////////////////////////////////
    
    $('.front_plan_row').click(function(event){
        event.preventDefault();
        $('.front_plan_row_image').slideUp();        
        $(this).next().slideDown();
    })

    $('.deleter_floor').click(function(){
        $(this).parent().remove();
    })
    // on submit
    
    
    
    
    
    
    
    
    
    
    
    
    
    ////////////////////////////////////////////////////////////////////////////
    /// slider price 
    ////////////////////////////////////////////////////////////////////////////
    
    var price_low_val= parseInt( $('#price_low').val() );
    var price_max_val= parseInt( $('#price_max').val() );
 
    function getCookie(cname) {
       var name = cname + "=";
       var ca = document.cookie.split(';');
       for(var i=0; i<ca.length; i++) {
           var c = ca[i];
           while (c.charAt(0)==' ') c = c.substring(1);
           if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
       }
       return "";
   }


 
    var my_custom_curr_symbol  =   decodeURI ( getCookie('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( getCookie('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( getCookie('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   getCookie('my_custom_curr_cur_post');
 
    wpestate_enable_slider('slider_price', 'price_low', 'price_max', 'amount', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);
    $( "#slider_price" ).slider({
        stop: function( event, ui ) {
            if (typeof (show_pins) !== "undefined") {   
                first_time_wpestate_show_inpage_ajax_half=1
                show_pins(); 
            }
        }
    });
    wpestate_enable_slider('slider_price_sh', 'price_low_sh', 'price_max_sh', 'amount_sh', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef); 
    wpestate_enable_slider('slider_price_widget', 'price_low_widget', 'price_max_widget', 'amount_wd', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);
    wpestate_enable_slider('slider_price_mobile', 'price_low_mobile', 'price_max_mobile', 'amount_mobile', my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post,my_custom_curr_coef);


   
    function replace_plus(string){
        return string.replace("+"," ");
    }

    function wpestate_enable_slider(slider_name, price_low, price_max, amount, my_custom_curr_pos, my_custom_curr_symbol, my_custom_curr_cur_post, my_custom_curr_coef) {
        "use strict";
        var price_low_val, price_max_val, temp_min, temp_max, slider_min, slider_max;
        price_low_val = parseInt(jQuery('#'+price_low).val(), 10);
        price_max_val = parseInt(jQuery('#'+price_max).val(), 10);

  
        slider_min = control_vars.slider_min;
        slider_max = control_vars.slider_max;
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
            slider_min =slider_min *my_custom_curr_coef;
            slider_max =slider_max *my_custom_curr_coef;
        }
        
        jQuery("#" + slider_name).slider({
            range: true,
            min: parseFloat(slider_min),
            max: parseFloat(slider_max),
            values: [price_low_val, price_max_val ],
            slide: function (event, ui) {

                if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                    jQuery("#" + price_low).val(ui.values[0]);
                    jQuery("#" + price_max).val(ui.values[1]);

                    temp_min= ui.values[0] ;
                    temp_max= ui.values[1];

                    if (my_custom_curr_cur_post === 'before') {
                        jQuery("#" + amount).text( replace_plus( decodeURIComponent ( my_custom_curr_symbol ) ) + " " + temp_min.format() + " " + control_vars.to + " " + replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + temp_max.format());
                    } else {
                        jQuery("#" + amount).text(temp_min.format() + " " + replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) )+ " " + control_vars.to + " " + temp_max.format() + " " + replace_plus ( decodeURIComponent ( my_custom_curr_symbol ) ) );
                    }
                } else {
                    jQuery("#" + price_low).val(ui.values[0]);
                    jQuery("#" + price_max).val(ui.values[1]);

                    if (control_vars.where_curency === 'before') {
                        jQuery("#" + amount).text( replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + ui.values[0].format() + " " + control_vars.to + " " +  replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + ui.values[1].format());
                    } else {
                        jQuery("#" + amount).text(ui.values[0].format() + " " + replace_plus ( decodeURIComponent ( control_vars.curency ) ) + " " + control_vars.to + " " + ui.values[1].format() + " " + replace_plus ( decodeURIComponent ( control_vars.curency ) ) );
                    }
                }
            }
        });
    }


    
    ////////////////////////////////////////////////////////////////////////////
    /// print property page
    ////////////////////////////////////////////////////////////////////////////
      
    $('#print_page').click(function(event){
        var prop_id, myWindow, ajaxurl;
        ajaxurl      =   control_vars.admin_url+'admin-ajax.php'; 
        event.preventDefault();
   
        prop_id=$(this).attr('data-propid');
     
        myWindow=window.open('','Print Me','width=595 ,height=842');
        $.ajax({    
                type: 'POST',
                url: ajaxurl, 
            data: {
                'action'        :   'ajax_create_print',
                'propid'        :   prop_id, 
            },
            success:function(data) {  
               myWindow.document.write(data); 
                myWindow.document.close();
                myWindow.focus();
               // setTimeout(function(){
                  //myWindow.print();
               // }, 3000);
            //     myWindow.close();
            },
            error: function(errorThrown){
            }

        });//end ajax  var ajaxurl      =   control_vars.admin_url+'admin-ajax.php';     
    });
    
        

    ////////////////////////////////////////////////////////////////////////////
    /// save search actions
    ////////////////////////////////////////////////////////////////////////////
    
    
    $('#save_search_button').click(function(){
        var nonce, search, search_name, parent, ajaxurl;
        search_name     =   jQuery('#search_name').val();
        search          =   jQuery('#search_args').val();
        nonce           =   jQuery('#save_search_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        
        jQuery('#save_search_notice').html('saving...');
        
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   'wpestate_save_search_function',
                'search_name'   :   search_name,
                'search'        :   search,
                'nonce'         :   nonce
            },
            success: function (data) {
               
                jQuery('#save_search_notice').html(data);
                jQuery('#search_name').val('');
            },
            error: function (errorThrown) {
            }
        });
        
    });
    
    
    $('.delete_search').click(function(event){
        var  search_id, parent, ajaxurl,confirmtext;
        confirmtext = control_vars.deleteconfirm;
        
        if (confirm(confirmtext)) {       
            event.preventDefault();
            ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
            search_id       =   $(this).attr('data-searchid');
            parent          =   $(this).parent();
            $(this).html(control_vars.deleting);
          
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'        :   'wpestate_delete_search',
                    'search_id'     :   search_id
                },
                success: function (data) {
                  
                    if (data==='deleted'){
                        parent.remove();
                    }

                },
                error: function (errorThrown) {
                }
            });
            
       
        }
        
    });
    
    
    
    
    ////////////////////////////////////////////////////////////////////////////
    
    
    $('#adv_extended_options_text_adv ').click(function(){
        $('.adv-search-1.adv_extended_class').css('height','auto');
        $('.adv_extended_class .adv1-holder').css('height','auto');
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_adv').show();
    });
    
    $('#adv_extended_close_adv').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
        $('.adv-search-1.adv_extended_class').removeAttr('style');
        $('.adv_extended_class .adv1-holder').removeAttr('style');
    });
    
    
    //////////////////////////////////////////////////////////////
    
    $('#adv_extended_options_text_widget').click(function(){
      
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_widget').show();
    });
    
    $('#adv_extended_close_widget').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    
    ////////////////////////////////////////////////////////////////////////////////
       $('#adv_extended_options_text_short').click(function(){     
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_short').show();
    });
    
    $('#adv_extended_close_short').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    
    
    /////////////////////////////////////////////////////////////////////////////////////
    $('#adv_extended_options_text_mobile').click(function(){      
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_mobile').show();
    });
    
    $('#adv_extended_close_mobile').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    /////////////////////////////////////////////////////////////////////////////////////////
    
    
   
   
  
    
    $('#login_user_topbar,#login_pwd_topbar').on('focus', function(e) {
       $('#user_menu_open').addClass('iosfixed');
    });
     
     
     
    $('#estate-carousel .slider-content h3 a,#estate-carousel .slider-content .read_more ').click(function(){
      var new_link;
      new_link =  $(this).attr('href');
      window.open (new_link,'_self',false)
    });
     
     
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///city-area-selection
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    wpestate_filter_city_area('filter_city','filter_area');
    wpestate_filter_city_area('sidebar-adv-search-city','sidebar-adv-search-area');
    wpestate_filter_city_area('adv-search-city ','adv-search-area');
    wpestate_filter_city_area('half-adv-search-city ','half-adv-search-area');
    wpestate_filter_city_area('shortcode-adv-search-city','shortcode-adv-search-area');
    wpestate_filter_city_area('mobile-adv-search-city','mobile-adv-search-area');

  
        
   
    
    
    var all_browsers_stuff;
    
    $('#property_city_submit').change(function(){
        var city_value, area_value;
        city_value=$(this).val();
  
        all_browsers_stuff=$('#property_area_submit_hidden').html();
        $('#property_area_submit').empty().append(all_browsers_stuff);
        $('#property_area_submit option').each(function(){
            area_value=$(this).attr('data-parentcity');
          
            if( city_value ===area_value || area_value==='all'){
              //  $(this).show();        
            }else{
                //$(this).hide();
                 $(this).remove();
            }
        });
    })
    
     
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///mobile
    ///////////////////////////////////////////////////////////////////////////////////////////


    $('#adv-search-header-mobile').click(function(){
        $('#adv-search-mobile').fadeToggle('300');
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    ///navigational links
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('.nav-prev,.nav-next ').click(function(event){
        event.preventDefault();
        var link = $(this).find('a').attr('href');
        window.open (link,'_self',false)
    })

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featured agent
    ///////////////////////////////////////////////////////////////////////////////////////////
 
  
    $('.featured_agent_details_wrapper, .agent-listing-img-wrapper').click(function(){
        var newl= $( this ).attr('data-link');
        window.open (newl,'_self',false)
    });  
    
    $('.see_my_list_featured').click(function(event){
            event.stopPropagation();
    });
  
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featuerd property
    ///////////////////////////////////////////////////////////////////////////////////////////
    
    $('.featured_cover').click(function(){
        var newl= $( this ).attr('data-link');
        window.open (newl,'_self',false)
    }); 


    $( '.agent_face' ).hover(
        function() {
            $(this).find('.agent_face_details').fadeIn('500')
        }, function() {
            $(this).find('.agent_face_details').fadeOut('500')
        }
    );
        
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// listings unit navigation
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.property_listing, .agent_unit, .blog_unit , .featured_widget_image').click(function(){
        var link;
        link = $(this).attr('data-link'); 
        
        window.open(link, '_self');
    });

   

    $('.share_unit').click(function(event){
        event.stopPropagation();
    });

    $('.related_blog_unit_image').click(function(){
         var link;
        link = $(this).attr('data-related-link'); 
        window.open(link, '_self');
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// user menu
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('#user_menu_u').click(function(event){
        
        if( $('#user_menu_open').is(":visible")){
            $('#user_menu_open').removeClass('iosfixed').fadeOut(400); 
            $('.navicon-button').removeClass('opensvg');
        }else{
            $('#user_menu_open').fadeIn(400); 
            $('.navicon-button').addClass('opensvg');
        }     
        event.stopPropagation();
    });
    

    $(document).click(function(event) {

        var clicka  =   event.target.id;
        var clicka2 =   $(event.target).attr('share_unit');
        
        if ( !$('#'+clicka).parents('.topmenux').length) {
            $('#user_menu_open').removeClass('iosfixed').hide(400); 
            $('#user_menu_u .navicon-button').removeClass('open');
        }
        
        $('.share_unit').hide();
     
       
    });
  
      
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// new controls for upload pictures
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#imagelist i.fa-trash-o').click(function(){
          var curent='';  
          jQuery(this).parent().remove();

          jQuery('#imagelist .uploaded_images').each(function(){
             curent=curent+','+jQuery(this).attr('data-imageid'); 
          });
          jQuery('#attachid').val(curent); 

      });

    jQuery('#imagelist img').dblclick(function(){

        jQuery('#imagelist .uploaded_images .thumber').each(function(){
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>')
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });   

    
  
    
    
    $('#switch').click(function () {
        $('.main_wrapper').toggleClass('wide');
    });


    $('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features').on('shown.bs.collapse', function () {
        $(this).find('h4').removeClass('carusel_closed');
    })
    
    $('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features').on('hidden.bs.collapse', function () {
        $(this).find('h4').addClass('carusel_closed');
    })
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////    
 
    var elems = ['#adv-search-3', '#adv-search-1', '#advanced_search_shortcode', '#adv-search-2', '#advanced_search_shortcode_2', '.adv-search-mobile','.advanced_search_sidebar'];
 
    $.each( elems, function( i, elem ) {
      
        $(elem+' li').click(function (event) {
            event.preventDefault();
            var pick, value, parent,parent_replace;
            
            parent_replace='.filter_menu_trigger';
            if(elem === '.advanced_search_sidebar'){
                parent_replace='.sidebar_filter_menu';      
            }
            
            pick = $(this).text();
            value = $(this).attr('data-value');
            parent = $(this).parent().parent();  
            parent.find(parent_replace).text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
           parent.find('input').val(value);    
        });
    });
 
    
 
 
    jQuery('#adv-search-1 li, #adv-search-3 li, .halfsearch input[type="checkbox"]').click(function () {
         if (typeof (show_pins) !== "undefined") {    
            first_time_wpestate_show_inpage_ajax_half=1
            show_pins(); 
        }
    });

    jQuery('#adv_rooms, #adv_bath, #price_low, #price_max, #adv-search-1 input[type=text], #adv-search-3 input[type=text]').change(function () {        
        if (typeof (show_pins) !== "undefined") {   
            first_time_wpestate_show_inpage_ajax_half=1
            show_pins(); 
        }
       
    });

    function isFunction(possibleFunction) {
         return typeof(possibleFunction) === typeof(Function);
    }


    $('#showinpage,#showinpage_mobile').click(function (event) {
        event.preventDefault();
        wpestate_show_inpage_ajax();       
    });
    
    
    function wpestate_show_inpage_ajax(){
        if( $('#gmap-full').hasClass('spanselected')){
            $('#gmap-full').trigger('click');
        }
     
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        } 
    }
    

    /// ******************** end check
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////    

    $('#openmap').click(function(){
        
        if( $(this).find('i').hasClass('fa-angle-down') ){
            $(this).empty().append('<i class="fa fa-angle-up"></i>'+control_vars.close_map);
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
        }else{
            $(this).empty().append('<i class="fa fa-angle-down"></i>'+control_vars.open_map);
          
        }
        new_open_close_map(2);
     
    });
  
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// full screen map
    ////////////////////////////////////////////////////////////////////////////////////////////    
    var wrap_h;
    var map_h;
    
    $('#gmap-full').click(function(){

      
        if(  $('#gmap_wrapper').hasClass('fullmap') ){    
            $('#google_map_prop_list_wrapper').removeClass('fullhalf');

            $('#gmap_wrapper').removeClass('fullmap').css('height',wrap_h+'px');
            $('#googleMap').removeClass('fullmap').css('height',map_h+'px');
            $('.master_header ').removeClass('header_full_map');
            $('#search_wrapper').removeClass('fullscreen_search');
            $('#search_wrapper').removeClass('fullscreen_search_open');
            $('.nav_wrapper').removeClass('hidden');
             if(  !$('#google_map_prop_list_wrapper').length ){
                 $('.content_wrapper').show();
             }
            $('body,html').animate({
                 scrollTop: 0
            }, "slow");
            $('#openmap').show();
            $(this).empty().append('<i class="fa fa-arrows-alt"></i>'+control_vars.fullscreen).removeClass('spanselected');

            $('#google_map_prop_list_wrapper').removeClass('fullscreen');
            $('#google_map_prop_list_sidebar').removeClass('fullscreen');
        }else{
            $('#gmap_wrapper,#googleMap').css('height','100%').addClass('fullmap');
  
            $('#google_map_prop_list_wrapper').addClass('fullscreen');
            $('#google_map_prop_list_sidebar').addClass('fullscreen');




            $('#google_map_prop_list_wrapper').addClass('fullhalf');


            wrap_h=$('#gmap_wrapper').outerHeight();
            map_h=$('#googleMap').outerHeight();
          
            $('.master_header ').addClass('header_full_map');


            $('#search_wrapper').addClass('fullscreen_search');
            $('.nav_wrapper').addClass('hidden');
            if(  !$('#google_map_prop_list_wrapper').length ){
                $('.content_wrapper').hide();
            }

            $('#openmap').hide();
            $(this).empty().append('<i class="fa fa-square-o"></i>'+control_vars.default).addClass('spanselected');

        }
        
            google.maps.event.trigger(map, 'resize');
            google.maps.event.addListenerOnce(map, 'idle', function() {
                google.maps.event.trigger(map, 'resize');
            });
      
    });
  
    
    $('#street-view').click(function(){
         toggleStreetView();
    });
    
    
    
    $('#slider_enable_map').click(function(){
        var cur_lat, cur_long, myLatLng;
        
        $('#carousel-listing div').removeClass('slideron');
        $('.vertical-wrapper,.verticalstatus ').hide();
        $(this).addClass('slideron');
        
        $('#googleMapSlider').show();
        google.maps.event.trigger(map, "resize");
        map.setOptions({draggable: true});
        
        cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
    
        map.setCenter(myLatLng);
        map.panBy(10,-100);
       // map.setZoom(17);
        panorama.setVisible(false); 
        
       $('#gmapzoomminus.smallslidecontrol').show();
       $('#gmapzoomplus.smallslidecontrol').show();
    });
    
    $('#slider_enable_street').click(function(){
        var cur_lat, cur_long, myLatLng;
        
        $('#carousel-listing div').removeClass('slideron');
        $('.vertical-wrapper,.verticalstatus ').hide();
        $(this).addClass('slideron');
        
        cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
        $('#googleMapSlider').show();
        panorama.setPosition(myLatLng);
        panorama.setVisible(true); 
        $('#gmapzoomminus.smallslidecontrol').hide();
        $('#gmapzoomplus.smallslidecontrol').hide();

    });
  
    $('#slider_enable_slider').click(function(){
        $('#carousel-listing div').removeClass('slideron');
        $(this).addClass('slideron');
         $('.vertical-wrapper,.verticalstatus ').show();
        $('#googleMapSlider').hide();
        panorama.setVisible(false); 
        
        $('#gmapzoomminus.smallslidecontrol').hide();
        $('#gmapzoomplus.smallslidecontrol').hide();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////     caption-wrapper
    ///////////////////////////////////////////////////////////////////////////////////////////	       
  
    $('.caption-wrapper').click(function(){
        $(this).toggleClass('closed');   
        $('.carusel-back').toggleClass('rowclosed');
        $('.post-carusel .carousel-indicators').toggleClass('rowclosed');      
    });

    $('#carousel-listing').on('slid.bs.carousel', function () {
   
        if( $(this).hasClass('carouselvertical') ){
            show_capture_vertical();
        }else{
            show_capture();
        }
        $('#carousel-listing div').removeClass('slideron');
        $('#slider_enable_slider').addClass('slideron');
    })
    
    
    $('.carousel-round-indicators li').click(function(){
        $('.carousel-round-indicators li').removeClass('active');
        $(this).addClass('active');
    });
    
    $('.videoitem iframe').click(function(){
        $('.estate_video_control').remove();
    });
    ///////////////////////////////////////////////////////////////////////////////////////
    ////// Advanced search
    /////////////////////////////////////////////////////////////////////////////////////////

    adv_search_click();
 
    $('#adv-search-header-1').click(function(){
        if( document.getElementById("adv_extended_options_text_adv") !== null ) {
             $(this).parent().toggleClass('adv-search-1-close-extended');
        }else{
             $(this).parent().toggleClass('adv-search-1-close');
        }
    });
   
    $('#adv-search-header-3').click(function(){
        $(this).parent().parent().toggleClass(' search_wrapper-close-extended');
    });
    
    
  
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   tool tips on prop unit
    ///////////////////////////////////////////////////////////////////////////////////////////	       
  
    $( ".share_list, .icon-fav, .compare-action, .dashboad-tooltip").hover(
        function() {
            $( this ).tooltip('show') ;
        }, function() {
            $( this ).tooltip('hide');
        }
    );
        
     $('.share_list').click(function(event){
        event.stopPropagation();
        var sharediv=$(this).parent().find('.share_unit');
        sharediv.toggle();
        $(this).toggleClass('share_on');
     })
    

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   back to top
    ///////////////////////////////////////////////////////////////////////////////////////////	       
           
         
     $('.backtop').click(function(event){
         event.preventDefault();
  
         $('body,html').animate({
                scrollTop: 0
          }, "slow");

     })    
         
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    footer contact
    ///////////////////////////////////////////////////////////////////////////////////////////	       
         
    $('.contact-box ').click(function(event){
        event.preventDefault();
        $('.contactformwrapper').toggleClass('hidden');
        contact_footer_starter();
    });
         
   
         
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    add pretty photo
    ///////////////////////////////////////////////////////////////////////////////////////////	
    
 

    //$(" a[data-pretty='prettyPhoto']").prettyPhoto();
    $("a[rel^='prettyPhoto']").prettyPhoto();



    var mediaQuery = 'has_pretty_photo';
    if (Modernizr.mq('only screen and (max-width: 600px)') || Modernizr.mq('only screen and (max-height: 520px)')) {
        mediaQuery = 'no_pretty_photo';
       //$("a[data-pretty^='prettyPhoto']").unbind('click');
        $("a[rel^='prettyPhoto']").unbind('click');
    }

    //   pretty photo on / off
    mediaQuery = 'has_pretty_photo';

    if ((Modernizr.mq('only screen and (max-width: 600px)') || Modernizr.mq('only screen and (max-height: 520px)')) && mediaQuery === 'has_pretty_photo') {
       // jQuery("a[data-pretty='prettyPhoto']").unbind('click');
         jQuery("a[rel^='prettyPhoto']").unbind('click');
        mediaQuery = 'no_pretty_photo';
    } else if (!Modernizr.mq('only screen and (max-width: 600px)') && !Modernizr.mq('only screen and (max-height: 520px)') && mediaQuery === 'no_pretty_photo') {
        //$("a[data-pretty='prettyPhoto']").prettyPhoto();
          $("a[rel^='prettyPhoto']").prettyPhoto();
        mediaQuery = 'has_pretty_photo';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   widget morgage calculator
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#morg_compute').click(function() {
        
        var intPayPer  = 0;
        var intMthPay  = 0;
        var intMthInt  = 0;
        var intPerFin  = 0;
        var intAmtFin  = 0;
        var intIntRate = 0;
        var intAnnCost = 0;
        var intVal     = 0;
        var salePrice  = 0;

        salePrice = $('#sale_price').val();
        intPerFin = $('#percent_down').val() / 100;

        intAmtFin = salePrice - salePrice * intPerFin;
        intPayPer =  parseInt ($('#term_years').val(),10) * 12;
        intIntRate = parseFloat ($('#interest_rate').val(),10);
        intMthInt = intIntRate / (12 * 100);
        intVal = raisePower(1 + intMthInt, -intPayPer);
        intMthPay = intAmtFin * (intMthInt / (1 - intVal));
        intAnnCost = intMthPay * 12;

        $('#am_fin').html("<strong>"+control_vars.morg1+"</strong><br> " + (Math.round(intAmtFin * 100)) / 100 + " ");
        $('#morgage_pay').html("<strong>"+control_vars.morg2+"</strong><br> " + (Math.round(intMthPay * 100)) / 100 + " ");
        $('#anual_pay').html("<strong>"+control_vars.morg3+"</strong><br> " + (Math.round(intAnnCost * 100)) / 100 + " ");
        $('#morg_results').show();
        $('.mortgage_calculator_div').css('height',532+'px');
    });



    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Search widget
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#searchform input').focus(function(){
      $(this).val(''); 
    }).blur(function(){

    });
   
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// idx widget 
     /////////////////////////////////////////////////////////////////////////////////////////
     
     $('.dsidx-controls a').click(function(){
         sizeContent();         
     });
     
   
     ///////////////////////////////////////////////////////////////////////////////////////
     ////// Geolocation
     /////////////////////////////////////////////////////////////////////////////////////////
     
     $("#geolocation-button").hover(
            function () {
              $('#tooltip-geolocation').fadeIn();
              $('.tooltip').fadeOut("fast");
            },
            function () {
              $('#tooltip-geolocation').fadeOut();
            }
        );     
         

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// adding total for featured listings  
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.extra_featured').change(function(){
       var parent= $(this).parent();
       var price_regular  = parseFloat( parent.find('.submit-price-no').text(),10 );
       var price_featured = parseFloat( parent.find('.submit-price-featured').text(),10 );
       var total= price_regular+price_featured;

       if( $(this).is(':checked') ){
            parent.find('.submit-price-total').text(total);
            parent.find('#stripe_form_featured').show();
            parent.find('#stripe_form_simple').hide();
       }else{
           //substract from total
            parent.find('.submit-price-total').text(price_regular);
            parent.find('#stripe_form_featured').hide();
            parent.find('#stripe_form_simple').show();
       }
    });
  
  
     ///////////////////////////////////////////////////////////////////////////////////////////
    ///////  resise colums on compare page
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('.compare_wrapper').each(function() {
        var cols = $(this).find('.compare_item_head').length;
        $(this).addClass('compar-' + cols);
    });
    
    /////////////////////////////////////////////////////////////////////////////////////////
    /////// grid to list view
    ///////////////////////////////////////////////////////////////////////////////////////////


    $('#list_view').click(function(){
         $(this).toggleClass('icon_selected');
         $('#listing_ajax_container').addClass('ajax12');
         $('#grid_view').toggleClass('icon_selected');
        
         
         $('.listing_wrapper').hide().removeClass('col-md-4').removeClass('col-md-3').addClass('col-md-12').fadeIn(400) ;
         $('.the_grid_view').fadeOut(10,function() {
            $('.the_list_view').fadeIn(300);
         });       
     })
     
     $('#grid_view').click(function(){
         var class_type;
         class_type = $('.listing_wrapper:first-of-type').attr('data-org');
         $(this).toggleClass('icon_selected');
         $('#listing_ajax_container').removeClass('ajax12');
         $('#list_view').toggleClass('icon_selected');
         $('.listing_wrapper ').hide().removeClass('col-md-12').addClass('col-md-'+class_type).fadeIn(400); 
         $('.the_list_view').fadeOut(10,function(){
              $('.the_grid_view').fadeIn(300);
         });     
     })
     
     
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   compare action
    ///////////////////////////////////////////////////////////////////////////////////////////
    var already_in=[];
    $('.compare-action').click(function(e) {
    
        e.preventDefault();
        e.stopPropagation();
        $('.prop-compare').show();

        var post_id = $(this).attr('data-pid');
         for(var i = 0; i < already_in.length; i++) {
            if(already_in[i] === post_id) {
                return;
            }
        }
        
        already_in.push(post_id);
      
        
        var post_image = $(this).attr('data-pimage');

        var to_add = '<div class="items_compare" style="display:none;"><img src="' + post_image + '" alt="compare_thumb" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        $('div.items_compare:first-child').css('background', 'red');
        if (parseInt($('.items_compare').length,10) > 3) {
            $('.items_compare:first').remove();
        }
        $('#submit_compare').before(to_add);
        
        $('#submit_compare').click(function() {
            $('#form_compare').trigger('submit');
        })
    
        $('.items_compare').fadeIn(500);
    });

    $('#submit_compare').click(function() {
        $('#form_compare').trigger('submit');
    })
    
    
    
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// form upload
     /////////////////////////////////////////////////////////////////////////////////////////
       
    $('#form_submit_2,#form_submit_1 ').click(function(){
        var loading_modal;
        window.scrollTo(0, 0);
        loading_modal='<div class="modal fade" id="loadingmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit"><span>'+control_vars.addprop+'</div></div></div></div></div>';
        
        jQuery('body').append(loading_modal);
        jQuery('#loadingmodal').modal();
    });
       
       
       $('#add-new-image').click(function(){
           $('<p><label for="file">New Image:</label><input type="file" name="upload_attachment[]" id="file_featured"></p> ').appendTo('#files_area');
       })
       
       
       
       $('.delete_image').click(function(){
          var image_id=$(this).attr('data-imageid'); 
          
          var curent=$('#images_todelete').val(); 
        if(curent===''){
                 curent=image_id;
           }else{
                 curent=curent+','+image_id;
           }
         
          $('#images_todelete').val(curent) ;     
          $(this).parent().remove();              
      });
  
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// mouse over map tooltip
     /////////////////////////////////////////////////////////////////////////////////////////
       
    $('#googleMap').bind('mousemove', function(e){
       $('.tooltip').css({'top':e.pageY,'left':e.pageX, 'z-index':'1'});
    });

    setTimeout(function(){  $('.tooltip').fadeOut("fast");},10000);
});

////////////////// END ready

function wpestate_filter_city_area(selected_city,selected_area){
       
    jQuery('#'+selected_city+' li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( jQuery(this).attr('data-value2') ).toLowerCase();       

        jQuery('#'+selected_area+' li').each(function(){
            is_city = String ( jQuery(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
            area_value   = String ( jQuery(this).attr('data-value') ).toLowerCase();    
            if(is_city === value_city || value_city === 'all' ){
                jQuery(this).show();
            }else{
                jQuery(this).hide();
            }
        });
    });
}
    




function  show_capture_vertical(){
    "use strict";
   
    
    var position, slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt( jQuery('#carousel-listing .carousel-inner .active').index(),10);
    jQuery('#carousel-indicators-vertical  li').removeClass('active');
    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
   
    jQuery("#carousel-indicators-vertical  li[data-slide-to='"+position+"'] ").addClass('active');
    
    slideno=position+1;

    slidedif=slideno*84;
    

    if( slidedif > 336){
        tomove=336-slidedif;
        tomove=tomove;
        jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
    }else{
        position = jQuery('#carousel-indicators-vertical').css('top',tomove+"px").position();
        curentleft = position.top;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('#carousel-indicators-vertical').css('top',tomove+"px");
        }

    }
}

function show_capture(){
    "use strict";
    var position, slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt( jQuery('#carousel-listing .carousel-inner .active').index(),10);
    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery('#carousel-listing  .carousel-round-indicators li').removeClass('active');
    
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .carousel-round-indicators li[data-slide-to='"+position+"'] ").addClass('active');
    slideno=position+1;

    slidedif=slideno*146;
    if( slidedif > 810){
        tomove=810-slidedif;
        jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
    }else{
        position = jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px").position();
        curentleft = position.left;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
        }

    }
        
}

 function raisePower(x, y) {
        return Math.pow(x, y);
} 
    
function shortcode_google_map_load(containermap, lat, long, mapid){
    "use strict";    
  
    var myCenter = new google.maps.LatLng(lat, long);
    var mapOptions = {
             flat:false,
             noClear:false,
             zoom: 15,
             scrollwheel: false,
             draggable: true,
             center: myCenter,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
             streetViewControl:false,
             mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP]
            },
            disableDefaultUI: true
           };
           
    map = new google.maps.Map(document.getElementById(mapid), mapOptions);
    google.maps.visualRefresh = true;
    
    var marker=new google.maps.Marker({
       position: myCenter,
             map: map
    });

    marker.setMap(map);

}

function adv_search_click(){
   jQuery('#adv-search-header-1').click(function(){
        jQuery('#search_wrapper').toggleClass('fullscreen_search_open');
   });
   
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// Contact footer
///////////////////////////////////////////////////////////////////////////////////////////
function contact_footer_starter(){
    jQuery('#btn-cont-submit').click(function () {
        var contact_name, contact_email, contact_phone, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   jQuery('#foot_contact_name').val();
        contact_email   =   jQuery('#foot_contact_email').val();
        contact_phone   =   jQuery('#foot_contact_phone').val();
        contact_coment  =   jQuery('#foot_contact_content').val();
        nonce           =   jQuery('#contact_footer_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_contact_form_footer',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'contact_coment'   :   contact_coment,
                'propid'    :   property_id,
                'nonce'     :   nonce
            },
            success: function (data) {
         
                if (data.sent) {
                    jQuery('#foot_contact_name').val('');
                    jQuery('#foot_contact_email').val('');
                    jQuery('#foot_contact_phone').val('');
                    jQuery('#foot_contact_content').val('');
                }
                jQuery('#footer_alert-agent-contact').empty().append(data.response);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
    });
}



function filter_invoices(){
    "use strict";
    var ajaxurl, start_date, end_date, type, status;
    start_date  = jQuery('#invoice_start_date').val();
    end_date    = jQuery('#invoice_end_date').val();
    type        = jQuery('#invoice_type').val();
    status      = jQuery('#invoice_status').val();
    
    ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'        :   'wpestate_ajax_filter_invoices',
            'start_date'    :   start_date,
            'end_date'      :   end_date,
            'type'          :   type,
            'status'        :   status
        },
        success: function (data) {
         
            jQuery('#container-invoices').empty().append(data.results);
            jQuery('#invoice_confirmed').empty().append(data.invoice_confirmed);
            //enable_invoice_actions();
    
        },
        
        error: function (errorThrown) {
       
        }
    });//end ajax
}