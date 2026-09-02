<?php
/**
 * Custom Post Type: Photo Stories & Photo Features (ছবির গল্প ও ফটো ফিচার)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register CPT 'bdk_photo_story'
 */
function bdk_register_photo_stories_cpt() {
	$labels = array(
		'name'                  => 'ছবির গল্প ও ফটো ফিচার',
		'singular_name'         => 'ছবির গল্প',
		'menu_name'             => 'ছবির গল্প (Photos)',
		'name_admin_bar'        => 'ছবির গল্প',
		'archives'              => 'ফটো ফিচার আর্কাইভ',
		'attributes'            => 'ফটো ফিচার বৈশিষ্ট্য',
		'parent_item_colon'     => 'প্যারেন্ট অ্যালবাম:',
		'all_items'             => 'সকল ছবির গল্প',
		'add_new_item'          => 'নতুন ছবির গল্প যোগ করুন',
		'add_new'               => 'নতুন যোগ করুন',
		'new_item'              => 'নতুন ফটো ফিচার',
		'edit_item'             => 'সম্পাদনা করুন',
		'update_item'           => 'আপডেট করুন',
		'view_item'             => 'গ্যালারি দেখুন',
		'view_items'            => 'সকল গ্যালারি দেখুন',
		'search_items'          => 'ছবি খুঁজুন',
		'not_found'             => 'কোনো ছবির গল্প পাওয়া যায়নি',
		'not_found_in_trash'    => 'ট্র্যাশে কোনো ছবির গল্প নেই',
	);

	$args = array(
		'label'                 => 'ছবির গল্প',
		'description'           => 'ছবি ও ফটো অ্যালবামের জন্য বিশেষ পোস্ট টাইপ',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'menu_icon'             => 'dashicons-format-gallery',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'photo-stories',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite'               => array( 'slug' => 'photo-stories', 'with_front' => false ),
	);

	register_post_type( 'bdk_photo_story', $args );
}
add_action( 'init', 'bdk_register_photo_stories_cpt', 0 );

/**
 * Flush rewrite rules if not yet flushed
 */
function bdk_check_and_flush_photo_rewrites() {
	if ( ! get_option( 'bdk_photo_stories_flushed_v4' ) ) {
		flush_rewrite_rules( false );
		update_option( 'bdk_photo_stories_flushed_v4', 1 );
	}
}
add_action( 'init', 'bdk_check_and_flush_photo_rewrites', 99 );

/**
 * Guarantee Template Loading for bdk_photo_story (Single & Archive)
 */
