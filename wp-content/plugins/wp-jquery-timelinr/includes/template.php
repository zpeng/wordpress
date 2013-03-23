<?php 
$container = $atts["containerdiv"];

if ($atts["category"] != ""){
	$args = array(
	    'post_type' => 'timelinr',
	    'posts_per_page' => -1,
	    'tax_query' => array(
		    array(
		        'taxonomy' => 'timelinr_cats',
		        'terms' => $atts["category"],
		        'field' => 'slug',
		    ),
		),
	    'meta_key' => 'timelineDate',
		'meta_compare' => '>',
		'orderby' => 'meta_value',
		'order' => $atts["order"]
	);
}else{
	$args = array(
	    'post_type' => 'timelinr',
	    'posts_per_page' => -1,
	    'meta_key' => 'timelineDate',
		'meta_compare' => '>',
		'orderby' => 'meta_value',
		'order' => 'DESC'
	);
}

$timelinr_query = new WP_Query( $args );
if ($timelinr_query->have_posts()):?>
	<div <?php if (!empty($container)) echo 'class="'.$container.'"'; ?>>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
			 	$('<?php if (!empty($container)) echo ".".$container." "; ?>.timeline').timelinr({
				 	orientation: '<?php echo $atts['orientation']; ?>',
				    // value: horizontal | vertical, default to horizontal
				    containerDiv: '<?php echo $atts['containerdiv']; ?>',
				    // value: any HTML tag or #id, default to #timeline
					datesSpeed: 'normal',
				    // value: integer between 100 and 1000 (recommended) or 'slow', 'normal' or 'fast'; default to normal
			  		issuesSpeed: 'fast',
				    // value: integer between 100 and 1000 (recommended) or 'slow', 'normal' or 'fast'; default to fast
				    issuesTransparency: 0.2,
				    // value: integer between 0 and 1 (recommended), default to 0.2
				    issuesTransparencySpeed: 500,
				    // value: integer between 100 and 1000 (recommended), default to 500 (normal)
				    arrowKeys: '<?php echo $atts['arrowkeys']; ?>',
				    // value: true/false, default to false
				    startAt: <?php echo $atts['startat']; ?>,
				    // value: integer, default to 1 (first)
				    autoPlay: '<?php echo $atts['autoplay']; ?>',
				    // value: true | false, default to false
				    autoPlayDirection: '<?php echo $atts['autoplaydirection']; ?>',
				    // value: forward | backward, default to forward
				    autoPlayPause: <?php echo $atts['autoplaypause']; ?>
				    // value: integer (1000 = 1 seg), default to 2000 (2segs)< });
			   });
			});
		</script>
		<div class="timeline">
			<ul class="dates">
		    <?php  
			while ($timelinr_query->have_posts()) : $timelinr_query->the_post();
			 	$timelineDate = get_post_meta($post->ID, 'timelineDate', 'true');
			 	
			 	$date = $this->get_date_format($timelineDate, $atts['dateformat']);
			 	echo '<li><a href="#">'.$date.'</a></li>';
			endwhile;
			?>
			</ul>
			<ul class="issues"><?php 
				while ($timelinr_query->have_posts()) : $timelinr_query->the_post();
					//$timelineDate = get_post_meta($post->ID, 'timelineDate', 'true');
				 	echo '<li id="date'.$post->ID.'">';
				 	echo get_the_post_thumbnail($post->ID, "small" );
					echo '<span>'.$post->post_title.'</span>';
				 	echo '<p>'.$post->post_content.'</p>';
					echo '</li>';
				endwhile;?> 
		   	</ul>
		   	<a href="#" class="next">+</a>
	   		<a href="#" class="prev">-</a>
	   	</div>
   	</div><?php 	
endif;?>
