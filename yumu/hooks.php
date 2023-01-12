<?php
header('X-Frame-Options:Deny');
function register_my_menus() {
	register_nav_menus(
	  array(
		'header-menu' => __( '顶部菜单'),
		'footer-menu' => __( '底部菜单')
	   )
	 );
   }
add_action( 'init', 'register_my_menus' );
add_filter('show_admin_bar', '__return_false');
remove_action( 'template_redirect','wp_shortlink_header', 11, 0);
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_resource_hints',2);
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'wp_shortlink_wp_head',10,0);
remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large');
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10 );
remove_filter('oembed_response_data',   'get_oembed_response_data_rich',  10, 4);
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');
function fanly_remove_block_library_css() {
  wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'fanly_remove_block_library_css', 100 );
//修改前端js，css版本号
function yumu_remove_wp_version_strings($src) {
  global $wp_version;
  parse_str(parse_url($src, PHP_URL_QUERY), $query);
  if ( !empty($query['ver']) && $query['ver'] === $wp_version ) {
    $src = remove_query_arg( 'ver', $src );
  }
  return $src;
}
add_filter( 'script_loader_src', 'yumu_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'yumu_remove_wp_version_strings' );
// Disable auto-embeds for WordPress >= v3.5
remove_filter( 'the_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
/**移除window._wpemojiSettings**/
remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
remove_action( 'admin_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_action( 'embed_head','print_emoji_detection_script');
remove_filter( 'the_content_feed', 'wp_staticize_emoji');
remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email');
remove_filter( 'the_content', 'capital_P_dangit' );
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );
function yumu_disable_feed() {
  wp_die(__('<h1>Feed已经关闭, 请访问网站<a href="'.get_bloginfo('url').'">首页</a>!</h1>'));
}
add_action('do_feed','yumu_disable_feed', 1);
add_action('do_feed_rdf','yumu_disable_feed', 1);
add_action('do_feed_rss','yumu_disable_feed', 1);
add_action('do_feed_rss2','yumu_disable_feed', 1);
add_action('do_feed_atom','yumu_disable_feed', 1);
add_filter('run_wptexturize', '__return_false');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('admin_email_check_interval', '__return_false');
add_action('admin_print_styles', function(){
	wp_deregister_style('wp-editor-font');
	wp_register_style('wp-editor-font', '');
});
//禁用未登录用户 REST API
add_filter('rest_api_init','rest_only_for_authorized_users',99);
function rest_only_for_authorized_users($wp_rest_server){
    if(!is_user_logged_in()) {
        wp_die('扑街崽');
    }
}
//古登堡相关
add_action('wp_enqueue_scripts', 'fanly_remove_styles_inline');
function fanly_remove_styles_inline(){
	wp_deregister_style( 'global-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
}
//彻底关闭 pingback
add_filter('xmlrpc_methods',function($methods){
	$methods['pingback.ping'] = '__return_false';
	$methods['pingback.extensions.getPingbacks'] = '__return_false';
	return $methods;
});
//禁用 pingbacks, enclosures, trackbacks
remove_action( 'do_pings', 'do_all_pings', 10 );
//去掉 _encloseme 和 do_ping 操作。
remove_action( 'publish_post','_publish_post_hook',5 );
/* 移除不必要的存档页面 */
add_action('template_redirect', 'meks_remove_wp_archives');
function meks_remove_wp_archives(){
  //If we are on category or tag or date or author archive
  if( is_attachment() || is_feed() || is_date() || is_author() ) {
    global $wp_query;
    $wp_query->set_404(); //set to 404 not found page
  }
}
//禁止 WordPress 网站title中的 “-” 被转义成 & #8211;
add_filter( 'run_wptexturize', '__return_false' );
// 禁用WP Editor Google字体css
function yumu_remove_gutenberg_styles($translation, $text, $context, $domain)
{
  if($context != 'Google Font Name and Variants' || $text != 'Noto Serif:400,400i,700,700i') {
    return $translation;
  }
  return 'off';
}
add_filter( 'gettext_with_context', 'yumu_remove_gutenberg_styles',10, 4);
//禁止代码标点转换
remove_filter('the_content', 'wptexturize');
//载入JS\CSS
add_action('wp_enqueue_scripts', function () {
  if (!is_admin()) {
    wp_enqueue_script('darkmode', get_template_directory_uri().'/style/js/darkmode-js.min.js','',false);
	wp_enqueue_script('yumus', get_template_directory_uri().'/style/js/yumu.min.js','',false,true);	
	wp_enqueue_style('style', get_template_directory_uri().'/style/css/yumu.min.css');
	wp_enqueue_style('font', get_template_directory_uri().'/style/css/iconfont.css' );
	if(is_single()){
		wp_enqueue_script('highlight', get_template_directory_uri().'/style/js/highlight.min-11.3.1.js');
		wp_enqueue_script('highlight-line', get_template_directory_uri().'/style/js/highlightjs-line-numbers-2.8.0.min.js');
		wp_enqueue_style('highlight', get_template_directory_uri().'/style/css/monokai-sublime.min-11.3.1.css');
	}
	global $wp_query; 
  }	
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
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_image_sizes');
//禁用缩放尺寸
add_filter('big_image_size_threshold', '__return_false');
//禁用其他图片尺寸
function shapeSpace_disable_other_image_sizes() {
	remove_image_size('post-thumbnail');
	remove_image_size('another-size');
}
add_action('init', 'shapeSpace_disable_other_image_sizes');
//disable srcset on images
function disable_srcset( $sources ) {
	return false;
}
add_filter( 'wp_calculate_image_srcset', 'disable_srcset' );
//设定摘要的长度
function new_excerpt_length($length) {
    return 200;
}
add_filter('excerpt_length','new_excerpt_length');
function new_excerpt_more(){
}
add_filter('excerpt_more', 'new_excerpt_more');
//获取文章封面
function yumu_the_post_thumbnail($postID) {
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
                '/wp-content/themes/yumu/style/img/074b7ee923e44e2c9c9c166ffb5af938.jpg',
                '/wp-content/themes/yumu/style/img/f62e2961be366795facaf7d070a683d4.jpg');
                $rndthumb = array_rand($thumbarr);
                $thumb = $thumbarr[$rndthumb];
        }
    }
    return $thumb;
}
//翻页
function yumu_paginate_links(){
	$pagination_links = paginate_links( array(
		'mid_size'     => 1,
		'prev_text'    => __('上一页'),
		'next_text'    => __('下一页'),
	) );
	if($pagination_links){
	    $pagination_links = '<div class="pagenavi">'.$pagination_links.'</div>';
	}
	return $pagination_links;
}

add_filter('pre_option_link_manager_enabled', '__return_true');	/*激活友情链接后台*/
add_theme_support( "post-thumbnails" );
function yumu_the_tags(){
    $entry_tag = the_tags( '<div class="entry-tag">Tags：', ' • ','</div>');
	if($entry_tag){return $entry_tag;}
}
add_filter('wp_img_tag_add_srcset_and_sizes_attr', '__return_false');
add_filter( 'use_default_gallery_style', '__return_false' );
/* 搜索关键词为空 */
add_filter( 'request', function ( $query_variables ) {
	if (isset($_GET['s']) && !is_admin()) {
		if (empty($_GET['s']) || ctype_space($_GET['s'])) {
			wp_redirect( home_url() );
			exit;
		}
	}
	return $query_variables;
});
//SEO标题
function yumu_title_seo(){
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

add_filter( 'wp_sitemaps_add_provider', function ($provider, $name) {
  return ( $name == 'users' ) ? false : $provider;
}, 10, 2);

add_filter('locale', function($locale) {
    $locale = ( is_admin() ) ? $locale : 'en_US';
    return $locale;
});
add_filter('pre_get_posts',function($query){
    if ($query->is_search && !$query->is_admin) {
		$query->set('post_type', 'post');
	}
	return $query;
});
//当搜索结果只有一篇时直接跳转到文章页面
add_action('template_redirect', 'yumu_redirect_single_post');
function yumu_redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
        }
    }
}
//解决日志改变 post type 之后跳转错误的问题
add_action( 'template_redirect', 'yumu_old_slug_redirect');
function yumu_old_slug_redirect() {
    global $wp_query;
    if ( is_404() && '' != $wp_query->query_vars['name'] ) :
        global $wpdb;
        $query = $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_wp_old_slug' AND meta_value = %s", $wp_query->query_vars['name']);
        $id = (int) $wpdb->get_var($query);
        if ( !$id ){
            $link = yumu_redirect_guess_404_permalink();
        }else{
            $link = get_permalink($id);
        }
        if ( !$link )
            return;
        wp_redirect( $link, 301 );
        exit;
    endif;
}

