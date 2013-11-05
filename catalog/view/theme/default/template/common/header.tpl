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
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/mcustomscrollbar.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/slideshow.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.mcustomscrollbar.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.js"></script>
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
        <div id="banner">
          <a href="<?php echo $home; ?>">
            <img src="<?php echo $logo; ?>" width="266" height="87" alt="Song Nguyen Logo">
          </a>
        </div>
        <div id="menu">
          <ul class="nav">
              <li class="item-with-ul">
                <a href="#">Giới Thiệu</a>
                <ul style="display: none;">
                    <li><a class="" href="#">Về Công Ty</a></li>
                    <li><a class="" href="#">Giá Trị Cốt Lõi</a></li>
                    <li><a class="" href="#">Nhiệm Vụ</a></li>
                    <li><a class="" href="#">Nhân Sự</a></li>
                    <li><a class="" href="#">Đối Tác</a></li>
                </ul>
              </li>
              <li class="item-with-ul">
                <a href="#">Du Học</a>
                <ul style="display: none;">
                  <li><a href="#">Du Học Mỹ</a></li>
                  <li><a href="#">Du Học Úc</a></li>
                  <li><a href="#">Du Học New Zealand</a></li>
                  <li><a href="#">Du Học Anh</a></li>
                  <li><a href="#">Du Học Sing</a></li>
                  <li><a href="#">Du Học Pháp</a></li>
                  <li><a href="#">Du Học Canada</a></li>        
                </ul>
              </li>
              <li class="item-with-ul">
                <a href="#">Du Học Hè</a>
                <ul style="display: none;">
                  <li><a href="#">Du Học Hè Singapore</a></li>
                  <li><a href="#">Du Học Hè Mỹ</a></li>
                  <li><a href="#">Du Học Hè Úc</a></li>
                  <li><a href="#">Du Học Hè New Zealand</a></li>
                  <li><a href="#">Du Học Hè Anh</a></li>
                </ul>
              </li>
              <li>
                <a href="#">Chương trình</a>
              </li>
              <li class="item-with-ul">
                <a href="#">Dịch Vụ</a>
                <ul style="display: none;">               
                  <li><a href="#">Đăng Ký Nhập Học</a></li>
                  <li><a href="#">Thủ Tục Visa</a></li>
                  <li><a href="#">Chứng Minh Tài Chính</a></li>
                  <li><a href="#">Vé Máy Bay</a></li>
                  <li><a href="#">Dịch Thuật Và Công Chứng</a></li>
                </ul>
              </li>
              <li>
                <a href="<?php echo $news; ?>" class="link-popup iframe">Tin Tức & Sự Kiện</a>
              </li>
              <li class="item-with-ul">
                <a href="#">Các Lớp Học</a>
                <ul style="display: none;">
                    <li><a href="#">IELTS, TOEFL</a></li>
                    <li><a href="#">SAT, SAT II</a></li>
                    <li><a href="#">Toán, Lý, Hóa bằng tiếng Anh</a></li>
                    <li><a href="#">Văn Hóa Mỹ</a></li>
                    <li><a href="#">Kỹ Năng</a></li>
                </ul>
              </li>              
              <li>
                <a href="<?php echo $faq; ?>" class="link-popup iframe">FAQ</a>
              </li>
              <li class="item-with-ul">
                <a href="<?php echo $pcontact; ?>">Liên hệ</a>
                <ul style="display: none;">
                    <li><a href="#contact-address" class="link-popup contact">Thông Tin Liên Hệ</a></li>
                    <li><a href="<?php echo $contactus; ?>" class="link-popup iframe">Gửi Mail cho Song Nguyen</a>
                    </li>
                    <li><a href="#contact-online-support" class="link-popup inline">Hỗ Trợ Trực Tuyến</a></li>
                </ul>
              </li>
          </ul>
        </div>
  </div>