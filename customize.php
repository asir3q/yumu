<?php

//自定义通用SEO关键字和通用SEO描述，你可以看看网站首页源代码的效果。
function key_Desc($type){
    switch ($type) {
        case 'k':
            //默认SEO关键字，请在此定义，多个关键字请用英文逗号隔开。
            $con = '关键字1,关键字2';
            break;
        case 'd':
        default:
            //默认SEO描述，请在此定义，最好不要超过200字符。
            $con = '这是我的网站描述啊';
            break;
    }
    return $con;
}
//上面的自定义SEO关键字和描述请勿删除，下面的随便删，但不建议。

//哎，操碎了心～

//隐藏wordpress后台登录地址，防止一下子就被人猜到，默认注释，需要请自己删除注释，建议开启安全性。
// add_action('login_enqueue_scripts','login_protection');  
// function login_protection(){  
//     //可以在下面设置两个参数，设置后你的后台登录地址会变成  xxxxxx.com/wp-login.php?参数1=参数值1&参数2=参数值2
//     //否则打不开后台登录地址
//    if($_GET['参数1'] != '参数值1' || $_GET['参数2'] != '参数值2'){
//        header("HTTP/1.1 501 Not Found");
//        exit();
//    }
// }

//使用smtp发邮件，如果需要你可以设置你的SMTP邮箱信息
function mail_smtp( $phpmailer ) {
    $phpmailer->IsSMTP();
    $phpmailer->SMTPAuth = true;//启用SMTPAuth服务
    $phpmailer->Port = 465;//MTP邮件发送端口，这个和下面的对应，如果这里填写25，则下面为空白
    $phpmailer->SMTPSecure ="ssl";//是否验证 ssl，这个和上面的对应，如果不填写，则上面的端口须为25
    $phpmailer->Host = "smtp.exmail.qq.com";//邮箱的SMTP服务器地址，如果是QQ的则为：smtp.exmail.qq.com
    $phpmailer->Username = "************";//你的邮箱地址
    $phpmailer->Password ="************";//你的邮箱登陆密码
}
add_action('phpmailer_init', 'mail_smtp');

function ashuwp_wp_mail_from( $original_email_address ) {
    return '************';//这个很重要，得将发件地址改成和上面smtp邮箱一致才行。
}
add_filter( 'wp_mail_from', 'ashuwp_wp_mail_from' );
//SMTP设置结束，不需要的可以把这些东西删除。

//评论相关的设置开始咯，语幕主题不提供文章评论，但留了一个评论模板页面，你可以在后台新建一个页面然后选择“评论墙”模板。
//如果你不需要评论墙，删除下面的代码也无所谓。
//屏蔽纯英文评论和纯日文
function refused_english_comments($incoming_comment) {
    $pattern = '/[一-龥]/u';
    // 禁止全英文评论
    if(!preg_match($pattern, $incoming_comment['comment_content'])) {
        die( "您的评论中必须包含汉字!");
    }
    $pattern = '/[あ-んア-ン]/u';
    // 禁止日文评论
    if(preg_match($pattern, $incoming_comment['comment_content'])) {
        die( "评论禁止包含日文!" );
    }
    return( $incoming_comment );
}
add_filter('preprocess_comment', 'refused_english_comments');

// 评论添加@，好让人知道你在回复谁！！！
function ds_comment_add_at( $comment_text, $comment = '') {
    if( $comment->comment_parent > 0) {
      $comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
    }
    return $comment_text;
  }
add_filter( 'comment_text' , 'ds_comment_add_at', 20, 2);

//新窗口打开评论者网站链接
add_filter('get_comment_author_link', function ($return, $author, $id) {
    return str_replace('<a ', '<a target="_blank" ', $return);
},0,3 );

//删除掉函数 comment_class() 和 body_class() 中输出的 "comment-author-" 和 "author-"，防止暴露管理员用户名
function remove_comment_body_class($content){ 
    $pattern = "/(.*?)([^>]*)author-([^>]*)(.*?)/i";
    $content = preg_replace_callback($pattern, function(){return '';}, $content);
    return $content;
}
add_filter('comment_class', 'remove_comment_body_class');
add_filter('body_class', 'remove_comment_body_class');
//评论相关的定义到此结束，如果你不需要评论墙，完全可以删除它，以免碍眼。

//go跳转，使用MD5加密外链，一定程度上可以防止搜索引擎爬虫逃跑。
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