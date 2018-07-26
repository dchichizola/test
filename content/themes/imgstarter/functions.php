<?php
/****************************************
Theme Setup
 *****************************************/

/**
 * Theme initialization
 */
require get_template_directory() . '/lib/init.php';

/**
 * Custom theme functions defined in /lib/init.php
 */
require get_template_directory() . '/lib/theme-functions.php';

/**
 * Shortcodes
 */
require get_template_directory() . '/lib/theme-shortcodes.php';

/*
 * Custom Post Type and Taxonomy Functions
 */
require get_template_directory() . '/lib/theme-cpt.php';

/**
 * Helper functions for use in other areas of the theme
 */
require get_template_directory() . '/lib/theme-helpers.php';

/**
 * Theme Hook Alliance for use in other areas of the theme
 */
require get_template_directory() . '/../core/lib/tha/tha-theme-hooks.php';


/****************************************
Require Plugins
 *****************************************/

require get_template_directory() . '/lib/class-tgm-plugin-activation.php';
require get_template_directory() . '/lib/theme-require-plugins.php';
add_action( 'tgmpa_register', 'mb_register_required_plugins' );

/****************************************
Misc Theme Functions
 *****************************************/

/**
 * Filter Yoast SEO Metabox Priority
 */
add_filter( 'wpseo_metabox_prio', 'core_filter_yoast_seo_metabox' );
function core_filter_yoast_seo_metabox() {
	return 'low';
}
