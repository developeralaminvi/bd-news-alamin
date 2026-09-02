<?php
/**
 * The Front Page Template for BD News Alamin Theme (100% Dynamic & Pixel-Perfect)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

  <!-- ================= 5. HERO SECTION (3 Columns Layout) ================= -->
  <main class="hero-section">
    <div class="container">
      <div class="hero-grid-layout">
        
        <!-- Column 1: Tabbed Widget (Latest, Popular, Discussed) -->
        <div class="hero-tabs-box">
          <div class="hero-tab-nav">
            <button class="hero-tab-btn active" data-tab="tab-latest"><i class="far fa-clock"></i> সর্বশেষ</button>
            <button class="hero-tab-btn" data-tab="tab-popular"><i class="fas fa-fire"></i> জনপ্রিয়</button>
            <button class="hero-tab-btn" data-tab="tab-discussed"><i class="far fa-comments"></i> আলোচিত</button>
          </div>

          <div class="hero-tab-content">
            <!-- Tab 1: Latest News -->
            <div class="hero-tab-pane" id="tab-latest" style="display: block;">
              <div class="tab-news-list">
                <?php
                $latest_count = get_theme_mod( 'bdk_hero_tab_latest_count', 5 );
                $latest_query = new WP_Query( array( 'posts_per_page' => $latest_count, 'ignore_sticky_posts' => 1 ) );
                $idx = 1;
                if ( $latest_query->have_posts() ) :
                  while ( $latest_query->have_posts() ) : $latest_query->the_post();
                ?>
                  <a href="<?php the_permalink(); ?>" class="tab-news-item">
                    <span class="tab-item-num"><?php echo bdk_to_bengali_numerals( $idx++ ); ?></span>
                    <div class="tab-item-content">
                      <h4><?php the_title(); ?></h4>
                      <span class="tab-item-time"><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                    </div>
                  </a>
                <?php
                  endwhile;
                  wp_reset_postdata();
                else :
                ?>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">১</span><div class="tab-item-content"><h4>কৃষি ও খাদ্য উৎপাদনে স্বয়ংসম্পূর্ণতা অর্জনে সারা দেশে আধুনিক প্রযুক্তির প্রসার</h4><span class="tab-item-time"><i class="far fa-clock"></i> এইমাত্র</span></div></a>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">২</span><div class="tab-item-content"><h4>তৈরি পোশাক ও চামড়াশিল্পে নতুন বাজার সৃষ্টিতে ইউরোপীয় ইউনিয়নের সাথে বড় সমঝোতা</h4><span class="tab-item-time"><i class="far fa-clock"></i> এইমাত্র</span></div></a>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">৩</span><div class="tab-item-content"><h4>হোয়াইট হাউসে বৈশ্বিক জলবায়ু নিরাপত্তা ও কার্বন কর নিয়ে ঐতিহাসিক সমঝোতা চুক্তি</h4><span class="tab-item-time"><i class="far fa-clock"></i> এইমাত্র</span></div></a>
                <?php endif; ?>
              </div>
            </div>

            <!-- Tab 2: Popular News -->
            <div class="hero-tab-pane" id="tab-popular" style="display: none;">
              <div class="tab-news-list">
                <?php
                $pop_count = get_theme_mod( 'bdk_hero_tab_popular_count', 5 );
                $pop_query = new WP_Query( array(
                  'posts_per_page'      => $pop_count,
                  'meta_key'            => 'bdk_post_views_count',
                  'orderby'             => 'meta_value_num',
                  'order'               => 'DESC',
                  'ignore_sticky_posts' => 1
                ) );
                $idx = 1;
                if ( $pop_query->have_posts() ) :
                  while ( $pop_query->have_posts() ) : $pop_query->the_post();
                ?>
                  <a href="<?php the_permalink(); ?>" class="tab-news-item">
                    <span class="tab-item-num" style="background: var(--accent-light); color: var(--accent-color);"><?php echo bdk_to_bengali_numerals( $idx++ ); ?></span>
                    <div class="tab-item-content">
                      <h4><?php the_title(); ?></h4>
                      <span class="tab-item-time"><i class="fas fa-eye"></i> <?php echo bdk_get_post_views(); ?> বার পঠিত</span>
                    </div>
                  </a>
                <?php
                  endwhile;
                  wp_reset_postdata();
                else :
                ?>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">১</span><div class="tab-item-content"><h4>দেশব্যাপী অর্থনৈতিক পুনরুদ্ধার ও কর্মসংস্থান সৃষ্টিতে বড় ধরনের মাস্টারপ্ল্যান বাস্তবায়ন শুরু</h4><span class="tab-item-time"><i class="fas fa-eye"></i> ৪,৩৫০ বার পঠিত</span></div></a>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">২</span><div class="tab-item-content"><h4>মাঠের লড়াইয়ে নতুন কৌশলে জয়ের আনন্দে টাইগাররা</h4><span class="tab-item-time"><i class="fas fa-eye"></i> ৩,১২০ বার পঠিত</span></div></a>
                <?php endif; ?>
              </div>
            </div>

            <!-- Tab 3: Discussed News -->
            <div class="hero-tab-pane" id="tab-discussed" style="display: none;">
              <div class="tab-news-list">
                <?php
                $disc_count = get_theme_mod( 'bdk_hero_tab_discussed_count', 5 );
                $disc_query = new WP_Query( array(
                  'posts_per_page'      => $disc_count,
                  'orderby'             => 'comment_count',
                  'order'               => 'DESC',
                  'ignore_sticky_posts' => 1
                ) );
                $idx = 1;
                if ( $disc_query->have_posts() ) :
                  while ( $disc_query->have_posts() ) : $disc_query->the_post();
                ?>
                  <a href="<?php the_permalink(); ?>" class="tab-news-item">
                    <span class="tab-item-num"><?php echo bdk_to_bengali_numerals( $idx++ ); ?></span>
                    <div class="tab-item-content">
                      <h4><?php the_title(); ?></h4>
                      <span class="tab-item-time"><i class="far fa-comments"></i> <?php echo bdk_to_bengali_numerals( get_comments_number() ); ?> মন্তব্য</span>
                    </div>
                  </a>
                <?php
                  endwhile;
                  wp_reset_postdata();
                else :
                ?>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">১</span><div class="tab-item-content"><h4>সড়ক নিরাপত্তা নিশ্চিত করতে ট্রাফিক আইনে বড় পরিবর্তনের প্রস্তাবনা</h4><span class="tab-item-time"><i class="far fa-comments"></i> ৩৪০ মন্তব্য</span></div></a>
                  <a href="#" class="tab-news-item"><span class="tab-item-num">২</span><div class="tab-item-content"><h4>নতুন শিক্ষাবর্ষে পাঠ্যপুস্তক বিতরণ নিয়ে শিক্ষামন্ত্রণালয়ের জরুরি দিকনির্দেশনা</h4><span class="tab-item-time"><i class="far fa-comments"></i> ২১০ মন্তব্য</span></div></a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Column 2: Big Lead Story & Dual Sub Grid -->
        <div class="hero-center-col">
          <?php
          $lead_query = new WP_Query( array( 'posts_per_page' => 1, 'ignore_sticky_posts' => 1 ) );
          if ( $lead_query->have_posts() ) :
            while ( $lead_query->have_posts() ) : $lead_query->the_post();
              $post_cats = get_the_category();
              $cat_name  = ! empty( $post_cats ) ? $post_cats[0]->name : 'প্রধান সংবাদ';
          ?>
            <article class="hero-lead-card">
              <a href="<?php the_permalink(); ?>" class="hero-lead-img-wrapper">
                <span class="hero-cat-tag"><?php echo esc_html( $cat_name ); ?></span>
                <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
              </a>
              <div class="hero-lead-body">
                <h2 class="hero-lead-title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <p class="hero-lead-excerpt">
                  <?php echo wp_trim_words( get_the_excerpt(), 28, '...' ); ?>
                </p>
                <div class="news-meta-row">
                  <span><i class="far fa-user"></i> <?php the_author(); ?></span>
                  <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                  <?php
                  $dist = wp_get_object_terms( get_the_ID(), 'bdk_district' );
                  if ( ! empty( $dist ) && ! is_wp_error( $dist ) ) {
                    echo '<span><i class="fas fa-location-dot"></i> ' . esc_html( $dist[0]->name ) . '</span>';
                  } else {
                    echo '<span><i class="fas fa-location-dot"></i> ঢাকা</span>';
                  }
                  ?>
                </div>
              </div>
            </article>
          <?php
            endwhile;
            wp_reset_postdata();
          endif;
          ?>

          <!-- Dual Sub-Lead Grid -->
          <div class="hero-dual-grid">
            <?php
            $sub_query = new WP_Query( array( 'posts_per_page' => 2, 'offset' => 1, 'ignore_sticky_posts' => 1 ) );
            if ( $sub_query->have_posts() ) :
              while ( $sub_query->have_posts() ) : $sub_query->the_post();
            ?>
              <article class="sub-lead-card">
                <a href="<?php the_permalink(); ?>" class="sub-lead-img-box">
                  <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                </a>
                <div class="sub-lead-body">
                  <h3 class="sub-lead-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <div class="news-meta-row" style="margin-top: auto;">
                    <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                  </div>
                </div>
              </article>
            <?php
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>

        <!-- Column 3: Trending Stack & Special Highlight Card -->
        <div class="hero-right-col">
          <!-- Special Highlight Card -->
          <div class="special-highlight-card">
            <span class="special-tag"><i class="fas fa-star"></i> বিশেষ প্রতিবেদন</span>
            <h4>সরিষাবাড়ী ও জামালপুরের ঐতিহ্যের রূপরেখা</h4>
            <p>যমুনা নদীর অববাহিকার উর্বর মাটি ও মানুষের জীবনসংগ্রামের গৌরবোজ্জ্বল ইতিহাস নিয়ে বিশেষ অনুসন্ধান।</p>
            <a href="<?php echo esc_url( home_url( '/category/saradesh' ) ); ?>" class="special-read-btn">সম্পূর্ণ পড়ুন <i class="fas fa-arrow-right"></i></a>
          </div>

          <!-- Trending News Stack -->
          <div class="trending-news-stack">
            <div class="widget-title-bar">
              <h3><i class="fas fa-fire" style="color: var(--accent-color);"></i> ট্রেন্ডিং খবর</h3>
              <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>" class="view-all">সবগুলো <i class="fas fa-angle-right"></i></a>
            </div>

            <div class="trending-list">
              <?php
              $trend_count = get_theme_mod( 'bdk_hero_trending_count', 3 );
              $trend_query = new WP_Query( array( 'posts_per_page' => $trend_count, 'offset' => 3, 'ignore_sticky_posts' => 1 ) );
              if ( $trend_query->have_posts() ) :
                while ( $trend_query->have_posts() ) : $trend_query->the_post();
              ?>
                <a href="<?php the_permalink(); ?>" class="trending-item">
                  <div class="trending-img">
                    <?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
                  </div>
                  <div class="trending-text">
                    <h5><?php the_title(); ?></h5>
                  </div>
                </a>
              <?php
                endwhile;
                wp_reset_postdata();
              endif;
              ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- ================= 6. SECTION 1: NATIONAL & POLITICS ================= -->
  <section class="section-national">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2><a href="<?php echo esc_url( home_url( '/category/national' ) ); ?>">জাতীয় ও রাজনীতি</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/category/national' ) ); ?>" class="section-more-link">আরও দেখুন <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="national-grid">
        <div class="national-lead-wrapper">
          <?php
          $nat_args = array( 'posts_per_page' => 3, 'category_name' => 'national', 'ignore_sticky_posts' => 1 );
          $nat_query = new WP_Query( $nat_args );
          if ( ! $nat_query->have_posts() ) {
            $nat_query = new WP_Query( array( 'posts_per_page' => 3, 'ignore_sticky_posts' => 1 ) );
          }

          $nat_idx = 0;
          if ( $nat_query->have_posts() ) :
            while ( $nat_query->have_posts() ) : $nat_query->the_post();
              if ( 0 === $nat_idx ) :
          ?>
                <article class="card-national-lead">
                  <div class="img-box">
                    <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                  </div>
                  <div class="content-box">
                    <span class="hero-cat-tag" style="position: static; margin-bottom: 0.5rem; display: inline-block;">জাতীয়</span>
                    <h3 style="font-size: 1.35rem; font-weight: 800; line-height: 1.35; margin-bottom: 0.5rem;">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p style="font-size: 0.92rem; color: var(--text-body); margin-bottom: 0.75rem;">
                      <?php echo wp_trim_words( get_the_excerpt(), 22, '...' ); ?>
                    </p>
                    <div class="news-meta-row">
                      <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                      <span><i class="far fa-user"></i> <?php the_author(); ?></span>
                    </div>
                  </div>
                </article>
          <?php
              else :
          ?>
                <article class="card-national-sub">
                  <div class="sub-img">
                    <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                  </div>
                  <div class="sub-body">
                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="news-meta-row">
                      <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                    </div>
                  </div>
                </article>
          <?php
              endif;
              $nat_idx++;
            endwhile;
            wp_reset_postdata();
          endif;
          ?>
        </div>

        <div class="politics-side-box">
          <div class="widget-title-bar">
            <h3><i class="fas fa-landmark" style="color: var(--primary-color);"></i> রাজনৈতিক অঙ্গন</h3>
          </div>

          <div class="politics-list">
            <?php
            $pol_args = array( 'posts_per_page' => 3, 'category_name' => 'politics', 'ignore_sticky_posts' => 1 );
            $pol_query = new WP_Query( $pol_args );
            if ( ! $pol_query->have_posts() ) {
              $pol_query = new WP_Query( array( 'posts_per_page' => 3, 'offset' => 4, 'ignore_sticky_posts' => 1 ) );
            }

            if ( $pol_query->have_posts() ) :
              while ( $pol_query->have_posts() ) : $pol_query->the_post();
            ?>
              <a href="<?php the_permalink(); ?>" class="politics-list-item">
                <div class="thumb">
                  <?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
                </div>
                <div>
                  <h4><?php the_title(); ?></h4>
                  <span class="tab-item-time"><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                </div>
              </a>
            <?php
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= 7. SECTION 2: SARADESH / DISTRICT NEWS (100% DYNAMIC) ================= -->
  <section class="section-saradesh">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2><a href="<?php echo esc_url( home_url( '/category/saradesh' ) ); ?>">সারাদেশ ও জেলা বার্তা</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/category/saradesh' ) ); ?>" class="section-more-link">সকল জেলা <i class="fas fa-chevron-right"></i></a>
      </div>

      <!-- Interactive Division Pills -->
      <div class="division-tab-pills" id="saradeshDivisionTabs">
        <button class="div-pill-btn active" data-division="all">সব বিভাগ</button>
        <button class="div-pill-btn" data-division="mymensingh">ময়মনসিংহ ও জামালপুর</button>
        <button class="div-pill-btn" data-division="dhaka">ঢাকা</button>
        <button class="div-pill-btn" data-division="chittagong">চট্টগ্রাম</button>
        <button class="div-pill-btn" data-division="rajshahi">রাজশাহী</button>
        <button class="div-pill-btn" data-division="khulna">খুলনা</button>
        <button class="div-pill-btn" data-division="barisal">বরিশাল</button>
        <button class="div-pill-btn" data-division="sylhet">সিলেট</button>
        <button class="div-pill-btn" data-division="rangpur">রংপুর</button>
      </div>

      <!-- Dynamic District Grid Cards -->
      <div class="saradesh-grid" id="saradeshGridContainer">
        <?php
        // Query posts that have a district assigned, or category saradesh
        $saradesh_args = array(
          'posts_per_page'      => 8,
          'ignore_sticky_posts' => 1,
          'tax_query'           => array(
            'relation' => 'OR',
            array(
              'taxonomy' => 'bdk_district',
              'operator' => 'EXISTS',
            ),
            array(
              'taxonomy' => 'category',
              'field'    => 'slug',
              'terms'    => array( 'saradesh', 'district' ),
            ),
          ),
        );
        $saradesh_query = new WP_Query( $saradesh_args );
        if ( ! $saradesh_query->have_posts() ) {
          $saradesh_query = new WP_Query( array( 'posts_per_page' => 4, 'ignore_sticky_posts' => 1 ) );
        }

        if ( $saradesh_query->have_posts() ) :
          while ( $saradesh_query->have_posts() ) : $saradesh_query->the_post();
            
            // Determine District & Division dynamically
            $d_terms = wp_get_object_terms( get_the_ID(), 'bdk_district' );
            $district_display = 'সারাদেশ';
            $div_slug = 'all';

            if ( ! empty( $d_terms ) && ! is_wp_error( $d_terms ) ) {
              $term = $d_terms[0];
              $district_display = $term->name;
              $parent_term = $term->parent ? get_term( $term->parent, 'bdk_district' ) : null;
              $comb = $term->name . ' ' . ( $parent_term ? $parent_term->name : '' );

              if ( preg_match( '/(ময়মনসিংহ|জামালপুর|সরিষাবাড়ী|শেরপুর|নেত্রকোণা)/u', $comb ) ) {
                $div_slug = 'mymensingh';
              } elseif ( preg_match( '/(ঢাকা|গাজীপুর|নারায়ণগঞ্জ|টাঙ্গাইল|নরসিংদী|মুন্সীগঞ্জ|মানিকগঞ্জ)/u', $comb ) ) {
                $div_slug = 'dhaka';
              } elseif ( preg_match( '/(চট্টগ্রাম|কক্সবাজার|কুমিল্লা|ফেনী|নোয়াখালী)/u', $comb ) ) {
                $div_slug = 'chittagong';
              } elseif ( preg_match( '/(রাজশাহী|বগুড়া|পাবনা|সিরাজগঞ্জ|নাটোর)/u', $comb ) ) {
                $div_slug = 'rajshahi';
              } elseif ( preg_match( '/(সিলেট|মৌলভীবাজার|শ্রীমঙ্গল|সুনামগঞ্জ)/u', $comb ) ) {
                $div_slug = 'sylhet';
              } elseif ( preg_match( '/(খুলনা|যশোর|কুষ্টিয়া|বাগেরহাট)/u', $comb ) ) {
                $div_slug = 'khulna';
              } elseif ( preg_match( '/(বরিশাল|পটুয়াখালী|ভোলা)/u', $comb ) ) {
                $div_slug = 'barisal';
              } elseif ( preg_match( '/(রংপুর|দিনাজপুর|কুড়িগ্রাম)/u', $comb ) ) {
                $div_slug = 'rangpur';
              }
            } else {
              // Distribute demo cards across divisions
              $divisions_cycle = array( 'mymensingh', 'chittagong', 'sylhet', 'rajshahi' );
              $div_slug = $divisions_cycle[ $saradesh_query->current_post % 4 ];
              $district_display = 'সরিষাবাড়ী, জামালপুর';
            }
        ?>
          <article class="district-news-card" data-division="<?php echo esc_attr( $div_slug ); ?>">
            <a href="<?php the_permalink(); ?>" class="district-img-box">
              <span class="district-badge-loc"><i class="fas fa-map-pin"></i> <?php echo esc_html( $district_display ); ?></span>
              <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
            </a>
            <div class="district-card-body">
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <div class="news-meta-row">
                <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
              </div>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- ================= 8. SECTION 3: ENTERTAINMENT & LIFESTYLE (DYNAMIC) ================= -->
  <section class="section-entertainment">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2><a href="<?php echo esc_url( home_url( '/category/entertainment' ) ); ?>">বিনোদন ও লাইফস্টাইল</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/category/entertainment' ) ); ?>" class="section-more-link">আরও বিনোদন <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="lifestyle-cards-grid">
        <?php
        $ent_args = array( 'posts_per_page' => 4, 'category_name' => 'entertainment,lifestyle', 'ignore_sticky_posts' => 1 );
        $ent_query = new WP_Query( $ent_args );
        if ( ! $ent_query->have_posts() ) {
          $ent_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 2, 'ignore_sticky_posts' => 1 ) );
        }

        if ( $ent_query->have_posts() ) :
          while ( $ent_query->have_posts() ) : $ent_query->the_post();
            $e_cats = get_the_category();
            $e_tag = ! empty( $e_cats ) ? $e_cats[0]->name : 'বিনোদন';
        ?>
          <article class="lifestyle-card">
            <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
            <div class="lifestyle-overlay">
              <span class="lifestyle-tag"><?php echo esc_html( $e_tag ); ?></span>
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- ================= 8b. HOMEPAGE MID-CONTENT BANNER AD ================= -->
  <div class="container homepage-mid-ad-container" style="margin-top: 1.75rem; margin-bottom: 1.75rem;">
    <?php bdk_display_ad_slot( 'bdk_mid_ad', 'হোমপেজ মিড-কনটেন্ট বিজ্ঞাপন', '৯৭০×৯০ বা ৭২৮×৯০ Leaderboard' ); ?>
  </div>

  <!-- ================= 9. SECTION: ECONOMY & BUSINESS MATRIX WITH MARKET TICKER (DYNAMIC) ================= -->
  <section class="section-economy-matrix">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2><a href="<?php echo esc_url( home_url( '/category/economy' ) ); ?>">অর্থনীতি ও বাণিজ্য মেট্রিক্স</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/category/economy' ) ); ?>" class="section-more-link">বাজার বিশ্লেষণ <i class="fas fa-chevron-right"></i></a>
      </div>

      <!-- Live Stock & Currency Metrics Ticker Strip -->
      <div class="stock-ticker-strip">
        <div class="stock-ticker-label">
          <i class="fas fa-chart-line"></i> বাজার আপডেট (লাইভ)
        </div>
        <div class="ticker-metrics-row" id="marketTickerRow">
          <div class="metric-pill" id="dsexMetric">
            <span>DSEX সূচক:</span>
            <strong class="metric-val">৫,৪২০.৫০</strong>
            <span class="trend-badge trend-up"><i class="fas fa-caret-up"></i> +০.৭৮%</span>
          </div>
          <div class="metric-pill" id="dollarMetric">
            <span>ডলার রেট:</span>
            <strong class="metric-val" id="usdRateText">৳১২১.৫০</strong>
            <span class="trend-badge trend-up"><i class="fas fa-caret-up"></i> +০.১০</span>
          </div>
          <div class="metric-pill" id="goldMetric">
            <span>স্বর্ণ (২২ ক্যারেট):</span>
            <strong class="metric-val">৳১,২৮,৫০০/ভরি</strong>
            <span class="trend-badge trend-down"><i class="fas fa-caret-down"></i> -৳৭৫০</span>
          </div>
          <div class="metric-pill" id="oilMetric">
            <span>অপরিশোধিত তেল:</span>
            <strong class="metric-val">$৮২.৪০/ব্যারেল</strong>
            <span class="trend-badge trend-up"><i class="fas fa-caret-up"></i> +১.২%</span>
          </div>
          <div class="metric-pill" id="remitMetric">
            <span>রেমিট্যান্স প্রবাহ:</span>
            <strong class="metric-val">$২.২৫ বিলিয়ন</strong>
            <span class="trend-badge trend-up"><i class="fas fa-caret-up"></i> রেকর্ড বৃদ্ধি</span>
          </div>
        </div>
      </div>

      <!-- Economy Matrix Grid -->
      <div class="economy-matrix-grid">
        <?php
        $eco_args = array( 'posts_per_page' => 4, 'category_name' => 'economy,business', 'ignore_sticky_posts' => 1 );
        $eco_query = new WP_Query( $eco_args );
        if ( ! $eco_query->have_posts() ) {
          $eco_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 4, 'ignore_sticky_posts' => 1 ) );
        }

        $eco_idx = 0;
        $lead_eco_post = null;
        $sub_eco_posts = array();

        if ( $eco_query->have_posts() ) {
          while ( $eco_query->have_posts() ) {
            $eco_query->the_post();
            if ( 0 === $eco_idx ) {
              $lead_eco_post = clone $post;
            } else {
              $sub_eco_posts[] = clone $post;
            }
            $eco_idx++;
          }
          wp_reset_postdata();
        }

        if ( $lead_eco_post ) :
          global $post;
          $post = $lead_eco_post;
          setup_postdata( $post );
        ?>
          <!-- Lead Card with Market Badge -->
          <article class="economy-lead-card">
            <a href="<?php the_permalink(); ?>" class="economy-lead-img-box">
              <span class="market-highlight-badge"><i class="fas fa-arrow-trend-up"></i> শীর্ষ বাণিজ্য সংবাদ</span>
              <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
            </a>
            <div class="economy-lead-body">
              <span class="hero-cat-tag" style="position: static; margin-bottom: 0.5rem; display: inline-block;">রপ্তানি খাত</span>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p>
                <?php echo wp_trim_words( get_the_excerpt(), 24, '...' ); ?>
              </p>
              <div class="news-meta-row" style="margin-top: auto;">
                <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
                <span><i class="far fa-user"></i> <?php the_author(); ?></span>
              </div>
            </div>
          </article>
        <?php
          wp_reset_postdata();
        endif;
        ?>

        <!-- Sub Stack 3 Compact Items -->
        <div class="economy-sub-stack">
          <?php
          if ( ! empty( $sub_eco_posts ) ) :
            foreach ( $sub_eco_posts as $sp ) :
              $post = $sp;
              setup_postdata( $post );
          ?>
            <article class="economy-mini-item">
              <div class="economy-mini-thumb">
                <?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
              </div>
              <div class="economy-mini-info">
                <span style="font-size: 0.72rem; color: #10b981; font-weight: 700;"><i class="fas fa-bolt"></i> বাণিজ্য</span>
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <span style="font-size: 0.75rem; color: var(--text-muted);"><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
              </div>
            </article>
          <?php
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= 10. SECTION 4: SPORTS & TECH (DYNAMIC) ================= -->
  <section class="section-sports-tech">
    <div class="container">
      <div class="sports-tech-grid">
        
        <!-- Sports Column -->
        <div class="sports-col-box">
          <div class="section-header-block">
            <div class="section-title-wrap">
              <span class="title-bar-accent"></span>
              <h2><a href="<?php echo esc_url( home_url( '/category/sports' ) ); ?>">খেলাধুলা</a></h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/category/sports' ) ); ?>" class="section-more-link">স্কোর ও খবর <i class="fas fa-chevron-right"></i></a>
          </div>

          <div class="featured-sub-split">
            <?php
            $sports_args = array( 'posts_per_page' => 3, 'category_name' => 'sports', 'ignore_sticky_posts' => 1 );
            $sports_query = new WP_Query( $sports_args );
            if ( ! $sports_query->have_posts() ) {
              $sports_query = new WP_Query( array( 'posts_per_page' => 3, 'offset' => 1, 'ignore_sticky_posts' => 1 ) );
            }

            $sp_idx = 0;
            if ( $sports_query->have_posts() ) :
              while ( $sports_query->have_posts() ) : $sports_query->the_post();
                if ( 0 === $sp_idx ) :
            ?>
                  <article class="sports-main-card">
                    <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
                    <div class="sports-main-overlay">
                      <span class="special-tag">ক্রিকেট ও ফুটবল</span>
                      <h3><a href="<?php the_permalink(); ?>" style="color: #fff;"><?php the_title(); ?></a></h3>
                    </div>
                  </article>
            <?php
                else :
            ?>
                  <article class="sub-lead-card">
                    <div class="sub-lead-body">
                      <span class="badge-type" style="color: var(--accent-color); font-weight: 700; font-size: 0.75rem;">খেলা</span>
                      <h4 style="font-size: 0.95rem; font-weight: 700; margin-top: 0.25rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                  </article>
            <?php
                endif;
                $sp_idx++;
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>

        <!-- Technology Column -->
        <div class="tech-col-box">
          <div class="section-header-block">
            <div class="section-title-wrap">
              <span class="title-bar-accent"></span>
              <h2><a href="<?php echo esc_url( home_url( '/category/tech' ) ); ?>">বিজ্ঞান ও প্রযুক্তি</a></h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/category/tech' ) ); ?>" class="section-more-link">প্রযুক্তি জগৎ <i class="fas fa-chevron-right"></i></a>
          </div>

          <div class="featured-sub-split">
            <?php
            $tech_args = array( 'posts_per_page' => 3, 'category_name' => 'tech,technology', 'ignore_sticky_posts' => 1 );
            $tech_query = new WP_Query( $tech_args );
            if ( ! $tech_query->have_posts() ) {
              $tech_query = new WP_Query( array( 'posts_per_page' => 3, 'offset' => 3, 'ignore_sticky_posts' => 1 ) );
            }

            $tc_idx = 0;
            if ( $tech_query->have_posts() ) :
              while ( $tech_query->have_posts() ) : $tech_query->the_post();
                if ( 0 === $tc_idx ) :
            ?>
                  <article class="sports-main-card">
                    <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
                    <div class="sports-main-overlay">
                      <span class="special-tag" style="background: #2563eb;">প্রযুক্তি উদ্ভাবন</span>
                      <h3><a href="<?php the_permalink(); ?>" style="color: #fff;"><?php the_title(); ?></a></h3>
                    </div>
                  </article>
            <?php
                else :
            ?>
                  <article class="sub-lead-card">
                    <div class="sub-lead-body">
                      <span class="badge-type" style="color: #2563eb; font-weight: 700; font-size: 0.75rem;">আইটি সংবাদ</span>
                      <h4 style="font-size: 0.95rem; font-weight: 700; margin-top: 0.25rem;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                  </article>
            <?php
                endif;
                $tc_idx++;
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 11. SECTION: WORLD NEWS MAGAZINE GRID (DYNAMIC) ================= -->
  <section class="section-world-news">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent" style="background: #2563eb;"></span>
          <h2><a href="<?php echo esc_url( home_url( '/category/international' ) ); ?>">আন্তর্জাতিক ও বিশ্ব দৃষ্টিভঙ্গি</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/category/international' ) ); ?>" class="section-more-link">বিশ্ব সংবাদ <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="world-magazine-grid">
        <?php
        $world_args = array( 'posts_per_page' => 4, 'category_name' => 'international,world', 'ignore_sticky_posts' => 1 );
        $world_query = new WP_Query( $world_args );
        if ( ! $world_query->have_posts() ) {
          $world_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 5, 'ignore_sticky_posts' => 1 ) );
        }

        if ( $world_query->have_posts() ) :
          while ( $world_query->have_posts() ) : $world_query->the_post();
        ?>
          <article class="world-magazine-card">
            <div class="world-card-img-wrap">
              <span class="read-time-pill"><i class="far fa-clock"></i> ৩ মিনিট</span>
              <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
            </div>
            <div class="world-card-body">
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <p><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></p>
              <div class="news-meta-row" style="margin-top: auto;">
                <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
              </div>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- ================= 12. SECTION 5: MULTIMEDIA & VIDEO CAROUSEL (DYNAMIC) ================= -->
  <section class="section-video-carousel">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2 style="color: #ffffff;"><i class="fab fa-youtube" style="color: var(--accent-color);"></i> ভিডিও সংবাদ ও টকশো</h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" class="section-more-link" style="background: rgba(255,255,255,0.15); color: #fff;">সব ভিডিও <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="video-carousel-container">
        <?php
        $vid_query = new WP_Query( array( 'post_type' => 'bdk_video', 'posts_per_page' => 5, 'ignore_sticky_posts' => 1 ) );
        $first_vid = null;
        $side_vids = array();

        if ( $vid_query->have_posts() ) {
          $v_idx = 0;
          while ( $vid_query->have_posts() ) {
            $vid_query->the_post();
            if ( 0 === $v_idx ) {
              $first_vid = clone $post;
            } else {
              $side_vids[] = clone $post;
            }
            $v_idx++;
          }
          wp_reset_postdata();
        }

        if ( $first_vid ) :
          global $post;
          $post = $first_vid;
          setup_postdata( $post );
          $yt_id = get_post_meta( get_the_ID(), '_bdk_youtube_url', true ) ?: 'dQw4w9WgXcQ';
        ?>
          <!-- Main Highlight Video Card -->
          <div class="video-main-player-card">
            <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
            <button class="video-play-btn-large" data-video-id="<?php echo esc_attr( $yt_id ); ?>" aria-label="ভিডিও চালান">
              <i class="fas fa-play"></i>
            </button>
            <div class="video-main-caption">
              <span class="special-tag"><i class="fas fa-circle-dot"></i> বিশেষ বুলেটিন</span>
              <h3><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>" style="color:#fff;"><?php the_title(); ?></a></h3>
            </div>
          </div>
        <?php
          wp_reset_postdata();
        else :
        ?>
          <div class="video-main-player-card">
            <img src="https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=1000&auto=format&fit=crop&q=80" alt="ভিডিও থাম্বনেইল" loading="lazy">
            <button class="video-play-btn-large" data-video-id="dQw4w9WgXcQ" aria-label="ভিডিও চালান">
              <i class="fas fa-play"></i>
            </button>
            <div class="video-main-caption">
              <span class="special-tag"><i class="fas fa-circle-dot"></i> বিশেষ টকশো</span>
              <h3>সমসাময়িক রাজনীতি ও অর্থনীতির আগামী দিনের চ্যালেঞ্জ | দৈনিক বাংলাদেশের কথা বিশ্লেষণ</h3>
            </div>
          </div>
        <?php endif; ?>

        <!-- Video Playlist Side Stack -->
        <div class="video-sidebar-list">
          <?php
          if ( ! empty( $side_vids ) ) :
            foreach ( $side_vids as $sv ) :
              $post = $sv;
              setup_postdata( $post );
              $yt_sub_id = get_post_meta( get_the_ID(), '_bdk_youtube_url', true ) ?: 'dQw4w9WgXcQ';
              $duration  = get_post_meta( get_the_ID(), '_bdk_video_duration', true ) ?: '০৮:৪৫ মিনিট';
          ?>
            <div class="video-sidebar-item" data-video-id="<?php echo esc_attr( $yt_sub_id ); ?>">
              <div class="video-thumb-small">
                <?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
                <div class="play-icon-tiny"><i class="fas fa-play"></i></div>
              </div>
              <div>
                <h4><?php the_title(); ?></h4>
                <span style="font-size: 0.75rem; color: #94a3b8;"><i class="far fa-clock"></i> <?php echo esc_html( $duration ); ?></span>
              </div>
            </div>
          <?php
            endforeach;
            wp_reset_postdata();
          else :
          ?>
            <div class="video-sidebar-item" data-video-id="dQw4w9WgXcQ">
              <div class="video-thumb-small"><img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?w=200&auto=format&fit=crop&q=80" alt="ভিডিও ১"><div class="play-icon-tiny"><i class="fas fa-play"></i></div></div>
              <div><h4>ডিজিটাল গণমাধ্যমের ভবিষ্যৎ ও বিশ্বাসযোগ্যতা রক্ষা</h4><span style="font-size: 0.75rem; color: #94a3b8;"><i class="far fa-clock"></i> ০৮:৪৫ মিনিট</span></div>
            </div>
            <div class="video-sidebar-item" data-video-id="dQw4w9WgXcQ">
              <div class="video-thumb-small"><img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=200&auto=format&fit=crop&q=80" alt="ভিডিও ২"><div class="play-icon-tiny"><i class="fas fa-play"></i></div></div>
              <div><h4>কৃত্রিম উপগ্রহ উৎক্ষেপণে বিজ্ঞানীদের অক্লান্ত পরিশ্রম</h4><span style="font-size: 0.75rem; color: #94a3b8;"><i class="far fa-clock"></i> ১২:২০ মিনিট</span></div>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </section>

  <!-- ================= 13. SECTION: INVESTIGATIVE SPOTLIGHT & SERIES TIMELINE (DYNAMIC) ================= -->
  <section class="section-investigative-series">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent" style="background: #f59e0b;"></span>
          <h2 style="color: #ffffff;"><i class="fas fa-magnifying-glass-chart" style="color: #f59e0b;"></i> বিশেষ অনুসন্ধান ও ধারাবাহিক ফিচার</h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/archive?cat=investigation' ) ); ?>" class="section-more-link" style="background: rgba(255,255,255,0.15); color: #fff;">অনুসন্ধান সিরিজ <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="investigative-container-box">
        <?php
        $inv_args = array( 'posts_per_page' => 4, 'category_name' => 'investigation', 'ignore_sticky_posts' => 1 );
        $inv_query = new WP_Query( $inv_args );
        if ( ! $inv_query->have_posts() ) {
          $inv_query = new WP_Query( array( 'posts_per_page' => 4, 'offset' => 3, 'ignore_sticky_posts' => 1 ) );
        }

        $lead_inv = null;
        $timeline_invs = array();
        $in_idx = 0;

        if ( $inv_query->have_posts() ) {
          while ( $inv_query->have_posts() ) {
            $inv_query->the_post();
            if ( 0 === $in_idx ) {
              $lead_inv = clone $post;
            } else {
              $timeline_invs[] = clone $post;
            }
            $in_idx++;
          }
          wp_reset_postdata();
        }

        if ( $lead_inv ) :
          global $post;
          $post = $lead_inv;
          setup_postdata( $post );
        ?>
          <article class="investigative-spotlight-card">
            <div class="spotlight-media-frame">
              <span class="investigative-badge-gold"><i class="fas fa-fingerprint"></i> অনুসন্ধানী মহাপরিকল্পনা</span>
              <?php bdk_post_thumbnail( 'bdk-large', '', get_the_title() ); ?>
            </div>
            <div class="spotlight-body-box">
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p>
                <?php echo wp_trim_words( get_the_excerpt(), 26, '...' ); ?>
              </p>
              <ul class="spotlight-highlights-list">
                <li><i class="fas fa-check-circle"></i> চরাঞ্চলের ৩০ হাজার হেক্টর কৃষিজমি পুনরুদ্ধারের বিশেষ রূপরেখা</li>
                <li><i class="fas fa-check-circle"></i> নদী শাসনের আধুনিক প্রযুক্তি ব্যবহারের কার্যকারিতা সমীক্ষা</li>
              </ul>
              <div class="news-meta-row" style="margin-top: auto; color: #94a3b8;">
                <span style="color: #34d399;"><i class="fas fa-user-shield"></i> অনুসন্ধানী টিম, দৈনিক বাংলাদেশের কথা</span>
                <span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
              </div>
            </div>
          </article>
        <?php
          wp_reset_postdata();
        endif;
        ?>

        <div class="investigative-timeline-box">
          <?php
          $ep_num = 1;
          if ( ! empty( $timeline_invs ) ) :
            foreach ( $timeline_invs as $t_post ) :
              $post = $t_post;
              setup_postdata( $post );
          ?>
            <article class="timeline-episode-card">
              <div class="episode-number-circle"><?php echo bdk_to_bengali_numerals( $ep_num++ ); ?></div>
              <div class="episode-content">
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <p><?php echo wp_trim_words( get_the_excerpt(), 14, '...' ); ?></p>
              </div>
            </article>
          <?php
            endforeach;
            wp_reset_postdata();
          endif;
          ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= 14. SECTION 6: OPINION & READER COMMENTS (DYNAMIC) ================= -->
  <section class="section-opinion">
    <div class="container">
      <div class="section-header-block">
        <div class="section-title-wrap">
          <span class="title-bar-accent"></span>
          <h2><a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>"><i class="fas fa-comments" style="color: var(--primary-color);"></i> মতামত ও সম্পাদকীয়</a></h2>
        </div>
        <a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>" class="section-more-link">সকল মতামত ও মন্তব্য <i class="fas fa-chevron-right"></i></a>
      </div>

      <div class="opinion-grid">
        <?php
        // Fetch latest approved comments across all posts
        $latest_comments = get_comments( array(
          'status'  => 'approve',
          'number'  => 3,
          'orderby' => 'comment_date',
          'order'   => 'DESC',
        ) );

        if ( ! empty( $latest_comments ) ) :
          foreach ( $latest_comments as $cmt ) :
            $post_id   = $cmt->comment_post_ID;
            $post_link = get_permalink( $post_id );
            $post_title = get_the_title( $post_id );
            $cmt_link  = get_comment_link( $cmt );
        ?>
          <article class="opinion-card">
            <div class="opinion-author-header">
              <div class="author-avatar">
                <?php echo get_avatar( $cmt, 54 ); ?>
              </div>
              <div class="author-info">
                <h4>
                  <?php echo esc_html( $cmt->comment_author ); ?>
                  <span class="comment-verified-badge" title="ভেরিফাইড পাঠক" style="color: var(--primary-color); font-size: 0.8rem; margin-left: 2px;"><i class="fas fa-circle-check"></i></span>
                </h4>
                <span><i class="far fa-clock"></i> <?php echo esc_html( human_time_diff( strtotime( $cmt->comment_date ), current_time( 'timestamp' ) ) ); ?> আগে</span>
              </div>
            </div>
            
            <div class="opinion-quote-body">
              <a href="<?php echo esc_url( $cmt_link ); ?>">
                "<?php echo esc_html( wp_trim_words( wp_strip_all_tags( $cmt->comment_content ), 16, '...' ) ); ?>"
              </a>
            </div>

            <div style="margin-top: auto; padding-top: 0.75rem; border-top: 1px dashed var(--border-color); font-size: 0.78rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center;">
              <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 65%;">
                <i class="fas fa-newspaper" style="color: var(--primary-color);"></i> <?php echo esc_html( wp_trim_words( $post_title, 6, '...' ) ); ?>
              </span>
              <a href="<?php echo esc_url( $post_link ); ?>" style="color: var(--accent-color); font-weight: 700; text-decoration: none;">
                উত্তর দিন <i class="fas fa-angle-right"></i>
              </a>
            </div>
          </article>
        <?php
          endforeach;
        else :
        ?>
          <article class="opinion-card">
            <div class="opinion-author-header">
              <div class="author-avatar">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="লেখক ১" loading="lazy">
              </div>
              <div class="author-info">
                <h4>ছামিউল ইসলাম রিপন</h4>
                <span>সম্পাদক ও প্রকাশক</span>
              </div>
            </div>
            <div class="opinion-quote-body">
              <a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>">"বস্তুনিষ্ঠ সাংবাদিকতা কোনো আপসের জায়গা নয়; সত্য প্রকাশের সাহসই জাতির আসল শক্তি।"</a>
            </div>
          </article>

          <article class="opinion-card">
            <div class="opinion-author-header">
              <div class="author-avatar">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80" alt="লেখক ২" loading="lazy">
              </div>
              <div class="author-info">
                <h4>মো. সিফাত</h4>
                <span>বার্তা সম্পাদক</span>
              </div>
            </div>
            <div class="opinion-quote-body">
              <a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>">"তৃণমূলের সমস্যা যখন জাতীয় শিরোনাম হয়, তখনই সত্যিকারের গণমাধ্যম সার্থক হয়ে ওঠে।"</a>
            </div>
          </article>

          <article class="opinion-card">
            <div class="opinion-author-header">
              <div class="author-avatar">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80" alt="লেখক ৩" loading="lazy">
              </div>
              <div class="author-info">
                <h4>ড. কামরুল হাসান</h4>
                <span>কলামিস্ট ও অর্থনীতিবিদ</span>
              </div>
            </div>
            <div class="opinion-quote-body">
              <a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>">"মুদ্রাস্ফীতি নিয়ন্ত্রণ ও স্থানীয় উৎপাদনের মেলবন্ধনই পারে স্থিতিশীল অর্থনৈতিক মুক্তি দিতে।"</a>
            </div>
          </article>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ================= 15. SECTION 7: PHOTO GALLERY (DYNAMIC) ================= -->
  <section class="section-photo-gallery">
    <div class="container">
      <div class="photo-gallery-full-wrap">
        
        <!-- Photo Gallery Box -->
        <div class="photo-gallery-card-box">
          <div class="section-header-block">
            <div class="section-title-wrap">
              <span class="title-bar-accent"></span>
              <h2><i class="fas fa-camera-retro" style="color: var(--primary-color);"></i> <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>">ছবির গল্প ও ফটো ফিচার</a></h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>" class="section-more-link">সকল ছবির গল্প <i class="fas fa-chevron-right"></i></a>
          </div>

          <div class="photo-tiles-grid">
            <?php
            $photo_query = new WP_Query( array(
              'post_type'           => 'bdk_photo_story',
              'posts_per_page'      => 3,
              'ignore_sticky_posts' => 1,
            ) );

            if ( $photo_query->have_posts() ) :
              while ( $photo_query->have_posts() ) : $photo_query->the_post();
                $g_images = get_post_meta( get_the_ID(), '_bdk_gallery_images', true );
                $p_count = $g_images ? count( explode( ',', $g_images ) ) + 1 : 8;
            ?>
              <a href="<?php the_permalink(); ?>" class="photo-tile-item" style="display: block; text-decoration: none;">
                <?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
                <span class="photo-count-badge"><i class="far fa-images"></i> <?php echo bdk_to_bengali_numerals( $p_count ); ?>টি ছবি</span>
                <h5><?php the_title(); ?></h5>
              </a>
            <?php
              endwhile;
              wp_reset_postdata();
            else :
            ?>
              <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>" class="photo-tile-item" style="display: block;">
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=700&auto=format&fit=crop&q=80" alt="প্রকৃতি" loading="lazy">
                <span class="photo-count-badge"><i class="far fa-images"></i> ১২টি ছবি</span>
                <h5>বর্ষায় বাংলার অপরূপ রূপ</h5>
              </a>

              <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>" class="photo-tile-item" style="display: block;">
                <img src="https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=500&auto=format&fit=crop&q=80" alt="গ্রামীণ জীবন" loading="lazy">
                <span class="photo-count-badge"><i class="far fa-images"></i> ৮টি ছবি</span>
                <h5>কৃষকের সোনালী হাসি ও ফসল কাটার উৎসব</h5>
              </a>

              <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>" class="photo-tile-item" style="display: block;">
                <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=500&auto=format&fit=crop&q=80" alt="সাংস্কৃতিক সন্ধ্যা" loading="lazy">
                <span class="photo-count-badge"><i class="far fa-images"></i> ১৫টি ছবি</span>
                <h5>জাতীয় নাট্যোৎসবের জমকালো মঞ্চ</h5>
              </a>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </section>

<?php
get_footer();
