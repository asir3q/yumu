    <footer class="site-footer">
        <div class="container">
            <ul class="footer-nav-list flex">
                <?php wp_nav_menu(['container'=>false,'items_wrap'=>'%3$s','theme_location'=>'footer-menu']);?>
            </ul>
            <p>站点声明：本站部分内容转载自网络，作品版权归原作者及来源网站所有，任何内容转载、商业用途等均须联系原作者并注明来源。</p>
            <p>相关侵权、举报、投诉及建议等，请发邮件至E-mail：******@******.***</p>
            <ul class="footer-nav-list flex link">
                <li>友情链接：</li>
                <!-- 这里调用的是后台链接里面的一个分类，注意修改category后面的数字，不知道如何获取这个数字不妨百度下wordpress链接分类ID -->
                <?php wp_list_bookmarks('title_li=&categorize=0&show_images=0&category=17'); ?>
            </ul>
            <div class="Copyright flex">
                <span>Copyright <script>document.currentScript.insertAdjacentHTML('afterEnd',new Date().getFullYear())</script> <a href="<?php bloginfo('url');?>"><?php echo get_bloginfo('name')?></a>&nbsp;&nbsp;<a rel="nofollow" target="_blank" href="http://beian.miit.gov.cn">京ICP备**********号</a></span>
                <!-- 保留版权是对作者最大的尊重，介意者请勿使用，在此画个圈圈诅咒删除版权者 -->
                <span><a rel="nofollow" target="_blank" href="http://cn.wordpress.org">基于WordPress</a>&nbsp;|&nbsp;<a href="https://www.yumus.cn" target = "_blank">语幕主题</a></span>
            </div>
        </div>
    </footer>
    <div class="mask"></div>
    <div id="goTop" class="hoverBg"><i class="iconfont icon-arrow-up-s-line"></i><em>回到顶部</em></div>
    <?php wp_footer();?>
</body>
</html>