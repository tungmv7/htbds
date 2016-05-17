<?php
global $options;
global $prop_id;
global $post;
global $agent_url;
global $agent_urlc;


$pict_size=5;
$content_size=7;

if ($options['content_class']=='col-md-12'){
   $pict_size=4; 
   $content_size='8';
}

if ( get_post_type($prop_id) == 'estate_property' ){
    $pict_size=4;
    $content_size=8;
    if ($options['content_class']=='col-md-12'){
       $pict_size=3; 
       $content_size='9';
    }   
}
$link =  get_permalink();

if($preview_img==''){
    $preview_img    =   get_template_directory_uri().'/img/default_user_agent.gif';
}
?>



   <?php 
   if ( 'estate_agent' == get_post_type($prop_id)) { ?>
            <div class="agent_content col-md-12">
                <div class="agent-listing-img-wrapper" data-link="<?php echo  $link; ?>">
                    <?php
                    if ( 'estate_agent' != get_post_type($prop_id)) { ?>
                        <a href="<?php print esc_url($link);?>">
                            <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive"/>
                        </a>
                        <?php
                    }else{
                        ?>
                        <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive"/>
                    <?php }?>

                </div>
                <?php the_content();?>
            </div>
    <?php } ?>