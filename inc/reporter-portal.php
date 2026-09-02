<?php
/**
 * Reporter Portal, Recruitment, Digital ID Card & Approval Workflow
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize Pages on Theme Setup
 */
function bdk_reporter_portal_auto_setup() {
	if ( ! get_option( 'bdk_reporter_pages_initialized' ) ) {
		// 1. Account / Auth Page
		$existing_account = get_page_by_path( 'reporter-account' );
		if ( ! $existing_account ) {
			$acc_id = wp_insert_post( array(
				'post_title'   => 'সাংবাদিক লগইন ও নিয়োগ আবেদন',
				'post_name'    => 'reporter-account',
				'post_content' => 'দৈনিক বাংলাদেশের কথা সাংবাদিক পোর্টাল। লগইন করুন অথবা ডিজিটাল সাংবাদিক নিয়োগ ফরম পূরণ করে আবেদন করুন।',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );
			if ( $acc_id && ! is_wp_error( $acc_id ) ) {
				update_post_meta( $acc_id, '_wp_page_template', 'page-reporter-account.php' );
			}
		} else {
			update_post_meta( $existing_account->ID, '_wp_page_template', 'page-reporter-account.php' );
		}

		// 2. Reporter Dashboard Page
		$existing_dash = get_page_by_path( 'reporter-dashboard' );
		if ( ! $existing_dash ) {
			$dash_id = wp_insert_post( array(
				'post_title'   => 'রিপোর্টার ড্যাশবোর্ড',
				'post_name'    => 'reporter-dashboard',
				'post_content' => 'সাংবাদিকদের নিজস্ব ড্যাশবোর্ড। সরাসরি সংবাদ সাবমিট করুন ও ডিজিটাল প্রেস আইডি কার্ড সংগ্রহ করুন।',
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );
			if ( $dash_id && ! is_wp_error( $dash_id ) ) {
				update_post_meta( $dash_id, '_wp_page_template', 'page-reporter-dashboard.php' );
			}
		} else {
			update_post_meta( $existing_dash->ID, '_wp_page_template', 'page-reporter-dashboard.php' );
		}

		update_option( 'bdk_reporter_pages_initialized', 1 );
	}
}
add_action( 'init', 'bdk_reporter_portal_auto_setup' );

/**
 * Universal Template Routing for /reporter-account, /reporter-login, /reporter-dashboard
 */
function bdk_reporter_template_include( $template ) {
	if ( is_page( 'reporter-account' ) || is_page( 'reporter-login' ) ) {
		$acc_template = locate_template( 'page-reporter-account.php' );
		if ( $acc_template ) {
			return $acc_template;
		}
	}
	if ( is_page( 'reporter-dashboard' ) ) {
		$dash_template = locate_template( 'page-reporter-dashboard.php' );
		if ( $dash_template ) {
			return $dash_template;
		}
	}

	if ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$request_path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
		$home_path    = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
		if ( ! empty( $home_path ) && strpos( $request_path, $home_path ) === 0 ) {
			$request_path = trim( substr( $request_path, strlen( $home_path ) ), '/' );
		}

		if ( $request_path === 'reporter-account' || $request_path === 'reporter-login' ) {
			$acc_template = locate_template( 'page-reporter-account.php' );
			if ( $acc_template ) {
				global $wp_query;
				if ( $wp_query ) {
					$wp_query->is_404  = false;
					$wp_query->is_page = true;
				}
				status_header( 200 );
				return $acc_template;
			}
		}

		if ( $request_path === 'reporter-dashboard' ) {
			$dash_template = locate_template( 'page-reporter-dashboard.php' );
			if ( $dash_template ) {
				global $wp_query;
				if ( $wp_query ) {
					$wp_query->is_404  = false;
					$wp_query->is_page = true;
				}
				status_header( 200 );
				return $dash_template;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'bdk_reporter_template_include', 98 );

/**
 * Handle Reporter Registration Form Submission
 */
function bdk_handle_reporter_registration() {
	if ( ! isset( $_POST['bdk_reporter_reg_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_reporter_reg_nonce'], 'bdk_reporter_reg_action' ) ) {
		return;
	}

	$full_name   = sanitize_text_field( $_POST['full_name'] ?? '' );
	$phone       = sanitize_text_field( $_POST['phone'] ?? '' );
	$username    = sanitize_user( $_POST['username'] ?? '' );
	$email       = sanitize_email( $_POST['email'] ?? '' );
	$designation = sanitize_text_field( $_POST['designation'] ?? 'সাংবাদিক / প্রতিনিধি' );
	$password    = $_POST['password'] ?? '';
	$confirm_pass= $_POST['confirm_password'] ?? '';

	$errors = array();

	if ( empty( $full_name ) || empty( $username ) || empty( $email ) || empty( $phone ) || empty( $password ) ) {
		$errors[] = 'সকল আবশ্যিক তথ্য (স্টার চিহ্নিত) পূরণ করুন।';
	}
	if ( $password !== $confirm_pass ) {
		$errors[] = 'পাসওয়ার্ড এবং পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।';
	}
	if ( username_exists( $username ) ) {
		$errors[] = 'এই ইউজারনেমটি দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট তৈরি করা আছে।';
	}
	if ( email_exists( $email ) ) {
		$errors[] = 'এই ইমেইলটি দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট তৈরি করা আছে।';
	}

	// Handle Photo Upload
	$photo_url = '';
	if ( ! empty( $_FILES['reporter_photo']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$photo_id = media_handle_upload( 'reporter_photo', 0 );
		if ( is_wp_error( $photo_id ) ) {
			$errors[] = 'ছবি আপলোড করতে ব্যর্থ হয়েছে: ' . $photo_id->get_error_message();
		} else {
			$photo_url = wp_get_attachment_url( $photo_id );
		}
	} else {
		$errors[] = 'আপনার পাসপোর্ট সাইজ ছবি আপলোড করুন।';
	}

	// Handle CV Upload
	$cv_url = '';
	if ( ! empty( $_FILES['reporter_cv']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$uploaded_cv = wp_handle_upload( $_FILES['reporter_cv'], array( 'test_form' => false ) );
		if ( isset( $uploaded_cv['error'] ) ) {
			$errors[] = 'সিভি ফাইল আপলোড করতে ব্যর্থ হয়েছে: ' . $uploaded_cv['error'];
		} else {
			$cv_url = $uploaded_cv['url'];
		}
	} else {
		$errors[] = 'আপনার বায়োডাটা / সিভি ফাইল (PDF/Doc) আপলোড করুন।';
	}

	if ( ! empty( $errors ) ) {
		set_transient( 'bdk_reg_errors', $errors, 60 );
		wp_safe_redirect( add_query_arg( 'reg_error', '1', home_url( '/reporter-account' ) ) );
		exit;
	}

	// Create User
	$user_id = wp_create_user( $username, $password, $email );
	if ( is_wp_error( $user_id ) ) {
		set_transient( 'bdk_reg_errors', array( $user_id->get_error_message() ), 60 );
		wp_safe_redirect( add_query_arg( 'reg_error', '1', home_url( '/reporter-account' ) ) );
		exit;
	}

	// Update Display Name & User Meta
	wp_update_user( array(
		'ID'           => $user_id,
		'display_name' => $full_name,
		'first_name'   => $full_name,
		'role'         => 'author',
	) );

	$id_code = 'BDK-REP-' . date( 'Y' ) . '-' . str_pad( $user_id, 4, '0', STR_PAD_LEFT );

	update_user_meta( $user_id, 'bdk_reporter_phone', $phone );
	update_user_meta( $user_id, 'bdk_reporter_designation', $designation );
	update_user_meta( $user_id, 'bdk_reporter_photo', $photo_url );
	update_user_meta( $user_id, 'bdk_reporter_cv', $cv_url );
	update_user_meta( $user_id, 'bdk_reporter_status', 'pending' );
	update_user_meta( $user_id, 'bdk_reporter_id_code', $id_code );
	update_user_meta( $user_id, 'bdk_reporter_applied_date', current_time( 'mysql' ) );

	// Automatically log in the newly registered user
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id );

	wp_safe_redirect( home_url( '/reporter-dashboard?registered=1' ) );
	exit;
}
add_action( 'admin_post_nopriv_bdk_reporter_register', 'bdk_handle_reporter_registration' );
add_action( 'admin_post_bdk_reporter_register', 'bdk_handle_reporter_registration' );

/**
 * Handle Reporter Login Form Submission
 */
function bdk_handle_reporter_login() {
	if ( ! isset( $_POST['bdk_reporter_login_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_reporter_login_nonce'], 'bdk_reporter_login_action' ) ) {
		return;
	}

	$log      = sanitize_text_field( $_POST['log'] ?? '' );
	$pwd      = $_POST['pwd'] ?? '';
	$remember = ! empty( $_POST['rememberme'] );

	$creds = array(
		'user_login'    => $log,
		'user_password' => $pwd,
		'remember'      => $remember,
	);

	$user = wp_signon( $creds, is_ssl() );

	if ( is_wp_error( $user ) ) {
		set_transient( 'bdk_login_errors', array( 'ইউজারনেম বা পাসওয়ার্ড ভুল হয়েছে। অনুগ্রহ করে সঠিক তথ্য দিয়ে চেষ্টা করুন।' ), 60 );
		wp_safe_redirect( add_query_arg( 'login_error', '1', home_url( '/reporter-account' ) ) );
		exit;
	}

	wp_safe_redirect( home_url( '/reporter-dashboard' ) );
	exit;
}
add_action( 'admin_post_nopriv_bdk_reporter_login', 'bdk_handle_reporter_login' );
add_action( 'admin_post_bdk_reporter_login', 'bdk_handle_reporter_login' );

/**
 * Handle Front-end News Submission by Approved Reporters
 */
function bdk_handle_reporter_submit_post() {
	if ( ! is_user_logged_in() ) {
		wp_die( 'অ্যাক্সেস সংরক্ষিত। অনুগ্রহ করে প্রথমে লগইন করুন।' );
	}

	if ( ! isset( $_POST['bdk_reporter_post_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_reporter_post_nonce'], 'bdk_reporter_post_action' ) ) {
		wp_die( 'নিরাপত্তা যাচাই ব্যর্থ হয়েছে।' );
	}

	$current_user = wp_get_current_user();
	$status       = get_user_meta( $current_user->ID, 'bdk_reporter_status', true );

	$post_title   = sanitize_text_field( $_POST['post_title'] ?? '' );
	$post_cat     = intval( $_POST['post_category'] ?? 0 );
	$post_excerpt = sanitize_textarea_field( $_POST['post_excerpt'] ?? '' );
	$post_content = wp_kses_post( $_POST['post_content'] ?? '' );

	if ( empty( $post_title ) || empty( $post_content ) || empty( $post_cat ) ) {
		set_transient( 'bdk_post_sub_error', 'সংবাদের শিরোনাম, ক্যাটাগরি এবং মূল বিবরণ প্রদান আবশ্যক।', 60 );
		wp_safe_redirect( home_url( '/reporter-dashboard?post_error=1' ) );
		exit;
	}

	$editing_post_id = intval( $_POST['editing_post_id'] ?? 0 );
	$auto_approve    = get_user_meta( $current_user->ID, 'bdk_reporter_auto_approve', true );
	$target_status   = ( $auto_approve || current_user_can( 'administrator' ) ) ? 'publish' : 'pending';

	if ( $editing_post_id > 0 ) {
		$existing_post = get_post( $editing_post_id );
		if ( ! $existing_post || ( $existing_post->post_author != $current_user->ID && ! current_user_can( 'administrator' ) ) ) {
			wp_die( 'আপনার এই পোস্টটি সম্পাদনা করার অনুমতি নেই।' );
		}

		$post_data = array(
			'ID'           => $editing_post_id,
			'post_title'   => $post_title,
			'post_content' => $post_content,
			'post_excerpt' => $post_excerpt,
			'post_status'  => $target_status,
			'post_category'=> array( $post_cat ),
		);

		$new_post_id = wp_update_post( $post_data );
	} else {
		$post_data = array(
			'post_title'   => $post_title,
			'post_content' => $post_content,
			'post_excerpt' => $post_excerpt,
			'post_status'  => $target_status,
			'post_author'  => $current_user->ID,
			'post_category'=> array( $post_cat ),
		);

		$new_post_id = wp_insert_post( $post_data );
	}

	if ( is_wp_error( $new_post_id ) ) {
		set_transient( 'bdk_post_sub_error', 'সংবাদ পোস্ট সাবমিট করতে ত্রুটি: ' . $new_post_id->get_error_message(), 60 );
		wp_safe_redirect( home_url( '/reporter-dashboard?post_error=1' ) );
		exit;
	}

	// Handle District Taxonomy selection
	if ( isset( $_POST['post_district'] ) ) {
		$district_id = intval( $_POST['post_district'] );
		if ( $district_id > 0 ) {
			wp_set_object_terms( $new_post_id, array( $district_id ), 'bdk_district' );
		}
	}

	// Handle Post Thumbnail Upload
	if ( ! empty( $_FILES['post_thumbnail']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attach_id = media_handle_upload( 'post_thumbnail', $new_post_id );
		if ( ! is_wp_error( $attach_id ) ) {
			set_post_thumbnail( $new_post_id, $attach_id );
		}
	}

	$redirect_flag = ( $editing_post_id > 0 ) ? 'updated=1' : 'submitted=1';
	wp_safe_redirect( home_url( '/reporter-dashboard?' . $redirect_flag . '&edit_post=' . $new_post_id ) );
	exit;
}
add_action( 'admin_post_bdk_reporter_submit_post', 'bdk_handle_reporter_submit_post' );

/**
 * Handle Reporter Profile Update Request Submission
 */
function bdk_handle_reporter_update_profile() {
	if ( ! is_user_logged_in() ) {
		wp_die( 'অ্যাক্সেস সংরক্ষিত।' );
	}

	if ( ! isset( $_POST['bdk_reporter_profile_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_reporter_profile_nonce'], 'bdk_reporter_profile_action' ) ) {
		wp_die( 'নিরাপত্তা যাচাই ব্যর্থ হয়েছে।' );
	}

	$current_user = wp_get_current_user();
	$user_id      = $current_user->ID;

	$full_name   = sanitize_text_field( $_POST['full_name'] ?? '' );
	$phone       = sanitize_text_field( $_POST['phone'] ?? '' );
	$designation = sanitize_text_field( $_POST['designation'] ?? '' );

	$photo_url = get_user_meta( $user_id, 'bdk_reporter_photo', true );
	if ( ! empty( $_FILES['reporter_photo']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$photo_id = media_handle_upload( 'reporter_photo', 0 );
		if ( ! is_wp_error( $photo_id ) ) {
			$photo_url = wp_get_attachment_url( $photo_id );
		}
	}

	$cv_url = get_user_meta( $user_id, 'bdk_reporter_cv', true );
	if ( ! empty( $_FILES['reporter_cv']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$uploaded_cv = wp_handle_upload( $_FILES['reporter_cv'], array( 'test_form' => false ) );
		if ( ! isset( $uploaded_cv['error'] ) ) {
			$cv_url = $uploaded_cv['url'];
		}
	}

	$auto_approve = get_user_meta( $user_id, 'bdk_reporter_auto_approve', true );

	if ( $auto_approve || current_user_can( 'administrator' ) ) {
		wp_update_user( array(
			'ID'           => $user_id,
			'display_name' => $full_name,
			'first_name'   => $full_name,
		) );
		update_user_meta( $user_id, 'bdk_reporter_phone', $phone );
		update_user_meta( $user_id, 'bdk_reporter_designation', $designation );
		update_user_meta( $user_id, 'bdk_reporter_photo', $photo_url );
		update_user_meta( $user_id, 'bdk_reporter_cv', $cv_url );
		delete_user_meta( $user_id, 'bdk_pending_profile_update' );
		delete_user_meta( $user_id, 'bdk_profile_update_status' );
		wp_safe_redirect( home_url( '/reporter-dashboard?profile_updated=1' ) );
		exit;
	} else {
		$pending_data = array(
			'full_name'   => $full_name,
			'phone'       => $phone,
			'designation' => $designation,
			'photo'       => $photo_url,
			'cv'          => $cv_url,
			'updated_at'  => current_time( 'mysql' ),
		);
		update_user_meta( $user_id, 'bdk_pending_profile_update', $pending_data );
		update_user_meta( $user_id, 'bdk_profile_update_status', 'pending' );
		wp_safe_redirect( home_url( '/reporter-dashboard?profile_requested=1' ) );
		exit;
	}
}
add_action( 'admin_post_bdk_reporter_update_profile', 'bdk_handle_reporter_update_profile' );

/**
 * Render Hierarchical Parent & Sub Terms for Select Dropdowns
 */
function bdk_render_hierarchical_terms_options( $taxonomy = 'category', $parent = 0, $level = 0, $selected_id = 0 ) {
	$terms = get_terms( array(
		'taxonomy'   => $taxonomy,
		'parent'     => $parent,
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return;
	}

	foreach ( $terms as $term ) {
		$prefix = '';
		if ( $level > 0 ) {
			$prefix = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;', $level ) . '└─ ';
		} else {
			$prefix = ( 'bdk_district' === $taxonomy ) ? '📌 ' : '📁 ';
		}

		$selected = ( $selected_id == $term->term_id ) ? 'selected' : '';
		echo '<option value="' . esc_attr( $term->term_id ) . '" ' . $selected . '>';
		echo $prefix . esc_html( $term->name );
		echo '</option>';

		bdk_render_hierarchical_terms_options( $taxonomy, $term->term_id, $level + 1, $selected_id );
	}
}

/**
 * Send Email Notification to Reporter when Post is Published by Admin
 */
function bdk_notify_reporter_on_post_publish( $new_status, $old_status, $post ) {
	if ( 'publish' === $new_status && 'publish' !== $old_status && 'post' === $post->post_type ) {
		$author_id = $post->post_author;
		$user      = get_userdata( $author_id );

		if ( $user ) {
			$reporter_status = get_user_meta( $author_id, 'bdk_reporter_status', true );
			if ( ! empty( $reporter_status ) ) {
				$to      = $user->user_email;
				$subject = 'অভিনন্দন! আপনার জমা দেওয়া সংবাদটি প্রকাশিত হয়েছে - দৈনিক বাংলাদেশের কথা';
				
				$post_title = get_the_title( $post->ID );
				$post_link  = get_permalink( $post->ID );
				$site_name  = get_bloginfo( 'name' );

				$message  = "প্রিয় " . esc_html( $user->display_name ) . ",\n\n";
				$message .= "আপনার জমা দেওয়া সংবাদটি সফলভাবে পর্যালোচনা শেষে '{$site_name}' পোর্টালে প্রকাশ করা হয়েছে।\n\n";
				$message .= "সংবাদের শিরোনাম: " . $post_title . "\n";
				$message .= "লিংক: " . $post_link . "\n\n";
				$message .= "বস্তুনিষ্ঠ সংবাদ পরিবেশনে আমাদের পাশে থাকার জন্য ধন্যবাদ।\n\n";
				$message .= "শুভেচ্ছান্তে,\nসম্পাদনা পরিষদ, " . $site_name;

				wp_mail( $to, $subject, $message );
			}
		}
	}
}
add_action( 'transition_post_status', 'bdk_notify_reporter_on_post_publish', 10, 3 );

/**
 * Helper: Count Pending Reporter Accounts & Profile Edits
 */
function bdk_get_pending_reporters_count() {
	$pending_reporters = get_users( array(
		'meta_key'   => 'bdk_reporter_status',
		'meta_value' => 'pending',
		'fields'     => 'ID',
	) );

	$pending_profile_edits = get_users( array(
		'meta_key'   => 'bdk_profile_update_status',
		'meta_value' => 'pending',
		'fields'     => 'ID',
	) );

	return count( $pending_reporters ) + count( $pending_profile_edits );
}

/**
 * Helper: Count Pending News Posts
 */
function bdk_get_pending_posts_count() {
	$counts = wp_count_posts( 'post' );
	return isset( $counts->pending ) ? (int) $counts->pending : 0;
}

/**
 * Register WP Admin Reporter Portal Menu with Dynamic Notification Badge
 */
function bdk_register_admin_reporter_menu() {
	$pending_count = bdk_get_pending_reporters_count();
	$menu_title    = 'সাংবাদিক প্যানেল';

	if ( $pending_count > 0 ) {
		$menu_title .= sprintf(
			' <span class="awaiting-mod count-%1$d" style="background:#ef4444; color:#fff; font-size:10px; font-weight:700; padding:2px 6px; border-radius:10px; margin-left:4px;"><span class="pending-count">%1$d</span></span>',
			$pending_count
		);
	}

	add_menu_page(
		'সাংবাদিক প্যানেল',
		$menu_title,
		'manage_options',
		'bdk-reporters',
		'bdk_render_admin_reporters_page',
		'dashicons-id-alt',
		25
	);
}
add_action( 'admin_menu', 'bdk_register_admin_reporter_menu' );

/**
 * Add Pending Posts Notification Badge to WP Admin "Posts" (পোস্ট) Menu
 */
function bdk_update_admin_posts_menu_badge() {
	global $menu;
	$pending_posts = bdk_get_pending_posts_count();

	if ( $pending_posts > 0 && ! empty( $menu ) ) {
		foreach ( $menu as $key => $value ) {
			if ( isset( $value[2] ) && 'edit.php' === $value[2] ) {
				$menu[$key][0] .= sprintf(
					' <span class="awaiting-mod count-%1$d" style="background:#f59e0b; color:#fff; font-size:10px; font-weight:700; padding:2px 6px; border-radius:10px; margin-left:4px;"><span class="pending-count">%1$d</span></span>',
					$pending_posts
				);
				break;
			}
		}
	}
}
add_action( 'admin_menu', 'bdk_update_admin_posts_menu_badge', 999 );

/**
 * Render WP Admin Reporter Portal & Approval System
 */
function bdk_render_admin_reporters_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'আপনার এই পেজ দেখার অনুমতি নেই।' );
	}

	// Handle Admin Status Actions
	if ( isset( $_GET['action'], $_GET['user_id'] ) && check_admin_referer( 'bdk_reporter_admin_action' ) ) {
		$target_user_id = intval( $_GET['user_id'] );
		$action         = sanitize_text_field( $_GET['action'] );

		if ( 'approve' === $action ) {
			update_user_meta( $target_user_id, 'bdk_reporter_status', 'approved' );
			
			// Send Email Notification upon Approval
			$user = get_userdata( $target_user_id );
			if ( $user ) {
				$to      = $user->user_email;
				$subject = 'অভিনন্দন! আপনার সাংবাদিক একাউন্টটি অনুমোদিত হয়েছে - দৈনিক বাংলাদেশের কথা';
				$dash_url= home_url( '/reporter-dashboard' );
				$site    = get_bloginfo( 'name' );

				$message  = "প্রিয় " . esc_html( $user->display_name ) . ",\n\n";
				$message .= "অভিনন্দন! '{$site}' পোর্টালে আপনার আবেদনকৃত ডিজিটাল সাংবাদিক একাউন্টটি পর্যালোচনা শেষে সফলভাবে অনুমোদন (Approved) করা হয়েছে।\n\n";
				$message .= "এখন থেকে আপনি আপনার ড্যাশবোর্ডে লগইন করে সরাসরি সংবাদ সাবমিট করতে পারবেন এবং ডিজিটাল প্রেস আইডি কার্ড ডাউনলোড করতে পারবেন।\n\n";
				$message .= "ড্যাশবোর্ড লিঙ্ক: " . $dash_url . "\n\n";
				$message .= "শুভেচ্ছান্তে,\nসম্পাদনা পরিষদ, " . $site;

				wp_mail( $to, $subject, $message );
			}

			echo '<div class="notice notice-success is-dismissible"><p>সাংবাদিকের একাউন্ট সফলভাবে অনুমোদন করা হয়েছে এবং ইমেইল পাঠানো হয়েছে!</p></div>';
		} elseif ( 'reject' === $action ) {
			update_user_meta( $target_user_id, 'bdk_reporter_status', 'rejected' );
			echo '<div class="notice notice-warning is-dismissible"><p>সাংবাদিকের একাউন্ট সাময়িকভাবে বাতিল (Reject) করা হয়েছে।</p></div>';
		} elseif ( 'toggle_auto_approve' === $action ) {
			$current = get_user_meta( $target_user_id, 'bdk_reporter_auto_approve', true );
			update_user_meta( $target_user_id, 'bdk_reporter_auto_approve', $current ? 0 : 1 );
			echo '<div class="notice notice-success is-dismissible"><p>সাংবাদিকের অটো-এপ্রুভ স্ট্যাটাস পরিবর্তন করা হয়েছে!</p></div>';
		} elseif ( 'approve_profile_update' === $action ) {
			$pending = get_user_meta( $target_user_id, 'bdk_pending_profile_update', true );
			if ( is_array( $pending ) ) {
				wp_update_user( array(
					'ID'           => $target_user_id,
					'display_name' => $pending['full_name'],
					'first_name'   => $pending['full_name'],
				) );
				update_user_meta( $target_user_id, 'bdk_reporter_phone', $pending['phone'] );
				update_user_meta( $target_user_id, 'bdk_reporter_designation', $pending['designation'] );
				if ( ! empty( $pending['photo'] ) ) {
					update_user_meta( $target_user_id, 'bdk_reporter_photo', $pending['photo'] );
				}
				if ( ! empty( $pending['cv'] ) ) {
					update_user_meta( $target_user_id, 'bdk_reporter_cv', $pending['cv'] );
				}
				delete_user_meta( $target_user_id, 'bdk_pending_profile_update' );
				delete_user_meta( $target_user_id, 'bdk_profile_update_status' );
				echo '<div class="notice notice-success is-dismissible"><p>সাংবাদিকের প্রোফাইল সংশোধনের আবেদন সফলভাবে অনুমোদন করা হয়েছে!</p></div>';
			}
		} elseif ( 'reject_profile_update' === $action ) {
			delete_user_meta( $target_user_id, 'bdk_pending_profile_update' );
			delete_user_meta( $target_user_id, 'bdk_profile_update_status' );
			echo '<div class="notice notice-warning is-dismissible"><p>প্রোফাইল সংশোধনের আবেদন বাতিল করা হয়েছে।</p></div>';
		}
	}

	// Handle Pending Post Approval Action
	if ( isset( $_GET['action'], $_GET['approve_post_id'] ) && check_admin_referer( 'bdk_reporter_admin_action' ) ) {
		if ( 'approve_pending_post' === $_GET['action'] ) {
			$post_to_approve = intval( $_GET['approve_post_id'] );
			wp_update_post( array(
				'ID'          => $post_to_approve,
				'post_status' => 'publish',
			) );
			echo '<div class="notice notice-success is-dismissible"><p>সংবাদ পোস্টটি (ID: #' . $post_to_approve . ') সফলভাবে প্রকাশ (Publish) করা হয়েছে!</p></div>';
		}
	}

	// Fetch all users with reporter status
	$args = array(
		'meta_key' => 'bdk_reporter_status',
		'orderby'  => 'user_registered',
		'order'    => 'DESC',
	);
	$reporters = get_users( $args );

	// Check if viewing specific ID Card
	$view_id_user = isset( $_GET['view_id'] ) ? intval( $_GET['view_id'] ) : 0;
?>
<div class="wrap" style="max-width: 1200px;">
	<h1 style="display: flex; align-items: center; gap: 10px; font-weight: 700;">
		<span class="dashicons dashicons-id-alt" style="font-size: 32px; width: 32px; height: 32px;"></span>
		দৈনিক বাংলাদেশের কথা — সাংবাদিক আবেদন ও প্রেস আইডি প্যানেল
	</h1>
	<p class="description">ওয়েবসাইট থেকে আবেদনকারী সাংবাদিকদের তথ্য পর্যালোচনা, অনুমোদন/বাতিলকরণ এবং ডিজিটাল প্রেস আইডি কার্ড প্রিন্ট সুবিধা।</p>

	<?php if ( $view_id_user ) : ?>
		<div style="margin: 20px 0; padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 8px;">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=bdk-reporters' ) ); ?>" class="button button-secondary" style="margin-bottom: 15px;">← তালিকায় ফিরে যান</a>
			<?php bdk_render_press_id_card( $view_id_user ); ?>
		</div>
	<?php endif; ?>

	<!-- Pending Profile Updates Box -->
	<?php
	$profile_requests = get_users( array( 'meta_key' => 'bdk_profile_update_status', 'meta_value' => 'pending' ) );
	if ( ! empty( $profile_requests ) ) :
	?>
		<div style="margin-top: 20px; padding: 20px; background: #fffbeb; border: 2px solid #f59e0b; border-radius: 8px;">
			<h2 style="margin-top: 0; color: #b45309; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
				<span class="dashicons dashicons-edit-large"></span> 📝 প্রোফাইল সংশোধনের আবেদনসমূহ (রিভিউ প্রয়োজন)
			</h2>
			<?php foreach ( $profile_requests as $p_user ) :
				$p_id      = $p_user->ID;
				$pending   = get_user_meta( $p_id, 'bdk_pending_profile_update', true );
				if ( ! is_array( $pending ) ) continue;

				$old_name  = $p_user->display_name;
				$old_phone = get_user_meta( $p_id, 'bdk_reporter_phone', true );
				$old_desig = get_user_meta( $p_id, 'bdk_reporter_designation', true );
				$old_photo = bdk_get_author_photo_url( $p_id );
			?>
				<div style="background: #fff; border: 1px solid #fde68a; border-radius: 6px; padding: 15px; margin-bottom: 12px;">
					<h3 style="margin: 0 0 10px 0; font-size: 1rem; color: #1e293b;"><?php echo esc_html( $old_name ); ?> (ইমেইল: <?php echo esc_html( $p_user->user_email ); ?>)</h3>
					
					<table style="width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 12px;">
						<thead>
							<tr style="background: #f8fafc; text-align: left;">
								<th style="padding: 6px; border: 1px solid #e2e8f0;">ফিল্ড (Field)</th>
								<th style="padding: 6px; border: 1px solid #e2e8f0;">বর্তমান তথ্য (Current)</th>
								<th style="padding: 6px; border: 1px solid #e2e8f0; color: #d97706;">নতুন সংশোধিত আবেদন (New Request)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><strong>নাম</strong></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><?php echo esc_html( $old_name ); ?></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0; color: #0284c7; font-weight: 600;"><?php echo esc_html( $pending['full_name'] ?? $old_name ); ?></td>
							</tr>
							<tr>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><strong>মোবাইল</strong></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><?php echo esc_html( $old_phone ); ?></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0; color: #0284c7; font-weight: 600;"><?php echo esc_html( $pending['phone'] ?? $old_phone ); ?></td>
							</tr>
							<tr>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><strong>পদবী / স্থান</strong></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0;"><?php echo esc_html( $old_desig ); ?></td>
								<td style="padding: 6px; border: 1px solid #e2e8f0; color: #0284c7; font-weight: 600;"><?php echo esc_html( $pending['designation'] ?? $old_desig ); ?></td>
							</tr>
							<?php if ( ! empty( $pending['photo'] ) && $pending['photo'] !== $old_photo ) : ?>
								<tr>
									<td style="padding: 6px; border: 1px solid #e2e8f0;"><strong>নতুন ছবি</strong></td>
									<td style="padding: 6px; border: 1px solid #e2e8f0;"><img src="<?php echo esc_url( $old_photo ); ?>" style="width: 40px; height: 40px; border-radius: 50%;"></td>
									<td style="padding: 6px; border: 1px solid #e2e8f0;"><img src="<?php echo esc_url( $pending['photo'] ); ?>" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid #0284c7;"></td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>

					<div>
						<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=approve_profile_update&user_id=' . $p_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-primary button-small" style="background: #10b981; border-color: #059669;">✓ সংশোধন অনুমোদন করুন</a>
						<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=reject_profile_update&user_id=' . $p_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-secondary button-small" style="color: #ef4444;">✕ সংশোধন বাতিল</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<!-- Pending News Posts Box -->
	<?php
	$pending_news_query = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'pending',
		'posts_per_page' => 20,
	) );
	if ( $pending_news_query->have_posts() ) :
	?>
		<div style="margin-top: 20px; padding: 20px; background: #f0fdf4; border: 2px solid #22c55e; border-radius: 8px;">
			<h2 style="margin-top: 0; color: #15803d; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
				<span class="dashicons dashicons-newspaper"></span> 📰 সাংবাদিকদের পেন্ডিং সংবাদ প্রকাশের আবেদনসমূহ (<?php echo esc_html( $pending_news_query->found_posts ); ?> টি)
			</h2>
			<div style="background: #fff; border: 1px solid #bbf7d0; border-radius: 6px; overflow: hidden;">
				<table class="wp-list-table widefat fixed striped table-view-list" style="border: none;">
					<thead>
						<tr>
							<th style="width: 50px;">ছবি</th>
							<th>সংবাদের শিরোনাম</th>
							<th>সাংবাদিকের নাম</th>
							<th>ক্যাটাগরি</th>
							<th>তারিখ</th>
							<th style="width: 160px;">কার্যক্রম (Action)</th>
						</tr>
					</thead>
					<tbody>
						<?php while ( $pending_news_query->have_posts() ) : $pending_news_query->the_post();
							$p_id     = get_the_ID();
							$author   = get_userdata( get_the_author_meta( 'ID' ) );
							$cats     = get_the_category();
							$cat_name = ! empty( $cats ) ? $cats[0]->name : 'ক্যাটাগরিহীন';
						?>
							<tr>
								<td>
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( array( 40, 40 ), array( 'style' => 'width: 40px; height: 40px; border-radius: 4px; object-fit: cover;' ) ); ?>
									<?php else : ?>
										<span style="color: #999;">নাই</span>
									<?php endif; ?>
								</td>
								<td>
									<strong><a href="<?php echo esc_url( get_edit_post_link( $p_id ) ); ?>" target="_blank" style="color: #0284c7;"><?php the_title(); ?></a></strong>
								</td>
								<td><strong><?php echo esc_html( $author ? $author->display_name : 'অজানা' ); ?></strong></td>
								<td><?php echo esc_html( $cat_name ); ?></td>
								<td><?php echo esc_html( get_the_date( 'd/m/Y H:i' ) ); ?></td>
								<td>
									<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=approve_pending_post&approve_post_id=' . $p_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-primary button-small" style="background: #10b981; border-color: #059669;">
										✓ প্রকাশ করুন (Publish)
									</a>
								</td>
							</tr>
						<?php endwhile; wp_reset_postdata(); ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>

	<div style="margin-top: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
		<table class="wp-list-table widefat fixed striped table-view-list">
			<thead>
				<tr>
					<th style="width: 50px;">ছবি</th>
					<th>সাংবাদিকের নাম ও তথ্য</th>
					<th>পদবী / স্থান</th>
					<th>মোবাইল</th>
					<th>অবস্থা</th>
					<th style="width: 110px;">⚡ অটো-এপ্রুভ</th>
					<th>সিভি</th>
					<th>প্রেস আইডি</th>
					<th style="width: 180px;">কার্যক্রম (Action)</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ( ! empty( $reporters ) ) :
					foreach ( $reporters as $rep ) :
						$r_id          = $rep->ID;
						$r_status      = get_user_meta( $r_id, 'bdk_reporter_status', true ) ?: 'pending';
						$r_phone       = get_user_meta( $r_id, 'bdk_reporter_phone', true ) ?: 'N/A';
						$r_designation = get_user_meta( $r_id, 'bdk_reporter_designation', true ) ?: 'প্রতিনিধি';
						$r_photo       = bdk_get_author_photo_url( $r_id );
						$r_cv          = get_user_meta( $r_id, 'bdk_reporter_cv', true );
						$r_code        = get_user_meta( $r_id, 'bdk_reporter_id_code', true ) ?: 'BDK-REP-' . $r_id;
						$auto_app      = get_user_meta( $r_id, 'bdk_reporter_auto_approve', true );

						$badge_style = 'background: #f59e0b; color: #fff;';
						$status_label= 'পেন্ডিং (Pending)';
						if ( 'approved' === $r_status ) {
							$badge_style  = 'background: #10b981; color: #fff;';
							$status_label = 'অনুমোদিত (Approved)';
						} elseif ( 'rejected' === $r_status ) {
							$badge_style  = 'background: #ef4444; color: #fff;';
							$status_label = 'বাতিলকৃত (Rejected)';
						}
				?>
						<tr>
							<td>
								<img src="<?php echo esc_url( $r_photo ); ?>" alt="<?php echo esc_attr( $rep->display_name ); ?>" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #22c55e;">
							</td>
							<td>
								<strong><?php echo esc_html( $rep->display_name ); ?></strong><br>
								<small style="color: #666;"><?php echo esc_html( $rep->user_email ); ?></small><br>
								<code style="font-size: 0.75rem;"><?php echo esc_html( $r_code ); ?></code>
							</td>
							<td><strong><?php echo esc_html( $r_designation ); ?></strong></td>
							<td><?php echo esc_html( $r_phone ); ?></td>
							<td>
								<span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; <?php echo $badge_style; ?>">
									<?php echo esc_html( $status_label ); ?>
								</span>
							</td>
							<td>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=toggle_auto_approve&user_id=' . $r_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-small" style="<?php echo $auto_app ? 'background: #10b981; color: #fff; border: none;' : 'color: #64748b;'; ?>" title="ক্লিক করে অটো এপ্রুভ পরিবর্তন করুন">
									<?php echo $auto_app ? '⚡ অন (Auto)' : '⚪ অফ (Manual)'; ?>
								</a>
							</td>
							<td>
								<?php if ( $r_cv ) : ?>
									<a href="<?php echo esc_url( $r_cv ); ?>" target="_blank" class="button button-small" style="color: #0284c7;"><span class="dashicons dashicons-pdf" style="font-size: 16px; margin-top: 3px;"></span> সিভি দেখুন</a>
								<?php else : ?>
									<span style="color: #999;">নাই</span>
								<?php endif; ?>
							</td>
							<td>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=bdk-reporters&view_id=' . $r_id ) ); ?>" class="button button-small" style="background: #0284c7; color: #fff; border: none;">
									<span class="dashicons dashicons-id" style="font-size: 16px; margin-top: 3px;"></span> আইডি কার্ড
								</a>
							</td>
							<td>
								<?php if ( 'approved' !== $r_status ) : ?>
									<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=approve&user_id=' . $r_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-primary button-small" style="background: #10b981; border-color: #059669;">অনুমোদন করুন</a>
								<?php endif; ?>
								<?php if ( 'rejected' !== $r_status ) : ?>
									<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=bdk-reporters&action=reject&user_id=' . $r_id ), 'bdk_reporter_admin_action' ) ); ?>" class="button button-secondary button-small" style="color: #ef4444;">বাতিল</a>
								<?php endif; ?>
							</td>
						</tr>
				<?php
					endforeach;
				else :
				?>
					<tr>
						<td colspan="8" style="padding: 20px; text-align: center; color: #666;">এখনও কোনো নতুন ডিজিটাল সাংবাদিক আবেদন করেননি।</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
<?php
}

/**
 * Render Modern Digital Press ID Card HTML Component
 */
function bdk_render_press_id_card( $user_id ) {
	$user = get_userdata( $user_id );
	if ( ! $user ) return;

	$photo_url   = bdk_get_author_photo_url( $user_id );
	$designation = get_user_meta( $user_id, 'bdk_reporter_designation', true ) ?: 'জেলা প্রতিনিধি';
	$phone       = get_user_meta( $user_id, 'bdk_reporter_phone', true ) ?: 'N/A';
	$id_code     = get_user_meta( $user_id, 'bdk_reporter_id_code', true ) ?: 'BDK-REP-' . str_pad( $user_id, 4, '0', STR_PAD_LEFT );
	$status      = get_user_meta( $user_id, 'bdk_reporter_status', true ) ?: 'pending';
	$site_name   = get_bloginfo( 'name' );
	$site_url    = home_url( '/' );

	$issue_date  = bdk_to_bengali_numerals( date( 'd/m/Y' ) );
?>
<div class="digital-id-card-wrapper" id="pressIdCardPrintable">
	<style>
		.press-card-box {
			width: 360px;
			max-width: 100%;
			background: linear-gradient(145deg, #0d1b2a, #1b263b);
			color: #ffffff;
			border-radius: 16px;
			padding: 24px 20px;
			box-shadow: 0 20px 35px rgba(0,0,0,0.3);
			font-family: 'Hind Siliguri', 'Roboto', sans-serif;
			position: relative;
			overflow: hidden;
			border: 2px solid rgba(255,255,255,0.1);
			margin: 0 auto;
		}
		.press-card-box::before {
			content: '';
			position: absolute;
			top: -50px;
			right: -50px;
			width: 140px;
			height: 140px;
			background: radial-gradient(circle, rgba(220,38,38,0.35) 0%, rgba(0,0,0,0) 70%);
			border-radius: 50%;
		}
		.press-card-header {
			text-align: center;
			border-bottom: 2px solid rgba(255,255,255,0.15);
			padding-bottom: 12px;
			margin-bottom: 16px;
		}
		.press-card-brand {
			font-size: 1.15rem;
			font-weight: 800;
			color: #ffffff;
			margin: 0;
			letter-spacing: 0.5px;
		}
		.press-card-sub {
			display: inline-block;
			background: #dc2626;
			color: #ffffff;
			font-size: 0.72rem;
			font-weight: 700;
			padding: 2px 10px;
			border-radius: 12px;
			margin-top: 4px;
			text-transform: uppercase;
			letter-spacing: 1px;
		}
		.press-card-photo-wrap {
			text-align: center;
			margin-bottom: 14px;
			position: relative;
		}
		.press-card-photo {
			width: 100px;
			height: 100px;
			border-radius: 50%;
			object-fit: cover;
			border: 3px solid #dc2626;
			box-shadow: 0 4px 12px rgba(0,0,0,0.4);
			background: #ffffff;
		}
		.press-card-body {
			text-align: center;
		}
		.press-card-name {
			font-size: 1.25rem;
			font-weight: 700;
			color: #ffffff;
			margin: 0 0 2px 0;
		}
		.press-card-desig {
			font-size: 0.9rem;
			color: #38bdf8;
			font-weight: 600;
			margin-bottom: 14px;
		}
		.press-card-details {
			background: rgba(255,255,255,0.06);
			border-radius: 8px;
			padding: 10px 12px;
			font-size: 0.82rem;
			text-align: left;
			margin-bottom: 14px;
			line-height: 1.6;
		}
		.press-card-row {
			display: flex;
			justify-content: space-between;
			border-bottom: 1px dashed rgba(255,255,255,0.1);
			padding: 3px 0;
		}
		.press-card-row:last-child { border-bottom: none; }
		.press-card-label { color: #94a3b8; }
		.press-card-val { color: #f8fafc; font-weight: 600; }
		.press-card-footer {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding-top: 8px;
			border-top: 1px solid rgba(255,255,255,0.1);
			font-size: 0.72rem;
			color: #94a3b8;
		}
		.press-qr-code {
			width: 42px;
			height: 42px;
			background: #fff;
			padding: 3px;
			border-radius: 4px;
		}
		@media print {
			body * { visibility: hidden; }
			#pressIdCardPrintable, #pressIdCardPrintable * { visibility: visible; }
			#pressIdCardPrintable { position: absolute; left: 0; top: 0; width: 100%; }
			.no-print { display: none !important; }
		}
	</style>

	<div class="press-card-box">
		<div class="press-card-header">
			<h3 class="press-card-brand"><?php echo esc_html( $site_name ); ?></h3>
			<span class="press-card-sub">ডিজিটাল প্রেস আইডি কার্ড</span>
		</div>

		<div class="press-card-photo-wrap">
			<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $user->display_name ); ?>" class="press-card-photo">
		</div>

		<div class="press-card-body">
			<h4 class="press-card-name"><?php echo esc_html( $user->display_name ); ?></h4>
			<div class="press-card-desig"><?php echo esc_html( $designation ); ?></div>

			<div class="press-card-details">
				<div class="press-card-row">
					<span class="press-card-label">আইডি নম্বর:</span>
					<span class="press-card-val"><?php echo esc_html( $id_code ); ?></span>
				</div>
				<div class="press-card-row">
					<span class="press-card-label">মোবাইল:</span>
					<span class="press-card-val"><?php echo esc_html( $phone ); ?></span>
				</div>
				<div class="press-card-row">
					<span class="press-card-label">ইমেইল:</span>
					<span class="press-card-val"><?php echo esc_html( $user->user_email ); ?></span>
				</div>
				<div class="press-card-row">
					<span class="press-card-label">ইস্যুর তারিখ:</span>
					<span class="press-card-val"><?php echo esc_html( $issue_date ); ?></span>
				</div>
			</div>
		</div>

		<div class="press-card-footer">
			<div>
				<span style="color: #22c55e; font-weight: 700; display: block;">✓ সত্যায়িত পরিচিতিপত্র</span>
				<span>সম্পাদকীয় বিভাগ কর্তৃক ইস্যুকৃত</span>
			</div>
			<div class="press-qr-code">
				<img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo urlencode( $site_url . '?rep_id=' . $id_code ); ?>" alt="QR" style="width: 100%; height: 100%;">
			</div>
		</div>
	</div>

	<div style="text-align: center; margin-top: 15px;" class="no-print">
		<button type="button" onclick="window.print();" class="button button-primary" style="background: #dc2626; border-color: #b91c1c; font-weight: 600; padding: 6px 20px;">
			🖨️ প্রেস আইডি কার্ড প্রিন্ট / সেভ করুন
		</button>
	</div>
</div>
<?php
}

/**
 * Get Author Photo URL with standard Fallbacks
 */
function bdk_get_author_photo_url( $user_id ) {
	$photo_url = get_user_meta( $user_id, 'bdk_reporter_photo', true );
	if ( ! empty( $photo_url ) ) {
		return $photo_url;
	}
	$avatar_url = get_avatar_url( $user_id, array( 'size' => 150 ) );
	if ( $avatar_url ) {
		return $avatar_url;
	}
	return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=300&auto=format&fit=crop&q=80';
}

/**
 * Get Author Designation with Fallback
 */
function bdk_get_author_designation( $user_id ) {
	$desig = get_user_meta( $user_id, 'bdk_reporter_designation', true );
	if ( ! empty( $desig ) ) {
		return $desig;
	}
	return 'সাংবাদিক ও বিশেষ প্রতিবেদক, দৈনিক বাংলাদেশের কথা';
}
