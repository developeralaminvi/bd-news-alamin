<?php
/**
 * Template Name: Advertising & Rates Page (বিজ্ঞাপন ও মূল্য তালিকা)
 *
 * @package BD_News_Alamin
 */

get_header();

$packages = bdk_get_ad_packages();
?>

<main id="primary" class="site-main advertising-page-wrapper" style="padding-bottom: 3rem; background: var(--surface-color);">
	
	<!-- ================= 1. ADVERTISING HERO BANNER ================= -->
	<section class="ad-hero-section" style="background: linear-gradient(135deg, #00442b 0%, #006a4e 50%, #0f766e 100%); color: #ffffff; padding: 3.5rem 0 3rem; position: relative; overflow: hidden;">
		<div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; pointer-events: none;"></div>
		<div style="position: absolute; bottom: -80px; left: -50px; width: 300px; height: 300px; background: rgba(255, 255, 255, 0.04); border-radius: 50%; pointer-events: none;"></div>
		
		<div class="container" style="position: relative; z-index: 2;">
			<!-- Breadcrumb -->
			<div class="breadcrumb-trail" style="margin-bottom: 1rem; opacity: 0.9; font-size: 0.88rem;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #ffffff; text-decoration: none;"><i class="fas fa-house"></i> প্রচ্ছদ</a>
				<span style="margin: 0 6px;">&gt;</span>
				<span>বিজ্ঞাপন ও মূল্য তালিকা</span>
			</div>

			<div style="max-width: 800px;">
				<span style="background: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255, 255, 255, 0.3); padding: 0.35rem 0.9rem; border-radius: 50px; font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 0.8rem;">
					📢 ব্র্যান্ড প্রমোশন ও বিজ্ঞাপন সার্ভিস
				</span>
				<h1 style="font-family: 'Noto Serif Bengali', serif; font-size: clamp(1.8rem, 4vw, 2.7rem); font-weight: 800; margin-bottom: 0.8rem; line-height: 1.25;">
					আপনার ব্র্যান্ড পৌঁছে দিন লক্ষাধিক পাঠকের দ্বারে
				</h1>
				<p style="font-size: 1.05rem; opacity: 0.95; line-height: 1.7; margin-bottom: 1.5rem; max-width: 720px;">
					দৈনিক বাংলাদেশের কথা অনলাইন পোর্টালে বিজ্ঞাপন দিয়ে আপনার পণ্য, প্রতিষ্ঠান ও সেবাকে সহজেই পরিচিত করুন দেশের ৬৪ জেলার লক্ষাধিক টার্গেটেড পাঠকের কাছে।
				</p>

				<!-- Highlight Statistics -->
				<div style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 1.25rem;">
					<div>
						<span style="font-size: 1.5rem; font-weight: 800; color: #f59e0b; display: block;">৫০,০০০+</span>
						<span style="font-size: 0.82rem; opacity: 0.85;">দৈনিক সক্রিয় পাঠক</span>
					</div>
					<div style="border-left: 1px solid rgba(255, 255, 255, 0.2); padding-left: 1.5rem;">
						<span style="font-size: 1.5rem; font-weight: 800; color: #f59e0b; display: block;">১০০%</span>
						<span style="font-size: 0.82rem; opacity: 0.85;">রেসপনসিভ ও ডিজিটাল ভিউ</span>
					</div>
					<div style="border-left: 1px solid rgba(255, 255, 255, 0.2); padding-left: 1.5rem;">
						<span style="font-size: 1.5rem; font-weight: 800; color: #f59e0b; display: block;">৬৪ জেলা</span>
						<span style="font-size: 0.82rem; opacity: 0.85;">প্রতিনিধি ও পাঠক নেটওয়ার্ক</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ================= 2. AD PACKAGES PRICING GRID ================= -->
	<section style="padding: 3rem 0; background: var(--surface-color);">
		<div class="container">
			<div style="text-align: center; max-width: 650px; margin: 0 auto 2.5rem;">
				<h2 style="font-family: 'Noto Serif Bengali', serif; font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.5rem;">
					বিজ্ঞাপনের স্থান ও প্রাইস রেট তালিকা
				</h2>
				<p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">
					আপনার বাজেট ও সুবিধার সাথে মানানসই সেরা স্থানটি বেছে নিন এবং ১-ক্লিকেই বুকিং দিন।
				</p>
			</div>

			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
				<?php
				foreach ( $packages as $pkg_id => $pkg ) :
					if ( empty( $pkg['active'] ) ) {
						continue;
					}
				?>
					<div class="ad-package-card" style="background: var(--surface-color); border: 2px solid var(--border-color); border-radius: 14px; padding: 1.5rem; transition: all 0.3s ease; display: flex; flex-direction: column; justify-content: space-between; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
						
						<?php if ( ! empty( $pkg['badge'] ) ) : ?>
							<span style="position: absolute; top: 15px; right: 15px; background: #f59e0b; color: #ffffff; font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 50px; text-transform: uppercase;">
								<?php echo esc_html( $pkg['badge'] ); ?>
							</span>
						<?php endif; ?>

						<div>
							<!-- Header -->
							<div style="margin-bottom: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
								<span style="color: var(--primary-color); font-size: 0.85rem; font-weight: 700; display: block; margin-bottom: 2px;">
									📐 সাইজ: <?php echo esc_html( $pkg['size'] ); ?>
								</span>
								<h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.3;">
									<?php echo esc_html( $pkg['title'] ); ?>
								</h3>
							</div>

							<!-- Visual Mockup Diagram -->
							<div style="background: var(--surface-secondary); border: 1px dashed var(--border-color); border-radius: 8px; padding: 12px; text-align: center; margin-bottom: 1.25rem;">
								<div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px;">অবস্থান: <?php echo esc_html( $pkg['location'] ); ?></div>
								<div style="background: var(--primary-light); color: var(--primary-color); padding: 8px; border-radius: 6px; font-weight: 700; font-size: 0.82rem; border: 1px solid var(--primary-color);">
									<?php echo esc_html( $pkg['size'] ); ?> BANNER SPOT
								</div>
							</div>

							<!-- Rates Text -->
							<div style="background: rgba(16, 185, 129, 0.08); border-left: 4px solid #10b981; padding: 10px 12px; border-radius: 4px; margin-bottom: 1.25rem;">
								<span style="font-size: 0.78rem; color: #047857; font-weight: 700; display: block;">মূল্য তালিকা (Rates):</span>
								<strong style="font-size: 0.88rem; color: #065f46;"><?php echo esc_html( $pkg['rates_text'] ); ?></strong>
							</div>

							<!-- Description -->
							<p style="font-size: 0.88rem; color: var(--text-body); line-height: 1.6; margin-bottom: 1.5rem;">
								<?php echo esc_html( $pkg['desc'] ); ?>
							</p>
						</div>

						<!-- Action Button -->
						<div>
							<button type="button" class="submit-brand-btn open-ad-booking-modal" 
								data-id="<?php echo esc_attr( $pkg_id ); ?>"
								data-title="<?php echo esc_attr( $pkg['title'] ); ?>"
								data-size="<?php echo esc_attr( $pkg['size'] ); ?>"
								style="width: 100%; padding: 0.75rem; font-size: 0.92rem; font-weight: 700; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
								<i class="fas fa-paper-plane"></i> বিজ্ঞাপন বুকিং দিন
							</button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ================= 3. ADVERTISING GUIDELINES & PAYMENT INFO ================= -->
	<section style="background: var(--surface-secondary); padding: 3rem 0; border-top: 1px solid var(--border-color);">
		<div class="container">
			<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
				
				<!-- Terms & Specs -->
				<div style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem;">
					<h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-top: 0; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
						<i class="fas fa-list-check" style="color: var(--primary-color);"></i> বিজ্ঞাপনের শর্তাবলী ও বিন্যাস:
					</h3>
					<ul style="list-style: disc; margin-left: 1.25rem; font-size: 0.88rem; color: var(--text-body); line-height: 1.8;">
						<li><strong>ফরম্যাট:</strong> JPG, PNG, Static GIF অথবা Animated Banner গ্রহণযোগ্য।</li>
						<li><strong>সর্বোচ্চ ফাইল সাইজ:</strong> ব্যানার ফাইলের সাইজ ১৫০ KB এর মধ্যে হতে হবে।</li>
						<li><strong>ব্যানার ডিজাইন:</strong> প্রয়োজনে আমাদের অভিজ্ঞ গ্রাফিক ডিজাইনার দিয়ে আকর্ষণীয় ব্যানার তৈরি সুবিধা রয়েছে।</li>
						<li><strong>বিজ্ঞাপন অনুমোদন:</strong> জাতীয় নীতিমালার পরিপন্থী, অবাস্তব বা বিভ্রান্তিকর কোনো বিজ্ঞাপন প্রকাশ করা হয় না।</li>
					</ul>
				</div>

				<!-- Payment Methods & Direct Contact -->
				<div style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem;">
					<h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin-top: 0; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
						<i class="fas fa-wallet" style="color: var(--primary-color);"></i> পেমেন্ট মাধ্যম ও সরাসরি যোগাযোগ:
					</h3>
					<p style="font-size: 0.88rem; color: var(--text-body); line-height: 1.6; margin-bottom: 1rem;">
						বুকিং কনফার্ম হওয়ার পর বিকাশ, নগদ, রকেট অথবা সরাসরি ব্যাংক ট্রান্সফারের মাধ্যমে পেমেন্ট সম্পন্ন করতে পারবেন।
					</p>
					
					<div style="background: var(--surface-secondary); padding: 1rem; border-radius: 8px; font-size: 0.88rem;">
						<p style="margin: 0 0 6px; font-weight: 700; color: var(--text-main);">📞 জরুরি যোগাযোগ (বিজ্ঞাপন বিভাগ):</p>
						<p style="margin: 0 0 4px; color: var(--primary-color); font-weight: 700;"><i class="fas fa-phone"></i> +৮৮০ ১৭০০-০০০০০০ / ০১৮০০-০০০০০০</p>
						<p style="margin: 0; color: var(--text-muted);"><i class="fas fa-envelope"></i> ads@dainikbangladesherkotha.com</p>
					</div>
				</div>

			</div>
		</div>
	</section>

