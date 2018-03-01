<?php

/**
 * Get various info from ACF options page
 * @param  str $type Info to retrieve
 * @return mixed     The field, mainly text fields
 */
function get_company_info($type) {
	$type = 'company_' . $type;
	return get_field($type, 'option');
}

function the_company_address($inc_name = false) {
	// Company name
	$name = get_company_info('name');
	// Company address
	$address = get_company_info('address');
	// Address items
	$address_one = $address['company_address_1'];
	$address_two = $address['company_address_2'];
	$str_address = $address['company_street'];
	$locality = $address['company_locality'];
	$region = $address['company_region'];
	$postcode = $address['company_postcode'];

	echo '<div itemscope itemtype="http://schema.org/PostalAddress">';
	echo '<p class="address">';
	if($inc_name) echo '<span itemprop="name" class="address__name">' . $name . '</span> ';
	if($address_one) echo '<span itemprop="streetAddress" class="address__street">' . $address_one . '</span> ';
	if($address_two) echo '<span itemprop="streetAddress" class="address__street">' . $address_two . '</span> ';
	echo '<span itemprop="streetAddress" class="address__street">' . $str_address . '</span> ';
	echo '<span itemprop="addressLocality" class="address__locality">' . $locality . '</span> ';
	echo '<span itemprop="addressRegion" class="address_region">' . $region . '</span> ';
	echo '<span itemprop="postalCode" class="address__postcode">' . $postcode . '</span>';
	echo '</p>';
	echo '</div>';
}

function get_company_gm_link($type, $inc_name = false) {

	if($type === 'directions') {
		$url = 'https://www.google.com/maps/dir/Current+Location/';
	} elseif ($type === 'place') {
		$url = 'https://www.google.com/maps/search/';
	}

	$name = get_company_info('name');
	$address = get_company_info('address');
	$address = implode('+', array_filter($address));
	if($inc_name) $address = $name . ' ' . $address;
	$link = str_replace(' ', '+', $address);

	return $url . $link;
}

function the_company_email_link() {
	$email_address = get_company_info('email');

	return '<a href="' . antispambot("mailto:$email_address") . '">' . antispambot($email_address) . '</a>';
}

function the_company_tel_link() {
	$tel_no = get_company_info('tel');
	$tel_no_link = str_replace(' ', '', $tel_no);
	// Replace leading zero with country code
	$tel_no_link = preg_replace('/^0?/', '+44', $tel_no_link);

	return '<a href="tel:' . $tel_no_link . '">' . $tel_no . '</a>';
}