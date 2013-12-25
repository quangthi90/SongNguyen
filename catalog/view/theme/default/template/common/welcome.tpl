<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/orginal.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
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
<?php echo $google_analytics; ?>
</head>
<body>
	<div id="wrap">
		<div id="flashintro">
		  	<embed src="<?php echo $flash; ?>" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="1000" height="500">
		</div>
		<div id="menulang" style="border-top: 2px solid #021D63;">
        	<form action="<?php echo $lang_url; ?>" method="post" enctype="multipart/form-data">
			    <ul class="list-flag">
	                <li class="lang-item" title="Tiếng Việt"
	                	 onclick="$('input[name=\'language_code\']').attr('value', 'vn'); $(this).parents('form').submit();">
	                	<span>Tiếng Việt</span>
	                </li>	  
	                <li class="lang-item" title="English" 
	                	onclick="$('input[name=\'language_code\']').attr('value', 'en'); $(this).parents('form').submit();">
	                	<span>English</span>
	                </li>
	            </ul>    
			    <input type="hidden" name="language_code" value="">
			    <input type="hidden" name="redirect" value="<?php echo $home; ?>">
			</form>
        </div>
	</div>
</body>
</html>
