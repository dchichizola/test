<?php get_header(); ?>
<div class="col-sm-8">
	<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

		<?php
		if (is_category()) {
			/* If this is a category archive */
			?>
			<h2>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
			<?php
		} elseif (is_tag()) {
			/* If this is a tag archive */
			?>
			<h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
			<?php
		} elseif (is_day()) {
			/* If this is a daily archive */
			?>
			<h2>Archive for <?php the_time('F jS, Y'); ?></h2>
			<?php
		} elseif (is_month()) {
			/* If this is a monthly archive */
			?>
			<h2>Archive for <?php the_time('F, Y'); ?></h2>
			<?php
		} elseif (is_year()) {
			/* If this is a yearly archive */
			?>
			<h2>Archive for <?php the_time('Y'); ?></h2>
			<?php
		} elseif (is_author()) {
			/* If this is an author archive */
			?>
			<h2>Author Archive</h2>
			<?php
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			/* If this is a paged archive */
			?>
			<h2>Blog Archives</h2>
			<?php
		}
		?>

		<?php include (TEMPLATEPATH . '/inc/nav.php'); ?>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?>>

				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php include (TEMPLATEPATH . '/inc/meta.php'); ?>

				<div class="entry">
					<?php the_content(); ?>
				</div>

			</div>

		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/inc/nav.php'); ?>

	<?php else : ?>

		<h2>Nothing found</h2>

	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
