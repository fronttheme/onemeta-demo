<?php
/**
 * Header — OneMeta Demo
 *
 * @package OneMeta_Demo
 */

defined( 'ABSPATH' ) || exit;

$omd_logo_url         = OMD_URI . '/assets/img/onemeta-logo.svg';
$omd_theme_toggle_url = OMD_URI . '/assets/img/theme-appearance.svg';
$omd_logo_alt         = get_bloginfo( 'name' )
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class( 'onemeta-demo' ); ?> data-omd-theme="light">

<header class="omd-header">
  <a class="omd-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
    <img class="omd-header__logo"
         src="<?php echo esc_url( $omd_logo_url ); ?>"
         alt="<?php echo esc_attr( $omd_logo_alt ); ?>">
    <span class="omd-header__tagline"><?php esc_html_e( 'Field Demo', 'onemeta-demo' ); ?></span>
  </a>
  <div class="omd-header__actions">
    <?php
    $omd_page_id = (int) get_option( 'omd_demo_page_id' );
    if ( $omd_page_id && current_user_can( 'edit_post', $omd_page_id ) ) :
      ?>
      <a class="omd-btn omd-btn--primary" href="<?php echo esc_url( get_edit_post_link( $omd_page_id, '' ) ); ?>">
        Edit Demo Page
      </a>
    <?php endif; ?>
    <a class="omd-btn" href="https://github.com/fronttheme/onemeta" target="_blank" rel="noopener">
      OneMeta on GitHub
    </a>
    <button type="button" class="omd-btn" data-omd-theme-toggle aria-label="Toggle light and dark mode">
      <svg xmlns="http://www.w3.org/2000/svg" id="omd-theme__icon" version="1.1" viewBox="0 0 256 256">
        <defs/>
        <path d="M128.03 51.29c-42.46 0-76.88 34.34-76.88 76.7s34.42 76.7 76.88 76.7 76.88-34.34 76.88-76.7-34.42-76.7-76.88-76.7m31.84 109.99c-10.7 5.97-29.06 9.73-31.85-6.6 1.57-16.84-2.1-37.51.05-53.9.72-5.43 5.17-10.12 10.6-10.99 6.62-1.06 15.41 1.71 21.2 4.93 25.77 14.39 25.77 52.15 0 66.54zM206.72 67.18c3.82-1.69 15.68-13.57 16.55-17.65 2.13-9.98-5.29-18.16-15.51-16.08-4.78.97-17.12 13.45-18.64 17.95-3.64 10.85 7.07 20.43 17.6 15.77ZM139.74 30.91c1.37-3.4 1.35-16.03.9-20.07C139.8 3.07 132.16-.77 124.87.5c-3.86.67-8.06 4.54-9.05 8.36-.85 3.31-.82 15.12-.41 18.77 1.42 12.59 19.66 14.9 24.32 3.29v-.02ZM27.42 115.42c-3.72-.43-14.3-.46-17.89.15-11.2 1.89-13.11 18.99-2.66 23.94 3.36 1.59 15.8 1.47 19.97 1.11 15.14-1.35 15.07-23.57.58-25.19v-.02ZM246.03 115.47c-3.62-.49-14.88-.49-18.43.09-13.12 2.18-12.99 23.14.51 24.97 3.79.51 13.5.46 17.37.05 13.86-1.48 14.01-23.26.55-25.12v.02ZM126.7 217.45c-5.67.61-10.65 5.29-11.28 10.94-.44 3.99-.44 16.69.9 20.07 3.96 9.9 19.8 9.66 23.6-.43 1.16-3.05 1.14-15.97.73-19.66-.75-6.6-7.34-11.67-13.94-10.94l-.02.02ZM49.13 66.78c11.55 5.94 23.43-5.6 17.75-17.1-1.33-2.7-8.74-10.17-11.33-12.07-3.33-2.42-6.35-3.6-10.56-2.95-8.48 1.31-12.8 10.43-9.37 18.06 1.48 3.29 10.36 12.42 13.53 14.06zM51.59 189.27c-4.62.79-16.62 12.51-17.6 17.2-2.44 11.62 9.51 19.44 19.75 13.7 2.68-1.5 8.36-6.98 10.34-9.47 8.35-10.53 1.06-23.74-12.48-21.44h-.02ZM201.16 190.48c-8.45 1.3-13.23 11.01-9.18 18.47 1.33 2.44 9.68 10.79 12.12 11.88 11.4 5.12 22.58-5.39 16.78-16.74-3.17-6.21-12.2-14.76-19.71-13.6Z" class="st0"/>
      </svg>
    </button>
  </div>
</header>
