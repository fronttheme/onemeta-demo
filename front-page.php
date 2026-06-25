<?php
/**
 * Front Page — OneMeta Demo
 *
 * Sidebar + panel shell. Panels are switched client-side (no reload) by
 * assets/js/demo.js; nav items come from omd_nav_items() so PHP and JS
 * stay in sync from one source of truth.
 *
 * @package OneMeta_Demo
 */

get_header();

$omd_page_id = (int) get_option( 'omd_demo_page_id' );
$omd_nav     = omd_nav_items();
?>

<div class="omd-shell">

  <aside class="omd-sidebar">
    <ul class="omd-nav">
      <?php foreach ( $omd_nav as $omd_key => $omd_item ) : ?>
        <li>
          <button
              type="button"
              class="omd-nav__link<?php echo 'welcome' === $omd_key ? ' is-active' : ''; ?>"
              data-omd-nav-link
              data-omd-target="<?php echo esc_attr( $omd_key ); ?>"
          >
            <span class="omd-nav__icon"><?php echo omd_icon( $omd_item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Local trusted SVG file, not user input. ?></span>
            <?php echo esc_html( $omd_item['label'] ); ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>
  </aside>

  <main class="omd-main">

    <?php if ( ! omd_onemeta_active() ) : ?>
      <div class="omd-notice omd-notice--warning">
        <strong>OneMeta isn't active.</strong>
        Every panel below will render, but values will show as empty until you
        install and activate the <code>onemeta</code> plugin.
      </div>
    <?php endif; ?>

    <section class="omd-panel is-active" data-omd-panel="welcome">
      <?php get_template_part( 'template-parts/demo/welcome' ); ?>
    </section>

    <section class="omd-panel" data-omd-panel="field-types">
      <?php get_template_part( 'template-parts/demo/field-types-lab', null, [ 'page_id' => $omd_page_id ] ); ?>
    </section>

    <section class="omd-panel" data-omd-panel="repeater">
      <?php get_template_part( 'template-parts/demo/repeater-lab', null, [ 'page_id' => $omd_page_id ] ); ?>
    </section>

    <section class="omd-panel" data-omd-panel="conditional">
      <?php get_template_part( 'template-parts/demo/conditional-lab', null, [ 'page_id' => $omd_page_id ] ); ?>
    </section>

    <section class="omd-panel" data-omd-panel="user-meta">
      <?php get_template_part( 'template-parts/demo/user-meta-lab' ); ?>
    </section>

    <section class="omd-panel" data-omd-panel="all-values">
      <?php get_template_part( 'template-parts/demo/all-values', null, [ 'page_id' => $omd_page_id ] ); ?>
    </section>

  </main>

</div>

<?php get_footer(); ?>
