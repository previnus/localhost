<?
/**
 * Back-end initialization
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_admin_init() {
    
    global $SChat;

    // Get current page
    $current_page = ( !empty( $_GET['page'] ) ) ? $_GET['page'] : null;

    // Load back-end styles and scripts
    add_action( 'admin_enqueue_scripts', 'fn_schat_backend_scripts', 10 );

    add_action( 'current_screen', 'fn_schat_conditional_includes' );

    // Add extra profile fields to operator users
    if( defined( 'SLC_OP' ) ) {
        add_action( 'show_user_profile', 'fn_schat_op_profile', 10 );
        add_action( 'edit_user_profile', 'fn_schat_op_profile', 10 );
        add_action( 'personal_options_update', 'fn_schat_save_op_profile' );
        add_action( 'edit_user_profile_update', 'fn_schat_save_op_profile' );
    }

    if( $current_page == 'schat_console-options' ) {

        // Add editor stylesheet
        add_editor_style( SLC_URL . '/assets/css/schat.editor-style.css' );

    }

}
add_action( 'admin_init', 'fn_schat_admin_init', 10 );



function fn_schat_conditional_includes() {
    if ( ! $screen = get_current_screen() ) { return; }

    if( $screen->id == 'schat_offline_msg' ) {
        include SLC_PATH . '/core/offline-msgs.php';
    }
}

/**
 * Register translatable strings.
 */
function fn_schat_register_strings() {
    global $SChat;

    $opts = TitanFramework::getInstance( SLC_SLUG );

    // Register strings to Polylang
    if( function_exists( 'pll_register_string' ) ) {
        foreach( $SChat->__opts as $id => $opt ) {
            $string = $opts->getOption( $id );
            pll_register_string( $opt['name'], $string, SLC_NAME, $opt['multiline'] );
        }
    }

    // Register strings to WPML 3.2+
    if( has_action( 'wpml_register_single_string' ) ) {
        foreach( $SChat->__opts as $id => $opt ) {
            $string = $opts->getOption( $id );
            do_action( 'wpml_register_single_string', SLC_NAME, $id, $string );
        }
    }
}
add_action( 'tf_done', 'fn_schat_register_strings', 20 );

