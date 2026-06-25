<?php
/**
 * Panel: Field Types Lab
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omd_page_id = (int) ( $args['page_id'] ?? 0 );
?>

<div class="omd-panel__head">
	<h1>Field Types Lab</h1>
	<p>The 14 documented field types, plus one undocumented bonus, one meta box, registered via <code>omd_register_field_types_lab()</code>.</p>
</div>

<div class="omd-card omd-card--bonus">
	<p class="omd-card__title">Bonus — Undocumented</p>
	<div class="omd-field-grid">

		<div class="omd-field">
			<span class="omd-field__label">Heading <code>type: heading</code></span>
			<div class="omd-field__rendered">
				<h3 style="margin:0 0 8px;">This Is a Heading Field</h3>
				<hr style="border-color:var(--omd-border);margin:0;">
			</div>
			<p class="omd-field__note">
				Defined in <code>FieldTypeSchemas.php</code> and listed in the field palette
				(<code>field-palette-sidebar.js</code>) — but absent from the GitHub README,
				readme.txt, and docs site "14 field types" list. Display-only: renders an HTML
				tag (<code>h2</code>–<code>h6</code> or <code>p</code>) with an optional separator
				and stores no value, so there's nothing for <code>onemeta_get_meta()</code> to
				return — no drawer below.
			</p>
		</div>

	</div>
</div>

<div class="omd-card">
	<p class="omd-card__title">Basic</p>
	<div class="omd-field-grid">

		<div class="omd-field">
			<span class="omd-field__label">Text</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_text' ); ?>
			<div class="omd-field__rendered<?php echo '' === $v ? ' is-empty' : ''; ?>">
				<?php echo esc_html( '' !== $v ? $v : 'Not set yet' ); ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Textarea</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_textarea' ); ?>
			<div class="omd-field__rendered<?php echo '' === $v ? ' is-empty' : ''; ?>">
				<?php echo '' !== $v ? wp_kses_post( wpautop( $v ) ) : 'Not set yet'; ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">URL</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_url' ); ?>
			<div class="omd-field__rendered<?php echo '' === $v ? ' is-empty' : ''; ?>">
				<?php if ( '' !== $v ) : ?>
					<a href="<?php echo esc_url( $v ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $v ); ?></a>
				<?php else : ?>
					Not set yet
				<?php endif; ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Email</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_email' ); ?>
			<div class="omd-field__rendered<?php echo '' === $v ? ' is-empty' : ''; ?>">
				<?php if ( '' !== $v ) : ?>
					<a href="mailto:<?php echo esc_attr( $v ); ?>"><?php echo esc_html( $v ); ?></a>
				<?php else : ?>
					Not set yet
				<?php endif; ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Date</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_date' ); ?>
			<div class="omd-field__rendered<?php echo '' === $v ? ' is-empty' : ''; ?>">
				<?php
				echo '' !== $v
					? esc_html( date_i18n( get_option( 'date_format' ), strtotime( $v ) ) )
					: 'Not set yet';
				?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

	</div>
</div>

<div class="omd-card">
	<p class="omd-card__title">Choice</p>
	<div class="omd-field-grid">

		<div class="omd-field">
			<span class="omd-field__label">Toggle</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_toggle' ); ?>
			<div class="omd-field__rendered">
				<span class="omd-badge<?php echo '1' === $v ? '' : ' omd-badge--off'; ?>">
					<?php echo '1' === $v ? 'On' : 'Off'; ?>
				</span>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Select</span>
			<?php
			$choices = [ 'grid' => 'Grid View', 'list' => 'List View', 'map' => 'Map View' ];
			$v       = omd_meta( $omd_page_id, 'demo_select' );
			?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php echo esc_html( ! empty( $v ) ? omd_choice_label( $v, $choices ) : 'Not set yet' ); ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Radio</span>
			<?php
			$choices = [ 'small' => 'Small', 'medium' => 'Medium', 'large' => 'Large' ];
			$v       = omd_meta( $omd_page_id, 'demo_radio' );
			?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php echo esc_html( ! empty( $v ) ? omd_choice_label( $v, $choices ) : 'Not set yet' ); ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Button Group</span>
			<?php
			$choices = [ 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ];
			$v       = omd_meta( $omd_page_id, 'demo_button_group' );
			?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php echo esc_html( ! empty( $v ) ? omd_choice_label( $v, $choices ) : 'Not set yet' ); ?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Checkbox</span>
			<?php
			$choices = [ 'wifi' => 'WiFi', 'parking' => 'Parking', 'pets' => 'Pet Friendly' ];
			$v       = omd_meta( $omd_page_id, 'demo_checkbox', [] );
			?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php
				if ( is_array( $v ) && ! empty( $v ) ) {
					foreach ( $v as $choice_value ) {
						echo '<span class="omd-badge" style="margin-right:6px;">' . esc_html( $choices[ $choice_value ] ?? $choice_value ) . '</span>';
					}
				} else {
					echo 'Not set yet';
				}
				?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

	</div>
</div>

<div class="omd-card">
	<p class="omd-card__title">Media</p>
	<div class="omd-field-grid">

		<div class="omd-field">
			<span class="omd-field__label">Image (return_format: id)</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_image' ); ?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php
				if ( ! empty( $v ) ) {
					echo wp_get_attachment_image( (int) $v, 'medium', false, [ 'style' => 'border-radius:8px;' ] );
				} else {
					echo 'Not set yet';
				}
				?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Image (return_format: array)</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_image_array' ); ?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php
				if ( is_array( $v ) && ! empty( $v['url'] ) ) {
					echo '<img src="' . esc_url( $v['url'] ) . '" alt="' . esc_attr( $v['alt'] ?? '' ) . '" style="max-width:100%;border-radius:8px;display:block;margin-bottom:8px;">';
					echo '<small>' . esc_html( ( $v['width'] ?? 0 ) . '×' . ( $v['height'] ?? 0 ) ) . '</small>';
				} else {
					echo 'Not set yet';
				}
				?>
			</div>
			<p class="omd-field__note">
				Same field type as above, only <code>return_format</code> differs — this is
				<code>FieldValueResolver::build_image_array()</code>, which most documented
				examples never show since <code>id</code> is the default everywhere.
			</p>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">File</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_file' ); ?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php
				if ( ! empty( $v ) && get_attached_file( (int) $v ) ) {
					$file_url = wp_get_attachment_url( (int) $v );
					echo '<a href="' . esc_url( $file_url ) . '" download>' . esc_html( basename( get_attached_file( (int) $v ) ) ) . '</a>';
				} else {
					echo 'Not set yet';
				}
				?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

		<div class="omd-field">
			<span class="omd-field__label">Gallery</span>
			<?php $v = omd_meta( $omd_page_id, 'demo_gallery', [] ); ?>
			<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
				<?php
				if ( is_array( $v ) && ! empty( $v ) ) {
					echo '<div style="display:flex;gap:8px;flex-wrap:wrap;">';
					foreach ( $v as $image_id ) {
						echo wp_get_attachment_image( (int) $image_id, 'thumbnail', false, [ 'style' => 'border-radius:6px;width:60px;height:60px;object-fit:cover;' ] );
					}
					echo '</div>';
				} else {
					echo 'Not set yet';
				}
				?>
			</div>
			<?php omd_drawer( $v ); ?>
		</div>

	</div>
</div>
