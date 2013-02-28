<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 * @subpackage Pim
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	
	if(!empty($pp_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<?php
	/**
	*	Get header font
	**/
	$pp_header_font = get_option('pp_header_font');
	
	if(!empty($pp_header_font))
	{
?>
<style>
@font-face {
	font-family: 'PimFont';
	src: url('<?php bloginfo( 'stylesheet_directory' ); ?>/fonts/<?php echo $pp_header_font; ?>.eot');
	src: local('☺'), url('<?php bloginfo( 'stylesheet_directory' ); ?>/fonts/<?php echo $pp_header_font; ?>.woff') format('woff'), url('<?php bloginfo( 'stylesheet_directory' ); ?>/fonts/<?php echo $pp_header_font; ?>.ttf') format('truetype'), url('<?php bloginfo( 'stylesheet_directory' ); ?>/fonts/<?php echo $pp_header_font; ?>.svg#webfontQvsv8Mp8') format('svg');
	font-weight: normal;
	font-style: normal;
}
</style>
<?php
	}
?>

<!-- Template stylesheet -->
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/jqueryui/custom.css" type="text/css" media="all"/>
<!-- <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/NOscreen.css" type="text/css" media="all"/> -->
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/tipsy.css" type="text/css" media="all"/>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/bootstrap/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/app.css" type="text/css">


<?php
if(empty($pp_header_font) OR ($pp_header_font == 'Sansation_Regular-webfont'))
	{
?>
<?php
	}
?>

<?php

	/**
	*	Check selected skin
	**/
	$pp_skin = get_option('pp_skin');
	if(empty($pp_skin))
	{
		$pp_skin = 'silver';
	}
	
?>

<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/skins/<?php echo $pp_skin; ?>.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_directory' ); ?>/js/fancybox/jquery.fancybox-1.3.0.css" media="screen"/>

<!--[if IE 7]>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie7.css" type="text/css" media="all"/>
<![endif]-->

<!--[if IE]>
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/ie.css" type="text/css" media="all"/>
<![endif]-->

<!-- Jquery and plugins -->
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/fancybox/jquery.fancybox-1.3.0.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/hint.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/browser.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' ); ?>/js/app.js"></script>
</head>

<?php

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

$search_key = '';
if(isset($_GET['s']))
{
	$search_key = $_GET['s'];
}

?>

<body <?php body_class(); ?>>
	
	<?php
		$pp_portfolio_auto_scroll = get_option('pp_portfolio_auto_scroll');
	?>
	<input type="hidden" id="pp_portfolio_auto_scroll" name="pp_portfolio_auto_scroll" value="<?php echo $pp_portfolio_auto_scroll; ?>"/>
	<input type="hidden" id="pp_color" name="pp_color" value="<?php echo $pp_color; ?>"/>


	<div class="navbar">
	    <div class="navbar-inner">
	    <div class="container-fluid">

			<?php 	
			    wp_nav_menu( 
			        	array( 
			        		'menu_id'			=> 'top_menu',
			        		'menu_class'		=> 'nav',
			        		'theme_location' 	=> 'top-menu',
			        	) 
			    ); 
			?>

			<form class="navbar-search pull-right">
		    	<input type="text" class="search-query" placeholder="搜索">
		    </form>

			<ul class="nav pull-right">
				<li>
					<a href="<?php bloginfo('rss2_url'); ?>">
						<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_rss.png" alt="RSS"/>
					</a>
				</li>
				<?php
					//Twitter
					$pp_twitter_url = get_option('pp_twitter_url');
					if(!empty($pp_twitter_url))
					{
				?>
				
				<li>
					<a href="<?php echo $pp_twitter_url; ?>">
						<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_twitter.png" alt="Twitter"/>
					</a>
				</li>
				
				<?php
					}
				?>
				
				<?php
					//Facebook
					$pp_facebook_url = get_option('pp_facebook_url');
					if(!empty($pp_facebook_url))
					{
				?>
				
				<li>
					<a href="<?php echo $pp_facebook_url; ?>">
						<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_facebook.png" alt="Facebook"/>
					</a>
				</li>
				
				<?php
					}
				?>
			</ul>
			    </div>
		    
	    </div>
    </div>
<div class="main container-fluid">
	<div class="row-fluid">
		<div class="span9">
				<a class="brand" href="<?php bloginfo( 'url' ); ?>">
		    	<?php
					//get custom logo
					$pp_logo = get_option('pp_logo');
					
					if(empty($pp_logo))
					{	
						if($pp_skin != 'black')
						{
							//$pp_logo = get_bloginfo( 'stylesheet_directory' ).'/images/logo_black.png';
						}
						else
						{
							//$pp_logo = get_bloginfo( 'stylesheet_directory' ).'/images/logo_white.png';
						}
					}
				?>
				<h2><?php bloginfo('name'); ?></h2>
				<a id="custom_logo" href="<?php bloginfo( 'url' ); ?>"><img src="<?php echo $pp_logo; ?>" alt=""/></a></a>
	            <?php 	
					wp_nav_menu( 
						array( 
							'menu_id'			=> 'main_nav',
				        	'menu_class'		=> 'nav',
							'theme_location' 	=> 'primary-menu',
						) 
					);
				?>
		</div>
	</div>

	<!--<div class="row-fluid">
		<div class="span4">
			<span class="ad"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/jiaheng.gif"></span>
		</div>
		<div class="span4">
			<span class="ad"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/jiaheng.gif"></span>
		</div>
		<div class="span4">
			<span class="ad"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/jiaheng.gif"></span>
		</div>
	</div>-->