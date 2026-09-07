<?php
/**
 * Theme Customizer Settings & Live Controls (Hero Counts, Ads Manager, Category Controls)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once BDK_THEME_DIR . '/inc/customizer-repeater.php';

/**
 * Helper to retrieve category term ID by matching slugs
 */
function bdk_get_category_id_by_slug( $slugs ) {
	if ( ! is_array( $slugs ) ) {
		$slugs = array( $slugs );
	}
	foreach ( $slugs as $slug ) {
		$term = get_category_by_slug( $slug );
		if ( $term && ! is_wp_error( $term ) ) {
			return (string) $term->term_id;
		}
	}
	return '0';
}

/**
 * Sanitize Checkbox Inputs
 */
function bdk_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === (bool) $checked ) ? true : false );
}

/**
 * Default homepage sections configuration
 */
function bdk_get_default_homepage_sections() {
	return array(
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'national', 'politics', 'জাতীয়', 'জাতীয়-ও-রাজনীতি' ) ),
			'layout'      => 'design_1',
			'title'       => 'জাতীয় ও রাজনীতি',
			'btn_text'    => 'আরও দেখুন',
			'posts_count' => 6,
			'enabled'     => true,
		),
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'saradesh', 'district', 'সারাদেশ' ) ),
			'layout'      => 'design_8',
			'title'       => 'সারাদেশ ও জেলা বার্তা',
			'btn_text'    => 'সকল জেলা',
			'posts_count' => 8,
			'enabled'     => true,
		),
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'entertainment', 'lifestyle', 'বিনোদন' ) ),
			'layout'      => 'design_2',
			'title'       => 'বিনোদন ও লাইফস্টাইল',
			'btn_text'    => 'আরও বিনোদন',
			'posts_count' => 4,
			'enabled'     => true,
		),
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'economy', 'business', 'অর্থনীতি' ) ),
			'layout'      => 'design_3',
			'title'       => 'অর্থনীতি ও বাণিজ্য মেট্রিক্স',
			'btn_text'    => 'বাজার বিশ্লেষণ',
			'posts_count' => 4,
			'enabled'     => true,
		),
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'sports', 'cricket', 'খেলাধুলা' ) ),
			'layout'      => 'design_6',
			'title'       => 'খেলাধুলা ও প্রযুক্তি',
			'btn_text'    => 'স্কোর ও খবর',
			'posts_count' => 6,
			'enabled'     => true,
		),
		array(
			'category'    => bdk_get_category_id_by_slug( array( 'international', 'world', 'আন্তর্জাতিক' ) ),
			'layout'      => 'design_4',
			'title'       => 'আন্তর্জাতিক ও বিশ্ব দৃষ্টিভঙ্গি',
			'btn_text'    => 'বিশ্ব সংবাদ',
			'posts_count' => 4,
			'enabled'     => true,
		),
	);
}

/**
 * Sanitize Repeater Data for Customizer
 */
function bdk_sanitize_repeater_data( $input ) {
	if ( empty( $input ) ) {
		return wp_json_encode( array() );
	}
	if ( is_string( $input ) ) {
		$decoded = json_decode( wp_unslash( $input ), true );
	} else {
		$decoded = (array) $input;
	}
	if ( ! is_array( $decoded ) ) {
		return wp_json_encode( array() );
	}

	$sanitized       = array();
	$allowed_layouts = array( 'design_1', 'design_2', 'design_3', 'design_4', 'design_5', 'design_6', 'design_7', 'design_8' );

	foreach ( $decoded as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$cat_id      = isset( $item['category'] ) ? (string) absint( $item['category'] ) : '0';
		$layout      = isset( $item['layout'] ) && in_array( $item['layout'], $allowed_layouts, true ) ? $item['layout'] : 'design_1';
		$title       = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
		$btn_text    = isset( $item['btn_text'] ) ? sanitize_text_field( $item['btn_text'] ) : '';
		$posts_count = isset( $item['posts_count'] ) && ! empty( $item['posts_count'] ) ? max( 1, min( 30, absint( $item['posts_count'] ) ) ) : '';
		$enabled     = ! isset( $item['enabled'] ) || ! empty( $item['enabled'] );

		$sanitized[] = array(
			'category'    => $cat_id,
			'layout'      => $layout,
			'title'       => $title,
			'btn_text'    => $btn_text,
			'posts_count' => $posts_count,
			'enabled'     => $enabled,
		);
	}

	return wp_json_encode( $sanitized );
}

/**
 * Get active homepage sections list
 */
function bdk_get_homepage_sections() {
	$raw = get_theme_mod( 'bdk_homepage_sections_data' );
	if ( empty( $raw ) ) {
		return bdk_get_default_homepage_sections();
	}
	$decoded = json_decode( $raw, true );
	if ( ! is_array( $decoded ) || empty( $decoded ) ) {
		return bdk_get_default_homepage_sections();
	}
	return $decoded;
}

