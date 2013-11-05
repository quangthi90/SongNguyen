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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/faq.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_question; ?></td>
              <td class="left"><?php echo $column_category; ?></td>
              <td class="left"><?php if ($sort == 'n.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_question" value="<?php echo $filter_question; ?>" /></td>
              <td><input type="text" name="filter_faq_category_name" value="<?php echo $filter_faq_category_name; ?>" /></td>
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($faqs) { ?>
            <?php foreach ($faqs as $faq) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($faq['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $faq['faq_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $faq['faq_id']; ?>" />
                <?php } ?></td>
              <td><?php echo $faq['question']; ?></td>
              <td><?php echo $faq['category_name']; ?></td>
              <td class="left"><?php echo $faq['status']; ?></td>
              <td class="right"><?php foreach ($faq['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=faq/faq&token=<?php echo $token; ?>';
  
  var filter_question = $('input[name=\'filter_question\']').attr('value');
  
  if (filter_question) {
    url += '&filter_question=' + encodeURIComponent(filter_question);
  }
	
	var filter_faq_category_name = $('input[name=\'filter_faq_category_name\']').attr('value');
	
	if (filter_faq_category_name) {
		url += '&filter_faq_category_name=' + encodeURIComponent(filter_faq_category_name);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_faq_category_name\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=faq/faq_category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
          'faq_category_id':  0,
          'name':  '',
          'parent_name': 'root',
        });

        response($.map(json, function(item) {
          return {
            label: (item.name) ? item.parent_name + ' > ' + item.name : item.parent_name,
            value: item.faq_category_id,
            name: item.name 
          }
        }));
			},
      error: function (xhr, error) {
        alert(xhr.responseText);
      }
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_faq_category_name\']').val(ui.item.name);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_question\']').autocomplete({
  delay: 500,
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=faq/faq/autocomplete&token=<?php echo $token; ?>&filter_question=' +  encodeURIComponent(request.term),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item.question,
            value: item.faq_category_id
          }
        }));
      },
      error: function (xhr, error) {
        alert(xhr.responseText);
      }
    });
  }, 
  select: function(event, ui) {
    $('input[name=\'filter_question\']').val(ui.item.label);
            
    return false;
  },
  focus: function(event, ui) {
        return false;
    }
});
//--></script> 
<?php echo $footer; ?>