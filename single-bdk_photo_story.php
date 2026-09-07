<?php
/**
 * Single Template for Photo Stories (ছবির গল্প ও ফটো ফিচার)
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) : the_post();
	// Track post views
	bdk_set_post_views( get_the_ID() );

	$gallery_images_raw = get_post_meta( get_the_ID(), '_bdk_gallery_images', true );
	$gallery_captions   = get_post_meta( get_the_ID(), '_bdk_gallery_captions', true );
	if ( ! is_array( $gallery_captions ) ) {
		$gallery_captions = array();
	}

	$photographer = get_post_meta( get_the_ID(), '_bdk_photographer_name', true ) ?: 'স্টাফ ফটোসাংবাদিক';
	$location     = get_post_meta( get_the_ID(), '_bdk_photo_location', true ) ?: 'বাংলাদেশ';

	$gallery_items = array();

	// Include featured image as first gallery image
	if ( has_post_thumbnail() ) {
		$feat_id  = get_post_thumbnail_id();
		$feat_src = wp_get_attachment_image_url( $feat_id, 'full' );
		$feat_cap = isset( $gallery_captions[ $feat_id ] ) && ! empty( $gallery_captions[ $feat_id ] ) 
			? $gallery_captions[ $feat_id ] 
			: ( get_the_post_thumbnail_caption() ?: get_the_title() );

		$gallery_items[] = array(
			'url'     => $feat_src,
			'caption' => $feat_cap,
		);
	}

	if ( ! empty( $gallery_images_raw ) ) {
		$img_ids = explode( ',', $gallery_images_raw );
		foreach ( $img_ids as $id ) {
			$src = wp_get_attachment_image_url( $id, 'full' );
			$cap = isset( $gallery_captions[ $id ] ) && ! empty( $gallery_captions[ $id ] ) 
				? $gallery_captions[ $id ] 
				: ( wp_get_attachment_caption( $id ) ?: get_the_title() );

			if ( $src ) {
				$gallery_items[] = array(
					'url'     => $src,
					'caption' => $cap,
				);
			}
		}
	}

	// Fallback demo gallery images if empty
	if ( empty( $gallery_items ) ) {
		$demo_photos = array(
			array( 'url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1200&auto=format&fit=crop&q=80', 'caption' => 'বর্ষায় শ্রীমঙ্গলের সবুজ চা বাগান ও পাহাড়ি নদীর অপরূপ জলরাশি' ),
			array( 'url' => 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=1200&auto=format&fit=crop&q=80', 'caption' => 'সরিষাবাড়ীর চরাঞ্চলে কৃষকের সোনালী হাসি ও নতুন আমন ধান কাটার দৃশ্য' ),
			array( 'url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&auto=format&fit=crop&q=80', 'caption' => 'কক্সবাজার সমুদ্র সৈকতে গোধূলি লগ্নের রক্তিম সূর্য ও পর্যটকদের আনন্দ মুহূর্ত' ),
			array( 'url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1200&auto=format&fit=crop&q=80', 'caption' => 'জাতীয় নাট্যোৎসবে আদিবাসী নৃত্যশিল্পীদের অপূর্ব ঐতিহ্যবাহী পরিবেশনা' ),
			array( 'url' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=1200&auto=format&fit=crop&q=80', 'caption' => 'যমুনার অববাহিকায় জেগে ওঠা সবুজ চরে শ্রমজীবী মানুষের জীবনসংগ্রাম' ),
		);
		$gallery_items = $demo_photos;
	}

	$total_photos = count( $gallery_items );
?>

  <!-- Single Photo Story Main Layout -->
  <main class="container">
    <div class="single-page-layout">
      
      <!-- Left Column: Photo Feature Content -->
      <article class="single-article-main">
        
        <!-- 1. Breadcrumbs -->
        <nav class="breadcrumb-bar">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">প্রচ্ছদ</a>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <a href="<?php echo esc_url( home_url( '/photo-stories' ) ); ?>">ছবির গল্প</a>
          <i class="fas fa-angle-right" style="font-size: 0.75rem;"></i>
          <span><?php echo wp_trim_words( get_the_title(), 5, '...' ); ?></span>
        </nav>

        <!-- 2. Headline & Badge -->
        <div style="margin-bottom: 0.75rem;">
          <span class="special-tag" style="background: #e11d48; color: #fff; font-size: 0.8rem; padding: 4px 10px; border-radius: 4px;">
            <i class="fas fa-camera"></i> ছবির গল্প ও ফটো ফিচার
          </span>
          <span style="background: var(--surface-secondary); color: var(--text-main); font-size: 0.8rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; border: 1px solid var(--border-color); margin-left: 0.5rem;">
            <i class="far fa-images"></i> মোট <?php echo bdk_to_bengali_numerals( $total_photos ); ?>টি ছবি
          </span>
        </div>

        <h1 class="article-headline" style="font-size: 2rem; line-height: 1.35; margin-bottom: 0.75rem;">
          <?php the_title(); ?>
        </h1>

        <?php if ( has_excerpt() ) : ?>
          <p class="article-subheadline" style="font-size: 1.05rem; color: var(--text-muted); margin-bottom: 1.25rem;">
            <?php echo get_the_excerpt(); ?>
          </p>
        <?php endif; ?>

        <!-- 3. Photographer & Meta Toolbar -->
        <div class="article-author-toolbar" style="margin-bottom: 2rem;">
          <div class="author-meta-block">
            <div class="author-avatar" style="width: 48px; height: 48px; border-radius: 50%; background: #006a4e; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
              <i class="fas fa-camera-retro"></i>
            </div>
            <div class="author-meta-text">
              <h5>ছবি: <?php echo esc_html( $photographer ); ?> <span style="font-size: 0.8rem; color: var(--primary-color); font-weight: normal;">(<?php echo esc_html( $location ); ?>)</span></h5>
              <span><i class="far fa-clock"></i> প্রকাশিত: <?php echo esc_html( bdk_bengali_date() ); ?> | <?php echo bdk_posted_time_ago(); ?></span>
            </div>
          </div>

          <div class="article-action-tools">
            <button class="tool-btn" id="printArticleBtn" title="প্রিন্ট করুন"><i class="fas fa-print"></i></button>
            <button class="tool-btn" id="copyLinkBtn" title="লিংক কপি করুন"><i class="far fa-copy"></i></button>
          </div>
        </div>

        <!-- 4. Interactive Photo Gallery Grid with Visible Captions under Each Photo -->
        <div class="photo-story-gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
          <?php foreach ( $gallery_items as $index => $item ) : ?>
            <div class="gallery-photo-card" data-index="<?php echo $index; ?>" style="display: flex; flex-direction: column; border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow); border: 1px solid var(--border-color); background: var(--surface-color); cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;">
              
              <!-- Photo Image Container -->
              <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; background: #0f172a;">
                <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['caption'] ); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                <span style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.75); color: #fff; font-size: 0.75rem; font-weight: 700; padding: 3px 8px; border-radius: 4px; backdrop-filter: blur(2px);">
                  <i class="fas fa-expand"></i> বড় করুন
                </span>
              </div>
              
              <!-- Clean Visible Caption Underneath Each Photo -->
              <div class="photo-card-caption-box" style="padding: 0.9rem 1.1rem; background: var(--surface-color); display: flex; gap: 0.6rem; align-items: flex-start;">
                <span style="background: var(--primary-color); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 2px 7px; border-radius: 4px; flex-shrink: 0; margin-top: 2px;">
                  ছবি <?php echo bdk_to_bengali_numerals( $index + 1 ); ?>
                </span>
                <p style="margin: 0; font-size: 0.92rem; font-weight: 600; color: var(--text-main); line-height: 1.45;">
                  <?php echo esc_html( $item['caption'] ); ?>
                </p>
              </div>

            </div>
          <?php endforeach; ?>
        </div>

        <!-- 5. Story Written Content -->
        <div class="article-body-content" id="articleBodyContent" style="margin-bottom: 2rem;">
          <?php the_content(); ?>
        </div>

        <!-- 6. Social Share Bar -->
        <div class="share-bar-sticky">
          <span style="font-weight: 700; font-size: 0.95rem; margin-right: 0.5rem;">শেয়ার করুন:</span>
          <?php
          $share_url   = urlencode( get_permalink() );
          $share_title = urlencode( get_the_title() );
          ?>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-fb">
            <i class="fab fa-facebook-f"></i> ফেসবুক
          </a>
          <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . '%20' . $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-wa">
            <i class="fab fa-whatsapp"></i> হোয়াটসঅ্যাপ
          </a>
          <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" rel="noopener" class="share-btn-brand share-tw">
            <i class="fab fa-x-twitter"></i> টুইটার
          </a>
          <button type="button" class="share-btn-brand share-copy" id="copyLinkBtn">
            <i class="fas fa-link"></i> লিংক কপি
          </button>
        </div>

        <!-- 7. Comments Section -->
        <?php
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;
        ?>

      </article>

      <!-- Sticky Sidebar -->
      <?php get_sidebar(); ?>

    </div>
  </main>

  <!-- ================= 8. FULL-SCREEN INTERACTIVE PHOTO LIGHTBOX SLIDER ================= -->
  <div class="photo-lightbox-modal" id="photoLightboxModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.96); z-index: 999999; flex-direction: column; justify-content: space-between; padding: 20px;">
    
    <!-- Top Lightbox Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; color: #fff; width: 100%; max-width: 1200px; margin: 0 auto;">
      <div style="font-size: 1.1rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
        <i class="fas fa-camera" style="color: var(--accent-color);"></i> <span id="lightboxIndexCount">ছবি ১ / <?php echo bdk_to_bengali_numerals( $total_photos ); ?></span>
      </div>
      <div style="display: flex; gap: 15px; align-items: center;">
        <button id="lightboxCloseBtn" style="background: none; border: none; color: #fff; font-size: 1.75rem; cursor: pointer;" title="বন্ধ করুন (Esc)"><i class="fas fa-times"></i></button>
      </div>
    </div>

    <!-- Center Stage: Main Image & Navigation Arrows -->
    <div style="position: relative; width: 100%; max-width: 1100px; height: 70vh; margin: auto; display: flex; align-items: center; justify-content: center;">
      <!-- Prev Button -->
      <button id="lightboxPrevBtn" style="position: absolute; left: 10px; z-index: 10; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 50%; width: 50px; height: 50px; cursor: pointer; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <i class="fas fa-chevron-left"></i>
      </button>

      <!-- Active Slide Image -->
      <img id="lightboxActiveImg" src="<?php echo esc_url( $gallery_items[0]['url'] ); ?>" alt="গ্যালারি ছবি" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 35px rgba(0,0,0,0.8); transition: opacity 0.25s ease;">

      <!-- Next Button -->
      <button id="lightboxNextBtn" style="position: absolute; right: 10px; z-index: 10; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 50%; width: 50px; height: 50px; cursor: pointer; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Bottom Caption Bar (Prominently displaying the photo description) -->
    <div style="text-align: center; color: #ffffff; width: 100%; max-width: 950px; margin: 0 auto 10px; background: rgba(0,0,0,0.6); padding: 12px 20px; border-radius: 8px; backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.15);">
      <p id="lightboxActiveCaption" style="font-size: 1.05rem; font-weight: 600; margin: 0; line-height: 1.45; text-shadow: 0 2px 4px rgba(0,0,0,0.9);">
        <?php echo esc_html( $gallery_items[0]['caption'] ); ?>
      </p>
    </div>

  </div>

  <script>
  (function() {
    const galleryItems = <?php echo json_encode( $gallery_items ); ?>;
    const totalCount = galleryItems.length;
    let currentIndex = 0;

    const modal = document.getElementById('photoLightboxModal');
    const activeImg = document.getElementById('lightboxActiveImg');
    const activeCaption = document.getElementById('lightboxActiveCaption');
    const indexCounter = document.getElementById('lightboxIndexCount');
    const prevBtn = document.getElementById('lightboxPrevBtn');
    const nextBtn = document.getElementById('lightboxNextBtn');
    const closeBtn = document.getElementById('lightboxCloseBtn');

    function toBengali(num) {
      const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
      return num.toString().replace(/\d/g, d => bnDigits[d]);
    }

    function updateLightbox(index) {
      if (index < 0) index = totalCount - 1;
      if (index >= totalCount) index = 0;
      currentIndex = index;

      activeImg.style.opacity = '0.3';
      setTimeout(() => {
        activeImg.src = galleryItems[currentIndex].url;
        activeCaption.innerText = galleryItems[currentIndex].caption;
        indexCounter.innerText = 'ছবি ' + toBengali(currentIndex + 1) + ' / ' + toBengali(totalCount);
        activeImg.style.opacity = '1';
      }, 120);
    }

    // Open lightbox on card click
    document.querySelectorAll('.gallery-photo-card').forEach(card => {
      card.addEventListener('click', function() {
        const idx = parseInt(this.getAttribute('data-index')) || 0;
        updateLightbox(idx);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      });
    });

    // Prev / Next click handlers
    prevBtn?.addEventListener('click', (e) => {
      e.stopPropagation();
      updateLightbox(currentIndex - 1);
    });

    nextBtn?.addEventListener('click', (e) => {
      e.stopPropagation();
      updateLightbox(currentIndex + 1);
    });

    // Close button handler
    function closeLightbox() {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }

    closeBtn?.addEventListener('click', closeLightbox);

    // Keyboard navigation (Left, Right, Esc)
    document.addEventListener('keydown', function(e) {
      if (modal.style.display === 'flex') {
        if (e.key === 'ArrowLeft') {
          updateLightbox(currentIndex - 1);
        } else if (e.key === 'ArrowRight') {
          updateLightbox(currentIndex + 1);
        } else if (e.key === 'Escape') {
          closeLightbox();
        }
      }
    });

    // Close on clicking backdrop
    modal?.addEventListener('click', function(e) {
      if (e.target === modal) {
        closeLightbox();
      }
    });
  })();
  </script>

<?php
endwhile;

get_footer();
