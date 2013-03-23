<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();
?>


	<div class="pages_title"><h2><?php $theme->option('blog_single_title'); ?></h2></div>
    
<div class="content">  
	<div class="left23">
    
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        
        	<div class="post">
            
                 <div class="entry_single">
                 	<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
                    <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
                 </div> 
            
                 
                 <div class="post_left">
                     <div class="date_line_blog">
                        <span class="day"><?php the_time('d') ?></span> <br />
                        <span class="month"><?php the_time('M') ?></span>
                        <img class="date_line" src="<?php echo get_template_directory_uri(); ?>/images/date_line.png" alt="" title="" border="0" />
                     </div>
                     <div class="comm_line_blog icon_comm"><?php comments_popup_link('0', '1', '%'); ?></div>
                     <div class="comm_line_blog icon_category"><?php the_category(', ') ?></div>
                     
						<?php if( has_tag() ) { ?>
                        <div class="comm_line_blog">
                        <?php the_tags(); ?> 
						</div>
						<?php } ?>
                 </div>

                 


                 
        	 </div>  
        
        

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

	<?php endif; ?>
    
    </div>

    
    <?php get_sidebar(); ?>

</div> 
<div class="clear"></div>    
<?php get_footer(); ?>