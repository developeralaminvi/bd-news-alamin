<?php
/**
 * Ad Manager, Multi-Banner Rotation & Analytics Module for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Default Theme Ad Slots Configuration
 */
function bdk_get_default_theme_ad_slots() {
	return array(
		'bdk_header_ad' => array(
			'title'          => '১. হেডার ব্যানার (Header Ad - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'timer',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_mid_ad' => array(
			'title'          => '২. হোমপেজ মিড-কনটент ব্যানার (Homepage Mid Ad - 970x90)',
			'enable'         => true,
			'rotation_mode'  => 'reload',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_archive_ad' => array(
			'title'          => '৩. ক্যাটাগরি ও জেলা পেজ ব্যানার (Category / Archive Ad - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'reload',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_single_top_ad' => array(
			'title'          => '৪. সিঙ্গেল পোস্ট: শীর্ষ ব্যানার (Single Post Top - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'timer',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_single_mid_ad' => array(
			'title'          => '৫. সিঙ্গেল পোস্ট: ইন-আর্টিকেল ব্যানার (In-Article Ad - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'timer',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_single_bot_ad' => array(
			'title'          => '৬. সিঙ্গেল পোস্ট: কমেন্টের পূর্বে ব্যানার (Single Post Bottom - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'reload',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_sidebar_ad' => array(
			'title'          => '৭. সাইডবার স্কয়ার ব্যানার (Sidebar Ad - 300x250)',
			'enable'         => true,
			'rotation_mode'  => 'timer',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
		'bdk_footer_ad' => array(
			'title'          => '৮. ফুটার / বটম ব্যানার (Footer Ad - 728x90)',
			'enable'         => true,
			'rotation_mode'  => 'reload',
			'rotate_seconds' => 5,
			'banners'        => array(),
		),
	);
}

/**
 * Get Theme Ad Slots Saved Data
 */
function bdk_get_theme_ad_slots() {
	$saved    = get_option( 'bdk_theme_ad_slots_data' );
	$defaults = bdk_get_default_theme_ad_slots();

	if ( empty( $saved ) || ! is_array( $saved ) ) {
		return $defaults;
	}

	// Merge missing slot keys
	foreach ( $defaults as $key => $def ) {
		if ( ! isset( $saved[ $key ] ) ) {
			$saved[ $key ] = $def;
		}
	}

	return $saved;
}

/**
 * Default Ad Booking Packages
 */
function bdk_get_default_ad_packages() {
	return array(
		'header-leaderboard' => array(
			'id'          => 'header-leaderboard',
			'title'       => 'হেডার টপ ব্যানার (Header Leaderboard)',
			'size'        => '728 x 90 px',
			'location'    => 'মেইন হেডার - লোগোর পাশে সকল পেজে দৃশ্যমান',
			'badge'       => 'জনপ্রিয় স্পট',
			'rates_text'  => '১ সপ্তাহ: ৩,৫০০ ৳ | ১ মাস: ১০,০০০ ৳ | ৩ মাস: ২৫,০০০ ৳',
			'desc'        => 'দৈনিক লক্ষ্যভিত্তিক পাঠকদের কাছে আপনার ব্র্যান্ড দ্রুত পৌঁছে দেওয়ার সবচেয়ে বড় ও দৃষ্টিনন্দন স্থান।',
			'active'      => true,
		),
		'sidebar-rectangle' => array(
			'id'          => 'sidebar-rectangle',
			'title'       => 'সাইডবার বক্স ব্যানার (Sidebar Square)',
			'size'        => '300 x 250 px',
			'location'    => 'প্রতিটি সংবাদের ডানপাশের সাইডবারে',
			'badge'       => 'হাই কনভার্সন',
			'rates_text'  => '১ সপ্তাহ: ২,৫০০ ৳ | ১ মাস: ৭,০০০ ৳ | ৩ মাস: ১৮,০০০ ৳',
			'desc'        => 'ইন-ডেপথ নিউজ পড়ার সময় দীর্ঘক্ষণ দৃষ্টি আকর্ষণ করে উচ্চ ক্লিক-থ্রু রেট (CTR) দেয়।',
			'active'      => true,
		),
		'in-article-banner' => array(
			'id'          => 'in-article-banner',
			'title'       => 'ইন-আর্টিকেল ব্যানার (In-Article Banner)',
			'size'        => '728 x 90 px / Full Width',
			'location'    => 'সংবাদ আর্টিকেলের ঠিক মাঝখানে কন্টেন্ট বডি',
			'badge'       => 'সর্বোচ্চ ভিউ',
			'rates_text'  => '১ সপ্তাহ: ৩,০০০ ৳ | ১ মাস: ৮,৫০০ ৳ | ৩ মাস: ২২,০০০ ৳',
			'desc'        => 'পাঠক যখন সম্পূর্ণ খবর পড়েন ঠিক তার চোখের সামনে ব্র্যান্ড মেসেজ পরিবেশন করে।',
			'active'      => true,
		),
		'sidebar-half-page' => array(
			'id'          => 'sidebar-half-page',
			'title'       => 'সাইডবার লার্জ ব্যানার (Half Page Banner)',
			'size'        => '300 x 600 px',
			'location'    => 'সাইডবার প্রমিজিং দীর্ঘতম স্থান',
			'badge'       => 'প্রিমিয়াম স্লট',
			'rates_text'  => '১ সপ্তাহ: ৪,০০০ ৳ | ১ মাস: ১২,০০০ ৳ | ৩ মাস: ৩০,০০০ ৳',
			'desc'        => 'বিশাল আকৃতির প্রিমিয়াম স্লট যা এক ক্লিকেই ব্যবহারকারীদের ব্যাপকভাবে আকৃষ্ট করে।',
			'active'      => true,
		),
	);
}

/**
 * Get Saved Ad Packages
 */
function bdk_get_ad_packages() {
	$saved = get_option( 'bdk_ad_packages_data' );
	if ( empty( $saved ) || ! is_array( $saved ) ) {
		$saved = bdk_get_default_ad_packages();
		update_option( 'bdk_ad_packages_data', $saved );
	}
	return $saved;
}

/**
 * Register Admin Menu & Enqueue Scripts
 */
function bdk_register_ad_manager_menu() {
	$page_hook = add_menu_page(
		'বিজ্ঞাপন বুকিং ও ম্যানেজার',
		'বিজ্ঞাপন বুকিং',
		'manage_options',
		'bdk-ad-manager',
		'bdk_render_ad_manager_page',
		'dashicons-megaphone',
		26
	);

	add_action( 'admin_print_styles-' . $page_hook, function() {
		wp_enqueue_media();
	} );
}
add_action( 'admin_menu', 'bdk_register_ad_manager_menu' );

/**
 * Render Ad Manager Main Admin Page
 */
function bdk_render_ad_manager_page() {
	$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'bookings';

	// Handle Booking Status Update
	if ( isset( $_POST['action'] ) && 'update_booking_status' === $_POST['action'] && check_admin_referer( 'bdk_update_status_nonce' ) ) {
		$booking_id = sanitize_text_field( $_POST['booking_id'] );
		$new_status = sanitize_text_field( $_POST['status'] );
		$bookings   = get_option( 'bdk_ad_bookings_list', array() );

		if ( isset( $bookings[ $booking_id ] ) ) {
			$bookings[ $booking_id ]['status'] = $new_status;
			update_option( 'bdk_ad_bookings_list', $bookings );
			echo '<div class="notice notice-success is-dismissible"><p>আবেদনের স্ট্যাটাস সফলভাবে পরিবর্তন করা হয়েছে!</p></div>';
		}
	}

	// Handle Delete Booking
	if ( isset( $_GET['action'] ) && 'delete_booking' === $_GET['action'] && isset( $_GET['id'] ) && check_admin_referer( 'bdk_delete_booking_nonce' ) ) {
		$booking_id = sanitize_text_field( $_GET['id'] );
		$bookings   = get_option( 'bdk_ad_bookings_list', array() );
		if ( isset( $bookings[ $booking_id ] ) ) {
			unset( $bookings[ $booking_id ] );
			update_option( 'bdk_ad_bookings_list', $bookings );
			echo '<div class="notice notice-success is-dismissible"><p>আবেদনটি মুছে ফেলা হয়েছে।</p></div>';
		}
	}

	// Handle Save Theme Ad Slots Configuration & Add Banner
	if ( isset( $_POST['action'] ) && 'save_theme_ad_slots' === $_POST['action'] && check_admin_referer( 'bdk_save_ad_slots_nonce' ) ) {
		$ad_slots = bdk_get_theme_ad_slots();

		// Save Slot General Settings
		if ( isset( $_POST['slots'] ) && is_array( $_POST['slots'] ) ) {
			foreach ( $_POST['slots'] as $s_key => $s_data ) {
				if ( isset( $ad_slots[ $s_key ] ) ) {
					$ad_slots[ $s_key ]['enable']         = isset( $s_data['enable'] ) ? true : false;
					$ad_slots[ $s_key ]['rotation_mode']  = sanitize_text_field( $s_data['rotation_mode'] );
					$ad_slots[ $s_key ]['rotate_seconds'] = absint( $s_data['rotate_seconds'] );
				}
			}
		}

		// Handle New Banner Addition (Supports multiple dynamic repeater banners)
		if ( ! empty( $_POST['new_banners'] ) && is_array( $_POST['new_banners'] ) ) {
			foreach ( $_POST['new_banners'] as $s_key => $b_list ) {
				if ( ! isset( $ad_slots[ $s_key ] ) || ! is_array( $b_list ) ) {
					continue;
				}

				// Handle both single array and numeric repeater list
				$items = ( isset( $b_list[0] ) && is_array( $b_list[0] ) ) ? $b_list : array( $b_list );

				foreach ( $items as $b_data ) {
					if ( ! is_array( $b_data ) ) {
						continue;
					}
					if ( ! empty( $b_data['image'] ) || ! empty( $b_data['code'] ) ) {
						$b_id = 'b_' . time() . '_' . rand( 100, 999 );
						$ad_slots[ $s_key ]['banners'][ $b_id ] = array(
							'id'          => $b_id,
							'title'       => ! empty( $b_data['title'] ) ? sanitize_text_field( $b_data['title'] ) : 'বিজ্ঞাপন ব্যানার',
							'image'       => sanitize_text_field( $b_data['image'] ),
							'link'        => sanitize_text_field( $b_data['link'] ),
							'code'        => isset( $b_data['code'] ) ? ( current_user_can( 'unfiltered_html' ) ? trim( $b_data['code'] ) : wp_kses_post( $b_data['code'] ) ) : '',
							'impressions' => 0,
							'clicks'      => 0,
						);
					}
				}
			}
		}

		update_option( 'bdk_theme_ad_slots_data', $ad_slots );
		echo '<div class="notice notice-success is-dismissible"><p>বিজ্ঞাপন স্লটের সেটিংস ও ব্যানার সফলভাবে আপলোড/সংরক্ষণ করা হয়েছে!</p></div>';
	}

	// Handle Delete Banner Item
	if ( isset( $_GET['action'] ) && 'delete_banner' === $_GET['action'] && isset( $_GET['slot'] ) && isset( $_GET['banner_id'] ) && check_admin_referer( 'bdk_delete_banner_nonce' ) ) {
		$slot_id   = sanitize_text_field( $_GET['slot'] );
		$banner_id = sanitize_text_field( $_GET['banner_id'] );
		$ad_slots  = bdk_get_theme_ad_slots();

		if ( isset( $ad_slots[ $slot_id ]['banners'][ $banner_id ] ) ) {
			unset( $ad_slots[ $slot_id ]['banners'][ $banner_id ] );
			update_option( 'bdk_theme_ad_slots_data', $ad_slots );
			echo '<div class="notice notice-success is-dismissible"><p>বিজ্ঞাপন ব্যানারটি মুছে ফেলা হয়েছে।</p></div>';
		}
	}

	// Handle Reset Analytics Report
	if ( isset( $_GET['action'] ) && 'reset_ad_stats' === $_GET['action'] && check_admin_referer( 'bdk_reset_stats_nonce' ) ) {
		$ad_slots = bdk_get_theme_ad_slots();
		foreach ( $ad_slots as $s_key => &$s_data ) {
			if ( ! empty( $s_data['banners'] ) && is_array( $s_data['banners'] ) ) {
				foreach ( $s_data['banners'] as &$b ) {
					$b['impressions'] = 0;
					$b['clicks']      = 0;
				}
			}
		}
		update_option( 'bdk_theme_ad_slots_data', $ad_slots );
		echo '<div class="notice notice-success is-dismissible"><p>সকল বিজ্ঞাপনের ইম্প্রেশন ও ক্লিক রিপোর্ট রিসেট করা হয়েছে।</p></div>';
	}

	// Handle Save Booking Packages
	if ( isset( $_POST['action'] ) && 'save_ad_packages' === $_POST['action'] && check_admin_referer( 'bdk_save_packages_nonce' ) ) {
		$packages = bdk_get_ad_packages();
		if ( isset( $_POST['packages'] ) && is_array( $_POST['packages'] ) ) {
			foreach ( $_POST['packages'] as $pkg_id => $p_data ) {
				if ( isset( $packages[ $pkg_id ] ) ) {
					$packages[ $pkg_id ]['title']      = sanitize_text_field( $p_data['title'] );
					$packages[ $pkg_id ]['size']       = sanitize_text_field( $p_data['size'] );
					$packages[ $pkg_id ]['location']   = sanitize_text_field( $p_data['location'] );
					$packages[ $pkg_id ]['badge']      = sanitize_text_field( $p_data['badge'] );
					$packages[ $pkg_id ]['rates_text'] = sanitize_text_field( $p_data['rates_text'] );
					$packages[ $pkg_id ]['desc']       = sanitize_textarea_field( $p_data['desc'] );
					$packages[ $pkg_id ]['active']     = isset( $p_data['active'] ) ? true : false;
				}
			}
			update_option( 'bdk_ad_packages_data', $packages );
			echo '<div class="notice notice-success is-dismissible"><p>বিজ্ঞাপন প্যাকেজের তথ্য সফলভাবে সংরক্ষণ করা হয়েছে!</p></div>';
		}
	}

	$bookings = get_option( 'bdk_ad_bookings_list', array() );
	$packages = bdk_get_ad_packages();
	$ad_slots = bdk_get_theme_ad_slots();

	// Calculate Total Analytics Stats
	$total_impressions = 0;
	$total_clicks      = 0;
	foreach ( $ad_slots as $s ) {
		if ( ! empty( $s['banners'] ) ) {
			foreach ( $s['banners'] as $b ) {
				$total_impressions += isset( $b['impressions'] ) ? $b['impressions'] : 0;
				$total_clicks      += isset( $b['clicks'] ) ? $b['clicks'] : 0;
			}
		}
	}
	$overall_ctr = $total_impressions > 0 ? number_format( ( $total_clicks / $total_impressions ) * 100, 2 ) : 0;
	?>
	<div class="wrap" style="max-width: 100%; margin-top: 15px; margin-right: 20px; font-family: 'Hind Siliguri', -apple-system, BlinkMacSystemFont, sans-serif;">
		
		<!-- Ultra-Modern Header Card with Emerald Gradient & Glassmorphism -->
		<div style="background: linear-gradient(135deg, #047857 0%, #065f46 50%, #064e3b 100%); border-radius: 16px; padding: 24px 30px; box-shadow: 0 10px 25px -5px rgba(4, 120, 87, 0.25); margin-bottom: 24px; color: #ffffff; position: relative; overflow: hidden;">
			<!-- Decorative Background Glow -->
			<div style="position: absolute; top: -40px; right: -40px; width: 180px; height: 180px; background: rgba(255, 255, 255, 0.08); border-radius: 50%; pointer-events: none;"></div>

			<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; position: relative; z-index: 1;">
				<div style="display: flex; align-items: center; gap: 16px;">
					<div style="background: rgba(255, 255, 255, 0.18); backdrop-filter: blur(8px); width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; border: 1px solid rgba(255, 255, 255, 0.25); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
						📢
					</div>
					<div>
						<h1 style="margin: 0; font-size: 22px; color: #ffffff; font-weight: 800; letter-spacing: -0.3px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
							<span>বিজ্ঞাপন ও পারফরম্যান্স ম্যানেজার</span>
							<span style="font-size: 12px; font-weight: 700; background: rgba(255, 255, 255, 0.2); padding: 3px 12px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.3);">Ad & Analytics Pro</span>
						</h1>
						<p style="margin: 5px 0 0; color: rgba(255, 255, 255, 0.88); font-size: 13px;">মাল্টি-অ্যাড রোটেশন, ইম্প্রেশন ও ক্লিক এনালিটিক্স এবং অনলাইন বিজ্ঞাপনের আবেদনের সকল রিপোর্ট কাস্টমাইজ করুন।</p>
					</div>
				</div>
				<a href="<?php echo esc_url( home_url( '/advertising' ) ); ?>" target="_blank" style="background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35); border-radius: 10px; padding: 10px 18px; font-weight: 700; text-decoration: none; font-size: 13px; backdrop-filter: blur(6px); display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;">
					🔗 ফ্রন্টএন্ড বিজ্ঞাপন পেজ দেখুন ↗
				</a>
			</div>

			<!-- Sleek Pill Tab Bar -->
			<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 22px; padding-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.18); position: relative; z-index: 1;">
				<a href="?page=bdk-ad-manager&tab=bookings" style="<?php echo 'bookings' === $active_tab ? 'background: #ffffff; color: #047857; box-shadow: 0 4px 14px rgba(0,0,0,0.15); font-weight: 800;' : 'background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 600;'; ?> padding: 9px 18px; border-radius: 10px; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;">
					📩 প্রাপ্ত বুকিং আবেদন
					<span style="<?php echo 'bookings' === $active_tab ? 'background: #dcfce7; color: #15803d;' : 'background: rgba(255,255,255,0.22); color: #ffffff;'; ?> padding: 1px 8px; border-radius: 12px; font-size: 11px; font-weight: 800;">
						<?php echo esc_html( count( $bookings ) ); ?>
					</span>
				</a>
				
				<a href="?page=bdk-ad-manager&tab=slots" style="<?php echo 'slots' === $active_tab ? 'background: #ffffff; color: #047857; box-shadow: 0 4px 14px rgba(0,0,0,0.15); font-weight: 800;' : 'background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 600;'; ?> padding: 9px 18px; border-radius: 10px; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;">
					🖼️ থিম বিজ্ঞাপন স্লট ও মাল্টি-অ্যাড সেটিং
				</a>

				<a href="?page=bdk-ad-manager&tab=analytics" style="<?php echo 'analytics' === $active_tab ? 'background: #ffffff; color: #047857; box-shadow: 0 4px 14px rgba(0,0,0,0.15); font-weight: 800;' : 'background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 600;'; ?> padding: 9px 18px; border-radius: 10px; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;">
					📊 বিজ্ঞাপন রিপোর্ট ও এনালিটিক্স
					<span style="<?php echo 'analytics' === $active_tab ? 'background: #dbeafe; color: #1e40af;' : 'background: rgba(255,255,255,0.22); color: #ffffff;'; ?> padding: 1px 8px; border-radius: 12px; font-size: 11px; font-weight: 800;">
						<?php echo esc_html( $total_clicks ); ?> Clicks
					</span>
				</a>

				<a href="?page=bdk-ad-manager&tab=packages" style="<?php echo 'packages' === $active_tab ? 'background: #ffffff; color: #047857; box-shadow: 0 4px 14px rgba(0,0,0,0.15); font-weight: 800;' : 'background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); font-weight: 600;'; ?> padding: 9px 18px; border-radius: 10px; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease;">
					⚙️ বুকিং প্যাকেজ রেট
				</a>
			</div>
		</div>

		<?php if ( 'bookings' === $active_tab ) : ?>
			<!-- TAB 1: BOOKING APPLICATIONS TABLE -->
			<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
					<h3 style="margin: 0; color: #0f172a; font-size: 17px; font-weight: 700;">📋 জমাকৃত বিজ্ঞাপন বুকিং আবেদনের তালিকা:</h3>
					<span style="font-size: 13px; color: #64748b; background: #f1f5f9; padding: 4px 12px; border-radius: 20px; border: 1px solid #cbd5e1; font-weight: 600;">
						মোট আবেদন: <strong style="color: #047857;"><?php echo esc_html( count( $bookings ) ); ?></strong> টি
					</span>
				</div>
				
				<?php if ( empty( $bookings ) ) : ?>
					<div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 45px; text-align: center; color: #64748b;">
						<p style="margin: 0; font-size: 15px; font-weight: 600;">এখনও কোনো নতুন বিজ্ঞাপনের আবেদন জমা পড়েনি।</p>
					</div>
				<?php else : ?>
					<div style="overflow-x: auto;">
						<table class="wp-list-table widefat fixed striped table-view-list" style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
							<thead>
								<tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
									<th style="width: 120px; font-weight: 700; color: #334155; padding: 12px 15px;">তারিখ ও সময়</th>
									<th style="width: 190px; font-weight: 700; color: #334155; padding: 12px 15px;">আবেদনকারী ও প্রতিষ্ঠান</th>
									<th style="width: 180px; font-weight: 700; color: #334155; padding: 12px 15px;">যোগাযোগ মাধ্যম</th>
									<th style="font-weight: 700; color: #334155; padding: 12px 15px;">বিজ্ঞাপন প্যাকেজ</th>
									<th style="width: 100px; font-weight: 700; color: #334155; padding: 12px 15px;">সময়কাল</th>
									<th style="width: 150px; font-weight: 700; color: #334155; padding: 12px 15px;">স্ট্যাটাস</th>
									<th style="width: 120px; text-align: right; font-weight: 700; color: #334155; padding: 12px 15px;">অ্যাকশন</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sorted_bookings = array_reverse( $bookings, true );
								foreach ( $sorted_bookings as $b_id => $b ) :
									$status = isset( $b['status'] ) ? $b['status'] : 'pending';
									$status_bg = '#fef3c7';
									$status_color = '#92400e';
									$status_text = 'পেন্ডিং';

									if ( 'contacted' === $status ) {
										$status_bg = '#e0f2fe';
										$status_color = '#0369a1';
										$status_text = 'যোগাযোগ করা হয়েছে';
									} elseif ( 'approved' === $status ) {
										$status_bg = '#dcfce7';
										$status_color = '#15803d';
										$status_text = 'অনুমোদিত / কনফার্ম';
									} elseif ( 'rejected' === $status ) {
										$status_bg = '#fee2e2';
										$status_color = '#b91c1c';
										$status_text = 'বাতিল';
									}

									$msg_clean = ! empty( $b['message'] ) ? $b['message'] : 'কোনো বিশেষ বার্তা নেই।';
								?>
									<tr style="vertical-align: middle;">
										<td style="padding: 12px 15px;">
											<strong style="color: #047857; font-size: 13px;"><?php echo esc_html( date( 'd/m/Y', strtotime( $b['date'] ) ) ); ?></strong><br>
											<span style="font-size: 11px; color: #64748b; font-weight: 600;"><?php echo esc_html( date( 'h:i A', strtotime( $b['date'] ) ) ); ?></span>
										</td>
										<td style="padding: 12px 15px;">
											<strong style="font-size: 14px; color: #0f172a;"><?php echo esc_html( $b['name'] ); ?></strong><br>
											<span style="font-size: 12px; color: #64748b; font-weight: 600;">🏢 <?php echo esc_html( $b['company'] ); ?></span>
										</td>
										<td style="padding: 12px 15px;">
											📞 <a href="tel:<?php echo esc_attr( $b['phone'] ); ?>" style="font-weight: 700; text-decoration: none; color: #047857; font-size: 12px;"><?php echo esc_html( $b['phone'] ); ?></a><br>
											✉️ <a href="mailto:<?php echo esc_attr( $b['email'] ); ?>" style="font-size: 11px; color: #2563eb; text-decoration: none;"><?php echo esc_html( $b['email'] ); ?></a>
										</td>
										<td style="padding: 12px 15px;">
											<span style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-block; color: #0f766e; border: 1px solid #cbd5e1;"><?php echo esc_html( $b['package_name'] ); ?></span>
										</td>
										<td style="padding: 12px 15px;">
											<span style="font-size: 12px; font-weight: 700; color: #334155;">⏱️ <?php echo esc_html( $b['duration'] ); ?></span>
										</td>
										<td style="padding: 12px 15px;">
											<form method="post" style="margin: 0;">
												<?php wp_nonce_field( 'bdk_update_status_nonce' ); ?>
												<input type="hidden" name="action" value="update_booking_status">
												<input type="hidden" name="booking_id" value="<?php echo esc_attr( $b_id ); ?>">
												<select name="status" onchange="this.form.submit()" style="font-size: 11px; padding: 4px 8px; border-radius: 8px; background: <?php echo esc_attr( $status_bg ); ?>; color: <?php echo esc_attr( $status_color ); ?>; font-weight: 700; border: 1px solid <?php echo esc_attr( $status_color ); ?>; cursor: pointer;">
													<option value="pending" <?php selected( $status, 'pending' ); ?>>⏳ পেন্ডিং</option>
													<option value="contacted" <?php selected( $status, 'contacted' ); ?>>📞 যোগাযোগ করা হয়েছে</option>
													<option value="approved" <?php selected( $status, 'approved' ); ?>>✅ অনুমোদিত</option>
													<option value="rejected" <?php selected( $status, 'rejected' ); ?>>❌ বাতিল</option>
												</select>
											</form>
										</td>
										<td style="text-align: right; padding: 12px 15px;">
											<div style="display: flex; gap: 6px; justify-content: flex-end; align-items: center;">
												<button type="button" class="button button-small button-secondary" onclick="openAdminBookingModal(this)"
													data-id="<?php echo esc_attr( $b_id ); ?>"
													data-name="<?php echo esc_attr( $b['name'] ); ?>"
													data-company="<?php echo esc_attr( $b['company'] ); ?>"
													data-phone="<?php echo esc_attr( $b['phone'] ); ?>"
													data-email="<?php echo esc_attr( $b['email'] ); ?>"
													data-package="<?php echo esc_attr( $b['package_name'] ); ?>"
													data-duration="<?php echo esc_attr( $b['duration'] ); ?>"
													data-date="<?php echo esc_attr( date( 'd/m/Y h:i A', strtotime( $b['date'] ) ) ); ?>"
													data-status="<?php echo esc_attr( $status ); ?>"
													data-statustext="<?php echo esc_attr( $status_text ); ?>"
													data-statusbg="<?php echo esc_attr( $status_bg ); ?>"
													data-statuscolor="<?php echo esc_attr( $status_color ); ?>"
													data-message="<?php echo esc_attr( $msg_clean ); ?>"
													style="font-weight: 700; color: #047857; border-color: #047857; border-radius: 6px;">
													👁️ দেখুন
												</button>
												
												<a href="<?php echo esc_url( wp_nonce_url( '?page=bdk-ad-manager&tab=bookings&action=delete_booking&id=' . $b_id, 'bdk_delete_booking_nonce' ) ); ?>" onclick="return confirm('আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?');" class="button button-small" style="color: #dc2626; border-color: #fca5a5; background: #fff5f5; border-radius: 6px;">🗑️</a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>

		<?php elseif ( 'slots' === $active_tab ) : ?>
			<!-- TAB 2: THEME AD SLOTS & MULTI-BANNER ROTATION SETUP -->
			<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
				<form method="post">
					<?php wp_nonce_field( 'bdk_save_ad_slots_nonce' ); ?>
					<input type="hidden" name="action" value="save_theme_ad_slots">

					<div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 22px;">
						<div>
							<h3 style="margin: 0; color: #0f172a; font-size: 18px; font-weight: 800;">🖼️ থিমের সকল বিজ্ঞাপন স্লট ও মাল্টি-অ্যাড রোটেশন সেটিংস</h3>
							<p style="margin: 5px 0 0; color: #64748b; font-size: 13px;">নিচের প্রতিটি স্লট বাটনে ক্লিক করে সেই বিষয়ের বিজ্ঞাপন ব্যানার ও রোটেশন টাইম সেটআপ করুন।</p>
						</div>
						<button type="submit" class="button button-primary button-hero" style="background: #047857; border-color: #065f46; font-size: 14px; height: 42px; border-radius: 10px; font-weight: 700; box-shadow: 0 4px 12px rgba(4, 120, 87, 0.2);">
							💾 সকল স্লট সেটিং সেভ করুন
						</button>
					</div>

					<!-- Sub-Tabs Navigation for Ad Slots -->
					<div class="bdk-slot-subtabs" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; border-bottom: 2px solid #f1f5f9; padding-bottom: 14px;">
						<?php 
						$subtab_i = 0;
						foreach ( $ad_slots as $s_key => $s ) : 
							$subtab_i++;
							$active_style = ( 1 === $subtab_i ) ? 'background: #047857; color: #ffffff; border-color: #047857; box-shadow: 0 4px 12px rgba(4, 120, 87, 0.25);' : 'background: #f8fafc; color: #334155; border-color: #cbd5e1;';
							$banner_count = count( $s['banners'] );
						?>
							<button type="button" class="bdk-slot-tab-btn button" data-slot-target="slot_panel_<?php echo esc_attr( $s_key ); ?>" style="font-weight: 700; font-size: 12px; padding: 8px 16px; border-radius: 10px; transition: all 0.2s ease; cursor: pointer; <?php echo esc_attr( $active_style ); ?>">
								<?php echo esc_html( $s['title'] ); ?>
								<span style="background: rgba(0,0,0,0.12); padding: 2px 7px; border-radius: 10px; font-size: 11px; margin-left: 6px;">
									<?php echo esc_html( $banner_count ); ?>
								</span>
							</button>
						<?php endforeach; ?>
					</div>

					<!-- Slots Panels -->
					<div class="bdk-slots-panels">
						<?php 
						$panel_i = 0;
						foreach ( $ad_slots as $s_key => $s ) : 
							$panel_i++;
							$panel_display = ( 1 === $panel_i ) ? 'display: block;' : 'display: none;';
						?>
							<div id="slot_panel_<?php echo esc_attr( $s_key ); ?>" class="bdk-slot-panel" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 14px; padding: 22px; <?php echo esc_attr( $panel_display ); ?>">
								
								<!-- Slot Header -->
								<div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #cbd5e1; padding-bottom: 14px; margin-bottom: 18px;">
									<h4 style="margin: 0; font-size: 18px; color: #047857; font-weight: 800;">📌 <?php echo esc_html( $s['title'] ); ?></h4>
									<label style="font-weight: 700; color: #15803d; font-size: 13px; display: flex; align-items: center; gap: 6px; background: #dcfce7; padding: 5px 12px; border-radius: 8px; border: 1px solid #86efac;">
										<input type="checkbox" name="slots[<?php echo esc_attr( $s_key ); ?>][enable]" value="1" <?php checked( ! empty( $s['enable'] ) ); ?>> স্লটটি সচল রাখুন
									</label>
								</div>

								<!-- Rotation Control Bar -->
								<div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
									<div style="display: flex; align-items: center; gap: 10px;">
										<label style="font-weight: 700; font-size: 13px; color: #334155;">🔄 রোটেশন মোড (Ads Rotation):</label>
										<select name="slots[<?php echo esc_attr( $s_key ); ?>][rotation_mode]" style="font-weight: 700; font-size: 12px; border-radius: 8px; padding: 5px 10px; border: 1px solid #94a3b8;">
											<option value="reload" <?php selected( $s['rotation_mode'], 'reload' ); ?>>🔄 পেজ রিলোড দিলে স্বয়ংক্রিয়ভাবে চেঞ্জ হবে (Page Reload)</option>
											<option value="timer" <?php selected( $s['rotation_mode'], 'timer' ); ?>>⏱️ অটো-রোটেশন টাইমার (Auto-Rotate Every X Seconds)</option>
											<option value="fixed" <?php selected( $s['rotation_mode'], 'fixed' ); ?>>📌 ফিক্সড সিঙ্গেল (১ম ব্যানারটি স্থির থাকবে)</option>
										</select>
									</div>

									<div style="display: flex; align-items: center; gap: 8px;">
										<label style="font-weight: 700; font-size: 13px; color: #334155;">⏱️ টাইমার সেকেন্ড (Interval):</label>
										<input type="number" name="slots[<?php echo esc_attr( $s_key ); ?>][rotate_seconds]" value="<?php echo esc_attr( isset( $s['rotate_seconds'] ) ? $s['rotate_seconds'] : 5 ); ?>" min="2" max="300" style="width: 75px; font-weight: 700; text-align: center; border-radius: 8px; border: 1px solid #94a3b8; padding: 4px;">
										<span style="font-size: 12px; color: #64748b; font-weight: 600;">সেকেন্ড</span>
									</div>
								</div>

								<!-- Banners List Table for this slot -->
								<div style="margin-bottom: 22px;">
									<h5 style="margin: 0 0 12px; font-size: 14px; color: #1e293b; font-weight: 800;">প্রদর্শিত ব্যানারসমূহের তালিকা (<?php echo esc_html( count( $s['banners'] ) ); ?> টি সক্রিয় ব্যানার):</h5>
									
									<?php if ( empty( $s['banners'] ) ) : ?>
										<div style="background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 10px; padding: 22px; text-align: center; color: #64748b; font-size: 13px;">
											বর্তমানে এই স্লটে কোনো ব্যানার যুক্ত করা হয়নি। নিচে বাটনে ক্লিক করে ব্যানার যুক্ত করুন।
										</div>
									<?php else : ?>
										<table class="widefat fixed striped" style="border-radius: 10px; overflow: hidden; font-size: 12px; border: 1px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
											<thead>
												<tr style="background: #e2e8f0;">
													<th style="width: 80px;">প্রিভিউ</th>
													<th>ব্যানারের নাম & লিংক</th>
													<th style="width: 120px; text-align: center;">ভিউ (Impressions)</th>
													<th style="width: 100px; text-align: center;">মোট ক্লিক</th>
													<th style="width: 90px; text-align: right;">অ্যাকশন</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ( $s['banners'] as $b_id => $b ) : ?>
													<tr>
														<td>
															<?php if ( ! empty( $b['image'] ) ) : ?>
																<img src="<?php echo esc_url( $b['image'] ); ?>" style="width: 65px; height: 38px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
															<?php else : ?>
																<span style="background: #e2e8f0; padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700;">HTML Code</span>
															<?php endif; ?>
														</td>
														<td>
															<strong style="color: #0f172a; font-size: 13px;"><?php echo esc_html( $b['title'] ); ?></strong><br>
															<a href="<?php echo esc_url( ! empty( $b['link'] ) ? $b['link'] : '#' ); ?>" target="_blank" style="font-size: 11px; color: #2563eb; text-decoration: none; font-weight: 600;"><?php echo esc_html( ! empty( $b['link'] ) ? $b['link'] : 'কোনো লিংক নেই' ); ?></a>
														</td>
														<td style="text-align: center; font-weight: 800; color: #047857; font-size: 13px;">
															👁️ <?php echo esc_html( number_format( isset( $b['impressions'] ) ? $b['impressions'] : 0 ) ); ?>
														</td>
														<td style="text-align: center; font-weight: 800; color: #2563eb; font-size: 13px;">
															🖱️ <?php echo esc_html( number_format( isset( $b['clicks'] ) ? $b['clicks'] : 0 ) ); ?>
														</td>
														<td style="text-align: right;">
															<a href="<?php echo esc_url( wp_nonce_url( '?page=bdk-ad-manager&tab=slots&action=delete_banner&slot=' . $s_key . '&banner_id=' . $b_id, 'bdk_delete_banner_nonce' ) ); ?>" onclick="return confirm('আপনি কি নিশ্চিত যে এই ব্যানারটি মুছে ফেলতে চান?');" style="color: #dc2626; font-weight: 700; text-decoration: none; background: #fee2e2; padding: 4px 10px; border-radius: 6px; font-size: 11px;">🗑️ মুছে ফেলুন</a>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									<?php endif; ?>
								</div>

								<!-- Add New Banners Repeater Container -->
								<div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 12px; padding: 18px; margin-top: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
									<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
										<h5 style="margin: 0; font-size: 15px; color: #047857; font-weight: 800;">➕ এই স্লটে নতুন এড ব্যানার যুক্ত করুন:</h5>
										<button type="button" class="button button-secondary bdk-add-banner-box-btn" data-slot="<?php echo esc_attr( $s_key ); ?>" style="font-weight: 700; color: #047857; border-color: #047857; border-radius: 8px;">
											➕ আরও একটি ব্যানার বক্স যোগ করুন
										</button>
									</div>

									<div id="bdk_banner_repeater_<?php echo esc_attr( $s_key ); ?>" class="bdk-banner-repeater-container" style="display: flex; flex-direction: column; gap: 14px;">
										<!-- Default 1st Banner Card -->
										<div class="bdk-banner-input-card" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; position: relative; border-left: 4px solid #047857;">
											<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
												<div>
													<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">ব্যানারের শিরোনাম / প্রতিষ্ঠানের নাম:</label>
													<input type="text" name="new_banners[<?php echo esc_attr( $s_key ); ?>][0][title]" placeholder="যেমন: স্কয়ার ইলেকট্রনিক্স বা AdSense Slot 1" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
												</div>
												<div>
													<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">টার্গেট ইউআরএল / ওয়েব লিংক (ইমেজ ব্যানারের জন্য):</label>
													<input type="url" name="new_banners[<?php echo esc_attr( $s_key ); ?>][0][link]" placeholder="https://example.com" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
												</div>
											</div>
											<div style="margin-bottom: 12px;">
												<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">ব্যানার ছবি (Image Banner):</label>
												<div style="display: flex; gap: 10px; align-items: center;">
													<input type="text" id="img_url_<?php echo esc_attr( $s_key ); ?>_0" name="new_banners[<?php echo esc_attr( $s_key ); ?>][0][image]" placeholder="ইমেজ লিংক সিলেক্ট করুন" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
													<button type="button" class="button bdk-upload-media-btn" data-target="img_url_<?php echo esc_attr( $s_key ); ?>_0" style="font-weight: 700; white-space: nowrap; border-radius: 6px;">🖼️ ছবি বাছুন</button>
												</div>
											</div>
											<div style="background: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px;">
												<label style="font-size: 11px; font-weight: 700; color: #1e40af; display: block; margin-bottom: 4px;">
													অথবা কাস্টম HTML / Google AdSense Script Code (Optional):
												</label>
												<textarea name="new_banners[<?php echo esc_attr( $s_key ); ?>][0][code]" rows="3" placeholder="Google AdSense বা অন্য কোনো অ্যাড নেটওয়ার্কের <script> / HTML কোড পেস্ট করুন..." class="widefat" style="font-size: 12px; font-family: monospace; border-radius: 6px; padding: 6px 10px;"></textarea>
												<span style="font-size: 11px; color: #64748b; font-weight: 600; display: block; margin-top: 4px;">💡 বি:দ্র: ব্যানার ছবি আপলোড না থাকলে এই HTML/AdSense কোডটি বিজ্ঞাপনের জায়গায় শো করবে।</span>
											</div>
										</div>
									</div>

									<div style="margin-top: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
										<button type="button" class="button button-secondary bdk-add-banner-box-btn" data-slot="<?php echo esc_attr( $s_key ); ?>" style="font-weight: 700; color: #047857; border-color: #047857; border-radius: 8px;">
											➕ আরও একটি ব্যানার বক্স যোগ করুন
										</button>

										<button type="submit" class="button button-primary button-hero" style="background: #047857; border-color: #065f46; font-size: 14px; height: 40px; border-radius: 10px; font-weight: 700;">
											💾 নতুন ব্যানার ও সেটিং সেভ করুন
										</button>
									</div>
								</div>

							</div>
						<?php endforeach; ?>
					</div>

					<div style="margin-top: 22px;">
						<button type="submit" class="button button-primary button-hero" style="background: #047857; border-color: #065f46; font-size: 15px; border-radius: 10px; font-weight: 700; padding: 8px 24px;">
							💾 সকল বিজ্ঞাপন সেটিং সেভ করুন
						</button>
					</div>
				</form>
			</div>

		<?php elseif ( 'analytics' === $active_tab ) : ?>
			<!-- TAB 3: AD ANALYTICS & IMPRESSIONS / CLICKS REPORT -->
			<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
				
				<!-- Analytics Summary Modern Stat Cards -->
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 28px;">
					<!-- Card 1: Impressions -->
					<div style="background: linear-gradient(180deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; border-top: 5px solid #10b981; border-radius: 14px; padding: 22px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);">
						<div style="display: flex; align-items: center; justify-content: space-between;">
							<span style="font-size: 13px; color: #166534; font-weight: 800;">👁️ মোট ইম্প্রেশন (Ad Views)</span>
							<span style="background: #ffffff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #059669; border: 1px solid #a7f3d0;">Live Impressions</span>
						</div>
						<strong style="font-size: 32px; color: #047857; font-weight: 900; display: block; margin-top: 10px; letter-spacing: -0.5px;"><?php echo esc_html( number_format( $total_impressions ) ); ?></strong>
					</div>

					<!-- Card 2: Clicks -->
					<div style="background: linear-gradient(180deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #bfdbfe; border-top: 5px solid #3b82f6; border-radius: 14px; padding: 22px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);">
						<div style="display: flex; align-items: center; justify-content: space-between;">
							<span style="font-size: 13px; color: #1e40af; font-weight: 800;">🖱️ মোট প্রাপ্ত ক্লিক (Clicks)</span>
							<span style="background: #ffffff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #2563eb; border: 1px solid #93c5fd;">User Clicks</span>
						</div>
						<strong style="font-size: 32px; color: #1d4ed8; font-weight: 900; display: block; margin-top: 10px; letter-spacing: -0.5px;"><?php echo esc_html( number_format( $total_clicks ) ); ?></strong>
					</div>

					<!-- Card 3: Overall CTR -->
					<div style="background: linear-gradient(180deg, #fff7ed 0%, #ffedd5 100%); border: 1px solid #fed7aa; border-top: 5px solid #f97316; border-radius: 14px; padding: 22px; box-shadow: 0 4px 15px rgba(249, 115, 22, 0.08);">
						<div style="display: flex; align-items: center; justify-content: space-between;">
							<span style="font-size: 13px; color: #9a3412; font-weight: 800;">📈 এভারেজ সি-টি-আর (Overall CTR)</span>
							<span style="background: #ffffff; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; color: #ea580c; border: 1px solid #fdba74;">Conversion Rate</span>
						</div>
						<strong style="font-size: 32px; color: #c2410c; font-weight: 900; display: block; margin-top: 10px; letter-spacing: -0.5px;"><?php echo esc_html( $overall_ctr ); ?>%</strong>
					</div>
				</div>

				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;">
					<h3 style="margin: 0; color: #0f172a; font-size: 17px; font-weight: 800;">📊 সকল বিজ্ঞাপন স্লট ও ব্যানারের পারফরম্যান্স রিপোর্ট:</h3>
					<a href="<?php echo esc_url( wp_nonce_url( '?page=bdk-ad-manager&tab=analytics&action=reset_ad_stats', 'bdk_reset_stats_nonce' ) ); ?>" onclick="return confirm('আপনি কি নিশ্চিত যে সকল ইম্প্রেশন ও ক্লিক রিপোর্ট রিসেট করতে চান?');" class="button button-secondary" style="color: #dc2626; border-color: #fca5a5; font-weight: 700; border-radius: 8px; background: #fff5f5;">
						🔄 কাউন্ট রিসেট করুন
					</a>
				</div>

				<table class="wp-list-table widefat fixed striped table-view-list" style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
					<thead>
						<tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
							<th style="width: 220px; font-weight: 700; color: #334155; padding: 12px 15px;">বিজ্ঞাপনের স্লট</th>
							<th style="font-weight: 700; color: #334155; padding: 12px 15px;">ব্যানার টাইটেল & লিংক</th>
							<th style="width: 140px; text-align: center; font-weight: 700; color: #334155; padding: 12px 15px;">👁️ ভিউ (Impressions)</th>
							<th style="width: 130px; text-align: center; font-weight: 700; color: #334155; padding: 12px 15px;">🖱️ ক্লিক (Clicks)</th>
							<th style="width: 130px; text-align: center; font-weight: 700; color: #334155; padding: 12px 15px;">📈 CTR %</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$has_data = false;
						foreach ( $ad_slots as $s_key => $s ) :
							if ( ! empty( $s['banners'] ) ) :
								$has_data = true;
								foreach ( $s['banners'] as $b_id => $b ) :
									$imp = isset( $b['impressions'] ) ? $b['impressions'] : 0;
									$clk = isset( $b['clicks'] ) ? $b['clicks'] : 0;
									$ctr = $imp > 0 ? number_format( ( $clk / $imp ) * 100, 2 ) : '0.00';
						?>
									<tr style="vertical-align: middle;">
										<td style="padding: 12px 15px;">
											<strong style="color: #047857; font-size: 13px;"><?php echo esc_html( $s['title'] ); ?></strong>
										</td>
										<td style="padding: 12px 15px;">
											<div style="display: flex; align-items: center; gap: 12px;">
												<?php if ( ! empty( $b['image'] ) ) : ?>
													<img src="<?php echo esc_url( $b['image'] ); ?>" style="width: 60px; height: 35px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
												<?php endif; ?>
												<div>
													<strong style="font-size: 13px; color: #0f172a;"><?php echo esc_html( $b['title'] ); ?></strong><br>
													<a href="<?php echo esc_url( ! empty( $b['link'] ) ? $b['link'] : '#' ); ?>" target="_blank" style="font-size: 11px; color: #2563eb; text-decoration: none; font-weight: 600;"><?php echo esc_html( ! empty( $b['link'] ) ? $b['link'] : 'কোনো লিংক নেই' ); ?></a>
												</div>
											</div>
										</td>
										<td style="text-align: center; font-weight: 800; color: #047857; font-size: 15px; padding: 12px 15px;">
											<?php echo esc_html( number_format( $imp ) ); ?>
										</td>
										<td style="text-align: center; font-weight: 800; color: #1d4ed8; font-size: 15px; padding: 12px 15px;">
											<?php echo esc_html( number_format( $clk ) ); ?>
										</td>
										<td style="text-align: center; font-weight: 900; color: #c2410c; font-size: 15px; padding: 12px 15px;">
											<?php echo esc_html( $ctr ); ?>%
										</td>
									</tr>
						<?php
								endforeach;
							endif;
						endforeach;

						if ( ! $has_data ) :
						?>
							<tr>
								<td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
									কোনো সক্রিয় ব্যানার পাওয়া যায়নি। 'থিম বিজ্ঞাপন স্লট' ট্যাবে গিয়ে ব্যানার যুক্ত করুন।
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

			</div>

		<?php else : ?>
			<!-- TAB 4: AD PACKAGES CONFIGURATION -->
			<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
				<form method="post">
					<?php wp_nonce_field( 'bdk_save_packages_nonce' ); ?>
					<input type="hidden" name="action" value="save_ad_packages">

					<h3 style="margin-top: 0; color: #0f172a; font-size: 18px; font-weight: 800; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
						⚙️ ফ্রন্টএন্ড প্রাইসিং পেজের জন্য স্থান ও মূল্যের রেট কাস্টমাইজ করুন:
					</h3>

					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
						<?php foreach ( $packages as $pkg_id => $pkg ) : ?>
							<div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; padding: 18px;">
								<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
									<h4 style="margin: 0; color: #006a4e; font-size: 15px; font-weight: 700;">📌 <?php echo esc_html( $pkg['title'] ); ?></h4>
									<label style="font-size: 12px; font-weight: 700; color: #15803d;">
										<input type="checkbox" name="packages[<?php echo esc_attr( $pkg_id ); ?>][active]" value="1" <?php checked( ! empty( $pkg['active'] ) ); ?>> চালু রাখুন
									</label>
								</div>

								<div style="display: flex; flex-direction: column; gap: 10px;">
									<div>
										<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">প্যাকেজের নাম/শিরোনাম:</label>
										<input type="text" name="packages[<?php echo esc_attr( $pkg_id ); ?>][title]" value="<?php echo esc_attr( $pkg['title'] ); ?>" class="widefat" style="margin-top: 3px;">
									</div>

									<div style="display: flex; gap: 10px;">
										<div style="flex: 1;">
											<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">সাইজ (Dimensions):</label>
											<input type="text" name="packages[<?php echo esc_attr( $pkg_id ); ?>][size]" value="<?php echo esc_attr( $pkg['size'] ); ?>" class="widefat" style="margin-top: 3px;">
										</div>
										<div style="flex: 1;">
											<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">ব্যাজ/ট্যাগ:</label>
											<input type="text" name="packages[<?php echo esc_attr( $pkg_id ); ?>][badge]" value="<?php echo esc_attr( $pkg['badge'] ); ?>" class="widefat" style="margin-top: 3px;">
										</div>
									</div>

									<div>
										<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">বিজ্ঞাপনের অবস্থান:</label>
										<input type="text" name="packages[<?php echo esc_attr( $pkg_id ); ?>][location]" value="<?php echo esc_attr( $pkg['location'] ); ?>" class="widefat" style="margin-top: 3px;">
									</div>

									<div>
										<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">প্রাইস রেট লিস্ট (টেক্সট):</label>
										<input type="text" name="packages[<?php echo esc_attr( $pkg_id ); ?>][rates_text]" value="<?php echo esc_attr( $pkg['rates_text'] ); ?>" class="widefat" style="margin-top: 3px;">
									</div>

									<div>
										<label style="font-size: 12px; font-weight: 600; color: #475569; display: block;">বিবরণ / সুবিধা:</label>
										<textarea name="packages[<?php echo esc_attr( $pkg_id ); ?>][desc]" rows="2" class="widefat" style="margin-top: 3px;"><?php echo esc_textarea( $pkg['desc'] ); ?></textarea>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div style="margin-top: 20px;">
						<button type="submit" class="button button-primary button-hero" style="background: #006a4e; border-color: #00442b; font-size: 15px; padding: 6px 20px;">
							💾 সকল সেটিং সংরক্ষণ করুন
						</button>
					</div>
				</form>
			</div>
		<?php endif; ?>

	<!-- WP Admin Booking Details Popup Modal -->
	<div id="adminBookingDetailsModal" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(3px); z-index: 99999; align-items: center; justify-content: center; padding: 15px;">
		<div style="background: #ffffff; border-radius: 14px; width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3); position: relative; font-family: 'Hind Siliguri', sans-serif;">
			<div style="background: #006a4e; color: #ffffff; padding: 16px 22px; border-radius: 14px 14px 0 0; display: flex; align-items: center; justify-content: space-between;">
				<h3 style="margin: 0; color: #ffffff; font-size: 17px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
					<span>📋</span> বিজ্ঞাপন বুকিং আবেদনের পূর্ণাঙ্গ বিবরণ
				</h3>
				<button type="button" onclick="closeAdminBookingModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
			</div>

			<div style="padding: 22px;">
				<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 18px;">
					<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
						<div>
							<h4 id="detailName" style="margin: 0; font-size: 18px; color: #0f172a; font-weight: 700;"></h4>
							<span id="detailCompany" style="font-size: 13px; color: #64748b; font-weight: 600;"></span>
						</div>
						<span id="detailStatusBadge" style="padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 700;"></span>
					</div>
					<div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px; border-top: 1px dashed #cbd5e1; padding-top: 12px;">
						<a id="detailCallBtn" href="#" class="button button-primary" style="background: #10b981; border-color: #059669; font-weight: 700; height: 32px; display: inline-flex; align-items: center; gap: 6px;">📞 সরাসরি কল করুন</a>
						<a id="detailMailBtn" href="#" class="button button-secondary" style="font-weight: 700; color: #2563eb; height: 32px; display: inline-flex; align-items: center; gap: 6px;">✉️ ইমেইল পাঠান</a>
					</div>
				</div>

				<table style="width: 100%; border-collapse: collapse; margin-bottom: 18px; font-size: 13px;">
					<tr style="border-bottom: 1px solid #f1f5f9;">
						<td style="padding: 8px 0; color: #64748b; font-weight: 600; width: 150px;">আবেদনের তারিখ:</td>
						<td id="detailDate" style="padding: 8px 0; color: #0f172a; font-weight: 700;"></td>
					</tr>
					<tr style="border-bottom: 1px solid #f1f5f9;">
						<td style="padding: 8px 0; color: #64748b; font-weight: 600;">বিজ্ঞাপনের স্থান/প্যাকেজ:</td>
						<td id="detailPackage" style="padding: 8px 0; color: #006a4e; font-weight: 700;"></td>
					</tr>
					<tr style="border-bottom: 1px solid #f1f5f9;">
						<td style="padding: 8px 0; color: #64748b; font-weight: 600;">পছন্দকৃত সময়কাল:</td>
						<td id="detailDuration" style="padding: 8px 0; color: #0f172a; font-weight: 700;"></td>
					</tr>
				</table>

				<div style="margin-bottom: 20px;">
					<label style="font-weight: 700; font-size: 13px; color: #334155; display: block; margin-bottom: 6px;">আবেদনকারীর বিশেষ বার্তা / বিবরণ:</label>
					<div id="detailMessage" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; font-size: 13px; color: #1e293b; white-space: pre-wrap; min-height: 60px; line-height: 1.6;"></div>
				</div>

				<div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
					<span style="font-weight: 700; font-size: 13px; color: #9a3412;">স্ট্যাটাস হালনাগাদ করুন:</span>
					<form method="post" style="margin: 0; display: flex; gap: 8px; align-items: center;">
						<?php wp_nonce_field( 'bdk_update_status_nonce' ); ?>
						<input type="hidden" name="action" value="update_booking_status">
						<input type="hidden" id="detailBookingIdInput" name="booking_id" value="">
						<select id="detailStatusSelect" name="status" style="font-size: 12px; padding: 5px 10px; font-weight: 700; border-radius: 6px; border: 1px solid #fdba74;">
							<option value="pending">⏳ পেন্ডিং</option>
							<option value="contacted">📞 যোগাযোগ করা হয়েছে</option>
							<option value="approved">✅ অনুমোদিত / কনফার্ম</option>
							<option value="rejected">❌ বাতিল</option>
						</select>
						<button type="submit" class="button button-primary" style="background: #006a4e; border-color: #00442b; font-weight: 700;">হালনাগাদ করুন</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		// Delegate Media Uploader for dynamic and static upload buttons
		$(document).on('click', '.bdk-upload-media-btn', function(e) {
			e.preventDefault();
			const targetId = $(this).attr('data-target');
			const inputField = $('#' + targetId);

			const customUploader = wp.media({
				title: 'বিজ্ঞাপন ব্যানার নির্বাচন করুন',
				button: { text: 'ব্যানার যোগ করুন' },
				multiple: false
			}).on('select', function() {
				const attachment = customUploader.state().get('selection').first().toJSON();
				inputField.val(attachment.url);
			}).open();
		});

		// Subtab Switching for Ad Slots
		$('.bdk-slot-tab-btn').on('click', function(e) {
			e.preventDefault();
			const target = $(this).attr('data-slot-target');

			$('.bdk-slot-tab-btn').css({
				'background': '#f1f5f9',
				'color': '#334155',
				'border-color': '#cbd5e1'
			});
			$(this).css({
				'background': '#006a4e',
				'color': '#fff',
				'border-color': '#006a4e'
			});

			$('.bdk-slot-panel').hide();
			$('#' + target).fadeIn(150);
		});

		// Dynamic Banner Box Repeater (Adds another banner box)
		$(document).on('click', '.bdk-add-banner-box-btn', function(e) {
			e.preventDefault();
			const slotKey = $(this).attr('data-slot');
			const container = $('#bdk_banner_repeater_' + slotKey);
			const index = container.find('.bdk-banner-input-card').length;

			const newCardHtml = `
				<div class="bdk-banner-input-card" style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; padding: 16px; margin-top: 12px; position: relative; border-left: 4px solid #047857;">
					<button type="button" class="bdk-remove-banner-card-btn" title="মুছে ফেলুন" style="position: absolute; top: 10px; right: 10px; background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; border-radius: 50%; width: 26px; height: 26px; cursor: pointer; font-weight: bold; line-height: 22px; text-align: center;">✕</button>
					<h6 style="margin: 0 0 10px; color: #047857; font-weight: 800; font-size: 13px;">➕ নতুন অতিরিক্ত ব্যানার #${index + 1}</h6>
					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
						<div>
							<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">ব্যানারের শিরোনাম / প্রতিষ্ঠানের নাম:</label>
							<input type="text" name="new_banners[${slotKey}][${index}][title]" placeholder="যেমন: ব্র্যান্ড প্রমোশন বা AdSense" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
						</div>
						<div>
							<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">টার্গেট ইউআরএল / ওয়েব লিংক (ইমেজ ব্যানারের জন্য):</label>
							<input type="url" name="new_banners[${slotKey}][${index}][link]" placeholder="https://example.com" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
						</div>
					</div>
					<div style="margin-bottom: 12px;">
						<label style="font-size: 11px; font-weight: 700; color: #475569; display: block; margin-bottom: 3px;">ব্যানার ছবি (Image Banner):</label>
						<div style="display: flex; gap: 10px; align-items: center;">
							<input type="text" id="img_url_${slotKey}_${index}" name="new_banners[${slotKey}][${index}][image]" placeholder="ইমেজ লিংক সিলেক্ট করুন" class="widefat" style="font-size: 12px; border-radius: 6px; padding: 6px 10px;">
							<button type="button" class="button bdk-upload-media-btn" data-target="img_url_${slotKey}_${index}" style="font-weight: 700; white-space: nowrap; border-radius: 6px;">🖼️ ছবি বাছুন</button>
						</div>
					</div>
					<div style="background: #f1f5f9; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px;">
						<label style="font-size: 11px; font-weight: 700; color: #1e40af; display: block; margin-bottom: 4px;">
							অথবা কাস্টম HTML / Google AdSense Script Code (Optional):
						</label>
						<textarea name="new_banners[${slotKey}][${index}][code]" rows="3" placeholder="Google AdSense বা অন্য কোনো অ্যাড নেটওয়ার্কের <script> / HTML কোড পেস্ট করুন..." class="widefat" style="font-size: 12px; font-family: monospace; border-radius: 6px; padding: 6px 10px;"></textarea>
						<span style="font-size: 11px; color: #64748b; font-weight: 600; display: block; margin-top: 4px;">💡 বি:দ্র: ব্যানার ছবি আপলোড না থাকলে এই HTML/AdSense কোডটি বিজ্ঞাপনের জায়গায় শো করবে।</span>
					</div>
				</div>
			`;

			container.append(newCardHtml);
		});

		// Remove Banner Box
		$(document).on('click', '.bdk-remove-banner-card-btn', function(e) {
			e.preventDefault();
			$(this).closest('.bdk-banner-input-card').remove();
		});
	});

	function openAdminBookingModal(btn) {
		const modal = document.getElementById('adminBookingDetailsModal');
		if (!modal) return;

		const id = btn.getAttribute('data-id');
		const name = btn.getAttribute('data-name');
		const company = btn.getAttribute('data-company');
		const phone = btn.getAttribute('data-phone');
		const email = btn.getAttribute('data-email');
		const pkg = btn.getAttribute('data-package');
		const duration = btn.getAttribute('data-duration');
		const date = btn.getAttribute('data-date');
		const status = btn.getAttribute('data-status');
		const statustext = btn.getAttribute('data-statustext');
		const statusbg = btn.getAttribute('data-statusbg');
		const statuscolor = btn.getAttribute('data-statuscolor');
		const message = btn.getAttribute('data-message');

		document.getElementById('detailName').textContent = name;
		document.getElementById('detailCompany').textContent = '🏢 ' + company;
		document.getElementById('detailDate').textContent = date;
		document.getElementById('detailPackage').textContent = pkg;
		document.getElementById('detailDuration').textContent = duration;
		document.getElementById('detailMessage').textContent = message;
		document.getElementById('detailBookingIdInput').value = id;

		document.getElementById('detailCallBtn').setAttribute('href', 'tel:' + phone);
		document.getElementById('detailMailBtn').setAttribute('href', 'mailto:' + email);

		const badge = document.getElementById('detailStatusBadge');
		badge.textContent = statustext;
		badge.style.background = statusbg;
		badge.style.color = statuscolor;
		badge.style.border = '1px solid ' + statuscolor;

		const select = document.getElementById('detailStatusSelect');
		if (select) {
			select.value = status;
		}

		modal.style.display = 'flex';
	}

	function closeAdminBookingModal() {
		const modal = document.getElementById('adminBookingDetailsModal');
		if (modal) {
			modal.style.display = 'none';
		}
	}

	document.getElementById('adminBookingDetailsModal')?.addEventListener('click', function(e) {
		if (e.target === this) {
			closeAdminBookingModal();
		}
	});
	</script>
	<?php
}

/**
 * AJAX Handler for Ad Impression Analytics Tracking
 */
function bdk_track_ad_impression_ajax() {
	$slot_id   = isset( $_POST['slot_id'] ) ? sanitize_text_field( $_POST['slot_id'] ) : '';
	$banner_id = isset( $_POST['banner_id'] ) ? sanitize_text_field( $_POST['banner_id'] ) : '';

	if ( ! empty( $slot_id ) && ! empty( $banner_id ) ) {
		$ad_slots = bdk_get_theme_ad_slots();
		if ( isset( $ad_slots[ $slot_id ]['banners'][ $banner_id ] ) ) {
			$ad_slots[ $slot_id ]['banners'][ $banner_id ]['impressions'] = ( isset( $ad_slots[ $slot_id ]['banners'][ $banner_id ]['impressions'] ) ? $ad_slots[ $slot_id ]['banners'][ $banner_id ]['impressions'] : 0 ) + 1;
			update_option( 'bdk_theme_ad_slots_data', $ad_slots );
			wp_send_json_success();
		}
	}
	wp_send_json_error();
}
add_action( 'wp_ajax_bdk_track_ad_impression', 'bdk_track_ad_impression_ajax' );
add_action( 'wp_ajax_nopriv_bdk_track_ad_impression', 'bdk_track_ad_impression_ajax' );

/**
 * AJAX Handler for Ad Click Analytics Tracking
 */
function bdk_track_ad_click_ajax() {
	$slot_id   = isset( $_POST['slot_id'] ) ? sanitize_text_field( $_POST['slot_id'] ) : '';
	$banner_id = isset( $_POST['banner_id'] ) ? sanitize_text_field( $_POST['banner_id'] ) : '';

	if ( ! empty( $slot_id ) && ! empty( $banner_id ) ) {
		$ad_slots = bdk_get_theme_ad_slots();
		if ( isset( $ad_slots[ $slot_id ]['banners'][ $banner_id ] ) ) {
			$ad_slots[ $slot_id ]['banners'][ $banner_id ]['clicks'] = ( isset( $ad_slots[ $slot_id ]['banners'][ $banner_id ]['clicks'] ) ? $ad_slots[ $slot_id ]['banners'][ $banner_id ]['clicks'] : 0 ) + 1;
			update_option( 'bdk_theme_ad_slots_data', $ad_slots );
			wp_send_json_success();
		}
	}
	wp_send_json_error();
}
add_action( 'wp_ajax_bdk_track_ad_click', 'bdk_track_ad_click_ajax' );
add_action( 'wp_ajax_nopriv_bdk_track_ad_click', 'bdk_track_ad_click_ajax' );

/**
 * AJAX Handler for Ad Booking Submission
 */
function bdk_submit_ad_booking_ajax() {
	check_ajax_referer( 'bdk_ajax_nonce', 'nonce' );

	$applicant_name = isset( $_POST['applicant_name'] ) ? sanitize_text_field( $_POST['applicant_name'] ) : '';
	$company_name   = isset( $_POST['company_name'] ) ? sanitize_text_field( $_POST['company_name'] ) : '';
	$phone          = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
	$email          = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$package_name   = isset( $_POST['package_name'] ) ? sanitize_text_field( $_POST['package_name'] ) : '';
	$duration       = isset( $_POST['duration'] ) ? sanitize_text_field( $_POST['duration'] ) : '';
	$message        = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

	if ( empty( $applicant_name ) || empty( $phone ) || empty( $email ) ) {
		wp_send_json_error( 'অনুগ্রহ করে সকল আবশ্যকীয় ঘর পূরণ করুন।' );
	}

	$booking_id = 'bk_' . time() . '_' . rand( 100, 999 );
	$bookings   = get_option( 'bdk_ad_bookings_list', array() );

	$bookings[ $booking_id ] = array(
		'id'           => $booking_id,
		'date'         => current_time( 'mysql' ),
		'name'         => $applicant_name,
		'company'      => ! empty( $company_name ) ? $company_name : 'ব্যক্তিগত',
		'phone'        => $phone,
		'email'        => $email,
		'package_name' => $package_name,
		'duration'     => $duration,
		'message'      => $message,
		'status'       => 'pending',
	);

	update_option( 'bdk_ad_bookings_list', $bookings );

	// Emails
	$admin_email   = get_option( 'admin_email' );
	$site_name     = get_bloginfo( 'name' );
	$admin_subject = '[বিজ্ঞাপন বুকিং] নতুন আবেদন: ' . $applicant_name;
	$admin_body    = "<h2>📢 নতুন বিজ্ঞাপন বুকিং আবেদন</h2><p><strong>আবেদনকারী:</strong> {$applicant_name} ({$company_name})</p><p><strong>ফোন:</strong> {$phone}</p><p><strong>প্যাকেজ:</strong> {$package_name} ({$duration})</p>";

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	wp_mail( $admin_email, $admin_subject, $admin_body, $headers );

	$user_subject = "দৈনিক বাংলাদেশের কথা - বিজ্ঞাপন বুকিং আবেদন প্রাপ্তি";
	$user_body    = "<p>সম্মানিত {$applicant_name}, আপনার বিজ্ঞাপন বুকিং আবেদনটি সফলভাবে গৃহীত হয়েছে। আমাদের এডভারটাইজিং টিম খুব শীঘ্রই আপনার সাথে যোগাযোগ করবে।</p>";
	wp_mail( $email, $user_subject, $user_body, $headers );

	wp_send_json_success( array(
		'message' => '🎉 আপনার বিজ্ঞাপনের বুকিং আবেদনটি সফলভাবে জমা হয়েছে! আমাদের এডভারটাইজিং টিম খুব শীঘ্রই আপনার সাথে যোগাযোগ করবে।',
	) );
}
add_action( 'wp_ajax_bdk_submit_ad_booking', 'bdk_submit_ad_booking_ajax' );
add_action( 'wp_ajax_nopriv_bdk_submit_ad_booking', 'bdk_submit_ad_booking_ajax' );

/**
 * Auto Setup Advertising Page on Theme Init
 */
function bdk_advertising_page_auto_setup() {
	if ( ! get_option( 'bdk_advertising_page_initialized' ) ) {
		$existing_page = get_page_by_path( 'advertising' );
		if ( ! $existing_page ) {
			$page_id = wp_insert_post( array(
				'post_title'   => 'বিজ্ঞাপন ও মূল্য তালিকা',
				'post_name'    => 'advertising',
				'post_content' => 'দৈনিক বাংলাদেশের কথা পোর্টালে বিজ্ঞাপনের স্থান, সাইজ, রেট ও অনলাইন বুকিং।',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_post_meta( $page_id, '_wp_page_template', 'page-advertising.php' );
			}
		} else {
			update_post_meta( $existing_page->ID, '_wp_page_template', 'page-advertising.php' );
		}
		update_option( 'bdk_advertising_page_initialized', 1 );
	}
}
add_action( 'init', 'bdk_advertising_page_auto_setup' );
