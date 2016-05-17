wpestate_set_theme_tab_visible();
jQuery(document).ready(function($) {
    estate_create_columns();
    var picked_col;

    
    
   /* $(".prop_page_design_el" ).draggable({ 
            grid: [ 30, 30 ],
            containment: "#property_page_content", 
            scroll: false ,
            revert: true
        });
     */   
    $(".delete_design_el").show().click(function(){
        var acest_del;
        acest_del=$(this).parent().remove();
    });
        
    $('.prop_page_design_el_modal').click(function(){
        var tip, to_add;
        tip = $(this).attr('data-tip');
        to_add='<div class="design_element_col" data-tip="'+tip+'">'+tip+'</div>';
        picked_col.append(to_add);
        picked_col.parent().css('height','auto');
        $('#modal_el_pick').hide();
    });  
        
        
    $('#property_page_tools li').draggable({
        helper: function(e) {
            var col_controls 
            col_controls = '<div class="prop-col-control-wrapper"><div class="prop-col-control" data-separation="1/2+1/2">1/2</div>';
            col_controls += '<div class="prop-col-control" data-separation="1/3+1/3+1/3">1/3</div>';
            col_controls += '<div class="prop-col-control" data-separation="1/4+1/4+1/4+1/4">1/4</div>';
            col_controls += '<div class="prop-col-control" data-separation="1/3+2/3">1/3 b</div>';
            
            col_controls += '</div>';
            
            var to_append='<div class="col-prop-12 prop-columns">'+Math.random() +'<div class="add_prop_design_element">+</div></div><div class="delete_design_el" ></div>';
            return $('<div>').addClass('prop_full_width').append(to_append).append(col_controls);
        },
        connectToSortable: "#property_page_content"
    });
    
    
    function estate_create_columns(){
        $('.add_prop_design_element').unbind('click');
        $('.add_prop_design_element').click(function(){
            picked_col=$(this).parent();
            $('#modal_el_pick').show();
        });
        
        
        
        
        $('.prop-col-control').unbind('click');
        $('.prop-col-control').click(function(){
            var acesta          = $(this);
            var parent          = acesta.parent().parent();
            var separation_data = $(this).attr('data-separation');
            var myArray         = separation_data.split('+');
            var temp='';
            var to_append='';
            console.log(myArray);
            
            parent.find('.prop-columns').remove();
            for(var i=0;i<myArray.length;i++){
                temp = $.trim(myArray[i]);
                if(temp!==''){
                    if(temp==='1/2'){
                        to_append='<div class="col-prop-6 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='1/3'){
                        to_append='<div class="col-prop-4 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='1/4'){
                        to_append='<div class="col-prop-3 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='2/3'){
                        to_append='<div class="col-prop-8 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='2/4'){
                        to_append='<div class="col-prop-6 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='3/4'){
                        to_append='<div class="col-prop-9 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }else if(temp==='1/1'){
                        to_append='<div class="col-prop-12 prop-columns"><div class="add_prop_design_element">+</div></div>';
                    }
                    parent.append(to_append);
                }
            }
        });  
        
    }
    
    
    
    $('#property_page_content').sortable({
        placeholder: 'block-placeholder',
        update: function (event, ui) {
            // turn the dragged item into a "block"
            ui.item.addClass('block');
            estate_create_columns();
            update_sortable_content();
        }
    });


    function update_sortable_content(){
      
    }


    //initilize_actions_property_page_design();
        
  /*  $( "#property_page_content,#property_page_sidebar_right,#property_page_sidebar_left" ).droppable({
        drop: function( event, ui ) {
           
            if ( ui.draggable.hasClass('original_el') ){
                var new_element = ui.draggable.clone();
                var new_top= parseInt( ui.draggable.css("top"),10 ) -240;
                new_element.removeClass('original_el').removeClass('prop_page_design_el').css('left','30px').css('top',new_top+"px");
                    new_element.find('.delete_design_el').show().click(function(){
                        var acest_del;
                        acest_del=$(this).parent().remove();
                    });
                
                new_element.draggable({ 
                    grid: [ 30, 30 ],
                    containment: "#property_page_content", 
                    scroll: false ,
                    revert: false
                });    
                
                if ( new_element.hasClass('prop_row') ){
                    new_element.addClass('prop_full_width');
                    new_element.draggable( "option", "axis", "y" );
                } 
                
                
            
                
            }
            
            
            
            
            
            $(this).append(new_element);
           
        }
    });*/
         

    
    
    function initilize_actions_property_page_design(){
       
     /*    $(".prop_full_width").draggable({ 
            grid: [ 30, 30 ],
            containment: "#property_page_content", 
            scroll: false ,
            revert: false,
            axis:"y"
        });
        
        $(".delete_design_el").show().click(function(){
            var acest_del;
            acest_del=$(this).parent().remove();
        });
    */
       // $( "#property_page_content" ).sortable();
       // $( "#property_page_content" ).disableSelection(); 
        
    }
         
    
    
    
    
    
    
    $('#modal_el_pick_close').click(function(){
       $('#modal_el_pick').hide();
        
    });
    
    
    
    
    
    
    $('#property_page_design_sidebar').change(function(event){
        event.preventDefault();
        var new_sidebar_value = $(this).val();
        
        if(new_sidebar_value==='1'){
            $('#property_page_content').removeClass('full_page');
            $('#property_page_sidebar_right').show();
            $('#property_page_sidebar_left').hide();
            console.log('1');
            
        } else if(new_sidebar_value==='2') {
            $('#property_page_sidebar_right').hide();
            $('#property_page_sidebar_left').show();
            $('#property_page_content').removeClass('full_page');
            console.log('2');
        
        }else{
            $('#property_page_sidebar_right').hide();
            $('#property_page_sidebar_left').hide();
            $('#property_page_content').addClass('full_page');
            console.log('3 no');
        }
        
        
    });
    
    
    
    
   
    
    
    
    
    
    
    
    
    
    // theme interface
    estate_activate_template_action();
    wpestate_theme_options_sidebar();
    
   // localStorage.setItem('hidden_tab','');
    //localStorage.setItem('hidden_sidebar','');
      
    $('.admin_top_bar_button').click(function(event){
        event.preventDefault();
        var selected = $(this).attr('data-menu');
        var autoselect='';
        
        $('.admin_top_bar_button').removeClass('tobpbar_selected_option');
        $(this).addClass('tobpbar_selected_option');
        
        $('.theme_options_sidebar, .theme_options_wrapper_tab,.theme_options_tab').hide();
        $('#'+selected).show();
        $('#'+selected+'_tab').show();
        $('#'+selected+'_tab .theme_options_tab:eq(0)').show();
      
      
        localStorage.setItem('hidden_tab',selected);
        
        
        $('#'+selected+' li:eq(0)').addClass('selected_option');
        autoselect =  $('#'+selected+' li:eq(0)').attr('data-optiontab');
     
        localStorage.setItem('hidden_sidebar',autoselect);
        wpestate_theme_options_sidebar();
    });
     
     
   
    
     
    $('#wpestate_sidebar_menu li').click(function(event){
        event.preventDefault();
        $('#wpestate_sidebar_menu li').removeClass('selected_option');
        $(this).addClass('selected_option');
        
        var selected = $(this).attr('data-optiontab');
      
        $('.theme_options_tab').hide();
        $('#'+selected).show();
        $('#hidden_sidebar').val(selected);
        
       
        localStorage.setItem('hidden_sidebar',selected);
        wpestate_theme_options_sidebar();
                
    });
     
     
     

    
    
    
    
    $( '.wpestate-megamenu-background-image' ).css( 'display', 'block' );
    $( ".wpestate-megamenu-background-image[src='']" ).css( 'display', 'none' );
    
    
    $('.edit-menu-item-wpestate-megamenu-check').click(function(){
        var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

        if( $( this ).is( ':checked' ) ) {
                parent_li_item.addClass( 'wpestate-megamenu' );
        } else 	{
                parent_li_item.removeClass( 'wpestate-megamenu' );
        }
        update_megamenu_fields();
    });
    
    
    $('.load_back_menu').click(function(e){
        e.preventDefault();
        var parent = $(this).parent().parent();
        var item_id = this.id.replace('wpestate-media-upload-', '');
        
        formfield  = parent.find('#category_featured_image').attr('name');
        
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            parent.find('#edit-menu-item-megamenu-background-'+item_id).val(imgurl);
            parent.find( '#wpestate-media-img-'+item_id ).attr( 'src', imgurl ).css( 'display', 'block' );
            var theid = $('img', html).attr('class');
            var thenum = theid.match(/\d+$/)[0];
            parent.find('#category_attach_id').val(thenum);
            tb_remove();
        };
        return false;
        
        
                              
    });

    
    $('.remove-megamenu-background').click(function(e){
        var  item_id = this.id.replace( 'wpestate-media-remove-', '' );
        $( '#edit-menu-item-megamenu-background-'+item_id ).val( '' );
        $( '#wpestate-media-img-'+item_id ).attr( 'src', '' ).css( 'display', 'none' );
    });
    
    
    
    function update_megamenu_fields() {
        var menu_li_items = $( '.menu-item');

        menu_li_items.each( function( i ) 	{

                var megamenu_status = $( '.edit-menu-item-wpestate-megamenu-check', this );

                if( ! $( this ).is( '.menu-item-depth-0' ) ) {
                        var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );


                        if( check_against.is( '.wpestate-megamenu' ) ) {

                                megamenu_status.attr( 'checked', 'checked' );
                                $( this ).addClass( 'wpestate-megamenu' );
                        } else {
                                megamenu_status.attr( 'checked', '' );
                                $( this ).removeClass( 'wpestate-megamenu' );
                        }
                } else {
                        if( megamenu_status.attr( 'checked' ) ) {
                                $( this ).addClass( 'wpestate-megamenu' );
                        }
                }
        });
    }
    
    
    
    
 $('.category_featured_image_button').click(function () {
        var parent = $(this).parent();
        formfield  = parent.find('#category_featured_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            parent.find('#category_featured_image').val(imgurl);
            var theid = $('img', html).attr('class');
            var thenum = theid.match(/\d+$/)[0];
            parent.find('#category_attach_id').val(thenum);
            tb_remove();
        };
        return false;
    });
    
 ///////////////////////////////////////////////////////////////////////////////
 /// add new membership
 ///////////////////////////////////////////////////////////////////////////////
    
    $('#new_membership').click(function(){
       var new_row=$('#sample_member_row').html();
       
       new_row='<div class="memebership_row">'+new_row+'</div>';
       $('#new_membership').before(new_row); 
        
    });
        
    
    
    $('.remove_pack').click(function(){
        
        $(this).parent().remove();
        
    });
    
    
    
    
    
    
 ///////////////////////////////////////////////////////////////////////////////
 /// pin upload
 ///////////////////////////////////////////////////////////////////////////////
    
    $('.pin-upload').click(function() {
      
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
         var formfield=$(this).prev();
	 
        window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 formfield.val(imgurl);
		 tb_remove();
	}
           
    return false;
    });
     
    
 ///////////////////////////////////////////////////////////////////////////////
 /// upload header
 ///////////////////////////////////////////////////////////////////////////////
