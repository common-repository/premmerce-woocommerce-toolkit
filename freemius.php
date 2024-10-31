<?php
// Create a helper function for easy SDK access.
function premmerce_pwt_fs() {
	global $premmerce_pwt_fs;

	if ( ! isset( $premmerce_pwt_fs ) ) {
		// Include Freemius SDK.
		require_once dirname(__FILE__) . '/freemius/start.php';

		$premmerce_pwt_fs = fs_dynamic_init( array(
			'id'                  => '1491',
			'slug'                => 'premmerce-woocommerce-toolkit',
			'type'                => 'plugin',
			'public_key'          => 'pk_11569102e8e91998c505210b814c2',
			'is_premium'          => false,
			'has_addons'          => false,
			'has_paid_plans'      => false,
			'menu'                => array(
				'slug'           => 'premmerce_toolkit',
				'override_exact' => true,
				'account'        => false,
				'contact'        => false,
				'support'        => false,
				'parent'         => array(
					'slug' => 'premmerce',
				),
			),
		) );
	}

	return $premmerce_pwt_fs;
}

// Init Freemius.
premmerce_pwt_fs();
// Signal that SDK was initiated.
do_action( 'premmerce_pwt_fs_loaded' );

function premmerce_pwt_fs_settings_url() {
	return admin_url( 'admin.php?page=premmerce_toolkit&tab=settings' );
}

premmerce_pwt_fs()->add_filter( 'connect_url', 'premmerce_pwt_fs_settings_url' );
premmerce_pwt_fs()->add_filter( 'after_skip_url', 'premmerce_pwt_fs_settings_url' );
premmerce_pwt_fs()->add_filter( 'after_connect_url', 'premmerce_pwt_fs_settings_url' );
premmerce_pwt_fs()->add_filter( 'after_pending_connect_url', 'premmerce_pwt_fs_settings_url' );