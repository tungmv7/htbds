/*global $, jQuery, ajaxcalls_vars, document, control_vars, window, control_vars*/
///////////////////////////////////////////////////////////////////////////////////////////



function wpestate_load_stats_tabs(listing_id) {
    "use strict";
    var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_load_stats_property',
            'postid'            :   listing_id
        },
        success: function (data) {  
            wpestate_show_prop_stat_graph_tab (data.array_values , data.labels,listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax     
}

function wpestate_show_prop_stat_graph_tab(values,labels ,listing_id){
    var ctx         =   jQuery("#myChartacc").get(0).getContext('2d');
    var myNewChart  =   new Chart(ctx);
   
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: values
        },
    ]
    };
    
    var options = {
       //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
       scaleBeginAtZero : true,

       //Boolean - Whether grid lines are shown across the chart
       scaleShowGridLines : true,

       //String - Colour of the grid lines
       scaleGridLineColor : "rgba(0,0,0,.05)",

       //Number - Width of the grid lines
       scaleGridLineWidth : 1,

       //Boolean - Whether to show horizontal lines (except X axis)
       scaleShowHorizontalLines: true,

       //Boolean - Whether to show vertical lines (except Y axis)
       scaleShowVerticalLines: true,

       //Boolean - If there is a stroke on each bar
       barShowStroke : true,

       //Number - Pixel width of the bar stroke
       barStrokeWidth : 2,

       //Number - Spacing between each of the X value sets
       barValueSpacing : 5,

       //Number - Spacing between data sets within X values
       barDatasetSpacing : 1,

       //String - A legend template
       legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    }
 
    var myBarChart = new Chart(ctx).Bar(data, options);
}



function wpestate_load_stats(listing_id) {
    "use strict";
    var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_load_stats_property',
            'postid'            :   listing_id
        },
        success: function (data) {  
            wpestate_show_prop_stat_graph (data.array_values , data.labels,listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax     
}

function wpestate_show_prop_stat_graph(values,labels ,listing_id){
    var ctx         =   jQuery("#myChart_"+listing_id).get(0).getContext('2d');
    var myNewChart  =   new Chart(ctx);
   
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: values
        },
    ]
    };
    
    var options = {
       //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
       scaleBeginAtZero : true,

       //Boolean - Whether grid lines are shown across the chart
       scaleShowGridLines : true,

       //String - Colour of the grid lines
       scaleGridLineColor : "rgba(0,0,0,.05)",

       //Number - Width of the grid lines
       scaleGridLineWidth : 1,

       //Boolean - Whether to show horizontal lines (except X axis)
       scaleShowHorizontalLines: true,

       //Boolean - Whether to show vertical lines (except Y axis)
       scaleShowVerticalLines: true,

       //Boolean - If there is a stroke on each bar
       barShowStroke : true,

       //Number - Pixel width of the bar stroke
       barStrokeWidth : 2,

       //Number - Spacing between each of the X value sets
       barValueSpacing : 5,

       //Number - Spacing between data sets within X values
       barDatasetSpacing : 1,

       //String - A legend template
       legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    }
 
    var myBarChart = new Chart(ctx).Bar(data, options);
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function get_filtering_ajax_result() {
    "use strict";

    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';



    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'get_filtering_ajax_result',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'postid'            :   postid
        },
        success: function (data) {     
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data); 
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_get_filtering_ajax_result() {
    "use strict";

    var  newpage, halfmap, val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl, postid, slider_min, slider_max, all_checkers;
    newpage =0;
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);
 
    
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    slider_min  =   parseFloat ( jQuery('#price_low').val() );
    slider_max  =   parseFloat ( jQuery('#price_max').val() );
    
    halfmap    = 0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    } 
    
    all_checkers = '';
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'custom_adv_get_filtering_ajax_result',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'slider_min'        :   slider_min,
            'slider_max'        :   slider_max,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers
        },
        success: function (data) {  
            
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data); 
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering_ajax(newpage) {
    "use strict";
        
    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid,halfmap, all_checkers;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    
    halfmap    = 0;
  
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    
    all_checkers = '';
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
    halfmap    = 0;
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
    
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_filter_listings_search',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers
        },
        success: function (data) {      
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.pagination_nojax').hide();
            jQuery('#listing_ajax_container').empty().append(data);
        
            restart_js_after_ajax();
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}



