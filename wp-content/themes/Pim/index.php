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

$args = array( 
  'numberposts' => $items, 
  'orderby' => 'date', 
  'order' => 'DESC',
  'meta_key' => '_thumbnail_id'
);

$featured_posts_arr = get_posts( $args );

get_header(); 

$pp_homepage_style = get_option('pp_homepage_style');
if(empty($pp_homepage_style))
{
	$pp_homepage_style = 'newspaper';
}

include (TEMPLATEPATH . "/templates/template-homepage-".$pp_homepage_style.".php");
?>

<?php get_footer(); ?>