<?php

if( ! defined('ABSPATH' ) ) exit;

/**
 * Get various info from ACF options page
 * @param  str $type Info to retrieve
 * @return mixed     The field, mainly text fields
 */
function get_company_info( $type ) {
	$type = 'company_' . $type;
	return get_field( $type, 'option' );
}

/**
 * Return the company address in relavant schema markup
 * @param  bool $inc_name Optionally include the company name
 * @return str            The address markup
 */
function the_company_address( $inc_name = false ) {

	$name = get_company_info( 'name' ); // Store company name
	$address = get_company_info( 'address' ); // Store company address

	// Address items
	$address_one = $address['company_address_1'];
	$address_two = $address['company_address_2'];
	$str_address = $address['company_street'];
	$locality = $address['company_locality'];
	$region = $address['company_region'];
	$postcode = $address['company_postcode'];
	$country = $address['company_country'];

	echo '<div itemscope itemtype="http://schema.org/PostalAddress">';
	echo '<p class="address">';
	if( $inc_name )    echo '<span itemprop="name" class="address__name">' . $name . '</span> ';
	if( $address_one ) echo '<span itemprop="streetAddress" class="address__street">' . $address_one . '</span> ';
	if( $address_two ) echo '<span itemprop="streetAddress" class="address__street">' . $address_two . '</span> ';
	if( $str_address ) echo '<span itemprop="streetAddress" class="address__street">' . $str_address . '</span> ';
	if( $locality )    echo '<span itemprop="addressLocality" class="address__locality">' . $locality . '</span> ';
	if( $region )      echo '<span itemprop="addressRegion" class="address_region">' . $region . '</span> ';
	if( $postcode )    echo '<span itemprop="postalCode" class="address__postcode">' . $postcode . '</span>';
	if( $country !== 'false' ) echo '<span itemprop="addressCounty" class="address__country">' . $country . '</span>';
	echo '</p>';
	echo '</div>';
}

/**
 * Use the company address to create a link to Google Maps
 * @param  str  $type     Choose link type [directions|place]
 * @param  bool $inc_name Optionally include the company name within the link
 * @return str            The Google Maps url based on selected options
 */
function get_company_gm_link( $type, $inc_name = false ) {

	if( $type === 'directions' ) {
		$url = 'https://www.google.com/maps/dir/Current+Location/';
	} elseif ( $type === 'place' ) {
		$url = 'https://www.google.com/maps/search/';
	}

	$name = get_company_info( 'name' );
	$address = get_company_info( 'address' );
	$address = implode( '+', array_filter( $address ) );
	if( $inc_name ) $address = $name . ' ' . $address;
	$link = str_replace( ' ', '+', $address );

	return $url . $link;
}

/**
 * Return the company email address
 * @param  bool $echo Choose whether to echo (true) or return (false) the end result
 * @param  bool $link Wrap email address in mailto link
 * @return str        The email address either with or without anchor tags
 */
function the_company_email( $echo, $link ) {
	$email_address = get_company_info( 'email' ); // store the email address

	$email = $link ? '<a href="' . antispambot( "mailto:$email_address" ) . '" class="email-link">' : '';
	$email .= antispambot( $email_address );
	$email .= $link ? '</a>' : '';

	if( $echo ) {
		echo $email;
	} else {
		return $email;
	}

}

/**
 * Return the company telephone number
 * @param  bool $echo         Choose whether to echo (true) or return (false) the end resul
 * @param  bool $link         Wrap telephone number in mailto link
 * @param  str $country_code  If outside the UK update the country code accordingly
 * @return str                The telephone number either with or without anchor tags
 */
function the_company_tel( $echo, $link, $country_code = '44' ) {
	$tel_no = get_company_info( 'tel' ); // store the telephone number from the options

	// Modify telephone number for link purposes
	$tel_no_link = str_replace( array(' ', '-'), '', $tel_no ); // Remove any spaces or dashes from the telephone number
	$tel_no_link = preg_replace( '/^0?/', '+' . $country_code, $tel_no_link ); // Replace leading zero with country code

	$tel = $link ? '<a href="tel:' . $tel_no_link . '" class="tel-link">' : '';
	$tel .= $tel_no;
	$tel .= $link ? '</a>' : '';

	if( $echo ) {
		echo $tel;
	} else {
		return $tel;
	}
}