<aside class="col-md-4 col-sm-5">
    <div class="list-group">
        <div class="list-group-item sidebar-group">

            <?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Primary Sidebar' ) ) : ?>
            
            <h4 class="site-search-title">Search This Site</h4>
            <?php get_search_form(); ?>

            <?php endif; ?>

       </div>
    </div>
</aside>