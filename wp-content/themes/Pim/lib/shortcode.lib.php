<?php

// [dropcap foo="foo-value"]
function dropcap_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'style' => 1
	), $atts));
	
	//get first char
	$first_char = substr($content, 0, 1);
	$text_len = strlen($content);
	$rest_text = substr($content, 1, $text_len);

	$return_html = '<span class="dropcap'.$style.'">'.$first_char.'</span>';
	$return_html.= do_shortcode($rest_text);
	
	return $return_html;
}
add_shortcode('dropcap', 'dropcap_func');




// [quote foo="foo-value"]
function quote_func($atts, $content) {
	
	$return_html = '<blockquote>'.do_shortcode($content).'</blockquote>';
	
	return $return_html;
}
add_shortcode('quote', 'quote_func');



// [button foo="foo-value"]
function button_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something',
		'link' => '',
		'size' => '',
		'align' => '',
	), $atts));
	
	if(!empty($size))
	{
		$size.= '_';
	}
	
	$return_html = '<a class="'.$size.'button '.$align.'" href="'.$link.'">';
	$return_html.= '<span>'.$text.'</span>';
	$return_html.= '</a>';
	
	return $return_html;
}
add_shortcode('button', 'button_func');




// [highlight foo="foo-value"]
function highlight_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'text' => 'something',
		'style' => '1',
	), $atts));
	
	$return_html = '<span class="highlight'.$style.'">'.$text.'</span>';
	
	return $return_html;
}
add_shortcode('highlight', 'highlight_func');




function frame_left_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_left">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_left', 'frame_left_func');




function frame_right_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_right">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_right', 'frame_right_func');



function frame_center_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));
	
	$return_html = '<div class="frame_center">';
	
	if(!empty($href))
	{
		$return_html.= '<a href="'.$href.'" class="img_frame">';
	}
	
	$return_html.= '<img src="'.$src.'" alt=""/>';
	
	if(!empty($href))
	{
		$return_html.= '</a>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<span class="caption">'.$content.'</span>';
	}
	
	$return_html.= '</div>';
	
	return $return_html;
}
add_shortcode('frame_center', 'frame_center_func');




function arrow_list_func($atts, $content) {
	
	$return_html = '<ul class="arrow_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('arrow_list', 'arrow_list_func');




function check_list_func($atts, $content) {
	
	$return_html = '<ul class="check_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('check_list', 'check_list_func');




function star_list_func($atts, $content) {
	
	$return_html = '<ul class="star_list">'.html_entity_decode(strip_tags($content,'<li><a>')).'</ul>';
	
	return $return_html;
}
add_shortcode('star_list', 'star_list_func');



function one_half_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half '.$class.'">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half', 'one_half_func');




function one_half_last_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'class' => '',
	), $atts));
	
	$return_html = '<div class="one_half last '.$class.'">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_half_last', 'one_half_last_func');



function one_third_func($atts, $content) {
	
	$return_html = '<div class="one_third">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third', 'one_third_func');




function one_third_last_func($atts, $content) {
	
	$return_html = '<div class="one_third last">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_third_last', 'one_third_last_func');



function two_third_func($atts, $content) {
	
	$return_html = '<div class="two_third">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third', 'two_third_func');




function two_third_last_func($atts, $content) {
	
	$return_html = '<div class="two_third last">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('two_third_last', 'two_third_last_func');




function one_fourth_func($atts, $content) {
	
	$return_html = '<div class="one_fourth">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth', 'one_fourth_func');




function one_fourth_last_func($atts, $content) {
	
	$return_html = '<div class="one_fourth last">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fourth_last', 'one_fourth_last_func');



function one_fifth_func($atts, $content) {
	
	$return_html = '<div class="one_fifth">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fifth', 'one_fifth_func');




function one_fifth_last_func($atts, $content) {
	
	$return_html = '<div class="one_fifth last">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_fifth_last', 'one_fifth_last_func');



function one_sixth_func($atts, $content) {
	
	$return_html = '<div class="one_sixth">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_sixth', 'one_sixth_func');




function one_sixth_last_func($atts, $content) {
	
	$return_html = '<div class="one_sixth last">'.do_shortcode($content).'</div>';
	
	return $return_html;
}
add_shortcode('one_sixth_last', 'one_sixth_last_func');



function pp_gallery_func($atts, $content) {

	//extract short code attr
	/*extract(shortcode_atts(array(
		'src' => '',
	), $atts));*/
	
	$return_html = '<div class="pp_gallery">'.html_entity_decode(strip_tags($content,'<img><a>')).'</div>';
	
	return $return_html;
}
add_shortcode('pp_gallery', 'pp_gallery_func');


function recent_posts_func($atts) {
	
	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 5,
	), $atts));

	$return_html = peerapong_posts('recent', $items, FALSE);
	
	return $return_html;
}
add_shortcode('recent_posts', 'recent_posts_func');



function popular_posts_func($atts) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 5,
	), $atts));

	$return_html = peerapong_posts('poopular', $items, FALSE);
	
	return $return_html;
}
add_shortcode('popular_posts', 'popular_posts_func');


function cat_posts_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'cat_id' => '',
		'items' => 5,
	), $atts));

	$return_html = peerapong_cat_posts($cat_id, $items, FALSE);
	
	return $return_html;
}
add_shortcode('cat_posts', 'cat_posts_func');


function recent_comments_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 5,
	), $atts));

	$return_html = peerapong_recent_comments($items, FALSE);
	
	return $return_html;
}
add_shortcode('recent_comments', 'recent_comments_func');


function photos_in_news_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'items' => 10,
	), $atts));

	$return_html = peerapong_photos_in_news($items, FALSE);
	
	return $return_html;
}
add_shortcode('photos_in_news', 'photos_in_news_func');


function banner_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'src' => '',
		'href' => '',
	), $atts));

	$return_html = '<a href="'.$href.'" style="float:left;display:block;margin-right:5px">';
	$return_html.= '<img src="'.$src.'" alt=""/>';
	$return_html.= '</a>';
	
	return $return_html;
}
add_shortcode('banner', 'banner_func');


function alert_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'type' => 'info',
	), $atts));
	
	$return_html = '<div class="alert_'.$type.'" style="margin-top:0">';
	$return_html.= '<p><img src="'.get_bloginfo( 'stylesheet_directory' ).'/images/icon_'.$type.'.png" alt="'.$type.'" class="mid_align"/>';
	$return_html.= $content.'</p></div>';
	
	return $return_html;
}
add_shortcode('alert', 'alert_func');


?>