<?php
/**
 * The Category & Archive Template for BD News Alamin Theme (100% Identical to HTML Layout)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$clean_title = single_term_title( '', false );
if ( empty( $clean_title ) ) {
	$clean_title = get_the_archive_title();
}
// Strip generic prefix like "Category: ", "Tag: ", "Author: "
$clean_title = preg_replace( '/^(Category|Tag|Author|Archives):\s*/i', '', $clean_title );
?>

  <!-- Category Hero Banner (High Contrast & Full Width) -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>ক্যাটাগরি আর্কাইভ</span>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span><?php echo esc_html( $clean_title ); ?></span>
      </div>
      <h1><?php echo esc_html( $clean_title ); ?> আর্কাইভ</h1>
      <p><?php echo get_the_archive_description() ?: esc_html( $clean_title ) . ' সম্পর্কিত সর্বশেষ, বস্তুনিষ্ঠ ও জনগুরুত্বপূর্ণ সকল সংবাদের সার্বক্ষণিক আপডেট।'; ?></p>
    </div>
  </section>

  <!-- Main Archive Content Area -->
  <main class="container">
    <div class="archive-layout">
      
      <!-- Left Column: News Grid -->
      <div class="archive-main-col">
        
        <!-- Archive Top Banner Ad Slot -->
        <?php bdk_display_ad_slot( 'bdk_archive_ad', 'ক্যাটাগরি শীর্ষ ব্যানার বিজ্ঞাপন', '728×90 Leaderboard' ); ?>
        
        <?php if ( have_posts() ) : ?>
          
          <!-- Sub Categories Bar (if is category) -->
          <?php
          if ( is_category() ) {
            $current_cat = get_queried_object();
            $sub_cats = get_categories( array( 'parent' => $current_cat->term_id, 'hide_empty' => false ) );
            if ( ! empty( $sub_cats ) ) {
              echo '<div class="division-tab-pills" style="margin-bottom: 1.5rem;">';
              echo '<a href="' . esc_url( get_category_link( $current_cat->term_id ) ) . '" class="div-pill-btn active">সকল ' . esc_html( $current_cat->name ) . '</a>';
              foreach ( $sub_cats as $sc ) {
                echo '<a href="' . esc_url( get_category_link( $sc->term_id ) ) . '" class="div-pill-btn">' . esc_html( $sc->name ) . '</a>';
              }
              echo '</div>';
            }
          }
          ?>

          <!-- Archive 2-Column Grid -->
          <div class="archive-news-grid">
            <?php while ( have_posts() ) : the_post(); ?>
              <article class="archive-card">
                <a href="<?php the_permalink(); ?>" class="card-img-wrap">
                  <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                </a>
                <div class="card-body">
                  <span class="lifestyle-tag" style="margin-bottom: 0.4rem; display: inline-block;">
                    <?php echo esc_html( get_the_category()[0]->name ?? 'সংবাদ' ); ?>
                  </span>
                  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 0.5rem;"><?php echo wp_trim_words( get_the_excerpt(), 16, '...' ); ?></p>
                  <div class="news-meta-row" style="margin-top: auto;">
                    <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                    <span><i class="far fa-user"></i> <?php the_author(); ?></span>
                  </div>
                </div>
              </article>
            <?php endwhile; ?>
          </div>

          <!-- Dynamic Pagination -->
          <div class="archive-pagination" style="margin-top: 2.5rem;">
            <?php
            echo paginate_links( array(
              'prev_text' => '<i class="fas fa-chevron-left"></i> পূর্ববর্তী',
              'next_text' => 'পরবর্তী <i class="fas fa-chevron-right"></i>',
              'type'      => 'plain',
            ) );
            ?>
          </div>

        <?php else : ?>
          <div class="static-content-box" style="text-align: center; padding: 3rem 1.5rem;">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3>এই বিভাগে বর্তমানে কোনো সংবাদ নেই</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">অনুগ্রহ করে অন্য কোনো ক্যাটাগরি বা বিষয় অনুসন্ধান করুন।</p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="submit-brand-btn" style="padding: 0.6rem 1.4rem;">প্রচ্ছদে ফিরে যান</a>
          </div>
        <?php endif; ?>

      </div>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
get_footer();
