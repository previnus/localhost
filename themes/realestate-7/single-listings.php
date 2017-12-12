<?php
/**
 * Single Listings Template
 * Template Post Type: listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_single_listing_main_layout = isset( $ct_options['ct_single_listing_main_layout']['enabled'] ) ? $ct_options['ct_single_listing_main_layout']['enabled'] : '';

$ct_listing_single_layout = isset( $ct_options['ct_listing_single_layout'] ) ? esc_html( $ct_options['ct_listing_single_layout'] ) : '';
$ct_listing_single_content_layout = isset( $ct_options['ct_listing_single_content_layout'] ) ? esc_html( $ct_options['ct_listing_single_content_layout'] ) : '';
$ct_listing_tools = isset( $ct_options['ct_listing_tools'] ) ? esc_html( $ct_options['ct_listing_tools'] ) : '';
$ct_listings_login_register = isset( $ct_options['ct_listings_login_register'] ) ? esc_html( $ct_options['ct_listings_login_register'] ) : '';
$ct_single_listing_tools_layout = isset( $ct_options['ct_single_listing_tools_layout']['enabled'] ) ? $ct_options['ct_single_listing_tools_layout']['enabled'] : '';

get_header();
 
if (!empty($_GET['search-listings'])) {
    get_template_part('search-listings');
    return;
}

$cat = get_the_category();

do_action('before_single_listing_header');

// Header
echo '<header id="title-header"';
        if($ct_listing_single_layout == 'listings-two') { echo 'class="marB0"'; }
    echo '>';
    echo '<div class="container">';
        echo '<div class="left">';
            echo '<h5 class="marT0 marB0">';
                esc_html_e('Listings', 'contempo');
            echo '</h5>';
        echo '</div>';
        echo ct_breadcrumbs();
        echo '<div class="clear"></div>';
    echo '</div>';
echo '</header>';

// Listing Tools
if($ct_listing_tools == 'yes') {

    echo '<!-- Listing Tools -->';
    echo '<div id="tools">';
         echo '<ul class="social marB0">';

            if($ct_single_listing_tools_layout) {
                    
                foreach($ct_single_listing_tools_layout as $key => $value) {

                    switch($key) {

                        // Twitter
                        case 'listing_twitter' : ?>    

                             <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_facebook' : ?>    

                             <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_linkedin' : ?>    

                             <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
                        
                        <?php break; ?>

                        <?php case 'listing_google_plus' : ?>    

                             <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>

                        <?php break; ?>

                        <?php case 'listing_print' : ?>    

                             <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
                        
                        <?php break;

                    }
                }

            } else {

                /*-----------------------------------------------------------------------------------*/
                /* For Legacy Users */
                /*-----------------------------------------------------------------------------------*/

            ?>
           
                <li class="twitter"><a href="javascript:void(0);" onclick="popup('http://twitter.com/home/?status=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?> &mdash; <?php the_permalink(); ?>', 'twitter',500,260);"><i class="fa fa-twitter"></i></a></li>
                <li class="facebook"><a href="javascript:void(0);" onclick="popup('http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>', 'facebook',658,225);"><i class="fa fa-facebook"></i></a></li>
                <li class="linkedin"><a href="javascript:void(0);" onclick="popup('http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink() ?>&title=<?php esc_html_e('Check out this great listing on', 'contempo'); ?> <?php bloginfo('name'); ?> &mdash; <?php ct_listing_title(); ?>&summary=&source=<?php bloginfo('name'); ?>', 'linkedin',560,400);"><i class="fa fa-linkedin"></i></a></li>
                <li class="google"><a href="javascript:void(0);" onclick="popup('https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink(); ?>', 'google',500,275);"><i class="fa fa-google-plus"></i></a></a></li>
                <li class="print"><a class="print" href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
                <span id="tools-toggle"><a href="#"><span id="text-toggle"><?php esc_html_e('Close', 'contempo'); ?></span></a></span>
            
            <?php }
                   
        echo '</ul>';
    echo '</div>';
    echo '<!-- //Listing Tools -->';

} 

do_action('before_single_listing_content'); ?>

<!-- Lead Carousel -->
<?php

