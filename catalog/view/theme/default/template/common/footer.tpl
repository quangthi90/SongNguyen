<div style="display: none;">
  <div id="site-map" class="popup-container inline">
    <h2><?php echo $text_sitemap; ?></h2>
    <div class="contentbox">  
      <?php if (isset($sitemap['items'])) { ?>
      <ul>
      <?php $i = 0; ?>
      <?php $column = 4; ?>
      <?php foreach ($sitemap['items'] as $key => $item) { ?> 
        <?php $i++; ?>
          <li>
            <a class="<?php echo $item['class']; ?>" <?php if ($item['href']) { ?>href="<?php echo $item['href']; ?>"<?php } ?>><?php echo $item['text']; ?></a>
            <?php if (isset($item['items'])) { ?>  
            <?php $i += count($item['items']); ?>  
            <ul> 
              <?php foreach ($item['items'] as $item) { ?> 
              <li><a class="<?php echo $item['class']; ?>" <?php if ($item['href']) { ?>href="<?php echo $item['href']; ?>"<?php } ?>><?php echo $item['text']; ?></a>
                <?php if (isset($item['items'])) { ?> 
                <?php $i += count($item['items']); ?>  
                <ul>    
                <?php foreach ($item['items'] as $item) { ?> 
                  <li><a class="<?php echo $item['class']; ?>" <?php if ($item['href']) { ?>href="<?php echo $item['href']; ?>"<?php } ?>><?php echo $item['text']; ?></a></li>
                <?php } ?>
                </ul>
                <?php } ?>
              </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </li>  
        <?php if ($i > $count/$column) { ?>
        <?php $count -= $i; ?>
        <?php $i = 0; ?>
        <?php if ($column > 1) $column--; ?>
      </ul>
      <ul>
        <?php } ?>   
      <?php } ?>  
      </ul>
      <?php } ?>                                   
      <!--<ul>
        <li><a href="#">Giới Thiệu</a>
            <ul>
                <li><a class="" href="#">Về Công Ty</a></li>
                <li><a class="" href="#">Giá Trị Cốt Lõi</a></li>
                <li><a class="" href="#">Nhiệm Vụ</a></li>
                <li><a class="" href="#">Nhân Sự</a></li>
                <li><a class="" href="#">Đối Tác</a></li>
            </ul>
        </li>        
        <li><a href="#">Du Học Hè</a>
            <ul>
                <li><a class="" href="#">Du Học Hè Singapore</a></li>
                <li><a class="" href="#">Du Học Hè Mỹ</a></li>
                <li><a class="" href="#">Du Học Hè Úc</a></li>
                <li><a class="" href="#">Du Học Hè New Zealand</a></li>
                <li><a class="" href="#">Du Học Hè Anh</a></li>
            </ul>
        </li>
        <li><a class="" a="" href="#">Chương trình</a></li>
      </ul>
      <ul>
        <li><a href="#">Du Học</a>
            <ul>
                <li><a href="#">Du Học Mỹ</a>
                    <ul>
                        <li>Cuộc Sống</li>
                        <li>Các Trường</li>
                        <li>Giáo Dục</li>
                        <li>Luyện Thi</li>
                        <li>Visa</li>
                    </ul>
                </li>
                <li><a href="#">Du Học Úc</a>
                    <ul>
                        <li>Cuộc Sống</li>
                        <li>Các Trường</li>
                        <li>Giáo Dục</li>
                        <li>Luyện Thi</li>
                        <li>Visa</li>
                    </ul>
                </li>
                <li><a href="#">Các Nước Khác</a>
                    <ul>
                        <li><a href="#">Du Học New Zealand</a>
                            <ul>
                                <li>Cuộc Sống</li>
                                <li>Các Trường</li>
                                <li>Giáo Dục</li>
                                <li>Luyện Thi</li>
                                <li>Visa</li>
                            </ul>
                        </li>
                        <li><a href="#">Du Học Anh</a>
                            <ul>
                                <li>Cuộc Sống</li>
                                <li>Các Trường</li>
                                <li>Giáo Dục</li>
                                <li>Luyện Thi</li>
                                <li>Visa</li>
                            </ul>
                        </li>
                        <li><a href="#">Du Học Sing</a>
                            <ul>
                                <li>Cuộc Sống</li>
                                <li>Các Trường</li>
                                <li>Giáo Dục</li>
                                <li>Luyện Thi</li>
                                <li>Visa </li>
                            </ul>
                        </li>
                        <li><a href="#">Du Học Pháp</a>
                            <ul>
                                <li>Cuộc Sống</li>
                                <li>Các Trường</li>
                                <li>Giáo Dục</li>
                                <li>Luyện Thi</li>
                                <li>Visa</li>
                            </ul>
                        </li>
                        <li><a href="#">Du Học Canada</a>
                            <ul>
                                <li>Cuộc Sống</li>
                                <li>Các Trường</li>
                                <li>Giáo Dục</li>
                                <li>Luyện Thi</li>
                                <li>Visa</li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
      </ul>
      <ul>
        <li><a href="#">Dịch Vụ</a>
            <ul>
                <li><a class="" href="#">Đăng Ký Nhập Học</a></li>
                <li><a class="" href="#">Thủ Tục Visa</a></li>
                <li><a class="" href="#">Chứng Minh Tài Chính</a></li>
                <li><a class="" href="#">Vé Máy Bay</a></li>
                <li><a class="" href="#">Dịch Thuật và Công Chứng</a></li>
            </ul>
        </li>
        <li><a class="" href="#">Tin Tức</a></li>
        <li><a href="#">Các Lớp Học</a>
            <ul>
                <li><a class="" href="#">IELTS, TOEFL</a></li>
                <li><a class="" href="#">SAT, SAT II</a></li>
                <li><a class="" href="#">Toán, Lý, Hóa bằng tiếng Anh</a></li>
                <li><a class="" href="#">Văn Hóa Mỹ</a></li>
                <li><a class="" href="#">Kỹ Năng</a></li>
            </ul>
        </li>        
      </ul>
      <ul>
        <li><a class="" href="#">FAQs</a></li>
        <li><a href="#">Liên Hệ</a>
          <ul>
            <li><a class="" href="#">Form Email</a></li>
            <li><a class="" href="#">Địa chỉ</a></li>
            <li><a class="" href="#">Hỗ Trợ Trực Tuyến</a></li>
          </ul>
        </li>
      </ul>-->                
    </div>
  </div>
  <div id="contact-address" class="popup-container inline">
    <h2><?php echo $text_contact_inf; ?></h2>
    <div class="contentbox">
      <div class="contact-info">
        <h2 class="company-name">
          <?php echo $text_company_name; ?>
        </h2>
        <div class="contact-item">
          <h3><?php echo $text_company_main_location; ?></h3>
          <div class="group-contact-info">
            <?php echo $text_company_main_address; ?>
          </div>
          <div class="group-contact-info">
            <?php echo $text_company_main_fone; ?><br>
            <?php echo $text_company_main_fax; ?>
          </div>
          <div class="group-contact-info">
            <?php echo $text_company_main_email; ?><br>
            <?php echo $text_company_main_website; ?>
          </div>
        </div>
        <div class="contact-item">
          <h3><?php echo $text_company_behalf_location; ?></h3>
          <div class="group-contact-info">
            <?php echo $text_company_behalf_address; ?>
          </div>
          <div class="group-contact-info">
            <?php echo $text_company_behalf_fone; ?> <br>
            <?php echo $text_company_behalf_fax; ?>
          </div>
          <div class="group-contact-info">
            <?php echo $text_company_behalf_email; ?> <br>
            <?php echo $text_company_behalf_website; ?>
          </div>
          <div class="group-contact-info">
            <?php echo $text_company_behalf_fanpage; ?>
          </div>          
        </div>        
      </div>
      <div class="contact-map">        
        <a class="link-popup map-item" href="<?php echo $urlImg; ?>contact/map-01.jpg">
          <img src="<?php echo $urlImg; ?>contact/map-01.jpg">
        </a>
        <a class="link-popup map-item" href="<?php echo $urlImg; ?>contact/map-02.jpg">
          <img src="<?php echo $urlImg; ?>contact/map-02.jpg">
        </a>
        <a class="link-popup map-item" href="<?php echo $urlImg; ?>contact/map-03.jpg">
          <img src="<?php echo $urlImg; ?>contact/map-03.jpg">
        </a>
        <a class="link-popup map-item" href="<?php echo $urlImg; ?>contact/map-04.jpg">
          <img src="<?php echo $urlImg; ?>contact/map-04.jpg">
        </a>
      </div>
    </div>
  </div>
  <div id="contact-online-support" class="popup-container inline">
    <h2><?php echo $text_support_onl; ?></h2>
    <div class="contentbox">
      <ul class="support-list">
        <li class="support-item">
          <a href="ymsgr:sendim?quangthi_90">
            <img src="http://opi.yahoo.com/online?u=quangthi_90&m=g&t=2" alt="Support Yahoo" border="0">
          </a> 
        </li>
        <li class="support-item">
          <a href="skype:nvthiet_90?call">
            <img src="http://mystatus.skype.com/bigclassic/nvthiet_90" title="Support Skype" style="border: none;" alt="My status">
          </a>
        </li>
        <li class="support-item">
          <a href="http://www.facebook.com/songnguyen" target="_blank">
            <img src="<?php echo $urlImg; ?>btn-fb.jpg" alt="Connect FB's Song Nguyen">
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div id="email-sub" class="popup-container inline">
    <h2><?php echo $text_newsletter; ?></h2>
    <div class="contentbox">
      <form method="POST" data-url="<?php echo $subcriber; ?>">
        <div class="container">
        <p class="success-msg"><?php echo $text_success; ?></p>
        <div class="row">
        <input type="text" name="reg-email" id="reg-email" placeholder="<?php echo $text_enter_email; ?>">      
        <input type="submit" value="<?php echo $text_ok; ?>">
        </div>    
        <p class="error-msg"><?php echo $text_invalid_email; ?></p>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="footer">
  <div id="menulang">
    <form action="<?php echo $lang_url; ?>" method="post" enctype="multipart/form-data">
        <ul class="list-flag has-site-map">
          <?php foreach ($languages as $language) { ?>
          <li class="lang-item" title="<?php echo $language['name']; ?>" 
            onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $(this).parents('form').submit();">
            <span><?php echo $language['name']; ?></span>
          </li>
          <?php } ?>
          <li>
            <a href="#site-map" class="link-popup sitemap-ref"><span><?php echo $text_sitemap; ?></span></a>
          </li>
          <li>
            <a href="#email-sub" class="link-popup email-subscription"><span><?php echo $text_newsletter; ?></span></a>
          </li>
        </ul>    
        <input type="hidden" name="language_code" value="">
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
    </form>
  </div>  
  <p class="copyright"><?php echo $text_copyright; ?></p>
</div>
</div>
<?php if (isset($popup_url)) { ?>
<a class="link-popup iframe" id="active-popup" href="<?php echo $popup_url; ?>"></a>
<script type="text/javascript"><!--//
    $(document).ready(function() {
        $('#active-popup').click();
    });
//--></script>
<?php } ?>
</body>
</html>