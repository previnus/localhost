<?php
/**
 * User Sidebar Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Includes
 */

global $ct_options;

$current_user = wp_get_current_user();

$ct_user_listings = ct_listing_post_count($current_user->ID, 'listings');
$saved_listings = isset( $ct_options['ct_saved_listings'] ) ? esc_html( $ct_options['ct_saved_listings'] ) : '';
$ct_listing_email_alerts_page_id = isset( $ct_options['ct_listing_email_alerts_page_id'] ) ? esc_attr( $ct_options['ct_listing_email_alerts_page_id'] ) : '';
$submit_listing = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
$user_listings = isset( $ct_options['ct_view'] ) ? esc_html( $ct_options['ct_view'] ) : '';
$user_profile = isset( $ct_options['ct_profile'] ) ? esc_html( $ct_options['ct_profile'] ) : '';

?>

<?php do_action('before_user_sidebar'); ?>

<!-- Sidebar -->
<div id="user-sidebar" class="col span_3 first">
	<div id="sidebar-inner">
        
        <aside id="user-nav" class="widget left">
            <ul class="user-nav">
                <?php if($saved_listings != '' && function_exists('wpfp_link')) { ?>
                    <li class="saved-listings"><a <?php if(is_page($saved_listings)) { echo 'class="current"'; } ?> href="<?php echo get_page_link($saved_listings); ?>"><i class="fa fa-heart"></i> <?php esc_html_e('Favorite Listings', 'contempo'); ?></a></li>
                <?php } ?>
                <?php if($ct_listing_email_alerts_page_id != '' && function_exists('ctea_show_alert_creation')) { ?>
                <li class="listing-email-alerts"><a <?php if(is_page($ct_listing_email_alerts_page_id)) { echo 'class="current"'; } ?> href="<?php echo get_page_link($ct_listing_email_alerts_page_id); ?>"><i class="fa fa-exclamation-circle"></i> <?php _e('Listing Alerts', 'contempo'); ?></a></li>
                <?php } ?>
                <?php if(!empty($submit_listing) && $ct_options['ct_enable_front_end'] == 'yes') { ?>
                    <li class="submit-listing"><a <?php if(is_page($submit_listing)) { echo 'class="current"'; } ?> href="<?php echo get_page_link($submit_listing); ?>"><i class="fa fa-plus"></i> <?php esc_html_e('Submit Listing', 'contempo'); ?></a></li>
                <?php } ?>
                <?php if(!empty($user_listings) && $ct_options['ct_enable_front_end'] == 'yes') { ?>
                    <li class="my-listings"><a <?php if(is_page($user_listings)) { echo 'class="current"'; } ?> href="<?php echo get_page_link($user_listings); ?>"><i class="fa fa-th-list"></i> <?php esc_html_e('My Listings', 'contempo'); ?> (<?php echo esc_html($ct_user_listings); ?>)</a></li>
                <?php } ?>
                <?php if(!empty($user_profile)) { ?>
                    <li class="my-account"><a <?php if(is_page($user_profile)) { echo 'class="current"'; } ?> href="<?php echo get_page_link($user_profile); ?>"><i class="fa fa-user"></i> <?php esc_html_e('Account Settings', 'contempo'); ?></a></li>
                <?php } ?>
                <li class="logout"><a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-sign-out"></i> <?php esc_html_e('Logout', 'contempo'); ?></a></li>
            </ul>
        </aside>

		<?php if(is_active_sidebar('user-sidebar')) {
            dynamic_sidebar('User Sidebar');
        } ?>
		<div class="clear"></div>
	</div>
</div>
<!-- //Sidebar -->

<?php do_action('after_user_sidebar'); ?>