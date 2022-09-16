<?php
include_once TEMPLATEPATH.'/hooks.php';
include_once TEMPLATEPATH.'/disable_embeds.php';

add_filter( 'login_display_language_dropdown', '__return_false' );

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
//免广告腾讯视频
function v_qq_video($atts, $content=null) {
    extract(shortcode_atts(array("vids" => ''), $atts));
    $url = 'https://vv.video.qq.com/getinfo?vids='.$vids.'&platform=101001&charge=0&otype=json';
    $json = file_get_contents($url);
    preg_match('/^QZOutputJson=(.*?);$/',$json,$json2);
    $tempStr = json_decode($json2[1],true);
    $vurl = 'https://ugcws.video.gtimg.com/'.$tempStr['vl']['vi'][0]['fn']."?vkey=".$tempStr['vl']['vi'][0]['fvkey'];
  	$video = '<video style="width: 100%;" controls src="'.$vurl.'" poster="https://puui.qpic.cn/qqvideo_ori/0/'.$vids.'_496_280/0"></video>';
    return $video;
}
add_shortcode('tx-video', 'v_qq_video');

/** 图片自动添加ALT和TITLE */
function image_alt_tag($content){
    global $post;preg_match_all('/<img (.*?)\/>/', $content, $images);
    if(!is_null($images)) {foreach($images[1] as $index => $value)
    {
        $new_img = str_replace('<img', '<img alt="'.get_the_title().'-'.get_bloginfo('name').'"', $images[0][$index]);
        $content = str_replace($images[0][$index], $new_img, $content);}}
        return $content;
}
add_filter('the_content', 'image_alt_tag', 99999);
//替换 Gravatar 头像为 Cravatar 头像
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