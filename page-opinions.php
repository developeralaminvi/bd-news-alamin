<?php
/**
 * Template Name: Opinions & Reader Comments (মতামত ও পাঠকদের প্রতিক্রিয়া)
 *
 * Description: Displays all reader comments across all news posts with latest comments on top.
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Pagination setup for comments
$paged        = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$per_page     = 10;
$offset       = ( $paged - 1 ) * $per_page;

$total_comments_count = get_comments( array(
	'status' => 'approve',
	'count'  => true,
) );

$comments_query = get_comments( array(
	'status'  => 'approve',
	'number'  => $per_page,
	'offset'  => $offset,
	'orderby' => 'comment_date',
	'order'   => 'DESC',
) );

$total_pages = ceil( max( 1, $total_comments_count ) / $per_page );
?>

<!-- Full-Width High-Contrast Hero Banner -->
<section class="category-hero-banner static-hero-banner" style="background: linear-gradient(135deg, #0f172a 0%, var(--primary-color) 100%);">
	<div class="container">
		<nav class="breadcrumb-bar" aria-label="ব্রেডক্রাম্ব">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-house"></i> প্রচ্ছদ</a>
			<i class="fas fa-chevron-right separator"></i>
			<span>মতামত ও পাঠকদের প্রতিক্রিয়া</span>
		</nav>
		
		<div class="hero-content-wrap">
			<h1><i class="fas fa-comments" style="color: var(--secondary-color); margin-right: 8px;"></i> মতামত ও পাঠকদের প্রতিক্রিয়া</h1>
			<p>দেশ-বিদেশের পাঠকদের মূল্যবান গঠনমূলক মন্তব্য, সম্পাদকীয় পর্যালোচনা ও মুক্ত আলোচনা। সর্বমোট <?php echo bdk_to_bengali_numerals( max( 3, $total_comments_count ) ); ?>টি প্রতিক্রিয়া প্রকাশিত হয়েছে।</p>
		</div>
	</div>
</section>

<!-- Main Opinions & Comments Content Area -->
<div class="container section-gap" style="padding-top: 2rem; padding-bottom: 3rem;">
	<div class="archive-layout" style="display: grid; grid-template-columns: 2.3fr 1fr; gap: 2rem;">
		
		<!-- Main Content Column -->
		<main class="archive-main-col">

			<!-- Top Banner Ad Slot -->
			<?php bdk_display_ad_slot( 'bdk_archive_ad', 'মতামত পেজ শীর্ষ ব্যানার বিজ্ঞাপন', '728×90 Leaderboard' ); ?>

			<!-- Header Filter & Count Summary -->
			<div class="opinion-page-header" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
				<div>
					<h3 style="font-size: 1.15rem; font-weight: 700; color: var(--text-main); margin: 0;">
						<i class="far fa-clock" style="color: var(--primary-color);"></i> সাম্প্রতিক পাঠকদের মন্তব্য (সর্বশেষ মন্তব্য উপরে)
					</h3>
					<span style="font-size: 0.82rem; color: var(--text-muted);">পৃষ্ঠা <?php echo bdk_to_bengali_numerals( $paged ); ?> এর <?php echo bdk_to_bengali_numerals( max( 1, $total_pages ) ); ?></span>
				</div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="submit-brand-btn" style="padding: 0.4rem 1rem; font-size: 0.82rem; text-decoration: none;">
					<i class="fas fa-newspaper"></i> সংবাদ পড়ুন ও মন্তব্য করুন
				</a>
			</div>

			<!-- Reader Comments Feed -->
			<?php if ( ! empty( $comments_query ) ) : ?>
				<div class="opinions-feed-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
					<?php foreach ( $comments_query as $cmt ) : 
						$post_id    = $cmt->comment_post_ID;
						$post_link  = get_permalink( $post_id );
						$post_title = get_the_title( $post_id );
						$cmt_link   = get_comment_link( $cmt );
					?>
						<article class="opinion-full-card" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; box-shadow: var(--card-shadow); transition: transform 0.2s, box-shadow 0.2s; position: relative;">
							
							<div class="opinion-card-top" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem;">
								<div class="comment-author-meta" style="display: flex; align-items: center; gap: 0.75rem;">
									<div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color); flex-shrink: 0;">
										<?php echo get_avatar( $cmt, 48 ); ?>
									</div>
									<div>
										<h4 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0 0 2px;">
											<?php echo esc_html( $cmt->comment_author ); ?>
											<span class="comment-verified-badge" title="ভেরিফাইড পাঠক" style="color: var(--primary-color); font-size: 0.85rem; margin-left: 3px;"><i class="fas fa-circle-check"></i></span>
										</h4>
										<span style="font-size: 0.78rem; color: var(--text-muted);">
											<i class="far fa-clock"></i> <?php echo esc_html( human_time_diff( strtotime( $cmt->comment_date ), current_time( 'timestamp' ) ) ); ?> আগে (<?php echo esc_html( date_i18n( 'd M Y, g:i A', strtotime( $cmt->comment_date ) ) ); ?>)
										</span>
									</div>
								</div>

								<span class="comment-tag" style="background: var(--primary-light); color: var(--primary-color); font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; border: 1px solid var(--primary-border);">
									<i class="fas fa-comment-dots"></i> পাঠকদের মন্তব্য
								</span>
							</div>

							<!-- Comment Body Quote -->
							<div class="opinion-quote-content" style="font-size: 0.98rem; line-height: 1.65; color: var(--text-body); background: var(--bg-color); border-left: 3px solid var(--accent-color); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.9rem 1.25rem; margin-bottom: 0.85rem; font-style: normal;">
								"<?php echo esc_html( wp_strip_all_tags( $cmt->comment_content ) ); ?>"
							</div>

							<!-- Linked Post Bar -->
							<div class="opinion-post-anchor" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.84rem; padding-top: 0.65rem; border-top: 1px dashed var(--border-color);">
								<div style="color: var(--text-muted);">
									<i class="fas fa-newspaper" style="color: var(--primary-color);"></i> সংবাদ: 
									<a href="<?php echo esc_url( $post_link ); ?>" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">
										<?php echo esc_html( wp_trim_words( $post_title, 10, '...' ) ); ?>
									</a>
								</div>
								<a href="<?php echo esc_url( $cmt_link ); ?>" style="display: inline-flex; align-items: center; gap: 4px; color: var(--accent-color); font-weight: 700; text-decoration: none; font-size: 0.82rem;">
									মন্তব্য দেখুন ও উত্তর দিন <i class="fas fa-arrow-right"></i>
								</a>
							</div>

						</article>
					<?php endforeach; ?>
				</div>

				<!-- Pagination Bar -->
				<?php if ( $total_pages > 1 ) : ?>
					<nav class="archive-pagination" style="margin-top: 2.5rem; display: flex; justify-content: center; gap: 0.4rem; flex-wrap: wrap;">
						<?php
						echo paginate_links( array(
							'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'format'    => '?paged=%#%',
							'current'   => $paged,
							'total'     => $total_pages,
							'prev_text' => '<i class="fas fa-chevron-left"></i> পূর্ববর্তী',
							'next_text' => 'পরবর্তী <i class="fas fa-chevron-right"></i>',
							'type'      => 'plain',
						) );
						?>
					</nav>
				<?php endif; ?>

			<?php else : ?>
				<!-- Demo Reader Opinions Feed when no comments posted yet -->
				<div class="opinions-feed-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
					
					<article class="opinion-full-card" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; box-shadow: var(--card-shadow); position: relative;">
						<div class="opinion-card-top" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem;">
							<div class="comment-author-meta" style="display: flex; align-items: center; gap: 0.75rem;">
								<div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color); flex-shrink: 0;">
									<img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="ছামিউল ইসলাম রিপন" style="width: 100%; height: 100%; object-fit: cover;">
								</div>
								<div>
									<h4 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0 0 2px;">
										ছামিউল ইসলাম রিপন
										<span class="comment-verified-badge" title="ভেরিফাইড" style="color: var(--primary-color); font-size: 0.85rem; margin-left: 3px;"><i class="fas fa-circle-check"></i></span>
									</h4>
									<span style="font-size: 0.78rem; color: var(--text-muted);">
										<i class="far fa-clock"></i> সম্পাদক ও প্রকাশক — সম্পাদকীয় মতামত
									</span>
								</div>
							</div>
							<span class="comment-tag" style="background: var(--primary-light); color: var(--primary-color); font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; border: 1px solid var(--primary-border);">
								<i class="fas fa-feather-pointed"></i> সম্পাদকীয়
							</span>
						</div>
						<div class="opinion-quote-content" style="font-size: 0.98rem; line-height: 1.65; color: var(--text-body); background: var(--bg-color); border-left: 3px solid var(--accent-color); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.9rem 1.25rem; margin-bottom: 0.85rem;">
							"বস্তুনিষ্ঠ সাংবাদিকতা কোনো আপসের জায়গা নয়; সত্য প্রকাশের সাহসই জাতির আসল শক্তি। তৃণমূলের প্রতিটি মানুষের অধিকার ও সমস্যা তুলে ধরাই আমাদের প্রধান লক্ষ্য।"
						</div>
						<div class="opinion-post-anchor" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.84rem; padding-top: 0.65rem; border-top: 1px dashed var(--border-color);">
							<div style="color: var(--text-muted);">
								<i class="fas fa-newspaper" style="color: var(--primary-color);"></i> সম্পাদকীয় বার্তা
							</div>
							<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" style="display: inline-flex; align-items: center; gap: 4px; color: var(--accent-color); font-weight: 700; text-decoration: none; font-size: 0.82rem;">
								আমাদের সম্পর্কে বিস্তারিত <i class="fas fa-arrow-right"></i>
							</a>
						</div>
					</article>

					<article class="opinion-full-card" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; box-shadow: var(--card-shadow); position: relative;">
						<div class="opinion-card-top" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem;">
							<div class="comment-author-meta" style="display: flex; align-items: center; gap: 0.75rem;">
								<div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color); flex-shrink: 0;">
									<img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80" alt="মো. সিফাত" style="width: 100%; height: 100%; object-fit: cover;">
								</div>
								<div>
									<h4 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0 0 2px;">
										মো. সিফাত
										<span class="comment-verified-badge" title="ভেরিফাইড" style="color: var(--primary-color); font-size: 0.85rem; margin-left: 3px;"><i class="fas fa-circle-check"></i></span>
									</h4>
									<span style="font-size: 0.78rem; color: var(--text-muted);">
										<i class="far fa-clock"></i> বার্তা সম্পাদক
									</span>
								</div>
							</div>
							<span class="comment-tag" style="background: var(--primary-light); color: var(--primary-color); font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; border: 1px solid var(--primary-border);">
								<i class="fas fa-feather-pointed"></i> সম্পাদকীয়
							</span>
						</div>
						<div class="opinion-quote-content" style="font-size: 0.98rem; line-height: 1.65; color: var(--text-body); background: var(--bg-color); border-left: 3px solid var(--accent-color); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.9rem 1.25rem; margin-bottom: 0.85rem;">
							"তৃণমূলের সমস্যা যখন জাতীয় শিরোনাম হয়, তখনই একটি গণমাধ্যমের আসল ভূমিকা সার্থক হয়ে ওঠে। পাঠকদের মতামত আমাদের চলার পথের সবচেয়ে বড় অনুপ্রেরণা।"
						</div>
						<div class="opinion-post-anchor" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.84rem; padding-top: 0.65rem; border-top: 1px dashed var(--border-color);">
							<div style="color: var(--text-muted);">
								<i class="fas fa-newspaper" style="color: var(--primary-color);"></i> বার্তা বিভাগ
							</div>
							<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" style="display: inline-flex; align-items: center; gap: 4px; color: var(--accent-color); font-weight: 700; text-decoration: none; font-size: 0.82rem;">
								যোগাযোগ ও বার্তা পাঠান <i class="fas fa-arrow-right"></i>
							</a>
						</div>
					</article>

					<article class="opinion-full-card" style="background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1.25rem 1.5rem; box-shadow: var(--card-shadow); position: relative;">
						<div class="opinion-card-top" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem;">
							<div class="comment-author-meta" style="display: flex; align-items: center; gap: 0.75rem;">
								<div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid var(--primary-color); flex-shrink: 0;">
									<img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80" alt="ড. কামরুল হাসান" style="width: 100%; height: 100%; object-fit: cover;">
								</div>
								<div>
									<h4 style="font-size: 1.05rem; font-weight: 700; color: var(--text-main); margin: 0 0 2px;">
										ড. কামরুল হাসান
										<span class="comment-verified-badge" title="কলামিস্ট" style="color: var(--primary-color); font-size: 0.85rem; margin-left: 3px;"><i class="fas fa-circle-check"></i></span>
									</h4>
									<span style="font-size: 0.78rem; color: var(--text-muted);">
										<i class="far fa-clock"></i> কলামিস্ট ও অর্থনীতিবিদ
									</span>
								</div>
							</div>
							<span class="comment-tag" style="background: var(--primary-light); color: var(--primary-color); font-size: 0.75rem; font-weight: 700; padding: 3px 10px; border-radius: 99px; border: 1px solid var(--primary-border);">
								<i class="fas fa-pen-nib"></i> কলাম
							</span>
						</div>
						<div class="opinion-quote-content" style="font-size: 0.98rem; line-height: 1.65; color: var(--text-body); background: var(--bg-color); border-left: 3px solid var(--accent-color); border-radius: 0 var(--radius-md) var(--radius-md) 0; padding: 0.9rem 1.25rem; margin-bottom: 0.85rem;">
							"মুদ্রাস্ফীতি নিয়ন্ত্রণ ও স্থানীয় উৎপাদনের মেলবন্ধনই পারে স্থিতিশীল অর্থনৈতিক মুক্তি দিতে। সাধারণ মানুষের মতামতকে নীতি-নির্ধারণে যুক্ত করা এখন সময়ের দাবি।"
						</div>
						<div class="opinion-post-anchor" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; font-size: 0.84rem; padding-top: 0.65rem; border-top: 1px dashed var(--border-color);">
							<div style="color: var(--text-muted);">
								<i class="fas fa-newspaper" style="color: var(--primary-color);"></i> অর্থনীতি ও কলাম
							</div>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-flex; align-items: center; gap: 4px; color: var(--accent-color); font-weight: 700; text-decoration: none; font-size: 0.82rem;">
								সংবাদ পড়ুন ও মন্তব্য করুন <i class="fas fa-arrow-right"></i>
							</a>
						</div>
					</article>

				</div>
			<?php endif; ?>

		</main>

		<!-- Sidebar Column -->
		<aside class="archive-sidebar-col">
			<?php get_sidebar(); ?>
		</aside>

	</div>
</div>

<?php
get_footer();
