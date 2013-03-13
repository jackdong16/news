<?php
/**
 * The main template file for display search page.
 *
 * @package WordPress
 * @subpackage Pim
*/

get_header(); 

?>

<div id="search">

	<?php peerapong_breadcrumbs(); ?>

	<!--Content-->
	<div class="row-fluid">
		<li class="span9">
			<?php
			if (have_posts()) : while (have_posts()) : the_post();


				$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	
				$thumb = theme_thumb($image_thumb[0], 60, 60, 'c'); // Crops from center
				?>

					
					<div class="thumbnail clearfix clickable">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
					      	<img class="thumbnail" src="<?php echo $thumb ?>">
			              	<div class="caption">
				                <h4 class="title"><?php the_title(); ?></h4>
								<h5 class="post_content"><?php echo cn_substr(get_the_content_with_formatting(), 50); ?></h5>
			              	</div>
			              			
				            
		            </div>

	            
				<!-- End each blog post -->
			<?php endwhile; endif; ?>
			
			<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>

		</li>

		<li class="span3">
			<ul class="sidebar_widget">
				<?php //dynamic_sidebar('Blog Sidebar'); ?>
			</ul>
		</li>
	</div>
</div>
<?php get_footer(); ?>