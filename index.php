<?php get_header(); ?>
    <div class="hero">
    </div>
    <div class="section-title">
        <div class="wrapper">
            <strong><?php wp_title(); ?></strong>
        </div>
    </div>
    <span class="section-title"></span>

    <div class="wrapper">
        <div class="listings-grid">
        	<?php $query = new WP_Query(); ?>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="article intro">
                <?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
                	</a>
                <?php } ?>
				<div class="article-content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p><?php the_excerpt(); ?></p>
                    <span class="article-meta">
                        <a href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>"><?php the_author(); ?></a>, <span class="article-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
                    </span>
                    <a class="fancy-text" href="<?php the_permalink(); ?>">Read More</a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
        <div class="pagination">
            <div class="wrapper">
	            <span><?php echo 'Page '.$paged.' of '. $wp_query->max_num_pages; ?></span>
                <?php previous_posts_link(__( 'Prev', 'lydias-mission-theme' )) ?>
                <?php next_posts_link(__( 'Next', 'lydias-mission-theme' )) ?>
            </div>
        </div>
    <?php } ?>
<?php get_footer(); ?>