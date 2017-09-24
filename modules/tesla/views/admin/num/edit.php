<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<?php if(isset($_SESSION['errors'])): ?>
			<?php print $_SESSION['errors']; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php elseif(isset($_SESSION['success'])): ?>
			<?php print $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>            
		<?php endif; ?>
		
		<form action="/module/tesla/admin/num/update" method="POST">
			<input type="hidden" name="id" value="<?php isset($essence['id']) ? print $essence['id'] : ''; ?>">
			<label>Номер квартиры №:</label>
			<input type="number" name="num" value="<?php isset($essence['num']) ? print $essence['num'] : ''; ?>">
			<button type="submit">Обновить</button>
			<a href="/module/tesla/admin/nums">Отмена</a>
		</form>
	</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>