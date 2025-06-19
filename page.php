<?php get_header();?>
<link rel='stylesheet' id='single-css' href=<?php echo get_template_directory_uri().'/style/css/imgbox.css'?>" type='text/css' media='all' />
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
	    <div class="gallery-modal" id="galleryModal">
                <div class="gallery-content">
                    <div class="gallery-image-container"><img class="gallery-main" id="galleryMainImage"></div>
                    <div class="gallery-thumbnails-nav">
                        <div class="gallery-thumbnails" id="galleryThumbnails"></div>
                    </div>
                    <div class="gallery-zoom-display" id="zoomDisplay">×1</div>
                </div>
                <div class="gallery-nav">
                    <button class="gallery-prev"><i class="iconfont icon-arrow-left-s-line"></i></button>
                    <button class="gallery-next"><i class="iconfont icon-arrow-right-s-line"></i></button>
                </div>
                <div class="gallery-zoom-controls">
                    <button class="gallery-zoom-btn" id="zoomIn">+</button>
                    <button class="gallery-zoom-btn" id="zoomReset">O</button>
                    <button class="gallery-zoom-btn" id="zoomOut">-</button>
                </div>
                <button class="gallery-close"><i class="iconfont icon-close-line"></i></button>
                <div class="gallery-hint">← ↑ → ↓ 或鼠标滚轮切换图片 · + o - 缩放图片 · ESC 关闭</div>
            </div>
        </article>
    </main>
    <script src="<?php echo get_template_directory_uri().'/style/js/imgbox.js'?>"></script>
    <script>hljs.initHighlightingOnLoad();hljs.initLineNumbersOnLoad();function highlightjs(){$("code.hljs").each(function(i,block){hljs.lineNumbersBlock(block)})}document.addEventListener("highlightjs",highlightjs,false);</script>
<?php get_footer();
