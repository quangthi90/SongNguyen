<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/orginal.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/mcustomscrollbar.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
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
      //FAQ:
      $('.link-faq').click(function(e){
        e.preventDefault();
        if($(this).hasClass('active')){
        return;
      }
        var item = $(this).attr('href');
        $('.link-faq').removeClass('active');
        $('.topic-item').removeClass('active').hide();
        $(this).addClass('active');
        $(item).addClass('active').slideDown(300);
      });
      $('.problem-item').click(function(e){
        $('.problem-item').removeClass('active');
        $('.problem-item-answer').hide(200);
        $(this).addClass('active');       
        $(this).children('.problem-item-answer').slideDown(300);
      });
      $('.problem-list').mCustomScrollbar({
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
  });
</script>
</head>
<body>
  <div id="faq-page">
    <h2>Những câu hỏi thường gặp</h2>
    <div class="contentbox">
      <div id="topic-container"> 
        <div class="img">    
          <img src="<?php echo $base ?>/image/data/faqs.jpg" alt="FAQ">      
        </div>
        <ul class="list-topic">
          <li>
            <a class="link-faq active" href="#du-hoc-my">Du học Mỹ</a>
          </li>
          <li>
            <a class="link-faq" href="#du-hoc-uc">Du học Úc</a>
          </li>
          <li>
            <a class="link-faq" href="#du-hoc-thuysi">Du học Thụy Sĩ</a>
          </li>
          <li>
            <a class="link-faq" href="#du-hoc-singapor">Du học Singapor</a>
          </li>
          <li>
            <a class="link-faq" href="#du-hoc-anhquoc">Du học Anh Quốc</a>
          </li>
        </ul>
      </div>
      <div id="content-container"> 
        <div id="du-hoc-my" class="topic-item active">
          <h3 class="topic-item-name">Những thắc mắc du học Mỹ</h3>
          <div class="problem-list">
            <ol>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
            </ol>
          </div>          
        </div> 
        <div id="du-hoc-uc" class="topic-item">
          <h3 class="topic-item-name">Những thắc mắc du học Úc</h3>
          <div class="problem-list">
            <ol>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
            </ol>
          </div>
        </div> 
        <div id="du-hoc-thuysi" class="topic-item">
          <h3 class="topic-item-name">Những thắc mắc du học Thụy Sĩ</h3>
          <div class="problem-list">
            <ol>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
            </ol>
          </div>
        </div> 
        <div id="du-hoc-singapor" class="topic-item">
          <h3 class="topic-item-name">Những thắc mắc du học Singapor</h3>
          <div class="problem-list">
            <ol>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
            </ol>
          </div>
        </div> 
        <div id="du-hoc-anhquoc" class="topic-item">
          <h3 class="topic-item-name">Những thắc mắc du học Anh Quốc</h3>
          <div class="problem-list">
            <ol>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
              <li class="problem-item">              
                <p class="problem-item-question">
                  Em tên Minh Quân, năm nay 16 tuổi. Cho em hỏi có phải đi du học ở từng tiểu bang khác nhau của Mỹ thì cần chứng minh tài chính nhiều ít khác nhau không?
                </p>
                <p class="problem-item-answer">
                  Theo như quy định thông thường thì em phải chứng minh đủ tài chính cho năm học đầu tiên và thuyết phục về khả năng có thể chi trả tiền học cho những năm kế tiếp.
                </p>
              </li>
            </ol>
          </div>
        </div> 
      </div>
    </div>
  </div>
</body>
</html>
