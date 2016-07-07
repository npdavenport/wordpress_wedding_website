<form action="/" method="get">
	<label for="search"></label>
	<div class="form-group has-feedback">
		<input type="text" class="form-control" name="s" id="search" value="<?php the_search_query(); ?>" />
		<i class="glyphicon glyphicon-search form-control-feedback"></i>
	</div>
	<input type="submit" class="search-submit btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />	
	<input type="hidden" value="post" name="post_type" id="post_type" />
</form>
