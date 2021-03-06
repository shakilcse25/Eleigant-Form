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
	private $callbacks;

	/**
	 * settings_api of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $settings_api    settings_api of this plugin.
	 */
	private $settings_api;

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
		$this->dbActivated();
		$this->load_dependencies();
		$this->callbacks = new Elegant_Form_Admin_Callback();
		$this->settings_api = new SettingsApi();

		$this->setSettings();
        $this->setSections();
        $this->setFields();
		$this->settings_api->register();
	}

	
	
	/**
	 * short code init for front-end form view
	 *
	 * @return void
	 */
	public function elegant_form_shortcodes_init(){
		add_shortcode('elegant-form', array($this,'elegant_form_shortcode'));
	}
	
	/**
	 * short-code generation for front-end view
	 *
	 * @param  mixed $atts
	 * @return void
	 */
	public function elegant_form_shortcode($atts=[]){
		$params = shortcode_atts(
			array(
				'id' => '12345',
			), $atts
		);

		$file = ELEGANT_FORM_DIR_PATH.'public/partials/create-plugin-elegant-form.php';
        ob_start();
        if (file_exists($file)) {
            include_once($file);
        }
        $template = ob_get_contents();
        ob_end_clean();
        echo $template;
	}
	
	/**
	 * Check the initial required option is exist or not, if not exist, then will be created.
	 *
	 * @return void
	 */
	public function dbActivated(){
		$default = array();
        if(!get_option('elegant_form')){
            update_option( 'elegant_form', $default );
        }

		if(!get_option('elegant_form_submit')){
			update_option( 'elegant_form_submit', $default );
		}
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/api/class-elegant-form-settings-api.php';

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
			wp_enqueue_style( $this->plugin_name.'-jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/elegant-form-admin.js', array('jquery'), $this->version, false );

		$valid_page = array('manage-elegant-form','create-elegant-form');
		$page = (isset($_GET['page'])) ? $_GET['page'] : '';

		if(in_array($page,$valid_page)){
			wp_enqueue_script( 'elegant-form-bootstrap-js-support', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array('jquery'), $this->version, false );
			wp_enqueue_script( $this->plugin_name.'-jquery-ui-support', plugin_dir_url( __FILE__ ) . 'js/jquery-ui.min.js', array('jquery'), $this->version, false );
		}

	}
	
	/**
	 * add required dashboard menu
	 *
	 * @return void
	 */
	public function admin_main_menu() {
		add_menu_page( 'Manage Elegant Form', 'Elegant Form', 'manage_options', 'manage-elegant-form', array($this->callbacks,'pageRender'), 'dashicons-welcome-widgets-menus', 90 );

		add_submenu_page( 'manage-elegant-form', 'Manage Elegant Form', 'Manage Elegant Form', 'manage_options', 'manage-elegant-form',array($this->callbacks,'pageRender') );

		add_submenu_page( 'manage-elegant-form', 'Create New Form', 'Create New Form', 'manage_options', 'create-elegant-form',array($this->callbacks,'pageRender') );
	}


	
	/**
	 * set settings of create form page using settings api
	 *
	 * @return void
	 */
	public function setSettings(){
        $args = array(
			array(
				'option_group' => 'elegant_form_settings',
				'option_name' => 'elegant_form',
				'callback' => array( $this->callbacks, 'efSanitize' )
			)
		);

        $this->settings_api->setSettings($args);
    }
    
    /**
     * set sections of create form page using settings api
     *
     * @return void
     */
    public function setSections(){
        $args = array(
            array(
                'id' => 'elegant_form_section',
                'title' => 'Elegant Form Creator',
                'callback' => array($this->callbacks,'efSectionManager'),
                'page' => 'elegant_form'
            )
        );
        $this->settings_api->setSections($args);
    }
    
    /**
     * set required fields of create form page using settings api
     *
     * @return void
     */
    public function setFields(){

        $args = array(
            array(
					'id' => 'form_name',
					'title' => 'Form Name',
					'callback' => array( $this->callbacks, 'textField' ),
					'page' => 'elegant_form',
					'section' => 'elegant_form_section',
					'args' => array(
						'option_name' => 'elegant_form',
						'label_for' => 'form_name',
						'placeholder' => 'Form Name'
					)
				),
				array(
					'id' => 'bg',
					'title' => 'Form Background Color',
					'callback' => array( $this->callbacks, 'textField' ),
					'page' => 'elegant_form',
					'section' => 'elegant_form_section',
					'args' => array(
						'option_name' => 'elegant_form',
						'label_for' => 'bg',
						'placeholder' => 'Form Background Color'
					)
				),
				array(
					'id' => 'text_color',
					'title' => 'Form Text Color',
					'callback' => array( $this->callbacks, 'textField' ),
					'page' => 'elegant_form',
					'section' => 'elegant_form_section',
					'args' => array(
						'option_name' => 'elegant_form',
						'label_for' => 'text_color',
						'placeholder' => 'Form Text Color'
					)
				),

				
        );

        $this->settings_api->setFields($args);
    }
	
	/**
	 * ajax form submit from front end then this action is triggered. 
	 *
	 * @return void
	 */
	public function elegant_form_submit(){

		if (! DOING_AJAX || ! check_ajax_referer('elegant-and-form-nonce', 'nonce') ) {
			return $this->return_json('error');
		}

		if (!empty($_FILES)) {
			$dir = plugin_dir_path( dirname( __FILE__ )).'admin/uploads/';
			$_POST['file'] = [];
			foreach($_FILES['file']['tmp_name'] as $key => $value) {
				$time = microtime(true);
				$filename =  $time.$_FILES['file']['name'][$key];
				$tempFile = $_FILES['file']['tmp_name'][$key];
				$targetFile =  $dir.$filename;
				move_uploaded_file($tempFile,$targetFile);
				array_push($_POST['file'], $filename);
			}
		}

		
		$elegant_form_submit = get_option('elegant_form_submit');
		$elegant_form_submit[] = (object)$_POST;

		$res = update_option( 'elegant_form_submit', $elegant_form_submit );

		if($res){
			return $this->return_json('success');
		}

		return $this->return_json('error');

	}
	
	/**
	 * format return json
	 *
	 * @param  mixed $status
	 * @return void
	 */
	public function return_json($status)
	{
		$return = array(
			'status' => $status
		);
		wp_send_json($return);

		wp_die();
	}

}
