<?php
/**
 * The main template file for display author page.
 *
 * @package WordPress
 * @subpackage Pim
*/

get_header(); 

?>

		<!-- Begin content -->
		<div id="content_wrapper">
		
			<div class="inner">
			
				<!-- Begin main content -->
				<div class="two_third">
				
					<div class="sidebar_content">
					
					<?php peerapong_breadcrumbs(); ?><br/>
					
<?php

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = get_post_meta(get_the_ID(), 'blog_thumb_image_url', true);
?>
						
						
						<!-- Begin each blog post -->
						<div class="post_wrapper">
							<div class="post_header">
								<h2 class="cufon">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_title(); ?>									
									</a>
								</h2>
								<div class="post_detail">
									Posted by:&nbsp;<?php the_author(); ?>&nbsp;&nbsp;&nbsp;
									Tags:&nbsp;
									<?php the_tags(''); ?>&nbsp;&nbsp;&nbsp;
									Posted date:&nbsp;
									<?php the_time('F j, Y'); ?> <?php edit_post_link('edit post', ', ', ''); ?>
									&nbsp;|&nbsp;
									<?php comments_number('No comment', 'Comment', '% Comments'); ?>
								</div>
							</div>
							<br class="clear"/><br/>
							
							<div class="post_img">
								<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_thumb; ?>&h=300&w=600&zc=1" alt="" />
							
								<div class="post_img_date">
									<?php the_time('F j, Y'); ?>
								</div>
							</div>
							
							<br class="clear"/>
							
							<?php echo get_the_content_with_formatting(); ?>
							
						</div>
						<!-- End each blog post -->
						



<?php endwhile; endif; ?>

						<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
						
					</div>
					
					</div>
					
					<div class="one_third last">
						<div class="sidebar">
							
							<div class="content">
							
								<ul class="sidebar_widget">
									<?php dynamic_sidebar('Blog Sidebar'); ?>
								</ul>
								
							</div>
						
						</div>
						<br class="clear"/>
					
						<div class="sidebar_bottom"></div>
					</div>
					
				</div>
				<!-- End main content -->
				
				<br class="clear"/>
			</div>
			
			<div class="bottom"></div>
			
		</div>
		<!-- End content -->
				

<?php get_footer(); ?>