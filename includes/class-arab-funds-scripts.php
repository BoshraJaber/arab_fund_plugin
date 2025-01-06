<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package Arab Funds
 * @since 1.0.0
 */

class Arab_Funds_Scripts {

	//class constructor
	function __construct()
	{
		
	}
	
	/**
	 * Enqueue Scripts on Admin Side
	 * 
	 * @package Arab Funds
	 * @since 1.0.0
	 */
	public function arab_funds_admin_scripts( $hook_suffix ){
		wp_register_script('arab-funds-admin-script', ARAB_FUNDS_INC_URL . '/js/arab-admin-script.js',array('jquery'),rand());
		if ( function_exists( 'pll_current_language' ) ) {
			$current_language = pll_current_language();
			if( ( $hook_suffix == "post.php" || $hook_suffix == "post-new.php" ) && 'ar' === $current_language ) {
				wp_enqueue_script('arab-funds-admin-script');
			}
		}	

		$localize_scriptArgs = array();
		$current_language = pll_current_language();
        $localize_scriptArgs['ajaxurl'] = admin_url('admin-ajax.php', ( is_ssl() ? 'https' : 'http'));
		$localize_scriptArgs['defaultcountry'] = !empty( $_GET['cid'] ) ? $_GET['cid'] : '';
		$localize_scriptArgs['defaultlang'] = !empty( $current_language ) ? $current_language : '';
		$localize_scriptArgs['no_input'] =  arabfund_plugin_str_display('Search input is required.'); ;
		wp_localize_script('arab-funds-admin-script', 'ArabFundsPublicAdmin', $localize_scriptArgs);

	}

	/**
	 * Enqueue Scripts on Front-side Side
	 * 
	 * @package Arab Funds
	 * @since 1.0.0
	 */
	
	 public function arab_funds_front_scripts() {

		wp_enqueue_style('arab-funds-magnific-style', ARAB_FUNDS_INC_URL . '/css/arab-magnific-css.css', array(), '1.1.0');
		wp_enqueue_style('arab-funds-public-style', ARAB_FUNDS_INC_URL . '/css/arab-custom-style.css', array(), rand());
		
		wp_enqueue_script('arab-funds-magnific-script', ARAB_FUNDS_INC_URL . '/js/arab-magnific-js.js',array('jquery'),'1.1.0');
		wp_register_script('arab-funds-pagination', ARAB_FUNDS_INC_URL . '/js/simplePagination.js',array('jquery'),rand());
		wp_register_script('arab-funds-public-script', ARAB_FUNDS_INC_URL . '/js/arab-custom-script.js',array('jquery'),rand());
        wp_enqueue_script('arab-funds-pagination');
		wp_enqueue_script('arab-funds-public-script');
		

		
        $localize_scriptArgs = array();
		$current_language = pll_current_language();
        $localize_scriptArgs['ajaxurl'] = admin_url('admin-ajax.php', ( is_ssl() ? 'https' : 'http'));
		$localize_scriptArgs['defaultcountry'] = !empty( $_GET['cid'] ) ? $_GET['cid'] : '';
		$localize_scriptArgs['defaultlang'] = !empty( $current_language ) ? $current_language : '';
		$localize_scriptArgs['no_input'] =  arabfund_plugin_str_display('Search input is required.'); ;
		wp_localize_script('arab-funds-public-script', 'ArabFundsPublic', $localize_scriptArgs);

	 }

	 /**
	 * Custom code to replace home url with arabic text.
	 * 
	 * @package Arab Funds
	 * @since 1.0.0
	 */

	 public function arab_replace_home_label( $output ){
		   // Check if Polylang is active
		   if (function_exists('pll_current_language')) {
			// Get the current language slug
			$current_language = pll_current_language('slug');
	
			// Check if the current language is Arabic
			if ($current_language === 'ar') {
				// Define the Arabic translation for "Home"
				$translated_home = 'بيت'; // Replace with your Arabic translation for "Home"
	
				// Find and replace the anchor text for the home page link
				$output = preg_replace('/<a href="[^"]*">Home<\/a>/', '<a href="' . esc_url(home_url('/').'ar/home') . '">' . esc_html($translated_home) . '</a>', $output);
			}
		}
	
		return $output;
	 }


	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package Arab Funds
	 * @since 1.0.0
	 */	
	function add_hooks(){
		
		//add admin scripts
		add_action('admin_enqueue_scripts', array($this, 'arab_funds_admin_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'arab_funds_front_scripts'));
		//add_filter('wpseo_breadcrumb_output', array($this, 'arab_replace_home_label'));

	}
}
?>