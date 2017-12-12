<?php 
/**
 * Listings Loop
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_options;
global $paged;
$paged = ct_currentPage();

if ( ! $wp_query->have_posts() ) : ?>
		<div class="clear"></div>
	<?php if(is_author()) { ?>
		<p class="nomatches"><strong><?php esc_html_e( 'This agent currently has no active listings.', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Check back soon.', 'contempo' ); ?></p>
    <?php } elseif( 'brokerage' == get_post_type() ) { ?>
        <p class="nomatches"><strong><?php esc_html_e( 'This brokerage currently has no active listings.', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Check back soon.', 'contempo' ); ?></p>
	<?php } else { ?>
	    <p class="nomatches"><strong><?php esc_html_e( 'No properties were found which match your search criteria', 'contempo' ); ?></strong>.<br /><?php esc_html_e( 'Try broadening your search to find more results.', 'contempo' ); ?></p>
    <?php } ?>

<?php

	echo '<ul class="marB0">';

	elseif ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post();

        $author_id = get_the_author_meta('ID');
        $first_name = get_the_author_meta('first_name');
        $last_name = get_the_author_meta('last_name');
        $ct_property_type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
        $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
        $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

    ?>

    <li class="listing listing-list col span_12 first">

        <?php do_action('before_listing_list_img'); ?>

        <?php if(has_post_thumbnail()) { ?>
        <figure class="col span_4 first">
            <?php ct_status_featured(); ?>
            <?php ct_status(); ?>
            <?php ct_property_type_icon(); ?>
            <?php ct_listing_actions(); ?>
            <?php ct_first_image_linked(); ?>
        </figure>
        <?php } ?>

        <?php do_action('before_listing_list_info'); ?>

        <div class="list-listing-info col span_8 first">
            <div class="list-listing-info-inner">
                <header>
                    <?php do_action('before_listing_list_title'); ?>
                    <h4 class="marT0 marB0"><a <?php ct_listing_permalink(); ?>><?php ct_listing_title(); ?></a></h4>
                    <?php do_action('before_listing_grid_address'); ?>
                    <p class="location muted marB0"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?><?php country(); ?></p>
                </header>
                
                <?php do_action('before_listing_list_price'); ?>
                
                <p class="price marB10"><?php ct_listing_price(); ?></p>

                <?php do_action('before_listing_list_propinfo'); ?>
                
                <ul class="propinfo propinfo-list marB0 padT0">
                    <?php if($ct_property_type != 'commercial' || $ct_property_type != 'lot' || $ct_property_type != 'land') { 
                        if(!empty($beds)) {
                                echo '<li class="beds">';
                                    echo '<span class="muted left">';
                                        _e('Bed:', 'contempo');
                                    echo '</span>';
                                    echo '<span class="right">';
                                       echo $beds;
                                    echo '</span>';
                                echo '</li>';
                            }   
                            if(!empty($baths)) {
                                echo '<li class="baths">';
                                    echo '<span class="muted left">';
                                        _e('Baths:', 'contempo');
                                    echo '</span>';
                                    echo '<span class="right">';
                                       echo $baths;
                                    echo '</span>';
                                echo '</li>';
                        }
                    } ?>
                    <?php if(!empty($ct_property_type)) {
                        echo '<li class="property-type">';
                            echo '<span class="muted left">';
                                _e('Type:', 'contempo');
                            echo '</span>';
                            echo '<span class="right">';
                               echo $ct_property_type;
                            echo '</span>';
                        echo '</li>';
                    } ?>
                </ul>

                <div class="col span_12 first list-agent-info">
                    <?php
                    echo '<figure class="col span_1 first list-agent-image">';
                        echo '<a href="' . get_author_posts_url($author_id) . '">';
                           if(get_the_author_meta('ct_profile_url')) {  
                                echo '<img class="authorimg" src="';
                                    echo the_author_meta('ct_profile_url');
                                echo '" />';
                            } else {
                                echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                            }
                        echo '</a>';
                    echo '</figure>';
                    ?>
                    <div class="col span_5">
                            <p class="muted marB0"><small><?php _e('Agent', 'contempo'); ?></small></p>
                            <p class="marB0"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></p>
                        </div>
                    <div class="col span_4">
                        <?php ct_brokered_by(); ?>
                    </div>
                </div>
                    <div class="clear"></div>
            </div>
        </div>

        <?php do_action('after_listing_list_info'); ?>
	
    </li>
    
<?php

echo '<div class="clear"></div>';

endwhile; ?>

	</ul>

	<?php ct_numeric_pagination(); ?>

		<div class="clear"></div>

<?php endif; wp_reset_postdata(); ?>