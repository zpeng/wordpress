<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>


	<?php if (have_posts()) : ?>
    
        <div class="pages_title"><h2>Search Result for <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); _e('<span class="search-terms">'); echo $key; _e('</span>'); _e(' &mdash; '); echo $count . ' '; _e('articles'); wp_reset_query(); ?></h2></div>
<div class="content"> 
        <div class="left23">
        
			<?php while (have_posts()) : the_post(); ?>
            
                <div class="post">
                <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <?php echo blog_excerpts(); ?>        
                </div>
            <?php endwhile; ?>
            
            <div class="navigation">
                <div class="blog_next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
                <div class="blog_prev"><?php next_posts_link('&laquo; Older Entries') ?></div>    
            </div>
            <?php else : ?>
            
            <h2 class="center">No posts found. Try a different search?</h2>
            <?php get_search_form(); ?>
        
        
        
    <?php endif; ?>

	</div>

  <?php get_template_part ('sidebar_pages'); ?>

</div> 
<div class="clear"></div> 
<?php get_footer(); ?>
