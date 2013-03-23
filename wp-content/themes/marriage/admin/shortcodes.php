<?php
/*------------------------------FULL WIDTH SHORTCODES--------------------*/

function fullcontent( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left_full"><h1>'.$title.'</h1><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('fullcontent', 'fullcontent');

function fullcontentsimple( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left_full"><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('fullcontentsimple', 'fullcontentsimple');

function halfcontent( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left12"><h2>'.$title.'</h2><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('halfcontent', 'halfcontent');

function twothirdscontent( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left23"><h2>'.$title.'</h2><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('twothirdscontent', 'twothirdscontent');

/*------------------------------IMAGES SHORTCODES--------------------*/

function onethirdscontent( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left13 border_img"><h2>'.$title.'</h2><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('onethirdscontent', 'onethirdscontent');

function quartercontent( $atts, $content = null)
{
 extract(shortcode_atts(array(
        'title'      => '',
        ), $atts));
   return '<div class="left14"><h3>'.$title.'</h3><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('quartercontent', 'quartercontent');


/*------------------------------VIDEO SHORTCODES--------------------*/

function video( $atts, $content = null)
{
 extract(shortcode_atts(array(
 		'title'      => '',
        ), $atts));
   return '<div class="videocontainer"><iframe src="'.do_shortcode($content) .'" frameborder="0" width="400" height="225" webkitAllowFullScreen allowfullscreen></iframe></div>';
}
add_shortcode('video', 'video');

function icon( $atts, $content = null)
{
 extract(shortcode_atts(array(
 		'title'      => '',
		'iconurl'      => '',
		'iconlink'      => '',
        ), $atts));
   return '<div class="contact_info"><h3>'.$title.'</h3><div class="icon"><a href="'.$iconlink.'" title="'.$title.'"><img src="'.$iconurl.'" alt="" title="" border="0"/></a></div><p>'.do_shortcode($content) .'</p></div>';
}
add_shortcode('icon', 'icon');

?>
