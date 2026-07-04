<?php
/**
 * Plugin Name: PDF Thumbnail Link Block
 * Plugin URI: https://github.com/wpfangirl/pdf-thumbnail-link-block
 * Description: A native WordPress block to display an accessible thumbnail linking to a PDF document with custom link text, layout toggles, and forced download button options. Automatic updates via GitHub.
 * Version: 1.5.0 
 * Requires at least: 6.5
 * Tested up to: 7.0
 * Requires PHP: 7.4
 * Author: WP Fangirl
 * Author URI: https://www.wpfangirl.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pdf-thumbnail-link
 * Update URI: https://github.com/wpfangirl/pdf-thumbnail-link-block
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================================
   1. CORE UPDATE CHECK LOGIC
   ========================================================================== */

// Hook into the native WordPress plugin update check for github.com hostnames
add_filter( 'update_plugins_github.com', 'wpfangirl_pdf_block_check_update', 10, 4 );

/**
 * Checks GitHub for plugin updates via the public raw update.json file.
 */
function wpfangirl_pdf_block_check_update( $update, array $plugin_data, string $plugin_file, $locales ) {
    // Ensure we only run this for our specific plugin folder and main file
    if ( 'pdf-thumbnail-link-block/pdf-thumbnail-link.php' !== $plugin_file ) {
        return $update;
    }

    // URL to your public raw JSON file on GitHub
    $json_url = 'https://githubusercontent.com';

    // Fetch the JSON data from GitHub
    $response = wp_remote_get( $json_url, array( 'timeout' => 10 ) );
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return $update;
    }

    // Decode the update data
    $remote_data = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( empty( $remote_data ) || empty( $remote_data['version'] ) ) {
        return $update;
    }

    // Compare versions. If a newer version exists on GitHub, return the update data
    if ( version_compare( $plugin_data['Version'], $remote_data['version'], '<' ) ) {
        return array(
            'slug'        => $remote_data['slug'],
            'version'     => $remote_data['version'],
            'package'     => $remote_data['download_url'],
            'url'         => $plugin_data['PluginURI'],
            'sections'    => isset( $remote_data['sections'] ) ? $remote_data['sections'] : array(),
        );
    }

    return $update;
}

/* ==========================================================================
   2. AUTOMATIC GITHUB ZIP FOLDER FIXER
   ========================================================================== */

// Hook into the source selection process during plugin updates
add_filter( 'upgrader_source_selection', 'wpfangirl_pdf_block_fix_github_folder', 10, 4 );

/**
 * Automatically renames the messy GitHub ZIP folder name during updates.
 */
function wpfangirl_pdf_block_fix_github_folder( $source, $remote_source, $upgrader, $hook_extra ) {
    // Only target our specific plugin update
    if ( ! isset( $hook_extra['plugin'] ) || 'pdf-thumbnail-link-block/pdf-thumbnail-link.php' !== $hook_extra['plugin'] ) {
        return $source;
    }

    // Define the correct, clean target folder path
    $correct_folder_name = 'pdf-thumbnail-link-block';
    $corrected_source = trailingslashit( $remote_source ) . $correct_folder_name;

    // If the directory already matches the correct name, do nothing
    if ( basename( $source ) === $correct_folder_name ) {
        return $source;
    }

    // Rename the folder (e.g., pdf-thumbnail-link-block-main -> pdf-thumbnail-link-block)
    if ( rename( $source, $corrected_source ) ) {
        return trailingslashit( $corrected_source );
    }

    return $source;
}

/* ==========================================================================
   Register the block using the metadata defined in the block.json file.
   ========================================================================== */

function wpf_pdf_thumbnail_block_init() {
	register_block_type( __DIR__ . '/pdf-thumbnail' );
}
add_action( 'init', 'wpf_pdf_thumbnail_block_init' );