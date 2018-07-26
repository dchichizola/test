<?php
global $browser;

/**
 * Register Menus
 */
if (!function_exists('register_my_menu')){
	function register_my_menu() {
		register_nav_menus(
			array(
				'navbar' => __( 'Navigation Menu' ),
				'sitemap' => __( 'Sitemap Menu' )
			)
		);
	}
}

/**
* Removing support to editor for Page post type
*/
add_action( 'init', 'my_custom_init' );
function my_custom_init() {
	//remove_post_type_support( 'page', 'editor' );
}

/**
 * Register Widget Areas
 */
if (!function_exists('core_widgets_init')){
	function core_widgets_init() {
		// Main Sidebar
		register_sidebar( array(
			'name'          => __( 'Sidebar', '_corebasetheme' ),
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		) );
	}
}
/**
 * Modifying Widget output based on Widget Title existence.
 */
if (!function_exists('check_sidebar_params')){
	// if no title then add widget content wrapper to before widget
	function check_sidebar_params( $params ) {
		global $wp_registered_widgets;

		$settings_getter = $wp_registered_widgets[ $params[0]['widget_id'] ]['callback'][0];
		$settings = $settings_getter->get_settings();
		$settings = $settings[ $params[1]['number'] ];

		if ( $params[0][ 'after_widget' ] == '</div></div>' && isset( $settings[ 'title' ] ) && empty( $settings[ 'title' ] ) )
			$params[0][ 'before_widget' ] .= '<div class="entry">';

		return $params;
	}
}

/**
 * Remove Dashboard Meta Boxes
 */
if (!function_exists('core_remove_dashboard_widgets')){
	function core_remove_dashboard_widgets() {
		global $wp_meta_boxes;
		// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
}

/**
 * Change Admin Menu Order
 */
if (!function_exists('core_custom_menu_order')){
	function core_custom_menu_order( $menu_ord ) {
		if ( !$menu_ord ) return true;
		return array(
			// 'index.php', // Dashboard
			// 'separator1', // First separator
			// 'edit.php?post_type=page', // Pages
			// 'edit.php', // Posts
			// 'upload.php', // Media
			// 'gf_edit_forms', // Gravity Forms
			// 'genesis', // Genesis
			// 'edit-comments.php', // Comments
			// 'separator2', // Second separator
			// 'themes.php', // Appearance
			// 'plugins.php', // Plugins
			// 'users.php', // Users
			// 'tools.php', // Tools
			// 'options-general.php', // Settings
			// 'separator-last', // Last separator
		);
	}
}

/**
 * Hide Admin Areas that are not used
 */
if (!function_exists('core_remove_menu_pages')){
	function core_remove_menu_pages() {
		// remove_menu_page( 'link-manager.php' );
	}
}

/**
 * Remove default link for images
 */
if (!function_exists('core_imagelink_setup')){
	function core_imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );
		if ( $image_set !== 'none' ) {
			update_option( 'image_default_link_type', 'none' );
		}
	}
}

/**
 * Enqueue scripts
 */
if (!function_exists('core_load_scripts')) {
	function core_load_scripts() {
		$theme = wp_get_theme();
		$compact = (WP_LOCAL_DEV === true) ? '' : '.min';

		if ( !is_admin() ) { // instruction to only load if it is not the admin area

			//CDN
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"), false, '2.2.3', true);
			wp_enqueue_script('jquery');
			//wp_enqueue_script('modernizr','//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',false,'2.8.3'); //handler, location, dependencies, version, at the footer?
			wp_enqueue_script('hoverIntent','//cdnjs.cloudflare.com/ajax/libs/jquery.hoverintent/1.8.1/jquery.hoverIntent.min.js','jquery','1.8.1', true); //handler, location, dependencies, version, at the footer?

			//CUSTOM
			//wp_enqueue_script('colorbox','//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.2/jquery.colorbox-min.js','jquery','1.6.2', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_script('cycle2','//cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js','jquery','2.1.5', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_script('easing','//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js','jquery','1.3', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_script('fittext','//cdnjs.cloudflare.com/ajax/libs/FitText.js/1.1/jquery.fittext.min.js','jquery','1.1', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_script('fitvids','//cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js','jquery','1.1.0', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_script('touchswipe','//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.9/jquery.touchSwipe.min.js','jquery','1.6.9', true); //handler, location, dependencies, version, at the footer?
			//wp_enqueue_style('select2', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css',false,'4.0.0', 'all');

			//CORE
			//wp_enqueue_style('font', '//fonts.googleapis.com/css?family=Lato:300,400,700',false,'1.0.0', 'all');
			wp_enqueue_style('corecss', get_template_directory_uri() . '/assets/css/main' . $compact . '.css', false, $theme['Version'], 'all');
			wp_enqueue_script('corejs', get_template_directory_uri() . '/assets/js/main' . $compact . '.js', 'jquery', $theme['Version'], true); //handler, location, dependencies, version, at the footer?

			//ADDING A HOOK SO YOU CAN ENQUEUE MORE SCRIPTS OR STYLES AT CORE LOAD TIME
			do_action( 'core_load_scripts_hook');
		}
	}
}

