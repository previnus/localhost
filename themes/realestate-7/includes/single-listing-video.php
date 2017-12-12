<?php
/**
 * Single Listing Video
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

 do_action('before_single_listing_video');
            
echo '<!-- Video -->';
$ct_video_url = get_post_meta($post->ID, "_ct_video", true);
$ct_embed_code = wp_oembed_get( $ct_video_url );
if($ct_video_url) {
   echo '<div id="listing-video" class="videoplayer marB20">';
        echo '<h4 class="border-bottom marB20">' . __('Video', 'contempo') . '</h4>';
        echo $ct_embed_code;
    echo '</div>';
}
echo '<!-- //Video -->';

?>