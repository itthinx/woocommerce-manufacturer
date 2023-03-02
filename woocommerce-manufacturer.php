<?php
/**
 * woocommerce-manufacturer.php
 *
 * Copyright (c) 2023 www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author itthinx
 * @package woocommerce-manufacturer
 * @since 1.0.0
 *
 * Plugin Name: WooCommerce Manufacturer Taxonomy
 * Plugin URI: https://github.com/itthinx/woocommerce-manufacturer
 * Description: Registers the Manufacturer product taxonomy for WooCommerce.
 * Version: 1.0.0
 * Author: itthinx
 * Author URI: https://www.itthinx.com
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Manufacturer {

	/**
	 * @var string[]
	 */
	private static $active_plugins = null;

	/**
	 * Whether WooCommerce is active.
	 *
	 * @return boolean
	 */
	private static function is_woocommerce_active() {
		if ( self::$active_plugins === null ) {
			self::$active_plugins = (array) get_option( 'active_plugins', array() );
			if ( is_multisite() ) {
				self::$active_plugins = array_merge( self::$active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
			}
		}
		return in_array( 'woocommerce/woocommerce.php', self::$active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', self::$active_plugins );
	}

	/**
	 * Boot this ...
	 */
	public static function boot() {
		if ( self::is_woocommerce_active() ) {
			add_action( 'init', array( __CLASS__, 'init'), 0 );
		}
	}

	public static function init() {
		$labels = array(
			'name'                       => esc_html__( 'Manufacturers', 'woocommerce-manufacturer' ),
			'singular_name'              => esc_html__( 'Manufacturer', 'woocommerce-manufacturer' ),
			'menu_name'                  => esc_html__( 'Manufacturers', ' woocommerce-manufacturer' ),
			'all_items'                  => esc_html__( 'All Manufacturers', ' woocommerce-manufacturer' ),
			'edit_item'                  => esc_html__( 'Edit Manufacturer', ' woocommerce-manufacturer' ),
			'view_item'                  => esc_html__( 'View Manufacturer', ' woocommerce-manufacturer' ),
			'update_item'                => esc_html__( 'Update Manufacturer', ' woocommerce-manufacturer' ),
			'add_new_item'               => esc_html__( 'Add New Manufacturer', ' woocommerce-manufacturer' ),
			'new_item_name'              => esc_html__( 'New Manufacturer Name', ' woocommerce-manufacturer' ),
			'parent_item'                => esc_html__( 'Parent Manufacturer', ' woocommerce-manufacturer' ),
			'parent_item_colon'          => esc_html__( 'Parent Manufacturer:', ' woocommerce-manufacturer' ),
			'search_items'               => esc_html__( 'Search Manufacturers', ' woocommerce-manufacturer' ),
			'popular_items'              => esc_html__( 'Popular Manufacturers', ' woocommerce-manufacturer' ),
			'separate_items_with_commas' => esc_html__( 'Separate manufacturers with commas', ' woocommerce-manufacturer' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove manufacturers', ' woocommerce-manufacturer' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used manufacturers', ' woocommerce-manufacturer' ),
			'not_found'                  => esc_html__( 'No manufacturers found', ' woocommerce-manufacturer' ),
		);
		$args = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'public'            => true,
			'rewrite'           => array(
				'slug'         => 'manufacturer',
				'hierarchical' => false,
				'with_front'   => true
			),
		);
		register_taxonomy( 'manufacturer', array( 'product' ), $args );
	}
}

WooCommerce_Manufacturer::boot();
