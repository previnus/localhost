<?php
/**
 * Single Listing Content
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_single_listing_agent_details_layout = isset( $ct_options['ct_single_listing_agent_details_layout']['enabled'] ) ? $ct_options['ct_single_listing_agent_details_layout']['enabled'] : '';

$ct_listing_contact_form_7 = isset( $ct_options['ct_listing_contact_form_7'] ) ? esc_html( $ct_options['ct_listing_contact_form_7'] ) : '';
$ct_listing_contact_form_7_shortcode = isset( $ct_options['ct_listing_contact_form_7_shortcode'] ) ? $ct_options['ct_listing_contact_form_7_shortcode'] : '';

$first_name = get_the_author_meta('first_name');
$last_name = get_the_author_meta('last_name');
$author_id = get_the_author_meta('ID');
$tagline = get_the_author_meta('tagline');
$mobile = get_the_author_meta('mobile');
$office = get_the_author_meta('office');
$fax = get_the_author_meta('fax');
$email = get_the_author_meta('email');
$ct_user_url = get_the_author_meta('user_url');
$twitterhandle = get_the_author_meta('twitterhandle');
$facebookurl = get_the_author_meta('facebookurl');
$instagramurl = get_the_author_meta('instagramurl');
$linkedinurl = get_the_author_meta('linkedinurl');
$gplus = get_the_author_meta('gplus');
$youtubeurl = get_the_author_meta('youtubeurl');

?>

<?php do_action('before_single_listing_agent'); ?>

<!-- Agent Contact -->
<div id="listing-contact" class="marb20 listing-agent-contact">
    <div class="main-agent">

        <?php if($ct_single_listing_agent_details_layout) {

            echo '<div class="col span_4 first agent-info">';
                            
                foreach($ct_single_listing_agent_details_layout as $key => $value) {

                    switch($key) {

                        // Twitter
                        case 'listing_agent_name' : ?>    

                             <h4 class="border-bottom marB20"><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h4>
                        
                        <?php break; ?>

                        <?php case 'listing_agent_image' : ?>    

                            <?php
                            echo '<figure class="col span_12 first row">';
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
                        
                        <?php break; ?>

                        <?php case 'listing_agent_info' : ?>    

                            <?php do_action('before_single_listing_agent_details'); ?>

                             <ul class="marB0">
                                <?php if($mobile) { ?>
                                    <li class="marT3 marB0 row"><span class="left"><i class="fa fa-phone"></i></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
                                <?php } ?>
                                <?php if($office) { ?>
                                    <li class="marT3 marB0 row"><span class="left"><i class="fa fa-building"></i></span><span class="right"><?php echo esc_html($office); ?></span></li>
                                <?php } ?>
                                <?php if($fax) { ?>
                                    <li class="marT3 marB0 row"><span class="left"><i class="fa fa-print"></i></span><span class="right"><?php echo esc_html($fax); ?></span></li>
                                <?php } ?>
                                <?php if($email) { ?>
                                    <li class="marT3 marB0 row"><span class="left"><i class="fa fa-envelope"></i></span><span class="right"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
                                <?php } ?>
                                <?php if($ct_user_url) {
                                    $ct_user_url = trim($ct_user_url, '/');
                                    // If scheme not included, prepend it
                                    if (!preg_match('#^http(s)?://#', $ct_user_url)) {
                                        $ct_user_url = 'http://' . $ct_user_url;
                                    }

                                    $ct_urlParts = parse_url($ct_user_url);

                                    // remove www
                                    $ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
                                ?>
                                    <li class="row"><span class="left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($ct_user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
                                <?php } ?>
                            </ul>
                        
                        <?php break; ?>

                        <?php case 'listing_agent_social' : ?>    

                            <ul class="social marT15 marL0">
                                <?php if ($twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                <?php if ($instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                                <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                <?php if ($gplus) { ?><li class="google"><a href="<?php echo esc_url($gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                <?php if ($youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                            </ul>

                        <?php break;

                    }
                }

            echo '</div>';



            } else {

                /*-----------------------------------------------------------------------------------*/
                /* For Legacy Users */
                /*-----------------------------------------------------------------------------------*/
            ?>

                <h4 class="border-bottom marB20"><a href="<?php echo esc_url(home_url()); ?>/?author=<?php echo esc_html($author_id); ?>"><?php echo esc_html($first_name); ?> <?php echo esc_html($last_name); ?></a></h4>

                <?php do_action('before_single_listing_agent_img'); ?>

                <div class="col span_4 first agent-info">
                    <?php
                    echo '<figure class="col span_12 first row">';
                        echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($author_id) . '">';
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

                    <?php do_action('before_single_listing_agent_details'); ?>

                    <div class="details col span_12 first row">         
                        <ul class="marB0">
                            <?php if($mobile) { ?>
                                <li class="marT3 marB0 row"><span class="left"><i class="fa fa-phone"></i></span><span class="right"><?php echo esc_html($mobile); ?></span></li>
                            <?php } ?>
                            <?php if($office) { ?>
                                <li class="marT3 marB0 row"><span class="left"><i class="fa fa-building"></i></span><span class="right"><?php echo esc_html($office); ?></span></li>
                            <?php } ?>
                            <?php if($fax) { ?>
                                <li class="marT3 marB0 row"><span class="left"><i class="fa fa-print"></i></span><span class="right"><?php echo esc_html($fax); ?></span></li>
                            <?php } ?>
                            <?php if($email) { ?>
                                <li class="marT3 marB0 row"><span class="left"><i class="fa fa-envelope"></i></span><span class="right"><a href="mailto:<?php echo antispambot($email,1) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
                            <?php } ?>
                            <?php if($ct_user_url) {
                                $ct_user_url = trim($ct_user_url, '/');
                                // If scheme not included, prepend it
                                if (!preg_match('#^http(s)?://#', $ct_user_url)) {
                                    $ct_user_url = 'http://' . $ct_user_url;
                                }

                                $ct_urlParts = parse_url($ct_user_url);

                                // remove www
                                $ct_domain = preg_replace('/^www\./', '', $ct_urlParts['host']);
                            ?>
                                <li class="row"><span class="left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($ct_user_url); ?>"><?php echo esc_html($ct_domain); ?></a></span></li>
                            <?php } ?>
                        </ul>
                        <ul class="social marT15 marL0">
                            <?php if ($twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_html($twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                            <?php if ($facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                            <?php if ($instagramurl) { ?><li class="instagram"><a href="<?php echo esc_url($instagramurl); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php } ?>
                            <?php if ($linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                            <?php if ($gplus) { ?><li class="google"><a href="<?php echo esc_url($gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                            <?php if ($youtubeurl) { ?><li class="youtube"><a href="<?php echo esc_url($youtubeurl); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php } ?>
                        </ul>
                    </div>
                </div>

            <?php } ?>

            <?php do_action('before_single_listing_agent_contact'); ?>
            
            <div class="col span_8 agent-contact">
                <h4 class="border-bottom marB20"><?php esc_html_e('Request More Information', 'contempo'); ?></h4>
                
                <?php if($ct_listing_contact_form_7 == 'yes' && $ct_listing_contact_form_7_shortcode != '') { ?>
                
                    <?php echo do_shortcode($ct_listing_contact_form_7_shortcode); ?>
                
                <?php } else { ?>
                
                    	 <form id="listingscontact" class="formular" method="post">
            				<fieldset class="col span_12">
            					<select id="ctsubject" name="ctsubject">
            						<option><?php esc_html_e('Tell me more about this property', 'contempo'); ?></option>
            						<option><?php esc_html_e('Request a showing', 'contempo'); ?></option>
            					</select>
            						<div class="clear"></div>
            					<input type="text" name="name" id="name" class="validate[required] text-input" placeholder="<?php esc_html_e('Name', 'contempo'); ?>" />

            					<input type="text" name="email" id="email" class="validate[required,custom[email]] text-input" placeholder="<?php esc_html_e('Email', 'contempo'); ?>" />

            					<input type="text" name="ctphone" id="ctphone" class="text-input" placeholder="<?php esc_html_e('Phone', 'contempo'); ?>" />

            					<textarea class="validate[required,length[2,1000]] text-input" name="message" id="message" rows="6" cols="10"></textarea>

            					<input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php the_author_meta('user_email'); ?>" />
            					<input type="hidden" id="ctproperty" name="ctproperty" value="<?php the_title(); ?>, <?php city(); ?>, <?php state(); ?> <?php zipcode(); ?>" />
            					<input type="hidden" id="ctpermalink" name="ctpermalink" value="<?php the_permalink(); ?>" />

            					<input type="submit" name="Submit" value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn" />  
            				</fieldset>
            			</form>

                <?php } ?>

            </div>
        </div>
                <div class="clear"></div>

        <?php
        if(class_exists('CoAuthors_Plus')) {
            if (count( get_coauthors(get_the_id())) >= 2) { ?>
            <!-- Co Agent -->
            <div class="co-list-agent col span_12 first marB20">
                <h5 class="border-bottom marB20"><?php esc_html_e('Co-listing Agent', 'contempo'); ?></h5>
                <?php

                    $coauthors = get_coauthors();

                    // Remove the first author/agent
                    array_shift($coauthors);

                    echo '<ul id="co-agent" class="marB0">';
                        foreach($coauthors as $coauthor) {
                            echo '<li class="agent">';
                                echo '<figure class="col span_3 first">';
                                    echo '<a href="' . esc_url(home_url()) . '/?author=' . esc_html($coauthor->ID) . '" title="' . esc_html($coauthor->display_name) .'">';
                                    if($coauthor->ct_profile_url) {
                                        echo '<img class="author-img" src="' . esc_html($coauthor->ct_profile_url) . '" />';
                                    } else {
                                         echo '<img class="author-img" src="' . get_template_directory_uri() . '/images/user-default.png' . '" />';
                                    }
                                    echo '</a>';
                                echo '</figure>';
                                echo '<div class="agent-info col span_9">';
                                    echo '<h4 class="marT0 marB0">' . esc_html($coauthor->display_name) . '</h4>';
                                    if ($coauthor->title) { 
                                        echo '<h5 class="muted marB10">' . esc_html($coauthor->title) . '</h5>';
                                    } ?>
                                    <div class="agent-bio col span_8 first">
                                       <?php if($coauthor->tagline) { ?>
                                           <p class="tagline"><strong><?php echo esc_html($coauthor->tagline); ?></strong></p>
                                       <?php } ?>
                                       <ul class="col span_8 marT15 first">
                                            <?php if($coauthor->mobile) { ?>
                                                <li class="row"><span class="muted left"><i class="fa fa-phone"></i></span> <span class="right"><?php echo esc_html($coauthor->mobile); ?></span></span></li>
                                            <?php } ?>
                                            <?php if($coauthor->office) { ?>
                                                <li class="row"><span class="muted left"><i class="fa fa-building"></i></span> <span class="right"><?php echo esc_html($coauthor->office); ?></span></li>
                                            <?php } ?>
                                            <?php if($coauthor->fax) { ?>
                                                <li class="row"><span class="muted left"><i class="fa fa-print"></i></span> <span class="right"><?php echo esc_html($coauthor->fax); ?></span></li>
                                            <?php } ?>
                                            <?php if($coauthor->user_email) { $email = $coauthor->user_email; ?>
                                                <li class="row"><span class="muted left"><i class="fa fa-envelope"></i></span> <span class="right"><a href="mailto:<?php echo antispambot($email,1 ) ?>"><?php esc_html_e('Email', 'contempo'); ?></a></span></li>
                                            <?php } ?>
                                            <?php if($coauthor->user_url) {
                                                $ct_coauthor_url = $coauthor->user_url;
                                                $ct_coauthor_url = trim($ct_coauthor_url, '/');
                                                // If scheme not included, prepend it
                                                if (!preg_match('#^http(s)?://#', $ct_coauthor_url)) {
                                                    $ct_coauthor_url = 'http://' . $ct_coauthor_url;
                                                }

                                                $ct_coauthor_urlParts = parse_url($ct_coauthor_url);

                                                // remove www
                                                $ct_coauthor_domain = preg_replace('/^www\./', '', $ct_coauthor_urlParts['host']);
                                            ?>
                                                <li class="row"><span class="left"><i class="fa fa-globe"></i></span> <span class="right"><a href="<?php echo esc_html($coauthor->user_url); ?>"><?php echo esc_html($ct_coauthor_domain); ?></a></span></li>
                                            <?php } ?>
                                            <?php if($coauthor->brokername) { ?><p class="marB3"><strong><?php echo esc_html($coauthor->brokername); ?></strong></p><?php } ?>
                                            <?php if($coauthor->brokernum) { ?><p class="marB3"><?php echo esc_html($coauthor->brokernum); ?></p><?php } ?>
                                        </ul>
                                        
                                    </div>
                                    <ul class="social">
                                        <?php if ($coauthor->twitterhandle) { ?><li class="twitter"><a href="http://twitter.com/#!/<?php echo esc_url($coauthor->twitterhandle); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php } ?>
                                        <?php if ($coauthor->facebookurl) { ?><li class="facebook"><a href="<?php echo esc_url($coauthor->facebookurl); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php } ?>
                                        <?php if ($coauthor->linkedinurl) { ?><li class="facebook"><a href="<?php echo esc_url($coauthor->linkedinurl); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php } ?>
                                        <?php if ($coauthor->gplus) { ?><li class="google"><a href="<?php echo esc_url($coauthor->gplus); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php } ?>
                                    </ul>
                                </div>
                           <?php  echo '</li>';
                        }
                    echo '</ul>';
                ?>
            </div>
                <div class="clear"></div>
            <!-- //Co Agent -->
            <?php }
        } ?>

</div>
<!-- //Agent Contact -->