<?php get_header(); ?>
	<?php tha_content_top(); ?>
	<div class="col-sm-8">

		<?php if ( have_posts() ) : ?>

			<?php tha_content_while_before(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

				<?php include (TEMPLATEPATH . '/inc/meta.php'); ?>

				<?php tha_entry_before(); ?>
					<div class="entry">
						<?php tha_entry_top(); ?>
						<?php tha_entry_content_before(); ?>
						<?php the_content(); ?>
						<?php tha_entry_content_after(); ?>
						<?php tha_entry_bottom(); ?>
					</div>
				<?php tha_entry_after(); ?>

				<div class="postmetadata">
					<?php the_tags('Tags: ', ', ', '<br />'); ?>
					Posted in <?php the_category(', ') ?> |
					<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
				</div>

			</div>

		<?php endwhile; ?>

		<?php tha_content_while_after(); ?>

		<?php tha_comments_before(); ?>
		<!-- Post Comments Begin -->
		<?php //comments_template(); ?>
		<!-- post Comments End -->
		<?php tha_comments_after(); ?>

		<?php tha_content_bottom(); ?>

		<?php include (TEMPLATEPATH . '/inc/nav.php'); ?>

		<?php else : ?>

			<h2>Not Found</h2>

		<?php endif; ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