/**
 * Back-end styles and scripts
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_backend_scripts( $hook ) {

    global $is_IE, $SChat;

    $taxonomy = !( empty( $_GET['taxonomy'] ) ) ? $_GET['taxonomy'] : null;

    if ( ! $screen = get_current_screen() ) { return; }

    // Admin styles (common)
    wp_register_style(
        'schat-admin',
        SLC_URL . '/assets/css/schat.admin.css'
    );
    wp_enqueue_style( 'schat-admin' );

    // Icons
    wp_register_style(
        'schat-icons',
        SLC_URL . '/assets/css/schat.icons.css',
        array(),
        SLC_VERSION
    );
    wp_enqueue_style( 'schat-icons' );

    // Offline messages
    if( $screen->id == 'edit-schat_offline_msg' || $screen->id == 'schat_offline_msg' ) {
        echo '<style> .page-title-action { display: none; } </style>';
    }

    switch( $hook ) {

        // 
        // Chat console scripts
        //
        case 'toplevel_page_schat_console':

            // Load common scripts
            $SChat->common_scripts();

            // Get console dependencies
            $console_dependecies = array( 'twemoji', 'firebase', 'schat-firebase' );

            if( !empty( $gm_api ) ) {
                $console_dependecies[] = 'google-maps';
            }

            // Console styles
            wp_register_style(
                'schat-console',
                SLC_URL . '/assets/css/schat.console.css',
                null,
                SLC_VERSION
            );
            wp_enqueue_style( 'schat-console' );

            // Moment JS
            wp_register_script(
                'moment',
                SLC_URL . '/assets/js/moment.js',
                array( 'jquery' ),
                SLC_VERSION,
                true
            );
            wp_enqueue_script( 'moment' );

            // Livestamp JS
            wp_register_script(
                'livestamp',
                SLC_URL . '/assets/js/livestamp.js',
                array( 'moment' ),
                SLC_VERSION,
                true
            );
            wp_enqueue_script( 'livestamp' );

            // Application JS
            wp_register_script(
                'schat-app',
                SLC_URL . '/assets/js/schat.app.js',
                array( 'twemoji', 'firebase', 'schat-firebase', 'livestamp' ),
                SLC_VERSION,
                true
            );
            wp_enqueue_script( 'schat-app' );

            // Console user interface JS
            wp_register_script(
                'schat-console-ui',
                SLC_URL . '/assets/js/schat.console.ui.js',
                array( 'schat-polyfill', 'schat-firebase', 'firebase' ),
                SLC_VERSION,
                true
            );
            wp_enqueue_script( 'schat-console-ui' );

            break;

        //
        // Options, widgets and customize pages
        //
        case 'live-chat_page_schat_console-options':
        case 'widgets.php';

            // Firebase JS
            wp_register_script(
                'firebase',
                SLC_URL . '/assets/js/firebase.min.js',
                null,
                SLC_FIREBASE_VERSION,
                true
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
                        document.addEventListener( "DOMContentLoaded", function(e) {
                            jQuery('#schat-get-api').css('display', 'none' );
                            jQuery('#screets-lc_api-key').addClass('schat-success');
                            
                            <?php if( !empty( $license['warning'] ) ): ?>
                                jQuery('#screets-lc_api-key').after( ' <div class="schat-license-warning">(!) <?php echo str_replace( "\n", '', $license['warning']['msg'] ); ?></div>' );
                            <?php endif; ?>

                            jQuery('#screets-lc_api-key').after( ' <div class="schat-license-info"><span class="schat-license-name"><?php echo ucfirst( $license['product']['defaultLicense'] ); ?> version <span style="font-weight:normal;"><?php echo $license_name_suffix; ?></span> <a href="http://support.screets.org" class="button button-small" target="_blank" style="font-size: 12px;font-weight: normal;padding: 0 8px;line-height: 18px;height: 20px;margin-left: 5px;">Edit</a></span> <span class="schat-license-notes"><?php echo str_replace( "\n", '', $license['product']['notes'] ); ?></span></div>' );

                            
                        });
                    </script>
                    <?php
                }
            }

            break;

    }

    //
    // The plugin some custom post types and options page styles
    //
    if( 
        $hook == 'user-new.php' ||
        $hook == 'live-chat_page_schat_console-options' ||
        ( $hook == 'edit-tags.php' && $taxonomy == 'schat_support_cat' ) 
    ) {

        // schat-admin.js custom data
        $admin_js_vars = array(
            'ajax_url'          => $SChat->ajax_url(),
            'plugin_url'        => SLC_URL,
            'op_caps'           => fn_schat_get_op_cap_names(),
            'user_role'         => !empty( $_GET['role'] ) ? $_GET['role'] : ''
        );

        // Admin JS
        wp_register_script(
            'schat-admin',
            SLC_URL . '/assets/js/schat.admin.js',
            array( 'jquery' ),
            SLC_VERSION,
            true
        );
        wp_enqueue_script( 'schat-admin' );

        wp_localize_script( 'schat-admin', 'schat', $admin_js_vars );

    }

}

/**
 * Admin menus
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_admin_menu() {

    /*// Live Chat menu
    add_menu_page(
        '', // Page title
        SLC_NAME_SHORT, // Menu title
        'schat_answer_visitor',
        'schat_console',
        'fn_schat_console_ui',
        SLC_URL . '/assets/img/admin-menu-ico.png',
        '25.19865'
    );

    // Console
    $console_page = add_submenu_page(
        'schat_console',
        __( 'Chat Console', 'schat' ),
        __( 'Chat Console', 'schat' ),
        'schat_answer_visitor',
        'schat_console'
    );
    add_action( 'admin_footer-'. $console_page, 'fn_schat_console_footer' );*/

    add_menu_page(
        SLC_NAME_SHORT,
        SLC_NAME_SHORT,
        'schat_answer_visitor',
        'schat_console', // menu slug
        'fn_schat_console_footer', // callback
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
        'fn_schat_console_footer' // callback
    );

    add_submenu_page(
        'schat_console',
        __( 'Offline Messages', 'schat' ),
        __( 'Offline Messages', 'schat' ),
        'schat_answer_visitor',
        'edit.php?post_type=schat_offline_msg'
    );

    // Support Categories
    /*add_submenu_page(
        'schat_console',
        __( 'Support Categories', 'schat' ),
        __( 'Support Categories', 'schat' ),
        'schat_manage_chat_options',
        'edit-tags.php?taxonomy=schat_support_cat'
    );

    // Support Topics
    add_submenu_page(
        'schat_console',
        __( 'Support Topics', 'schat' ),
        __( 'Support Topics', 'schat' ),
        'manage_options',
        'edit.php?post_type=schat_topic'
    );*/

    // Customize
    /*add_submenu_page(
        'schat_console',
        __( 'Customize', 'schat' ),
        __( 'Customize', 'schat' ),
        'schat_manage_chat_options',
        'customize.php?return=admin.php?page=schat_console-options'
    );*/

    // Support
    add_submenu_page(
        'schat_console',
        __( 'Support', 'schat' ),
        __( 'Support', 'schat' ),
        'schat_answer_visitor',
        'admin.php?page=schat_console-options&tab=support'
    );

    // Remove "All items" link from the menu
    remove_submenu_page( 'schat_console', 'edit.php?post_type=schat_offline_msg' );
    
    
}

