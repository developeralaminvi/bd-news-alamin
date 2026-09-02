<?php
/**
 * The Main Template File (Clean layout matching archive.php)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

  <!-- Index Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner" style="background: linear-gradient(135deg, #006a4e 0%, #064e3b 50%, #0f172a 100%);">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>সর্বশেষ সংবাদ</span>
      </div>
      <h1><?php bloginfo( 'name' ); ?></h1>
      <p><?php bloginfo( 'description' ); ?></p>
    </div>
  </section>

  <!-- Main Index Content Area -->
  <main class="container">
    <div class="archive-layout">
      
      <!-- Left Column: News Grid -->
      <div class="archive-main-col">
        
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
            <i class="fas fa-newspaper" style="font-size: 3.5rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h3>কোনো সংবাদ পাওয়া যায়নি</h3>
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
