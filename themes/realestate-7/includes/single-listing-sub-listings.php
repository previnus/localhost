<?php
/**
 * Single Listing Sub Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_community');

$terms = $terms = get_the_terms( $post->id, 'community' );
if ($terms) {
    echo '<!-- Sub Listings -->';
    echo '<div class="marb20 sub-listings">';
         echo '<h4 class="border-bottom marB20">' . __('Other Listings in Community', 'contempo') . '</h4>';
         get_template_part('includes/sub-listings');
    echo '</div>';
    echo '<!-- //Sub Listings -->';
}

?>