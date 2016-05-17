/*global $, jQuery, document, window */

jQuery(document).ready(function ($) {
    "use strict";
    
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase lsitings
    ///////////////////////////////////////////////////////////////////////////////
    $('#save_prop_design').click(function(){
        var acesta,content,sidebar_right,sidebar_left;
        
        content = $('#property_page_content').html();
       // content ='';
        sidebar_right=$('#property_page_sidebar_right').html();
        sidebar_left=$('#property_page_sidebar_left').html();
        
        
        acesta=$(this);
        acesta.empty().text('salvam....');
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
            data: {
                'action'        :   'wpestate_save_property_page_design',
                'content'       :   content,
                'sidebar_right' :   sidebar_right,
                'sidebar_left'  :   sidebar_left
               

            },
            success: function (data) {  
                acesta.empty().text('saved....');
            },
            error: function (errorThrown) {}
        });//end ajax  
        
        
    })
    
    
    
    $('#activate_pack_listing').click(function(){
        var item_id, invoice_id,ajaxurl,type;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        type        = $(this).attr('data-type');
        ajaxurl     =   admin_control_vars.ajaxurl;
    
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase_listing',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id,
            'type'          :   type
           
        },
        success: function (data) {  
            jQuery("#activate_pack_listing").remove();
            jQuery("#invnotpaid").remove(); 
          
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });
    
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase
    ///////////////////////////////////////////////////////////////////////////////
    
     $('#activate_pack').click(function(){
        var item_id, invoice_id,ajaxurl;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        ajaxurl     =   admin_control_vars.ajaxurl;
    
    
      
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id
           
        },
        success: function (data) {   
            jQuery("#activate_pack").remove();
            jQuery("#invnotpaid").remove(); 
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });
    
    
    
    
    
    
    
    
    
    ///////////////////////////////////////////////////////////////////////////////
    /// upload custom image on page - jslint checked
    ///////////////////////////////////////////////////////////////////////////////
    var formfield, imgurl;
    $('#page_custom_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    $('.deleter_floor').click(function(){
       $(this).parent().remove();
        
    });
   
     jQuery(".floorbuttons").click(function () {
                        var parent = jQuery(this).parent();
                        formfield  = parent.find("#plan_image").attr("name");
                        tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
                        window.send_to_editor = function (html) {

                            imgurl = jQuery("img", html).attr("src");
                            var theid = jQuery("img", html).attr("class");
                          
                            var thenum = theid.match(/\d+$/)[0];
                            
                            parent.find("#plan_image").val(imgurl);
                            parent.find("#plan_image_attach").val(thenum);
                            tb_remove();
                        };
                        return false;
                    });
    
    $('#add_new_plan').click(function () {
        var to_insert;
      
        to_insert='<div class="plan_row"><p class="meta-options floor_p">\n\
                <label for="plan_title">'+admin_control_vars.plan_title+'</label><br />\n\
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />\n\
            </p>\n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_description">'+admin_control_vars.plan_desc+'</label><br /> \n\
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea> \n\
            </p>\n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_image">'+admin_control_vars.plan_image+'</label><br /> \n\
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="" /> \n\
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="Upload Image" /> \n\
                <input type="hidden" id="plan_image_attach" name="plan_image_attach[]" value="">\n\
            </p> \n\
             \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_size">'+admin_control_vars.plan_size+'</label><br /> \n\
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="" /> \n\
            </p> \n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_rooms">'+admin_control_vars.plan_rooms+'</label><br /> \n\
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_bath">'+admin_control_vars.plan_bathrooms+'</label><br /> \n\
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_price">'+admin_control_vars.plan_price+'</label><br /> \n\
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="" /> \n\
            </p> \n\
    </div>';
        
        $('#plan_wrapper').append(to_insert);
        
        $('.floorbuttons').unbind('click');
        
        
        
        $('.floorbuttons').click(function () {
            var parent = $(this).parent();
            formfield  = parent.find('#plan_image').attr('name');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            window.send_to_editor = function (html) {
                
               imgurl = $('img', html).attr('src');
               var theid = $('img', html).attr('class');
               var thenum = theid.match(/\d+$/)[0];
       
                parent.find('#plan_image').val(imgurl);
                parent.find('#plan_image_attach').val(thenum);
                tb_remove();
            };
            return false;
        });
        
        //alert('plan'); 
    });
    
});
