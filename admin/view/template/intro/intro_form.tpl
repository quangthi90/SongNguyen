<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/intro.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form method="post" enctype="multipart/form-data" id="form" action="<?php echo $action; ?>">
        <table class="form">
          <tr>
            <td><strong><?php echo $entry_name; ?></strong></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>"/>
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_url; ?></strong></td>
            <td><input type="text" name="url" id="url" value="<?php echo $url; ?>" disabled="disalbe"/><a class="button" onclick="file_upload('url');"><?php echo $text_browser; ?></a></td>
          </tr>
          <tr>
            <td><strong><?php echo $entry_status; ?></strong></td>
            <td><?php echo ($status) ? $text_enabled : $text_disabled; ?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function file_upload(field) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_file_manager; ?>',
    close: function (event, ui) {
      
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script> 
<?php echo $footer; ?>