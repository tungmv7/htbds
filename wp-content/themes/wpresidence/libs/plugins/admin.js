
jQuery(document).ready(function($) {
    
     
    $('.activate_template').click(function(){
        console.log('start import');
        var ajaxurl, base_template, parent;
        base_template   =   $(this).attr('data-baseid');
        ajaxurl         =   ajax_upload_demo_vars.admin_url + 'admin-ajax.php';
        parent          =   $(this).parent();
        $(this).parent().find('.importing_mess').empty().text('Importing Translate....');
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'             :   'wpestate_start_demo_import',
                'base_template'      :   base_template,
                
            },
            success: function (data) { 
           
                console.log(data);  
                parent.find('.importing_mess').empty().text('DONE - translate');
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });//end ajax     
        
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


