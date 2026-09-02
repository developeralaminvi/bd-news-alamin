<?php
/**
 * The Comments Template for BD News Alamin Theme
 *
 * @package BD_News_Alamin
 */

if ( post_password_required() ) {
	return;
}
?>

<section class="article-comments-section" id="comments">
	
	<div class="comments-header-bar">
		<h3>
			<i class="fas fa-comments"></i> পাঠকদের মতামত 
			<span class="comments-count-pill" id="commentCountBadge">
				<?php echo bdk_to_bengali_numerals( get_comments_number() ); ?>টি
			</span>
		</h3>
		<span style="font-size: 0.82rem; color: var(--text-muted);"><i class="fas fa-shield-halved"></i> মডারেটেড ফোরাম</span>
	</div>

	<!-- Custom Styled Comment Form -->
	<div class="comment-form-box">
		<?php
		$commenter     = wp_get_current_commenter();
		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );
		$consent       = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		$fields = array(
			'author' => '<div class="comment-form-grid"><input type="text" id="author" name="author" class="comment-input-field" placeholder="আপনার পূর্ণ নাম *" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' required>',
			'email'  => '<input type="email" id="email" name="email" class="comment-input-field" placeholder="ইমেইল ঠিকানা (প্রকাশিত হবে না) *" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' required></div>',
			'cookies' => '<div class="comment-form-actions"><label class="save-info-checkbox"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> পরবর্তী মন্তব্যের জন্য নাম ও ইমেইল ব্রাউজারে সংরক্ষণ করুন</label></div>',
		);

		$comments_args = array(
			'title_reply'          => '<i class="fas fa-pen-to-square" style="color: var(--primary-color);"></i> আপনার মূল্যবান মন্তব্য লিখুন',
			'title_reply_to'       => 'উত্তর দিন: %s',
			'cancel_reply_link'    => 'বাতিল করুন',
			'comment_field'        => '<textarea id="comment" name="comment" class="comment-textarea" placeholder="সংবাদ সম্পর্কিত গঠনমূলক ও বস্তুনিষ্ঠ মতামত লিখুন..." required></textarea>',
			'fields'               => $fields,
			'submit_button'        => '<button type="submit" class="submit-brand-btn" style="padding: 0.6rem 1.4rem; margin-top: 0.75rem;"><i class="fas fa-paper-plane"></i> মন্তব্য প্রকাশ করুন</button>',
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
		);

		comment_form( $comments_args );
		?>
	</div>

	<!-- Comments List -->
	<?php if ( have_comments() ) : ?>
		<div class="comments-list" id="commentsListContainer">
			<?php
			wp_list_comments( array(
				'style'       => 'div',
				'short_ping'  => true,
				'avatar_size' => 44,
				'callback'    => 'bdk_custom_comment_callback',
			) );
			?>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="comment-navigation" style="margin-top: 1.5rem; text-align: center;">
				<?php paginate_comments_links(); ?>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

</section>

<?php
/**
 * Custom Comment Callback for Modern Threaded Layout
 * Depth-aware: replies show reply badge, indent, and thread accent line
 */
function bdk_custom_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$is_reply           = $depth > 1;
	$parent_author      = '';
	if ( $is_reply && $comment->comment_parent ) {
		$parent          = get_comment( $comment->comment_parent );
		$parent_author   = $parent ? get_comment_author( $parent->comment_ID ) : '';
	}
?>
	<div <?php comment_class( 'comment-single-item' . ( $is_reply ? ' is-reply depth-' . $depth : '' ) ); ?> id="comment-<?php comment_ID(); ?>">

		<?php if ( $is_reply ) : ?>
		<!-- Reply thread indicator line -->
		<div class="reply-thread-line" aria-hidden="true"></div>
		<?php endif; ?>

		<div class="comment-inner-wrap<?php echo $is_reply ? ' reply-inner-wrap' : ''; ?>">

			<?php if ( $is_reply ) : ?>
			<!-- Reply Label Badge -->
			<div class="reply-indicator-badge">
				<i class="fas fa-reply" style="transform: scaleX(-1);"></i>
				<?php if ( $parent_author ) : ?>
					<span><?php echo esc_html( $parent_author ); ?>-এর উত্তরে</span>
				<?php else : ?>
					<span>উত্তর</span>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<div class="comment-author-header">
				<div class="comment-avatar">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
				<div class="comment-author-info">
					<h5>
						<?php echo get_comment_author_link(); ?>
						<?php if ( $is_reply ) : ?>
						<span class="commenter-reply-tag"><i class="fas fa-turn-down"></i> উত্তরদাতা</span>
						<?php else : ?>
						<span class="comment-verified-badge" title="ভেরিফাইড পাঠক"><i class="fas fa-circle-check"></i></span>
						<?php endif; ?>
					</h5>
					<span><i class="far fa-clock"></i> <?php printf( '%1$s, %2$s', get_comment_date( 'd M Y' ), get_comment_time( 'g:i A' ) ); ?></span>
				</div>
			</div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p style="color: #f59e0b; font-size: var(--fs-xs); margin-bottom: 0.5rem;"><i class="fas fa-hourglass-half"></i> আপনার মন্তব্যটি মডারেশনের অপেক্ষায় রয়েছে।</p>
			<?php endif; ?>

			<div class="comment-body-text">
				<?php comment_text(); ?>
			</div>

			<div class="comment-actions-bar">
				<button type="button" class="comment-action-btn" onclick="let s=this.querySelector('span'); s.innerText=parseInt(s.innerText)+1;">
					<i class="far fa-thumbs-up"></i> <span>৫</span>
				</button>
				<button type="button" class="comment-action-btn" onclick="let s=this.querySelector('span'); s.innerText=parseInt(s.innerText)+1;">
					<i class="far fa-thumbs-down"></i> <span>০</span>
				</button>
				<?php
				comment_reply_link( array_merge( $args, array(
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => '<i class="fas fa-reply"></i> উত্তর দিন',
				) ) );
				?>
			</div>

		</div><!-- .comment-inner-wrap -->
	</div><!-- .comment-single-item -->
<?php
}
?>
