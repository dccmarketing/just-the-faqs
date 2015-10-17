<?php
/**
 * Globally-accessible functions
 *
 * @link 		http://slushman.com
 * @since 		1.0.0
 *
 * @package		Just_The_FAQs
 * @subpackage 	Just_The_FAQs/classes
 */

/**
 * Returns the path to a template file
 *
 * Looks for the file in these directories, in this order:
 * 		Current theme
 * 		Parent theme
 * 		Current theme templates folder
 * 		Parent theme templates folder
 * 		This plugin
 *
 * To use a custom list template in a theme, copy the
 * file from public/templates into a templates folder in your
 * theme. Customize as needed, but keep the file name as-is. The
 * plugin will automatically use your custom template file instead
 * of the ones included in the plugin.
 *
 * @param 	string 		$name 			The name of a template file
 * @param 	array 		$args 			The shortcode arguments
 * @return 	string 						The path to the template
 */
function just_the_faqs_get_template( $name, $args = '' ) {

	$template = '';

	$locations[] = "{$name}.php";
	$locations[] = "/templates/{$name}.php";

	/**
	 * Filter the locations to search for a template file
	 *
	 * @param 	array 		$locations 			File names and/or paths to check
	 */
	apply_filters( 'just-the-faqs-template-paths', $locations );

	$template = locate_template( $locations, TRUE );

	if ( empty( $template ) ) {

		$template = plugin_dir_path( dirname( __FILE__ ) ) . 'classes/views/' . $name . '.php';

	}

	return $template;

} // just_the_faqs_get_template()