function typeof_value(val1, slug){
    "use strict";

    if( typeof(val1)!=="undefined"){
        if( !jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
         
            if(slug !== 'adv_categ' && slug !== 'adv_actions' &&  
                slug !== 'advanced_city' &&  slug !== 'advanced_area'  &&  
                slug !== 'county-state' && slug !== 'property-country'   ){
                val1=val1;
              
            }  else{
                val1=val1.replace("-"," ");
            }
        }
        
    }else{
        val1='';
    }
    return val1;
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_search_start_filtering_ajax(newpage) {
    "use strict";
    var   val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl,postid , slider_min, slider_max, halfmap, all_checkers;
    
      console.log('custom_search_start_filtering_ajax');
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);

   
    val1= typeof_value(val1,mapfunctions_vars.slugs[0]);
    val2= typeof_value(val2,mapfunctions_vars.slugs[1]);
    
    val3= typeof_value(val3,mapfunctions_vars.slugs[2]);
    val4= typeof_value(val4,mapfunctions_vars.slugs[3]);
    
    val5= typeof_value(val5,mapfunctions_vars.slugs[4]);
    val6= typeof_value(val6,mapfunctions_vars.slugs[5]);
    
    val7= typeof_value(val7,mapfunctions_vars.slugs[6]);
    val8= typeof_value(val8,mapfunctions_vars.slugs[7]);    
   
    
    
    

            
    //console.log("val1:"+val1+" val2:"+val2+" val3:"+val3+" val4:"+val4+" val5:"+val5);
    //console.log("val6:"+val6+" val7:"+val7+" val8:"+val8);
   
    
    slider_min  = parseFloat ( jQuery('#price_low').val() );
    slider_max  = parseFloat ( jQuery('#price_max').val() );
     
    all_checkers = '';
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
 
    halfmap    = 0;
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
 
 
    //console.log("val1:"+val1+" val2:"+val2+" val3:"+val3+" val4:"+val4+" val5:"+val5);
    //console.log("val6:"+val6+" val7:"+val7+" val8:"+val8);
   
 
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_custom_adv_ajax_filter_listings_search',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'slider_min'        :   slider_min,
            'slider_max'        :   slider_max,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers
        },
        success: function (data) {  
         //   console.log(data);
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.entry-title.title_prop').hide();
            jQuery('#listing_ajax_container').empty().append(data);
            restart_js_after_ajax();
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}





////////////////////////////////////////////////////////////////////////////////////////////
/// redo js after ajax calls - jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function restart_js_after_ajax() {
    "use strict";
    wpestate_lazy_load_carousel_property_unit();
    // enable_half_map_pin_action();
    if (typeof enable_half_map_pin_action == 'function'){
        enable_half_map_pin_action();
    }
    var newpage, post_id, post_image, to_add, icon;
    
    jQuery('.prop-compare:first-of-type').remove();
    
    
    jQuery('.pagination_ajax_search a').click(function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering_ajax(newpage);
    });

    jQuery('.pagination_ajax a').click(function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering(newpage);
    });
    
    jQuery('.property_listing').click(function(){
        var link;
        link = jQuery(this).attr('data-link'); 
        window.open(link, '_self');
    });
   
    jQuery('.share_unit').click(function(event){
        event.stopPropagation();
    });
   
    var already_in=[];
    jQuery('.compare-action').unbind('click');
    jQuery('.compare-action').click(function (e) {
        
        e.preventDefault();
        e.stopPropagation();
        jQuery('.prop-compare').show();

        post_id = jQuery(this).attr('data-pid');
        
     
         for(var i = 0; i < already_in.length; i++) {
            if(already_in[i] === post_id) {
                return;
            }
        }
        
        already_in.push(post_id); 
        post_image = jQuery(this).attr('data-pimage');

        to_add = '<div class="items_compare ajax_compare" style="display:none;"><img src="' + post_image + '" alt="compare_thumb" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        jQuery('div.items_compare:first-child').css('background', 'red');
        if (parseInt(jQuery('.items_compare').length, 10) > 3) {
            jQuery('.items_compare:first').remove();
        }
        jQuery('#submit_compare').before(to_add);
        jQuery('.items_compare').fadeIn(800);
    });

    jQuery('#submit_compare').unbind('click');
    jQuery('#submit_compare').click(function () {
        jQuery('#form_compare').trigger('submit');
    });
    
    jQuery('.icon-fav').click(function (event) {
        event.stopPropagation();
        icon = jQuery(this);
        add_remove_favorite(icon);
    });
   
    jQuery(".share_list, .icon-fav, .compare-action").hover(
        function () {
            jQuery(this).tooltip('show');
        },
        function () {
            jQuery(this).tooltip('hide');
    });
       
    jQuery('.share_list').click(function (event) {
        event.stopPropagation();
        var sharediv = jQuery(this).parent().find('.share_unit');
        sharediv.toggle();
        jQuery(this).toggleClass('share_on');
    });
    
  
}

