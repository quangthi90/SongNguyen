<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/subcriber.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><strong><?php echo $entry_name; ?></strong></td>
            <td><?php echo $name; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_email; ?></strong></td>
            <td><?php echo $email; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_phone; ?></strong></td>
            <td><?php echo $phone; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_content; ?></strong></td>
            <td><?php echo $content; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_status; ?></strong></td>
            <td><?php echo ($status) ? $text_enabled : $text_disabled; ?></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_date_posted; ?></strong></td>
            <td><?php echo $date_posted; ?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" />Reply</h1>
      <div class="buttons"><a id="button-send" onclick="send('index.php?route=subcriber/subcriber/send&token=<?php echo $token; ?>');" class="button">Send</a></div>
    </div>
    <div class="content">
      <input type="hidden" value="newsletter" name="to" />
      <input type="hidden" value="<?php echo $email; ?>" name="subcriber_email[]" />
        <table id="mail" class="form">
          <tr>
            <td><span class="required">*</span> Subject</td>
            <td><input type="text" name="subject" value="" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> Message</td>
            <td><textarea name="message"></textarea></td>
          </tr>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
CKEDITOR.replace('message', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
//--></script> 
<script type="text/javascript">
function send(url) { 
  $('textarea[name="message"]').val(CKEDITOR.instances.message.getData());
  
  $.ajax({
    url: url,
    type: 'post',
    data: $('input[name=\'to\'], input[name=\'subcriber_email[]\'], input[name=\'subject\'], textarea'),   
    dataType: 'json',
    beforeSend: function() {
      $('#button-send').attr('disabled', true);
      $('#button-send').before('<span class="wait"><img src="view/image/loading.gif" alt="" />&nbsp;</span>');
    },
    complete: function() {
      $('#button-send').attr('disabled', false);
      $('.wait').remove();
    },        
    success: function(json) {
      $('.success, .warning, .error').remove();
      
      if (json['error']) {
        if (json['error']['warning']) {
          $('.box').before('<div class="warning" style="display: none;">' + json['error']['warning'] + '</div>');
      
          $('.warning').fadeIn('slow');
        }
        
        if (json['error']['subject']) {
          $('input[name=\'subject\']').after('<span class="error">' + json['error']['subject'] + '</span>');
        } 
        
        if (json['error']['message']) {
          $('textarea[name=\'message\']').parent().append('<span class="error">' + json['error']['message'] + '</span>');
        }                 
      }     
      
      if (json['next']) {
        if (json['success']) {
          $('.box').before('<div class="success">' + json['success'] + '</div>');
          
          send(json['next']);
        }   
      } else {
        if (json['success']) {
          $('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');
      
          $('.success').fadeIn('slow');
        }         
      }       
    },
    error: function (xhr, error) {
      alert(xhr.responseText);
    }
  });
}
</script>
<?php echo $footer; ?>