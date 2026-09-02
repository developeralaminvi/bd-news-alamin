<?php
/**
 * The Footer template for BD News Alamin Theme (100% Identical to HTML)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$editor_publisher = get_theme_mod( 'bdk_editor_publisher', 'ছামিউল ইসলাম রিপন' );
$news_editor      = get_theme_mod( 'bdk_news_editor', 'মো. সিফাত' );
$office_address   = get_theme_mod( 'bdk_office_address', 'বাসা- উদেরপাড়া (শান্তি নীড়), পোস্ট- ভাটারা, উপজেলা- সরিষাবাড়ী, জেলা- জামালপুর।' );
$phone_hotline    = get_theme_mod( 'bdk_phone_hotline', '01680182662' );
$whatsapp_num     = get_theme_mod( 'bdk_whatsapp_number', '01721029727' );
$official_email   = get_theme_mod( 'bdk_official_email', 'dainikbangladesherkotha@gmail.com' );
$editor_email     = get_theme_mod( 'bdk_editor_email', 'siripon455520@gmail.com' );

$fb_url = get_theme_mod( 'bdk_social_facebook', 'https://www.facebook.com/dainikbangladesherkotha' );
$yt_url = get_theme_mod( 'bdk_social_youtube', 'https://youtube.com' );
$wa_url = get_theme_mod( 'bdk_social_whatsapp', 'https://wa.me/8801721029727' );
$tw_url = get_theme_mod( 'bdk_social_twitter', 'https://twitter.com' );
$ig_url = get_theme_mod( 'bdk_social_instagram', 'https://instagram.com' );
?>

  <!-- ================= 12b. FOOTER TOP BANNER AD ================= -->
  <div class="container footer-ad-container" style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
    <?php bdk_display_ad_slot( 'bdk_footer_ad', 'ফুটার ব্যানার বিজ্ঞাপন', '৯৭০×৯০ বা ৭২৮×৯০ Leaderboard' ); ?>
  </div>

  <!-- ================= 13. FOOTER SECTION ================= -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-top-grid">
        
        <!-- Col 1: Logo & Mission Summary -->
        <div class="footer-col footer-col-about">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" title="<?php bloginfo( 'name' ); ?>">
            <?php bdk_footer_logo(); ?>
          </a>
          <p>
            'দৈনিক বাংলাদেশের কথা' সত্য, বস্তুনিষ্ঠ ও নিরপেক্ষ সংবাদ প্রকাশে অঙ্গীকারবদ্ধ একটি আধুনিক অনলাইন গণমাধ্যম। দেশ ও বিদেশের সর্বশেষ খবর সবার আগে পৌঁছে দিতে আমরা নিরন্তর কাজ করছি।
          </p>
          <div class="footer-social-links">
            <?php if ( $fb_url ) : ?><a href="<?php echo esc_url( $fb_url ); ?>" class="social-btn social-fb" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
            <?php if ( $yt_url ) : ?><a href="<?php echo esc_url( $yt_url ); ?>" class="social-btn social-yt" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a><?php endif; ?>
            <?php if ( $ig_url ) : ?><a href="<?php echo esc_url( $ig_url ); ?>" class="social-btn social-ig" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a><?php endif; ?>
            <?php if ( $tw_url ) : ?><a href="<?php echo esc_url( $tw_url ); ?>" class="social-btn social-tw" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
            <?php if ( $wa_url ) : ?><a href="<?php echo esc_url( $wa_url ); ?>" class="social-btn social-wa" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
          </div>
        </div>

        <!-- Col 2: News Category Quick Links -->
        <div class="footer-col">
          <h4>সংবাদ বিভাগসমূহ</h4>
          <?php
          if ( has_nav_menu( 'footer_categories' ) ) {
            wp_nav_menu( array(
              'theme_location' => 'footer_categories',
              'container'      => false,
              'menu_class'     => 'footer-links-list',
            ) );
          } else {
            echo '<ul class="footer-links-list">';
            $f_cats = get_categories( array( 'number' => 7, 'hide_empty' => false ) );
            foreach ( $f_cats as $fc ) {
              echo '<li><a href="' . esc_url( get_category_link( $fc->term_id ) ) . '"><i class="fas fa-angle-right"></i> ' . esc_html( $fc->name ) . '</a></li>';
            }
            echo '</ul>';
          }
          ?>
        </div>

        <!-- Col 3: Useful Links & Static Pages -->
        <div class="footer-col">
          <h4>গুরুত্বপূর্ণ পাতা</h4>
          <?php
          if ( has_nav_menu( 'footer_legal' ) ) {
            wp_nav_menu( array(
              'theme_location' => 'footer_legal',
              'container'      => false,
              'menu_class'     => 'footer-links-list',
            ) );
          } else {
          ?>
            <ul class="footer-links-list">
              <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><i class="fas fa-angle-right"></i> আমাদের সম্পর্কে</a></li>
              <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><i class="fas fa-angle-right"></i> যোগাযোগ ও বিজ্ঞাপন</a></li>
              <li><a href="<?php echo esc_url( home_url( '/career' ) ); ?>"><i class="fas fa-angle-right" style="color: var(--accent-color);"></i> প্রতিনিধি নিয়োগ ফরম</a></li>
              <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><i class="fas fa-angle-right"></i> গোপনীয়তা নীতি</a></li>
              <li><a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><i class="fas fa-angle-right"></i> ব্যবহারের শর্তাবলী</a></li>
              <li><a href="<?php echo esc_url( home_url( '/cookies' ) ); ?>"><i class="fas fa-angle-right"></i> কুকি পলিসি</a></li>
            </ul>
          <?php } ?>
        </div>

        <!-- Col 4: Contact & Office Info -->
        <div class="footer-col">
          <h4>অফিস ও নিউজরুম</h4>
          <div class="footer-contact-info">
            <div class="info-item">
              <i class="fas fa-location-dot"></i>
              <span><?php echo esc_html( $office_address ); ?></span>
            </div>
            <div class="info-item">
              <i class="fas fa-phone-volume"></i>
              <span>ফোন: <a href="tel:<?php echo esc_attr( $phone_hotline ); ?>"><?php echo esc_html( $phone_hotline ); ?></a></span>
            </div>
            <div class="info-item">
              <i class="fab fa-whatsapp"></i>
              <span>হোয়াটসঅ্যাপ: <a href="https://wa.me/88<?php echo esc_attr( $whatsapp_num ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $whatsapp_num ); ?></a></span>
            </div>
            <div class="info-item">
              <i class="fas fa-envelope"></i>
              <span><a href="mailto:<?php echo esc_attr( $official_email ); ?>"><?php echo esc_html( $official_email ); ?></a></span>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer Editorial & Publisher Panel -->
      <div class="footer-editorial-panel">
        <div class="editorial-item">
          <h5>সম্পাদক ও প্রকাশক</h5>
          <p><?php echo esc_html( $editor_publisher ); ?></p>
        </div>
        <div class="editorial-item">
          <h5>বার্তা সম্পাদক</h5>
          <p><?php echo esc_html( $news_editor ); ?></p>
        </div>
        <div class="editorial-item">
          <h5>সম্পাদক ইমেইল</h5>
          <p><?php echo esc_html( $editor_email ); ?></p>
        </div>
        <div class="editorial-item">
          <h5>অফিসিয়াল হটলাইন</h5>
          <p><?php echo esc_html( bdk_to_bengali_numerals( $phone_hotline ) ); ?></p>
        </div>
      </div>

      <!-- Footer Bottom Copyright Bar -->
      <div class="footer-bottom-bar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
          <p>© <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?> (<?php echo esc_html( home_url() ); ?>) - সর্বস্বত্ব সংরক্ষিত।</p>
          <div class="footer-legal-links">
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">আমাদের সম্পর্কে</a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">যোগাযোগ</a>
            <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">প্রাইভেসি</a>
            <a href="<?php echo esc_url( home_url( '/terms' ) ); ?>">শর্তাবলী</a>
          </div>
        </div>
      </div>

    </div>
  </footer>

  <!-- ================= 14. SEARCH MODAL OVERLAY ================= -->
  <div class="search-modal-overlay" id="searchModalOverlay">
    <div class="search-modal-box">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="color: var(--primary-color); font-weight: 700;">খবর অনুসন্ধান করুন</h3>
        <button id="searchModalClose" style="font-size: 1.3rem; cursor: pointer; color: var(--text-muted);"><i class="fas fa-times"></i></button>
      </div>
      <form role="search" method="get" class="search-input-wrap" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="search" name="s" id="siteSearchInput" placeholder="কীওয়ার্ড বা খবর লিখে সার্চ করুন..." value="<?php echo get_search_query(); ?>" required>
        <button type="submit" class="submit-brand-btn" style="padding: 0.6rem 1.4rem;"><i class="fas fa-magnifying-glass"></i> খুঁজুন</button>
      </form>
      <div style="margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.85rem; color: var(--text-muted);">জনপ্রিয় সার্চ:</span>
        <?php
        $pop_cats = get_categories( array( 'number' => 4, 'hide_empty' => false ) );
        foreach ( $pop_cats as $pc ) :
        ?>
          <a href="<?php echo esc_url( get_category_link( $pc->term_id ) ); ?>" class="section-more-link" style="font-size: 0.8rem; padding: 0.2rem 0.6rem;">
            <?php echo esc_html( $pc->name ); ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- ================= 15. VIDEO PLAYER MODAL ================= -->
  <div class="video-modal-overlay" id="videoModalOverlay">
    <div class="video-modal-container">
      <button class="modal-close-btn" id="videoModalClose"><i class="fas fa-times"></i></button>
      <iframe id="videoModalIframe" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>

  <!-- Back to top button -->
  <button class="back-to-top-btn" id="backToTopBtn" aria-label="উপরে যান">
    <i class="fas fa-arrow-up"></i>
  </button>

  <?php wp_footer(); ?>
</body>
</html>
