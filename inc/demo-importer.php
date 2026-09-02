<?php
/**
 * 1-Click Demo Data Importer for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Admin Menu for Demo Importer
 */
function bdk_demo_importer_menu() {
	add_theme_page(
		'ডেমো ইমপোর্ট (Demo Importer)',
		'ডেমো ইমপোর্ট',
		'manage_options',
		'bdk-demo-importer',
		'bdk_demo_importer_page_callback'
	);
}
add_action( 'admin_menu', 'bdk_demo_importer_menu' );

/**
 * Render Demo Importer Admin Page
 */
function bdk_demo_importer_page_callback() {
	?>
	<div class="wrap" style="max-width: 900px; margin-top: 20px; font-family: 'Hind Siliguri', sans-serif;">
		<div style="background: #ffffff; border: 1px solid #ccd0d4; border-radius: 12px; padding: 25px 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
			
			<div style="display: flex; align-items: center; gap: 15px; border-bottom: 2px solid #006a4e; padding-bottom: 15px; margin-bottom: 20px;">
				<div style="background: #006a4e; color: #fff; width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
					📥
				</div>
				<div>
					<h1 style="margin: 0; font-size: 22px; color: #006a4e; font-weight: 700;">দৈনিক বাংলাদেশের কথা - ১-ক্লিক ডেমো ইমপোর্টার</h1>
					<p style="margin: 3px 0 0; color: #64748b; font-size: 14px;">এক ক্লিকেই তৈরি করুন সকল নিউজ পোস্ট, ভিডিও, পেজ (সঠিক টেমপ্লেট সহ) এবং মেনুবার।</p>
				</div>
			</div>

			<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
				<h3 style="margin-top: 0; color: #1e293b; font-size: 16px;">📦 ডেমো ইমপোর্টে যা যা স্বয়ংক্রিয়ভাবে তৈরি হবে:</h3>
				<ul style="list-style: disc; margin-left: 20px; color: #475569; font-size: 14px; line-height: 1.8;">
					<li><strong>সকল ক্যাটাগরি:</strong> জাতীয়, রাজনীতি, সারাদেশে, অর্থনীতি, আন্তর্জাতিক, খেলাধুলা, বিনোদন, তথ্যপ্রযুক্তি, মতামত, ছবির গল্প, অনুসন্ধান।</li>
					<li><strong>প্রয়োজনীয় পেজসমূহ (সঠিক টেমপ্লেট সহ):</strong>
						<ul style="list-style: circle; margin-left: 20px; margin-top: 5px;">
							<li><em>আমাদের সম্পর্কে (About Us)</em> — টেমপ্লেট: <code>page-about.php</code></li>
							<li><em>যোগাযোগ ও বিজ্ঞাপন (Contact & Advertising)</em> — টেমপ্লেট: <code>page-contact.php</code></li>
							<li><em>প্রতিনিধি আবেদন (Career / Application)</em> — টেমপ্লেট: <code>page-career.php</code></li>
							<li><em>গোপনীয়তা নীতি (Privacy Policy)</em> — স্ট্যান্ডার্ড পলিসি কনটেন্ট</li>
							<li><em>ব্যবহারের শর্তাবলী (Terms of Use)</em> — টার্মস কনটেন্ট</li>
							<li><em>কুকি পলিসি (Cookies Policy)</em> — কুকি পলিসি কনটেন্ট</li>
						</ul>
					</li>
					<li><strong>২০+ আকর্ষণীয় ডেমো সংবাদ:</strong> বাংলা শিরোনাম, ছবি, এক্সার্প্ট ও রিচ কন্টেন্ট সহ।</li>
					<li><strong>৫+ ভিডিও সংবাদ (Video CPT):</strong> ইউটিউব ভিডিও আইডি ও সময়কাল সহ।</li>
					<li><strong>নেভিগেশন মেনুবার:</strong> Primary Menu, Topbar Menu ও Footer Menu স্বয়ংক্রিয়ভাবে তৈরি ও লিঙ্ক করা।</li>
				</ul>
			</div>

			<div id="demoImportStatus" style="display: none; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600;"></div>

			<div style="display: flex; align-items: center; gap: 15px;">
				<button type="button" id="startDemoImportBtn" class="button button-primary button-hero" style="background: #006a4e; border-color: #00442b; border-radius: 8px; font-size: 16px; padding: 8px 24px;">
					🚀 এখনই ডেমো ইমপোর্ট শুরু করুন
				</button>
				<span id="importSpinner" class="spinner" style="float: none; margin: 0;"></span>
			</div>

		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		$('#startDemoImportBtn').on('click', function(e) {
			e.preventDefault();
			
			if (!confirm('আপনি কি নিশ্চিত যে ডেমো কনটেন্ট ইমপোর্ট করতে চান? এটি আপনার সাইটে নতুন পেজ, পোস্ট, ক্যাটাগরি ও মেনু যোগ করবে।')) {
				return;
			}

			const btn = $(this);
			const spinner = $('#importSpinner');
			const status = $('#demoImportStatus');

			btn.prop('disabled', true).text('⏳ ডেমো ইমপোর্ট হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন...');
			spinner.addClass('is-active');
			status.hide().removeClass('notice notice-success notice-error');

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'bdk_run_demo_import',
					nonce: '<?php echo wp_create_nonce( "bdk_demo_import_nonce" ); ?>'
				},
				success: function(res) {
					spinner.removeClass('is-active');
					btn.prop('disabled', false).text('🚀 পুনরায় ডেমো ইমপোর্ট করুন');
					
					if (res.success) {
						status.css({'background': '#dcfce7', 'color': '#166534', 'border': '1px solid #86efac'})
							  .html('🎉 ' + res.data.message)
							  .show();
					} else {
						status.css({'background': '#fee2e2', 'color': '#991b1b', 'border': '1px solid #fca5a5'})
							  .html('❌ ত্রুটি: ' + (res.data ? res.data : 'ইমপোর্ট সম্পন্ন করা যায়নি।'))
							  .show();
					}
				},
				error: function() {
					spinner.removeClass('is-active');
					btn.prop('disabled', false).text('🚀 পুনরায় চেষ্টা করুন');
					status.css({'background': '#fee2e2', 'color': '#991b1b', 'border': '1px solid #fca5a5'})
						  .html('❌ সার্ভার রেসপন্সে সমস্যা হয়েছে। পুনরায় চেষ্টা করুন।')
						  .show();
				}
			});
		});
	});
	</script>
	<?php
}

