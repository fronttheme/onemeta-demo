<?php
/**
 * Panel: Repeater Lab
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omd_page_id = (int) ( $args['page_id'] ?? 0 );
$team        = omd_meta( $omd_page_id, 'team_members', [] );
?>

<div class="omd-panel__head">
	<h1>Repeater Lab</h1>
	<p>
		One repeater field, <code>team_members</code>, with <code>member_name</code>,
		<code>member_role</code>, and <code>member_avatar</code> sub-fields.
		Add, remove, or reorder rows in the editor and refresh.
	</p>
</div>

<div class="omd-card">
	<p class="omd-card__title">Rendered</p>

	<?php if ( is_array( $team ) && ! empty( $team ) ) : ?>
		<?php foreach ( $team as $member ) : ?>
			<div class="omd-repeater-row">
				<?php
				$avatar_id = (int) ( $member['member_avatar'] ?? 0 );
				if ( $avatar_id ) {
					echo wp_get_attachment_image( $avatar_id, 'thumbnail', false, [ 'class' => 'omd-repeater-row__avatar' ] );
				} else {
					echo '<div class="omd-repeater-row__avatar"></div>';
				}
				?>
				<div>
					<p class="omd-repeater-row__name"><?php echo esc_html( $member['member_name'] ?? '' ); ?></p>
					<p class="omd-repeater-row__role"><?php echo esc_html( $member['member_role'] ?? '' ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<p class="omd-field__rendered is-empty">No rows yet — add one in the editor.</p>
	<?php endif; ?>

	<?php omd_drawer( $team ); ?>
</div>
