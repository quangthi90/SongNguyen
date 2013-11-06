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
<script type="text/javascript">
  $(document).ready(function(){
      
  });
</script>
</head>
<body>
    <div id="contact-page" class="popup-container">
        <h2><?php echo $heading_title; ?></h2>
        <div class="contentbox">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <table>
                    <tbody>
                        <tr>
                            <td class="label">
                                <b><?php echo $entry_name; ?></b> <span class="required">(*)</span>
                            </td>
                            <td class="value">
                                <input type="text" name="name" value="<?php echo $name; ?>" />
                                <?php if ($error_name) { ?>
                                   <br /> <span class="error"><?php echo $error_name; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <b><?php echo $entry_phone; ?></b>
                            </td>
                            <td class="value">
                                <input type="text" name="phone" value="<?php echo $phone; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <b><?php echo $entry_email; ?></b> <span class="required">(*)</span>
                            </td>
                            <td class="value">
                                <input type="text" name="email" value="<?php echo $email; ?>" />
                                <?php if ($error_email) { ?>
                                   <br /> <span class="error"><?php echo $error_email; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <b><?php echo $entry_enquiry; ?></b> <span class="required">(*)</span>
                            </td>
                            <td class="value">
                                <textarea name="enquiry" cols="40" rows="10" style="width: 99%;">
                                    <?php echo $enquiry; ?>
                                </textarea>
                                <?php if ($error_enquiry) { ?>
                                   <br /> <span class="error"><?php echo $error_enquiry; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
                            </td>
                        </tr>
                    </tbody>
                </table>    
          </form>
        </div>
    </div>
</body>
</html>