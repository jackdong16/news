<div class="row-fluid">
	<div class="narrow_thumbnail fixed_height span3">
		<?php dynamic_sidebar('HP_Top_Left_Sidebar'); ?>
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
		<div id="homepage_new_post">
			<a href="javascript:;" rel="165" class="btn btn-primary btn-large postpopup" data-loading-text="等一下..">
				分享吧！
	    	</a>
		</div>
	</div>
	<div class="fixed_height span3">
		<?php dynamic_sidebar('HP_Top_Right_Sidebar'); ?>
	</div>
</div>

<hr>

<div class="row-fluid">
	<div class="span6">
		<?php dynamic_sidebar('Homepage Map Widget'); ?>
	</div>
	<div class="span6">
		<div class="tabbable"> <!-- Only required for left/right tabs -->
		  <ul class="nav nav-tabs">
		    <!--<li class="active"><a href="#popular" data-toggle="tab">最火热</a></li>-->
		    <li><a href="#latest" data-toggle="tab">最新</a></li>
		  </ul>
		  <div class="tab-content">
		    <div class="tab-pane" id="popular">
				<?php dynamic_sidebar('Popular Rank Widget'); ?>
		    </div>
		    <div class="tab-pane active" id="latest">
		      	<?php dynamic_sidebar('Latest Rank Widget'); ?>
		    </div>
		  </div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span4">
		<?php dynamic_sidebar('HP_2ndLayer_Left_Widget'); ?>	
	</div>

	<div class="span4">
		<?php dynamic_sidebar('HP_2ndLayer_Middle_Widget'); ?>
	</div>

	<div class="span4">
		<?php dynamic_sidebar('HP_2ndLayer_Right_Widget'); ?>
	</div>
</div>