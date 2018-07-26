<?php
// CUSTOM POST TYPES
require_once(get_template_directory() . '/../core/lib/acpt.php');

// CREATING COMMON TAXONOMIES
function myargs($label = null, $hierarchical = true, $slug = '')
{
	$lowercase = strtolower($label);
	$plural = substr($label, -1) == 's' ? $label : $label .'s';
	$labels = array(
		'name'              => _x( $plural, 'taxonomy general name' ),
		'singular_name'     => _x( $label, 'taxonomy singular name' ),
		'search_items'      => __( 'Search '.$plural ),
		'all_items'         => __( 'All '.$plural ),
		'parent_item'       => __( 'Parent '.$label ),
		'parent_item_colon' => __( 'Parent '.$label.':' ),
		'edit_item'         => __( 'Edit '.$label ),
		'update_item'       => __( 'Update '.$label ),
		'add_new_item'      => __( 'Add New '.$label ),
		'new_item_name'     => __( 'New '.$label.' Name' ),
		'menu_name'         => __( $label ),
	);

	$args = array(
		'hierarchical'      => $hierarchical,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);
	if ( $slug != '' )
		$args['rewrite'] = array( 'slug' => $slug );

	return $args;
}
// CREATING CUSTOM POST TYPES
global $cpt_args_simple;
$cpt_args_simple = array(
	'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
	'show_in_nav_menus' => TRUE,
	'has_archive' => TRUE
);

// EXAMPLE OF CPT
/*
// CPT - Study
$study = new acpt(
	array(
		'post_type_name' => 'study',
		'singular' => 'Study', //singular
		'plural' => 'Studies', //plural
		'slug' => 'study' //slug
		),
	array(
		'supports' => array('title', 'thumbnail', 'excerpt', 'revisions'),
		'show_in_nav_menus'   => TRUE,
		'has_archive' => TRUE,
//	    'taxonomies' => array('post_tag')
		)
);
$study->menu_icon('dashicons-welcome-learn-more');

// Taxonomy - Service
register_taxonomy( 'service', array( 'study'), myargs('Services', true, 'services'));
*/

// SORTABLE
/*
// true = string, false = number
$products->sortable(array(
	'category' => array('category', true),
	'feature-order' => array('feature-order', false),
	'cat-order' => array('cat-order', false),
	'subcat-order' => array('subcat-order', false),
	'brand' => array('brand', true)
));
*/

// MODIFYING THE HELP TEXT "ENTER TITLE HERE" IN CUSTOM POST TYPES
/*
add_filter('gettext','custom_enter_title');

function custom_enter_title( $input ) {

	global $post_type;

	if( is_admin() && 'Enter title here' == $input && 'staff' == $post_type )
		return 'Enter full name';
	if( is_admin() && 'Enter title here' == $input && 'study' == $post_type )
		return 'Enter the case study title';


	return $input;
}
*/

// ADMIN COLUMNS TO CUSTOM TAXONOMY - SERVICE
/*
add_filter("manage_edit-service_columns", 'service_columns');
function service_columns($theme_columns) {
	$new_columns = array(
		'cb' => '<input type="checkbox" />',
		'thumb' => __('Image'),
		'name' => __('Service Name'),
		'descr' => __('Description'),
		'slug' => __('Slug'),
		'posts' => __('Count')
		);
	return $new_columns;
}
// Add to admin_init function
add_filter("manage_service_custom_column", 'manage_service_columns', 10, 3);
function manage_service_columns($out, $column_name, $cat_id) {
	$cat = get_term($cat_id, 'service');
	switch ($column_name) {
		case 'thumb':
			$term_id = $cat->term_id;

			$data = get_field(get_acf_key('image','service'), 'service'. '_' .$term_id);

			// ACF FIX Image error -> returns ID instead of Object
			if (!empty($data))
			{
				if (!is_array($data))
				{
					// ACF Image ID
					$image_attributes = wp_get_attachment_image_src($data);
					if ($image_attributes)
					{
						$thumb_url = $image_attributes[0];
					}
				}
				else
				{
					// ACF Image Object
					$thumb_url = $data['url'];
				}
			}
			else
			{
				// No image has been added to this term - display placeholder.
				// $thumb_url = get_template_directory_uri() . '/images/img_default_616x400.jpg';
				$thumb_url = "https://placehold.it/616x400";
			}
			// ACF FIX Image error -> returns ID instead of Object

			$out .= "<img src=\"{$thumb_url}\" width=\"80\" />";
			break;
		default:
			break;
	}
	return $out;
}
*/

//ADMIN COLUMNS TO CUSTOM POST TYPE - STAFF
/*
$staff->columns(array(
	'cb' => '<input type="checkbox" />',
	'thumbnail' => __('Picture'),
	'hover' => __('Hover Picture'),
	'title' => __('Name'),
	'team' => __('Team'),
	'date' => __('Date')
));
$staff->populate_column('thumbnail', function($column, $post){
	$post_id = $post->ID;
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) , 'full');
	if (empty($feat_image))
	{
		$feat_image = 'https://placehold.it/280x280';
	}
	echo "<img src='".$feat_image."' width='80' />";
});
$staff->populate_column('hover', function($column, $post){
	$post_id = $post->ID;
    $data = get_field('hover_image', $post_id);

	// ACF FIX Image error -> returns ID instead of Object
	if (!empty($data))
	{
		if (!is_array($data))
		{
			// ACF Image ID
			$image_attributes = wp_get_attachment_image_src($data);
			if ($image_attributes)
			{
				$thumb_url = $image_attributes[0];
			}
		}
		else
		{
			// ACF Image Object
			$thumb_url = $data['url'];
		}
	}
	else
	{
		//No image has been added to this term - display placeholder.
		//$thumb_url = get_template_directory_uri() . '/images/img_default_616x400.jpg';
		$thumb_url = "https://placehold.it/280x280";
	}
	// ACF FIX Image error -> returns ID instead of Object

	echo "<img src='".$thumb_url."' width='80' />";
});
*/
