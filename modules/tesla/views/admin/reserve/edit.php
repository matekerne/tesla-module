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
		
		<form action="/module/tesla/admin/reserve/update" method="POST">
			<input type="hidden" name="id" value="<?php isset($essence['id']) ? print $essence['id'] : ''; ?>">
			<label>Бронь для риэлтора на (кол-во дней):</label>
			<input type="number" name="realtor" value="<?php isset($essence['realtor']) ? print $essence['realtor'] : ''; ?>">
			<label>Бронь для менеджера на (кол-во дней):</label>
			<input type="number" name="manager" value="<?php isset($essence['manager']) ? print $essence['manager'] : ''; ?>">
			<button type="submit">Обновить</button>
			<a href="/module/tesla/admin/reserves">Отмена</a>
		</form>
	</div>
	</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>