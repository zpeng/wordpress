<?php
/*---------------------POST EXTRA OPTIONS FOR IMAGES--------------------*/
function com_save_meta($postId)
{

	if(isset($_POST['use_post_in_slideshow']) )
    {
    	update_post_meta($postId, 'use_post_in_slideshow', $_POST['use_post_in_slideshow']); 
    }
	if(isset($_POST['slideshow_large_image_url']) )
    {
    	update_post_meta($postId, 'slideshow_large_image_url', $_POST['slideshow_large_image_url']); 
    }
}
add_action('save_post', 'com_save_meta');

function com_post_meta()
{
    if(isset($_REQUEST['post']) && is_numeric($_REQUEST['post']))
    {
        $post = (int)$_REQUEST['post'];
        $post = get_post($post);
		
		$use_post_in_slideshow = get_post_meta($post->ID, 'use_post_in_slideshow', true);
		$slideshow_large_image_url = get_post_meta($post->ID, 'slideshow_large_image_url', true);
    }

?>


	<script type="text/javascript">
	window.onload = function(){
		toggleElement(document.getElementById('use_post_in_slideshow'), 'slideshow_large_image');
	};
    
    function toggleElement(sel1, element1) {
    	
      element1 = document.getElementById(element1);
      
      if (sel1.value == 'yes') {
    
        element1.style.display = 'block';
    
      }
      else if (sel1.value == 'no') {
        element1.style.display = 'none'; // hide text element
      }
    
      return;
    }
    </script>
    <div style="padding:10px;float:left;">
    
     <label style="width:200px; float: left; padding-top:6px;">Use this post in home slideshow</label>
     
     <div style="float:left;">
     <select name="use_post_in_slideshow" id="use_post_in_slideshow" style="width:50px;" onchange="toggleElement(this, 'slideshow_large_image')">
      <option name="no" value="no"<?php if($use_post_in_slideshow == "no") { echo ' selected'; } ?>>no</option>
      <option name="yes" value="yes"<?php if($use_post_in_slideshow == "yes") { echo ' selected'; } ?>>yes</option>     
     </select>
     <em style="padding:5px 0px; display:block;">Select "yes" if you want to use this post in home slideshow</em>
     </div>
     
    </div>
    <div class="clear"></div> 
    
   
 
    
    <div style="padding:10px;float:left;" id="slideshow_large_image">
    
     <label style="width:200px; float: left; padding-top:6px;">Slideshow image</label>
     
     <div style="float:left;">
     	<div>
        <input class="admin-text admincore_image_upload_slideshow_large_image_url" type="text" name="slideshow_large_image_url" value="<?php echo  $slideshow_large_image_url; ?>"/>
        <a id="admincore_image_upload_slideshow_large_image_url" class="admin_imageupload" >Upload Now</a>
        </div>
        <em style="padding:5px 0px; display:block;">Use images at <strong>900 x 400 px</strong></em>
		<div style="clear:both; padding:10px 0 0 0;">
        <?php if(!empty($slideshow_large_image_url)) { ?>
        <img src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo $slideshow_large_image_url; ?>&h=120&w=300&zc=1&q=100" alt="<?php the_title(); ?>" />
        <?php }?>
		</div>

     </div>
     
    </div>
    <div class="clear"></div> 
    
    
    
    
    
<?php
}
function com_register_meta_box()
{
    add_meta_box('custom_meta', __('Post Custom Options'), 'com_post_meta', 'post', 'normal', 'high');
	add_meta_box('custom_meta', __('Post Custom Options'), 'com_post_meta', 'portfolio', 'normal', 'high');
	add_meta_box('custom_meta', __('Post Custom Options'), 'com_post_meta', 'page', 'normal', 'high');
}
add_action('admin_init', 'com_register_meta_box');

?>