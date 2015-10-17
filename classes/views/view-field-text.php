<?php

/**
 * Provides the markup for any text field
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes/views
 */

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'just-the-faqs' ); ?>: </label><?php

}

?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />
<span class="description"><?php esc_html_e( $atts['description'], 'just-the-faqs' ); ?></span>