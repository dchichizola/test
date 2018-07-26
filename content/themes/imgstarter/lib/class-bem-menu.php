<?php
/*
BEM Menu Class

Example usage - place this in the header or footer:

// CLEAN CUSTOM MENUS FUNCTION
// Defined in lib/theme-functions.php
if (class_exists('bem_menu')){
	$menu = new bem_menu(array(
		'location_name'   		=> 'mobile',
		'menu_name'       		=> 'navbar',
		'menu_class' 			=> 'menu_mobile menu--push-right hidden-md-up hidden-print',
		'link_class'    		=> 'button ripple js-ripple',
		'close_button_enabled' 	=> 'true'
	));
	echo $menu->output;
}
*/

if ( ! class_exists( 'bem_menu' ) ) {
	class bem_menu {

		public $submenu = array();

		private static $post;

		private static $toplevels;

		public $menu_items = array();

		public static $output;



		public function __construct($atts) {
			extract(shortcode_atts(array(
				'location_name'   		=> 'navbar',
				'menu_name'	   		=> 'navbar',
				'menu_class' 			=> '',
				'link_class'			=> 'link ripple js-ripple',
				'close_button_enabled' 	=> 'false',
				'protected_pages'		=> array(''),
				'hidden_on_logon_pages'	=> array('Register')
				),
			$atts));

			global $post;
			//self::$post = $post;

			$this->location_name = $location_name;
			$this->menu_name = $menu_name;
			$this->menu_class = $menu_class;
			$this->link_class = $link_class;
			$this->close_button_enabled = $close_button_enabled;
			$this->protected_pages = $protected_pages;
			$this->hidden_on_logon_pages = $hidden_on_logon_pages;

			$this->menu_items = wp_get_nav_menu_items($menu_name);

			$this->submenu = $submenu;
			$this->toplevels = self::$toplevels;

			//Populating submenus
			$this->populating_submenus();

			//Building the output;
			$output = $this->build_output();
			$this->output = $output;
		}

		public function findchildren($parent_id)
		{
			$submenu = $this->submenu;
			$children = $submenu[$parent_id];
			if (count($children) > 0)
			{
				return $children;
			}
			else
			{
				return false;
			}
		}

		public function populating_submenus() {

			$menu_items = $this->menu_items;
			$submenu = $this->submenu;
			$toplevels = $this->toplevels;

			foreach ((array)$menu_items as $key => $menu_item)
			{
				if ($menu_item->menu_item_parent != '0')
				{
					$submenu[$menu_item->menu_item_parent][] = $menu_item;
				}
				else
				{
					$toplevels++;
				}
			}
			$this->toplevels = $toplevels;
			$this->submenu = $submenu;
		}

		public function build_output() {

			$menu_name = $this->menu_name;
			$location_name = $this->location_name;
			$link_class = $this->link_class;
			$menu_class = $this->menu_class;
			$menu_items = $this->menu_items;
			$toplevels = $this->toplevels;
			$protected_pages = $this->protected_pages;
			$hidden_on_logon_pages = $this->hidden_on_logon_pages;
			$close_button_enabled = $this->close_button_enabled;

	$return = '<nav class="menu '.$menu_class.'" itemscope="itemscope"  itemtype="http://schema.org/SiteNavigationElement">';
	$return .= '<ul class="menu__list" role="menubar">';

	$toplevelcount = 0 ;
	foreach ((array)$menu_items as $key => $menu_item)
	{
		if ($menu_item->menu_item_parent == '0')
		{
			//ORDER
			if ($toplevelcount == 0)
			{
				$order = ' first';
			}
			else if ($toplevelcount == $toplevels-1)
			{
				$order = ' last';
			}
			else
			{
				$order = '';
			}

			//CHILDREN
			$haschild = $this->findchildren($menu_item->ID);
			if (is_array($haschild))
			{
				$children = ' haschild';
			}
			else
			{
				$children = '';
			}

			//PROTECTED AND HIDDEN PAGES BASED ON USER LOGIN
			if (in_array($menu_item->title, $protected_pages) && !is_user_logged_in())
			{
				//SKIP THE PAGE AND SUBPAGES
			}
			else if (in_array($menu_item->title, $hidden_on_logon_pages) && is_user_logged_in())
			{
				//SKIP THE PAGE
			}
			else
			{
				$title = $menu_item->title;
				$url = substr($menu_item->url,0,1) == '/' ? get_bloginfo('siteurl') . $menu_item->url : $menu_item->url;
				$return .= '<li class="menu__item'. (getUrl() == $url ? ' menu__item--active': '') . $order . $children . '" role="menuitem"><a href="'. $url .'" class="'.$link_class.'">'. $title .'</a>';

				if (is_array($haschild))
				{
					$return .= '<ul class="menu__list--sub-level" aria-hidden="true" role="menu">';
					$sublevelcount = 0;

					foreach((array)$haschild as $key => $child)
					{
						//ORDER
						if ($sublevelcount == 0)
						{
							$order = ' first';
						}
						else if ($sublevelcount == count($haschild)-1)
						{
							$order = ' last';
						}
						else
						{
							$order = '';
						}

						$title = $child->title;
						$url = substr($child->url,0,1) == '/' ? get_bloginfo('siteurl') . $child->url : $child->url;
						$return .= '<li class="menu__item'. (getUrl() == $url ? ' menu__item--active': '') . $order  . '" role="menuitem"><a href="'. $url .'" class="'.$link_class.'">'. $title .'</a></li>';

						$sublevelcount++;
					}
					$return .= '</ul>';
				}
				$return .= '</li>';
			}
			$toplevelcount++;
		}
	}
	$return .= '</ul>';
	if ($close_button_enabled === 'true'){
		$return .= '<div class="menu-button__close" role="link">CLOSE</div>';
	}
	$return .= '</nav>';
	return $return;



		} /* BUILD OUTPUT */

	}
}
