<?php
/**
 * Panel: All Values
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$omd_page_id = (int) ( $args['page_id'] ?? 0 );
$omd_user_id = get_current_user_id();

$omd_post_keys = [
    'demo_text',
    'demo_textarea',
    'demo_url',
    'demo_email',
    'demo_date',
    'demo_toggle',
    'demo_select',
    'demo_radio',
    'demo_button_group',
    'demo_checkbox',
    'demo_image',
    'demo_image_array',
    'demo_file',
    'demo_gallery',
    'team_members',
    'lab_fruit',
    'lab_available',
    'lab_and_rule',
    'lab_or_rule',
    'lab_contains_rule',
    'lab_mixed_and_rule',
];

$omd_user_keys = [ 'tagline', 'portfolio_url', 'headshot', 'skills' ];

$omd_dump = "// onemeta_get_meta( {$omd_page_id}, \$key ) — post meta\n";
$omd_dump .= str_repeat( '─', 60 ) . "\n";

foreach ( $omd_post_keys as $key ) {
  $value    = omd_meta( $omd_page_id, $key );
  $type     = omd_php_type( $value );
  $omd_dump .= sprintf( "%-20s (%-6s) => %s\n", $key, $type, omd_export_value( $value ) );
}

$omd_dump .= "\n// onemeta_get_user_meta( {$omd_user_id}, \$key ) — current user\n";
$omd_dump .= str_repeat( '─', 60 ) . "\n";

if ( ! $omd_user_id ) {
  $omd_dump .= "(log in to see your own values)\n";
} else {
  foreach ( $omd_user_keys as $key ) {
    $value    = omd_user_meta( $omd_user_id, $key );
    $type     = omd_php_type( $value );
    $omd_dump .= sprintf( "%-20s (%-6s) => %s\n", $key, $type, omd_export_value( $value ) );
  }
}
?>

<div class="omd-panel__head">
  <h1>All Values</h1>
  <p>Every key registered in this demo, dumped raw — exactly what's stored in <code>wp_postmeta</code> / <code>wp_usermeta</code>.
  </p>
</div>

<div class="omd-card">
  <div class="omd-xray" style="margin-bottom:12px;">
    <button type="button" class="omd-btn" data-omd-xray-toggle>🔬 X-ray: open every drawer on this page</button>
  </div>
  <pre class="omd-dump"><?php echo esc_html( $omd_dump ); ?></pre>
</div>
