<?php

/*
 * subscribers Datatable
 */
function seedprod_pro_subscribers_datatable() {
	if ( check_ajax_referer( 'seedprod_nonce' ) ) {
		$data         = array( '' );
		$current_page = 1;
		if ( ! empty( absint( $_GET['current_page'] ) ) ) {
			$current_page = absint( $_GET['current_page'] );
		}
		$per_page = 100;

		$filter = null;
		if ( ! empty( $_GET['filter'] ) ) {
			$filter = sanitize_text_field( $_GET['filter'] );
			if ( $filter == 'all' ) {
				$filter = null;
			}
		}

		if ( ! empty( $_GET['s'] ) ) {
			$filter = null;
		}

		$results = array();
		
		global $wpdb;
		$tablename = $wpdb->prefix . 'csp3_subscribers';

		// Get records

		$sql = "SELECT *
             FROM $tablename 
             ";

		if ( ! empty( $_GET['id'] ) ) {
			$sql .= ' WHERE page_uuid = "' . esc_sql( $_GET['id'] ) . '"';

		} else {
			$sql .= ' WHERE 1 =1 ';
		}

		if ( ! empty( $_GET['s'] ) ) {
			$sql .= ' AND email LIKE "%' . esc_sql( trim( sanitize_text_field( $_GET['s'] ) ) ) . '%"';
		}

		if ( ! empty( $_GET['orderby'] ) ) {
			// $orderby = $_GET['orderby'];
			// if ($_GET['orderby'] == 'entries') {
			//     $orderby  = 'entries_count';
			// }
			// $sql .= ' ORDER BY ' . esc_sql(sanitize_text_field($orderby));
			// if(sanitize_text_field($_GET['order']) === 'desc'){
			//     $order = 'DESC';
			// }else{
			//     $order = 'ASC';
			// }
			// $sql .=  ' ' . $order;
		} else {
			$sql .= ' ORDER BY created DESC';
		}

		$sql .= " LIMIT $per_page";
		if ( empty( $_GET['s'] ) ) {
			$sql .= ' OFFSET ' . ( $current_page - 1 ) * $per_page;
		}

		$results = $wpdb->get_results( $sql );
		
		//var_dump($results);
		$data = array();
		foreach ( $results as $v ) {

				// Format Date
			$created_at = date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $v->created ) );

			// Load Data
			$data[] = array(
				'id'         => $v->id,
				'email'      => $v->email,
				'name'       => $v->fname . ' ' . $v->lname,
				'created_at' => $created_at,
				'page_uuid'  => $v->page_uuid,
			);
		}

		$totalitems = 0;
		$views      = array();
		
		$totalitems = seedprod_pro_subscribers_get_data_total( $filter );
		$views      = seedprod_pro_subscribers_get_views( $filter );
		

		// Get recent subscriber data
		$chart_timeframe = 7;
		if ( ! empty( $_GET['interval'] ) ) {
			$chart_timeframe = absint( $_GET['interval'] );
		}

		$recent_subscribers = array();
		
		if ( empty( $_GET['id'] ) ) {
			$tablename          = $wpdb->prefix . 'csp3_subscribers';
			$sql                = 'SELECT count(id) as count,DATE_FORMAT(created,"%Y-%m-%d") as created FROM ' . $tablename . ' ';
			$sql               .= ' WHERE created >= DATE(NOW()) - INTERVAL ' . esc_sql( $chart_timeframe ) . ' DAY GROUP BY DAY(created)';
			$recent_subscribers = $wpdb->get_results( $sql );

		} else {

			$tablename          = $wpdb->prefix . 'csp3_subscribers';
			$sql                = 'SELECT count(id) as count,DATE_FORMAT(created,"%Y-%m-%d") as created FROM ' . $tablename . ' ';
			$sql               .= ' WHERE page_uuid = "' . esc_sql( $_GET['id'] ) . '"';
			$sql               .= ' AND created >= DATE(NOW()) - INTERVAL ' . esc_sql( $chart_timeframe ) . ' DAY GROUP BY DAY(created)';
			$recent_subscribers = $wpdb->get_results( $sql );
		}
		

		$now      = new \DateTime( "$chart_timeframe days ago", new \DateTimeZone( 'America/New_York' ) );
		$interval = new \DateInterval( 'P1D' ); // 1 Day interval
		$period   = new \DatePeriod( $now, $interval, $chart_timeframe ); // 7 Days

		$recent_subscribers_data = array(
			array( 'Year', 'Subscribers' ),
		);
		foreach ( $period as $day ) {
			$key         = $day->format( 'Y-m-d' );
			$display_key = $day->format( 'M j' );
			$no_val      = true;
			foreach ( $recent_subscribers as $v ) {
				if ( $key == $v->created ) {
					$recent_subscribers_data[] = array( $display_key, absint( $v->count ) );
					$no_val                    = false;
				}
			}
			if ( $no_val ) {
				$recent_subscribers_data[] = array( $display_key, 0 );
			}
		}

		$response = array(
			'recent_subscribers' => $recent_subscribers_data,
			'rows'               => $data,
			'lpage_name'         => '',
			'totalitems'         => $totalitems,
			'totalpages'         => ceil( $totalitems / $per_page ),
			'currentpage'        => $current_page,
			'views'              => $views,
		);

		wp_send_json( $response );
	}
}



