<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codesforprogress.com
 * @since      1.0.0
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin
 * @author     SM Shakil Ahmed <shakilcse25@gmail.com>
 */
class Elegant_Form_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * callback of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $callback    callback of this plugin.
	 */
	private $callback;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
		$this->callback = new Elegant_Form_Admin_Callback();

	}



	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Elegant_Form_Loader. Orchestrates the hooks of the plugin.
	 * - Elegant_Form_i18n. Defines internationalization functionality.
	 * - Elegant_Form_Admin. Defines all hooks for the admin area.
	 * - Elegant_Form_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/callbacks/class-elegant-form-admin-callback.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Elegant_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Elegant_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/elegant-form-admin.css', array(), $this->version, 'all' );

		$valid_page = array('manage-elegant-form','create-elegant-form');
		$page = (isset($_GET['page'])) ? $_GET['page'] : 'no-file.php';

		if(in_array($page,$valid_page)){
			wp_enqueue_style( 'elegan-plugin-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Elegant_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Elegant_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/elegant-form-admin.js', array( 'myscript' ), $this->version, false );

		$valid_page = array('manage-elegant-form','create-elegant-form');
		$page = (isset($_GET['page'])) ? $_GET['page'] : '';

		if(in_array($page,$valid_page)){
			wp_enqueue_script( 'elegant-form-jquery-support', plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( 'elegant-form-bootstrap-js-support', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'bootstrap-js' ), $this->version, false );
		}

	}

	public function admin_main_menu() {
		add_menu_page( 'Manage Elegant Form', 'Elegant Form', 'manage_options', 'manage-elegant-form', array($this->callback,'pageRender'), 'dashicons-welcome-widgets-menus', 90 );

		add_submenu_page( 'manage-elegant-form', 'Manage Elegant Form', 'Manage Elegant Form', 'manage_options', 'manage-elegant-form',array($this->callback,'pageRender') );

		add_submenu_page( 'manage-elegant-form', 'Create Form', 'Create Form', 'manage_options', 'create-elegant-form',array($this->callback,'pageRender') );
	}

}
