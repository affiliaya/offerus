<?php

if ( defined( 'DOING_AJAX' ) ) {
	
	add_action( 'wp_ajax_seedprod_pro_get_nested_navmenu', 'seedprod_pro_get_nested_navmenu' );
	
}

function seedprod_pro_get_nested_navmenu(){

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {

		$navmenu_name = filter_input( INPUT_GET, 'navmenu_name' );
		$args = ['menu'=>$navmenu_name,
				'container_class' => 'nav-menu-bar',
			 	'menu_class' => 'seedprod-menu-list'];
		wp_nav_menu($args);

		wp_die();

	}
}

add_shortcode('seedprodnestedmenuwidget', 'seedprod_pro_wordpress_menuwidget');

function seedprod_pro_wordpress_menuwidget( $atts ){

	$navmenu_name = "";	
	if(isset($atts[0])){
		$navmenu_name = $atts[0];
	}
	$args = ['menu'=>$navmenu_name, 
			 'container_class' => 'nav-menu-bar',
			 'menu_class' => 'seedprod-menu-list'
			];
	
	ob_start();
	wp_nav_menu($args);
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode('seedprodwpwidget', 'seedprod_pro_wordpress_widget');

function seedprod_pro_wordpress_widget( $atts ){

	$widget_name = $atts[0];
	unset($atts[0]);

	global $wp_widget_factory;
	$inst = $wp_widget_factory->widgets[$widget_name];
	$instance = $atts;

	ob_start();
	the_widget( $widget_name , $instance );
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

