<?php

use Premmerce\Toolkit\PremmerceToolkitPlugin;

/**
 * Premmerce WooCommerce Toolkit
 *
 * @package           Premmerce\Toolkit
 *
 * @wordpress-plugin
 * Plugin Name:       Premmerce WooCommerce Toolkit
 * Plugin URI:        https://premmerce.com/woocommerce-toolkit-catalog-mode-product-video/
 * Description:       Plugin add different upgrades
 * Version:           1.1.6
 * Author:            premmerce
 * Author URI:        https://premmerce.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       premmerce-toolkit
 * Domain Path:       /languages
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 3.2.5
 */

// If this file is called directly, abort.
if(!defined('WPINC')){
	die;
}


call_user_func(function(){
	require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

	if(!get_option('premmerce_version')){
		require_once plugin_dir_path(__FILE__) . '/freemius.php';
	}

	$main = new PremmerceToolkitPlugin(__FILE__);

	register_activation_hook(__FILE__, [$main, 'activate']);

	register_uninstall_hook(__FILE__, [\Premmerce\Toolkit\PremmerceToolkitPlugin::class, 'uninstall']);

	$main->run();
});
