<?php
/**
 * The main template file for display archive page.
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
									</a>&nbsp;
									<a href="<?php echo gen_permalink(get_permalink(), 'quick_view=1'); ?>" class="quick_view"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_quick_view.png" style="width:16px" class="mid_align"/></a>
								</h2>
								<div class="post_detail">
									Posted by:&nbsp;<?php the_author_posts_link(); ?>&nbsp;&nbsp;&nbsp;
									Tags:&nbsp;
									<?php the_tags(''); ?>&nbsp;&nbsp;&nbsp;
									Posted date:&nbsp;
									<?php the_time('F j, Y'); ?> <?php edit_post_link('edit post', ', ', ''); ?>
									&nbsp;|&nbsp;
									<?php comments_number('No comment', 'One Comment', '% Comments'); ?>
								</div>
							</div>
							<br class="clear"/><br/>
							
							<?php if($image_thumb){ ?>
								<div class="post_img">
									<?php $thumb = theme_thumb($image_thumb, 60, 60, 'c');?>
									<img class="thumbnail" src="<?php echo $thumb ?>">
									<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_thumb; ?>&h=300&w=600&zc=1" alt="" />
								</div>

							<?php 
							}
							?>
							
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
					</div>
					
				</div>
				<!-- End main content -->
				
			</div>
			<br class="clear"/>
						
		<!-- End content -->
				

<?php get_footer(); ?>