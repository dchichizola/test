<?php tha_sidebars_before(); ?>
<div class="col-sm-4">
	<?php tha_sidebar_top(); ?>
	    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar')) : else : ?>
	        <!-- All this stuff in here only shows up if you DON'T have any widgets active in this zone -->
		<?php endif; ?>
	<?php tha_sidebar_bottom(); ?>
</div>
<?php tha_sidebars_after(); ?>