function seedprod_pro_subscribers_get_data_total( $filter = null ) {
	global $wpdb;

	$tablename = $wpdb->prefix . 'csp3_subscribers';

	$sql = "SELECT count(id) FROM $tablename";

	if ( ! empty( $_GET['id'] ) ) {
		$sql .= ' WHERE page_uuid = ' . esc_sql( sanitize_text_field($_GET['id']) );
	} else {
		$sql .= ' WHERE 1 =1 ';
	}

	if ( ! empty( $_GET['s'] ) ) {
		$sql .= ' AND email LIKE "%' . esc_sql( trim( sanitize_text_field( $_GET['s'] ) ) ) . '%"';
	}

	$results = $wpdb->get_var( $sql );
	return $results;
}

function seedprod_pro_subscribers_get_views( $filter = null ) {
	$views   = array();
	$current = ( ! empty( $filter ) ? $filter : 'all' );

	global $wpdb;
	$tablename = $wpdb->prefix . 'csp3_subscribers';

	//All link
	$sql = "SELECT count(id) FROM $tablename";

	if ( ! empty( $_GET['id'] ) ) {
		$sql .= ' WHERE lpage_id = ' . esc_sql( sanitize_text_field($_GET['id'] ));
	} else {
		$sql .= ' WHERE 1 =1 ';
	}

	$results      = $wpdb->get_var( $sql );
	$class        = ( $current == 'all' ? ' class="current"' : '' );
	$all_url      = remove_query_arg( 'filter' );
	$views['all'] = $results;

	return $views;
}


/*
* Update Subscriber
*/
function seedprod_pro_update_subscriber_count() {
	if ( check_ajax_referer( 'seedprod_pro_update_subscriber_count' ) ) {
		update_option( 'seedprod_subscriber_count', 1 );
	}

}


/*
* Delete Subscribers
*/
function seedprod_pro_delete_subscribers() {
	if ( check_ajax_referer( 'seedprod_pro_delete_subscribers' ) ) {
		if ( current_user_can( apply_filters( 'seedprod_delete_subscriber_capability', 'list_users' ) ) ) {
			$dids = $_POST['items'];
			if ( is_array( $dids ) && ! empty( $dids ) ) {
				global $wpdb;
				$tablename = $wpdb->prefix . 'csp3_subscribers';
				$sql       = "SELECT id FROM $tablename";
				$sql      .= ' WHERE id IN ( ' . esc_sql( implode( ',', $dids ) ) . ' )';
				$ids       = $wpdb->get_col( $sql );

				$how_many     = count( $ids );
				$placeholders = array_fill( 0, $how_many, '%d' );
				$format       = implode( ', ', $placeholders );

				//Deleted subscribers
				$tablename = $wpdb->prefix . 'csp3_subscribers';
				$sql       = 'DELETE FROM ' . $tablename . " WHERE id IN ($format)";
				$safe_sql  = $wpdb->prepare( $sql, $ids );
				$result    = $wpdb->query( $safe_sql );
				wp_send_json_success();
			} elseif ( ! empty( $dids ) ) {
				// Deleted subscriber
				global $wpdb;
				$tablename = $wpdb->prefix . 'csp3_subscribers';
				$sql       = 'DELETE FROM ' . $tablename . ' WHERE id = %d';
				$safe_sql  = $wpdb->prepare( $sql, $dids );
				$result    = $wpdb->query( $safe_sql );
				wp_send_json_success();
			}

			wp_send_json_error();

		}
	}
}

