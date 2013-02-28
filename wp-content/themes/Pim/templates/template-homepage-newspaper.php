<div class="row-fluid">
	<div class="span3">
		<ul class="sidebar_widget narrow_thumbnail">
			<?php dynamic_sidebar('Home Left Sidebar'); ?>
		</ul>
	</div>
	<div class="span6">
		<?php
			if(!empty($featured_posts_arr))
			{
		?>
				<div id="myCarousel" class="carousel slide">
				    <ol class="carousel-indicators">
					    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					    <li data-target="#myCarousel" data-slide-to="1"></li>
					    <li data-target="#myCarousel" data-slide-to="2"></li>
					    <li data-target="#myCarousel" data-slide-to="3"></li>
					    <li data-target="#myCarousel" data-slide-to="4"></li>
				    </ol>
						<div class="carousel-inner">
							<?php
								$first_flag = true;
								foreach($featured_posts_arr as $featured_post)
								{
									$image_url = get_post_meta($featured_post->ID, 'blog_thumb_image_url', true);	
							?>
								<?php if ($image_url) { ?> <!-- hide articles if there are no images. TODO - remove no images articles in featured_posts_arr -->
									<div class="<?php if ($first_flag) echo "active" ?> item">
										<a href="<?php echo $featured_post->guid; ?>" title="<?php echo $featured_post->post_title; ?>">
											<img onerror="imgError(this);" src="<?php bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_url; ?>&amp;h=300&amp;w=460&amp;zc=1" alt=""/>
									    	<div class="carousel-caption">
							                  <h4><?php echo $featured_post->post_title; ?></h4>
							                  <!-- <p><?php echo _substr(strip_tags(strip_shortcodes($featured_post->post_content)), 300); ?></p> -->
							                </div>
						                </a>
									</div>
								

							<?php
									$first_flag = false;
									}
								}
							?>
					
						</div>
					<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
					<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
				</div>
		<?php
			}
		?>
		
		<br class="clear"/>
		
	    <ul class="nav nav-tabs" id="myTab">
	    <li><a href="#popular" data-toggle="tab">热门</a></li>
	    <li><a href="#commented" data-toggle="tab">最多讨论</a></li>
	    <li><a href="#liked" data-toggle="tab">最多喜欢</a></li>
	    </ul>

	    <div class="tab-content wide_thumbail">
			<div class="tab-pane active" id="popular">
				<ul class="sidebar_widget">
					<?php dynamic_sidebar('Home Center Sidebar'); ?>
				</ul>
			</div>
			<div class="tab-pane" id="commented">...</div>
			<div class="tab-pane" id="liked">...</div>
		</div>


	    <script>
			$(function () {
				$('#myTab a[href="#popular"]').tab('show'); 
			// $('#myTab a:first').tab('show');
			})
		</script>

		
	</div>
	<div class="span3">
		<ul class="sidebar_widget">
				<?php dynamic_sidebar('Home Right Sidebar'); ?>
			</ul>
	</div>
</div>

<div class="row-fluid">
	<div class="span3">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('Home Bottom Left Sidebar'); ?>
		</ul>
	</div>

	<div class="span6">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('Home Bottom Center Sidebar'); ?>
		</ul>
	</div>

	<div class="span3">

	</div>
</div>