add_action( 'admin_menu', 'fn_schat_admin_menu' );

/**
 * Add extra fields to operator user profile page
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_op_profile( $user ) {?>

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
function fn_schat_save_op_profile( $user_id ) {

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


/**
 * Console page JS
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_console_footer() {

    global $SChat;

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


/**
 * Chat console user interface
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_console_ui() {
    require SLC_PATH . '/core/templates/console.php';
}


/**
 * Add extra fields to support categories (insert mode)
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_xtra_support_cat_fields() { ?>

    <input type="hidden" name="cx_xtra_support_cat[featured_img]" id="CX_field_featured_img" value="">

    <div class="form-field cx-cat-img-wrap">
        <label for="cx_xtra_support_cat[featured_img]"><?php _e( 'Category image', 'schat' ); ?></label>
        <p><a href="javascript:;" class="button cx-media-uploader" data-id="featured_img"><?php _e( 'Set featured image', 'schat' ); ?></a></p>
        <div id="CX_media_featured_img" class="cx-media-wrap hidden">
            <img src="" alt="" title="" />
        </div>
        <p><a href="javascript:;" class="cx-media-remove hidden" id="CX_remove_featured_img" data-id="featured_img"><?php _e( 'Remove image', 'schat' ); ?></a></p>
    </div>
<?php }

add_action( 'schat_support_cat_add_form_fields', 'fn_schat_xtra_support_cat_fields', 10, 2 );

/**
 * Add extra fields to support categories (edit mode)
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_edit_xtra_support_cat_fields( $term ) {

    // Put the term ID into a variable
    $term_id = $term->term_id;

    // Retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$term_id" );


    // Get featured image
    $featured_img_id = ( !empty( $term_meta['featured_img'] ) ) ? esc_attr( $term_meta['featured_img'] ) : ''; 
    $featured_img_url = wp_get_attachment_url( $featured_img_id );

    // Hide featured image
    $hide_featured_img = ( empty( $featured_img_url ) ) ? 'hidden' : '';

    ?>
    
    <input type="hidden" name="cx_xtra_support_cat[featured_img]" id="CX_field_featured_img" value="<?php echo $featured_img_id; ?>">

    <tr class="form-field cx-cat-img-wrap">
        <th scope="row" valign="top">
            <label for="cx_xtra_support_cat[featured_img]"><?php _e( 'Category image', 'schat' ); ?></label>
        </th>
        <td>
            <p><a href="javascript:;" class="button cx-media-uploader" data-id="featured_img"><?php _e( 'Set featured image', 'schat' ); ?></a></p>
            <div id="CX_media_featured_img" class="cx-media-wrap <?php echo $hide_featured_img; ?>">
                <img src="<?php echo @$featured_img_url; ?>" alt="" title="" />
            </div>
            <p><a href="javascript:;" class="cx-media-remove <?php echo $hide_featured_img; ?>" id="CX_remove_featured_img" data-id="featured_img"><?php _e( 'Remove image', 'schat' ); ?></a></p>
        </td>
    </tr>

<?php }

add_action( 'schat_support_cat_edit_form_fields', 'fn_schat_edit_xtra_support_cat_fields', 10, 2 );

/**
 * Save extra fields of suport topics
 *
 * @since Live Chat (2.0)
 * @return void
 */
