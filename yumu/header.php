<!DOCTYPE html>
<script>
  const isDark= localStorage.getItem("isDarkMode");
  document.documentElement.classList.toggle('dark',isDark==="1");
</script>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noarchive" />
<meta name="robots" content="max-image-preview:large" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta name="renderer" content="webkit" />
<meta name="format-detection" content="telephone=no" />
<meta name="format-detection" content="email=no" />
<meta content="九凌少子" name="author"/>
<meta name="format-detection" content="address=no" />
<title><?php if(is_search()){$title = $s.' - '.get_bloginfo( 'name' );}else{$title = yumu_title_seo();}echo $title;?></title>
<?php wp_head();?>
</head>
<body id="body">
    <header class="site-header">
        <div class="header-container container">
            <div class="header-caidan">
                <i class="iconfont icon-caidan"></i>
            </div>
            <div class="header-logo">
                <a class="logo" href="<?php echo home_url();?>" rel="home">
                    <img src="/wp-content/themes/yumu/style/img/logo.svg"></a>
                </a>
            </div>
            <nav class="header-menu">
                <div class="theme-switch-menu" onclick="switchDarkMode()">
			        <i class="iconfont icon-faxiandengpao2"></i>
			    </div>
                <div class="header-menu-close navbar-button">
					<i class="iconfont icon-cuo"></i>
				</div>
                <ul class="nav-list">
                <?php wp_nav_menu(['container'=>false, 'items_wrap'=>'%3$s', 'theme_location'=>'header-menu']); ?>
                </ul>
            </nav>
            <div class="main-search">
				<form method="get" class="search-form inline" action="<?php bloginfo('url'); ?>">
					<input type="search" class="search-field inline-field" placeholder="输入关键词进行搜索…" autocomplete="off" value="" name="s" required="true">
				</form>
				<div class="search-close navbar-button">
					<i class="iconfont icon-cuo"></i>
				</div>
			</div>
			<div class="theme-switch" onclick="switchDarkMode()">
			    <i class="iconfont icon-faxiandengpao2"></i>
			</div>
            <div class="search-open navbar-button">
                <i class="iconfont icon-sousuo"></i>
            </div>
        </div>
    </header>