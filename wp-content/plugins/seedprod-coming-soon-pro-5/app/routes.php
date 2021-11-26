<?php


/**
 * Postback Routes
 */


add_action( 'admin_init', 'seedprod_pro_export_subscribers' );



/**
 * Admin Menu Routes
 */


add_action( 'admin_menu', 'seedprod_pro_create_menus' );

function seedprod_pro_create_menus() {
	// get notifications count
	$notification        = '';
	$n                   = new SeedProd_Notifications();
	$notifications_count = $n->get_count();

	
	// check for invalid license
	$seedprod_a = get_option( 'seedprod_per' );
	if ( empty( $seedprod_a ) ) {
		$notifications_count = 1;
	}

	
	if ( ! empty( $notifications_count ) ) {
		$notification = '<div class="seedprod-menu-notification-counter"><span>' . $notifications_count . '</span></div>';
	}

	add_menu_page(
		'SeedProd',
		'SeedProd' . $notification,
		apply_filters( 'seedprod_main_menu_capability', 'edit_others_posts' ),
		'seedprod_pro',
		'seedprod_pro_dashboard_page',
		'data:image/svg+xml;base64,' . 'PHN2ZyB3aWR0aD0iMTI1IiBoZWlnaHQ9IjEzMiIgdmlld0JveD0iMCAwIDEyNSAxMzIiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0wIDBDMCAwIDIuOTE2NjQgMC4xOTc4OTQgNjIuODIxMiA4LjAyNjgzQzEyMi43MjYgMTUuODU1OCAxNDMuNDU5IDc2LjYwNjQgMTA2Ljc4MSAxMjkuNjI4QzExMi40NTQgODIuMjUyNyAxMDIuMDcgMzMuMTA2MiA2MC4zNjA1IDI3LjM2MDZDMTguNjUwNSAyMS42MTUxIDIyLjI4MzQgMjIuNDk1NCAyMi4yODM0IDIyLjQ5NTRDMjIuMjgzNCAyMi40OTU0IDIyLjk3NDUgMzIuOTI5OSAyNi44ODgzIDYwLjk3OTlDMzAuODAyMSA4OS4wMjk5IDUyLjcwMzUgMTAyLjc4NiA3MS44NzA0IDEwOS44NjhDNzEuODcwNCAxMDkuODY4IDcyLjk5NDUgNzcuMDQwMSA2Mi4zMDA3IDYyLjU5MDlDNTEuNjA2OSA0OC4xNDE4IDM4LjMwMjYgMzguNTQ2IDM4LjMwMjYgMzguNTQ2QzM4LjMwMjYgMzguNTQ2IDY5LjU2OCA0Mi4yOTYgODEuMzcyMiA2NC4xMDE5QzkzLjE3NjQgODUuOTA3OCA5Mi4wMjY1IDEzMiA5Mi4wMjY1IDEzMkw3OS4yOTI1IDEzMS4zNDFDNDUuMDI4NCAxMjcuMjI1IDEzLjAxNzIgMTA2LjU5MSA3LjU3NDIzIDYzLjNDMi4xMzEzIDIwLjAwODggMCAwIDAgMFoiIGZpbGw9ImJsYWNrIi8+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0wIDBDMCAwIDIuOTE2NjQgMC4xOTc4OTQgNjIuODIxMiA4LjAyNjgzQzEyMi43MjYgMTUuODU1OCAxNDMuNDU5IDc2LjYwNjQgMTA2Ljc4MSAxMjkuNjI4QzExMi40NTQgODIuMjUyNyAxMDIuMDcgMzMuMTA2MiA2MC4zNjA1IDI3LjM2MDZDMTguNjUwNSAyMS42MTUxIDIyLjI4MzQgMjIuNDk1NCAyMi4yODM0IDIyLjQ5NTRDMjIuMjgzNCAyMi40OTU0IDIyLjk3NDUgMzIuOTI5OSAyNi44ODgzIDYwLjk3OTlDMzAuODAyMSA4OS4wMjk5IDUyLjcwMzUgMTAyLjc4NiA3MS44NzA0IDEwOS44NjhDNzEuODcwNCAxMDkuODY4IDcyLjk5NDUgNzcuMDQwMSA2Mi4zMDA3IDYyLjU5MDlDNTEuNjA2OSA0OC4xNDE4IDM4LjMwMjYgMzguNTQ2IDM4LjMwMjYgMzguNTQ2QzM4LjMwMjYgMzguNTQ2IDY5LjU2OCA0Mi4yOTYgODEuMzcyMiA2NC4xMDE5QzkzLjE3NjQgODUuOTA3OCA5Mi4wMjY1IDEzMiA5Mi4wMjY1IDEzMkw3OS4yOTI1IDEzMS4zNDFDNDUuMDI4NCAxMjcuMjI1IDEzLjAxNzIgMTA2LjU5MSA3LjU3NDIzIDYzLjNDMi4xMzEzIDIwLjAwODggMCAwIDAgMFoiIGZpbGw9IndoaXRlIi8+PC9zdmc+',
		apply_filters( 'seedprod_top_level_menu_postion', 58 )
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Pages', 'seedprod-pro' ),
		__( 'Pages', 'seedprod-pro' ),
		apply_filters( 'seedprod_dashboard_menu_capability', 'edit_others_posts' ),
		'seedprod_pro',
		'seedprod_pro_dashboard_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Templates', 'seedprod-pro' ),
		__( 'Templates', 'seedprod-pro' ),
		apply_filters( 'seedprod_templates_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_templates',
		'seedprod_pro_templates_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Subscribers', 'seedprod-pro' ),
		__( 'Subscribers', 'seedprod-pro' ),
		apply_filters( 'seedprod_subscribers_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_subscribers',
		'seedprod_pro_subscribers_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Settings', 'seedprod-pro' ),
		__( 'Settings', 'seedprod-pro' ),
		apply_filters( 'seedprod_settings_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_settings',
		'seedprod_pro_settings_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Growth Tools', 'seedprod-pro' ),
		__( 'Growth Tools', 'seedprod-pro' ),
		apply_filters( 'seedprod_growthtools_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_growth_tools',
		'seedprod_pro_growth_tools_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'About Us', 'seedprod-pro' ),
		__( 'About Us', 'seedprod-pro' ),
		apply_filters( 'seedprod_aboutus_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_about_us',
		'seedprod_pro_about_us_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Request a Feature', 'seedprod-pro' ),
		'<span id="sp-feature-request">' . __( 'Request a Feature', 'seedprod-pro' ) . '</span>',
		apply_filters( 'seedprod_featurerequest_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_featurerequest',
		'seedprod_pro_featurerequest_page'
	);

	if ( SEEDPROD_PRO_BUILD == 'lite' ) {
		add_submenu_page(
			'seedprod_pro',
			__( 'Get Pro', 'seedprod-pro' ),
			'<span id="sp-lite-admin-menu__upgrade" style="color:#ff845b">' . __( 'Get Pro', 'seedprod-pro' ) . '</span>',
			apply_filters( 'seedprod_gopro_menu_capability', 'edit_others_posts' ),
			'seedprod_pro_get_pro',
			'seedprod_pro_get_pro_page'
		);
	}

	add_submenu_page(
		'seedprod_pro',
		__( 'Templates', 'seedprod-pro' ),
		__( 'Templates', 'seedprod-pro' ),
		apply_filters( 'seedprod_templates_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_template',
		'seedprod_pro_template_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Builder', 'seedprod-pro' ),
		__( 'Builder', 'seedprod-pro' ),
		apply_filters( 'seedprod_builder_menu_capability', 'edit_others_posts' ),
		'seedprod_pro_builder',
		'seedprod_pro_builder_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Import/Export', 'seedprod-pro' ),
		__( 'Import/Export', 'seedprod-pro' ),
		apply_filters( 'seedprod_exportimport_menu_capability', 'edit_others_posts' ),
		'sp_pro_importexport',
		'seedprod_pro_importexport_page'
	);

	add_submenu_page(
		'seedprod_pro',
		__( 'Debug', 'seedprod-pro' ),
		__( 'Debug', 'seedprod-pro' ),
		apply_filters( 'seedprod_debug_menu_capability', 'edit_others_posts' ),
		'sp_pro_debug',
		'seedprod_pro_debug_page'
	);
}

