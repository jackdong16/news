<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
 * @subpackage Pim
*/

?>
		<div class="quick_view_wrapper">
		
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
									Posted by:&nbsp;<?php the_author_posts_link(); ?>&nbsp;&nbsp;&nbsp;
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
							</div>
							
							<br class="clear"/><br/>
							
							<?php echo the_content(); ?>
							
<?php endwhile; endif; ?>
		
		</div>