function bdk_customize_register( $wp_customize ) {

	// ================= 0. LOGO & BRANDING PANEL =================
	$wp_customize->add_section( 'bdk_logo_section', array(
		'title'       => '🖼️ লোগো ও ব্র্যান্ডিং সেটিংস (Logo & Branding)',
		'priority'    => 15,
		'description' => 'ওয়েবসাইটের হেডার এবং ফুটারের জন্য লোগো আপলোড ও সাইজ নির্ধারণ করুন।',
	) );

	// Custom Site Name / Brand Name
	$wp_customize->add_setting( 'bdk_custom_site_name', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_custom_site_name', array(
		'label'       => 'সাইটের নাম / ব্র্যান্ডিং নাম (Site Name / Branding)',
		'description' => 'এখানে যেকোনো নাম দিতে পারেন। খালি রাখলে WordPress জেনারেল সেটিংসের সাইট টাইটেল (Site Title) স্বয়ংক্রিয়ভাবে ডিফল্ট হিসেবে ব্যবহৃত হবে।',
		'section'     => 'bdk_logo_section',
		'type'        => 'text',
		'priority'    => 5,
	) );

	// Header Main Logo
	$wp_customize->add_setting( 'bdk_header_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bdk_header_logo', array(
		'label'       => 'হেডার মেইন লোগো (Header Main Logo)',
		'description' => 'মূল হেডারে প্রদর্শিত হবে (PNG, JPG, SVG)। খালি রাখলে ডিফল্ট লোগো শো করবে।',
		'section'     => 'bdk_logo_section',
		'settings'    => 'bdk_header_logo',
	) ) );

	// Header Logo Width
	$wp_customize->add_setting( 'bdk_header_logo_width', array(
		'default'           => 260,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_header_logo_width', array(
		'label'       => 'হেডার লোগো সর্বোচ্চ প্রস্থ / Max-Width (px)',
		'section'     => 'bdk_logo_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 80, 'max' => 600, 'step' => 5 ),
	) );

	// Header Logo Height
	$wp_customize->add_setting( 'bdk_header_logo_height', array(
		'default'           => 68,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_header_logo_height', array(
		'label'       => 'হেডার লোগো উচ্চতা / Height (px)',
		'section'     => 'bdk_logo_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 25, 'max' => 200, 'step' => 2 ),
	) );

	// Dark Mode Header Logo (Optional)
	$wp_customize->add_setting( 'bdk_dark_mode_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bdk_dark_mode_logo', array(
		'label'       => 'হেডার ডার্ক মোড লোগো (Dark Mode Logo - ঐচ্ছিক)',
		'description' => 'ডার্ক মোড সক্রিয় হলে যদি আলাদা বা সাদা লোগো দেখাতে চান।',
		'section'     => 'bdk_logo_section',
		'settings'    => 'bdk_dark_mode_logo',
	) ) );

	// Footer Logo
	$wp_customize->add_setting( 'bdk_footer_logo', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bdk_footer_logo', array(
		'label'       => 'ফুটার লোগো (Footer Logo)',
		'description' => 'ফুটারের ডার্ক ব্যাকগ্রাউন্ডের জন্য আলাদা লোগো আপলোড করুন। খালি থাকলে হেডার লোগো ব্যবহার হবে।',
		'section'     => 'bdk_logo_section',
		'settings'    => 'bdk_footer_logo',
	) ) );

	// Footer Logo Width
	$wp_customize->add_setting( 'bdk_footer_logo_width', array(
		'default'           => 220,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_footer_logo_width', array(
		'label'       => 'ফুটার লোগো সর্বোচ্চ প্রস্থ / Max-Width (px)',
		'section'     => 'bdk_logo_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 60, 'max' => 500, 'step' => 5 ),
	) );

	// Footer Logo Height
	$wp_customize->add_setting( 'bdk_footer_logo_height', array(
		'default'           => 48,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_footer_logo_height', array(
		'label'       => 'ফুটার লোগো উচ্চতা / Max Height (px)',
		'section'     => 'bdk_logo_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 20, 'max' => 150, 'step' => 2 ),
	) );

	// Default Post Thumbnail / Fallback Image
	$wp_customize->add_setting( 'bdk_default_post_thumbnail', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bdk_default_post_thumbnail', array(
		'label'       => 'ডিফল্ট পোস্ট ছবি / ব্যাকআপ থাম্বনেইল (Default Post Thumbnail)',
		'description' => 'কোনো পোস্টে ফিচার্ড ইমেজ না থাকলে ব্যাকআপ বা ফলব্যাক হিসেবে এই ছবিটি প্রদর্শিত হবে। খালি রাখলে স্ট্যান্ডার্ড ছবি শো করবে।',
		'section'     => 'bdk_logo_section',
		'settings'    => 'bdk_default_post_thumbnail',
	) ) );

	// ================= 1. BRAND COLORS PANEL =================
	$wp_customize->add_section( 'bdk_colors_section', array(
		'title'    => '🎨 থিমের কালার সেটিংস (Color Palette)',
		'priority' => 20,
	) );

	// Primary Color
	$wp_customize->add_setting( 'bdk_primary_color', array(
		'default'           => '#006a4e',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bdk_primary_color', array(
		'label'    => 'প্রধান রঙ (Primary Color / Emerald Green)',
		'section'  => 'bdk_colors_section',
		'settings' => 'bdk_primary_color',
	) ) );

	// Accent Color
	$wp_customize->add_setting( 'bdk_accent_color', array(
		'default'           => '#d32f2f',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bdk_accent_color', array(
		'label'    => 'হাইলাইট রঙ (Accent Color / Crimson Red)',
		'section'  => 'bdk_colors_section',
		'settings' => 'bdk_accent_color',
	) ) );

	// Secondary / Gold Color
	$wp_customize->add_setting( 'bdk_secondary_color', array(
		'default'           => '#f59e0b',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bdk_secondary_color', array(
		'label'    => 'সেকেন্ডারি গোল্ডেন রঙ (Gold Accent)',
		'section'  => 'bdk_colors_section',
		'settings' => 'bdk_secondary_color',
	) ) );

	// ================= 2. HERO TABS & POST COUNTS =================
	$wp_customize->add_section( 'bdk_hero_post_counts_section', array(
		'title'    => '🔢 পোস্ট সংখ্যা ও ট্যাব সেটিংস (Post Counts)',
		'priority' => 22,
		'description' => 'হিরো সেকশনের সর্বশেষ, জনপ্রিয়, আলোচিত এবং ট্রেন্ডিং খবরে কতটি করে পোস্ট শো করবে তা নির্ধারণ করুন।',
	) );

	// Latest Posts Count
	$wp_customize->add_setting( 'bdk_hero_tab_latest_count', array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_hero_tab_latest_count', array(
		'label'       => 'সর্বশেষ ট্যাব - পোস্ট সংখ্যা',
		'section'     => 'bdk_hero_post_counts_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 3, 'max' => 15, 'step' => 1 ),
	) );

	// Popular Posts Count
	$wp_customize->add_setting( 'bdk_hero_tab_popular_count', array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_hero_tab_popular_count', array(
		'label'       => 'জনপ্রিয় ট্যাব - পোস্ট সংখ্যা',
		'section'     => 'bdk_hero_post_counts_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 3, 'max' => 15, 'step' => 1 ),
	) );

	// Discussed Posts Count
	$wp_customize->add_setting( 'bdk_hero_tab_discussed_count', array(
		'default'           => 5,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_hero_tab_discussed_count', array(
		'label'       => 'আলোচিত ট্যাব - পোস্ট সংখ্যা',
		'section'     => 'bdk_hero_post_counts_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 3, 'max' => 15, 'step' => 1 ),
	) );

	// Trending News Count
	$wp_customize->add_setting( 'bdk_hero_trending_count', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_hero_trending_count', array(
		'label'       => 'ট্রেন্ডিং খবর - পোস্ট সংখ্যা',
		'section'     => 'bdk_hero_post_counts_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 2, 'max' => 10, 'step' => 1 ),
	) );

	// ================= 3. ORGANIZATION & EDITORIAL INFO =================
	$wp_customize->add_section( 'bdk_org_info_section', array(
		'title'       => '🏢 সম্পাদকীয় ও যোগাযোগ তথ্য (Org Info)',
		'priority'    => 25,
		'description' => 'ফুটারের সম্পাদকীয় প্যানেল ও যোগাযোগ তথ্য। যেকোনো পদবী বা নাম খালি রাখলে ফুটারে সংশ্লিষ্ট আইটেমটি প্রদর্শিত হবে না।',
	) );

	// 1. Editor & Publisher Title & Name
	$wp_customize->add_setting( 'bdk_editor_publisher_title', array(
		'default'           => 'সম্পাদক ও প্রকাশক',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_editor_publisher_title', array(
		'label'       => 'পদবী / হেডিং ১ (ডিফল্ট: সম্পাদক ও প্রকাশক)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'bdk_editor_publisher', array(
		'default'           => 'ছামিউল ইসলাম রিপন',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_editor_publisher', array(
		'label'       => 'ব্যক্তির নাম ১ (সম্পাদক ও প্রকাশক)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	// 2. News Editor Title & Name
	$wp_customize->add_setting( 'bdk_news_editor_title', array(
		'default'           => 'বার্তা সম্পাদক',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_news_editor_title', array(
		'label'       => 'পদবী / হেডিং ২ (ডিফল্ট: বার্তা সম্পাদক)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'bdk_news_editor', array(
		'default'           => 'মো. সিফাত',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_news_editor', array(
		'label'       => 'ব্যক্তির নাম ২ (বার্তা সম্পাদক)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	// 3. Editor Email Title & Address
	$wp_customize->add_setting( 'bdk_editor_email_title', array(
		'default'           => 'সম্পাদক ইমেইল',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_editor_email_title', array(
		'label'       => 'পদবী / হেডিং ৩ (ডিফল্ট: সম্পাদক ইমেইল)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'bdk_editor_email', array(
		'default'           => 'siripon455520@gmail.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'bdk_editor_email', array(
		'label'       => 'সম্পাদকের ইমেইল ঠিকানা',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'email',
	) );

	// 4. Hotline Title & Number
	$wp_customize->add_setting( 'bdk_phone_hotline_title', array(
		'default'           => 'অফিসিয়াল হটলাইন',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_phone_hotline_title', array(
		'label'       => 'পদবী / হেডিং ৪ (ডিফল্ট: অফিসিয়াল হটলাইন)',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'bdk_phone_hotline', array(
		'default'           => '01680182662',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_phone_hotline', array(
		'label'       => 'হটলাইন / ফোন নম্বর',
		'description' => 'খালি রাখলে ফুটারে এই বক্সটি প্রদর্শিত হবে না।',
		'section'     => 'bdk_org_info_section',
		'type'        => 'text',
	) );

	// General Office Address & Contacts
	$wp_customize->add_setting( 'bdk_office_address', array(
		'default'           => 'বাসা_ উদেরপাড়া (শান্তি নীড়), পোস্ট - ভাটারা, উপজেলা- সরিষাবাড়ী, জেলা- জামালপুর।',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'bdk_office_address', array(
		'label'   => 'অফিস ঠিকানা',
		'section' => 'bdk_org_info_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'bdk_whatsapp_number', array(
		'default'           => '01721029727',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_whatsapp_number', array(
		'label'   => 'হোয়াটসঅ্যাপ নম্বর',
		'section' => 'bdk_org_info_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bdk_official_email', array(
		'default'           => 'dainikbangladesherkotha@gmail.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'bdk_official_email', array(
		'label'   => 'অফিসিয়াল সাধারণ ইমেইল',
		'section' => 'bdk_org_info_section',
		'type'    => 'email',
	) );

	// ================= 3b. REPORTER RECRUITMENT SETTINGS =================
	$wp_customize->add_section( 'bdk_recruitment_section', array(
		'title'       => '📝 সাংবাদিক নিয়োগ সেটিংস (Recruitment)',
		'priority'    => 28,
		'description' => 'হেডার ও মেনুতে সাংবাদিক নিয়োগ বাটন এবং অনলাইন আবেদন অপশন চালু বা বন্ধ করার সেটিংস।',
	) );

	// 1. Enable / Disable Recruitment
	$wp_customize->add_setting( 'bdk_enable_reporter_recruitment', array(
		'default'           => true,
		'sanitize_callback' => 'bdk_sanitize_checkbox',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_enable_reporter_recruitment', array(
		'label'       => 'সাংবাদিক নিয়োগ চালু রাখুন (Enable Recruitment)',
		'description' => 'অন থাকলে হেডার ও মেনুতে "সাংবাদিক নিয়োগ" বাটন প্রদর্শিত হবে এবং ভিজিটররা অনলাইনে আবেদন করতে পারবে। অফ করলে মেনু ও হেডারের বাটন লুকানো থাকবে এবং নিয়োগ আবেদন পেজে অ্যাক্সেস বন্ধ থাকবে।',
		'section'     => 'bdk_recruitment_section',
		'type'        => 'checkbox',
	) );

	// 2. Button Label
	$wp_customize->add_setting( 'bdk_recruitment_btn_text', array(
		'default'           => 'সাংবাদিক নিয়োগ',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_recruitment_btn_text', array(
		'label'       => 'বাটনের টেক্সট (Button Label)',
		'description' => 'হেডার ও মেনুর বাটনে যে লেখাটি প্রদর্শিত হবে (ডিফল্ট: সাংবাদিক নিয়োগ)।',
		'section'     => 'bdk_recruitment_section',
		'type'        => 'text',
	) );

	// 3. Closed Notice Message
	$wp_customize->add_setting( 'bdk_recruitment_closed_msg', array(
		'default'           => 'বর্তমানে নতুন সাংবাদিক নিয়োগ কার্যক্রম সাময়িকভাবে স্থগিত রয়েছে। পরবর্তী বিজ্ঞপ্তির জন্য আমাদের সাথে থাকুন।',
		'sanitize_callback' => 'sanitize_textarea_field',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_recruitment_closed_msg', array(
		'label'       => 'নিয়োগ বন্ধ থাকার নোটিশ (Notice when Closed)',
		'description' => 'নিয়োগ অপশন অফ থাকলে আবেদন পেজে ভিজিটরদের এই বার্তাটি প্রদর্শিত হবে।',
		'section'     => 'bdk_recruitment_section',
		'type'        => 'textarea',
	) );

	// ================= 3c. ADVERTISING PAGE & CONTACT SETTINGS =================
	$wp_customize->add_section( 'bdk_advertising_section', array(
		'title'       => '📢 বিজ্ঞাপন পেজ ও যোগাযোগ সেটিংস (Advertising Info)',
		'priority'    => 29,
		'description' => 'বিজ্ঞাপন পেজ (/advertising) এর জরুরি যোগাযোগ নম্বর, ইমেইল, পেমেন্ট মাধ্যম ও শর্তাবলী এখান থেকে পরিবর্তন করুন।',
	) );

	// 1. Contact Box Title
	$wp_customize->add_setting( 'bdk_ad_page_contact_title', array(
		'default'           => '📞 জরুরি যোগাযোগ (বিজ্ঞাপন বিভাগ):',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_contact_title', array(
		'label'       => 'জরুরি যোগাযোগ শিরোনাম (Heading)',
		'section'     => 'bdk_advertising_section',
		'type'        => 'text',
	) );

	// 2. Emergency Phone Numbers
	$wp_customize->add_setting( 'bdk_ad_page_phone', array(
		'default'           => '+৮৮০ ১৭০০-০০০০০০ / ০১৮০০-০০০০০০',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_phone', array(
		'label'       => 'বিজ্ঞাপন ফোন নম্বর (Phone Numbers)',
		'description' => 'যেমন: +৮৮০ ১৭০০-০০০০০০ / ০১৮০০-০০০০০০',
		'section'     => 'bdk_advertising_section',
		'type'        => 'text',
	) );

	// 3. Ad Email
	$wp_customize->add_setting( 'bdk_ad_page_email', array(
		'default'           => 'ads@dainikbangladesherkotha.com',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_email', array(
		'label'       => 'বিজ্ঞাপন ইমেইল (Ad Email)',
		'description' => 'যেমন: ads@dainikbangladesherkotha.com',
		'section'     => 'bdk_advertising_section',
		'type'        => 'text',
	) );

	// 4. Payment Box Title
	$wp_customize->add_setting( 'bdk_ad_page_payment_title', array(
		'default'           => 'পেমেন্ট মাধ্যম ও সরাসরি যোগাযোগ:',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_payment_title', array(
		'label'       => 'পেমেন্ট বক্স শিরোনাম',
		'section'     => 'bdk_advertising_section',
		'type'        => 'text',
	) );

	// 5. Payment Box Description
	$wp_customize->add_setting( 'bdk_ad_page_payment_desc', array(
		'default'           => 'বুকিং কনফার্ম হওয়ার পর বিকাশ, নগদ, রকেট অথবা সরাসরি ব্যাংক ট্রান্সফারের মাধ্যমে পেমেন্ট সম্পন্ন করতে পারবেন।',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_payment_desc', array(
		'label'       => 'পেমেন্ট মাধ্যম সংক্রান্ত বিবরণ',
		'section'     => 'bdk_advertising_section',
		'type'        => 'textarea',
	) );

	// 6. Terms Box Title
	$wp_customize->add_setting( 'bdk_ad_page_terms_title', array(
		'default'           => 'বিজ্ঞাপনের শর্তাবলী ও বিন্যাস:',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_ad_page_terms_title', array(
		'label'       => 'বিজ্ঞাপনের শর্তাবলী শিরোনাম',
		'section'     => 'bdk_advertising_section',
		'type'        => 'text',
	) );

	// 7. Terms Box Content (List)
	$wp_customize->add_setting( 'bdk_ad_page_terms_content', array(
		'default'           => "<li><strong>ফরম্যাট:</strong> JPG, PNG, Static GIF অথবা Animated Banner গ্রহণযোগ্য।</li>\n<li><strong>সর্বোচ্চ ফাইল সাইজ:</strong> ব্যানার ফাইলের সাইজ ১৫০ KB এর মধ্যে হতে হবে।</li>\n<li><strong>ব্যানার ডিজাইন:</strong> প্রয়োজনে আমাদের অভিজ্ঞ গ্রাফিক ডিজাইনার দিয়ে আকর্ষণীয় ব্যানার তৈরি সুবিধা রয়েছে।</li>\n<li><strong>বিজ্ঞাপন অনুমোদন:</strong> জাতীয় নীতিমালার পরিপন্থী, অবাস্তব বা বিভ্রান্তিকর কোনো বিজ্ঞাপন প্রকাশ করা হয় না।</li>",
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'bdk_ad_page_terms_content', array(
		'label'       => 'শর্তাবলীর তালিকা (HTML <li>...</li> সাপোর্টেড)',
		'description' => 'প্রতিটি পয়েন্ট <li>...</li> দিয়ে লিখুন।',
		'section'     => 'bdk_advertising_section',
		'type'        => 'textarea',
	) );

	// ================= 4. SOCIAL MEDIA LINKS =================
	$wp_customize->add_section( 'bdk_social_section', array(
		'title'    => '🌐 সোশ্যাল মিডিয়া লিংক (Social Links)',
		'priority' => 30,
	) );

	$socials = array(
		'bdk_social_facebook'  => 'Facebook Page URL',
		'bdk_social_youtube'   => 'YouTube Channel URL',
		'bdk_social_whatsapp'  => 'WhatsApp Direct Chat URL',
		'bdk_social_twitter'   => 'Twitter / X URL',
		'bdk_social_instagram' => 'Instagram URL',
	);

	foreach ( $socials as $id => $label ) {
		$wp_customize->add_setting( $id, array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'bdk_social_section',
			'type'    => 'url',
		) );
	}

	// ================= 5. ADS MANAGER NOTICE (MOVED TO ADMIN MENU) =================
	$wp_customize->add_section( 'bdk_ad_notice_sec', array(
		'title'       => '📢 বিজ্ঞাপন ব্যানার ব্যবস্থাপনা (Admin Menu)',
		'priority'    => 35,
		'description' => 'বিজ্ঞাপনের সকল সেটিংস, মাল্টি-অ্যাড রোটেশন, ক্লিক ও ইম্প্রেশন রিপোর্ট এখন ওয়ার্ডপ্রেস এডমিন ড্যাশবোর্ডের 📢 "বিজ্ঞাপন বুকিং" মেনুতে স্থানান্তর করা হয়েছে।',
	) );


	// ================= 5b. API & PRAYER / WEATHER SETTINGS =================
	$wp_customize->add_section( 'bdk_api_section', array(
		'title'       => '🌤️ নামাজ ও আবহাওয়া সেটিংস (Prayer & Weather)',
		'priority'    => 37,
		'description' => 'বাংলাদেশের নামাজের সময় (ইসলামিক ফাউন্ডেশন সতর্কতা) ও আবহাওয়ার লাইভ সেটিংস।',
	) );

	// Prayer City
	$wp_customize->add_setting( 'bdk_prayer_city', array(
		'default'           => 'Dhaka',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_prayer_city', array(
		'label'       => 'নামাজের বিভাগ/শহর (ইংরেজিতে)',
		'description' => 'যেমন: Dhaka, Jamalpur, Chittagong, Sylhet, Rajshahi, Khulna, Barisal, Rangpur, Mymensingh',
		'section'     => 'bdk_api_section',
		'type'        => 'text',
	) );

	// Juristic School (Hanafi / Shafi'i)
	$wp_customize->add_setting( 'bdk_prayer_school', array(
		'default'           => '1',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_prayer_school', array(
		'label'       => 'মাযহাব ও আসরের হিসাব পদ্ধতি',
		'description' => 'বাংলাদেশে আসরের সঠিক সময়ের জন্য হানাফি নির্বাচন করুন।',
		'section'     => 'bdk_api_section',
		'type'        => 'select',
		'choices'     => array(
			'1' => 'হানাফি (Hanafi - বাংলাদেশ ইসলামিক ফাউন্ডেশন স্ট্যান্ডার্ড)',
			'0' => 'শাফেয়ী / মালেকী / হাম্বলী (Standard)',
		),
	) );

	// Islamic Foundation Bangladesh Maghrib/Iftar Safety Offset (+3 mins)
	$wp_customize->add_setting( 'bdk_prayer_maghrib_offset', array(
		'default'           => 3,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_prayer_maghrib_offset', array(
		'label'       => 'মাগরিব / ইফতার সতর্কতা যোগ (মিনিট)',
		'description' => 'ইসলামিক ফাউন্ডেশন সূর্যাস্তের সাথে +৩ মিনিট সতর্কতা যোগ করে (ডিফল্ট: ৩ মিনিট)।',
		'section'     => 'bdk_api_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0, 'max' => 10, 'step' => 1 ),
	) );

	// Dhuhr Safety Offset (+2 mins)
	$wp_customize->add_setting( 'bdk_prayer_dhuhr_offset', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_prayer_dhuhr_offset', array(
		'label'       => 'যোহর ওয়াক্ত সতর্কতা যোগ (মিনিট)',
		'description' => 'দুপুর সূর্য ঢলে পড়ার পর ওয়াক্ত শুরু (ডিফল্ট: ২ মিনিট)।',
		'section'     => 'bdk_api_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0, 'max' => 10, 'step' => 1 ),
	) );

	// Isha Safety Offset (+2 mins)
	$wp_customize->add_setting( 'bdk_prayer_isha_offset', array(
		'default'           => 2,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( 'bdk_prayer_isha_offset', array(
		'label'       => 'ইশা ওয়াক্ত সতর্কতা যোগ (মিনিট)',
		'description' => 'লালিমা ও শুভ্রতা দূর হওয়ার সতর্কতা (ডিফল্ট: ২ মিনিট)।',
		'section'     => 'bdk_api_section',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 0, 'max' => 10, 'step' => 1 ),
	) );

	// Weather City
	$wp_customize->add_setting( 'bdk_weather_city', array(
		'default'           => 'Dhaka',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_weather_city', array(
		'label'       => 'আবহাওয়ার শহর (ইংরেজিতে)',
		'description' => 'যেমন: Dhaka, Jamalpur, Chittagong',
		'section'     => 'bdk_api_section',
		'type'        => 'text',
	) );

	// OpenWeatherMap API Key
	$wp_customize->add_setting( 'bdk_owm_api_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_owm_api_key', array(
		'label'       => 'OpenWeatherMap API Key (ফ্রি)',
		'description' => 'openweathermap.org থেকে ফ্রি API কী এনে বসান।',
		'section'     => 'bdk_api_section',
		'type'        => 'text',
	) );

	// ================= 6. HOMEPAGE SECTIONS REPEATER & LAYOUT SETTINGS =================
	$wp_customize->add_section( 'bdk_homepage_sections', array(
		'title'       => '🏠 হোমপেজ সেকশন ও ক্যাটাগরি সেটিংস',
		'priority'    => 40,
		'description' => 'হোমপেজে আপনার ইচ্ছেমতো নতুন সেকশন যোগ করুন, প্রতিটি সেকশনে পছন্দের ডিজাইন লেআউট (ডিজাইন ১, ২, ৩...) এবং ক্যাটাগরি নির্ধারণ করুন।',
	) );

	// Homepage Sections Repeater Setting
	$wp_customize->add_setting( 'bdk_homepage_sections_data', array(
		'default'           => wp_json_encode( bdk_get_default_homepage_sections() ),
		'sanitize_callback' => 'bdk_sanitize_repeater_data',
		'transport'         => 'refresh',
	) );

	// Repeater Control
	$wp_customize->add_control( new BDK_Customizer_Repeater_Control(
		$wp_customize,
		'bdk_homepage_sections_data',
		array(
			'label'       => 'হোমপেজ সেকশন তালিকা ও লেআউট কন্ট্রোল',
			'description' => 'নিচের রিপিটার থেকে সেকশন যোগ, মুছে ফেলা, ক্যাটাগরি ও লেআউট ডিজাইন পছন্দমতো সাজিয়ে নিন।',
			'section'     => 'bdk_homepage_sections',
			'settings'    => 'bdk_homepage_sections_data',
			'priority'    => 10,
		)
	) );

	// Mid-Content Banner Ad Toggle
	$wp_customize->add_setting( 'bdk_show_mid_ad', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_show_mid_ad', array(
		'label'       => 'হোমপেজ মিড-কনটেন্ট ব্যানার বিজ্ঞাপন দেখাবেন?',
		'description' => 'দ্বিতীয় সেকশনের পর মাঝখানের ব্যানার অ্যাড স্লট প্রদর্শন করবে।',
		'section'     => 'bdk_homepage_sections',
		'type'        => 'checkbox',
		'priority'    => 20,
	) );

	// Video Section Toggle
	$wp_customize->add_setting( 'bdk_show_video_section', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_show_video_section', array(
		'label'       => 'ভিডিও বুলেটিন ও টকশো সেকশন দেখাবেন?',
		'section'     => 'bdk_homepage_sections',
		'type'        => 'checkbox',
		'priority'    => 25,
	) );

	// Investigative Spotlight Toggle
	$wp_customize->add_setting( 'bdk_show_investigative_section', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_show_investigative_section', array(
		'label'       => 'বিশেষ অনুসন্ধান ও ফিচার সিরিজ সেকশন দেখাবেন?',
		'section'     => 'bdk_homepage_sections',
		'type'        => 'checkbox',
		'priority'    => 30,
	) );

	// Opinion Section Toggle
	$wp_customize->add_setting( 'bdk_show_opinion_section', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_show_opinion_section', array(
		'label'       => 'মতামত ও সম্পাদকীয় সেকশন দেখাবেন?',
		'section'     => 'bdk_homepage_sections',
		'type'        => 'checkbox',
		'priority'    => 35,
	) );

	// Photo Gallery Section Toggle
	$wp_customize->add_setting( 'bdk_show_photo_section', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_control( 'bdk_show_photo_section', array(
		'label'       => 'ছবির গল্প ও ফটো অ্যালবাম সেকশন দেখাবেন?',
		'section'     => 'bdk_homepage_sections',
		'type'        => 'checkbox',
		'priority'    => 40,
	) );
}
add_action( 'customize_register', 'bdk_customize_register' );

/**
 * Universal Ad Renderer Helper Function
 * Supports: ON/OFF toggle, Device targeting (Hide on Mobile/Desktop), HTML code, uploaded image+link, responsive fit, and styled placeholder
 *
 * @param string $slot_key   Base key for the ad slot (e.g. 'bdk_header_ad')
 * @param string $slot_title Human-readable title for placeholder
 * @param string $slot_size  Size hint text for placeholder
 */
function bdk_display_ad_slot( $slot_key, $slot_title = 'বিজ্ঞাপন', $slot_size = 'বিজ্ঞাপন স্লট' ) {
	// Check Theme Multi-Banner System First
	$ad_slots_data = function_exists( 'bdk_get_theme_ad_slots' ) ? bdk_get_theme_ad_slots() : array();
	$wrapper_id    = 'ad-slot-' . sanitize_html_class( $slot_key );

	if ( isset( $ad_slots_data[ $slot_key ] ) ) {
		$slot_cfg = $ad_slots_data[ $slot_key ];
		
		if ( empty( $slot_cfg['enable'] ) ) {
			return; // Slot disabled
		}

		$banners = isset( $slot_cfg['banners'] ) ? array_values( $slot_cfg['banners'] ) : array();

		if ( ! empty( $banners ) ) {
			$mode    = isset( $slot_cfg['rotation_mode'] ) ? $slot_cfg['rotation_mode'] : 'reload';
			$seconds = isset( $slot_cfg['rotate_seconds'] ) ? max( 2, absint( $slot_cfg['rotate_seconds'] ) ) : 5;

			if ( 'reload' === $mode ) {
				// Pick 1 random banner on page load
				$banner = $banners[ array_rand( $banners ) ];
				$b_id   = $banner['id'];
				?>
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-wrapper no-print" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">
					<span class="ad-badge" style="display:inline-block; font-size:9px; font-weight:700; color:#888; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">বিজ্ঞাপন</span><br>
					<?php if ( ! empty( $banner['image'] ) ) : ?>
						<a href="<?php echo esc_url( ! empty( $banner['link'] ) ? $banner['link'] : '#' ); ?>" target="_blank" rel="noopener nofollow" class="bdk-trackable-ad-link" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b_id ); ?>" style="display:inline-block; max-width:100%; line-height:0; text-decoration:none;">
							<img src="<?php echo esc_url( $banner['image'] ); ?>" alt="<?php echo esc_attr( $banner['title'] ); ?>" class="theme-ad-img" style="height: auto; max-width: 100%; border-radius: 4px; display:inline-block; box-shadow: var(--card-shadow);">
						</a>
					<?php elseif ( ! empty( $banner['code'] ) ) : ?>
						<div class="bdk-trackable-ad-code" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b_id ); ?>">
							<?php echo do_shortcode( $banner['code'] ); ?>
						</div>
					<?php endif; ?>
				</div>
				<script>
				(function(){
					try {
						var fd = new FormData();
						fd.append('action', 'bdk_track_ad_impression');
						fd.append('slot_id', '<?php echo esc_js( $slot_key ); ?>');
						fd.append('banner_id', '<?php echo esc_js( $b_id ); ?>');
						navigator.sendBeacon ? navigator.sendBeacon('<?php echo admin_url( "admin-ajax.php" ); ?>', fd) : fetch('<?php echo admin_url( "admin-ajax.php" ); ?>', {method:'POST', body:fd});
					} catch(e){}
				})();
				</script>
				<?php
				return;
			} elseif ( 'timer' === $mode && count( $banners ) > 1 ) {
				// Auto Rotation Slider Mode
				$container_id = 'bdk_ad_slider_' . sanitize_html_class( $slot_key ) . '_' . rand( 100, 999 );
				?>
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-slider no-print" style="margin: 1.25rem auto; text-align: center; max-width: 100%; position: relative;">
					<span class="ad-badge" style="display:inline-block; font-size:9px; font-weight:700; color:#888; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">বিজ্ঞাপন</span><br>
					<div id="<?php echo esc_attr( $container_id ); ?>" class="bdk-ad-slides-container" style="position: relative;">
						<?php foreach ( $banners as $idx => $b ) : ?>
							<div class="bdk-ad-slide" data-banner="<?php echo esc_attr( $b['id'] ); ?>" style="display: <?php echo 0 === $idx ? 'block' : 'none'; ?>; transition: opacity 0.5s ease;">
								<?php if ( ! empty( $b['image'] ) ) : ?>
									<a href="<?php echo esc_url( ! empty( $b['link'] ) ? $b['link'] : '#' ); ?>" target="_blank" rel="noopener nofollow" class="bdk-trackable-ad-link" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b['id'] ); ?>" style="display:inline-block; max-width:100%; line-height:0; text-decoration:none;">
										<img src="<?php echo esc_url( $b['image'] ); ?>" alt="<?php echo esc_attr( $b['title'] ); ?>" class="theme-ad-img" style="height: auto; max-width: 100%; border-radius: 4px; display:inline-block; box-shadow: var(--card-shadow);">
									</a>
								<?php elseif ( ! empty( $b['code'] ) ) : ?>
									<div class="bdk-trackable-ad-code" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b['id'] ); ?>">
										<?php echo do_shortcode( $b['code'] ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<script>
				(function(){
					var container = document.getElementById('<?php echo esc_js( $container_id ); ?>');
					if (!container) return;
					var slides = container.querySelectorAll('.bdk-ad-slide');
					if (slides.length <= 1) return;
					var current = 0;

					function trackImp(bId) {
						try {
							var fd = new FormData();
							fd.append('action', 'bdk_track_ad_impression');
							fd.append('slot_id', '<?php echo esc_js( $slot_key ); ?>');
							fd.append('banner_id', bId);
							navigator.sendBeacon ? navigator.sendBeacon('<?php echo admin_url( "admin-ajax.php" ); ?>', fd) : fetch('<?php echo admin_url( "admin-ajax.php" ); ?>', {method:'POST', body:fd});
						} catch(e){}
					}

					// Track initial
					trackImp(slides[0].getAttribute('data-banner'));

					setInterval(function(){
						slides[current].style.display = 'none';
						current = (current + 1) % slides.length;
						slides[current].style.display = 'block';
						trackImp(slides[current].getAttribute('data-banner'));
					}, <?php echo $seconds * 1000; ?>);
				})();
				</script>
				<?php
				return;
			} else {
				// Single / Fixed Mode
				$banner = $banners[0];
				$b_id   = $banner['id'];
				?>
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-wrapper no-print" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">
					<span class="ad-badge" style="display:inline-block; font-size:9px; font-weight:700; color:#888; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">বিজ্ঞাপন</span><br>
					<?php if ( ! empty( $banner['image'] ) ) : ?>
						<a href="<?php echo esc_url( ! empty( $banner['link'] ) ? $banner['link'] : '#' ); ?>" target="_blank" rel="noopener nofollow" class="bdk-trackable-ad-link" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b_id ); ?>" style="display:inline-block; max-width:100%; line-height:0; text-decoration:none;">
							<img src="<?php echo esc_url( $banner['image'] ); ?>" alt="<?php echo esc_attr( $banner['title'] ); ?>" class="theme-ad-img" style="height: auto; max-width: 100%; border-radius: 4px; display:inline-block; box-shadow: var(--card-shadow);">
						</a>
					<?php elseif ( ! empty( $banner['code'] ) ) : ?>
						<div class="bdk-trackable-ad-code" data-slot="<?php echo esc_attr( $slot_key ); ?>" data-banner="<?php echo esc_attr( $b_id ); ?>">
							<?php echo do_shortcode( $banner['code'] ); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
				return;
			}
		}
	}

	// Legacy Fallback (Customizer Settings)
	$is_enabled = (bool) get_theme_mod( "{$slot_key}_enable", true );
	if ( ! $is_enabled ) {
		return;
	}

	$global_hide_mobile = (bool) get_theme_mod( 'bdk_ads_hide_all_mobile', false );
	$device_target      = get_theme_mod( "{$slot_key}_device_target", 'both' );
	$hide_mobile        = (bool) get_theme_mod( "{$slot_key}_hide_mobile", false );

	$device_class = '';
	if ( $global_hide_mobile || 'desktop_only' === $device_target || $hide_mobile ) {
		$device_class = ' bdk-hide-on-mobile';
	} elseif ( 'mobile_only' === $device_target ) {
		$device_class = ' bdk-hide-on-desktop';
	}

	$ad_code  = get_theme_mod( "{$slot_key}_code", get_theme_mod( $slot_key, '' ) );
	$ad_image = get_theme_mod( "{$slot_key}_image", '' );
	$ad_link  = get_theme_mod( "{$slot_key}_link", '' );
	$fit_mode = get_theme_mod( "{$slot_key}_fit", 'contain' );

	if ( ! empty( $ad_code ) ) {
		echo '<div id="' . esc_attr( $wrapper_id ) . '" class="theme-ad-wrapper theme-ad-code-slot no-print ' . esc_attr( $wrapper_id ) . esc_attr( $device_class ) . '" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">';
		echo do_shortcode( $ad_code );
		echo '</div>';
	} elseif ( ! empty( $ad_image ) ) {
		$fit_inline = ( 'auto' === $fit_mode ) ? 'height: auto; max-width: 100%;' : 'object-fit: ' . esc_attr( $fit_mode ) . '; width: 100%; max-width: 100%;';
		echo '<div id="' . esc_attr( $wrapper_id ) . '" class="theme-ad-wrapper theme-ad-image-banner no-print ' . esc_attr( $wrapper_id ) . esc_attr( $device_class ) . '" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">';
		echo '<span class="ad-badge" style="display:inline-block; font-size:9px; font-weight:700; color:#888; letter-spacing:1px; text-transform:uppercase; margin-bottom:4px;">বিজ্ঞাপন</span><br>';
		if ( ! empty( $ad_link ) ) {
			echo '<a href="' . esc_url( $ad_link ) . '" target="_blank" rel="noopener nofollow" class="theme-ad-link" style="display:inline-block; max-width:100%; line-height:0; text-decoration:none;">';
		}
		echo '<img src="' . esc_url( $ad_image ) . '" alt="' . esc_attr( $slot_title ) . '" class="theme-ad-img" style="' . $fit_inline . ' border-radius: 4px; display:inline-block; box-shadow: var(--card-shadow);">';
		if ( ! empty( $ad_link ) ) {
			echo '</a>';
		}
		echo '</div>';
	} else {
		$show_placeholder = (bool) get_theme_mod( 'bdk_ads_show_placeholder', true );
		if ( ! $show_placeholder ) {
			return;
		}
		?>
		<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-placeholder no-print <?php echo esc_attr( $wrapper_id ); ?><?php echo esc_attr( $device_class ); ?>" style="margin: 1.25rem auto; max-width: 970px; background: var(--surface-secondary); border: 2px dashed var(--border-color); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; text-align: center; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
			<div style="text-align: left;">
				<span class="ad-tag" style="background: var(--primary-color); color: #fff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 3px;">বিজ্ঞাপন</span>
				<h4 style="font-size: 1rem; font-weight: 700; color: var(--primary-color); margin: 4px 0 2px;"><?php echo esc_html( $slot_title ); ?></h4>
				<p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;"><?php echo esc_html( $slot_size ); ?> | প্রতিদিন ভিজিট করছেন দেশ-বিদেশের অগণিত পাঠক</p>
			</div>
			<a href="<?php echo esc_url( home_url( '/advertising' ) ); ?>" class="submit-brand-btn" style="padding: 0.45rem 1.2rem; font-size: 0.85rem; text-decoration: none;">
				বিজ্ঞাপন দিন
			</a>
		</div>
		<?php
	}
}

