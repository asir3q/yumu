<?php get_header();?>
<div class="site-content container">
    <main class="article-container">
        <article class="type-post">
            <header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
            <div class="entry-content">
                <div class="entry-main-content">
                    <?php while( have_posts() ): the_post(); ?>
                        <?php the_content();?>
                    <?php endwhile; ?>
                </div>
            </div>
        </article>
    </main>
</div>
<?php
get_footer();