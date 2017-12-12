<?php
/*
This is COMMERCIAL SCRIPT
We are do not guarantee correct work and support of Booking Calendar, if some file(s) was modified by someone else then wpdevelop.
*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  S u p p o r t    f u n c t i o n s       ///////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Check  if this date available for specific booking resource, depend from the season filter.
function is_this_day_available_on_season_filters( $date, $bk_type, $season_filters = array() ){

    if ( empty($season_filters) ) {
        $season_filters = apply_bk_filter('get_available_days',  $bk_type );
    }

    $is_day_inside_filters = false ;
    $is_all_days_available = $season_filters['available'];
    $season_filters_dates_count = count( $season_filters['days'] );
    
    if ($season_filters_dates_count > 0) {

        $season_filters_dates = $season_filters['days'];
  

        $date_arr = explode( '-', $date );
        $d_mday = (int) $date_arr[2];
        $d_mon  = (int) $date_arr[1];
        $d_year = (int) $date_arr[0];    

        foreach ( $season_filters_dates as $filter_num => $season_filters_dates_value ) {           //FixIn: 6.0.1.13                 
            $version = '1.0';
            if (isset($season_filters_dates[$filter_num]['version']))                               // Version 2.0
                if ($season_filters_dates[$filter_num]['version'] == '2.0')   {

                    $version = '2.0';
                    if (isset($season_filters_dates[$filter_num][ $d_year ]))
                        if (isset($season_filters_dates[$filter_num][ $d_year ][ $d_mon ]))
                            if (isset($season_filters_dates[$filter_num][ $d_year ][ $d_mon ][ $d_mday ]))
                                if ($season_filters_dates[$filter_num][ $d_year ][ $d_mon ][ $d_mday ] == 1 ) {
                                    $is_day_inside_filters = true;
                                    break;
                                }
                }

            if ($version == '1.0') {                                    // Version 1.0

                $is_day_inside_filter = '';

                
                if (  $season_filters_dates[$filter_num]['days'][  $d_mday  ] == 'On' )     $is_day_inside_filter .= 'day ';
                if (  $season_filters_dates[$filter_num]['monthes'][  $d_mon  ] == 'On' )   $is_day_inside_filter .= 'month ';
                if ( isset(  $season_filters_dates[$filter_num]['year'][  $d_year  ] ) )
                    if (  $season_filters_dates[$filter_num]['year'][  $d_year  ] == 'On' )     $is_day_inside_filter .= 'year ';
                $d_wday = (int) date( "w", mktime(0, 0, 0, $d_mon, $d_mday, $d_year ) );
                if ($is_day_inside_filter == 'day month year ') {
                    if (  $season_filters_dates[$filter_num]['weekdays'][ $d_wday ] == 'On' ) $is_day_inside_filter .= 'week ';
                    if ($is_day_inside_filter == 'day month year week ') {$is_day_inside_filters = true; break;}
                }
            }
            
        }        
    }
    
      
    
    if ($is_day_inside_filters) {
        if ($is_all_days_available) return false;
        else                        return true;
    } else {
        if ($is_all_days_available) return true;
        else                        return false;
    }
        
}




/**
	 * Check if this day inside of filter  , return TRUE  or FALSE   or   array( 'hour', 'start_time', 'end_time']) if HOUR filter this FILTER ID
 * 
 * @param int $day
 * @param int $month
 * @param int $year
 * @param int $filter_id
 * 
 * @return bool
 */
