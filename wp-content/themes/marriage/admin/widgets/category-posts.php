<?php

global $theme;

$admincore_posts_defaults = array(
    'title' => 'Posts from category',
    'posts_number' => '5',
    'order_by' => 'none',
    'display_featured_image' => 'true'
);

        
add_action('widgets_init', create_function('', 'return register_widget("AdmincorePosts");'));

class AdmincorePosts extends WP_Widget 
{
    function AdmincorePosts() 
    {
        $widget_options = array('description' => __('Display posts from a specific selected category. Works only on home widget areas', 'admincore') );
        $control_options = array( 'width' => 300);
		$this->WP_Widget('admincore_posts', 'Custom Posts from Category', $widget_options, $control_options);
    }

    function widget($args, $instance)
    {
        global $theme;
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
    ?>
        <div class="widget-categories">
            <?php  if ( $title ) {  ?> <h2><?php echo $title; ?></h2> <?php }  ?>

        	<?php
                switch ($instance['order_by']) {
                    case 'none' : $order_query = ''; break;
                    case 'id_asc' : $order_query = '&orderby=ID&order=ASC'; break;
                    case 'id_desc' : $order_query = '&orderby=ID&order=DESC'; break;
                    case 'date_asc' : $order_query = '&orderby=date&order=ASC'; break;
                    case 'date_desc' : $order_query = '&orderby=date&order=DESC'; break;
                    case 'title_asc' : $order_query = '&orderby=title&order=ASC'; break;
                    case 'title_desc' : $order_query = '&orderby=title&order=DESC'; break;
                    default : $order_query = '&orderby=' . $instance['order_by'];
                    
                }
                $filter_query = '&cat=' . trim($instance['selected_category']) ;
                query_posts('posts_per_page=' . $instance['posts_number'] . $filter_query . $order_query);
                if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'large', true);
				?>
                    <div class="widget_post">
                        <?php if ($instance['display_featured_image'] && has_post_thumbnail() ) { ?><a href="<?php the_permalink(); ?>">
						<img src="<?php echo get_template_directory_uri(); ?>/scripts/timthumb.php?src=<?php echo $image_url[0]; ?>&h=45&w=45&zc=1" alt="" class="post_thumb_small"/>
						</a> <?php } ?>
                        <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                        
                        <?php echo home_excerpts(); ?>
                    </div>
                <?php
                endwhile; 
                endif;
                wp_reset_query();
            ?>

        </div>
        <?php
    }

    function update($new_instance, $old_instance) 
    {				
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_number'] = strip_tags($new_instance['posts_number']);
        $instance['order_by'] = strip_tags($new_instance['order_by']);
        $instance['display_featured_image'] = strip_tags($new_instance['display_featured_image']);
        $instance['selected_category'] = strip_tags($new_instance['selected_category']);
        return $instance;
    }
    
    function form($instance) 
    {	
        global $theme;
		$instance = wp_parse_args( (array) $instance, $theme->options['widgets_options']['posts'] );
        
        ?>
        
        <div class="tt-widget">
            <table width="100%">
                <tr>
                    <td class="tt-widget-label" width="25%"><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label></td>
                    <td class="tt-widget-content" width="75%"><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></td>
                </tr>
                
                <tr>
                    <td class="tt-widget-label"><label for="<?php echo $this->get_field_id('posts_number'); ?>">Nr of posts:</label></td>
                    <td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('posts_number'); ?>" name="<?php echo $this->get_field_name('posts_number'); ?>" type="text" value="<?php echo esc_attr($instance['posts_number']); ?>" /></td>
                </tr>
                
                <tr>
                    <td class="tt-widget-label"><label for="<?php echo $this->get_field_id('order_by'); ?>">Order by:</label></td>
                    <td class="tt-widget-content">
                        <select id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
                            <option value="none" <?php selected('none', $instance['order_by']); ?> >None (Default)</option>
                            <option value="id_asc" <?php selected('id_asc', $instance['order_by']); ?> >ID ( Ascending ) </option>
                            <option value="id_desc" <?php selected('id_desc', $instance['order_by']); ?> >ID ( Descending ) </option>
                            <option value="date_asc"  <?php selected('date_asc', $instance['order_by']); ?>>Date ( Ascending ) </option>
                            <option value="date_desc"  <?php selected('date_desc', $instance['order_by']); ?>>Date ( Descending ) </option>
                            <option value="title_asc" <?php selected('title_asc', $instance['order_by']); ?>>Title ( Ascending ) </option>
                            <option value="title_desc" <?php selected('title_desc', $instance['order_by']); ?>>Title ( Descending  ) </option>
                            <option value="rand" <?php selected('rand', $instance['order_by']); ?>>Random</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td class="tt-widget-label">Thumbnail:</td>
                    <td class="tt-widget-content">
                        <input type="checkbox" name="<?php echo $this->get_field_name('display_featured_image'); ?>"  <?php checked('true', $instance['display_featured_image']); ?> value="true" /> 
                    </td>
                </tr>
            
                <tr>
                    <td class="tt-widget-label">Category:</td>
                    <td class="tt-widget-content" style="padding-top: 5px;">
                        <select name="<?php echo $this->get_field_name('selected_category'); ?>">
                        <?php
                            $categories = get_categories('hide_empty=0');
                            foreach ($categories as $category) {
                                $category_selected = $this->get_field_name('selected_category') == $category->cat_ID ? ' selected="selected" ' : '';
                                ?>
                                <option value="<?php echo $category->cat_ID; ?>" <?php selected($category->cat_ID, $instance['selected_category']); ?> ><?php echo $category->cat_name; ?></option>
                                <?php
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                
            </table>
          </div>
        <?php 
    }
} 
?>