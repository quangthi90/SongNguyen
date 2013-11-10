<?php echo $header; ?>
<div id="body-content">
	<div class="pagelocation">
		<?php echo $title; ?>
	</div>
	<?php if (!empty($items)) { ?>
	<div class="content-list">
		<?php foreach ($items as $item) { ?>
		<div class="box box3">
			<a href="<?php echo $item['href']; ?>" class="<?php echo $item['class']; ?>">
				<img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
			</a>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php echo $footer; ?>