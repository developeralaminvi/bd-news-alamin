<?php
/**
 * Photo Story Archive Template for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

  <!-- Category Hero Banner (High Contrast & Full Width) -->
  <section class="category-hero-banner" style="background: linear-gradient(135deg, #1e1b4b 0%, #006a4e 100%);">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>ছবির গল্প ও ফটো ফিচার</span>
      </div>
      <h1><i class="fas fa-camera-retro" style="color: var(--accent-color);"></i> ছবির গল্প ও ফটো ফিচার</h1>
      <p>দেশ ও প্রকৃতির অপরূপ সৌন্দর্য, মানুষ ও সংস্কৃতির বৈচিত্র্যময় মুহূর্ত ক্যামেরার চোখে।</p>
    </div>
  </section>

  <!-- Main Archive Content Area -->
  <main class="container">
    <div class="archive-layout">
      
      <!-- Left Column: Photo Stories Grid -->
      <div class="archive-main-col">
        
        <?php if ( have_posts() ) : ?>
          
          <div class="archive-news-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
            <?php while ( have_posts() ) : the_post();
              $gallery_images = get_post_meta( get_the_ID(), '_bdk_gallery_images', true );
              $photo_count = $gallery_images ? count( explode( ',', $gallery_images ) ) + 1 : 8;
            ?>
              <article class="archive-card" style="border-radius: var(--radius-md); overflow: hidden; background: var(--surface-color); box-shadow: var(--card-shadow);">
                <a href="<?php the_permalink(); ?>" class="card-img-wrap" style="position: relative; display: block; aspect-ratio: 16/10;">
                  <span class="photo-count-badge" style="position: absolute; top: 10px; right: 10px; z-index: 2; background: rgba(0,0,0,0.75); color: #fff; padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700;">
                    <i class="far fa-images"></i> <?php echo bdk_to_bengali_numerals( $photo_count ); ?>টি ছবি
                  </span>
                  <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                </a>
                <div class="card-body" style="padding: 1.25rem;">
                  <span class="special-tag" style="background: #e11d48; color: #fff; font-size: 0.75rem; padding: 2px 6px; border-radius: 3px; display: inline-block; margin-bottom: 0.5rem;">
                    ফটো ফিচার
                  </span>
                  <h4 style="font-size: 1.1rem; line-height: 1.4; margin-bottom: 0.5rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 0.75rem;"><?php echo wp_trim_words( get_the_excerpt(), 14, '...' ); ?></p>
                  <div class="news-meta-row" style="margin-top: auto; font-size: 0.78rem;">
                    <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
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
            <i class="fas fa-camera-retro" style="font-size: 3.5rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>বর্তমানে কোনো ছবির গল্প নেই</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">এডমিন প্যানেল থেকে নতুন ছবির গল্প ও অ্যালবাম যোগ করুন।</p>
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
