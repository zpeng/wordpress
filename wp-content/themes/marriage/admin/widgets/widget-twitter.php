<?php
class Widget_twitter extends WP_Widget {

	function Widget_twitter()
    {
		$widget_ops = array( 'classname'=>'widget_twitter', 'description'=>__('Custom Twitter widget for home page and sidebars'));
		$this->WP_Widget('com-bigadt', __('Custom Twitter widget'), $widget_ops);
	}

	function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', empty($instance['title'] ) ? __('') : $instance['title']);

        echo $before_widget;
		?>       
        
        <div class="twitter_widget">
        <?php
        if($title)
        {
            echo $before_title . $title . $after_title;
        }

        ?>
             
        <div class="tweet"></div>
        <img src="<?php echo get_template_directory_uri(); ?>/images/icon_tweets.gif" alt="" title="" class="tweet_icon" />   
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
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
 
        <p>Twitter username must be introduced from "Sapientia Theme Options" admin panel.</p>

        <?php
	}
}
register_widget('Widget_twitter');
?>