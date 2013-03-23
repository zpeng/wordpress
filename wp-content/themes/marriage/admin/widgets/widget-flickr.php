<?php
/*---------------------------------------------------------------------------------*/
/* Flickr widget */
/*---------------------------------------------------------------------------------*/
class widget_flickr extends WP_Widget {

	function widget_flickr() {
		$widget_ops = array('description' => 'This Flickr widget populates photos from a Flickr ID.' );

		parent::WP_Widget(false, __('Widget - Flickr', 'widget'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$widgettitle = esc_attr($instance['widgettitle']);
		$id = $instance['id'];
		$number = $instance['number'];
		
		echo "<div class=\"flickr_widget\">";
		echo $before_title; ?>
        
		<?php echo $widgettitle; ?>
        <?php echo $after_title; ?>
            

         <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>&amp;size=s"></script> 
             

		
	   <?php			
	   echo "</div>";
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {   
        $widgettitle = esc_attr($instance['widgettitle']);     
		$id = esc_attr($instance['id']);
		$number = esc_attr($instance['number']);
		?>
       	<p>
            <label for="<?php echo $this->get_field_id('widgettitle'); ?>"><?php _e('Title:','widget'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('widgettitle'); ?>" class="widefat" id="<?php echo $this->get_field_id('widgettitle'); ?>" value="<?php echo $widgettitle; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID:','widget'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
        </p>
       	<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Thumbs number:','widget'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" value="<?php echo $number; ?>"/>
        </p>
		<?php
	}
} 

register_widget('widget_flickr');
?>