add_action( 'admin_head', 'seedprod_pro_remove_menus' );

function seedprod_pro_remove_menus() {
	remove_submenu_page( 'seedprod_pro', 'seedprod_pro_builder' );
	remove_submenu_page( 'seedprod_pro', 'seedprod_pro_template' );
	remove_submenu_page( 'seedprod_pro', 'sp_pro_importexport' );
	remove_submenu_page( 'seedprod_pro', 'sp_pro_debug' );
}

function seedprod_pro_importexport_page() {
	 require_once SEEDPROD_PRO_PLUGIN_PATH . 'resources/views/importexport.php';
}

function seedprod_pro_debug_page() {
	require_once SEEDPROD_PRO_PLUGIN_PATH . 'resources/views/debug.php';
}

function seedprod_pro_dashboard_page() {
	require_once SEEDPROD_PRO_PLUGIN_PATH . 'resources/views/dashboard.php';
}


function seedprod_pro_builder_page() {
	require_once SEEDPROD_PRO_PLUGIN_PATH . 'resources/views/builder.php';
}

function seedprod_pro_template_page() {
	 require_once SEEDPROD_PRO_PLUGIN_PATH . 'resources/views/builder.php';
}


/* Short circuit new request */

add_action( 'admin_init', 'seedprod_pro_new_lpage', 1 );


