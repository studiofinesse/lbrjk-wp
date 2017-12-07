<?php

/**
 * Build array of opening hours from repeater option
 * @return array Company opening hours
 */
function get_opening_hours() {

	$opening = [];

	if(have_rows('opening_hours', 'option')) {
		while(have_rows('opening_hours', 'option')) {
			the_row();

			$day = get_sub_field('opening_hours_day');
			$closed = get_sub_field('opening_hours_closed');

			if($closed) {
				$start = null;
				$end = null;
			} else {
				$start = get_sub_field('opening_hours_start');
				$end = get_sub_field('opening_hours_end');
			}

			$opening[$day] = (object)[
				'start' => $start,
				'end' => $end
			];
		}
	}

	return $opening;

}

/**
 * Build array of opening times formatted for outting on site
 * by converting start time values to string e.g. 8am - 5pm
 * @return array The opening hours
 */
function get_opening_hours_formatted($format = 'ampm') {

	$opening = [];
	$days = get_opening_hours();

	foreach($days as $day => $times) {
		$day = $day;

		// Format Opening Time
		$start = $times->start;
		$start = new DateTime($start);

		// Format Closing Time
		$end = $times->end;
		$end = new DateTime($end);

		if($format === 'ampm') {
			$start = $start->format('i') == '00' ? $start->format('ga') : $start->format('g.ia');
			$end = $end->format('i') == '00' ? $end->format('ga') : $end->format('g.ia');
		} elseif($format === '24hr') {
			$start = $start->format('H:i');
			$end = $end->format('H:i');
		}

		// Determine if closed
		$closed = $times->start == null ? true : false;
		$hours = $closed ? 'Closed' : $start . '—' . $end;
		$opening[$day] = $hours;
	}

	return $opening;

}

/**
 * Build array of opening times,
 * grouping all days that have the same values
 * @return array The grouped opening hours
 */
function opening_hours_summary($format = 'ampm') {

	$opening = get_opening_hours_formatted($format);
	$times = [];
	$days = [];

	foreach($opening as $day => $hours) {

		if(count($times) === 0) {
			$current = false;
		} else {
			$current = &$times[count($times) -1];
		}

		if($current === false || $current['hours'] !== $hours) {
			$times[] = array('hours' => $hours, 'days' => array($day));
		} else {
			$current['days'][] = $day;
		}
	}

	foreach($times as $time) {
		if(count($time['days']) === 1) {
			$day = reset($time['days']);
		} elseif(count($time['days']) === 2) {
			$day = $day = reset($time['days']) . ' &amp; ' . end($time['days']);
		} else {
			$day = reset($time['days']) . ' - ' . end($time['days']);
		}
		$hours = $time['hours'];
		$days[$day] = $hours;
	}

	return $days;

}

function opening_hours_as_text($time_format) {
	$openingtimes = opening_hours_summary($time_format);
	echo '<p class="opening-hours">';
	foreach($openingtimes as $day => $hours) echo '<span>' . $day . ' ' . $hours . '</span>';
	echo '</p>';
}

/**
 * Logic behind returning informative message regarding
 * current day opening hours. If currently closed find the
 * next day's hours and update
 * @return str Paragraph inc message with correct info
 */
function when_are_we_open() {
	// Set timezone
    date_default_timezone_set('Europe/London');

	// Get today's opening hours
	$today = date('l');
    $now = date('H:i:s');
	$opening_hours = get_opening_hours_formatted('H:i');
	$hours = $opening_hours[$today];

    $today_closing = get_opening_hours()[$today]->end;

	// // If today is listed as 'Closed'
	if($hours === 'Closed' || $now > $today_closing) {

		$days  = array_keys($opening_hours);
		$times = array_values($opening_hours);
		$index = array_search($today, $days);
		$tomorrow = array_search($today, $days) + 1;

		if(array_diff($times, ['Closed'])) {
			do {
				if(!isset($days[++$index])) {
					$index = 0;
				}
				$day = $days[$index];
			} while($times[$index] === 'Closed');

			$hours = $opening_hours[$day];
			$day = $index == $tomorrow ? 'tomorrow' : $day;
		}

	} else {
		$day = 'today';
	}

	return 'We\'re open ' . $day . ', ' . $hours;
}