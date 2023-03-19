<?php 
/*
Template Name: 留言墙
*/
get_header();?>
<link rel='stylesheet' id='comments-css' href='<?php echo get_template_directory_uri().'/style/css/comments.css'?>' type='text/css' media='all' />
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
        <?php if ( comments_open() || get_comments_number() ) :?>
		<?php comments_template();?>
		<?php endif;?>
    </main>
</div>
<?php
get_footer();