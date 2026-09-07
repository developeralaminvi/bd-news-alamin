<?php
/**
 * Template Name: Career & Representative Application (প্রতিনিধি নিয়োগ আবেদন)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

  <!-- Page Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>প্রতিনিধি নিয়োগ</span>
      </div>
      <h1>প্রতিনিধি নিয়োগ ও ক্যারিয়ার (Career & Reporter Application)</h1>
      <p>সারা দেশে জেলা ও উপজেলা পর্যায়ে দক্ষ, সাহসী ও অনুসন্ধানী সাংবাদিক নিয়োগ চলছে</p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main">
        
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.75rem;">আমাদের সাথে যোগ দিন</h2>
          <p>
            '<?php echo bdk_get_site_name(); ?>' পরিবারে আপনিও হতে পারেন একজন সাহসী সংবাদযোদ্ধা। আপনার জেলা, উপজেলা বা ক্যাম্পাসের অনিয়ম, উন্নয়ন ও সম্ভাবনার কথা সবার সামনে তুলে ধরতে আজই আবেদন করুন।
          </p>

          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">প্রয়োজনীয় যোগ্যতা</h2>
          <ul style="list-style: disc; margin-left: 1.5rem; margin-bottom: 1.5rem; color: var(--text-body); font-size: var(--fs-sm);">
            <li>স্নাতক/ডিগ্রি পাস (অভিজ্ঞদের ক্ষেত্রে শিক্ষাগত যোগ্যতা শিথিলযোগ্য)।</li>
            <li>স্মার্টফোন ও ইন্টারনেট ব্যবহারের দক্ষতা থাকতে হবে।</li>
            <li>সংবাদ সংগ্রহ ও ছবি তোলার সক্ষমতা।</li>
            <li>স্থানীয় ভাষায় সাবলীল ও নির্ভুল বাংলা লেখার দক্ষতা।</li>
          </ul>

          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 1rem;">ডিজিটাল সাংবাদিক নিয়োগ আবেদন</h2>
          <div style="background: var(--surface-secondary); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); text-align: center; margin-top: 1rem;">
            <?php if ( bdk_is_recruitment_enabled() ) : ?>
              <p style="font-weight: 600; font-size: 1.05rem; margin-bottom: 1rem; color: var(--text-main);">
                আপনার ছবি, তথ্য ও সিভি আপলোড করে সরাসরি অনলাইন পোর্টালে সাংবাদিক পদে আবেদন করুন।
              </p>
              <a href="<?php echo esc_url( home_url( '/reporter-account?tab=register' ) ); ?>" class="submit-brand-btn" style="padding: 0.85rem 2.2rem; font-size: 1rem; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-id-card-clip"></i> <?php echo esc_html( bdk_get_recruitment_btn_text() ); ?> ফরমটি পূরণ করুন
              </a>
            <?php else : ?>
              <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 1.25rem; text-align: center; border-radius: 4px;">
                <i class="fas fa-circle-info" style="font-size: 1.6rem; color: #dc2626; margin-bottom: 0.5rem; display: block;"></i>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #991b1b; margin-bottom: 0.4rem;">সাংবাদিক নিয়োগ কার্যক্রম বর্তমানে স্থগিত</h3>
                <p style="color: #7f1d1d; margin: 0; font-size: 0.92rem;">
                  <?php echo esc_html( bdk_get_recruitment_closed_message() ); ?>
                </p>
              </div>
            <?php endif; ?>
          </div>

        </div>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
get_footer();
