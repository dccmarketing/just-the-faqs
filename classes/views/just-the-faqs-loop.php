<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Just_The_FAQs
 * @subpackage Just_The_FAQs/classes/views
 */

/**
 * just-the-faqs-before-loop hook
 *
 * @hooked 		loop_wrap_start 		10
 */
do_action( 'just-the-faqs-before-loop', $args );

foreach ( $items as $item ) {

	$meta = get_post_custom( $item->ID );

	/**
	 * just-the-faqs-before-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		loop_content_wrap_start 		10
	 * @hooked 		loop_content_link_start 		15
	 */
	do_action( 'just-the-faqs-before-loop-content', $item, $meta );

		/**
		 * just-the-faqs-loop-content hook
		 *
		 * @param 		object  	$item 		The post object
		 *
		 * @hooked 		loop_content_question 		15
		 * @hooked 		loop_content_answer 		20
		 */
		do_action( 'just-the-faqs-loop-content', $item, $meta );

	/**
	 * just-the-faqs-after-loop-content hook
	 *
	 * @param 		object  	$item 		The post object
	 *
	 * @hooked 		loop_content_link_end 		10
	 * @hooked 		loop_content_wrap_end 		90
	 */
	do_action( 'just-the-faqs-after-loop-content', $item, $meta );

} // foreach

/**
 * just-the-faqs-after-loop hook
 *
 * @hooked 		loop_wrap_end 			10
 */
do_action( 'just-the-faqs-after-loop', $args );
