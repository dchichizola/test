<?php tha_html_before(); ?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="date=no">
	<meta name="format-detection" content="address=no">
	<?php if (is_search()) { ?><meta name="robots" content="noindex, nofollow" /><?php } ?>
	<title><?php wp_title(); ?></title>
	<meta name="author" content="Incremental Marketing">
	<?php
	/*

	http://realfavicongenerator.net/
	Generate favicon links from one image

	*/
	?>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/manifest.json">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/mstile-144x144.png">
    <meta name="msapplication-config" content="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

	<?php tha_head_bottom(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
$http_host_parts = explode(".", $_SERVER['HTTP_HOST']);
if (((!is_page('Login') || !is_admin()) && array_shift($http_host_parts) !== "sg1") && end($http_host_parts) !== 'dev' && end($http_host_parts) !== 'locahost') {
?>
<!-- Google Tag Manager -->
<!-- End Google Tag Manager -->
<?php
}
?>
<?php tha_body_top(); ?>
<!--[if IE]>
<div class="old-browser">
	<div class="old-browser-notice">
		<strong>You are using an outdated browser.</strong>
		For a better experience using this site, please upgrade to a modern browser:
		<a href="http://www.mozilla.com/firefox/" target="_blank">Firefox</a>
		<a href="http://www.google.com/chrome/" target="_blank">Chrome</a>
		<a href="http://www.apple.com/safari/" target="_blank">Safari</a>
		<a href="http://www.browserforthebetter.com/" target="_blank">Internet&nbsp;Explorer</a>
	</div>
	<a class="old-browser-close" href="#" onclick="javascript:this.parentNode.style.display='none'; return false;">x</a>
</div>
<![endif]-->

<div class="viewport render-<?php echo friendlyUrl($post->post_title);?>">
	<div class="wrap">

		<?php tha_header_before(); ?>
		<div class="section-top hidden-md-down">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<a href="<?php echo get_bloginfo('siteurl');?>"><img src="https://placehold.it/320x100/E8117F/fff.png?text=logo%402x.png" alt=""></a>
					</div>
					<div class="col-sm-6">
						<div class="searchbox hidden-md-down">
                            <?php include (TEMPLATEPATH . '/inc/searchform.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-nav hidden-md-down">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php
						/*

						CLEAN CUSTOM MENUS FUNCTION
						Defined in lib/theme-functions.php

						*/
						if (function_exists('clean_custom_menus')){
							echo clean_custom_menus('navbar');
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		/*

		MOBILE HEADER
		@Available classes:
		sticky-header
		auto-hide

		*/
		?>
		<div class="mobile-header sticky-header auto-hide hidden-lg-up hidden-print">
			<div class="container">
				<div class="row">
					<div class="col-xs-8">
						<a href="<?php echo get_bloginfo('siteurl');?>" class="logo"><img src="https://placehold.it/210x50/E8117F/fff.png?text=mobile-logo%402x.png" alt=""></a>
					</div>
					<div class="col-xs-4">
						<div class="mobile_menubtn hidden-lg-up">
							<span class="menuitem"></span>
							<span class="menuitem"></span>
							<span class="menuitem"></span>
							<span class="menutext">Menu</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php tha_header_after(); ?>

		<div class="section-hero">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="HeroFeature">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe class="embed-responsive-item" width="640" height="360" src="https://www.youtube.com/embed/G7IRFxNeirg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
					</div>
					<div class="col-sm-4">

					</div>
				</div>
			</div>
		</div>

		<?php tha_content_before(); ?>
		<div class="section-content middle">
			<div class="container">
				<div class="row">
