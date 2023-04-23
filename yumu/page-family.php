<?php 
/*
Template Name: 家庭称谓计算
*/
?>
<?php get_header();?>
<style>
    .group,.row{margin-bottom:15px;width:100%}label{position:relative;display:inline-block;margin-right:30px;margin-left:24px;vertical-align:middle;cursor:pointer}.btn-group:last-child,.input-button:last-child,label:last-child{margin-right:0}label input{position:absolute;margin:6px 10px 0 -24px;width:18px;height:18px}textarea{margin-bottom:15px;padding:10px 12px;width:calc(100% - 26px);border:1px solid #e6e6e6;border-radius:5px;background:#f8f8f8}.btn-group,.input-button{position:relative;display:inline-block;margin-right:10px;margin-bottom:10px;vertical-align:middle}.btn-group>.btn{position:relative;float:left;padding:.5rem .875rem;border:1px solid rgba(135,150,165,.075);background:#333;color:#fff}.btn[disabled]{opacity:.3}.btn-group>.btn:first-child{border-radius:5px 0 0 5px}.btn-group>.btn:last-child{border-radius:0 5px 5px 0}.input-button{padding:.5rem .875rem;border:none;border-radius:5px;background:#f1404b;color:#fff}.dark .input-button,.dark textarea{border:none;background:#212121}.dark .btn-group>.btn{background:#212121}
</style>
<div class="site-content container">
    <main class="article-container">
        <article class="type-post">
            <header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
            <div class="entry-content">
                <div class="entry-main-content">
                    <div class="row">
                        <span>计算类型：</span>
                        <label for="default"><input id="default" type="radio" name="type" value="default" checked="">找称呼</label>
                        <label for="chain"><input id="chain" type="radio" name="type" value="chain">找关系</label>
                    </div>
                    <div class="group">
                        <div class="row">
                            <span>我的性别：</span>
                            <label for="male"><input id="male" type="radio" name="sex" value="1" checked="">男</label>
                            <label for="female"><input id="female" type="radio" name="sex" value="0">女</label>
                        </div>
                        <div class="row">
                            <span>称呼方式：</span>
                            <label for="call"><input id="call" type="radio" name="reverse" value="0" checked="">我称呼对方</label>
                            <label for="called"><input id="called" type="radio" name="reverse" value="1">对方称呼我</label>
                        </div>
                    </div>
                    <textarea id="input" placeholder="称谓间用&#39;的&#39;字分开…" class="form-control" rows="3"></textarea>
                    <div class="row">
                        <span style="display:block">快速选择：</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-value="爸爸">父</button>
                            <button type="button" class="btn btn-info" data-value="妈妈">母</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-value="老公" disabled="">夫</button>
                            <button type="button" class="btn btn-info" data-value="老婆">妻</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-value="儿子">子</button>
                            <button type="button" class="btn btn-info" data-value="女儿">女</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-value="哥哥">兄</button>
                            <button type="button" class="btn btn-info" data-value="弟弟">弟</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-value="姐姐">姐</button>
                            <button type="button" class="btn btn-info" data-value="妹妹">妹</button>
                        </div>
                    </div>
                    <div class="row">
                        <button class="input-button btn btn-warning">回退</button>
                        <button class="input-button btn btn-danger">清空</button>
                        <button class="input-button btn btn-primary">计算</button>
                    </div>
                    <div class="row">
                        <span>计算结果：</span>
                        <textarea id="reslut" class="form-control" rows="5" readonly=""></textarea>
                    </div>
                    <h3>工具说明</h3>
                    <ol>
                        <li>由于工作生活节奏不同，如今很多关系稍疏远的亲戚之间来往并不多。因此放假回家过年时，往往会搞不清楚哪位亲戚应该喊什么称呼，很是尴尬。然而搞不清亲戚关系和亲戚称谓的不仅是小孩，就连年轻一代的大人也都常常模糊混乱，“家庭称谓计算器”为你避免了这种尴尬，只需简单的输入即可算出称谓。</li>
                        <li>输入框兼容了不同的叫法，你可以称呼父亲为：“老爸”、“爹地”、“老爷子”等等，方面不同地域的习惯叫法。快捷输入按键，只需简单的点击即可完成关系输入，算法还支持逆向查找称呼！</li>
                        <li>一些称呼存在南北方或地区差异，容易引起歧义，并不保证和你所处地区的称谓习惯一致。本工具主要以现代生活常见的理解为主。</li>
                        <li>媳妇：在古代或者当今北方地区指儿子的妻子，这里指自己的妻子。</li>
                        <li>大爷：北方指父亲的哥哥，这里指爷爷的哥哥</li>
                        <li>太太：一些地方指年长的妇人，这里指自己的妻子</li>
                    </ol>
                </div>
            </div>
        </article>
    </main>
</div>
<script src="<?php echo get_template_directory_uri().'/style/js/cwjs.js'?>"></script>
<?php
get_footer();