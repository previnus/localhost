<?php
/**
 * Template Name: Favorite Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

get_header();

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

while ( have_posts() ) : the_post();

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

	<!-- Container -->
	<div class="container marT60 padB60">

        <?php if(is_user_logged_in()) {
            get_template_part('/includes/user-sidebar');
        } ?>

		<!-- Page Content -->
		<div class="content col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?>">
			<?php the_content(); ?>
                
            <?php endwhile; wp_reset_query(); ?>

            <?php
                  global $favorite_post_ids;
            if ( !empty($user) ) {
                if ( wpfp_is_user_favlist_public($user) )
                    $favorite_post_ids = wpfp_get_users_favorites($user);

            } else {
                $favorite_post_ids = wpfp_get_users_favorites();
            }

            $wpfp_before = "";
            
            echo "<div class='wpfp-span'>";
            
            if (!empty($user)) {
                if (wpfp_is_user_favlist_public($user)) {
                    $wpfp_before = "$user's Favorite Posts.";
                } else {
                    $wpfp_before = "$user's list is not public.";
                }
            }

            if ($wpfp_before):
                echo '<div class="wpfp-page-before">'.$wpfp_before.'</div>';
            endif; ?>

                <?php if(!empty($favorite_post_ids)) { ?>
                    <!-- Request More Info -->
                    <script>    
                        jQuery(document).ready(function() {
                            jQuery(".contact-form").validationEngine({
                                ajaxSubmit: true,
                                ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-favorites.php",
                                ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                                success :  false,
                                failure : function() {}
                            });
                            jQuery(".fav-contact").click(function() {
                                jQuery("#overlay.contact-modal").addClass('open');
                            });

                            jQuery(".close").click(function() {
                                jQuery("#overlay.contact-modal").removeClass('open');
                                jQuery(".formError").hide();
                            });
                        });
                    </script>

                    <?php 
                        echo '<div id="email-favorites" class="col span_12 first clr marB30"><a class="fav-contact btn" href="#">' . __('Request More Information on All Favorites', 'contempo') . '</a></div>';
                    ?>

                    <div id="overlay" class="contact-modal">
                        <div id="modal">
                            <div id="modal-inner">
                                <a href="#" class="close"><i class="fa fa-close"></i></a>
                                <form id="listingscontact" class="contact-form formular" method="post">
                                    <fieldset class="col span_12">
                                        <select id="ctsubject" name="ctsubject">
                                            <option><?php esc_html_e('Tell me more about a property', 'contempo'); ?></option>
                                            <option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
                                            <option><?php esc_html_e('General Questions', 'contempo'); ?></option>
                                        </select>
                                            <div class="clear"></div>
                                        <input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

                                        <input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

                                        <input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

                                        <textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

                                        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo $ct_options['ct_favorite_posts_contact_email'] ?>" />
                                        <input type="hidden" id="ctproperty" name="ctproperty" value="<?php ct_fav_listings_permalinks(); ?>" />

                                        <input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />
                                    </fieldset>
                                        <div class="clear"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- //Request More Info -->
                <?php } ?>

            <?php
            echo '<!-- Saved Listings -->';
            echo '<ul class="saved-listings">';
            if($favorite_post_ids) {

                $favorite_post_ids = array_reverse($favorite_post_ids);
                $post_per_page = wpfp_get_option("post_per_page");
                $page = intval(get_query_var('paged'));

                $args = array(
                    'post_type' => 'listings',
                    'post__in' => $favorite_post_ids,
                    'posts_per_page'=> $post_per_page,
                    'orderby' => 'post__in',
                    'paged' => $page
                );
                $wp_query = new WP_Query($args);

                while($wp_query->have_posts()) : $wp_query->the_post();

                $ct_property_type = strip_tags( get_the_term_list( $wp_query->post->ID, 'property_type', '', ', ', '' ) );
                $beds = strip_tags( get_the_term_list( $wp_query->post->ID, 'beds', '', ', ', '' ) );
                $baths = strip_tags( get_the_term_list( $wp_query->post->ID, 'baths', '', ', ', '' ) );

                ?>

                    <li class="fav-listing listing col span_12 first">

                        <figure class="col span_4 first">
                            <?php ct_status(); ?>
                            <?php ct_first_image_linked(); ?>
                        </figure>
                        <div class="col span_8 listing-info muted">
                            <h5 class="marT0 marB0"><?php ct_listing_title(); ?></h5>
                            <div class="location muted marB10"><?php city(); ?>, <?php state(); ?> <?php zipcode(); ?></div>
                            <p class="price marB10"><?php ct_listing_price(); ?></p>
                            <ul class="propinfo-list marB0">
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
                        </div>
                        <div class="col span_12 first listing-tools">
                            <div class="col span_12 first">
                                <ul class="edit-view-delete marT0 marB0 right">
                                    <li><a class="btn view-listing" href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i></a></li>
                                    <li><?php wpfp_remove_favorite_link(get_the_ID()); ?></li>
                                </ul>
                            </div>
                        </div>
                    </li>

                        <div class="clear"></div>

                <?php endwhile;

                echo '<div class="navigation">';
                    if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
                    <div class="alignleft"><?php next_posts_link( __( 'Previous Entries', 'contempo' ) ) ?></div>
                    <div class="alignright"><?php previous_posts_link( __( 'Next Entries', 'contempo' ) ) ?></div>
                    <?php }
                echo '</div>';

                wp_reset_query();
            } else {
                $wpfp_options = wpfp_get_options();
                echo '<li class="favorite-empty">';
                    echo '<h4>' . $wpfp_options['favorites_empty'] . '</h4>';
                echo '</li>';
            }
            echo "</ul>";
            echo '<!-- //Saved Listings -->';

            if ($favorite_post_ids) {
                echo '<p class="clear-saved">';
                        wpfp_clear_list_link();
                echo '</p>';
                echo "</div>";
            }
            wpfp_cookie_warning(); ?>
                
                    <div class="clear"></div>
		</div>
		<!-- //Page Content -->
	</div>
	<!-- //Container -->

<?php get_footer(); ?>