</main>

<!-- ================= 4. AD BOOKING MODAL POPUP ================= -->
<div id="adBookingModal" class="ad-modal-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.65); backdrop-filter: blur(4px); z-index: 99999; align-items: center; justify-content: center; padding: 1rem;">
	<div class="ad-modal-box" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 16px; width: 100%; max-width: 580px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); position: relative;">
		
		<!-- Modal Header -->
		<div style="background: var(--primary-color); color: #ffffff; padding: 1.2rem 1.5rem; border-radius: 16px 16px 0 0; display: flex; align-items: center; justify-content: space-between;">
			<div>
				<h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #ffffff;"><i class="fas fa-paper-plane"></i> বিজ্ঞাপন বুকিং আবেদন</h3>
				<span id="modalPackageSubtitle" style="font-size: 0.82rem; opacity: 0.9; display: block; margin-top: 2px;"></span>
			</div>
			<button id="closeAdBookingModal" type="button" style="background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center;">
				<i class="fas fa-times"></i>
			</button>
		</div>

		<!-- Modal Body & Form -->
		<form id="adBookingForm" style="padding: 1.5rem;">
			<input type="hidden" id="adBookingPackageName" name="package_name" value="">
			
			<div id="adFormResponse" style="display: none; padding: 12px; border-radius: 8px; margin-bottom: 1rem; font-size: 0.88rem; font-weight: 600;"></div>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
				<div>
					<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">আপনার পূর্ণ নাম <span style="color: #dc2626;">*</span></label>
					<input type="text" name="applicant_name" required placeholder="যেমন: মো. রহিম উদ্দিন" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem;">
				</div>
				<div>
					<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">কোম্পানি / ব্র্যান্ডের নাম <span style="color: #dc2626;">*</span></label>
					<input type="text" name="company_name" required placeholder="যেমন: স্কয়ার গ্রুপ" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem;">
				</div>
			</div>

			<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
				<div>
					<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">মোবাইল নম্বর <span style="color: #dc2626;">*</span></label>
					<input type="tel" name="phone" required placeholder="01700-000000" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem;">
				</div>
				<div>
					<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">ইমেইল ঠিকানা <span style="color: #dc2626;">*</span></label>
					<input type="email" name="email" required placeholder="name@company.com" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem;">
				</div>
			</div>

			<div style="margin-bottom: 1rem;">
				<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">বিজ্ঞাপনের সময়কাল নির্বাচন করুন <span style="color: #dc2626;">*</span></label>
				<select name="duration" required style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem; font-weight: 600;">
					<option value="১ সপ্তাহ">১ সপ্তাহ</option>
					<option value="১ মাস (প্রস্তাবিত)" selected>১ মাস (প্রস্তাবিত)</option>
					<option value="৩ মাস">৩ মাস (ডিসকাউন্ট রেট)</option>
					<option value="৬ মাস">৬ মাস (বিশেষ ছাড়)</option>
					<option value="১ বছর">১ বছর (বার্ষিক কন্ট্রাক্ট)</option>
					<option value="কাস্টম সময়কাল">কাস্টম বাজেট/সময়কাল</option>
				</select>
			</div>

			<div style="margin-bottom: 1.5rem;">
				<label style="font-weight: 700; font-size: 0.85rem; color: var(--text-main); display: block; margin-bottom: 4px;">বিজ্ঞাপনের বার্তা / বিবরণ / বিশেষ চাহিদা (ঐচ্ছিক):</label>
				<textarea name="message" rows="3" placeholder="বিজ্ঞাপনের বার্তা বা ব্যানার ফাইল লিংক থাকলে এখানে লিখুন..." style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-main); font-size: 0.88rem;"></textarea>
			</div>

			<div style="display: flex; gap: 1rem; align-items: center; justify-content: flex-end;">
				<button type="button" id="cancelAdBookingBtn" class="button button-secondary" style="padding: 8px 16px; border-radius: 8px;">বাতিল</button>
				<button type="submit" id="submitAdBookingBtn" class="submit-brand-btn" style="padding: 8px 24px; font-weight: 700; border-radius: 8px; font-size: 0.92rem; display: inline-flex; align-items: center; gap: 8px;">
					<i class="fas fa-paper-plane"></i> বুকিং জমা দিন
				</button>
			</div>
		</form>

	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const modal = document.getElementById('adBookingModal');
	const openBtns = document.querySelectorAll('.open-ad-booking-modal');
	const closeBtn = document.getElementById('closeAdBookingModal');
	const cancelBtn = document.getElementById('cancelAdBookingBtn');
	const form = document.getElementById('adBookingForm');
	const subtitle = document.getElementById('modalPackageSubtitle');
	const packageInput = document.getElementById('adBookingPackageName');
	const responseBox = document.getElementById('adFormResponse');
	const submitBtn = document.getElementById('submitAdBookingBtn');

	openBtns.forEach(btn => {
		btn.addEventListener('click', function() {
			const title = this.getAttribute('data-title');
			const size = this.getAttribute('data-size');
			
			packageInput.value = title + ' (' + size + ')';
			subtitle.textContent = 'প্যাকেজ: ' + title + ' [' + size + ']';
			
			responseBox.style.display = 'none';
			modal.style.display = 'flex';
		});
	});

	function closeModal() {
		modal.style.display = 'none';
	}

	closeBtn?.addEventListener('click', closeModal);
	cancelBtn?.addEventListener('click', closeModal);

	modal?.addEventListener('click', function(e) {
		if (e.target === modal) {
			closeModal();
		}
	});

	// Form Submission via AJAX
	form?.addEventListener('submit', function(e) {
		e.preventDefault();

		const formData = new FormData(form);
		formData.append('action', 'bdk_submit_ad_booking');
		formData.append('nonce', '<?php echo wp_create_nonce( "bdk_ajax_nonce" ); ?>');

		submitBtn.disabled = true;
		submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> প্রসেস হচ্ছে...';
		responseBox.style.display = 'none';

		fetch('<?php echo admin_url( "admin-ajax.php" ); ?>', {
			method: 'POST',
			body: formData
		})
		.then(res => res.json())
		.then(data => {
			submitBtn.disabled = false;
			submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> বুকিং জমা দিন';

			responseBox.style.display = 'block';
			if (data.success) {
				responseBox.style.background = '#dcfce7';
				responseBox.style.color = '#15803d';
				responseBox.style.border = '1px solid #86efac';
				responseBox.innerHTML = data.data.message;
				form.reset();
				setTimeout(function() {
					closeModal();
				}, 3500);
			} else {
				responseBox.style.background = '#fee2e2';
				responseBox.style.color = '#b91c1c';
				responseBox.style.border = '1px solid #fca5a5';
				responseBox.innerHTML = '❌ ' + (data.data ? data.data : 'আবেদন গ্রহণে সমস্যা হয়েছে।');
			}
		})
		.catch(err => {
			submitBtn.disabled = false;
			submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> বুকিং জমা দিন';
			responseBox.style.display = 'block';
			responseBox.style.background = '#fee2e2';
			responseBox.style.color = '#b91c1c';
			responseBox.style.border = '1px solid #fca5a5';
			responseBox.innerHTML = '❌ নেটওয়ার্ক ত্রুটি। আবার চেষ্টা করুন।';
		});
	});
});
</script>

<?php
get_footer();