/*
 * GET USER BROWSER
 */
if (!function_exists('get_user_browser')){
	function get_user_browser()
	{
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$ub = '';
		if(preg_match('/MSIE/i',$u_agent))
		{
			$ub = "ie";
		}
		if(preg_match('/Trident/i',$u_agent))
		{
			$ub = "ie";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$ub = "firefox";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			if(preg_match('/Android/i',$u_agent))
			{
				$ub = "android";
			}
			else{
				$ub = "safari";
			}
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$ub = "chrome";
		}
		elseif(preg_match('/Flock/i',$u_agent))
		{
			$ub = "flock";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$ub = "opera";
		}
		return $ub;
	}
}

/**
 * Remove Query Strings From Static Resources
 */
if (!function_exists('core_remove_script_version')){
	function core_remove_script_version( $src ){
		$parts = explode( '?ver', $src );
		return $parts[0];
	}
}

/**
 * Remove Read More Jump
 */
if (!function_exists('core_remove_more_jump_link')){
	function core_remove_more_jump_link( $link ) {
		$offset = strpos( $link, '#more-' );
		if ($offset) {
			$end = strpos( $link, '"',$offset );
		}
		if ($end) {
			$link = substr_replace( $link, '', $offset, $end-$offset );
		}
		return $link;
	}
}

//GET PAGE ID BY PAGE NAME
if (!function_exists('wt_get_ID_by_page_name')){
	function wt_get_ID_by_page_name($page_name) {
		global $wpdb;
		if ($page_name == '') return false;
		$page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$page_name."' AND post_type = 'page'");
		return $page_name_id;
	}
}
//GET POST ID BY POST NAME
if (!function_exists('wt_get_ID_by_post_name')){
	function wt_get_ID_by_post_name($post_name) {
		global $wpdb;
		if ($post_name == '') return false;
		$post_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$post_name."' AND post_type = 'post'");
		return $post_name_id;
	}
}
//GET POST CATEGORY ID BY CATEGORY NAME
if (!function_exists('wt_get_ID_by_cat_name')){
	function wt_get_ID_by_cat_name($cat_name) {
		global $wpdb;
		if ($cat_name == '') return false;
		$cat_name_id = $wpdb->get_var($wpdb->prepare("SELECT key1.term_id FROM $wpdb->terms key1 LEFT JOIN $wpdb->term_taxonomy key2 ON key1.term_id = key2.term_id WHERE key1.name = '".$cat_name."' AND key2.taxonomy = 'category'"));
		return $cat_name_id;
	}
}
//GET CUSTOM POST ID BY TITLE
if (!function_exists('img_get_id_by_title')){
	function img_get_id_by_title($title, $post_type = 'post')
	{
		global $wpdb;
		if ($title == '') return false;
		$post_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$title."' AND post_type = '".$post_type."'");
		return $post_name_id;
	}
}

/**
 * CUSTOM NAV MENU -- STANDARD ONE --
 * @param $location_name : menu_name (i.e. navbar, sitemap)
 * custom menu example @ http://digwp.com/2011/11/html-formatting-custom-menus/
 */
if (!function_exists('clean_custom_menus')){
	function clean_custom_menus($location_name) {
		$menu_name = $location_name; // specify custom menu slug
		if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
			$menu = wp_get_nav_menu_object($locations[$menu_name]);
			$menu_items = wp_get_nav_menu_items($menu->term_id);

			$menu_list = '<div class="'.$location_name.'">' ."\n";
			$menu_list .= "\t\t\t\t". '<ul id="menu-'.$location_name.'" class="menu">' ."\n";
			$counter = 0;
			foreach ((array) $menu_items as $key => $menu_item) {
				$title = $menu_item->title;
				$target= '';
				if ($menu_item->target == '_blank') $target = 'target="_blank"';
				$url = substr($menu_item->url,0,1) == '/' ? get_bloginfo('siteurl') . $menu_item->url : $menu_item->url;
				$menu_list .= "\t\t\t\t\t". '<li class="menu-item'. (getUrl() == $url ? ' selected': '').($counter == 0 ? ' first':''). ($counter == count($menu_items) - 1 ? ' last':'').'"><a href="'. $url .'" '.$target.' class="ico_'.friendlyUrl($title).'"><span class="text">'. $title .'</span></a></li>' ."\n";
				$counter++;
			}
			$menu_list .= "\t\t\t\t". '</ul>' ."\n";
			$menu_list .= "\t\t\t". '</div>' ."\n";
		} else {
			// $menu_list = '<!-- no list defined -->';
		}
		echo $menu_list;
	}
}


