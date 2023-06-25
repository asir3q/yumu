<?php
if ( post_password_required() )
    return;
?>
<div id="comments" class="comments-area">
<span class="attach-title"><?php echo get_comments_number();?>条评论</span>
<div class="layoutSingleColumn">
<?php 
    comment_form(array(
        'label_submit'=>'提交留言',
        'title_reply'=>'',
        'comment_form_top' => 'ds',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" placeholder="请输入你的留言内容" required></textarea></p>',
        'fields' => apply_filters( 'comment_form_default_fields', array(
        'author' =>
        '<p class="comment-form-author">'.
        '<input id="author" class="blog-form-input" placeholder="昵称（必填）" name="author" type="text" required value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30" /></p>',
        'email' =>
        '<p class="comment-form-email">'.
        '<input id="email" class="blog-form-input" placeholder="Email（必填）" name="email" type="text" required value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30" /></p>',
        'url' =>
        '<p class="comment-form-url">'.
        '<input id="url" class="blog-form-input" placeholder="网站链接" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" /></p>'
        )),)
    );
?>
<?php if ( have_comments() ) : ?>
    <ol class="comment-list">
    <?php
        wp_list_comments(array(
            'style'         => 'ol',
            'short_ping'    => true,
            'reply_text'    => '回复',
            'avatar_size'   => 40,
            'format'        => 'html5'
        ) );
    ?>
    </ol>
    <?php
        $pagination_links = the_comments_pagination(array(
            'mid_size'     => 1,
            'prev_text'    => __('上一页'),
            'next_text'    => __('下一页'),
            'label' => __('ni')
        ) );
    ?>
<?php endif;?>
</div>
</div>
