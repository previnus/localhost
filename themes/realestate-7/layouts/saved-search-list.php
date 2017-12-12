<?php
/**
 * Saved Search List
 *
 * @package WP Pro Real Estate 7
 * @subpackage Template
 */

global $ct_search_data, $ct_options;

$ct_currency_placement = isset( $ct_options['ct_currency_placement'] ) ? esc_attr( $ct_options['ct_currency_placement'] ) : '';

$format = 'Y-m-d H:i:s';$date = DateTime::createFromFormat($format, $ct_search_data->time);
$time = $date->format('Y-m-d');
$ct_search_args = $ct_search_data->query;
$ct_search_args_decoded = unserialize( base64_decode( $ct_search_args ) );

$ct_beds = isset($ct_search_args_decoded['beds']) ? $ct_search_args_decoded['beds'] : '';
$ct_baths = isset($ct_search_args_decoded['baths']) ? $ct_search_args_decoded['baths'] : '';
$ct_property_type = isset($ct_search_args_decoded['property_type']) ? ct_get_property_type_name($ct_search_args_decoded['property_type']) : '';
$ct_city = isset($ct_search_args_decoded['city']) ? ct_get_city_name($ct_search_args_decoded['city']) : '';
$ct_state = isset($ct_search_args_decoded['state']) ? ct_get_state_name($ct_search_args_decoded['state']) : '';
$ct_status = isset($ct_search_args_decoded['status']) ? ct_get_status_name($ct_search_args_decoded['status']) : '';
$ct_zipcode = isset($ct_search_args_decoded['zip']) ? $ct_search_args_decoded['zip'] : '';
$ct_price_from = isset($ct_search_args_decoded['pricefrom']) ? $ct_search_args_decoded['pricefrom'] : '';
$ct_price_to = isset($ct_search_args_decoded['priceto']) ? $ct_search_args_decoded['priceto'] : '';
?>

<li class="saved-search-block">                              
	<div class="col span_7 first">                                    
		<p class="saved-alert-query">&nbsp;<?php
		if('' != $ct_beds){ echo $ct_beds . ' beds, ';}
		if('' != $ct_baths){ echo $ct_baths . ' baths, ';}
		if($ct_currency_placement == 'after') {
			if('' != $ct_price_from){ echo number_format_i18n($ct_price_from, 0); ct_currency(); echo ', ';}
			if('' != $ct_price_to){ ct_currency(); echo number_format_i18n($ct_price_to, 0); ct_currency(); echo ', ';}
		} else {
			if('' != $ct_price_from){ ct_currency(); echo number_format_i18n($ct_price_from, 0) . ', ';}
			if('' != $ct_price_to){ ct_currency(); echo number_format_i18n($ct_price_to, 0) . ', ';}
		}
		if('' != $ct_property_type){ echo $ct_property_type . ', ';}
		if('' != $ct_status){ echo $ct_status . ', ';}
		if('' != $ct_city){ echo $ct_city . ', ';}
		if('' != $ct_state){ echo $ct_state . ' ';}
		if('' != $ct_zipcode){ echo $ct_zipcode . ' ';}
		?></p>
    </div>                                                                    
	<div class="col span_2">
		<p><?php echo $time; ?></p>                                
	</div>
	<div class="col span_2">                                    
		<select class="esetting">
			<option value="<?php _e('on', 'contempo'); ?>"><?php _e('On', 'contempo'); ?></option>
			<option value="<?php _e('off', 'contempo'); ?>"><?php _e('Off', 'contempo'); ?></option>
		</select>
	</div>                                
	<div class="col span_1 delete">
		<a class="remove-search btn" href="#" data-propertyid='<?php echo intval($ct_search_data->id); ?>'><i class="fa fa-trash-o"></i></a>
	</div>
</li>  
	<div class="clear"></div>