/**
 * Output Dynamic CSS from Customizer Theme Colors & Responsive Ad Heights directly into <head>
 */
function bdk_customizer_css() {
	$primary   = get_theme_mod( 'bdk_primary_color', '#006a4e' );
	$accent    = get_theme_mod( 'bdk_accent_color', '#d32f2f' );
	$secondary = get_theme_mod( 'bdk_secondary_color', '#f59e0b' );

	$header_logo_w = get_theme_mod( 'bdk_header_logo_width', 260 );
	$header_logo_h = get_theme_mod( 'bdk_header_logo_height', 68 );
	$footer_logo_w = get_theme_mod( 'bdk_footer_logo_width', 220 );
	$footer_logo_h = get_theme_mod( 'bdk_footer_logo_height', 48 );

	$ad_slots_css = array(
		'bdk_header_ad'     => array( 'h_d' => 85, 'h_m' => 65 ),
		'bdk_mid_ad'        => array( 'h_d' => 100, 'h_m' => 70 ),
		'bdk_archive_ad'    => array( 'h_d' => 90, 'h_m' => 65 ),
		'bdk_single_top_ad' => array( 'h_d' => 90, 'h_m' => 65 ),
		'bdk_single_mid_ad' => array( 'h_d' => 120, 'h_m' => 80 ),
		'bdk_single_bot_ad' => array( 'h_d' => 90, 'h_m' => 65 ),
		'bdk_sidebar_ad'    => array( 'h_d' => 250, 'h_m' => 220 ),
		'bdk_footer_ad'     => array( 'h_d' => 95, 'h_m' => 70 ),
	);
	?>
	<style type="text/css" id="bdk-customizer-colors">
		:root {
			--primary-color: <?php echo esc_attr( $primary ); ?>;
			--primary-hover: <?php echo esc_attr( $primary ); ?>ee;
			--primary-dark: <?php echo esc_attr( $primary ); ?>dd;
			--primary-gradient: linear-gradient(135deg, <?php echo esc_attr( $primary ); ?> 0%, #008765 100%);
			--accent-color: <?php echo esc_attr( $accent ); ?>;
			--accent-hover: <?php echo esc_attr( $accent ); ?>ee;
			--secondary-color: <?php echo esc_attr( $secondary ); ?>;
		}
		.brand-logo-img {
			max-width: <?php echo esc_attr( $header_logo_w ); ?>px;
			height: <?php echo esc_attr( $header_logo_h ); ?>px;
			object-fit: contain;
		}
		.footer-logo img,
		.footer-logo-img {
			max-width: <?php echo esc_attr( $footer_logo_w ); ?>px;
			max-height: <?php echo esc_attr( $footer_logo_h ); ?>px;
			height: auto;
			object-fit: contain;
		}
		.brand-logo-dark {
			display: none;
		}
		[data-theme="dark"] .brand-logo-dark {
			display: inline-block !important;
		}
		[data-theme="dark"] .brand-logo-light {
			display: none !important;
		}

		/* Device Target Visibility CSS */
		.bdk-hide-on-mobile {
			display: block;
		}
		@media (max-width: 768px) {
			.bdk-hide-on-mobile,
			.theme-ad-wrapper.bdk-hide-on-mobile,
			.theme-ad-placeholder.bdk-hide-on-mobile,
			.sidebar-ad-card:has(.bdk-hide-on-mobile) {
				display: none !important;
			}
			.header-ad-box:has(.bdk-hide-on-mobile) {
				display: none !important;
			}
			.homepage-mid-ad-container:has(.bdk-hide-on-mobile) {
				display: none !important;
			}
			.footer-ad-container:has(.bdk-hide-on-mobile) {
				display: none !important;
			}
		}

		.bdk-hide-on-desktop {
			display: none !important;
		}
		@media (max-width: 768px) {
			.bdk-hide-on-desktop,
			.theme-ad-wrapper.bdk-hide-on-desktop,
			.theme-ad-placeholder.bdk-hide-on-desktop {
				display: block !important;
			}
		}

		/* Responsive Ad Heights & Fitting */
		<?php
		foreach ( $ad_slots_css as $slot_id => $defaults ) {
			$hd  = absint( get_theme_mod( "{$slot_id}_height_desktop", $defaults['h_d'] ) );
			$hm  = absint( get_theme_mod( "{$slot_id}_height_mobile", $defaults['h_m'] ) );
			$fit = sanitize_key( get_theme_mod( "{$slot_id}_fit", 'contain' ) );

			if ( 'auto' === $fit ) {
				echo "#ad-slot-{$slot_id} .theme-ad-img { height: auto !important; max-height: none !important; max-width: 100%; display: block; margin: 0 auto; }\n";
			} else {
				echo "#ad-slot-{$slot_id} .theme-ad-img { height: {$hd}px !important; max-height: {$hd}px !important; object-fit: {$fit} !important; width: 100%; max-width: 100%; display: block; margin: 0 auto; }\n";
			}

			if ( 'bdk_header_ad' === $slot_id ) {
				echo ".header-ad-box { min-height: {$hd}px; height: auto; }\n";
			}

			echo "@media (max-width: 768px) {\n";
			if ( 'auto' !== $fit ) {
				echo "  #ad-slot-{$slot_id} .theme-ad-img { height: {$hm}px !important; max-height: {$hm}px !important; }\n";
			}
			if ( 'bdk_header_ad' === $slot_id ) {
				echo "  .header-ad-box { min-height: {$hm}px; height: auto; }\n";
			}
			echo "}\n";
		}
		?>
	</style>
	<?php
}
add_action( 'wp_head', 'bdk_customizer_css' );

/**
 * Modern Customizer Admin UI Styling for Toggle Switches & Sections
 */
function bdk_customizer_admin_styles() {
	?>
	<style type="text/css">
		/* Sleek iOS-style switch for Customizer Checkboxes */
		#sub-accordion-panel-bdk_ads_panel .customize-control-checkbox label {
			display: flex;
			align-items: center;
			justify-content: space-between;
			font-weight: 700;
			color: #0f172a;
			font-size: 13px;
			padding: 10px 12px;
			background: #f8fafc;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			cursor: pointer;
			margin-bottom: 8px;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control-checkbox input[type="checkbox"] {
			width: 44px;
			height: 24px;
			appearance: none;
			-webkit-appearance: none;
			background: #cbd5e1;
			border-radius: 24px;
			position: relative;
			outline: none;
			cursor: pointer;
			transition: all 0.25s ease;
			border: none;
			flex-shrink: 0;
			margin: 0;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control-checkbox input[type="checkbox"]:checked {
			background: #006a4e;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control-checkbox input[type="checkbox"]:before {
			content: '';
			position: absolute;
			width: 18px;
			height: 18px;
			border-radius: 50%;
			top: 3px;
			left: 3px;
			background: #ffffff;
			box-shadow: 0 2px 4px rgba(0,0,0,0.25);
			transition: all 0.25s ease;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control-checkbox input[type="checkbox"]:checked:before {
			left: 23px;
		}
		#sub-accordion-panel-bdk_ads_panel .accordion-section-title {
			font-weight: 700;
			color: #0f172a;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control {
			margin-bottom: 16px;
			padding-bottom: 12px;
			border-bottom: 1px solid #f1f5f9;
		}
		#sub-accordion-panel-bdk_ads_panel .customize-control-title {
			font-weight: 700;
			color: #1e293b;
			margin-bottom: 4px;
		}
		#sub-accordion-panel-bdk_ads_panel .description {
			color: #64748b;
			font-size: 12px;
			line-height: 1.45;
			margin-bottom: 8px;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'bdk_customizer_admin_styles' );

