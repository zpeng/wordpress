<?php
/*----------------------------------------------------------------------*/
/* Include Files */
/*----------------------------------------------------------------------*/
require_once TEMPLATEPATH . '/admin/core.php';
require_once(TEMPLATEPATH . '/admin/post-options.php');
require_once(TEMPLATEPATH . '/admin/portfolio-post-type.php');
require_once(TEMPLATEPATH . '/admin/shortcodes.php');
require_once(TEMPLATEPATH . '/admin/widgets/category-posts.php');
require_once(TEMPLATEPATH . '/admin/widgets/widget-flickr.php');
require_once(TEMPLATEPATH . '/admin/widgets/widget-twitter.php');
require_once(TEMPLATEPATH . '/admin/widgets/widget-text.php');
require_once(TEMPLATEPATH . '/admin/widgets/widget-about.php');
require_once(TEMPLATEPATH . '/admin/widgets/widget-map.php');
$theme = new Admincore();
$theme->theme_name = 'Marriage';
$theme->load();
add_theme_support( 'automatic-feed-links' );
add_filter( 'show_admin_bar', '__return_false' );
add_filter( 'visual-form-builder-css', '__return_false' );

if ( !is_admin() ) { // instruction to only load if it is not the admin area
function my_init() {
		// comment out the next two lines to load the local copy of jQuery
		wp_enqueue_script('jquery');
}
add_action('init', 'my_init');
}
/*----------------------------------------------------------------------*/
/* Remove images atributes to make them 100% width */
/*----------------------------------------------------------------------*/
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
// Removes attached image sizes as well
add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

/*----------------------------------------------------------------------*/
/* Register main menu */
/*----------------------------------------------------------------------*/
add_action('init', 'theme_register_menu');
function theme_register_menu() {
    if (function_exists('register_nav_menus')) {
		register_nav_menus( array(
		'theme-main-menu' => 'Main Menu',
		'theme-main-fmenu' => 'Footer Menu'
		) );
    }
}
function theme_default_menu() {
    echo '<ul id="main_menu">';
    if ('page' != get_option('show_on_front')) {
        echo '<li><a href="'. get_option('home') . '/">Home</a></li>';
    }
    wp_list_pages('title_li=');
    echo '</ul>';
}
/*----------------------------------------------------------------------*/
/* Add shortcode buttons */
/*----------------------------------------------------------------------*/
add_action('init', 'add_button');
function add_button() {  
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
   {  
	 add_filter('mce_external_plugins', 'add_plugin');  
	 add_filter('mce_buttons', 'register_button');  
   }  
}    
function register_button($buttons) {  
   array_push($buttons, "fullcontent", "halfcontent", "twothirdscontent", "onethirdscontent", "quartercontent", "video", "icon");  
   return $buttons;  
} 
function add_plugin($plugin_array) {  
   $plugin_array['fullcontent'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['halfcontent'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['twothirdscontent'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['onethirdscontent'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['quartercontent'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['video'] = get_template_directory_uri().'/scripts/customcodes.js';
   $plugin_array['icon'] = get_template_directory_uri().'/scripts/customcodes.js';
   return $plugin_array;  
}  
/*----------------------------------------------------------------------*/
/* Home exerpt used for posts on home page */
/*----------------------------------------------------------------------*/
add_filter('the_excerpt', 'home_excerpts');
function home_excerpts($content = false) {
            global $post;
            $mycontent = $post->post_excerpt;
 
            $mycontent = $post->post_content;
            $mycontent = strip_shortcodes($mycontent);
            $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
            $mycontent = strip_tags($mycontent);
            $excerpt_length = 7;
            $words = explode(' ', $mycontent, $excerpt_length + 1);
            if(count($words) > $excerpt_length) :
                array_pop($words);
                array_push($words, '...');
                $mycontent = implode(' ', $words);
            endif;
            $mycontent = '<p>' . $mycontent . '</p>';
// Make sure to return the content
    return $mycontent;
}
function blog_excerpts($content = false) {
            global $post;
            $mycontent = $post->post_excerpt;
 
            $mycontent = $post->post_content;
            $mycontent = strip_shortcodes($mycontent);
            $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
            $mycontent = strip_tags($mycontent);
            $excerpt_length = 50;
            $words = explode(' ', $mycontent, $excerpt_length + 1);
            if(count($words) > $excerpt_length) :
                array_pop($words);
                array_push($words, '...');
                $mycontent = implode(' ', $words);
            endif;
            $mycontent = '<p>' . $mycontent . '</p>';
// Make sure to return the content
    return $mycontent;
}
function test_excerpts($content = false) {
            global $post;
            $mycontent = $post->post_excerpt;
 
            $mycontent = $post->post_content;
            $mycontent = strip_shortcodes($mycontent);
            $mycontent = str_replace(']]>', ']]&gt;', $mycontent);
            $mycontent = strip_tags($mycontent);
            $excerpt_length = 4;
            $words = explode(' ', $mycontent, $excerpt_length + 1);
            if(count($words) > $excerpt_length) :
                array_pop($words);
                array_push($words, '...');
                $mycontent = implode(' ', $words);
            endif;
            $mycontent = '<p>' . $mycontent . '</p>';
// Make sure to return the content
    return $mycontent;
}
/*----------------------------------------------------------------------*/
/* Limit title */
/*----------------------------------------------------------------------*/
function limit_title($title, $n){
if ( strlen ($title) > $n )
{
echo substr(the_title('', '', FALSE), 0, $n) . '';
}
else { the_title(); }
}
/*----------------------------------------------------------------------*/
/* Register Home About Section Widgets */
/*----------------------------------------------------------------------*/
register_sidebar( array(
	'name' => __( 'About Section Widgets'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
/*----------------------------------------------------------------------*/
/* Register Home Center Widgets */
/*----------------------------------------------------------------------*/
register_sidebar( array(
	'name' => __( 'Home Center Widgets'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
/*----------------------------------------------------------------------*/
/* Register Home Bottom Widgets */
/*----------------------------------------------------------------------*/
register_sidebar( array(
	'name' => __( 'Home widget bottom left'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
register_sidebar( array(
	'name' => __( 'Home widget bottom center'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
register_sidebar( array(
	'name' => __( 'Home widget bottom right'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
/*----------------------------------------------------------------------*/
/* Register Sidebar Widgets*/
/*----------------------------------------------------------------------*/
register_sidebar( array(
	'name' => __( 'Sidebar Pages'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
register_sidebar( array(
	'name' => __( 'Sidebar Blog'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
register_sidebar( array(
	'name' => __( 'Sidebar Contact'),
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
) );
?>