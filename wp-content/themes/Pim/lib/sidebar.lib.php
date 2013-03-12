<?php
/**
*	Setup Home left column side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_Top_Left_Sidebar'));
    
/**
*	Setup Home right column side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_Top_Right_Sidebar'));
    
/**
*	Setup Home center column side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Home Center Sidebar'));

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_2ndLayer_Left_Widget'));

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_2ndLayer_Middle_Widget'));

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'HP_2ndLayer_Right_Widget'));

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Forum Login Sidebar'));

/**
*	Setup Page side bar
**/
if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Page Sidebar'));
    
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