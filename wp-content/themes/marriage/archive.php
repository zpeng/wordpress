<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header();?>


	  <?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<div class="pages_title"><h2><?php single_cat_title(); ?></h2></div>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<div class="pages_title"><h2>Posts Tagged <span><?php single_tag_title(); ?></span></h2></div>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<div class="pages_title"><h2>Archive for <span><?php the_time('F jS, Y'); ?></span></h2></div>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<div class="pages_title"><h2>Archive for <span><?php the_time('F, Y'); ?></span></h2></div>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<div class="pages_title"><h2>Archive for <span><?php the_time('Y'); ?></span></h2></div>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<div class="pages_title"><h2>Author <span>Archive</span></h2></div>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<div class="pages_title"><h2>Blog <span>Archives</span></h2></div>
 	  <?php } ?>
<div class="content">

	  <div class="left23">
    	
		<?php while (have_posts()) : the_post(); ?>
			<?php $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_image_src($image_id,'large', true);
            ?>     
            
        	<div class="post">
            
                 
                   <?php if ( has_post_thumbnail() ) { ?>
                 <div class="post_thumb">
                    <a href="<?php the_permalink() ?>" rel="" title="<?php the_title_attribute(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo $image_url[0]; ?>&h=234&w=486&zc=1" alt=""/></a>
                    <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                 </div>
                  <?php } else {?>
                  <h2 class="post_title_nothumb" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                  <?php } ?>
                 
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
                 

                 
                 <div class="entry">
                   <?php echo blog_excerpts(); ?>
                 </div>
                 
                <a href="<?php the_permalink() ?>" class="read_more"><span class="swirl_left"><span class="swirl_right">read more</span></span></a>
                 
        	 </div>  
            
            
		<?php endwhile; ?>

		<div class="navigation">
            <div class="blog_next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			<div class="blog_prev"><?php next_posts_link('&laquo; Older Entries') ?></div>
			
		</div>
        
		<?php else :
        
        if ( is_category() ) { // If this is a category archive
            printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
        } else if ( is_date() ) { // If this is a date archive
            echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
        } else if ( is_author() ) { // If this is a category archive
            $userdata = get_userdatabylogin(get_query_var('author_name'));
            printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
        } else {
            echo("<h2 class='center'>No posts found.</h2>");
        }
        get_search_form();
        
        endif;
        ?>

		</div>
        
        <?php get_sidebar(); ?>

</div> 
<div class="clear"></div>    
<?php get_footer(); ?>
