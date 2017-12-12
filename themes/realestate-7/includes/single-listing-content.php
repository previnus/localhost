<?php
/**
 * Single Listing Content
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_single_listing_content_layout_type = isset( $ct_options['ct_single_listing_content_layout_type'] ) ? $ct_options['ct_single_listing_content_layout_type'] : '';
$ct_single_listing_content_layout = isset( $ct_options['ct_single_listing_content_layout']['enabled'] ) ? $ct_options['ct_single_listing_content_layout']['enabled'] : '';

do_action('before_single_listing_content');
            
if($ct_single_listing_content_layout_type == 'tabbed') {
    echo '<div class="post-content inside">';
} else {
    echo '<div class="post-content">';
}

	if(!empty($ct_single_listing_content_layout)) {

	    foreach ($ct_single_listing_content_layout as $key => $value) {
	    
	        switch($key) {

    	        // Content
    	        case 'listing_content' :   

                    echo '<div id="listing-content">';
        				the_content();
                    echo '</div>';
    	    
    	        break;

                // Floorplans
                case 'listing_open_house' :

                    get_template_part('includes/single-listing-open-house');
                    
                break;

                // Floorplans
                case 'listing_floorplans' :

                    get_template_part('includes/single-listing-multi-floorplan');
                    
                break;

                // Rental Info
                case 'listing_rental_info' :

                   get_template_part('includes/single-listing-rental-info');
                    
                break;

    	        // Features
    	        case 'listing_features' :

    	           get_template_part('includes/single-listing-features');
    	            
    	        break;

                // Booking Calendar
                case 'listing_booking_calendar' :

                   get_template_part('includes/single-listing-booking-calendar');
                    
                break;

    	        // Attachments
    	        case 'listing_attachments' :

    	            get_template_part('includes/single-listing-attachments');
    	            
    	        break;

                // Video
                case 'listing_video' :

                    get_template_part('includes/single-listing-video');
                    
                break;

                // Virtual Tour
                case 'listing_virtual_tour' :

                    get_template_part('includes/single-listing-virtual-tour');
                    
                break;

                // Virtual Tour
                case 'listing_map' :

                    get_template_part('includes/single-listing-map');
                    
                break;

                // Yelp
                case 'listing_yelp' :

                    get_template_part('includes/single-listing-google-places');
                    
                break;

                // Reviews
                case 'listing_reviews' :

                    get_template_part('includes/single-listing-reviews');
                    
                break;
	        
	        }

	    }
	    
	} else {

        /*-----------------------------------------------------------------------------------*/
        /* For Legacy Users */
        /*-----------------------------------------------------------------------------------*/

        the_content();

        get_template_part('includes/single-listing-multi-floorplan');

        get_template_part('includes/single-listing-rental-info');

        get_template_part('includes/single-listing-features');

        get_template_part('includes/single-listing-booking-calendar');

        get_template_part('includes/single-listing-attachments');

        get_template_part('includes/single-listing-video');

        get_template_part('includes/single-listing-virtual-tour');

        get_template_part('includes/single-listing-map');

        get_template_part('includes/single-listing-yelp');

        get_template_part('includes/single-listing-reviews');

    }

echo '</div>';