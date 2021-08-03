<?php get_header(); ?>
<section class="page-title-bar title-left">
  <div class="container">
    <div class="breadcrumb-nav">
    <?php cactus_breadcrumbs();?>
    </div>
    <div class="clearfix"></div>
  </div>
</section>
<div class="page-wrap">
  <div class="container">
    <div class="page-inner row right-aside">
      <div class="col-main">
        <section class="post-main" role="main" id="content">
          <article class="post-entry text-left">
            
            <?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					the_posts_pagination( array(
					'prev_text' => '<i class="fa fa-arrow-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'cactus' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'cactus' ) . '</span><i class="fa fa-arrow-right"></i>' ,
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cactus' ) . ' </span>',
				) );

				endwhile; // End of the loop.
			?>
            
            
            <div class="entry-footer clearfix">
              <div class="pull-left"> 
              <?php
				  if(get_the_tag_list()) {
					  echo get_the_tag_list(__( 'Tags:', 'cactus' ),', ');
				  }
				  
				  $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				  ?>
             </div>
            </div>
          </article>
          <div class="post-attributes">
            <!--About Author-->
            <div class="about-author">
              <div class="author-avatar"> <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?> </div>
              <div class="author-description">
                 <h3><?php the_author_link(); ?></h3>
                <?php the_author_meta('description');?>
              </div>
            </div>
            <!--About Author End-->
            <!--Comments Area-->
            <div class="comments-area text-left">
              <?php
			  // If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
			  ?>
            </div>            
          </div>
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