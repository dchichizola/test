				</div> <!-- row -->
			</div> <!-- container -->
		</div> <!-- middle -->

	</div> <!-- DIV WRAP -->

	<div class="section-bottom-feature hidden-print">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
                	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Newsletter Area')) : ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="section-bottom hidden-print">

		<?php tha_footer_before(); ?>

		<div class="footer">
			<?php tha_footer_top(); ?>

			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<img src="https://placehold.it/210x60/E8117F/fff.png?text=footer-logo%402x.png" alt="" class="footer-logo">
					</div>
					<div class="col-sm-9 footer-links">
						<p>
							<a href="<?php echo get_permalink(wt_get_ID_by_page_name('Terms and Conditions')); ?>">Terms and Conditions</a> |
							<a href="<?php echo get_permalink(wt_get_ID_by_page_name('Privacy Policy')); ?>">Privacy Policy</a> |
							<a href="<?php echo get_permalink(wt_get_ID_by_page_name('Contact')); ?>">Contact Us</a> |
							<a href="<?php echo get_permalink(wt_get_ID_by_page_name('Site map')); ?>">Site map</a>
						</p>
						<p><span class="copyright">&copy; Copyright <?php echo date('Y'); ?></span></p>
					</div>
				</div>
			</div>

			<?php tha_footer_bottom(); ?>
		</div>

		<?php tha_footer_after(); ?>

	</div> <!-- End bottom -->

</div><!-- End Viewport -->

<div class="overlay"></div>
<div class="mobile_menu static hidden-lg-up">
	<div class="mobileMenuItems">
		<?php
			$items_wrap = '<ul class="%2$s"><li class="searchbox"><form method="get" action="'.get_bloginfo('siteurl').'"><input class="inputbox" name="s" placeholder="Search the site..." type="text" value="'. get_search_query() . '" /></form></li>%3$s</ul>';

			$args = array(
				'menu' => 'navbar',
				'container' => 'div',
				'container_id' => 'dnnMenu',
				'fallback_cb' => false,
				'menu_class' => 'menu',
				'menu_id' => 'mobile-navbar',
				'items_wrap' => $items_wrap
			);
			wp_nav_menu( $args );
		?>
	</div>
</div> <!-- End mobile_menu -->
<input type="hidden" id="templatepath" name="templatepath" value="<?php echo get_bloginfo('template_url');?>">
<input type="hidden" id="siteurl" name="siteurl" value="<?php echo get_bloginfo('url');?>">

<?php tha_body_bottom(); ?>
<?php wp_footer(); ?>
</body>
</html>
