<?php

if ( ! defined( 'ABSPATH') ) exit;

/**
 * Get an excerpt of post with custom length
 * @param  Integer $length Number of words to return
 * @return String          The excerpt text
 */
function lj_custom_excerpt( $length )  {
    $content = get_the_content();
    return wp_trim_words( $content, $length );
}