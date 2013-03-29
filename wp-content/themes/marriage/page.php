<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
/*
Template Name: Page full width
*/
get_header(); ?>



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="pages_title"><h2><?php the_title(); ?></h2></div>
    
<div class="content">
	
    <div class="postfull" id="post-<?php the_ID(); ?>">

        <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

        <?php comments_template(); ?>

    </div>
    <?php endwhile; endif; ?>
    
    

</div> 
<div class="clear"></div>
<?php get_footer(); ?>