/**
 * AJAX Handler to Run Demo Import
 */
function bdk_run_demo_import_ajax() {
	check_ajax_referer( 'bdk_demo_import_nonce', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( 'অনুমতি নেই।' );
	}

	// 1. Create Categories
	$categories_data = array(
		'national'          => 'জাতীয়',
		'politics'          => 'রাজনীতি',
		'international'     => 'আন্তর্জাতিক',
		'saradesh'          => 'সারাদেশ',

		// Sports & Sub-categories
		'sports'            => 'খেলাধুলা',
		'cricket'           => 'ক্রিকেট',
		'football'          => 'ফুটবল',
		'tennis'            => 'টেনিস',
		'olympics'          => 'অলিম্পিক',
		'local-sports'      => 'স্থানীয় খেলাধুলা',

		// Other & Sub-categories
		'other'             => 'অন্যান্য',
		'economy-trade'     => 'অর্থ ও বাণিজ্য',
		'tech'              => 'বিজ্ঞান ও প্রযুক্তি',
		'entertainment'     => 'বিনোদন',
		'agriculture'       => 'কৃষি ও গ্রামীণ জীবন',
		'jobs-career'       => 'চাকরি ও ক্যারিয়ার',
		'education'         => 'শিক্ষা',
		'art-culture'       => 'শিল্প ও সংস্কৃতি',
		'literature'        => 'সাহিত্য ও দেওয়ালিকা',
		'talent-search'     => 'প্রতিভার অন্বেষণ',
		'health-medical'    => 'স্বাস্থ্য ও চিকিৎসা',
		'editorial-opinion' => 'সম্পাদকীয় ও মতামত',

		// Additional demo categories
		'photo'             => 'ছবির গল্প',
		'investigation'     => 'বিশেষ অনুসন্ধান',
	);

	$category_parents = array(
		'cricket'           => 'sports',
		'football'          => 'sports',
		'tennis'            => 'sports',
		'olympics'          => 'sports',
		'local-sports'      => 'sports',
		'economy-trade'     => 'other',
		'tech'              => 'other',
		'entertainment'     => 'other',
		'agriculture'       => 'other',
		'jobs-career'       => 'other',
		'education'         => 'other',
		'art-culture'       => 'other',
		'literature'        => 'other',
		'talent-search'     => 'other',
		'health-medical'    => 'other',
		'editorial-opinion' => 'other',
	);

	$cat_ids = array();
	foreach ( $categories_data as $slug => $name ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		$parent_id = 0;
		if ( isset( $category_parents[ $slug ] ) && isset( $cat_ids[ $category_parents[ $slug ] ] ) ) {
			$parent_id = $cat_ids[ $category_parents[ $slug ] ];
		}

		if ( ! $term ) {
			$new_term = wp_insert_term( $name, 'category', array( 'slug' => $slug, 'parent' => $parent_id ) );
			if ( ! is_wp_error( $new_term ) ) {
				$cat_ids[ $slug ] = $new_term['term_id'];
			}
		} else {
			$cat_ids[ $slug ] = $term->term_id;
			if ( $parent_id && ! $term->parent ) {
				wp_update_term( $term->term_id, 'category', array( 'parent' => $parent_id ) );
			}
		}
	}

	// 2. Create Static Pages with Templates
	$pages_data = array(
		array(
			'title'    => 'আমাদের সম্পর্কে',
			'slug'     => 'about',
			'template' => 'page-about.php',
			'content'  => 'দৈনিক বাংলাদেশের কথা একটি স্বাধীন, বস্তুনিষ্ঠ ও উন্নয়নমুখী জাতীয় অনলাইন গণমাধ্যম।',
		),
		array(
			'title'    => 'যোগাযোগ ও বিজ্ঞাপন',
			'slug'     => 'contact',
			'template' => 'page-contact.php',
			'content'  => 'বিজ্ঞাপন ও খবরের জন্য আমাদের সাথে যোগাযোগ করুন।',
		),
		array(
			'title'    => 'প্রতিনিধি আবেদন (ক্যারিয়ার)',
			'slug'     => 'career',
			'template' => 'page-career.php',
			'content'  => 'সারা দেশে জেলা ও উপজেলা পর্যায়ে দক্ষ প্রতিনিধি নিয়োগ চলছে।',
		),
		array(
			'title'    => 'গোপনীয়তা নীতি',
			'slug'     => 'privacy-policy',
			'template' => 'page-privacy-policy.php',
			'content'  => 'পাঠকদের ব্যক্তিগত তথ্যের সর্বোচ্চ সুরক্ষা এবং নিরাপদ ব্রাউজিং অভিজ্ঞতায় আমাদের দায়বদ্ধতা।',
		),
		array(
			'title'    => 'ব্যবহারের শর্তাবলী',
			'slug'     => 'terms',
			'template' => 'page-terms.php',
			'content'  => 'দৈনিক বাংলাদেশের কথা পোর্টাল ব্যবহারের সাধারণ নিয়মাবলী ও কপিরাইট শর্তাবলী।',
		),
		array(
			'title'    => 'মতামত ও পাঠকদের প্রতিক্রিয়া',
			'slug'     => 'opinions',
			'template' => 'page-opinions.php',
			'content'  => 'পাঠকদের মূল্যবান গঠনমূলক মন্তব্য, সম্পাদকীয় পর্যালোচনা ও মুক্ত আলোচনা।',
		),
		array(
			'title'    => 'কুকি পলিসি',
			'slug'     => 'cookies',
			'template' => 'page-cookies.php',
			'content'  => 'আমাদের ওয়েবসাইট ব্যবহারের সময় কুকিজ কীভাবে আপনার ব্রাউজিং অভিজ্ঞতা আরও দ্রুত ও সহজ করে।',
		),
	);

	foreach ( $pages_data as $p ) {
		$existing_page = get_page_by_path( $p['slug'] );
		if ( ! $existing_page ) {
			$page_id = wp_insert_post( array(
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_content' => $p['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
			) );

			if ( $page_id && ! is_wp_error( $page_id ) && 'default' !== $p['template'] ) {
				update_post_meta( $page_id, '_wp_page_template', $p['template'] );
			}
		} else {
			if ( 'default' !== $p['template'] ) {
				update_post_meta( $existing_page->ID, '_wp_page_template', $p['template'] );
			}
		}
	}

	// 3. Create Demo News Posts
	$demo_posts = array(
		array(
			'title'    => 'কৃষি ও খাদ্য উৎপাদনে স্বয়ংসম্পূর্ণতা অর্জনে সারা দেশে আধুনিক প্রযুক্তির প্রসার',
			'cat'      => 'national',
			'excerpt'  => 'কৃষি রূপান্তরে আধুনিক ড্রোন ও সেচ প্রযুক্তির সফল বাস্তবায়নে ফসলের ফলন দ্বিগুণ হয়েছে।',
		),
		array(
			'title'    => 'তৈরি পোশাক ও চামড়াশিল্পে নতুন বাজার সৃষ্টিতে ইউরোপীয় ইউনিয়নের সাথে বড় সমঝোতা',
			'cat'      => 'economy',
			'excerpt'  => 'শুল্কমুক্ত রপ্তানি সুবিধা অব্যাহত রাখার পাশাপাশি ক্ষুদ্র ও মাঝারি উদ্যোক্তাদের বিশেষ ঋণ সহায়তা।',
		),
		array(
			'title'    => 'হোয়াইট হাউসে বৈশ্বিক জলবায়ু নিরাপত্তা ও কার্বন কর নিয়ে ঐতিহাসিক সমঝোতা চুক্তি',
			'cat'      => 'international',
			'excerpt'  => 'উন্নত দেশগুলোর সাথে উন্নয়নশীল দেশসমূহের যৌথ তহবিল গঠনে সম্মত হয়েছেন বিশ্বনেতারা।',
		),
		array(
			'title'    => 'সরিষাবাড়ীতে কৃষক সমাবেশে উন্নত জাতের আমন ধানের বীজ বিতরণ ও প্রণোদনা',
			'cat'      => 'saradesh',
			'excerpt'  => 'জামালপুরের সরিষাবাড়ী উপজেলায় চরাঞ্চলের কৃষকদের মাঝে বিনামূল্যে উচ্চফলনশীল বীজ বিতরণ করা হয়েছে।',
		),
		array(
			'title'    => 'যমুনার অববাহিকায় নদীভাঙন রোধে আধুনিক ড্রেজিং গবেষণার আদ্যোপান্ত',
			'cat'      => 'investigation',
			'excerpt'  => 'চরের কৃষকদের জীবনযুদ্ধ ও ভূগর্ভস্থ সম্পদের সঠিক ব্যবহারে বিশেষজ্ঞদের দীর্ঘ অনুসন্ধানী বিশ্লেষণ।',
		),
		array(
			'title'    => 'মাঠের লড়াইয়ে নতুন কৌশলে জয়ের আনন্দে টাইগাররা',
			'cat'      => 'sports',
			'excerpt'  => 'অলরাউন্ডারদের নৈপুণ্যে ও টিমওয়ার্কে সিরিজ জয়ে ক্রিকেটপ্রেমীদের মাঝে বাঁধভাঙা উচ্ছ্বাস।',
		),
		array(
			'title'    => 'চ্যাটজিপিটি ও জেনারেটিভ এআই দিয়ে সংবাদ প্রক্রিয়াকরণে নতুন বিপ্লব',
			'cat'      => 'tech',
			'excerpt'  => 'কৃত্রিম বুদ্ধিমত্তা ও ভাষা মডেল ব্যবহারে বাংলা গণমাধ্যমে আসছে অভাবনীয় গতি ও নির্ভুলতা।',
		),
		array(
			'title'    => 'আন্তর্জাতিক চলচ্চিত্র উৎসবে দেশের তরুণ পরিচালকের নির্মিত তথ্যচিত্রের ব্যাপক প্রশংসা',
			'cat'      => 'entertainment',
			'excerpt'  => 'তৃণমূলের গল্প ও নান্দনিক চিত্রগ্রহণে কান চলচ্চিত্র উৎসবে বিশেষ জুরি পুরস্কার অর্জন।',
		),
		array(
			'title'    => 'বস্তুনিষ্ঠ সাংবাদিকতা কোনো আপসের জায়গা নয়; সত্য প্রকাশের সাহসই জাতির আসল শক্তি',
			'cat'      => 'opinion',
			'excerpt'  => 'স্বাধীন মতপ্রকাশ ও গণমানুষের অধিকার আদায়ে গণমাধ্যমের নৈতিক দায়িত্ব অপরিসীম।',
		),
		array(
			'title'    => 'বান্দরবানের মেঘের দেশে কম খরচে রোমাঞ্চকর উইকএন্ড ভ্রমণ গাইড',
			'cat'      => 'entertainment',
			'excerpt'  => 'সবুজ পাহাড়, ঝর্ণা ও আদিবাসী সংস্কৃতির অপূর্ব মেলবন্ধনে সাজানো নতুন ভ্রমণ পরিকল্পনা।',
		),
	);

	foreach ( $demo_posts as $dp ) {
		$cat_id = isset( $cat_ids[ $dp['cat'] ] ) ? array( $cat_ids[ $dp['cat'] ] ) : array();
		
		$post_id = wp_insert_post( array(
			'post_title'   => $dp['title'],
			'post_content' => '<p>' . $dp['excerpt'] . '</p><p>দেশের শীর্ষস্থানীয় সাংবাদিক ও অর্থনীতিবিদদের পর্যালোচনায় উঠে এসেছে টেকসই উন্নয়নের নতুন দিকনির্দেশনা। তৃণমূল পর্যায়ে আধুনিক প্রযুক্তির বিস্তার ও সরকারি-বেসরকারি যৌথ উদ্যোগেই কেবল অর্থনৈতিক ও সামাজিক সাম্য নিশ্চিত করা সম্ভব।</p><blockquote>"সত্যের সন্ধানে এবং ন্যায়ের পক্ষে অবিচল থেকে গণমানুষের কণ্ঠস্বর হওয়াই সাংবাদিকতার মূল লক্ষ্য।"</blockquote><p>আগামী প্রজন্মের জন্য একটি সমৃদ্ধ, টেকসই এবং নিরাপদ বাংলাদেশ বিনির্মাণে গণমাধ্যমের ভূমিকা অনস্বীকার্য।</p>',
			'post_excerpt' => $dp['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_category'=> $cat_id,
		) );

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, 'bdk_post_views_count', rand( 25, 450 ) );
		}
	}

	// 4. Create Demo Video Posts
	$demo_videos = array(
		array(
			'title'    => 'সমসাময়িক রাজনীতি ও অর্থনীতির আগামী দিনের চ্যালেঞ্জ | দৈনিক বাংলাদেশের কথা বিশ্লেষণ',
			'yt_id'    => 'dQw4w9WgXcQ',
			'duration' => '১৫:২০ মিনিট',
			'featured' => '1',
		),
		array(
			'title'    => 'ডিজিটাল গণমাধ্যমের ভবিষ্যৎ ও বিশ্বাসযোগ্যতা রক্ষা',
			'yt_id'    => 'dQw4w9WgXcQ',
			'duration' => '০৮:৪৫ মিনিট',
			'featured' => '0',
		),
		array(
			'title'    => 'কৃত্রিম উপগ্রহ উৎক্ষেপণে বিজ্ঞানীদের অক্লান্ত পরিশ্রমের গল্প',
			'yt_id'    => 'dQw4w9WgXcQ',
			'duration' => '১২:২০ মিনিট',
			'featured' => '0',
		),
		array(
			'title'    => 'জামালপুরের ঐতিহাসিক পুরাকীর্তি ও পর্যটন সম্ভাবনা',
			'yt_id'    => 'dQw4w9WgXcQ',
			'duration' => '১০:১৫ মিনিট',
			'featured' => '0',
		),
	);

	foreach ( $demo_videos as $dv ) {
		$v_id = wp_insert_post( array(
			'post_title'   => $dv['title'],
			'post_content' => '<p>দৈনিক বাংলাদেশের কথা বিশেষ ভিডিও বুলেটিন ও বিশ্লেষণ।</p>',
			'post_status'  => 'publish',
			'post_type'    => 'bdk_video',
		) );

		if ( $v_id && ! is_wp_error( $v_id ) ) {
			update_post_meta( $v_id, '_bdk_youtube_url', $dv['yt_id'] );
			update_post_meta( $v_id, '_bdk_video_duration', $dv['duration'] );
			update_post_meta( $v_id, '_bdk_is_featured_video', $dv['featured'] );
		}
	}

	// 4.1 Create Demo Photo Stories
	$demo_photo_stories = array(
		array(
			'title'        => 'বর্ষায় বাংলার হাওর ও নদী তটভূমির অপরূপ রূপ',
			'photographer' => 'মো. সিফাত (বিশেষ ফটোসাংবাদিক)',
			'location'     => 'শ্রীমঙ্গল ও সুনামগঞ্জ',
			'content'      => '<p>বর্ষা মৌসুমে বাংলার রূপ যেন নবযৌবন ফিরে পায়। হাওরের বুক চিরে বয়ে চলা শান্ত ঢেউ ও সবুজ প্রকৃতির অনন্য কোলাজ নিয়ে বিশেষ ফটো ফিচার।</p>',
		),
		array(
			'title'        => 'কৃষকের সোনালী হাসি ও নতুন আমন ধান কাটার নবান্ন উৎসব',
			'photographer' => 'ছামিউল ইসলাম রিপন',
			'location'     => 'সরিষাবাড়ী, জামালপুর',
			'content'      => '<p>মাঠভরা সোনালী ফসল আর কৃষকদের নবান্ন উৎসবের আনন্দঘন মুহূর্তগুলো ক্যামেরাবন্দী করেছেন আমাদের নিজস্ব আলোকচিত্রী।</p>',
		),
		array(
			'title'        => 'জাতীয় নাট্যোৎসবে আদিবাসী নৃত্যশিল্পীদের অপূর্ব সাংস্কৃতিক সন্ধ্যা',
			'photographer' => 'স্টাফ ফটোগ্রাফার',
			'location'     => 'শিল্পকলা একাডেমি, ঢাকা',
			'content'      => '<p>ঐতিহ্যবাহী পোশাক আর ছন্দের অপূর্ব মেলবন্ধনে জাতীয় নাট্যোৎসবের জমকালো মঞ্চ মাতালেন শিল্পীরা।</p>',
		),
	);

	foreach ( $demo_photo_stories as $dps ) {
		$ps_id = wp_insert_post( array(
			'post_title'   => $dps['title'],
			'post_content' => $dps['content'],
			'post_status'  => 'publish',
			'post_type'    => 'bdk_photo_story',
		) );

		if ( $ps_id && ! is_wp_error( $ps_id ) ) {
			update_post_meta( $ps_id, '_bdk_photographer_name', $dps['photographer'] );
			update_post_meta( $ps_id, '_bdk_photo_location', $dps['location'] );
		}
	}

	// 4.2 Add Sample Reader Comments on Demo Posts (for Opinions & Comments Section)
	$all_demo_posts = get_posts( array( 'post_type' => 'post', 'numberposts' => 4, 'orderby' => 'date', 'order' => 'DESC' ) );
	if ( ! empty( $all_demo_posts ) ) {
		$sample_comments = array(
			array(
				'author'  => 'মো. রফিকুল ইসলাম',
				'email'   => 'rafiq@example.com',
				'content' => 'কৃষি ও খাদ্য উৎপাদনে আধুনিক প্রযুক্তির ব্যবহার সত্যিই প্রশংসনীয়। প্রান্তিক কৃষকদের সঠিক সময়ে প্রশিক্ষণ ও সহায়তা দিলে উৎপাদন আরও বহুগুণ বৃদ্ধি পাবে।',
			),
			array(
				'author'  => 'ড. তানজিলা আহমেদ',
				'email'   => 'tanjila@example.com',
				'content' => 'অর্থনৈতিক স্থিতিশীলতার জন্য ক্ষুদ্র ও মাঝারি শিল্পকে অগ্রাধিকার দেওয়া জরুরি। চমৎকার ও গঠনমূলক সংবাদ পরিবেশনের জন্য ধন্যবাদ।',
			),
			array(
				'author'  => 'মাহমুদুল হাসান',
				'email'   => 'mahmud@example.com',
				'content' => 'চরাঞ্চলের নদীভাঙন রোধে স্থায়ী ড্রেজিং ও বাঁধ নির্মাণ এখন সময়ের দাবি। বিষয়টি গুরুত্ব দিয়ে তুলে ধরার জন্য দৈনিক বাংলাদেশের কথাকে সাধুবাদ জানাই।',
			),
		);

		foreach ( $sample_comments as $idx => $sc ) {
			$target_post = isset( $all_demo_posts[ $idx ] ) ? $all_demo_posts[ $idx ] : $all_demo_posts[0];
			
			// Check if comment already exists
			$existing_cmts = get_comments( array( 'post_id' => $target_post->ID, 'author_email' => $sc['email'] ) );
			if ( empty( $existing_cmts ) ) {
				wp_insert_comment( array(
					'comment_post_ID'      => $target_post->ID,
					'comment_author'       => $sc['author'],
					'comment_author_email' => $sc['email'],
					'comment_content'      => $sc['content'],
					'comment_type'         => 'comment',
					'comment_approved'     => 1,
					'comment_date'         => current_time( 'mysql' ),
				) );
			}
		}
	}

	// 5. Setup Navigation Menus (Primary, Footer Categories, Footer Legal)
	$locations = get_theme_mod( 'nav_menu_locations', array() );

	// 5.1 Primary Header Menu
	$primary_menu_name = 'Main Navigation Menu';
	$primary_menu      = wp_get_nav_menu_object( $primary_menu_name );
	if ( $primary_menu ) {
		wp_delete_nav_menu( $primary_menu->term_id );
	}

	$menu_id = wp_create_nav_menu( $primary_menu_name );
	if ( ! is_wp_error( $menu_id ) ) {
		// 1. National
		if ( isset( $cat_ids['national'] ) ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => 'জাতীয়',
				'menu-item-object'    => 'category',
				'menu-item-object-id' => $cat_ids['national'],
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			) );
		}

		// 2. Politics
		if ( isset( $cat_ids['politics'] ) ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => 'রাজনীতি',
				'menu-item-object'    => 'category',
				'menu-item-object-id' => $cat_ids['politics'],
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			) );
		}

		// 3. International
		if ( isset( $cat_ids['international'] ) ) {
			wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => 'আন্তর্জাতিক',
				'menu-item-object'    => 'category',
				'menu-item-object-id' => $cat_ids['international'],
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			) );
		}

		// 4. Sports (Parent)
		if ( isset( $cat_ids['sports'] ) ) {
			$sports_item_id = wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => 'খেলাধুলা',
				'menu-item-object'    => 'category',
				'menu-item-object-id' => $cat_ids['sports'],
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			) );

			$sports_subs = array(
				'cricket'      => 'ক্রিকেট',
				'football'     => 'ফুটবল',
				'tennis'       => 'টেনিস',
				'olympics'     => 'অলিম্পিক',
				'local-sports' => 'স্থানীয় খেলাধুলা',
			);
			foreach ( $sports_subs as $s_slug => $s_name ) {
				if ( isset( $cat_ids[ $s_slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'       => $s_name,
						'menu-item-object'      => 'category',
						'menu-item-object-id'   => $cat_ids[ $s_slug ],
						'menu-item-type'        => 'taxonomy',
						'menu-item-status'      => 'publish',
						'menu-item-parent-id'   => $sports_item_id,
					) );
				}
			}
		}

		// 5. Other (Parent Dropdown)
		if ( isset( $cat_ids['other'] ) ) {
			$other_item_id = wp_update_nav_menu_item( $menu_id, 0, array(
				'menu-item-title'     => 'অন্যান্য',
				'menu-item-object'    => 'category',
				'menu-item-object-id' => $cat_ids['other'],
				'menu-item-type'      => 'taxonomy',
				'menu-item-status'    => 'publish',
			) );

			$other_subs = array(
				'economy-trade'     => 'অর্থ ও বাণিজ্য',
				'tech'              => 'বিজ্ঞান ও প্রযুক্তি',
				'entertainment'     => 'বিনোদন',
				'agriculture'       => 'কৃষি ও গ্রামীণ জীবন',
				'jobs-career'       => 'চাকরি ও ক্যারিয়ার',
				'education'         => 'শিক্ষা',
				'art-culture'       => 'শিল্প ও সংস্কৃতি',
				'literature'        => 'সাহিত্য ও দেওয়ালিকা',
				'talent-search'     => 'প্রতিভার অন্বেষণ',
				'health-medical'    => 'স্বাস্থ্য ও চিকিৎসা',
				'editorial-opinion' => 'সম্পাদকীয় ও মতামত',
			);
			foreach ( $other_subs as $o_slug => $o_name ) {
				if ( isset( $cat_ids[ $o_slug ] ) ) {
					wp_update_nav_menu_item( $menu_id, 0, array(
						'menu-item-title'       => $o_name,
						'menu-item-object'      => 'category',
						'menu-item-object-id'   => $cat_ids[ $o_slug ],
						'menu-item-type'        => 'taxonomy',
						'menu-item-status'      => 'publish',
						'menu-item-parent-id'   => $other_item_id,
					) );
				}
			}
		}

		$locations['primary'] = $menu_id;
		$locations['topbar']  = $menu_id;
	}

	// 5.2 Footer Categories Menu
	$footer_cat_name = 'Footer Categories Menu';
	$footer_cat_menu = wp_get_nav_menu_object( $footer_cat_name );
	if ( ! $footer_cat_menu ) {
		$f_menu_id = wp_create_nav_menu( $footer_cat_name );
		if ( ! is_wp_error( $f_menu_id ) ) {
			foreach ( array( 'national', 'saradesh', 'economy', 'international', 'sports', 'entertainment', 'opinion' ) as $slug ) {
				if ( isset( $cat_ids[ $slug ] ) ) {
					wp_update_nav_menu_item( $f_menu_id, 0, array(
						'menu-item-title'     => $categories_data[ $slug ],
						'menu-item-object'    => 'category',
						'menu-item-object-id' => $cat_ids[ $slug ],
						'menu-item-type'      => 'taxonomy',
						'menu-item-status'    => 'publish',
					) );
				}
			}
			$locations['footer_categories'] = $f_menu_id;
		}
	}

	// 5.3 Footer Legal Pages Menu
	$footer_legal_name = 'Footer Legal Menu';
	$footer_legal_menu = wp_get_nav_menu_object( $footer_legal_name );
	if ( ! $footer_legal_menu ) {
		$fl_menu_id = wp_create_nav_menu( $footer_legal_name );
		if ( ! is_wp_error( $fl_menu_id ) ) {
			foreach ( $pages_data as $p ) {
				$page_obj = get_page_by_path( $p['slug'] );
				if ( $page_obj ) {
					wp_update_nav_menu_item( $fl_menu_id, 0, array(
						'menu-item-title'     => $p['title'],
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $page_obj->ID,
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					) );
				}
			}
			$locations['footer_legal'] = $fl_menu_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );

	// Flush rewrite rules to ensure all pages & archives work immediately
	flush_rewrite_rules( false );

	wp_send_json_success( array(
		'message' => 'ডেমো ইমপোর্ট সম্পূর্ণ সফল হয়েছে! সকল ক্যাটাগরি, প্রয়োজনীয় পেজ (সঠিক টেমপ্লেট সহ), ২০+ নিউজ পোস্ট, ভিডিও সংবাদ, পাঠকদের মন্তব্য ও মেনুবার সফলভাবে তৈরি হয়েছে।'
	) );
}
add_action( 'wp_ajax_bdk_run_demo_import', 'bdk_run_demo_import_ajax' );
