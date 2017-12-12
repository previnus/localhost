<?php
/**
 * Post Social
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_single_listing_header_layout = isset( $ct_options['ct_single_listing_header_layout']['enabled'] ) ? $ct_options['ct_single_listing_header_layout']['enabled'] : '';

echo '<!-- FPO Site name -->';
echo '<h4 id="sitename-for-print-only">';
    bloginfo('name');
echo '</h4>';

do_action('before_single_listing_location');

echo '<!-- Location -->';
echo '<header class="listing-location">';

    if ($ct_single_listing_header_layout) {

        foreach ($ct_single_listing_header_layout as $key => $value) {
        
            switch($key) {

            // Status
            case 'listing_status' :   

                echo '<div class="snipe-wrap">';
                    if(class_exists('CoAuthors_Plus')) {
                        if ( 2 == count( get_coauthors( get_the_id() ) ) ) {
                            echo '<h6 class="snipe co-listing"><span>' . __('Co-listing', 'contempo') . '</span></h6>';
                        }
                    }
                    ct_status_featured();
                    ct_status();
                    echo '<div class="clear"></div>';
                echo '</div>';
        
            break;

            // Title
            case 'listing_title' :

               echo '<h2 class="marT5 marB0">';
                    ct_listing_title();
                echo '</h2>';
                
            break;

            // City, State, Zip/Postcode
            case 'listing_city_state_zip' :

                echo '<p class="location marB0">';
                    city();
                    echo ', ';
                    state();
                    echo ' ';
                    zipcode();
                    echo ' ';
                    country();
                echo '</p>';
                
            break;
            
            }

        }
        
    } else {

        echo '<div class="snipe-wrap">';
            if(class_exists('CoAuthors_Plus')) {
                if ( 2 == count( get_coauthors( get_the_id() ) ) ) {
                    echo '<h6 class="snipe co-listing"><span>' . __('Co-listing', 'contempo') . '</span></h6>';
                }
            }
            ct_status();
            echo '<div class="clear"></div>';
        echo '</div>';
        echo '<h2 class="marT5 marB0">';
            ct_listing_title();
        echo '</h2>';
        echo '<p class="location marB0">';
            city() . ', ' . state() . ' ' . zipcode() . ' ' . country();
        echo '</p>';

    }
        
echo '</header>';
echo '<!--//Location -->';