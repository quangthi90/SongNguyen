<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/mail.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a id="button-send" onclick="send('index.php?route=subcriber/subcriber/send&token=<?php echo $token; ?>');" class="button"><?php echo $button_send; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
        <table id="mail" class="form">
          <tr>
            <td><?php echo $entry_to; ?></td>
            <td><select name="to">
                <option value="newsletter"><?php echo $text_newsletter; ?></option>
                <option value="all-newsletter"><?php echo $text_all_newsletter; ?></option>
              </select></td>
          </tr>
          <tbody id="to-newsletter" class="to">
            <tr>
              <td><?php echo $entry_email; ?></td>
              <td><input type="text" name="email" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="subcriber-email" class="scrollbox"></div></td>
            </tr>
          </tbody>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_subject; ?></td>
            <td><input type="text" name="subject" value="" /></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_message; ?></td>
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
<script type="text/javascript"><!--
$('input[name=\'email\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=subcriber/subcriber/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.email,
						value: item.subcriber_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#subcriber-email' + ui.item.value).remove();
		
		$('#subcriber-email').append('<div id="subcriber-email' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="subcriber_email[]" value="' + ui.item.value + '" /></div>');

		$('#subcriber-email div:odd').attr('class', 'odd');
		$('#subcriber-email div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#subcriber-email div img').live('click', function() {
	$(this).parent().remove();
	
	$('#subcriber-email div:odd').attr('class', 'odd');
	$('#subcriber-email div:even').attr('class', 'even');	
});
//--></script>
<script type="text/javascript"><!--	
$('select[name=\'to\']').bind('change', function() {
	if ($(this).attr('value') == 'all-newsletter') {
		$('#subcriber-email div').remove();
		$.ajax({
			url: 'index.php?route=subcriber/subcriber/getSubcribers&token=<?php echo $token; ?>',
			dataType: 'json',
			success: function(json) {	
				$.each(json, function (index, item) {
					$('#subcriber-email').append('<div id="subcriber-email' + item.subcriber_id + '">' + item.email + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="subcriber_email[]" value="' + item.subcriber_id + '" /></div>');
				});
			}
		});
	}else if ($(this).attr('value') == 'newsletter') {

	}
});

$('select[name=\'to\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--	
function send(url) { 
	$('textarea[name="message"]').val(CKEDITOR.instances.message.getData());
	
	$.ajax({
		url: url,
		type: 'post',
		data: $('select, input, textarea'),		
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
//--></script> 
<?php echo $footer; ?>