<?php
/*
Template Name: Contact
*/
get_header(); ?>

<!-- form validation scripts -->
<script src="<?php echo get_template_directory_uri(); ?>/scripts/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
	// initialize form validation
	jQuery(document).ready(function() {
		$("#CommentForm").validate({
			submitHandler: function(form) {
				// form is valid, submit it
				ajaxContact(form);
				return false;
			}
		});
	});
</script>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="pages_title"><h2><?php the_title(); ?></h2></div> 
        
<div class="content">    
        <div class="left23">

           <div class="post" id="post-<?php the_ID(); ?>">
                    <div class="pageentry">
                    <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                    </div>
                    
                
                                
                    <!-- Contact form -->                                        
                    <?php if($theme->get_option('show_contact_form') == 'enable') { ?>
                    <div class="form_content">
                    <h3 class="form_subtitle"><?php $theme->option('contact_form_title'); ?></h3>
                    <div id="Note"></div>
                    <div class="form">
                    <form class="cmxform" id="CommentForm" method="post" action="">
                            <div class="form_row">
                                <label for="ContactName" class="overlabel">Name</label>
                                <input id="ContactName" name="ContactName" class="form_input required" />
                            </div>                            
                            <div class="form_row">
                                <label for="ContactEmail" class="overlabel">E-Mail</label>
                                <input id="ContactEmail" name="ContactEmail" class="form_input required email" />
                            </div>
                            <div class="form_row">
                                <label for="ContactComment" class="overlabel">Message</label>
                                <textarea id="ContactComment" name="ContactComment" class="form_textarea required" rows="10" cols="4"></textarea>
                            </div>
                            <div class="form_row">
                                <input type="submit" name="submit" class="form_submit_contact" id="submit" value="Send" />
                                <input class="" type="hidden" name="to" value="<?php echo $theme->get_option("contactemail");?>" />
                                <input class="" type="hidden" name="subject" value="<?php echo $theme->get_option("contactsubject");?>" />
                                <div id="loader" style="display:none;"><img src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" alt="Loading..." id="LoadingGraphic" /></div>
                            </div>
                    </form>
                    </div>
                    </div>
                    <?php } else {}?> 
             </div>
        
        </div>
        <?php endwhile; endif; ?>
      <?php get_template_part ('sidebar_contact'); ?>              
</div>

<div class="clear"></div> 
    
    
<script type="text/javascript">  
	// Contact form submit function        
	function ajaxContact(theForm) {
		var $ = jQuery;
        $('#loader').fadeIn();
        var formData = $(theForm).serialize(),
			note = $('#Note');
        $.ajax({
            type: "POST",
            url: "<?php echo get_template_directory_uri(); ?>/contact-send.php",
            data: formData,
            success: function(response) {
				if ( note.height() ) {			
					note.fadeIn('fast', function() { $(this).hide(); });
				} else {
					note.hide();
				}
				$('#LoadingGraphic').fadeOut('fast', function() {
					if (response === 'success') {
						$(theForm).animate({opacity: 0},'fast');
					}
					// Message Sent? Show the 'Thank You' message and hide the form
				result = '';
					c = '';
					if (response === 'success') { 
						result = '<?php echo $theme->get_option("contactsucces"); ?>';
						c = 'success';
					} else {
						result = response;
						c = 'error';

					}
					note.removeClass('success').removeClass('error').text('');
					var i = setInterval(function() {
						if ( !note.is(':visible') ) {

							note.html(result).addClass(c).slideDown('fast');
							clearInterval(i);
						}

					}, 40);    
				}); // end loading image fadeOut
            }
        });

        return false;
    }
</script>  
<?php get_footer(); ?>