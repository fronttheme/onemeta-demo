<?php
/**
 * OneMeta Demo — Template Helpers
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Safe wrapper around onemeta_get_meta() — returns null if OneMeta isn't
 * active rather than fataling, so templates can show a friendly notice.
 */
function omd_meta( int $post_id, string $key, mixed $default = '' ): mixed {
  if ( ! omd_onemeta_active() ) {
    return null;
  }

  return onemeta_get_meta( $post_id, $key, $default );
}

/**
 * Safe wrapper around onemeta_get_user_meta().
 */
function omd_user_meta( int $user_id, string $key, mixed $default = '' ): mixed {
  if ( ! omd_onemeta_active() ) {
    return null;
  }

  return onemeta_get_user_meta( $user_id, $key, $default );
}

/**
 * PHP type label for a value, formatted the way the docs' return-type
 * table describes it (string / array / int).
 */
function omd_php_type( mixed $value ): string {
  return match ( true ) {
    is_array( $value ) => 'array',
    is_int( $value ) => 'int',
    is_bool( $value ) => 'bool',
    is_null( $value ) => 'null',
    default => 'string',
  };
}

/**
 * Render a value as a readable string for the "Saved value" drawer.
 */
function omd_export_value( mixed $value ): string {
  if ( is_array( $value ) ) {
    return print_r( $value, true );
  }

  if ( '' === $value || null === $value ) {
    return '(empty)';
  }

  return (string) $value;
}

/**
 * Output a collapsible "Saved value" drawer — the OneMeta-Demo equivalent
 * of the value/type inspector used throughout ThemePlus Demo.
 */
function omd_drawer( mixed $value ): void {
  ?>
  <div class="omd-drawer">
    <button type="button" class="omd-drawer__toggle" data-omd-drawer-toggle>Saved value ▾</button>
    <div class="omd-drawer__body">
      <span class="omd-drawer__type"><?php echo esc_html( omd_php_type( $value ) ); ?></span>
      <?php echo esc_html( omd_export_value( $value ) ); ?>
    </div>
  </div>
  <?php
}

/**
 * Map a choice value to its label using a 'choices' style array.
 */
function omd_choice_label( string|array $value, array $choices ): string {
  if ( is_array( $value ) ) {
    $labels = array_map(
        static fn( $v ) => $choices[ $v ] ?? $v,
        $value
    );

    return implode( ', ', $labels );
  }

  return $choices[ $value ] ?? $value;
}

/**
 * Sidebar navigation definition — single source of truth shared by
 * front-page.php and assets/js/demo.js (via a matching data-omd-panel attr).
 */
function omd_nav_items(): array {
  return [
      'welcome'     => [ 'label' => 'Welcome', 'icon' => 'welcome.svg' ],
      'field-types' => [ 'label' => 'Field Types Lab', 'icon' => 'field-types.svg' ],
      'repeater'    => [ 'label' => 'Repeater Lab', 'icon' => 'repeater.svg' ],
      'conditional' => [ 'label' => 'Conditional Lab', 'icon' => 'conditional.svg' ],
      'user-meta'   => [ 'label' => 'User Meta Lab', 'icon' => 'user-meta.svg' ],
      'all-values'  => [ 'label' => 'All Values', 'icon' => 'all-values.svg' ],
  ];
}

/**
 * Inline an SVG icon from assets/icons/ so its color can inherit
 * currentColor and respond to the same nav active/hover/dark-mode states
 * that already recolor the label text. Returns '' (not a placeholder
 * glyph) if the file is missing, so a typo'd filename fails silently
 * rather than dumping raw text into the nav markup.
 */
function omd_icon( string $filename ): string {
  static $cache = [];

  if ( isset( $cache[ $filename ] ) ) {
    return $cache[ $filename ];
  }

  $path = get_template_directory() . '/assets/img/' . $filename;

  if ( ! file_exists( $path ) ) {
    $cache[ $filename ] = '';

    return '';
  }

  // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_get_contents -- Local trusted theme asset, not user-supplied.
  $cache[ $filename ] = file_get_contents( $path );

  return $cache[ $filename ];
}

/**
 * Evaluate a OneMeta `conditional` config — ['relation' => 'AND'|'OR',
 * 'rules' => [[field,operator,value], ...]] — against a map of currently
 * saved field values. Display-only, mirrors OneMeta's own JS engine.
 * 'contains'/'!contains' are case-insensitive, per the in-plugin docs note.
 */
function omd_evaluate_conditional( array $conditional, array $values ): bool {
  $relation = strtoupper( $conditional['relation'] ?? 'AND' );
  $rules    = $conditional['rules'] ?? [];

  if ( empty( $rules ) ) {
    return true;
  }

  $results = array_map(
      static function ( array $rule ) use ( $values ) {
        $field    = $rule['field'] ?? '';
        $operator = $rule['operator'] ?? '==';
        $target   = (string) ( $rule['value'] ?? '' );
        $actual   = (string) ( $values[ $field ] ?? '' );

        return match ( $operator ) {
          '==' => $actual === $target,
          '!=' => $actual !== $target,
          'contains' => str_contains( strtolower( $actual ), strtolower( $target ) ),
          '!contains' => ! str_contains( strtolower( $actual ), strtolower( $target ) ),
          default => true,
        };
      },
      $rules
  );

  return 'OR' === $relation ? in_array( true, $results, true ) : ! in_array( false, $results, true );
}
