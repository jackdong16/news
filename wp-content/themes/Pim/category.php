<?php
/**
 * The main template file for display category page.
 *
 * @package WordPress
 * @subpackage Pim
*/

get_header(); 

?>
<div id="category">
	<div class="row-fluid">
		<div class="span8">
			<?php dynamic_sidebar('Category Map Widget'); ?>
		</div>
		<div class="span4">
			<?php dynamic_sidebar('Category Mini Feed'); ?>
		</div>
	</div>
	<div class="row-fluid">
		<?php peerapong_breadcrumbs(); ?>
		<ul class="thumbnails">

		<?php
		if (have_posts()) : while (have_posts()) : the_post();


			$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	
			$thumb = theme_thumb($image_thumb[0], 200, 200, 'c'); // Crops from center
			if ( has_post_thumbnail() ) {
			?>
	      	
			  <li class="span3">
			    <div class="thumbnail clickable">
			    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
			      <img class="thumbnail" src="<?php echo $thumb ?>">
	              <div class="caption">
	                <h4>
	                	
							<?php the_title(); ?>									
						<a href="<?php echo gen_permalink(get_permalink(), 'quick_view=1'); ?>" class="quick_view"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_quick_view.png" style="width:16px" class="mid_align"/></a>
					</h4>
	                <p class="content"><?php echo cn_substr(get_the_content_with_formatting(), 50); ?></p>
	                <!-- <p><a href="#" class="btn btn-primary">Action</a> <a href="#" class="btn">Action</a></p> -->
	              </div>
	            </div>
			  </li>
			
					<?php 
					}
					?>
						
			<!-- Begin each blog post -->
			<!-- <div class="post_wrapper">
				<div class="post_header">
					<h2 class="cufon">
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
				
				

				<hr>
				
			</div> -->
		<?php endwhile; endif; ?>

		</ul>

		<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>

		<div class="span3">
			<ul class="widget">
				<?php dynamic_sidebar('Blog Sidebar'); ?>
			</ul>
		</div>
	</div>
</div>

<?php get_footer(); ?>