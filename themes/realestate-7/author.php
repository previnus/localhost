<?php
/**
 * Author/Agent Template
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */
 
global $ct_options;

$ct_agent_single_listings = isset( $ct_options['ct_agent_single_listings'] ) ? esc_attr( $ct_options['ct_agent_single_listings'] ) : '';

if(isset($_GET['author_name'])) :
	$curauth = get_user_by('slug', $author_name);
else :
	$curauth = get_userdata(intval($author));
endif;

$author_page_url = $curauth->user_url;
$profile_img = $curauth->ct_profile_url;
$brokerage_id = $curauth->brokeragename;

get_header();

do_action('before_agent_header');

echo '<!-- Page Header -->';
echo '<header id="title-header">';
	echo '<div class="container">';
		echo '<div class="left">';
			echo '<h5 class="marT0 marB0">';
				esc_html_e('Agent', 'contempo');
			echo '</h5>';
		echo '</div>';
		echo ct_breadcrumbs();
		echo '<div class="clear"></div>';
	echo '</div>';
echo '</header>';
echo '<!-- //Page Header -->';

?>

<?php do_action('before_agent_content'); ?>

	<div class="agent-single container marT30 padB60">

		<?php if($curauth->user_email) {
			$email = $curauth->user_email; ?>

			<script>    
                jQuery(document).ready(function() {
                    jQuery("#listingscontact").validationEngine({
                        ajaxSubmit: true,
                        ajaxSubmitFile: "<?php echo get_template_directory_uri(); ?>/includes/ajax-submit-agent.php",
                        ajaxSubmitMessage: "<?php $contact_success = str_replace(array("\r\n", "\r", "\n"), " ", $ct_options['ct_contact_success']); echo esc_html($contact_success); ?>",
                        success :  false,
                        failure : function() {}
                    });
                });
            </script>

			<!-- Agent Contact Modal -->
	        <div id="overlay" class="contact-modal">
			    <div id="modal">
			    	<div id="modal-inner">
				        <a href="#" class="close"><i class="fa fa-close"></i></a>
			            <form id="listingscontact" class="formular" method="post">
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

	    						<input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($email) ?>" />
	    						<input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
	    						<input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

	    						<input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
	    					</fieldset>
	    						<div class="clear"></div>
	    				</form>
			        </div>
			    </div>
			</div>
	        <!-- //Agent Contact Modal -->
	    <?php } ?>

		<div class="col span_12 first">

			<!-- Agent -->
			<div class="agent marT20 marB40">

	                <figure class="col span_3 first">
	                	<?php if($curauth->ct_profile_url) { ?>
		                    <img class="author-img" src="<?php echo esc_html($curauth->ct_profile_url); ?>" />
	                    <?php } else { ?>
		                    <img class="author-img" src="<?php echo get_template_directory_uri() . '/images/user-default.png'; ?>" />
	                    <?php } ?>
	                </figure>

	             <div class="agent-info col span_9">
	                <h3><?php echo esc_html($curauth->display_name); ?></h3>
	                <?php if ($curauth->title) { ?><h5 class="muted position"><?php echo esc_html($curauth->title); ?></h5><?php } ?>

	                <div class="agent-bio col span_8 first">
	                	<p><?php if($curauth->tagline) { ?><strong class="tagline"><?php echo esc_html($curauth->tagline); ?></strong> <?php } ?><?php $bio = $curauth->description; echo nl2br($bio); ?></p>
	                	<ul class="social marT20 marL0">
                            <?php if ($curauth->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($curauth->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                            <?php if ($curauth->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                            <?php if ($curauth->instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($curauth->instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                            <?php if ($curauth->linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($curauth->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                            <?php if ($curauth->gplus) { ?><li class="google"><a href="<?php echo esc_url($curauth->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                            <?php if ($curauth->youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($curauth->youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                        </ul>
	                </div>

	                <?php if($brokerage_id != '') { ?>
	                	<figure class="col span_4 first broker-logo">
			                <?php ct_brokerage_logo($brokerage_id); ?>
		                </figure>
	                <?php } elseif($curauth->ct_broker_logo) { ?>
						<figure class="col span_4 first broker-logo">
						    <img src="<?php echo esc_html($curauth->ct_broker_logo); ?>" />
						</figure>
					<?php } elseif($curauth->brokerage) { ?>
						<div class="col span_4 first broker-logo">
						    <h6><?php echo esc_html($curauth->brokerage); ?></h6>
						</div>
					<?php } ?>

	                 <ul class="col span_4">
		                <?php if($curauth->mobile) { ?><li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($curauth->mobile); ?></span></span></li><?php } ?>
		                <?php if($curauth->office) { ?><li class="row"><span class="muted left"><i class="fa fa-building"></i></span> <span class="right"><?php echo esc_html($curauth->office); ?></span></li><?php } ?>
		                <?php if($curauth->fax) { ?><li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($curauth->fax); ?></span></li><?php } ?>
		                <?php if($curauth->user_email) { $email = $curauth->user_email; ?><li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a class="agent-contact" href="#"><?php esc_html_e('Email', 'contempo'); ?></a
		                ></span></li><?php } ?>
		                <?php if($curauth->user_url) {
		                	$ct_user_url = $curauth->user_url;
		                	$ct_user_url = trim($ct_user_url, '/');
		                	// If scheme not included, prepend it
							if (!preg_match('#^http(s)?://#', $ct_user_url)) {
							    $ct_user_url = 'http://' . $ct_user_url;
							}

							$ct_urlParts = parse_url($ct_user_url);

							// remove www
							$ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
		                ?>
		                	<li class="row"><span class="muted left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($curauth->user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
		                	<?php if($curauth->agentlicense) { ?><li class="row"><span class="muted left">Agent #</span> <span class="right"><?php echo esc_html($curauth->agentlicense); ?></span></li><?php } ?>
		                	<?php if($curauth->brokeragelicense) { ?><li class="row"><span class="muted left">Brokerage #</span> <span class="right"><?php echo esc_html($curauth->brokeragelicense); ?></span></li><?php } ?>
		                <?php } ?>
	            	</ul>
	            </div>
	        </div>
	        <!-- //Agent -->
            
		        <div class="clear"></div>
		        
		    <?php
		    if($curauth->userTestimonial != '') {
		    	echo '<div id="agent-testimonials" class="marB20">';
		    		echo '<div class="inner-content">';
	                	echo stripslashes($curauth->userTestimonial);
	                echo '</div>';
		    	echo '</div>';
		    } ?>

	        <?php do_action('before_agent_listings'); ?>

			<!-- Listings -->
			<?php
				if($ct_agent_single_listings != 'yes') {
	                $ID = $curauth->ID;
	                $args = array(
	                    'post_type' => 'listings',
						'posts_per_page' => -1,
						'tax_query' => array(
							array(
							    'taxonomy'  => 'ct_status',
							    'field'     => 'slug',
							    'terms'     => 'ghost',
							    'operator'  => 'NOT IN'
						    ),
					    ),
	                    'author' => $ID
	                );
					query_posts($args); ?>

					<form id="agent-listing-live-search" action="" method="post">
			            <fieldset>
			                <input type="text" class="text-input" id="agent-listing-filter" value="" placeholder="<?php _e('Type a listing address or keyword to filter the list.', 'contempo'); ?>" />
			            </fieldset>
			        </form>

			        <script>
			            jQuery(document).ready(function($){
			                $("#agent-listing-filter").keyup(function(){

			                    var filter = $(this).val(), count = 0;

			                    $(".agent-listings li.listing").each(function(){
			                        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
			                            $(this).fadeOut();
			                        } else {
			                            $(this).show();
			                            count++;
			                        }
			                    });
			                    $(".agent-listings div.clear" ).remove();
			                    $(".agent-listings li.listing" ).removeClass("first");
			                    $(".agent-listings li.listing:nth-child(3)").addClass("first");
			                    //$(".agent-listings li.listing:nth-child(3)").after("<div class='clear'></div>");
			                    var numberItems = count;
			                });
			            });
			        </script>

					<?php

					echo '<ul class="agent-listings marB0">';

						get_template_part( 'layouts/grid');

					echo '</ul>';
				}
            ?>
            <!-- //Listings -->

            <?php do_action('after_agent_listings'); ?>

		</div>
		
		<div class="clear"></div>
        
</div>

<?php get_footer(); ?>