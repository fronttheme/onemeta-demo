<?php
/**
 * OneMeta Demo — Theme Bootstrap
 *
 * Demonstration and test-harness theme for the OneMeta custom fields plugin.
 * Not intended for production use.
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'OMD_VERSION', '1.0.0' );
define( 'OMD_DIR', get_template_directory() );
define( 'OMD_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function omd_setup(): void {
	load_theme_textdomain( 'onemeta-demo', OMD_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
}
add_action( 'after_setup_theme', 'omd_setup' );

/**
 * Enqueue assets.
 *
 * Buildless by design — OneMeta integration requires zero tooling,
 * and this theme proves it. Plain CSS + vanilla JS only.
 */
function omd_assets(): void {
	wp_enqueue_style( 'onemeta-demo-style', get_stylesheet_uri(), [], OMD_VERSION );
	wp_enqueue_script( 'onemeta-demo-script', OMD_URI . '/assets/js/demo.js', [], OMD_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'omd_assets' );

/**
 * Whether the OneMeta plugin is active and its helper functions are available.
 *
 * Field groups registered below via the `onemeta_field_groups` filter still
 * work even if the plugin itself is inactive — the filter simply won't fire.
 * Template code guards every integration point with this check, the same
 * pattern a real theme or plugin should use when OneMeta is an optional
 * dependency rather than a hard requirement.
 */
function omd_onemeta_active(): bool {
	return function_exists( 'onemeta_get_meta' ) && function_exists( 'onemeta_get_user_meta' );
}

require_once OMD_DIR . '/inc/onemeta-field-groups.php';
require_once OMD_DIR . '/inc/demo-content.php';
require_once OMD_DIR . '/inc/template-functions.php';
