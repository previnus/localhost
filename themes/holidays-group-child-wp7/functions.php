<?php
/**
 * Child theme functions
 *
 * When using a child theme please review the following helpful links
 * http://contempothemes.com/wp-real-estate-7/documentation/#childthemes
 * http://contempothemes.com/wp-real-estate-7/documentation/#advdev
 * http://codex.wordpress.org/Child_Themes
 *
 * Text Domain: contempo
 *
 */

/**
 * Load the parent theme style.css file
 */
function ct_child_enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action('wp_enqueue_scripts', 'ct_child_enqueue_parent_theme_style');

/**
 * Add your custom code below this comment
 */
 //popup windows
 /* Register and Enqueue scripts for popup window*/

 function SZpopup() {
 	wp_register_script( 'popup', get_stylesheet_directory_uri() . '/js/popup.js', array( 'jquery' ), '1.0.0', false );
 	wp_enqueue_script( 'popup' );
  }

 add_action('wp_enqueue_scripts', 'SZpopup');

 /*Enqueue custom script for listings page (gtranslate, listing content, comments) */
  function SZcustomscripts() {
 	wp_register_script( 'SZcustomscripts', get_stylesheet_directory_uri() . '/js/SZcustomscripts.js', array( 'jquery' ), '1.0.0', false );
 	wp_enqueue_script( 'SZcustomscripts' );
  }

 add_action('wp_enqueue_scripts', 'SZcustomscripts');

 /*-----------------------------------------------------------------------------------*/
 /* Listing Rental Info */
 /*-----------------------------------------------------------------------------------*/
 	function ct_rental_info() {
 		global $post;
 		if(get_post_meta($post->ID, "_ct_rental_checkin", true)) {
 	        echo '<li class="row rental-checkin">';
 	            echo '<span class="muted left"><strong>';
 	                esc_html_e('Check In', 'contempo');
 	            echo '</strong></span>';
 	            echo '<span class="right">';
 		            $checkin = get_post_meta(get_the_ID(), '_ct_rental_checkin', true);
 		            echo date("H:i", strtotime($checkin));
 	            echo '</span>';
 	        echo '</li>';
 	    }
 	    if(get_post_meta($post->ID, "_ct_rental_checkout", true)) {
 	        echo '<li class="row rental-checkout">';
 	            echo '<span class="muted left"><strong>';
 	                esc_html_e('Check Out', 'contempo');
 	            echo '</strong></span>';
 	            echo '<span class="right">';
 	            	$checkout = get_post_meta(get_the_ID(), '_ct_rental_checkout', true);
 		            echo date("H:i", strtotime($checkout));
 	            echo '</span>';
 	        echo '</li>';
 	    }
 	    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
 	        echo '<li class="row rental-max-guests">';
 	            echo '<span class="muted left"><strong>';
 	                esc_html_e('Max Guests', 'contempo');
 	            echo '</strong></span>';
 	            echo '<span class="right">';
 	            	$ct_rental_guests = get_post_meta(get_the_ID(), '_ct_rental_guests', true);
 		            echo $ct_rental_guests;
 	            echo '</span>';
 	        echo '</li>';
 	    }
 	    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
 	        echo '<li class="row rental-min-stay">';
 	            echo '<span class="muted left"><strong>';
 	                esc_html_e('Min Stay', 'contempo');
 	            echo '</strong></span>';
 	            echo '<span class="right">';
 	            	$ct_rental_min_stay = get_post_meta(get_the_ID(), '_ct_rental_min_stay', true);
 		            echo $ct_rental_min_stay;
 	            echo '</span>';
 	        echo '</li>';
 	    }
 	}

	// enqueue modified advanced search js

wp_deregister_script('adv-search');
wp_register_script('adv-search', get_stylesheet_directory_uri() . '/js/ct.advanced.search.js', array('jquery'), '1.0', false);


/* Remove WordPress logo and menu from admin bar */
function wp_debranding_remove_wp_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'wp_debranding_remove_wp_logo');

/* Change WordPress login page logo link href attribute */
function wp_debranding_change_login_page_url($login_header_url) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'wp_debranding_change_login_page_url' );

/* Change WordPress login page logo link title attribute */
function wp_debranding_change_login_page_title($login_header_title) {
    return get_bloginfo('description');
}
add_filter( 'login_headertitle', 'wp_debranding_change_login_page_title' );