$('#global_header_button').click(function() {
	 formfield = $('#global_header').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#global_header').val(imgurl);
		 tb_remove();
	}

 return false;
});

///////////////////////////////////////////////////////////////////////////////
/// upload footer
///////////////////////////////////////////////////////////////////////////////
$('#footer_background_button').click(function() {
	 formfield = $('#footer_background').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#footer_background').val(imgurl);
		 tb_remove();
	}

 return false;
});

    
 ///////////////////////////////////////////////////////////////////////////////
 /// upload logo
 ///////////////////////////////////////////////////////////////////////////////
$('#logo_image_button').click(function() {
	 formfield = $('#logo_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#logo_image').val(imgurl);
		 tb_remove();
	}

 return false;
});


///////////////////////////////////////////////////////////////////////////////
/// mobile logo
///////////////////////////////////////////////////////////////////////////////
$('#mobile_logo_image_button').click(function() {
	 formfield = $('#mobile_logo_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#mobile_logo_image').val(imgurl);
		 tb_remove();
	}

 return false;
});


 ///////////////////////////////////////////////////////////////////////////////
 /// upload fotoer logo
 ///////////////////////////////////////////////////////////////////////////////

$('#footer_logo_image_button').click(function() {
	 formfield = $('#footer_logo_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#footer_logo_image').val(imgurl);
		 tb_remove();
	}

 return false;
});

