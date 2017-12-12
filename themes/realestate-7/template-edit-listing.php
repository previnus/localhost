<?php
/**
 * Template Name: Edit Listing
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options; 

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$ct_front_submit_street_address = isset( $ct_options['ct_front_submit_street_address'] ) ? esc_html( $ct_options['ct_front_submit_street_address'] ) : '';
$ct_front_submit_alt_title = isset( $ct_options['ct_front_submit_alt_title'] ) ? esc_html( $ct_options['ct_front_submit_alt_title'] ) : '';
$ct_front_submit_type = isset( $ct_options['ct_front_submit_type'] ) ? esc_html( $ct_options['ct_front_submit_type'] ) : '';
$ct_front_submit_status = isset( $ct_options['ct_front_submit_status'] ) ? esc_html( $ct_options['ct_front_submit_status'] ) : '';
$ct_front_submit_price = isset( $ct_options['ct_front_submit_price'] ) ? esc_html( $ct_options['ct_front_submit_price'] ) : '';
$ct_front_submit_price_prefix = isset( $ct_options['ct_front_submit_price_prefix'] ) ? esc_html( $ct_options['ct_front_submit_price_prefix'] ) : '';
$ct_front_submit_price_postfix = isset( $ct_options['ct_front_submit_price_postfix'] ) ? esc_html( $ct_options['ct_front_submit_price_postfix'] ) : '';
$ct_front_submit_description = isset( $ct_options['ct_front_submit_description'] ) ? esc_html( $ct_options['ct_front_submit_description'] ) : '';
$ct_front_submit_price_postfix = isset( $ct_options['ct_front_submit_price_postfix'] ) ? esc_html( $ct_options['ct_front_submit_price_postfix'] ) : '';
$ct_front_submit_beds = isset( $ct_options['ct_front_submit_beds'] ) ? esc_html( $ct_options['ct_front_submit_beds'] ) : '';
$ct_front_submit_baths = isset( $ct_options['ct_front_submit_baths'] ) ? esc_html( $ct_options['ct_front_submit_baths'] ) : '';
$ct_front_submit_size = isset( $ct_options['ct_front_submit_size'] ) ? esc_html( $ct_options['ct_front_submit_size'] ) : '';
$ct_front_submit_property_id = isset( $ct_options['ct_front_submit_property_id'] ) ? esc_html( $ct_options['ct_front_submit_property_id'] ) : '';
$ct_front_submit_video_url = isset( $ct_options['ct_front_submit_video_url'] ) ? esc_html( $ct_options['ct_front_submit_video_url'] ) : '';
$ct_front_submit_open_house_date = isset( $ct_options['ct_front_submit_open_house_date'] ) ? esc_html( $ct_options['ct_front_submit_open_house_date'] ) : '';
$ct_front_submit_open_house_start_time = isset( $ct_options['ct_front_submit_open_house_start_time'] ) ? esc_html( $ct_options['ct_front_submit_open_house_start_time'] ) : '';
$ct_front_submit_open_house_end_time = isset( $ct_options['ct_front_submit_open_house_end_time'] ) ? esc_html( $ct_options['ct_front_submit_open_house_end_time'] ) : '';
$ct_front_submit_additional_features = isset( $ct_options['ct_front_submit_additional_features'] ) ? esc_html( $ct_options['ct_front_submit_additional_features'] ) : '';
$ct_front_submit_max_guests = isset( $ct_options['ct_front_submit_max_guests'] ) ? esc_html( $ct_options['ct_front_submit_max_guests'] ) : '';
$ct_front_submit_min_stay = isset( $ct_options['ct_front_submit_min_stay'] ) ? esc_html( $ct_options['ct_front_submit_min_stay'] ) : '';
$ct_front_submit_check_in = isset( $ct_options['ct_front_submit_check_in'] ) ? esc_html( $ct_options['ct_front_submit_check_in'] ) : '';
$ct_front_submit_check_out = isset( $ct_options['ct_front_submit_check_out'] ) ? esc_html( $ct_options['ct_front_submit_check_out'] ) : '';
$ct_front_submit_extra_person = isset( $ct_options['ct_front_submit_extra_person'] ) ? esc_html( $ct_options['ct_front_submit_extra_person'] ) : '';
$ct_front_submit_cleaning_fee = isset( $ct_options['ct_front_submit_cleaning_fee'] ) ? esc_html( $ct_options['ct_front_submit_cleaning_fee'] ) : '';
$ct_front_submit_cancellation_fee = isset( $ct_options['ct_front_submit_cancellation_fee'] ) ? esc_html( $ct_options['ct_front_submit_cancellation_fee'] ) : '';
$ct_front_submit_security_deposit = isset( $ct_options['ct_front_submit_security_deposit'] ) ? esc_html( $ct_options['ct_front_submit_security_deposit'] ) : '';
$ct_front_submit_address = isset( $ct_options['ct_front_submit_address'] ) ? esc_html( $ct_options['ct_front_submit_address'] ) : '';
$ct_front_submit_city = isset( $ct_options['ct_front_submit_city'] ) ? esc_html( $ct_options['ct_front_submit_city'] ) : '';
$ct_front_submit_state = isset( $ct_options['ct_front_submit_state'] ) ? esc_html( $ct_options['ct_front_submit_state'] ) : '';
$ct_front_submit_zip_post = isset( $ct_options['ct_front_submit_zip_post'] ) ? esc_html( $ct_options['ct_front_submit_zip_post'] ) : '';
$ct_front_submit_country = isset( $ct_options['ct_front_submit_country'] ) ? esc_html( $ct_options['ct_front_submit_country'] ) : '';
$ct_front_submit_community = isset( $ct_options['ct_front_submit_community'] ) ? esc_html( $ct_options['ct_front_submit_community'] ) : '';
$ct_front_submit_lat_long = isset( $ct_options['ct_front_submit_lat_long'] ) ? esc_html( $ct_options['ct_front_submit_lat_long'] ) : '';
$ct_front_submit_private_notes = isset( $ct_options['ct_front_submit_private_notes'] ) ? esc_html( $ct_options['ct_front_submit_private_notes'] ) : '';

$query = new WP_Query(array('post_type' => 'listings', 'posts_per_page' =>'-1', 'post_status' => array('publish', 'pending', 'draft', 'private', 'trash') ) );

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
    
    if(isset($_GET['listings'])) {
        
        if($_GET['listings'] == $post->ID) {
            $current_post = $post->ID;

            $title = get_the_title();
            $alt_title = get_post_meta($current_post, '_ct_listing_alt_title', true);
            $content = get_the_content();
            $featuredImage = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
            $galleryImages = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );

            $ct_price = get_post_meta($current_post, '_ct_price', true);
            $ct_price_prefix = get_post_meta($current_post, '_ct_price_prefix', true);
            $ct_price_postfix = get_post_meta($current_post, '_ct_price_postfix', true);
            $ct_sqft = get_post_meta($current_post, '_ct_sqft', true);
            $ct_video_url = get_post_meta($current_post, '_ct_video', true);
            $ct_mls = get_post_meta($current_post, '_ct_mls', true);
            $ct_latlng = get_post_meta($current_post, '_ct_latlng', true);

            // Rental Information
            $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
            $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') {
                $ct_rental_guests = get_post_meta($current_post, '_ct_rental_guests', true);
                $ct_rental_min_stay = get_post_meta($current_post, '_ct_rental_min_stay', true);
                $ct_rental_checkin = get_post_meta($current_post, '_ct_rental_checkin', true);
                $ct_rental_checkout = get_post_meta($current_post, '_ct_rental_checkout', true);
                $ct_rental_extra_people = get_post_meta($current_post, '_ct_rental_extra_people', true);
                $ct_rental_cleaning = get_post_meta($current_post, '_ct_rental_cleaning', true);
                $ct_rental_cancellation = get_post_meta($current_post, '_ct_rental_cancellation', true);
                $ct_rental_deposit = get_post_meta($current_post, '_ct_rental_deposit', true);
            }

            $ct_property_type = strip_tags( get_the_term_list( $current_post, 'property_type', '', ', ', '' ) );
            $ct_status = strip_tags( get_the_term_list( $current_post, 'ct_status', '', ', ', '' ) );
            $ct_city = strip_tags( get_the_term_list( $current_post, 'city', '', ', ', '' ) );
            $ct_state = strip_tags( get_the_term_list( $current_post, 'state', '', ', ', '' ) );
            $ct_zip = strip_tags( get_the_term_list( $current_post, 'zipcode', '', ', ', '' ) );
            $ct_country = strip_tags( get_the_term_list( $current_post, 'country', '', ', ', '' ) );
            $ct_community = strip_tags( get_the_term_list( $current_post, 'community', '', ', ', '' ) );
            $ct_beds = strip_tags( get_the_term_list( $current_post, 'beds', '', ', ', '' ) );
            $ct_baths = strip_tags( get_the_term_list( $current_post, 'baths', '', ', ', '' ) );
            $ct_features = strip_tags( get_the_term_list( $current_post, 'additional_features', '', ', ', '' ) );
        }
    }

endwhile; endif;
wp_reset_query();

global $current_post;

$postTitleError = '';

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
    
    global $ct_options;

    $view = $ct_options['ct_view'];
    $ct_auto_publish = $ct_options['ct_auto_publish'];

    if(trim($_POST['postTitle']) === '') {
        $postTitleError = 'Please enter an address.';
        $hasError = true;
    } else {
        $postTitle = trim($_POST['postTitle']);
    }

    $post_information = array(
        'ID' => $current_post,
        'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
        'post_content' => esc_attr(strip_tags($_POST['postContent'])),
        'post-type' => 'listings',
        'post_status' => $ct_auto_publish
    );
	
    $post_id = wp_update_post($post_information);

    /*if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            $newupload = ct_insert_attachment($file,$post_id);
        }
    }*/

    if($post_id) {
        if(!empty($_POST['att_id'])) {
    		$positions = implode(',',$_POST['att_id']);
        }
		update_post_meta($post_id, '_ct_images_position', $positions);

        $ct_price = str_replace(array('.', ','), '' , $_POST['customMetaPrice']);
		
        // Update Custom Meta
        update_post_meta($post_id, '_ct_listing_alt_title', esc_attr(strip_tags($_POST['customMetaAltTitle'])));
        update_post_meta($post_id, '_ct_price', esc_attr(strip_tags($ct_price)));
        update_post_meta($post_id, '_ct_price_prefix', esc_attr(strip_tags($_POST['customMetaPricePrefix'])));
        update_post_meta($post_id, '_ct_price_postfix', esc_attr(strip_tags($_POST['customMetaPricePostfix'])));
        update_post_meta($post_id, '_ct_sqft', esc_attr(strip_tags($_POST['customMetaSqFt'])));
        update_post_meta($post_id, '_ct_video', esc_attr(strip_tags($_POST['customMetaVideoURL'])));
        update_post_meta($post_id, '_ct_mls', esc_attr(strip_tags($_POST['customMetaMLS'])));
        update_post_meta($post_id, '_ct_latlng', esc_attr(strip_tags($_POST['customMetaLatLng'])));

        // Rental Information
        $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
        $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if($ct_rentals_booking == 'yes' || is_plugin_active('booking/wpdev-booking.php') && $ct_submit_rental_info == 'yes') {
            update_post_meta($post_id, '_ct_rental_guests', esc_attr(strip_tags($_POST['customMetaMaxGuests'])));
            update_post_meta($post_id, '_ct_rental_min_stay', esc_attr(strip_tags($_POST['customMetaMinStay'])));
            update_post_meta($post_id, '_ct_rental_checkin', esc_attr(strip_tags($_POST['customMetaCheckIn'])));
            update_post_meta($post_id, '_ct_rental_checkout', esc_attr(strip_tags($_POST['customMetaCheckOut'])));
            update_post_meta($post_id, '_ct_rental_extra_people', esc_attr(strip_tags($_POST['customMetaExtraPerson'])));
            update_post_meta($post_id, '_ct_rental_cleaning', esc_attr(strip_tags($_POST['customMetaCleaningFee'])));
            update_post_meta($post_id, '_ct_rental_cancellation', esc_attr(strip_tags($_POST['customMetaCancellationFee'])));
            update_post_meta($post_id, '_ct_rental_deposit', esc_attr(strip_tags($_POST['customMetaSecurityDeposit'])));
        }

        //Update Custom Taxonomies
        wp_set_post_terms($post_id,array($_POST['ct_property_type']),'property_type',false);
        wp_set_post_terms($post_id,array($_POST['customTaxBeds']),'beds',false);
        wp_set_post_terms($post_id,array($_POST['customTaxBaths']),'baths',false);
        wp_set_post_terms($post_id,array($_POST['ct_status']),'ct_status',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCity']),'city',false);
        wp_set_post_terms($post_id,array($_POST['customTaxState']),'state',false);
        wp_set_post_terms($post_id,array($_POST['customTaxZip']),'zipcode',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCountry']),'country',false);
        wp_set_post_terms($post_id,array($_POST['customTaxCommunity']),'community',false);
        wp_set_post_terms($post_id, $_POST['customTaxFeat'],'additional_features',false);
		
		//SET FEATURED
		if($_POST['featured_id']!="") set_post_thumbnail($post_id, $_POST['featured_id']);
		else set_post_thumbnail($post_id, $_POST['att_id'][0]);
		
        // Redirect
        wp_redirect( home_url() . '/?page_id=' . $view ); exit;
    }       

}

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

if($inside_page_title == "Yes") { 
	// Custom Page Header Background Image
	if(get_post_meta($post->ID, '_ct_page_header_bg_image', true) != '') {
		echo'<style type="text/css">';
		echo '#single-header { background: url(';
		echo get_post_meta($post->ID, '_ct_page_header_bg_image', true);
		echo ') no-repeat center center; background-size: cover;}';
		echo '</style>';
	} ?>

	<!-- Single Header -->
	<div id="single-header">
		<div class="dark-overlay">
			<div class="container">
				<h1 class="marT0 marB0"><?php the_title(); ?></h1>
				<?php if(get_post_meta($post->ID, '_ct_page_sub_title', true) != '') { ?>
					<h2 class="marT0 marB0"><?php echo get_post_meta($post->ID, "_ct_page_sub_title", true); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- //Single Header -->
<?php } ?>

<div class="container">

        <?php if(is_user_logged_in()) {
            get_template_part('/includes/user-sidebar');
        } ?>

        <article class="listing col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

            <?php if(!is_user_logged_in()) {
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
            } else { ?>

                <?php ct_listings_progress_bar(); ?>
            
    			<form action="" id="primaryPostForm" class="front-end-form" method="POST" enctype="multipart/form-data">

                    <fieldset class="col span_10 first form-section">

                        <div class="input-full-width">
                            <label><?php esc_html_e('Street Address', 'contempo'); ?></label>
                            <input type="text" name="postTitle" id="postTitle" value="<?php echo esc_attr($title); ?>" <?php if($ct_front_submit_street_address == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="input-full-width">
                            <label><?php esc_html_e('Alternate Title', 'contempo'); ?></label>
                            <input type="text" name="customMetaAltTitle" id="customMetaAltTitle" value="<?php echo esc_html($alt_title); ?>" placeholder="<?php esc_html_e('(e.g. Downtown Penthouse)', 'contempo'); ?>" <?php if($ct_front_submit_alt_title == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4 first">
                            <label><?php esc_html_e('Type', 'contempo'); ?></label>
                            <?php 
                                $taxonomy_name = 'property_type';
                                $name = strip_tags( get_the_term_list( $current_post, 'property_type', '', ', ', '' ) );
                            ?>
                            <select id="ct_property_type" name="ct_property_type" <?php if($ct_front_submit_type == 'required') { echo 'required'; } ?>>
                                <option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
                                <?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
                                    <?php if ($ct_property_type == $t->name) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
                                    <option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Status', 'contempo'); ?></label>
                            <?php 
                                $taxonomy_name = 'ct_status';
                                $name = strip_tags( get_the_term_list( $current_post, 'ct_status', '', ', ', '' ) );
                            ?>
                            <select id="ct_status" name="ct_status" <?php if($ct_front_submit_status == 'required') { echo 'required'; } ?>>
                                <option value="0"><?php esc_html_e('Any', 'contempo'); ?></option>
                                <?php foreach( get_terms($taxonomy_name, 'hide_empty=true') as $t ) : ?>
                                    <?php if ($ct_status == $t->name) { $selected = 'selected="selected" '; } else { $selected = ''; } ?>
                                    <option <?php echo esc_html($selected); ?>value="<?php echo esc_attr($t->slug); ?>"><?php echo esc_html($t->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Price', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                            <input type="text" name="customMetaPrice" id="customMetaPrice" value="<?php echo esc_html($ct_price); ?>" <?php if($ct_front_submit_price == 'required') { echo 'required'; } ?> />
                        </div>

                            <div class="clear"></div>

                        <div class="col span_6 first">
                            <label><?php esc_html_e('Price Prefix', 'contempo'); ?><span class="muted"><?php esc_html_e(' (e.g. From, Call for price)', 'contempo'); ?></span></label>
                            <input type="text" name="customMetaPricePrefix" id="customMetaPricePrefix" value="<?php echo esc_html($ct_price_prefix); ?>" <?php if($ct_front_submit_price_prefix == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_6">
                            <label><?php esc_html_e('Price Postfix Text', 'contempo'); ?><span class="muted"><?php esc_html_e(' (e.g. /month, /week)', 'contempo'); ?></span></label>
                            <input type="text" name="customMetaPricePostfix" id="customMetaPricePostfix" value="<?php echo esc_html($ct_price_postfix); ?>" <?php if($ct_front_submit_price_postfix == 'required') { echo 'required'; } ?> />
                        </div>

                            <div class="clear"></div>

                            <div class="clear"></div>

                        <label><?php esc_html_e('Listing Description', 'contempo'); ?></label>
                        <?php
                            $content = $content;
                            $editor_id = 'postContent';

                            wp_editor( $content, $editor_id, $settings = array('textarea_rows' => '8') );
                        ?>

                    </fieldset>

                    <fieldset class="col span_10 first form-section">

                        <div class="left" style="display: none;">
                            <figure class="col span_3 first">
                                <img src="<?php echo esc_url($featuredImage); ?>" />
                            </figure>
                            <div class="col span_9">
                                <label><?php esc_html_e('Listing Featured Image', 'contempo'); ?></label>
                                <input type="file" name="featuredImage" id="featuredImage" />
                            </div>
                        </div>

                        <div class="1-left"> <!-- class="left" not needed here --> 
                            <div class="col span_12 first">
                                <input type="hidden" id="nonce_rem" value="<?php echo wp_create_nonce( 'ct_delete_attachment_edit_'.$post->ID ); ?>" />
                                <input type="hidden" id="nonce_feature" value="<?php echo wp_create_nonce( 'ct_set_attachment_featured_'.$post->ID ); ?>" />
                               <label><?php esc_html_e('Listing Images', 'contempo'); ?></label>
                                <?php
                                $featured_id=get_post_thumbnail_id($_GET['listings']);
                                if(is_object($featured_id)) $featured_id=0;
                                echo '<input type="hidden" id="featured_id" name="featured_id" value="'.$featured_id.'" />';
                                echo '<ul id="sortable" class="marT15 listing-images">';
                                if ($galleryImages) {
                                        $i = 0;
                                        $position=get_post_meta($current_post, '_ct_images_position', true);
                                        if($position==""){
                                            foreach ($galleryImages as $photo) { ?>
                                                <li id="file-<?php echo esc_html($photo->ID); ?>" class="col span_4 first"><?php
                                                    echo '<figure class="gallery-thumb">';
                                                        echo '<span class="featured-img">';
                                                            echo '<a class="setImageFeatured" name="' . esc_html($photo->ID) .'" href="#"><i class="fa '.( $photo->ID == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
                                                        echo '</span>';
                                                        echo '<span class="delete-img">';
                                                            echo '<a class="remImage" name="' . esc_html($photo->ID) .'" href="#"><i class="fa fa-trash-o"></i></a>';
                                                        echo '</span>';
                                                        echo '<img src="' . wp_get_attachment_url($photo->ID) . '" />';
                                                        echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($photo->ID) . '" />';
                                                    echo '</figure>';
                                                echo '</li>';
                                                $i++;
                                            }
                                        } else {
                                            $position=explode(',',$position);
                                            foreach ($position as $pos) {
                                                if($pos!="" && isset($galleryImages[$pos])){ unset($galleryImages[$pos]); }

                                                $photo=wp_get_attachment_url($pos);
                                                if($photo!=false){
                                                ?>
                                                <li id="file-<?php echo esc_html($pos); ?>" class="col span_4 first"><?php
                                                    echo '<figure class="gallery-thumb">';
                                                        echo '<span class="featured-img">';
                                                            echo '<a class="setImageFeatured" name="' . esc_html($pos) .'" href="#"><i class="fa '.( $pos == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
                                                        echo '</span>';
                                                        echo '<span class="delete-img">';
                                                            echo '<a class="remImage" name="' . esc_html($pos) .'" href="#"><i class="fa fa-trash-o"></i></a>';
                                                        echo '</span>';

                                                        echo '<img src="' . $photo . '" />';
                                                        echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($pos) . '" />';
                                                    echo '</figure>';
                                                echo '</li>';
                                                }
                                            }
                                            foreach ($galleryImages as $pos) {
                                            $photo=wp_get_attachment_url($pos);
                                            if($photo!=false){
                                            ?>
                                            <li id="file-<?php echo esc_html($pos); ?>" class="col span_4 first"><?php
                                                echo '<figure class="gallery-thumb">';
                                                    echo '<span class="featured-img">';
                                                        echo '<a class="setImageFeatured" name="' . esc_html($pos) .'" href="#"><i class="fa '.( $pos == $featured_id ? 'fa-star' : 'fa-star-o').'"></i></a>';
                                                    echo '</span>';
                                                    echo '<span class="delete-img">';
                                                        echo '<a class="remImage" name="' . esc_html($pos) .'" href="#"><i class="fa fa-trash-o"></i></a>';
                                                    echo '</span>';
                                                    echo '<img src="' . $photo . '" />';
                                                    echo '<input type="hidden" name="att_id[]" id="att_id" value="' . esc_html($pos) . '" />';
                                                echo '</figure>';
                                            echo '</li>';
                                            }
                                        }
                                    }
                                    
                                }
                                    echo '</ul>';
                                    echo '<div class="clear"></div>';
                                ?>
                            <div id="plupload-upload-ui" class="hide-if-no-js drag-drop"> <!-- RF --> 
                                <div class="drag-drop col span_12 first row">
                                    <div id="drag-drop-area" class="drag-drop-area">
                                        <div class="drag-drop-msg">
                                            <i class="fa fa-cloud-upload"></i><br />
                                            <strong><?php esc_html_e('Drag & Drop Images Here', 'contempo'); ?></strong>
                                        </div>
                                        <div class="drag-drop-or">
                                            <?php esc_html_e('or', 'contempo'); ?>
                                        </div>
                                        <div class="drag-drop-btn">
                                            <a id="select-images" class="btn" href="javascript:;"><?php esc_html_e('Select Images', 'contempo'); ?></a>
                                        </div>
                                    </div>
                                    <input style="display: none;" type="file" name="galleryImages" id="galleryImages" multiple="" />
                                    <p class="muted marT10 marB0"><?php esc_html_e('*At least one image is required for valid submission, minimum width of 817px.', 'contempo'); ?></p>
                                    <p class="muted marB0"><?php esc_html_e('*You can mark an image as featured by clicking the star icon, Otherwise first image will be considered featured image.', 'contempo'); ?></p>
                                    <div id="plupload-container"></div>
                                    <div id="errors-log"></div>
                                </div>
                            </div><!-- RF -->   
                            </div>
                        </div>

                    </fieldset>

                    <fieldset class="col span_10 first form-section">

                        <div class="col span_4 first">
                            <label><?php esc_html_e('Beds', 'contempo'); ?></label>
                            <input type="text" name="customTaxBeds" id="customTaxBeds" value="<?php echo esc_attr($ct_beds); ?>" <?php if($ct_front_submit_beds == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4">
                            <label><?php esc_html_e('Baths', 'contempo'); ?></label>
                            <input type="text" name="customTaxBaths" id="customTaxBaths" value="<?php echo esc_attr($ct_baths); ?>" <?php if($ct_front_submit_baths == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4">
                            <label><?php strtoupper(ct_sqftsqm()); ?></label>
                            <input type="text" name="customMetaSqFt" id="customMetaSqFt" value="<?php echo esc_attr($ct_sqft); ?>" <?php if($ct_front_submit_size == 'required') { echo 'required'; } ?> />
                        </div>

                         <div class="col span_6 first">
                            <label><?php esc_html_e('Property ID', 'contempo'); ?></label>
                            <input type="text" name="customMetaMLS" id="customMetaMLS" value="<?php echo esc_attr($ct_mls); ?>" <?php if($ct_front_submit_property_id == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_6">
                            <label><?php esc_html_e('Video URL', 'contempo'); ?></label>
                            <input type="text" name="customMetaVideoURL" id="customMetaVideoURL" value="<?php echo esc_attr($ct_video_url); ?>" <?php if($ct_front_submit_video_url == 'required') { echo 'required'; } ?> />
                        </div>

                            <div class="clear"></div>

                        <label><?php esc_html_e('Additional Features (comma separated)', 'contempo'); ?></label>
                        <textarea name="customTaxFeat" id="customTaxFeat" rows="8" cols="30" <?php if($ct_front_submit_additional_features == 'required') { echo 'required'; } ?>>
                            <?php echo esc_html($ct_features); ?>
                        </textarea>

                    </fieldset>

                    <?php

                    $ct_submit_rental_info = isset( $ct_options['ct_submit_rental_info'] ) ? esc_attr( $ct_options['ct_submit_rental_info'] ) : '';
                    $ct_rentals_booking = isset( $ct_options['ct_rentals_booking'] ) ? esc_html( $ct_options['ct_rentals_booking'] ) : '';
                    
                    if($ct_rentals_booking == 'yes' || class_exists('Booking_Calendar') && $ct_submit_rental_info == 'yes') { ?>

                        <fieldset class="col span_10 first form-section">

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Max-number of Guests', 'contempo'); ?></label>
                                <input type="text" name="customMetaMaxGuests" id="customMetaMaxGuests" value="<?php echo esc_html($ct_rental_guests); ?>" <?php if($ct_front_submit_max_guests == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Minimum Stay', 'contempo'); ?></label>
                                <input type="text" name="customMetaMinStay" id="customMetaMinStay" value="<?php echo esc_html($ct_rental_min_stay); ?>" <?php if($ct_front_submit_min_stay == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Check In Time', 'contempo'); ?></label>
                                <input type="text" name="customMetaCheckIn" id="customMetaCheckIn" value="<?php echo esc_html($ct_rental_checkin); ?>" <?php if($ct_front_submit_check_in == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Check Out Time', 'contempo'); ?></label>
                                <input type="text" name="customMetaCheckOut" id="customMetaCheckOut" value="<?php echo esc_html($ct_rental_checkout); ?>" <?php if($ct_front_submit_check_out == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Extra Person Charge', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" name="customMetaExtraPerson" id="customMetaExtraPerson" value="<?php echo esc_html($ct_rental_extra_people); ?>" <?php if($ct_front_submit_extra_person == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Cleaning Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" name="customMetaCleaningFee" id="customMetaCleaningFee" value="<?php echo esc_html($ct_rental_cleaning); ?>" <?php if($ct_front_submit_cleaning_fee == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                            <div class="col span_6 first">
                                <label><?php esc_html_e('Cancellation Fee', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" name="customMetaCancellationFee" id="customMetaCancellationFee" value="<?php echo esc_html($ct_rental_cancellation); ?>" <?php if($ct_front_submit_cancellation_fee == 'required') { echo 'required'; } ?> />
                            </div>

                            <div class="col span_6">
                                <label><?php esc_html_e('Security Deposit', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
                                <input type="text" name="customMetaSecurityDeposit" id="customMetaSecurityDeposit" value="<?php echo esc_html($ct_rental_deposit); ?>" <?php if($ct_front_submit_security_deposit == 'required') { echo 'required'; } ?> />
                            </div>

                                <div class="clear"></div>

                        </fieldset>

                    <?php } ?>

                    <fieldset class="col span_10 first form-section">

                        <script>
                            jQuery(document).ready(function() {
                                jQuery("#pac-input").trigger("geocode");
                            });
                        </script>

                        <div class="input-full-width">
                            <label><?php esc_html_e('Address', 'contempo'); ?></label>
                            <input type="text" name="pac-input" id="pac-input" value="<?php echo esc_html($title); ?> <?php echo esc_attr($ct_city); ?> <?php echo esc_attr($ct_state); ?> <?php echo esc_attr($ct_zip); ?> <?php if(!empty($ct_country)) { echo esc_attr($ct_country); } ?>" placeholder="<?php _e('Type in an address', 'contempo'); ?>" <?php if($ct_front_submit_address == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4 first">
                            <label><?php esc_html_e('City', 'contempo'); ?></label>
                            <input type="text" name="customTaxCity" id="customTaxCity" value="<?php echo esc_attr($ct_city); ?>" <?php if($ct_front_submit_city == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4">
                            <?php
                            global $ct_options;
                            $ct_state_or_area = isset( $ct_options['ct_state_or_area'] ) ? $ct_options['ct_state_or_area'] : '';

                            if($ct_state_or_area == 'area') { ?>
                                <label for="ct_state"><?php _e('Area', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'suburb') { ?>
                                <label for="ct_state"><?php _e('Suburb', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'province') { ?>
                                <label for="ct_state"><?php _e('Province', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'region') { ?>
                                <label for="ct_state"><?php _e('Region', 'contempo'); ?></label>
                            <?php } elseif($ct_state_or_area == 'parish') { ?>
                                <label for="ct_state"><?php _e('Parish', 'contempo'); ?></label>
                            <?php } else { ?>
                                <label for="ct_state"><?php _e('State', 'contempo'); ?></label>
                            <?php } ?>
                            <input type="text" name="customTaxState" id="customTaxState" value="<?php echo esc_attr($ct_state); ?>" <?php if($ct_front_submit_state == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_4">
                            <label><?php ct_zip_or_post(); ?></label>
                            <input type="text" name="customTaxZip" id="customTaxZip" value="<?php echo esc_attr($ct_zip); ?>" <?php if($ct_front_submit_zip_post == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_6 first">
                            <label><?php esc_html_e('Country', 'contempo'); ?></label>
                            <input type="text" name="customTaxCountry" id="customTaxCountry" value="<?php echo esc_attr($ct_country); ?>" <?php if($ct_front_submit_country == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_6">
                            <label><?php ct_community_neighborhood_or_district(); ?></label>
                            <input type="text" name="customTaxCommunity" id="customTaxCommunity" value="<?php echo esc_attr($ct_community); ?>" <?php if($ct_front_submit_community == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_12 first">
                            <input type="text" name="customMetaLatLng" id="customMetaLatLng"  placeholder="<?php esc_html_e('Latitude & Longitude (optional)', 'contempo'); ?>" value="<?php echo esc_attr($ct_latlng); ?>" <?php if($ct_front_submit_lat_long == 'required') { echo 'required'; } ?> />
                        </div>

                        <div class="col span_12 first">
                            <div id="map-canvas"></div>
                        </div>

                            <div class="clear"></div>

                        <p class="form-note"><?php _e('You can also manually drag the marker to the exact location of your listing if the automatic geolocation is off.', 'contempo'); ?></p>

                    </fieldset>

                    <fieldset class="col span_10 first form-section">

                        <label><?php esc_html_e('Private Notes', 'contempo'); ?></label>
                        <textarea name="customOwnerNotes" id="customOwnerNotes" rows="8" cols="30" placeholder="<?php _e('Write a private note about this listing, this textarea will not be displayed anywhere on the front end of the site.', 'contempo'); ?>" <?php if($ct_front_submit_private_notes == 'required') { echo 'required'; } ?> >
                            <?php
                                if (isset( $_POST['customOwnerNotes'])) {
                                    echo esc_html($ct_owner_notes);
                                }
                            ?>
                        </textarea>

                    </fieldset>

                    <div class="col span_12 first fieldset-buttons">
                        <div class="col span_9 first">
                            <a class="btn btn-cancel left" href="<?php echo get_page_link($user_listings); ?>" data-tooltip="<?php _e('Cancel', 'contempo'); ?>"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="col span_3">
                            <a name="next" class="next btn right" data-tooltip="<?php _e('Next', 'contempo'); ?>"><i class="fa fa-chevron-right"></i></a>
                            <?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>

                            <?php if(!empty($ct_listing_expiration)) { ?>
                            <input type="hidden" name="customMetaExpireListing" id="customMetaExpireListing" value="<?php echo esc_attr($ct_listing_expiration); ?>" />
                            <?php } ?>

                            <input type="hidden" name="submitted" id="submitted" value="true" />
                            <input type="submit" value="<?php esc_html_e('Update', 'contempo'); ?>" tabindex="5" id="submit" name="submit" class="btn right" onClick="javascript:jQuery('#primaryPostForm').parsley( 'validate' );" />
                            <a name="previous" class="previous btn right" data-tooltip="<?php _e('Previous', 'contempo'); ?>"><i class="fa fa-chevron-left"></i></a>
                        </button>
                    </div>

                </form>

            <?php } ?>
            
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'contempo' ) . '</span>', 'after' => '</div>' ) ); ?>
            
            <?php endwhile; endif; wp_reset_query(); ?>
            
                <div class="clear"></div>

        </article>
		
			<?php echo '<div class="clear"></div>';

echo '</div>';

get_footer(); ?>
