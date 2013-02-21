<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Pim
 */
?>

		<footer class="footer">
	      <!-- div class="container-fluid"> -->
	        <?php

					$pp_footer_text = get_option('pp_footer_text');

					if(empty($pp_footer_text))
					{
						$pp_footer_text = 'Copyright © 2013 :)';
					}
					
					echo $pp_footer_text;
				?>
	        <?php 	
					//Get page nav
					wp_nav_menu( 
						array( 
							'menu_id'			=> 'footer_menu',
							'menu_class'		=> 'footer-links',
							'theme_location' 	=> 'footer-menu',
						) 
					);
			?>
	      <!-- </div> -->
	    </footer>
	    </div>
<?php
		/**
    	*	Setup Google Analyric Code
    	**/
    	include (TEMPLATEPATH . "/google-analytic.php");
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
