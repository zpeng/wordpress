<?php global $theme; ?>


</div>

</div>
</div>

   
   <div class="footer">
       <div class="footer_content">
       <div class="footer_text">
           Copyright © All Rights Reserved.
       </div>
       <div class="footer_menu">
			<?php
            /* don't show the bottom menu
            if (function_exists('wp_nav_menu')) {
            wp_nav_menu( array( 'theme_location' => 'theme-main-fmenu', 'fallback_cb' => 'theme_default_menu', 'container_class' => 'footermenu', 'menu_id' => 'main_menu_footer', 'menu_class' => 'main_menu_footer') );
            }
            else {
            theme_default_menu();
            }
            */

           $date = strtotime("June 1, 2013 1:00 PM");
           $remaining = $date - time();

           $days_remaining = floor($remaining / 86400);
           $hours_remaining = floor(($remaining % 86400) / 3600);
           echo "Wedding day countdown: move $days_remaining days and $hours_remaining hours left";

            ?>
       </div>
       <div class="clear"></div>
       </div>
       
   </div>

<?php wp_footer(); ?>
<?php $theme->option('analytics_code'); ?>
<?php if ( !is_home() ) { ?>
<script type="text/javascript">
$(".videocontainer").fitVids();
</script>
<?php } ?>
<script type="text/javascript">
var main_menu=new main_menu.dd("main_menu");
main_menu.init("main_menu","menuhover");
</script>
</body>
</html>
