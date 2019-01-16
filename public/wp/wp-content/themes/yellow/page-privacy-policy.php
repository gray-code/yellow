<?php
// File Name:		page-privacy-policy.php
// Template Name:	Privacy Policy Template
?>
<?php get_header(); ?>

<?php if( have_posts() ): ?>
<?php while( have_posts() ): the_post(); ?>
<div class="wrapper">
	<main class="main-content">
		<article class="terms-wrap">
			<h1><?php the_title(); ?></h1>
			<p class="text-last-updated">最終更新日：<time datetime="<?php echo get_the_modified_date('Y-m-d'); ?>"><?php echo get_the_modified_date('Y年m月d日'); ?></time></p>
			<div class="terms-content">
				<?php the_content(); ?>
			</div>
		</article>
	</main>

	<?php get_sidebar(); ?>
</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>