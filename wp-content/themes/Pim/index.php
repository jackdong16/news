<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Pim
 */


// Get featured posts
$pp_featured_cat = get_option('pp_featured_cat');
$pp_featured_items = get_option('pp_featured_items');
if(empty($pp_featured_items))
{
	$pp_featured_items = 5;
}

$featured_posts_arr = get_posts('numberposts='.$pp_featured_items.'&order=DESC&orderby=date&category='.$pp_featured_cat);

get_header(); 

$pp_homepage_style = get_option('pp_homepage_style');
if(empty($pp_homepage_style))
{
	$pp_homepage_style = 'newspaper';
}

include (TEMPLATEPATH . "/templates/template-homepage-".$pp_homepage_style.".php");
?>

<?php get_footer(); ?>