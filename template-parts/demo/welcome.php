<?php
/**
 * Panel: Welcome
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omd_page_id = (int) get_option( 'omd_demo_page_id' );
?>

<div class="omd-panel__head">
	<h1>Welcome to OneMeta Demo</h1>
	<p>
		A test-harness theme for OneMeta — every field type, every conditional-logic
		operator, repeater fields, and user meta, registered entirely in code via the
		<code>onemeta_field_groups</code> filter. No builder setup required.
	</p>
</div>

<div class="omd-card">
	<p class="omd-card__title">The experiment loop</p>
	<ol>
		<li>Pick a lab from the sidebar — the labels match the meta boxes on the demo page exactly.</li>
		<li>
			<?php if ( $omd_page_id && current_user_can( 'edit_post', $omd_page_id ) ) : ?>
				<a href="<?php echo esc_url( get_edit_post_link( $omd_page_id, '' ) ); ?>">Open the demo page editor</a>
				and change a field.
			<?php else : ?>
				Open the demo page editor and change a field.
			<?php endif; ?>
		</li>
		<li>Save, then come back here and refresh — the matching panel reflects exactly what you saved.</li>
	</ol>
	<p>
		Every rendered value has a <strong>Saved value</strong> drawer underneath it —
		click it to see the raw value OneMeta returned, and its PHP type, exactly as
		documented in the
		<a href="https://www.fronttheme.com/docs/onemeta/helper-functions/return-types/" target="_blank" rel="noopener">Return Types reference</a>.
	</p>
</div>

<div class="omd-field-grid">
	<div class="omd-field">
		<span class="omd-field__label">Field Types Lab</span>
		<p>14 documented field types — Text through Gallery — plus one undocumented bonus, all on one meta box.</p>
	</div>
	<div class="omd-field">
		<span class="omd-field__label">Repeater Lab</span>
		<p>A Team Members repeater with name, role, and avatar sub-fields.</p>
	</div>
	<div class="omd-field">
		<span class="omd-field__label">Conditional Lab</span>
		<p>One control field, four dependents — one per operator: ==, !=, contains, !contains.</p>
	</div>
	<div class="omd-field">
		<span class="omd-field__label">User Meta Lab</span>
		<p>Edit your own profile to see <code>onemeta_get_user_meta()</code> in action.</p>
	</div>
</div>
