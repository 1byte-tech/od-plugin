 <?php
/**
 * Add the top level menu page.
 */
function aod_options_page() {
	add_menu_page(
		esc_html__( 'Order Defense', 'axon-order-defense' ),
		esc_html__( 'Order Defense', 'axon-order-defense' ),
		'manage_options',
		'aod_setting',
		'aod_options_page_html',
		'',
		30
	);
	
	wp_enqueue_style( 'aod-admin-style' );

}


/**
 * Register our aod_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'aod_options_page' );


/**
 * Top level menu callback function
 */
function aod_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<div class="aod-multi-step-wrap">
			<input id="aod-multi-step" type="hidden" value="1">
			<h1>Order Defense</h1>
			<h2>Delivery Insurance Integration</h2>
			<p>Fill the following steps to integrate order defense.</p>
			<ul class="aod-multi-step-progress">
				<li class="step1 active">
					<i class="aod-svg">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM160 152c0-13.3 10.7-24 24-24h88c44.2 0 80 35.8 80 80c0 28-14.4 52.7-36.3 67l34.1 75.1c5.5 12.1 .1 26.3-11.9 31.8s-26.3 .1-31.8-11.9L268.9 288H208v72c0 13.3-10.7 24-24 24s-24-10.7-24-24V264 152zm48 88h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H208v64z"/></svg>
					</i>
					<strong>Register</strong>
				</li>
				<li class="step2">
					<i class="aod-svg">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
					</i>
					<strong>Billing</strong>
				</li>
				<li class="step3">
					<i class="aod-svg">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M352 144c0-44.2 35.8-80 80-80s80 35.8 80 80v48c0 17.7 14.3 32 32 32s32-14.3 32-32V144C576 64.5 511.5 0 432 0S288 64.5 288 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H352V144z"/></svg>
					</i>
					<strong>Permission</strong>
				</li>
				<li class="step4">
					<i class="aod-svg">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M326.3 218.8c0 20.5-16.7 37.2-37.2 37.2h-70.3v-74.4h70.3c20.5 0 37.2 16.7 37.2 37.2zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-128.1-37.2c0-47.9-38.9-86.8-86.8-86.8H169.2v248h49.6v-74.4h70.3c47.9 0 86.8-38.9 86.8-86.8z"/></svg>
					</i>
					<strong>Product</strong>
				</li>
				<li class="step4">
					<i class="aod-svg">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
					</i>
					<strong>Finish</strong>
				</li>
			</ul>
			<div class="aod-multi-steps">
				<div class="aod-multi-step step1 active">
					<p class="aod-multi-step-count">step 1 - 5</p>
					<input id="registration" class="regular-text" name="aod_options[registration]" type="text" placeholder="Enter link">
					<p class="description"><?php esc_html_e( 'Get link from order defense.', 'axon-order-defense' ); ?></p>
					<div class="aod-setting-btns">
						<button data-step="1" class="button button-primary aod-setting-btn aod-register"><?php esc_html_e( 'Next', 'axon-order-defense' ); ?></button>
					</div>
				</div>
				<div class="aod-multi-step step2">
					<p class="aod-multi-step-count">step 2 - 5</p>
					<input id="setup_billing" class="regular-text" name="aod_options[setup_billing]" type="text" placeholder="Enter link">
					<p class="description"><?php esc_html_e( 'Get link from order defense.', 'axon-order-defense' ); ?></p>
					<div class="aod-setting-btns">
						<button data-step="2" class="button button-primary aod-setting-btn aod-prev"><?php esc_html_e( 'Prev', 'axon-order-defense' ); ?></button>
						<button class="button button-primary aod-setting-btn aod-setup-billing"><?php esc_html_e( 'Next', 'axon-order-defense' ); ?></button>
					</div>
				</div>
				<div class="aod-multi-step step3">
					<p class="aod-multi-step-count">step 3 - 5</p>
					<input id="api_permission" class="regular-text" name="aod_options[api_permission]" type="text" placeholder="Enter link">
					<p class="description"><?php esc_html_e( 'Give api permission to order defense.', 'axon-order-defense' ); ?></p>
					<div class="aod-setting-btns">
						<button data-step="3" class="button button-primary aod-setting-btn aod-prev"><?php esc_html_e( 'Prev', 'axon-order-defense' ); ?></button>
						<button class="button button-primary aod-setting-btn aod-api-permission"><?php esc_html_e( 'Next', 'axon-order-defense' ); ?></button>
					</div>
				</div>
				<div class="aod-multi-step step4">
					<p>step 4 - 5</p>
					<input id="setup_product" class="regular-text" name="aod_options[setup_product]" type="text" placeholder="Enter product title">
					<p class="description"><?php esc_html_e( 'Set up insurance product.', 'axon-order-defense' ) ?></p>
					<div class="aod-setting-btns">
						<button data-step="4" class="button button-primary aod-setting-btn aod-prev"><?php esc_html_e( 'Prev', 'axon-order-defense' ); ?></button>
						<button class="button button-primary aod-setting-btn aod-setup-product"><?php esc_html_e( 'Next', 'axon-order-defense' ); ?></button>
					</div>
				</div>
				<div class="aod-multi-step step5">
					<p>step 5 - 5</p>
					<h2>Success !</h2>
					<i class="aod-svg">
						<svg fill="#2271b1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
					</i>
					<p><?php esc_html_e( 'You have successfully integrate order defense.', 'axon-order-defense' ) ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php
}