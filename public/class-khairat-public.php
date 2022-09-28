<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       khairat
 * @since      1.0.0
 *
 * @package    Khairat
 * @subpackage Khairat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Khairat
 * @subpackage Khairat/public
 * @author     khairat <khairat>
 */
class Khairat_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Khairat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Khairat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/khairat-public.css', array(), $this->version, 'all' );
		$files = glob(KHAI_PATH . '/myapp/dist/assets/*.css');
		
		foreach ($files AS $key => $val){
			wp_enqueue_style( 'svelte_my-app#'.$key , KHAI_URL.'/myapp/dist/assets/' . basename($val) , array(), null, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Khairat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Khairat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */




		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/khairat-public.js', array( 'jquery' ), $this->version, false );
		$files = glob(KHAI_PATH . '/myapp/dist/assets/*.js');
		
		foreach ($files AS $key => $val){
			wp_enqueue_script( 'svelte_my-app#'.$key , KHAI_URL.'/myapp/dist/assets/' . basename($val) , array(), null, true );
		}
		wp_localize_script( 'svelte_my-app#'.$key, 'frontend_ajax_object',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'statuslogin' => wp_get_current_user()
			)
		);

	}


	public function add_type_attribute($tag, $handle, $src) {
		// if not your script, do nothing and return original $tag
		if (strpos($handle, 'svelte_my-app') !== false) {
			$tag = '<script type="module" crossorigin src="' . esc_url( $src ) . '"></script>';
			return $tag;
		}
		
		return $tag;
	}


	public function khai_wp_head(){
		// global $wp ; 

		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/khairat.php';
		
	}


	public function khai_woocommerce_register_form(){
		require_once KHAI_PATH . '/public/khai_woocommerce_register_form.php' ;

	}

	public function khai_woocommerce_created_customer($customer_id, $new_customer_data, $password_generated){
		
		if($_POST['type_reg'] === 'pentadbir'){
			$updated = update_user_meta( $customer_id, 'wp_capabilities', array('pentadbir' => 1) );
			$updated = update_user_meta( $customer_id, 'stage_daftar', 0 );
		}

		if($_POST['type_reg'] === 'ahli'){
			$updated = update_user_meta( $customer_id, 'wp_capabilities', array('ahli' => 1) );
			$updated = update_user_meta( $customer_id, 'stage_daftar', 0 );
			$updated = update_user_meta( $customer_id, 'select_kariah', $_POST['select_kariah'] );
		}

	}

	
	public function khai_template_redirect(){
		global $wp ;

		if(isset($wp->query_vars) && isset($wp->query_vars['pagename']) && $wp->query_vars['pagename'] === 'my-account'){
			if(wp_get_current_user()->ID !== 0 ){
				require_once KHAI_PATH . '/public/khairat.php' ;
				exit();
			}
			

		}



	}

	public function khai_check_admin_referer($action, $result)
	{
		/**
		 * Allow logout without confirmation
		 */
		if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
			$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : home_url('my-account');
			$location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
			header("Location: $location");
			die;
		}
	}


}
