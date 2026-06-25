<?php
/**
 * OneMeta Demo — Demo Content Seeding
 *
 * On theme activation, creates one "OneMeta Demo" page, sets it as the
 * static front page, and pre-fills every field group registered in
 * onemeta-field-groups.php with real saved values — so the front end
 * isn't blank on first load. Values are only ever seeded once per field;
 * if a visitor edits the page and re-saves, their values are never
 * overwritten on a later activation.
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create (or locate) the demo page and seed its meta.
 */
function omd_seed_demo_content(): void {

	$page_id = (int) get_option( 'omd_demo_page_id' );

	if ( ! $page_id || ! get_post( $page_id ) ) {
		$page_id = wp_insert_post(
			[
				'post_title'   => __( 'OneMeta Demo', 'onemeta-demo' ),
				'post_name'    => 'onemeta-demo',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			],
			true
		);

		if ( is_wp_error( $page_id ) ) {
			return;
		}

		update_option( 'omd_demo_page_id', $page_id );
	}

	// Make the demo page the homepage so the seeded meta boxes are
	// reachable from Pages → OneMeta Demo → Edit, one click from wp-admin.
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $page_id );

	omd_seed_field_values( (int) $page_id );
}

add_action( 'after_switch_theme', 'omd_seed_demo_content' );

/**
 * Write seed values directly via update_post_meta(), bypassing the editor.
 * Each key is only written if it has never been saved before, so a
 * visitor's own edits always win on subsequent activations.
 */
function omd_seed_field_values( int $page_id ): void {

	$seed = [

		// Field Types Lab
		'demo_text'          => 'Hello from OneMeta',
		'demo_textarea'      => "OneMeta is a free, open-source custom fields plugin for WordPress.\n\nThis paragraph is stored in a Textarea field.",
		'demo_url'           => 'https://fronttheme.com',
		'demo_email'         => 'hello@fronttheme.com',
		'demo_date'          => gmdate( 'Y-m-d' ),
		'demo_toggle'        => '1',
		'demo_select'        => 'grid',
		'demo_radio'         => 'medium',
		'demo_button_group'  => 'center',
		'demo_checkbox'      => [ 'wifi', 'pets' ],

		// Repeater Lab
		'team_members'       => [
			[
				'member_name'   => 'Faruk Ahmed',
				'member_role'   => 'Lead Developer',
				'member_avatar' => 0,
			],
			[
				'member_name'   => 'Amina Rahman',
				'member_role'   => 'UI Designer',
				'member_avatar' => 0,
			],
			[
				'member_name'   => 'Tahmid Hasan',
				'member_role'   => 'QA Engineer',
				'member_avatar' => 0,
			],
		],

		// Conditional Lab
		'lab_fruit'          => 'banana',
		'lab_available'      => '1',
		'lab_and_rule'       => 'Visible: Fruit is Banana AND Available is on.',
		'lab_or_rule'        => 'Hidden right now — Banana is neither Apple nor Cherry.',
		'lab_contains_rule'  => 'Visible: "banana" contains "an".',
		'lab_mixed_and_rule' => 'Hidden right now — "banana" contains "an", so the !contains rule fails.',
	];

	foreach ( $seed as $key => $value ) {
		$meta_key = 'onemeta_' . $key;

		if ( metadata_exists( 'post', $page_id, $meta_key ) ) {
			continue; // Respect anything the visitor has already saved.
		}

		update_post_meta( $page_id, $meta_key, $value );
	}
}

/**
 * Convenience admin notice linking straight to the demo page editor,
 * shown once right after activation.
 */
function omd_activation_notice(): void {
	if ( ! get_transient( 'omd_show_activation_notice' ) ) {
		return;
	}

	delete_transient( 'omd_show_activation_notice' );

	$page_id = (int) get_option( 'omd_demo_page_id' );
	if ( ! $page_id ) {
		return;
	}

	printf(
		'<div class="notice notice-success is-dismissible"><p>%s <a href="%s">%s</a></p></div>',
		esc_html__( 'OneMeta Demo is ready.', 'onemeta-demo' ),
		esc_url( get_edit_post_link( $page_id, '' ) ),
		esc_html__( 'Edit the demo page →', 'onemeta-demo' )
	);
}

add_action( 'admin_notices', 'omd_activation_notice' );

function omd_set_activation_notice_flag(): void {
	set_transient( 'omd_show_activation_notice', true, MINUTE_IN_SECONDS * 5 );
}

add_action( 'after_switch_theme', 'omd_set_activation_notice_flag' );
