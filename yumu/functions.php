<?php
include_once TEMPLATEPATH.'/hooks.php';
include_once TEMPLATEPATH.'/disable_embeds.php';
include_once TEMPLATEPATH.'/login_ui.php';

add_filter( 'login_display_language_dropdown', '__return_false' );
function custom_admin_css() {
echo '<style type="text/css">
.wp-block {max-width:980px;margin-left:auto;margin-right:auto;}
</style>';
}
add_action('admin_head', 'custom_admin_css');

//go跳转
function the_content_nofollow($content){
    preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/',$content,$matches);
    if($matches){
        foreach($matches[2] as $val){
            if(strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff|zip|rar|exe|dmg|7z|svg|mp3|mp4|avi|3gp|webp)/i',$val)){
                $content=str_replace("href=\"$val\"", "href=\""."https://link.yumus.cn/aq/?url=".base64_encode($val)."\" rel=\"nofollow\" target=\"_blank\"",$content);
            }
        }
    }
    return $content;
}
add_filter('the_content','the_content_nofollow',999);

//附件重命名
add_filter('wp_handle_upload_prefilter', 'custom_upload_filter' );
function custom_upload_filter( $file ){
    $info = pathinfo($file['name']);
    $ext = $info['extension'];
    $filedate = date('YmdHis').rand(0,99).$file['name'];
    $filedate = md5($filedate);
    $file['name'] = $filedate.'.'.$ext;
    return $file;
}

/** 图片自动添加ALT和TITLE */
function image_alt_tag($content){
    global $post;preg_match_all('/<img (.*?)\/>/', $content, $images);
    if(!is_null($images)) {foreach($images[1] as $index => $value)
    {
        $new_img = str_replace('<img', '<img title="'.get_the_title().'-'.get_bloginfo('name').'" alt="'.get_the_title().'-'.get_bloginfo('name').'"', $images[0][$index]);
        $content = str_replace($images[0][$index], $new_img, $content);}}
        return $content;
}
add_filter('the_content', 'image_alt_tag', 99999);

if ( ! function_exists( 'get_cravatar_url' ) ) {
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
if ( ! function_exists( 'set_user_profile_picture_for_cravatar' ) ) {
    function set_user_profile_picture_for_cravatar() {
        return '<a href="https://cravatar.cn" target="_blank">您可以在 Cravatar 修改您的资料图片</a>';
    }
    add_filter( 'user_profile_picture_description', 'set_user_profile_picture_for_cravatar', 1 );
}

//新窗口打开评论者网站链接
add_filter('get_comment_author_link', function ($return, $author, $id) {
    return str_replace('<a ', '<a target="_blank" ', $return);
},0,3 );
/**
 * 正确的避免你的 WordPress 管理员登录用户名被暴露
 * 说明：直接去掉函数 comment_class() 和 body_class() 中输出的 "comment-author-" 和 "author-"
 */
function lxtx_comment_body_class($content){ 
    $pattern = "/(.*?)([^>]*)author-([^>]*)(.*?)/i";
    $replacement = '$1$4';
    $content = preg_replace($pattern, $replacement, $content);  
    return $content;
}
add_filter('comment_class', 'lxtx_comment_body_class');
add_filter('body_class', 'lxtx_comment_body_class');
//评论前面添加@xxx
function ludou_comment_add_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<a href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '：</a>' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);
