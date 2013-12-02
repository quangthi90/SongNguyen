<?php echo $header; ?>
<div id="body-content">
	<div class="pagelocation margin-box3">
		<?php echo $title; ?>
	</div>
	<?php if (!empty($items)) { ?>
	<ul class="content-list">
		<?php foreach ($items as $item) { ?>
		<li class="box-item box3">
			<a class="item-avatar <?php echo $item['class']; ?>" href="<?php echo $item['href']; ?>">
				<img class="item-avatar-img on" src="<?php echo $item['image1']; ?>" alt="<?php echo $item['name']; ?>">
				<img class="item-avatar-img off" src="<?php echo $item['image2']; ?>" alt="<?php echo $item['name']; ?>">
				<span class="category-title"><?php echo $item['name']; ?></span>
			</a>			
		</li>
		<?php } ?>
	</ul>
	<?php } ?>
</div>
<?php echo $footer; ?>