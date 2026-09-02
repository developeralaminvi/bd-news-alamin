<?php
/**
 * Template Name: About Us (আমাদের সম্পর্কে)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$editor_publisher = get_theme_mod( 'bdk_editor_publisher', 'ছামিউল ইসলাম রিপন' );
$news_editor      = get_theme_mod( 'bdk_news_editor', 'মো. সিফাত' );
$office_address   = get_theme_mod( 'bdk_office_address', 'বাসা_ উদেরপাড়া (শান্তি নীড়), পোস্ট - ভাটারা, উপজেলা- সরিষাবাড়ী, জেলা- জামালপুর।' );
$phone_hotline    = get_theme_mod( 'bdk_phone_hotline', '01680182662' );
$whatsapp_num     = get_theme_mod( 'bdk_whatsapp_number', '01721029727' );
$official_email   = get_theme_mod( 'bdk_official_email', 'dainikbangladesherkotha@gmail.com' );
$editor_email     = get_theme_mod( 'bdk_editor_email', 'siripon455520@gmail.com' );
?>

  <!-- Page Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>আমাদের সম্পর্কে</span>
      </div>
      <h1>আমাদের সম্পর্কে (About Us)</h1>
      <p>'দৈনিক বাংলাদেশের কথা' - সত্য, বস্তুনিষ্ঠ ও নিরপেক্ষ সাংবাদিকতায় অঙ্গীকারবদ্ধ জাতীয় গণমাধ্যম</p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main">
        
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.75rem;">আমাদের লক্ষ্য ও উদ্দেশ্য</h2>
          <p>
            'দৈনিক বাংলাদেশের কথা' একটি স্বাধীন, নির্ভীক ও উন্নয়নমুখী জাতীয় অনলাইন গণমাধ্যম। আমাদের মূল অঙ্গীকার হলো গ্রামীণ তৃণমূলের মানুষের সুখ-দুঃখ, সমস্যা, সম্ভাবনা এবং সাফল্যকে জাতীয় ও আন্তর্জাতিক পরিমণ্ডলে তুলে ধরা। আমরা কোনো দলীয় বা ব্যক্তিস্বার্থের পক্ষপাতিত্ব না করে সত্যকে সাহসের সাথে প্রকাশ করতে প্রতিশ্রুতিবদ্ধ।
          </p>

          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">আমাদের সম্পাদকীয় নীতি</h2>
          <p>
            ১. <strong>বস্তুনিষ্ঠতা:</strong> তথ্যের নির্ভুলতা ও যাচাই-বাছাই ব্যতীত কোনো সংবাদ প্রকাশ না করা।<br>
            ২. <strong>নিরপেক্ষতা:</strong> সকল পক্ষের মতামত প্রকাশের সমান সুযোগ দেওয়া।<br>
            ৩. <strong>মানবাধিকার ও উন্নয়ন:</strong> দেশপ্রেম, মুক্তিযুদ্ধের চেতনা, নারীর ক্ষমতায়ন এবং সামাজিক ন্যায়বিচার প্রতিষ্ঠায় সোচ্চার থাকা।
          </p>

          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">সম্পাদকীয় ও ব্যবস্থাপনা পরিষদ</h2>
          <div class="opinion-grid" style="margin: 1.5rem 0; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            <div class="opinion-card">
              <div class="opinion-author-header">
                <div class="author-avatar" style="width: 55px; height: 55px; border-radius: 50%; overflow: hidden;">
                  <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="সম্পাদক">
                </div>
                <div class="author-info">
                  <h4><?php echo esc_html( $editor_publisher ); ?></h4>
                  <span>সম্পাদক ও প্রকাশক</span>
                  <span style="font-size: 0.78rem; color: var(--text-muted);"><i class="fas fa-envelope"></i> <?php echo esc_html( $editor_email ); ?></span>
                </div>
              </div>
            </div>

            <div class="opinion-card">
              <div class="opinion-author-header">
                <div class="author-avatar" style="width: 55px; height: 55px; border-radius: 50%; overflow: hidden;">
                  <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80" alt="বার্তা সম্পাদক">
                </div>
                <div class="author-info">
                  <h4><?php echo esc_html( $news_editor ); ?></h4>
                  <span>বার্তা সম্পাদক</span>
                  <span style="font-size: 0.78rem; color: var(--text-muted);"><i class="fas fa-envelope"></i> dainikbangladesherkotha@gmail.com</span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
get_footer();