/* Redirect to SPA */

add_action( 'admin_init', 'seedprod_pro_redirect_to_site', 1 );

function seedprod_pro_redirect_to_site() {
	// settings page
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_settings' ) {
		wp_redirect( 'admin.php?page=seedprod_pro#/settings' );
		exit();
	}

	// subscribers
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_templates' ) {
		wp_redirect( 'admin.php?page=seedprod_pro_template&id=0&from=sidebar#/template' );
		exit();
	}

	// subscribers
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_subscribers' ) {
		wp_redirect( 'admin.php?page=seedprod_pro#/subscribers/0' );
		exit();
	}

	// growth tools page
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_growth_tools' ) {
		wp_redirect( 'admin.php?page=seedprod_pro#/growth-tools' );
		exit();
	}

	//  about us page
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_about_us' ) {
		wp_redirect( 'admin.php?page=seedprod_pro#/aboutus' );
		exit();
	}

	// feature request page
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_featurerequest' ) {
		wp_redirect( 'https://www.seedprod.com/suggest-a-feature/?utm_source=wordpress&utm_medium=plugin-sidebar&utm_campaign=suggest-a-feature' );
		exit();
	}

	// getpro page
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'seedprod_pro_get_pro' ) {
		wp_redirect( seedprod_pro_upgrade_link( 'wp-sidebar-menu' ) );
		exit();
	}
}

/**
 * Ajax Request Routes
 */

function seedprod_pro_render_shortcode() {
	//ob_start();
	echo do_shortcode( '[wpforms id="67" title="false" description="false"]' );
	//echo do_shortcode('[rafflepress id="23"]');
	//echo 'html';
	//return ob_get_clean();
	exit;
}


/**
 * Render WooCommerce Checkout Shortcode for Builder Preview
 */
function seedprod_pro_render_shortcode_wc_checkout() {
	// Prevent redirect if cart is empty for preview
	add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
	add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );

	echo do_shortcode( '[woocommerce_checkout]' );
	exit();
}


/**
 * Render WooCommerce Cart Shortcode for Builder Preview
 */