//FRIENDLY URL OUT OF A STRING
if (!function_exists('friendlyUrl')){
	function friendlyUrl ($str = '') {

		$friendlyURL = htmlentities($str, ENT_COMPAT, "UTF-8", false);
		$friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
		$friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8");
		$friendlyURL = preg_replace('/[^a-z0-9-]+/i', '-', $friendlyURL);
		$friendlyURL = preg_replace('/-+/', '-', $friendlyURL);
		$friendlyURL = trim($friendlyURL, '-');
		$friendlyURL = strtolower($friendlyURL);
		return $friendlyURL;
	}
}

/**
 * @return string (CURRENT URL)
 */
if (!function_exists('getUrl')){
	function getUrl() {
		$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
		//$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
		$url .= $_SERVER["REQUEST_URI"];
		return $url;
	}
}

/**
 * ADD BROWSER NAME TO BODY CLASS
 * @param $classes
 * @return array
 */
if (!function_exists('browser_body_class')){
	function browser_body_class($classes) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) $classes[] = 'ie';
		else $classes[] = 'unknown';

		if($is_iphone) $classes[] = 'iphone';
		return $classes;
	}
}

//SUPPORT TO WOOCOMMERCE
//add_theme_support( 'woocommerce' );





/**
 * Hide ACF menu item from the admin menu
 */
if (!function_exists('remove_acf_menu')){
	add_action( 'admin_menu', 'remove_acf_menu', 999 );
	function remove_acf_menu()
	{

	    // provide a list of usernames who can edit custom field definitions here
	    $admins = array(
	        'indy'
	    );

	    // get the current user
	    $current_user = wp_get_current_user();

	    // match and remove if needed
	    if( !in_array( $current_user->user_login, $admins ) )
	    {
	        remove_menu_page('edit.php?post_type=acf');
	    }

	}
}

/* DEVELOPMENT FUNCTION TO PRINT OUT DATA */
if (!function_exists('dev')){
	function dev($obj)
	{
		echo "<xmp>";
		print_r($obj);
		echo "</xmp>";
	}
}

/*

ARRAY 2 JSON FUNCTION

*/
if (!function_exists('array2json')){
	function array2json($arr) {
	    if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
	    $parts = array();
	    $is_list = false;

	    //Find out if the given array is a numerical array
	    $keys = array_keys($arr);
	    $max_length = count($arr)-1;
	    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
	        $is_list = true;
	        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
	            if($i != $keys[$i]) { //A key fails at position check.
	                $is_list = false; //It is an associative array.
	                break;
	            }
	        }
	    }

	    foreach($arr as $key=>$value) {
	        if(is_array($value)) { //Custom handling for arrays
	            if($is_list) $parts[] = array2json($value); /* :RECURSION: */
	            else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
	        } else {
	            $str = '';
	            if(!$is_list) $str = '"' . $key . '":';

	            //Custom handling for multiple data types
	            if(is_numeric($value)) $str .= $value; //Numbers
	            elseif($value === false) $str .= 'false'; //The booleans
	            elseif($value === true) $str .= 'true';
	            else $str .= '"' . addslashes($value) . '"'; //All other things
	            // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

	            $parts[] = $str;
	        }
	    }
	    $json = implode(',',$parts);

	    if($is_list) return '[' . $json . ']';//Return numerical JSON
	    return '{' . $json . '}';//Return associative JSON
	}
}

/**
 * Remove a given term from the specified post
 *
 * Helper function since this functionality doesn't exist in core
 */
if (!function_exists('my_remove_post_term')){
	function my_remove_post_term( $post_id, $term, $taxonomy ) {

		if ( ! is_numeric( $term ) ) {
			$term = get_term( $term, $taxonomy );
			if ( ! $term || is_wp_error( $term ) )
				return false;
			$term_id = $term->term_id;
		} else {
			$term_id = $term;
		}

		// Get the existing terms and only keep the ones we don't want removed
		$new_terms = array();
		$current_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );

		foreach ( $current_terms as $current_term ) {
			if ( $current_term != $term_id )
				$new_terms[] = intval( $current_term );
		}

		return wp_set_object_terms( $post_id, $new_terms, $taxonomy );
	}
}


// Prevent WP from re-ordering selected categories/taxonomies and placing them on top
// as this breaks hierarchy
function prevent_reordering_categories($args) {
	$args['checked_ontop'] = false;
    return $args;
}
// add_filter('wp_terms_checklist_args', 'prevent_reordering_categories');


// FIND THE ACF FIELD KEY FROM A MAPPING ARRAY
if (!function_exists('acf_find_key')){
	function acf_find_key($array, $field_name)
	{
		$return = false;
		foreach ($array as $key => $value)
		{
			if ($key === $field_name){
				$return = $value;
				break;
			}
		}
		return $return;
	}
}