// upload favicon
$('#favicon_image_button').click(function() {
	 formfield = $('#favicon_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	
		
	 window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#favicon_image').val(imgurl);
		 tb_remove();
	 }
 return false;
});


// upload contact image
$('#company_contact_image_button').click(function() {
	 formfield = $('#company_contact_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	
		
	 window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#company_contact_image').val(imgurl);
		 tb_remove();
	 }
 return false;
});


//upload image background
$('#background_image_button').click(function() {
	 formfield = $('#background_image').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');	
	
	window.send_to_editor = function(html) {
		 imgurl = $('img',html).attr('src');
		 $('#background_image').val(imgurl);
		 tb_remove();
	}
 return false;
});



// function for tab management
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}




	
if ($(".admin_menu_list")[0]){	//if is our custom admin page
    
    // admin tab controls
fullUrl=getUrlVars()["page"];
tab=(fullUrl.split("#"));
pick=tab[1];
	
if(typeof tab[1] === 'undefined'){
	pick="tab1";
}

	
$(".tabadmin").each(function(){		
	if ($(this).attr("data-tab")==pick){
		$(this).addClass("active");
	}else{
		$(this).removeClass("active")
	}	
})
	
	
$(".admin_menu_list li").each(function(){		
	if ($(this).attr("rel")==pick){
		$(this).addClass("active");
	}else{
		$(this).removeClass("active")
	}	
});    
    
 }	
 


