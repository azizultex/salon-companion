<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.keendevs.com/
 * @since             1.0.0
 * @package           Salon_Companion
 *
 * @wordpress-plugin
 * Plugin Name:       Salon Companion
 * Plugin URI:        https://www.keendevs.com/
 * Description:       5 extremely useful custom widgets and package post type to create an engaging website.
 * Version:           1.0.0
 * Author:            KeenDevs
 * Author URI:        https://www.keendevs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       salon-companion
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SALON_COMPANION_VERSION', '1.0.0' );
define( 'SALONC_BASE_PATH', dirname( __FILE__ ) );
define( 'SALONC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SALONC_FILE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-salon-companion-activator.php
 */
function activate_salon_companion() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-salon-companion-activator.php';
	Salon_Companion_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-salon-companion-deactivator.php
 */
function deactivate_salon_companion() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-salon-companion-deactivator.php';
	Salon_Companion_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_salon_companion' );
register_deactivation_hook( __FILE__, 'deactivate_salon_companion' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-salon-companion.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_salon_companion() {

	$plugin = new Salon_Companion();
	$plugin->run();

}
run_salon_companion();