////////////////////////////////////////////////////////////////////////////////////////////
/// add remove from favorite-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function add_remove_favorite(icon) {
    "use strict";
    var post_id, securitypass, ajaxurl;
    post_id         =  icon.attr('data-postid');
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
  
    if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
        show_login_form();
    } else {
        icon.toggleClass('icon-fav-off');
        icon.toggleClass('icon-fav-on');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
              data: {
                  'action'            :   'wpestate_ajax_add_fav',
                  'post_id'           :   post_id
                  },
           success: function (data) {          
               if (data.added) {
                    icon.removeClass('icon-fav-off').addClass('icon-fav-on');
               } else {
                    icon.removeClass('icon-fav-on').addClass('icon-fav-off');
               }
           },
           error: function (errorThrown) {

           }
         });//end ajax
    }// end login use
} 

////////////////////////////////////////////////////////////////////////////////////////////
/// resend listing for approval-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function resend_for_approval(prop_id, selected_div) {
    "use strict";
    var ajaxurl, normal_list_no;
    ajaxurl   =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_resend_for_approval',
            'propid'        :   prop_id
        },
        success: function (data) {
            if (data === 'pending') {
                selected_div.parent().empty().append('<span class="featured_prop">Sent for approval</span>');
                normal_list_no    =  parseInt(jQuery('#normal_list_no').text(), 10);
                jQuery('#normal_list_no').text(normal_list_no - 1);
            } else {
                selected_div.parent().empty().append(data);
            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// make property featured-jslint checked
//////////////////////////////////////////////////////////////////////////////////////////// 
function make_prop_featured(prop_id, selectedspan) {
    "use strict";
    var ajaxurl      =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_make_prop_featured',
            'propid'        :   prop_id
        },
        success: function (data) {
            
           
            if (data.trim() === 'done') {
                selectedspan.empty().html('<span class="label label-success">'+ajaxcalls_vars.prop_featured+'</span>');
                var featured_list_no = parseInt(jQuery('#featured_list_no').text(), 10);
                jQuery('#featured_list_no').text(featured_list_no - 1);
            } else {
                selectedspan.empty().removeClass('make_featured').addClass('featured_exp').text(ajaxcalls_vars.no_prop_featured);
            }

        },
        error: function (errorThrown) {
        }

    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal recuring-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function recuring_pay_pack_via_paypal() {
    "use strict";
    var ajaxurl, packName, packId;
    ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
    packName     =   jQuery('#pack_select :selected').text();
    packId       =   jQuery('#pack_select :selected').val();

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_paypal_pack_recuring_generation',
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {      
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax    
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function pay_pack_via_paypal() {
    "use strict";
    var  ajaxurl, packName, packId;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
    packName    =   jQuery('#pack_select :selected').text();
    packId      =   jQuery('#pack_select :selected').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_paypal_pack_generation',
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax

}
////////////////////////////////////////////////////////////////////////////////////////////
/// listing pay -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function listing_pay(prop_id, selected_div, is_featured, is_upgrade) {
    "use strict";
    var ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_listing_pay',
            'propid'        :   prop_id,
            'is_featured'   :   is_featured,
            'is_upgrade'    :   is_upgrade
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// start filtering -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering(newpage) {
    "use strict";
    jQuery('#grid_view').addClass('icon_selected');
    jQuery('#list_view').removeClass('icon_selected');
    var action, category, city, area, order, ajaxurl,page_id;
    // get action vars
    action = jQuery('#a_filter_action').attr('data-value');
    // get category
    category = jQuery('#a_filter_categ').attr('data-value');
    // get city
    city = jQuery('#a_filter_cities').attr('data-value');
    // get area
    area = jQuery('#a_filter_areas').attr('data-value');
    // get order
    order = jQuery('#a_filter_order').attr('data-value');
    ajaxurl =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    page_id =   jQuery('#page_idx').val();
    
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
 
 

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_filter_listings',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'order'             :   order,
            'newpage'           :   newpage,
            'page_id'           :   page_id
        },
        success: function (data) {
            jQuery('#listing_loader').hide();
            jQuery('#listing_ajax_container').empty().append(data);
            jQuery('.pagination_nojax').hide();
            restart_js_after_ajax();

        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// show login form on fav login-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function show_login_form() {
    "use strict";
    var  ajaxurl    =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'    :   'wpestate_ajax_show_login_form'
        },
        success: function (data) {
            jQuery('body').append(data);
            jQuery('#loginmodal').modal();
            enable_actions_modal();
        },
        error: function (errorThrown) {
        }
    }); //end ajax

}

