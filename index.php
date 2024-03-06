<?php get_header();if(is_category() || is_tag()){?>
    <section class="term-bar">
        <div class="container">
            <span>当前<?php if(is_category()){ echo '分类'; }elseif(is_tag()){ echo '标签'; }else{ echo '浏览'; } ?></span>
            <span class="term-illustrate"><?php single_term_title();?></span>
        </div>
    </section>
    <?php }elseif(is_search()){?>
    <section class="term-bar">
        <div class="container">
            <span>搜索结果</span>
            <span class="term-illustrate">“<?php echo $s;?>” <?php global $wp_query; echo '搜到 '.$wp_query->found_posts.' 篇文章';?></span>
        </div>
    </section>
    <?php }?>
    <section class="site-content container">
    <?php if(have_posts()){while (have_posts()){ the_post();?>
        <article class="hasThumb flex">
            <div class="article-content">
                <h2 class="entry-title hidden">
                    <a class="hoverColor" href="<?php the_permalink();?>" title="<?php the_title();?>" rel="bookmark"><?php the_title();?></a>
                </h2>
                <div class="entry-content hidden">
                    <?php the_excerpt();?>
                </div>
                <div class="entry-info">
                    <span class="infoLeft"><i class="iconfont icon-book-read-line"></i><?php the_category(' ');?></span>
                    <span class="rtime infoLeft"><i class="iconfont icon-calendar-2-line"></i><?php the_time('Y-m-d');?></span>
                    <span><i class="iconfont icon-user-3-line"></i><?php the_author();?></span>
                </div>
            </div>
            <div class="entry-thumb">
                <a class="focus hidden" href="<?php the_permalink();?>" title="<?php the_title();?>">
                    <img loading="auto" src="<?php echo list_the_post_thumbnail($post->ID,0);?>" alt="<?php the_title();?>" title="<?php the_title();?>">
                </a>
            </div>
        </article>
    <?php }echo list_paginate_links();}else{?>
        <style>.term-bar{display:none;}</style>
        <?php if(is_search()){ ?>
            <span class="trem-state">姿势不对？换个词搜一下~</span>
            <span class="trem-info">抱歉，没有找到“<?php echo $s; ?>”的相关内容</span>
        <?php }elseif(is_404()){?>
            <span class="trem-state">抱歉，这个页面不存在！</span>
            <span class="trem-info">它可能已经被删除，或者您访问的URL是不正确的。也许您可以试试搜索？</span>
        <?php }else{?>
            <span class="trem-state">此分类暂无文章</span>
            <span class="trem-info">也许您可以试试搜索？</span>
        <?php }?>
            <form method="get" class="vice-search" action="<?php bloginfo('url'); ?>">
                <input class="field" placeholder="输入关键词进行搜索…" autocomplete="off" value="" name="s" required="true" type="search">
                <button type="submit" class="search-submit"><i class="iconfont icon-search-2-line"></i></button>
            </form>
    <?php }?>
    </section>
<?php get_footer();