/*
* Export Contestants
*/
function seedprod_pro_export_subscribers() {
        if (! empty($_REQUEST['action']) && $_REQUEST['action'] == 'seedprod_pro_export_subscribers' && current_user_can('export')) {
            if (! empty($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'seedprod_pro_export_subscribers') !== false) {
                $data = array();

                $filename = sprintf('%1$s-%2$s-%3$s', 'subscribers', date('Ymd'), date('His'));

                $header = array(
                'First Name',
                'Last Name',
                'Email',
                'Created',
                'Page ID',
            );

                seedprod_pro_set_time_limit();

                seedprod_pro_export_csv($header, $data, $filename);
            }
        }
}

function seedprod_pro_export_subscribers_entry( $args = array(), $count = false ){
	
	global $wpdb;
	if ( true === $count ) {
		if ( ! empty( $_REQUEST['id'] ) ) {
			$tablename = $wpdb->prefix . 'csp3_subscribers';
			$sql       = "SELECT COUNT(*) from $tablename where page_id = %d";
			$safe_sql  = $wpdb->prepare( $sql, absint( $_REQUEST['id'] ) );
			//$data      = $wpdb->get_results( $safe_sql );
		} else {
			$tablename = $wpdb->prefix . 'csp3_subscribers';
			$sql       = "SELECT  COUNT(*) from $tablename";
			$safe_sql  = $sql;
			//$data      = $wpdb->get_results( $safe_sql );
		}
		return absint( $wpdb->get_var(
			$safe_sql
		));
	}else{
		$offset = $args['offset'];
		$limit_number = $args['number'];
		
		if ( ! empty( $_REQUEST['id'] ) ) {
			$tablename = $wpdb->prefix . 'csp3_subscribers';
			$sql       = "SELECT fname, lname, email, created, page_uuid from $tablename where page_id = %d limit $offset , $limit_number";
			$safe_sql  = $wpdb->prepare( $sql, absint( $_REQUEST['id'] ) );
			$data      = $wpdb->get_results( $safe_sql );
		} else {
			$tablename = $wpdb->prefix . 'csp3_subscribers';
			$sql       = "SELECT fname, lname, email, created, page_uuid from $tablename  limit $offset , $limit_number";
			$data      = $wpdb->get_results( $sql );
		}
		
		return $data;

	}

	
}

function seedprod_pro_set_time_limit( $limit = 0 ) {

	if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.safe_modeDeprecatedRemoved
		@set_time_limit( $limit ); // @codingStandardsIgnoreLine
	}
}


