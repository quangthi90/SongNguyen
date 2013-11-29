<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/orginal.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/mcustomscrollbar.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.mcustomscrollbar.min.js"></script>
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
<script type="text/javascript">
  $(document).ready(function(){      
      $('.news-content').mCustomScrollbar({
        set_width:false, /*optional element width: boolean, pixels, percentage*/
        set_height:false, /*optional element height: boolean, pixels, percentage*/
        horizontalScroll: false, /*scroll horizontally: boolean*/
        scrollInertia:950, /*scrolling inertia: integer (milliseconds)*/
        mouseWheel:true, /*mousewheel support: boolean*/
        mouseWheelPixels:"auto", /*mousewheel pixels amount: integer, "auto"*/
        autoDraggerLength:true, /*auto-adjust scrollbar dragger length: boolean*/
        autoHideScrollbar:true, /*auto-hide scrollbar when idle*/
        scrollButtons:{ /*scroll buttons*/
          enable:false, /*scroll buttons support: boolean*/
          scrollType:"continuous", /*scroll buttons scrolling type: "continuous", "pixels"*/
          scrollSpeed:"auto", /*scroll buttons continuous scrolling speed: integer, "auto"*/
          scrollAmount:40 /*scroll buttons pixels scroll amount: integer (pixels)*/
        },
        advanced:{
          updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
          updateOnContentResize:false, /*auto-update scrollbars on content resize (for dynamic content): boolean*/
          autoExpandHorizontalScroll:false, /*auto-expand width for horizontal scrolling: boolean*/
          autoScrollOnFocus:true, /*auto-scroll on focused elements: boolean*/
          normalizeMouseWheelDelta:false /*normalize mouse-wheel delta (-1/1)*/
        },
        contentTouchScroll:true, /*scrolling by touch-swipe content: boolean*/
        theme:"dark" /*"light", "dark", "light-2", "dark-2", "light-thick", "dark-thick", "light-thin", "dark-thin"*/
      });
      $('.normal-link').on('click', function(e){
        e.preventDefault();
        top.location = $(this).attr('href');
      });
      $('.news-detail-content img').each(function(){
        var linkPopup = $('<a></a>').attr('href', $(this).attr('src'));
        linkPopup.colorbox({
          height:"100%"
        });
        $(this).wrap(linkPopup);
      });
  });
</script>
</head>
<body>
  <div id="news-page" class="popup-container">
    <h2>
      <?php echo $news['title']; ?> 
      <span class="time"><?php echo $news['date_added']; ?></span>
    </h2>
    <div class="contentbox">
      <div id="topic-container"> 
        <div class="img">    
          <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">      
        </div>
      </div>
      <div id="content-container">
        <div class="news-content">
          <div class="news-detail-content">
            <?php echo $news['content']; ?>  
          </div>
          <div class="additional-news-info">
            <h4><?php echo $text_older_post; ?></h4>
            <ul class="list-old-news">
              <?php foreach ($older as $news) { ?>
              <li>
                <a href="<?php echo $news['href']; ?>"><?php echo $news['title'] . '(' . $news['date_added'] . ')'; ?></a>
              </li>
              <?php } ?>
            </ul>
            <p class="btn-container">
              <a href="<?php echo $back_link['href']; ?>" class="button <?php echo ($back_link['popup']) ? 'link-popup iframe' : 'normal-link'; ?>"><?php echo $text_go_back; ?></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