function seedprod_pro_render_shortcode_wc_cart() {
	echo do_shortcode( '[woocommerce_cart]' );
	exit;
}


if ( defined( 'DOING_AJAX' ) ) {
	
	add_action( 'wp_ajax_seedprod_pro_render_shortcode_wc_cart', 'seedprod_pro_render_shortcode_wc_cart' );

	add_action( 'wp_ajax_seedprod_pro_render_shortcode_wc_custom_products_grid', 'seedprod_pro_render_shortcode_wc_custom_products_grid' );

	

	
	add_action( 'wp_ajax_seedprod_pro_render_shortcode_wc_checkout', 'seedprod_pro_render_shortcode_wc_checkout' );
	

	add_action( 'wp_ajax_seedprod_pro_render_shortcode', 'seedprod_pro_render_shortcode' );

	add_action( 'wp_ajax_seedprod_pro_dismiss_settings_lite_cta', 'seedprod_pro_dismiss_settings_lite_cta' );

	add_action( 'wp_ajax_seedprod_pro_save_settings', 'seedprod_pro_save_settings' );
	add_action( 'wp_ajax_seedprod_pro_save_api_key', 'seedprod_pro_save_api_key' );

	add_action( 'wp_ajax_seedprod_pro_save_app_settings', 'seedprod_pro_save_app_settings' );

	
	add_action( 'wp_ajax_seedprod_pro_deactivate_api_key', 'seedprod_pro_deactivate_api_key' );
	

	add_action( 'wp_ajax_seedprod_pro_template_subscribe', 'seedprod_pro_template_subscribe' );
	add_action( 'wp_ajax_seedprod_pro_save_template', 'seedprod_pro_save_template' );
	add_action( 'wp_ajax_seedprod_pro_save_lpage', 'seedprod_pro_save_lpage' );
	add_action( 'wp_ajax_seedprod_pro_get_revisions', 'seedprod_pro_get_revisisons' );
	add_action( 'wp_ajax_seedprod_pro_get_utc_offset', 'seedprod_pro_get_utc_offset' );
	add_action( 'wp_ajax_seedprod_pro_get_namespaced_custom_css', 'seedprod_pro_get_namespaced_custom_css' );
	add_action( 'wp_ajax_seedprod_pro_get_stockimages', 'seedprod_pro_get_stockimages' );
	
	add_action( 'wp_ajax_seedprod_pro_backgrounds_sideload', 'seedprod_pro_backgrounds_sideload' );
	add_action( 'wp_ajax_seedprod_pro_backgrounds_download', 'seedprod_pro_backgrounds_download' );
	

	add_action( 'wp_ajax_seedprod_pro_slug_exists', 'seedprod_pro_slug_exists' );
	add_action( 'wp_ajax_seedprod_pro_lpage_datatable', 'seedprod_pro_lpage_datatable' );
	add_action( 'wp_ajax_seedprod_pro_duplicate_lpage', 'seedprod_pro_duplicate_lpage' );
	add_action( 'wp_ajax_seedprod_pro_get_lpage_list', 'seedprod_pro_get_lpage_list' );
	add_action( 'wp_ajax_seedprod_pro_archive_selected_lpages', 'seedprod_pro_archive_selected_lpages' );
	add_action( 'wp_ajax_seedprod_pro_unarchive_selected_lpages', 'seedprod_pro_unarchive_selected_lpages' );
	add_action( 'wp_ajax_seedprod_pro_delete_archived_lpages', 'seedprod_pro_delete_archived_lpages' );

	add_action( 'wp_ajax_seedprod_pro_update_subscriber_count', 'seedprod_pro_update_subscriber_count' );
	add_action( 'wp_ajax_seedprod_pro_subscribers_datatable', 'seedprod_pro_subscribers_datatable' );
	 
	add_action( 'wp_ajax_seedprod_pro_delete_subscribers', 'seedprod_pro_delete_subscribers' );
	

	add_action( 'wp_ajax_seedprod_pro_get_plugins_list', 'seedprod_pro_get_plugins_list' );

	add_action( 'wp_ajax_seedprod_pro_install_addon', 'seedprod_pro_install_addon' );
	add_action( 'wp_ajax_seedprod_pro_activate_addon', 'seedprod_pro_activate_addon' );
	add_action( 'wp_ajax_seedprod_pro_deactivate_addon', 'seedprod_pro_deactivate_addon' );

	add_action( 'wp_ajax_seedprod_pro_install_addon', 'seedprod_pro_install_addon' );
	add_action( 'wp_ajax_seedprod_pro_deactivate_addon', 'seedprod_pro_deactivate_addon' );
	add_action( 'wp_ajax_seedprod_pro_activate_addon', 'seedprod_pro_activate_addon' );
	add_action( 'wp_ajax_seedprod_pro_plugin_nonce', 'seedprod_pro_plugin_nonce' );

	add_action( 'wp_ajax_nopriv_seedprod_pro_run_one_click_upgrade', 'seedprod_pro_run_one_click_upgrade' );
	add_action( 'wp_ajax_seedprod_pro_upgrade_license', 'seedprod_pro_upgrade_license' );

	add_action( 'wp_ajax_seedprod_pro_get_wpforms', 'seedprod_pro_get_wpforms' );
	add_action( 'wp_ajax_seedprod_pro_get_wpform', 'seedprod_pro_get_wpform' );
	add_action( 'wp_ajax_seedprod_pro_get_rafflepress', 'seedprod_pro_get_rafflepress' );
	add_action( 'wp_ajax_seedprod_pro_get_rafflepress_code', 'seedprod_pro_get_rafflepress_code' );


	add_action( 'wp_ajax_seedprod_pro_dismiss_upsell', 'seedprod_pro_dismiss_upsell' );

	// WooCommerce.
	add_action( 'wp_ajax_seedprod_pro_get_woocommerce_products', 'seedprod_pro_get_woocommerce_products' );
	add_action( 'wp_ajax_seedprod_pro_get_woocommerce_product_taxonomy', 'seedprod_pro_get_woocommerce_product_taxonomy' );
	add_action( 'wp_ajax_seedprod_pro_get_woocommerce_product_attributes', 'seedprod_pro_get_woocommerce_product_attributes' );
	add_action( 'wp_ajax_seedprod_pro_get_woocommerce_product_attribute_terms', 'seedprod_pro_get_woocommerce_product_attribute_terms' );

	
	//Subscribe Callback
	add_action( 'wp_ajax_seedprod_pro_subscribe_callback', 'seedprod_pro_subscribe_callback' );
	add_action( 'wp_ajax_nopriv_seedprod_pro_subscribe_callback', 'seedprod_pro_subscribe_callback' );
	

	
	add_action( 'wp_ajax_seedprod_pro_get_domain_mapping_domain', 'seedprod_pro_get_domain_mapping_domain' );
	

}