function wpbc_is_day_inside_of_filter( $day , $month, $year, $filter_id ){

    global $wpdb;

    if ( IS_USE_WPDEV_BK_CACHE ) {
        global $wpbc_cache_season_filters;

        if (! isset($wpbc_cache_season_filters)) $wpbc_cache_season_filters = array();
        if (! isset($wpbc_cache_season_filters[$filter_id])) {
            $result = $wpdb->get_results( "SELECT booking_filter_id as id, filter FROM {$wpdb->prefix}booking_seasons" );

            foreach ($result as $value) {
                $wpbc_cache_season_filters[$value->id] = array($value);
            }
            if (isset($wpbc_cache_season_filters[$filter_id])) {
                $result = $wpbc_cache_season_filters[$filter_id];
            }
        } else {
            $result = $wpbc_cache_season_filters[$filter_id];
        }
    } else
        $result = $wpdb->get_results( $wpdb->prepare( "SELECT filter FROM {$wpdb->prefix}booking_seasons WHERE booking_filter_id = %d " , $filter_id ) );

    if (count($result)>0){

        foreach($result as $filter) {

            if ( is_serialized( $filter->filter ) ) $filter = unserialize($filter->filter);
            else $filter = $filter->filter ;
        }

        return wpbc_is_day_in_season_filter($day , $month, $year, $filter);                
    }
    return false;    // there are no filter so not inside of filter
}

    
/**
	 * Check if this day inside of filter  , return TRUE  or FALSE   or   array( 'hour', 'start_time', 'end_time']) if HOUR filter this FILTER ID
 * 
 * @param int $day
 * @param int $month
 * @param int $year
 * @param STRING $filter - data from resource meta
 * 
 * @return bool
 */
function wpbc_is_day_in_season_filter( $day , $month, $year, $filter ){

    if ( isset( $filter ) > 0 ) {
        
        $filter = maybe_unserialize( $filter );

        if ( (isset( $filter['version'] )) && ($filter['version'] == '2.0') ) { // Ver: 2.0

            if (       ( isset( $filter[$year] ) )
                    && ( isset( $filter[$year][$month] ) )
                    && ( isset( $filter[$year][$month][$day] ) )
                    && ( $filter[$year][$month][$day] == 1 )
                ){
                    
                return true;
            } else
                return false;
            
        } else {                                                                // Ver: 1.0

            $week_day_num = date( 'w', mktime( 0, 0, 0, $month, $day, $year ) );
            $weekdays = array();
            $days = array();
            $monthes = array();
            $years = array();

            foreach ( $filter['weekdays'] as $key => $value ) {
                if ( $value == 'On' )
                    $weekdays[] = $key;
            }
            foreach ( $filter['days'] as $key => $value ) {
                if ( $value == 'On' )
                    $days[] = $key;
            }
            foreach ( $filter['monthes'] as $key => $value ) {
                if ( $value == 'On' )
                    $monthes[] = $key;
            }
            foreach ( $filter['year'] as $key => $value ) {
                if ( $value == 'On' )
                    $years[] = $key;
            }
            
            if ( ( ! empty( $filter['start_time'] )) && ( ! empty( $filter['end_time'] )) ) {
                
                return array( 'hour', $filter['start_time'], $filter['end_time'] );             // Its hourly filter, so its apply to all days
            }
            
            if ( ! in_array( $week_day_num, $weekdays ) )   return false;              
            if ( ! in_array( $day, $days ) )                return false;            
            if ( ! in_array( $month, $monthes ) )           return false;            
            if ( ! in_array( $year, $years ) )              return false;

            return true;                                                        // Its inside of filter
        }
    }
    
    return false;    
}


function wpdev_bk_get_max_days_in_calendar(){
    $max_monthes_in_calendar = get_bk_option( 'booking_max_monthes_in_calendar');
    if (strpos($max_monthes_in_calendar, 'm') !== false) {
        $max_monthes_in_calendar = str_replace('m', '', $max_monthes_in_calendar) * 31 +5;
    } else {
        $max_monthes_in_calendar = str_replace('y', '', $max_monthes_in_calendar) * 365+15 ;
    }
    return $max_monthes_in_calendar;
}


// FixIn: 6.1.1.18   
/**
	 * Extend booking dates/times interval to extra hours or days.
 * 
 * @param array $param - array( $blocked_days_range, $prior_check_out_date )
 * @return  array( $blocked_days_range, $prior_check_out_date )
 */
