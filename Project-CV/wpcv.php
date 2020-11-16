<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              ibrar9020@gmail.com
 * @since             1.0.0
 * @package           Wpcv
 *
 * @wordpress-plugin
 * Plugin Name:       WPCV
 * Plugin URI:        ibrar9020@gmail.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Abrar
 * Author URI:        ibrar9020@gmail.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcv
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
define( 'WPCV_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpcv-activator.php
 */
function activate_wpcv() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcv-activator.php';
	Wpcv_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpcv-deactivator.php
 */
function deactivate_wpcv() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcv-deactivator.php';
	Wpcv_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpcv' );
register_deactivation_hook( __FILE__, 'deactivate_wpcv' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpcv.php';


/**
 * Method to write logs
 */
if (!function_exists('fc_write_log')) {

    function fc_write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpcv() {

	$plugin = new Wpcv();
	$plugin->run();

}
run_wpcv();
