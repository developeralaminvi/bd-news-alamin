<?php
/**
 * Customizer Repeater Control for Homepage Sections
 *
 * @package BD_News_Alamin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'BDK_Customizer_Repeater_Control' ) ) {

	class BDK_Customizer_Repeater_Control extends WP_Customize_Control {
		public $type = 'bdk_repeater';

		public $categories = array();
		public $layouts    = array();

		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Fetch categories
			$cats = get_categories( array(
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			) );

			$this->categories = array(
				'0' => '— সাম্প্রতিক সকল খবর (Latest All) —',
			);
			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
				foreach ( $cats as $c ) {
					$this->categories[ (string) $c->term_id ] = $c->name;
				}
			}

			// Define layout designs
			$this->layouts = array(
				'design_1' => 'ডিজাইন ১: ১টি লিড + ২টি সাব কার্ড + ডানে সংবাদ তালিকা (জাতীয় গ্রিড)',
				'design_2' => 'ডিজাইন ২: ৪ কলাম ওভারলে ফটো গ্রিড (বিনোদন ও লাইফস্টাইল)',
				'design_3' => 'ডিজাইন ৩: ১টি বড় হাইলাইট কার্ড + ডানে ৩টি কমপ্যাক্ট স্ট্যাক (বাণিজ্য)',
				'design_4' => 'ডিজাইন ৪: ৪ কলাম স্ট্যান্ডার্ড ম্যাগাজিন কার্ড (আন্তর্জাতিক)',
				'design_5' => 'ডিজাইন ৫: ৩ কলাম ক্লাসিক নিউজ কার্ড গ্রিড',
				'design_6' => 'ডিজাইন ৬: ২ কলাম স্প্লিট কার্ড ও ফিচার্ড তালিকা (খেলাধুলা ও প্রযুক্তি)',
				'design_7' => 'ডিজাইন ৭: ১টি বড় লিড কার্ড + ৪টি অনুভূমিক তালিকা',
				'design_8' => 'ডিজাইন ৮: সারা দেশ ও জেলা বার্তা স্পেশাল গ্রিড (বিভাগ ফিল্টার সহ)',
			);
		}

		/**
		 * Render Control HTML
		 */
		public function render_content() {
			$raw_val = $this->value();
			$items   = array();

			if ( ! empty( $raw_val ) ) {
				if ( is_string( $raw_val ) ) {
					$items = json_decode( $raw_val, true );
				} elseif ( is_array( $raw_val ) ) {
					$items = $raw_val;
				}
			}

			if ( empty( $items ) || ! is_array( $items ) ) {
				if ( function_exists( 'bdk_get_default_homepage_sections' ) ) {
					$items = bdk_get_default_homepage_sections();
				} else {
					$items = array();
				}
			}

			$control_id = esc_attr( $this->id );
			?>
			<div class="bdk-repeater-control-wrapper" id="bdk-rep-ctrl-<?php echo $control_id; ?>">
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>

				<!-- Hidden Input bound to Customizer setting -->
				<input type="hidden" id="<?php echo $control_id; ?>" <?php $this->link(); ?> value="<?php echo esc_attr( wp_json_encode( $items ) ); ?>" class="bdk-repeater-collector" />

				<!-- Repeater Items Container -->
				<div class="bdk-repeater-items-list">
					<?php
					if ( ! empty( $items ) ) :
						foreach ( $items as $idx => $item ) :
							$cat_id      = isset( $item['category'] ) ? (string) $item['category'] : '0';
							$layout      = isset( $item['layout'] ) ? $item['layout'] : 'design_1';
							$title       = isset( $item['title'] ) ? $item['title'] : '';
							$btn_text    = isset( $item['btn_text'] ) ? $item['btn_text'] : 'আরও দেখুন';
							$posts_count = isset( $item['posts_count'] ) ? $item['posts_count'] : '';
							$enabled     = ! isset( $item['enabled'] ) || ! empty( $item['enabled'] );

							$cat_name = isset( $this->categories[ $cat_id ] ) ? $this->categories[ $cat_id ] : 'ক্যাটাগরি ' . $cat_id;
							$layout_name = isset( $this->layouts[ $layout ] ) ? explode( ':', $this->layouts[ $layout ] )[0] : 'ডিজাইন ১';
							?>
							<div class="bdk-rep-item-card" data-index="<?php echo esc_attr( $idx ); ?>">
								<div class="bdk-rep-item-header">
									<div class="bdk-rep-item-title-wrap">
										<span class="bdk-rep-drag-handle" title="সেকশন">☰</span>
										<strong class="bdk-rep-header-title">
											সেকশন <span class="bdk-item-num"><?php echo esc_html( $idx + 1 ); ?></span>: 
											<span class="bdk-item-cat-label"><?php echo esc_html( $cat_name ); ?></span> 
											<span class="bdk-item-layout-badge"><?php echo esc_html( $layout_name ); ?></span>
										</strong>
									</div>
									<div class="bdk-rep-actions">
										<button type="button" class="bdk-rep-action-btn bdk-rep-up" title="উপরে তুলুন">▲</button>
										<button type="button" class="bdk-rep-action-btn bdk-rep-down" title="নিচে নামান">▼</button>
										<button type="button" class="bdk-rep-action-btn bdk-rep-toggle" title="খুলুন বা বন্ধ করুন">▾</button>
										<button type="button" class="bdk-rep-action-btn bdk-rep-delete" title="মুছে ফেলুন">✕</button>
									</div>
								</div>

								<div class="bdk-rep-item-body">
									<div class="bdk-rep-field-group">
										<label class="bdk-rep-label">📂 ক্যাটাগরি নির্বাচন করুন:</label>
										<select class="bdk-field-category">
											<?php foreach ( $this->categories as $c_id => $c_name ) : ?>
												<option value="<?php echo esc_attr( $c_id ); ?>" <?php selected( (string) $c_id, (string) $cat_id ); ?>>
													<?php echo esc_html( $c_name ); ?>
												</option>
											<?php endforeach; ?>
										</select>
										<span class="bdk-rep-hint">নির্বাচিত ক্যাটাগরির পোস্টগুলো এই সেকশনে স্বয়ংক্রিয়ভাবে শো করবে।</span>
									</div>

									<div class="bdk-rep-field-group">
										<label class="bdk-rep-label">🎨 লেআউট ডিজাইন নির্বাচন করুন:</label>
										<select class="bdk-field-layout">
											<?php foreach ( $this->layouts as $l_key => $l_label ) : ?>
												<option value="<?php echo esc_attr( $l_key ); ?>" <?php selected( $l_key, $layout ); ?>>
													<?php echo esc_html( $l_label ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>

									<div class="bdk-rep-field-group">
										<label class="bdk-rep-label">🏷️ সেকশন শিরোনাম (ঐচ্ছিক):</label>
										<input type="text" class="bdk-field-title" value="<?php echo esc_attr( $title ); ?>" placeholder="খালি রাখলে ক্যাটাগরির নাম শো করবে" />
										<span class="bdk-rep-hint">খালি রাখলে স্বয়ংক্রিয়ভাবে ক্যাটাগরির নাম সেকশন শিরোনাম হিসেবে প্রদর্শিত হবে।</span>
									</div>

									<div class="bdk-rep-field-row">
										<div class="bdk-rep-field-col">
											<label class="bdk-rep-label">🔗 বাটন টেক্সট:</label>
											<input type="text" class="bdk-field-btn-text" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="আরও দেখুন" />
											<span class="bdk-rep-hint">বাটনে ক্লিক করলে সরাসরি ওই ক্যাটাগরির লিংকে যাবে।</span>
										</div>
										<div class="bdk-rep-field-col">
											<label class="bdk-rep-label">🔢 পোস্ট সংখ্যা (ঐচ্ছিক):</label>
											<input type="number" class="bdk-field-posts-count" min="1" max="30" value="<?php echo esc_attr( $posts_count ); ?>" placeholder="ডিফল্ট" />
											<span class="bdk-rep-hint">খালি রাখলে লেআউটের ডিফল্ট সংখ্যা ব্যবহৃত হবে।</span>
										</div>
									</div>

									<div class="bdk-rep-field-group bdk-rep-checkbox-wrap">
										<label>
											<input type="checkbox" class="bdk-field-enabled" <?php checked( $enabled ); ?> />
											<strong>এই সেকশনটি হোম পেজে প্রদর্শন করুন</strong>
										</label>
									</div>
								</div>
							</div>
						<?php
						endforeach;
					endif;
					?>
				</div>

				<!-- Add Button -->
				<button type="button" class="button button-primary bdk-rep-add-btn">
					<span class="dashicons dashicons-plus-alt2" style="line-height: inherit; vertical-align: middle; margin-right: 4px;"></span> 
					নতুন সেকশন যোগ করুন
				</button>

				<!-- Template for New Repeater Item -->
				<script type="text/template" class="bdk-rep-item-template">
					<div class="bdk-rep-item-card" data-index="__INDEX__">
						<div class="bdk-rep-item-header">
							<div class="bdk-rep-item-title-wrap">
								<span class="bdk-rep-drag-handle" title="সেকশন">☰</span>
								<strong class="bdk-rep-header-title">
									সেকশন <span class="bdk-item-num">__NUM__</span>: 
									<span class="bdk-item-cat-label">— সাম্প্রতিক সকল খবর —</span> 
									<span class="bdk-item-layout-badge">ডিজাইন ১</span>
								</strong>
							</div>
							<div class="bdk-rep-actions">
								<button type="button" class="bdk-rep-action-btn bdk-rep-up" title="উপরে তুলুন">▲</button>
								<button type="button" class="bdk-rep-action-btn bdk-rep-down" title="নিচে নামান">▼</button>
								<button type="button" class="bdk-rep-action-btn bdk-rep-toggle" title="খুলুন বা বন্ধ করুন">▾</button>
								<button type="button" class="bdk-rep-action-btn bdk-rep-delete" title="মুছে ফেলুন">✕</button>
							</div>
						</div>

						<div class="bdk-rep-item-body">
							<div class="bdk-rep-field-group">
								<label class="bdk-rep-label">📂 ক্যাটাগরি নির্বাচন করুন:</label>
								<select class="bdk-field-category">
									<?php foreach ( $this->categories as $c_id => $c_name ) : ?>
										<option value="<?php echo esc_attr( $c_id ); ?>">
											<?php echo esc_html( $c_name ); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<span class="bdk-rep-hint">নির্বাচিত ক্যাটাগরির পোস্টগুলো এই সেকশনে স্বয়ংক্রিয়ভাবে শো করবে।</span>
							</div>

							<div class="bdk-rep-field-group">
								<label class="bdk-rep-label">🎨 লেআউট ডিজাইন নির্বাচন করুন:</label>
								<select class="bdk-field-layout">
									<?php foreach ( $this->layouts as $l_key => $l_label ) : ?>
										<option value="<?php echo esc_attr( $l_key ); ?>">
											<?php echo esc_html( $l_label ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="bdk-rep-field-group">
								<label class="bdk-rep-label">🏷️ সেকশন শিরোনাম (ঐচ্ছিক):</label>
								<input type="text" class="bdk-field-title" value="" placeholder="খালি রাখলে ক্যাটাগরির নাম শো করবে" />
								<span class="bdk-rep-hint">খালি রাখলে স্বয়ংক্রিয়ভাবে ক্যাটাগরির নাম সেকশন শিরোনাম হিসেবে প্রদর্শিত হবে।</span>
							</div>

							<div class="bdk-rep-field-row">
								<div class="bdk-rep-field-col">
									<label class="bdk-rep-label">🔗 বাটন টেক্সট:</label>
									<input type="text" class="bdk-field-btn-text" value="আরও দেখুন" placeholder="আরও দেখুন" />
									<span class="bdk-rep-hint">বাটনে ক্লিক করলে সরাসরি ওই ক্যাটাগরির লিংকে যাবে।</span>
								</div>
								<div class="bdk-rep-field-col">
									<label class="bdk-rep-label">🔢 পোস্ট সংখ্যা (ঐচ্ছিক):</label>
									<input type="number" class="bdk-field-posts-count" min="1" max="30" value="" placeholder="ডিফল্ট" />
									<span class="bdk-rep-hint">খালি রাখলে লেআউটের ডিফল্ট সংখ্যা ব্যবহৃত হবে।</span>
								</div>
							</div>

							<div class="bdk-rep-field-group bdk-rep-checkbox-wrap">
								<label>
									<input type="checkbox" class="bdk-field-enabled" checked />
									<strong>এই সেকশনটি হোম পেজে প্রদর্শন করুন</strong>
								</label>
							</div>
						</div>
					</div>
				</script>
			</div>

			<style>
				.bdk-repeater-control-wrapper {
					margin-top: 10px;
					font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
				}
				.bdk-repeater-items-list {
					margin-bottom: 12px;
				}
				.bdk-rep-item-card {
					background: #fff;
					border: 1px solid #ccd0d4;
					border-radius: 6px;
					margin-bottom: 10px;
					box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
					transition: border-color 0.2s ease, box-shadow 0.2s ease;
				}
				.bdk-rep-item-card:hover {
					border-color: #2271b1;
					box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
				}
				.bdk-rep-item-header {
					padding: 10px 12px;
					background: #f8fafc;
					border-bottom: 1px solid #e2e8f0;
					border-radius: 5px 5px 0 0;
					display: flex;
					align-items: center;
					justify-content: space-between;
					cursor: pointer;
					user-select: none;
				}
				.bdk-rep-item-card.is-collapsed .bdk-rep-item-header {
					border-bottom: none;
					border-radius: 5px;
				}
				.bdk-rep-item-title-wrap {
					display: flex;
					align-items: center;
					gap: 6px;
					flex: 1;
					overflow: hidden;
				}
				.bdk-rep-drag-handle {
					color: #94a3b8;
					font-size: 14px;
					line-height: 1;
				}
				.bdk-rep-header-title {
					font-size: 13px;
					color: #1e293b;
					white-space: nowrap;
					overflow: hidden;
					text-overflow: ellipsis;
				}
				.bdk-item-layout-badge {
					display: inline-block;
					background: #e0f2fe;
					color: #0369a1;
					font-size: 11px;
					padding: 2px 6px;
					border-radius: 10px;
					font-weight: 600;
					margin-left: 4px;
				}
				.bdk-rep-actions {
					display: flex;
					align-items: center;
					gap: 4px;
					margin-left: 8px;
				}
				.bdk-rep-action-btn {
					background: transparent;
					border: 1px solid #cbd5e1;
					border-radius: 3px;
					color: #475569;
					cursor: pointer;
					font-size: 10px;
					width: 24px;
					height: 24px;
					display: flex;
					align-items: center;
					justify-content: center;
					padding: 0;
					line-height: 1;
					transition: all 0.15s ease;
				}
				.bdk-rep-action-btn:hover {
					background: #f1f5f9;
					color: #0f172a;
					border-color: #94a3b8;
				}
				.bdk-rep-action-btn.bdk-rep-delete:hover {
					background: #fee2e2;
					color: #dc2626;
					border-color: #fca5a5;
				}
				.bdk-rep-item-body {
					padding: 12px;
				}
				.bdk-rep-item-card.is-collapsed .bdk-rep-item-body {
					display: none;
				}
				.bdk-rep-field-group {
					margin-bottom: 12px;
				}
				.bdk-rep-field-group:last-child {
					margin-bottom: 0;
				}
				.bdk-rep-label {
					display: block;
					font-weight: 600;
					font-size: 12px;
					color: #334155;
					margin-bottom: 4px;
				}
				.bdk-rep-field-group select,
				.bdk-rep-field-group input[type="text"],
				.bdk-rep-field-group input[type="number"],
				.bdk-rep-field-col select,
				.bdk-rep-field-col input[type="text"],
				.bdk-rep-field-col input[type="number"] {
					width: 100%;
					border: 1px solid #cbd5e1;
					border-radius: 4px;
					padding: 6px 8px;
					font-size: 12px;
					background: #fff;
				}
				.bdk-rep-hint {
					display: block;
					font-size: 11px;
					color: #64748b;
					margin-top: 3px;
					font-style: italic;
				}
				.bdk-rep-field-row {
					display: flex;
					gap: 10px;
					margin-bottom: 12px;
				}
				.bdk-rep-field-col {
					flex: 1;
				}
				.bdk-rep-checkbox-wrap {
					background: #f8fafc;
					padding: 8px 10px;
					border-radius: 4px;
					border: 1px solid #e2e8f0;
				}
				.bdk-rep-checkbox-wrap label {
					display: flex;
					align-items: center;
					gap: 6px;
					font-size: 12px;
					cursor: pointer;
				}
				.bdk-rep-add-btn {
					width: 100%;
					height: 38px !important;
					font-size: 13px !important;
					display: flex !important;
					align-items: center;
					justify-content: center;
					border-radius: 4px !important;
				}
			</style>

			<script>
			(function($) {
				$(document).ready(function() {
					var $wrap = $('#bdk-rep-ctrl-<?php echo esc_js( $control_id ); ?>');
					if (!$wrap.length) return;

					var $input = $wrap.find('.bdk-repeater-collector');
					var settingId = '<?php echo esc_js( $this->id ); ?>';

					function serializeData() {
						var items = [];
						$wrap.find('.bdk-repeater-items-list .bdk-rep-item-card').each(function() {
							var $card = $(this);
							var cat = $card.find('.bdk-field-category').val() || '0';
							var layout = $card.find('.bdk-field-layout').val() || 'design_1';
							var title = $.trim($card.find('.bdk-field-title').val() || '');
							var btnText = $.trim($card.find('.bdk-field-btn-text').val() || 'আরও দেখুন');
							var postsCount = parseInt($card.find('.bdk-field-posts-count').val(), 10) || 0;
							var enabled = $card.find('.bdk-field-enabled').is(':checked');

							items.push({
								category: cat,
								layout: layout,
								title: title,
								btn_text: btnText,
								posts_count: postsCount,
								enabled: enabled
							});
						});

						var jsonStr = JSON.stringify(items);
						$input.val(jsonStr).trigger('change');

						if (wp && wp.customize && wp.customize(settingId)) {
							wp.customize(settingId).set(jsonStr);
						}
					}

					function refreshIndexes() {
						$wrap.find('.bdk-repeater-items-list .bdk-rep-item-card').each(function(idx) {
							var $card = $(this);
							$card.attr('data-index', idx);
							$card.find('.bdk-item-num').text(idx + 1);

							// Update title previews
							var catText = $card.find('.bdk-field-category option:selected').text();
							if (catText) {
								$card.find('.bdk-item-cat-label').text($.trim(catText));
							}
							var layoutText = $card.find('.bdk-field-layout option:selected').text();
							if (layoutText) {
								var shortLayout = layoutText.split(':')[0] || 'ডিজাইন ১';
								$card.find('.bdk-item-layout-badge').text($.trim(shortLayout));
							}
						});
					}

					// Toggle Accordion
					$wrap.on('click', '.bdk-rep-item-header', function(e) {
						if ($(e.target).closest('.bdk-rep-action-btn').length) {
							return; // Handled by button action
						}
						var $card = $(this).closest('.bdk-rep-item-card');
						$card.toggleClass('is-collapsed');
						$card.find('.bdk-rep-toggle').text($card.hasClass('is-collapsed') ? '▸' : '▾');
					});

					$wrap.on('click', '.bdk-rep-toggle', function(e) {
						e.preventDefault();
						var $card = $(this).closest('.bdk-rep-item-card');
						$card.toggleClass('is-collapsed');
						$(this).text($card.hasClass('is-collapsed') ? '▸' : '▾');
					});

					// Move Up
					$wrap.on('click', '.bdk-rep-up', function(e) {
						e.preventDefault();
						var $card = $(this).closest('.bdk-rep-item-card');
						var $prev = $card.prev('.bdk-rep-item-card');
						if ($prev.length) {
							$card.insertBefore($prev);
							refreshIndexes();
							serializeData();
						}
					});

					// Move Down
					$wrap.on('click', '.bdk-rep-down', function(e) {
						e.preventDefault();
						var $card = $(this).closest('.bdk-rep-item-card');
						var $next = $card.next('.bdk-rep-item-card');
						if ($next.length) {
							$card.insertAfter($next);
							refreshIndexes();
							serializeData();
						}
					});

					// Delete
					$wrap.on('click', '.bdk-rep-delete', function(e) {
						e.preventDefault();
						if (confirm('আপনি কি নিশ্চিত এই সেকশনটি মুছে ফেলতে চান?')) {
							var $card = $(this).closest('.bdk-rep-item-card');
							$card.slideUp(200, function() {
								$(this).remove();
								refreshIndexes();
								serializeData();
							});
						}
					});

					// Add New Section
					$wrap.find('.bdk-rep-add-btn').on('click', function(e) {
						e.preventDefault();
						var tmpl = $wrap.find('.bdk-rep-item-template').html();
						var count = $wrap.find('.bdk-repeater-items-list .bdk-rep-item-card').length;
						var html = tmpl.replace(/__INDEX__/g, count).replace(/__NUM__/g, count + 1);

						var $newItem = $(html).hide();
						$wrap.find('.bdk-repeater-items-list').append($newItem);
						$newItem.slideDown(200);

						refreshIndexes();
						serializeData();
					});

					// Live update on input changes
					$wrap.on('change', 'select, input', function() {
						refreshIndexes();
						serializeData();
					});
					$wrap.on('keyup', 'input[type="text"], input[type="number"]', function() {
						serializeData();
					});

					// Initial index refresh
					refreshIndexes();
				});
			})(jQuery);
			</script>
			<?php
		}
	}
}