/* Change WordPress login page logo image */
function wp_debranding_change_login_page_logo() {
    ?>
    <style type="text/css">
        .login h1 a{
            background-image: url('https://www.holidays.group/wp-content/uploads/2017/06/wdlh-logo-btm.png');
            background-size: auto;
            margin: 0 auto;

            /* Set to your image dimensions */
            height: 219px;
            width: 200px;
        }
    </style>
    <?php
}
add_action('login_head', 'wp_debranding_change_login_page_logo');

/* Remove WordPress name from adming interface footer */
function change_admin_footer_text() {
    return '';
}
add_filter('admin_footer_text', 'change_admin_footer_text');

/* Remove content generator meta tag from page source */
remove_action('wp_head', 'wp_generator');

/* Custom Meta Widget class without WordPress links */
class WP_Debranding_Widget_Meta extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'widget_meta', 'description' => __( "Log in/out, admin, feed and WordPress links") );
        parent::__construct('meta', __('Meta'), $widget_ops);
    }

    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Meta') : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        ?>
            <ul>
            <?php wp_register(); ?>
            <li><?php wp_loginout(); ?></li>
            <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
            <li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
            <?php wp_meta(); ?>
            </ul>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <?php
    }
}

/* Replace default Meta widget with custom widget without WordPress.org link */
function wp_debranding_load_widgets(){
    unregister_widget('WP_Widget_Meta');
    register_widget('WP_Debranding_Widget_Meta');
}
add_action('widgets_init', 'wp_debranding_load_widgets');

/* Remove WordPress related admin dashboard widgets */
function wp_debranding_remove_dashboard_widgets(){
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // wordpress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');   // other wordpress news
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // plugins
}
add_action('admin_menu', 'wp_debranding_remove_dashboard_widgets');

/* Hide help menus and .wp-pointers pop-up dialogs that inform about
 * new features after WordPress upgrade */
function wp_debranding_admin_css_hide(){
    ?>
    <style type="text/css">
        #contextual-help-link-wrap,
        .wp-pointer{
            display: none !important;
        }
    </style>
    <?php
}
add_action('admin_print_styles', 'wp_debranding_admin_css_hide');


