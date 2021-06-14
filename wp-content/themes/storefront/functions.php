<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

// function zebra_register_scripts() {
// 	wp_enqueue_script('zone-filter-js', get_template_directory_uri() . '/filter.js', ['jquery'], null, true);

// 	wp_localize_script( 'zone-filter-js', 'zebra', array(
// 	    'nonce'    => wp_create_nonce( 'zebra' ),
// 	    'ajax_url' => admin_url( 'admin-ajax.php' )
// 	));
// }
// add_action( 'wp_enqueue_scripts', 'zebra_register_scripts' );

// function get_zona_livrare($zona) {
	
// 	/**
// 	 * This values would come from a admin screen. In next iteration
// 	 */

// 	$zona_livrare = array();
	
// 	// Grigorescu, Baciu, Dâmbul Rotund, Gruia, Iris 
// 	$zona_livrare['zona_1']['comanda_minima'] = 30;
// 	$zona_livrare['zona_1']['fs_mimimum_amount'] = 40;


// 	// Centru, Mărăşti, Gheorgheni, Andrei Mureşanu, Între Lacuri, Plopilor, Mănăştur, Bulgari
// 	$zona_livrare['zona_2']['comanda_minima'] = 40;
// 	$zona_livrare['zona_2']['fs_mimimum_amount'] = 50;


// 	// Centru, Sopor, Borhanci, Europa, Zorilor, Buna Ziua
// 	$zona_livrare['zona_3']['comanda_minima'] = 50;
// 	$zona_livrare['zona_3']['fs_mimimum_amount'] = 60;


// 	// Someşeni, Becaş, Făget, Florest
// 	$zona_livrare['zona_4']['comanda_minima'] = 70;
// 	$zona_livrare['zona_4']['fs_mimimum_amount'] = 70;


// 	// Feleacu 
// 	$zona_livrare['zona_5']['comanda_minima'] = 80;
// 	$zona_livrare['zona_5']['fs_mimimum_amount'] = 80;


// 	// Apahida, Gilău 
// 	$zona_livrare['zona_6']['comanda_minima'] = 100;
// 	$zona_livrare['zona_6']['fs_mimimum_amount'] = 100;

// 	return $zona_livrare[$zona];
// }

// add_action( 'woocommerce_check_cart_items', 'required_min_cart_subtotal_amount' );
// function required_min_cart_subtotal_amount() {

//     // Get mimimum account based on neighbourhood zone. And set it.
//     $shipping_zone = get_zona_livrare(WC()->session->get('zona_livrare'));

//     $minimum_amount = $shipping_zone['comanda_minima'];
//     $fs_mimimum_amount = $shipping_zone['fs_mimimum_amount'];

//     // Total (before taxes and shipping charges)
//     $cart_subtotal = WC()->cart->subtotal;

//     // Add an error notice is cart total is less than the minimum required
//     if( $cart_subtotal < $minimum_amount  ) {
//         // Display an error message
//         wc_add_notice( '<strong>' . sprintf( __("A minimum total purchase amount of %s is required to checkout."), wc_price($minimum_amount) ) . '<strong>', 'error' );
//         // Optional: remove proceed to checkout button
//         remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
//     }  else {
//     	// WC()->session->__unset( 'zona_livrare' );
//     }         
// }

// function add_shipping_zone_to_session(){
// 	return WC()->session->set( 'zona_livrare', 'zona_6' );
// }
// add_action( 'woocommerce_init', 'add_shipping_zone_to_session' );
// add_action('wp_ajax_do_add_shipping_zone_to_session', 'add_shipping_zone_to_session');
// add_action('wp_ajax_nopriv_do_add_shipping_zone_to_session', 'add_shipping_zone_to_session');

// add_filter('woocommerce_package_rates', 'change_shipping_method_based_on_cart_total', 11, 2);
// function change_shipping_method_based_on_cart_total( $rates, $package ) {
// 	$total_cart = WC()->cart->subtotal;
// 	$shipping_zone = get_zona_livrare(WC()->session->get('zona_livrare'));


//     if ( $total_cart <  $shipping_zone['fs_mimimum_amount'] ) {
// 		unset($rates['free_shipping:5']);
//     } else {
// 		unset($rates['flat_rate:4']);
//     }

// 	return $rates;
 
// }

/**
 * Ce mai trebuie sa facem.
 * - pop-up alegere zona.
 * - posibilitate editare zona / update zona in session.
 */