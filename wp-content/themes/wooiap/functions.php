<?php 
/**
 * Display Header Cart
 *
 * @since  1.0.0
 * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
 * @return void
 */
function storefront_header_cart() {
	if ( storefront_is_woocommerce_activated() ) {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
	<ul id="site-header-cart" class="site-header-cart menu">
		<li class="<?php echo esc_attr( $class ); ?>">
			<?php storefront_cart_link(); ?>
		</li>
		<li>
			<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
		</li>
	</ul>
		<?php
	}
}


function iap_add_styles() {
	wp_enqueue_style( 'google-font', 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap', array(), false);
}
add_action( 'wp_enqueue_scripts', 'iap_add_styles' );



add_action( 'wp_head', 'remove_my_class_action' );
function remove_my_class_action() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
}

add_action( 'wp_head', 'iap_woocommerce_functions', 10 );

function iap_woocommerce_functions() {
	// remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	
	// add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_title', 5 );
	// add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title', 5 );
}

