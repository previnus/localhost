<?php
/**
 * Template Name: View Listings
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

if (session_status() == PHP_SESSION_NONE) { session_start(); } 

global $ct_options; 

$submit_listing = isset( $ct_options['ct_submit'] ) ? esc_html( $ct_options['ct_submit'] ) : '';
$ct_enable_front_end_paid = isset( $ct_options['ct_enable_front_end_paid'] ) ? esc_attr( $ct_options['ct_enable_front_end_paid'] ) : '';
$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);
$edit = $ct_options['ct_edit'];
$userID = get_current_user_id();

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
<?php }

endwhile; endif; ?>

<div class="container marT30">

    <?php if(is_user_logged_in()) {
        get_template_part('/includes/user-sidebar');
    } ?>

    <article class="col <?php if(is_user_logged_in()) { echo 'span_9'; } else { echo 'span_12 first'; } ?> marB60">

        <?php if(!is_user_logged_in()) {
                echo '<h4 class="center must-be-logged-in">' . __('You must be logged in to view this page.', 'contempo') . '</h4>';
            } else { ?>

            <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $query = new WP_Query(
            	array(
                	'post_type' => 'listings',
                	'author' => $userID,
                    'paged' => $paged,
                	'posts_per_page' => -1,
                	'post_status' => array('publish', 'pending')
            	)
            ); 
			
			?>

                <form id="my-listings-live-search" action="" method="post">
                    <fieldset>
                        <input type="text" class="text-input" id="my-listings-filter" value="" placeholder="<?php _e('Type a listing name or address here to filter the list.', 'contempo'); ?>" />
                    </fieldset>
                </form>

                <script>
                    jQuery(document).ready(function($){
                        $("#my-listings-filter").keyup(function(){

                            var filter = $(this).val(), count = 0;

                            $("#my-listings li.listing").each(function(){
                                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                    $(this).fadeOut();
                                } else {
                                    $(this).show();
                                    count++;
                                }
                            });
                            var numberItems = count;
                        });
                    });
                </script>
            	
            	<ul id="my-listings" class="marB0">

                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

                    $ct_listing_paid_transaction_id = get_post_meta($post->ID, "_ct_listing_paid_transaction_id", true);

                    $city = strip_tags( get_the_term_list( $query->post->ID, 'city', '', ', ', '' ) );
                    $state = strip_tags( get_the_term_list( $query->post->ID, 'state', '', ', ', '' ) );
                    $zipcode = strip_tags( get_the_term_list( $query->post->ID, 'zipcode', '', ', ', '' ) );
                    $country = strip_tags( get_the_term_list( $query->post->ID, 'country', '', ', ', '' ) );
                    $ct_property_type = strip_tags( get_the_term_list( $query->post->ID, 'property_type', '', ', ', '' ) );
                    $beds = strip_tags( get_the_term_list( $query->post->ID, 'beds', '', ', ', '' ) );
                    $baths = strip_tags( get_the_term_list( $query->post->ID, 'baths', '', ', ', '' ) );
                    ?>

                        <li class="listing col span_12 first">

                            <figure class="col span_4 first">
                                <?php ct_status(); ?>
                                <?php if (has_post_thumbnail()) {
    	                            ct_first_image_linked();
    	                        } else {
    	                        	echo '<img src="' . esc_url( get_stylesheet_directory_uri() ) . '/images/thumbnail-default.png" />';
    	                        } ?>
                            </figure>
                            <div class="col span_8 listing-info muted">
                                <h5 class="marT0 marB0"><?php ct_listing_title(); ?></h5>
                                <p class="location muted marB10"><?php echo esc_html($city); ?>, <?php echo esc_html($state); ?> <?php echo esc_html($zipcode); ?> <?php echo esc_html($country); ?></p>
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
                                <div class="marB0 listing-status <?php echo get_post_status( get_the_ID() ) ?>"><?php echo get_post_status( get_the_ID() ) ?></div>
                                <?php if(has_term( 'featured', 'ct_status')) { ?>
                                    <div class="marB0 listing-status featured"><?php echo _e('Featured', 'contempo'); ?></div>
                                <?php } ?>
                            </div>
                            <div class="col span_12 first listing-tools">
                                <?php if($ct_enable_front_end_paid == 'yes') { ?>
        	                        <?php if($ct_listing_paid_transaction_id == '') { ?>
        	                            <div class="col span_9 ct-paypal">
                                            <?php
                                                if(class_exists('PayPal_Listings')) {
                                                    echo PayPal_Listings::ct_paypal();
                                                }
                                            ?>
        	                            </div>
        	                        <?php } else { ?>
                                        <div class="col span_9">
                                            <div class="btn paid">
                                                <?php _e('Paid', 'contempo'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="col span_9">
                                        &nbsp;
                                    </div>
                                <?php } ?>
                                <?php
                                    $referrer = isset( $_POST['_wp_http_referer'] ) ? $_POST['_wp_http_referer'] : '';
                                ?>
    	                        <div class="col span_3">
    		                        <ul class="edit-view-delete marT0 marB0 right">
    		                        	<?php $edit_post = add_query_arg('listings', get_the_ID(), get_permalink($edit + $referrer)); ?>
    		                            <li><a class="btn edit-listing" href="<?php echo $edit_post; ?>" data-tooltip="<?php _e('Edit','contempo'); ?>"><i class="fa fa-edit"></i></a></li>
    									<li><a class="btn view-listing" href="<?php the_permalink(); ?>"data-tooltip="<?php _e('View','contempo'); ?>"><i class="fa fa-eye"></i></a></li>
    		                            <li><?php ct_delete_post_link('<i class="fa fa-trash-o"></i>', '', ''); ?></li>
    	                            </ul>
                                </div>
                            </div>
                        </li>

                    <?php endwhile; ?>
                    <?php ct_numeric_pagination(); ?>

                        <div class="clear"></div>

                    <?php else : ?>

                    <div class="col span_12 row no-listings">
                    	<h4 class="marB20"><?php esc_html_e('You don\'t have any listings yet...', 'contempo'); ?></h4>
                    	<p class="marB0"><a class="btn" href="<?php echo home_url(); ?>/?page_id=<?php echo esc_html($submit_listing); ?>"><?php esc_html_e('Create One', 'contempo'); ?></a></p>
                    </div>

                <?php endif; wp_reset_postdata(); ?>

                </ul>
        
            <div class="clear"></div>
            
        <?php } ?>

    </article>
	
		<div class="clear"></div>

</div>

<?php get_footer(); ?>