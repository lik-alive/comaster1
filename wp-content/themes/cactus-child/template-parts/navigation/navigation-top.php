<nav class="site-nav" role="navigation">
  <?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
		'fallback_cb'    => 'wp_page_menu'
	) ); ?>
</nav>
