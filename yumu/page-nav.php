<?php 
/*
Template Name: 网址导航
*/
get_header();?>
<div class="site-content container">
    <main class="article-container" style="overflow:auto">
        <div class="page-list"><h3 class="side-title">网址分类</h3><ul class="page-nav-list"><?php wp_nav_menu(['container'=>false, 'items_wrap'=>'%3$s', 'theme_location'=>'page-nav-menu']); ?></ul></div>
        <div class="page-nav-right">
            <ul class="plinks">
			<?php
    			wp_list_bookmarks(array(
                    'category_orderby' => 'id',
                    'category_order' => 'DESC',
                    'title_before' => '<h3>',
                    'title_after' => '</h3>',
                    'order' => 'ASC',
                    'before' => '<li>',
                    'after' => '</p></li>',
                    'between' => '<p>',
                    'link_after' => '<i class="iconfont icon-xuanzeqixiayige"></i>',
                    'show_images' => 0,
                    'show_description' => 1
                ));
			?>
		</ul>
        </div>
    </main>
</div>
<?php
get_footer();