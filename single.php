<?php get_header();?>
    <main class="site-content container">
        <article class="post-content">
            <div class="post-header">
				<h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-info">
                    <span class="infoLeft"><i class="iconfont icon-book-read-line"></i><?php the_category(' ');?></span>
                    <span class="infoLeft"><i class="iconfont icon-calendar-2-line"></i><?php the_time('Y-m-d');?></span>
                    <span class="infoLeft"><i class="iconfont icon-user-3-line"></i><?php echo get_the_author_meta( 'display_name',$post->post_author);?></span>
                    <span class="opQrcode"><i class="iconfont icon-qr-code-line"></i>手机阅读</span>
                    <div id="qrcode" class="flex"></div>
                </div>
            </div>
            <div class="post-main">
            <?php while(have_posts()):the_post(); ?>
            <?php the_content();?>
            <?php endwhile;?>
            </div>
        </article>
        <?php post_the_tags();?>
        <div class="post-navigation flex">
            <?php
                $prev_post = get_previous_post();
                if(!empty($prev_post)):?>
                <div class="nav-box previous nav_box_previous">
                    <a href="<?php echo get_permalink($prev_post->ID);?>" style="background-image: url(<?php echo list_the_post_thumbnail($prev_post->ID);?>);">
                        <div class="prev_info">
                            <span><i class="iconfont icon-arrow-left-s-line"></i>上一篇</span>
                            <p><?php echo $prev_post->post_title;?></p>
                        </div>
                    </a>
                </div>
            <?php endif;?>
            <?php
                $next_post = get_next_post();
                if(!empty($next_post)):?>
                <div class="nav-box next nav_box_next">
                    <a href="<?php echo get_permalink($next_post->ID);?>" style="background-image: url(<?php echo list_the_post_thumbnail($next_post->ID);?>);">
                        <div class="prev_info">
                            <span>下一篇<i class="iconfont icon-arrow-right-s-line"></i></span>
                            <p><?php echo $next_post->post_title;?></p>
                        </div>
                    </a>
                </div>
            <?php endif;?>
        </div>
        <div class="related-post">
			<span class="attach-title">相关推荐</span>
            <?php
				$categories = get_the_category();
				foreach ($categories as $category) :
				$posts = get_posts('numberposts=5&&orderby=rand&category='. $category->term_id); 
				foreach($posts as $post) : ?> 
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
            <?php endforeach;endforeach;?> 
        </div>
    </main>
    <script src="<?php echo get_template_directory_uri().'/style/js/qrcode.js'?>"></script>
    <script>var qrcode=new QRCode("qrcode",{text:window.location.href,width:128,height:128,correctLevel:QRCode.CorrectLevel.H});</script>
    <script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();function highlightjs(){$("code.hljs").each(function(i,block){hljs.lineNumbersBlock(block)})}document.addEventListener("highlightjs",highlightjs,false);</script>
<?php get_footer();