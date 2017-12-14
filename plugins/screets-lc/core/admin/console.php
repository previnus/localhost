<?php
/**
 * SCREETS © 2017
 *
 * SCREETS, d.o.o. Sarajevo. All rights reserved.
 * This  is  commercial  software,  only  users  who have purchased a valid
 * license  and  accept  to the terms of the  License Agreement can install
 * and use this program.
 *
 * @package LiveChatX
 * @author Screets
 *
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Console class.
 */
class SChat_Console {

    /**
     * Constructor.
     */
    function __construct() {

        // Include WP media JS libraries
        wp_enqueue_media();

        // Icons
        wp_register_style(
            'schat-icons',
            SLC_URL . '/assets/css/schat.icons.css',
            array(),
            SLC_VERSION
        );
        wp_enqueue_style( 'schat-icons' );

        // Console styles
        wp_register_style(
            'schat-console',
            SLC_URL . '/assets/css/schat.console.css',
            null,
            SLC_VERSION
        );
        wp_enqueue_style( 'schat-console' );

        // Firebase JS
        wp_register_script(
            'firebase',
            'https://www.gstatic.com/firebasejs/' . SLC_FIREBASE_VERSION . '/firebase.js',
            null, SLC_FIREBASE_VERSION, true
        );
        wp_enqueue_script( 'firebase' );

        wp_register_script(
            'schat-firebase',
            SLC_URL . '/assets/js/schat.firebase.js',
            array( 'firebase' ),
            SLC_VERSION,
            true
        );
        wp_enqueue_script( 'schat-firebase' );

        // Application JS
        wp_register_script(
            'schat-app',
            SLC_URL . '/assets/js/schat.app.js',
            array( 'firebase', 'schat-firebase' ),
            SLC_VERSION,
            true
        );
        wp_enqueue_script( 'schat-app' );

        // Console user interface JS
        wp_register_script(
            'schat-console-ui',
            SLC_URL . '/assets/js/schat.console.ui.js',
            array( 'schat-firebase', 'firebase' ),
            SLC_VERSION,
            true
        );
        wp_enqueue_script( 'schat-console-ui' );

    }

