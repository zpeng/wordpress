<?php
class Widget_gmap extends WP_Widget {

	function Widget_gmap()
    {
		$widget_ops = array( 'classname'=>'widget_gmap', 'description'=>__('Custom google map widget for sidebars'));
		$this->WP_Widget('com-bigadmap', __('Custom google map widget'), $widget_ops);
	}

	function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title'] ) ? __('') : $instance['title']);
		$test_content = $instance['test_content'];

        echo $before_widget;
		?>     
        
        
        
        <?php
        if($title)
        {
            echo $before_title . $title . $after_title;
        }

        ?>
        <div class="gmap"><iframe width="100%" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $test_content; ?>"></iframe>  
		</div>
        <?php
        echo $after_widget;
	}

	function update($new_instance, $old_instance)
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['test_content'] = strip_tags($new_instance['test_content']);
		return $instance;
	}

	function form($instance)
    {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'test_content' => '') );
		$title = esc_attr( $instance['title'] );
		$test_content = esc_attr( $instance['test_content'] );
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('test_content'); ?>"><?php _e( 'Map Src:' ); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('test_content'); ?>" name="<?php echo $this->get_field_name('test_content'); ?>" rows="2" cols="20"><?php echo $test_content; ?></textarea></p>
        <?php
	}
}
register_widget('Widget_gmap');
?>