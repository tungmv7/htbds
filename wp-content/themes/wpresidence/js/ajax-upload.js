 ///////////////////////////////////////////////////////////////////////////////////////////  
  ////////  profile uploader
  ////////////////////////////////////////////////////////////////////////////////////////////   
  jQuery(document).ready(function($) {
     "use strict";
  
      if (typeof(plupload) !== 'undefined') {
            var uploader = new plupload.Uploader(ajax_vars.plupload);
            uploader.init();
            uploader.bind('FilesAdded', function (up, files) {
               
                $.each(files, function (i, file) {
                    
                    $('#aaiu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                        '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );   
                up.refresh(); // Reposition Flash/Silverlight
            });



            uploader.bind('FileUploaded', function (up, file, response) {
        
               
                var result = $.parseJSON(response.response);
                 
            
                $('#image_warn').remove();
                $('#' + file.id).remove();
                if (result.success) {               
                   
                    $('#profile-image').attr('src',result.html);
                    $('#profile-image').attr('data-profileurl',result.html);
                    $('#profile-image').attr('data-smallprofileurl',result.attach);
                    
                    var all_id=$('#attachid').val();
                    all_id=all_id+","+result.attach;
                    $('#attachid').val(all_id);
                            
                    if (result.html!==''){
                        if(ajax_vars.is_floor === '1'){
                            $('#no_plan_mess').remove();
                            $('#imagelist').append('<div class="uploaded_images floor_container" data-imageid="'+result.attach+'"><input type="hidden" name="plan_image_attach[]" value="'+result.attach+'"><input type="hidden" name="plan_image[]" value="'+result.html+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i>'+to_insert_floor+'</div>');
                    
                        }else{
                            $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                        }
                        
                    }else{
                        $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+ajax_vars.path+'/img/pdf.png" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                    
                    }
                    $( "#imagelist" ).sortable({
                        revert: true,
                        update: function( event, ui ) {
                            var all_id,new_id;
                            all_id="";
                            $( "#imagelist .uploaded_images" ).each(function(){
                                
                                new_id = $(this).attr('data-imageid'); 
                                if (typeof new_id != 'undefined') {
                                    all_id=all_id+","+new_id; 
                                   
                                }
                               
                            });
                          
                            $('#attachid').val(all_id);
                        },
                    });
 
                       
                    delete_binder();
                    thumb_setter();
                }else{
                    
                    if (result.image){ 
                        $('#imagelist').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_vars.warning+'</div>');
                    }
                }
            });

     
            $('#aaiu-uploader').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                uploader.start();
            });
            
            $('#aaiu-uploader2').click(function (e) {
                uploader.start();
                e.preventDefault();
            });
                  
            $('#aaiu-uploader-floor').click(function (e) {
                e.preventDefault();
                $('#aaiu-uploader').trigger('click');
            });      
                     
 }
 
 });
 function thumb_setter(){
  
    jQuery('#imagelist img').dblclick(function(){
    
        jQuery('#imagelist .uploaded_images .thumber').each(function(){
     
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>')
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });   
 }
 
 
 
 function delete_binder(){
      jQuery('#imagelist i.fa-trash-o').click(function(){
          var curent='';  
          jQuery(this).parent().remove();
          
          jQuery('#imagelist .uploaded_images').each(function(){
             curent=curent+','+jQuery(this).attr('data-imageid'); 
          });
          jQuery('#attachid').val(curent); 
          
      });
           
 }
 
to_insert_floor='<div class=""><p class="meta-options floor_p">\n\
                <label for="plan_title">'+control_vars.plan_title+'</label><br />\n\
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />\n\
            </p>\n\
            \n\
            <p class="meta-options floor_full"> \n\
                <label for="plan_description">'+control_vars.plan_desc+'</label><br /> \n\
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea> \n\
            </p>\n\
             \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_size">'+control_vars.plan_size+'</label><br /> \n\
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="" /> \n\
            </p> \n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_rooms">'+control_vars.plan_rooms+'</label><br /> \n\
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_bath">'+control_vars.plan_bathrooms+'</label><br /> \n\
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_price">'+control_vars.plan_price+'</label><br /> \n\
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="" /> \n\
            </p> \n\
    </div>';