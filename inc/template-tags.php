<?php
/**
 * Custom Template Tags and Helper Functions for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Convert English numbers to Bengali numerals
 */
function bdk_to_bengali_numerals( $number ) {
	if ( null === $number || '' === $number ) {
		return '';
	}
	$bengali_digits = array( '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' );
	$english_digits = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	return str_replace( $english_digits, $bengali_digits, (string) $number );
}

/**
 * Format post date in Bengali
 */
function bdk_bengali_date( $post_id = null ) {
	$date_timestamp = get_the_time( 'U', $post_id );
	$english_months = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
	$bangla_months  = array( 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );

	$english_days = array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' );
	$bangla_days  = array( 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার' );

	$day_num = bdk_to_bengali_numerals( date( 'd', $date_timestamp ) );
	$month   = str_replace( $english_months, $bangla_months, date( 'F', $date_timestamp ) );
	$year    = bdk_to_bengali_numerals( date( 'Y', $date_timestamp ) );
	$day     = str_replace( $english_days, $bangla_days, date( 'l', $date_timestamp ) );

	return sprintf( '%s, %s %s %s', $day, $day_num, $month, $year );
}

/**
 * Human-readable time ago in Bengali (e.g., '২৫ মিনিট আগে', '২ ঘণ্টা আগে')
 */
function bdk_posted_time_ago( $post_id = null ) {
	$post_time = get_post_time( 'U', true, $post_id );
	$current   = current_time( 'timestamp' );
	$diff      = $current - $post_time;

	if ( $diff < 60 ) {
		return 'এইমাত্র';
	} elseif ( $diff < 3600 ) {
		$mins = floor( $diff / 60 );
		return bdk_to_bengali_numerals( $mins ) . ' মিনিট আগে';
	} elseif ( $diff < 86400 ) {
		$hours = floor( $diff / 3600 );
		return bdk_to_bengali_numerals( $hours ) . ' ঘণ্টা আগে';
	} elseif ( $diff < 604800 ) {
		$days = floor( $diff / 86400 );
		return bdk_to_bengali_numerals( $days ) . ' দিন আগে';
	} else {
		return bdk_bengali_date( $post_id );
	}
}

/**
 * Calculate reading time in Bengali
 */
function bdk_reading_time( $post_id = null ) {
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = mb_strlen( strip_tags( $content ), 'UTF-8' ) / 5; // Approx for Bengali
	$minutes    = ceil( $word_count / 150 );
	if ( $minutes < 1 ) {
		$minutes = 1;
	}
	return bdk_to_bengali_numerals( $minutes ) . ' মিনিট পাঠ';
}

/**
 * Get and Track Post Views Counter
 */
function bdk_get_post_views( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	$count_key = 'bdk_post_views_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( '' === $count ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		return '০';
	}
	return bdk_to_bengali_numerals( $count );
}

function bdk_set_post_views( $post_id ) {
	$count_key = 'bdk_post_views_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( '' === $count ) {
		$count = 0;
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $post_id, $count_key, $count );
	}
}

/**
 * Primary Category Name & Link
 */
function bdk_get_primary_category( $post_id = null ) {
	$categories = get_the_category( $post_id );
	if ( ! empty( $categories ) ) {
		return sprintf(
			'<a href="%s" class="hero-cat-tag">%s</a>',
			esc_url( get_category_link( $categories[0]->term_id ) ),
			esc_html( $categories[0]->name )
		);
	}
	return '';
}

/**
 * Post Thumbnail with Fallback
 */
function bdk_post_thumbnail( $size = 'large', $classes = '', $alt = '' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size, array(
			'class'   => esc_attr( $classes ),
			'alt'     => esc_attr( $alt ? $alt : get_the_title() ),
			'loading' => 'lazy',
		) );
	} else {
		// Aesthetic fallback news image
		$fallback_url = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?w=800&auto=format&fit=crop&q=80';
		printf(
			'<img src="%s" class="%s" alt="%s" loading="lazy">',
			esc_url( $fallback_url ),
			esc_attr( $classes ),
			esc_attr( $alt ? $alt : get_the_title() )
		);
	}
}

/**
 * Dynamic Breadcrumbs
 */