function fn_schat_save_xtra_support_cats( $term_id ) {

    if ( isset( $_POST['cx_xtra_support_cat'] ) ) {
        $tid = $term_id;

        $term_meta = get_option( "taxonomy_$tid" );
        $cat_keys = array_keys( $_POST['cx_xtra_support_cat'] );

        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['cx_xtra_support_cat'][$key] ) ) {
                $term_meta[$key] = $_POST['cx_xtra_support_cat'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$tid", $term_meta );

    }
}

add_action( 'edited_schat_support_cat', 'fn_schat_save_xtra_support_cats', 10, 2 );
add_action( 'create_schat_support_cat', 'fn_schat_save_xtra_support_cats', 10, 2 );

/**
 * Add extra column to support catgories
 *
 * @since Live Chat (2.0)
 * @return array $columns
 */
function fn_schat_support_add_xtra_columns( $columns ) {
    
    unset( $columns['description'] );
    unset( $columns['slug'] );
    unset( $columns['posts'] );

    $columns['cx_featured_img'] = '';

    return $columns;

}

/**
 * Edit extra column of support catgories
 *
 * @since Live Chat (2.0)
 * @return array $columns
 */
function fn_schat_support_edit_xtra_columns( $out, $column_name, $term_id ) {
    
    // Retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$term_id" );

    switch ( $column_name ) {

        case 'cx_featured_img' :
            
            // Get featured image
            $featured_img_id = ( !empty( $term_meta['featured_img'] ) ) ? esc_attr( $term_meta['featured_img'] ) : ''; 
            $featured_img_url = wp_get_attachment_url( $featured_img_id );
            
            if( !empty( $featured_img_url ) ) {
                return '<img src="' . $featured_img_url . '" alt="" class="cx-featured-img">';
            } else {
                return '<img src="' . SLC_URL . '/assets/img/cx-no-img.png" alt="" class="cx-featured-img">';
            }

            break;

    }

}

add_filter( 'manage_edit-schat_support_cat_columns', 'fn_schat_support_add_xtra_columns', 10, 1 );
add_filter( 'manage_schat_support_cat_custom_column', 'fn_schat_support_edit_xtra_columns', 10, 3 );

function fn_schat_replace_admin_menu_icons_css() { 
    ?>
    <style>
        @font-face {
            font-family: 'slcadmin';
            src: url('<?php echo SLC_URL; ?>/assets/fonts/slc-admin.eot');
            src: url('<?php echo SLC_URL; ?>/assets/fonts/slc-admin.eot?#iefix') format('embedded-opentype'),
                 url('<?php echo SLC_URL; ?>/assets/fonts/slc-admin.woff') format('woff'),
                 url('<?php echo SLC_URL; ?>/assets/fonts/slc-admin.ttf') format('truetype'),
                 url('<?php echo SLC_URL; ?>/assets/fonts/slc-admin.svg#slc-admin') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        /* [class*='slca-']:before{
            display: inline-block;
            font-family: 'slcadmin';
            font-style: normal;
            font-weight: normal;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }
        .slca-lc:before{content:'\0041';} */

        #toplevel_page_schat_console .wp-menu-image img { display: none; }
        #toplevel_page_schat_console .wp-menu-image::before {
            font-family: slcadmin;
            content:'\0041';
        }
        #toplevel_page_schat_console:hover .wp-menu-image::before,
        #toplevel_page_schat_console.wp-menu-open .wp-menu-image::before {
            content:'\0041';
        }
    </style>

    <?php
}

add_action( 'admin_head', 'fn_schat_replace_admin_menu_icons_css' );