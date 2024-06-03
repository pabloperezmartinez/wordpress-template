<?php
/**
 * Custom Cron
 *
 */

$bas_cron_recurrence = "year"; // hourly, twicedaily, daily

/**
 * Add cron intervals
 */
function bas_addCronIntervals($array) {
    $array['year'] = array(
            'interval' => (3600*24)*365,
            'display' => 'One Year',
    );
    return $array;
}
add_filter('cron_schedules','bas_addCronIntervals');

// Remove CRON
//wp_clear_scheduled_hook( 'bas_scheduled_update' );

/**
 * Create CRON Update Event.
 */
if ( function_exists('wp_next_scheduled') && function_exists('wp_schedule_event') ) {
	if ( !wp_next_scheduled('bas_scheduled_update') )
		wp_schedule_event(strtotime((date("Y-01-01", mktime()) . " + 365 day")), $bas_cron_recurrence, 'bas_scheduled_update');
}

/**
 * Create Action to CRON Update Event.
 */
add_action( 'bas_scheduled_update', 'bas_do_scheduled_update' );
function bas_do_scheduled_update() {
	    
	// Year period renovation
    bas_active_year_period_for_renovation();
}
//bas_do_scheduled_update();