function yumu_redirect_guess_404_permalink() {
    global $wpdb, $wp_rewrite;
    if ( get_query_var('name') ) {
        $where = $wpdb->prepare("post_name LIKE %s", like_escape( get_query_var('name') ) . '%');
        $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE $where AND post_status = 'publish'");
        if ( ! $post_id )
            return false;
        if ( get_query_var( 'feed' ) )
            return get_post_comments_feed_link( $post_id, get_query_var( 'feed' ) );
        elseif ( get_query_var( 'page' ) )
            return trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( get_query_var( 'page' ), 'single_paged' );
        else
            return get_permalink( $post_id );
    }
    return false;
}
//禁止使用 admin 用户名尝试登录
add_filter( 'wp_authenticate', 'yumu_no_admin_user' );
function yumu_no_admin_user($user){
	if($user == 'admin'){
		exit;
	}
}
add_filter('sanitize_user', 'yumu_sanitize_user_no_admin',10,3);
function yumu_sanitize_user_no_admin($username, $raw_username, $strict){
	if($raw_username == 'admin' || $username == 'admin'){
		exit;
	}
	return $username;
}
add_action('admin_menu', function (){
	global $menu, $submenu;
	unset($submenu['options-general.php'][45]);
	remove_action( 'admin_menu', '_wp_privacy_hook_requests_page' );
	remove_filter( 'wp_privacy_personal_data_erasure_page', 'wp_privacy_process_personal_data_erasure_page', 10, 5 );
	remove_filter( 'wp_privacy_personal_data_export_page', 'wp_privacy_process_personal_data_export_page', 10, 7 );
	remove_filter( 'wp_privacy_personal_data_export_file', 'wp_privacy_generate_personal_data_export_file', 10 );
	remove_filter( 'wp_privacy_personal_data_erased', '_wp_privacy_send_erasure_fulfillment_notification', 10 );
	remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'text_change_check' ), 100 );
	remove_action( 'edit_form_after_title', array( 'WP_Privacy_Policy_Content', 'notice' ) );
	remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'add_suggested_content' ), 1 );
	remove_action( 'post_updated', array( 'WP_Privacy_Policy_Content', '_policy_page_updated' ) );
},9);