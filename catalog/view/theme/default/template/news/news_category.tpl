<?php echo $header; ?>
<div id="body-content">
	<div class="pagelocation">
		<?php echo $category['name']; ?>
	</div>
	<?php if (!empty($category['childs'])) { ?>
	<ul class="content-list">
	<?php foreach ($category['childs'] as $child) { ?>
		<li class="box-item <?php echo ($parent_id == 0) ? 'box3' : 'box5'; ?>">
			<a class="item-avatar <?php echo (!empty($child['class'])) ? $child['class'] : ''; ?>" href="<?php echo $child['href']; ?>">
				<img class="item-avatar-img on" src="<?php echo $child['primary_image']; ?>" alt="<?php echo $child['name']; ?>">
				<img class="item-avatar-img off" src="<?php echo $child['second_image']; ?>" alt="<?php echo $child['name']; ?>">
				<span class="category-title"><?php echo $child['name']; ?></span>
			</a>			
		</li>
	<?php } ?>
	</ul>
	<?php } ?>
</div>
<?php if (!empty($category['popup'])) { ?>
<div style="display: none;">
	<?php if ($category['popup']['type'] == 2) { ?>
	<div id="popup-slide-image" class="popup-container popup-intro">
		<h2>Title of popup intro</h2>
		<div class="contentbox"> 
			<?php if (!empty($category['popup']['banners'])) { ?>
			<div class="slider-wrapper theme-default">
	            <div id="slider" class="nivoSlider">
	            	<?php foreach ($category['popup']['banners'] as $banner) { ?>
	            		<?php if (!empty($banner['href'])) { ?>
	                	<a href="<?php echo $banner['href']; ?>"><img src="<?php echo $banner['image']; ?>" title="slideshow image 1" alt="<?php echo $banner['title']; ?>" /></a>
	            		<?php }else { ?>
	                	<img src="<?php echo $banner['image']; ?>" title="slideshow image 1" alt="<?php echo $banner['title']; ?>" />
	            		<?php } ?>
	            	<?php } ?>
	            </div>
        	</div>
			<?php } ?>
		</div>
	</div>
	<?php }elseif ($category['popup']['type'] == 1) { ?>
	<div id="popup-video" class="popup-container popup-intro">
		<h2><?php echo $category['popup']['title']; ?></h2>
		<div class="contentbox"> 
			<?php echo $category['popup']['embbed']; ?>
		</div>
	</div>
	<?php }elseif ($category['popup']['type'] == 0) { ?>
	<div id="popup-text" class="popup-container popup-intro">
		<h2><?php echo $category['popup']['title']; ?></h2>
    	<div class="contentbox">  
			<?php echo $category['popup']['content']; ?>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>
<!--<div style="display: none;">	
	<div id="popup-text" class="popup-container popup-intro">
		<h2>Title of popup intro</h2>
    	<div class="contentbox">  
			<p>Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo </p>
			<p>Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo </p>
			<p>Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo </p>
			<p>Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo </p>
			<p>Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo Demo </p>
		</div>
	</div>
	<div id="popup-slide-image" class="popup-container popup-intro">
		<h2>Title of popup intro</h2>
		<div class="contentbox"> 
			<div class="slider-wrapper theme-default">
	            <div id="slider" class="nivoSlider">
	                <img src="<?php echo $introImgUrl; ?>/intro-dm-01.jpg" 
	                	title="slideshow image 1" alt="slideshow image 1">
	                <img src="<?php echo $introImgUrl; ?>/intro-dm-02.jpg" 
	                	title="slideshow image 1" alt="slideshow image 2">
	                <img src="<?php echo $introImgUrl; ?>/intro-dm-03.jpg" 
	                	title="slideshow image 1" alt="slideshow image 3">
	                <img src="<?php echo $introImgUrl; ?>/intro-dm-04.jpg" 
	                	title="slideshow image 1" alt="slideshow image 5">
	            </div>
        	</div>
		</div>
	</div>
	<div id="popup-video" class="popup-container popup-intro">
		<h2>Title of popup intro</h2>
		<div class="contentbox"> 
			<iframe width="854" height="510" src="//www.youtube.com/embed/HLphrgQFHUQ" 
				frameborder="0" allowfullscreen>
			</iframe>
		</div>
	</div>
</div>-->
<?php echo $footer; ?>