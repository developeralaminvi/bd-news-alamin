<?php
/**
 * Theme Recommended Plugins Installer & Auto-Activator
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Azad Photo Card plugin is active
 */
function bdk_is_photo_card_plugin_active() {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	return is_plugin_active( 'azadnews-photo-card-main/azadnews-photo-card.php' );
}

/**
 * Display Admin Notice if plugin is not active
 */
function bdk_photo_card_plugin_notice() {
	if ( ! current_user_can( 'install_plugins' ) || bdk_is_photo_card_plugin_active() ) {
		return;
	}

	$install_url = wp_nonce_url(
		admin_url( 'admin-post.php?action=bdk_install_photo_card_plugin' ),
		'bdk_install_photo_card_nonce'
	);
	?>
	<div class="notice notice-info is-dismissible" style="padding: 15px 20px; border-left-color: #0284c7; background: #f0f9ff; margin: 15px 0;">
		<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
			<div style="display: flex; align-items: center; gap: 12px;">
				<span class="dashicons dashicons-format-image" style="font-size: 32px; width: 32px; height: 32px; color: #0284c7;"></span>
				<div>
					<h3 style="margin: 0 0 4px 0; color: #0369a1; font-size: 1rem; font-weight: 700;">দৈনিক বাংলাদেশের কথা — রিকমেন্ডেড প্লাগইন ইনস্টলেশন</h3>
					<p style="margin: 0; color: #0c4a6e; font-size: 0.88rem;">সোশ্যাল মিডিয়ায় ১-ক্লিকে ব্রেকিং নিউজ ফটো কার্ড তৈরি ও ডাউনলোডের জন্য <strong>"Azad News Photo Card"</strong> প্লাগইনটি সক্রিয় করা প্রয়োজন।</p>
				</div>
			</div>
			<div>
				<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary button-large" style="background: #0284c7; border-color: #0369a1; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
					<span class="dashicons dashicons-download" style="font-size: 18px; width: 18px; height: 18px;"></span> ১-ক্লিকে ইনস্টল ও অ্যাক্টিভ করুন
				</a>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'admin_notices', 'bdk_photo_card_plugin_notice' );

/**
 * Helper: Recursive Directory Copying
 */
function bdk_copy_directory_recursive( $src, $dst ) {
	if ( ! file_exists( $src ) ) {
		return false;
	}
	if ( ! is_dir( $dst ) ) {
		mkdir( $dst, 0755, true );
	}
	$dir = opendir( $src );
	if ( $dir ) {
		while ( false !== ( $file = readdir( $dir ) ) ) {
			if ( ( '.' !== $file ) && ( '..' !== $file ) ) {
				if ( is_dir( $src . '/' . $file ) ) {
					bdk_copy_directory_recursive( $src . '/' . $file, $dst . '/' . $file );
				} else {
					copy( $src . '/' . $file, $dst . '/' . $file );
				}
			}
		}
		closedir( $dir );
	}
	return true;
}

/**
 * One-Click Auto Install & Activation Handler
 */
function bdk_handle_install_photo_card_plugin() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_die( 'আপনার প্লাগইন ইনস্টল করার অনুমতি নেই।' );
	}

	check_admin_referer( 'bdk_install_photo_card_nonce' );

	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	include_once ABSPATH . 'wp-admin/includes/file.php';

	$plugin_slug         = 'azadnews-photo-card-main/azadnews-photo-card.php';
	$target_dir          = WP_PLUGIN_DIR . '/azadnews-photo-card-main';
	$theme_plugin_source = BDK_THEME_DIR . '/inc/plugins/azadnews-photo-card-main';

	// If plugin directory does not exist, copy from theme inc/plugins folder
	if ( ! file_exists( $target_dir ) && file_exists( $theme_plugin_source ) ) {
		bdk_copy_directory_recursive( $theme_plugin_source, $target_dir );
	}

	// Activate plugin
	if ( file_exists( $target_dir . '/azadnews-photo-card.php' ) ) {
		$result = activate_plugin( $plugin_slug );
		if ( ! is_wp_error( $result ) ) {
			wp_safe_redirect( admin_url( 'plugins.php?activate=true' ) );
			exit;
		}
	}

	wp_safe_redirect( admin_url( 'plugins.php' ) );
	exit;
}
add_action( 'admin_post_bdk_install_photo_card_plugin', 'bdk_handle_install_photo_card_plugin' );
