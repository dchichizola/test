<?php
/*
LIST MENU
Function that will return our Wordpress menu

[listmenu menu="sitemap" container_class="sitemap-list" before="<ul>" after="</ul>"]
*/
if (!function_exists('list_menu')){
	add_shortcode("listmenu", "list_menu");
	function list_menu($atts, $content = null) {
		extract(shortcode_atts(array(
			'menu'            => '',
			'container'       => 'div',
			'container_class' => '',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 0,
			'walker'          => '',
			'theme_location'  => ''),
			$atts));


		return wp_nav_menu( array(
			'menu'            => $menu,
			'container'       => $container,
			'container_class' => $container_class,
			'container_id'    => $container_id,
			'menu_class'      => $menu_class,
			'menu_id'         => $menu_id,
			'echo'            => false,
			'fallback_cb'     => $fallback_cb,
			'before'          => $before,
			'after'           => $after,
			'link_before'     => $link_before,
			'link_after'      => $link_after,
			'depth'           => $depth,
			'walker'          => $walker,
			'theme_location'  => $theme_location));
	}
}


/*

DISPLAY POSTS SHORTCODE
[display_posts]
[display_posts mycount='3' classname='myprojects' template_filename='parts/template-post' override_template = 'false']

Multiple Post Types (no spaces around the comma):
[display_posts mycount='3' classname='myprojects' post_type='article,event']

*/

if (!function_exists('my_posts')){
	$shortcode_name = 'display_posts';
	add_shortcode($shortcode_name, 'my_posts');
	function my_posts($atts, $content = null){
		extract( shortcode_atts( array(
			'mycount' => 3,
			'mysort' => true,
			'include' => '',
			'exclude' => '',
			'post_type' => 'post',
			'classname' => str_replace(',', '-', $atts['post_type']) . '-list',
			'template_filename' => 'parts/part_' . str_replace(',', '-', $atts['post_type']) . '-grid',
			'override_template' => 'false',
			'html_tag' => 'div',
			'widgetID' => '',
			'post_status' => 'publish',
			'post_parent' => '',
			'orderby' => 'date', // Use 'rand', for random posts
			'order' => 'DESC',
			'wrap_before' => '',
			'wrap_after' =>''
		), $atts, $shortcode_name ) );


		$save_post = $GLOBALS['post'];  // Save state so you can restore later

		if ($post_type == 'post' && $override_template == 'true') $template_filename = 'post';
		if (strpos($post_type, ',') !== false) {
			$post_type = explode(',', $post_type);
		}
		$template_file = get_stylesheet_directory() . "/{$template_filename}.php";
		if (!file_exists($template_file)) {
			return "<p>Missing template [$template_file].</p>";
		} else {
			global $post;

			if ( ! is_array($include) && $include != '' )
				$include = explode(',', $include);

			if ( ! is_array($exclude) && $exclude != '' )
				$exclude = explode(',', $exclude);

			//$q = new WP_Query("showposts={$mycount}&post_type={$post_type}&post_status={$post_status}{$post_parent_string}&post__not_in={$exclude}&orderby={$orderby}&order={$order}");
			$query_args = array(
				'showposts' => $mycount,
				'post_type' => $post_type,
				'post_status' => $post_status,
				'post__in' => $include,
				'post__not_in' => $exclude,
				'orderby' => $orderby,
				'order' => $order
			);
			if ($post_parent != '')
				$query_args['post_parent'] = $post_parent;

			$q = new WP_Query($query_args);
			$rows = array();

			$widgetAttributes = '';
			if ($widgetID != '') $widgetAttributes = 'id="'.$widgetID.'"';

			if ( is_array($post_type) ) {
				$rows[] = '<'.$html_tag.' class="'.$classname.' ' . implode('-', $post_type) . '-post-list" '.$widgetAttributes.'>'.$wrap_before;
			} else {
				// Must not call `implode()` on a string, as it returns NULL
				$rows[] = '<'.$html_tag.' class="'.$classname.' ' . $post_type . '-post-list" '.$widgetAttributes.'>'.$wrap_before;
			}

			global $post_list_data;
			$post_list_data = array();
			$post_list_data['post_count'] = $post_count = count($q->posts);

			global $post_list_counter;
			$post_list_counter = 0;
			foreach ($q->posts as $post) {
				$q->the_post();
				$post_list_counter++;
				ob_start();
				include($template_file);
				$rows[] = ob_get_clean();
			}
			$rows[] = $wrap_after.'</'.$html_tag.'>';
			$GLOBALS['post'] = $save_post;

			return implode("\n",$rows);
		}
	}
}


