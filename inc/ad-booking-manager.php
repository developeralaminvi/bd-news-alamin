<?php
/**
 * Ad Manager & Booking Management Module for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Default Ad Packages List
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
 * Register Admin Menu for Ad Management
 */
function bdk_register_ad_manager_menu() {
	add_menu_page(
		'বিজ্ঞাপন বুকিং',
		'বিজ্ঞাপন বুকিং',
		'manage_options',
		'bdk-ad-manager',
		'bdk_render_ad_manager_page',
		'dashicons-megaphone',
		26
	);
}
add_action( 'admin_menu', 'bdk_register_ad_manager_menu' );

/**
 * Render Ad Manager Admin Page
 */
function bdk_render_ad_manager_page() {
	$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'bookings';

	// Handle Status Updates
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

	// Handle Save Packages
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
	?>
	<div class="wrap" style="max-width: 1100px; margin-top: 20px; font-family: 'Hind Siliguri', sans-serif;">
		
		<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px;">
			<div style="display: flex; align-items: center; justify-content: space-between; gap: 15px; border-bottom: 2px solid #006a4e; padding-bottom: 15px;">
				<div style="display: flex; align-items: center; gap: 12px;">
					<div style="background: #006a4e; color: #fff; width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
						📢
					</div>
					<div>
						<h1 style="margin: 0; font-size: 20px; color: #006a4e; font-weight: 700;">বিজ্ঞাপন ও প্যাকেজ ব্যবস্থাপনা (Ad Booking Manager)</h1>
						<p style="margin: 3px 0 0; color: #64748b; font-size: 13px;">বিজ্ঞাপনের স্থান কাস্টমাইজ করুন এবং পাঠকদের পাঠানো বুকিং আবেদনসমূহ পরিচালনা করুন।</p>
					</div>
				</div>
				<a href="<?php echo esc_url( home_url( '/advertising' ) ); ?>" target="_blank" class="button button-secondary" style="font-weight: 600;">
					🔗 ফ্রন্টএন্ড বিজ্ঞাপন পেজ দেখুন
				</a>
			</div>

			<!-- Navigation Tabs -->
			<h2 class="nav-tab-wrapper" style="margin-top: 15px; border-bottom: 1px solid #ccc;">
				<a href="?page=bdk-ad-manager&tab=bookings" class="nav-tab <?php echo 'bookings' === $active_tab ? 'nav-tab-active' : ''; ?>" style="font-weight: 700;">
					📩 প্রাপ্ত বুকিং আবেদনসমূহ (<?php echo esc_html( count( $bookings ) ); ?>)
				</a>
				<a href="?page=bdk-ad-manager&tab=packages" class="nav-tab <?php echo 'packages' === $active_tab ? 'nav-tab-active' : ''; ?>" style="font-weight: 700;">
					⚙️ বিজ্ঞাপনের স্থান ও প্যাকেজ সেটিং
				</a>
			</h2>
		</div>

		<?php if ( 'bookings' === $active_tab ) : ?>
			<!-- TAB 1: BOOKING APPLICATIONS TABLE -->
			<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
				<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
					<h3 style="margin: 0; color: #1e293b; font-size: 16px; font-weight: 700;">📋 জমাকৃত বিজ্ঞাপন বুকিং আবেদনের তালিকা:</h3>
					<span style="font-size: 13px; color: #64748b;">মোট আবেদন: <strong><?php echo esc_html( count( $bookings ) ); ?></strong> টি</span>
				</div>
				
				<?php if ( empty( $bookings ) ) : ?>
					<div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 35px; text-align: center; color: #64748b;">
						<p style="margin: 0; font-size: 15px;">এখনও কোনো নতুন বিজ্ঞাপনের আবেদন জমা পড়েনি।</p>
					</div>
				<?php else : ?>
					<div style="overflow-x: auto;">
						<table class="wp-list-table widefat fixed striped table-view-list" style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
							<thead>
								<tr style="background: #f1f5f9;">
									<th style="width: 110px; font-weight: 700; color: #334155;">তারিখ ও সময়</th>
									<th style="width: 170px; font-weight: 700; color: #334155;">আবেদনকারী ও প্রতিষ্ঠান</th>
									<th style="width: 160px; font-weight: 700; color: #334155;">যোগাযোগ মাধ্যম</th>
									<th style="font-weight: 700; color: #334155;">বিজ্ঞাপন প্যাকেজ</th>
									<th style="width: 90px; font-weight: 700; color: #334155;">সময়কাল</th>
									<th style="width: 140px; font-weight: 700; color: #334155;">স্ট্যাটাস</th>
									<th style="width: 120px; text-align: right; font-weight: 700; color: #334155;">অ্যাকশন</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Sort latest first
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
										<td>
											<strong style="color: #006a4e; font-size: 13px;"><?php echo esc_html( date( 'd/m/Y', strtotime( $b['date'] ) ) ); ?></strong><br>
											<span style="font-size: 11px; color: #64748b;"><?php echo esc_html( date( 'h:i A', strtotime( $b['date'] ) ) ); ?></span>
										</td>
										<td>
											<strong style="font-size: 13px; color: #0f172a;"><?php echo esc_html( $b['name'] ); ?></strong><br>
											<span style="font-size: 12px; color: #64748b; font-weight: 600;">🏢 <?php echo esc_html( $b['company'] ); ?></span>
										</td>
										<td>
											📞 <a href="tel:<?php echo esc_attr( $b['phone'] ); ?>" style="font-weight: 700; text-decoration: none; color: #006a4e; font-size: 12px;"><?php echo esc_html( $b['phone'] ); ?></a><br>
											✉️ <a href="mailto:<?php echo esc_attr( $b['email'] ); ?>" style="font-size: 11px; color: #2563eb; text-decoration: none;"><?php echo esc_html( $b['email'] ); ?></a>
										</td>
										<td>
											<span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 12px; display: inline-block; color: #0f766e; border: 1px solid #cbd5e1;"><?php echo esc_html( $b['package_name'] ); ?></span>
										</td>
										<td>
											<span style="font-size: 12px; font-weight: 700; color: #334155;">⏱️ <?php echo esc_html( $b['duration'] ); ?></span>
										</td>
										<td>
											<form method="post" style="margin: 0;">
												<?php wp_nonce_field( 'bdk_update_status_nonce' ); ?>
												<input type="hidden" name="action" value="update_booking_status">
												<input type="hidden" name="booking_id" value="<?php echo esc_attr( $b_id ); ?>">
												<select name="status" onchange="this.form.submit()" style="font-size: 11px; padding: 3px 6px; border-radius: 6px; background: <?php echo esc_attr( $status_bg ); ?>; color: <?php echo esc_attr( $status_color ); ?>; font-weight: 700; border: 1px solid <?php echo esc_attr( $status_color ); ?>; cursor: pointer;">
													<option value="pending" <?php selected( $status, 'pending' ); ?>>⏳ পেন্ডিং</option>
													<option value="contacted" <?php selected( $status, 'contacted' ); ?>>📞 যোগাযোগ করা হয়েছে</option>
													<option value="approved" <?php selected( $status, 'approved' ); ?>>✅ অনুমোদিত</option>
													<option value="rejected" <?php selected( $status, 'rejected' ); ?>>❌ বাতিল</option>
												</select>
											</form>
										</td>
										<td style="text-align: right;">
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
													style="font-weight: 700; color: #006a4e; border-color: #006a4e;">
													👁️ দেখুন
												</button>
												
												<a href="<?php echo esc_url( wp_nonce_url( '?page=bdk-ad-manager&tab=bookings&action=delete_booking&id=' . $b_id, 'bdk_delete_booking_nonce' ) ); ?>" onclick="return confirm('আপনি কি নিশ্চিত যে এই আবেদনটি মুছে ফেলতে চান?');" class="button button-small" style="color: #dc2626; border-color: #fca5a5; background: #fff5f5;">🗑️</a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>

		<?php else : ?>
			<!-- TAB 2: AD PACKAGES CONFIGURATION -->
			<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.04);">
				<form method="post">
					<?php wp_nonce_field( 'bdk_save_packages_nonce' ); ?>
					<input type="hidden" name="action" value="save_ad_packages">

					<h3 style="margin-top: 0; color: #1e293b; font-size: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
						⚙️ বিজ্ঞাপনের স্থান ও মূল্যের রেট কাস্টমাইজ করুন:
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
			
			<!-- Modal Header -->
			<div style="background: #006a4e; color: #ffffff; padding: 16px 22px; border-radius: 14px 14px 0 0; display: flex; align-items: center; justify-content: space-between;">
				<h3 style="margin: 0; color: #ffffff; font-size: 17px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
					<span>📋</span> বিজ্ঞাপন বুকিং আবেদনের পূর্ণাঙ্গ বিবরণ
				</h3>
				<button type="button" onclick="closeAdminBookingModal()" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
			</div>

			<!-- Modal Body -->
			<div style="padding: 22px;">
				<!-- Contact Info Card -->
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

				<!-- Application Details Table -->
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

				<!-- Message / Details Box -->
				<div style="margin-bottom: 20px;">
					<label style="font-weight: 700; font-size: 13px; color: #334155; display: block; margin-bottom: 6px;">আবেদনকারীর বিশেষ বার্তা / বিবরণ:</label>
					<div id="detailMessage" style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; font-size: 13px; color: #1e293b; white-space: pre-wrap; min-height: 60px; line-height: 1.6;"></div>
				</div>

				<!-- Quick Status Update Form inside Modal -->
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
 * AJAX Handler for Ad Booking Submission (From Frontend Modal Form)
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
		wp_send_json_error( 'অনুগ্রহ করে সকল আবশ্যকীয় ঘর (নাম, ফোন নম্বর ও ইমেইল) পূরণ করুন।' );
	}

	// Save to DB Option List
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

	// Send Email Notification to Site Admin
	$admin_email = get_option( 'admin_email' );
	$site_name   = get_bloginfo( 'name' );

	$admin_subject = '[বিজ্ঞাপন বুকিং] নতুন আবেদন: ' . $applicant_name . ' (' . $company_name . ')';
	$admin_body    = "
		<h2>📢 নতুন বিজ্ঞাপন বুকিং আবেদন জমা হয়েছে</h2>
		<p><strong>দৈনিক বাংলাদেশের কথা</strong> নিউজ পোর্টালে একজন ব্যবহারকারী বিজ্ঞাপনের আবেদন পাঠিয়েছেন।</p>
		<hr>
		<p><strong>আবেদনকারীর নাম:</strong> {$applicant_name}</p>
		<p><strong>প্রতিষ্ঠান / ব্র্যান্ড:</strong> {$company_name}</p>
		<p><strong>মোবাইল নম্বর:</strong> {$phone}</p>
		<p><strong>ইমেইল ঠিকানা:</strong> {$email}</p>
		<p><strong>আবেদনকৃত প্যাকেজ:</strong> {$package_name}</p>
		<p><strong>সময়কাল:</strong> {$duration}</p>
		<p><strong>বিশেষ বার্তা / বিবরণ:</strong> {$message}</p>
		<hr>
		<p>ওয়ার্ডপ্রেস এডমিন প্যানেলে লগইন করে সরাসরি বিস্তারিত স্ট্যাটাস আপডেট করুন।</p>
	";

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	wp_mail( $admin_email, $admin_subject, $admin_body, $headers );

	// Send Thank You Email to Applicant
	$user_subject = "দৈনিক বাংলাদেশের কথা - বিজ্ঞাপন বুকিং আবেদন নিশ্চিতকরণ";
	$user_body    = "
		<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;'>
			<h2 style='color: #006a4e; margin-top: 0;'>সম্মানিত {$applicant_name},</h2>
			<p>শুভেচ্ছা নেবেন। <strong>{$site_name}</strong> পোর্টালে বিজ্ঞাপনের আবেদন জানানোর জন্য আপনাকে আন্তরিক ধন্যবাদ।</p>
			<p>আপনার আবেদনের বিস্তারিত সংক্ষেপ:</p>
			<ul style='background: #f8fafc; padding: 15px 25px; border-radius: 6px; color: #334155;'>
				<li><strong>প্যাকেজের নাম:</strong> {$package_name}</li>
				<li><strong>সময়কাল:</strong> {$duration}</li>
				<li><strong>মোবাইল নম্বর:</strong> {$phone}</li>
			</ul>
			<p>আমাদের এডভারটাইজিং বিভাগ আপনার আবেদনটি পর্যালোচনা করে খুব দ্রুততম সময়ের মধ্যে উল্লিখিত ফোন নম্বর বা ইমেইলে যোগাযোগ করবে।</p>
			<br>
			<p style='color: #64748b; font-size: 13px;'>ধন্যবাদান্তে,<br><strong>বিজ্ঞাপন ও বিপণন বিভাগ</strong><br>{$site_name}</p>
		</div>
	";

	wp_mail( $email, $user_subject, $user_body, $headers );

	wp_send_json_success( array(
		'message' => '🎉 আপনার বিজ্ঞাপনের বুকিং আবেদনটি সফলভাবে জমা হয়েছে! আপনার ইমেইলে একটি নিশ্চয়তা বার্তা পাঠানো হয়েছে। আমাদের এডভারটাইজিং টিম খুব শীঘ্রই আপনার সাথে যোগাযোগ করবে।',
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
