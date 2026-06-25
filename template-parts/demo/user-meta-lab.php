<?php
/**
 * Panel: User Meta Lab
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omd_user_id = get_current_user_id();
?>

<div class="omd-panel__head">
	<h1>User Meta Lab</h1>
	<p>
		Same plugin, different entity — <code>type =&gt; 'user'</code> field groups
		attach to WordPress user profiles and read back with
		<code>onemeta_get_user_meta()</code>.
	</p>
</div>

<?php if ( ! $omd_user_id ) : ?>

	<div class="omd-notice">
		You're browsing as a guest, so there's no profile to read.
		<a href="<?php echo esc_url( wp_login_url( home_url( '/' ) ) ); ?>">Log in</a>
		and this panel will show your own saved values.
	</div>

<?php else : ?>

	<div class="omd-notice">
		Showing fields for <strong><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>.
		<a href="<?php echo esc_url( get_edit_user_link( $omd_user_id ) ); ?>">Edit your profile →</a>
		Scroll to the User Meta Lab section, fill in a few fields, update, then refresh this page.
	</div>

	<div class="omd-card">
		<p class="omd-card__title">Profile Fields</p>
		<div class="omd-field-grid">

			<div class="omd-field">
				<span class="omd-field__label">Tagline</span>
				<?php $v = omd_user_meta( $omd_user_id, 'tagline' ); ?>
				<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
					<?php echo esc_html( ! empty( $v ) ? $v : 'Not set yet' ); ?>
				</div>
				<?php omd_drawer( $v ); ?>
			</div>

			<div class="omd-field">
				<span class="omd-field__label">Portfolio URL</span>
				<?php $v = omd_user_meta( $omd_user_id, 'portfolio_url' ); ?>
				<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
					<?php if ( ! empty( $v ) ) : ?>
						<a href="<?php echo esc_url( $v ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $v ); ?></a>
					<?php else : ?>
						Not set yet
					<?php endif; ?>
				</div>
				<?php omd_drawer( $v ); ?>
			</div>

			<div class="omd-field">
				<span class="omd-field__label">Headshot</span>
				<?php $v = omd_user_meta( $omd_user_id, 'headshot' ); ?>
				<div class="omd-field__rendered<?php echo empty( $v ) ? ' is-empty' : ''; ?>">
					<?php
					if ( ! empty( $v ) ) {
						echo wp_get_attachment_image( (int) $v, 'thumbnail', false, [ 'style' => 'border-radius:50%;width:64px;height:64px;object-fit:cover;' ] );
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
		<p class="omd-card__title">Skills (user-meta repeater)</p>
		<?php $skills = omd_user_meta( $omd_user_id, 'skills', [] ); ?>
		<?php if ( is_array( $skills ) && ! empty( $skills ) ) : ?>
			<?php foreach ( $skills as $skill ) : ?>
				<div class="omd-repeater-row">
					<div>
						<p class="omd-repeater-row__name"><?php echo esc_html( $skill['skill_name'] ?? '' ); ?></p>
						<p class="omd-repeater-row__role"><?php echo esc_html( ucfirst( $skill['skill_level'] ?? '' ) ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="omd-field__rendered is-empty">No skills added yet.</p>
		<?php endif; ?>
		<?php omd_drawer( $skills ); ?>
	</div>

<?php endif; ?>
