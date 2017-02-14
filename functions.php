<?php
/**
 * base_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package base_theme
 */

if ( ! function_exists( 'base_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function base_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on base_theme, use a find and replace
	 * to change 'base_theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'base_theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'base_theme' ),
		'secondary-menu' => __( 'secondary Menu' )) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'base_theme_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'base_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function base_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'base_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'base_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function base_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'base_theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'base_theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area', 'base_theme' ),
		'id'            => 'footer-widget-area',
		'description'   => esc_html__( 'Footer widget area.', 'base_theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'base_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function base_theme_scripts() {
	wp_enqueue_style( 'base_theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'base_theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'base_theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'base_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



function base_theme_tag_cloud_font_size($args) {
    $args['smallest'] = 12; /* Set the smallest size to 12px */
    $args['largest'] = 12;  /* set the largest size to 19px */
    return $args; 
}

add_filter('widget_tag_cloud_args','base_theme_tag_cloud_font_size');

class author_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'author_widget',
			__('Author Widget', 'base_theme'),
			array('description' => __('Display list of authors', 'base_theme'), 
			'classname' => 'widget_authors'));
	}
	public function widget($args) {
		global $wpdb;
	 
    echo $args['before_widget'];
    echo "<ul>";

	/*$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name"); */
	 $args= array(role__in => array('author', 'administrator', 'contributor'));
	 $authors = get_users($args);


	foreach($authors as $author) {
	echo "<li>";
	/*echo "<a href=\"".get_bloginfo('url')."/?author="; */
    echo "<a href=\"". esc_url( home_url() ) ."/?author=";
	echo $author->ID;
	echo "\">";
	echo get_avatar($author->ID);
	echo "<h4>";
	the_author_meta('first_name', $author->ID);
	echo "<br/>";
	the_author_meta('last_name', $author->ID);
	echo "</h4>";
	echo "</a>";
	echo "</li>";
	}
    echo "</ul>";
    echo $args['after_widget'];

	}
}

function base_theme_load_widget() {
    register_widget( 'author_widget' );
}
add_action( 'widgets_init', 'base_theme_load_widget' );


function base_theme_add_google_fonts() {

wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:200,200i,600,900|Titillium+Web:300,300i,400,600|Rubik:400,400i,500,500i,700i,900i', false );
}

add_action( 'wp_enqueue_scripts', 'base_theme_add_google_fonts' );