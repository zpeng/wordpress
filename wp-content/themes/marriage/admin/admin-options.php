<?php

/*********************************************
* General Options
*********************************************
*/
$this->admin_option(array('General', 1),
	'Title', 'maintitle', 
	'text', 'Michael & Sarah', 
	array('help' => 'Change the color of title from Theme Colors tab', 'display'=>'extended')
);
$this->admin_option('General',
	'Logo Image', 'logo', 
	'imageupload', '',
	array('help' => 'Use logo as image intead of text title. Delete the title text if using image.', 'display'=>'extended')
);
$this->admin_option('General',
	'Under title date', 'weddingdate', 
	'text', '25 june 2012',
	array('help' => 'This will be displayed under the main title', 'display'=>'extended')
);
$this->admin_option('General',
	'Home welcome title', 'hometitle', 
	'text', 'Welcome to Our <span>Wedding Website</span>',
	array('help' => 'This will be displayed under the home slider', 'display'=>'extended')
);
$this->admin_option('General', 
	'Favicon', 'favicon', 
	'imageupload', get_template_directory_uri() . "/images/favicon.ico", 
	array('help' => '')
);
$this->admin_option('General',
	'Enable Home Slider', 'show_home_slider', 
	'select', 'enable',
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
$this->admin_option('General',
	'Blog Single page main title', 'blog_single_title', 
	'text', 'Blog', 
	array('help' => 'Blog details page main top title', 'display'=>'inline')
);
$this->admin_option('General',
	'Twitter Username', 'twitter_username', 
	'text', 'famousthemes', 
	array('help' => 'Will be used in Twitter custom widget', 'display'=>'inline')
);
$this->admin_option('General',
	'Custom CSS', 'custom_css', 
	'textarea', '', 
	array('help' => '')
);

$this->admin_option('General',
	'Bottom divider name initials', 'nameinitials', 
	'text', 'MS',
	array('help' => '')
);

$this->admin_option('General',
	'Footer Text', 'footer_text', 
	'textarea', 'Marriage | Premium Wordpress Theme by <a href="http://famousthemes.com">Famous Themes</a> <br /> Photos by <a href="http://antondemin.ru/" target="_blank">antondemin.ru</a>', 
	array('help' => '')
);

$this->admin_option('General',
	'Analytics Code', 'analytics_code', 
	'textarea', '', 
	array('help' => '')
);
/*********************************************
* Theme Colors
*********************************************
*/
$this->admin_option(array('Layout and Colors', 2),
	'Main color style', 'main_color', 
	'select', 'yellow', 
	array('help'=>'', 'display'=>'inline', 'options'=>array('yellow' => 'Yellow', 'blue' => 'Blue', 'green' => 'Green', 'grayscale' => 'Grayscale', 'red' => 'Red', 'orange' => 'Orange', 'purple' => 'Purple', 'brown' => 'Brown'))
);
$this->admin_option('Layout and Colors', 
	'Main yellow links color', 'links_colors', 
	'colorpicker', 'e8a900', 
	array('help' => 'This will replace all red default color used', 'display'=>'inline')
);

$this->admin_option('Layout and Colors',
	'Title Color', 'title_color', 
	'colorpicker', '4c402b', 
	array('display' => 'inline')
);
$this->admin_option('Layout and Colors', 
	'Description date undertitle', 'description_color', 
	'colorpicker', 'e8a900', 
	array('display' => 'inline')
);
$this->admin_option('Layout and Colors',
	'Html Background Image', 'html_bg_image', 
	'imageupload', get_template_directory_uri() . "/images/bg-texture1.jpg",
	array('help' => 'Main Website Html Background image. The image will repeat from top left. Best to use is a texture or pattern', 'display'=>'extended')
);
$this->admin_option('Layout and Colors',
	'Body Background Image', 'body_bg_image', 
	'imageupload', get_template_directory_uri() . "/images/top_bg.jpg",
	array('help' => 'Main Website Body Background image. The image will repeat on top X-axis only. This will stay on top of the Html image used. Best to use is a texture or pattern', 'display'=>'extended')
);



/*********************************************
* Social Icons
*********************************************
*/
$this->admin_option(array('Social icons', 3),
	'RSS icon', 'icon_rss', 
	'imageupload', get_template_directory_uri() . "/images/social_icons/rss.png", 
	array('help' => 'Remove if you do not want to display this icon', 'display'=>'inline')
);
$this->admin_option('Social icons',
	'RSS icon URL', 'url_rss', 
	'text', '', 
	array('help' => '')
);
$this->admin_option('Social icons', 
	'Twitter icon', 'icon_twitter', 
	'imageupload', get_template_directory_uri() . "/images/social_icons/twitter.png",  
	array('help' => 'Remove if you do not want to display this icon', 'display'=>'inline')
);
$this->admin_option('Social icons',
	'Twitter icon URL', 'url_twitter', 
	'text', '', 
	array('help' => '')
);
$this->admin_option('Social icons', 
	'Facebook icon', 'icon_facebook', 
	'imageupload', get_template_directory_uri() . "/images/social_icons/facebook.png",  
	array('help' => 'Remove if you do not want to display this icon', 'display'=>'inline')
);
$this->admin_option('Social icons',
	'Facebook icon URL', 'url_facebook', 
	'text', '', 
	array('help' => '')
);
$this->admin_option('Social icons', 
	'Google icon', 'icon_google', 
	'imageupload', get_template_directory_uri() . "/images/social_icons/google.png",  
	array('help' => 'Remove if you do not want to display this icon', 'display'=>'inline')
);
$this->admin_option('Social icons',
	'Google icon URL', 'url_google', 
	'text', '', 
	array('help' => '')
);
$this->admin_option('Social icons', 
	'Vimeo icon', 'icon_vimeo', 
	'imageupload', get_template_directory_uri() . "/images/social_icons/vimeo.png",  
	array('help' => 'Remove if you do not want to display this icon', 'display'=>'inline')
);
$this->admin_option('Social icons',
	'Vimeo icon URL', 'url_vimeo', 
	'text', '', 
	array('help' => '')
);
/*********************************************
* Widgets
*********************************************
*/
$this->admin_option(array('Widgets', 4),
	'Enable Home Widget About Area', 'show_widget_area_1', 
	'select', 'enable',
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
$this->admin_option('Widgets',
	'Enable Home Widget Center Area (3 col sections)', 'show_widget_area_2', 
	'select', 'enable', 
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
$this->admin_option('Widgets',
	'Enable Name Initials Area', 'show_widget_area_3', 
	'select', 'enable', 
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
$this->admin_option('Widgets',
	'Enable Home Widget Bottom Area (Under the name initials)', 'show_widget_area_4', 
	'select', 'enable', 
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
/*********************************************
* Photos page Options
*********************************************
*/
$this->admin_option(array('Photos Page', 5),
	'Photos page main title', 'portfolio_maintitle', 
	'text', 'Our Photo <span>Gallery</span>', 
	array('help' => '')
);
$this->admin_option('Photos Page',
	'Filter View All text', 'viewall', 
	'text', 'View all', 
	array('help' => '')
);
$this->admin_option('Photos Page',
	'Photos per page', 'perpage', 
	'text', '9', 
	array('help' => 'Download WP_PageNavi Plugin at: http://wordpress.org/extend/plugins/wp-pagenavi/ - Page Navigation Will Appear If Plugin Is Installed', 'display'=>'inline')
);
/*********************************************
* Contact Options
*********************************************
*/
$this->admin_option(array('Contact Page', 6),
	'Enable Contact Form', 'show_contact_form', 
	'select', 'enable',
	array('help'=>'', 'display'=>'inline', 'options'=>array('enable' => 'Enable', 'disable' => 'Disable'))
);
$this->admin_option('Contact Page',
	'Contact form title', 'contact_form_title', 
	'text', 'Contact form', 
	array('help' => '')
);
$this->admin_option('Contact Page',
	'Contact email', 'contactemail', 
	'text', '', 
	array('help' => '')
);
$this->admin_option('Contact Page',
	'Contact subject title', 'contactsubject', 
	'text', 'Contact subject title', 
	array('help' => '')
);
$this->admin_option('Contact Page',
	'Contact succes message', 'contactsucces', 
	'text', 'Your message has been sent. Thank you!', 
	array('help' => '')
);

/*********************************************
* Reset Options
*********************************************
*/
$this->admin_option(array('Reset Options', 9), 
'Reset Theme Options', 'reset_options', 
'content', '
<div id="admin_reset_options" style="margin-bottom:40px; display:none;"></div>
<div style="margin-bottom:40px;"><a class="admin-button-reset" onclick="if (confirm(\'All the saved settings will be lost! Do you really want to continue?\')) { admincore_form(\'admin_options&do=reset\', \'fpForm\',\'admin_reset_options\',\'true\'); } return false;">Reset Options Now</a></div>', 
array('help' => '<span style="color:red; margin:0 0 40px 0; display:block;"><strong>Note:</strong> All the previous saved settings will be lost!</span>', 'display'=>'extended-top')
);

?>