function bdk_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="breadcrumb-bar" aria-label="Breadcrumb">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '"><i class="fas fa-house"></i> প্রচ্ছদ</a>';

	if ( is_category() ) {
		echo ' <span>/</span> <span>' . single_cat_title( '', false ) . '</span>';
	} elseif ( is_single() ) {
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			echo ' <span>/</span> <a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
		}
		echo ' <span>/</span> <span class="active-crumb">' . wp_trim_words( get_the_title(), 6, '...' ) . '</span>';
	} elseif ( is_page() ) {
		echo ' <span>/</span> <span class="active-crumb">' . get_the_title() . '</span>';
	} elseif ( is_search() ) {
		echo ' <span>/</span> <span>অনুসন্ধান: ' . esc_html( get_search_query() ) . '</span>';
	} elseif ( is_archive() ) {
		echo ' <span>/</span> <span>' . get_the_archive_title() . '</span>';
	}

	echo '</nav>';
}

/**
 * Render Header Brand Logo
 */
function bdk_header_logo() {
	$header_logo_url = get_theme_mod( 'bdk_header_logo', '' );
	$dark_logo_url   = get_theme_mod( 'bdk_dark_mode_logo', '' );
	$site_name       = get_bloginfo( 'name' );

	if ( empty( $header_logo_url ) ) {
		if ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo_src       = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			if ( $logo_src ) {
				$header_logo_url = $logo_src[0];
			}
		}
	}

	if ( empty( $header_logo_url ) ) {
		$header_logo_url = BDK_THEME_URI . '/images/logo.svg';
	}

	if ( ! empty( $dark_logo_url ) ) {
		echo '<img src="' . esc_url( $header_logo_url ) . '" alt="' . esc_attr( $site_name ) . '" class="brand-logo-img brand-logo-light">';
		echo '<img src="' . esc_url( $dark_logo_url ) . '" alt="' . esc_attr( $site_name ) . '" class="brand-logo-img brand-logo-dark">';
	} else {
		echo '<img src="' . esc_url( $header_logo_url ) . '" alt="' . esc_attr( $site_name ) . '" class="brand-logo-img">';
	}
}

/**
 * Render Footer Brand Logo
 */
function bdk_footer_logo() {
	$footer_logo_url = get_theme_mod( 'bdk_footer_logo', '' );
	$site_name       = get_bloginfo( 'name' );

	if ( empty( $footer_logo_url ) ) {
		$header_logo_url = get_theme_mod( 'bdk_header_logo', '' );
		if ( ! empty( $header_logo_url ) ) {
			$footer_logo_url = $header_logo_url;
		} elseif ( has_custom_logo() ) {
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			$logo_src       = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			if ( $logo_src ) {
				$footer_logo_url = $logo_src[0];
			}
		}
	}

	if ( empty( $footer_logo_url ) ) {
		$footer_logo_url = BDK_THEME_URI . '/images/logo.svg';
	}

	echo '<img src="' . esc_url( $footer_logo_url ) . '" alt="' . esc_attr( $site_name ) . '" class="footer-logo-img">';
}

/**
 * Render Fallback Navigation Menu when no Primary Menu is assigned
 */
