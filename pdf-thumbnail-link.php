<?php
/**
 * Plugin Name: PDF Thumbnail Link Block
 * Plugin URI: https://github.com/wpfangirl/pdf-thumbnail-link-block
 * Description: A native WordPress block to display an accessible thumbnail linking to a PDF document with custom link text, layout toggles, and forced download button options.
 * Version: 1.4.3 
 * Author: WP Fangirl
 * Author URI: https://www.wpfangirl.com
 * Text Domain: pdf-thumbnail-link
 * License: GPL-2.0+
 * Requires at least: 6.5
 * Tested up to: 7.0
 * Requires PHP: 7.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the block using the metadata defined in the block.json file.
 */
function wpf_pdf_thumbnail_block_init() {
	// Points to the nested folder containing the block.json file
	register_block_type( __DIR__ . '/pdf-thumbnail' );
}
add_action( 'init', 'wpf_pdf_thumbnail_block_init' );