//admin color changes
var my_colors = ['main_color','background_color','content_back_color','header_color','breadcrumbs_back_color','menu_items_color','breadcrumbs_font_color','font_color','link_color','headings_color','comments_font_color','coment_back_color','footer_back_color','footer_font_color','footer_copy_color','sidebar_widget_color','sidebar_heading_boxed_color','sidebar_heading_color','sidebar2_font_color','menu_font_color','menu_hover_back_color','menu_hover_font_color','agent_color','listings_color','blog_color','dotted_line','footer_top_band','top_bar_back','top_bar_font','adv_search_back_color','adv_search_font_color','box_content_back_color','box_content_border_color','hover_button_color'];

for ( k in my_colors ) {
        eval("$('#" + my_colors[k] + "' ).ColorPicker({ onChange: function (hsb, hex, rgb) {$('#" + my_colors[k] + " .sqcolor').css('background-color', '#' + hex);$('[name=" + my_colors[k] + "]' ).val( hex );}});");			
}

    

        
function clearimg(){
	$('#tabpat img').each(function(){
	$(this).css('border','none');
	})	
};

	
});


jQuery(document).ready(function($) {

	$('input[id^="item-custom"]').click(function() {
          
	    formfieldx = "edit-menu-"+$(this).attr("id");
		
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

		 window.send_to_editor = function(html) {
			 imgurl = jQuery('img',html).attr('src');
			 jQuery("#"+formfieldx).val(imgurl);
			 tb_remove();
		}
	 return false;
	});
});


function wpestate_theme_options_sidebar(){
    var new_height;
    new_height = jQuery ('#wpestate_wrapper_admin_menu').height();
    jQuery ('#wpestate_sidebar_menu').height(new_height)
    
}

function wpestate_set_theme_tab_visible(){
    //   var show_tab = jQuery('#hidden_tab').val();
   // var show_sidebar = jQuery('#hidden_sidebar').val();
   
    var show_tab        =   localStorage.getItem('hidden_tab');
    var show_sidebar    =   localStorage.getItem('hidden_sidebar');
   
    // console.log ("show_tab "+show_tab+" / show_sidebar "+show_sidebar + ' / ' +typeof(show_tab));
    
    if(show_tab===null || show_tab===''){
        show_tab = 'general_settings_sidebar';
    }
    
    if(show_sidebar=== null || show_sidebar==''){
        show_sidebar = 'global_settings_tab';
    }
    
    //console.log ("show_tab "+show_tab+" / show_sidebar "+show_sidebar);
  
    if(show_tab!=='none'){
     
        jQuery('.theme_options_sidebar, .theme_options_wrapper_tab').hide();
        jQuery('#'+show_tab).show();
        jQuery('#'+show_tab+'_tab').show();
        jQuery('.wrap-topbar div').removeClass('tobpbar_selected_option');
        jQuery('.wrap-topbar div[data-menu="'+show_tab+'"]').addClass('tobpbar_selected_option');
    }


    if(show_sidebar!=='none'){
       
        jQuery('.theme_options_tab').hide();
        jQuery('#'+show_sidebar).show();
        jQuery('#wpestate_sidebar_menu li').removeClass('selected_option');
        jQuery('#wpestate_sidebar_menu li[data-optiontab="'+show_sidebar+'"]').addClass('selected_option');
        
    }
 
}


function    estate_activate_template_action(){ 
    jQuery('.activate_template').click(function(){
        console.log('start import');
        var ajaxurl, base_template, parent;
        base_template   =   jQuery(this).attr('data-baseid');
        ajaxurl         =   ajax_upload_demo_vars.admin_url + 'admin-ajax.php';
        parent          =   jQuery(this).parent();
        jQuery(this).parent().find('.importing_mess').empty().text(ajax_upload_demo_vars.importing);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'             :   'wpestate_start_demo_import',
                'base_template'      :   base_template,
                
            },
            success: function (data) { 
           
               // console.log(data);  
                parent.find('.importing_mess').empty().text(ajax_upload_demo_vars.complete);
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });//end ajax     
        
    });
}