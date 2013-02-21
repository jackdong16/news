<?php

/**
*	Themes API call
**/
include (TEMPLATEPATH . "/lib/api.lib.php");

/**
*	Setup Theme post custom fields
**/
include (TEMPLATEPATH . "/lib/theme-post-custom-fields.php");

/**
*	Setup Theme page custom fields
**/
include (TEMPLATEPATH . "/lib/theme-page-custom-fields.php");

/**
*	Setup Sidebar
**/
include (TEMPLATEPATH . "/lib/sidebar.lib.php");


//Get custom function
include (TEMPLATEPATH . "/lib/custom.lib.php");


//Get custom shortcode
include (TEMPLATEPATH . "/lib/shortcode.lib.php");

// Register Custom Navigation Walker
//require_once('twitter_bootstrap_nav_walker.php');

/**
*	Setup Menu
**/
include (TEMPLATEPATH . "/lib/menu.lib.php");


function filter_rss_query($query) {
	if ( $query->is_feed ) {
		$query->set('cat', get_option('nm_blog_cat'));
	}
	return $query;
}
add_filter('pre_get_posts', 'filter_rss_query');


/*
	Begin creating admin optinos
*/

$themename = "PIM";
$shortname = "pp";

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array(
	0		=> "Choose a category"
);
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}

$pages = get_pages(array('parent' => 0));
$wp_pages = array(
	0		=> "Choose a page"
);
foreach ($pages as $page_list ) {
       $wp_pages[$page_list->ID] = $page_list->post_title;
}

$nm_handle = opendir(TEMPLATEPATH.'/css/skins');
$nm_skin_arr = array();

while (false!==($nm_file = readdir($nm_handle))) {
	if ($nm_file != "." && $nm_file != ".." && $nm_file != ".DS_Store") {
		$nm_file_name = basename($nm_file, '.css');
		$nm_name = str_replace('_', ' ', $nm_file_name);

		$nm_skin_arr[$nm_file_name] = $nm_name;
	}
}
closedir($nm_handle);
asort($nm_skin_arr);


$options = array (
 
//Begin admin header
array( 
		"name" => $themename." Options",
		"type" => "title"
),
//End admin header
 

//Begin first tab "General"
array( 
		"name" => "General",
		"type" => "section"
)
,

array( "type" => "open"),

array( "name" => "Skins",
	"desc" => "Select the skin for the theme",
	"id" => $shortname."_skin",
	"type" => "select",
	"options" => $nm_skin_arr,
	"std" => "silver"
),
array( "name" => "Header Font",
	"desc" => "Select the font for template's header text",
	"id" => $shortname."_header_font",
	"type" => "select",
	"options" => array(
		'BebasNeue-webfont' => 'BebasNeue',
		'' => 'Arial',
		'Sansation_Regular-webfont' => 'Sensation',
	),
	"std" => "BebasNeue"
),
array( "name" => "Your Logo (Image URL)",
	"desc" => "Enter the URL of image that you want to use as the logo",
	"id" => $shortname."_logo",
	"type" => "text",
	"std" => "",
),
array( "name" => "Google Analytics Domain ID ",
	"desc" => "Get analytics on your site. Simply give us your Google Analytics Domain ID (something like UA-123456-1)",
	"id" => $shortname."_ga_id",
	"type" => "text",
	"std" => ""

),
array( "name" => "Custom Favicon",
	"desc" => "A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image",
	"id" => $shortname."_favicon",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Twitter URL",
	"desc" => "Enter the URL of your Twitter account.",
	"id" => $shortname."_twitter_url",
	"type" => "text",
	"std" => "",
),
array( "name" => "Your Facebook URL",
	"desc" => "Enter the URL of your Facebook account.",
	"id" => $shortname."_facebook_url",
	"type" => "text",
	"std" => "",
),
	
array( "type" => "close"),
//End first tab "General"


//Begin second tab "Homepage"
array( "name" => "Homepage",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Homepage Styles",
	"desc" => "Select style for your homepage display",
	"id" => $shortname."_homepage_style",
	"type" => "select",
	"options" => array(
		'newspaper' => 'Newspaper',
		'blog' => 'Blog',
	),
	"std" => "Newspaper"
),
array( "name" => "Homepage featured posts category",
	"desc" => "Choose a category from which contents in eatured posts are drawn",
	"id" => $shortname."_featured_cat",
	"type" => "select",
	"options" => $wp_cats,
	"std" => "Choose a category"
),
array( "name" => "Homepage featured posts items",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => $shortname."_featured_items",
	"type" => "text",
	"size" => "40px",
	"std" => "5"

),

array( "type" => "close"),
//End second tab "Homepage"


//Begin second tab "Special Content"
array( "name" => "Sidebar",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Add a new sidebar",
	"desc" => "Enter sidebar name",
	"id" => $shortname."_sidebar0",
	"type" => "text",
	"std" => "",
),
array( "type" => "close"),
//End second tab "Special Content"


//Begin fourth tab "Contact"
array( "name" => "Contact",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Choose page for contact form",
	"desc" => "Choose a page from which your contact form to display",
	"id" => $shortname."_contact_page",
	"type" => "select",
	"options" => $wp_pages,
	"std" => "Choose a page"),
array( "name" => "Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => $shortname."_contact_email",
	"type" => "text",
	"std" => ""

),
//End fourth tab "Contact"


//Begin fifth tab "Footer"
array( "type" => "close"),
array( "name" => "Footer",
	"type" => "section"),
array( "type" => "open"),
	
array( "name" => "Footer text",
	"desc" => "Enter footer text ex. copyright description",
	"id" => $shortname."_footer_text",
	"type" => "textarea",
	"std" => ""

),
//End fifth tab "Footer"

 
array( "type" => "close")
 
);


