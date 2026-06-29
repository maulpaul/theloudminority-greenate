# Greenate

Custom Elementor widgets for the Greenate landing-page build. Three responsive,
content-editable widgets — nothing is hardcoded; every string, image, link, and
slider option is set from the Elementor panel.

| Widget | What it does |
| --- | --- |
| **Greenate Banner Carousel** | Full-width hero slider — image, highlighted heading, subtitle, CTA button. One slide visible. |
| **Greenate Product Cards** | Product slider — image, "Organic" badge, title, description, two buttons. |
| **Greenate Testimonials** | Testimonial slider — avatar, name, role, star rating, quote. |

All three share the same slider engine ([Swiper](https://swiperjs.com/)) and the
same **Slider Settings** panel: responsive columns (desktop / tablet / mobile),
autoplay + delay, pause-on-hover, infinite loop, transition speed, and
independent toggles for **pagination dots** and **navigation arrows**.

## Requirements

- WordPress 6.0+
- PHP 7.4+
- **Elementor (Free) 3.5+** — uses the modern `elementor/widgets/register` API. No Elementor Pro required.

## Install

1. Copy the `greenate` folder into `wp-content/plugins/`, or upload the zip via
   **Plugins → Add New → Upload Plugin**.
2. Activate **Greenate**.
3. Edit any page with Elementor → find the widgets under the **Greenate**
   category in the panel.

No build step. No `composer install`. A small PSR-4 autoloader is bundled in the
main plugin file.

## Structure

```
greenate/
├── greenate.php              # header, constants, autoloader, bootstrap
├── src/
│   ├── Plugin.php            # deps check, asset registration, widget registration
│   ├── Traits/
│   │   └── Slider_Controls.php   # shared slider controls + Swiper config builder
│   └── Widgets/
│       ├── Banner_Carousel.php
│       ├── Product_Card_Grid.php
│       └── Testimonial.php
└── assets/
    ├── css/greenate.css
    └── js/greenate.js        # generic, config-driven Swiper init (editor-aware)
```

## Notes

- **Swiper source.** Loaded from a pinned CDN (`swiper@11`) for zero config.
  Elementor Free also bundles Swiper under the handle `swiper`; to use that copy
  instead, see the note in `src/Plugin.php::register_assets()`.
- **Assets load on demand.** Styles/scripts are *registered* and pulled in per
  widget via `get_style_depends()` / `get_script_depends()`, so pages without
  these widgets stay clean.
- **Security.** Every file guards `ABSPATH`; all output is escaped
  (`esc_html` / `esc_attr` / `esc_url`); link attributes are derived from
  Elementor's URL control, not raw input.
- **Styling.** Colors/spacing use a `--gnt-*` token system. Values marked
  `TODO` in `greenate.css` and in each widget's Style tab should be matched to
  the exact Figma values.
```
```
