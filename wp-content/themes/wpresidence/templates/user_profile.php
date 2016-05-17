<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$first_name             =   get_the_author_meta( 'first_name' , $userID );
$last_name              =   get_the_author_meta( 'last_name' , $userID );
$user_email             =   get_the_author_meta( 'user_email' , $userID );
$user_mobile            =   get_the_author_meta( 'mobile' , $userID );
$user_phone             =   get_the_author_meta( 'phone' , $userID );
$description            =   get_the_author_meta( 'description' , $userID );
$facebook               =   get_the_author_meta( 'facebook' , $userID );
$twitter                =   get_the_author_meta( 'twitter' , $userID );
$linkedin               =   get_the_author_meta( 'linkedin' , $userID );
$pinterest              =   get_the_author_meta( 'pinterest' , $userID );
$user_skype             =   get_the_author_meta( 'skype' , $userID );
$website                =   get_the_author_meta( 'website' , $userID );


$user_title             =   get_the_author_meta( 'title' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/img/default_user.png';
}
?>


<div class="user_profile_div"> 
        <h3><?php _e('Welcome back, ','wpestate'); echo esc_html($user_login).'!';?></h3>
        <div id="profile_message">
        </div>    
            
        <div class="add-estate profile-page row">  
            <div class="profile_div col-md-4" id="profile-div">
                <?php print '<img id="profile-image" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="'.$image_id.'" >';
                
                //print '/ '.$user_small_picture;?>

                <div id="upload-container">                 
                    <div id="aaiu-upload-container">                 
              
                        <button id="aaiu-uploader" class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php _e('Upload Profile Image','wpestate');?></button>
                        <div id="aaiu-upload-imagelist">
                            <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                        </div>
                    </div>  
                </div>
                <span class="upload_explain"><?php _e('*minimum 500px x 500px','wpestate');?></span>
            </div>

            <div class="col-md-4">
                <p>
                    <label for="firstname"><?php _e('First Name','wpestate');?></label>
                    <input type="text" id="firstname" class="form-control" value="<?php echo esc_html($first_name);?>"  name="firstname">
                </p>
      
                <p>
                    <label for="secondname"><?php _e('Last Name','wpestate');?></label>
                    <input type="text" id="secondname" class="form-control" value="<?php echo esc_html($last_name);?>"  name="firstname">
                </p>
                
                <p>
                    <label for="useremail"><?php _e('Email','wpestate');?></label>
                    <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($user_email);?>"  name="useremail">
                </p>
                
            </div>

            
            <div class="col-md-4">
                

                <p>
                    <label for="userphone"><?php _e('Phone','wpestate');?></label>
                    <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($user_phone);?>"  name="userphone">
                </p>
                <p>
                    <label for="usermobile"><?php _e('Mobile','wpestate');?></label>
                    <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($user_mobile);?>"  name="usermobile">
                </p>
                
                <p>
                    <label for="userskype"><?php _e('Skype','wpestate');?></label>
                    <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($user_skype);?>"  name="userskype">
                </p>
                
                <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
                
               
            </div>
            </div>
            
            
            
            <div class="add-estate profile-page row">  
            <div class="col-md-4">
                <p>
                    <label for="userfacebook"><?php _e('Facebook Url','wpestate');?></label>
                    <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($facebook);?>"  name="userfacebook">
                </p>
                
                 <p>
                    <label for="usertwitter"><?php _e('Twitter Url','wpestate');?></label>
                    <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($twitter);?>"  name="usertwitter">
                </p>
                
                 <p>
                    <label for="userlinkedin"><?php _e('Linkedin Url','wpestate');?></label>
                    <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($linkedin);?>"  name="userlinkedin">
                </p>
                
                 <p>
                    <label for="userpinterest"><?php _e('Pinterest Url','wpestate');?></label>
                    <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($pinterest);?>"  name="userpinterest">
                </p> 
                <p>
                    <label for="website"><?php _e('Website Url (without http)','wpestate');?></label>
                    <input type="text" id="website" class="form-control" value="<?php echo esc_html($website);?>"  name="website">
                </p>
            </div>
                
            <div class="col-md-8">
                 <p>
                    <label for="usertitle"><?php _e('Title/Position','wpestate');?></label>
                    <input type="text" id="usertitle" class="form-control" value="<?php echo esc_html($user_title);?>"  name="usertitle">
                </p>
                 <p>
                    <label for="about_me"><?php _e('About Me','wpestate');?></label>
                    <textarea id="about_me" class="form-control" name="about_me"><?php echo esc_html($about_me);?></textarea>
                </p>
                
            </div>
            
            <p class="fullp-button">
                <button class="wpb_button  wpb_btn-info wpb_btn-large" id="update_profile"><?php _e('Update profile','wpestate');?></button>
            </p>
            
        </div>

    
    
 
    
    
      
    
        <h3><?php _e('Change Password','wpestate');?> </h3>
       
        <div class="profile-page row">  
            <div class="pass_note"> <?php _e('*After you change the password you will have to login again.','wpestate')?></div>
            <div id="profile_pass">
            </div> 
            
            <p  class="col-md-4">
                <label for="oldpass"><?php _e('Old Password','wpestate');?></label>
                <input  id="oldpass" value=""  class="form-control" name="oldpass" type="password">
            </p>
            
            <p  class="col-md-4">
                <label for="newpass"><?php _e('New Password ','wpestate');?></label>
                <input  id="newpass" value="" class="form-control" name="newpass" type="password">
            </p>
            <p  class="col-md-4">
                <label for="renewpass"><?php _e('Confirm New Password','wpestate');?></label>
                <input id="renewpass" value=""  class="form-control" name="renewpass"type="password">
            </p>
            
            <?php   wp_nonce_field( 'pass_ajax_nonce', 'security-pass' );   ?>
            <p class="fullp-button">
                <button class="wpb_button  wpb_btn-info wpb_btn-large vc_button" id="change_pass"><?php _e('Reset Password','wpestate');?></button>
             
            </p>
        </div>




       

    

    
 </div>