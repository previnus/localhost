<?php
/**
 * Header Advanced Search
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */
 
global $ct_options;

$ct_header_adv_search_fields = isset( $ct_options['ct_header_adv_search_fields']['enabled'] ) ? $ct_options['ct_header_adv_search_fields']['enabled'] : '';
$ct_home_adv_search_fields = isset( $ct_options['ct_home_adv_search_fields']['enabled'] ) ? $ct_options['ct_home_adv_search_fields']['enabled'] : '';
?>

<!-- Header Search -->
<div id="header-search-wrap">
	<div class="container">
        <form id="advanced_search" class="col span_12 first header-search" name="search-listings" action="<?php echo home_url(); ?>">

        	<?php

        		if ($ct_header_adv_search_fields) {
			    
			    foreach ($ct_header_adv_search_fields as $field=>$value) {
			    
			        switch($field) {
						
					// Type            
			        case 'header_type' : ?>
			            <div class="col span_2">
			                <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
			                <?php ct_search_form_select('property_type'); ?>
			            </div>
			        <?php
					break;
					
					// City
					case 'header_city' : ?>
					<div class="col span_2">
						<label for="ct_city"><?php _e('City', 'contempo'); ?></label>
						<?php ct_search_form_select('city'); ?>
					</div>
			        <?php
					break;
					
			        // State            
			        case 'header_state' : ?>
			            <div class="col span_2">
							<?php ct_search_form_select('state'); ?>
			            </div>
			        <?php
					break;

					// Zipcode            
			        case 'header_zipcode' : ?>
			            <div class="col span_2">
							<?php ct_search_form_select('zipcode'); ?>
			            </div>
			        <?php
					break;

			        // Country            
			        case 'header_country' : ?>
			            <div class="col span_2">
			                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
			                <?php ct_search_form_select('country'); ?>
			            </div>
			        <?php
			        break;

			        // Community            
			        case 'header_type' : ?>
			            <div class="col span_2">
			                <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
			                <?php ct_search_form_select('community'); ?>
			            </div>
			        <?php
			        break;
					
					// Beds            
			        case 'header_beds' : ?>
			            <div class="col span_2">
			                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
							<?php ct_search_form_select('beds'); ?>
			            </div>
			        <?php
					break;
					
					// Baths            
			        case 'header_baths' : ?>
			            <div class="col span_2">
			                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
							<?php ct_search_form_select('baths'); ?>
			            </div>
			        <?php
					break;
					
					// Status            
			        case 'header_status' : ?>
			            <div class="col span_2">
			                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
							<?php ct_search_form_select('ct_status'); ?>
			            </div>
			        <?php
					break;

			        // Community          
			        case 'header_community' : ?>
			            <div class="col span_2">
			                <?php
			                global $ct_options;
			                $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

			                if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
			                    <label for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
			                <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
			                    <label for="ct_community"><?php _e('District', 'contempo'); ?></label>
			                <?php } else { ?>
			                    <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
			                <?php } ?>
			                <?php ct_search_form_select('community'); ?>
			            </div>
			        <?php
			        break;
					
					// Price From            
			        case 'header_price_from' : ?>
			            <div class="col span_2">
			                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			        <?php
					break;
					
					// Price To            
			        case 'header_price_to' : ?>
			            <div class="col span_2">
			                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			        <?php
					break;

			        // Sq Ft From            
			        case 'header_sqft_from' : ?>
			            <div class="col span_3">
			                <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
			                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
			        
			        // Sq Ft To            
			        case 'header_sqft_to' : ?>
			            <div class="col span_2">
			                <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
			                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;

			        // Lot Size From            
			        case 'header_lotsize_from' : ?>
			            <div class="col span_2">
			                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
			        
			        // Lot Size To            
			        case 'header_lotsize_to' : ?>
			            <div class="col span_2">
			                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
					
					// MLS            
			        case 'header_mls' : ?>
			            <div class="col span_2">
			                <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
			                <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
			            </div>
			        <?php
					break;

			        // Number of Guests            
			        case 'header_numguests' : ?>
			            <div class="col span_2">
			                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
			                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
			            </div>
			        <?php
			        break;

			        // Keyword           
			        case 'header_keyword' : ?>
			            <div class="col span_3">
			            	<div id="keyword-wrap">
			            		<i class="fa fa-search"></i>
				                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
				                <input type="text" id="ct_keyword" class="number" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Street address or keyword', 'contempo'); ?>" />
			                </div>
			            </div>
			        <?php
			        break;

			        }
			    
			    } ?>

			    <?php
			        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			        if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {

			            $lang =  ICL_LANGUAGE_CODE;

			            echo '<input type="hidden" name="lang" value="' . $lang . '" />';
			        }
			    ?>

			    <input type="hidden" name="search-listings" value="true" />

	            <div class="col span_3">
		            <input id="submit" class="btn left" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />
		            <span id="more-search-options-toggle" class="btn right"><i class="fa fa-plus-square-o"></i></span>
	            </div>

		            <div class="clear"></div>

			<?php } else {

				/*-----------------------------------------------------------------------------------*/
                /* For Legacy Users */
                /*-----------------------------------------------------------------------------------*/

                ?>

		    	<div class="col span_6">
	            	<div id="keyword-wrap">
			            <i class="fa fa-search"></i>
		                <input type="text" id="ct_keyword" class="number" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Enter a street address or keyword', 'contempo'); ?>" />
	                </div>
	            </div>

	            <div class="col span_2">
					<?php ct_search_form_select('city'); ?>
				</div>

				 <div class="col span_2">
					<?php ct_search_form_select('state'); ?>
	            </div>

	            <input type="hidden" name="search-listings" value="true" />

	            <div class="col span_2">
		            <input id="submit" class="btn left" type="submit" value="<?php esc_html_e('Search', 'contempo'); ?>" />
		            <span id="more-search-options-toggle" class="btn right"><i class="fa fa-plus-square-o"></i></span>
	            </div>

	            	<div class="clear"></div>

		    <?php } ?>

	        <div id="more-search-options">
		        <?php
				
			    if ($ct_home_adv_search_fields) :
			    
			    foreach ($ct_home_adv_search_fields as $field=>$value) {
			    
			        switch($field) {
						
					// Type            
			        case 'type' :
			        	if(!in_array('Type', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
				                <label for="ct_type"><?php _e('Type', 'contempo'); ?></label>
				                <?php ct_search_form_select('property_type'); ?>
				            </div>
			            <?php }
					break;
					
					// City
					case 'city' :
						if(!in_array('City', $ct_header_adv_search_fields)) { ?>
							<div class="col span_3">
								<label for="ct_city"><?php _e('City', 'contempo'); ?></label>
								<?php ct_search_form_select('city'); ?>
							</div>
						<?php }
					break;
					
			        // State            
			        case 'state' :
			        	if(!in_array('State', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
								<?php ct_search_form_select('state'); ?>
				            </div>
				        <?php }
				    break;
				
					// Zipcode            
			        case 'zipcode' :
			        	if(!in_array('Zipcode', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
								<?php ct_search_form_select('zipcode'); ?>
				            </div>
				        <?php }
					break;

			        // Country            
			        case 'country' :
			        	if(!in_array('Country', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
				                <label for="ct_country"><?php _e('Country', 'contempo'); ?></label>
				                <?php ct_search_form_select('country'); ?>
				            </div>
				        <?php }
			        break;
					
					// Beds            
			        case 'beds' :
			        	if(!in_array('Beds', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
				                <label for="ct_beds"><?php _e('Beds', 'contempo'); ?></label>
								<?php ct_search_form_select('beds'); ?>
				            </div>
				        <?php }
					break;
					
					// Baths            
			        case 'baths' :
			        	if(!in_array('Baths', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
				                <label for="ct_baths"><?php _e('Baths', 'contempo'); ?></label>
								<?php ct_search_form_select('baths'); ?>
				            </div>
				        <?php }
					break;
					
					// Status            
			        case 'status' :
			        	if(!in_array('Status', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_3">
				                <label for="ct_status"><?php _e('Status', 'contempo'); ?></label>
								<?php ct_search_form_select('ct_status'); ?>
				            </div>
				        <?php }
					break;
					
					// Additional Features            
			        case 'additional_features' :
			        	if(!in_array('Additional Features', $ct_header_adv_search_fields)) { ?>
				            <div class="col span_12 first additional-features marT10">
				                <label for="ct_additional_features"><?php _e('Addtional Features', 'contempo'); ?></label>
								<?php ct_search_form_checkboxes_header('additional_features'); ?>
				            </div>
				        <?php }
					break;

			        // Community          
			        case 'community' : ?>
			            <div class="col span_3">
			                <?php
			                global $ct_options;
			                $ct_community_neighborhood_or_district = isset( $ct_options['ct_community_neighborhood_or_district'] ) ? $ct_options['ct_community_neighborhood_or_district'] : '';

			                if($ct_community_neighborhood_or_district == 'neighborhood') { ?>
			                    <label for="ct_community"><?php _e('Neighborhood', 'contempo'); ?></label>
			                <?php } elseif($ct_community_neighborhood_or_district == 'district') { ?>
			                    <label for="ct_community"><?php _e('District', 'contempo'); ?></label>
			                <?php } else { ?>
			                    <label for="ct_community"><?php _e('Community', 'contempo'); ?></label>
			                <?php } ?>
			                <?php ct_search_form_select('community'); ?>
			            </div>
			        <?php
			        break;
					
					// Price From            
			        case 'price_from' : ?>
			            <div class="col span_3">
			                <label for="ct_price_from"><?php _e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_from" class="number" name="ct_price_from" size="8" placeholder="<?php esc_html_e('Price From', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			        <?php
					break;
					
					// Price To            
			        case 'price_to' : ?>
			            <div class="col span_3">
			                <label for="ct_price_to"><?php _e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)</label>
			                <input type="text" id="ct_price_to" class="number" name="ct_price_to" size="8" placeholder="<?php esc_html_e('Price To', 'contempo'); ?> (<?php ct_currency(); ?>)" />
			            </div>
			        <?php
					break;

			        // Sq Ft From            
			        case 'sqft_from' : ?>
			            <div class="col span_3">
			                <label for="ct_sqft_from"><?php ct_sqftsqm(); ?> <?php _e('From', 'contempo'); ?></label>
			                <input type="text" id="ct_sqft_from" class="number" name="ct_sqft_from" size="8" placeholder="<?php _e('Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
			        
			        // Sq Ft To            
			        case 'sqft_to' : ?>
			            <div class="col span_3">
			                <label for="ct_sqft_to"><?php ct_sqftsqm(); ?> <?php _e('To', 'contempo'); ?></label>
			                <input type="text" id="ct_sqft_to" class="number" name="ct_sqft_to" size="8" placeholder="<?php _e('Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;

			        // Lot Size From            
			        case 'lotsize_from' : ?>
			            <div class="col span_3">
			                <label for="ct_lotsize_from"><?php _e('Lot Size From', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_from" class="number" name="ct_lotsize_from" size="8" placeholder="<?php _e('Lot Size From', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
			        
			        // Lot Size To            
			        case 'lotsize_to' : ?>
			            <div class="col span_3">
			                <label for="ct_lotsize_to"><?php _e('Lot Size To', 'contempo'); ?> <?php ct_sqftsqm(); ?></label>
			                <input type="text" id="ct_lotsize_to" class="number" name="ct_lotsize_to" size="8" placeholder="<?php _e('Lot Size To', 'contempo'); ?> -<?php ct_sqftsqm(); ?>" />
			            </div>
			        <?php
			        break;
					
					// MLS            
			        case 'mls' : ?>
			            <div class="col span_3">
			                <label for="ct_mls"><?php _e('Property ID', 'contempo'); ?></label>
			                <input type="text" id="ct_mls" name="ct_mls" size="12" placeholder="<?php esc_html_e('Property ID', 'contempo'); ?>" />
			            </div>
			        <?php
					break;

			        // Number of Guests            
			        case 'numguests' : ?>
			            <div class="col span_3">
			                <label for="ct_rental_guests"><?php _e('Number of Guests', 'contempo'); ?></label>
			                <input type="text" id="ct_rental_guests" name="ct_rental_guests" size="12" placeholder="<?php esc_html_e('Number of Guests', 'contempo'); ?>" />
			            </div>
			        <?php
			        break;

			        // Keyword           
			        case 'keyword' : ?>
			            <div class="col span_3">
			                <label for="ct_keyword"><?php _e('Keyword', 'contempo'); ?></label>
			                <input type="text" id="ct_keyword" class="number" name="ct_keyword" size="8" placeholder="<?php esc_html_e('Keyword', 'contempo'); ?>" />
			            </div>
			        <?php
			        break;

			        }
			    
			    } endif; ?>
			    	<div class="clear"></div>
	        </div>
        </form>
	        <div class="clear"></div>
    </div>
</div>
<!-- //Header Search -->