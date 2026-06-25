# OneMeta Demo

A demonstration and test-harness WordPress theme for **[OneMeta](https://github.com/fronttheme/onemeta)** — the free, open-source custom fields plugin by [FrontTheme](https://www.fronttheme.com/).

Every field type OneMeta ships is registered, seeded with real saved values, and rendered live on the front end. Edit the demo page in wp-admin, save, refresh — and watch the matching panel react.

## What this theme does

- **Registers four field groups entirely in code** via the `onemeta_field_groups` filter — the same mechanism OneMeta's own "Export as PHP" feature generates — so every meta box is ready to use the instant the theme activates. No builder setup required.
- **Field Types Lab**: all 14 documented field types (Text through Gallery) plus the undocumented `heading` type, on one meta box, with config arguments documented inline as a copy-ready reference.
- **Repeater Lab**: a `team_members` repeater with name, role, and avatar sub-fields.
- **Conditional Lab**: one control field driving four dependents — one per supported operator (`==`, `!=`, `contains`, `!contains`) — with the live pass/fail state computed and shown for each.
- **User Meta Lab**: fields attached to `type => 'user'`, read back with `onemeta_get_user_meta()` for whoever is logged in — including a user-meta repeater (Skills).
- **Saved value drawers**: every rendered field has a collapsible drawer showing the raw value and its PHP type, matching the [Return Types reference](https://www.fronttheme.com/docs/onemeta/helper-functions/return-types/). An **X-ray** toggle opens every drawer on the page at once.
- **Seeded demo content**: on activation, creates one "OneMeta Demo" page, sets it as the site's front page, and pre-fills every field with real values — so the demo isn't blank on first load. Seeding never overwrites a value you've already saved yourself.
- **Light/dark theming** with a header toggle, persisted in `localStorage`.
- **Graceful degradation**: every OneMeta call is wrapped in `omd_meta()` / `omd_user_meta()`, which check `function_exists()` and return `null` instead of fataling if the plugin is inactive — the pattern your own theme or plugin integrations should copy.

## Requirements

- WordPress 6.8+
- PHP 8.2+
- The [OneMeta](https://github.com/fronttheme/onemeta) plugin, installed and activated

## Installation

1. Install and activate the OneMeta plugin.
2. Download this repository as a ZIP (or clone it into `wp-content/themes/onemeta-demo`).
3. Activate **OneMeta Demo** under Appearance → Themes — this seeds the demo page and sets it as your homepage.
4. Visit the site front page and explore the sidebar.

## The experiment loop

1. Pick a lab from the sidebar — the labels match the meta boxes on the demo page exactly.
2. Open the demo page editor (button in the header, or **Pages → OneMeta Demo**) and change a field.
3. Save, then refresh the front page — the matching panel reflects exactly what you saved.

Try flipping the Conditional Lab's control field between Apple / Banana / Cherry, or adding a row to the Team Members repeater.

## Structure

```
onemeta-demo/
├── functions.php                  # Setup, asset enqueueing, OneMeta presence guard
├── front-page.php                 # Demo shell: sidebar nav + panels
├── index.php                      # Fallback template (theme is single-purpose)
├── header.php / footer.php        # Chrome: brand bar, theme toggle, footer credit
├── inc/
│   ├── onemeta-field-groups.php   # All four field groups (reference implementation)
│   ├── demo-content.php           # Seeds the demo page + front-page assignment
│   └── template-functions.php     # omd_meta(), omd_user_meta(), drawer renderer
├── template-parts/demo/           # One panel per lab + Welcome + All Values
├── assets/js/demo.js              # Panel switching, drawers, X-ray, theme toggle
└── style.css                      # Theme header + all styling (buildless)
```

No build step, no npm — by design, same as ThemePlus Demo. OneMeta integration requires zero tooling, and this theme proves it.

## A note on field config schema

`inc/onemeta-field-groups.php` is built directly against `includes/Admin/FieldTypeSchemas.php` and `includes/Core/Sanitizer.php` — every key (`choices`, `sub_fields`, `button_text`, `return_format`, `preview_size`, `file_type`, `min`/`max`, `min_rows`/`max_rows`, `on_text`/`off_text`, `allow_null`, `layout`) is taken from the real source, not reconstructed from docs.

Two things worth your attention came out of that review:

1. **`heading` is a real, working field type** — defined in `FieldTypeSchemas.php` and listed first in the field palette (`field-palette-sidebar.js`), but it's not in the GitHub README, readme.txt, or docs site "14 field types" list anywhere. It's display-only (renders a heading tag + optional separator, stores no value), so it may be intentionally excluded from the count rather than a doc gap — worth deciding which, since right now anyone who opens the palette will find an entirely undocumented field type. The Field Types Lab panel calls it out explicitly.
2. **Possible repeater sub-field sanitization mismatch**: `Sanitizer::get_sub_field_type()` looks up a sub-field's type by iterating `$sub_fields_config` and checking `$sub_field['key'] === $field_key` — i.e. it expects a flat list where each entry carries its own `key` property. But every documented and exported example of `sub_fields` (including the CodeExporter output) is an *associative* array keyed by the sub-field's own key, like the top-level `fields` array — with no `key` property inside each entry. If that's accurate, the lookup never matches, and every repeater sub-field silently falls back to generic `sanitize_value()` instead of its type-specific sanitizer (so an `image` sub-field's ID wouldn't get `absint()`'d, a `toggle` sub-field wouldn't get normalized to `"0"`/`"1"`, etc.). Worth a quick check against `MetaSaver.php` (not reviewed here) to see what shape actually reaches the sanitizer at save time — if `sub_fields` really is associative-by-key everywhere else, this is a real bug rather than something I've misread.

## Conventions demonstrated

- Prefixes: `omd_` (PHP functions/constants), `omd-` (CSS/BEM), text domain `onemeta-demo`.
- Meta keys use the `demo_` / `lab_` prefix on top of OneMeta's own `onemeta_` prefix — e.g. `demo_text` is stored and read as `onemeta_demo_text`.
- Demo content seeding is idempotent and additive-only: `metadata_exists()` is checked before every write, so re-activating the theme never clobbers anything you've changed.

## Links

- OneMeta plugin: [github.com/fronttheme/onemeta](https://github.com/fronttheme/onemeta)
- Documentation: [fronttheme.com/docs/onemeta](https://www.fronttheme.com/docs/onemeta/)
- FrontTheme: [fronttheme.com](https://www.fronttheme.com/)

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
