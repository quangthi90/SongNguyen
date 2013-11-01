<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/faq.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-links"><?php echo $tab_links; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><?php echo $entry_question; ?></td>
                <td><textarea name="faq_description[<?php echo $language['language_id']; ?>][question]" id="question<?php echo $language['language_id']; ?>"><?php echo isset($faq_description[$language['language_id']]) ? $faq_description[$language['language_id']]['question'] : ''; ?></textarea>
                  <?php if (isset($error_question[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_question[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_answer; ?></td>
                <td><textarea name="faq_description[<?php echo $language['language_id']; ?>][answer]" id="answer<?php echo $language['language_id']; ?>"><?php echo isset($faq_description[$language['language_id']]) ? $faq_description[$language['language_id']]['answer'] : ''; ?></textarea>
                  <?php if (isset($error_answer[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_answer[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
            </tr>
          </table>
        </div>
        <div id="tab-links">
          <table class="form">
            <tr>
              <td><?php echo $entry_faq_category; ?></td>
              <td><input type="text" name="faq_category" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="faq-category" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($faq_categories as $faq_category) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="faq-category<?php echo $faq_category['faq_category_id']; ?>" class="<?php echo $class; ?>"><?php echo $faq_category['name']; ?><img src="view/image/delete.png" alt="" />
                    <input type="hidden" name="faq_category[]" value="<?php echo $faq_category['faq_category_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr> 
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('question<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});

CKEDITOR.replace('answer<?php echo $language['language_id']; ?>', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

// Category
$('input[name=\'faq_category\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=faq/faq_category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.faq_category_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('#faq-category' + ui.item.value).remove();
		
		$('#faq-category').append('<div id="faq-category' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" alt="" /><input type="hidden" name="faq_category[]" value="' + ui.item.value + '" /></div>');

		$('#faq-category div:odd').attr('class', 'odd');
		$('#faq-category div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#faq-category div img').live('click', function() {
	$(this).parent().remove();
	
	$('#faq-category div:odd').attr('class', 'odd');
	$('#faq-category div:even').attr('class', 'even');	
});
//--></script> 
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
//--></script>

<?php echo $footer; ?>