/*

DISPLAY TERM LIST SHORTCODE
Usage: [display_termlist taxonomy='brand' template_filename='partials/content-brand-grid' hide_empty='FALSE' classname='brandcontainer' wrap_before='<div class="row">' wrap_after='</div>']

*/

if (!function_exists('render_term_list')){
	$shortcode_name = 'display_termlist';
	add_shortcode($shortcode_name, 'render_term_list');
	function render_term_list($atts, $content = null){
		extract( shortcode_atts( array(
			'taxonomy' => 'category',
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'parent' => 0,
			'exclude' => '1',
			'current' => '',
			'sortbyacf' => '',
			'classname' => 'term-list',
			'template_filename' => 'parts/part_'.$atts['taxonomy']. '-grid',
			'html_tag' => 'div',
			'widgetID' => '',
			'wrap_before' => '',
			'wrap_after' =>''
			), $atts, $shortcode_name ) );

		$save_post = $GLOBALS['post'];  // Save state so you can restore later

		$template_file = get_stylesheet_directory() . "/{$template_filename}.php";
		if (!file_exists($template_file)) {
			return "<p>Missing template [$template_file].</p>";
		} else {
			$taxonomies = array($taxonomy);

			if ($exclude != ''){
				if (strpos(',', $exclude) == -1) {
					$exclude = array($exclude);
				}
				else {
					$exclude = explode(',', $exclude);
				}
			}

			$args = array(
				'orderby'           => $orderby,
				'order'             => $order,
				'hide_empty'        => $hide_empty,
				'parent'            => $parent,
				'exclude'			=> $exclude, //REMOVE UNCATEGORIZE CATEGORY
			);
			$terms = get_terms($taxonomies, $args);

			if ($sortbyacf != '')
			{
				for ($i=0; $i<count($terms); $i++) {
					$terms[$i]->sort_order = get_field($sortbyacf, $taxonomies[0].'_'.$terms[$i]->term_id);
				}
				usort($terms, 'my_sort_terms_function');
			}

			$rows = array();

			$widgetAttributes = '';
			if ($widgetID != '') $widgetAttributes = 'id="'.$widgetID.'"';

			$rows[] = '<'.$html_tag.' class="'.$classname.' ' . $taxonomy . '-term-list" '.$widgetAttributes.'>'.$wrap_before;

			global $dd_tax_list_counter, $term, $current_term;

			$current_term = $current;
			$dd_tax_list_counter = 0;
			foreach ($terms as $term)
			{
				$dd_tax_list_counter++;
				ob_start();
				include($template_file);
				$rows[] = ob_get_clean();
			}
			$rows[] = $wrap_after.'</'.$html_tag.'>';
			$GLOBALS['post'] = $save_post;
			return implode("\n",$rows);

		}
	}
}


/**
 *
 * INCLUDE EXTERNAL FILES FROM SHORTCODE
 *  i.e.
 * 	[include slug="form"]
 *	[include slug="sub-folder/filename_without_extension"]
 *  [include slug="sub-folder/filename_without_extension" title="Variable to be used as header in the template"]
 */
function include_file($atts, $content = null){
		extract( shortcode_atts( array(
			'slug' => 'NULL',
			'title' => ''
		), $atts, 'include' ) );
		if($slug != 'NULL'){
			global $the_title;
			$the_title = $title;
			ob_start();
			get_template_part($slug);
			return ob_get_clean();
		}

}
add_shortcode('include', 'include_file');
