<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>

	<table class="form-table">

		<tr>
			<th scope="row"><?php _e('Products', 'premmerce-toolkit'); ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="premmerce_toolkit_product_video" <?php checked(get_option('premmerce_toolkit_product_video') == 'on'); ?> /> <?php _e('Product video', 'premmerce-toolkit'); ?>
					</label>
				</fieldset>

				<p class="description"><?php _e('Activate the ability to add videos to the product.', 'premmerce-toolkit'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('WooCommerce settings', 'premmerce-toolkit') ?></th>
			<td>
				<fieldset>
					<label>
						<input type="checkbox" name="premmerce_toolkit_shipping_description" <?php checked(get_option('premmerce_toolkit_shipping_description') == 'on'); ?> /> <?php _e('Shipping description', 'premmerce-toolkit'); ?>
					</label>
				</fieldset>

				<p class="description"><?php _e('Enable the option to add description to shipping methods.', 'premmerce-toolkit'); ?></p>

				<br>

				<fieldset>
					<label>
						<input type="checkbox" name="premmerce_toolkit_catalog_mode" <?php checked(get_option('premmerce_toolkit_catalog_mode') == 'on'); ?> /> <?php _e('Catalog mode', 'premmerce-toolkit'); ?>
					</label>
				</fieldset>

				<p class="description"><?php _e('If you use this option, the user will not be able to buy items in the store.', 'premmerce-toolkit'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><?php _e('User scripts', 'premmerce-toolkit') ?></th>
			<td>
				&lt;head&gt;<br>
				<textarea name="premmerce_toolkit_head_scripts" rows="10" cols="90"><?= get_option('premmerce_toolkit_head_scripts'); ?></textarea><br>
				&lt;/head&gt;
				<br><br>
				&lt;body&gt;<br>
				<textarea name="premmerce_toolkit_footer_scripts" rows="10" cols="90"><?= get_option('premmerce_toolkit_footer_scripts'); ?></textarea><br>
				&lt;/body&gt;
			</td>
		</tr>

	</table>

	<input type="hidden" name="action" value="update" />

	<input type="hidden" name="page_options" value="premmerce_toolkit_product_video,premmerce_toolkit_shipping_description,premmerce_toolkit_head_scripts,premmerce_toolkit_footer_scripts,premmerce_toolkit_catalog_mode" />

	<?php submit_button(__('Save Changes')); ?>
</form>