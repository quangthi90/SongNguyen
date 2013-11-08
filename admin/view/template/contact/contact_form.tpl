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
            <td><?php echo $entry_name; ?></td>
            <td><input type="text" value="<?php echo $name; ?>" disabled="disabled" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><input type="text" value="<?php echo $email; ?>" disabled="disabled" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_phone; ?></td>
            <td><input type="text" value="<?php echo $phone; ?>" disabled="disabled" />
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_content; ?></td>
            <td><textarea disabled="disabled" cols="80" rows="5"><?php echo $content; ?></textarea></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status" disabled="disabled">
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
            <td><?php echo $entry_date_posted; ?></td>
            <td><input type="text" value="<?php echo $date_posted; ?>" disabled="disabled" />
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>