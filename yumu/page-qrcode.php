<?php 
/*
Template Name: 二维码
*/
?>
<?php get_header();?>
<style>.qrcontent{display:flex;align-items:flex-start}.qrtext{margin-right:15px;width:calc(100% - 293px);text-align:center}.form-control{padding:10px 12px;width:calc(100% - 26px);font-size:1rem;line-height:2}#qrCode,.form-control{border:1px solid #e6e6e6;border-radius:5px;background:#f8f8f8}#qrCode{display:flex;width:276px;height:276px;align-items:center;justify-content:center}#qrCode span{color:#999;font-size:12px}#generate{margin:40px 0;padding:10px 15px;border:none;border-radius:5px;background:#f1404b;color:#fff;line-height:inherit}#reset{margin:40px 20px 40px 0;padding:10px 15px;border:none;border-radius:5px;background:rgba(51,51,51,.3);color:#fff;line-height:inherit}@media (max-width:639px){.qrcontent{align-items:center;flex-direction:column-reverse}.qrtext{margin-top:15px;margin-right:0;width:100%}}.dark #generate,.dark #qrCode,.dark #qrinput{border:none;background:#212121}</style>
<div class="site-content container">
    <main class="article-container">
        <article class="type-post">
            <header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
            <div class="entry-content">
                <div class="entry-main-content">
                    <div class="qrcontent">
                        <div class="qrtext">
                            <textarea id="qrinput" name="qrinput" placeholder="请输入需要生成二维码的内容…" class="form-control" rows="8"></textarea>
                            <button id="reset">重置</button>
                            <button id="generate">生成二维码</button>
                        </div>
                        <div id="qrCode"><span>此处预览二维码</span></div>
                    </div>
                    <h3>工具说明</h3>
                    <ol>
                        <li>内容可以是数字、中英文或网址的任意形式文本，如果需要别人扫码后进入对应链接填写网址即可。</li>
                        <li>我们不会保存你生成的二维码，如有传播需要请自行保存二维码图片。</li>
                        <li>所有二维码都是前端生成，我们不会也不能记录你的二维码生成记录，你可放心使用本工具。</li>
                    </ol>
                </div>
            </div>
        </article>
    </main>
</div>
<script src="<?php echo get_template_directory_uri().'/style/js/qrcode.js'?>"></script>
<script>var qrcode=document.getElementById("qrCode");document.getElementById("generate").onclick=function(){let qrinput=document.getElementById("qrinput").value;if(!(qrinput==null||qrinput=="undefined"||qrinput=="")){while(qrcode.firstChild){qrcode.removeChild(qrcode.firstChild)}new QRCode(document.getElementById("qrCode"),qrinput)}else{alert("你不输入内容，我给你生成个毛线的二维码！！！")}};document.getElementById("reset").onclick=function(){document.getElementById("qrinput").value="";while(qrcode.firstChild){qrcode.removeChild(qrcode.firstChild)}};</script>
<?php
get_footer();