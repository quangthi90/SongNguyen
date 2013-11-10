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
    $(function () {
        ContactForm = function ($element) {
            this.$element = $element;
            this.inputName = $element.find('input[name=\"name\"]');
            this.inputPhone = $element.find('input[name=\"phone\"]');
            this.inputEmail = $element.find('input[name=\"email\"]');
            this.inputEnquiry = $element.find('textarea[name=\"enquiry\"]');

            this.attachEvents();
        }

        ContactForm.prototype.attachEvents = function () {
            this.inputName.blur(function () {
                $(this).parent().find('.error, .success, br').remove();

                var name = $(this).val();
                if (name.length < 1 || name.length > 255)
                {
                    $(this).after('<br /><span class="error">' + $(this).data('error') + '</span>');
                }else {
                    $(this).after('<br /><span class="success">' + $(this).data('success') + '</span>');
                }
            });

            this.inputPhone.blur(function () {
                $(this).parent().find('.error, .success, br').remove();

                var phonePartern = new RegExp('^[0-9]{3,20}$');
                if ((!phonePartern.test($(this).val())) && ($(this).val() != '')) {
                    $(this).after('<br /><span class="error">' + $(this).data('error') + '</span>');
                }else {
                    $(this).after('<br /><span class="success">' + $(this).data('success') + '</span>');
                }
            });
                
            this.inputEnquiry.blur(function () {
                $(this).parent().find('.error, .success, br').remove();

                $(this).val($.trim($(this).val()));
                var enquiry = $.trim($(this).val());
                if (enquiry.length < 10 || enquiry.length > 3000)
                {
                    $(this).after('<br /><span class="error">' + $(this).data('error') + '</span>');
                }else {
                    $(this).after('<br /><span class="success">' + $(this).data('success') + '</span>');
                }
            });
                
            this.inputEmail.blur(function () {
                $(this).parent().find('.error, .success, br').remove();

                var emailPartern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                if (!emailPartern.test($(this).val())) {
                    $(this).after('<br /><span class="error">' + $(this).data('error') + '</span>');
                }else {
                    $(this).after('<br /><span class="success">' + $(this).data('success') + '</span>');
                }
            });
        }
    });

    $(document).ready(function(){
        new ContactForm($('#contact-page form'));
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
                                <input type="text" name="name" value="<?php echo $name; ?>" data-error="<?php echo $text_error_name; ?>" data-success="<?php echo $text_success_name; ?>" />
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
                                <input type="text" name="phone" value="<?php echo $phone; ?>" data-error="<?php echo $text_error_phone; ?>" data-success="<?php echo $text_success_phone; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">
                                <b><?php echo $entry_email; ?></b> <span class="required">(*)</span>
                            </td>
                            <td class="value">
                                <input type="text" name="email" value="<?php echo $email; ?>" data-error="<?php echo $text_error_email; ?>" data-success="<?php echo $text_success_email; ?>" />
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
                                <textarea name="enquiry" cols="40" rows="10" style="width: 99%;" data-error="<?php echo $text_error_enquiry; ?>" data-success="<?php echo $text_success_enquiry; ?>" ><?php echo $enquiry; ?></textarea>
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