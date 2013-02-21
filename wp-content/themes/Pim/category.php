<?php
/**
 * The main template file for display category page.
 *
 * @package WordPress
 * @subpackage Pim
*/

get_header(); 

?>

<div class="row-fluid">
	<div class="span9">
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
				
				<div class="post_img">
					<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_thumb; ?>&amp;h=300&amp;w=600&amp;zc=1" alt="" />
				</div>
				
				<br class="clear"/>
				
				<?php echo get_the_content_with_formatting(); ?>

				<hr>
				
			</div>
			<!-- End each blog post -->
		<?php endwhile; endif; ?>

		<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
	</div>
	<div class="span3">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('Blog Sidebar'); ?>
		</ul>
	</div>
</div>				

<?php get_footer(); ?>