/*
 * Force License Recheck
 */
add_action( 'init', 'seedprod_pro_force_license_recheck' );

add_action( 'init', 'seedprod_pro_deactivate_license' );




function seedprod_pro_get_wpforms() {
	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		$forms = array();
		if ( function_exists( 'wpforms' ) ) {
			$forms = \wpforms()->form->get( '', array( 'order' => 'DESC' ) );
			$forms = ! empty( $forms ) ? $forms : array();
			$forms = array_map(
				function ( $form ) {
					$form->post_title = wp_html_excerpt( htmlspecialchars_decode( $form->post_title, ENT_QUOTES ), 100 );
					return $form;
				},
				$forms
			);
		}

		wp_send_json( $forms );
	}
}

function seedprod_pro_get_wpform() {

	if ( check_ajax_referer( 'seedprod_nonce' ) && function_exists( 'wpforms_display' ) ) {
		$form_id          = filter_input( INPUT_GET, 'form_id', FILTER_SANITIZE_NUMBER_INT );
		$form_title       = filter_input( INPUT_GET, 'form_title', FILTER_VALIDATE_BOOLEAN );
		$form_description = filter_input( INPUT_GET, 'form_description', FILTER_VALIDATE_BOOLEAN );
		ob_start();
		?>
	  <link rel='stylesheet' id='wpforms-full-css'  href='<?php echo WPFORMS_PLUGIN_URL; ?>assets/css/wpforms-full.css' media='all' />
		<?php
		wpforms_display( $form_id, $form_title, $form_description );
		return wp_send_json( ob_get_clean() );
	}
}