/* Modified Listing Property Info */

	function ct_propinfo() {
	    global $post;
	    global $wp_query;
	    global $ct_options;

	    $ct_use_propinfo_icons = isset( $ct_options['ct_use_propinfo_icons'] ) ? esc_html( $ct_options['ct_use_propinfo_icons'] ) : '';
	    $ct_listings_propinfo_property_type = isset( $ct_options['ct_listings_propinfo_property_type'] ) ? esc_html( $ct_options['ct_listings_propinfo_property_type'] ) : '';

	    $ct_property_type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
	    $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
	    $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

	    $ct_walkscore = isset( $ct_options['ct_enable_walkscore'] ) ? esc_html( $ct_options['ct_enable_walkscore'] ) : '';
	    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
	    $ct_listing_reviews = isset( $ct_options['ct_listing_reviews'] ) ? esc_html( $ct_options['ct_listing_reviews'] ) : '';

	    if($ct_walkscore == 'yes') {
		    /* Walk Score */
		   	$latlong = get_post_meta($post->ID, "_ct_latlng", true);
		   	$ct_trans_name = uniqid('ct_');

		   	if($latlong != '' && false === ( $ct_ws = get_transient( $ct_trans_name . '_walkscore_data' ) )) {
				list($lat, $long) = explode(',',$latlong,2);
				$address = get_the_title() . ct_taxonomy_return('city') . ct_taxonomy_return('state') . ct_taxonomy_return('zipcode');
				$json = ct_get_walkscore($lat,$long,$address);

				$ct_ws = json_decode($json);

				set_transient( $ct_trans_name . '_walkscore_data', $ct_ws, 7 * DAY_IN_SECONDS );
			}
		}

		if(!empty($ct_property_type) && $ct_listings_propinfo_property_type != 'yes') {
	        echo '<li class="row property-type">';
	            echo '<span class="muted left">';
	    			if($ct_use_propinfo_icons != 'icons') {
		    			_e('Type', 'contempo');
		    		} else {
		    			if(ct_has_type('commercial')) {
							echo '<i class="fa fa-building-o"></i>';
						} elseif(ct_has_type('land') || ct_has_type('lot')) {
							echo '<i class="fa fa-tree"></i>';
						} else {
							echo '<i class="fa fa-home"></i>';
						}
		    		}
	    		echo '</span>';
	    		echo '<span class="right">';
	               echo $ct_property_type;
	            echo '</span>';
	        echo '</li>';
	    }

	    if(get_post_meta($post->ID, "_ct_sqft", true)) {
	    	if($ct_use_propinfo_icons != 'icons') {
		        echo '<li class="row sqft">';
		            echo '<span class="muted left">';
		    			ct_sqftsqm();
		    		echo '</span>';
		    		echo '<span class="right">';
		                 echo get_post_meta($post->ID, "_ct_sqft", true);
		            echo '</span>';
		        echo '</li>';
		    } else {
		    	echo '<li class="row sqft">';
		            echo '<span class="muted left">';
			            ct_listing_size_icon();
		    		echo '</span>';
		    		echo '<span class="right">';
		                 echo get_post_meta($post->ID, "_ct_sqft", true);
		                 echo ' ' . ct_sqftsqm();
		            echo '</span>';
		        echo '</li>';
		    }
	    } else{
				//display only blank row
				echo '<li class="row sqft">';
							echo '<span class="muted left">';
								ct_sqftsqm();
					echo '</span>';
					echo '</li>';
			}

	    if(ct_has_type('commercial') || ct_has_type('lot') || ct_has_type('land')) {
	        // Dont Display Bed/Bath
	    } else {

		    	echo '<li class="row beds">';
		    		echo '<span class="muted left">';
		    			if($ct_use_propinfo_icons != 'icons') {
			    			_e('Bed', 'contempo');
			    		} else {
			    			echo '<i class="fa fa-bed"></i>';
			    		}
		    		echo '</span>';
		    		echo '<span class="right">';
                        if(!empty($beds)) {echo $beds;} else {echo '&nbsp;';};
		            echo '</span>';
		        echo '</li>';


		        echo '<li class="row baths">';
		            echo '<span class="muted left">';
		    			if($ct_use_propinfo_icons != 'icons') {
			    			_e('Baths', 'contempo');
			    		} else {
			    			echo '<i class="fa fa-bath"></i>';
			    		}
		    		echo '</span>';
		    		echo '<span class="right">';
                       if(!empty($baths)) {echo $baths;} else {echo '&nbsp;';}
		            echo '</span>';
		        echo '</li>';
	    }

	    include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php')) {
		    if(get_post_meta($post->ID, "_ct_rental_guests", true)) {
		        echo '<li class="row guests">';
		            echo '<span class="muted left">';
		                if($ct_use_propinfo_icons != 'icons') {
			    			_e('Guests', 'contempo');
			    		} else {
			    			echo '<i class="fa fa-group"></i>';
			    		}
		            echo '</span>';
		            echo '<span class="right">';
		                 echo get_post_meta($post->ID, "_ct_rental_guests", true);
		            echo '</span>';
		        echo '</li>';
		    } else{
					// display only guest row
					echo '<li class="row guests">';
							echo '<span class="muted left">';
							_e('Guests', 'contempo');
							echo '</span>';
					echo '</li>';
				}

	    if($ct_walkscore == 'yes') {
		    if(!empty($ct_ws->walkscore)) {
			    echo '<li class="row walkscore">';
					echo '<span class="muted left">';
						_e('Walk Score&reg;', 'contempo');
					echo '</span>';
					echo '<span class="right">';
						echo '<a class="tooltips" href=" ' . $ct_ws->ws_link , '" target="_blank">';
					        echo $ct_ws->walkscore;
					        echo '<span>' . $ct_ws->description. '</span>';
				        echo '</a>';
			        echo '</span>';
			    echo '</li>';
			}
		}

		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		if($ct_listing_reviews == 'yes' || is_plugin_active('comments-ratings/comments-ratings.php')) {
			global $pixreviews_plugin;
			$ct_rating_avg = $pixreviews_plugin->get_average_rating();
			if($ct_rating_avg != '') {
				echo '<li class="row rating">';
		            echo '<span class="muted left">';
		                if($ct_use_propinfo_icons != 'icons') {
			    			_e('Rating', 'contempo');
			    		} else {
			    			echo '<i class="fa fa-star"></i>';
			    		}
		            echo '</span>';
		            echo '<span class="right">';
		                 echo $pixreviews_plugin->get_average_rating();
		            echo '</span>';
		        echo '</li>';
		    } else{ // display only rating
					echo '<li class="row rating">';
									echo '<span class="muted left">';
									_e('Rating', 'contempo');
									echo '</span>';
							echo '</li>';
				}
		}

		    if(get_post_meta($post->ID, "_ct_rental_min_stay", true)) {
		        echo '<li class="row min-stay">';
		            echo '<span class="muted left">';
		                if($ct_use_propinfo_icons != 'icons') {
			    			_e('Min Stay', 'contempo');
			    		} else {
			    			echo '<i class="fa fa-calendar"></i>';
			    		}
		            echo '</span>';
		            echo '<span class="right">';
		                 echo get_post_meta($post->ID, "_ct_rental_min_stay", true);
		            echo '</span>';
		        echo '</li>';
		    }
		}

	    if(get_post_meta($post->ID, "_ct_lotsize", true)) {
	        if(get_post_meta($post->ID, "_ct_lotsize", true)) {
	            echo '<li class="row lotsize">';
	        }
	            echo '<span class="muted left">';
	    			if($ct_use_propinfo_icons != 'icons') {
		    			_e('Lot Size', 'contempo');
		    		} else {
		    			echo '<i class="fa fa-arrows-alt"></i>';
		    		}
	    		echo '</span>';
	    		echo '<span class="right">';
	                 echo get_post_meta($post->ID, "_ct_lotsize", true) . ' ';
	                 ct_acres();
	            echo '</span>';

	        if((get_post_meta($post->ID, "_ct_lotsize", true))) {
	            echo '</li>';
	        }
	    }

	}

