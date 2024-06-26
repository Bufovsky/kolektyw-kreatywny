<?php
/**
 * kolektyw-kreatywny functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kolektyw-kreatywny
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kolektyw_kreatywny_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kolektyw-kreatywny, use a find and replace
	 * to change 'kolektyw-kreatywny' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('kolektyw-kreatywny', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'kolektyw-kreatywny'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'kolektyw_kreatywny_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'kolektyw_kreatywny_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kolektyw_kreatywny_content_width()
{
	$GLOBALS['content_width'] = apply_filters('kolektyw_kreatywny_content_width', 640);
}
add_action('after_setup_theme', 'kolektyw_kreatywny_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kolektyw_kreatywny_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'kolektyw-kreatywny'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'kolektyw-kreatywny'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'kolektyw_kreatywny_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function kolektyw_kreatywny_scripts()
{
	wp_enqueue_style('kolektyw-kreatywny-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('kolektyw-kreatywny-style', 'rtl', 'replace');

	wp_enqueue_script('kolektyw-kreatywny-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'kolektyw_kreatywny_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Init calculator block.
 */
function register_acf_block()
{
	register_block_type(get_template_directory() . '/blocks/calculator-block');
}
add_action('init', 'register_acf_block');

add_action('acf/include_fields', 'acf_fields_init');
function acf_fields_init()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(
		array(
			array(
				"key" => "group_calculator-block",
				"title" => "calculator",
				"fields" => array(
					array(
						"key" => "field_calculator-block",
						"label" => "background-color",
						"name" => "background-color",
						"aria-label" => "",
						"type" => "color_picker",
						"instructions" => "",
						"required" => 0,
						"conditional_logic" => 0,
						"wrapper" => array(
							"width" => "",
							"class" => "",
							"id" => ""
						),
						"default_value" => "",
						"enable_opacity" => 1,
						"return_format" => "string"
					)
				),
				"location" => array(
					array(
						array(
							"param" => "block",
							"operator" => "==",
							"value" => "acf/calculator-block"
						)
					)
				),
				"menu_order" => 0,
				"position" => "normal",
				"style" => "default",
				"label_placement" => "top",
				"instruction_placement" => "label",
				"hide_on_screen" => "",
				"active" => true,
				"description" => "",
				"show_in_rest" => 1
			)
		)
	);
}