function seedprod_pro_get_rafflepress() {
	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		$giveaways  = array();
		$rp_version = 'lite';
		if ( function_exists( 'rafflepress_pro_load_textdomain' ) ) {
			$rp_version = 'pro';
		}
		if ( function_exists( 'rafflepress_' . $rp_version . '_activation' ) || function_exists( 'rafflepress_' . $rp_version . '' ) ) {
			global $wpdb;
			$tablename = $wpdb->prefix . 'rafflepress_giveaways';
			$sql       = "SELECT id,name FROM $tablename WHERE deleted_at IS NULL";
			$giveaways = $wpdb->get_results( $sql );
		}

		wp_send_json( $giveaways );
	}
}

function seedprod_pro_get_rafflepress_code() {

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		$id = filter_input( INPUT_GET, 'form_id', FILTER_SANITIZE_NUMBER_INT );
		if(empty($id)){
			return '';
		}
		ob_start();
		?>
	  <div class="sp-relative">
	  <div class="rafflepress-giveaway-iframe-wrapper rpoverlay">
	  <iframe id="rafflepress-<?php echo $id; ?>"
		  src="<?php echo home_url() . '?rpid=' . $id . '?iframe=1' ?>"
		  frameborder="0" scrolling="no" allowtransparency="true" style="width:100%; height:400px" ></iframe>
  </div>
	</div>
		<?php
		$code = ob_get_clean();
		return wp_send_json( $code );
	}
}



/**
 * Render WooCommerce Custom Products Grid Shortcode for Builder Preview
 */
function seedprod_pro_render_shortcode_wc_custom_products_grid() {
	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		$cols           = $_GET['cols'];
		$paginate       = $_GET['paginate'];
		$limit          = $_GET['limit'];
		$order_by       = $_GET['orderby'];
		$order          = $_GET['order'];
		$skus           = $_GET['skus'];
		$ids            = $_GET['ids'];
		$category       = $_GET['category'];
		$tag            = $_GET['tag'];
		$product_group  = $_GET['product_group']; // Options - on_sale, best_selling, top_rated.
		$attribute      = $_GET['attribute'];
		$terms          = $_GET['terms'];
		$terms_operator = $_GET['terms_operator'];
		$tag_operator   = $_GET['tag_operator'];
		$cat_operator   = $_GET['cat_operator'];
		$visibility     = $_GET['visibility'];
		$source         = $_GET['source'];
		$group_attr     = '';

		if ( '' !== $product_group ) {
			$group_attr = $product_group . "='true'";
		}

		if ( 'all_products' === $source ) {
			echo do_shortcode( "[products paginate='$paginate' limit='$limit' columns='$cols' orderby='$order_by' order='$order' ]" );
		}

		if ( 'featured_products' === $source ) {
			echo do_shortcode( "[products visibility='featured' paginate='$paginate' limit='$limit' columns='$cols' ]" );
		}

		if ( 'sale_products' === $source ) {
			echo do_shortcode( "[products orderby='popularity' on_sale='true' paginate='$paginate' limit='$limit' columns='$cols' ]" );
		}

		if ( 'best_selling_products' === $source ) {
			echo do_shortcode( "[products best_selling='true' paginate='$paginate' limit='$limit' columns='$cols' ]" );
		}

		if ( 'recent_products' === $source ) {
			echo do_shortcode( "[products orderby='id' order='DESC' visibility='visible' paginate='$paginate' limit='$limit' columns='$cols']" );
		}

		if ( 'top_rated_products' === $source ) {
			echo do_shortcode( "[products orderby='popularity' top_rated='true' paginate='$paginate' limit='$limit' columns='$cols']" );
		}

		if ( 'custom_query' === $source ) {
			echo do_shortcode( "[products columns='$cols' paginate='$paginate' limit='$limit' orderby='$order_by' order='$order' ids='$ids' skus='$skus' category='$category' tag='$tag' $group_attr attribute='$attribute' terms='$terms' terms_operator='$terms_operator' tag_operator='$tag_operator' cat_operator='$cat_operator' visibility='$visibility']" );
		}

		exit;
	}
}

