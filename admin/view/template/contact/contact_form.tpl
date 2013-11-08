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
            <td><?php echo $name; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><?php echo $email; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_phone; ?></td>
            <td><?php echo $phone; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_content; ?></td>
            <td><?php echo $content; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><?php echo ($status) ? $text_enabled : $text_disabled; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_date_posted; ?></td>
            <td><?php echo $date_posted; ?></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>