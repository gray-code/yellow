<?php
// Get the custom field
$cf = get_post_custom();

// Get the category
$categories = array();
$cat = get_the_category();

/*
$cat = $cat[0];
while ( isset($cat->name) ) {
	array_unshift( $categories, $cat);
	$cat = get_category($cat->parent);
}
*/

// Get the Main Picture
$args = array(
	"alt" => get_the_title(),
	"title" => false,
);
$main_src = wp_get_attachment_image_src(post_custom('File Upload'), array( 620, 250), false, $args);

get_header();
?>
<div class="wrapper">
	<main class="main-content">
		<?php if( have_posts() ): ?>
			<?php while( have_posts() ): the_post(); ?>
				<article class="document-content">
					<header>
						<div class="text-info"><time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time><p class="text-category"><?php echo $cat[0]->name; ?></p></div>
						<h1><?php the_title(); ?></h1>
						<ul class="sns-area">
							<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
						</ul>
						<?php if( isset($main_src[0]) && $main_src[0] !== null ): ?>
							<p class="main_pic"><img src="<?php echo $main_src[0]; ?>" alt="<?php the_title(); ?>"></p>
						<?php endif; ?>
						<p class="text-excerpt"><?php echo nl2br(get_the_excerpt()); ?></p>
					</header>
					<hr>
					<?php if( isset($cf['table_of_contents']) && 0 < count($cf['table_of_contents']) ): ?>
					<section class="content_table">
						<h2><span>目次</span></h2>
						<ol>
							<?php for( $i=0; isset($cf['table_of_contents'][$i]); $i++ ): ?>
								<li>#&nbsp;&nbsp;<a href="#<?php echo 'section'.($i+1); ?>"><?php echo $cf['table_of_contents'][$i]; ?></a></li>
							<?php endfor; ?>
						</ol>
					</section>
					<?php endif; ?>

					<?php the_content(); ?>

					<?php if( isset($cf['relation_link'][0]) && 0 < count($cf['relation_link']) ): ?>
					<section class="relation_link">
						<h2><span>関連記事</span></h2>
						<ul>
							<?php for( $i=0; isset($cf['relation_link'][$i]); $i++ ): ?>
								<li><a href="<?php echo $cf['relation_link'][$i]; ?>" target="_blank" rel="nofollow"><?php echo $cf['relation_link_title'][$i]; ?></a></li>
							<?php endfor; ?>
						</ul>
					</section>
					<?php endif; ?>

					<footer>
						<ul class="sns-area">
							<li class="btn_fb"><div class="fb-share-button" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u&amp;src=sdkpreparse">シェア</a></div></li><li><a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></li><li><div class="g-plusone" data-size="medium" data-annotation="none"></div></li><li><a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="basic-label-counter" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script></li>
						</ul>
					</footer>
					<hr>
					<p class="link-toc"><a href="/document/">一覧へ</a></p>
					<section class="register-area">
						<p>無料で、登録後すぐにご利用いただけます。</p>
						<div class="btn-area"><a class="btn-register" href="/pre-register">アカウントを作成</a></div>
					</section>
				</article>
			<?php endwhile; ?>
		<?php endif; ?>

		<div class="ad-type02">
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
	</main>

	<?php get_sidebar(); ?>
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