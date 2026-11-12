<?php
/**
 * OneMeta Demo — Field Group Registration
 *
 * Registers every demo field group via the `onemeta_field_groups` filter —
 * the exact mechanism OneMeta's own "Export as PHP" feature generates.
 * Nothing here touches the builder UI or the wp_onemeta_field_groups table;
 * these groups exist purely in code, the same way a theme bundling OneMeta
 * fields for distribution would.
 *
 * Schema confirmed directly against includes/Admin/FieldTypeSchemas.php and
 * includes/Core/Sanitizer.php — every key below (choices, sub_fields,
 * button_text, return_format, etc.) is taken from the real source, not
 * reconstructed from docs.
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'onemeta_field_groups', 'omd_register_field_types_lab' );
add_filter( 'onemeta_field_groups', 'omd_register_repeater_lab' );
add_filter( 'onemeta_field_groups', 'omd_register_conditional_lab' );
add_filter( 'onemeta_field_groups', 'omd_register_user_meta_lab' );

/**
 * Field Types Lab — every field type, post meta.
 *
 * Includes the undocumented `heading` type (display-only, registered in
 * FieldTypeSchemas.php and the field palette, but absent from the GitHub
 * README / readme.txt / docs site "14 field types" list and field-type
 * count). It stores no value — onemeta_get_meta() has nothing to return
 * for it — so it's shown separately at the top rather than mixed into
 * the data-bearing fields below.
 */
function omd_register_field_types_lab( array $groups ): array {

	$groups['omd_field_types_lab'] = [
		'title'     => 'Field Types Lab',
		'type'      => 'post',
		'post_type' => 'page',
		'position'  => 'normal',
		'fields'    => [

			// Display-only — renders an HTML tag + optional separator in the
			// meta box. No 'conditional' key: FieldTypeSchemas explicitly
			// skips heading when generating conditional-logic support.
			'demo_heading' => [
				'type'      => 'heading',
				'label'     => 'This Is a Heading Field',
				'tag'       => 'h3',
				'separator' => '0',
			],

			'demo_text' => [
				'type'        => 'text',
				'label'       => 'Text',
				'description' => 'A single line of plain text.',
				'placeholder' => 'e.g. Faruk Ahmed',
				'default'     => '',
				'maxlength'   => 255,
			],

			'demo_textarea' => [
				'type'        => 'textarea',
				'label'       => 'Textarea',
				'description' => 'Multi-line text, with line breaks preserved on output.',
				'placeholder' => 'Write a short bio…',
				'default'     => '',
				'rows'        => 4,
				'maxlength'   => 1000,
			],

			'demo_url' => [
				'type'        => 'url',
				'label'       => 'URL',
				'description' => 'Validated as a URL on save.',
				'placeholder' => 'https://fronttheme.com',
				'default'     => '',
			],

			'demo_email' => [
				'type'        => 'email',
				'label'       => 'Email',
				'description' => 'Validated as an email address on save.',
				'placeholder' => 'hello@fronttheme.com',
				'default'     => '',
			],

			'demo_date' => [
				'type'        => 'date',
				'label'       => 'Date',
				'description' => 'Stored in Y-m-d format.',
				'default'     => '',
			],

			'demo_toggle' => [
				'type'        => 'toggle',
				'label'       => 'Toggle',
				// 'default' is the toggle's OWN default state ('0'/'1') —
				// on_text/off_text only relabel the switch in the editor UI;
				// onemeta_get_meta() still returns the raw "0"/"1" string.
				'default'     => '0',
				'on_text'     => 'Featured',
				'off_text'    => 'Not Featured',
				'description' => 'Returns "1" when on, empty string when off — not a boolean. on_text/off_text only relabel the editor UI switch.',
			],

			'demo_select' => [
				'type'        => 'select',
				'label'       => 'Select',
				'description' => 'Dropdown — returns the selected key, not the label.',
				'choices'     => [
					'grid' => 'Grid View',
					'list' => 'List View',
					'map'  => 'Map View',
				],
				'default'     => 'grid',
				'allow_null'  => '0',
			],

			'demo_radio' => [
				'type'        => 'radio',
				'label'       => 'Radio',
				'description' => 'Single choice, rendered as radio buttons.',
				'choices'     => [
					'small'  => 'Small',
					'medium' => 'Medium',
					'large'  => 'Large',
				],
				'default'     => 'medium',
				'layout'      => 'horizontal',
			],

			'demo_button_group' => [
				'type'        => 'button_group',
				'label'       => 'Button Group',
				'description' => 'Single choice, rendered as a segmented button row.',
				'choices'     => [
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right',
				],
				'default'     => 'left',
			],

			'demo_checkbox' => [
				'type'        => 'checkbox',
				'label'       => 'Checkbox',
				'description' => 'Multiple choice — returns an array of selected values. (The builder UI authors the default as a comma-separated string and converts it to this array shape before saving; registering it directly in code, like here, skips that step.)',
				'choices'     => [
					'wifi'    => 'WiFi',
					'parking' => 'Parking',
					'pets'    => 'Pet Friendly',
				],
				'default'     => [ 'wifi', 'pets' ],
				'layout'      => 'vertical',
			],

			'demo_image'       => [
				'type'          => 'image',
				'label'         => 'Image (return_format: id)',
				'description'   => 'Returns a plain attachment ID — the default.',
				'return_format' => 'id',
				'preview_size'  => 'medium',
			],

			// Same field type, different return_format — surfaces
			// FieldValueResolver::build_image_array(), which most users
			// never see since 'id' is the default everywhere else.
			'demo_image_array' => [
				'type'          => 'image',
				'label'         => 'Image (return_format: array)',
				'description'   => 'Returns a structured array: id, url, alt, title, width, height, sizes.',
				'return_format' => 'array',
				'preview_size'  => 'medium',
			],

			'demo_file' => [
				'type'          => 'file',
				'label'         => 'File',
				'description'   => 'Returns an attachment ID for any uploaded file (restricted here to documents).',
				'button_text'   => 'Select Document',
				'file_type'     => 'document',
				'return_format' => 'id',
			],

			'demo_gallery' => [
				'type'          => 'gallery',
				'label'         => 'Gallery',
				'description'   => 'Returns an array of attachment IDs by default — note the plural "ids", unlike Image/File\'s singular "id".',
				'button_text'   => 'Add Images',
				'min'           => 0,
				'max'           => 6,
				'return_format' => 'ids',
			],

		],
	];

	return $groups;
}

