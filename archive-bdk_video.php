<?php
/**
 * Video Archive Template for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="container archive-layout" style="padding: 2rem 0 4rem;">
	<section class="archive-main-content" style="grid-column: span 2;">
		
		<?php bdk_breadcrumbs(); ?>

		<!-- Video Hero Banner -->
		<div class="category-hero-banner" style="background: linear-gradient(135deg, #0b0f19 0%, #1e1b4b 100%);">
			<h1 style="color: #ffffff !important;"><i class="fab fa-youtube" style="color: var(--accent-color);"></i> ভিডিও সংবাদ ও টকশো গ্যালারি</h1>
			<p>সমসাময়িক রাজনীতি, অর্থনীতি, আন্তর্জাতিক ও বিশেষ অনুসন্ধানী ভিডিও বুলেটিন</p>
		</div>

		<?php if ( have_posts() ) : ?>
			
			<div class="archive-news-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
				<?php while ( have_posts() ) : the_post();
					$yt_id    = get_post_meta( get_the_ID(), '_bdk_youtube_url', true ) ?: 'dQw4w9WgXcQ';
					$duration = get_post_meta( get_the_ID(), '_bdk_video_duration', true ) ?: '০৮:৪৫ মিনিট';
				?>
					<article class="world-magazine-card" style="background: var(--surface-color);">
						<div class="world-card-img-wrap">
							<button class="video-play-btn-large" data-video-id="<?php echo esc_attr( $yt_id ); ?>" style="width: 50px; height: 50px; font-size: 1.1rem;" aria-label="ভিডিও চালান">
								<i class="fas fa-play"></i>
							</button>
							<span class="read-time-pill" style="background: rgba(0,0,0,0.75);"><i class="far fa-clock"></i> <?php echo esc_html( $duration ); ?></span>
							<?php bdk_post_thumbnail( 'bdk-grid', '', get_the_title() ); ?>
						</div>
						<div class="world-card-body">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<div class="news-meta-row" style="margin-top: auto;">
								<span><i class="far fa-clock"></i> <?php echo bdk_posted_time_ago(); ?></span>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<!-- Dynamic Pagination -->
			<div class="archive-pagination">
				<?php
				echo paginate_links( array(
					'prev_text' => '<i class="fas fa-chevron-left"></i> পূর্ববর্তী',
					'next_text' => 'পরবর্তী <i class="fas fa-chevron-right"></i>',
					'type'      => 'plain',
				) );
				?>
			</div>

		<?php else : ?>
			<div class="static-content-box" style="text-align: center; padding: 3rem 1.5rem;">
				<i class="fab fa-youtube" style="font-size: 3.5rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
				<h3>বর্তমানে কোনো ভিডিও পোস্ট নেই</h3>
				<p style="color: var(--text-muted); margin-bottom: 1.5rem;">এডমিন প্যানেল থেকে নতুন ভিডিও যোগ করুন।</p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="submit-brand-btn" style="padding: 0.6rem 1.4rem;">প্রচ্ছদে ফিরে যান</a>
			</div>
		<?php endif; ?>

	</section>
</main>

<?php
get_footer();
