<?php
/**
 * The Single Post Template for BD News Alamin Theme (100% Matching single.html)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
	// Track post views
	bdk_set_post_views( get_the_ID() );
	$primary_cat = get_the_category()[0] ?? null;
	$post_thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: bdk_get_default_post_thumbnail_url();
?>

  <!-- Single Post Main Layout -->
  <main class="container">
    <div class="single-page-layout">
      
      <!-- Left Column: Article Content -->
      <article class="single-article-main" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- Print-Only Newspaper Masthead -->
        <div class="bdk-print-masthead">
          <div class="bdk-print-masthead-top">
            <h2 class="bdk-print-site-name"><?php echo esc_html( bdk_get_site_name() ); ?></h2>
            <span class="bdk-print-site-url"><?php echo esc_html( preg_replace( '(^https?://)', '', home_url() ) ); ?></span>
          </div>
          <div class="bdk-print-masthead-meta">
            <?php if ( $primary_cat ) : ?>
              <span class="bdk-print-cat"><strong>বিভাগ:</strong> <?php echo esc_html( $primary_cat->name ); ?></span>
            <?php endif; ?>
            <span class="bdk-print-date"><strong>মুদ্রণ:</strong> <?php echo esc_html( bdk_bengali_date() ); ?></span>
          </div>
          <div class="bdk-print-divider"></div>
        </div>

        <!-- 1. Breadcrumbs -->
        <nav class="breadcrumb-bar">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">প্রচ্ছদ</a>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <?php if ( $primary_cat ) : ?>
            <a href="<?php echo esc_url( get_category_link( $primary_cat->term_id ) ); ?>"><?php echo esc_html( $primary_cat->name ); ?></a>
            <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <?php endif; ?>
          <span><?php echo wp_trim_words( get_the_title(), 5, '...' ); ?></span>
        </nav>

        <!-- 2. Headlines -->
        <h1 class="article-headline"><?php the_title(); ?></h1>
        <?php if ( has_excerpt() ) : ?>
          <p class="article-subheadline">
            <?php echo get_the_excerpt(); ?>
          </p>
        <?php endif; ?>

        <!-- 3. Author Toolbar & Reading Tools -->
        <div class="article-author-toolbar">
          <div class="author-meta-block">
            <?php
            $author_id    = get_the_author_meta( 'ID' );
            $author_photo = bdk_get_author_photo_url( $author_id );
            $author_desig = bdk_get_author_designation( $author_id );
            ?>
            <div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color);">
              <img src="<?php echo esc_url( $author_photo ); ?>" alt="<?php the_author(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="author-meta-text">
              <h5>
                <?php the_author_posts_link(); ?>
                <span style="font-size: 0.78rem; color: var(--primary-color); background: rgba(220,38,38,0.08); padding: 1px 6px; border-radius: 4px; font-weight: 600; margin-left: 4px;">
                  <?php echo esc_html( $author_desig ); ?>
                </span>
              </h5>
              <span><i class="far fa-clock"></i> প্রকাশ: <?php echo esc_html( bdk_bengali_date() ); ?> | আপডেট: <?php echo bdk_posted_time_ago(); ?></span>
            </div>
          </div>

          <!-- Action Tools (Font Size, Print, Custom Shortcode) -->
          <div class="article-action-tools" style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <button type="button" class="tool-btn" id="fontIncreaseBtn" title="ফন্ট বড় করুন">A+</button>
            <button type="button" class="tool-btn" id="fontDecreaseBtn" title="ফন্ট ছোট করুন">A-</button>
            <button type="button" class="tool-btn" id="printArticleBtn" title="প্রিন্ট করুন"><i class="fas fa-print"></i></button>
            <div class="photo-card-toolbar-item" style="display: inline-flex; align-items: center;">
              <?php echo do_shortcode( '[azad_photo_card]' ); ?>
            </div>
          </div>
        </div>

        <!-- 4. Featured Media (Video Player if Video post, else Featured Image) -->
        <?php
        $yt_raw   = get_post_meta( get_the_ID(), '_bdk_youtube_url', true );
        $mp4_url  = get_post_meta( get_the_ID(), '_bdk_custom_video_file', true );
        $is_video = ( get_post_type() === 'bdk_video' ) || ! empty( $yt_raw ) || ! empty( $mp4_url );

        if ( $is_video && ( ! empty( $mp4_url ) || ! empty( $yt_raw ) ) ) :
          $yt_id = bdk_extract_youtube_id( $yt_raw );
        ?>
          <div class="article-featured-video" style="margin: 1.5rem 0; border-radius: var(--radius-md); overflow: hidden; background: #000; box-shadow: 0 10px 30px rgba(0,0,0,0.25);">
            <?php if ( ! empty( $mp4_url ) ) : ?>
              <video controls autoplay playsinline preload="metadata" poster="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>" style="width: 100%; aspect-ratio: 16/9; display: block; max-height: 520px; object-fit: contain; background: #000;">
                <source src="<?php echo esc_url( $mp4_url ); ?>" type="video/mp4">
                আপনার ব্রাউজার ভিডিও প্লে করতে সমর্থন করছে না।
              </video>
            <?php elseif ( ! empty( $yt_id ) ) : ?>
              <div style="position: relative; width: 100%; aspect-ratio: 16/9;">
                <iframe src="https://www.youtube-nocookie.com/embed/<?php echo esc_attr( $yt_id ); ?>?autoplay=1&rel=0&modestbranding=1" title="<?php the_title_attribute(); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
              </div>
            <?php endif; ?>
          </div>
        <?php else : ?>
          <figure class="article-featured-image" style="margin: 1.5rem 0;">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail( 'full', array( 'class' => 'featured-main-img', 'style' => 'width: 100%; border-radius: var(--radius-md); max-height: 480px; object-fit: cover;' ) ); ?>
            <?php else : ?>
              <img src="<?php echo esc_url( bdk_get_default_post_thumbnail_url() ); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; border-radius: var(--radius-md); max-height: 480px; object-fit: cover;">
            <?php endif; ?>
            <figcaption class="article-image-caption" style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.5rem; border-left: 3px solid var(--primary-color); padding-left: 0.5rem;">
              ছবি: <?php echo get_the_post_thumbnail_caption() ?: get_the_title() . ' | ' . bdk_get_site_name(); ?>
            </figcaption>
          </figure>
        <?php endif; ?>

        <!-- Top In-Article Banner Ad Slot -->
        <?php bdk_display_ad_slot( 'bdk_single_top_ad', 'শীর্ষ ব্যানার বিজ্ঞাপন', '৪১২×৯০ Leaderboard' ); ?>

        <!-- 5. Article Body Content -->
        <div class="article-body-content" id="articleBodyContent">
          <?php the_content(); ?>
        </div>

        <!-- 6. Mid-content In-Article Banner Ad Slot -->
        <?php bdk_display_ad_slot( 'bdk_single_mid_ad', 'ইন-আর্টিকেল বিজ্ঞাপন', 'In-Article Ad Slot' ); ?>

        <!-- 7. Social Share Bar -->
        <div class="share-bar-sticky">
          <span style="font-weight: 700; font-size: 0.95rem; margin-right: 0.5rem;">শেয়ার করুন:</span>
          <?php
          $share_url   = urlencode( get_permalink() );
          $share_title = urlencode( get_the_title() );
          ?>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-fb">
            <i class="fab fa-facebook-f"></i> ফেসবুক
          </a>
          <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-wa">
            <i class="fab fa-whatsapp"></i> হোয়াটসঅ্যাপ
          </a>
          <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-tw">
            <i class="fab fa-x-twitter"></i> টুইটার
          </a>
          <button type="button" class="share-btn-brand share-copy" id="copyLinkBtn">
            <i class="fas fa-link"></i> লিংক কপি
          </button>
        </div>

        <!-- 8. Author Bio Card -->
        <div class="opinion-card" style="margin: 2.5rem 0; background: var(--surface-secondary); border-left: 4px solid var(--primary-color);">
          <div class="opinion-author-header">
            <div class="author-avatar" style="width: 64px; height: 64px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color);">
              <img src="<?php echo esc_url( $author_photo ); ?>" alt="<?php the_author(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="author-info">
              <h4 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-bottom: 2px;"><?php the_author(); ?></h4>
              <span style="font-size: 0.88rem; color: var(--primary-color); font-weight: 600;"><?php echo esc_html( $author_desig ); ?></span>
              <p style="font-size: 0.85rem; color: var(--text-body); margin-top: 0.35rem; line-height: 1.5;">
                তৃণমূলের উন্নয়ন, গণমানুষের অধিকার ও বস্তুনিষ্ঠ অনুসন্ধানী সাংবাদিকতায় নিবেদিতপ্রাণ।
              </p>
            </div>
          </div>
        </div>

        <!-- 9. Related News Grid -->
        <?php
        if ( $primary_cat ) :
          $related_query = new WP_Query( array(
            'cat'                 => $primary_cat->term_id,
            'post__not_in'        => array( get_the_ID() ),
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => 1,
          ) );
          if ( $related_query->have_posts() ) :
        ?>
          <div class="related-news-section" style="margin: 3rem 0;">
            <div class="section-header-block">
              <div class="section-title-wrap">
                <span class="title-bar-accent"></span>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">আরও পড়ুন</h3>
              </div>
            </div>
            <div class="archive-news-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
              <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                <article class="archive-card">
                  <a href="<?php the_permalink(); ?>" class="card-img-wrap">
                    <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                  </a>
                  <div class="card-body">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <span class="news-time"><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                  </div>
                </article>
              <?php endwhile; wp_reset_postdata(); ?>
            </div>
          </div>
        <?php endif; endif; ?>

        <!-- Bottom Banner Ad Slot (Before Comments) -->
        <?php bdk_display_ad_slot( 'bdk_single_bot_ad', 'নিচের ব্যানার বিজ্ঞাপন', 'মন্তব্য বিভাগের আগে' ); ?>

        <!-- 10. Comments Section -->
        <?php
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;
        ?>

        <!-- Print-Only Newspaper Footer -->
        <div class="bdk-print-footer">
          <div class="bdk-print-divider"></div>
          <div class="bdk-print-footer-grid">
            <div class="bdk-print-footer-source">
              <strong><?php echo esc_html( bdk_get_site_name() ); ?></strong> — বস্তুনিষ্ঠ ও নিরপেক্ষ সংবাদের প্রতীক
            </div>
            <div class="bdk-print-footer-link">
              অনলাইন লিংক: <?php echo esc_url( get_permalink() ); ?>
            </div>
          </div>
          <div class="bdk-print-copyright">
            © <?php echo date( 'Y' ); ?> <?php echo esc_html( bdk_get_site_name() ); ?> | সর্বস্বত্ব সংরক্ষিত।
          </div>
        </div>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
endwhile;

get_footer();