function wpbc_get_extended_block_dates( $param ) {
    
    list( $blocked_days_range, $prior_check_out_date ) = $param;
    $my_booking_date = $blocked_days_range[0];
    
    
    // FixIn: 6.1.1.18
    $booking_unavailable_extra_in_out = get_bk_option( 'booking_unavailable_extra_in_out' );
    ////////////////////////////////////////////////////////////////
    // Extend unavailbale interval to extra hours; cleaning time, or any other service time
    ////////////////////////////////////////////////////////////////
    /*            
    $extra_hours_in  = 1;
    $extra_hours_out = 1;
    if ( substr( $my_booking_date, -1 ) == '1' )
        $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '-' . $extra_hours_in  . ' hour', strtotime( $my_booking_date ) ) );
    if ( substr( $my_booking_date, -1 ) == '2' )
        $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '+' . $extra_hours_out . ' hour', strtotime( $my_booking_date ) ) );
    */
    if ( $booking_unavailable_extra_in_out == 'm' ) {

        $extra_minutes_in  = str_replace( array('m','d'), '', get_bk_option( 'booking_unavailable_extra_minutes_in' )  );       // 0
        $extra_minutes_out = str_replace( array('m','d'), '', get_bk_option( 'booking_unavailable_extra_minutes_out' ) );      // 30

        if ( ( ! empty( $extra_minutes_in ) ) && ( substr( $my_booking_date, -1 ) == '1' ) ) {
            $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '-' . $extra_minutes_in  . ' minutes', strtotime( $my_booking_date ) ) );                      
        }
        if ( ( ! empty( $extra_minutes_out ) ) && ( substr( $my_booking_date, -1 ) == '2' ) ) {
            $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '+' . $extra_minutes_out . ' minutes', strtotime( $my_booking_date ) ) );                      
        }

        // Fix overlap of previous times
        if ( $prior_check_out_date !== false ) {
            if (
                   ( substr( $my_booking_date, -1 ) == '1' ) 
                && ( substr( $prior_check_out_date, -1 ) == '2' )    
                && ( strtotime( $prior_check_out_date ) >= strtotime( $my_booking_date )  )                                
               ) {
                $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '-1 second', strtotime( $prior_check_out_date ) ) );
            }                    
        }

        $blocked_days_range = array( $my_booking_date );        

        
        /* Fix of one internal  free date in special  situation
         * For exmaple we have booked 2016-05-05 10:00 - 12:00
         * and we have shift  previous date 23 hours and next date shift 23 hours
         * its means that we will have one booked date 2016-05-04 11:00 and other booked date 2016-05-06 11:00
         * And have free date 2016-05-05 - so  need to  fix it.
         */
        if ( $prior_check_out_date !== false ) {
            if (
                   ( substr( $my_booking_date, -1 ) == '2' ) 
                && ( substr( $prior_check_out_date, -1 ) == '1' )    
                && ( wpbc_get_difference_in_days(  date( 'Y-m-d 00:00:00',  strtotime($my_booking_date) ), date( 'Y-m-d 00:00:00',  strtotime($prior_check_out_date) )  ) >= 2  )                                
               ) {
                $blocked_days_range = array( date( 'Y-m-d 00:00:00', strtotime( '-1 day', strtotime( $my_booking_date ) ) ), $my_booking_date );
            }                    
        }
        
        
        $prior_check_out_date = $my_booking_date;
    }

    ////////////////////////////////////////////////////////////////
    // Extend unavailbale interval to extra DAYS
    ////////////////////////////////////////////////////////////////
    if ( $booking_unavailable_extra_in_out == 'd' ) {

        $extra_days_in  = str_replace( array('m','d'), '', get_bk_option( 'booking_unavailable_extra_days_in' ) );          // 0
        $extra_days_out = str_replace( array('m','d'), '', get_bk_option( 'booking_unavailable_extra_days_out' ) );         // 21

        $initial_check_in_day = $initial_check_out_day = false;
        if ( ( ! empty( $extra_days_in ) ) && ( substr( $my_booking_date, -1 ) == '1' ) ) {
            $initial_check_in_day = $my_booking_date;
            $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '-' . $extra_days_in . ' day', strtotime( $my_booking_date ) ) );
            $blocked_days_range = array( $my_booking_date );        // We have shifted our Start date,  so  need to  start  from  begining
        } 

        if ( ( ! empty( $extra_days_out ) ) && ( substr( $my_booking_date, -1 ) == '2' ) ) {
            $initial_check_out_day = $my_booking_date;
            $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '+' . $extra_days_out . ' day', strtotime( $my_booking_date ) ) );                        
            $blocked_days_range = array();
        } 

        if ( $prior_check_out_date !== false ) { // Check if we intersected with  previous date, because dates sorted. Check  only for Check out dates. //TODO: Test more detail here
            if (
                   ( substr( $my_booking_date, -1 ) == '1' ) 
                && ( substr( $prior_check_out_date, -1 ) == '2' )    
                && ( strtotime( $prior_check_out_date ) >= strtotime( $my_booking_date )  )                                
               ) {
                $my_booking_date = date( 'Y-m-d H:i:s', strtotime( '-1 second', strtotime( $prior_check_out_date ) ) );
            }                    
        }
        $prior_check_out_date = $my_booking_date;

        if ( $initial_check_in_day !== false ) {
            if ( get_bk_option( 'booking_range_selection_time_is_active')  == 'On' )    $conditional_date = 0;  //If we are using check in/out times, so  need to block  also initial date
            else                                                                        $conditional_date = 1;  // Otherwise we do not need to  block  this date for times, booking,  becaseu its will be blocked by  check out date. 
            for ( $di = ($extra_days_in-1); $di >= $conditional_date; $di-- ) {
                $blocked_days_range[] = date( 'Y-m-d 00:00:00', strtotime( '-' . $di . ' day', strtotime( $initial_check_in_day ) ) );
            }
        }
        if (  $initial_check_out_day !== false ) {
            if ( ( $extra_days_in > 0 ) && ( $extra_days_out > 0 ) )
                $conditional_date = 0;                                          //Do  not skip our one day  booking,  if we set intervals for start and end range
            else
                $conditional_date = 1;

            if ( get_bk_option( 'booking_range_selection_time_is_active')  == 'On' )                //FixIn: 7.0.1.38
                $conditional_date = 0;                                          //If we are using check in/out times, so  need to block  also initial date

            for ( $di = $conditional_date; $di < $extra_days_out; $di++ ) {
                $blocked_days_range[] = date( 'Y-m-d 00:00:00', strtotime( '+' . $di . ' day', strtotime( $initial_check_out_day ) ) );        
            }
            $blocked_days_range[] = $my_booking_date;
        }
    } 


    return array( $blocked_days_range, $prior_check_out_date );
    
}
add_filter('wpbc_get_extended_block_dates_filter', 'wpbc_get_extended_block_dates');


