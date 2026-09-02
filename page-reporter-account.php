<?php
/**
 * Template Name: Reporter Account & Recruitment Application (সাংবাদিক লগইন ও নিয়োগ আবেদন)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Redirect logged-in users directly to Reporter Dashboard
if ( is_user_logged_in() ) {
	wp_safe_redirect( home_url( '/reporter-dashboard' ) );
	exit;
}

get_header();

$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'login';
if ( isset( $_GET['reg_error'] ) || isset( $_GET['registered'] ) ) {
	$active_tab = 'register';
}

$reg_errors   = get_transient( 'bdk_reg_errors' );
delete_transient( 'bdk_reg_errors' );

$login_errors = get_transient( 'bdk_login_errors' );
delete_transient( 'bdk_login_errors' );
?>

  <!-- Page Hero Banner -->
  <section class="category-hero-banner">
    <div class="container">
      <div class="breadcrumb-bar" style="color: rgba(255,255,255,0.85); margin-bottom: 0.5rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #fff; font-weight: 600;">প্রচ্ছদ</a>
        <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
        <span>সাংবাদিক পোর্টাল</span>
      </div>
      <h1>ডিজিটাল সাংবাদিক নিয়োগ ও একাউন্ট পোর্টাল</h1>
      <p>বস্তুনিষ্ঠ অনুসন্ধানী সাংবাদিকতায় যুক্ত হতে আবেদন করুন অথবা আপনার একাউন্টে লগইন করুন</p>
    </div>
  </section>

  <!-- Auth Main Layout -->
  <main class="container" style="margin-top: 2rem; margin-bottom: 4rem;">
    <div style="max-width: 720px; margin: 0 auto; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); box-shadow: var(--card-shadow); overflow: hidden;">
      
      <!-- Auth Switcher Tabs -->
      <div style="display: flex; border-bottom: 2px solid var(--border-color); background: var(--surface-secondary);">
        <button type="button" onclick="switchAuthTab('login')" id="tabBtnLogin" class="auth-tab-btn <?php echo 'login' === $active_tab ? 'active' : ''; ?>" style="flex: 1; padding: 1rem; font-size: 1rem; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-main); transition: all 0.2s;">
          <i class="fas fa-right-to-bracket"></i> লগইন করুন
        </button>
        <button type="button" onclick="switchAuthTab('register')" id="tabBtnRegister" class="auth-tab-btn <?php echo 'register' === $active_tab ? 'active' : ''; ?>" style="flex: 1; padding: 1rem; font-size: 1rem; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-main); transition: all 0.2s;">
          <i class="fas fa-user-pen"></i> সাংবাদিক নিয়োগ আবেদন
        </button>
        <button type="button" onclick="switchAuthTab('reset')" id="tabBtnReset" class="auth-tab-btn <?php echo 'reset' === $active_tab ? 'active' : ''; ?>" style="flex: 1; padding: 1rem; font-size: 1rem; font-weight: 700; border: none; background: transparent; cursor: pointer; color: var(--text-main); transition: all 0.2s;">
          <i class="fas fa-key"></i> পাসওয়ার্ড রিসেট
        </button>
      </div>

      <div style="padding: 2rem;">

        <!-- 1. LOGIN FORM -->
        <div id="authSectionLogin" style="display: <?php echo 'login' === $active_tab ? 'block' : 'none'; ?>;">
          <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1.25rem;">
            <i class="fas fa-user-check"></i> সংবাদের ড্যাশবোর্ডে প্রবেশের লগইন ফরম
          </h2>

          <?php if ( ! empty( $login_errors ) ) : ?>
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 0.85rem 1rem; border-radius: 4px; margin-bottom: 1.25rem; font-size: 0.9rem;">
              <?php foreach ( $login_errors as $err ) : ?>
                <p style="margin: 0;"><i class="fas fa-circle-exclamation"></i> <?php echo esc_html( $err ); ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="bdk_reporter_login">
            <?php wp_nonce_field( 'bdk_reporter_login_action', 'bdk_reporter_login_nonce' ); ?>

            <div style="margin-bottom: 1.2rem;">
              <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-main);">ইউজারনেম অথবা ইমেইল ঠিকানা *</label>
              <input type="text" name="log" class="comment-input-field" required placeholder="আপনার ইউজারনেম/ইমেইল লিখুন" style="width: 100%; height: 46px; padding: 0 14px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>

            <div style="margin-bottom: 1.2rem;">
              <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-main);">পাসওয়ার্ড *</label>
              <input type="password" name="pwd" class="comment-input-field" required placeholder="আপনার গোপনীয় পাসওয়ার্ড" style="width: 100%; height: 46px; padding: 0 14px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.9rem;">
              <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--text-body);">
                <input type="checkbox" name="rememberme" value="forever"> আমাকে মনে রাখুন
              </label>
              <a href="javascript:void(0)" onclick="switchAuthTab('reset')" style="color: var(--primary-color); font-weight: 600;">পাসওয়ার্ড ভুলে গেছেন?</a>
            </div>

            <button type="submit" class="submit-brand-btn" style="width: 100%; height: 46px; font-size: 1rem; font-weight: 700;">
              <i class="fas fa-right-to-bracket"></i> লগইন করুন
            </button>
          </form>
        </div>

        <!-- 2. DIGITAL RECRUITMENT / REGISTRATION FORM -->
        <div id="authSectionRegister" style="display: <?php echo 'register' === $active_tab ? 'block' : 'none'; ?>;">
          <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">
            <i class="fas fa-id-card-clip"></i> ডিজিটাল সাংবাদিক নিয়োগ আবেদন ফরম
          </h2>
          <p style="font-size: 0.88rem; color: var(--text-body); margin-bottom: 1.25rem;">
            অনলাইনে আবেদন করার পর আপনার তথ্য ও সিভি পর্যালোচনা করে প্রেস আইডি কার্ড ও রিপোর্টার ড্যাশবোর্ড অনুমোদন দেওয়া হবে।
          </p>

          <?php if ( ! empty( $reg_errors ) ) : ?>
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 0.85rem 1rem; border-radius: 4px; margin-bottom: 1.25rem; font-size: 0.9rem;">
              <?php foreach ( $reg_errors as $err ) : ?>
                <p style="margin: 0 0 4px 0;"><i class="fas fa-circle-exclamation"></i> <?php echo esc_html( $err ); ?></p>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="bdk_reporter_register">
            <?php wp_nonce_field( 'bdk_reporter_reg_action', 'bdk_reporter_reg_nonce' ); ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">আপনার পূর্ণ নাম *</label>
                <input type="text" name="full_name" class="comment-input-field" required placeholder="যেমন: মোঃ আল-আমিন" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">মোবাইল নম্বর *</label>
                <input type="tel" name="phone" class="comment-input-field" required placeholder="যেমন: 017xxxxxxxx" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">ইউজারনেম (ইংরেজিতে) *</label>
                <input type="text" name="username" class="comment-input-field" required placeholder="যেমন: reporter_alamin" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">ইমেইল ঠিকানা *</label>
                <input type="email" name="email" class="comment-input-field" required placeholder="আপনার সচল ইমেইল" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
            </div>

            <div style="margin-bottom: 1rem;">
              <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">পদবী / আবেদনকৃত স্থান (যেমন: জেলা/উপজেলা প্রতিনিধি, জামালপুর) *</label>
              <input type="text" name="designation" class="comment-input-field" required placeholder="যেমন: জেলা প্রতিনিধি, জামালপুর" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
              <div style="background: var(--surface-secondary); padding: 0.85rem; border-radius: 6px; border: 1px dashed var(--border-color);">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">
                  <i class="fas fa-camera"></i> আপনার ছবি আপলোড করুন *
                </label>
                <input type="file" name="reporter_photo" accept="image/*" required style="font-size: 0.8rem; width: 100%;">
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 2px;">পাসপোর্ট সাইজ স্পষ্ট ছবি (JPG/PNG)</span>
              </div>

              <div style="background: var(--surface-secondary); padding: 0.85rem; border-radius: 6px; border: 1px dashed var(--border-color);">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem;">
                  <i class="fas fa-file-pdf"></i> আপনার সিভি ফাইল আপলোড *
                </label>
                <input type="file" name="reporter_cv" accept=".pdf,.doc,.docx" required style="font-size: 0.8rem; width: 100%;">
                <span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 2px;">বায়োডাটা / রেজুমি (PDF বা Doc)</span>
              </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">পাসওয়ার্ড *</label>
                <input type="password" name="password" class="comment-input-field" required placeholder="অন্তত ৬ অক্ষরের পাসওয়ার্ড" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
              <div>
                <label style="display: block; font-size: 0.88rem; font-weight: 600; margin-bottom: 0.3rem;">পাসওয়ার্ড নিশ্চিতকরণ *</label>
                <input type="password" name="confirm_password" class="comment-input-field" required placeholder="পাসওয়ার্ড পুনরায় লিখুন" style="width: 100%; height: 42px; padding: 0 12px; border-radius: 6px; border: 1px solid var(--border-color);">
              </div>
            </div>

            <button type="submit" class="submit-brand-btn" style="width: 100%; height: 46px; font-size: 1rem; font-weight: 700; background: var(--primary-color);">
              <i class="fas fa-paper-plane"></i> আবেদনের তথ্য জমা দিন
            </button>
          </form>
        </div>

        <!-- 3. PASSWORD RESET FORM -->
        <div id="authSectionReset" style="display: <?php echo 'reset' === $active_tab ? 'block' : 'none'; ?>;">
          <h2 style="font-size: 1.3rem; font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">
            <i class="fas fa-lock"></i> পাসওয়ার্ড পুনরুদ্ধার
          </h2>
          <p style="font-size: 0.88rem; color: var(--text-body); margin-bottom: 1.25rem;">
            আপনার নিবন্ধিত ইমেইল ঠিকানাটি লিখুন। পাসওয়ার্ড পুনর্নির্ধারণ লিংক আপনার ইমেইলে পাঠিয়ে দেওয়া হবে।
          </p>

          <form action="<?php echo esc_url( wp_lostpassword_url() ); ?>" method="post">
            <div style="margin-bottom: 1.25rem;">
              <label style="display: block; font-weight: 600; margin-bottom: 0.4rem;">ইমেইল ঠিকানা *</label>
              <input type="email" name="user_login" class="comment-input-field" required placeholder="আপনার একাউন্টের ইমেইল" style="width: 100%; height: 46px; padding: 0 14px; border-radius: 6px; border: 1px solid var(--border-color);">
            </div>
            <button type="submit" class="submit-brand-btn" style="width: 100%; height: 46px; font-size: 1rem; font-weight: 700;">
              <i class="fas fa-envelope-open-text"></i> রিসেট লিঙ্ক পাঠান
            </button>
          </form>
        </div>

      </div>
    </div>
  </main>

  <style>
    .auth-tab-btn.active {
      background: var(--surface-color) !important;
      color: var(--primary-color) !important;
      border-bottom: 3px solid var(--primary-color) !important;
    }
  </style>

  <script>
    function switchAuthTab(tab) {
      document.getElementById('authSectionLogin').style.display = (tab === 'login') ? 'block' : 'none';
      document.getElementById('authSectionRegister').style.display = (tab === 'register') ? 'block' : 'none';
      document.getElementById('authSectionReset').style.display = (tab === 'reset') ? 'block' : 'none';

      document.getElementById('tabBtnLogin').classList.toggle('active', tab === 'login');
      document.getElementById('tabBtnRegister').classList.toggle('active', tab === 'register');
      document.getElementById('tabBtnReset').classList.toggle('active', tab === 'reset');
    }
  </script>

<?php
get_footer();
