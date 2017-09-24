<?php require_once(ROOT . '/views/layouts/header.php'); ?>
		
	<div class="grid-content">
		<div class="main__content">
			<br>
			<?php if(isset($_SESSION['errors'])): ?>
				<?php print $_SESSION['errors']; ?>
				<?php unset($_SESSION['errors']); ?>
			<?php elseif(isset($_SESSION['success'])): ?>
				<?php print $_SESSION['success']; ?>
				<?php unset($_SESSION['success']); ?>            
			<?php endif; ?>
			<br>
			<form action="/module/tesla/admin/prices/upload" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
				<input type="file" name="prices[]" multiple>
				<button type="submit">Загрузить</button>
			</form>
		</div>
	</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>