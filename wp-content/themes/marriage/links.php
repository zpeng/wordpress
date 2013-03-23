<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

/*
Template Name: Links
*/
?>

<?php get_header(); ?>
<div class="pages_title"><h2>Links:</h2></div>

<div class="content">
<div class="left_full">


<ul>
<?php wp_list_bookmarks(); ?>
</ul>
</div>
</div>
<div class="clear"></div>
<?php get_footer(); ?>
