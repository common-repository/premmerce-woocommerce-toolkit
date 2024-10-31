<?php
if(function_exists('premmerce_pwt_fs') && premmerce_pwt_fs()->is_registered()){
	premmerce_pwt_fs()->add_filter('hide_account_tabs', '__return_true');
	premmerce_pwt_fs()->_account_page_load();
	premmerce_pwt_fs()->_account_page_render();
}
