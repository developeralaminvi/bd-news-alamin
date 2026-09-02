<?php
/**
 * The Header template for BD News Alamin Theme (100% Identical to HTML)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fb_url = get_theme_mod( 'bdk_social_facebook', 'https://www.facebook.com/dainikbangladesherkotha' );
$yt_url = get_theme_mod( 'bdk_social_youtube', 'https://youtube.com' );
$wa_url = get_theme_mod( 'bdk_social_whatsapp', 'https://wa.me/8801721029727' );
$tw_url = get_theme_mod( 'bdk_social_twitter', 'https://twitter.com' );
$ig_url = get_theme_mod( 'bdk_social_instagram', 'https://instagram.com' );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- ================= 1. TOP HEADER ================= -->
  <header class="top-header">
    <div class="container">
      <div class="top-left-info">
        <!-- Division Location Indicator & Switcher (Desktop) -->
        <div class="location-indicator" id="locationSelectorBtn" title="ক্লিক করে বিভাগ পরিবর্তন করুন">
          <i class="fas fa-location-dot"></i>
          <span id="currentLocationText">ঢাকা</span>
          <i class="fas fa-chevron-down" style="font-size: 0.65rem;"></i>
        </div>

        <!-- Live Clock & Dynamic Bengali Date -->
        <div class="live-time-date">
          <div class="live-clock">
            <span class="pulse-dot"></span>
            <span id="liveClockText">সকাল ১১:৩০:০০</span>
          </div>
          <span class="date-divider">|</span>
          <span id="liveDateFull" class="date-text"><?php echo esc_html( bdk_bengali_date() ); ?></span>
        </div>
      </div>

      <!-- Mobile Topbar Info Offcanvas Trigger Button -->
      <button class="topbar-mobile-btn" id="topbarInfoToggle" aria-label="তথ্য ও সেটিংস">
        <i class="fas fa-sliders"></i> <span>তথ্য</span>
      </button>

      <!-- Desktop Right Meta (Weather, Prayer, Socials) -->
      <div class="top-right-meta">
        <div class="weather-badge" id="bdkWeatherBadge" title="বাংলাদেশের আবহাওয়া">
          <i class="fas fa-cloud-sun" id="bdkWeatherIcon" style="color: #f59e0b;"></i>
          <span id="bdkWeatherText">লোড হচ্ছে...</span>
        </div>
        <div class="prayer-badge" id="bdkPrayerBadge" title="আসন্ন নামাজের সময়">
          <i class="fas fa-mosque" style="color: var(--primary-color);"></i>
          <span id="bdkPrayerText">নামাজ লোড...</span>
          <span id="bdkPrayerCountdown" style="font-size:0.7rem; font-weight:700; color:var(--accent-color); margin-left:4px;"></span>
        </div>

        <!-- Social Media Links -->
        <div class="social-top-links">
          <?php if ( $fb_url ) : ?><a href="<?php echo esc_url( $fb_url ); ?>" target="_blank" rel="noopener" title="Facebook"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
          <?php if ( $yt_url ) : ?><a href="<?php echo esc_url( $yt_url ); ?>" target="_blank" rel="noopener" title="YouTube"><i class="fab fa-youtube"></i></a><?php endif; ?>
          <?php if ( $ig_url ) : ?><a href="<?php echo esc_url( $ig_url ); ?>" target="_blank" rel="noopener" title="Instagram"><i class="fab fa-instagram"></i></a><?php endif; ?>
          <?php if ( $tw_url ) : ?><a href="<?php echo esc_url( $tw_url ); ?>" target="_blank" rel="noopener" title="X (Twitter)"><i class="fab fa-x-twitter"></i></a><?php endif; ?>
          <?php if ( $wa_url ) : ?><a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener" title="WhatsApp"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <!-- ================= 2. MAIN HEADER (Logo & Header Ad) ================= -->
  <section class="main-header">
    <div class="container">
      <!-- Brand Logo with actual SVG/Image graphic -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand-logo" title="<?php bloginfo( 'name' ); ?>">
        <?php bdk_header_logo(); ?>
      </a>

      <!-- Header Leaderboard Ad (728x90) -->
      <div class="header-ad-box">
        <?php bdk_display_ad_slot( 'bdk_header_ad', 'হেডার বিজ্ঞাপন স্লট', '728×90 Leaderboard' ); ?>
      </div>
    </div>
  </section>

  <!-- ================= 3. BOTTOM HEADER: MAIN NAVBAR ================= -->
  <nav class="navbar-wrapper">
    <div class="container nav-container">
      <!-- Mobile Menu Toggle Button -->
      <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="মেনু খুলুন">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Main Navigation Menu -->
      <?php
      if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'main-menu',
          'menu_id'        => 'mainMenu',
          'items_wrap'     => '<ul id="%1$s" class="%2$s"><li><a href="' . esc_url( home_url( '/' ) ) . '" class="home-icon-link" aria-label="প্রচ্ছদ"><i class="fas fa-house"></i></a></li>%3$s</ul>',
        ) );
      } else {
        bdk_fallback_menu();
      }
      ?>

      <!-- Right Nav Tools (Live TV, Search Modal, Theme Switcher) -->
      <div class="nav-actions">
        <!-- Mobile District & Upazila Filter Toggle Button -->
        <button class="mobile-filter-btn" id="mobileDistrictFilterToggle" aria-label="জেলা ফিল্টার" title="জেলা ও উপজেলা খবর ফিল্টার">
          <i class="fas fa-sliders" style="color: #f59e0b;"></i>
          <span>জেলা ফিল্টার</span>
        </button>

        <!-- Journalist Portal Button -->
        <?php if ( is_user_logged_in() ) : ?>
          <a href="<?php echo esc_url( home_url( '/reporter-dashboard' ) ); ?>" class="live-tv-btn" style="background: #10b981;">
            <i class="fas fa-gauge"></i> ড্যাশবোর্ড
          </a>
        <?php else : ?>
          <a href="<?php echo esc_url( home_url( '/reporter-account' ) ); ?>" class="live-tv-btn" style="background: #dc2626;">
            <i class="fas fa-id-card-clip"></i> সাংবাদিক নিয়োগ
          </a>
        <?php endif; ?>

        <!-- Live TV Button -->
        <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" class="live-tv-btn" title="লাইভ টিভি">
          <i class="fas fa-tv"></i> <span class="live-tv-text">লাইভ টিভি</span>
        </a>

        <!-- Search Modal Trigger Button -->
        <button class="nav-btn" id="searchModalToggle" aria-label="অনুসন্ধান করুন" title="খবর খুঁজুন">
          <i class="fas fa-magnifying-glass"></i>
        </button>

        <!-- Dark/Light Theme Switcher Button -->
        <button class="theme-switch-btn theme-toggle-btn" id="themeToggleBtn" aria-label="ডার্ক/লাইট মোড পরিবর্তন" title="ডার্ক/লাইট মোড পরিবর্তন">
          <div class="theme-toggle-track">
            <i class="fas fa-sun theme-icon-sun"></i>
            <i class="fas fa-moon theme-icon-moon"></i>
            <div class="theme-toggle-thumb"></div>
          </div>
        </button>
      </div>
    </div>
  </nav>

  <!-- ================= 4. DISTRICT & UPAZILA QUICK FILTER STRIP ================= -->
  <section class="district-filter-bar" style="background: var(--surface-secondary, #f8fafc); border-bottom: 1px solid var(--border-color, #e2e8f0); padding: 0.55rem 0; font-size: 0.88rem;">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
      
      <!-- Filter Inputs -->
      <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
        <span style="font-weight: 700; color: var(--primary-color); display: flex; align-items: center; gap: 6px; font-size: 0.88rem;">
          <i class="fas fa-location-dot" style="color: var(--primary-color);"></i> 📍 জেলা ও উপজেলা সংবাদ:
        </span>

        <!-- Select Division / Parent District -->
        <select id="districtFilterDivision" onchange="bdkFilterSubDistricts(this.value)" style="padding: 5px 12px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.82rem; font-weight: 600; cursor: pointer;">
          <option value="">-- ১. বিভাগ নির্বাচন করুন --</option>
          <?php
          $parent_districts = get_terms( array(
            'taxonomy'   => 'bdk_district',
            'parent'     => 0,
            'hide_empty' => false,
          ) );
          $grouped_data = array();
          if ( ! empty( $parent_districts ) && ! is_wp_error( $parent_districts ) ) {
            foreach ( $parent_districts as $p_term ) {
              echo '<option value="' . esc_attr( $p_term->term_id ) . '">' . esc_html( $p_term->name ) . '</option>';

              $children = get_terms( array(
                'taxonomy'   => 'bdk_district',
                'parent'     => $p_term->term_id,
                'hide_empty' => false,
              ) );
              $child_list = array();
              if ( ! empty( $children ) && ! is_wp_error( $children ) ) {
                foreach ( $children as $c_term ) {
                  $child_list[] = array(
                    'id'   => $c_term->term_id,
                    'name' => $c_term->name,
                    'url'  => get_term_link( $c_term ),
                  );
                }
              }
              $grouped_data[ $p_term->term_id ] = array(
                'name'     => $p_term->name,
                'url'      => get_term_link( $p_term ),
                'children' => $child_list,
              );
            }
          }
          ?>
        </select>

        <!-- Select Sub-District / Upazila -->
        <select id="districtFilterUpazila" disabled style="padding: 5px 12px; border-radius: 6px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.82rem; cursor: pointer; min-width: 190px;">
          <option value="">-- ২. জেলা/উপজেলা বেছে নিন --</option>
        </select>

        <!-- Filter Button -->
        <button type="button" onclick="bdkGoToDistrictNews()" class="submit-brand-btn" style="padding: 5px 14px; font-size: 0.8rem; border-radius: 6px; font-weight: 700; height: 32px; display: inline-flex; align-items: center; gap: 5px;">
          <i class="fas fa-filter"></i> খবর দেখুন
        </button>
      </div>

      <!-- Quick District Link Pills -->
      <div style="display: flex; gap: 0.4rem; align-items: center; flex-wrap: wrap;">
        <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600;">জনপ্রিয় এলাকা:</span>
        <?php
        $popular_districts = get_terms( array(
          'taxonomy'   => 'bdk_district',
          'number'     => 7,
          'hide_empty' => false,
        ) );
        if ( ! empty( $popular_districts ) && ! is_wp_error( $popular_districts ) ) {
          foreach ( $popular_districts as $pop_term ) {
            echo '<a href="' . esc_url( get_term_link( $pop_term ) ) . '" style="font-size: 0.78rem; background: var(--surface-color); border: 1px solid var(--border-color); padding: 2px 8px; border-radius: 4px; color: var(--text-main); text-decoration: none; font-weight: 600; transition: all 0.2s ease;">' . esc_html( $pop_term->name ) . '</a>';
          }
        }
        ?>
      </div>

    </div>
  </section>

  <script>
    var bdkDistrictData = <?php echo json_encode( $grouped_data, JSON_UNESCAPED_UNICODE ); ?>;

    function bdkFilterSubDistricts(divId) {
      var upazilaSelect = document.getElementById('districtFilterUpazila');
      if (!upazilaSelect) return;

      upazilaSelect.innerHTML = '<option value="">-- ২. জেলা/উপজেলা বেছে নিন --</option>';

      if (!divId || !bdkDistrictData[divId]) {
        upazilaSelect.disabled = true;
        return;
      }

      var divInfo = bdkDistrictData[divId];
      if (divInfo.children && divInfo.children.length > 0) {
        upazilaSelect.disabled = false;
        divInfo.children.forEach(function(item) {
          var opt = document.createElement('option');
          opt.value = item.url;
          opt.textContent = '└─ ' + item.name;
          upazilaSelect.appendChild(opt);
        });
      } else {
        upazilaSelect.disabled = true;
      }
    }

    function bdkGoToDistrictNews() {
      var divSelect = document.getElementById('districtFilterDivision');
      var upazilaSelect = document.getElementById('districtFilterUpazila');

      var targetUrl = '';
      if (upazilaSelect && upazilaSelect.value) {
        targetUrl = upazilaSelect.value;
      } else if (divSelect && divSelect.value && bdkDistrictData[divSelect.value]) {
        targetUrl = bdkDistrictData[divSelect.value].url;
      }

      if (targetUrl) {
        window.location.href = targetUrl;
      } else {
        alert('অনুগ্রহ করে আগে একটি বিভাগ নির্বাচন করুন।');
      }
    }
  </script>

  <!-- Mobile Backdrop Overlay -->
  <div class="mobile-nav-backdrop" id="mobileNavBackdrop"></div>

  <!-- Mobile Topbar Info Offcanvas Drawer -->
  <div class="topbar-offcanvas" id="topInfoOffcanvas">
    <div class="offcanvas-header">
      <h3><i class="fas fa-sliders"></i> দৈনিক ইনফো ও সেটিংস</h3>
      <button id="topbarOffcanvasClose" style="font-size: 1.25rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
    </div>

    <!-- Location Selector -->
    <div class="offcanvas-section">
      <h5>আপনার বিভাগ নির্বাচন করুন</h5>
      <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
        <button class="div-pill-btn active" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='ঢাকা';">ঢাকা</button>
        <button class="div-pill-btn" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='জামালপুর';">জামালপুর</button>
        <button class="div-pill-btn" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='চট্টগ্রাম';">চট্টগ্রাম</button>
        <button class="div-pill-btn" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='রাজশাহী';">রাজশাহী</button>
        <button class="div-pill-btn" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='সিলেট';">সিলেট</button>
        <button class="div-pill-btn" style="font-size: 0.8rem; padding: 0.25rem 0.65rem;" onclick="document.getElementById('currentLocationText').innerText='খুলনা';">খুলনা</button>
      </div>
    </div>

    <!-- Live Date & Calendar -->
    <div class="offcanvas-section">
      <h5>আজকের তারিখ ও পঞ্জিকা</h5>
      <p style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem;">
        <i class="far fa-calendar-alt" style="color: var(--primary-color);"></i> <?php echo esc_html( bdk_bengali_date() ); ?>
      </p>
    </div>

    <!-- Weather & Prayer -->
    <div class="offcanvas-section">
      <h5>আবহাওয়া ও নামাজের সময়</h5>
      <p style="font-size: 0.85rem; color: var(--text-body);" id="bdkWeatherMobile"><i class="fas fa-cloud-sun" style="color: #f59e0b;"></i> <span>লোড হচ্ছে...</span></p>
      <p style="font-size: 0.85rem; color: var(--text-body); margin-top: 0.25rem;" id="bdkPrayerMobile"><i class="fas fa-mosque" style="color: var(--primary-color);"></i> <span id="bdkPrayerMobileText">নামাজ লোড...</span> <span id="bdkPrayerMobileCountdown" style="font-weight:700; color:var(--accent-color);"></span></p>
    </div>

    <!-- Social Media Links -->
    <div class="offcanvas-section">
      <h5>সামাজিক যোগাযোগ মাধ্যম</h5>
      <div class="social-top-links" style="display: flex; gap: 0.6rem;">
        <?php if ( $fb_url ) : ?><a href="<?php echo esc_url( $fb_url ); ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
        <?php if ( $yt_url ) : ?><a href="<?php echo esc_url( $yt_url ); ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a><?php endif; ?>
        <?php if ( $wa_url ) : ?><a href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a><?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Mobile District & Upazila Filter Offcanvas Drawer -->
  <div class="topbar-offcanvas" id="districtFilterOffcanvas">
    <div class="offcanvas-header">
      <h3><i class="fas fa-location-dot" style="color: var(--primary-color);"></i> 📍 জেলা ও উপজেলা ফিল্টার</h3>
      <button id="districtFilterOffcanvasClose" style="font-size: 1.25rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
    </div>

    <div class="offcanvas-section">
      <label style="font-weight: 700; font-size: 0.88rem; color: var(--text-main); display: block; margin-bottom: 0.4rem;">১. বিভাগ নির্বাচন করুন</label>
      <select id="mobileDistrictFilterDivision" onchange="bdkFilterSubDistricts(this.value); bdkSyncMobileSubDistricts(this.value);" style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.9rem; font-weight: 600;">
        <option value="">-- ১. বিভাগ নির্বাচন করুন --</option>
        <?php
        if ( ! empty( $parent_districts ) && ! is_wp_error( $parent_districts ) ) {
          foreach ( $parent_districts as $p_term ) {
            echo '<option value="' . esc_attr( $p_term->term_id ) . '">' . esc_html( $p_term->name ) . '</option>';
          }
        }
        ?>
      </select>
    </div>

    <div class="offcanvas-section">
      <label style="font-weight: 700; font-size: 0.88rem; color: var(--text-main); display: block; margin-bottom: 0.4rem;">২. জেলা / উপজেলা নির্বাচন করুন</label>
      <select id="mobileDistrictFilterUpazila" disabled style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.9rem;">
        <option value="">-- ২. জেলা/উপজেলা বেছে নিন --</option>
      </select>
    </div>

    <div class="offcanvas-section" style="margin-top: 1rem;">
      <button type="button" onclick="bdkGoToMobileDistrictNews()" class="submit-brand-btn" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; font-weight: 700; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 8px;">
        <i class="fas fa-filter"></i> খবর দেখুন
      </button>
    </div>

    <div class="offcanvas-section">
      <h5>জনপ্রিয় এলাকাসমূহ</h5>
      <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
        <?php
        if ( ! empty( $popular_districts ) && ! is_wp_error( $popular_districts ) ) {
          foreach ( $popular_districts as $pop_term ) {
            echo '<a href="' . esc_url( get_term_link( $pop_term ) ) . '" style="font-size: 0.8rem; background: var(--surface-secondary); border: 1px solid var(--border-color); padding: 4px 10px; border-radius: 6px; color: var(--text-main); text-decoration: none; font-weight: 600;">' . esc_html( $pop_term->name ) . '</a>';
          }
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    function bdkSyncMobileSubDistricts(divId) {
      var upazilaSelect = document.getElementById('mobileDistrictFilterUpazila');
      if (!upazilaSelect) return;

      upazilaSelect.innerHTML = '<option value="">-- ২. জেলা/উপজেলা বেছে নিন --</option>';

      if (!divId || !bdkDistrictData[divId]) {
        upazilaSelect.disabled = true;
        return;
      }

      var divInfo = bdkDistrictData[divId];
      if (divInfo.children && divInfo.children.length > 0) {
        upazilaSelect.disabled = false;
        divInfo.children.forEach(function(item) {
          var opt = document.createElement('option');
          opt.value = item.url;
          opt.textContent = '└─ ' + item.name;
          upazilaSelect.appendChild(opt);
        });
      } else {
        upazilaSelect.disabled = true;
      }
    }

    function bdkGoToMobileDistrictNews() {
      var divSelect = document.getElementById('mobileDistrictFilterDivision');
      var upazilaSelect = document.getElementById('mobileDistrictFilterUpazila');

      var targetUrl = '';
      if (upazilaSelect && upazilaSelect.value) {
        targetUrl = upazilaSelect.value;
      } else if (divSelect && divSelect.value && bdkDistrictData[divSelect.value]) {
        targetUrl = bdkDistrictData[divSelect.value].url;
      }

      if (targetUrl) {
        window.location.href = targetUrl;
      } else {
        alert('অনুগ্রহ করে আগে একটি বিভাগ নির্বাচন করুন।');
      }
    }
  </script>

  <!-- ================= 4. BREAKING NEWS TICKER ================= -->
  <section class="breaking-news-bar">
    <div class="container breaking-container">
      <div class="breaking-badge">
        <i class="fas fa-bolt"></i> ব্রেকিং নিউজ
      </div>
      <div class="ticker-content">
        <div class="ticker-track">
          <?php
          $ticker_query = new WP_Query( array(
            'posts_per_page'      => 8,
            'ignore_sticky_posts' => 1,
          ) );
          if ( $ticker_query->have_posts() ) :
            while ( $ticker_query->have_posts() ) : $ticker_query->the_post();
          ?>
            <a href="<?php the_permalink(); ?>" class="ticker-item">
              <i class="fas fa-circle"></i> <?php the_title(); ?>
            </a>
          <?php
            endwhile;
            wp_reset_postdata();
          else :
          ?>
            <a href="#" class="ticker-item"><i class="fas fa-circle"></i> দেশজুড়ে ডিজিটাল সাংবাদিকতার নতুন দিগন্ত উন্মোচন করল 'দৈনিক বাংলাদেশের কথা'</a>
            <a href="#" class="ticker-item"><i class="fas fa-circle"></i> দেশের ৬৪ জেলায় প্রতিনিধি নিয়োগ কার্যক্রম শুরু হয়েছে, আবেদন ফরম অনলাইনে উন্মুক্ত</a>
            <a href="#" class="ticker-item"><i class="fas fa-circle"></i> জাতীয় অর্থনৈতিক পরিষদের গুরুত্বপূর্ণ বৈঠক আজ, একাধিক মেগা প্রকল্পে অনুমোদন</a>
            <a href="#" class="ticker-item"><i class="fas fa-circle"></i> জামালপুর সরিষাবাড়ীতে শান্তি নীড় কার্যালয়ে নতুন নিউজরুমের আধুনিকায়ন সম্পন্ন</a>
            <a href="#" class="ticker-item"><i class="fas fa-circle"></i> টি-টোয়েন্টি সিরিজে টাইগারদের চমকপ্রদ জয়, ক্রিকেটপ্রেমীদের আনন্দ মিছিল</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
