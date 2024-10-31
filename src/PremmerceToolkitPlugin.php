<?php namespace Premmerce\Toolkit;

use Premmerce\Toolkit\Admin\Admin;
use Premmerce\Toolkit\Frontend\Frontend;
use Premmerce\Toolkit\WordpressSDK\FileManager\FileManager;
use Premmerce\Toolkit\WordpressSDK\Notifications\AdminNotifier;
use Premmerce\Toolkit\WordpressSDK\Plugin\PluginInterface;

/**
 * Class PremmerceToolkitPlugin
 * @package Premmerce\Toolkit
 */
class PremmerceToolkitPlugin implements PluginInterface{

	const DOMAIN = 'premmerce-toolkit';

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * @var AdminNotifier
	 */
	private $notifier;

	/**
	 * PremmerceToolkitPlugin constructor.
	 *
	 * @param string $mainFile
	 */
	public function __construct($mainFile){
		$this->fileManager = new FileManager($mainFile);
		$this->notifier    = new AdminNotifier();
		add_action('admin_init', [$this, 'checkRequirePlugins']);
		add_action('init', [$this, 'loadTextDomain']);
	}

	/**
	 * Register plugin hooks
	 */
	private function registerHooks(){

		if(get_option('premmerce_toolkit_shipping_description') == 'on'){
			add_filter('woocommerce_shipping_instance_form_fields_flat_rate', [$this, 'addShippingDescription'], 10, 1);
			add_filter('woocommerce_shipping_instance_form_fields_free_shipping', [
				$this,
				'addShippingDescription',
			], 10, 1);
			add_filter('woocommerce_shipping_instance_form_fields_local_pickup', [
				$this,
				'addShippingDescription',
			], 10, 1);
		}
	}

	/**
	 * Add shipping description to method
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public function addShippingDescription($fields){
		$fields['description'] = [
			'title'       => __('Description', 'premmerce-toolkit'),
			'type'        => 'text',
			'description' => __('Description shipping method', 'premmerce-toolkit'),
			'default'     => '',
			'desc_tip'    => true,
		];

		return $fields;
	}

	/**
	 * Run plugin part
	 */
	public function run(){
		$valid = count($this->validateRequiredPlugins()) === 0;

		if(is_admin()){
			new Admin($this->fileManager);
		}
		
		if($valid){
			$this->registerHooks();

			if(!is_admin()){
				new Frontend($this->fileManager);
			}
		}

	}

	/**
	 * Load plugin translations
	 */
	public function loadTextDomain(){
		$name = $this->fileManager->getPluginName();
		load_plugin_textdomain('premmerce-toolkit', false, $name . '/languages/');
	}

	/**
	 * Check required plugins and push notifications
	 */
	public function checkRequirePlugins(){
		$message = __('The %s plugin requires %s plugin to be active!', 'premmerce-toolkit');

		$plugins = $this->validateRequiredPlugins();

		if(count($plugins)){
			foreach($plugins as $plugin){
				$error = sprintf($message, 'Premmerce WooCommerce Toolkit', $plugin);
				$this->notifier->push($error, AdminNotifier::ERROR, false);
			}
		}

	}

	/**
	 * Validate required plugins
	 *
	 * @return array
	 */
	private function validateRequiredPlugins(){

		$plugins = [];

		if(!function_exists('is_plugin_active')){
			include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		/**
		 * Check if WooCommerce is active
		 **/
		if(!(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active_for_network('woocommerce/woocommerce.php'))){
			$plugins[] = '<a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a>';
		}

		return $plugins;
	}

	/**
	 * Fired when the plugin is activated
	 */
	public function activate(){
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall(){
		delete_option('premmerce_toolkit_product_video');
		delete_option('premmerce_toolkit_product_video');
		delete_option('premmerce_toolkit_head_scripts');
		delete_option('premmerce_toolkit_footer_scripts');
		delete_option('premmerce_toolkit_catalog_mode');
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate(){
	}
}
