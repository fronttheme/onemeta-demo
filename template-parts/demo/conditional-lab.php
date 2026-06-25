<?php
/**
 * Panel: Conditional Lab
 *
 * @package OneMeta_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$omd_page_id = (int) ( $args['page_id'] ?? 0 );

$omd_values = [
    'lab_fruit'     => omd_meta( $omd_page_id, 'lab_fruit', '' ),
    'lab_available' => omd_meta( $omd_page_id, 'lab_available', '' ),
];

$omd_fruit_choices = [ 'apple' => 'Apple', 'banana' => 'Banana', 'cherry' => 'Cherry' ];

$omd_dependents = [
    'lab_and_rule' => [
        'label'       => 'AND — Fruit == banana AND Available == 1',
        'conditional' => [
            'relation' => 'AND',
            'rules'    => [
                [ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'banana' ],
                [ 'field' => 'lab_available', 'operator' => '==', 'value' => '1' ],
            ],
        ],
    ],
    'lab_or_rule' => [
        'label'       => 'OR — Fruit == apple OR Fruit == cherry',
        'conditional' => [
            'relation' => 'OR',
            'rules'    => [
                [ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'apple' ],
                [ 'field' => 'lab_fruit', 'operator' => '==', 'value' => 'cherry' ],
            ],
        ],
    ],
    'lab_contains_rule' => [
        'label'       => 'Single rule — Fruit contains "an"',
        'conditional' => [
            'relation' => 'AND',
            'rules'    => [
                [ 'field' => 'lab_fruit', 'operator' => 'contains', 'value' => 'an' ],
            ],
        ],
    ],
    'lab_mixed_and_rule' => [
        'label'       => 'AND — Fruit !contains "an" AND Available == 1',
        'conditional' => [
            'relation' => 'AND',
            'rules'    => [
                [ 'field' => 'lab_fruit', 'operator' => '!contains', 'value' => 'an' ],
                [ 'field' => 'lab_available', 'operator' => '==', 'value' => '1' ],
            ],
        ],
    ],
];
?>

<div class="omd-panel__head">
  <h1>Conditional Lab</h1>
  <p>
    Two control fields, four dependents combining <strong>AND</strong>,
    <strong>OR</strong>, and single-rule conditions. Built against
    <code>'conditional' => ['relation' => 'AND'|'OR', 'rules' => [[field, operator, value], ...]]</code>
    — the shape OneMeta actually saves (confirmed in <code>AdminAjax::sanitize_array_setting()</code>),
    not the single-condition shape shown on the public docs site.
  </p>
</div>

<div class="omd-card">
  <div class="omd-field-grid">

    <div class="omd-field">
      <span class="omd-field__label">Control 1 — lab_fruit</span>
      <div class="omd-field__rendered">
        <?php echo esc_html( omd_choice_label( $omd_values['lab_fruit'], $omd_fruit_choices ) ); ?>
      </div>
      <?php omd_drawer( $omd_values['lab_fruit'] ); ?>
    </div>

    <div class="omd-field">
      <span class="omd-field__label">Control 2 — lab_available</span>
      <div class="omd-field__rendered">
				<span class="omd-badge<?php echo '1' === $omd_values['lab_available'] ? '' : ' omd-badge--off'; ?>">
					<?php echo '1' === $omd_values['lab_available'] ? 'Available' : 'Unavailable'; ?>
				</span>
      </div>
      <?php omd_drawer( $omd_values['lab_available'] ); ?>
    </div>

  </div>
</div>

<div class="omd-field-grid">
  <?php foreach ( $omd_dependents as $omd_key => $omd_rule ) : ?>
    <?php
    $omd_visible = omd_evaluate_conditional( $omd_rule['conditional'], $omd_values );
    $omd_value   = omd_meta( $omd_page_id, $omd_key );
    ?>
    <div class="omd-field omd-conditional-dependent<?php echo $omd_visible ? '' : ' is-hidden'; ?>">
			<span class="omd-field__label">
				<?php echo esc_html( $omd_key ); ?>
				<span class="omd-operator-tag"><?php echo esc_html( $omd_rule['conditional']['relation'] ); ?></span>
			</span>
      <p style="font-size:13px;color:var(--omd-text-muted);margin:4px 0 10px;">
        <?php echo esc_html( $omd_rule['label'] ); ?>
      </p>
      <div class="omd-field__rendered">
				<span class="omd-badge<?php echo $omd_visible ? '' : ' omd-badge--off'; ?>">
					<?php echo $omd_visible ? 'Visible' : 'Hidden'; ?>
				</span>
      </div>
      <?php if ( $omd_visible ) : ?>
        <p style="margin:10px 0 0;"><?php echo esc_html( (string) $omd_value ); ?></p>
      <?php endif; ?>
      <?php omd_drawer( $omd_value ); ?>
    </div>
  <?php endforeach; ?>
</div>