<div id="content_wrapper">
		<div class="row">

		<div class="six columns push-three">
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
					<h4>
						<a href="#">
							<?php echo $featured_post->post_title; ?>
						</a>
					</h4>
					<div>
						<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_url; ?>&amp;h=300&amp;w=460&amp;zc=1" alt=""/>
						<br/><br/>
						<?php echo _substr(strip_tags(strip_shortcodes($featured_post->post_content)), 300); ?>
						<br/><br/>
						<a href="<?php echo gen_permalink($featured_post->guid, 'quick_view=1'); ?>" class="quick_view"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_quick_view.png" style="width:16px" class="mid_align"/>&nbsp;<strong>预览</strong></a>
						&nbsp;|&nbsp;
						<a href="<?php echo $featured_post->guid; ?>" title="<?php echo $featured_post->post_title; ?>"><strong>看全文</strong></a>
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
			<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Center Sidebar'); ?>
			</ul>
		</div>
			
		<div class="three columns pull-six">
		<!--<div class="one_fourth home_left">-->
			<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Left Sidebar'); ?>
			</ul>
		</div>
		
		<div class="three columns">
		<!--<div class="one_fourth home last">-->
			<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Right Sidebar'); ?>
			</ul>
		</div>
	</div>
</div>