<?php get_header(); ?>
<header class="archive_header">
	<p><img src="<?php echo get_template_directory_uri(); ?>/img/title_html.png" srcset="<?php echo get_template_directory_uri(); ?>/img/title_htmlx2.png 2x" alt="HTML5&CSS3"></p>
</header>

<div class="wrapper php_wrapper">
	<main class="main_content">
		<div class="main_content_wrap">
			<?php if( have_posts() ): ?>
				<?php while( have_posts() ): the_post(); ?>
					<?php
					$cf = get_post_custom();
					$cat = get_the_terms( get_the_ID(), 'html_post_cat');
					$browser = get_field('browser');
					?>
					<article>
						<header>
							<div class="text_info">
								<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo the_date('Y.m.d'); ?></time><?php foreach( $cat as $value ): ?><p class="text_category"><?php echo $value->name; ?></p><?php endforeach; ?>
								<dl class="browser_list">
									<dt>対応ブラウザ</dt>
									<?php
									$browser_list = array(
										'IE9' => false,
										'IE10' => false,
										'IE11' => false,
										'firefox' => false,
										'Chrome' =>false,
										'Safari' => false,
										'Opera' => false,
										'iOS' => false,
										'Android' => false
									);

									if( !empty($browser) ) {
										foreach( $browser as $value ) {
											switch( $value ) {
												case "1":
													$browser_list['IE9'] = true;
													break;
												
												case "2":
													$browser_list['IE10'] = true;
													break;
												
												case "3":
													$browser_list['IE11'] = true;
													break;
												
												case "4":
													$browser_list['firefox'] = true;
													break;
												
												case "5":
													$browser_list['Chrome'] = true;
													break;
												
												case "6":
													$browser_list['Safari'] = true;
													break;
												
												case "7":
													$browser_list['Opera'] = true;
													break;
												
												case "8":
													$browser_list['iOS'] = true;
													break;
												
												case "9":
													$browser_list['Android'] = true;
													break;
											}
										}
									}
									
									// IE9
									if( $browser_list['IE9'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie9_on.png" alt="IE9 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie9_off.png" alt="IE9 非対応"></dd>';
									}
									
									// IE10
									if( $browser_list['IE10'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie10_on.png" alt="IE10 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie10_off.png" alt="IE10 非対応"></dd>';
									}

									// IE11
									if( $browser_list['IE11'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie11_on.png" alt="IE11 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ie11_off.png" alt="IE11 非対応"></dd>';
									}
									
									// firefox
									if( $browser_list['firefox'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_firefox_on.png" alt="firefox 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_firefox_off.png" alt="firefox 非対応"></dd>';
									}
									
									// Chrome
									if( $browser_list['Chrome'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_chrome_on.png" alt="Chrome 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_chrome_off.png" alt="Chrome 非対応"></dd>';
									}
									
									// Safari
									if( $browser_list['Safari'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_safari_on.png" alt="Safari 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_safari_off.png" alt="Safari 非対応"></dd>';
									}
									
									// Opera
									if( $browser_list['Opera'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_opera_on.png" alt="Opera 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_opera_off.png" alt="Opera 非対応"></dd>';
									}
									
									// iOS safari
									if( $browser_list['iOS'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ios_on.png" alt="iOS Safari 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_ios_off.png" alt="iOS Safari 非対応"></dd>';
									}
									
									// Android
									if( $browser_list['Android'] ) {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_android_on.png" alt="Android 対応"></dd>';
									} else {
										echo '<dd><img src="' . get_template_directory_uri() . '/img/icon_android_off.png" alt="Android 非対応"></dd>';
									}
									?>
								</dl>
							</div>

							<?php if( !empty($cf['tag_name'][0]) ): ?>
								<p class="text_name"><?php echo $cf['tag_name'][0]; ?></p>
							<?php endif; ?>
							<h1><?php the_title(); ?></h1>
							<ul class="sns_area">
								<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
							</ul>
						</header>
						<section class="descant_area">
							<?php if( !empty($cf['tag_excerpt'][0]) ): ?>
								<p class="text_excerpt"><?php echo nl2br($cf['tag_excerpt'][0]); ?></p>
							<?php endif; ?>
							<?php if( !empty($cf['code_sample'][0]) ): ?>
								<pre class="code_box"><code class="language-html"><?php echo htmlspecialchars( $cf['code_sample'][0], ENT_QUOTES); ?></code></pre>
							<?php endif; ?>
							<ul class="descant_list">
								
								<?php if( !empty($cf['tag_category'][0]) ): ?>
								<li>
									<p class="descant_category">カテゴリー</p>
									<div>
										<p><?php echo nl2br($cf['tag_category'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
								<?php if( !empty($cf['tag_content'][0]) ): ?>
								<li>
									<p class="descant_category">コンテンツモデル</p>
									<div>
										<p><?php echo nl2br($cf['tag_content'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
								<?php if( !empty($cf['tag_usecase'][0]) ): ?>
								<li>
									<p class="descant_category">使用ケース</p>
									<div>
										<p><?php echo nl2br($cf['tag_usecase'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
								<?php if( !empty($cf['default_parameter'][0]) || $cf['default_parameter'][0] === "0" ): ?>
								<li>
									<p class="descant_category">初期値</p>
									<div>
										<p><?php echo nl2br($cf['default_parameter'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
								<?php if( !empty($cf['inheritance'][0]) ): ?>
								<li>
									<p class="descant_category">継承</p>
									<div>
										<p><?php echo nl2br($cf['inheritance'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
								<?php if( !empty($cf['application'][0]) ): ?>
								<li>
									<p class="descant_category">適用できる要素</p>
									<div>
										<p><?php echo nl2br($cf['application'][0]); ?></p>
									</div>
								</li>
								<?php endif; ?>
							</ul>
						</section>

						<div class="ad_type07">
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- G-3 -->
							<ins class="adsbygoogle"
							     style="display:block"
							     data-ad-client="ca-pub-6292870682629488"
							     data-ad-slot="5504879258"
							     data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</div>

						<?php the_content(); ?>

						<?php
						$post_ids = array();
						
						for( $i=1; $i<=5; $i++ ) {
							if( !empty($cf['relation_link'.$i][0]) ) {
								$post_ids[] = $cf['relation_link'.$i][0];
							}
						}

						$args = array(
							'post_type' => 'html_css',
							'post_status' => 'publish',
							'post__in' => $post_ids,
							'orderby' => array(
								'title' => 'ASC',
								'meta_value' => 'ASC',
							),
						);
						$relation_post = new WP_Query($args);
						if( $relation_post->have_posts() ):	?>
							<section class="relation_link">
								<h2><span>関連リンク</span></h2>
								<ul>
								<?php while( $relation_post->have_posts() ): $relation_post->the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
								</ul>
							</section>
						<?php endif; ?>

						<footer class="sns_area">
							<ul>
								<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button"{count} data-via="koheiishido">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
							</ul>
						</footer>
					</article>

					<!-- Paging -->
					<?php
					$next_post = get_adjacent_post( true, '', false);
					$prev_post = get_adjacent_post( true, '', true);
					?>
					<div class="paging">
						<?php if( $next_post !== "" ): ?><p class="link_next"><a href="<?php echo get_the_permalink($next_post->ID); ?>"><?php echo $next_post->post_title; ?></a></p><?php else: ?><div class="link_next">&nbsp;</div><?php endif; ?><p class="link_list"><a href="/html_css/">一覧へ</a></p><?php if( $prev_post !== "" ): ?><p class="link_prev"><a href="<?php echo get_the_permalink($prev_post->ID); ?>"><?php echo $prev_post->post_title; ?></a></p><?php else: ?><div class="link_prev">&nbsp;</div><?php endif; ?>
					</div>
					<div class="paging_sp">
						<p class="link_next"><?php if( $next_post !== "" ): ?><a href="<?php echo get_the_permalink($next_post->ID); ?>">次のページ</a></p><?php else: ?><span>次のページ</span><?php endif; ?><p class="link_prev"><?php if( $prev_post !== "" ): ?><a href="<?php echo get_the_permalink($prev_post->ID); ?>">前のページ</a><?php else: ?><span>前のページ</span><?php endif; ?></p>
					</div>
					<!-- //Paging -->
				<?php endwhile; ?>
			<?php endif; ?>
			<div class="ad_type03">
				<div class="ad_left">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- GRAYCODE Type1 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-6292870682629488"
					     data-ad-slot="2830614454"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
				<div class="ad_right">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- GRAYCODE Type1 -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:300px;height:250px"
					     data-ad-client="ca-pub-6292870682629488"
					     data-ad-slot="2830614454"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				</div>
			</div>
			
			<!-- Alphabet List -->
			<section class="alphabet_list">
				<h2 class="ttl"><span>アルファベット順</span></h2>
				<?php
				// Initialize
				$alpha_post = null;
				$before_char = null;

				$args = array(
					'post_status' => 'publish',
					'post_type' => 'html_css',
					'posts_per_page' => -1,
					'orderby' => 'meta_value',
					'meta_key' => 'search_alpha',
					'order' => 'ASC'
				);
				$alpha_post = new WP_Query($args);
				
				if( $alpha_post->have_posts() ): ?>
				<dl>
					<?php while( $alpha_post->have_posts() ): ?>
						<?php
						$alpha_post->the_post();
						$cf = get_post_custom();
						?>
						<?php if( $before_char !== $cf['search_alpha'][0][0] ): ?>
							<?php $before_char = $cf['search_alpha'][0][0]; ?>
							<dt><?php echo strtoupper($before_char); ?></dt>
						<?php endif; ?>
						<dd><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></dd>
					<?php endwhile; ?>
				</dl>
				<?php endif; ?>
			</section>
			<!-- //Alphabet List -->

			<div class="ad_type02 sp_ad">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- GRAYCODE Type1 -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:300px;height:250px"
				     data-ad-client="ca-pub-6292870682629488"
				     data-ad-slot="2830614454"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
	</main>

	<?php get_sidebar('html'); ?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/highlights/tomorrow.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/highlight.pack.js"></script>
<script type="text/javascript">
$(function(){
	hljs.configure({
		tabReplace: "	"
	});
	hljs.initHighlightingOnLoad();
});
</script>


<?php get_footer(); ?>