<?php
/**
 * Single Listing Open House
 *
 * @package WP Pro Real Estate 7
 * @subpackage Include
 */

$ct_open_house_entries = get_post_meta( get_the_ID(), '_ct_open_house', true );

foreach ( (array) $ct_open_house_entries as $key => $entry ) {

    $ct_open_house_date = '';

    if ( isset( $entry['_ct_open_house_date'] ) )
        $ct_open_house_date = esc_html( $entry['_ct_open_house_date'] );

}

if($ct_open_house_entries != '' && $ct_open_house_date != '') {

    $ct_todays_date = date("mdY");
    
    echo '<!-- Open House -->';
    echo '<div id="listing-open-house">';
        echo '<h4 class="border-bottom marB20">' . __('Open House', 'contempo') . '</h4>';

        echo '<table id="open-house">';

            echo '<thead>';
                echo '<th>';
                    echo __('Date', 'contempo');
                echo '</th>';
                echo '<th>';
                    echo __('Time', 'contempo');
                echo '</th>';
                echo '<th>';
                    echo __('RSVP', 'contempo');
                echo '</th>';
            echo '</thead>';

            foreach ( (array) $ct_open_house_entries as $key => $entry ) {

                $ct_open_house_date = $ct_open_house_start_time = $ct_open_house_end_time = $open_house_rsvp = '';

                if ( isset( $entry['_ct_open_house_date'] ) )
                    $ct_open_house_date = esc_html( $entry['_ct_open_house_date'] );
                    $ct_open_house_date_formatted = strftime('%m%d%Y', $ct_open_house_date);

                if ( isset( $entry['_ct_open_house_start_time'] ) )
                    $ct_open_house_start_time = esc_html( $entry['_ct_open_house_start_time'] );

                if ( isset( $entry['_ct_open_house_end_time'] ) )
                    $ct_open_house_end_time = esc_html( $entry['_ct_open_house_end_time'] );

                if ( isset( $entry['_ct_open_house_rsvp'] ) ) {
                    $ct_open_house_rsvp = $entry['_ct_open_house_rsvp'];
                }

                if($ct_open_house_date_formatted >= $ct_todays_date) {

                    echo '<tr>';
                        echo '<td>';
                            if($ct_open_house_date != '') {
                                echo strftime('%-m/%d/%Y', $ct_open_house_date);
                            }
                        echo '</td>';
                        echo '<td>';
                            if($ct_open_house_start_time != '') {
                                echo $ct_open_house_start_time;  
                            }
                            if($ct_open_house_end_time != '') {
                                echo ' - ';
                                echo $ct_open_house_end_time;  
                            }
                        echo '</td>';
                        echo '<td>';
                            if($ct_open_house_rsvp == 'yes') {
                                echo '<a class="btn" href="#listing-contact">';
                                    echo __('RSVP', 'contempo');
                                echo '</a>';  
                            } else {
                                echo '-';
                            }
                        echo '</td>';
                    echo '</tr>';
                }
            }

        echo '</table>';
    echo '</div>';
    echo '<!-- //Open House -->';
}

?>