/* Restrict user post visibility for authors */

add_action( 'load-edit.php', 'posts_for_current_author' );
function posts_for_current_author() {
    global $user_ID;

    /*if current user is an 'administrator' or 'editor' do nothing*/
    if ( current_user_can( 'edit_others_pages' ) ) return;

    if ( ! isset( $_GET['author'] ) ) {
        wp_redirect( add_query_arg( 'author', $user_ID ) );
        exit;
    }

}


/* Modifications on plugin ct-real-estate-custom-post-types : Override plugin function/filters/actions */

// remove old filter from plugin and add new filter - manage edit listings

remove_filter("manage_edit-listings_columns", "ct_listings_cols");
add_filter("manage_edit-listings_columns", "ct_listings_cols_modified");

if(!function_exists('ct_listings_cols_modified')) {
		function ct_listings_cols_modified($columns) {
			$columns = array(
				//Create custom columns
				'cb' => '<input type="checkbox" />',
				'pid' => __('Post ID', 'contempo'),
				'propertyid' => __('Property ID', 'contempo'),
				'bookingid' => __('Booking ID', 'contempo'),
				'image' => __('Image', 'contempo'),
				'propertytype' => __('Type', 'contempo'),
				'title' => __('Address', 'contempo'),
				'location' => __('Location', 'contempo'),
				'pzipcode' => __('Zipcode', 'contempo'),
				'price' => __('Price', 'contempo'),
				'bookingcost' => __('Booking Cost', 'contempo'),
				'rentaltime' => __('Check In/Out', 'contempo'),
				'numofguest' => __('Max Guests', 'contempo'),
				'author' => __('Agent', 'contempo'),
				//'status' => __('Status', 'contempo'),
				'date' => __('Listed', 'contempo')
			);
			return $columns;
		}
	}

// remove old action from plugin and add new action - manage custom column

remove_action("manage_posts_custom_column", "ct_custom_listings_cols");
add_action("manage_posts_custom_column", "ct_custom_listings_cols_modified");

