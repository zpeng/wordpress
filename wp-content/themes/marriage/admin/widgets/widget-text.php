<?php
class Widget_textcontent extends WP_Widget {

	function Widget_textcontent()
    {
		$widget_ops = array( 'classname'=>'widget_textcontent', 'description'=>__('Custom text widget for home page and sidebars'));
		$this->WP_Widget('com-bigad', __('Custom text widget'), $widget_ops);
	}

	function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title'] ) ? __('') : $instance['title']);
		$test_content = $instance['test_content'];
		$thumb_url = $instance['thumb_url'];
		$more_url = $instance['more_url'];

        echo $before_widget;
		?>
        <div class="left13 section_home">
        <?php
        if($title)
        {
            echo $before_title . $title . $after_title;
        }

        ?>

        <a href="<?php echo $more_url; ?>"><img src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo $thumb_url; ?>&h=120&w=250&zc=1" alt="image" /></a>
         <p><?php echo $test_content; ?></p>
         <a href="<?php echo $more_url; ?>" class="section_more"><span class="swirl_left"><span class="swirl_right">read more</span></span></a>
		</div>
        <?php
        echo $after_widget;
	}

	function update($new_instance, $old_instance)
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['test_content'] = strip_tags($new_instance['test_content']);
		$instance['thumb_url'] = strip_tags($new_instance['thumb_url']);
		$instance['more_url'] = strip_tags($new_instance['more_url']);
		return $instance;
	}

	function form($instance)
    {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'test_content' => '', 'test_url' => '', 'thumb_url' => '', 'more_url' => '') );
		$title = esc_attr( $instance['title'] );
		$test_content = esc_attr( $instance['test_content'] );
		$thumb_url = esc_attr( $instance['thumb_url'] );
		$more_url = esc_attr( $instance['more_url'] );
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('test_content'); ?>"><?php _e( 'Text content:' ); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('test_content'); ?>" name="<?php echo $this->get_field_name('test_content'); ?>" rows="2" cols="20"><?php echo $test_content; ?></textarea></p>
        
        <p><label for="<?php echo $this->get_field_id('thumb_url'); ?>"><?php _e( 'Thumb URL:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('thumb_url'); ?>" name="<?php echo $this->get_field_name('thumb_url'); ?>" type="text" value="<?php echo $thumb_url; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('more_url'); ?>"><?php _e( 'More link:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('more_url'); ?>" name="<?php echo $this->get_field_name('more_url'); ?>" type="text" value="<?php echo $more_url; ?>" /></p>
        <?php
	}
}
register_widget('Widget_textcontent');
?>