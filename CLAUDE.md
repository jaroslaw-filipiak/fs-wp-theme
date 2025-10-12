# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a custom WordPress theme called "fajnestarocie" that integrates WooCommerce for e-commerce functionality. The theme uses modern build tools (Vite) with TailwindCSS for styling and includes GSAP animations and Swiper components.

## Build System

### Development
```bash
npm run dev
```
Starts Vite development server with hot module replacement.

### Production Build
```bash
npm run build
```
Compiles assets for production. Output goes to `dist/` directory.

### Watch Mode
```bash
npm run build:watch
```
Watches for file changes and rebuilds automatically during development.

## Architecture

### Directory Structure

- `src/` - Source files for JavaScript and SCSS
  - Entry points: `main.js`, `single-product.js`, `front-page.js`, `archive-product.js`, `cart.js`, `search.js`, `404.js`, `contact.js`
  - Each entry point has corresponding `.scss` file
  - `src/scss/` - SCSS partials organized by type (components, pages, vendors)

- `dist/` - Built assets (compiled by Vite)
  - Contains minified JS/CSS with predictable naming: `assets/[name].js` and `assets/[name].css`

- `inc/` - PHP includes
  - `woocommerce.php` - WooCommerce customizations and setup
  - `template-functions.php` - Theme utility functions
  - `template-tags.php` - Custom template tags
  - `translations.php` - Polylang string registrations
  - `subscription-form.php` - Newsletter form handler
  - `customizer.php` - WordPress Customizer settings

- `page-templates/` - Custom page templates
  - `page-home.php` - Homepage template
  - `page-collections.php` - Collections page
  - `page-contact.php` - Contact page
  - `page-recents-products.php` - Recent products page
  - `page-about.php` - About page

- `woocommerce/` - WooCommerce template overrides
  - `single-product.php` - Single product layout
  - `content-single-product.php` - Product content
  - `single-product-gallery.php` - Custom product gallery

### Asset Loading Strategy

The theme conditionally loads assets based on page type (see `functions.php:146-200`):

- **Global**: `main.css` + `main.js` loaded on all pages
- **Single Product**: Additional `single-product.css/js` + lightbox library
- **Homepage**: Additional `front-page.css/js`
- **Product Archive**: Additional `archive-product.css/js`
- **Cart**: Additional `cart.css/js`
- **Search**: Additional `search.css`
- **404**: Additional `404.css/js`
- **Contact Page**: Additional `contact.css/js`

### WooCommerce Customizations

Located in `inc/woocommerce.php`:

- Default WooCommerce styles are disabled (`add_filter('woocommerce_enqueue_styles', '__return_empty_array')`)
- Custom product gallery implementation (replaces default)
- Custom breadcrumb wrapper with container classes
- Cart link fragments for AJAX updates
- Related products limited to 3 items

### Search Functionality

Custom optimized search implementation in `functions.php:247-386`:

- Includes posts, pages, and WooCommerce products in search
- Uses MySQL FULLTEXT indexes for better performance (automatically created on init)
- Searches in post title, content, excerpt, and product meta (SKU, attributes)
- Results limited to 20 items
- Implements simple caching to avoid duplicate queries

### Infinite Scroll for Products

REST API endpoint for loading products (`functions.php:391-477`):

- Endpoint: `/wp-json/fajnestarocie/v1/products`
- Parameters: `page` (pagination), `category` (filter by category)
- Returns 40 products per page with varying image heights for masonry layout
- JavaScript implementation in `src/archive-product.js`

## Key Technologies

- **WordPress**: Theme built on Underscores (_s) starter theme
- **WooCommerce**: Full e-commerce integration
- **Vite**: Modern build tool for assets
- **TailwindCSS**: Utility-first CSS framework (config: `tailwind.config.js`)
- **GSAP**: Animation library used on homepage
- **Swiper**: Slider/carousel component
- **Lightbox**: Product image gallery (third-party library in `public/libs/lightbox/`)
- **Polylang**: Multilingual support (string translations registered in `inc/translations.php`)

## Important Patterns

### Version Management

Theme version is defined in two places and should be updated together:
- `style.css` header comment (currently: 1.1.26)
- `functions.php` constant `_S_VERSION` (currently: 1.2.0)

Note: These versions are currently out of sync. When bumping version, update both locations.

### Adding New Page-Specific Assets

1. Create entry files in `src/`: `your-page.js` and `your-page.scss`
2. Add entry point to `vite.config.js` rollupOptions.input
3. Add conditional enqueue in `functions.php` fajnestarocie_scripts() function
4. Run `npm run build`

### Custom Page Templates

Custom page templates in `page-templates/` use standard WordPress template naming:
- Must have Template Name header comment
- Selected via WordPress admin page attributes

## Development Notes

- Mobile menu handled by `src/mobile-menu.js` with hamburger animations
- Newsletter form handler in `src/newsletter.js`
- Search box toggle in `src/search-box.js`
- All global JavaScript modules imported in `src/main.js`
- TailwindCSS @apply directives used extensively in SCSS files
- Debug styles available in `src/scss/vendors/_debug.scss`

## Common Tasks

### Adding New WooCommerce Hooks
Place custom hooks in `inc/woocommerce.php` following existing pattern.

### Registering Translatable Strings
Add strings to `inc/translations.php` using `pll_register_string()` for Polylang integration.

### Modifying Product Archive Behavior
- Query modifications: `functions.php:381-386` (products per page, etc.)
- Infinite scroll logic: `src/archive-product.js`
- REST endpoint: `functions.php:413-477`
