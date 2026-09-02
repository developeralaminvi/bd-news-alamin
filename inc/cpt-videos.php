<?php
/**
 * Video Custom Post Type & Meta Boxes
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Video Custom Post Type
 */
function bdk_register_video_cpt() {
	$labels = array(
		'name'                  => 'ভিডিও সংবাদ',
		'singular_name'         => 'ভিডিও সংবাদ',
		'menu_name'             => 'ভিডিও গ্যালারি',
		'name_admin_bar'        => 'ভিডিও সংবাদ',
		'add_new'               => 'নতুন ভিডিও যোগ করুন',
		'add_new_item'          => 'নতুন ভিডিও সংবাদ যোগ করুন',
		'new_item'              => 'নতুন ভিডিও',
		'edit_item'             => 'ভিডিও সম্পাদনা করুন',
		'view_item'             => 'ভিডিও দেখুন',
		'all_items'             => 'সব ভিডিও সংবাদ',
		'search_items'          => 'ভিডিও খুঁজুন',
		'not_found'             => 'কোনো ভিডিও পাওয়া যায়নি',
		'not_found_in_trash'    => 'ট্র্যাশে কোনো ভিডিও নেই',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'videos' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-video-alt3',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'bdk_video', $args );

	// Register Video Category Taxonomy
	$tax_labels = array(
		'name'          => 'ভিডিও ক্যাটাগরি',
		'singular_name' => 'ভিডিও ক্যাটাগরি',
		'search_items'  => 'ক্যাটাগরি খুঁজুন',
		'all_items'     => 'সকল ক্যাটাগরি',
		'edit_item'     => 'ক্যাটাগরি সম্পাদনা',
		'add_new_item'  => 'নতুন ক্যাটাগরি যোগ করুন',
	);

	register_taxonomy( 'bdk_video_cat', array( 'bdk_video' ), array(
		'hierarchical'      => true,
		'labels'            => $tax_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'video-category' ),
		'show_in_rest'      => true,
	) );
}
add_action( 'init', 'bdk_register_video_cpt' );

/**
 * Add Meta Box for Video Settings
 */
function bdk_video_meta_boxes() {
	add_meta_box(
		'bdk_video_details',
		'ভিডিও সেটিংস (YouTube / Media)',
		'bdk_video_meta_box_callback',
		'bdk_video',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bdk_video_meta_boxes' );

function bdk_video_meta_box_callback( $post ) {
	wp_nonce_field( 'bdk_video_save_meta', 'bdk_video_meta_nonce' );

	$youtube_url = get_post_meta( $post->ID, '_bdk_youtube_url', true );
	$duration    = get_post_meta( $post->ID, '_bdk_video_duration', true );
	$custom_file = get_post_meta( $post->ID, '_bdk_custom_video_file', true );
	$is_featured = get_post_meta( $post->ID, '_bdk_is_featured_video', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="bdk_youtube_url">YouTube ভিডিও লিংক / Video ID:</label></th>
			<td>
				<input type="text" id="bdk_youtube_url" name="bdk_youtube_url" value="<?php echo esc_attr( $youtube_url ); ?>" class="regular-text" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ অথবা dQw4w9WgXcQ">
				<p class="description">YouTube সম্পূর্ণ লিংক বা ১১ সংখ্যার ভিডিও আইডি লিখুন।</p>
			</td>
		</tr>
		<tr>
			<th><label for="bdk_video_duration">ভিডিওর সময়কাল (Duration):</label></th>
			<td>
				<input type="text" id="bdk_video_duration" name="bdk_video_duration" value="<?php echo esc_attr( $duration ); ?>" class="regular-text" placeholder="০৮:৪৫ মিনিট">
			</td>
		</tr>
		<tr>
			<th><label for="bdk_custom_video_file">মিডিয়া লাইব্রেরি ভিডিও ফাইল (MP4):</label></th>
			<td>
				<input type="text" id="bdk_custom_video_file" name="bdk_custom_video_file" value="<?php echo esc_url( $custom_file ); ?>" class="regular-text" placeholder="https://domain.com/video.mp4">
				<p class="description">(ঐচ্ছিক) যদি সরাসরি সার্ভার থেকে ভিডিও চালাতে চান।</p>
			</td>
		</tr>
		<tr>
			<th><label for="bdk_is_featured_video">প্রধান হাইলাইট ভিডিও?</label></th>
			<td>
				<input type="checkbox" id="bdk_is_featured_video" name="bdk_is_featured_video" value="1" <?php checked( $is_featured, '1' ); ?>>
				<span>হোম পেজের ভিডিও সেকশনে বড় প্লেয়ারে প্রধান ভিডিও হিসেবে দেখান</span>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Save Video Meta Data
 */
function bdk_save_video_meta_data( $post_id ) {
	if ( ! isset( $_POST['bdk_video_meta_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_video_meta_nonce'], 'bdk_video_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bdk_youtube_url'] ) ) {
		$url = sanitize_text_field( $_POST['bdk_youtube_url'] );
		// Extract 11 char ID if full url given
		if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
			$video_id = $match[1];
		} else {
			$video_id = $url;
		}
		update_post_meta( $post_id, '_bdk_youtube_url', $video_id );
	}

	if ( isset( $_POST['bdk_video_duration'] ) ) {
		update_post_meta( $post_id, '_bdk_video_duration', sanitize_text_field( $_POST['bdk_video_duration'] ) );
	}

	if ( isset( $_POST['bdk_custom_video_file'] ) ) {
		update_post_meta( $post_id, '_bdk_custom_video_file', esc_url_raw( $_POST['bdk_custom_video_file'] ) );
	}

	$is_feat = isset( $_POST['bdk_is_featured_video'] ) ? '1' : '0';
	update_post_meta( $post_id, '_bdk_is_featured_video', $is_feat );
}
add_action( 'save_post_bdk_video', 'bdk_save_video_meta_data' );
