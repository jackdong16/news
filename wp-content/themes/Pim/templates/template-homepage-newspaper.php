<!--<div id="content_wrapper">-->
<div class="row-fluid">
	<div class="span9">
				    <a class="brand" href="#">
	    	<?php
				//get custom logo
				$pp_logo = get_option('pp_logo');
				
				if(empty($pp_logo))
				{	
					if($pp_skin != 'black')
					{
						//$pp_logo = get_bloginfo( 'stylesheet_directory' ).'/images/logo_black.png';
					}
					else
					{
						//$pp_logo = get_bloginfo( 'stylesheet_directory' ).'/images/logo_white.png';
					}
				}
			?>
			<h2><?php bloginfo('name'); ?></h2>
			<a id="custom_logo" href="<?php bloginfo( 'url' ); ?>"><img src="<?php echo $pp_logo; ?>" alt=""/></a></a>
            <?php 	
				wp_nav_menu( 
					array( 
						'menu_id'			=> 'main_nav',
			        	'menu_class'		=> 'nav',
						'theme_location' 	=> 'primary-menu',
					) 
				);
			?>
	</div>
</div>


<div class="row-fluid">
	<div class="span3">
		<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Left Sidebar'); ?>
			</ul>
	</div>
	<div class="span6">
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
	<div class="span3">
		<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Right Sidebar'); ?>
			</ul>
	</div>
</div>