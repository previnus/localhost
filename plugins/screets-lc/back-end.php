<?php
/**
 * SCREETS © 2016
 *
 * Initialization the plug-in for back-end
 *
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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Admin class.
*
* @since Live Chat X (3.0.0)
*
*/
class SChatBackend {

	/**
	* Constructor.
	*/
	public function __construct() {
		add_action( 'current_screen', array( $this, 'conditional_includes' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 20, 0 );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		// Disable WP emoji
		add_action( 'init', array( $this, 'disable_emoji' ) );

	}

	public function admin_init() {

		// Get current page
    	$current_page = ( !empty( $_GET['page'] ) ) ? $_GET['page'] : null;

		// Add extra profile fields to operator users
	    if( defined( 'SLC_OP' ) ) {
	        add_action( 'show_user_profile', array( $this, 'op_profile' ), 10 );
	        add_action( 'edit_user_profile', array( $this, 'op_profile' ), 10 );
	        add_action( 'personal_options_update', array( $this, 'save_op_profile' ) );
	        add_action( 'edit_user_profile_update', array( $this, 'save_op_profile' ) );
	    }

	    if( $current_page == 'schat_console-options' ) {

	        // Add editor stylesheet
	        add_editor_style( SLC_URL . '/assets/css/schat.editor-style.css' );

	    }
	}

	/**
	 * Include admin files conditionally.
	 */
	public function conditional_includes() {
		if ( ! $screen = get_current_screen() ) { return; }

		global $SChat;

		switch ( $screen->id ) {
			case 'toplevel_page_schat_console':
			case 'live-chat_page_admin?page=schat_console':
				include SLC_PATH . '/core/admin/console.php';
				break;

			case 'schat_offline_msg':
		    	include SLC_PATH . '/core/offline-msgs.php';
		    	break;

			case 'live-chat_page_schat_console-options':
				
				// Firebase JS
		        wp_register_script(
		            'firebase',
		            'https://www.gstatic.com/firebasejs/' . SLC_FIREBASE_VERSION . '/firebase.js',
		            null, SLC_FIREBASE_VERSION, true
		        );
		        wp_enqueue_script( 'firebase' );

				// Admin JS
	            wp_register_script(
	                'schat-admin-opts',
	                SLC_URL . '/assets/js/schat.admin.opts.js',
	                array('firebase'),
	                SLC_VERSION,
	                true
	            );
	            wp_enqueue_script( 'schat-admin-opts' );

	            // Icons
	            wp_register_style(
	                'schat-icons',
	                SLC_URL . '/assets/css/schat.icons.css',
	                array(),
	                SLC_VERSION
	            );
	            wp_enqueue_style( 'schat-icons' );

	            // Admin styles
	            wp_register_style(
	                'schat-admin-opts',
	                SLC_URL . '/assets/css/schat.admin.opts.css',
	                null,
	                SLC_VERSION
	            );
	            wp_enqueue_style( 'schat-admin-opts' );

	            // Get admin options
	            $admin_opts = $opts = array(
	                'app-key' => $SChat->opts->getOption('app-key'),
	                'app-project-id' => $SChat->opts->getOption('app-project-id'),
	                'app-private-key' => $SChat->opts->getOption('app-private-key'),
	                'site-name' => $SChat->opts->getOption('site-name'),
	                'site-url' => $SChat->opts->getOption('site-url'),
	                'site-email' => $SChat->opts->getOption('site-email'),
	                'site-reply-to' => $SChat->opts->getOption('site-reply-to'),
	                'guest-prefix' => schat__( 'guest-prefix')
	            );
	            
	            // Localize global data
	            wp_localize_script( 'schat-admin-opts', 'schat_admin_opts', $admin_opts );

	            if( !defined( 'DOING_AJAX' ) ) {
                
	                $license = get_option( 'screets-lcx-license' );
	                $license_err = get_option( 'screets-lcx-license-error' );
	                $license_name_suffix = ( !empty( $license['warning'] ) ) ? '(No Support)' : '';

	                if( !empty( $license_err ) ) {
	                    ?>
	                    <script>
	                        document.addEventListener( "DOMContentLoaded", function(e) {
	                            jQuery('#screets-lc_api-key').addClass('schat-error');
	                            jQuery('#screets-lc_api-key').after( ' <div class="schat-license-error"><?php echo $license_err['error']; ?></div>' );
	                        });
	                    </script>
	                    <?php       
	                } else {
	                    ?>
	                    <script>
	                        /*document.addEventListener( "DOMContentLoaded", function(e) {
	                            jQuery('#schat-get-api').css('display', 'none' );
	                            jQuery('#screets-lc_api-key').addClass('schat-success');
	                            
	                            <?php if( !empty( $license['warning'] ) ): ?>
	                                jQuery('#screets-lc_api-key').after( ' <div class="schat-license-warning">(!) <?php echo str_replace( "\n", '', $license['warning']['msg'] ); ?></div>' );
	                            <?php endif; ?>

	                            jQuery('#screets-lc_api-key').after( ' <div class="schat-license-info"><span class="schat-license-name"><?php echo ucfirst( $license['product']['defaultLicense'] ); ?> version <span style="font-weight:normal;"><?php echo $license_name_suffix; ?></span> <a href="http://support.screets.org" class="button button-small" target="_blank" style="font-size: 12px;font-weight: normal;padding: 0 8px;line-height: 18px;height: 20px;margin-left: 5px;">Edit</a></span> <span class="schat-license-notes"><?php echo str_replace( "\n", '', $license['product']['notes'] ); ?></span></div>' );

	                            
	                        });*/
	                    </script>
	                    <?php
	                }
	            }

	            break;
		}

	}

	/**
	 * Show admin notifications.
	 */
	function admin_notices() {
		if ( ! $screen = get_current_screen() ) { return; }

		switch ( $screen->id ) {
			case '':
				break;
		}
	}

	/**
	 * Setup admin menu.
	 */
	function admin_menu() {

		add_menu_page(
	        SLC_NAME_SHORT,
	        SLC_NAME_SHORT,
	        'schat_answer_visitor',
	        'schat_console', // menu slug
	        array( 'SChat_Console', 'render_console' ), // callback
	        'dashicons-format-chat',
	        '26.2985'
	    );
	    remove_submenu_page( 'schat_console', 'admin.php?page=schat_console' );

	    add_submenu_page(
	        'schat_console',
	        __( 'Chat Console', 'lcx' ),
	        __( 'Chat Console', 'lcx' ),
	        'schat_answer_visitor',
	        'admin.php?page=schat_console',
	        array( 'SChat_Console', 'render_console' ) // callback
	    );

	    add_submenu_page(
	        'schat_console',
	        __( 'Offline Messages', 'schat' ),
	        __( 'Offline Messages', 'schat' ),
	        'schat_answer_visitor',
	        'edit.php?post_type=schat_offline_msg'
	    );

	    // Support
	    add_submenu_page(
	        'schat_console',
	        __( 'Support', 'schat' ),
	        __( 'Support', 'schat' ),
	        'schat_answer_visitor',
	        'admin.php?page=schat_console-options&tab=support'
	    );

		// Offline messages
		remove_submenu_page( 'schat_console', 'edit.php?post_type=schat_offline_msg' );
		/*add_submenu_page(
			'livechatx',
			__( 'Offline Messages', 'lcx' ),
			__( 'Offline Messages', 'lcx' ),
			'lcx_admin',
			'edit.php?post_type=lcx_offline_msg'
		);*/

	}


	/**
	 * Render extensions page.
	 */
	function render_extensions() {
		include SLC_PATH . '/core/templates/admin/extensions.php';
	}

	/**
	 * Render support page.
	 */
	function render_support() { ?>
		<iframe src="//support.screets.io/?product=<?php echo SLC_SLUG; ?>&amp;v=<?php echo SLC_VERSION; ?>" frameborder="0" style="width: calc(100% - 20px); height: calc(100vh - 32px);"></iframe>

		<style>
			#wpfooter { display: none; }
		</style>
	<?php }

	/**
	 * Render the main plugin page.
	 */
	function disable_emoji() {

		// Disable emoji support on "Chat Console"
		if( !empty( $_GET['page'] ) ) {	
			if( $_GET['page'] == 'admin.php?page=livechatx' ) {
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );	
				remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
				remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
				remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			}
		}

	}

