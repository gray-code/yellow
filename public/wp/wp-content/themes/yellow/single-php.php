<?php
// File Name:		single.php
// Template Name:	Single Template
?>
<?php
// Initialize
$contents_list = null;
$cf = null;
$categories = null;
$cat = null;
$i = 1;

// Get the custom field
$cf = get_post_custom();

// Get the category
$categories = array();
$cat = get_the_terms( get_the_ID(), 'php_post_cat');
?>
<?php get_header(); ?>

<header class="archive_header header_php">
	<p><img src="<?php echo get_template_directory_uri(); ?>/img/title_php.png" srcset="<?php echo get_template_directory_uri(); ?>/img/title_phpx2.png 2x" alt="PHPプログラミング"></p>
</header>

<div class="wrapper">
	<main class="main_content">
		<div class="main_content_wrap">
			<?php if( have_posts() ): ?>
				<?php while( have_posts() ): the_post(); ?>
					<article class="article_php">
						<header <?php if( empty($cf['table_of_contents'][0]) ): ?>class="no_table_of_contents"<?php endif; ?>>
							<div class="text_info"><time datetime="<?php echo get_the_modified_date('Y-m-d'); ?>"><?php echo get_the_modified_date('Y.m.d'); ?></time><p class="text_category php"><?php echo getBlogCategory($cat); ?></p></div>
							<?php if( !empty($cf['subtitle'][0]) ): ?><p class="subtitle"><?php echo $cf['subtitle'][0]; ?></p><?php endif; ?>
							<h1><?php the_title(); ?></h1>
							<ul class="sns_area">
								<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
							</ul>
							<p class="text_excerpt"><?php echo nl2br(get_the_excerpt()); ?></p>
						</header>
						<?php if( !empty($cf['table_of_contents'][0]) ): ?>
						<section class="content_table">
							<h2><span>目次</span></h2>
							<?php
							$contents_list = preg_split( '/\n/', $cf['table_of_contents'][0]);
							?>
							<ol>
								<?php if( 0 < count($contents_list) ): ?>
									<?php foreach( $contents_list as $value ): ?>
										<li>#&nbsp;&nbsp;<a href="#section<?php echo $i; ?>"><?php echo $value; ?></a></li>
										<?php $i++; ?>
									<?php endforeach; ?>
								<?php else: ?>
									<li>#&nbsp;&nbsp;<a href="#section1"><?php echo $contents_list; ?></a></li>
								<?php endif; ?>
							</ol>
						</section>
						<?php endif; ?>
						<div class="ad_type05">
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
							'post_type' => 'php',
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
								<h2><span>関連記事</span></h2>
								<ul>
								<?php while( $relation_post->have_posts() ): $relation_post->the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
								</ul>
							</section>
						<?php endif; ?>

						<footer class="sns_area">
							<ul>
								<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
							</ul>
						</footer>
					</article>

					<!-- Paging -->
					<?php
					$now_current = array_pop($categories);
					if( isset($categories[0]) && $categories[0]->slug === 'php' ) {
						$now_current = $categories[0];
					}
					$next_post = get_adjacent_post( true, '', false);
					$prev_post = get_adjacent_post( true, '', true);
					?>
					<div class="paging">
						<?php if( $next_post !== "" ): ?><p class="link_next"><a href="<?php echo get_the_permalink($next_post->ID); ?>"><?php echo $next_post->post_title; ?></a></p><?php else: ?><div class="link_next">&nbsp;</div><?php endif; ?><p class="link_list"><a href="/php/">一覧へ</a></p><?php if( $prev_post !== "" ): ?><p class="link_prev"><a href="<?php echo get_the_permalink($prev_post->ID); ?>"><?php echo $prev_post->post_title; ?></a></p><?php else: ?><div class="link_prev">&nbsp;</div><?php endif; ?>
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

			<!-- Popular List -->
			<section class="popular_list">
				<h2 class="ttl_popular"><span>よく読まれている記事</span></h2>
				<?php
				$wpp = array(
					'limit' => 5,
					'range' => 'weekly',
					'order_by' => 'views',
					'post_type' => 'post',
					'thumbnail_width' => '100',
					'thumbnail_height' => '100',
					'wpp_start' => '<ul>',
					'wpp_end' => '</ul>'
				);
				wpp_get_mostpopular($wpp);
				?>
			</section>
			<!-- //Popular List -->

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
	<?php get_sidebar('php'); ?>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/highlights/zenburn.css">
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