<?php
/**
 * Dainik Bangladesher Kotha (BD News Alamin) Functions and Definitions
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BDK_THEME_VERSION', '1.2.0' );
define( 'BDK_THEME_DIR', get_template_directory() );
define( 'BDK_THEME_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function bdk_theme_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'bd-news-alamin', BDK_THEME_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 480, true );
	add_image_size( 'bdk-lead', 1000, 560, true );
	add_image_size( 'bdk-grid', 600, 380, true );
	add_image_size( 'bdk-thumb', 240, 160, true );

	// Register Navigation Menus
	register_nav_menus( array(
		'primary'           => 'প্রধান মেনু (Primary Header Menu)',
		'topbar'            => 'টপ হেডার মেনু (Top Bar Menu)',
		'footer_categories' => 'ফুটার ক্যাটাগরি মেনু (Footer Categories)',
		'footer_legal'      => 'ফুটার পলিসি ও প্রয়োজনীয় লিংক (Footer Legal)',
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Custom Logo Support
	add_theme_support( 'custom-logo', array(
		'height'      => 75,
		'width'       => 280,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Gutenberg & Block Editor Support
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'bdk_theme_setup' );

/**
 * Enqueue Styles and Scripts
 */
function bdk_enqueue_scripts() {
	// Google Fonts
	wp_enqueue_style(
		'bdk-google-fonts',
		'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@600;700;800&family=Outfit:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	// Font Awesome 6
	wp_enqueue_style(
		'bdk-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
		array(),
		'6.5.1'
	);

	// Theme Main Styles
	wp_enqueue_style( 'bdk-style-core', BDK_THEME_URI . '/css/style.css', array(), BDK_THEME_VERSION );
	wp_enqueue_style( 'bdk-style-responsive', BDK_THEME_URI . '/css/responsive.css', array( 'bdk-style-core' ), BDK_THEME_VERSION );
	wp_enqueue_style( 'bdk-style', get_stylesheet_uri(), array( 'bdk-style-responsive' ), BDK_THEME_VERSION );

	// JavaScript Modules
	wp_enqueue_script( 'bdk-dark-mode', BDK_THEME_URI . '/js/dark-mode.js', array(), BDK_THEME_VERSION, false ); // in head/early to prevent flash
	wp_enqueue_script( 'bdk-location-time', BDK_THEME_URI . '/js/location-time.js', array(), BDK_THEME_VERSION, true );
	wp_enqueue_script( 'bdk-market-ticker', BDK_THEME_URI . '/js/market-ticker.js', array(), BDK_THEME_VERSION, true );
	wp_enqueue_script( 'bdk-main', BDK_THEME_URI . '/js/main.js', array(), BDK_THEME_VERSION, true );

	// Weather & Prayer dynamic widget
	wp_enqueue_script( 'bdk-weather-prayer', BDK_THEME_URI . '/js/weather-prayer.js', array(), BDK_THEME_VERSION, true );
	wp_localize_script( 'bdk-weather-prayer', 'bdkApiConfig', array(
		'owmKey'        => get_theme_mod( 'bdk_owm_api_key', '' ),
		'weatherCity'   => get_theme_mod( 'bdk_weather_city', 'Dhaka' ),
		'prayerCity'    => get_theme_mod( 'bdk_prayer_city', 'Dhaka' ),
		'prayerSchool'  => get_theme_mod( 'bdk_prayer_school', '1' ),
		'maghribOffset' => (int) get_theme_mod( 'bdk_prayer_maghrib_offset', 3 ),
		'dhuhrOffset'   => (int) get_theme_mod( 'bdk_prayer_dhuhr_offset', 2 ),
		'fajrOffset'    => (int) get_theme_mod( 'bdk_prayer_fajr_offset', 0 ),
		'asrOffset'     => (int) get_theme_mod( 'bdk_prayer_asr_offset', 0 ),
		'ishaOffset'    => (int) get_theme_mod( 'bdk_prayer_isha_offset', 2 ),
	) );

	// Localize script for AJAX
	wp_localize_script( 'bdk-main', 'bdk_vars', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'bdk_ajax_nonce' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bdk_enqueue_scripts' );

/**
 * Register Sidebars and Widget Areas
 */
function bdk_widgets_init() {
	// Single Post Sidebar
	register_sidebar( array(
		'name'          => 'সিঙ্গেল পোস্ট সাইডবার (Single Post Sidebar)',
		'id'            => 'sidebar-single',
		'description'   => 'সিঙ্গেল নিউজের ডানপাশের সাইডবারে উইজেট যোগ করুন।',
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="sidebar-widget-header"><span class="title-bar-accent"></span><h3>',
		'after_title'   => '</h3></div>',
	) );

	// Archive & Category Sidebar
	register_sidebar( array(
		'name'          => 'আর্কাইভ সাইডবার (Archive Sidebar)',
		'id'            => 'sidebar-archive',
		'description'   => 'ক্যাটাগরি ও আর্কাইভ পেজের সাইডবার।',
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="sidebar-widget-header"><span class="title-bar-accent"></span><h3>',
		'after_title'   => '</h3></div>',
	) );

	// Header Ad Slot
	register_sidebar( array(
		'name'          => 'হেডার ব্যানার বিজ্ঞাপন (Header Ad 728x90)',
		'id'            => 'header-ad-slot',
		'description'   => 'মেইন হেডারে লোগোর পাশের ৭২৮x৯০ ব্যানার অ্যাড।',
		'before_widget' => '<div class="header-ad-wrapper">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="screen-reader-text">',
		'after_title'   => '</span>',
	) );
}
add_action( 'widgets_init', 'bdk_widgets_init' );

/**
 * Include Required Modules
 */
require_once BDK_THEME_DIR . '/inc/template-tags.php';
require_once BDK_THEME_DIR . '/inc/taxonomy-district.php';
require_once BDK_THEME_DIR . '/inc/cpt-videos.php';
require_once BDK_THEME_DIR . '/inc/cpt-photo-stories.php';
require_once BDK_THEME_DIR . '/inc/customizer.php';
require_once BDK_THEME_DIR . '/inc/photo-card-integration.php';
require_once BDK_THEME_DIR . '/inc/demo-importer.php';
require_once BDK_THEME_DIR . '/inc/reporter-portal.php';
require_once BDK_THEME_DIR . '/inc/plugin-recommendations.php';
require_once BDK_THEME_DIR . '/inc/ad-booking-manager.php';

/**
 * Auto-create Opinions page if missing in database
 */
function bdk_opinions_page_auto_setup() {
	if ( ! get_option( 'bdk_opinions_page_initialized' ) ) {
		$existing_page = get_page_by_path( 'opinions' );
		if ( ! $existing_page ) {
			$page_id = wp_insert_post( array(
				'post_title'   => 'মতামত ও পাঠকদের প্রতিক্রিয়া',
				'post_name'    => 'opinions',
				'post_content' => 'পাঠকদের মূল্যবান গঠনমূলক মন্তব্য, সম্পাদকীয় পর্যালোচনা ও মুক্ত আলোচনা।',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-opinions.php' );
			}
		} else {
			update_post_meta( $existing_page->ID, '_wp_page_template', 'page-opinions.php' );
		}
		update_option( 'bdk_opinions_page_initialized', 1 );
	}
}
add_action( 'init', 'bdk_opinions_page_auto_setup' );

/**
 * Universal Template Routing for /opinions and /opinion URL
 */
function bdk_opinions_template_include( $template ) {
	if ( is_page( 'opinions' ) || is_page( 'opinion' ) ) {
		$opinions_template = locate_template( 'page-opinions.php' );
		if ( $opinions_template ) {
			return $opinions_template;
		}
	}

	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$request_path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
		$home_path    = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
		if ( ! empty( $home_path ) && strpos( $request_path, $home_path ) === 0 ) {
			$request_path = trim( substr( $request_path, strlen( $home_path ) ), '/' );
		}

		if ( $request_path === 'opinions' || $request_path === 'opinion' ) {
			$opinions_template = locate_template( 'page-opinions.php' );
			if ( $opinions_template ) {
				global $wp_query;
				if ( $wp_query ) {
					$wp_query->is_404  = false;
					$wp_query->is_page = true;
				}
				status_header( 200 );
				return $opinions_template;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'bdk_opinions_template_include', 99 );

/**
 * Automatically inject sub-menu icons and dropdown arrows for Primary Nav Menu
 */
function bdk_nav_menu_icons( $title, $item, $args, $depth ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$icon_map = array(
			'জাতীয়'            => '<i class="fas fa-flag" style="color: #ef4444; margin-right: 4px;"></i> ',
			'রাজনীতি'          => '<i class="fas fa-landmark" style="color: #3b82f6; margin-right: 4px;"></i> ',
			'আন্তর্জাতিক'      => '<i class="fas fa-globe" style="color: #10b981; margin-right: 4px;"></i> ',
			'খেলাধুলা'          => '<i class="fas fa-trophy" style="color: #f59e0b; margin-right: 4px;"></i> ',
			'অন্যান্য'          => '<i class="fas fa-cubes" style="color: #8b5cf6; margin-right: 4px;"></i> ',
			'ক্রিকেট'           => '<i class="fas fa-baseball-bat-ball" style="color: #059669;"></i> ',
			'ফুটবল'            => '<i class="fas fa-futbol" style="color: #2563eb;"></i> ',
			'টেনিস'            => '<i class="fas fa-table-tennis-paddle-ball" style="color: #d97706;"></i> ',
			'অলিম্পিক'          => '<i class="fas fa-trophy" style="color: #eab308;"></i> ',
			'স্থানীয় খেলাধুলা'  => '<i class="fas fa-medal" style="color: #9333ea;"></i> ',
			'অর্থ ও বাণিজ্য'     => '<i class="fas fa-chart-line" style="color: #16a34a;"></i> ',
			'বিজ্ঞান ও প্রযুক্তি' => '<i class="fas fa-microchip" style="color: #0284c7;"></i> ',
			'বিনোদন'           => '<i class="fas fa-film" style="color: #e11d48;"></i> ',
			'কৃষি ও গ্রামীণ জীবন' => '<i class="fas fa-wheat-awn" style="color: #ca8a04;"></i> ',
			'চাকরি ও ক্যারিয়ার'  => '<i class="fas fa-briefcase" style="color: #0d9488;"></i> ',
			'শিক্ষা'            => '<i class="fas fa-graduation-cap" style="color: #4f46e5;"></i> ',
			'শিল্প ও সংস্কৃতি'   => '<i class="fas fa-palette" style="color: #9333ea;"></i> ',
			'সাহিত্য ও দেওয়ালিকা' => '<i class="fas fa-book-open" style="color: #c026d3;"></i> ',
			'প্রতিভার অন্বেষণ'   => '<i class="fas fa-star" style="color: #eab308;"></i> ',
			'স্বাস্থ্য ও চিকিৎসা' => '<i class="fas fa-user-doctor" style="color: #dc2626;"></i> ',
			'সম্পাদকীয় ও মতামত' => '<i class="fas fa-pen-nib" style="color: #2563eb;"></i> ',
		);

		$clean_title = trim( strip_tags( $title ) );
		if ( isset( $icon_map[ $clean_title ] ) && false === strpos( $title, '<i class=' ) ) {
			$title = $icon_map[ $clean_title ] . $title;
		}

		if ( in_array( 'menu-item-has-children', (array) $item->classes, true ) && false === strpos( $title, 'fa-angle-down' ) ) {
			$title .= ' <i class="fas fa-angle-down" style="font-size: 0.72rem; margin-left: 3px;"></i>';
		}
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'bdk_nav_menu_icons', 10, 4 );




