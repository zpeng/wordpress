<?php

	
    $custom_colors = '';

    if($this->display('title_color')) {
        $custom_colors .= ".title a{ color: #" . $this->get_option('title_color') ."; }\n";
    }
    if($this->display('description_color')) {
        $custom_colors .= ".description{ color: #" . $this->get_option('description_color') ."; }\n";
    }
    if($this->display('html_bg_image')) {
        $custom_colors .= "html{ background:url(" . $this->get_option('html_bg_image') .") repeat #e6e6e6; }\n";
    }
    if($this->display('body_bg_image')) {
        $custom_colors .= "body{ background:url(" . $this->get_option('body_bg_image') .") repeat-x top; }\n";
    }

	if($this->display('links_colors')) {
        $custom_colors .= "a { color: #" . $this->get_option('links_colors') ."; }\n";
		$custom_colors .= "h5.subtitle, h3.form_subtitle, .visual-form-builder .legend h3{ color: #" . $this->get_option('links_colors') ."; }\n";
		$custom_colors .= "ul#main_menu li a.selected, ul#main_menu li a:hover, .sidebar ul li a:hover{ color: #" . $this->get_option('links_colors') ."; }\n";
		$custom_colors .= ".home_title h2 span, .about_right h2, .sidebar .tweet ul li a, .select_container, span.date_value, .gallery13 h3, ul.filter_portfolio li a{ color: #" . $this->get_option('links_colors') ."; }\n";
		$custom_colors .= ".comm_line_blog, .blog_next a, .blog_prev a, .sidebar ul li, .bgs ul li{ border-bottom: 1px #" . $this->get_option('links_colors') ." dotted;; }\n";
    }
	if($this->display('main_color')) {
        $custom_colors .= ".section_home h2 { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/title_bg.png) no-repeat center; }\n";
		$custom_colors .= ".date_line_blog { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/date_bg.png) no-repeat center; }\n";
		$custom_colors .= ".caption_title_line, .post_thumb h2 { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/slider_caption_bg.png) repeat; }\n";
		$custom_colors .= "a.more_about, a.button { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/more_about_bg.png) no-repeat center; }\n";
		$custom_colors .= ".flex-direction-nav li a.next { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/next.png) no-repeat center; }\n";
		$custom_colors .= ".flex-direction-nav li a.prev { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/prev.png) no-repeat center; }\n";
		$custom_colors .= ".pages_title { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/page_titles_bg.png) no-repeat center; }\n";
		
		$custom_colors .= ".name_divider { background:url(".get_template_directory_uri() . "/images/" . $this->get_option('main_color') ."/name_divider.png) no-repeat center; }\n";

    }
	
?>
