<?php
/**
 * Template Name: Terms & Conditions (ব্যবহারের শর্তাবলী)
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
        <span>ব্যবহারের শর্তাবলী</span>
      </div>
      <h1>ব্যবহারের শর্তাবলী (Terms & Conditions)</h1>
      <p>'দৈনিক বাংলাদেশের কথা' পোর্টাল ব্যবহারের সাধারণ নিয়মাবলী ও কপিরাইট শর্তাবলী।</p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main">
        
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          
          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.75rem;">১. কপিরাইট ও কনটেন্ট পুনর্ব্যবহার</h2>
          <p>
            'দৈনিক বাংলাদেশের কথা' পোর্টালে প্রকাশিত সকল সংবাদ, নিবন্ধ, ছবি, গ্রাফিক্স, অডিও ও ভিডিও কনটেন্টের একমাত্র স্বত্বাধিকারী এই কর্তৃপক্ষ। লিখিত পূর্বানুমতি ব্যতীত কোনো ব্যক্তি, বাণিজ্যিক প্রতিষ্ঠান বা অন্য কোনো মিডিয়া আমাদের কোনো কনটেন্ট আংশিক বা সম্পূর্ণরূপে কপি, পুনর্মুদ্রণ, প্রচার বা অন্য কোনো ওয়েবসাইটে প্রকাশ করতে পারবে না। অননুমোদিত কপিরাইট লঙ্ঘনের ক্ষেত্রে বাংলাদেশের কপিরাইট আইন ও তথ্যপ্রযুক্তি আইন অনুযায়ী আইনগত ব্যবস্থা গ্রহণ করা হবে।
          </p>

          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">২. পাঠক মন্তব্য ও মতামত নীতিমালা</h2>
          <p>
            সংবাদের নিচে পাঠকদের মন্তব্য প্রকাশের স্বাধীনতা রয়েছে। তবে কোনো ব্যক্তি বা গোষ্ঠীর বিরুদ্ধে ধর্মীয় অনুভূতিতে আঘাত, মানহানিকর বক্তব্য, অশালীন ভাষা, সাম্প্রদায়িক উস্কানি কিংবা আইনবিরোধী মন্তব্য সম্পূর্ণ নিষিদ্ধ। কর্তৃপক্ষ যেকোনো অনুপযুক্ত বা আপত্তিকর মন্তব্য কোনো পূর্ব নোটিশ ছাড়াই মুছে ফেলার কিংবা ব্যান করার সর্বময় ক্ষমতা সংরক্ষণ করে।
          </p>

          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">৩. তথ্যের সঠিকতা ও সংশোধন নীতি</h2>
          <p>
            আমরা সবসময় সত্য, নির্ভুল ও যাচাইকৃত তথ্য প্রকাশে দায়বদ্ধ। অনিচ্ছাকৃত কোনো তথ্যের ভুল বা অসঙ্গতি পরিলক্ষিত হলে উপযুক্ত প্রমাণের ভিত্তিতে সম্পাদকীয় নীতি অনুযায়ী তা দ্রুত সংশোধন (Correction / Clarification) করা হয়।
          </p>

          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">৪. শর্তাবলী পরিবর্তন ও পরিবর্ধন</h2>
          <p>
            কর্তৃপক্ষ প্রয়োজনবোধে যেকোনো সময় ব্যবহারের এই শর্তাবলী সংশোধন, সংযোজন বা পরিমার্জন করার অধিকার রাখে। সংশোধিত নীতিমালা প্রকাশের সাথে সাথে তা অবিলম্বে কার্যকর বলে গণ্য হবে।
          </p>

          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div style="margin-top: 1.5rem;">
              <?php the_content(); ?>
            </div>
          <?php endwhile; endif; ?>

        </div>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

<?php
get_footer();