/**
	 * Replace HINT shortcode in form, with  ability to  use same hint shortcode several  times in the same form.
 * 
 * @param string $return_form
 * @param array $params
 * @return string
 */
function wpbc_replace_shortcode_hint( $return_form, $params ) {

	$params['shortcode'] = str_replace( array( '[', ']' ), '', $params['shortcode'] );

	// Trick. Replacing only 1 time and prevent esacaping any paterns in replacing
	$return_form = preg_replace( '/\['. $params['shortcode'] . '\]/', 'REPLACED_SINGLE_WORD', $return_form, 1);    

	// Replace 1st occurence of HINT shortcode with span element with  specific HTML ID and INPUT text element for saving this value
	$return_form = str_replace(   'REPLACED_SINGLE_WORD'
								, '<span id="'.  $params['span_class'] .'">' . $params['span_value'] . '</span>'
								. '<input id="'. $params['input_name'] .'" name="'. $params['input_name'] .'" value="'. $params['input_data'] .'" style="display:none;" type="text" />'
								, $return_form );

	// Replace all  other same shortcodes - only  to  show with  HTML CLASS identificator        
	$return_form = str_replace(   '['. $params['shortcode'] .']'
								, '<span class="'. $params['span_class'] .'">' . $params['span_value'] . '</span>'
								, $return_form );
	return $return_form;
}
