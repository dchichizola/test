<?php
if (!class_exists('Icon_Grid_Menu_Walker')){
	class Icon_Grid_Menu_Walker extends Walker {
		var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
		var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

		function start_lvl(&$output, $depth) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent";
			$output .= "<i class=\"dropdown icon\"></i>\n";
			$output .= "<div class=\"menu\">\n";
		}

		function end_lvl(&$output, $depth) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</div>\n";
		}

		function start_el(&$output, $item, $depth, $args) {
			$value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array();
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', '', $item, $args );
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			//Gathering info
			//echo '<xmp>'; print_r($item); echo '</xmp>';
			$data = get_field(get_acf_key('image','service'), 'service'. '_' .$item->object_id);
			/* ACF FIX Image error -> returns ID instead of Object */
			if (!empty($data))
			{
				if (!is_array($data))
				{
					//ACF Image ID
					$image_attributes = wp_get_attachment_image_src($data, 'full');
					if ($image_attributes)
					{
						$thumb_url = $image_attributes[0];
					}
				}
				else
				{
					//ACF Image Object
					$thumb_url = $data['url'];
				}
			}
			else
			{
				//No image has been added to this term - display placeholder.
				//$thumb_url = get_template_directory_uri() . '/images/img_default_616x400.jpg';
				$thumb_url = "http://placehold.it/616x400";
			}
			/* ACF FIX Image error -> returns ID instead of Object */


			$item_output = $args->before;
//	        $item_output .= '<a'. $attributes . $id . $value . $class_names . '>';

	        //	        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '	<div class="col-xs-6 col-sm-4 col-md-2">';
			$item_output .= '		<div class="service_item">';
			$item_output .= '			<div class="service_item--icon"><img src="'.$thumb_url.'" alt="'.$item->title.'"></div>';
			$item_output .= '			<div class="service_item--content">';
			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= '			</div>';
			$item_output .= '		</div>';
			$item_output .= '	</div>';
			$clear_classes = '';
			if ($item->menu_order % 6 == 0) {
				$clear_classes .= 'clearfix visible-md-block';
			}else if ($item->menu_order % 3 == 0){
				$clear_classes .= 'clearfix visible-sm-block';
			}else if ($item->menu_order % 2 == 0){
				$clear_classes .= 'clearfix visible-xs-block';
			}
			if ($clear_classes != '')
				$item_output .= '	<div class="'.$clear_classes.'"></div>'; // CLEAR FIXES


//	        $item_output .= "</a>\n";
			$item_output .= "\n";
			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}
