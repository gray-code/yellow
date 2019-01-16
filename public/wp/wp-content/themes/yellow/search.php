<?php
// File Name:		search.php
// Template Name:	Search Template
?>
<?php
// Initialize
$post_i = 0;
?>
<?php get_header(); ?>

<div class="wrapper">

	<div class="table_ad ad_type02">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- G-4 -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-6292870682629488"
		     data-ad-slot="8458345656"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>

	<div class="main_content">
		<div class="main_content_wrap">
			<h2 class="ttl_search_query"><?php echo get_search_query(); ?><span>検索結果：<?php echo $wp_query->found_posts; ?>件</span></h2>
			<?php if( have_posts() ): ?>
				<?php while( have_posts() ): the_post(); ?>
					<?php $cat = get_the_category(); ?>
					<?php if( $post_i === 3 ): ?>
						<div class="ad_type02">
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
					<?php endif; ?>
					<article<?php if( $post_i === 3 ): ?> class="border-top"<?php endif; ?>>
						<?php if( has_post_thumbnail() ): ?>
							<p class="thumb_content"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(100,100), array('alt'=>get_the_title())); ?></a></p>
						<?php else: ?>
							<p class="thumb_content"><a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/noimage_thumbnail.png" alt="No Image" width="100" height="100"></a></p>
						<?php endif; ?>
						<div class="text_content">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="text_excerpt"><?php echo nl2br(get_the_excerpt()); ?>&nbsp;&nbsp;<a href="<?php the_permalink(); ?>">記事を読む +</a></p>
							<div class="text_info"><time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date("Y.m.d"); ?></time><p class="text_category<?php if( getArticleType($cat[0]) === 'php' ) { echo ' php'; } ?>"><?php echo getBlogCategory(get_the_category()); ?></p></div>
						</div>
					</article>
					<?php $post_i++; ?>
				<?php endwhile; ?>
			<?php endif; ?>

			<?php
			global $paged;
			$max_page = (int)$wp_query->max_num_pages;
			?>
			<!-- Paging -->
			<div class="paging">
				<p class="link_next"><?php if( 1 < $paged ) { previous_posts_link('次のページ'); } else { echo "<span>次のページ</span>"; } ?></p><p class="text_page"><?php if( 1 < $paged ){ echo $paged; } else { echo '1'; } ?> / <?php echo $max_page; ?></p><p class="link_prev"><?php if( $paged < $max_page && 1 < $max_page ){ next_posts_link('前のページ'); } else { echo "<span>前のページ</span>"; } ?></p>
			</div>
			<!-- //Paging -->
			
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
		</div>
	</div>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>