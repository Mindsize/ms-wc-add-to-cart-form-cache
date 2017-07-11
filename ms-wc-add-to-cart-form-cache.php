<?php
/**
 * Plugin Name: Mindsize - WC Add to Cart Form Cache
 * Description: Sample plugin for showing how caching of variable product add to cart forms in WC can be achieved.
 * Version: 1.0.0
 * Author: Mindsize
 * Author URI: http://mindsize.me/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

function ms_cached_woocommerce_variable_add_to_cart_init() {
	$priority = apply_filters( 'woocommerce_variable_add_to_cart_priority', 30 );
	remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', $priority );
	add_action( 'woocommerce_variable_add_to_cart', 'ms_cached_woocommerce_variable_add_to_cart', $priority );
}

add_action( 'woocommerce_init', 'ms_cached_woocommerce_variable_add_to_cart_init' );

function ms_cached_woocommerce_variable_add_to_cart() {
	global $product;

	// Enqueue variation scripts
	wp_enqueue_script( 'wc-add-to-cart-variation' );

	ms_wc_cart_form_cacher()->do( 'ms_wc_variations_forms_output_form', array( 'product_id' => absint( $product->get_id() ) ) );
}

function ms_wc_variations_forms_output_form() {
	global $product;

	// Get Available variations?
	$get_variations = sizeof( $product->get_children() )
	                  <= apply_filters( 'woocommerce_ajax_variation_threshold', 999999999, $product );

	// Load the template
	wc_get_template( 'single-product/add-to-cart/variable.php', array(
		'available_variations' => $get_variations ? $product->get_available_variations() : false,
		'attributes'           => $product->get_variation_attributes(),
		'selected_attributes'  => $product->get_default_attributes(),
	) );
}

function ms_wc_cart_form_cache_add_product_id_to_uri( $base, $conditions, $cacher ) {
	$product_id = isset( $conditions[ 'product_id' ] ) ? absint( $conditions[ 'product_id' ] ) : 0;

	return ( 0 < $product_id ) ? trailingslashit( $cacher->get_cache_path( $product_id ) ) : $base;
}

add_filter( 'wc-add-to-cart-form_file_base', 'ms_wc_cart_form_cache_add_product_id_to_uri', 10, 3 );

function ms_wc_cart_form_cache_clear_on_save( $product, $data_store ) {
	ms_wc_cart_form_cacher()->clear_cache( $product->get_id() );
}

add_action( 'woocommerce_before_product_object_save', 'ms_wc_cart_form_cache_clear_on_save', 10, 2 );

function ms_wc_cart_form_cacher() {
	global $ms_wc_cart_form_cacher;

	require_once 'includes/class-ms-wc-add-to-cart-form-cache.php';
	$ms_wc_cart_form_cacher = new MS_WC_Add_To_Cart_Form_Cache();

	return $ms_wc_cart_form_cacher;
}