function bdk_fallback_menu() {
	$current_slug = '';
	if ( is_category() ) {
		$q_obj = get_queried_object();
		if ( $q_obj ) {
			$current_slug = $q_obj->slug;
		}
	} elseif ( is_single() ) {
		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			$current_slug = $cats[0]->slug;
		}
	} elseif ( is_page() ) {
		$q_obj = get_queried_object();
		if ( $q_obj ) {
			$current_slug = $q_obj->post_name;
		}
	}

	$is_active = function( $slugs ) use ( $current_slug ) {
		if ( is_array( $slugs ) ) {
			return in_array( $current_slug, $slugs, true ) ? ' active current-menu-parent current-menu-ancestor ' : '';
		}
		return ( $current_slug === $slugs ) ? ' active current-menu-item ' : '';
	};

	$sports_subs = array( 'sports', 'cricket', 'football', 'tennis', 'olympics', 'local-sports' );
	$other_subs  = array( 'other', 'economy-trade', 'tech', 'entertainment', 'agriculture', 'jobs-career', 'education', 'art-culture', 'literature', 'talent-search', 'health-medical', 'editorial-opinion', 'opinions' );
	?>
	<ul id="mainMenu" class="main-menu">
		<li class="<?php echo is_front_page() ? 'active current-menu-item' : ''; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="home-icon-link" aria-label="প্রচ্ছদ"><i class="fas fa-house"></i></a></li>
		<li class="<?php echo $is_active('national'); ?>"><a href="<?php echo esc_url( home_url( '/category/national' ) ); ?>"><i class="fas fa-flag" style="color: #ef4444; margin-right: 4px;"></i> জাতীয়</a></li>
		<li class="<?php echo $is_active('politics'); ?>"><a href="<?php echo esc_url( home_url( '/category/politics' ) ); ?>"><i class="fas fa-landmark" style="color: #3b82f6; margin-right: 4px;"></i> রাজনীতি</a></li>
		<li class="<?php echo $is_active('international'); ?>"><a href="<?php echo esc_url( home_url( '/category/international' ) ); ?>"><i class="fas fa-globe" style="color: #10b981; margin-right: 4px;"></i> আন্তর্জাতিক</a></li>
		
		<!-- Sports Dropdown Menu -->
		<li class="menu-item menu-item-has-children <?php echo $is_active( $sports_subs ); ?>">
			<a href="<?php echo esc_url( home_url( '/category/sports' ) ); ?>">
				<i class="fas fa-trophy" style="color: #f59e0b; margin-right: 4px;"></i> খেলাধুলা <i class="fas fa-angle-down" style="font-size: 0.72rem; margin-left: 3px;"></i>
			</a>
			<ul class="sub-menu">
				<li class="<?php echo $is_active('cricket'); ?>"><a href="<?php echo esc_url( home_url( '/category/cricket' ) ); ?>"><i class="fas fa-baseball-bat-ball" style="color: #059669;"></i> ক্রিকেট</a></li>
				<li class="<?php echo $is_active('football'); ?>"><a href="<?php echo esc_url( home_url( '/category/football' ) ); ?>"><i class="fas fa-futbol" style="color: #2563eb;"></i> ফুটবল</a></li>
				<li class="<?php echo $is_active('tennis'); ?>"><a href="<?php echo esc_url( home_url( '/category/tennis' ) ); ?>"><i class="fas fa-table-tennis-paddle-ball" style="color: #d97706;"></i> টেনিস</a></li>
				<li class="<?php echo $is_active('olympics'); ?>"><a href="<?php echo esc_url( home_url( '/category/olympics' ) ); ?>"><i class="fas fa-trophy" style="color: #eab308;"></i> অলিম্পিক</a></li>
				<li class="<?php echo $is_active('local-sports'); ?>"><a href="<?php echo esc_url( home_url( '/category/local-sports' ) ); ?>"><i class="fas fa-medal" style="color: #9333ea;"></i> স্থানীয় খেলাধুলা</a></li>
			</ul>
		</li>

		<!-- Other Categories Dropdown Menu -->
		<li class="menu-item menu-item-has-children <?php echo $is_active( $other_subs ); ?>">
			<a href="#" onclick="return false;">
				<i class="fas fa-cubes" style="color: #8b5cf6; margin-right: 4px;"></i> অন্যান্য <i class="fas fa-angle-down" style="font-size: 0.72rem; margin-left: 3px;"></i>
			</a>
			<ul class="sub-menu">
				<li class="<?php echo $is_active('economy-trade'); ?>"><a href="<?php echo esc_url( home_url( '/category/economy-trade' ) ); ?>"><i class="fas fa-chart-line" style="color: #16a34a;"></i> অর্থ ও বাণিজ্য</a></li>
				<li class="<?php echo $is_active('tech'); ?>"><a href="<?php echo esc_url( home_url( '/category/tech' ) ); ?>"><i class="fas fa-microchip" style="color: #0284c7;"></i> বিজ্ঞান ও প্রযুক্তি</a></li>
				<li class="<?php echo $is_active('entertainment'); ?>"><a href="<?php echo esc_url( home_url( '/category/entertainment' ) ); ?>"><i class="fas fa-film" style="color: #e11d48;"></i> বিনোদন</a></li>
				<li class="<?php echo $is_active('agriculture'); ?>"><a href="<?php echo esc_url( home_url( '/category/agriculture' ) ); ?>"><i class="fas fa-wheat-awn" style="color: #ca8a04;"></i> কৃষি ও গ্রামীণ জীবন</a></li>
				<li class="<?php echo $is_active('jobs-career'); ?>"><a href="<?php echo esc_url( home_url( '/category/jobs-career' ) ); ?>"><i class="fas fa-briefcase" style="color: #0d9488;"></i> চাকরি ও ক্যারিয়ার</a></li>
				<li class="<?php echo $is_active('education'); ?>"><a href="<?php echo esc_url( home_url( '/category/education' ) ); ?>"><i class="fas fa-graduation-cap" style="color: #4f46e5;"></i> শিক্ষা</a></li>
				<li class="<?php echo $is_active('art-culture'); ?>"><a href="<?php echo esc_url( home_url( '/category/art-culture' ) ); ?>"><i class="fas fa-palette" style="color: #9333ea;"></i> শিল্প ও সংস্কৃতি</a></li>
				<li class="<?php echo $is_active('literature'); ?>"><a href="<?php echo esc_url( home_url( '/category/literature' ) ); ?>"><i class="fas fa-book-open" style="color: #c026d3;"></i> সাহিত্য ও দেওয়ালিকা</a></li>
				<li class="<?php echo $is_active('talent-search'); ?>"><a href="<?php echo esc_url( home_url( '/category/talent-search' ) ); ?>"><i class="fas fa-star" style="color: #eab308;"></i> প্রতিভার অন্বেষণ</a></li>
				<li class="<?php echo $is_active('health-medical'); ?>"><a href="<?php echo esc_url( home_url( '/category/health-medical' ) ); ?>"><i class="fas fa-user-doctor" style="color: #dc2626;"></i> স্বাস্থ্য ও চিকিৎসা</a></li>
				<li class="<?php echo $is_active( array( 'editorial-opinion', 'opinions' ) ); ?>"><a href="<?php echo esc_url( home_url( '/opinions' ) ); ?>"><i class="fas fa-pen-nib" style="color: #2563eb;"></i> সম্পাদকীয় ও মতামত</a></li>
			</ul>
		</li>
		
		<!-- Mobile Drawer Bottom CTA (Dashboard / Recruitment) -->
		<li class="mobile-nav-cta-item" style="margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( home_url( '/reporter-dashboard' ) ); ?>" class="mobile-nav-cta-btn" style="background: #10b981; color: #ffffff !important; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.75rem 1rem; border-radius: 8px; margin: 0.5rem 0.75rem; font-size: 0.95rem;">
					<i class="fas fa-gauge"></i> ড্যাশবোর্ড
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/reporter-account' ) ); ?>" class="mobile-nav-cta-btn" style="background: #dc2626; color: #ffffff !important; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.75rem 1rem; border-radius: 8px; margin: 0.5rem 0.75rem; font-size: 0.95rem;">
					<i class="fas fa-id-card-clip"></i> সাংবাদিক নিয়োগ (আবেদন করুন)
				</a>
			<?php endif; ?>
		</li>
	</ul>
	<?php
}

/**
 * Append Mobile CTA Button to Bottom of Primary Header Nav Menu
 */
function bdk_append_mobile_cta_to_nav( $items, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		ob_start();
		?>
		<!-- Mobile Drawer Bottom CTA (Dashboard / Recruitment) -->
		<li class="mobile-nav-cta-item" style="margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 0.5rem;">
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( home_url( '/reporter-dashboard' ) ); ?>" class="mobile-nav-cta-btn" style="background: #10b981; color: #ffffff !important; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.75rem 1rem; border-radius: 8px; margin: 0.5rem 0.75rem; font-size: 0.95rem;">
					<i class="fas fa-gauge"></i> ড্যাশবোর্ড
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/reporter-account' ) ); ?>" class="mobile-nav-cta-btn" style="background: #dc2626; color: #ffffff !important; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.75rem 1rem; border-radius: 8px; margin: 0.5rem 0.75rem; font-size: 0.95rem;">
					<i class="fas fa-id-card-clip"></i> সাংবাদিক নিয়োগ (আবেদন করুন)
				</a>
			<?php endif; ?>
		</li>
		<?php
		$cta_html = ob_get_clean();
		$items .= $cta_html;
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'bdk_append_mobile_cta_to_nav', 10, 2 );

