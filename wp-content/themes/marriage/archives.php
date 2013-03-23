<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>



	<div class="pages_title"><h2>Archives</h2></div>
<div class="content">
        <div class="left_full">
        <h1>Archives by Month:</h1>
        <ul>
        <?php wp_get_archives('type=monthly'); ?>
        </ul>
        </div>
        
        <div class="left_full">
        <h1>Archives by Subject:</h1>
        <ul>
         <?php wp_list_categories(); ?>
        </ul>
        </div>

</div>
<div class="clear"></div> 

<?php get_footer(); ?>