	/**
	 * Add extra fields to operator user profile page
	 *
	 * @since Live Chat (2.0)
	 * @return void
	 */
	function op_profile( $user ) {?>

	        <a id="SLC-op-options"></a>
	        <hr style="margin-bottom:30px;">

	        <img src="<?php echo SLC_URL; ?>/assets/img/cx-badge.png" style="float:left; max-width:80px; margin-right:15px;">
	        <h3 style="margin-top:5px; margin-bottom:10px;"><?php _e( 'Operator Options', 'schat' ); ?></h3>
	        <span class="description" style="color: #e54045;"><?php _e( 'Click <strong>Restart</strong> button in Chat Console > Settings after updating operator information', 'schat' ); ?></span>

	        <table class="form-table">

	            <!-- Operator Name -->
	            <tr>
	                <th><?php _e( 'Operator Name', 'schat' ); ?></th>
	                <td>
	                    <input type="text" name="cx_op_name" id="f_chat_op_name" value="<?php echo esc_attr( get_the_author_meta( 'cx_op_name', $user->ID ) ); ?>" class="regular-text" />
	                    <br>
	                </td>
	            </tr>

	        </table>

	        <hr>


	    <?php }


	/**
	 * Save extra fields of operator users
	 *
	 * @since Live Chat (2.0)
	 * @return void
	 */
	function save_op_profile( $user_id ) {

	    if ( !current_user_can( 'edit_user', $user_id ) )
	        return false;

	    // Op name isn't defined yet, create new one for user
	    if( empty( $_POST['cx_op_name'] ) ) {

	        $current_user = wp_get_current_user();

	        $op_name = $current_user->display_name;


	    // OP name
	    } else
	        $op_name = $_POST['cx_op_name'];


	    // Update user meta now
	    update_user_meta( $user_id, 'cx_op_name', $op_name );
	}

}

return new SChatBackend();