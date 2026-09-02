<?php
/**
 * The Sidebar Template for BD News Alamin Theme (100% Matching HTML Prototype)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="archive-sidebar single-sidebar" id="mainSidebar">
	
	<!-- 1. Trending & Popular News Widget -->
	<div class="trending-news-stack" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 2rem; box-shadow: var(--card-shadow);">
		<div class="widget-title-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 2px solid var(--border-light); padding-bottom: 0.5rem;">
			<h3 style="font-size: 1.1rem; font-weight: 700; color: var(--primary-color); display: flex; align-items: center; gap: 0.4rem;">
				<i class="fas fa-fire" style="color: var(--accent-color);"></i> জনপ্রিয় ও আলোচিত খবর
			</h3>
		</div>

		<div class="trending-list" style="display: flex; flex-direction: column; gap: 0.85rem;">
			<?php
			$pop_sidebar = new WP_Query( array(
				'posts_per_page'      => 5,
				'meta_key'            => 'bdk_post_views_count',
				'orderby'             => 'meta_value_num',
				'order'               => 'DESC',
				'ignore_sticky_posts' => 1,
			) );

			$count = 1;
			if ( $pop_sidebar->have_posts() ) :
				while ( $pop_sidebar->have_posts() ) : $pop_sidebar->the_post();
			?>
				<a href="<?php the_permalink(); ?>" class="trending-item" style="display: flex; gap: 0.75rem; align-items: center; padding-bottom: 0.85rem; border-bottom: 1px solid var(--border-light); text-decoration: none;">
					<div class="trending-img" style="width: 75px; height: 55px; border-radius: var(--radius-xs); overflow: hidden; flex-shrink: 0;">
						<?php bdk_post_thumbnail( 'bdk-thumb', '', get_the_title() ); ?>
					</div>
					<div class="trending-text">
						<h5 style="font-size: 0.85rem; font-weight: 700; color: var(--text-main); line-height: 1.35;"><?php the_title(); ?></h5>
						<span style="font-size: 0.72rem; color: var(--text-muted); display: block; margin-top: 2px;"><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
					</div>
				</a>
			<?php
				endwhile;
				wp_reset_postdata();
			else :
			?>
				<a href="#" class="trending-item" style="display: flex; gap: 0.75rem; align-items: center; padding-bottom: 0.85rem; border-bottom: 1px solid var(--border-light);">
					<div class="trending-img" style="width: 75px; height: 55px; border-radius: var(--radius-xs); overflow: hidden; flex-shrink: 0;"><img src="https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=200&auto=format&fit=crop&q=80" alt="নিউজ"></div>
					<div class="trending-text"><h5 style="font-size: 0.85rem; font-weight: 700;">কৃষি ও খাদ্য উৎপাদনে স্বয়ংসম্পূর্ণতা অর্জনে আধুনিক প্রযুক্তি</h5><span style="font-size: 0.72rem; color: var(--text-muted);">৩০ মিনিট আগে</span></div>
				</a>
				<a href="#" class="trending-item" style="display: flex; gap: 0.75rem; align-items: center; padding-bottom: 0.85rem; border-bottom: 1px solid var(--border-light);">
					<div class="trending-img" style="width: 75px; height: 55px; border-radius: var(--radius-xs); overflow: hidden; flex-shrink: 0;"><img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=200&auto=format&fit=crop&q=80" alt="নিউজ"></div>
					<div class="trending-text"><h5 style="font-size: 0.85rem; font-weight: 700;">কক্সবাজার পর্যটনে নতুন নিরাপত্তা বলয় ও আধুনিক সেবা</h5><span style="font-size: 0.72rem; color: var(--text-muted);">১ ঘণ্টা আগে</span></div>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<!-- 2. Social Community Box -->
	<div class="special-highlight-card" style="background: linear-gradient(135deg, #006a4e 0%, #064e3b 100%); color: #fff; padding: 1.5rem; border-radius: var(--radius-md); margin-bottom: 2rem; box-shadow: 0 4px 15px rgba(0, 106, 78, 0.25);">
		<h4 style="color: #fff; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">আমাদের ফেসবুক পেজে যুক্ত থাকুন</h4>
		<p style="font-size: 0.85rem; opacity: 0.9; line-height: 1.5; margin-bottom: 1rem; color: #fff;">তাজা ও ব্রেকিং খবরের লাইভ আপডেট সবার আগে পেতে দৈনিক বাংলাদেশের কথা ফেসবুক পেজ ফলো করুন।</p>
		<a href="https://www.facebook.com/dainikbangladesherkotha" target="_blank" rel="noopener" class="special-read-btn" style="background: #ffffff; color: #006a4e; font-weight: 700; padding: 0.4rem 1rem; border-radius: var(--radius-full); display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem;">
			<i class="fab fa-facebook-f"></i> ফেসবুক পেজে যান
		</a>
	</div>

	<!-- 3. Dynamic Sidebars (If widgets are explicitly active) -->
	<?php
	if ( is_single() && is_active_sidebar( 'sidebar-single' ) ) {
		dynamic_sidebar( 'sidebar-single' );
	} elseif ( is_archive() && is_active_sidebar( 'sidebar-archive' ) ) {
		dynamic_sidebar( 'sidebar-archive' );
	}
	?>

	<!-- 4. Sidebar Square Ad (300x250) from Customizer -->
	<div class="sidebar-ad-card" style="margin-top: 1.5rem; text-align: center;">
		<?php bdk_display_ad_slot( 'bdk_sidebar_ad', 'সাইডবার স্কয়ার ব্যানার', '300×250 Square' ); ?>
	</div>

</aside>
