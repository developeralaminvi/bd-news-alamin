<?php
/**
 * Single Video Template for BD News Alamin Theme (ভিডিও সংবাদ বিস্তারিত)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
	// Track post views
	if ( function_exists( 'bdk_set_post_views' ) ) {
		bdk_set_post_views( get_the_ID() );
	}

	$post_id     = get_the_ID();
	$yt_url_raw  = get_post_meta( $post_id, '_bdk_youtube_url', true );
	$yt_id       = function_exists( 'bdk_extract_youtube_id' ) ? bdk_extract_youtube_id( $yt_url_raw ) : $yt_url_raw;
	$duration    = get_post_meta( $post_id, '_bdk_video_duration', true ) ?: '০৮:৪৫ মিনিট';
	$custom_file = get_post_meta( $post_id, '_bdk_custom_video_file', true );
	$views_count = function_exists( 'bdk_get_post_views' ) ? bdk_get_post_views( $post_id ) : '১,২০৪';

	// Video Category
	$video_cats = get_the_terms( $post_id, 'bdk_video_cat' );
	$cat_name   = 'ভিডিও বুলেটিন';
	$cat_link   = home_url( '/videos' );
	if ( ! empty( $video_cats ) && ! is_wp_error( $video_cats ) ) {
		$first_cat = reset( $video_cats );
		$cat_name  = $first_cat->name;
		$cat_link  = get_term_link( $first_cat );
	}

	// Author info
	$author_id    = get_the_author_meta( 'ID' );
	$author_name  = get_the_author();
	$author_desig = function_exists( 'bdk_get_author_designation' ) ? bdk_get_author_designation( $author_id ) : 'মাল্টিমিডিয়া রিপোর্টার';
?>

  <!-- Single Video Main Container -->
  <main class="container single-video-page" style="padding-top: 1.5rem; padding-bottom: 3.5rem;">
    <div class="single-page-layout">
      
      <!-- Main Content Column -->
      <article class="single-article-main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- 1. Breadcrumbs Navigation -->
        <nav class="breadcrumb-bar" style="margin-bottom: 1rem;">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">প্রচ্ছদ</a>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>">ভিডিও গ্যালারি</a>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <?php if ( ! empty( $video_cats ) && ! is_wp_error( $video_cats ) ) : ?>
            <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
            <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <?php endif; ?>
          <span><?php echo wp_trim_words( get_the_title(), 6, '...' ); ?></span>
        </nav>

        <!-- 2. Badges & Category Header -->
        <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 0.85rem;">
          <a href="<?php echo esc_url( $cat_link ); ?>" class="special-tag" style="background: var(--accent-color, #dc2626); color: #fff; text-decoration: none; padding: 4px 10px; border-radius: 4px; font-weight: 700; font-size: 0.82rem; display: inline-flex; align-items: center; gap: 5px;">
            <i class="fab fa-youtube"></i> <?php echo esc_html( $cat_name ); ?>
          </a>
          <span style="background: var(--surface-secondary, #f1f5f9); color: var(--text-main); font-size: 0.8rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; border: 1px solid var(--border-color); display: inline-flex; align-items: center; gap: 5px;">
            <i class="far fa-clock" style="color: var(--accent-color, #dc2626);"></i> <?php echo esc_html( $duration ); ?>
          </span>
          <span style="background: var(--surface-secondary, #f1f5f9); color: var(--text-muted); font-size: 0.8rem; font-weight: 600; padding: 4px 10px; border-radius: 4px; border: 1px solid var(--border-color); display: inline-flex; align-items: center; gap: 5px;">
            <i class="fas fa-eye" style="color: #0284c7;"></i> <?php echo esc_html( $views_count ); ?> বার দেখা হয়েছে
          </span>
        </div>

        <!-- 3. Headline & Subheadline -->
        <h1 class="article-headline" style="font-size: clamp(1.4rem, 3vw, 2.1rem); line-height: 1.35; margin-bottom: 0.75rem; font-weight: 800;">
          <?php the_title(); ?>
        </h1>

        <?php if ( has_excerpt() ) : ?>
          <p class="article-subheadline" style="font-size: 1.05rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem;">
            <?php echo get_the_excerpt(); ?>
          </p>
        <?php endif; ?>

        <!-- 4. Author & Meta Toolbar -->
        <div class="article-author-toolbar" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
          <div class="author-meta-block" style="display: flex; align-items: center; gap: 0.85rem;">
            <div class="author-avatar" style="width: 44px; height: 44px; border-radius: 50%; background: #dc2626; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; box-shadow: 0 4px 10px rgba(220,38,38,0.25);">
              <i class="fas fa-video"></i>
            </div>
            <div class="author-meta-text">
              <h5 style="margin: 0; font-size: 0.95rem; font-weight: 700;">
                <?php the_author_posts_link(); ?>
                <span style="font-size: 0.78rem; color: var(--accent-color, #dc2626); background: rgba(220,38,38,0.08); padding: 1px 6px; border-radius: 4px; font-weight: 600; margin-left: 4px;">
                  <?php echo esc_html( $author_desig ); ?>
                </span>
              </h5>
              <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 2px;">
                <i class="far fa-calendar-alt"></i> <?php echo esc_html( bdk_bengali_date() ); ?> &nbsp;|&nbsp; <i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?>
              </span>
            </div>
          </div>

          <!-- Action Tools -->
          <div class="article-action-tools" style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <button type="button" class="tool-btn" id="fontIncreaseBtn" title="ফন্ট বড় করুন">A+</button>
            <button type="button" class="tool-btn" id="fontDecreaseBtn" title="ফন্ট ছোট করুন">A-</button>
            <button type="button" class="tool-btn" id="printArticleBtn" title="প্রিন্ট করুন"><i class="fas fa-print"></i></button>
          </div>
        </div>

        <!-- Print-Only Video Thumbnail -->
        <div class="print-only-video-thumb">
          <?php if ( has_post_thumbnail() ) : ?>
            <figure class="article-featured-image" style="margin: 1.5rem 0;">
              <?php the_post_thumbnail( 'full', array( 'class' => 'featured-main-img' ) ); ?>
              <?php 
              $vid_caption = get_the_post_thumbnail_caption();
              if ( ! empty( $vid_caption ) ) : 
              ?>
                <figcaption class="article-image-caption">
                  ছবি: <?php echo esc_html( $vid_caption ); ?>
                </figcaption>
              <?php endif; ?>
            </figure>
          <?php endif; ?>
        </div>

        <!-- 5. MAIN CINEMATIC VIDEO PLAYER -->
        <div class="single-video-player-wrap" style="position: relative; width: 100%; border-radius: var(--radius-md, 12px); overflow: hidden; background: #000; box-shadow: 0 15px 35px rgba(0,0,0,0.35); margin-bottom: 2rem;">
          
          <?php if ( ! empty( $custom_file ) ) : ?>
            <!-- Self-Hosted MP4 Video Player -->
            <div style="width: 100%; aspect-ratio: 16 / 9; background: #000; display: flex; align-items: center; justify-content: center;">
              <video controls autoplay playsinline preload="metadata" poster="<?php echo esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ); ?>" style="width: 100%; height: 100%; object-fit: contain; background: #000;">
                <source src="<?php echo esc_url( $custom_file ); ?>" type="video/mp4">
                আপনার ব্রাউজার ভিডিও প্লে করতে সমর্থন করছে না।
              </video>
            </div>

          <?php elseif ( ! empty( $yt_id ) ) : ?>
            <!-- Responsive YouTube Video Player Embed -->
            <div style="position: relative; width: 100%; aspect-ratio: 16 / 9; background: #000;">
              <iframe 
                src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $yt_id ); ?>?autoplay=1&rel=0&modestbranding=1&enablejsapi=1" 
                title="<?php the_title_attribute(); ?>"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
              </iframe>
            </div>

          <?php elseif ( has_post_thumbnail() ) : ?>
            <!-- Fallback Poster Image if no video URL is provided -->
            <div style="position: relative; width: 100%; aspect-ratio: 16 / 9; overflow: hidden; background: #0f172a;">
              <?php the_post_thumbnail( 'full', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
              <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.65); display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; padding: 1.5rem; text-align: center;">
                <i class="fas fa-triangle-exclamation" style="font-size: 2.5rem; color: #f59e0b; margin-bottom: 0.75rem;"></i>
                <h4 style="color: #fff; font-weight: 700; margin-bottom: 0.4rem;">ভিডিও লিঙ্ক যুক্ত করা হয়নি</h4>
                <p style="font-size: 0.88rem; color: #cbd5e1; margin: 0;">এডমিন প্যানেল থেকে এই পোস্টে YouTube লিংক অথবা MP4 ভিডিও ফাইল যোগ করুন।</p>
              </div>
            </div>

          <?php else : ?>
            <!-- Default Placeholder -->
            <div style="width: 100%; aspect-ratio: 16 / 9; background: #0f172a; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff;">
              <i class="fab fa-youtube" style="font-size: 3.5rem; color: var(--accent-color, #dc2626); margin-bottom: 0.75rem;"></i>
              <p style="font-size: 0.95rem; color: #94a3b8;">ভিডিও লোড হচ্ছে না</p>
            </div>
          <?php endif; ?>

        </div>

        <!-- 6. Video Summary & Content -->
        <div class="article-body-content" id="articleBodyContent" style="font-size: 1.05rem; line-height: 1.85; margin-bottom: 2rem;">
          <?php 
          if ( get_the_content() ) {
            the_content(); 
          } else {
            echo '<p>' . esc_html( get_the_title() ) . ' — ভিডিও প্রতিবেদনটি উপভোগ করুন। আপনার মতামত ও মন্তব্য নিচে লিখে জানান।</p>';
          }
          ?>
        </div>

        <!-- Mid In-Article Banner Ad Slot -->
        <div class="no-print">
          <?php if ( function_exists( 'bdk_display_ad_slot' ) ) : ?>
            <?php bdk_display_ad_slot( 'bdk_single_mid_ad', 'ইন-আর্টিকেল বিজ্ঞাপন', 'In-Article Ad Slot' ); ?>
          <?php endif; ?>
        </div>

        <!-- 7. Social Share Bar -->
        <div class="share-bar-sticky" style="margin: 2rem 0; padding: 1rem; background: var(--surface-secondary, #f8fafc); border: 1px solid var(--border-color); border-radius: var(--radius-md); display: flex; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <span style="font-weight: 700; font-size: 0.95rem; margin-right: 0.25rem;"><i class="fas fa-share-nodes"></i> ভিডিওটি শেয়ার করুন:</span>
          <?php
          $share_url   = urlencode( get_permalink() );
          $share_title = urlencode( get_the_title() );
          ?>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-fb" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 6px; background: #1877f2; color: #fff; font-weight: 600; text-decoration: none; font-size: 0.85rem;">
            <i class="fab fa-facebook-f"></i> ফেসবুক
          </a>
          <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-wa" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 6px; background: #25d366; color: #fff; font-weight: 600; text-decoration: none; font-size: 0.85rem;">
            <i class="fab fa-whatsapp"></i> হোয়াটসঅ্যাপ
          </a>
          <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-tw" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 6px; background: #000; color: #fff; font-weight: 600; text-decoration: none; font-size: 0.85rem;">
            <i class="fab fa-x-twitter"></i> টুইটার
          </a>
          <button type="button" class="share-btn-brand share-copy" id="copyLinkBtn" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 6px; background: var(--surface-color); color: var(--text-main); border: 1px solid var(--border-color); font-weight: 600; cursor: pointer; font-size: 0.85rem;">
            <i class="fas fa-link"></i> লিংক কপি
          </button>
        </div>

        <!-- 8. Related / More Video Reports Grid -->
        <section class="related-videos-section" style="margin-top: 3rem; border-top: 2px solid var(--border-color); padding-top: 2rem;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 8px; margin: 0;">
              <i class="fab fa-youtube" style="color: var(--accent-color, #dc2626);"></i> আরও ভিডিও সংবাদ
            </h3>
            <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" style="font-size: 0.85rem; font-weight: 700; color: var(--primary-color); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
              সকল ভিডিও <i class="fas fa-angle-right"></i>
            </a>
          </div>

          <div class="archive-news-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.25rem;">
            <?php
            $rel_vids = new WP_Query( array(
              'post_type'           => 'bdk_video',
              'posts_per_page'      => 4,
              'post__not_in'        => array( $post_id ),
              'ignore_sticky_posts' => 1,
            ) );

            if ( $rel_vids->have_posts() ) :
              while ( $rel_vids->have_posts() ) : $rel_vids->the_post();
                $rel_yt_raw   = get_post_meta( get_the_ID(), '_bdk_youtube_url', true );
                $rel_yt_id    = function_exists( 'bdk_extract_youtube_id' ) ? bdk_extract_youtube_id( $rel_yt_raw ) : $rel_yt_raw;
                $rel_duration = get_post_meta( get_the_ID(), '_bdk_video_duration', true ) ?: '০৮:৪৫ মিনিট';
            ?>
              <article class="world-magazine-card" style="background: var(--surface-color); border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); display: flex; flex-direction: column;">
                <div class="world-card-img-wrap" style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background: #000;">
                  <a href="<?php the_permalink(); ?>" style="display: block; width: 100%; height: 100%;">
                    <?php if ( has_post_thumbnail() ) : ?>
                      <?php the_post_thumbnail( 'bdk-grid', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
                    <?php else : ?>
                      <img src="<?php echo esc_url( bdk_get_default_post_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php endif; ?>
                    <span class="video-play-btn-large" style="width: 42px; height: 42px; font-size: 0.95rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 50%; background: rgba(220,38,38,0.9); color: #fff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.4);">
                      <i class="fas fa-play"></i>
                    </span>
                    <span class="read-time-pill" style="position: absolute; bottom: 8px; right: 8px; background: rgba(0,0,0,0.8); color: #fff; font-size: 0.72rem; padding: 2px 6px; border-radius: 4px;">
                      <i class="far fa-clock"></i> <?php echo esc_html( $rel_duration ); ?>
                    </span>
                  </a>
                </div>
                <div class="world-card-body" style="padding: 0.85rem; display: flex; flex-direction: column; flex-grow: 1;">
                  <h4 style="font-size: 0.95rem; font-weight: 700; line-height: 1.4; margin-bottom: 0.5rem;">
                    <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;">
                      <?php the_title(); ?>
                    </a>
                  </h4>
                  <div class="news-meta-row" style="margin-top: auto; font-size: 0.75rem; color: var(--text-muted);">
                    <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                  </div>
                </div>
              </article>
            <?php
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </section>

        <!-- 9. Comments Section -->
        <?php
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;
        ?>

      </article>

      <!-- Sidebar: Video Playlist & Standard Widgets -->
      <aside class="sidebar-wrapper">
        
        <!-- Dedicated Latest Video Bulletins Widget -->
        <div class="sidebar-widget" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem; box-shadow: var(--card-shadow);">
          <div style="border-bottom: 2px solid var(--accent-color, #dc2626); padding-bottom: 0.5rem; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; font-size: 1.05rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 7px;">
              <i class="fab fa-youtube" style="color: var(--accent-color, #dc2626);"></i> সর্বশেষ ভিডিও
            </h4>
            <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" style="font-size: 0.78rem; font-weight: 700; color: var(--accent-color, #dc2626); text-decoration: none;">সকল ভিডিও</a>
          </div>

          <div class="video-sidebar-list" style="display: flex; flex-direction: column; gap: 0.85rem;">
            <?php
            $sidebar_vids = new WP_Query( array(
              'post_type'           => 'bdk_video',
              'posts_per_page'      => 5,
              'post__not_in'        => array( $post_id ),
              'ignore_sticky_posts' => 1,
            ) );

            if ( $sidebar_vids->have_posts() ) :
              while ( $sidebar_vids->have_posts() ) : $sidebar_vids->the_post();
                $sb_duration = get_post_meta( get_the_ID(), '_bdk_video_duration', true ) ?: '০৮:৪৫ মিনিট';
            ?>
              <a href="<?php the_permalink(); ?>" class="video-sidebar-item" style="display: flex; gap: 0.75rem; text-decoration: none; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color); align-items: flex-start;">
                <div class="video-thumb-small" style="position: relative; width: 85px; height: 58px; flex-shrink: 0; border-radius: 6px; overflow: hidden; background: #000;">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'bdk-thumb', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;' ) ); ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url( bdk_get_default_post_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                  <?php endif; ?>
                  <span style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.35); color: #fff; font-size: 0.8rem;">
                    <i class="fas fa-play"></i>
                  </span>
                </div>
                <div style="flex-grow: 1;">
                  <h5 style="margin: 0 0 4px 0; font-size: 0.88rem; font-weight: 600; line-height: 1.35; color: var(--text-main);">
                    <?php the_title(); ?>
                  </h5>
                  <span style="font-size: 0.72rem; color: var(--text-muted); display: block;">
                    <i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?>
                  </span>
                </div>
              </a>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
              echo '<p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">কোনো অতিরিক্ত ভিডিও নেই।</p>';
            endif;
            ?>
          </div>
        </div>

        <!-- Social Community Box -->
        <div class="special-highlight-card" style="background: linear-gradient(135deg, #006a4e 0%, #064e3b 100%); color: #fff; padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0, 106, 78, 0.25);">
          <h4 style="color: #fff; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem;">ফেসবুকে যুক্ত থাকুন</h4>
          <p style="font-size: 0.82rem; opacity: 0.9; line-height: 1.5; margin-bottom: 0.85rem; color: #fff;">ভিডিও ও ব্রেকিং নিউজের লাইভ আপডেট পেতে <?php echo bdk_get_site_name(); ?> ফেসবুক পেজ ফলো করুন।</p>
          <a href="<?php echo esc_url( get_theme_mod( 'bdk_social_facebook', 'https://www.facebook.com' ) ); ?>" target="_blank" rel="noopener" class="special-read-btn" style="background: #ffffff; color: #006a4e; font-weight: 700; padding: 0.35rem 0.9rem; border-radius: var(--radius-full); display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.82rem; text-decoration: none;">
            <i class="fab fa-facebook-f"></i> ফলো করুন
          </a>
        </div>

        <!-- Sidebar Widgets (if active) -->
        <?php
        if ( is_active_sidebar( 'sidebar-single' ) ) {
          dynamic_sidebar( 'sidebar-single' );
        }
        ?>

        <!-- Sidebar Ad Slot -->
        <?php if ( function_exists( 'bdk_display_ad_slot' ) ) : ?>
          <?php bdk_display_ad_slot( 'bdk_sidebar_ad', 'সাইডবার বিজ্ঞাপন স্লট', '300×250 Medium Rectangle' ); ?>
        <?php endif; ?>

      </aside>

    </div>
  </main>

  <!-- Copy link script -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var copyBtn = document.getElementById('copyLinkBtn');
    if (copyBtn) {
      copyBtn.addEventListener('click', function() {
        navigator.clipboard.writeText(window.location.href).then(function() {
          var original = copyBtn.innerHTML;
          copyBtn.innerHTML = '<i class="fas fa-check" style="color: #10b981;"></i> কপি হয়েছে!';
          setTimeout(function() {
            copyBtn.innerHTML = original;
          }, 2500);
        });
      });
    }
  });
  </script>

<?php
endwhile;

get_footer();
