<?php echo $header; ?>
<div id="body-content">
	<div class="pagelocation <?php echo ($parent_id == 0) ? 'margin-box3' : 'margin-box5'; ?>">
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
	<div class="carousel-container">
		<a href="#" id="next-scroll" class="btn-scroll"></a>
		<a href="#" id="prev-scroll" class="btn-scroll"></a>
	</div>
	<?php } ?>
</div>
<?php if (!empty($category['popup'])) { ?>
<div style="display: none;">
	<?php if ($category['popup']['type'] == 2) { ?>
	<div id="popup-slide-image" class="popup-container popup-intro">
		<h2><?php echo $category['popup']['title']; ?></h2>
		<div class="contentbox"> 
			<?php if (!empty($category['popup']['banners'])) { ?>
			<div class="slider-wrapper theme-default">
	            <div id="slider" class="nivoSlider">
	            	<?php foreach ($category['popup']['banners'] as $banner) { ?>
	            		<?php if (!empty($banner['href'])) { ?>
	                	<a href="<?php echo $banner['href']; ?>"><img src="<?php echo $banner['image']; ?>" title="<?php echo $banner['title']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
	            		<?php }else { ?>
	                	<img src="<?php echo $banner['image']; ?>" title="<?php echo $banner['title']; ?>" alt="<?php echo $banner['title']; ?>" />
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
<?php echo $footer; ?>