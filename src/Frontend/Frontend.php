<?php

namespace Premmerce\Toolkit\Frontend;
use Premmerce\Toolkit\WordpressSDK\FileManager\FileManager;


/**
 * Class Frontend
 * @package Premmerce\Toolkit\Frontend
 */
class Frontend{

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * Frontend constructor.
	 *
	 * @param FileManager $fileManager
	 */
	public function __construct(FileManager $fileManager){
		$this->registerHooks();

		$this->fileManager = $fileManager;
	}

	/**
	 * register frontend hooks
	 */
	private function registerHooks(){
		if(get_option('premmerce_toolkit_product_video') == 'on'){
			add_action('woocommerce_product_thumbnails', [$this, 'addProductVideo'], 30);
		}

		if(get_option('premmerce_toolkit_head_scripts')){
			add_action('wp_head', [$this, 'addHeaderUserScripts'], 99);
		}

		if(get_option('premmerce_toolkit_footer_scripts')){
			add_action('wp_footer', [$this, 'addFooterUserScripts'], 99);
		}

		if(get_option('premmerce_toolkit_catalog_mode')){
			add_action('init', function(){
				remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
				remove_action('storefront_header', 'storefront_header_cart', 60);
				remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
			});
		}
	}

	/**
	 * Add video to product page
	 */
	public function addProductVideo(){
		wp_enqueue_script('premmerce-toolkit', $this->fileManager->locateAsset('frontend/js/premmerce-toolkit.js'));

		$urls = explode(',', get_post_meta(get_the_ID(), '_product_video_url', true));

		if(get_post_meta(get_the_ID(), '_product_video_url', true) && has_post_thumbnail()){
			$this->fileManager->includeTemplate('frontend/product-video.php', [
				'urls' => $urls,
			]);
		}
	}

	/**
	 * Add user scripts to header
	 */
	public function addHeaderUserScripts(){
		echo get_option('premmerce_toolkit_head_scripts');
	}

	/**
	 * Add user scripts to footer
	 */
	public function addFooterUserScripts(){
		echo get_option('premmerce_toolkit_footer_scripts');
	}
}