////////////////////////////////////////////////////////////////////////////////////////////
/// change pass on profile-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_change_pass_profile() {
    "use strict";
    var oldpass, newpass, renewpass, securitypass, ajaxurl;
    oldpass         =  jQuery('#oldpass').val();
    newpass         =  jQuery('#newpass').val();
    renewpass       =  jQuery('#renewpass').val();
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_update_pass',
            'oldpass'           :   oldpass,
            'newpass'           :   newpass,
            'renewpass'         :   renewpass,
            'security-pass'     :   securitypass
        },
        success: function (data) {
            jQuery('#profile_pass').empty().append('<div class="login-alert">' + data + '<div>');
            jQuery('#oldpass, #newpass, #renewpass').val('');
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// user register -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////

function wpestate_register_user(type) {
    "use strict";
    var user_login_register, user_email_register, user_pass, user_pass_retype, nonce, ajaxurl;
    /* 1- topbar
     * 2- widget
     * 3- shortcode
     * 4- modal !?
     * 5 -mobile
     */
    
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php'; 
    jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">'+control_vars.procesing+'</div>');
    
    if(type===1){
        user_login_register =  jQuery('#user_login_register_topbar').val();
        user_email_register =  jQuery('#user_email_register_topbar').val();
        nonce               =  jQuery('#security-register-topbar').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_topbar').val();
            user_pass_retype    =  jQuery('#user_password_topbar_retype').val();
        }
        
        if ( !jQuery('#user_terms_register_topbar').is(":checked") ) {
            jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }else if(type===2){
        user_login_register =  jQuery('#user_login_register_wd').val();
        user_email_register =  jQuery('#user_email_register_wd').val();
        nonce               =  jQuery('#security-register').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_wd').val();
            user_pass_retype    =  jQuery('#user_password_wd_retype').val();
        }
        
        if ( !jQuery('#user_terms_register_wd').is(":checked") ) {
            jQuery('#register_message_area_wd').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }else if(type===3){
        user_login_register =  jQuery('#user_login_register').val();
        user_email_register =  jQuery('#user_email_register').val();
        nonce               =  jQuery('#security-register').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password').val();
            user_pass_retype    =  jQuery('#user_password_retype').val();
        }
       
        if ( !jQuery('#user_terms_register_sh').is(":checked") ) {
            jQuery('#register_message_area').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }else if(type===5){
       
        user_login_register =  jQuery('#user_login_register_mobile').val();
        user_email_register =  jQuery('#user_email_register_mobile').val();
        nonce               =  jQuery('#security-register-mobile').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_mobile').val();
            user_pass_retype    =  jQuery('#user_password_mobile_retype').val();
        }
        
        if ( !jQuery('#user_terms_register_mobile').is(":checked") ) {
            jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }
    
 
  

     
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'                    :   'wpestate_ajax_register_user',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'type'                      :   type,
            'security-register'         :   nonce
        },

        success: function (data) {
           // This outputs the result of the ajax request
         
            if(type===1){
                jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_topbar').val('');
                jQuery('#user_email_register_topbar').val('');
                jQuery('#user_password_topbar').val('');
                jQuery('#user_password_topbar_retype').val('');
            }else  if(type===2){
                jQuery('#register_message_area_wd').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_wd').val('');
                jQuery('#user_email_register_wd').val('');
                jQuery('#user_password_wd').val('');
                jQuery('#user_password_wd_retype').val('');
            }else  if(type===3){
                jQuery('#register_message_area').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register').val('');
                jQuery('#user_email_register').val('');
                jQuery('#user_password').val('');
                jQuery('#user_password_retype').val('');
            }else  if(type===5){
                jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_mobile').val('');
                jQuery('#user_email_register_mobile').val('');
                jQuery('#user_password_mobile').val('');
                jQuery('#user_password_mobile_retype').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}





////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_forgot(type) {
    "use strict";
   
    var  forgot_email, securityforgot, postid, ajaxurl;
    if(type===1){
        forgot_email          =  jQuery('#forgot_email').val();
        securityforgot        =  jQuery('#security-forgot').val();
    }
    if(type===2){
        forgot_email          =  jQuery('#forgot_email_topbar').val();
        securityforgot        =  jQuery('#security-forgot-topbar').val();
    }
    if(type===3){
        forgot_email          =  jQuery('#forgot_email_shortcode').val();
        securityforgot        =  jQuery('#security-login-forgot_wd').val();
    }
    if(type===5){
        forgot_email          =  jQuery('#forgot_email_mobile').val();
        securityforgot        =  jQuery('#security-forgot-mobile').val();
    }
    
    postid                =  jQuery('#postid').val();
    ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_forgot_pass',
            'forgot_email'      :   forgot_email,
            'security-forgot'    :   securityforgot,
            'postid'            :   postid,
            'type'              :   type
        },

        success: function (data) {
        
            if(type===1){
                jQuery('#forgot_email').val('');
                jQuery('#forgot_pass_area').empty().append('<div class="login-alert">' + data + '<div>');        
            }
            if(type===2){
                jQuery('#forgot_email_topbar').val('');
                jQuery('#forgot_pass_area_topbar').empty().append('<div class="login-alert">' + data + '<div>');        
            }
            if(type===3){
                jQuery('#forgot_email_shortcode').val('');
                jQuery('#forgot_pass_area_shortcode').empty().append('<div class="login-alert">' + data + '<div>');        
            }
            if(type===5){
                jQuery('#forgot_email_mobile').val('');
                jQuery('#forgot_pass_area_mobile').empty().append('<div class="login-alert">' + data + '<div>');        
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_wd() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_wd').val();
    login_pwd           =  jQuery('#login_pwd_wd').val();
    security            =  jQuery('#security-login').val();
    ispop               =  jQuery('#loginpop_wd').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security
        },

        success: function (data) {
            jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#ajax_login_container').remove();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
          
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_topbar() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_topbar').val();
    login_pwd           =  jQuery('#login_pwd_topbar').val();
    security            =  jQuery('#security-login-topbar').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form_topbar',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'security'          :   security
        },

        success: function (data) {
          
            jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
         
        }
    });
}


