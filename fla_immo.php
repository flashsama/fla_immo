<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://flashsama.me
 * @since             1.0.0
 * @package           Fla_immo
 *
 * @wordpress-plugin
 * Plugin Name:       Bourse de l’immobilier
 * Plugin URI:        http://flashsama.me
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            salaheddine El Ahoubi
 * Author URI:        http://flashsama.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fla_immo
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
define( 'FLA_IMMO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fla_immo-activator.php
 */
function activate_fla_immo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fla_immo-activator.php';
	Fla_immo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fla_immo-deactivator.php
 */
function deactivate_fla_immo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fla_immo-deactivator.php';
	Fla_immo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fla_immo' );
register_deactivation_hook( __FILE__, 'deactivate_fla_immo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fla_immo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fla_immo() {

	$plugin = new Fla_immo();
	$plugin->run();

}
run_fla_immo();
