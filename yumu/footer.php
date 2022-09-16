<div class="m-mas"></div>
<footer class="site-footer">
    <div class="nav-footer container"> 
        <ul class="nav-list">
        <?php wp_nav_menu(['container'=>false, 'items_wrap'=>'%3$s', 'theme_location'=>'footer-menu']); ?>
        </ul>
        <p>站点声明：本站部分内容转载自网络，作品版权归原作者及来源网站所有，任何内容转载、商业用途等均须联系原作者并注明来源。</p>
        <p>相关侵权、举报、投诉及建议等，请发邮件至E-mail：xxxxx@xxxxxx.com</p>
        <ul class="link-list">
            <li>友情链接：</li><?php wp_list_bookmarks('title_li=&categorize=0'); ?>
        </ul>
        <div class="Copyright">
            <div class="infoleft">Copyright ©2019-<?php echo date('Y'); ?> <a href="https://www.yumus.cn/">语幕</a> All Rights Reserved.&nbsp;&nbsp;<a rel="nofollow" target="_blank" href="http://beian.miit.gov.cn">赣ICP备xxxxxxxx号</a></div>
            <div class="inforight"><a rel="nofollow" target="_blank" href="http://cn.wordpress.org">基于WordPress</a>&nbsp;|&nbsp;<a target="_blank" href="https://www.yumus.cn/">YUMU主题</a>&nbsp;|&nbsp;<a rel="nofollow" target="_blank" href="https://curl.qcloud.com/Qkd7ndaz">托管于腾讯云</a></div>
        </div>
    </div>
</footer>
<!-- 回顶部 -->
<div id="goTop">
    <i class="iconfont icon-shang"></i><em>回到顶部</em>
</div> 
<?php wp_footer();?>
</body>
</html>