function wpestate_login_mobile() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_mobile').val();
    login_pwd           =  jQuery('#login_pwd_mobile').val();
    security            =  jQuery('#security-login-mobile').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_mobile').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form_mobile',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'security'          :   security
        },

        success: function (data) {
     
            jQuery('#login_message_area_mobile').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
            } else {
                jQuery('#login_user_mobile').val('');
                jQuery('#login_pwd_mobile').val('');
            }
        },
        error: function (errorThrown) {
           
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
// enable actions modal -jslint checked
////////////////////////////////////////////////////////////////////////////////
function enable_actions_modal() {
    "use strict";
    jQuery('#facebooklogin').click(function () {
        jQuery('#cover').hide();
        login_via_facebook(jQuery(this));
    });

    jQuery('#googlelogin,#yahoologin').click(function () {
        jQuery('#cover').hide();
        login_via_google(jQuery(this));
    });

    jQuery('#closeadvancedlogin').click(function () {
        jQuery('#ajax_login_container').remove();
        jQuery('#cover').remove();
    });

    jQuery('#reveal_register').click(function () {
        jQuery('#ajax_login_div').fadeOut(400, function () {
            jQuery('#ajax_register_div').fadeIn();
        });
    });

    jQuery('#reveal_login').click(function () {
        jQuery('#ajax_register_div').fadeOut(400, function () {
            jQuery('#ajax_login_div').fadeIn();
        });
    });


    jQuery('#wp-login-but').click(function () {
        wpestate_login();
    });

    jQuery('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });


    jQuery('#wp-submit-register').click(function () {
        wpestate_register_user(3);
    });

    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(3);
        }
    });
}


