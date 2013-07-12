<?php

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_Top_Left_Sidebar'));
    register_sidebar(array('name' => 'HP_Carousel_Widget'));
    register_sidebar(array('name' => 'HP_Top_Right_Sidebar'));
    
/**
*	Setup Home center column side bar
**/
if ( function_exists('register_sidebar') ){
    register_sidebar(array('name' => 'Home Center Sidebar'));
    register_sidebar(array('name' => 'Homepage Map Widget'));
    register_sidebar(array('name' => 'Popular Rank Widget'));
    register_sidebar(array('name' => 'Latest Rank Widget'));
    
    register_sidebar(array('name' => 'HP_Popular_Post_Widget'));
    register_sidebar(array('name' => 'HP_Category1_Widget'));
    register_sidebar(array('name' => 'HP_Category2_Widget'));
    register_sidebar(array('name' => 'HP_Category3_Widget'));
    register_sidebar(array('name' => 'HP_Category4_Widget'));
    register_sidebar(array('name' => 'HP_Category5_Widget'));
    register_sidebar(array('name' => 'Forum Login Sidebar'));
}

if ( function_exists('register_sidebar') ){
    register_sidebar(array('name' => 'Category Recent Mini Feed'));
    register_sidebar(array('name' => 'Category Carousel'));
    register_sidebar(array('name' => 'Category Popular Mini Feed'));
}
/**
*	Setup Contact side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Contact Sidebar'));
    
    
/*	Setup PostPage side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'PostPage_Sidebar'));
    
    
/*	Setup Footer side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Footer Sidebar'));
    

    
//Register dynamic sidebar
$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		if ( function_exists('register_sidebar') )
	    register_sidebar(array('name' => $sidebar));
	}
}
?>