if($ct_listing_single_layout == 'listings-two') {

    $listingslides = get_post_meta($post->ID, "_ct_slider", true);

    if(!empty($listingslides)) {
        // Grab Slider custom field images
        $imgattachments = get_post_meta($post->ID, "_ct_slider", true);
    } else {
        // Grab images attached to post via Add Media
        $imgattachments = get_children(
        array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_parent' => $post->ID
        ));
    }
    ?>
    <figure id="lead-carousel" <?php if(count($imgattachments) <= 1) { ?>class="single-image"<?php } ?>>
        <?php
        if(count($imgattachments) > 1) { ?>
            <div id="lrg-carousel" class="owl-carousel">
                <?php if(!empty($listingslides)) {
                    ct_slider_field_images();
                } else {
                    ct_slider_images();
                } ?>
            </div>
        <?php } else { ?>
            <?php ct_property_type_icon(); ?>
            <?php ct_listing_actions(); ?>
            <?php ct_first_image_lrg(); ?>
        <?php } ?>
    </figure>
    <!-- //Lead Carousel -->
<?php } ?>

<?php

echo '<div class="container">';

        if ( have_posts() ) : while ( have_posts() ) : the_post(); ct_set_listing_views(get_the_ID()); ?>

        <article class="col <?php if($ct_listing_single_content_layout == 'full-width') { echo 'span_12'; } else { echo 'span_9'; } ?> marB60">

        <?php if(!is_user_logged_in() && $ct_listings_login_register == 'yes') {
        
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
        
        } else {

            if($ct_single_listing_main_layout) {
        
                    foreach($ct_single_listing_main_layout as $key => $value) {
                    
                        switch($key) {

                            // Header
                            case 'listing_header' :    

                                get_template_part('includes/single-listing-header');
                            
                            break;

                            // Price
                            case 'listing_price' :    

                                get_template_part('includes/single-listing-price');
                            
                            break;

                            // Prop Info
                            case 'listing_prop_info' :

                                get_template_part('includes/single-listing-propinfo');
                                
                            break;

                            // Lead Media
                            case 'listing_lead_media' :

                                get_template_part('includes/single-listing-lead-media');
                                
                            break;

                            // Page Builder Four
                            case 'listing_nav' :

                               get_template_part('includes/single-listing-sub-navigation');
                                
                            break;

                            // Content
                            case 'listing_content' :

                               get_template_part('includes/single-listing-content');
                                
                            break;

                            // Contact
                            case 'listing_contact' :

                               get_template_part('includes/single-listing-contact');
                                
                            break;

                            // Creation Date
                            case 'listing_creation_date':

                                ct_listing_creation_date();
                        
                            break;

                            // Brokerage
                            case 'listing_brokerage' :

                                get_template_part('includes/single-listing-brokerage');
                                
                            break;

                            // Sub Listings
                            case 'listing_sub_listings' :

                                get_template_part('includes/single-listing-sub-listings');
                                
                            break;
                        
                        }
                    }
                
                } else {

                    /*-----------------------------------------------------------------------------------*/
                    /* For Legacy Users */
                    /*-----------------------------------------------------------------------------------*/

                    get_template_part('includes/single-listing-header');

                    get_template_part('includes/single-listing-price');

                    get_template_part('includes/single-listing-propinfo');

                    get_template_part('includes/single-listing-lead-media');

                    get_template_part('includes/single-listing-sub-navigation');

                    get_template_part('includes/single-listing-content');

                    get_template_part('includes/single-listing-contact');

                    get_template_part('includes/single-listing-brokerage');

                    get_template_part('includes/single-listing-sub-listings');

                }

            } endwhile; endif; ?>
            
                    <div class="clear"></div>

        </article>

        <?php do_action('before_single_listing_sidebar'); ?>
        
        <?php if($ct_listing_single_content_layout != 'full-width') { ?>
            <div id="sidebar" class="col span_3">
                <div id="sidebar-inner">
                    <?php if (is_active_sidebar('listings-single-right')) {
                        dynamic_sidebar('listings-single-right');
                    } ?>
                </div>
            </div>
        <?php } ?>

        <?php do_action('after_single_listing_sidebar'); ?>

</div>

<?php get_footer(); ?>