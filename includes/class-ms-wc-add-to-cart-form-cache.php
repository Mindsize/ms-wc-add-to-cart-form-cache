<?php
/**
 * WC Add To Cart Form Cache
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-2.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mindsize.me so we can send you a copy immediately.
 *
 * @package   Mindsize/WC_Add_To_Cart_Form_Cache
 * @author    Mindsize
 * @copyright Copyright (c) 2017, Mindsize, LLC.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2.0
 */

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * If the class already exists, no need to redeclare it.
 */
if( class_exists( 'MS_WC_Add_To_Cart_Form_Cache' ) ) {
	return;
}

/**
 * Class WP_Sample_HTML_Fragment_Cache
 *
 * @since 1.0.0
 */
class MS_WC_Add_To_Cart_Form_Cache extends WP_Fragment_HTML_Cache {

	/**
	 * The slug of the fragment cache prefixes all hooks and is sanitized to create the default cache directory.
	 *
	 * @var string
	 */
	protected $slug = 'wc-add-to-cart-form';

	public function get_cache_start_comment() {
		return __( 'Start Secret Mindsize.me Fragment Cache Sauce', 'wc-add-to-cart-form-cache' );
	}

	public function get_cache_close_comment() {
		return __( 'End Secret Mindsize.me Fragment Cache Sauce', 'wc-add-to-cart-form-cache' );
	}
}
