<?php
class Widget_testimonialcontent extends WP_Widget {

	function Widget_testimonialcontent()
    {
		$widget_ops = array( 'classname'=>'widget_testimonialcontent', 'description'=>__('Custom testimonial widget for home page and sidebars'));
		$this->WP_Widget('com-bigadd', __('Custom testimonial widget'), $widget_ops);
	}

	function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title'] ) ? __('') : $instance['title']);
		$testim_content = $instance['testim_content'];
		$test_author = $instance['test_author'];
		$test_author_url = $instance['test_author_url'];

        echo $before_widget;
		?>
        <div class="testimonial_widget">
        <?php
        if($title)
        {
            echo $before_title . $title . $after_title;
        }

        ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/icon_testimonials.gif" alt="" title="" class="left_icon" />

        <p><i><?php echo $testim_content; ?>...<strong><a href="<?php echo $test_author_url; ?>"><?php echo $test_author; ?></a></strong></i></p>
		</div>
        <?php
        echo $after_widget;
	}

	function update($new_instance, $old_instance)
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['testim_content'] = strip_tags($new_instance['testim_content']);
		$instance['test_author'] = strip_tags($new_instance['test_author']);
		$instance['test_author_url'] = strip_tags($new_instance['test_author_url']);
		return $instance;
	}

	function form($instance)
    {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'testim_content' => '', 'test_author' => '', 'test_author_url' => '') );
		$title = esc_attr( $instance['title'] );
		$testim_content = esc_attr( $instance['testim_content'] );
		$test_author = esc_attr( $instance['test_author'] );
		$test_author_url = esc_attr( $instance['test_author_url'] );
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        

        <p><label for="<?php echo $this->get_field_id('testim_content'); ?>"><?php _e( 'Testimonial content:' ); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('testim_content'); ?>" name="<?php echo $this->get_field_name('testim_content'); ?>" rows="2" cols="20"><?php echo $testim_content; ?></textarea></p>
        
        <p><label for="<?php echo $this->get_field_id('test_author'); ?>"><?php _e( 'Author:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('test_author'); ?>" name="<?php echo $this->get_field_name('test_author'); ?>" type="text" value="<?php echo $test_author; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('test_author_url'); ?>"><?php _e( 'Author url:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('mortest_author_urle_url'); ?>" name="<?php echo $this->get_field_name('test_author_url'); ?>" type="text" value="<?php echo $test_author_url; ?>" /></p>
        <?php
	}
}
register_widget('Widget_testimonialcontent');
?>