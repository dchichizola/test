<div class="search-form-container">
	<form method="get" action="<?php echo get_bloginfo('siteurl');?>" class="search-form">
		<label for="s" class="search-label">Search for:</label>
		<input type="text" name="s" placeholder="Search the site..." value="<?php echo get_search_query(); ?>">
		<input type="submit" value="Search">
	</form>
</div>