////////////////////////////////////////////////////////////////////////////////
// login function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_login() {
    "use strict";
    var login_user, login_pwd, security, ispop, ajaxurl;
    login_user          =  jQuery('#login_user').val();
    login_pwd           =  jQuery('#login_pwd').val();
    security            =  jQuery('#security-login').val();
    ispop               =  jQuery('#loginpop').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security
        },
        success: function (data) {
            jQuery('#login_message_area').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
                   
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#loginmodal').modal('hide');
                    update_menu_bar(data.newuser);
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
// login via facebook-jslint checked
////////////////////////////////////////////////////////////////////////////////    
function login_via_facebook(button) {
    "use strict";
    var login_type, ajaxurl;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
    login_type  =   'facebook';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_facebook_login',
            'login_type'        :   login_type
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////
function login_via_google(button) {
    "use strict";
    var ajaxurl, login_type;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';
    login_type      =  button.attr('data-social');

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login',
            'login_type'        :   login_type
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}
////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////

function login_via_google_oauth() {
    "use strict";
    var ajaxurl, login_type;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login_oauth'
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// update bar after login -jslint checked
////////////////////////////////////////////////////////////////////////////////
function update_menu_bar(newuser) {
    "use strict";
    var usericon, ajaxurl;
    ajaxurl =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   "wpestate_update_menu_bar",
            'newuser'           :    newuser
        },
        success: function (data) {
      
            jQuery('#user_menu_open').empty().append(data.menu).addClass('menulist');
            usericon = '<div class="menu_user_picture" style="background-image: url(' + data.picture + ')"></div>';
            jQuery('#user_menu_u').append(usericon).addClass('user_loged');
            jQuery('.submit_action').remove();
            
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    "use strict";
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
   $('.disable_listing').click(function () {
        var prop_id     =   $(this).attr('data-postid');
        var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var is_disabled =   0;
        if ( $(this).hasClass('disabledx') ){
            is_disabled=1;
            $(this).removeClass('disabledx');
        }else{
              $(this).addClass('disabledx');
        }
        var element = $(this);
        
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'       :   'wpestate_disable_listing',
                'prop_id'      :   prop_id,
               
            },
            success: function (data) {
                //location.reload();
                if (is_disabled===1){
                    element.empty().append('<i class="fa fa-play"></i>');
                  
                    element.tooltip('hide')
                    .attr('data-original-title', ajaxcalls_vars.enablelisting)
                    .tooltip('fixTitle')
                    .tooltip('show');
  
                }else{
                    element.empty().append('<i class="fa fa-pause"></i>');
                 
                    element.tooltip('hide')
                    .attr('data-original-title', ajaxcalls_vars.disablelisting)
                    .tooltip('fixTitle')
                    .tooltip('show');
                }
               
                
            },
            error: function (errorThrown) {
            }
        });
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#stripe_cancel').click(function(){
        var stripe_user_id, ajaxurl;
        stripe_user_id    =   $(this).attr('data-stripeid');
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $('#stripe_cancel').text(ajaxcalls_vars.saving);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'                  :   'wpestate_cancel_stripe',
                'stripe_customer_id'      :   stripe_user_id,
               
            },
            success: function (data) {
                $('#stripe_cancel').text(ajaxcalls_vars.stripecancel);
            },
            error: function (errorThrown) {
            }
        });
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    /// resend for approval  
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.resend_pending').click(function () {
        var prop_id = $(this).attr('data-listingid');
        resend_for_approval(prop_id, $(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  set featured inside membership
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.make_featured').click(function () {
        var prop_id = $(this).attr('data-postid');
        make_prop_featured(prop_id, $(this));
        $(this).unbind( "click" );
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  pack upgrade via paypal    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('#pick_pack').click(function () {
        var pay_paypal;
        pay_paypal='<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">'+ajaxcalls_vars.paypal+'</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();
            
            
        if ($('#pack_recuring').is(':checked')) {
            recuring_pay_pack_via_paypal();
        } else {
            pay_pack_via_paypal();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// listing pay via paypal
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.listing_submit_normal').click(function () {
        var prop_id, featured_checker, is_featured, is_upgrade,pay_paypal;
        pay_paypal='<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">'+ajaxcalls_vars.paypal+'</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();
        
        
        prop_id = $(this).attr('data-listingid');
        featured_checker = $(this).parent().find('input');
        is_featured = 0;
        is_upgrade = 0;

        if (featured_checker.prop('checked')) {
            is_featured = 1;
        } else {
            is_featured = 0;
        }

        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });


    $('.listing_upgrade').click(function () {
        var is_upgrade, is_featured, prop_id;
        is_upgrade = 1;
        is_featured = 0;
        prop_id = $(this).attr('data-listingid');
        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login via facebook conect    
    ///////////////////////////////////////////////////////////////////////////////////////////  

    $('#facebooklogin, #facebookloginsidebar, #facebookloginsidebar_topbar,#facebookloginsidebar_mobile').click(function () {
        login_via_facebook($(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  open id login - via google
    //////////////////////////////////////////////////////////////////////////////////////////// 

    $('#yahoologin, #aollogin,  #yahoologinsidebar, #yahoologinsidebar_topbar,#yahoologinsidebar_mobile').click(function () {
        login_via_google($(this));
    });

  $('#googlelogin, #googleloginsidebar, #googleloginsidebar_topbar,#googleloginsidebar_mobile').click(function () {
        login_via_google_oauth();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Property page  + ajax call on contact
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#agent_submit').click(function () {
        var contact_name, contact_email, contact_phone, contact_coment, agent_id, property_id, nonce, ajaxurl;
        contact_name    =   $('#agent_contact_name').val();
        contact_email   =   $('#agent_user_email').val();
        contact_phone   =   $('#agent_phone').val();
        contact_coment  =   $('#agent_comment').val();
        agent_id        =   $('#agent_id').val();
        property_id     =   $('#agent_property_id').val();
        nonce           =   $('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        
        $('#alert-agent-contact').empty().append(ajaxcalls_vars.sending);
// 
        $.ajax({
            type: 'POST',
            dataType: 'json',
           url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_agent_contact_form',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'comment'   :   contact_coment,
                'agent_id'  :   agent_id,
                'propid'    :   property_id,
                'nonce'     :   nonce
            },
            success: function (data) {
               // This outputs the result of the ajax request
                //console.log(data);
                if (data.sent) {
                    $('#agent_contact_name').val('');
                    $('#agent_user_email').val('');
                    $('#agent_phone').val('');
                    $('#agent_comment').val('');
                }
                $('#alert-agent-contact').empty().append(data.response);
            },
            error: function (errorThrown) {
                 console.log(errorThrown);
   
            }
        });
    });

    

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  property listing listing
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.listing_filters_head li').click(function () {
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
        parent.find('input:hidden'). val(value);
       
        start_filtering(1);
        
       
        show_pins_filters_from_file();       
    });
    
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filtering
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.adv_listing_filters_head li').click(function () {

        var pick, value, parent, args,page_id,ajaxurl;
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        pick        = $(this).text();
        value       = $(this).attr('data-value');
        parent      = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
        args        = $('#searcharg').val();
        page_id     = $('#page_idx').val();
        $('#listing_ajax_container').empty();
        $('#listing_loader').show();
        
        $.ajax({
                type: 'POST',
                url: ajaxurl,
              
                data: {
                    'action'    :   'wpestate_advanced_search_filters',
                    'args'      :   args,
                    'value'     :   value,
                    'page_id'   :   page_id
                },
                success: function (data) {
               
                    $('#listing_loader').hide();
                    $('#listing_ajax_container').append(data);
                    restart_js_after_ajax();
                },
                error: function (errorThrown) {
                }
            }); //end ajax
    });



    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on listing
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('.icon-fav').click(function (event) {
        event.stopPropagation();
        var icon = $(this);
        add_remove_favorite(icon);
    });

    // remove from fav listing on user profile
    $('.icon-fav-on-remove').click(function (event) {
        event.stopPropagation();
        $(this).parent().parent().remove();
        
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on propr
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('#add_favorites').click(function () {
        var post_id, securitypass, ajaxurl;
        post_id         =  $('#add_favorites').attr('data-postid');
        securitypass    =  $('#security-pass').val();
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

        if (parseInt(ajaxcalls_vars.userid, 10)  === 0) {
            show_login_form();
        } else {
            $('#add_favorites').text(ajaxcalls_vars.saving);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action'            :   'wpestate_ajax_add_fav',
                    'post_id'           :    post_id
                },
                success: function (data) {
                    if (data.added) {
                        $('#add_favorites').text(ajaxcalls_vars.favorite).removeClass('isnotfavorite').addClass('isfavorite');
                    } else {
                        $('#add_favorites').text(ajaxcalls_vars.add_favorite).removeClass('isfavorite').addClass('isnotfavorite');
                    }
                },
                error: function (errorThrown) {
                }
            }); //end ajax
        }// end check login
    });


    ////////////////////////////////////////////////////////////////////////////////
    // register calls and functions
    ////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register').click(function () {
        wpestate_register_user(3);
    });

    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(3);
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_wd').click(function () {
        wpestate_register_user(2);
    });

    $('#user_email_register_wd, #user_login_register_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(2);
        }
    });
   
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  TOPBAR Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_topbar').click(function () {
        wpestate_register_user(1);
    });

    $('#user_email_register_topbar, #user_login_register_topbar, #user_password_topbar, #user_password_topbar_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(1);
        }
    });
    
     $('#wp-submit-register_mobile').click(function () {
        wpestate_register_user(5);
    });

    $('#user_email_register_mobile, #user_login_register_mobile, #user_password_mobile, #user_password_mobile_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(5);
        }
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////  
    $('#forgot_pass').click(function (event) {
        event.preventDefault();
        $("#login-div").hide();
        $("#forgot-pass-div-sh").show();
    });

    $('#return_login').click(function (event) {
        event.preventDefault();
        $("#forgot-pass-div-sh").hide();
        $("#login-div").show();
    });


    $('#forgot_pass_topbar').click(function (event) {
        event.preventDefault();
        $("#login-div_topbar,#login-div-title-topbar").hide();
        $("#forgot-div-title-topbar,#forgot-pass-div").show();
    });


    $('#forgot_pass_mobile').click(function (event) {
        event.preventDefault();
        $("#login-div_mobile,#login-div-title-mobile").hide();
        $("#forgot-div-title-mobile,#forgot-pass-div").show();
    });


    $('#return_login_topbar').click(function (event) {
        event.preventDefault();
        $("#forgot-div-title-topbar,#forgot-pass-div").hide();
        $("#login-div_topbar,#login-div-title-topbar").show();
    });

    $('#return_login_mobile').click(function (event) {
        event.preventDefault();
        $("#forgot-div-title-mobile,#forgot-pass-div").hide();
        $("#login-div_mobile,#login-div-title-mobile").show();
    });

    $('#forgot_pass_widget').click(function (event) {
        event.preventDefault();
        $("#login-div-title,#login-div").hide();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").show();
    });

    $('#return_login_shortcode').click(function (event) {
        event.preventDefault();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").hide();
        $("#login-div-title,#login-div").show();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  forgot pass  
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-forgot-but').click(function () {
        wpestate_forgot(1);
    });
    
    $('#wp-forgot-but-topbar').click(function () {
        wpestate_forgot(2);
    });
     
    $('#wp-forgot-but-mobile').click(function () {
        wpestate_forgot(5);
    });
    
    
    $('#wp-forgot-but_shortcode').click(function () {
        wpestate_forgot(3);
    });
    

    $('#forgot_email').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(1);
        }
    });

    $('#forgot_email_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(2);
        }
    });
    
    $('#forgot_email_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(3);
        }
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// TOPBAR  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_topbar').click(function (event) {
        event.preventDefault();
        $('#login-div_topbar').hide();
        $('#register-div-topbar').show();
        $('#login-div-title-topbar').hide();
        $('#register-div-title-topbar').show();
    });

    $('#widget_login_topbar').click(function (event) {
        event.preventDefault();
        $('#login-div_topbar').show();
        $('#register-div-topbar').hide();
        $('#login-div-title-topbar').show();
        $('#register-div-title-topbar').hide();
    });
    
    $('#widget_register_mobile').click(function (event) {
        event.preventDefault();
        $('#login-div_mobile').hide();
        $('#register-div-mobile').show();
        $('#login-div-title-mobile').hide();
        $('#register-div-title-mobile').show();
    });

    $('#widget_login_mobile').click(function (event) {
        event.preventDefault();
        $('#login-div_mobile').show();
        $('#register-div-mobile').hide();
        $('#login-div-title-mobile').show();
        $('#register-div-title-mobile').hide();
    });
    
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// WIDGET  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #login-div').hide();
        $('.loginwd_sidebar #register-div').show();
        $('.loginwd_sidebar #login-div-title').hide();
        $('.loginwd_sidebar #register-div-title').show();
    });

    $('#widget_login_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #register-div').hide();
        $('.loginwd_sidebar #login-div').show();
        $('.loginwd_sidebar #register-div-title').hide();
        $('.loginwd_sidebar #login-div-title').show();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but').click(function () {
        wpestate_login();
    });

    $('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-wd').click(function () {
        wpestate_login_wd();
    });

    $('#login_pwd_wd, #login_user_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_wd();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  TOPBAR  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-topbar').click(function () {
        wpestate_login_topbar();
    });

    $('#login_pwd_topbar, #login_user_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_topbar();
        }
    });

    $('#wp-login-but-mobile').click(function () {
        wpestate_login_mobile();
    });

    $('#login_pwd_mobile, #login_user_mobile').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_mobile();
        }
    });
    

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax update password
    //////////////////////////////////////////////////////////////////////////////////////////// 
    $('#oldpass, #newpass, #renewpass').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_change_pass_profile();
        }
    });

    $('#change_pass').click(function () {
        wpestate_change_pass_profile();
    });
  
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  update profile
    ////////////////////////////////////////////////////////////////////////////////////////////   

    $('#update_profile').click(function () {
        var  userurl,usermobile, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        firstname       =  $('#firstname').val();
        secondname      =  $('#secondname').val();
        useremail       =  $('#useremail').val();
        userphone       =  $('#userphone').val();
        usermobile      =  $('#usermobile').val();
        userskype       =  $('#userskype').val();
        usertitle       =  $('#usertitle').val();
        description     =  $('#about_me').val();
        userfacebook    =  $('#userfacebook').val();
        usertwitter     =  $('#usertwitter').val();
        userlinkedin    =  $('#userlinkedin').val();
        userpinterest   =  $('#userpinterest').val();
        userurl         =  $('#website').val();
        
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        securityprofile =  $('#security-profile').val();
        upload_picture  =  $('#upload_picture').val();
        profile_image_url  = $('#profile-image').attr('data-profileurl');
        profile_image_url_small  = $('#profile-image').attr('data-smallprofileurl');
       

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_ajax_update_profile',
                'firstname'         :   firstname,
                'secondname'        :   secondname,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'usertitle'         :   usertitle,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
                'userurl'           :   userurl
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
            },
            error: function (errorThrown) {
            }
        });
    });

    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('#profile_message').attr({value: e.loaded, max: e.total});
        }
    }

}); // end ready jquery
//End ready ********************************************************************