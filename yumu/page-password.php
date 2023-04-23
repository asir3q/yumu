<?php 
/*
Template Name: 随机密码
*/
?>
<?php get_header();?>
<style>
    .form-group{margin-bottom:15px;max-width:100%}label.checkbox-inline{position:relative;display:inline-block;margin-left:24px;margin-right:30px;vertical-align:middle;cursor:pointer}label.checkbox-inline:last-child{margin-right:0}label input{position:absolute;margin:6px 10px 0 -24px;width:18px;height:18px}span.input-group-addon{padding:10px 12px;border:1px solid #e6e6e6;border-radius:5px 0 0 5px;background-color:#f8f8f8;color:#999;text-align:center;line-height:1}.input-group input{margin-left:-7px;padding:10px 0 10px 12px;width:calc(100% - 103px);border:1px solid #e6e6e6;border-radius:0 5px 5px 0}.form-group button{padding:10px 12px;width:150px;border:none;border-radius:5px;background:#f1404b;color:#fff;line-height:inherit}textarea{margin-bottom:30px;padding:10px 12px;width:calc(100% - 26px);border:1px solid #e6e6e6;border-radius:5px;background:#f8f8f8}.dark .form-group button,.dark .input-group input,.dark span.input-group-addon,.dark textarea{border:none;background:#212121}.dark .input-group input{opacity:.7}@media (max-width:767px){.form-group button{width:100%}}
</style>
<div class="site-content container">
    <main class="article-container">
        <article class="type-post">
            <header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
            <div class="entry-content">
                <div class="entry-main-content">
                    <div class="form-group">
                        <label class="checkbox-inline">
                          <input type="checkbox" id="include_number" checked>数字
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id="include_lowercaseletters" checked>小写字母
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id="include_uppercaseletters" checked>大写字母
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id="include_punctuation">标点符号
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id="password_unique">字符不重复
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon">密码长度</span>
                          <input type="number" id="password_length" class="form-control" min="0" value="16">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon">密码数量</span>
                          <input type="number" id="password_quantity" class="form-control" min="0" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <button id="generate" class="btn btn-success">生成密码</button>
                    </div>
                    <textarea id="output" class="form-control" cols="40" rows="10" readonly></textarea>
                    <h3>工具说明</h3>
                    <ol>
                        <li>随机密码生成后无法找回，请妥善保管。</li>
                        <li>所有密码都是前端生成，我们不会也不能记录你的密码生成记录，你可放心使用本工具。</li>
                    </ol>
                </div>
            </div>
        </article>
    </main>
</div>
<script src="<?php echo get_template_directory_uri().'/style/js/password.js'?>"></script>
<?php
get_footer();