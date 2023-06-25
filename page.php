<?php get_header();?>
    <main class="site-content container">
        <article class="post-content">
            <div class="post-header">
				<h1 class="post-title"><?php the_title(); ?></h1>
            </div>
            <div class="post-main">
            <?php while( have_posts() ): the_post(); ?>
            <?php the_content();?>
            <?php endwhile; ?>
            </div>
        </article>
    </main>
    <script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();function highlightjs(){$("code.hljs").each(function(i,block){hljs.lineNumbersBlock(block)})}document.addEventListener("highlightjs",highlightjs,false);</script>
<?php get_footer();