<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header(); ?>



	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <div class="pages_title"><h2><?php the_title(); ?></h2></div>
    
<div class="content">

	<div class="left23">
    
    <div class="post" id="post-<?php the_ID(); ?>">
        <div class="pageentry">
            <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

        </div>
    </div>
    
    <?php endwhile; endif; ?>
    <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
    
	</div>
    
    <?php get_template_part ('sidebar_pages'); ?>


</div> 
<div class="clear"></div> 
<?php get_footer(); ?>




