<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>


  <?php if($theme->get_option('show_home_slider') == 'enable') { ?>		
    
  <div class="slider_container">
		<div class="flexslider">
	    <ul class="slides">
			 <?php query_posts('post_type=any&meta_key=use_post_in_slideshow&meta_value=yes&showposts=999'); ?>
             <?php if (have_posts()) : ?>
             <?php while (have_posts()) : the_post(); ?>      
              <li>
	    		<a href="<?php the_permalink() ?>"><img src="<?php echo get_post_meta($post->ID, "slideshow_large_image_url", $single = true); ?>" alt="" title=""/></a>
	    		<div class="flex-caption">
                     <div class="caption_title_line"><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><?php echo home_excerpts(); ?></div>
                </div>
	    	  </li>
                 <?php endwhile; ?>
             <?php endif; ?> 
	    </ul>
	  </div>
   </div>
   
   <?php } else {}?> 
   
   
    <div class="home_title">
       <h2><?php $theme->option('hometitle'); ?></h2>
       <div class="socials">
           <ul>
      <?php if ($theme->display('icon_rss')) { ?><li><a target="_blank" href="<?php $theme->option('url_rss'); ?>"><img src="<?php $theme->option('icon_rss'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_twitter')) { ?><li><a target="_blank" href="<?php $theme->option('url_twitter'); ?>"><img src="<?php $theme->option('icon_twitter'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_facebook')) { ?><li><a target="_blank" href="<?php $theme->option('url_facebook'); ?>"><img src="<?php $theme->option('icon_facebook'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_google')) { ?><li><a target="_blank" href="<?php $theme->option('url_google'); ?>"><img src="<?php $theme->option('icon_google'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_vimeo')) { ?><li><a target="_blank" href="<?php $theme->option('url_vimeo'); ?>"><img src="<?php $theme->option('icon_vimeo'); ?>" alt="" title="" /></a></li><?php } ?>
           </ul>
       </div>
       <div class="clear"></div>
   </div>
   
   <div class="content">
	<?php if($theme->get_option('show_widget_area_1') == 'enable') { ?>
   

         
         <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('About Section Widgets') ) : ?>
         <div class="widget_area_text_about"><h3>About Section Widgets</h3><strong>Best to use here the "Custom about widget" (2 on a row)</strong><br /><br /> You can add widgets here from Admin->Appearance->Widgets <br /><br /> Enable or Disable this widget area from<br /> Theme Options -> Widgets</div>
        <?php endif;?> 

    <?php } else {}?> 
    
    <div class="clear"></div>         
       
       <?php if($theme->get_option('show_widget_area_2') == 'enable') { ?>
                
             
             <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Center Widgets') ) : ?>
             <div class="widget_area_text_about"><h3>Home Center Widgets</h3><strong>Best to use here the "Custom text widget" (3 on a row)</strong> <br /> <br /> You can add widgets here from Admin->Appearance->Widgets <br /><br /> Enable or Disable this widget area from<br /> Theme Options -> Widgets</div>
            <?php endif;?>


        
       <?php } else {}?> 
       
       
        <?php if($theme->get_option('show_widget_area_3') == 'enable') { ?>
       <div class="name_divider"><?php $theme->option('nameinitials'); ?></div>
       <?php } else {}?> 
       
       <?php if($theme->get_option('show_widget_area_4') == 'enable') { ?>     
            <div class="left13 fdivider"> 
             <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home widget bottom left') ) : ?>
             <p class="widget_area_text"><strong>Home widget bottom left</strong><br /><br /> You can add widgets here from Admin->Appearance->Widgets <br /><br /> Enable or Disable this widget area from<br /> Theme Options -> Widgets</p>
            <?php endif;?>
			</div>
   
            <div class="left13 fdivider"> 
             <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home widget bottom center') ) : ?>
             <p class="widget_area_text"><strong>Home widget bottom center</strong><br /><br /> You can add widgets here from Admin->Appearance->Widgets <br /><br /> Enable or Disable this widget area from<br /> Theme Options -> Widgets</p>
            <?php endif;?>
			</div>
       
     
            <div class="left13"> 
             <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home widget bottom right') ) : ?>
             <p class="widget_area_text"><strong>Home widget bottom right</strong><br /><br /> You can add widgets here from Admin->Appearance->Widgets <br /><br /> Enable or Disable this widget area from<br /> Theme Options -> Widgets</p>
            <?php endif;?>
			</div>
       <?php } else {}?> 
        
       
       
   </div>
   
   <div class="clear"></div> 

<?php get_footer(); ?>