function bdk_photo_story_template_include( $template ) {
	if ( is_singular( 'bdk_photo_story' ) ) {
		$single_template = BDK_THEME_DIR . '/single-bdk_photo_story.php';
		if ( file_exists( $single_template ) ) {
			return $single_template;
		}
	} elseif ( is_post_type_archive( 'bdk_photo_story' ) ) {
		$archive_template = BDK_THEME_DIR . '/archive-bdk_photo_story.php';
		if ( file_exists( $archive_template ) ) {
			return $archive_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'bdk_photo_story_template_include', 99 );

/**
 * Add Meta Box for Photo Gallery & Captions
 */
function bdk_photo_story_meta_boxes() {
	add_meta_box(
		'bdk_photo_gallery_meta',
		'🖼️ ফটো গ্যালারি ও প্রতিটি ছবির বিবরণ (Captions)',
		'bdk_photo_gallery_meta_box_callback',
		'bdk_photo_story',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bdk_photo_story_meta_boxes' );

/**
 * Render Photo Gallery Meta Box in Admin
 */
function bdk_photo_gallery_meta_box_callback( $post ) {
	wp_nonce_field( 'bdk_photo_story_nonce_action', 'bdk_photo_story_nonce' );

	$gallery_images   = get_post_meta( $post->ID, '_bdk_gallery_images', true );
	$gallery_captions = get_post_meta( $post->ID, '_bdk_gallery_captions', true );
	if ( ! is_array( $gallery_captions ) ) {
		$gallery_captions = array();
	}

	$photographer = get_post_meta( $post->ID, '_bdk_photographer_name', true );
	$location     = get_post_meta( $post->ID, '_bdk_photo_location', true );
	?>
	<div style="padding: 10px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
		
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
			<div>
				<label style="font-weight: 600; display: block; margin-bottom: 5px;">📷 আলোকচিত্রীর নাম (Photographer):</label>
				<input type="text" name="bdk_photographer_name" value="<?php echo esc_attr( $photographer ); ?>" placeholder="যেমন: মো. সিফাত / স্টাফ ফটোসাংবাদিক" style="width: 100%; height: 38px; border-radius: 4px;">
			</div>
			<div>
				<label style="font-weight: 600; display: block; margin-bottom: 5px;">📍 ছবির স্থান / জেলা (Location):</label>
				<input type="text" name="bdk_photo_location" value="<?php echo esc_attr( $location ); ?>" placeholder="যেমন: সরিষাবাড়ী, জামালপুর / বান্দরবান" style="width: 100%; height: 38px; border-radius: 4px;">
			</div>
		</div>

		<div style="border-top: 1px solid #ddd; padding-top: 15px;">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
				<div>
					<h4 style="margin: 0; font-size: 15px; color: #0f172a;">📸 গ্যালারির ছবিসমূহ ও ক্যাপশন:</h4>
					<p style="color: #64748b; font-size: 12px; margin: 3px 0 0;">ছবি যোগ করার পর প্রতিটি ছবির পাশে সেই ছবিটি কিসের তার বিবরণ লিখে দিন।</p>
				</div>
				<button type="button" id="bdkUploadGalleryBtn" class="button button-primary" style="background: #006a4e; border-color: #00442b; padding: 6px 16px; font-weight: 600;">
					➕ ছবি যোগ করুন
				</button>
			</div>

			<div id="bdkPhotoGalleryRows" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 15px;">
				<?php
				if ( ! empty( $gallery_images ) ) {
					$img_ids = explode( ',', $gallery_images );
					$row_idx = 1;
					foreach ( $img_ids as $id ) {
						$src = wp_get_attachment_image_url( $id, 'medium' );
						$cap_val = isset( $gallery_captions[ $id ] ) ? $gallery_captions[ $id ] : wp_get_attachment_caption( $id );
						if ( $src ) {
							?>
							<div class="bdk-gallery-card-row" data-id="<?php echo esc_attr( $id ); ?>" style="display: flex; gap: 15px; align-items: center; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
								<div style="position: relative; width: 110px; height: 75px; border-radius: 6px; overflow: hidden; flex-shrink: 0; border: 1px solid #cbd5e1;">
									<img src="<?php echo esc_url( $src ); ?>" style="width: 100%; height: 100%; object-fit: cover;">
									<span style="position: absolute; bottom: 2px; left: 2px; background: rgba(0,0,0,0.7); color: #fff; font-size: 10px; padding: 1px 5px; border-radius: 3px;">ছবি #<?php echo $row_idx++; ?></span>
								</div>

								<div style="flex-grow: 1;">
									<label style="font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px;">
										✍️ ছবির বিবরণ / ক্যাপশন (এই ছবিটি কিসের?):
									</label>
									<input type="text" name="bdk_gallery_captions[<?php echo esc_attr( $id ); ?>]" value="<?php echo esc_attr( $cap_val ); ?>" placeholder="যেমন: সরিষাবাড়ীর চরাঞ্চলে কৃষকদের সোনালী আমন ধান কাটার মনোরম দৃশ্য" style="width: 100%; height: 36px; border-radius: 4px; border: 1px solid #94a3b8; padding: 0 10px;">
								</div>

								<button type="button" class="bdk-remove-gallery-img button" style="color: #e11d48; border-color: #fecdd3; padding: 4px 10px; font-size: 12px; height: 36px;">
									🗑️ মুছুন
								</button>
							</div>
							<?php
						}
					}
				}
				?>
			</div>

			<input type="hidden" name="bdk_gallery_images" id="bdkGalleryImagesInput" value="<?php echo esc_attr( $gallery_images ); ?>">
		</div>

	</div>

	<script>
	jQuery(document).ready(function($) {
		let mediaFrame;

		$('#bdkUploadGalleryBtn').on('click', function(e) {
			e.preventDefault();

			if (mediaFrame) {
				mediaFrame.open();
				return;
			}

			mediaFrame = wp.media({
				title: 'গ্যালারির জন্য ছবি নির্বাচন করুন',
				button: { text: 'গ্যালারিতে যুক্ত করুন' },
				multiple: true,
				library: { type: 'image' }
			});

			mediaFrame.on('select', function() {
				const attachments = mediaFrame.state().get('selection').toJSON();
				let currentIds = $('#bdkGalleryImagesInput').val() ? $('#bdkGalleryImagesInput').val().split(',') : [];

				attachments.forEach(function(att) {
					const idStr = att.id.toString();
					if (currentIds.indexOf(idStr) === -1) {
						currentIds.push(idStr);
						const thumbUrl = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
						const defaultCaption = att.caption || att.title || '';

						$('#bdkPhotoGalleryRows').append(
							'<div class="bdk-gallery-card-row" data-id="' + idStr + '" style="display: flex; gap: 15px; align-items: center; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">' +
								'<div style="position: relative; width: 110px; height: 75px; border-radius: 6px; overflow: hidden; flex-shrink: 0; border: 1px solid #cbd5e1;">' +
									'<img src="' + thumbUrl + '" style="width: 100%; height: 100%; object-fit: cover;">' +
								'</div>' +
								'<div style="flex-grow: 1;">' +
									'<label style="font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px;">✍️ ছবির বিবরণ / ক্যাপশন (এই ছবিটি কিসের?):</label>' +
									'<input type="text" name="bdk_gallery_captions[' + idStr + ']" value="' + defaultCaption + '" placeholder="যেমন: সরিষাবাড়ীর চরাঞ্চলে কৃষকদের সোনালী আমন ধান কাটার মনোরম দৃশ্য" style="width: 100%; height: 36px; border-radius: 4px; border: 1px solid #94a3b8; padding: 0 10px;">' +
								'</div>' +
								'<button type="button" class="bdk-remove-gallery-img button" style="color: #e11d48; border-color: #fecdd3; padding: 4px 10px; font-size: 12px; height: 36px;">🗑️ মুছুন</button>' +
							'</div>'
						);
					}
				});

				$('#bdkGalleryImagesInput').val(currentIds.join(','));
			});

			mediaFrame.open();
		});

		$(document).on('click', '.bdk-remove-gallery-img', function() {
			const row = $(this).closest('.bdk-gallery-card-row');
			const idToRemove = row.attr('data-id');
			let currentIds = $('#bdkGalleryImagesInput').val() ? $('#bdkGalleryImagesInput').val().split(',') : [];

			currentIds = currentIds.filter(id => id !== idToRemove);
			$('#bdkGalleryImagesInput').val(currentIds.join(','));
			row.remove();
		});
	});
	</script>
	<?php
}

/**
 * Save Photo Story Meta Box Data
 */
function bdk_save_photo_story_meta( $post_id ) {
	if ( ! isset( $_POST['bdk_photo_story_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_photo_story_nonce'], 'bdk_photo_story_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bdk_gallery_images'] ) ) {
		update_post_meta( $post_id, '_bdk_gallery_images', sanitize_text_field( $_POST['bdk_gallery_images'] ) );
	}

	if ( isset( $_POST['bdk_gallery_captions'] ) && is_array( $_POST['bdk_gallery_captions'] ) ) {
		$sanitized_captions = array();
		foreach ( $_POST['bdk_gallery_captions'] as $img_id => $cap ) {
			$sanitized_captions[ absint( $img_id ) ] = sanitize_text_field( $cap );
		}
		update_post_meta( $post_id, '_bdk_gallery_captions', $sanitized_captions );
	}

	if ( isset( $_POST['bdk_photographer_name'] ) ) {
		update_post_meta( $post_id, '_bdk_photographer_name', sanitize_text_field( $_POST['bdk_photographer_name'] ) );
	}

	if ( isset( $_POST['bdk_photo_location'] ) ) {
		update_post_meta( $post_id, '_bdk_photo_location', sanitize_text_field( $_POST['bdk_photo_location'] ) );
	}
}
add_action( 'save_post_bdk_photo_story', 'bdk_save_photo_story_meta' );
