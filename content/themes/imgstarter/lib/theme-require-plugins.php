<?php

/**
 * Register the required plugins for this theme.
 */
function mb_register_required_plugins() {

	$default_plugins = array(

		// ACF v4
		/*
		array(
			'name'				=> 'Advanced Custom Fields',
			'slug'				=> 'advanced-custom-fields',
			'required'			=> true,
			'force_activation'	=> false
		),
		*/

		// ACF v4 compatible, for v5 compatible version get from https://github.com/taylormsj/acf-cf7
		/*
		array(
			'name'				=> 'Advanced Custom Fields: Contact Form 7 Field',
			'slug'				=> 'advanced-custom-fields-contact-form-7-field',
			'required'			=> true,
			'force_activation'	=> false
		),
		*/

		array(
			'name'				=> 'ACF-Content Analysis for Yoast SEO',
			'slug'				=> 'acf-content-analysis-for-yoast-seo',
			'required'			=> true,
			'force_activation'	=> false
		),

		array(
			'name'				=> 'Autoptimize',
			'slug'				=> 'autoptimize',
			'required'			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Broken Link Checker',
			'slug' 				=> 'broken-link-checker',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Contact Form 7',
			'slug' 				=> 'contact-form-7',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Contact Form CFDB7',
			'slug' 				=> 'contact-form-cfdb7',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Rel Nofollow Checkbox',
			'slug' 				=> 'rel-nofollow-checkbox',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Safe Redirect Manager',
			'slug' 				=> 'safe-redirect-manager',
			'required' 			=> true,
			'force_activation'	=> false
		),

		// array(
		// 	'name' 				=> 'Save Contact Form 7',
		// 	'slug' 				=> 'save-contact-form-7',
		// 	'required' 			=> true,
		// 	'force_activation'	=> false
		// ),

		array(
			'name' 				=> 'Theme My Login',
			'slug' 				=> 'theme-my-login',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'User Role Editor',
			'slug' 				=> 'user-role-editor',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'W3 Total Cache',
			'slug' 				=> 'w3-total-cache',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'WP-DB-Backup',
			'slug' 				=> 'wp-db-backup',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'Wordpress Firewall',
			'slug' 				=> 'wordpress-firewall',
			'required' 			=> true,
			'force_activation'	=> false
		),

		array(
			'name' 				=> 'WordPress SEO by Yoast',
			'slug' 				=> 'wordpress-seo',
			'required' 			=> true,
			'force_activation'	=> false
		),

	);

	/*
	 * FILTER TO ALLOW CHILD THEMES TO INJECT A CUSTOM ARRAY OF PLUGINS FOR THE THEME
	 * @param $custom_plugins : array( array('name' => 'Plugin Name', 'slug' => 'plugin-name', 'required' => true, 'force_activation' => true), ...)
	 * @param $method : string (default is 'override'. Options: override, add, merge)
	 */
/*
	$custom_plugins = apply_filters('theme_custom_plugins', $custom_plugins = array(), $method = 'override');

	if ($method == 'override') $plugins = $custom_plugins;

	if ($method == 'add'){
 */
		$plugins = $default_plugins;
/*		array_push($plugins, $custom_plugins);
	}

	if ($method == 'merge'){
		$plugins = array();

		$temp_custom_plugins = $temp_default_plugins = array();
		foreach($custom_plugins as $single_plugin){
			$temp_custom_plugins[] = $single_plugin['name'];
		}
		foreach($default_plugins as $single_plugin){
			$temp_default_plugins[] = $single_plugin['name'];
		}
		$temp_combined = array_unique(array_merge($temp_custom_plugins, $temp_default_plugins));
		$temp_remaining = array_diff($temp_combined, $temp_default_plugins);

		$plugins = $custom_plugins;
		foreach($default_plugins as $single_plugin){
			if (!in_array($single_plugin['name'], $temp_remaining)){
				$plugins[] = $single_plugin;
			}
		}
	}
*/
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
			'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);

	if (function_exists( 'tgmpa' ) ) {
		tgmpa( $plugins, $config );
	}
}