function nm_add_admin() {
 
global $themename, $shortname, $options;
 
if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {
 
	if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
 
		foreach ($options as $value) 
		{
			update_option( $value['id'], $_REQUEST[ $value['id'] ] );
		}
 
foreach ($options as $value) {
	if( isset( $_REQUEST[ $value['id'] ] ) ) { 
		if($value['id'] != $shortname."_sidebar0")
		{
			update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
		}
		elseif(isset($_REQUEST[ $value['id'] ]) && !empty($_REQUEST[ $value['id'] ]))
		{
			//get last sidebar serialize array
			$current_sidebar = get_option($shortname."_sidebar");
			$current_sidebar[ $_REQUEST[ $value['id'] ] ] = $_REQUEST[ $value['id'] ];

			update_option( $shortname."_sidebar", $current_sidebar );
		}
	} 
	else 
	{ 
		delete_option( $value['id'] ); 
	} 
}

 
	header("Location: admin.php?page=functions.php&saved=true");
 
} 
else if( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
 
	foreach ($options as $value) {
		delete_option( $value['id'] ); }
 
	header("Location: admin.php?page=functions.php&reset=true");
 
}
}
 
add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'nm_admin');
}

function nm_add_init() {

$file_dir=get_bloginfo('template_directory');
wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
wp_enqueue_script("rm_script", $file_dir."/functions/rm_script.js", false, "1.0");

}
function nm_admin() {
 
global $themename, $shortname, $options;
$i=0;
 
if ( isset($_REQUEST['saved']) &&  $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong>w p l o c k e r . c o m</p></div>';
if ( isset($_REQUEST['reset']) &&  $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
	<div class="wrap rm_wrap">
	<h2><?php echo $themename; ?> Settings</h2>

	<div class="rm_opts">
	<form method="post"><?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?> <?php break;
 
case "close":
?>
	
	</div>
	</div>
	<br />


	<?php break;
 
case "title":
?>
	<br />


<?php break;
 
case 'text':
	
	//if sidebar input then not show default value
	if($value['id'] != $shortname."_sidebar0")
	{
		$default_val = get_settings( $value['id'] );
	}
	else
	{
		$default_val = '';	
	}
?>

	<div class="rm_input rm_text"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<input name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"
		value="<?php if ($default_val != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>"
		<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
		<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>
	
	<?php
	if($value['id'] == $shortname."_sidebar0")
	{
		$current_sidebar = get_option($shortname."_sidebar");
		
		if(!empty($current_sidebar))
		{
	?>
		<ul id="current_sidebar" class="rm_list">

	<?php
		$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
		foreach($current_sidebar as $sidebar)
		{
	?> 
			
			<li id="<?=$sidebar?>"><?=$sidebar?> ( <a href="<?php echo $url; ?>" class="sidebar_del" rel="<?=$sidebar?>">Delete</a> )</li>
	
	<?php
		}
	?>
	
		</ul>
	
	<?php
		}
	}
	?>

	</div>
	<?php
break;

case 'password':
?>

	<div class="rm_input rm_text"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<input name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"
		value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>"
		<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>

	</div>
	<?php
break;
 
case 'textarea':
?>

	<div class="rm_input rm_textarea"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<textarea name="<?php echo $value['id']; ?>"
		type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>

	</div>

	<?php
break;
 
case 'select':
?>

	<div class="rm_input rm_select"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

	<select name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>">
		<?php foreach ($value['options'] as $key => $option) { ?>
		<option
		<?php if (get_settings( $value['id'] ) == $key) { echo 'selected="selected"'; } ?>
			value="<?php echo $key; ?>"><?php echo $option; ?></option>
		<?php } ?>
	</select> <small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>
	</div>
	<?php
break;
 
case "checkbox":
?>

	<div class="rm_input rm_checkbox"><label
		for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

	<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
	<input type="checkbox" name="<?php echo $value['id']; ?>"
		id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


	<small><?php echo $value['desc']; ?></small>
	<div class="clearfix"></div>
	</div>
	<?php break; 
case "section":

$i++;

?>

	<div class="rm_section">
	<div class="rm_title">
	<h3><img
		src="<?php bloginfo('template_directory')?>/functions/images/trans.png"
		class="inactive" alt="""><?php echo $value['name']; ?></h3>
	<span class="submit"><input name="save<?php echo $i; ?>" type="submit"
		value="Save changes" /> </span>
	<div class="clearfix"></div>
	</div>
	<div class="rm_options"><?php break;
 
}
}
?> <input type="hidden" name="action" value="save" />
	</form>
	<form method="post"><!-- p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p --></form>
	</div>


	<?php
}

add_action('admin_init', 'nm_add_init');
add_action('admin_menu', 'nm_add_admin');

/*
	End creating admin options
*/

//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');
?>