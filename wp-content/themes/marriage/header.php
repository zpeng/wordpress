<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<?php global $theme; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<!-- Main CSS file -->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( !is_home() ) { ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<?php } ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/<?php $theme->option('main_color'); ?>.css" type="text/css" media="screen" charset="utf-8" />
<!-- Google web font -->
<link href='http://fonts.googleapis.com/css?family=Ovo' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css' />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
<?php 
if ( !is_home() ) {
wp_register_script('prettyPhoto', get_template_directory_uri().'/scripts/jquery.prettyPhoto.js', false, '1', false);
wp_enqueue_script('prettyPhoto');

wp_register_script('quicksand', get_template_directory_uri().'/scripts/jquery.quicksand.js', false, '1', false);
wp_enqueue_script('quicksand');

wp_register_script('custom', get_template_directory_uri().'/scripts/custom.quicksand.js', false, '1', false);
wp_enqueue_script('custom');

wp_register_script('fitvids', get_template_directory_uri().'/scripts/jquery.fitvids.js', false, '1');
wp_enqueue_script('fitvids');
}
?>

<?php 
wp_register_script('tweet', get_template_directory_uri().'/scripts/jquery.tweet.js', false, '1', false);
wp_enqueue_script('tweet');

wp_register_script('flexslider', get_template_directory_uri().'/scripts/jquery.flexslider-min.js', false, '1', false);
wp_enqueue_script('flexslider');

wp_register_script('menu', get_template_directory_uri().'/scripts/menu.js', false, '1', false);
wp_enqueue_script('menu');

?>
<script type="text/javascript" charset="utf-8">
var $ = jQuery.noConflict();
  $(window).load(function() {
    
	<?php if ( is_home() ) {?>
    $('.flexslider').flexslider({
          animation: "fade"
    });
	<?php } ?>
	
	$(function() {
		$('.show_menu').click(function(){
				$('.menu').fadeIn();
				$('.show_menu').fadeOut();
				$('.hide_menu').fadeIn();
		});
		$('.hide_menu').click(function(){
				$('.menu').fadeOut();
				$('.show_menu').fadeIn();
				$('.hide_menu').fadeOut();
		});
	});
	

  });
  
  jQuery(function($){
	$(".tweet").tweet({
	  join_text: "auto",
	  username: "<?php $theme->option('twitter_username'); ?>",
	  count: 1,
	  auto_join_text_default: "we said,",
	  auto_join_text_ed: "we",
	  auto_join_text_ing: "we were",
	  auto_join_text_reply: "we replied",
	  auto_join_text_url: "we were checking out",
	  loading_text: "loading tweets..."
	});
  });
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php $theme->hook('head'); ?>
</head>
<body <?php body_class(); ?>>
<div id="shadow_bg">
<div id="main_container">

       <div class="topsocials">
           <ul>
      <?php if ($theme->display('icon_rss')) { ?><li><a target="_blank" href="<?php $theme->option('url_rss'); ?>"><img src="<?php $theme->option('icon_rss'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_twitter')) { ?><li><a target="_blank" href="<?php $theme->option('url_twitter'); ?>"><img src="<?php $theme->option('icon_twitter'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_facebook')) { ?><li><a target="_blank" href="<?php $theme->option('url_facebook'); ?>"><img src="<?php $theme->option('icon_facebook'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_google')) { ?><li><a target="_blank" href="<?php $theme->option('url_google'); ?>"><img src="<?php $theme->option('icon_google'); ?>" alt="" title="" /></a></li><?php } ?>
      <?php if ($theme->display('icon_vimeo')) { ?><li><a target="_blank" href="<?php $theme->option('url_vimeo'); ?>"><img src="<?php $theme->option('icon_vimeo'); ?>" alt="" title="" /></a></li><?php } ?>
           </ul>
            <a class="hide_socials" href="#">close</a>
       </div>

	<a class="show_menu" href="#">menu</a>
    <a class="hide_menu" href="#">close menu</a>
	
    <div class="menu">                                                                   
		<?php
        if (function_exists('wp_nav_menu')) {
        wp_nav_menu( array( 'theme_location' => 'theme-main-menu', 'fallback_cb' => 'theme_default_menu', 'container_class' => 'menucontainer', 'menu_id' => 'main_menu', 'menu_class' => 'main_menu') );
        }
        else {
        theme_default_menu();
        }
        ?>
     </div>
	

<div id="center_container">

  <div id="header">
     
	<?php if ($theme->display('logo')) { ?> 
    <div class="title"><a href="<?php echo home_url(); ?>"><img src="<?php $theme->option('logo'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></a></div>
    <?php } else { }?> 
    <?php if ($theme->display('maintitle')) { ?> 
     <div class="title"><a href="<?php echo home_url(); ?>"><?php $theme->option('maintitle'); ?></a></div>
    <?php } else { }?> 

     
     <div class="description"><span class="swirl_left"><span class="swirl_right"><?php $theme->option('weddingdate'); ?></span></span></div>
     
  </div><!-- End of Header-->
