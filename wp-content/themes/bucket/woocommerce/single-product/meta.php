<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option( 'woocommerce_enable_sku' ) == 'yes' && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', wpgrade::textdomain() ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span>.</span>
	<?php endif; ?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		echo $product->get_categories( ' ', '<div class="btn-list">' . _n( '<div class="btn  btn--small  btn--secondary">Category</div>', '<div class="btn  btn--small  btn--secondary">Categories</div>', $size, wpgrade::textdomain() ) . ' ', '</div>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo $product->get_tags( ' ', '<div class="btn-list">' . _n( '<div class="btn  btn--small  btn--secondary">Tag:</div>', '<div class="btn  btn--small  btn--secondary">Tags:</div>', $size, wpgrade::textdomain() ) . ' ', '</div>' );
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>