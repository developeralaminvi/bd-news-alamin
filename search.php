<?php
/**
 * The Search Results Template (Full Width Hero Banner matching archive.php)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

  <!-- Search Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner" style="background: linear-gradient(135deg, #006a4e 0%, #064e3b 50%, #0f172a 100%);">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>অনুসন্ধান</span>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span><?php echo esc_html( get_search_query() ); ?></span>
      </div>

      <h1><i class="fas fa-magnifying-glass" style="color: var(--accent-color);"></i> অনুসন্ধানের ফলাফল</h1>
      <p>
        "<strong><?php echo esc_html( get_search_query() ); ?></strong>" কীওয়ার্ডে মোট 
        <strong><?php echo bdk_to_bengali_numerals( $wp_query->found_posts ); ?>টি</strong> সংবাদ পাওয়া গেছে।
      </p>
    </div>
  </section>

  <!-- Main Search Content Area -->
  <main class="container">
    <div class="archive-layout">
      
      <!-- Left Column: Search Results Grid -->
      <div class="archive-main-col">
        
        <!-- Search Input Bar for Refined Search -->
        <div style="margin-bottom: 2rem; background: var(--surface-color); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
          <form role="search" method="get" class="search-input-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; gap: 0.75rem;">
            <input type="search" name="s" placeholder="অন্য কোনো কীওয়ার্ড লিখে সার্চ করুন..." value="<?php echo get_search_query(); ?>" required style="flex-grow: 1; height: 44px; padding: 0 14px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); background: var(--surface-secondary); color: var(--text-main);">
            <button type="submit" class="submit-brand-btn" style="padding: 0 1.5rem; height: 44px; display: inline-flex; align-items: center; gap: 0.4rem;">
              <i class="fas fa-magnifying-glass"></i> নতুন সার্চ
            </button>
          </form>
        </div>

        <?php if ( have_posts() ) : ?>
          
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
                  <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                    <?php echo wp_trim_words( get_the_excerpt(), 16, '...' ); ?>
                  </p>
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
          <div class="static-content-box" style="text-align: center; padding: 3rem 1.5rem; background: var(--surface-color); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
            <i class="fas fa-magnifying-glass" style="font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3>কোনো সংবাদ বা তথ্য পাওয়া যায়নি</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">বানান সঠিক কিনা যাচাই করুন অথবা ভিন্ন কীওয়ার্ড দিয়ে পুনরায় অনুসন্ধান করুন।</p>
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