/**
 * Get WooCommerce Products.
 *
 * @return JSON object.
 */
function seedprod_pro_get_woocommerce_products() {
	$products = array();

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		// Check if Woocommmerce is installed and active.
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Fetch Products.
			$args = array(
				'status' => 'publish',
			);

			$p = wc_get_products( $args );

			foreach ( $p as $product ) {
				$products[] = $product->get_data();
			}
		}
	}

	wp_send_json( $products );
}

/**
 * Get product taxonomy.
 *
 * @return JSON object.
 */
function seedprod_pro_get_woocommerce_product_taxonomy() {
	$taxonomy = array();

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		// Check if Woocommmerce is installed and active.
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Fetch taxonomy.
			$args = array(
				'taxonomy'   => $_GET['taxonomy'],
				'hide_empty' => false,
			);

			$taxonomy = get_terms( $args );
		}
	}

	wp_send_json( $taxonomy );
}

/**
 * Get list of product attributes
 *
 * @return JSON object.
 */
function seedprod_pro_get_woocommerce_product_attributes() {
	$attributes = array();

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		// Check if Woocommmerce is installed and active.
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$attributes = wc_get_attribute_taxonomies();
		}
	}

	wp_send_json( $attributes );
}

/**
 * Get list of product attribute terms.
 *
 * @return JSON object.
 */
function seedprod_pro_get_woocommerce_product_attribute_terms() {
	$attribute_terms = array();

	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		// Check if Woocommmerce is installed and active.
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$attribute = $_GET['attribute'];

			// Get attribute terms
			if ( $attribute ) {
				$attribute_terms = get_terms(
					array(
						'taxonomy'   => 'pa_' . $attribute,
						'hide_empty' => false,
					)
				);
			}
		}
	}

	wp_send_json( $attribute_terms );
}

// login redirect
function seedprod_pro_redirect_login_page() {
	$post = $_POST;
	if ( empty( $post ) ) {
		$query = $_GET;

		if ( empty( $query ) || strpos( http_build_query( $query ), 'redirect_to' ) !== false || strpos( http_build_query( $query ), 'loggedout' ) !== false ) {
			// Top Level Settings
			$ts                = get_option( 'seedprod_settings' );
			$seedprod_settings = json_decode( $ts );

			// Page Info
			$page_id = 0;

			//Get 404 Page Id
			if ( ! empty( $seedprod_settings->enable_login_mode ) ) {
				$page_id = get_option( 'seedprod_login_page_id' );
			} else {
				return false;
			}

			// Get Page
			global $wpdb;
			$tablename = $wpdb->prefix . 'posts';
			$sql       = "SELECT * FROM $tablename WHERE id= %d";
			$safe_sql  = $wpdb->prepare( $sql, absint( $page_id ) );
			$page      = $wpdb->get_row( $safe_sql );

			$settings = json_decode( $page->post_content_filtered );

			if ( empty( $page ) ) {
				return false;
			}

			if ( ! empty( $settings->redirect_login_page ) && ! empty( $seedprod_settings->enable_login_mode ) ) {
				wp_redirect( '/?page_id=' . $page_id );
			}
		}
	}
}
add_action( 'login_head', 'seedprod_pro_redirect_login_page' );


