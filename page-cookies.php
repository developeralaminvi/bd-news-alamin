<?php
/**
 * Template Name: Cookies Policy (কুকি পলিসি)
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
        <span>কুকিজ পলিসি</span>
      </div>
      <h1>কুকি নীতি (Cookies Policy)</h1>
      <p>আমাদের ওয়েবসাইট ব্যবহারের সময় কুকিজ কীভাবে আপনার ব্রাউজিং অভিজ্ঞতা আরও দ্রুত ও সহজ করে।</p>
    </div>
  </section>

  <!-- Main Content Area -->
  <main class="container">
    <div class="single-page-layout">
      <article class="single-article-main">
        
        <div class="static-content-box" style="background: var(--surface-color); padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); line-height: 1.8;">
          
          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.75rem;">১. কুকিজ (Cookies) কী?</h2>
          <p>
            কুকিজ হলো ক্ষুদ্র টেক্সট ফাইল যা কোনো ওয়েবসাইটে প্রবেশের সময় ব্যবহারকারীর ডিভাইসে (কম্পিউটার, ট্যাবলেট বা স্মার্টফোন) স্বয়ংক্রিয়ভাবে সংরক্ষিত হয়। এটি পরবর্তী ভিজিটে ব্যবহারকারীকে চিনতে এবং সাইটের প্রয়োজনীয় প্রিফারেন্স মনে রাখতে সাহায্য করে।
          </p>

          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">২. আমরা কী ধরনের কুকিজ ব্যবহার করি?</h2>
          <ul style="list-style: disc; margin-left: 1.5rem; margin-bottom: 1.5rem; color: var(--text-body);">
            <li><strong>প্রয়োজনীয় ও কার্যকরী কুকি (Essential Cookies):</strong> আপনার ডার্ক/লাইট মোড সেটিংস, টেক্সট সাইজ এবং পছন্দের জেলা বা বিভাগ মনে রাখার জন্য এটি অত্যাবশ্যক।</li>
            <li><strong>পারফরম্যান্স ও অ্যানালিটিক্স কুকি (Analytics Cookies):</strong> কোন খবরগুলো পাঠকরা বেশি পড়ছেন এবং কোন পেজে পাঠক কেমন সময় অতিবাহিত করছেন তা বোঝার জন্য গুগল অ্যানালিটিক্স ব্যবহৃত হয়।</li>
            <li><strong>বিজ্ঞাপনী কুকিজ (Advertising Cookies):</strong> পাঠকদের আগ্রহ অনুযায়ী প্রাসঙ্গিক বিজ্ঞাপন পরিবেশনের জন্য অনুমোদিত বিজ্ঞাপন পার্টনাররা এই কুকিজ ব্যবহার করতে পারে।</li>
          </ul>

          <h2 style="font-size: 1.35rem; font-weight: 700; color: var(--primary-color); margin: 1.5rem 0 0.75rem;">৩. কীভাবে কুকিজ নিয়ন্ত্রণ বা বন্ধ করবেন?</h2>
          <p>
            আপনি চাইলে যেকোনো সময় আপনার ওয়েব ব্রাউজারের সেটিংস (Browser Settings / History) থেকে সংরক্ষিত কুকিজ মুছে ফেলতে বা কুকিজ ব্লকিং সক্রিয় করতে পারেন। তবে এতে থিমের কিছু ব্যক্তিগত সুবিধা (যেমন ডার্ক মোড মেমোরি) পুনরায় সেট করতে হতে পারে।
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