    static function render_console() {
        global $SChat;

        require SLC_PATH . '/core/templates/console.php';

        // Get current user data
        $user = fn_schat_get_user_data_by_array();

        // Get user agent data
        $agent = fn_schat_get_agent();

        // Default console application options
        $opts = apply_filters( 'schat_console_js_opts', array(
            'db' => fn_schat_get_realtime_config( 'firebase', true ),
            'max_msgs' => 70, // Total number of chat messages to load per chat
            'user' => array(
                'name' => $user['name'],
                'avatar' => $user['avatar'],
                'email' => $user['email'],
                'platform' => array(
                    'user_agent'=> $agent['user_agent'],
                    'browser'=> $agent['browser'],
                    'browser_version'=> $agent['browser_version'],
                    'os'=> $agent['os'],
                    'ip'=> fn_schat_ip_addr()
                )
            ),
            'user_pass' => md5( $user['email'] ),

            'pushover' => array(
                'active' => $SChat->opts->getOption('pushover-active'),
                'token' => $SChat->opts->getOption('pushover-api-token'),
                'user_key' => $SChat->opts->getOption('pushover-user-key')
            ),

            'site_name'=> $SChat->opts->getOption('site-name'),
            'ip'=> fn_schat_ip_addr(),

            'is_home' => false,
            'plugin_url' => SLC_URL,
            'ajax_url' => $SChat->ajax_url(),
            'console_url' => admin_url( 'admin.php?page=schat_console' ),
            'opts_url' => admin_url( 'admin.php?page=schat_console-options' ),

            'is_ssl' => ( is_ssl() ) ? true : false,

            '_online' => __( 'Online', 'schat' ),
            '_offline' => __( 'Offline', 'schat' ),
            '_saved' => __( 'Saved', 'schat' ),
            '_wait' => __( 'Please wait', 'schat' ),
            '_conn_success' => __( 'Connected', 'schat' ),
            '_active' => __( 'Active', 'schat' ),
            '_you' => __( 'You', 'schat' ),
            '_op' => __( 'Operator', 'schat' ),
            '_web_visitor' => __( 'Web visitor', 'schat' ),
            '_in_chat' => __( 'In chat', 'schat' ),
            '_join_chat' => __( 'Join chat', 'schat' ),
            '_leave_chat' => __( 'Leave chat', 'schat' ),
            '_end_chat' => __( 'End chat', 'schat' ),
            '_in_chat' => __( 'In chat', 'schat' ),
            '_ignore' => __( 'Ignore', 'schat' ),
            '_transfer' => __( 'Transfer', 'schat' ),
            '_del' => __( 'Delete', 'schat' ),
            '_look_at' => __( 'Looking at', 'schat' ),
            '_open' => __( 'Open', 'schat' ),
            '_close' => __( 'Close', 'schat' ),
            '_popup' => __( 'Popup', 'schat' ),
            '_mode' => __( 'Mode', 'schat' ),
            '_feedback' => __( 'Feedback', 'schat' ),
            '_like' => $SChat->opts->getOption( 'poschat-feedback-like' ),
            '_dislike' => $SChat->opts->getOption( 'poschat-feedback-dislike' ),
            '_chat_history' => __( 'Chat history', 'schat' ),
            '_no_conn' => __( 'No internet connection', 'schat' ),
            '_remove_usr' => __( 'Remove user', 'schat' ),
            '_ask_del' => __( "Are you sure you want to PERMANENTLY delete it?", 'schat' ),
            '_sure_end' => __( "Visitor won't be able to reply. Do you really want to end chat?", 'schat' ),
            '_reply_ph' => __( 'Your message', 'schat' ),
            '_invalid_conf' => sprintf( __( 'Your Firebase isn\'t configured correctly! <a href="%s">Go settings &raquo;</a>', 'schat' ), admin_url( 'admin.php?page=schat_console-options&tab=real-time' ) ),
            '_user_joined_chat' => __( '%s has joined the chat', 'schat' ),
            '_user_typing' => __( '%s is typing', 'schat' ),
            '_user_left_chat' => __( '%s has left the chat', 'schat' ),
            '_ask_end_chat' => __( 'Are you sure you want to end this chat?', 'schat' ),
            '_ask_leave_chat' => __( 'Are you sure you want to leave chat?', 'schat' ),
            '_ask_page_exit' => __( 'Are you sure you want to exit? You will be OFFLINE', 'schat' ),
            '_ntf_in_chat_already' => __( 'This visitor is talking with <strong>%s</strong>', 'schat' ),
            '_ntf_reset' => __( 'You will re-connect the chat!', 'schat' ),
            '_ntf_start_chat' => __( 'Send a message to initiate chat', 'schat' ),
            '_ntf_wait_reply' => __( '%s is waiting for a reply', 'schat' ),
            '_ntf_new_visitor' => __( '%s is online', 'schat' ),
            '_ntf_dn_active' => sprintf( __( '%s desktop notifications activated :) Good luck with sales', 'schat' ), SLC_NAME ),
            
            // Time strings
            '_time' => array(
                'prefix' => '',
                'suffix' => '',
                'seconds' => '',
                'minute' => __( '1m', 'schat' ),
                'minutes' => __( '%dm', 'schat' ),
                'hour' => __( '1h', 'schat' ),
                'hours' => __( '%dh', 'schat' ),
                'day' => __( '1d', 'schat' ),
                'days' => __( '%dd', 'schat' ),
                'month' => __( '1m', 'schat' ),
                'months' => __( '%dm', 'schat' ),
                'year' => __( '1y', 'schat' ),
                'years' => __( '%dy', 'schat' )
            )
        ));

        ?>

        <script type="text/javascript">

            document.addEventListener( 'DOMContentLoaded', function() {

                var schat = new SLC_UI( <?php echo json_encode( $opts ); ?> );

            }, false );

        </script>

        <?php



    }

}

new SChat_Console();