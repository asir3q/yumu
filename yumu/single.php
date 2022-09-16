<?php get_header();?>
<div class="site-content container">
    <main class="article-container">
        <article class="type-post">
            <header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
            <div class="single_info">
                <span><i class="iconfont icon-menu"></i><?php the_category(' ');?></span>
                <span><i class="iconfont icon-shijian"></i><?php the_time('Y-m-d') ?></span>
            </div>
            <div class="entry-content">
                <div class="entry-main-content">
                    <?php while( have_posts() ): the_post(); ?>
                        <?php the_content();?>
                    <?php endwhile; ?>
                </div>
            </div>
			<?php yumu_the_tags();?>
            <div class="entry-navigation">
				<?php
					$prev_post = get_previous_post();
					if(!empty($prev_post)):?>
					<div class="nav-box previous nav_box_previous">
						<a href="<?php echo get_permalink($prev_post->ID);?>" style="background-image: url(<?php echo yumu_the_post_thumbnail($prev_post->ID);?>);">
							<div class="prev_next_info">
								<small>上一篇</small>
								<p><?php echo $prev_post->post_title;?></p>
							</div>
						</a>
					</div>
				<?php endif;?>
				<?php
					$next_post = get_next_post();
					if(!empty($next_post)):?>
					<div class="nav-box next nav_box_next">
						<a href="<?php echo get_permalink($next_post->ID);?>" style="background-image: url(<?php echo yumu_the_post_thumbnail($next_post->ID);?>);">
							<div class="prev_next_info">
								<small>下一篇</small>
								<p><?php echo $next_post->post_title;?></p>
							</div>
						</a>
					</div>
				<?php endif;?>
			</div>
        </article>
		<div class="related-post">
			<h3 class="related-post-title">相关阅读</h3>
			<?php
				$categories = get_the_category();
				foreach ($categories as $category) :
				$posts = get_posts('numberposts=5&&orderby=rand&category='. $category->term_id); 
				foreach($posts as $post) : ?> 
			<article class="excerpt">
            <div class="article-content">
                <h2 class="post-title">
                    <a href="<?php the_permalink();?>" title="<?php the_title();?>" rel="bookmark"><?php the_title();?></a>
                </h2>
                <div class="des">
                    <?php the_excerpt();?>
                </div>
                <div class="single_info">
                    <span><i class="iconfont icon-menu"></i><?php the_category(' ');?></span>
                    <span><i class="iconfont icon-shijian"></i><?php the_time('Y-m-d') ?></span>
                </div>
            </div>
            <div class="post-img">
                <a class="focus" href="<?php the_permalink(); ?>" title="<?php the_title() ?>">
                    <img loading="auto" src="<?php echo yumu_the_post_thumbnail($post->ID);?>" alt="<?php the_title();?>" title="<?php the_title();?>">
                </a>
            </div>
        	</article>
			<?php endforeach;?> 
			<?php endforeach;?> 
		</div>
    </main>
</div>
<script>
hljs.initHighlightingOnLoad();
hljs.initLineNumbersOnLoad();
function highlightjs(){
	$('code.hljs').each(function(i, block) {
        hljs.lineNumbersBlock(block);
    });
};
document.addEventListener('highlightjs', highlightjs, false);
</script>
<?php
get_footer();