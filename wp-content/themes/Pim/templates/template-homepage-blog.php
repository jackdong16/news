<div id="content_wrapper">
		<div class="two_third">
			<h2>Top News</h2><hr/>
			
			<?php
				if(!empty($featured_posts_arr))
				{
			?>
			
			<div id="featured_posts">
			
			<?php
					foreach($featured_posts_arr as $featured_post)
					{
						$image_url = get_post_meta($featured_post->ID, 'blog_thumb_image_url', true);
			?>
					<h3>
						<a href="#">
							<?php echo $featured_post->post_title; ?>
						</a>
					</h3>
					<div>
						<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_url; ?>&h=340&w=590&zc=1" alt=""/>
						<br/><br/>
						<?php echo _substr(strip_tags(strip_shortcodes($featured_post->post_content)), 300); ?>
						<br/><br/>
						<a href="<?php echo gen_permalink($featured_post->guid, 'quick_view=1'); ?>" class="quick_view"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_quick_view.png" style="width:16px" class="mid_align"/>&nbsp;<strong>QuickView</strong></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $featured_post->guid; ?>" title="<?php echo $featured_post->post_title; ?>"><strong>Read Full Article</strong></a>
						<br/><br/><hr/>
					</div>
			<?php
					}
			?>
			
				</div>
				
			<?php
				}
			?>
			
			<br class="clear"/><br/>
			
			<h2>Recent Posts</h2><hr/>
			
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
		
		<div class="one_third last">
			<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Right Sidebar'); ?>
			</ul>
		</div>
	</div>