<?php
global $browser;


if ( ! function_exists( '_core_basetheme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _core_basetheme_setup() {

		// Clean up the head
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );


		// Register nav menus
		// Function location: /lib/theme-functions.php
		add_action( 'init', 'register_my_menu' );

		// Register Widget Areas
		// Function location: /lib/theme-functions.php
		add_action( 'widgets_init', 'core_widgets_init' );

		// Modifying Widget Output based on Title content
		// Function location: /lib/theme-functions.php
		add_filter( 'dynamic_sidebar_params', 'check_sidebar_params' );


		// Execute shortcodes in widgets
		add_filter('widget_text', 'do_shortcode');

		// Add Editor Style
		add_editor_style();

		// Prevent File Modifications
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Remove Dashboard Meta Boxes
		// Function location: /lib/theme-functions.php
		add_action( 'wp_dashboard_setup', 'core_remove_dashboard_widgets' );

		// Change Admin Menu Order
		// Function location: /lib/theme-functions.php
		add_filter( 'custom_menu_order', '__return_true' );
		add_filter( 'menu_order', 'core_custom_menu_order' );

		// Hide Admin Areas that are not used
		// Function location: /lib/theme-functions.php
		add_action( 'admin_menu', 'core_remove_menu_pages' );

		// Remove default link for images
		// Function location: /lib/theme-functions.php
		add_action( 'admin_init', 'core_imagelink_setup', 10 );

		// Enqueue scripts
		// Function location: /lib/theme-functions.php
		add_action( 'wp_enqueue_scripts', 'core_load_scripts' );

		// Remove Query Strings From Static Resources
		// Function location: /lib/theme-functions.php
		add_filter( 'script_loader_src', 'core_remove_script_version', 15, 1 );
		add_filter( 'style_loader_src', 'core_remove_script_version', 15, 1 );

		// Remove Read More Jump
		// Function location: /lib/theme-functions.php
		add_filter( 'the_content_more_link', 'core_remove_more_jump_link' );

		/*
		 * ADD BROWSER NAME TO BODY CLASS
		 */
		// Function location: /lib/theme-functions.php
		add_filter('body_class','browser_body_class');

	}
endif; // _core_basetheme_setup

add_action( 'after_setup_theme', '_core_basetheme_setup' );
