<?php
/**
 * SCREETS © 2016
 *
 * Plugin Options
 *
 * COPYRIGHT © 2016 Screets d.o.o. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 *
 * @package Live Chat
 * @author Screets
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;


require SLC_PATH . '/core/metaboxes.php';
require SLC_PATH . '/core/options.php';

/**
 * Plugin options (Hook Titan Framework)
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_hook_options() {

	global $SChat;

	// Framework
	$fw = TitanFramework::getInstance( SLC_SLUG );

	// Get all custom post types (public ones)
	$post_types = get_post_types( array( '_builtin' => false, 'public' => true ) );

	// Add default post types
	array_push( $post_types, 'post', 'page' );

	//
	// Metaboxes
	//
	/*$meta_posts = $fw->createMetaBox( array(
		'name' => SLC_NAME,
		'post_type' => $post_types
	));*/

	$meta_topics = $fw->createMetaBox( array(
		'name' => SLC_NAME,
		'post_type' => 'schat_support_cat'
	));

	// Get post metaboxes
	foreach( fn_schat_get_metaboxes( 'post' ) as $m ) {
		$meta_posts->createOption( $m );
	}

	foreach( fn_schat_get_metaboxes( 'topic' ) as $m ) {
		$meta_topics->createOption( $m );
	}

	// Get edition
	$license_info = get_option( 'screets-lcx-license' );

	$default_license = ucfirst( $license_info['product']['defaultLicense'] );

	if( empty( $license_info ) ) {
		$license_info = '<em style="color: #fc5151;">Unlicensed</em>';
	} else {
		$license_info = "<span style=\"color: #48a225;\">{$default_license} version</span>";
	}

	$license_info = '';

	//
	// Options page
	//
	$opts = $fw->createAdminPanel( array(
		'name' => 'Options',
		'title' => '<img src="' . SLC_URL . '/assets/img/lcx-logo.png" class="schat-logo" style="float:left; max-width:45px; margin-right:15px; margin-top:5px; ">' . sprintf( __( '%s Options', 'schat' ), 'Screets Live Chat' ),
		'desc' => '<span>' . SLC_EDITION . '</span> - <strong style="font-style:normal;">' . $license_info . '</strong> <span class="schat-highlight" style="margin:0 5px;">Version ' . SLC_VERSION . '</span>   &nbsp;&dash;&nbsp; <a href="https://screets.com/chat/night-bird/" target="_blank">Plugin page</a> <span class="schat-ico-new-win" style="color:#ccc;"></span>',
		'parent' => 'schat_console',
		'capability' => 'schat_manage_chat_options',
		'position' => 100
	));

	$current_theme = wp_get_theme();

	// Create option tabs
	$tab_general = $opts->createTab( array( 'name'	=> __( 'General', 'schat' ) ));
	$tab_site_info = $opts->createTab( array( 'name'	=> __( 'Site info', 'schat' ) ));
	$tab_design = $opts->createTab( array( 'name'	=> __( 'Design', 'schat' ) ));
	$tab_popups = $opts->createTab( array( 'name'	=> __( 'Popups', 'schat' ) ));
	// $tab_templates = $opts->createTab( array( 'name'	=> __( 'Templates', 'schat' ) ));
	$tab_users = $opts->createTab( array( 'name'	=> __( 'Users', 'schat' ) ));
	$tab_integrations = $opts->createTab( array( 'name'	=> __( 'Real-time', 'schat' ) ));
	$tab_advanced = $opts->createTab( array( 'name'	=> __( 'Advanced', 'schat' ) ));
	$tab_support = $opts->createTab( array(
		'name'	=> __( 'Support', 'schat' ),
		'desc' => '<iframe frameborder="0" src="https://support.screets.io?p=' . SLC_SLUG . '&amp;v='. SLC_VERSION . '&amp;domain=' . fn_schat_current_domain() . '&amp;wp='. get_bloginfo( 'version' ) .
 '&php=' . phpversion() . ' &theme=' . $current_theme->Name . '&themev='. $current_theme->Version . '" style="height: 100vh; width:100%;"></iframe>'
	));

	// Get admin options
	foreach( fn_schat_get_opts() as $k => $opt_list ) {
		foreach( $opt_list as $opt) {
			switch( $k ) {
				case 'general':
					$tab_general->createOption( $opt ); break;

				case 'site-info':
					$tab_site_info->createOption( $opt ); break;

				case 'design':
					$tab_design->createOption( $opt ); break;

				case 'popups':
					$tab_popups->createOption( $opt ); break;

				/*case 'templates':
					$tab_templates->createOption( $opt ); break;*/

				case 'users':
					$tab_users->createOption( $opt ); break;

				case 'integrations':
					$tab_integrations->createOption( $opt ); break;

				case 'advanced':
					$tab_advanced->createOption( $opt ); break;

				case 'support':
					$tab_support->createOption( $opt ); break;

			}

			// Translatable options
			if( !empty( $opt['translate'] ) ) {
				$multiline = ( $opt['type'] == 'textarea' ) ? true : false; // Translation text field is multiline?
				$name = ( !empty( $opt['name'] ) ) ? $opt['name'] : $opt['default'];


				$SChat->__opts[$opt['id']] = array(
					'name' => $name,
					'multiline' => $multiline 
				);

			}
			
		}
	}

	// Save button
	$opts->createOption( array( 'type' => 'save' ) );
}


/**
 * Save admin options (Hook Titan Framework)
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_hook_options_saved() {

	// Update operator capabilities
	fn_schat_update_op_caps();

	$url = parse_url( $_POST['_wp_http_referer'] );
	parse_str( $url['query'], $query );

	if( $query['tab'] == 'general' ) {

		$r = array();

		// Check license
		/*$response = fn_schat_curl_get( 'http://api.screets.org/v2/', array(
			'action' => 'validate',
			'api' => $_POST['screets-lc_api-key'],
			'domain' => fn_schat_current_domain()
		));
		$response = json_decode( $response, true );

		if( !empty( $response['error'] ) ) {
			delete_option( 'screets-lcx-license' );
			update_option( 'screets-lcx-license-error', $response );
		} else {
			delete_option( 'screets-lcx-license-error' );
			update_option( 'screets-lcx-license', $response );
		}*/
	}
}

// Hook Titan Framework
add_action( 'tf_create_options', 'fn_schat_hook_options' );
add_action( 'tf_admin_options_saved_' . SLC_SLUG, 'fn_schat_hook_options_saved' );