/**
 * Repeater Lab — repeatable team-member rows, post meta.
 */
function omd_register_repeater_lab( array $groups ): array {

	$groups['omd_repeater_lab'] = [
		'title'     => 'Repeater Lab',
		'type'      => 'post',
		'post_type' => 'page',
		'position'  => 'normal',
		'fields'    => [
			'team_members' => [
				'type'        => 'repeater',
				'label'       => 'Team Members',
				'description' => 'Add, remove, and reorder rows. Each row carries name, role, and an avatar.',
				'button_text' => 'Add Team Member',
				'min_rows'    => 0,
				'max_rows'    => 8,
				'sub_fields'  => [
					[
						'key'         => 'member_name',
						'type'        => 'text',
						'label'       => 'Name',
						'placeholder' => 'Full name',
					],
					[
						'key'         => 'member_role',
						'type'        => 'text',
						'label'       => 'Role',
						'placeholder' => 'e.g. Lead Developer',
					],
					[
						'key'           => 'member_avatar',
						'type'          => 'image',
						'label'         => 'Avatar',
						'return_format' => 'id',
					],
				],
			],
		],
	];

	return $groups;
}

/**
 * Conditional Lab — two control fields, four dependents demonstrating
 * AND, OR, and single-rule conditions.
 *
 * IMPORTANT: the public docs site and the original product-page FAQ both
 * show a single-condition shape — 'conditional' => ['field' => ...,
 * 'operator' => ..., 'value' => ...]. That shape does NOT match what the
 * plugin actually saves. The real shape, confirmed against
 * AdminAjax::sanitize_array_setting()'s 'conditional' case (and matching
 * the example on the in-plugin Documentation page, which IS correct) is:
 *
 *   'conditional' => [
 *       'relation' => 'AND' | 'OR',
 *       'rules'    => [
 *           [ 'field' => '...', 'operator' => '...', 'value' => '...' ],
 *       ],
 *   ]
 */
