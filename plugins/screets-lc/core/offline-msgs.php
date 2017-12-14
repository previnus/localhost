<?php
/**
 * SCREETS © 2016
 *
 * Plugin custom post types metaboxes
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

$post_type = 'schat_offline_msg';

add_action( "add_meta_boxes_{$post_type}", '_fn_schat_add_offline_msg_mb' );
add_action( "save_post_{$post_type}", '_fn_schat_save_offline_msg_mb' );


/**
 * Add meta-box.
 *
 * @param post $post The post object
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */
function _fn_schat_add_offline_msg_mb( $post ) {

	add_meta_box( 
		'schat_offline_msg_mb', 
		__( 'Info', 'schat' ), 
		'_fn_schat_render_offline_msg_mb', 
		$post->post_type, 
		'normal',
		'high'
	);

	// Remove "publish" box
	remove_meta_box( 'submitdiv', $post->post_type, 'side' );
}

/**
 * Render meta-box.
 *
 * @param post $post The post object
 */
function _fn_schat_render_offline_msg_mb( $post ) {
	
	// Make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), $post->post_type . '_metabox_nonce' );

	$name = get_post_meta( $post->ID, 'name', true );
	$name = ( empty( $name ) ) ? get_post_meta( $post->ID, 'namee', true ) : $name;
	$email = get_post_meta( $post->ID, 'email', true );
	$phone = get_post_meta( $post->ID, 'phone', true );
	$ip_addr = get_post_meta( $post->ID, 'ip_addr', true );
	$currentpage = get_post_meta( $post->ID, 'current-page', true );
	$question = get_post_meta( $post->ID, 'question', true );

?>
	<div class='inside'>

		<table class="schat-table">
	
			<tr>
				<td>
					<strong><?php _e( 'Name', 'schat' ); ?>:</strong> 
					<?php echo $name; ?>
				</td>
			</tr>
	
			<tr>
				<td>
					<strong><?php _e( 'Email', 'schat' ); ?>:</strong> 
					<?php echo $email; ?>
				</td>
			</tr>
	
			<tr>
				<td>
					<strong><?php _e( 'Phone', 'schat' ); ?>:</strong> 
					<?php echo $phone; ?>
				</td>
			</tr>
	
			<tr>
				<td>
					<strong><?php _e( 'IP Address', 'schat' ); ?>:</strong> 
					<?php echo $ip_addr; ?>
				</td>
			</tr>
	
			<tr>
				<td>
					<strong><?php _e( 'Location', 'schat' ); ?>:</strong> 
					<a href="<?php echo $currentpage; ?>" target="_blank"><?php echo $currentpage; ?></a>
				</td>
			</tr>
	
			<tr>
				<td style="padding-top:20px;">
					<strong><?php _e( 'Message', 'schat' ); ?>:</strong> 
					<?php echo $question; ?>
				</td>
			</tr>
			
		</table>

	</div>

	<?php
}
