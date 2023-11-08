<?php

//这是一个后台登录页面的美化，你要是嫌弃就删掉，我懒得管你。
include_once TEMPLATEPATH.'/login_ui.php';

//这里放置了给你自定义的内容，网站的一些设置可以在这个文件里面设置，也别搞什么后台设置了，花里胡哨的。
include_once TEMPLATEPATH.'/customize.php';


//从这里开始都是关于wordpress的优化，市面上大部分针对wp的优化或者安全设置我们都集成了，请不要在使用其它的优化插件，因为瞎安装插件带来的无法使用问题请自行面壁思过
//防止网页被iframe调用
header('X-Frame-Options:Deny');

//彻底屏蔽 XML-RPC，防止 xmlrpc.php 被扫描，也不需要用客户端发文章
add_filter('xmlrpc_enabled','__return_false');
add_filter('xmlrpc_methods', '__return_empty_array');

//屏蔽文章修订
add_filter('WP_POST_REVISIONS',false);

//禁止pingback，防止垃圾评论
add_filter('xmlrpc_methods',function($methods){
	$methods['pingback.ping'] = '__return_false';
	$methods['pingback.extensions.getPingbacks'] = '__return_false';
	return $methods;
});

//禁止pingbacks,enclosures,trackbacks，防止垃圾评论
remove_action('do_pings','do_all_pings', 10 );

//去掉 _encloseme 和 do_ping 操作，防止垃圾评论
remove_action('publish_post','_publish_post_hook',5);

//禁止Emoji转换为图片存储
remove_action('admin_print_scripts','print_emoji_detection_script');
remove_action('admin_print_styles','print_emoji_styles');
remove_action('wp_head','print_emoji_detection_script',7);
remove_action('wp_print_styles','print_emoji_styles');
remove_action('embed_head','print_emoji_detection_script');
remove_filter('the_content_feed','wp_staticize_emoji');
remove_filter('comment_text_rss','wp_staticize_emoji');
remove_filter('wp_mail','wp_staticize_emoji_for_email');
remove_filter('the_content','capital_P_dangit');
remove_filter('the_title','capital_P_dangit');
remove_filter('comment_text','capital_P_dangit');
add_filter('emoji_svg_url','__return_false');

//禁止后台加载Google字体
add_action('admin_print_styles', function(){
	wp_deregister_style('wp-editor-font');
	wp_register_style('wp-editor-font', '');
});

//禁止字符转码，加快页面显示，中文博客不需要它来处理
add_filter('run_wptexturize','__return_false');

//禁止代码标点转换
remove_filter('the_content','wptexturize');

//禁止Feed，防止RSS采集
function disable_feed() {
	wp_die(__('<h1>本站不提供Feed，浏览本站请访问本站<a href="'.get_bloginfo('url').'">首页</a>！</h1>'));
}
add_action('do_feed','disable_feed',1);
add_action('do_feed_rdf','disable_feed',1);
add_action('do_feed_rss','disable_feed',1);
add_action('do_feed_rss2','disable_feed',1);
add_action('do_feed_atom','disable_feed',1);

// 移除头部 wp-json 标签和 HTTP header 中的 link
remove_action('wp_head','rest_output_link_wp_head',10);
remove_action('template_redirect','rest_output_link_header',11);

//移除不必要的存档页面
function remove_wp_archives(){
    if( is_attachment() || is_feed() || is_date() || is_author() ) {
        global $wp_query;
        $wp_query->set_404();
    }
  }
add_action('template_redirect','remove_wp_archives');

//屏蔽渲染到前台显示的wp版本号，不要让别人知道你是什么版本
remove_action('wp_head','wp_generator');
// function remove_wp_version_strings($src) {
//     $parts = explode('?',$src);
//     return $parts[0];
// }
// add_filter('script_loader_src','remove_wp_version_strings');
// add_filter('style_loader_src','remove_wp_version_strings');

