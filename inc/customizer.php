<?php
/**
 * Theme Customizer Settings & Live Controls (Hero Counts, Ads Manager, Category Controls)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bdk_customize_register( $wp_customize ) {

	// ================= 0. LOGO & BRANDING PANEL =================
	$wp_customize->add_section( 'bdk_logo_section', array(
		'title'       => '🖼️ লোগো ও ব্র্যান্ডিং সেটিংস (Logo & Branding)',
		'priority'    => 15,
		'description' => 'ওয়েবসাইটের হেডার এবং ফুটারের জন্য লোগো আপলোড ও সাইজ নির্ধারণ করুন।',
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
		'title'    => '🏢 সম্পাদকীয় ও যোগাযোগ তথ্য (Org Info)',
		'priority' => 25,
	) );

	$wp_customize->add_setting( 'bdk_editor_publisher', array(
		'default'           => 'ছামিউল ইসলাম রিপন',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_editor_publisher', array(
		'label'   => 'সম্পাদক ও প্রকাশক',
		'section' => 'bdk_org_info_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bdk_news_editor', array(
		'default'           => 'মো. সিফাত',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_news_editor', array(
		'label'   => 'বার্তা সম্পাদক',
		'section' => 'bdk_org_info_section',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'bdk_office_address', array(
		'default'           => 'বাসা_ উদেরপাড়া (শান্তি নীড়), পোস্ট - ভাটারা, উপজেলা- সরিষাবাড়ী, জেলা- জামালপুর।',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'bdk_office_address', array(
		'label'   => 'অফিস ঠিকানা',
		'section' => 'bdk_org_info_section',
		'type'    => 'textarea',
	) );

	$wp_customize->add_setting( 'bdk_phone_hotline', array(
		'default'           => '01680182662',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'bdk_phone_hotline', array(
		'label'   => 'হটলাইন / ফোন নম্বর',
		'section' => 'bdk_org_info_section',
		'type'    => 'text',
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
		'label'   => 'অফিসিয়াল ইমেইল',
		'section' => 'bdk_org_info_section',
		'type'    => 'email',
	) );

	$wp_customize->add_setting( 'bdk_editor_email', array(
		'default'           => 'siripon455520@gmail.com',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'bdk_editor_email', array(
		'label'   => 'সম্পাদকের ইমেইল',
		'section' => 'bdk_org_info_section',
		'type'    => 'email',
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

	// ================= 6. HOMEPAGE SECTIONS & CATEGORY SELECTOR =================
	$wp_customize->add_section( 'bdk_homepage_sections', array(
		'title'       => '🏠 হোমপেজ সেকশন ও ক্যাটাগরি সেটিংস',
		'priority'    => 40,
		'description' => 'হোম পেজের প্রতিটি সেকশনের ক্যাটাগরি নিজের পছন্দমতো নির্ধারণ করুন।',
	) );

	// Categories helper for dropdowns
	$categories_array = array( '0' => '— সাম্প্রতিক সকল পোস্ট (Latest) —' );
	$categories       = get_categories( array( 'hide_empty' => false ) );
	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $cat ) {
			$categories_array[ $cat->term_id ] = $cat->name;
		}
	}

	$sections_config = array(
		'hero_national'   => '১. জাতীয় ও প্রধান সংবাদ (National & Hero)',
		'saradesh'        => '২. সারা দেশ / জেলা সংবাদ (Saradesh)',
		'entertainment'   => '৩. বিনোদন ও জীবনযাপন (Entertainment & Lifestyle)',
		'economy'         => '৪. অর্থনীতি ও বাণিজ্য মেট্রিক্স (Economy Matrix)',
		'sports'          => '৫. খেলাধুলা ও ক্রিকেট (Sports)',
		'technology'      => '৬. বিজ্ঞান ও প্রযুক্তি (Technology)',
		'international'   => '৭. আন্তর্জাতিক ও বিশ্ব ম্যাগাজিন (World News)',
		'investigative'   => '৮. বিশেষ অনুসন্ধান সিরিজ (Investigative Spotlight)',
		'opinion'         => '৯. মতামত ও সম্পাদকীয় (Opinion)',
		'photo'           => '১০. ছবির গল্প ও ফটো অ্যালবাম (Photo Gallery)',
	);

	foreach ( $sections_config as $key => $title ) {
		// Category selection setting
		$wp_customize->add_setting( "bdk_cat_{$key}", array(
			'default'           => '0',
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( "bdk_cat_{$key}", array(
			'label'   => $title . ' - ক্যাটাগরি নির্বাচন করুন',
			'section' => 'bdk_homepage_sections',
			'type'    => 'select',
			'choices' => $categories_array,
		) );

		// Section visibility setting
		$wp_customize->add_setting( "bdk_show_{$key}", array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		) );
		$wp_customize->add_control( "bdk_show_{$key}", array(
			'label'   => 'এই সেকশনটি হোম পেজে দেখাবেন?',
			'section' => 'bdk_homepage_sections',
			'type'    => 'checkbox',
		) );
	}
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
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-wrapper" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">
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
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-slider" style="margin: 1.25rem auto; text-align: center; max-width: 100%; position: relative;">
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
				<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-wrapper bdk-multi-ad-wrapper" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">
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
		echo '<div id="' . esc_attr( $wrapper_id ) . '" class="theme-ad-wrapper theme-ad-code-slot ' . esc_attr( $wrapper_id ) . esc_attr( $device_class ) . '" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">';
		echo do_shortcode( $ad_code );
		echo '</div>';
	} elseif ( ! empty( $ad_image ) ) {
		$fit_inline = ( 'auto' === $fit_mode ) ? 'height: auto; max-width: 100%;' : 'object-fit: ' . esc_attr( $fit_mode ) . '; width: 100%; max-width: 100%;';
		echo '<div id="' . esc_attr( $wrapper_id ) . '" class="theme-ad-wrapper theme-ad-image-banner ' . esc_attr( $wrapper_id ) . esc_attr( $device_class ) . '" style="margin: 1.25rem auto; text-align: center; max-width: 100%;">';
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
		<div id="<?php echo esc_attr( $wrapper_id ); ?>" class="theme-ad-placeholder <?php echo esc_attr( $wrapper_id ); ?><?php echo esc_attr( $device_class ); ?>" style="margin: 1.25rem auto; max-width: 970px; background: var(--surface-secondary); border: 2px dashed var(--border-color); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; text-align: center; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
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

