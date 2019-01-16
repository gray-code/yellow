<?php
// File Name:		page-terms.php
// Template Name:	Terms Template
?>
<?php get_header(); ?>

<?php if( have_posts() ): ?>
<?php while( have_posts() ): the_post(); ?>
<div class="wrapper">
	<main class="main-content">
		<?php the_content(); ?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>