<?php get_header();?>
<?php if(is_category() || is_tag() || is_tax()){?>
    <section class="term-bar">
		<div class="term-info container">
			<span>当前<?php if(is_category()){ echo '分类'; }elseif(is_tag()){ echo '标签'; }else{ echo '浏览'; } ?></span>
			<h3>
			<span class="term-title"><?php single_term_title(); ?></span>
			</h3>
		</div>
	</section>
    <?php }elseif(is_search()){ ?>
    <section class="term-bar">
        <div class="term-info container">
            <span>搜索结果</span>
            <h3>
            <span class="term-title">
            “<?php echo $s; ?>” <?php global $wp_query; echo '搜到 ' . $wp_query->found_posts . ' 篇文章';?>
            </span>
            </h3>
        </div>
    </section>
    <?php }?>
<div class="site-content container">
    <?php if(have_posts()){?>
    <div class="article-list">
        <?php while (have_posts()){ the_post(); ?>
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
            </article><?php } ?>
    <?php echo yumu_paginate_links();?>
    </div>
    <?php }else{?>
    <div class="_404 ">
    <style>.term-bar{display:none;}</style>
    <?php if(is_search()){ ?>
        <h2 class="entry-title">姿势不对？换个词搜一下~</h2>
        <div class="entry-content">
            抱歉，没有找到“<?php echo $s; ?>”的相关内容
        </div>
    <?php }elseif(is_404()) {?>
        <h1 class="entry-title">抱歉，这个页面不存在！</h1>
        <div class="entry-content">
            它可能已经被删除，或者您访问的URL是不正确的。也许您可以试试搜索？
        </div>
    <?php }else{?>
        <h1 class="entry-title">暂无文章</h1>
	<?php } ?>
    <?php if(is_search() || is_404()){ ?>
    <form method="get" class="search-form inline" action="<?php bloginfo('url'); ?>">
        <input class="search-field inline-field" placeholder="输入关键词进行搜索…" autocomplete="off" value="" name="s" required="true" type="search">
        <button type="submit" class="search-submit"><i class="iconfont icon-sousuo"></i></button>
    </form>
    <?php } ?>
    </div>
    <?php } ?>
</div>
<?php
get_footer();