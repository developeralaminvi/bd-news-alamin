<?php
/**
 * Template Name: Contact & Advertising (যোগাযোগ ও বিজ্ঞাপন)
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
?>

  <!-- Page Hero Banner (High Contrast & Full Width matching archive.php) -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>যোগাযোগ ও বিজ্ঞাপন</span>
      </div>
      <h1>যোগাযোগ ও বিজ্ঞাপন (Contact & Advertising)</h1>
      <p>সংবাদ পাঠানো, বিজ্ঞাপন প্রদান অথবা যেকোনো তথ্যের জন্য আমাদের সাথে সরাসরি যোগাযোগ করুন</p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main">
        
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          
          <div class="contact-grid-info" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="contact-info-card" style="background: var(--surface-secondary); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
              <i class="fas fa-location-dot" style="font-size: 1.75rem; color: var(--primary-color); margin-bottom: 0.75rem; display: block;"></i>
              <h4 style="font-size: var(--fs-base); font-weight: 700;">অফিস ঠিকানা</h4>
              <p style="font-size: var(--fs-sm); color: var(--text-muted); margin-top: 0.25rem;"><?php echo esc_html( $office_address ); ?></p>
            </div>

            <div class="contact-info-card" style="background: var(--surface-secondary); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
              <i class="fas fa-phone-volume" style="font-size: 1.75rem; color: var(--primary-color); margin-bottom: 0.75rem; display: block;"></i>
              <h4 style="font-size: var(--fs-base); font-weight: 700;">হটলাইন ও ফোন</h4>
              <p style="font-size: var(--fs-sm); color: var(--text-muted); margin-top: 0.25rem;">
                <a href="tel:<?php echo esc_attr( $phone_hotline ); ?>" style="color: var(--primary-color); font-weight: 700;"><?php echo esc_html( $phone_hotline ); ?></a>
              </p>
            </div>

            <div class="contact-info-card" style="background: var(--surface-secondary); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
              <i class="fab fa-whatsapp" style="font-size: 1.75rem; color: #25d366; margin-bottom: 0.75rem; display: block;"></i>
              <h4 style="font-size: var(--fs-base); font-weight: 700;">হোয়াটসঅ্যাপ ডিরেক্ট</h4>
              <p style="font-size: var(--fs-sm); color: var(--text-muted); margin-top: 0.25rem;">
                <a href="https://wa.me/88<?php echo esc_attr( $whatsapp_num ); ?>" target="_blank" rel="noopener" style="color: #25d366; font-weight: 700;"><?php echo esc_html( $whatsapp_num ); ?></a>
              </p>
            </div>

            <div class="contact-info-card" style="background: var(--surface-secondary); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
              <i class="fas fa-envelope-open-text" style="font-size: 1.75rem; color: var(--primary-color); margin-bottom: 0.75rem; display: block;"></i>
              <h4 style="font-size: var(--fs-base); font-weight: 700;">অফিসিয়াল ইমেইল</h4>
              <p style="font-size: var(--fs-sm); color: var(--text-muted); margin-top: 0.25rem;">
                <a href="mailto:<?php echo esc_attr( $official_email ); ?>"><?php echo esc_html( $official_email ); ?></a>
              </p>
            </div>
          </div>

          <h2 style="font-size: 1.4rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1rem;">সরাসরি বার্তা পাঠান</h2>
          <form id="contactMessageForm" onsubmit="event.preventDefault(); alert('ধন্যবাদ! আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে।'); this.reset();">
            <div class="comment-form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <input type="text" class="comment-input-field" placeholder="আপনার পূর্ণ নাম *" required style="height: 44px; padding: 0 12px; border-radius: 4px; border: 1px solid var(--border-color);">
              <input type="email" class="comment-input-field" placeholder="আপনার ইমেইল ঠিকানা *" required style="height: 44px; padding: 0 12px; border-radius: 4px; border: 1px solid var(--border-color);">
            </div>
            <div style="margin-bottom: 1rem;">
              <input type="text" class="comment-input-field" placeholder="বার্তার বিষয় (যেমন: বিজ্ঞাপন বুকিং / সংবাদ)" required style="width: 100%; height: 44px; padding: 0 12px; border-radius: 4px; border: 1px solid var(--border-color);">
            </div>
            <div style="margin-bottom: 1rem;">
              <textarea rows="5" class="comment-input-field" placeholder="আপনার বার্তা বিস্তারিত লিখুন..." required style="width: 100%; padding: 12px; border-radius: 4px; border: 1px solid var(--border-color);"></textarea>
            </div>
            <button type="submit" class="submit-brand-btn" style="padding: 0.75rem 2rem; font-size: var(--fs-sm);"><i class="fas fa-paper-plane"></i> বার্তা পাঠান</button>
          </form>

        </div>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
get_footer();
