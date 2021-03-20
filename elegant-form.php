<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codesforprogress.com
 * @since             1.0.0
 * @package           Elegant_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Elegant Form
 * Plugin URI:        https://codesforprogress.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            SM Shakil Ahmed
 * Author URI:        https://codesforprogress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       elegant-form
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
define( 'ELEGANT_FORM_VERSION', '1.0.0' );
define( 'ELEGANT_FORM_DIR_URL', plugin_dir_url( __FILE__ ));
define( 'ELEGANT_FORM_DIR_PATH', plugin_dir_path( __FILE__ ));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elegant-form-activator.php
 */
function activate_elegant_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elegant-form-activator.php';
	Elegant_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elegant-form-deactivator.php
 */
function deactivate_elegant_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elegant-form-deactivator.php';
	Elegant_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_elegant_form' );
register_deactivation_hook( __FILE__, 'deactivate_elegant_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-elegant-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_elegant_form() {

	$plugin = new Elegant_Form();
	$plugin->run();

}
run_elegant_form();
