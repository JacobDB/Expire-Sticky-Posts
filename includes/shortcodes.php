<?php
/**
 * Registers our plugin short codes
 *
 * @copyright   Copyright (c) 2014, Andy von Dohren
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register the [expires] short code
 *
 * @access public
 * @since 1.0
 * @return string
 */
function pw_esp_shortcode( $atts, $content = null ) {

	$atts = shortcode_atts( array(
		'expires_on'  => __( 'This item expires on: %s', 'pw-spe' ),
		'expired'     => __( 'This item expired on: %s', 'pw-spe' ),
		'date_format' => get_option( 'date_format', 'F j, Y' ),
		'class'       => 'pw-esp-post-expiration',
		'id'          => 'pw-esp-post-expiration-%d',
	), $atts, 'pw_esp' );

	$date = get_post_meta( get_the_ID(), 'pw_esp_expiration', true );

	$expires = '<div id="' . sprintf( $atts['id'], get_the_ID() ) . '" class="' . esc_attr( $atts['class'] ) . '">';

		if( pw_esp_is_expired( get_the_ID() ) ) {

			$text = $atts['expired'];
	
		} else {

			$text = $atts['expires_on'];
	
		}

		$expires .= sprintf( $text, date_i18n( $atts['date_format'], strtotime( $date ) ) );

	$expires .= '</div>';

	return $expires;

}
add_shortcode( 'expires', 'pw_esp_shortcode' );
