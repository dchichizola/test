<?php
// ===================================================
// Load database info and local development parameters
// ===================================================

$http_host_parts = explode(".", $_SERVER['HTTP_HOST']);
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	// Local Development Environment
	define( 'WP_LOCAL_DEV', true );
	include( dirname( __FILE__ ) . '/local-config.php' );
} elseif (array_shift($http_host_parts) == "sg1") {
	// Staging Environment
    include( dirname( __FILE__ ) . '/stage-config.php' );
} else {
	// Production Environment
	define( 'WP_LOCAL_DEV', false );
	define( 'DB_NAME', '%%DATABASE%%' );
	define( 'DB_USER', '%%USERNAME%%' );
	define( 'DB_PASSWORD', '%%PASSWORD%%' );
	define( 'DB_HOST', 'localhost' ); // Probably 'localhost'

	define('TESTMODE', false);
}

// ========================
// Custom Content Directory
// ========================
$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
    $isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';

define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', $REQUEST_PROTOCOL . '://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================
// Show/Hide errors
// ================
ini_set('log_errors', 'On');
ini_set('error_log', __DIR__.'/error_log');

// For debugging, if not set in local-config.php, you can set the Debug Mode here
if ( ! isset( $DEBUG_MODE ) ) {
	//$DEBUG_MODE = true;
}
if ( isset( $DEBUG_MODE ) && $DEBUG_MODE == true ) {
	ini_set( 'display_errors', 1 );
	define( 'WP_DEBUG_DISPLAY', true );
} else {
	ini_set( 'display_errors', 0 );
	define( 'WP_DEBUG_DISPLAY', false );
}

// =================================================================
// Debug mode
// Debugging? Enable these. Can also enable them in local-config.php
// =================================================================
// define( 'SAVEQUERIES', true );
// define( 'WP_DEBUG', true );

// =====================
// Security Enhancements
// =====================
// Disable theme editing without FTP/SSH, add this to wp-config:
define( 'DISALLOW_FILE_EDIT', true );

// ===============
// Custom Settings
// ===============
define( 'WP_CACHE', true );
define( 'WP_MEMORY_LIMIT', '512M' );

// Optimize Admin section by blocking external http requests
//define( 'WP_HTTP_BLOCK_EXTERNAL', true );

// Optimize Admin section by limiting the number of revisions
define( 'WP_POST_REVISIONS', 5 );

// Optimizing Empty trash and Autosave
define( 'AUTOSAVE_INTERVAL', 600 );
define( 'EMPTY_TRASH_DAYS', 3 );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
include( dirname( __FILE__ ) . '/salts.php' );

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix  = 'img_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) )
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );

// ===========================================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================================
define( 'WP_STAGE', '%%WP_STAGE%%' );
define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( !defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
require_once( ABSPATH . 'wp-settings.php' );
