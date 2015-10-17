<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://slushman.com
 * @since             1.0.0
 * @package           Just_The_FAQs
 *
 * @wordpress-plugin
 * Plugin Name:       Just the FAQs
 * Plugin URI:        http://slushman.com/just-the-faqs
 * Description:       Helps you manage your frequently asked questions.
 * Version:           1.0.0
 * Author:            Slushman
 * Author URI:        http://slushman.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       just-the-faqs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Used for referring to the plugin file or basename
if ( ! defined( 'JUST_THE_FAQS_FILE' ) ) {
	define( 'JUST_THE_FAQS_FILE', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in classes/class-just-the-faqs-activator.php
 */
function activate_just_the_faqs() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/class-activator.php';
	Just_The_FAQs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in classes/class-just-the-faqs-deactivator.php
 */
function deactivate_just_the_faqs() {
	require_once plugin_dir_path( __FILE__ ) . 'classes/class-deactivator.php';
	Just_The_FAQs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_just_the_faqs' );
register_deactivation_hook( __FILE__, 'deactivate_just_the_faqs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'classes/class-just-the-faqs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_just_the_faqs() {

	$plugin = new Just_The_FAQs();
	$plugin->run();

}
run_just_the_faqs();
