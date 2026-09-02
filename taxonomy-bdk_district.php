<?php
/**
 * Taxonomy Template for District News Archive (জেলা ও উপজেলা সংবাদ আর্কাইভ)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$current_term = get_queried_object();
$term_name    = $current_term->name;
$parent_id    = $current_term->parent;
$parent_name  = $parent_id ? get_term( $parent_id, 'bdk_district' )->name : '';
?>

  <!-- District Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner" style="background: linear-gradient(135deg, #064e3b 0%, #006a4e 50%, #0f172a 100%);">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <a href="<?php echo esc_url( home_url( '/category/saradesh' ) ); ?>" style="color: #fff;">সারাদেশ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <?php if ( $parent_name ) : ?>
          <span><?php echo esc_html( $parent_name ); ?></span>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <?php endif; ?>
        <span><?php echo esc_html( $term_name ); ?></span>
      </div>

      <h1><i class="fas fa-map-location-dot" style="color: var(--accent-color);"></i> <?php echo esc_html( $term_name ); ?> জেলার সংবাদ</h1>
      <p>
        <?php echo $current_term->description ?: esc_html( $term_name ) . ' ও সংলগ্ন অঞ্চলের উন্নয়ন, রাজনীতি, কৃষি, অপরাধ, বাণিজ্য এবং জনগুরুত্বপূর্ণ সকল ঘটনার তাৎক্ষণিক ও বস্তুনিষ্ঠ আপডেট।'; ?>
      </p>
    </div>
  </section>

  <!-- Main Archive Content Area -->
  <main class="container">
    <div class="archive-layout">
      
      <!-- Left Column: News Grid -->
      <div class="archive-main-col">
        
        <!-- District Archive Top Banner Ad Slot -->
        <?php bdk_display_ad_slot( 'bdk_archive_ad', 'জেলা সংবাদ শীর্ষ ব্যানার বিজ্ঞাপন', '728×90 Leaderboard' ); ?>
        
        <!-- Sibling / Sub-district Pills -->
        <?php
        $filter_parent = $parent_id ? $parent_id : $current_term->term_id;
        $sibling_terms = get_terms( array(
          'taxonomy'   => 'bdk_district',
          'parent'     => $filter_parent,
          'hide_empty' => false,
        ) );

        if ( ! empty( $sibling_terms ) && ! is_wp_error( $sibling_terms ) ) :
        ?>
          <div class="division-tab-pills" style="margin-bottom: 1.75rem; flex-wrap: wrap;">
            <a href="<?php echo esc_url( get_term_link( $filter_parent, 'bdk_district' ) ); ?>" class="div-pill-btn <?php echo ( $current_term->term_id === $filter_parent ) ? 'active' : ''; ?>">
              সকল উপজেলা
            </a>
            <?php foreach ( $sibling_terms as $st ) : ?>
              <a href="<?php echo esc_url( get_term_link( $st ) ); ?>" class="div-pill-btn <?php echo ( $current_term->term_id === $st->term_id ) ? 'active' : ''; ?>">
                <?php echo esc_html( $st->name ); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
          
          <div class="archive-news-grid">
            <?php while ( have_posts() ) : the_post(); ?>
              <article class="district-news-card" style="display: flex; flex-direction: column; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow);">
                <a href="<?php the_permalink(); ?>" class="district-img-box" style="position: relative; aspect-ratio: 16/10; overflow: hidden;">
                  <span class="district-badge-loc" style="position: absolute; top: 10px; left: 10px; z-index: 2; background: #e11d48; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 3px 8px; border-radius: 4px;">
                    <i class="fas fa-map-pin"></i> <?php echo esc_html( $term_name ); ?>
                  </span>
                  <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                </a>
                <div class="district-card-body" style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1;">
                  <h4 style="font-size: 1.05rem; font-weight: 700; line-height: 1.4; margin-bottom: 0.5rem;">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h4>
                  <p style="font-size: 0.88rem; color: var(--text-muted); margin-bottom: 0.75rem;">
                    <?php echo wp_trim_words( get_the_excerpt(), 16, '...' ); ?>
                  </p>
                  <div class="news-meta-row" style="margin-top: auto; font-size: 0.78rem;">
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
            <i class="fas fa-location-dot" style="font-size: 3.5rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
            <h3>এই জেলা/উপজেলায় বর্তমানে কোনো সংবাদ নেই</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">অনুগ্রহ করে অন্যান্য জেলা বা জাতীয় খবর অনুসন্ধান করুন।</p>
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