// Output custom columns
	function ct_custom_listings_cols_modified($column) {
		global $post;

		switch( $column ) {

			// Image
			case 'image' :

				if(has_post_thumbnail()) {
					the_post_thumbnail('thumb');
				}

			break;

			// City, State and Zipcode/Postcode
			case 'location' :

				$_taxonomy = 'city';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}
				echo ', ';
				$_taxonomy = 'state';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}
				echo ' ';
				$_taxonomy = 'zipcode';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}
				echo ' ';
				$_taxonomy = 'country';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}

			break;

			// Price
			case 'price' :
				if( function_exists('ct_listing_price') ) {
					ct_listing_price();
				}

			break;

			//Check in/out Time
			case 'rentaltime' :
			$checkin = date("H:i", strtotime(get_post_meta(get_the_ID(), '_ct_rental_checkin', true)));
			$checkout = date("H:i", strtotime(get_post_meta(get_the_ID(), '_ct_rental_checkout', true)));
			echo $checkin . " / " . $checkout;

			break;

			//Post id
			case 'pid' :
				echo get_the_ID();

			break;

			// Property id
			case 'propertyid' :
			echo get_post_meta($post->ID, "_ct_mls", true);

			break;

			// Max num of Guests
			case 'numofguest' :
			$rentalguests = get_post_meta($post->ID, "_ct_rental_guests", true);
			if(!empty($rentalguests)){
				echo $rentalguests;
			}else{
				echo 'Not defined';
			}

			break;

			// Booking Code
			case 'bookingid' :
				$re = '/type=([0-9]+)/';
				$str = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
				preg_match($re, $str, $matches);
				$arr = str_split($matches[0], 5);
				if (!empty($str)) {
					echo $arr[1];
					//echo $str;
				}else{
					echo 'Code booking invalide/inexistant';
				}

			break;

			// Booking Cost

			case 'bookingcost':
				global $wpdb;
				//get booking shortcode(only id of booking) from custom fields
				$re = '/type=([0-9]+)/';
				$str = get_post_meta($post->ID, "_ct_booking_cal_shortcode", true);
				preg_match($re, $str, $matches);
				$arr = str_split($matches[0], 5);
				$result = intval($arr[1]);
				//match with 
				$booking = $wpdb->get_results("SELECT cost FROM ". $wpdb->prefix ."bookingtypes WHERE booking_type_id LIKE $result");
				if(!empty($booking)){
				echo $booking[0]->cost;
				}else{
				echo 'La ressource n\'existe pas';
				}
				
			break;

			// Property Type

			case 'propertytype':

				$_taxonomy = 'property_type';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						echo $c->name;
				}
				else {
					_e('-', 'contempo');
				}
			break;

			// zipcode

			case 'pzipcode':

				$_taxonomy = 'zipcode';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						echo $c->name;
				}
				else {
					_e('-', 'contempo');
				}
			break;

			// Beds
			case 'beds' :
				$_taxonomy = 'beds';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}

			break;

			// Baths
			case 'baths' :

				$_taxonomy = 'baths';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}

			break;

			// Status
			case 'status' :

				$_taxonomy = 'ct_status';
				$terms = get_the_terms( $post->ID, $_taxonomy );
				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $c )
						$statusClass = preg_replace('/\s+/', '-', $c->name);
						$out[] = "<a class='" . strtolower($statusClass) . "' href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=listings&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
					echo join( ', ', $out );
				}
				else {
					_e('-', 'contempo');
				}

				global $ct_options;

				$author_level = get_the_author_meta('user_level');

				$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
				$ct_listing_trans_id = get_post_meta($post->ID, "_ct_listing_paid_transaction_id", true);
				$ct_listing_expiration = isset( $ct_options['ct_listing_expiration'] ) ? esc_attr( $ct_options['ct_listing_expiration'] ) : '';

				if($ct_enable_front_end_paid == 'yes' && $author_level <= '2') {
					// TO DO: Change if so that it only shows if the listing was paid for or not, based on PayPal
					if($ct_listing_trans_id != '') {
						echo '<a class="paid" href=="#">' . __('Paid', 'contempo') . '</a>';
					//} elseif($ct_listing_expiration != '') {
					//	echo '<a class="expired" href=="#">' . __('Expired', 'contempo') . '</a>';
					} else {
						echo '<a class="pending" href=="#">' . __('Pending', 'contempo') . '</a>';
					}
				}

			break;

		}

	}

// add filter/action to make admin column sortable

	add_filter("manage_edit-listings_sortable_columns", "ct_listings_sortable");
	// define which column is sortable
		function ct_listings_sortable($columns) {
			$columns = array(
				// Create custom columns
				'pid' => 'pid',
				'propertyid' => 'propertyid',
				'bookingid' => 'bookingid',
				'author' => 'author',
				'status' => 'status',
				'date' => 'date'
			);
			return $columns;
		}

	add_action( 'pre_get_posts', 'custom_orderby' );
		function custom_orderby( $query ) {
			if( ! is_admin() )
				return;

			$orderby = $query->get( 'orderby');
			// sort propertyid column
			if ( 'propertyid' == $orderby ) {
				$query->set('meta_key','_ct_mls');
				$query->set('orderby','meta_value');
			}
			// sort bookingid column
			elseif ( 'bookingid' == $orderby ) {
				$query->set('meta_key','_ct_booking_cal_shortcode');
				$query->set('orderby','meta_value');
			}
		}

//add additional class notranslate to body class to prevent google auto translate
add_filter( 'body_class', function( $classes ) {
    return array_merge( $classes, array( 'notranslate' ) );
} );