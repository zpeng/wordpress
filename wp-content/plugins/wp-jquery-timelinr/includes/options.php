<?php
function timelinr_page() {
	global $jqueryTimelinrLoad;
	$options = get_option('timelinr_options');
        
    if (isset($_POST['form_submit'])) {      
        $options['orientation'] 		= isset($_POST['orientation']) 			? $_POST['orientation'] 		: '';
		$options['arrowkeys']   		= isset($_POST['arrowkeys']) 			? $_POST['arrowkeys']  			: '';
        $options['autoplay']    		= isset($_POST['autoplay']) 			? $_POST['autoplay']  			: '';
        $options['autoplaydirection']   = isset($_POST['autoplaydirection'])	? $_POST['autoplaydirection']  	: '';
		$options['autoplaypause']   	= isset($_POST['autoplaypause'])		? $_POST['autoplaypause']  		: '';
        $options['startat']   			= isset($_POST['startat']) 				? $_POST['startat']  			: '';
		$options['order']   			= isset($_POST['order']) 				? $_POST['order']  				: '';
		$options['dateformat']  		= isset($_POST['dateformat']) 			? $_POST['dateformat']  		: '';
            
        echo '<div class="updated fade"><p>' . __('Settings Saved', 'tto') . '</p></div>';

        update_option('timelinr_options', $options);  
    }?>
    
    <div class="wrap options-timelinr"> 
   		<div id="icon-options-general" class="icon32"></div>
        <h2><?php _e( "Timelinr Settings", 'wp-jquery-timelinr' ) ?></h2>
        
        <div class="postbox-container" style="width:65%;">
			<div class="metabox-holder">
				<div class="meta-box-sortables"> 
					<form id="form_data" name="form" method="post">
					<?php
						$rows = array();
						$rows[] = array(
							'id'      => 'orientation',
							'label'   => 'Choose Style',
							'content' => $jqueryTimelinrLoad->select( 'orientation', array(
									'horizontal' => 'Horizontal',
									'vertical'  => 'Vertical',
								)
							),
						);
						$rows[] = array(
							'id'      => 'arrowkeys',
							'label'   => 'Arrowkeys?',
							'content' => $jqueryTimelinrLoad->select( 'arrowkeys', array(
									'false' => 'False',
									'true'  => 'True',
								)
							),
						);
						$rows[] = array(
							'id'      => 'autoplay',
							'label'   => 'Autoplay?',
							'content' => $jqueryTimelinrLoad->select( 'autoplay', array(
									'false' => 'False',
									'true'  => 'True',
								)
							),
						);
						$rows[] = array(
							'id'      => 'autoplaydirection',
							'label'   => 'Choose the autoplaydirection',
							'content' => $jqueryTimelinrLoad->select( 'autoplaydirection', array(
									'backward' => 'Backward',
									'fordward'  => 'Fordward',
								)
							),
						);
						$rows[]       = array(
							'id'      => 'autoplaypause',
							'label'   => 'Autoplay Pause#',
							'content' => $jqueryTimelinrLoad->textinput( 'autoplaypause' ),
						);
						$rows[]       = array(
							'id'      => 'startat',
							'label'   => 'Start At#',
							'content' => $jqueryTimelinrLoad->textinput( 'startat' ),
						);
						$rows[] = array(
							'id'      => 'order',
							'label'   => 'Order',
							'content' => $jqueryTimelinrLoad->select( 'order', array(
									'asc' => 'Asc',
									'desc'  => 'Desc',
								)
							),
						);
						$rows[] = array(
							'id'      => 'dateformat',
							'label'   => 'Choose Date Format',
							'content' => $jqueryTimelinrLoad->select( 'dateformat', array(
									'yy' => 'Year',
									'yy/mm' => 'Year/Month',
									'mm/yy'  => 'Month/Year',
								)
							),
						);
						$save_button = '<div class="submitbutton"><input type="submit" class="button-primary" name="submit" value="' . __( 'Update Timelinr Settings &raquo;' ) . '" /></div><br class="clear"/>';
						$jqueryTimelinrLoad->postbox( 'timelinr_general_options', 'General', $jqueryTimelinrLoad->form_table( $rows ) . $save_button);
						?>
						<input type="hidden" name="form_submit" value="true" />
		            </form>
				</div>
			</div>
		</div>
		
		<div class="postbox-container side" style="width:20%;">
			<div class="metabox-holder">
				<div class="meta-box-sortables">
					<?php
					$jqueryTimelinrLoad->postbox( 'timelinr-donation', '<strong class="blue">' . __( 'Help Spread the Word!' ) . '</strong>', 
						'<p><strong>' . __( 'Want to help make this plugin even better? All donations are used to improve this plugin, so donate $20, $50 or $100 now!' ) . '</strong></p>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="LCT5LX6S9JNSJ">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>'
						. '<p>' . __( 'Or you could:' ) . '</p>'
						. '<ul>'
						. '<li><a target="_blank" href="http://wordpress.org/extend/plugins/wp-jquery-timelinr/">' . __( 'Rate the plugin 5★ on WordPress.org' ) . '</a></li>'
						. '<li><a target="_blank" href="http://wordpress.org/tags/wp-jquery-timelinr">' . __( 'Help out other users in the forums' ) . '</a></li>'
						. '<li>' . sprintf( __( 'Blog about it & link to the %1$splugin page%2$s' ), '<a target="_blank" href="http://www.broobe.com/plugins/wp-jquery-timelinr/#utm_source=wpadmin&utm_medium=sidebanner&utm_term=link&utm_campaign=wptimelinrplugin">', '</a>' ) . '</li>' );
					
					?>
				</div>
				<br/><br/><br/>
			</div>
		</div>
	</div><?php            
} 
?>