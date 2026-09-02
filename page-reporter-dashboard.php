<?php
/**
 * Template Name: Reporter Dashboard (রিপোর্টার ড্যাশবোর্ড)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Redirect non-logged in users to Auth Account page
if ( ! is_user_logged_in() ) {
	wp_safe_redirect( home_url( '/reporter-account' ) );
	exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id      = $current_user->ID;

$r_status      = get_user_meta( $user_id, 'bdk_reporter_status', true ) ?: 'pending';
$r_phone       = get_user_meta( $user_id, 'bdk_reporter_phone', true ) ?: 'N/A';
$r_designation = get_user_meta( $user_id, 'bdk_reporter_designation', true ) ?: 'সংবাদদাতা';
$r_photo       = bdk_get_author_photo_url( $user_id );
$r_code        = get_user_meta( $user_id, 'bdk_reporter_id_code', true ) ?: 'BDK-REP-' . $user_id;

// Handle post submission alerts
$submitted   = ! empty( $_GET['submitted'] );
$registered  = ! empty( $_GET['registered'] );
$post_error  = get_transient( 'bdk_post_sub_error' );
delete_transient( 'bdk_post_sub_error' );
?>

  <!-- Dashboard Hero Banner -->
  <section class="category-hero-banner" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 2.5rem 0;">
    <div class="container">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.75); margin-bottom: 0.3rem;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff;">প্রচ্ছদ</a>
            <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
            <span>সাংবাদিক প্যানেল</span>
          </div>
          <h1 style="font-size: 1.6rem; color: #fff;">স্বাগতম, <?php echo esc_html( $current_user->display_name ); ?></h1>
          <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 4px;"><?php echo esc_html( $r_designation ); ?> | আইডি: <?php echo esc_html( $r_code ); ?></p>
        </div>

        <div>
          <a href="<?php echo esc_url( wp_logout_url( home_url( '/reporter-account' ) ) ); ?>" class="button" style="background: #ef4444; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 6px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
            <i class="fas fa-right-from-bracket"></i> লগআউট
          </a>
        </div>
      </div>
    </div>
  </section>

  <main class="container" style="margin-top: 2rem; margin-bottom: 4rem;">

    <?php if ( ! empty( $_GET['profile_requested'] ) ) : ?>
      <div style="background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <p style="margin: 0;"><i class="fas fa-clock-rotate-left"></i> আপনার প্রোফাইল সংশোধনের আবেদনটি সফলভাবে জমা হয়েছে। এডমিন এটি পর্যালোচনা করে অনুমোদন করবেন।</p>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $_GET['profile_updated'] ) ) : ?>
      <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <p style="margin: 0;"><i class="fas fa-circle-check"></i> আপনার প্রোফাইল তথ্য সফলভাবে আপডেট করা হয়েছে।</p>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $_GET['updated'] ) ) : ?>
      <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <p style="margin: 0;"><i class="fas fa-circle-check"></i> আপনার সংবাদটির পরিবর্তন সফলভাবে সংরক্ষিত হয়েছে।</p>
      </div>
    <?php endif; ?>

    <?php if ( $registered ) : ?>
      <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <h4 style="margin: 0 0 4px 0; font-size: 1.05rem;"><i class="fas fa-circle-check"></i> ধন্যবাদ! আপনার সাংবাদিক আবেদনপত্রটি জমা হয়েছে।</h4>
        <p style="margin: 0;">আপনার প্রদত্ত তথ্য ও সিভি এডমিন পর্যালোচনায় রয়েছে। অনুমোদন পাওয়ার সাথে সাথেই ইমেইলের মাধ্যমে জানানো হবে এবং এখান থেকে নিয়মিত সংবাদ পোস্ট করতে পারবেন।</p>
      </div>
    <?php endif; ?>

    <?php if ( $submitted ) : ?>
      <div style="background: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <p style="margin: 0;"><i class="fas fa-circle-check"></i> আপনার সংবাদটি সফলভাবে এডমিন পর্যালোচনার জন্য জমা দেওয়া হয়েছে। এডমিন রিভিউ শেষে সাইটে প্রকাশ করা হবে।</p>
      </div>
    <?php endif; ?>

    <?php if ( $post_error ) : ?>
      <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.95rem;">
        <p style="margin: 0;"><i class="fas fa-triangle-exclamation"></i> <?php echo esc_html( $post_error ); ?></p>
      </div>
    <?php endif; ?>

    <!-- Reporter Profile Overview Card -->
    <div style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.5rem; margin-bottom: 2rem; box-shadow: var(--card-shadow); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.5rem;">
      <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
        <img src="<?php echo esc_url( $r_photo ); ?>" alt="<?php echo esc_attr( $current_user->display_name ); ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary-color);">
        <div>
          <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 2px;"><?php echo esc_html( $current_user->display_name ); ?></h3>
          <p style="font-size: 0.9rem; color: var(--primary-color); font-weight: 600; margin-bottom: 4px;"><?php echo esc_html( $r_designation ); ?></p>
          <div style="font-size: 0.85rem; color: var(--text-body); display: flex; gap: 1rem; flex-wrap: wrap;">
            <span><i class="fas fa-phone" style="color: var(--text-muted);"></i> <?php echo esc_html( $r_phone ); ?></span>
            <span><i class="fas fa-envelope" style="color: var(--text-muted);"></i> <?php echo esc_html( $current_user->user_email ); ?></span>
          </div>
        </div>
      </div>

      <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
        <?php if ( 'approved' === $r_status || current_user_can( 'administrator' ) ) : ?>
          <span style="display: inline-block; background: #10b981; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem; font-weight: 700;">
            ✓ অনুমোদিত সংবাদদাতা
          </span>
          <div style="display: flex; gap: 0.5rem; margin-top: 4px;">
            <button type="button" onclick="openProfileEditModal()" class="button" style="padding: 0.45rem 0.85rem; font-size: 0.85rem; background: var(--surface-secondary); color: var(--text-main); border: 1px solid var(--border-color); border-radius: 6px; cursor: pointer;">
              <i class="fas fa-user-pen"></i> প্রোফাইল এডিট
            </button>
            <button type="button" onclick="openPressIdModal()" class="submit-brand-btn" style="padding: 0.45rem 1rem; font-size: 0.85rem; background: #0284c7; border: none;">
              <i class="fas fa-id-card"></i> প্রেস আইডি
            </button>
          </div>
        <?php else : ?>
          <span style="display: inline-block; background: #f59e0b; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.82rem; font-weight: 700;">
            ⏳ আবেদন পর্যালোচনায় (Pending)
          </span>
        <?php endif; ?>
      </div>
    </div>

    <?php if ( 'approved' !== $r_status && ! current_user_can( 'administrator' ) ) : ?>
      <!-- Pending Notice Banner -->
      <div style="background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
        <p style="margin: 0;"><i class="fas fa-circle-info"></i> <strong>বিজ্ঞপ্তি:</strong> আপনার সাংবাদিক একাউন্টটি বর্তমানে এডমিন পর্যালোচনায় রয়েছে। তবুও আপনি নিচ থেকে সংবাদ পোস্ট করতে পারবেন, এডমিন রিভিউ শেষে আপনার একাউন্ট ও জমা দেওয়া সংবাদ একসঙ্গে অনুমোদিত হবে।</p>
      </div>
    <?php endif; ?>

    <!-- 2-COLUMN DASHBOARD GRID -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start;" id="postFormSection">
      
      <!-- LEFT: CREATE / EDIT POST FORM -->
      <div style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.75rem; box-shadow: var(--card-shadow);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-color); padding-bottom: 0.75rem; margin-bottom: 1.25rem;">
          <h2 id="formTitleText" style="font-size: 1.15rem; font-weight: 700; color: var(--primary-color); margin: 0;">
            <i class="fas fa-pen-nib"></i> নতুন সংবাদ তৈরি ও সাবমিট
          </h2>
          <button type="button" id="cancelEditBtn" onclick="cancelPostEdit()" style="display: none; background: #0284c7; color: #fff; border: none; padding: 5px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
            <i class="fas fa-plus"></i> ➕ নতুন সংবাদ তৈরি করুন
          </button>
        </div>

          <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="bdk_reporter_submit_post">
            <input type="hidden" name="editing_post_id" id="editing_post_id" value="0">
            <?php wp_nonce_field( 'bdk_reporter_post_action', 'bdk_reporter_post_nonce' ); ?>

            <div style="margin-bottom: 1.2rem;">
              <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">সংবাদের শিরোনাম (Headline) *</label>
              <input type="text" name="post_title" class="comment-input-field" required placeholder="আকর্ষণীয় সংবাদের শিরোনাম লিখুন" style="width: 100%; height: 44px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.2rem;">
              <div>
                <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">সংবাদের ক্যাটাগরি (Main & Sub) *</label>
                <select name="post_category" class="comment-input-field" required style="width: 100%; height: 44px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                  <option value="">-- ক্যাটাগরি বেছে নিন --</option>
                  <?php bdk_render_hierarchical_terms_options( 'category' ); ?>
                </select>
              </div>

              <div>
                <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">📍 জেলা ও উপজেলা নির্বাচন (সারাদেশ)</label>
                <select name="post_district" class="comment-input-field" style="width: 100%; height: 44px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
                  <option value="0">-- জাতীয় / কোনো নির্দিষ্ট জেলা নেই --</option>
                  <?php bdk_render_hierarchical_terms_options( 'bdk_district' ); ?>
                </select>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.4rem; color: var(--text-main);">
                <i class="fas fa-image" style="color: var(--primary-color);"></i> সংবাদের প্রচ্ছদ ছবি (Featured Main Image)
              </label>

              <input type="file" name="post_thumbnail" id="post_thumbnail_input" accept="image/*" style="display: none;">

              <!-- Custom Interactive Upload Dropzone Box -->
              <div id="featuredImgDropzone" onclick="document.getElementById('post_thumbnail_input').click()" style="background: var(--surface-secondary); border: 2px dashed var(--border-color); border-radius: var(--radius-md); padding: 1.75rem 1rem; text-align: center; cursor: pointer; transition: all 0.25s ease; position: relative;" onmouseover="this.style.borderColor='var(--primary-color)'; this.style.background='rgba(220,38,38,0.03)';" onmouseout="this.style.borderColor='var(--border-color)'; this.style.background='var(--surface-secondary)';">
                <div id="dropzoneEmptyState">
                  <i class="fas fa-cloud-arrow-up" style="font-size: 2.4rem; color: var(--primary-color); margin-bottom: 0.6rem; display: block;"></i>
                  <span style="font-weight: 700; font-size: 0.95rem; color: var(--text-main); display: block;">এইচডি প্রচ্ছদ ছবি নির্বাচন করতে এখানে ক্লিক করুন</span>
                  <span style="font-size: 0.78rem; color: var(--text-muted); display: block; margin-top: 4px;">সমর্থিত ফরম্যাট: JPG, PNG, WEBP (পরামর্শ: 800x450 পিক্সেল)</span>
                </div>
              </div>

              <!-- High-Contrast Live Preview Card -->
              <div id="featuredImgPreviewBox" style="display: none; margin-top: 0.75rem; background: var(--surface-secondary); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem; box-shadow: var(--card-shadow);">
                <div style="font-size: 0.82rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.6rem; display: flex; justify-content: space-between; align-items: center;">
                  <span><i class="fas fa-circle-check" style="color: #10b981;"></i> নির্বাচিত প্রচ্ছদ ছবি প্রিভিউ:</span>
                  <div style="display: flex; gap: 0.5rem;">
                    <button type="button" onclick="document.getElementById('post_thumbnail_input').click()" style="background: #0284c7; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                      <i class="fas fa-arrows-rotate"></i> পরিবর্তন
                    </button>
                    <button type="button" onclick="removeFeaturedImgPreview()" style="background: #ef4444; color: #fff; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                      <i class="fas fa-trash-can"></i> মুছুন
                    </button>
                  </div>
                </div>
                <div style="position: relative; border-radius: 8px; overflow: hidden; background: #000; border: 1px solid var(--border-color);">
                  <img id="featuredImgPreview" src="" alt="Featured Preview" style="width: 100%; max-height: 240px; object-fit: cover; display: block;">
                </div>
              </div>
            </div>

            <div style="margin-bottom: 1.2rem;">
              <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">সংক্ষিপ্ত বিবরণ / সারসংক্ষেপ (Excerpt)</label>
              <textarea name="post_excerpt" id="post_excerpt_input" rows="2" class="comment-input-field" placeholder="সংবাদের ১-২ লাইনের সারসংক্ষেপ..." style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border-color);"></textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;">
                <i class="fas fa-file-signature"></i> সংবাদের বিস্তারিত বিবরণ (ছবি ও টেক্সট এডিটর) *
              </label>
              <!-- Quill Editor Styles & Scripts -->
              <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
              <div id="quillEditorContainer" style="height: 340px;"></div>
              <textarea name="post_content" id="post_content_hidden" style="display: none;"></textarea>
              <span style="font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; display: block;">
                💡 টিপস: লেখার সাইজ, বোল্ড, হেডিং, লিস্ট, লিংক এবং <b>🖼️ ইমেজ বাটনে ক্লিক করে লেখার মাঝামাঝি ছবি</b> যুক্ত করতে পারেন। এডিটর বক্সটি <b>কোণা ধরে টেনে ছোট-বড়</b> করতে পারবেন।
              </span>
            </div>

            <button type="submit" id="submitPostBtn" class="submit-brand-btn" style="width: 100%; height: 46px; font-size: 1rem; font-weight: 700;">
              <i class="fas fa-paper-plane"></i> সংবাদ সাবমিট করুন (এডমিন রিভিউর জন্য)
            </button>
          </form>
        </div>

        <!-- RIGHT: MY SUBMITTED POSTS LIST -->
        <div style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.75rem; box-shadow: var(--card-shadow);">
          <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1.25rem; border-bottom: 2px solid var(--border-color); padding-bottom: 0.75rem;">
            <i class="fas fa-newspaper"></i> আমার জমাকৃত সংবাদসমূহ
          </h2>

          <?php
          $my_posts = new WP_Query( array(
            'author'         => $user_id,
            'post_type'      => 'post',
            'post_status'    => array( 'publish', 'pending', 'draft' ),
            'posts_per_page' => 15,
          ) );

          if ( $my_posts->have_posts() ) :
          ?>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
              <?php
              while ( $my_posts->have_posts() ) : $my_posts->the_post();
                $post_id     = get_the_ID();
                $cats        = wp_get_post_categories( $post_id );
                $cat_id      = ! empty( $cats ) ? $cats[0] : 0;
                $dist_terms  = wp_get_object_terms( $post_id, 'bdk_district', array( 'fields' => 'ids' ) );
                $dist_id     = ! empty( $dist_terms ) ? $dist_terms[0] : 0;
                $thumb_url   = get_the_post_thumbnail_url( $post_id, 'medium' ) ?: '';
                $post_raw_content = get_post_field( 'post_content', $post_id );
              ?>
                <div style="display: flex; gap: 1rem; align-items: center; background: var(--surface-secondary); padding: 0.85rem; border-radius: 8px; border: 1px solid var(--border-color);">
                  <div style="width: 70px; height: 55px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                    <?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
                  </div>
                  <div style="flex: 1;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0 0 4px 0; line-height: 1.4;">
                      <?php if ( get_post_status() === 'publish' ) : ?>
                        <a href="<?php the_permalink(); ?>" target="_blank" style="color: var(--text-main);"><?php the_title(); ?></a>
                      <?php else : ?>
                        <span style="color: var(--text-main);"><?php the_title(); ?></span>
                      <?php endif; ?>
                    </h4>
                    <div style="font-size: 0.78rem; color: var(--text-muted); display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                      <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                      <?php if ( get_post_status() === 'publish' ) : ?>
                        <span style="color: #10b981; font-weight: 700;">● প্রকাশিত</span>
                      <?php else : ?>
                        <span style="color: #f59e0b; font-weight: 700;">● পর্যালোচনায় (Pending)</span>
                      <?php endif; ?>

                      <!-- Hidden Raw Content for Safe Editing -->
                      <textarea id="post-raw-content-<?php echo $post_id; ?>" style="display: none;"><?php echo esc_textarea( $post_raw_content ); ?></textarea>

                      <!-- Edit Button -->
                      <button type="button" onclick="editNewsPost(<?php echo $post_id; ?>, '<?php echo esc_js( get_the_title() ); ?>', <?php echo $cat_id; ?>, <?php echo $dist_id; ?>, '<?php echo esc_js( get_the_excerpt() ); ?>', '<?php echo esc_js( $thumb_url ); ?>')" class="button button-small" style="background: #0284c7; color: #fff; border: none; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; cursor: pointer; font-weight: 600;">
                        <i class="fas fa-pen-to-square"></i> এডিট
                      </button>
                    </div>
                  </div>
                </div>
              <?php endwhile; wp_reset_postdata(); ?>
            </div>
          <?php else : ?>
            <div style="text-align: center; padding: 2rem; color: var(--text-muted);">
              <i class="fas fa-folder-open" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block;"></i>
              আপনি এখনও কোনো সংবাদ সাবমিট করেননি। বামপাশের ফরমটি ব্যবহার করে সংবাদ পাঠান।
            </div>
          <?php endif; ?>
        </div>

      </div>

      <!-- DIGITAL PRESS ID CARD MODAL -->
      <div id="pressIdCardModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 99999; justify-content: center; align-items: center; padding: 1rem; overflow-y: auto;">
        <div style="background: #fff; border-radius: 12px; padding: 2rem; max-width: 480px; width: 100%; position: relative;">
          <button type="button" onclick="closePressIdModal()" style="position: absolute; top: 12px; right: 16px; background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b;">&times;</button>
          <?php bdk_render_press_id_card( $user_id ); ?>
        </div>
      </div>

      <!-- REPORTER PROFILE EDIT MODAL -->
      <div id="profileEditModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 99999; justify-content: center; align-items: center; padding: 1rem; overflow-y: auto;">
        <div style="background: var(--surface-color, #fff); color: var(--text-main, #0f172a); border-radius: 12px; padding: 2rem; max-width: 540px; width: 100%; position: relative; border: 1px solid var(--border-color);">
          <button type="button" onclick="closeProfileEditModal()" style="position: absolute; top: 12px; right: 16px; background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">&times;</button>
          
          <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem; border-bottom: 2px solid var(--border-color); padding-bottom: 0.5rem;">
            <i class="fas fa-user-pen"></i> সাংবাদিক প্রোফাইল সংশোধন আবেদন
          </h3>
          <p style="font-size: 0.85rem; color: var(--text-body); margin-bottom: 1.25rem;">
            আপনার নাম, মোবাইল নম্বর, পদবী বা ছবি পরিবর্তন করতে চাইলে নিচের তথ্য সংশোধন করুন। পরিবর্তনের আবেদনটি এডমিন অনুমোদন করলে ড্যাশবোর্ডে ও প্রেস কার্ডে আপডেট হবে।
          </p>

          <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="bdk_reporter_update_profile">
            <?php wp_nonce_field( 'bdk_reporter_profile_action', 'bdk_reporter_profile_nonce' ); ?>

            <div style="margin-bottom: 1rem;">
              <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">আপনার পূর্ণ নাম *</label>
              <input type="text" name="full_name" class="comment-input-field" required value="<?php echo esc_attr( $current_user->display_name ); ?>" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">মোবাইল নম্বর *</label>
                <input type="tel" name="phone" class="comment-input-field" required value="<?php echo esc_attr( $r_phone ); ?>" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
              <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">পদবী / স্থান *</label>
                <input type="text" name="designation" class="comment-input-field" required value="<?php echo esc_attr( $r_designation ); ?>" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
              <div style="background: var(--surface-secondary); padding: 0.75rem; border-radius: 6px; border: 1px dashed var(--border-color);">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.3rem;"><i class="fas fa-camera"></i> নতুন ছবি (যদি পরিবর্তন করতে চান)</label>
                <input type="file" name="reporter_photo" accept="image/*" style="font-size: 0.78rem; width: 100%;">
              </div>
              <div style="background: var(--surface-secondary); padding: 0.75rem; border-radius: 6px; border: 1px dashed var(--border-color);">
                <label style="display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.3rem;"><i class="fas fa-file-pdf"></i> নতুন সিভি (যদি থাকে)</label>
                <input type="file" name="reporter_cv" accept=".pdf,.doc,.docx" style="font-size: 0.78rem; width: 100%;">
              </div>
            </div>

            <button type="submit" class="submit-brand-btn" style="width: 100%; height: 44px; font-size: 0.95rem; font-weight: 700;">
              <i class="fas fa-paper-plane"></i> সংশোধনের আবেদন জমা দিন
            </button>
          </form>
        </div>
      </div>

      <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
      <style>
        .ql-toolbar.ql-snow {
          background: var(--surface-secondary, #f8fafc);
          border-color: var(--border-color, #e2e8f0) !important;
          border-radius: 8px 8px 0 0;
        }
        .ql-container.ql-snow {
          border-color: var(--border-color, #e2e8f0) !important;
          border-radius: 0 0 8px 8px;
          background: var(--surface-color, #ffffff);
          color: var(--text-main, #0f172a);
          font-family: 'Hind Siliguri', 'Roboto', sans-serif;
          font-size: 1rem;
          resize: vertical;
          overflow: auto;
          min-height: 260px;
          max-height: 800px;
        }
        .ql-editor {
          min-height: 240px;
          line-height: 1.7;
        }
        .ql-editor.ql-blank::before {
          color: var(--text-muted, #94a3b8);
          font-style: normal;
        }
        .ql-snow .ql-stroke { stroke: var(--text-main, #334155) !important; }
        .ql-snow .ql-fill { fill: var(--text-main, #334155) !important; }
        .ql-snow .ql-picker { color: var(--text-main, #334155) !important; }
      </style>

      <script>
        var globalQuillInstance = null;

        function openPressIdModal() {
          document.getElementById('pressIdCardModal').style.display = 'flex';
        }
        function closePressIdModal() {
          document.getElementById('pressIdCardModal').style.display = 'none';
        }

        function openProfileEditModal() {
          document.getElementById('profileEditModal').style.display = 'flex';
        }
        function closeProfileEditModal() {
          document.getElementById('profileEditModal').style.display = 'none';
        }

        function removeFeaturedImgPreview() {
          var fileInput = document.getElementById('post_thumbnail_input');
          if (fileInput) fileInput.value = '';
          document.getElementById('featuredImgPreviewBox').style.display = 'none';
          document.getElementById('featuredImgDropzone').style.display = 'block';
        }

        function editNewsPost(postId, title, catId, distId, excerpt, thumbUrl, overrideContent) {
          document.getElementById('editing_post_id').value = postId;
          document.querySelector('input[name="post_title"]').value = title;
          document.querySelector('select[name="post_category"]').value = catId;
          document.querySelector('select[name="post_district"]').value = distId;
          document.getElementById('post_excerpt_input').value = excerpt;

          var contentHtml = overrideContent;
          if (typeof contentHtml === 'undefined') {
            var rawElem = document.getElementById('post-raw-content-' + postId);
            contentHtml = rawElem ? rawElem.value : '';
          }

          if (globalQuillInstance) {
            globalQuillInstance.root.innerHTML = contentHtml || '';
          }

          if (thumbUrl) {
            document.getElementById('featuredImgPreview').src = thumbUrl;
            document.getElementById('featuredImgPreviewBox').style.display = 'block';
            document.getElementById('featuredImgDropzone').style.display = 'none';
          } else {
            removeFeaturedImgPreview();
          }

          document.getElementById('formTitleText').innerHTML = '<i class="fas fa-pen-to-square"></i> সংবাদ সম্পাদনা করুন (ID: #' + postId + ')';
          document.getElementById('cancelEditBtn').style.display = 'inline-block';
          document.getElementById('submitPostBtn').innerHTML = '<i class="fas fa-floppy-disk"></i> সংবাদের পরিবর্তন সংরক্ষণ করুন (এডমিন রিভিউর জন্য)';

          var section = document.getElementById('postFormSection');
          if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
          }
        }

        function cancelPostEdit() {
          document.getElementById('editing_post_id').value = '0';
          document.querySelector('input[name="post_title"]').value = '';
          document.querySelector('select[name="post_category"]').value = '';
          document.querySelector('select[name="post_district"]').value = '0';
          document.getElementById('post_excerpt_input').value = '';

          if (globalQuillInstance) {
            globalQuillInstance.root.innerHTML = '';
          }
          removeFeaturedImgPreview();

          document.getElementById('formTitleText').innerHTML = '<i class="fas fa-pen-nib"></i> নতুন সংবাদ তৈরি ও সাবমিট';
          document.getElementById('cancelEditBtn').style.display = 'none';
          document.getElementById('submitPostBtn').innerHTML = '<i class="fas fa-paper-plane"></i> সংবাদ সাবমিট করুন (এডমিন রিভিউর জন্য)';
        }

        document.addEventListener('DOMContentLoaded', function() {
          // Featured Image Live Preview Listener
          var thumbInput = document.getElementById('post_thumbnail_input');
          if (thumbInput) {
            thumbInput.addEventListener('change', function(e) {
              var file = e.target.files[0];
              if (file) {
                var reader = new FileReader();
                reader.onload = function(evt) {
                  document.getElementById('featuredImgPreview').src = evt.target.result;
                  document.getElementById('featuredImgPreviewBox').style.display = 'block';
                  document.getElementById('featuredImgDropzone').style.display = 'none';
                };
                reader.readAsDataURL(file);
              }
            });
          }

          // Quill Editor Initialization
          var container = document.getElementById('quillEditorContainer');
          if (container && typeof Quill !== 'undefined') {
            globalQuillInstance = new Quill('#quillEditorContainer', {
              theme: 'snow',
              placeholder: 'সংবাদের বিস্তারিত বক্তব্য সুন্দরভাবে সাজিয়ে লিখুন...',
              modules: {
                toolbar: [
                  [{ 'header': [2, 3, 4, false] }],
                  ['bold', 'italic', 'underline', 'strike'],
                  [{ 'color': [] }, { 'background': [] }],
                  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                  [{ 'align': [] }],
                  ['blockquote', 'link', 'image'],
                  ['clean']
                ]
              }
            });

            var form = container.closest('form');
            if (form) {
              form.addEventListener('submit', function(e) {
                var hiddenInput = document.getElementById('post_content_hidden');
                var htmlContent = globalQuillInstance.root.innerHTML;
                if (globalQuillInstance.getText().trim().length === 0) {
                  alert('অনুগ্রহ করে সংবাদের বিস্তারিত বিবরণ প্রদান করুন।');
                  e.preventDefault();
                  return false;
                }
                hiddenInput.value = htmlContent;
              });
            }
          }

          <?php
          $auto_edit_post_id = isset( $_GET['edit_post'] ) ? intval( $_GET['edit_post'] ) : 0;
          if ( $auto_edit_post_id > 0 ) :
            $auto_post = get_post( $auto_edit_post_id );
            if ( $auto_post && ( $auto_post->post_author == $user_id || current_user_can( 'administrator' ) ) ) :
              $a_cats       = wp_get_post_categories( $auto_edit_post_id );
              $a_cat_id     = ! empty( $a_cats ) ? $a_cats[0] : 0;
              $a_dist_terms = wp_get_object_terms( $auto_edit_post_id, 'bdk_district', array( 'fields' => 'ids' ) );
              $a_dist_id    = ! empty( $a_dist_terms ) ? $a_dist_terms[0] : 0;
              $a_thumb_url  = get_the_post_thumbnail_url( $auto_edit_post_id, 'medium' ) ?: '';
              $a_content    = $auto_post->post_content;
              $a_excerpt    = $auto_post->post_excerpt;
              $a_title      = $auto_post->post_title;
          ?>
            setTimeout(function() {
              editNewsPost(
                <?php echo $auto_edit_post_id; ?>,
                <?php echo json_encode( $a_title ); ?>,
                <?php echo $a_cat_id; ?>,
                <?php echo $a_dist_id; ?>,
                <?php echo json_encode( $a_excerpt ); ?>,
                <?php echo json_encode( $a_thumb_url ); ?>,
                <?php echo json_encode( $a_content ); ?>
              );
            }, 200);
          <?php endif; endif; ?>
        });
      </script>

  </main>

<?php
get_footer();