function omd_register_conditional_lab( array $groups ): array {

	$groups['omd_conditional_lab'] = [
		'title'     => 'Conditional Lab',
		'type'      => 'post',
		'post_type' => 'page',
		'position'  => 'normal',
		'fields'    => [

			'lab_fruit' => [
				'type'        => 'select',
				'label'       => 'Fruit (Control 1)',
				'description' => 'Change this and Available below — the four fields after react to combinations of both.',
				'choices'     => [
					'apple'  => 'Apple',
					'banana' => 'Banana',
					'cherry' => 'Cherry',
				],
				'default'     => 'apple',
			],

			'lab_available' => [
				'type'    => 'toggle',
				'label'   => 'Available (Control 2)',
				'default' => '1',
			],

			'lab_and_rule' => [
				'type'        => 'text',
				'label'       => 'AND: Fruit == banana AND Available == 1',
				'placeholder' => 'Visible only for Banana + Available',
				'conditional' => [
					'relation' => 'AND',
					'rules'    => [
						[ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'banana' ],
						[ 'field' => 'lab_available', 'operator' => '==', 'value' => '1' ],
					],
				],
			],

			'lab_or_rule' => [
				'type'        => 'text',
				'label'       => 'OR: Fruit == apple OR Fruit == cherry',
				'placeholder' => 'Visible for Apple or Cherry, hidden for Banana',
				'conditional' => [
					'relation' => 'OR',
					'rules'    => [
						[ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'apple' ],
						[ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'cherry' ],
					],
				],
			],

			'lab_contains_rule' => [
				'type'        => 'text',
				'label'       => 'Single rule: Fruit contains "an"',
				'placeholder' => 'Visible for Banana only',
				'conditional' => [
					'relation' => 'AND',
					'rules'    => [
						[ 'field' => 'lab_fruit', 'operator' => 'contains', 'value' => 'an' ],
					],
				],
			],

			'lab_mixed_and_rule' => [
				'type'        => 'text',
				'label'       => 'AND: Fruit !contains "an" AND Available == 1',
				'placeholder' => 'Visible for Apple or Cherry, only when Available',
				'conditional' => [
					'relation' => 'AND',
					'rules'    => [
						[ 'field' => 'lab_fruit', 'operator' => '!contains', 'value' => 'an' ],
						[ 'field' => 'lab_available', 'operator' => '==', 'value' => '1' ],
					],
				],
			],

		],
	];

	return $groups;
}

/**
 * User Meta Lab — a small field set on the user profile,
 * demonstrating onemeta_get_user_meta() including a user-meta repeater.
 */
function omd_register_user_meta_lab( array $groups ): array {

	$groups['omd_user_meta_lab'] = [
		'title'  => 'User Meta Lab',
		'type'   => 'user',
		'fields' => [

			'tagline' => [
				'type'        => 'text',
				'label'       => 'Tagline',
				'description' => 'Shown on the User Meta Lab panel for whoever is logged in.',
				'placeholder' => 'Designer | Developer',
			],

			'portfolio_url' => [
				'type'        => 'url',
				'label'       => 'Portfolio URL',
				'placeholder' => 'https://example.com',
			],

			'headshot' => [
				'type'          => 'image',
				'label'         => 'Headshot',
				'return_format' => 'id',
			],

			'skills' => [
				'type'        => 'repeater',
				'label'       => 'Skills',
				'button_text' => 'Add Skill',
				'sub_fields'  => [
					[
						'key'         => 'skill_name',
						'type'        => 'text',
						'label'       => 'Skill',
						'placeholder' => 'e.g. WordPress',
					],
					[
						'key'     => 'skill_level',
						'type'    => 'select',
						'label'   => 'Level',
						'choices' => [
							'beginner'     => 'Beginner',
							'intermediate' => 'Intermediate',
							'advanced'     => 'Advanced',
						],
						'default' => 'beginner',
					],
				],
			],

		],
	];

	return $groups;
}
