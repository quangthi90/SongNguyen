<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/orginal.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>
</head>
<body>
<div id="wrap">
  <div id="header">
    <div id="header">
          <div id="banner">
            <a href="<?php echo $home; ?>">
              <img src="<?php echo $logo; ?>" width="266" height="87" alt="Song Nguyen Logo">
            </a>
          </div>
          <div id="menu">
            <ul>
                <li>
                  <a href="gioithieu.html" data-flexmenu="gioithieu">Giới Thiệu</a>
                </li>
                <li>
                  <a href="duhoc.html" data-flexmenu="duhoc">Du Học</a>
                </li>
                <li>
                  <a href="duhoche.html" data-flexmenu="duhoche">Các Trường</a>
                </li>
                <li>
                  <a href="dichvu.html" data-flexmenu="dichvu">Dịch Vụ</a>
                </li>
                <li>
                  <a class="example7 cboxElement" href="#">Tin Tức</a>
                </li>
                <li>
                  <a href="caclophoc.html">Các Lớp Học</a>
                </li>
                <li>
                  <a class="example7 cboxElement" href="cacclb.html">Các CLB</a>
                </li>
                <li>
                  <a class="example7 cboxElement" href="faqs-vn.html">FAQ</a>
                </li>
                <li>
                  <a class="example8 cboxElement" href="#sitemap-page">Sitemap</a>
                </li>
                <li>
                  <a href="lienhe.html">Liên hệ</a>
                </li>
              </ul>
          </div>
    </div>
  </div>