function seedprod_pro_create_index_html_file( $path ) {

	if ( ! is_dir( $path ) || is_link( $path ) ) {
		return false;
	}

	$index_file = wp_normalize_path( trailingslashit( $path ) . 'index.html' );

	// Do nothing if index.html exists in the directory.
	if ( file_exists( $index_file ) ) {
		return false;
	}

	// Create empty index.html.
	return file_put_contents( $index_file, '' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
}


function seedprod_pro_get_tmpdir(){

	$upload_dir = wp_upload_dir();
	$export_path = trailingslashit( realpath( $upload_dir['basedir'] ) ) . 'seedprodexport';

	if ( ! file_exists( $export_path ) ) {
		wp_mkdir_p( $export_path );
	}
	seedprod_pro_create_index_html_file( $export_path );

	$export_path = wp_normalize_path( $export_path );
	return $export_path;
}

function seedprod_pro_get_tmpfname( $tmpname ){
	
	if ( empty( $tmpname ) ) {
		return '';
	}

	$export_dir  = seedprod_pro_get_tmpdir();
	$export_file = $export_dir . '/' . sanitize_key( $tmpname );
	touch( $export_file );

	return $export_file;

}

function seedprod_pro_export_csv( $header, $data, $filename ) {
	// No point in creating the export file on the file-system. We'll stream
	// it straight to the browser. Much nicer.

	$entries_per_step = 5000;
	$db_args = [
		'offset' => 0,
		'number' => $entries_per_step
	];
	$count = seedprod_pro_export_subscribers_entry($db_args,true);

	$request_data = [
		'db_args' => $db_args,
		'count' => $count,
		'total_steps' => ceil( $count / $entries_per_step ),
	];

	$tmpname = md5(strtotime("now"));
	$export_file_data = seedprod_pro_get_tmpfname( $tmpname );
	$export_file =  $export_file_data ;	
	if ( empty( $export_file ) ) {
		return;
	}

	
	$csv       = new SplFileObject( $export_file, 'a' );
	$enclosure = '"';
	$csv->fputcsv( $header,",",$enclosure);	
	
	if($count>0){
		for ( $i = 1; $i <= $request_data['total_steps']; $i ++ ) {

			$data = seedprod_pro_export_subscribers_entry($request_data['db_args'],false);
			foreach ( $data as $row ) {
				$arow = array();
				foreach ( $row as $k => $v ) {
					$arow[ $k ] = $v;
				}
				$csv->fputcsv( $arow,",",$enclosure);
			}
			$request_data['db_args']['offset'] = $i * $entries_per_step;
		}
	}

	clearstatcache( true, $export_file );
	$file_name = $filename.".csv";
	
	header( 'Content-Description: File Transfer' );
	header( 'Content-Type: text/csv' );
	header( 'Content-Disposition: attachment; filename=' . $file_name );
	header( 'Content-Transfer-Encoding: binary' );

	readfile( $export_file ); // phpcs:ignore
	
	exit;

}


function seedprod_pro_subscribe_callback() {
	// get request data

	$email = '';
	if ( ! empty( $_POST['email'] ) ) {
		$email = sanitize_email( $_POST['email'] );
	}

	if ( empty( $email ) ) {
		wp_send_json_error();
	}

	$page_uuid = '';
	if ( ! empty( $_POST['page_uuid'] ) ) {
		$page_uuid = sanitize_text_field( $_POST['page_uuid'] );
	}

	$page_id = '';
	if ( ! empty( $_POST['page_id'] ) ) {
		$page_id = absint( $_POST['page_id'] );
	}

	$name = '';
	if ( ! empty( $_REQUEST['name'] ) ) {
		$name = sanitize_text_field( $_REQUEST['name'] );
	}

	$fname = '';
	$lname = '';

	if ( ! empty( $name ) ) {
		require_once SEEDPROD_PRO_PLUGIN_PATH . 'app/includes/nameparse.php';
		$name  = seedprod_pro_parse_name( $name );
		$fname = $name['first'];
		$lname = $name['last'];
	}

	$optin_confirmation = 0;
	if ( ! empty( $_REQUEST['optin_confirmation'] ) ) {
		$optin_confirmation = 1;
	}

	// Record user in DB if they do not exist
	global $wpdb;
	$tablename     = $wpdb->prefix . 'csp3_subscribers';
	$sql           = "SELECT * FROM $tablename WHERE email = %s AND page_uuid = %d";
	$safe_sql      = $wpdb->prepare( $sql, $email, $page_uuid );
	$select_result = $wpdb->get_row( $safe_sql );

	if ( empty( $select_result->email ) ) {
		$values        = array(
			'email'         => $email,
			'page_id'       => $page_id,
			'page_uuid'     => $page_uuid,
			'ip'            => seedprod_pro_get_ip(),
			'fname'         => $fname,
			'lname'         => $lname,
			'optin_confirm' => $optin_confirmation,
		);
		$format_values = array(
			'%s',
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%d',
		);
		$insert_result = $wpdb->insert(
			$tablename,
			$values,
			$format_values
		);
	}

	wp_send_json_success();
}




