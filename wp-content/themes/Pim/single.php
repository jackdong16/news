<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
 * @subpackage Pim
*/

if(isset($_GET['quick_view']) && $_GET['quick_view'])
{
	include (TEMPLATEPATH . "/templates/template-quick_view.php");
    exit;
}

get_header(); 

?>

<?php

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = get_post_meta(get_the_ID(), 'blog_thumb_image_url', true);
?>

<!--Title-->
<div class="row-fluid">
	<div class="span9">
		<?php if(function_exists('up_down_post_votes')) { $return_html.= up_down_post_votes( $post->ID ); }?>
		<h1 id="post_title"><?php the_title(); ?></h1>

		<div id="post_detail">
			<!-- Posted by:&nbsp;<?php the_author_posts_link(); ?>&nbsp;&nbsp;&nbsp;
			Tags:&nbsp;
			<?php the_tags(''); ?>&nbsp;&nbsp;&nbsp;
			Posted date:&nbsp; -->
			<?php the_time('Y/m/d g:i A'); ?> <?php edit_post_link('edit post', ', ', ''); ?>
			&nbsp;|&nbsp;
			<?php comments_number('No comment', 'Comment', '% Comments'); ?>
		</div>

		<?php echo the_content(); ?>
	</div>

	<div class="span3">
		<ul class="widget">
			<?php dynamic_sidebar('PostPage_Sidebar'); ?>
		</ul>
	</div>

</div>

<!--Post Img-
<div class="row">
	<div class="nine columns">
		<div class="post_img">
		<img src="<?php echo get_bloginfo( 'stylesheet_directory' ); ?>/timthumb.php?src=<?php echo $image_thumb; ?>&h=300&w=600&zc=1" alt="" />

		<div class="post_img_date">
			<?php the_time('F j, Y'); ?>
		</div>
		</div>
	</div>
</div>-->

<!--Social Media-->
<div class="row-fluid">
	<div class="span9">
		<ul id="share" class="social_media">
			<h5>分享</h5>
			<hr/>
			<li>
				<a href="http://twitter.com/home?status=<?=the_title()?> <?=the_permalink()?>" title="Retweet">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/twitter_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://delicious.com/post?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Delicious">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/delicious_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://digg.com/submit?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Digg it">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/digg_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://www.facebook.com/share.php?u=<?=the_permalink()?>&t=<?=the_title()?>" title="Share to Facebook">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/facebook_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://posterous.com/share?linkto=<?=the_permalink()?>&title=<?=the_title()?>" title="Posterous">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/posterous_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://www.mixx.com/submit?page_url=<?=the_permalink()?>&title=<?=the_title()?>" title="Mixx">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/mixx_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://www.stumbleupon.com/submit?url=<?=the_permalink()?>&title=<?=the_title()?>" title="Stumbleupon">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/stumbleupon_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="mailto:?body=&subject=<?=the_title()?>" title="Email this">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/email_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://www.tumblr.com/share?u=<?=the_permalink()?>&t=<?=the_title()?>" title="Tumblr">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/tumblr_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://reporter.nl.msn.com/?fn=contribute&URL=<?=the_permalink()?>&Title=<?=the_title()?>" title="MSN">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/windows_32.png" alt=""/>
				</a>
			</li>
			<li>
				<a href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?=the_permalink()?>&title=<?=the_title()?>&annotation=" title="Google Bookmark">
					<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/share/google_32.png" alt=""/>
				</a>
			</li>
		</ul>
	</div>
</div>
<!-- End each blog post -->

<!--About Author
<div class="row">
	<div class="nine columns">
		<div id="about_the_author">
			<div class="header">
				<h5>About the author</h5>
				<hr/>
			</div>
			<div class="thumb"><?php echo get_avatar( get_the_author_email(), '100' ); ?></div>
			<div class="description">
				<strong><?php the_author_posts_link(); ?></strong><br/>
				<?php the_author_description(); ?>
			</div>
		</div>
	</div>
</div>
-->
							
<!--List 5 post titles related to first tag on current post-->
<div class="row-fluid">
	<div class="span9">
		<?php
		//for use in the loop, list 5 post titles related to first tag on current post
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
		  $first_tag = $tags[0]->term_id;
		  $args=array(
		    'tag__in' => array($first_tag),
		    'post__not_in' => array($post->ID),
		    'showposts'=>5,
		    'caller_get_posts'=>1
		   );
		  $my_query = new WP_Query($args);
		  if( $my_query->have_posts() ) {
		  	echo '<br class="clear"/><h5>相关文章</h5><hr/>';
		  	echo '<ul id="related">';
		  
		    while ($my_query->have_posts()) : $my_query->the_post(); 
		    	$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true); 
		    ?>
		    	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"></a>
		      	<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></strong><br/><a href="<?php echo gen_permalink(get_permalink(), 'quick_view=1'); ?>" class="quick_view"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_quick_view.png" style="width:16px" class="mid_align"/></a><?php the_time(get_option('date_format')); ?><br/><?php echo peerapong_substr(strip_shortcodes($post->post_content), 150); ?></li>
		      <?php
		    endwhile;
		    
		    wp_reset_query();
		    
		    echo '</ul>';
		  }
		}
		?>
	</div>
</div>					

<!--Comments-->
<div class="row-fluid">
	<div class="span9">
		<?php comments_template( '' ); ?>
	</div>
</div>


<?php endwhile; endif; ?>

<div class="row-fluid">
	<div class="span9">
		<div class="sidebar_bottom"></div>
	</div>
</div>
				

<?php get_footer(); ?>