<?php
/**
 * Single Listing Features
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

do_action('before_single_listing_featlist');
                
echo '<!-- Feature List -->';
$ct_additional_features = get_the_terms($post->ID, 'additional_features');
if($ct_additional_features) {
    echo '<div id="listing-features">';
        addfeatlist();
    echo '</div>';
}

echo '<div id="rform"><a href="javascript:void(0)" class="hg-abus-hide"><span class="glyphicon  glyphicon-remove"></span></a>';
echo do_shortcode( '[contact-form-7 id="348334" title="Abus"]' );
echo '</div>';
echo '<a href="javascript:void(0)" class="hg-abus-show">';
echo '<span class="glyphicon glyphicon-flash"></span> Signaler cette annonce</a>';
echo '<!-- //Feature List -->';
?>