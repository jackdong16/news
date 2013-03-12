<div class="row-fluid">
	<div class="span3">
		<ul class="sidebar_widget narrow_thumbnail">
			<?php dynamic_sidebar('HP_Top_Left_Sidebar'); ?>
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
									$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_post->ID ), 'single-post-thumbnail' );
									//$image_url = get_post_meta($featured_post->ID, 'blog_thumb_image_url', true);	
							?>
								<?php if ($image_url) { ?>
									<?php $thumb = theme_thumb($image_url[0], 468, 300, 'c'); // Crops from center ?>
									<div class="<?php if ($first_flag) echo "active" ?> item">
										<a href="<?php echo $featured_post->guid; ?>" title="<?php echo $featured_post->post_title; ?>">
											<img src="<?php echo $thumb ?>">
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
		
	</div>
	<div class="span3">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('HP_Top_Right_Sidebar'); ?>
		</ul>
	</div>
</div>

<hr>

<div class="row-fluid">
	<div class="span4">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('HP_2ndLayer_Left_Widget'); ?>
		</ul>
	</div>

	<div class="span4">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('HP_2ndLayer_Middle_Widget'); ?>
		</ul>
	</div>

<!-- 	<div class="span4">

	    <ul class="nav nav-tabs" id="homepageTab">
	    <li><a href="#popular" data-toggle="tab">今日头条</a></li>
	    <!-- <li><a href="#housing" data-toggle="tab">家居温哥华</a></li> 
	    <li><a href="#eat" data-toggle="tab">去哪吃</a></li>
	    <li><a href="#play" data-toggle="tab">去哪玩</a></li>
	    </ul>

	    <div id="homepage_popular">
		    <div class="tab-content wide_thumbail">
				<div class="tab-pane active" id="popular"><ul class="sidebar_widget"><?php dynamic_sidebar('Home Center Sidebar'); ?></ul></div>
				<div class="tab-pane" id="housing"><?php dynamic_sidebar('Home Center Sidebar'); ?></div>
				<div class="tab-pane" id="eat"><?php dynamic_sidebar('Home Center Sidebar'); ?></div>
				<div class="tab-pane" id="play"><?php dynamic_sidebar('Home Center Sidebar'); ?></div>
			</div>
		</div>


	    <script>
			$(function () {
				$('#homepageTab a[href="#popular"]').tab('show'); 
			// $('#myTab a:first').tab('show');
			})
		</script>

	</div> -->

	<div class="span4">
		<ul class="sidebar_widget">
			<?php dynamic_sidebar('HP_2ndLayer_Right_Widget'); ?>
		</ul>
	</div>
</div>