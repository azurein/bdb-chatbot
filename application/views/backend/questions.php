<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<!-- Page Content -->
<div class="container">

	<div class="row">
		<div class="col-md-12">
		<h4>
			<?=$title ?>
		</h4>
		<br/>
		</div>
	</div>
	
    <?php echo $output; ?>

</div>