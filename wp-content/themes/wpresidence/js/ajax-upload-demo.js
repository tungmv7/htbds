 ///////////////////////////////////////////////////////////////////////////////////////////  
  ////////  profile uploader
  ////////////////////////////////////////////////////////////////////////////////////////////   
  jQuery(document).ready(function($) {
     "use strict";
  
      if (typeof(plupload) !== 'undefined') {
            var uploader = new plupload.Uploader(ajax_upload_demo_vars.plupload);
            uploader.init();
            uploader.bind('FilesAdded', function (up, files) {
               
                $.each(files, function (i, file) {
                    
                    $('#aaiu-upload-imagelist').append(
                        '<div class="file_progress" id="' + file.id + '">' +
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
                var template = result.template; 
                template = template.replace('.zip','');
            
                $('#image_warn').remove();
                $('#' + file.id).remove();
                if (result.success) {       
                    $('.import_mess').empty();
                    $('#upload-container').prepend('<div class="template-item"><div class="template-wrapper"><img src="'+ajax_upload_demo_vars.destination_path+template+'/preview.jpg" alt="thumb" /><div class="activate_wrapper"><div class="activate_template" data-baseid="'+template+'">Activate</div><div class="importing_mess">click activate in order to import</div></div></div></div>');
                      
                    delete_binder();
                }else{
                    if (result.image){ 
                        $('#imagelist,#upload-container').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_upload_demo_vars.warning+'</div>');
                    }
                }
                estate_activate_template_action();
            });

     
            $('#aaiu-uploader-demo').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                uploader.start();
            });
            
               
                     
 }
 
 });

 
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
 