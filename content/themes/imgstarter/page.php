<?php get_header(); ?>
<?php tha_content_before(); ?>

<div class="col-sm-8">
	<?php if ( have_posts() ) : ?>

		<?php tha_content_while_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

		<?php tha_content_top(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<h2><?php the_title(); ?></h2>

			<?php include (TEMPLATEPATH . '/inc/meta.php'); ?>

			<?php tha_entry_before(); ?>
			<div class="entry">

				<?php tha_entry_top(); ?>
				<?php tha_entry_content_before(); ?>

				<?php the_content(); ?>

				<?php tha_entry_content_after(); ?>
				<?php tha_entry_bottom(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

			</div>
			<?php tha_entry_after(); ?>

			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

		</div>

		<?php tha_content_bottom(); ?>

		<?php // comments_template(); ?>

		<?php endwhile; ?>

		<?php tha_content_while_after(); ?>

	<?php endif; ?>
</div>

<?php tha_content_after(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
