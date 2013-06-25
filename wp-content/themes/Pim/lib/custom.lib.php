<?php
/**
*	Custom function to get current URL
**/
function curPageURL() {
 	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
 	 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
 	 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}
    
function peerapong_debug($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function gen_permalink($current_url = '', $additional = '')
{
	$current_arr = parse_url($current_url);
	
	$start = '';
	if(isset($current_arr['query']) && !empty($current_arr['query']))
    {
    	$start = '&amp;';
    }
    else
    {
    	$start = '?';
    }
    
    return $current_url.$start.$additional;
}

function gen_pagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=10) 
{ 
    if(!$total OR !$currentPage OR !$baseLink) 
    { 
        return false; 
    } 

    //Total Number of pages 
    $totalPages = ceil($total/$limit); 
     
    //Text to use after number of pages 
    //$txtPagesAfter = ($totalPages==1)? " page": " pages"; 
     
    //Start off the list. 
    //$txtPageList = '<br />'.$totalPages.$txtPagesAfter.' : <br />'; 
     
    //Show only 3 pages before current page(so that we don't have too many pages) 
    $min = ($page - 3 < $totalPages && $currentPage-3 > 0) ? $currentPage-3 : 1; 
     
    //Show only 3 pages after current page(so that we don't have too many pages) 
    $max = ($page + 3 > $totalPages) ? $totalPages : $currentPage+3; 
     
    //Variable for the actual page links 
    $pageLinks = ""; 
    
    $baseLinkArr = parse_url($baseLink);
    $start = '';
    
    if(isset($baseLinkArr['query']) && !empty($baseLinkArr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
     
    //Loop to generate the page links 
    for($i=$min;$i<=$max;$i++) 
    { 
        if($currentPage==$i) 
        { 
            //Current Page 
            $pageLinks .= '<a href="#" class="active">'.$i.'</a>';  
        } 
        elseif($max <= $totalPages OR $i <= $totalPages) 
        { 
            $pageLinks .= '<a href="'.$baseLink.$start.'page='.$i.'" class="slide">'.$i.'</a>'; 
        } 
    } 
     
    if($nextPrev) 
    { 
        //Next and previous links 
        $next = ($currentPage + 1 > $totalPages) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage + 1).'" class="slide">Next</a>'; 
         
        $prev = ($currentPage - 1 <= 0 ) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage - 1).'" class="slide">Previous</a>'; 
    } 
     
    if($totalPages > 1)
    {
    	return '<br class="clear"/><div class="pagination">'.$txtPageList.$prev.$pageLinks.$next.'</div>'; 
    }
    else
    {
    	return '';
    }
     
} 

function count_shortcode($content = '')
{
	$return = array();
	
	if(!empty($content))
	{
		$pattern = get_shortcode_regex();
    	$count = preg_match_all('/'.$pattern.'/s', $content, $matches);
    	
    	$return['total'] = $count;
    	
    	if(isset($matches[0]))
    	{
    		foreach($matches[0] as $match)
    		{
    			$return['content'][] = substr_replace($match ,"",-1);
    		}
    	}
	}
	
	return $return;
}

function peerapong_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      single_cat_title();
      echo $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}
    
/**
*	Setup blog comment style
**/
function peerapong_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; ?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<div class="left">
         	<?php echo get_avatar($comment,$size='50',$default='<path_to_url>' ); ?>
      	</div>
      

      	<div class="right">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php _e('(Your comment is awaiting moderation.)') ?></em>
         		<br />
      		<?php endif; ?>
			
			<strong><i><?php echo $comment->comment_author; ?></i></strong>
      		<?php ' '.comment_text() ?>
      		<p class="comment-reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' => '
Reply', 'login_text' => 'Log in to reply to this', 'max_depth' => $args['max_depth']))) ?></p>

      	</div>
    </div>
<?php
}

function cn_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("秒", "分钟", "小时", "天", "星期", "月", "年", "十年");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   //if($difference != 1) $periods[$j].= "s";
   $text = "$difference$periods[$j]";
   return $text;
}

function peerapong_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}

function cn_substr($str, $maxLength){
  $sub = '';
  $len = 0;
  $dotdot = false;

  preg_match_all('/./u', $str, $matches);
  
  foreach ($matches[0] as $word) //English letters and Chinese words
  {
    //echo '<'.$word.'>';

    if($len <= $maxLength){
      $sub .= $word;
      if(mb_strlen($word) == 1) //If it's a Chinese word, increment by 1
        $len += 1;
      elseif(mb_strlen($word) > 1) //If it's a English letter, increment by half. Since usually a Enghlish Character is half the size of a Chinese word.
        $len += 0.5;
      else{} //If it's a space, do nothing. 
    }
    else{
      $dotdot = true; //If we need to break out of this loop, it means the string length has exceded maxlength, we should put ...
    }
    
  }
  //echo "<br>";
  return $sub . (($dotdot) ? '...' : '');

}


// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function peerapong_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function peerapong_posts($sort = 'recent', $items = 5, $echo = TRUE, $mini = FALSE, $truncate = 35) 
{
	$topNum = 1; //Highlight the top x articles

  $pp_blog_cat = get_option('pp_blog_cat'); 
	$return_html = '';

  $cat_id = get_category( get_query_var( 'cat' ) ) -> cat_ID;

  if($cat_id){ //Recent cat posts TODO: Popular cat posts
      $posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
  }
  else{
      if($sort == 'recent')
      {
        $posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_status=publish');
        //$title = 'Recent Posts';
      }
      else
      {
        global $wpdb;
        
        $posts = $wpdb->get_results("SELECT comment_count, ID, post_title, post_content, post_date FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY comment_count DESC LIMIT 0 , ".$items);
        //$title = 'Popular Posts';
      }
  }
	
	if(!empty($posts))
	{

		if (!$mini) $return_html.= '<h4 class="widgettitle">'.$title.'</h4>';
		$return_html.= '<ul class="posts">';

			foreach($posts as $post)
			{
        if($mini){
          $return_html.= '<li class="mini"><div>';
          $return_html.= '<a class="bold title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
          $return_html.= '<span class="ago"> '. cn_ago(strtotime($post->post_date)) .'</span>';
          $return_html.= '</div></li>';
        }
        else{
          if($topNum > 0){
            $return_html.= '<li class="top">';

            $image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
            $thumb = theme_thumb($image_thumb[0], 60, 60, 'c'); // Crops from center
         
            if($image_thumb){
              $return_html.= '<div><a href="'.get_permalink($post->ID).'"><img class="thumbnail" src="'. $thumb.'"></a></div>';
            }
            $return_html.= '<div><a class="top title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
            $return_html.= '<a href="'.gen_permalink(get_permalink($post->ID), 'quick_view=1').'" class="quick_view" title="Quick View"><img src="'.get_bloginfo( 'stylesheet_directory' ).'/images/icon_quick_view.png" style="width:16px" class="mid_align"/></a>';//.date('n月j日', strtotime($post->post_date)).'</div>';
            $return_html.= '<div class="post_content">'.cn_substr(strip_tags(strip_shortcodes($post->post_content)), $truncate).'</div></div>';
          }
          else{
            $return_html.= '<li class="bullet">';
            $return_html.= '<div><a class="title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';   
          }

          $return_html.= '</li>';
        }
        $topNum--;
			}	

		$return_html.= '</ul>';
    //$return_html.= '更多...'; 
	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function peerapong_cat_posts($cat_id = '', $items = 10, $echo = TRUE, $truncate = 35) 
{
  $topNum = 1;
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	
	if(!empty($posts))
	{

		$return_html.= '<a href=""><h4 class="widgettitle">'.$title.'</h4></a>';
		$return_html.= '<ul class="category">';

      foreach($posts as $post)
      {
        if($mini){
          $return_html.= '<li class="mini"><div>';
            $return_html.= '<div><span class="ago">'. cn_ago(strtotime($post->post_date)) .' - </span>';
            $return_html.= '<span class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></span></div>';
            $return_html.= '';
          $return_html.= '</div></li>';
        }
        else{
          if($topNum > 0){
            $return_html.= '<li class="top">';

            $image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
            //$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
            $thumb = theme_thumb($image_thumb[0], 270, 200, 'c'); // Crops from center
                            
            if($image_thumb){
              $return_html.= '<div><a href="'.get_permalink($post->ID).'"><img class="thumbnail" src="'. $thumb.'"></a></div>';
            }
            $return_html.= '<div><a class="top title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
            $return_html.= '<a href="'.gen_permalink(get_permalink($post->ID), 'quick_view=1').'" class="quick_view" title="Quick View"><img src="'.get_bloginfo( 'stylesheet_directory' ).'/images/icon_quick_view.png" style="width:16px" class="mid_align"/></a>';//.date('n月j日', strtotime($post->post_date)).'</div>';
            //$return_html.= '<div class="post_content">'.cn_substr(strip_tags(strip_shortcodes($post->post_content)), $truncate).'</div></div>';
          }
          else{
            $return_html.= '<li>';
            $return_html.= '<div><a class="title" href="'.get_permalink($post->ID).'"><img class="bullet" src="'.get_bloginfo( 'template_directory' ).'/images/bullet.png">'.$post->post_title.'</a>';   
          }

          $return_html.= '</li>';
        }
        $topNum--;
      } 

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function ranking($cat_id, $items = 10, $echo = TRUE, $sort = 'popular')
{
  $return_html = '';

  //$return_html = $cat_id;

  if($sort == 'recent')
    $posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_status=publish&category='.$cat_id);
  else{  //Then it's popular
    global $wpdb;
    
    $posts = $wpdb->get_results("SELECT post_id, vote_count_up - vote_count_down AS difference FROM ".$wpdb->base_prefix."up_down_post_vote_totals ORDER BY difference");
    $posts = $wpdb->get_results("SELECT comment_count, ID, post_title, post_content, post_date FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND category = ".$cat_id." ORDER BY comment_count DESC LIMIT 0 , ".$items);
    
  }
  //$return_html.= print_r($posts);

  if(!empty($posts))
  {
    // $return_html.= '<h4 class="widgettitle">'.$title.'</h4>';
    $return_html.= '<ol class="ranking">';
    //$return_html.= print_r($posts);
    foreach($posts as $post)
    {
      $return_html.= '<li class="top">';

      $image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
      $thumb = theme_thumb($image_thumb[0], 60, 60, 'c'); // Crops from center

      $return_html.= '<div class="vote">';
       //updown-vote-box updown-post" id="updown-post-'.$post_id.'" post-id="'.$post_id.'">';
      //if(function_exists('up_down_post_votes')) { $return_html.= up_down_post_votes( $post->ID ); }
      $return_html.= '<div class="up icon-large icon-thumbs-up"></div>';
      //if(function_exists('up_down_post_vote_count')) { $return_html.= print_r(up_down_post_vote_count($post->ID));}
      $return_html.= '<div class="down icon-large icon-thumbs-down"></div>';
      $return_html.= '</div>';

      if($image_thumb){
        $return_html.= '<div><a href="'.get_permalink($post->ID).'"><img class="thumbnail" src="'. $thumb.'"></a></div>';
      }
      $return_html.= '<div><a class="top title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
      $return_html.= '</div>';

      $return_html.= '<div class="tagline">';//  作者: '.get_the_author_meta('display_name', $post->post_author);
      $return_html.= '<div class="icon icon-heart"></div>';
      $return_html.= '<a href="'.get_permalink($post->ID).'#comments"><div class="icon icon-comments"></div></a>';
      $return_html.= '<a href="'.get_permalink($post->ID).'#share"><div class="icon icon-share"></div></a>';;
      $return_html.= '</div>';

      $return_html.= '</li>';
      
    } 

    $return_html.= '</ol>';
  }

  if($echo)
  {
    echo $return_html;
  }
  else
  {
    return $return_html;
  }

}

function peerapong_recent_comments($items = 5, $echo = TRUE) 
{
	$return_html = '';
	
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
	comment_post_ID, comment_author, comment_date_gmt, comment_approved,
	comment_type,comment_author_url, user_id, 
	SUBSTRING(comment_content,1,30) AS com_excerpt
	FROM $wpdb->comments
	LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
	$wpdb->posts.ID)
	WHERE comment_approved = '1' AND comment_type = '' AND
	post_password = ''
	ORDER BY comment_date_gmt DESC
	LIMIT ".$items;
	$comments = $wpdb->get_results($sql);
	
	$title = 'Recent Comments';
	
	if(!empty($comments))
	{

		$return_html.= '<h4 class="widgettitle">'.$title.'</h4>';
		$return_html.= '<ul class="posts comments">';

			foreach($comments as $comment)
			{
				$return_html.= '<li>'.get_avatar($comment->user_id, $size='50', $default='<path_to_url>' );
				$return_html.= '<strong>'.$comment->comment_author.'</strong><br/><a href="'.get_permalink($comment->comment_post_ID).'">'.$comment->com_excerpt.'...</a></li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function peerapong_photos_in_news($items = 10, $echo = TRUE) 
{
	$return_html = '';
    
  $args = array( 
    'numberposts' => $items, 
    'orderby' => 'date', 
    'order' => 'DESC',
    'meta_key' => '_thumbnail_id'
  );

  $posts = get_posts( $args );

	$title = 'Photo in news';
	
	if(!empty($posts))
	{

		//$return_html.= '<h4 class="widgettitle">'.$title.'</h4>';
		$return_html.= '<ul class="thumb">';

			foreach($posts as $post)
			{
        $image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  
				$thumb = theme_thumb($image_thumb[0], 60, 60, 'c'); // Crops from center
        //if ($image_thumb)
 				 $return_html.= '<li><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><img class="resize" src="'. $thumb.'"></a></li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function _substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = strip_shortcodes($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = _substr(strip_tags($content), 600);
	$content.= '<br/><br/><br/>';
	
	if(get_post_type() == 'post')
	{
		$content.= '<a href="'.gen_permalink(get_permalink(), 'quick_view=1').'" class="quick_view" title="Quick View"><img src="'.get_bloginfo( 'stylesheet_directory' ).'/images/icon_quick_view.png" alt="Quick View" style="width:16px" class="mid_align"/>&nbsp;<strong>QuickView</strong></a>&nbsp;|&nbsp;';
	}
	
	$content.= '<a class="long_button" href="'.get_permalink().'"><strong>看全文</strong></a>';
	return $content;
}


function theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'theme_queue_js');

?>