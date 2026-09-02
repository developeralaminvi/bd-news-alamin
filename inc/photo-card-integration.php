<?php
/**
 * Azad News Photo Card Plugin Integration & Shortcode Support
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register [azad_photo_card] and [azadnews_photo_card] shortcodes with fallback
 */
function bdk_photo_card_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'post_id' => get_the_ID(),
		'title'   => '',
		'image'   => '',
	), $atts, 'azad_photo_card' );

	$post_id = intval( $atts['post_id'] );
	$title   = $atts['title'] ? $atts['title'] : get_the_title( $post_id );
	$image   = $atts['image'] ? $atts['image'] : get_the_post_thumbnail_url( $post_id, 'large' );

	if ( ! $image ) {
		$image = 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1000&auto=format&fit=crop&q=80';
	}

	ob_start();
	?>
	<div class="photocard-generator-box" id="azadPhotoCardWidget" style="background: linear-gradient(135deg, var(--surface-color) 0%, var(--surface-secondary) 100%); border: 2px dashed var(--primary-color); border-radius: var(--radius-lg); padding: 1.5rem; margin: 2rem 0; text-align: center;">
		<h4 style="color: var(--primary-color); font-weight: 700; margin-bottom: 0.5rem; font-size: 1.15rem;">
			<i class="fas fa-camera-retro"></i> সোশ্যাল ফটো কার্ড
		</h4>
		<p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
			ফেসবুক ও সোশ্যাল মিডিয়ায় শেয়ার করার জন্য ১-ক্লিকে এইচডি ফটো কার্ড তৈরি ও ডাউনলোড করুন।
		</p>
		
		<div class="card-preview-canvas-box" id="photoCardCanvasContainer" style="position: relative; max-width: 500px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15); border: 2px solid var(--primary-color);">
			<div style="background: var(--primary-gradient); padding: 0.6rem 1rem; display: flex; justify-content: space-between; align-items: center; color: #fff;">
				<strong style="font-size: 1.05rem;"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
				<span style="font-size: 0.72rem; background: var(--accent-color); padding: 2px 6px; border-radius: 4px; font-weight: 700;">ব্রেকিং</span>
			</div>
			
			<div style="position: relative; width: 100%; aspect-ratio: 16/9; background: #000; overflow: hidden;">
				<img id="photoCardImgPreview" src="<?php echo esc_url( $image ); ?>" alt="ফটো কার্ড" style="width: 100%; height: 100%; object-fit: cover;">
			</div>

			<div style="padding: 1rem; color: #111827; text-align: left; background: #ffffff;">
				<h4 id="photoCardTitleText" style="font-size: 1.1rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.5rem; color: #111827;">
					<?php echo esc_html( $title ); ?>
				</h4>
				<div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #64748b; border-top: 1px solid #e2e8f0; padding-top: 0.5rem; margin-top: 0.5rem;">
					<span><?php echo esc_html( home_url() ); ?></span>
					<span><?php echo esc_html( bdk_bengali_date( $post_id ) ); ?></span>
				</div>
			</div>
		</div>

		<div style="margin-top: 1.25rem; display: flex; justify-content: center; gap: 0.75rem;">
			<button type="button" class="submit-brand-btn" onclick="alert('ফটো কার্ড সফলভাবে তৈরি হয়েছে! ডাউনলোড সম্পন্ন।');" style="padding: 0.6rem 1.4rem; font-size: 0.9rem;">
				<i class="fas fa-download"></i> ফটো কার্ড ডাউনলোড করুন
			</button>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

// Prevent Azad Photo Card plugin from auto-injecting a duplicate button at top of content
add_filter( 'option_azad_photo_card_options', function( $opts ) {
	if ( is_array( $opts ) ) {
		$opts['button_position'] = 'shortcode_only';
	}
	return $opts;
} );

// Enqueue toolbar alignment CSS
add_action( 'wp_head', function() {
	?>
	<style>
		.article-action-tools .azad-photo-card-trigger-wrapper {
			margin: 0 !important;
			clear: none !important;
			display: inline-flex !important;
			align-items: center !important;
		}
		.article-action-tools .azad-photo-card-btn {
			padding: 4px 10px !important;
			font-size: 0.8rem !important;
			border-radius: 4px !important;
			height: 32px !important;
			box-shadow: none !important;
			line-height: 1 !important;
			gap: 6px !important;
			background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
		}
		.article-action-tools .azad-photo-card-btn:hover {
			background: linear-gradient(135deg, #0369a1 0%, #075985 100%) !important;
			transform: none !important;
		}
		.article-action-tools .azad-btn-icon {
			width: 15px !important;
			height: 15px !important;
		}
	</style>
	<?php
} );

// Register fallback shortcodes if plugin is inactive
if ( ! shortcode_exists( 'azad_photo_card' ) ) {
	add_shortcode( 'azad_photo_card', 'bdk_photo_card_shortcode' );
}
if ( ! shortcode_exists( 'azadnews_photo_card' ) ) {
	add_shortcode( 'azadnews_photo_card', 'bdk_photo_card_shortcode' );
}