//禁止加载古登堡样式
function remove_block_library_css(){
    wp_dequeue_style('wp-block-library');
    wp_deregister_style('global-styles');
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-block-style');
    wp_dequeue_style('wc-blocks-vendors-style');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('bp-member-block');
    wp_dequeue_style('bp-members-block');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts','remove_block_library_css',100);

//我们只是个简简单单的网站，不需要那么多冗余
remove_action('template_redirect','wp_shortlink_header',11,0);
remove_action('wp_head','feed_links_extra',3);
remove_action('wp_head','feed_links',2);
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','index_rel_link');
remove_action('wp_head','parent_post_rel_link',10,0);
remove_action('wp_head','start_post_rel_link',10,0);
remove_action('wp_head','adjacent_posts_rel_link',10,0);
remove_action('wp_head','wp_resource_hints',2);
remove_action('wp_head','wp_shortlink_wp_head',10,0);
remove_action('rest_api_init','wp_oembed_register_route');
remove_filter('rest_pre_serve_request','_oembed_rest_pre_serve_request',10,4);
remove_filter('oembed_dataparse','wp_filter_oembed_result',10);
remove_filter('oembed_response_data','get_oembed_response_data_rich',10,4);
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

//禁止每6个月的管理员邮箱验证
add_filter('admin_email_check_interval','__return_false');

//移除后台隐私相关页面，我大天朝不需要
add_action('admin_menu',function(){
	remove_submenu_page('options-general.php','options-privacy.php');
	remove_submenu_page('tools.php','export-personal-data.php');
	remove_submenu_page('tools.php','erase-personal-data.php');
},11);
add_action('admin_init',function(){
	remove_action('admin_init',['WP_Privacy_Policy_Content','text_change_check'],100);
	remove_action('edit_form_after_title',['WP_Privacy_Policy_Content','notice']);
	remove_action('admin_init',['WP_Privacy_Policy_Content','add_suggested_content'],1);
	remove_action('post_updated',['WP_Privacy_Policy_Content','_policy_page_updated']);
	remove_filter('list_pages','_wp_privacy_settings_filter_draft_page_titles',10,2);
},1);

//禁止 WordPress Auto Embeds
remove_filter('the_content',array( $GLOBALS['wp_embed'],'autoembed'),8);

//禁止Embed，防止被他人嵌入文章
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');

//禁用未登录用户访问REST API，如果你有小程序什么的需要，请注释或删除
function rest_only_for_authorized_users($wp_rest_server){
    if(!is_user_logged_in()) {
        wp_die('本站不支持REST API');
    }
}
add_filter('rest_api_init','rest_only_for_authorized_users',99);

//移除默认的max-image-preview指令，我手动加过了
remove_filter('wp_robots','wp_robots_max_image_preview_large');

//禁止前台展示工具条
add_filter('show_admin_bar', '__return_false');

//屏蔽找回密码，好好记牢密码，真的忘记了再来注释掉
add_filter('allow_password_reset','__return_false');

//登录错误提示，防止让有心人知道究竟是账号错误还是密码错误
function no_wordpress_errors(){
    return '扑街崽';
}
add_filter('login_errors', 'no_wordpress_errors');

//禁止使用 admin 用户名尝试登录
function no_admin_user($user){
	if($user == 'admin'){
		exit;
	}
}
add_filter('wp_authenticate','no_admin_user');
function sanitize_user_no_admin($username, $raw_username, $strict){
	if($raw_username == 'admin' || $username == 'admin'){
		exit;
	}
	return $username;
}
add_filter('sanitize_user','sanitize_user_no_admin',10,3);
add_action('admin_menu',function (){
	global $menu, $submenu;
	unset($submenu['options-general.php'][45]);
	remove_action('admin_menu','_wp_privacy_hook_requests_page');
	remove_filter('wp_privacy_personal_data_erasure_page','wp_privacy_process_personal_data_erasure_page',10,5);
	remove_filter('wp_privacy_personal_data_export_page','wp_privacy_process_personal_data_export_page',10,7);
	remove_filter('wp_privacy_personal_data_export_file','wp_privacy_generate_personal_data_export_file',10);
	remove_filter('wp_privacy_personal_data_erased','_wp_privacy_send_erasure_fulfillment_notification',10);
	remove_action('admin_init',array('WP_Privacy_Policy_Content','text_change_check'),100);
	remove_action('edit_form_after_title',array('WP_Privacy_Policy_Content','notice'));
	remove_action('admin_init',array('WP_Privacy_Policy_Content','add_suggested_content'),1);
	remove_action('post_updated',array('WP_Privacy_Policy_Content','_policy_page_updated'));
},9);

//当搜索结果只有一篇时直接跳转到文章页面
function redirect_single_post(){
    if(is_search()){
        global $wp_query;
        if($wp_query->post_count == 1){
            wp_redirect(get_permalink($wp_query->posts['0']->ID));
        }
    }
}
add_action('template_redirect','redirect_single_post');

//禁止author，防止暴露用户名
function disableAuthorUrl(){
    if (is_author()) {
      header("HTTP/1.1 404 Not Found");
      exit();
    }
}
add_action('template_redirect','disableAuthorUrl');
add_filter('wp_sitemaps_add_provider',function ($provider,$name){
  return ( $name == 'users' ) ? false : $provider;
},10,2);
add_filter('locale', function($locale){
    $locale = ( is_admin() ) ? $locale : 'en_US';
    return $locale;
});
add_filter('pre_get_posts',function($query){
    if ($query->is_search && !$query->is_admin) {
		$query->set('post_type', 'post');
	}
	return $query;
});

//禁用自动生成的图片尺寸
function shapeSpace_disable_image_sizes($sizes) {
	unset($sizes['thumbnail']);
	unset($sizes['medium']);
	unset($sizes['large']);
	unset($sizes['medium_large']);
	unset($sizes['1536x1536']);
	unset($sizes['2048x2048']);
	unset($sizes['60x75']);
	return $sizes;
}
add_action('intermediate_image_sizes_advanced','shapeSpace_disable_image_sizes');

//禁用缩放尺寸
add_filter('big_image_size_threshold','__return_false');

//禁用其他图片尺寸
function shapeSpace_disable_other_image_sizes(){
	remove_image_size('post-thumbnail');
	remove_image_size('another-size');
}
add_action('init','shapeSpace_disable_other_image_sizes');
function disable_srcset( $sources ) {
	return false;
}
add_filter('wp_calculate_image_srcset','disable_srcset');

//搜索关键词为空，返回主页
add_filter('request',function ($query_variables){
	if (isset($_GET['s']) && !is_admin()) {
		if(empty($_GET['s']) || ctype_space($_GET['s'])){
			wp_redirect( home_url());
			exit;
		}
	}
	return $query_variables;
});

//关闭后台登录界面的语言切换
add_filter('login_display_language_dropdown','__return_false');

//使用MD5对附件重命名，应该不会有附件重名，有助于减少上传附件时的sql查询
function custom_upload_filter( $file ){
    $info = pathinfo($file['name']);
    $ext = $info['extension'];
    $filedate = date('YmdHis').rand(0,99).$file['name'];
    $filedate = md5($filedate);
    $file['name'] = $filedate.'.'.$ext;
    return $file;
}
add_filter('wp_handle_upload_prefilter','custom_upload_filter');
add_filter('wp_img_tag_add_srcset_and_sizes_attr','__return_false');
add_filter('use_default_gallery_style','__return_false');
add_theme_support("post-thumbnails");
//至此，针对WordPress的优化结束，下面是主题的其它核心

//载入JS,CSS
add_action('wp_enqueue_scripts', function(){
  if (!is_admin()){
	wp_enqueue_script('global', get_template_directory_uri().'/style/js/main.js','',false,true);	
	wp_enqueue_style('global', get_template_directory_uri().'/style/css/main.css');
	wp_enqueue_style('iconfont', get_template_directory_uri().'/style/css/iconfont.css');
	if(is_single()||is_page()){
	    wp_enqueue_style('single', get_template_directory_uri().'/style/css/single.css',array('global'));
        wp_enqueue_style('highlight', get_template_directory_uri().'/style/css/monokai-sublime.min.css');
	    wp_enqueue_script('highlight', get_template_directory_uri().'/style/js/highlight.min.js');
	    wp_enqueue_script('highlight-line', get_template_directory_uri().'/style/js/highlightjs-line-numbers-2.8.0.min.js',array('highlight'));
    }
	global $wp_query; 
  }	
});

//设置古登堡编辑器的宽度
function custom_admin_css(){
    echo '<style type="text/css">.wp-block {max-width:980px;margin-left:auto;margin-right:auto;}</style>';
}
add_action('admin_head','custom_admin_css');

//接下来要开始SEO和某些自定义咯
//先搞几个菜单设置
function register_my_menus(){
	register_nav_menus([
	        'header-menu' => __('顶部菜单'),
		    'footer-menu' => __('底部菜单')
        ]);
   }
add_action('init','register_my_menus');

//开启友情链接
add_filter('pre_option_link_manager_enabled','__return_true');

//写一个自己看起来不错的翻页，列表里面可以调用它
function list_paginate_links(){
	$pagination_links = paginate_links( array(
		'mid_size'     => 1,
		'prev_text'    => __('上一页'),
		'next_text'    => __('下一页'),
	) );
	if($pagination_links){
	    $pagination_links = '<div class="pagenavi flex">'.$pagination_links.'</div>';
	}
	return $pagination_links;
}

//一个简洁的文章标签，文章里面可以调用它
function post_the_tags(){
    $post_tag = the_tags( '<div class="post-tag">','','</div>');
	if($post_tag){return $post_tag;}
}

//自定义一个文章封面，默认取编写文章时设置的封面，如果没有就取文章第一张图片，如果文章中一张图片也没有。。。。那就。。。随机一张默认图。
//如果你使用了对象存储，需要用到对象存储设置图片样式，可以把图片样式传给第二个参数
function list_the_post_thumbnail($postID,$imageMogr2 = ' ') {
    $already_has_thumb = has_post_thumbnail($postID);
    if($already_has_thumb){
        $thumb_id = get_post_thumbnail_id($postID);
        $thumb = wp_get_attachment_image_src($thumb_id, 'full');
        $thumb = $thumb[0];
    }else{
        $attached_image = get_children( "post_parent=$postID&post_type=attachment&post_mime_type=image&numberposts=3" );
        if ($attached_image){
            foreach ($attached_image as $attachment) {
                $thumb = $attachment->guid;
            }
        }else{
            $thumbarr=Array(
                '5b74c31d142aff027e4855b822b6c58f.jpg',
                'bc895b863405b84da7b536526c37d32c.jpg',
                'cab66e2bcf0765c8584b57dec862b711.jpg',
                'f62e2961be366795facaf7d070a683d4.jpg',
                'f0766dd2d7bfc5dea3562cb728ea47f4.jpg');
                $rndthumb = array_rand($thumbarr);
            $thumb = get_template_directory_uri().'/style/img/'.$thumbarr[$rndthumb];
        }
    }
    if(!empty($imageMogr2)){
        $thumb = $thumb.$imageMogr2;
    }
    return $thumb;
}

//图片自动添加ALT和TITLE，把SEO做好
function image_alt_tag($content){
    global $post;preg_match_all('/<img (.*?)\/>/', $content, $images);
    if(!is_null($images)) {foreach($images[1] as $index => $value)
    {
        $new_img = str_replace('<img', '<img title="'.get_the_title().'-'.get_bloginfo('name').'" alt="'.get_the_title().'-'.get_bloginfo('name').'"', $images[0][$index]);
        $content = str_replace($images[0][$index], $new_img, $content);}}
        return $content;
}
add_filter('the_content','image_alt_tag',99999);

//设定摘要的长度,以及屏蔽描述后面自带的[...]，200个字符无论是中英文都很够了。
function new_excerpt_length($length) {
    return 200;
}
add_filter('excerpt_length','new_excerpt_length');
function new_excerpt_more(){
    return '';
}
add_filter('excerpt_more','new_excerpt_more');

//给分类添加个可以输入关键字的框框吧
$category_meta = array( 
    array("name" => "categorykws","std" => "","title" => __('SEO关键词', 'haoui').'：'));
    function add_category_field(){
        global $category_meta;
        foreach($category_meta as $meta_box) {
            echo '<div class="form-field"><label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label><input name="'.$meta_box['name'].'" id="'.$meta_box['name'].'" type="text" value="" size="40">'.'</div>';
        } 
    }
    function edit_category_field($tag){
        global $category_meta;
        foreach($category_meta as $meta_box) {
            echo '<tr class="form-field"><th scope="row"><label for="'.$meta_box['name'].'">'.$meta_box['title'].'</label></th><td><input name="'.$meta_box['name'].'" id="'.$meta_box['name'].'" type="text" value="'; 
            echo get_option(''.$meta_box['name'].'-'.$tag->term_id).'" size="40"/>'.'</td></tr>';
        }
    }
    function category_save($term_id){
        global $category_meta;
        foreach($category_meta as $meta_box) {
            $data = $_POST[$meta_box['name']];
            if(isset($data)){
                if(!current_user_can('manage_categories')){
                    return $term_id;
                }
                $key = $meta_box['name'].'-'.$term_id;
                update_option( $key, $data );
            }
        }
    }
add_action('category_add_form_fields','add_category_field',10,2);
add_action('category_edit_form_fields','edit_category_field',10,2);
add_action('created_category','category_save',10,1);
add_action('edited_category','category_save',10,1);

//写一个用来调用SEO标题的函数，首页格式：站点标题——副标题，请在WordPress后台【设置——常规】中填写。
function seo_title(){
    $title = '';
	if(is_singular()){
		$title = wp_get_document_title();
	}elseif(is_category()){
		$title = single_cat_title().'-'.get_bloginfo( 'name' );
	}elseif(is_tag()){
	    $title = single_tag_title('',false).'-'.get_bloginfo( 'name' );
	}elseif(is_404()){
	    $title = '页面不存在 - '.get_bloginfo( 'name' );
	}else{
		$title = get_bloginfo( 'name' ).' - '.get_bloginfo( 'description' );
	}
	return $title;
}

//SEO关键字，文章的关键字取自文章标签，分类的关键字取自分类中自定义。
function seo_keywords(){
    $keywords = '';
    if(is_singular()){
        global $post, $posts;
    	$gettags = get_the_tags($post->ID);
    	if ($gettags) {
    		foreach ($gettags as $tag) {
    			$posttag[] = $tag->name;
    		}
    		$keywords = implode( ',', $posttag );
    	}
    }elseif(is_category()){
        $keywords = get_option('categorykws-'.get_query_var('cat'));
    }elseif(is_tag()){
        $keywords = single_tag_title('',false);
    }
    if(empty($keywords)){
        $keywords = key_Desc('k');
    }
    return $keywords;
}

//SEO描述，文章描述自动截取文章前200个字符，分类的描述取自分类描述。
function seo_description(){
    $category_id = '';
    $description = '';
    if(is_singular()){
        $description = get_the_excerpt ($post=null);
    }elseif(is_category()){
        $description = str_replace(array("<p>","","</p>", "\r", "\n"),"",category_description($category_id));
    }
    if(empty($description)){
        $description = key_Desc('d');
    }
	return $description;
}

//头像使用国内镜像
if (!function_exists( 'get_cravatar_url' )) {
    function get_cravatar_url( $url ) {
        $sources = array(
            'www.gravatar.com',
            '0.gravatar.com',
            '1.gravatar.com',
            '2.gravatar.com',
            'secure.gravatar.com',
            'cn.gravatar.com',
            'gravatar.com',
        );
        return str_replace( $sources, 'cravatar.cn', $url );
    }
    add_filter( 'um_user_avatar_url_filter', 'get_cravatar_url', 1 );
    add_filter( 'bp_gravatar_url', 'get_cravatar_url', 1 );
    add_filter( 'get_avatar_url', 'get_cravatar_url', 1 );
}
if ( ! function_exists( 'set_defaults_for_cravatar' ) ) {
    function set_defaults_for_cravatar( $avatar_defaults ) {
        $avatar_defaults['gravatar_default'] = 'Cravatar 标志';
        return $avatar_defaults;
    }
    add_filter( 'avatar_defaults', 'set_defaults_for_cravatar', 1 );
}
