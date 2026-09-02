<?php
/**
 * Custom Taxonomy: District & Division (জেলা ও উপজেলা সংবাদ)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register 'bdk_district' Taxonomy for Posts
 */
function bdk_register_district_taxonomy() {
	$labels = array(
		'name'              => 'জেলা ও উপজেলা',
		'singular_name'     => 'জেলা',
		'search_items'      => 'জেলা খুঁজুন',
		'all_items'         => 'সকল জেলা ও উপজেলা',
		'parent_item'       => 'বিভাগ / প্যারেন্ট জেলা',
		'parent_item_colon' => 'বিভাগ:',
		'edit_item'         => 'জেলা সম্পাদনা করুন',
		'update_item'       => 'জেলা আপডেট করুন',
		'add_new_item'      => 'নতুন জেলা / উপজেলা যোগ করুন',
		'new_item_name'     => 'নতুন জেলার নাম',
		'menu_name'         => 'জেলা ও উপজেলা (Districts)',
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'district', 'with_front' => false ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'bdk_district', array( 'post' ), $args );
}
add_action( 'init', 'bdk_register_district_taxonomy', 0 );

/**
 * Automatically Populate Bangladeshi Divisions and Key Districts
 */
function bdk_populate_default_districts() {
	if ( get_option( 'bdk_districts_populated_v1' ) ) {
		return;
	}

	$divisions_data = array(
		'ময়মনসিংহ ও জামালপুর' => array( 'সরিষাবাড়ী', 'জামালপুর সদর', 'ইসলামপুর', 'মেলান্দহ', 'বকশীগঞ্জ', 'মাদারগঞ্জ', 'দেওয়ানগঞ্জ', 'ময়মনসিংহ', 'শেরপুর', 'নেত্রকোণা' ),
		'ঢাকা বিভাগ'          => array( 'ঢাকা', 'গাজীপুর', 'নারায়ণগঞ্জ', 'টাঙ্গাইল', 'নরসিংদী', 'মুন্সীগঞ্জ', 'মানিকগঞ্জ', 'ফরিদপুর', 'কিশোরগঞ্জ' ),
		'চট্টগ্রাম বিভাগ'      => array( 'চট্টগ্রাম', 'কক্সবাজার', 'কুমিল্লা', 'ফেনী', 'নোয়াখালী', 'ব্রাহ্মণবাড়িয়া', 'চাঁদপুর', 'রাঙ্গামাটি', 'বান্দরবান' ),
		'রাজশাহী বিভাগ'        => array( 'রাজশাহী', 'বগুড়া', 'পাবনা', 'সিরাজগঞ্জ', 'নাটোর', 'নওগাঁ', 'চাঁপাইনবাবগঞ্জ', 'জয়পুরহাট' ),
		'সিলেট বিভাগ'          => array( 'সিলেট', 'মৌলভীবাজার', 'শ্রীমঙ্গল', 'সুনামগঞ্জ', 'হবিগঞ্জ' ),
		'খুলনা বিভাগ'          => array( 'খুলনা', 'যশোর', 'কুষ্টিয়া', 'বাগেরহাট', 'সাতক্ষীরা', 'ঝিনাইদহ', 'চুয়াডাঙ্গা' ),
		'বরিশাল বিভাগ'         => array( 'বরিশাল', 'পটুয়াখালী', 'ভোলা', 'পিরোজপুর', 'বরগুনা', 'ঝালকাঠি' ),
		'রংপুর বিভাগ'          => array( 'রংপুর', 'দিনাজপুর', 'কুড়িগ্রাম', 'গাইবান্ধা', 'লালমনিরহাট', 'নীলফামারী', 'পঞ্চগড়', 'ঠাকুরগাঁও' ),
	);

	foreach ( $divisions_data as $division_name => $districts ) {
		$parent_term = term_exists( $division_name, 'bdk_district' );
		if ( ! $parent_term ) {
			$parent_term = wp_insert_term( $division_name, 'bdk_district' );
		}
		$parent_id = is_array( $parent_term ) ? $parent_term['term_id'] : ( is_object( $parent_term ) ? $parent_term->term_id : 0 );

		if ( $parent_id ) {
			foreach ( $districts as $district_name ) {
				if ( ! term_exists( $district_name, 'bdk_district' ) ) {
					wp_insert_term( $district_name, 'bdk_district', array( 'parent' => $parent_id ) );
				}
			}
		}
	}

	update_option( 'bdk_districts_populated_v1', 1 );
}
add_action( 'init', 'bdk_populate_default_districts', 10 );

/**
 * Add Easy District Selector Meta Box on Post Edit Screen
 */
function bdk_add_district_meta_box() {
	add_meta_box(
		'bdk_district_select_box',
		'📍 জেলা ও উপজেলা নির্বাচন (সারাদেশের খবর)',
		'bdk_district_select_meta_box_callback',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bdk_add_district_meta_box' );

/**
 * Render District Dropdown Meta Box in Post Editor
 */
function bdk_district_select_meta_box_callback( $post ) {
	wp_nonce_field( 'bdk_district_nonce_action', 'bdk_district_nonce' );

	$current_terms = wp_get_object_terms( $post->ID, 'bdk_district', array( 'fields' => 'ids' ) );
	$selected_id   = ! empty( $current_terms ) ? $current_terms[0] : 0;

	$all_terms = get_terms( array(
		'taxonomy'   => 'bdk_district',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	?>
	<div style="padding: 5px 0;">
		<label style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px; color: #1e293b;">
			খবরের জেলা বা উপজেলা নির্ধারণ করুন:
		</label>
		<select name="bdk_selected_district_id" id="bdkSelectedDistrict" style="width: 100%; height: 38px; border-radius: 4px; border: 1px solid #cbd5e1;">
			<option value="0">-- জাতীয় সংবাদ / কোনো নির্দিষ্ট জেলা নেই --</option>
			<?php if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) ) : ?>
				<?php foreach ( $all_terms as $term ) : ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php selected( $selected_id, $term->term_id ); ?>>
						<?php echo ( $term->parent ? '↳ ' : '📌 ' ) . esc_html( $term->name ); ?>
					</option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<p style="font-size: 11px; color: #64748b; margin-top: 6px; line-height: 1.4;">
			জেলা নির্বাচন করলে খবরের কার্ডে জেলার লাল ব্যাজ ও সারাদেশ সেকশনে অটো শো করবে।
		</p>
	</div>
	<?php
}

/**
 * Save District Meta Box Selection
 */
function bdk_save_district_meta( $post_id ) {
	if ( ! isset( $_POST['bdk_district_nonce'] ) || ! wp_verify_nonce( $_POST['bdk_district_nonce'], 'bdk_district_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bdk_selected_district_id'] ) ) {
		$term_id = intval( $_POST['bdk_selected_district_id'] );
		if ( $term_id > 0 ) {
			wp_set_object_terms( $post_id, array( $term_id ), 'bdk_district' );
		} else {
			wp_set_object_terms( $post_id, array(), 'bdk_district' );
		}
	}
}
add_action( 'save_post', 'bdk_save_district_meta' );

/**
 * Helper function to get post district badge HTML
 */
function bdk_get_post_district_badge( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$terms = wp_get_object_terms( $post_id, 'bdk_district' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$term = $terms[0];
		$link = get_term_link( $term );
		return '<a href="' . esc_url( $link ) . '" class="district-badge-loc" style="position: absolute; top: 10px; left: 10px; z-index: 2; background: #e11d48; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; text-decoration: none;"><i class="fas fa-map-pin"></i> ' . esc_html( $term->name ) . '</a>';
	}
	return '';
}