//BUG FIXING
//ACF update_field function doesn't update both metas (value and reference) when called using field_name.
//You must use field_key and will do the job.
if (!function_exists('get_acf_key')){
	function get_acf_key($field_name, $post_id = null)
	{
		//$post_id
		//Specific post ID where your value was entered. Defaults to current post ID (not required). This can also be options / taxonomies / users / etc
		$field = get_field_object($field_name, $post_id);
		return $field['key'];
	}
}

//REMOVING EMOJI CSS AND JS FROM WORDPRESS
if (!function_exists('flush_emojicons'))
{
	function flush_emojicons() {
	    // Remove from comment feed and RSS
	    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	    // Remove from Emails
	    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	    // Remove from the head, i.e. wp_head()
	    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	    // Remove from Print-related CSS
	    remove_action( 'wp_print_styles', 'print_emoji_styles' );

	    // Remove from Admin area
	    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	    remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}
	add_action( 'init', 'flush_emojicons' );
}

//REMOVE WP VERSION NUMBER
if (!function_exists('remove_version_number')){
	function remove_version_number() {
		return '';
	}
	add_filter('the_generator', 'remove_version_number');
}

//ADDING HTTP AUTHENTICATION TO STAGING SITE
//HTTP_CREDENTIALS MUST BE DEFINED IN stage-config.php FILE IN SKELETON
/*
//Using AUTH_SALT
define( 'HTTP_CREDENTIALS', serialize(array(
	array('imgdits', '5cd66431e6be20da4e30d7cfa535e362'),
	array('imgdev', '5cd66431e6be20da4e30d7cfa535e362'),
	array('searchWP', '08825798A0B8FFFE8BE9C34EC3D7EB13')
)));
THE HASH IS THE imgdits PASSWORD FOLLOWED BY AUTH_SALT KEY
YOU CAN USE THE md5 HASH ONLINE TOOL
http://www.md5hashgenerator.com/
 */
if (!function_exists('secure_site_http_auth')){
	function secure_site_http_auth(){
		if(!is_admin()){
			global $wp;
			$http_host_parts = explode(".", $_SERVER['HTTP_HOST']);
			if (array_shift($http_host_parts) == "sg1" && ($_SERVER['REMOTE_ADDR'] != '220.233.131.47')) {
				# Check if user/pass has been entered
				if (!isset($_SERVER['PHP_AUTH_USER'])) {
					send_http_auth_headers();
				} else{
					# Check if the user/pass is correct
					$pass = false;
					foreach(unserialize(HTTP_CREDENTIALS) as $auth)
					{
						if ($_SERVER['PHP_AUTH_USER'] === $auth[0] && md5($_SERVER['PHP_AUTH_PW'].AUTH_SALT) === $auth[1]) {
							$pass = true;
						}
					}
					if (!$pass) send_http_auth_headers();
				}
			}
		}
	}
}
if (!function_exists('send_http_auth_headers')){
	function send_http_auth_headers(){
		header('WWW-Authenticate: Basic realm="Access Restricted"');
	        header('HTTP/1.0 401 Unauthorized');
	        echo 'The resource you want to access is restricted. Please contact the web administrator.';
	        exit;
	}
}

/**
 * Plugin Name: (WCM) Faster Admin Post Lists
 * AuthorURL:   http://unserkaiser.com
 * License:     MIT
 * REDUCE NUMBER OF QUERIED FIELDS FOR BETTER PERFORMANCE WP ADMIN PAGES
 */

//add_filter( 'posts_fields', 'wcm_limit_post_fields_cb', 0, 2 );
function wcm_limit_post_fields_cb( $fields, $query )
{
	if (
		! is_admin()
		OR ! $query->is_main_query()
		OR ( defined( 'DOING_AJAX' ) AND DOING_AJAX )
		OR ( defined( 'DOING_CRON' ) AND DOING_CRON )
		)
		return $fields;

	$p = $GLOBALS['wpdb']->posts;
	return implode( ",", array(
		"{$p}.ID",
		"{$p}.post_date",
		"{$p}.post_name",
		"{$p}.post_title",
		"{$p}.ping_status",
		"{$p}.post_author",
		"{$p}.post_password",
		"{$p}.comment_status",
		) );
}

//OPTIMIZE WP HEARTBEAT
function optimize_heartbeat_settings( $settings ) {
	$settings['autostart'] = false;
	$settings['interval'] = 60;
	return $settings;
}
add_filter( 'heartbeat_settings', 'optimize_heartbeat_settings' );

function disable_heartbeat_unless_post_edit_screen() {
	global $pagenow;
	if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' )
		wp_deregister_script('heartbeat');
}
add_action( 'init', 'disable_heartbeat_unless_post_edit_screen', 1 );

