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


/**
 * Adauga un prag minim pentru comanda.
 * */
add_action( 'woocommerce_check_cart_items', 'iap_required_min_cart_subtotal_amount' );
function iap_required_min_cart_subtotal_amount() {

	// setam pragul minim
	$minimum_amount = 50;

	// Sub-total (inainte de taxe si taxe de expediere)
	$cart_subtotal = WC()->cart->subtotal;

	// Cat mai avem de cumparat 
	$money_to_spend = $minimum_amount - $cart_subtotal;

	// Adauga o notificare in cos cumparaturi daca nu este indeplinita conditia.
	if( $cart_subtotal < $minimum_amount  ) {

		// Afiseaza mesaj de eroare
		wc_add_notice( '' . sprintf( __("Comanda minima este de <strong>%1s</strong>. Pentru a putea finaliza comanda trebuie sa mai adaugati in cos produse in valoare de <strong>%2s</strong>."),wc_price($minimum_amount), wc_price($money_to_spend) ) . '', 'error' );

		// Optional: sterge butonul de checkout
		remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
	}	
}


/**
 * Ascunde celelate metode de livrare daca freeshipping este activ.
 * */
function iap_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'iap_hide_shipping_when_free_is_available', 100 );

function iap_show_custom_product_message()  {
	
	$product_id = get_the_ID();
	$categorii = get_the_terms( $product_id, 'product_cat' );
	// var_dump($categorii);
	foreach ($categorii as $categorie) {
		if ( $categorie->term_id == '16' ) : 
			echo '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">
			Acest produs face parte din gama produselor <strong>ECO</strong>.	</div></div>';  
		endif;
	}

	// if ( $product_id == '14' ) :
	// 	echo '<div class="woocommerce-notices-wrapper"><div class="woocommerce-message" role="alert">
	// 	Acest produs face parte din gama produselor <strong>ECO</strong>.	</div></div>';
	// else: 
	// 	// nu afisa nimic
	// endif;
};

add_action( 'woocommerce_single_product_summary', 'iap_show_custom_product_message', $priority = 20 );