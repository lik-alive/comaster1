<?php
get_header(); ?>

 <!--Main Area-->
        
        <section class="page-title-bar title-left" style="background:;">
            <div class="container">
              <?php cactus_breadcrumbs();?>
                    
                <div class="clearfix"></div>            
            </div>
        </section>
        <div class="page-wrap">
            <div class="container">
                <div class="page-inner row right-aside">
                    <div class="col-main">
                        <section class="page-main" role="main" id="content">
                            <div class="page-content">
                                <!--blog list begin-->
                                <div class="blog-list-wrap">
                                
                          <?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/post/content', get_post_format() );

				endwhile;

				the_posts_pagination( array(
					'prev_text' => '<i class="fa fa-arrow-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'cactus' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'cactus' ) . '</span><i class="fa fa-arrow-right"></i>' ,
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cactus' ) . ' </span>',
				) );

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>         
                                    
                                    
                                </div>
                                <!--blog list end-->
                 
                            </div>
                            <div class="post-attributes"></div>
                        </section>
                    </div>
                    <div class="col-aside-left"></div>
                    <div class="col-aside-right">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                                
                                <?php get_sidebar();?>
                                
                            </div>
                        </aside>
                    </div>
                </div>
            </div>  
        </div>

<?php get_footer();
