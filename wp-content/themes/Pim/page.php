<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
 * @subpackage Pim
*/


/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}


/**
*	Check if contact page
**/
$pp_contact_page = get_option('pp_contact_page');
/**
*	if contact page
**/
if($current_page_id == $pp_contact_page)
{
    include (TEMPLATEPATH . "/templates/template-contact.php");
    exit;
}

/**
*	if other page
**/
else
{

$page_style = get_post_meta($current_page_id, 'page_style', true);
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

if(empty($page_style))
{
	$page_style = 'Fullwidth';
}

$add_sidebar = FALSE;
if($page_style == 'Right Sidebar')
{
	$add_sidebar = TRUE;
}
else
{
	$page_class = 'inner_wrapper';
}

get_header(); 
?>

<?php if ( 'forum' != get_post_type() ){ //Dont display the title if it's the forum page ?>
<!--Title-->
<div class="row-fluid">
	<div class="span9">
		<h4><?php the_title(); ?></h4>
	</div>
</div>
<?php } ?>

<!--Content-->
<div class="row-fluid">
	<div class="span9">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		
						
			<?php if($add_sidebar) { ?>
				<div class="two_third">
			<?php } ?>
			
					<?php do_shortcode(the_content()); ?>
					
			<?php if($add_sidebar) { ?>
				</div>
			<?php } ?>

		<?php endwhile; ?>
		
		<?php
			if($add_sidebar)
			{
		?>
			<div class="one_third last">
				<div class="sidebar">
				
					<div class="content">
				
						<ul class="widget">
						<?php dynamic_sidebar($page_sidebar); ?>
						</ul>
					
					</div>
			
				</div>
				<br class="clear"/>
		
				<div class="sidebar_bottom"></div>
			</div>
		<?php
			}
		?>
	</div>
	<div class="span3">
		<?php dynamic_sidebar( 'Forum Login Sidebar' ); ?>
	</div>
</div>

<?php get_footer(); ?>

<?php
}
//end if other page
?>