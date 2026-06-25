<?php
/**
 * Fallback template — OneMeta Demo
 *
 * This theme exists only to demonstrate OneMeta on the front page.
 * Any other URL bounces back home.
 *
 * @package OneMeta_Demo
 */

get_header();
?>
	<div class="omd-shell">
		<main class="omd-main">
			<div class="omd-panel is-active">
				<div class="omd-panel__head">
					<h1>This demo lives on the homepage</h1>
					<p>
						OneMeta Demo only renders its labs on the front page.
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Go there →</a>
					</p>
				</div>
			</div>
		</main>
	</div>
<?php
get_footer();
