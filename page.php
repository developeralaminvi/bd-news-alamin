<?php
/**
 * The Default Page Template for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
?>

  <!-- Page Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span><?php the_title(); ?></span>
      </div>
      <h1><?php the_title(); ?></h1>
      <p><?php echo has_excerpt() ? get_the_excerpt() : 'দৈনিক বাংলাদেশের কথা - সত্য ও ন্যায়ের পথে নিরন্তর'; ?></p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main" id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          <?php the_content(); ?>
        </div>
      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>
    </div>
  </main>

<?php
endwhile;

get_footer();
