<?php
/**
 * Single Listing Propinfo
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_propinfo');

echo '<!-- Listing Info -->';
echo '<ul class="propinfo marB0">';
    ct_propinfo();
    if(get_post_meta($post->ID, "_ct_mls", true)) {
        echo '<li class="row propid">';
            echo '<span class="muted left">';
                _e('Property ID', 'contempo');
            echo '</span>';
            echo '<span class="right">';
                 echo '#' . get_post_meta($post->ID, "_ct_mls", true);
            echo '</span>';
        echo '</li>';
    }
echo '</ul>';
echo '<!-- //Listing Info -->';

?>